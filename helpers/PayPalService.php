<?php

namespace App\Helpers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ConnectException;
use App\Helpers\AccessTokenService;
use GuzzleHttp\Psr7\Response;

require_once 'AccessTokenService.php';

class PayPalService
{
  private readonly array $ROUTES;
  private $client;
  private $accessToken;

  public function __construct()
  {
    $this->ROUTES = [
      "RETURN_URL" => base_url('/payment/processing'),
      "CANCEL_URL" => base_url('/payment/cancel')
    ];

    $config = [ // po i le ketu njehere
      'client_id' => $_ENV['PAYPAL_CLIENT_ID'],
      'client_secret' => $_ENV['PAYPAL_CLIENT_SECRET'],
      'api_base_url' => $_ENV['PAYPAL_API_BASE_URL'] // 'https://api-m.sandbox.paypal.com' or 'https://api.paypal.com'
    ];

    $accessTokenService = new AccessTokenService($config);
    $this->accessToken = $accessTokenService->getAccessToken();

    $this->client = new Client([
      'base_uri' => $config['api_base_url'],
      'headers' => [
        'Authorization' => 'Bearer ' . $this->accessToken,
      ],
    ]);
  }

  private function safeApiCall(callable $apiCall)
  {
    try {
      $result = $apiCall();
      return [
        'success' => true,
        'data' => $result,
      ];
    } catch (RequestException $e) {
      if ($e->hasResponse()) {
        $response = $e->getResponse();
        $responseBody = $response->getBody()->getContents();
        $errorData = json_decode($responseBody, true);
        if (isset($errorData['details']) && is_array($errorData['details']) && count($errorData['details']) > 0 && isset($errorData['details'][0]['description'])) {
          $errorMessage = $errorData['details'][0]['description'];
        } elseif (isset($errorData['message'])) {
          $errorMessage = $errorData['message'];
        } else {
          $errorMessage = $e->getMessage();
        }
      } else {
        $errorMessage = $e->getMessage();
      }
      return [
        'success' => false,
        'error' => $errorMessage,
      ];
    } catch (ConnectException $e) {
      return [
        'success' => false,
        'error' => "A connection error occurred: " . $e->getMessage(),
      ];
    } catch (\Exception $e) {
      return [
        'success' => false,
        'error' => $e->getMessage(),
      ];
    }
  }

  public function createOrder(string $amount, $name, $description, $sellerPayPalId, $imageUrl = '', $currency = 'USD') //Duhet te vendos nje default image me te mire
  { // vlerat monetare do jene ne string ose int, jo float
    return $this->safeApiCall(function () use ($amount, $name, $description, $sellerPayPalId, $imageUrl, $currency) {

      $quantity = 1; //maybe later we make quantity a variable too

      $cents = bcmul($amount, "100");
      $unitAmountInCents = intval($cents);
      if ($unitAmountInCents === 0 && $amount !== "0" && $amount !== "0.00") {
        die("Amount is 0, something is wrong");
      }

      $individualPrice = $unitAmountInCents; //this is in cents
      $itemTotal = $individualPrice * $quantity;

      $formattedIndividualPrice = bcdiv((string) $individualPrice, '100', 2);
      $formattedItemTotal = bcdiv((string)$itemTotal, '100', 2);

      $payload = [
        'intent' => 'CAPTURE',
        'purchase_units' => [[
          'description' => $description,
          'amount' => [
            'currency_code' => $currency,
            'value' => $formattedItemTotal,
            'breakdown' => [
              'item_total' => [
                'currency_code' => $currency,
                'value' => $formattedItemTotal, // Item total is required
              ],
            ],
          ],
          'items' => [[
            'name' => $name,
            'unit_amount' => [
              'currency_code' => $currency,
              'value' => $formattedIndividualPrice
            ],
            'quantity' => $quantity,
            'category' => 'DIGITAL_GOODS',
            // "image_url" => $imageUrl,
            // "url" => "https://example.com/url-to-the-item-being-purchased-2",  //ketu besoj do jete me id te travel package
          ]],
          'payee' => [
            'email_address' => $sellerPayPalId
          ],
        ]],
        'application_context' => [
          'return_url' => $this->ROUTES['RETURN_URL'],
          'cancel_url' => $this->ROUTES['CANCEL_URL']
        ]
      ];

      // Log the full payload
      // error_log("PayPal Payload: " . json_encode($payload, JSON_PRETTY_PRINT));

      $response = $this->client->post('v2/checkout/orders', [
        'headers' => [
          'Content-Type' => 'application/json',
        ],
        'json' => $payload
      ]);

      return json_decode($response->getBody()->getContents(), true);
    });
  }

  function getOrderDetails(string $orderId): bool|array
  {
    try {
      $response = $this->client->get('/v2/checkout/orders/' . $orderId, [
        'headers' => [
          'Accept' => 'application/json',
        ],
      ]);

      $statusCode = $response->getStatusCode();
      if ($statusCode == 200) {
        $data = json_decode($response->getBody(), true);
        error_log($response->getBody());
        return $data;
      } else {
        error_log("Paypal returned status code: " . $statusCode);
        return false;
      }
    } catch (RequestException $e) {
      error_log("Guzzle HTTP Request Exception: " . $e->getMessage());
      if ($e->hasResponse()) {
        error_log("Paypal returned body: " . $e->getResponse()->getBody());
      }
      return false;
    } catch (\Exception $e) {
      error_log("General exception: " . $e->getMessage());
      return false;
    }
  }

  public function verifyOrder(string $orderId)
  {
    return match ($this->getOrderDetails($orderId)['status']) {
      'APPROVED' => true,
      default => false
  };
  }

  public function captureOrder($token)
  {
    return $this->safeApiCall(function () use ($token) {
      $token = trim($token);
      $response = $this->client->post("/v2/checkout/orders/$token/capture", [
        'headers' => [
          'Content-Type' => 'application/json'
        ],
      ]);
      return json_decode($response->getBody()->getContents(), true);
    });
  }
}

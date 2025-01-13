<?php

namespace App\Helpers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ConnectException;
// use App\Helpers\AccessTokenService;

class PayPalService
{
  private readonly array $ROUTES;
  private $client;
  private $accessToken;

  public function __construct(array $config)
  {
    $root = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://') .$_SERVER['HTTP_HOST'];
    
    $this->ROUTES = [
      "RETURN_URL" => $root . '/payment/success',
      "CANCEL_URL" => $root . '/payment/cancel'
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

  public function createOrder(int|string|float $amount, $name, $description, $sellerPayPalId, $currency = 'USD')
  { // vlerat monetare do jene ne string ose int, jo float
    return $this->safeApiCall(function () use ($amount, $name, $description, $sellerPayPalId, $currency) {

      $quantity = 1; //maybe later we make quantity a variable too

      if (is_string($amount)) { // zakonisht do jete string, keshtu qe ndoshta e thjeshtoj kte pjese me vone
        // String input: convert to cents
        $cents = bcmul($amount, "100");
        $unitAmountInCents = intval($cents);
        if ($unitAmountInCents === 0 && $amount !== "0" && $amount !== "0.00") {
          return;
        }
      } elseif (is_int($amount)) {
        $unitAmountInCents = $amount;
      } elseif (is_float($amount)) {
        $unitAmountInCents = (int)round($amount * 100);
      } else {
        // Invalid type
        error_log("Error: Invalid amount type: " . gettype($amount));
        return;
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
            // "image_url" => "https://example.com/static/images/items/1/shoes_running.jpg",
            // "url" => "https://example.com/url-to-the-item-being-purchased-2",
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
      error_log("PayPal Payload: " . json_encode($payload, JSON_PRETTY_PRINT));

      $response = $this->client->post('v2/checkout/orders', [
        'headers' => [
          'Content-Type' => 'application/json',
        ],
        'json' => $payload
      ]);

      return json_decode($response->getBody()->getContents(), true);
    });
  }

  // kjo do perdoret nese duam me shume siguri, me shume hapa, intent te createOrder do behet "AUTHORIZE
  public function authorizeOrder($token)
  {
    return $this->safeApiCall(function () use ($token) {
      $token = trim($token);
      $response = $this->client->post("/v2/checkout/orders/$token/authorize", [
        'headers' => [
          'Content-Type' => 'application/json',
        ]
      ]);
      return json_decode($response->getBody()->getContents(), true);
    });
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

  // For Refunds (after capture):
  public function refundPayment($captureId, $amount = null)
  {
    return $this->safeApiCall(function () use ($captureId, $amount) {
      $requestBody = $amount ? ['amount' => $amount] : [];
      try {
        $response = $this->client->post("/v2/payments/captures/" . trim($captureId) . "/refund", [
          'headers' => [
            'Content-Type' => 'application/json',
          ],
          'json' => $requestBody,
        ]);
      } catch (\Exception $e) {
        error_log($e->getMessage());
        return [
          'success' => false,
          'error' => $e->getMessage(),
        ];
      }
      return json_decode($response->getBody()->getContents(), true);
    });
  }

  // For Voids (before capture, on an authorization):
  public function voidAuthorization($authorizationId)
  {
    return $this->safeApiCall(function () use ($authorizationId) {
      try {
        $response = $this->client->post("/v2/payments/authorizations/" . trim($authorizationId) . "/void", [
          'headers' => [], // Headers array can be empty
        ]);
      } catch (\Exception $e) {
        error_log($e->getMessage());
        return [
          'success' => false,
          'error' => $e->getMessage(),
        ];
      }
      return json_decode($response->getBody()->getContents(), true);
    });
  }
}

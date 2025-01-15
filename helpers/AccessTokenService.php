<?php
namespace App\Helpers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class AccessTokenService
{

  public function __construct(
    private readonly array $config
  ) {}

  private function getNewAccessToken(array $config)
  {
    $client = new Client([
      'base_uri' => $config['api_base_url'],
      'headers' => [
        'Content-Type' => 'application/x-www-form-urlencoded',
      ],
      'auth' => [$config['client_id'], $config['client_secret']]
    ]);

    error_log("Attempting to get access token...");
    error_log("Base URL: " . $config['api_base_url']);

    try {
      $response = $client->post('/v1/oauth2/token', [
        'form_params' => ['grant_type' => 'client_credentials']
      ]);

      $data = json_decode($response->getBody(), true);
      error_log("Raw response body:\n" . $response->getBody()->getContents());
      error_log("Decoded Token Response Data:\n" . print_r($data, true));

      if (isset($data['access_token'])) {
        $accessToken = $data['access_token'];
        error_log("Successfully retrieved access token: " . $accessToken);
        return $accessToken;
      } else {
        error_log("Error: Access token not found in response.");
        if (isset($data['error']) && isset($data['error_description'])) {
          error_log("PayPal Error: " . $data['error'] . " - " . $data['error_description']);
        }
        return null;
      }
    } catch (ClientException $e) {
      $response = $e->getResponse();
      if ($response) {
        error_log("Get Token Client Exception: " . $e->getMessage() . "\n" . $response->getBody()->getContents());
      } else {
        error_log("Get Token Client Exception: " . $e->getMessage());
      }
      return null;
    } catch (\Exception $e) {
      error_log("Get Token Exception: " . $e->getMessage());
      return null;
    }
  }

  public function getAccessToken()
  {
    // Token management (outside PayPalService)
    if (!isset($_SESSION['paypal_access_token']) || time() > $_SESSION['paypal_token_expiry']) {
      error_log("Making a new token");
      $accessToken = $this->getNewAccessToken($this->config);
      if ($accessToken) {
        $_SESSION['paypal_access_token'] = $accessToken;
        $_SESSION['paypal_token_expiry'] = time() + 3000; // 50 minutes
      } else {
        // Handle token retrieval error (e.g., log the error and display a message to the user)
        error_log("Failed to retrieve PayPal access token.");
        die("Payment processing is currently unavailable. Please try again later.");
      }
    }
    return $_SESSION['paypal_access_token'];
  }
}
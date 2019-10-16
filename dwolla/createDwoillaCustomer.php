<?php

function get_ip_address()
{
  foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
    if (array_key_exists($key, $_SERVER) === true) {
      foreach (explode(',', $_SERVER[$key]) as $ip) {
        $ip = trim($ip); // just to be safe

        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
          return $ip;
        }
      }
    }
  }
}

$customersApi = new DwollaSwagger\CustomersApi($apiClient);

session_start();

$FullNameArray = explode(" ", $_SESSION["name"]);

$customer = $customersApi->create([
  'firstName' => $FullNameArray[0],
  'lastName' => $FullNameArray[1],
  'email' => $_SESSION["email"],
  'ipAddress' => get_ip_address()
]);

print($customer); # => "https://api-sandbox.dwolla.com/customers/c7f300c0-f1ef-4151-9bbe-005005aa3747"


// <?php
// $customersApi = new DwollaSwagger\CustomersApi($apiClient);

$fsToken = $customersApi->getCustomerIavToken("https://api-sandbox.dwolla.com/customers/247B1BD8-F5A0-4B71-A898-F62F67B8AE1C");
$fsToken->token; # => "lr0Ax1zwIpeXXt8sJDiVXjPbwEeGO6QKFWBIaKvnFG0Sm2j7vL"


//<?php
$customerUrl = 'https://api-sandbox.dwolla.com/customers/5b29279d-6359-4c87-a318-e09095532733';

$fsApi = new DwollaSwagger\FundingsourcesApi($apiClient);

$fundingSources = $fsApi->getCustomerFundingSources($customerUrl);
$fundingSources->_embedded->{'funding-sources'}[0]->name; # => "Jane Doe’s Checking"


// <?php
$accountUrl = 'https://api.dwolla.com/accounts/ad5f2162-404a-4c4c-994e-6ab6c3a13254';

$fsApi = new DwollaSwagger\FundingsourcesApi($apiClient);

$fundingSources = $fsApi->getAccountFundingSources($accountUrl, $removed = false);
# Access desired information in response object fields
print($fundingSources->_embedded); # => PHP associative array of _embedded contents in schema


// <?php
$accountUrl = 'https://api.dwolla.com/accounts/ad5f2162-404a-4c4c-994e-6ab6c3a13254';

$fsApi = new DwollaSwagger\FundingsourcesApi($apiClient);

$fundingSources = $fsApi->getAccountFundingSources($accountUrl, $removed = false);
# Access desired information in response object fields
print($fundingSources->_embedded); # => PHP associative array of _embedded contents in schema


// <?php
$transfer_request = array(
  '_links' =>
  array(
    'source' =>
    array(
      'href' => 'https://api-sandbox.dwolla.com/funding-sources/b5e68264-7d4d-42a9-88d4-5616c77c6baa',
    ),
    'destination' =>
    array(
      'href' => 'https://api-sandbox.dwolla.com/funding-sources/3152c22b-3d72-442d-a83b-e575df3a043e',
    ),
  ),
  'amount' =>
  array(
    'currency' => 'USD',
    'value' => '225.00',
  )
);

$transferApi = new DwollaSwagger\TransfersApi($apiClient);
$transfer = $transferApi->create($transfer_request);

print($transfer); # => https://api-sandbox.dwolla.com/transfers/d76265cd-0951-e511-80da-0aa34a9b2388

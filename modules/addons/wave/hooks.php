<?php
/**
 * WHMCS SDK Sample Addon Module Hooks File
 *
 * Hooks allow you to tie into events that occur within the WHMCS application.
 *
 * This allows you to execute your own code in addition to, or sometimes even
 * instead of that which WHMCS executes by default.
 *
 * @see https://developers.whmcs.com/hooks/
 *
 * @copyright Copyright (c) WHMCS Limited 2017
 * @license http://www.whmcs.com/license/ WHMCS Eula
 */

// Require any libraries needed for the module to function.
// require_once __DIR__ . '/path/to/library/loader.php';
//
// Also, perform any initialization required by the service's library.

/**
 * Register a hook with WHMCS.
 *
 * This sample demonstrates triggering a service call when a change is made to
 * a client profile within WHMCS.
 *
 * For more information, please refer to https://developers.whmcs.com/hooks/
 *
 * add_hook(string $hookPointName, int $priority, string|array|Closure $function)
 */
use WHMCS\Module\Addon\Wave\WaveApp;
use WHMCS\Module\Addon\Wave\Client\Controller;
use WHMCS\Database\Capsule as DB;

add_hook('ClientAdd', 1, function(array $params) {
    $businessId = DB::table('tbladdonmodules')->select('value')->where('module', 'wave')->where('setting', 'Business Id')->first();
    $accessToken = DB::table('tbladdonmodules')->select('value')->where('module', 'wave')->where('setting', 'Access Token')->first();
    if (is_null($businessId) || is_null($accessToken)) {
        exit();
    }

    // Create client in Wave
    try {
        $waveapp = new WaveApp(
            null, 
            'https://gql.waveapps.com/graphql/public', 
            $accessToken->value,
            $businessId->value
        );

        $customer = [
            "input" => [
                "businessId" => $businessId->value,
                "name" => $params['firstname'] . ' ' . $params['lastname'],
                "firstName" => $params['firstname'],
                "lastName" => $params['lastname'],
                "displayId" => $params['firstname'],
                "email" => $params['email'],
                "mobile" => $params['phonenumber'],
                "phone" => $params['phonenumber'],
                "currency" => "USD",
                "address" => [
                    "addressLine1" => $params['address1'],
                    "city" => $params['city'],
                    "postalCode" => $params['postcode'],
                    "countryCode" => $params['country'],
               ],
            ],
        ];

        $newCustomer = $waveapp->customerCreate($customer, "CustomerCreateInput");
        
    } catch (Exception $e) {
        throw new Exception($e->getMessage() . json_encode($params));
    }
});

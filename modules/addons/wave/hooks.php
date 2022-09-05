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

add_hook('ClientAdd', 1, function(array $params) {
    // Create client in Wave
    try {
        $c = new Controller();
        $waveapp = new WaveApp(null, 'https://gql.waveapps.com/graphql/public', '75ycGuRotBichVoYG2RWps2lKIwyie', 'QnVzaW5lc3M6MmNlOWU5MzEtOTAyMi00NGYzLThlZTctOWIzNGM4MjY1ODU5');
        $customer = [
            "input" => [
                "businessId" => "QnVzaW5lc3M6MmNlOWU5MzEtOTAyMi00NGYzLThlZTctOWIzNGM4MjY1ODU5",
                "name" => "Genevieve Heidenreich",
                "firstName" => "Genevieve",
                "lastName" => "Heidenreich",
                "displayId" => "Genevieve",
                "email" => "genevieve.heidenreich@example.com",
                "mobile" => "011 8795",
                "phone" => "330 8738",
                "fax" => "566 5965",
                "tollFree" => "266 5698",
                "website" => "http://www.hermiston.com/architecto-commodi-possimus-esse-non-necessitatibus",
                "internalNotes" => "",
                "currency" => "USD",
                "address" => [
                    "addressLine1" => "167 Iva Run",
                    "addressLine2" => "Parker Mews, Monahanstad, 40778-7100",
                    "city" => "West Tyrique",
                    "postalCode" => "82271",
                    "countryCode" => "EC",
               ],
               "shippingDetails" => [
                    "name" => "Genevieve",
                    "phone" => "011 8795",
                    "instructions" => [
                        "Delectus deleniti accusamus rerum voluptatem tempora.",
                    ],
                    "address" => [
                        "addressLine1" => "167 Iva Run",
                        "addressLine2" => "Parker Mews, Monahanstad, 40778-7100",
                        "city" => "West Tyrique",
                        "postalCode" => "82271",
                        "countryCode" => "EC",
                    ],
                ],
            ],
        ];

        $newCustomer = $waveapp->customerCreate($customer, "CustomerCreateInput");
        
    } catch (Exception $e) {
        throw new Exception($e->getMessage() . json_encode($params));
    }
});

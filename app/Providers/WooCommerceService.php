<?php
namespace App\Providers;

use Automattic\WooCommerce\Client;


class WooCommerceService
{
    public static function getClient($storeUrl, $consumerKey, $consumerSecret)
    {
        
        $options = [
            'sslverify' => false
        ];
        
        return new Client(
            $storeUrl,
            $consumerKey,
            $consumerSecret,
            [
                'wp_api' => true,
                'version' => 'wc/v3',
                'query_string_auth' => true,
                'verify_ssl' => false,
                'curl' => $options
            ]
       );
       
       
    }
}
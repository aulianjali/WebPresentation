<?php

namespace App\Helpers;

class WebserviceHelper
{
    public static function login($email, $password)
    {
        $client = \Config\Services::curlrequest();
        $url = 'https://jwt-auth-eight-neon.vercel.app/login';

        $response = $client->post($url, [
            'json' => [
                'email' => $email,
                'password' => $password
            ]
        ]);

        return json_decode($response->getBody(), true);
    }

    public static function logout($refreshToken)
    {
        $client = \Config\Services::curlrequest();
        $url = 'https://jwt-auth-eight-neon.vercel.app/logout';

        try {
            $response = $client->post($url, [
                'json' => [
                    'refreshToken' => $refreshToken
                ]
            ]);

            return json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            return ['message' => 'error', 'error' => $e->getMessage()];
        }
    }
}

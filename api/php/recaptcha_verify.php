<?php

function isRecaptchaValid($response) {
    try {
        $secret = "6LcANhUUAAAAAC64wRl5XzXRY-VCZkbbVAUkdD9y";

        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $data = ['secret' => $secret,
            'response' => $response
        ];
        $options = [
            'http' => [
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data)
            ]
        ];

        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
//        echo $result;
        return json_decode($result)->success;
    } catch (Exception $e) {
        return null;
    }
}

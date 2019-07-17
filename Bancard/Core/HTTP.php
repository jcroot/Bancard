<?php

namespace Bancard\Core;

class HTTP
{
    /**
     *
     * Send POST data to url.
     *
     **/
    public static function post($url, $data, $method = "post")
    {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        if ($method == "post"){
            curl_setopt($curl, CURLOPT_POST, true);
        }else{
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
        }
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        $response = curl_exec($curl);
        if ($response === false) {
            $info = curl_getinfo($curl);
            curl_close($curl);

            return $info;
        }
        curl_close($curl);

        return $response;
    }

    /**
     *
     * Read data sent by POST.
     *
     **/
    public static function read()
    {
        $data = file_get_contents("php://input");

        return $data;
    }
}

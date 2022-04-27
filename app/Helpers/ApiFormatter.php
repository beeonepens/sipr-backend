<?php

namespace App\Helpers;

class ApiFormatter
{
    protected static $responseApi = [
        'data' => null,
        'message' => null,
    ];

    protected static $responseApiAuth = [
        'data' => null,
        // 'datetime' => null,
        'token' => null,
        'message' => null,
    ];

    protected static $responseApiMeet = [
        'data' => null,
        'message' => null,
    ];

    public static function createApi($data = null, $message = null)
    {
        self::$responseApi['data'] = $data;
        self::$responseApi['message'] = $message;

        return response()->json(self::$responseApi);
    }


    public static function createApiAuth($data = null, $token = null, $message = null)
    {
        self::$responseApiAuth['data'] = $data;
        self::$responseApiAuth['token'] = $token;
        self::$responseApiAuth['message'] = $message;

        return response()->json(self::$responseApiAuth);
    }

    public static function createApiMeet($data = null, $datetime = null, $message = null)
    {
        self::$responseApiMeet['data'] = $data;
        self::$responseApiMeet['data']['datetime'] = $datetime;
        self::$responseApiMeet['message'] = $message;

        return response()->json(self::$responseApiMeet);
    }
}

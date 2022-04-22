<?php
    namespace App\Helpers;

    class ApiFormatter{
        protected static $response = [
            'data' => null,
            'datetime' => null,
            'token' => null,
            'message' => null,
        ];

        public static function createApi($data =null, $token =null, $message =null){
            self::$response['data'] = $data;
            self::$response['token'] = $token;
            self::$response['message'] = $message;

            return response()->json(self::$response);
        }

        public static function createApiMeet($data =null, $data2 =null, $token =null, $message =null){
            self::$response['data'] = $data;
            self::$response['datetime'] = $data2;
            self::$response['token'] = $token;
            self::$response['message'] = $message;

            return response()->json(self::$response);
        }

    }
?>

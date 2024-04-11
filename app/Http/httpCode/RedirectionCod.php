<?php
/*
    Autor:Jesus Diego Rivero
    Fecha: 21/12/2023
    Modulo: DWES
    UD: 03
    Clase lanza mensajes por redirecciones
*/  
namespace App\Http\httpCode;
class RedirectionCod {
    public static function multipleChoices($data = null) {
        return response()->json(self::generateResponse(300, 'Multiple Choices', $data),300);
    }

    public static function movedPermanently($data = null) {
        return response()->json(self::generateResponse(301, 'Moved Permanently', $data),301);
    }

    public static function found($data = null) {
        return response()->json(self::generateResponse(302, 'Found', $data),302);
    }

    public static function seeOther($data = null) {
        return response()->json(self::generateResponse(303, 'See Other', $data),303);
    }

    private static function generateResponse($statusCode, $statusText, $data = null) {
        $response = [
            'status code' => $statusCode,
            'status' => $statusText,
        ];

        if ($data !== null) {
            $response['message'] = $data;
        }
        
        return $response;
    }
}
?>

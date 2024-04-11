<?php
/*
    Autor:Jesus Diego Rivero
    Fecha: 21/12/2023
    Modulo: DWES
    UD: 03
    Clase lanza mensajes por errores por parte del servidor
*/  
namespace App\Http\httpCode;
class ServerErrorCod {
    public static function internalServerError($data = null) {
        return response()->json(self::generateResponse(500, 'Internal Server Error', $data));
    }

    public static function notImplemented($data = null) {
        return response()->json(self::generateResponse(501, 'Not Implemented', $data));
    }

    public static function badGateway($data = null) {
        return response()->json(self::generateResponse(502, 'Bad Gateway', $data));
    }

    public static function serviceUnavailable($data = null) {
        return response()->json(self::generateResponse(503, 'Service Unavailable', $data));
    }

    // Puedes agregar más métodos según sea necesario para otros códigos 5xx...

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

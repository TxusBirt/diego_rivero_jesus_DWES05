<?php
/*
    Autor:Jesus Diego Rivero
    Fecha: 3/4/2024
    Modulo: DWES
    UD: 05
    Clase lanza mensajes por errores por parte del cliente
*/  
namespace App\Http\httpCode;

class ClientErrorCod {
    public static function badRequest($data = null) {
        return response()->json(self::generateResponse(400, 'Bad Request', $data), 400);
    }

    public static function unauthorized($data = null) {
        return response()->json(self::generateResponse(401, 'Unauthorized', $data),401);
    }

    public static function forbidden($data = null) {
        return response()->json(self::generateResponse(403, 'forbidden', $data), 404);
    }

    public static function notFound($data = null) {
        return response()->json(self::generateResponse(404, 'notFound', $data), 404);
    }
    public static function unprocessable($data = null) {
        return response()->json(self::generateResponse(422, 'Unprocessable entity', $data), 422);
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

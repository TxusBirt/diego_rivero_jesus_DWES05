<?php
/*
    Autor:Jesus Diego Rivero
    Fecha: 3/4/2024
    Modulo: DWES
    UD: 05
    Clase lanza mensajes cuando se tiene exito en las acciones requeridas
*/  
namespace App\Http\httpCode;
class SuccessCod {
    public static function ok($data = null) {
        return response()->json(self::generateResponse(200, 'OK', $data),200);
    }

    public static function created($data = null) {
        return response()->json(self::generateResponse(201, 'Created', $data), 201);
    }

    public static function accepted($data = null) {
        return response()->json(self::generateResponse(202, 'Accepted', $data), 202);
    }

    public static function noContent($data = null) {
        return response()->json(self::generateResponse(204, 'No Content', $data), 204);
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

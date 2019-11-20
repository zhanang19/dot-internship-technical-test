<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * Success API result formatter
     * 
     * @param  mixed    $data Data that must be returned
     * @param  string   $message Informational text
     * @param  int      $code
     * 
     * @return  \Illuminate\Http\Response
     */
    public function result($data = null, $message = 'Request success.', $code = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    /**
     * Error API result formatter
     * 
     * @param  mixed    $data Error data that must be returned
     * @param  string   $message Informational text
     * @param  int      $code HTTP status code
     * 
     * @return  \Illuminate\Http\Response
     */
    public function error($data = [], $message = 'Data not found.', $code = 404)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => $data
        ], $code);
    }
}
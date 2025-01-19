<?php

if (!function_exists('responseJson')) {
    function responseJson(bool $success = true, array|string $response = null, $error = null, $status = '200')
    {
        return response()
            ->json(['success' => $success,'result' => $response, 'error' => $error])
            ->setEncodingOptions(JSON_UNESCAPED_UNICODE)
            ->setStatusCode($status);
    }
}

if (!function_exists('getNumbers')){
    function getNumbers($var){
        preg_match_all('/[\d]/', $var, $matches);
        return implode('', $matches[0]);
    }
}
<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use JsonException;

trait CurlTrait
{
    function request($url, $post, $method, $body = null, $buildQuery = false)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, $post);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Token: ' . config('constants.TOKEN_WSRF'),
            'Content-Type: application/json'
        ]);

        if ($body) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, $buildQuery ? http_build_query($body) : json_encode($body));
        }
        
        $resp = curl_exec($curl);
        $respInfo = curl_getinfo($curl);
        curl_close($curl);

        switch ($respInfo['http_code']) {
            case 200:
            case 201:
                if ($resp == '') return new JsonResponse(null, 200);
                try {
                    return $this->handleCurl($resp);
                } catch (JsonException $e) {
                    return new JsonResponse(['message' => $e->getMessage()], 500);
                }
                break;
            case 400:
            case 403:
            case 503:
                try {
                    $resp = $this->handleCurl($resp);
                    if (property_exists($resp, 'errors')) {
                        return new JsonResponse(['message' => 'Verifique os campos informados', 'errors' => $resp->errors], $respInfo['http_code']);
                    }
                    return new JsonResponse(['message' => $resp->message], $respInfo['http_code']);
                } catch (JsonException $e) {
                    return new JsonResponse(['message' => $e->getMessage()], 500);
                }
                break;  
            case 404:
                return new JsonResponse(['message' => 'Recurso não encontrado'], 404);
                break;
            default:
                return new JsonResponse(['message' => 'Erro ao processar resposta da API'], 500);
                break;
        }
    }
}
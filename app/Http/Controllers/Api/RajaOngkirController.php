<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

class RajaOngkirController extends Controller
{
    /**
     * RajaOngkir API outcoming requester
     * 
     * @param   string  $endpoint Rajaongkir endpoint
     * @param   array   $data Requested data
     * @param   string  $httpMethod HTTP method
     * 
     * @return  array
     */
    private function apiCall(string $endpoint, array $data = [], string $httpMethod = 'GET')
    {
        $apiKey = config('services.rajaongkir.api_key');
        $baseUrl = config('services.rajaongkir.base_url.' . config('services.rajaongkir.package'));
        // remove not valid url endpoint character and remove trailing slash
        $endpoint = trim($endpoint, '/ \t\n\r\0\x0B');
        $data = http_build_query($data);
        $curl = curl_init();
        
        if ('GET' == $httpMethod) {
            // add get parameter to endpoint
            $endpoint .= '?' . $data;
        } else {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        }
        $endpoint = $baseUrl . $endpoint;
        
        curl_setopt($curl, CURLOPT_URL, $endpoint);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_ENCODING, '');
        curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            "key: $apiKey",
        ]);
        $response = curl_exec($curl);
        $error = curl_error($curl);
        curl_close($curl);

        if (! $error) {
            $response = collect(json_decode($response));
            if ($response->has('rajaongkir')) {
                if ($response->get('rajaongkir')->status->code == 200) {
                    return $response->get('rajaongkir')->results;
                } else {
                    Log::error(json_encode($response));
                    throw new \Exception("Rajaongkir service throw an error", 1001);
                }
            } else {
                Log::error(json_encode($response));
                throw new \Exception("Rajaongkir service throw an error", 1002);
            }
        } else {
            Log::error(json_encode($response));
            throw new \Exception("Rajaongkir service throw an error", 1003);
        }
    }

    /**
     * RajaOngkir get province data
     * 
     * @param   \Illuminate\Http\Request  $request
     * @param   string  $provinceId
     * 
     * @return  \Illuminate\Http\Response
     */
    public function getProvinces(Request $request, $provinceId = null)
    {
        $data = [
            'id' => $provinceId
        ];
        try {
            $result = collect($this->apiCall('province', $data));
            $keyword = $request->query('keyword');
            if (! empty($keyword)) {
                $result = $result->reject(function ($item) use ($keyword) {
                        // reject all province that not match to keyword
                        return (stripos($item->province, $keyword) === false);
                    })
                    ->values();
            }
            if ($result->isEmpty()) {
                return $this->error([], 'Data not found.', 404);
            }
            return $this->result($result);
        } catch (\Exception $e) {
            return $this->error([], $e->getCode() . ': ' . $e->getMessage(), 500);
        }
    }
}

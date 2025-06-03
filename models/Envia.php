<?php

class Envia
{
    private $apiUrl;
    private $token;

    public function __construct()
    {
        $this->apiUrl = 'https://api-test.envia.com/ship/rate/'; // O "mexico" o "colombia" si aplica
        $this->token = 'cd8a7cfb69e9e00f793cfeffbde653310b5f86f4995b8db48a639d6f8735a076'; // reemplaza con tu API Key real
    }

    public function cotizarEnvio($data)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $this->apiUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $this->token,
            ],
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        return json_decode($response, true);
    }
}

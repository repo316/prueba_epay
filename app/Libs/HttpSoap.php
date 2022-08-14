<?php

namespace App\Libs;

class HttpSoap{

    public static function send($url, $body): array|bool{
        $client=new \GuzzleHttp\Client([
            'headers'=>[
                'SOAPAction'=>'"#POST"',
                'Content-Type'=>'text/xml'
            ]
        ]);

        $response=$client->post($url, ['body'=>$body]);

        if($response->getStatusCode()==200){
            $xmlPayload=new XmlPayload();
            return $xmlPayload->setXML($response->getBody().'')->getPayload();
        }

        return ['cod_error'=>'-99'];
    }
}

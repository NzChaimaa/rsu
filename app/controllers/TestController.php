<?php

use Phalcon\Http\Request;
use Ramsey\Uuid\Uuid;


class TestController extends PrivateController
{
    /**
     * Welcome and user list
     */
    public function requestAction()
    {

        $request = $this->getDI()->get('request');

        //$request = $this->request;

        //var_dump($request);

        $uuid = Uuid::uuid4();

        //var_dump($request);
//var_dump($request->getHeaders());
$d = new DateTime(); 

        $response_data = [
            'datetime'              => $d->format('Y-m-d\TH:i:s.u'),
            'method'                => $request->getMethod(),
            'language'              => $request->getLanguages(),
            'acceptable_content'    => $request->getAcceptableContent(),
            'basic_auth'            => $request->getBasicAuth(),
            'client_adress'         => $request->getClientAddress(),
            'digets_auth'           => $request->getDigestAuth(),
            'http_referer'          => $request->getHTTPReferer(),
            //'header'                => $request->getHeader(),
            'headers'               => $request->getHeaders(),
            'http_host'             => $request->getHttpHost(),
            //'api_key'       => $request->getApiKey(),
            'port'                  => $request->getPort(),
            'uri'                   => $request->getURI(true),
            'user_agent'            => $request->getUserAgent(),
            'isAjax'                => $request->isAjax(),
            'isSecure'              => $request->isSecure(),
            'isValideHttp'          => $request->isValidHttpMethod($request->getMethod()),
            'uuid'                  => $uuid,

        ];
        /*
        $response = new \Phalcon\Http\Response();
        $response->setContent(json_encode($response_data));
        return $response;
        */

        $response = new Core\Http\Response();
        $response->setContent(json_encode($response_data));
        $response->setPayloadSuccess();
        return $response;
    }
}

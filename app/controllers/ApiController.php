<?php



class ApiController extends PrivateController
{
    public function pingAction()
    {
        $d = new DateTime(); 
        $response_data = [
            'ping' => 'get your ping back',
            'datetime' => $d->format('Y-m-d\TH:i:s.u')
        ];
        $response = new \Phalcon\Http\Response();
        $response->setContent(json_encode($response_data));
        return $response;
    }

    public function aboutAction()
    {

        $data = [];
        array_push($data, $this->request->getPost('key1'));
        array_push($data, $this->request->getPost('key2'));


        
        $response_data = [
            'api' => 'client api',
            'version'   => '1.0.0',
            'platforme' => 'phalcon 4.0'
        ];
        $response = new \Core\Http\Response();
        $response->setContent(json_encode($response_data))->setStatus(Core\Http\Response::OK);
        return $response;
    }
}
<?php


class IndexController extends PrivateController
{
    /**
     * Welcome and user list
     */
    public function indexAction()
    {
        $response_data = [
            'index-index' => 'Hello to phalcon app'
        ];
        $response = new \Phalcon\Http\Response();
        $response->setContent(json_encode($response_data));
        return $response;
    }
}

<?php

declare(strict_types=1);

namespace Core\Http;

use Phalcon\Http\Response as Res;
use Phalcon\Http\ResponseInterface;
use Phalcon\Messages\Messages;

class Response extends Res
{
    const OK                    = 200;
    const CREATED               = 201;
    const ACCEPTED              = 202;
    const MOVED_PERMANENTLY     = 301;
    const FOUND                 = 302;
    const TEMPORARY_REDIRECT    = 307;
    const PERMANENTLY_REDIRECT  = 308;
    const BAD_REQUEST           = 400;
    const UNAUTHORIZED          = 401;
    const FORBIDDEN             = 403;
    const NOT_FOUND             = 404;
    const INTERNAL_SERVER_ERROR = 500;
    const NOT_IMPLEMENTED       = 501;
    const BAD_GATEWAY           = 502;

    private $codes = [
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        301 => 'Moved Permanently',
        302 => 'Found',
        307 => 'Temporary Redirect',
        308 => 'Permanent Redirect',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        403 => 'Forbidden',
        404 => 'Not Found',
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
    ];


    /**
     * Send the response back
     *
     * @return ResponseInterface
     */
    public function send(): ResponseInterface
    {
        $content   = $this->getContent();
        $timestamp = date('c');
        $hash      = sha1($timestamp . $content);
        $eTag      = sha1($content);

        /**
         * $flag $success, $message, $id, $uuid 
         */
        $flag   = [];

        $content = [
            'content' => json_decode($this->getContent(), true)
            ];
        $meta    = [
            'signature' => [
                'timestamp' => $timestamp,
                'hash'      => $hash,
            ]
        ];

        /**
         * Join the array again
         */
        $data = $flag + $content + $meta;
        $this
            ->setHeader('E-Tag', $eTag)
            ->setJsonContent($data);


        return parent::send();
    }

    /**
     * Sets Http Response code and description
     * 
     * @param int $code
     * 
     * @return Response
     */
    public function setStatus(int $code): Response
    {
        $this->setStatusCode($code, $this->getHttpCodeDescription($code));

        return $this;
    }


    /**
     * Sets the payload code as Error
     *
     * @param string $detail
     *
     * @return Response
     */
    public function setPayloadError(string $detail = ''): Response
    {
        $this->setJsonContent(['errors' => [$detail]]);

        return $this;
    }

    /**
     * Traverses the errors collection and sets the errors in the payload
     *
     * @param Messages $errors
     *
     * @return Response
     */
    public function setPayloadErrors($errors): Response
    {
        $data = [];
        foreach ($errors as $error) {
            $data[] = $error->getMessage();
        }

        $this->setJsonContent(['errors' => $data]);

        return $this;
    }

    /**
     * Sets the payload code as Success
     *
     * @param null|string|array $content The content
     *
     * @return Response
     */
    public function setPayloadSuccess($content = []): Response
    {
        $data = (true === is_array($content)) ? $content : ['data' => $content];
        $data = (true === isset($data['data'])) ? $data  : ['data' => $data];

        $this->setJsonContent($data);

        return $this;
    }

    /**
     * Returns the http code description
     * @param int $code
     *
     * @return int|string
     */
    private function getHttpCodeDescription(int $code)
    {
        if (true === isset($this->codes[$code])) {
            return $this->codes[$code];
        }

        return '';
    }
}

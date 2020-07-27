<?php

declare(strict_types=1);

namespace Core\Http;

use Phalcon\Http\Request as Req;

class Request extends Req
{
    /**
     * @return string
     */
    public function getBearerTokenFromHeader(): string
    {
        return str_replace('Bearer ', '', $this->getHeader('Authorization'));
    }

    /**
     * @return bool
     */
    public function isEmptyBearerToken(): bool
    {
        return true === empty($this->getBearerTokenFromHeader());
    }
}

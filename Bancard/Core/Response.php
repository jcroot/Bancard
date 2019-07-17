<?php

namespace Bancard\Core;

use Bancard\Core\Config;
use Bancard\Core\HTTP;

class Response
{
    private $response;

    /**
     *
     * Get post data sent by VPOS.
     *
     * @return Response object
     *
     **/

    public static function read()
    {
        $self = new self();
        $self->response = HTTP::read();

        return $self;
    }

    /**
     *
     * Return response object.
     *
     * @return string
     *
     **/

    public function get()
    {
        return $this->response;
    }

    /**
     *
     * Return representation of json
     *
     * @return stdClass
     *
     **/

    public function json()
    {
        return json_decode($this->response);
    }
}



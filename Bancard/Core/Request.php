<?php

namespace Bancard\Core;

class Request
{
    private $token;

    private $shop_process_id;

    private $response_data;

    protected $environment;

    protected $path;

    protected $redirect_path;

    public $url;

    public $redirect_to;

    public $public_key;

    public $operation = [];

    public $data = [];

    public $response;

    public $process_id;

    /**
     *
     * Get valid token for given operation type.
     *
     * @param $type Type of operation.
     *
     * @return void
     *
     **/

    protected function getToken($type)
    {
        $this->token = Token::create(
            $type,
            $this->data
        );
    }

    /**
     *
     * Get configured public key.
     *
     * @return void
     *
     **/

    private function getPublicKey()
    {
        if (!empty($this->data['public_key'])) {
            $this->public_key = $this->data['public_key'];
        }
        if (empty($this->public_key)) {
            $public_key = (APPLICATION_ENV == 'production') ? 'production_public_key' : 'staging_public_key';
            $this->public_key = Config::get($public_key);
        }

        return $this->public_key;
    }

    /**
     *
     * Fill data array with values that then will turn into a json.
     *
     * @return void
     *
     **/

    public function addData($key, $value)
    {
        $this->data[$key] = $value;
    }

    /**
     *
     * Prapare operation object with expected structure.
     *
     * @return void
     *
     **/

    protected function makeOperationObject($removeField = "")
    {
        $this->operation['public_key'] = $this->getPublicKey();
        $this->operation['operation'] = [];
        $this->operation['operation']['token'] = $this->token->get();
        if (isset($this->shop_process_id) && !is_null($this->shop_process_id)) {
            if ($this->shop_process_id > 0) {
                $this->operation['operation']['shop_process_id'] = $this->shop_process_id;
            }
        }
        if (count($this->data) > 0) {
            foreach ($this->data as $key => $value) {
                if ($key == "public_key" or $key == "private_key" or $key == $removeField) {
                    continue;
                }
                $this->operation['operation'][$key] = $value;
            }
        }
        //\Zend_Registry::get('logger')->log(json_encode($this->operation), \Zend_Log::ERR);
    }

    /**
     *
     * Prepare url and post data to Bancard configured enviroment url.
     * If successful sets up redirect url.
     * Raise exception on error.
     *
     * @return bool
     *
     **/

    protected function post($method)
    {
        $this->url = $this->environment . $this->path;
        $this->response_data = HTTP::post($this->url, $this->json(), $method);

        if (!$this->response_data) {
            throw new \RuntimeException("No response data was found.");
        }

        $this->response = $this->response();

        //\Zend_Registry::get('logger')->log($this->json(), \Zend_Log::ERR);
        if ($this->response->status == "error") {
            throw new \Exception("[" . $this->response->messages[0]->key . "] " . $this->response->messages[0]->dsc);
        }

        if (!empty($this->response->process_id)) {
            $this->process_id = $this->response->process_id;
        }

        return true;
    }

    /**
     *
     * Return opeartion object.
     *
     * @return object
     *
     **/

    public function get()
    {
        return $this->operation;
    }

    /**
     *
     * Get json represetation of operation object.
     *
     * @return json
     *
     **/

    public function json()
    {
        return json_encode($this->operation);
    }

    /**
     *
     * Return response object (stdClass).
     *
     * @return void
     *
     **/

    public function response()
    {
        return json_decode($this->response_data);
    }

    /**
     *
     * Post data wrapper.
     *
     * @return void
     *
     **/

    public function send($method = "post")
    {
        $this->post($method);

        return $this;
    }
}


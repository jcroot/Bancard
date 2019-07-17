<?php

namespace Bancard\Operations\Card;

use Bancard\Core\Config;
use Bancard\Core\Environments;
use Bancard\Core\Request;
use Bancard\Operations\Operations;

class CardList extends Request
{
    /**
     *
     * Validates data
     *
     * @return void
     *
     **/
    private function validateData(array $data)
    {
        if (count($data) < 1) {
            throw new \InvalidArgumentException("Invalid argument count (at least 5 values are expected).");
        }
        if (!array_key_exists('user_id', $data)) {
            throw new \InvalidArgumentException("user_id argument was not found [user_id].");
        }
    }

    public static function init(array $data)
    {
        # Instance.
        $self = new self;
        # Validate data.
        $self->validateData($data);
        # Set Enviroment.
        $self->environment = (APPLICATION_ENV == 'production') ? Environments::PRODUCTION_URL : Environments::STAGING_URL;
        $self->path = sprintf(Operations::REQUEST_LIST_CARDS, $data['user_id']);
        # Configure extra data.
        if (empty($data['return_url'])) {
            $data['return_url'] = Config::get('return_url');
        }
        # Attach data.
        foreach ($data as $key => $value) {
            $self->addData($key, $value);
        }
        # Generate token.
        $self->getToken('cards_list');
        # Create operation array.
        $self->makeOperationObject();
        return $self;
    }
}

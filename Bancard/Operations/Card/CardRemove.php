<?php

namespace Bancard\Operations\Card;

use Bancard\Core\Config;
use Bancard\Core\Environments;
use Bancard\Core\Request;
use Bancard\Operations\Operations;

class CardRemove extends Request
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
        if (count($data) < 2) {
            throw new \InvalidArgumentException("Invalid argument count (at least 5 values are expected).");
        }
        if (!array_key_exists('user_id', $data)) {
            throw new \InvalidArgumentException("user_id argument was not found [user_id].");
        }
        if (!array_key_exists('alias_token', $data)) {
            throw new \InvalidArgumentException("Card Token argument was not found [alias_token].");
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
        # Attach data.
        foreach ($data as $key => $value) {
            $self->addData($key, $value);
        }
        # Generate token.
        $self->getToken('remove_card');
        # Create operation array.
        $self->makeOperationObject('user_id');
        return $self;
    }
}

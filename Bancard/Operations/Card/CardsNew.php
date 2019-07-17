<?php

namespace Bancard\Operations\Card;

use Bancard\Core\Config;
use Bancard\Core\Environments;
use Bancard\Core\Request;
use Bancard\Operations\Operations;

class CardsNew extends Request
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
        if (count($data) < 4) {
            throw new \InvalidArgumentException("Invalid argument count (at least 5 values are expected).");
        }
        if (!array_key_exists('card_id', $data)) {
            throw new \InvalidArgumentException("card_id argument was not found [card_id].");
        }
        if (!array_key_exists('user_id', $data)) {
            throw new \InvalidArgumentException("user_id argument was not found [user_id].");
        }
        if (!array_key_exists('user_cell_phone', $data)) {
            throw new \InvalidArgumentException("Description argment was not found [description].");
        }
        if (!array_key_exists('user_mail', $data)) {
            throw new \InvalidArgumentException("User email data argument was not found [user_mail].");
        }
    }

    public static function init(array $data, $environment = Environments::STAGING_URL)
    {
        # Instance.
        $self = new self;
        # Validate data.
        $self->validateData($data);
        # Set Enviroment.
        $self->environment = (APPLICATION_ENV == 'production') ? Environments::PRODUCTION_URL : Environments::STAGING_URL;
        $self->path = Operations::REQUEST_NEW_CARD;
        # Configure extra data.
        if (empty($data['return_url'])) {
            $data['return_url'] = Config::get('return_url');
        }
        # Attach data.
        foreach ($data as $key => $value) {
            $self->addData($key, $value);
        }
        # Generate token.
        $self->getToken('cards_new');
        # Create operation array.
        $self->makeOperationObject();
        return $self;
    }
}

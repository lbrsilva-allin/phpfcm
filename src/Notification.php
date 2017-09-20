<?php
namespace PHPFCM;

/**
*   This class has the responsability to render a JSON with a message
* for the Request
*
* @author Georgio Barbosa <georgio.barbosa@gmail.com>
*/

class Notification extends Message
{

    /**
    * @var string $body the main text of notification
    */
    private $body;

    /**
    * @var string $title The notification header
    */
    private $title;

    /**
    * @var string $icon an icon url
    */
    private $icon;

    /**
    * @var string $click_action url to open
    */
    private $click_action;

    protected function buildPayload()
    {
        $payload = $this->payload;

        if(!$this->body !== null) {
            $payload["body"] = $this->body;
        }

        if(!$this->title !== null) {
            $payload["title"] = $this->title;
        }

        if(!$this->icon !== null) {
            $payload["icon"] = $this->icon;
        }

        if(!$this->click_action !== null) {
            $payload["click_action"] = $this->click_action;
        }

        return $payload;
    }

    /**
    * @return the payload key
    */
    protected function getPayloadName()
    {
        return "notification";
    }
}

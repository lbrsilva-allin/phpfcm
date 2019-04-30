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
    * @return the payload key
    */
    protected function getPayloadName()
    {
        return "notification";
    }
}

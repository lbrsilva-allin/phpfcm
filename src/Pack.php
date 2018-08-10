<?php
namespace PHPFCM;

use GuzzleHttp\Client;

/**
* This class has the responsability to pack the messages in a PHP Generator
* @author Georgio Barbosa da Fonseca <georgio.barbosa@gmail.com>
*/
class Pack
{
    /**
    * The reference to the messages in this pack
    * @var Array <PHPFCM\Message> $load
    */
    private $load;

    public function __construct()
    {
        $this->load = array();
    }

    /**
    * Add a message to $load
    * @param PHPFCM\Message $msg
    */
    public function packMessage(Message $msg)
    {
        $this->load[] = $msg;
    }

    /**
    * Make the generator for guzzle pool
    * @param string $key Authorization key
    * @return \Generator
    */
    public function getGeneratorPack($key)
    {
        $header = array(
            "Authorization" => "key=$key",
            "Content-Type" => "application/json"
        );

        $gen = function () use($header){
            foreach ($this->load as $key => $message) {
                yield $message->getID() => new \GuzzleHttp\Psr7\Request(
                    'POST',
                    FCMClient::END_POINT,
                    $header,
                    $message->render()
                );
            }
        };

        return $gen();
    }

    public function getGeneratorPromise($key, Client $client)
    {
        $header = array(
            "Authorization" => "key=$key",
            "Content-Type" => "application/json"
        );

        $promises = [];
        
        foreach ($this->load as $key => $message) {
            $promises[$message->getID()]  = $client->requestAsync(
                'POST',
                FCMClient::END_POINT,
                [
                    "headers" => $header,
                    "body" => $message->render()
                ]
            );
        }

        return $promises;
    }
}

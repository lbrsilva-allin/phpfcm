<?php

namespace PHPFCM;

use GuzzleHttp\Pool;
use GuzzleHttp\Client;

/**
* FCMClient works as an facade for the rest of the whole lib
* @author Georgio Barbosa da Fonseca <georgio.barbosa@gmail.com>
*/
class FCMClient
{
    /**
    * the FCM uri
    */
    const END_POINT = "https://fcm.googleapis.com/fcm/send";

    /**
    * Can be taked at https://console.firebase.google.com/
    * @var String $auth_key Your app auth_key
    */
    private $auth_key;

    /**
    * @var Int $concurrency The total of paralel requisitions
    */
    private $concurrency;

    /**
    * @var array<Response> $responses the server responses
    */
    private $responses = null;

    /**
    * @param String $auth_key
    * @param Int $concurrency
    */
    public function __construct($auth_key, $concurrency = 1)

    {
        $this->auth_key = $auth_key;
        $this->concurrency = $concurrency;
        $this->responses = array();
        $this->rejected = array();
    }

    /**
    * Open a connection with fmc and paralel send the pack
    * @return Array <PHPFCM\FCMResponse>
    * @param
    */
    public function sendPack(Pack $pack)
    {
        $data = $pack->getGeneratorPack($this->auth_key);
        $pool = self::buildGuzzlePool(
            $data,
            $this->concurrency
        );
        $promise = $pool->promise();
        $promise->wait();
        return array("response" => $this->responses, "rejected" => $this->rejected);
    }

    /**
    * Build the GuzzleClient Object
    * @param Function $fulfiled Function for the 200 response requisitions
    * @param Function $rejected Function for the negative responses
    * @param Function $concurrency
    */
    protected function buildGuzzlePool($data, $concurrency = 5)
    {
        $client = new Client();
        $self = & $this;
        $pool = new Pool($client, $data, [
            'concurrency' => $concurrency,
            'fulfilled' => function($response, $index) use ($self){
                $response_contents = $response->getBody()->getContents();
                $self->responses[] = new Response($response_contents);
            },
            'rejected' => function($response, $index) use ($self){
                $self->rejected[] = $response->getResponse();
            }
        ]);
        return $pool;
    }

    public static function makeNotificationPool($callback, $data)
    {
        $pack = new Pack();
        $message_array = self::validMessagePool($callback, $data);
        foreach($message_array as $m) {
            $pack->packMessage(
                new Notification(
                    $m['to'],
                    $m['notification'],
                    $m['message_options']
                )
            );
        }
        return $pack;
    }

    public static function makeMessagePool($callback, $data)
    {
        $pack = new Pack();
        $message_array = self::validMessagePool($callback, $data);
        foreach($message_array as $m) {
            $pack->packMessage(
                new Message(
                    $m['to'],
                    $m['data'],
                    $m['message_options']
                )
            );
        }
        return $pack;
    }

    public static function validMessagePool($callback, $data)
    {
        return array_map(function($m) use ($callback){
            $message = $callback($m);
            if(!is_array($message)){
                throw new \UnexpectedValueException("The \$callback function return must be an array.");
            }
            if(!array_key_exists("to", $message)){
                throw new \UnexpectedValueException("The \"To\" field is required.");
            }
            if(
                !array_key_exists("data", $message) AND
                !array_key_exists("notification", $message)
            ){
                throw new \UnexpectedValueException("The \"notification\" or \"data\" fileds is required.");
            }
            return $message;
        }, $data);
    }
}

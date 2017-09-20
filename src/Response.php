<?php
namespace PHPFCM;

/**
* This class has the responsability return the response attributes
* @author Georgio Barbosa <georgio.barbosa@gmail.com>
*/
class Response {

    /**
    * @var string $message_id
    */
    private $message_id = null;

    /**
    * @var string $multicast_id
    */
    private $multicast_id;

    /**
    * @var string $ucces
    */
    private $succes;

    /**
    * @var string $failure
    */
    private $failure;

    /**
    * @var string $cannonical_ids
    */
    private $cannonical_ids;

    /**
    * @var array $results
    */
    private $results;

    /**
    * @var array $response_array
    */
    private $response_array;

    /**
    * @param string $response The json response
    */
    public function __construct(string $response, Message $message = null)
    {
        $this->message = $message;
        $this->response_array = json_decode($response, true);
        $this->hydrate();
    }

    private function hydrate()
    {
        $this->multicast_id = $this->response_array["multicast_id"];

        $this->success = $this->response_array["success"];
        $this->failure = $this->response_array["failure"];
        $this->cannonical_ids = $this->response_array["canonical_ids"];
        $this->results = $this->response_array["results"][0];
        if(array_key_exists("message_id", $this->results)){
            $this->message_id = $this->results["message_id"];
        }
    }

    public function getMulticastId()
    {
        return $this->multicast_id;
    }

    public function getMessageID()
    {
        return $this->message_id;
    }

    public function getSuccess()
    {
        return (bool)(int)$this->success;
    }

    public function getFailure()
    {
        return (bool)(int)$this->failure;
    }

    public function getCanonicalIDs()
    {
        return $this->cannonical_ids;
    }

    public function getResults()
    {
        return $this->results;
    }

    public function isFailed()
    {
        return (bool)(int)$this->failure;
    }
}

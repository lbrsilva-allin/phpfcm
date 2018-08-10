<?php
namespace PHPFCM;

/**
*   This class has the responsability to render a JSON with a message
* for the Request
*
* @author Georgio Barbosa <georgio.barbosa@gmail.com>
*/

class Message
{
    const PRIORITY_NORMAL = "normal";
    const PRIORITY_HIGH = "high";

    /**
    * This token is generate in the client (Browser|Android|IOS)
    * @var string $to Client address
    */
    private $to;

    /**
    * This parameter tag a message. Only the
    * last tagged message will be showned when the device turns on
    * @var Array $colaspe_key A tag to agroup messages
    */
    private $colaspe_key = null;

    /**
    * Priority
    * @var String ("high"|"normal") $priority Normal or High
    */
    private $priority = null;

    /**
    * Activate an inactive app
    * @var Bool $content_avaliable activate the app
    */
    private $content_avaliable = null;

    /**
    * The notification can be modified by the app
    * before being showned. (IOS only)
    * @var Bool $mutable_content The app can change message
    */
    private $mutable_content = null;

    /**
    * The time ins seconds te notification will be stored
    * in FCM Server if the device is offline
    * @var Int(Seconds) $time_to_live Time to store in seconds
    */
    private $time_to_live = null;

    /**
    * This parameter define an app package to restrict this message
    * @var String $restricted_package_name The package name
    */
    private $restricted_package_name = null;

    /**
    * When this is activated it's make a
    * call to api but none message is sent
    * @var Bool $dry_run Dry run
    */
    private $dry_run = null;

    /**
    * set an id that can be used to recover the message response
    * @var Bool $dry_run Dry run
    */
    private $id = null;

    /**
    * The options for the api
    */
    private $message_options = array();

    /**
    * A key=>values array for the api "data" field
    * @var Array $payload the data field for the FCM api
    */
    protected $payload;

    /**
    *
    * @param string $to The client address
    * @param array $data the data fiels
    */
    public function __construct($to, array $payload, $message_options = array(), $id=null)
    {
        $this->to = $to;
        $this->payload = $payload;
        $this->message_options = $message_options;
        $this->id = $id;
    }

    public function getColapseKey()
    {
        return $this->colaspe_key;
    }

    public function getPriority()
    {
        return $this->priority;
    }

    public function getMutableContent()
    {
        return $this->mutable_content;
    }

    public function getContentAvaliable()
    {
        return $this->content_avaliable;
    }
    public function getTimeToLive(int $val)
    {
        return $this->time_to_live;
    }

    public function getRestrictedPackageName()
    {
        return $this->restricted_package_name;
    }

    public function getDryRun()
    {
        return $this->dry_run;
    }

    public function getPayload()
    {
        return $this->payload;
    }

    public function getTo()
    {
        return $this->to;
    }

    public function getID()
    {
        return $this->id;
    }

    public function setID(bool $id)
    {
        $this->id = $id;
    }


    public function setColapseKey(bool $val)
    {
        $this->colaspe_key = $val;
    }

    public function setPriority(string $val)
    {
        $this->priority = $val;
    }

    public function setMutableContent(bool $val)
    {
        $this->mutable_content = $val;
    }

    public function setContentAvaliable(bool $val)
    {
        $this->content_avaliable = $val;
    }
    public function setTimeToLive(int $val)
    {
        $this->time_to_live = $val;
    }

    public function setRestrictedPackageName(string $val)
    {
        $this->restricted_package_name = $val;
    }

    public function setDryRun(bool $val)
    {
        $this->dry_run = $val;
    }

    private function buildMessageArray()
    {
        $msg = $this->message_options;

        $msg["to"] = $this->to;

        if($this->colaspe_key !== null) {
            $msg["colaspe_key"] = $this->colaspe_key;
        }
        if($this->priority !== null) {
            $msg["priority"] = $this->priority;
        }
        if($this->mutable_content !== null) {
            $msg["mutable_content"] = $this->mutable_content;
        }
        if($this->content_avaliable !== null) {
            $msg["content_avaliable"] = $this->content_avaliable;
        }
        if($this->time_to_live !== null) {
            $msg["time_to_live"] = $this->time_to_live;
        }
        if($this->restricted_package_name !== null) {
            $msg["restricted_package_name"] = $this->restricted_package_name;
        }
        if($this->dry_run !== null) {
            $msg["dry_run"] = $this->dry_run;
        }
        return $msg;
    }

    protected function buildPayload()
    {
        return $this->payload;
    }

    protected function getPayloadName()
    {
        return "data";
    }

    /**
    * @return Json message representation
    */
    public function render()
    {
        $msg = $this->buildMessageArray();
        $msg[$this->getPayloadName()] = $this->buildPayload();
        return json_encode($msg);
    }

}

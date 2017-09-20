<?php
namespace PHPFCMTest;

use PHPFCM\Message;
use Codeception\TestCase\Test;

class MessageTest extends Test
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    public function testSetters()
    {
        $m = new Message("google_token", array("foo" => "bar"));

        $m->setPriority(Message::PRIORITY_NORMAL);

        $msg = json_decode($m->render(), true);

        $this->assertArrayHasKey(
            "priority",
            $msg,
            "Attribute not found"
        );
    }

    public function testRender()
    {
        $m = new Message("google_token", array("foo" => "bar"));
        $msg = json_decode($m->render(), true);

        $this->assertTrue(
            is_array($msg),
            "Bad json return."
        );

        $this->assertArrayHasKey(
            "to",
            $msg,
            "Field to not found."
        );

        $this->assertArrayHasKey(
            "data",
            $msg,
            "Field data not found."
        );

        $this->assertTrue(
            $msg["to"] == "google_token",
            "Invalid Value to field to"
        );

        $this->assertTrue(
            is_array($msg["data"]),
            "Field data not found"
        );

        $this->assertArrayHasKey(
            "foo",
            $msg["data"],
            "Invalid values for field data"
        );
    }
}

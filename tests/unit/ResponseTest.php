<?php
namespace PHPFCMTest;

use Codeception\TestCase\Test;
use Codeception\Util\Debug;
use PHPFCM\Response;


class ResponseTest extends Test
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testGetmulticastId()
    {
        $r = new Response(self::mockJsonResponseOk());
        $this->assertEquals($r->getMulticastId() , "9209617363386672630");
    }
    public function testisFailed()
    {
        $r = new Response(self::mockJsonResponseOk());
        $this->assertFalse($r->isFailed());

        $r = new Response(self::mockJsonResponseErr());
        $this->assertTrue($r->isFailed());

    }

    private static function mockJsonResponseErr()
    {
        return '{"multicast_id":-1,"success":0,"failure":1,"canonical_ids":0,"results":[{"error":"InvalidRegistration"}]}';
    }

    private static function mockJsonResponseOk()
    {
        return '{"multicast_id":9209617363386672630,"success":1,"failure":0,"canonical_ids":0,"results":[{"message_id":"0:1505854204683779%2fd9afcdf9fd7ecd"}]}';
    }
}

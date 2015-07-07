<?php

namespace BrownPaperTickets\APIv2;

use PHPUnit_Framework_TestCase;

class BrownPaperTicketsClassTest extends \PHPUnit_Framework_TestCase
{
    public $bpt = null;

    public function __construct()
    {
        $this->bpt = new BptAPI('notneeded', array('logErrors' => true));
    }

    // public function testCheckDateFormat()
    // {
    //     $badDate = '1-14-1986 7:24';

    //     $goodDate = 'JAN-14-1986 07:00';

    //     $expectFalse = $this->bpt->checkDateFormat($badDate);

    //     $expectTrue = $this->bpt->checkDateFormat($goodDate);

    //     $this->assertInternalType('boolean', $expectFalse);

    // }
    public function testSetOption()
    {
        $setOption = $this->bpt->setOption('logErrors', true);

        $logErrors = $this->bpt->getOption('logErrors');

        $this->assertTrue($setOption);
        $this->assertTrue($logErrors);
    }

    /**
     * @expectedException Exception
     */
    public function testSetOptionException()
    {
        $this->bpt->getOption('something');
    }

    public function testErrors()
    {
        $this->bpt->setError('someMethod', 'Some Error');
        $this->bpt->setError('anotherMethod', 'WHAT IS HAPPENING');
        $this->bpt->setError('methodMan', 'ANOTHER ERROR?');

        $newest = $this->bpt->getErrors('newest');

        $this->assertArrayHasKey('methodMan', $newest);

        $allErrors = $this->bpt->getErrors();

        $this->assertCount(3, $allErrors);
    }

    public function testSetLogger()
    {
        $logger = new \Monolog\Logger('test-logger');
        $file = fopen('php://memory', 'rw');

        $logger->pushHandler(new \Monolog\Handler\StreamHandler($file, $logger::DEBUG));

        $this->assertInstanceOf('\Psr\Log\LoggerInterface', $this->bpt->setLogger($logger));
    }

    public function testSetDebug()
    {
        $this->bpt->setOption('debug', true);

        $this->assertTrue($this->bpt->getOption('debug'));
    }

    public function testDebugLogging()
    {
        $logger = new \Monolog\Logger('test-logger');
        $file = fopen('php://memory', 'rw');

        $logger->pushHandler(new \Monolog\Handler\StreamHandler($file, $logger::DEBUG));

        $event = new \BrownPaperTickets\APIv2\EventInfo(getenv('DEVID'), array(
            'debug' => true
        ));

        $event->setLogger($logger);

        $event->getEvents('chandler');

        rewind($file);
        $file = stream_get_contents($file);
        $this->assertContains('API Call: ', $file);
        $this->assertContains('API Response: ', $file);
    }
}

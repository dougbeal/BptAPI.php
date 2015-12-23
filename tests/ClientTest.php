<?php

namespace BrownPaperTicketsTests;

use BrownPaperTickets\Api;
use BrownPaperTickets\Client;
use Monolog\Logger;
use Symfony\Component\VarDumper\VarDumper;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    public function testApi()
    {
        $configurations = require('config/api.php');

        $api = new Api(new Client($configurations));

        $response = $api->call('eventlist', [
            'event_id'  => '153529'
        ]);

        VarDumper::dump($response);
    }
}

<?php

namespace BrownPaperTicketsTests;

use BrownPaperTickets\Api;
use BrownPaperTickets\Client;
use BrownPaperTickets\Logger\VoidLogger;
use Symfony\Component\VarDumper\VarDumper;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    public function testApi()
    {
        $configurations = require('config/api.php');

        $client = new Client($configurations);
        $logger = new VoidLogger();
        $client->setLogger($logger);

        $api = new Api($client);

        $response = $api->call('eventlist', [
            'event_id'  => '153529'
        ]);

        VarDumper::dump($response);
    }
}

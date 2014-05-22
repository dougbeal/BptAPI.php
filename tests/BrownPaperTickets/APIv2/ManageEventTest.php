<?php

namespace BrownPaperTickets\APIv2;

use PHPUnit_Framework_TestCase;

class BrownPaperTicketsCreateEventTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Test that true does in fact equal true
     */

    public function __construct()
    {
        $this->bptApi = new BptApi('p9ny29gi5h');
    }

    public function testCreateEvent()
    {
        $bpt = $this->bptApi;

        $eventParams = Array(
            'name' => 'Test - PHP Create Event',
            'city' => 'Seattle',
            'state' => 'WA',
            'shortDescription' => 'This is a short description.',
            'fullDescription' => 'This is a Full Description. So long.'
        );

        $createEvent = $bpt->createEvent('chandler_api', $eventParams);

        print_r($createEvent);
    }
}
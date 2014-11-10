<?php

namespace BrownPaperTickets\APIv2;

//use BrownPaperTickets\APIv2\eventInfo;
use PHPUnit_Framework_TestCase;

class BrownPaperTicketsGetEventImagesTest extends \PHPUnit_Framework_TestCase
{
    public function __construct()
    {
        $this->eventInfo = new EventInfo('p9ny29gi5h');
    }

    public function testGetImages()
    {
        $eventWithImages = 153529;
        $eventWithoutImages = 900435;
        $invalidEvent = 153512;

        $eventImages = $this->eventInfo->getEventImages($eventWithImages);
        $noImages = $this->eventInfo->getEventImages($eventWithoutImages);
        $invalidImages = $this->eventInfo->getEventImages($invalidEvent);

        $this->assertArrayHasKey('large', $eventImages[0]);
        $this->assertArrayHasKey('medium', $eventImages[0]);
        $this->assertArrayHasKey('small', $eventImages[0]);

        $this->assertCount(3, $eventImages);

        $this->assertEquals('http://www.brownpapertickets.com/g/e/64100-250.gif', $eventImages[0]['large']);
        $this->assertEquals('http://www.brownpapertickets.com/g/e/64100-100.gif', $eventImages[0]['medium']);
        $this->assertEquals('http://www.brownpapertickets.com/g/e/64100-50.gif', $eventImages[0]['small']);

        $this->assertEquals('http://www.brownpapertickets.com/g/e/54148-250.gif', $eventImages[1]['large']);
        $this->assertEquals('http://www.brownpapertickets.com/g/e/54148-100.gif', $eventImages[1]['medium']);
        $this->assertEquals('http://www.brownpapertickets.com/g/e/54148-50.gif', $eventImages[1]['small']);

        $this->assertEquals('http://www.brownpapertickets.com/g/e/394622-250.gif', $eventImages[2]['large']);
        $this->assertEquals('http://www.brownpapertickets.com/g/e/394622-100.gif', $eventImages[2]['medium']);
        $this->assertEquals('http://www.brownpapertickets.com/g/e/394622-50.gif', $eventImages[2]['small']);

        $this->assertArrayHasKey('error', $noImages);
        $this->assertEquals('No images found.', $noImages['error']);

        $this->assertArrayHasKey('error', $invalidImages);
        $this->assertEquals('Invalid event.', $invalidImages['error']);

    }
}

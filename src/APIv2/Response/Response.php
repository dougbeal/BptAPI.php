<?php

namespace BrownPaperTickets\APIv2\Response;

use BrownPaperTickets\Parser\XmlParser;

abstract class Response
{
    /**
     * Unformatted response from the server
     * @var string
     */
    protected $rawResponse;

    protected $parsedResponse;

    protected $result;

    protected $resultCode;

    public function setResponse($response)
    {
        $this->rawResponse = $response;

        $parser = XmlParser();

        $this->parsedResponse = $parser->parse($response);
    }
}
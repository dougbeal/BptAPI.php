<?php

namespace BrownPaperTickets\Parser;

class XmlParser implements ParserInterface
{
    /**
     * parse the XML file
     *
     * @param string $rawXML the XML string to parse
     * @return object $xmlTree A parsed XML object
     */
    public function parse($rawXML)
    {
        libxml_use_internal_errors(true);

        return new SimpleXMLElement($rawXML);
    }
}
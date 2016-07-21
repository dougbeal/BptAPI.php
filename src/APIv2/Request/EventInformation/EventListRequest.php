<?php

namespace BrownPaperTickets\APIv2\Request\EventInformation;

use BrownPaperTickets\APIv2\Request\Request;

class EventListRequest extends Request
{

    public function __construct($params = [])
    {
        parent::__construct($params);
    }

    protected function setRequiredParams()
    {
        $this->requiredParams = [];
    }

    public function getEndpoint()
    {
        return '/eventlist';
    }
}
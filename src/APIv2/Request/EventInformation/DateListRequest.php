<?php
/**
 * Created by PhpStorm.
 * User: m_tanguay
 * Date: 12/23/2015
 * Time: 4:11 PM
 */

namespace BrownPaperTickets\APIv2\Request\EventInformation;

use BrownPaperTickets\APIv2\Request\Request;

class DateListRequest extends Request
{
    public function __construct($params = [])
    {
        parent::__construct();
        $this->params = $params;
    }

    protected function setRequiredParams()
    {
        $this->requiredParams = [
            'event_id'
        ];
    }
}
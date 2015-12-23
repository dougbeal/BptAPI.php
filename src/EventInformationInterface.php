<?php
/**
 * Created by PhpStorm.
 * User: m_tanguay
 * Date: 12/23/2015
 * Time: 4:40 PM
 */

namespace BrownPaperTickets\APIv2;

interface EventInformationInterface
{
    public function getEventList();
    public function getDateList();
    public function getPriceList();
}
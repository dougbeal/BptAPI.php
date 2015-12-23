<?php
/**
 * Created by PhpStorm.
 * User: m_tanguay
 * Date: 12/23/2015
 * Time: 4:41 PM
 */

namespace BrownPaperTickets;

interface SalesInformationInterface
{
    public function getEventSales();
    public function getDateSales();
    public function getOrderList();
}
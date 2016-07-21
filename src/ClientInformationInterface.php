<?php
/**
 * Created by PhpStorm.
 * User: m_tanguay
 * Date: 12/23/2015
 * Time: 4:42 PM
 */

namespace BrownPaperTickets;

interface ClientInformationInterface
{
    public function getAccountInformation();
    public function getSubAccountInformation();
    public function getPrinterList();
}
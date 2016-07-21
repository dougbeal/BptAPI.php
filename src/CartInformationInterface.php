<?php
/**
 * Created by PhpStorm.
 * User: lunfel
 * Date: 23/12/15
 * Time: 6:37 PM
 */

namespace BrownPaperTickets;


interface CartInformationInterface
{
    public function getCartContents();
    public function getCartValue();
}
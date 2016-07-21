<?php
/**
 * Created by PhpStorm.
 * User: lunfel
 * Date: 23/12/15
 * Time: 6:37 PM
 */

namespace BrownPaperTickets;


interface ManageEventInterface
{
    public function createEvent();
    public function changeEvent();
    public function addDate();
    public function changeDate();
    public function addPrice();
    public function changePrice();
}
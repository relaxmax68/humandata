<?php

namespace CalendarBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class CalendarBundle extends Bundle
{
   public function getParent()
    {
        return 'BladeTesterCalendarBundle';
    }
}
<?php

namespace Collect;

use DateTime;

class ActivityProcessorDefault implements ActivityProcessorInterface
{
  public function processRange(DateTime $startDate, DateTime $endDate, array $records)
  {
    // This is just a placeholder for doing some work with activity
  }
}
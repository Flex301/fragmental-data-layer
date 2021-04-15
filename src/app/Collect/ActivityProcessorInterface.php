<?php

namespace Collect;

interface ActivityProcessorInterface {
  public function processRange(\DateTime $startDate, \DateTime $endDate, array $records);
}
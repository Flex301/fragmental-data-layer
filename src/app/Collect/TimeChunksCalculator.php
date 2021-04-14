<?php

namespace Collect;

/** 
 * 
 */
class TimeChunksCalculator {

  public function calculate(\DateTime $startDate, \DateTime $endDate) : array {

    $chunkStart = clone $startDate;
    $chunks = [];
    $processed = false;
    $chunkDaysSize = 30;

    while (!$processed) {
      $chunk = [];

      if ($endDate->getTimestamp() - $chunkStart->getTimestamp() > 86400 * $chunkDaysSize) {
        $chunk[] = clone $chunkStart;
        $chunkStart->add(new \DateInterval('P30D'))->sub(new \DateInterval("PT1S"));
        $chunk[] = clone $chunkStart;
        $chunkStart->add(new \DateInterval("PT1S"));
      } else {
        $chunk[] = clone $chunkStart;
        $chunk[] = clone $endDate;
        $processed = true;
      }

      $chunks[] = $chunk;
    }

    return $chunks;
  }

}
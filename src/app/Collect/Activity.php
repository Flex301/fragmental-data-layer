<?php

namespace Collect;

use Api\ApiRangeInterface;
use Api\DataLimitException;

class Activity {

  public function collectByRanges(ApiRangeInterface $api, array $dateRanges) {

    foreach ($dateRanges as $dateRange) {
      list($startDate, $endDate) = $dateRange;

      try {
        $api->getRecordsByRange($startDate, $endDate);
      } catch (DataLimitException $ex) {
        $splitter = new TimeChunksSplitter();
        $newRanges = $splitter->split($startDate, $endDate);
        $this->collectByRanges($api, $newRanges);
      }
    }
  }
}
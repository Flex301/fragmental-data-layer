<?php

namespace Collect;

use Api\ApiRangeInterface;
use Api\DataLimitException;
use Log\TimeChunksLogInterface;

class Activity {

  private $api;
  private $log;
  private $processor;

  public function __construct(ApiRangeInterface $api, TimeChunksLogInterface $log, ActivityProcessorInterface $activityProcessor)
  {
    $this->api = $api;
    $this->log = $log;
    $this->processor = $activityProcessor;
  }

  public function collectByRanges(array $dateRanges) {

    foreach ($dateRanges as $dateRange) {
      list($startDate, $endDate) = $dateRange;

      try {
        $records = $this->api->getRecordsByRange($startDate, $endDate);
        $this->processor->processRange($startDate, $endDate, $records);
        $this->log->logChunk($startDate, $endDate);
      } catch (DataLimitException $ex) {
        $splitter = new TimeChunksSplitter();
        $newRanges = $splitter->split($startDate, $endDate);
        $this->collectByRanges($newRanges);
      }
    }
  }
}
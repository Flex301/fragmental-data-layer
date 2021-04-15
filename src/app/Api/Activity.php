<?php

namespace Api;

class Activity implements ApiRangeInterface {

  private string $dataFile;
  private int $userId;

  public function __construct(int $userId)
  {
    $this->userId = $userId;
    $this->dataFile = realpath(__DIR__ . "/../../data/logs.txt");
  }

  /** 
   * NOTE: This is just imitation of the api behavior 
   */
  public function getRecordsByRange(\DateTime $startDate, \DateTime $endDate) : array {

    $startTime = $startDate->getTimestamp();
    $endTime = $endDate->getTimestamp();

    // Just imitation: It throws DataLimitException when more than 10 days requested
    $dataLimitPeriod = 86400 * 10;

    if ($endTime - $startTime > $dataLimitPeriod) {
      throw new DataLimitException("Data limit per user reached");
    }

    return json_decode(file_get_contents($this->dataFile));
  }
}
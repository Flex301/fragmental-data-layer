<?php

namespace Api;

interface ApiRangeInterface {
  public function getRecordsByRange(\DateTime $startDate, \DateTime $endDate) : array;
}
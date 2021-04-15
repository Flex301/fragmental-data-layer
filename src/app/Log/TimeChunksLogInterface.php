<?php

namespace Log;

interface TimeChunksLogInterface {
  public function logChunk(\DateTime $startDate, \DateTime $endDate) : void;
}
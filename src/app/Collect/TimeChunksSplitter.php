<?php

namespace Collect;

/** 
 * Divide time period into two equal pieces
 */
class TimeChunksSplitter {

  public function split(\DateTime $chunkStart, \DateTime $chunkEnd) : array {
    $newChunks = [];
    $chunkDiff = $chunkEnd->getTimestamp() - $chunkStart->getTimestamp();
    $chunkStartShift = floor($chunkDiff / 2);

    $newChunks[] = [
      clone $chunkStart,
      clone $chunkStart->add(new \DateInterval("PT{$chunkStartShift}S"))
    ];

    $newChunks[] = [
      clone $chunkStart->add(new \DateInterval("PT1S")),
      clone $chunkEnd
    ];

    return $newChunks;
  }

}
<?php

namespace Log;

use Storage\KeyValueStorageInterface;

/**
 * The purpose of this class is to keep time chunks before saving using given storage
 */
class JsonFileTimeChunkLog implements TimeChunksLogInterface {

  private array $dateRange = [];
  private array $chunks = [];
  private KeyValueStorageInterface $storage;

  public function __construct(
    \DateTime $startDate,
    \DateTime $endDate,
    KeyValueStorageInterface $storage
  )
  {
    $this->dateRange = [$startDate, $endDate];
    $this->storage = $storage;
  }

  public function logChunk(\DateTime $startDate, \DateTime $endDate): void
  {
    $this->chunks[] = [$startDate->format('Y-m-d H:i:s'), $endDate->format('Y-m-d H:i:s')];
  }

  public function save() {
    list($start, $end) = $this->dateRange;
    $key = sprintf("%s,%s", $start->format("Y-m-d H:i:s"), $end->format("Y-m-d H:i:s"));
    $this->storage->save($key, $this->chunks);
  }

  public function load() {
    list($start, $end) = $this->dateRange;
    $key = sprintf("%s,%s", $start->format("Y-m-d H:i:s"), $end->format("Y-m-d H:i:s"));
    $chunks = $this->storage->retrieve($key);

    if (!is_null($chunks)) {
      $chunks = array_map(function($chunk) {
        return [new \DateTime($chunk[0]), new \DateTime($chunk[1])];
      }, $chunks);
    }

    return $chunks;
  }
}
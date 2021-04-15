<?php

// Add our app files path to include paths
set_include_path(get_include_path() . PATH_SEPARATOR . "app/");

// Use default autoload implementation
spl_autoload_register();

use Collect\Activity as ActivityCollector;
use Api\Activity as ActivityApi;
use Collect\TimeChunksCalculator;
use Log\JsonFileTimeChunkLog;
use Storage\JsonFileStorage;
use Collect\ActivityProcessorDefault;

// Create date range for our API
$startDate = new \DateTime("2021-01-01 00:00:00");
$endDate = new \DateTime("2022-05-01 00:00:00");

// Create logger for calculation results
$logger = new JsonFileTimeChunkLog($startDate, $endDate, new JsonFileStorage(__DIR__ . "/data/search.json"));

// Trying to find saved calculation results
$chunks = $logger->load();

// If we don't have saved chunks, then use calculator to calculate them from the given date range
if (is_null($chunks)) {
  $chunkCalculator = new TimeChunksCalculator();
  $chunks = $chunkCalculator->calculate($startDate, $endDate);
}

// Pass random user id 
$api = new ActivityApi(1);

// This is some activity processor just for imitation of some work
$activityProcessor = new ActivityProcessorDefault();

// Run activity collector to get user activity
$collector = new ActivityCollector($api, $logger, $activityProcessor);
$collector->collectByRanges($chunks);

// Save chunks to a file
$logger->save();
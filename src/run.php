<?php

set_include_path(get_include_path() . PATH_SEPARATOR . "app/");

// Use default autoload implementation
spl_autoload_register();

use Collect\Activity as ActivityCollector;
use Api\Activity as ActivityApi;
use Collect\TimeChunksCalculator;

$api = new ActivityApi(1);
// $api->getRecordsByRange(1, new \DateTime(), new \DateTime("2021-05-01 00:00:00"));

$chunkCalculator = new TimeChunksCalculator();
$chunks = $chunkCalculator->calculate(new \DateTime(), new \DateTime("2022-05-01 00:00:00"));

$collector = new ActivityCollector;
$collector->collectByRanges($api, $chunks);
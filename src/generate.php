<?php

$curlHandle = curl_init();

curl_setopt_array($curlHandle, [
  CURLOPT_URL => "https://randomuser.me/api/?inc=location&results=3000",
  CURLOPT_RETURNTRANSFER => true
]);

$fileHandle = fopen(__DIR__ . "/data/logs.txt", "w+");

$i = 0;

$date = new DateTime("2021-01-31 00:00:00");
$shiftInSeconds = 0;

// Write approx 10MB
while($i < 8) {
  $results = curl_exec($curlHandle);

  $decodedData = json_decode($results);

  $decodedData = array_map(function($decodedRow) use (&$shiftInSeconds, &$date) {
    $decodedRow->date = $date->add(new \DateInterval("PT{$shiftInSeconds}S"))->format("Y-m-d H:i:s");
    // Each time we shift by more seconds
    $shiftInSeconds += 2;
    return $decodedRow;
  }, $decodedData->results);

  $encodedData = json_encode($decodedData);

  fwrite($fileHandle, $encodedData);

  echo "Wrote " . strlen($encodedData) . " Bytes\n";

  sleep(50);
}

fclose($fileHandle);
curl_close($curlHandle);
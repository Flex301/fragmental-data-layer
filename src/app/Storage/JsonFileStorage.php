<?php

namespace Storage;

/** 
 * Key-value json file storage 
 */
class JsonFileStorage implements KeyValueStorageInterface
{  
  private string $filePath;

  public function __construct(string $filePath)
  {
    if (!file_exists($filePath)) {
      $fileHandle = fopen($filePath, "w+");
      fclose($fileHandle);
    }

    $this->filePath = $filePath;
  }

  public function save(string $key, $value): void
  {
    $data = (array)json_decode(file_get_contents($this->filePath));
    $data[$key] = $value;
    file_put_contents($this->filePath, json_encode($data));
  }

  public function retrieve(string $key, $default = null)
  {
    $data = (array)json_decode(file_get_contents($this->filePath));
    if (array_key_exists($key, $data)) {
      return $data[$key];
    }

    return null;
  }
}
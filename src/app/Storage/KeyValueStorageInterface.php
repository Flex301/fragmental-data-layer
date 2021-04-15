<?php

namespace Storage;

interface KeyValueStorageInterface {
  public function save(string $key, $value) : void;
  public function retrieve(string $key);
}
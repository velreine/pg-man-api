<?php

namespace App\DBAL;

interface CreateableInterface {

  /**
   * The method must return an array of strings that can be executed on the platform to create the type.
   * @return array<string>
   */
  public function GetCreateScript() : array;

}
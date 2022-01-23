<?php

namespace App\DBAL;

use App\DBAL\Objects\Role;
use App\DBAL\Objects\Schema;

/**
 * Interface for any object that belongs in a schema.
 */
interface SchemaObjectInterface {

  /**
   * Should return a reference to the schema it belongs to.
   * @return Schema
   */
  public function getSchema() : Schema;

  public function getOwner(): Role;

}
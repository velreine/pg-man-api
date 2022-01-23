<?php
declare(strict_types=1);

namespace App\DBAL\Objects\Schema;

use App\DBAL\Objects\Role;
use App\DBAL\Objects\Schema;
use App\DBAL\SchemaObjectInterface;

final class DBFunction implements SchemaObjectInterface {

  // TODO: NOT FINISHED...
  public function __construct(
    private string $name,
    private Schema $schema,
    private Role $owner
  )
  {
  }

  public function getName(): string {
    return $this->name;
  }

  public function getSchema(): Schema
  {
    return $this->schema;
  }

  public function getOwner(): Role
  {
    return $this->owner;
  }
}
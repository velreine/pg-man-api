<?php
declare(strict_types=1);

namespace App\DBAL\Objects\Schema\Type;

use App\DBAL\CreateableInterface;
use App\DBAL\Objects\Role;
use App\DBAL\Objects\Schema;
use App\DBAL\SchemaObjectInterface;

class ShellType implements CreateableInterface, SchemaObjectInterface {

  /**
   * Shell types are needed as forward references when creating range types and base types.
   * @see https://www.postgresql.org/docs/14/sql-createtype.html
   * @param string $name Name of the new type to create.
   */
  public function __construct(
    protected string $name,
    protected Schema $schema,
    protected Role $owner,
  )
  {
  }

  final protected function getName(): string {
    return $this->name;
  }

  final public function getOwner(): Role {
    return $this->owner;
  }

  public function GetCreateScript() : array
  {
    return ["CREATE TYPE $this->name;"];
  }

  final public function getSchema(): Schema
  {
    return $this->schema;
  }
}
<?php

namespace App\DBAL\Other;

use App\DBAL\Objects\Schema\Collation;

/**
 * The class just represents a function argument.
 */
final class CompositeTypeAttribute {

  /**
   * @param string $argumentName Name of the argument e.g. (num)
   * @param string $type Type of the argument, a built-in one or a user-defined type (optionally schema qualified).
   * @param ?Collation $collation The attribute's collation can be specified too, if its datatype is collatable.
   */
  public function __construct(
    private string $argumentName,
    private string $type, // todo: how to mix pre-known types "built-in-types" vs user-defined-types??
    private ?Collation $collation,
  )
  {
  }

  public function getArgumentName() : string {
    return $this->argumentName;
  }

  public function getType(): string {
    return $this->type;
  }

  public function getCollation(): ?Collation {
    return $this->collation;
  }

  public function getDDLRepresentation() : string {

    // TO be used in scenarios like:
    // CREATE TYPE compfoo AS (f1 int [COLLATE], f2 text)
    // will return f1 int [COLLATE]
    return "{$this->argumentName} {$this->type} {$this->collation->getSchema()}.{$this->collation->getName()}";
  }

}
<?php

namespace App\DBAL\Objects;

final class Schema {

  public function __construct(
    private string $name
  )
  {
    // Collations
    // Domains
    // FTS Configurations
    // FTS Parsers
    // Foreign Tables
    // Functions
    // Materialized Views
    // Procedures
    // Sequences
    // Tables
    // Trigger Functions
    // Types
    // Views
  }

  public function getName(): string {
    return $this->name;
  }

}
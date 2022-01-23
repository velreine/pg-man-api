<?php

namespace App\DBAL\Objects;

final class Role
{

  public function __construct(
    private string $name
  )
  {
  }

  public function getName(): string {
    return $this->name;
  }

}
<?php

namespace App\DBAL\Objects;

enum CastContext {
  /* Indicates that the cast can be invoked implicitly in assignment contexts. */
  case Assignment;

  /* Indicates that the cast can be invoked implicitly in any context. */
  case Implicit;
}

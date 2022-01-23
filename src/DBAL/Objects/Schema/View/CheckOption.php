<?php
declare(strict_types=1);

namespace App\DBAL\Objects\Schema\View;

enum CheckOption {
  case Local;
  case Cascaded;
}
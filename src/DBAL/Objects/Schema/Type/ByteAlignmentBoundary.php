<?php
declare(strict_types=1);

namespace App\DBAL\Objects\Schema\Type;

enum ByteAlignmentBoundary {
  case ONE_BYTE;
  case TWO_BYTES;
  case FOUR_BYTES;
  case EIGHT_BYTES;
}
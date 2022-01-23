<?php
declare(strict_types=1);

namespace App\DBAL\Objects\Schema\Type;

enum TypeCategory: string {
  case ArrayType = 'A';
  case BooleanType = 'B';
  case CompositeType = 'C';
  case DateTimeType = 'D';
  case EnumType = 'E';
  case GeometricType = 'G';
  case NetworkAddressType = 'I';
  case NumericType = 'N';
  case PseudoType = 'P';
  case RangeType = 'R';
  case StringType = 'S';
  case TimeSpanType = 'T';
  case UserDefinedType = 'U';
  case BitStringType = 'V';
  case UnknownType = 'X';
}
<?php
declare(strict_types=1);

namespace App\DBAL\Objects\Schema\Table;

use App\DBAL\DatabaseObject;
use App\DBAL\Objects\Schema;
use App\DBAL\Objects\Schema\Collation;
use App\DBAL\Objects\Schema\Domain;
use App\DBAL\Objects\Schema\Type\ShellType;

enum IdentityGeneration: string {
  case Always = 'ALWAYS';
  case ByDefault = 'BY DEFAULT';
}






final class Column  {

  public function __construct(
    private string $name,
    private int $ordinalPosition,
    private bool $nullable,
    private string $columnDefault,
    private string $dataType,
    private int $characterMaximumLength,
    private int $characterOctetLength,
    private int $numericPrecision,
    private int $numericPrecisionRadix,
    private int $numericScale,
    private int $datetimePrecision,
    private string $intervalType,
    private int $intervalPrecision,
    private DatabaseObject $collationCatalog,
    private Schema $collationSchema,
    private Collation $collation,
    private DatabaseObject $domainCatalog,
    private Schema $domainSchema,
    private Domain $domain,
    private DatabaseObject $udtCatalog,
    private Schema $udtSchema,
    private Schema\Type\ShellType $udt,
    private string $dtdIdentifier,
    private bool $isIdentity,
    private ?IdentityGeneration $identityGeneration,
    private int $identityStart,
    private int $identityIncrement,
    private int $identityMaximum,
    private int $identityMinimum,
    private ?bool $identityCycle,
    private ?bool $isGenerated,
    private ?string $generatedExpression,



  )
  {
  }

}
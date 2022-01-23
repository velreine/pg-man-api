<?php
declare(strict_types=1);

namespace App\DBAL\Objects\Schema\Type;

use App\DBAL\Objects\Role;
use App\DBAL\Objects\Schema;
use App\DBAL\Objects\Schema\Collation;
use App\DBAL\Objects\Schema\DBFunction;
use JetBrains\PhpStorm\Pure;

final class RangeType extends ShellType
{
  /**
   * @param string $name Name of the range type.
   * @param Schema $schema Schema that the type belongs in.
   * @param Role $owner Owner of the new type, per default the creator of the type.
   * @param ShellType $subType The name of the element type that the range type will represent ranges of.
   * @param string|null $subTypeOperatorClass The name of a b-tree operator class for the subtype.
   * @param Collation|null $collation The name of an existing collation to be associated with a column of a composite type, or with a range type.
   * @param DBFunction|null $canonicalFunction The name of the canonicalization function for the range type.
   * @param DBFunction|null $subTypeDiffFunction The name of a difference function for the subtype.
   * @param string|null $multiRangeTypeName The name of the corresponding multirange type.
   */
  #[Pure]
  public function __construct(
    protected string    $name,
    protected Schema    $schema,
    protected Role      $owner,

    private ShellType   $subType,
    private ?string     $subTypeOperatorClass = null,
    private ?Collation  $collation = null,
    private ?DBFunction $canonicalFunction = null,
    private ?DBFunction $subTypeDiffFunction = null,
    private ?string     $multiRangeTypeName = null,
  )
  {
    parent::__construct($this->name, $this->schema, $this->owner);
  }

  #[Pure]
  public function GetCreateScript(): array
  {
    //CREATE TYPE name AS RANGE (
    //SUBTYPE = subtype
    //[ , SUBTYPE_OPCLASS = subtype_operator_class ]
    //[ , COLLATION = collation ]
    //[ , CANONICAL = canonical_function ]
    //[ , SUBTYPE_DIFF = subtype_diff_function ]
    //[ , MULTIRANGE_TYPE_NAME = multirange_type_name ]
    //)

    $str = "CREATE TYPE $this->name AS RANGE (\r\n";

    $str .= "SUBTYPE = {$this->subType->getSchema()->getName()}.{$this->subType->getName()}\r\n";

    if($this->subTypeOperatorClass !== null) {
      $str .= ", SUBTYPE_OPCLASS = $this->subTypeOperatorClass\r\n";
    }

    if ($this->collation !== null) {
      $str .= ", COLLATION = {$this->collation->getSchema()->getName()}.{$this->collation->getName()}\r\n";
    }

    if ($this->canonicalFunction !== null) {
      $str .= ", CANONICAL = {$this->canonicalFunction->getSchema()->getName()}.{$this->canonicalFunction->getName()}\r\n";
    }

    if ($this->subTypeDiffFunction !== null) {
      $str .= ", SUBTYPE_DIFF = {$this->subTypeDiffFunction->getSchema()->getName()}.{$this->subTypeDiffFunction->getName()}\r\n";
    }

    if ($this->multiRangeTypeName !== null) {
      $str .= ", MULTIRANGE_TYPE_NAME = $this->multiRangeTypeName\r\n";
    }

    // End the string.
    $str .= ");";

    return [$str];
  }


}
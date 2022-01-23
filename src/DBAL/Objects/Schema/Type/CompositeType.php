<?php
/** @noinspection SpellCheckingInspection */
declare(strict_types=1);

namespace App\DBAL\Objects\Schema\Type;

use App\DBAL\Objects\Role;
use App\DBAL\Objects\Schema;
use App\DBAL\Other\CompositeTypeAttribute;
use JetBrains\PhpStorm\Pure;

/**
 * Represents a CompositeType useful in scenarios like:
 *  CREATE FUNCTION getfoo() RETURNS SETOF compfoo AS $$
 *    SELECT fooid, fooname FROM foo
 *  $$ LANGUAGE SQL;
 */
final class CompositeType extends ShellType
{

  /**
   * @param string $name Name of the composite types.
   * @param CompositeTypeAttribute[] $attributes
   */
  #[Pure]
  public function __construct(
    protected string $name,
    protected Schema $schema,
    protected Role $owner,
    private array    $attributes,
  )
  {
    parent::__construct($this->name, $this->schema, $this->owner);
  }

  public function GetCreateScript(): array
  {

    /** @var CompositeTypeAttribute $attributeStrings */
    $attributeStrings = array_map(function ($attribute) {
      return $attribute->getDDLRepresentation();
    }, $this->attributes);


    // CREATE TYPE compfoo AS (f1 int, f2 text);
    /** @noinspection PhpParamsInspection IDK why php-storm does this. */
    return ["CREATE TYPE $this->name AS (" . implode(',', $attributeStrings) . ");"];
  }

}



/**
 *
 * CREATE TYPE name AS
 *  ( [ attribute_name data_type [ COLLATE collation ] [, ... ] ] )
 * */



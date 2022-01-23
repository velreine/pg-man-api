<?php
declare(strict_types=1);

namespace App\DBAL\Objects\Schema\Type;


use App\DBAL\Objects\Role;
use App\DBAL\Objects\Schema;
use Exception;

final class EnumType extends ShellType {

  public const NAMEDATALEN = 64;

  /**
   * @param string $name Name of the enum type.
   * @param array<string> $values A list of labels, each of which must be less than NAMEDATALEN bytes long (64 bytes in a standard PostgreSQL build)
   * @throws Exception
   */
  public function __construct(
    protected string $name,
    protected Schema $schema,
    protected Role $owner,
    private array $values,
  )
  {

    parent::__construct($this->name, $this->schema, $this->owner);

    foreach($this->values as $value) {
      if(!is_string($value)) {
        throw new Exception('All values of EnumType must be strings.');
      }

      if(strlen($value) > self::NAMEDATALEN) {
        trigger_error("A string with a byte length above the supported default which is: " . self::NAMEDATALEN . " (in a standard PostgreSQL build) was passed to EnumType::construct");
      }
    }
  }

  public function GetCreateScript(): array
  {

    // TODO:: Guarantee strings are quoted properly

    // Removes any ' character or " character in the label.
    $withRemovedQuotes = array_map(function($value) {
      return str_replace('"', '', str_replace("'", "", $value));
    }, $this->values);

    // Appends and prepends label with single quote ex new => 'new'
    $wrappedInQuotes = array_Map(function($value) {
      return "'" . $value . "'";
    }, $withRemovedQuotes);

    // CREATE TYPE bug_status AS ENUM('new','open','closed');
    return [
      "CREATE TYPE {$this->schema->getName()}.$this->name AS ENUM (" . implode(',', $wrappedInQuotes) . ");"
    ];

  }

}
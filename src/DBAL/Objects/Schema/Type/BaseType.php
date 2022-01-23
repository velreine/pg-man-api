<?php
declare(strict_types=1);

namespace App\DBAL\Objects\Schema\Type;

use App\DBAL\Objects\Role;
use App\DBAL\Objects\Schema;
use App\DBAL\Objects\Schema\DBFunction;
use JetBrains\PhpStorm\Pure;

final class BaseType extends ShellType
{
  /**
   * @param string $name The name (optionally schema-qualified) of a type to be created.
   * @param Schema $schema
   * @param Role $role
   * @param DBFunction $inputFunction The name of a function that converts data from the type's external textual form to its internal form.
   * @param DBFunction $outputFunction The name of a function that converts data from the type's internal form to its external textual form.
   * @param DBFunction|null $receiveFunction The name of a function that converts data from the type's external binary form to its internal form.
   * @param DBFunction|null $sendFunction The name of a function that converts data from the type's internal form to its external binary form.
   * @param DBFunction|null $typeModifierInputFunction The name of a function that converts an array of modifier(s) for the type into internal form.
   * @param DBFunction|null $typeModifierOutputFunction The name of a function that converts the internal form of the type's modifier(s) to external textual form.
   * @param DBFunction|null $analyzeFunction The name of a function that performs statistical analysis for the data type.
   * @param DBFunction|null $subscriptFunction The name of a function that defines what subscripting a value of the data type does.
   * @param int|null $internalLength A numeric constant that specifies the length in bytes of the new type's internal representation. The default assumption is that it is variable-length.
   * @param bool|null $passedByValue
   * @param ByteAlignmentBoundary|null $alignment The storage alignment requirement of the data type. If specified, it must be char, int2, int4, or double; the default is int4.
   * @param StorageStrategy|null $storage The storage strategy for the data type. If specified, must be plain, external, extended, or main; the default is plain.
   * @param string|null $like The name of an existing data type that the new type will have the same representation as. The values of internallength, passedbyvalue, alignment, and storage are copied from that type, unless overridden by explicit specification elsewhere in this CREATE TYPE command.
   * @param TypeCategory|null $category The category code (a single ASCII character) for this type. The default is 'U' for “user-defined type”. Other standard category codes can be found in Table 52.63. You may also choose other ASCII characters in order to create custom categories.
   * @param bool $preferred True if this type is a preferred type within its type category, else false. The default is false. Be very careful about creating a new preferred type within an existing type category, as this could cause surprising changes in behavior.
   * @param mixed|null $default The default value for the data type. If this is omitted, the default is null.
   * @param ShellType|null $element The type being created is an array; this specifies the type of the array elements.
   * @param string|null $delimiter The delimiter character to be used between values in arrays made of this type.
   * @param bool $collatable True if this type's operations can use collation information. The default is false.
   */
  #[Pure]
  public function __construct(
    protected string               $name,
    protected Schema               $schema,
    protected Role                 $role,
    private DBFunction             $inputFunction,
    private DBFunction             $outputFunction,
    private ?DBFunction            $receiveFunction,
    private ?DBFunction            $sendFunction,
    private ?DBFunction            $typeModifierInputFunction,
    private ?DBFunction            $typeModifierOutputFunction,
    private ?DBFunction            $analyzeFunction,
    private ?DBFunction            $subscriptFunction,
    private ?int                   $internalLength = -1,
    private ?bool                  $passedByValue = null,
    private ?ByteAlignmentBoundary $alignment = ByteAlignmentBoundary::FOUR_BYTES,
    private ?StorageStrategy       $storage = StorageStrategy::PLAIN,
    private ?string                $like = null, // TODO: <--- ShellType???
    private ?TypeCategory          $category = TypeCategory::UserDefinedType,
    private ?bool                  $preferred = false,
    private mixed                  $default = null,
    private ?ShellType             $element = null,
    private ?string                $delimiter = null,
    private ?bool                  $collatable = false,
  )
  {
    parent::__construct($this->name, $this->schema, $this->owner);
  }

  #[Pure]
  public function GetCreateScript(): array
  {

    $str = "CREATE TYPE {$this->schema->getName()}.$this->name (\r\n";

    $str .= "INPUT = {$this->inputFunction->getSchema()->getName()}.{$this->inputFunction->getName()}\r\n";
    $str .= "OUTPUT = {$this->outputFunction->getSchema()->getName()}.{$this->outputFunction->getName()}\r\n";

    if ($this->receiveFunction !== null) {
      $str .= ", RECEIVE = {$this->receiveFunction->getSchema()->getName()}.{$this->receiveFunction->getName()}\r\n";
    }

    if ($this->sendFunction !== null) {
      $str .= ", SEND = {$this->sendFunction->getSchema()->getName()}.{$this->sendFunction->getName()}\r\n";
    }

    if ($this->typeModifierInputFunction !== null) {
      $str .= ", TYPMOD_IN = {$this->typeModifierInputFunction->getSchema()->getName()}.{$this->typeModifierInputFunction->getName()}\r\n";
    }

    if ($this->typeModifierOutputFunction !== null) {
      $str .= ", TYPMOD_OUT = {$this->typeModifierOutputFunction->getSchema()->getName()}.{$this->typeModifierOutputFunction->getName()}\r\n";
    }

    if ($this->analyzeFunction !== null) {
      $str .= ", ANALYZE = {$this->analyzeFunction->getSchema()->getName()}.{$this->analyzeFunction->getName()}\r\n";
    }

    if ($this->subscriptFunction !== null) {
      $str .= ", SUBSCRIPT = {$this->subscriptFunction->getSchema()->getName()}.{$this->subscriptFunction->getName()}\r\n";
    }

    if ($this->internalLength === -1) {
      $str .= ", INTERNALLENGTH = VARIABLE\r\n";
    } else {
      $str .= ", INTERNALLENGTH = $this->internalLength\r\n";
    }

    if ($this->passedByValue === true) {
      $str .= ", PASSEDBYVALUE\r\n";
    }

    if ($this->alignment !== null) {
      $str .= ", ALIGNMENT = {$this->alignment}\r\n";
    }

    if ($this->storage !== null) {
      $str .= ", STORAGE = {$this->storage}\r\n";
    }

    if ($this->like !== null) {
      $str .= ", LIKE = {$this->like}\r\n";
    }

    if ($this->category !== null) {
      $str .= ", CATEGORY = {$this->category}\r\n";
    }

    if ($this->preferred === true) {
      $str .= ", PREFERRED = True\r\n";
    }

    if ($this->default !== null) {
      // todo: abit unsure about this part.
      $str .= ", DEFAULT = " . (string)$this->default . "\r\n";
    }

    if ($this->element !== null) {
      $str .= ", ELEMENT = {$this->element->getSchema()->getName()}.{$this->element->getName()}\r\n";
    }

    if ($this->delimiter !== null) {
      // todo: wrap in quotes?
      $str .= ", DELIMITER = $this->delimiter\r\n";
    }

    if ($this->collatable === true) {
      $str .= ", COLLATABLE = True\r\n";
    }

    $str .= ");";

    return [$str];
  }


}
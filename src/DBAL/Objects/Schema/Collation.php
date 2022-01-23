<?php
declare(strict_types=1);

namespace App\DBAL\Objects\Schema;

use App\DBAL\CreateableInterface;
use App\DBAL\Objects\Role;
use App\DBAL\Objects\Schema;
use JetBrains\PhpStorm\Pure;

final class Collation implements CreateableInterface {

  /**
   * @param string $name Name of the collation.
   * @param Role $owner Owner of the collation.
   * @param Schema $schema Schema that the collation resides in.
   * @param string|null $comment (Optional) comment about the collation.
   * @param Collation|null $copyCollation The collation to copy from.
   * @param string|null $locale The locale to ?copy? from.
   * @param string|null $lcCollate The LC_COLLATE to ?copy? from.
   * @param string|null $lcType The LC_TYPE to ?copy? from.
   */
  private function __construct(
    private string $name,
    private Role $owner,
    private Schema $schema,
    private ?string $comment = null,
    private ?Collation $copyCollation = null,
    private ?string $locale = null, // TODO: ENUM?
    private ?string $lcCollate = null,
    private ?string $lcType = null,
  )
  {
  }

  public function getName(): string
  {
    return $this->name;
  }

  public function getOwner(): Role
  {
    return $this->owner;
  }

  public function getSchema(): Schema
  {
    return $this->schema;
  }

  public function getComment(): ?string
  {
    return $this->comment;
  }

  public function getCopyCollation(): ?Collation
  {
    return $this->copyCollation;
  }

  public function getLocale(): ?string
  {
    return $this->locale;
  }

  public function getLcCollate(): ?string
  {
    return $this->lcCollate;
  }

  public function getLcType(): ?string
  {
    return $this->lcType;
  }



  public static function createFromLocale(string $name, Role $owner, Schema $schema, string $locale, ?string $comment = null) : Collation {
    return new self(
      name: $name,
      owner: $owner,
      schema: $schema,
      comment: $comment,
      copyCollation: null,
      locale: $locale,
      lcCollate: null,
      lcType: null
    );
  }

  public static function createFromCollationCopy(string $name, Role $owner, Schema $schema, Collation $copyCollation, ?string $comment = null): Collation {
    return new self(
      name: $name,
      owner: $owner,
      schema: $schema,
      comment: $comment,
      copyCollation: $copyCollation,
      locale: null,
      lcCollate: null,
    );
  }

  public static function createWithLcCollateAndLcType(string $name, Role $owner, Schema $schema, string $lcCollate, string $lcType, ?string $comment) : Collation {
    return new self(
      name: $name,
      owner: $owner,
      schema: $schema,
      comment: $comment,
      copyCollation: null,
      locale: null,
      lcCollate: $lcCollate,
      lcType: $lcType
    );
  }


  #[Pure]
  public function GetCreateScript(): array
  {
    $createScript = [];

    // Create it by "copying" another collation.
    if($this->copyCollation !== null) {
      // CREATE COLLATION main.fooish FROM pg_catalog."C";
      $createScript[] = "CREATE COLLATION {$this->schema->getName()}.$this->name FROM {$this->copyCollation->getSchema()->getName()}.\"{$this->copyCollation->getName()}\";";
    }

    // Create it by "copying" from Locale.
    if($this->locale !== null) {
      // CREATE COLLATION main.fooish (LOCALE = 'da-DK');
      $createScript[] = "CREATE COLLATION {$this->schema->getName()}.$this->name (LOCALE = '$this->locale');";
    }

    // Create it by supplying LC_COLLATE & LC_TYPE
    if($this->lcCollate !== null && $this->lcType !== null) {
      // CREATE COLLATION main.fooish (LC_COLLATE = 'p', LC_CTYPE = 'q');
      $createScript[] = "CREATE COLLATION {$this->schema->getName()}.$this->name (LC_COLLATE = '$this->lcCollate', LC_CTYPE = '$this->lcType');";
    }

    // Finally, ensure the owner is set properly.
    // ALTER COLLATION main.fooish OWNER TO postgres;
    $createScript[] = "ALTER COLLATION {$this->getSchema()->getName()}.$this->name OWNER TO {$this->owner->getName()};";

    return $createScript;
  }
}
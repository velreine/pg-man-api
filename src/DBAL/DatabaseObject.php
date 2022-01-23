<?php

namespace App\DBAL;

final class DatabaseObject
{
    public function __construct(
      private array $casts,
      private array $catalogs,
      private array $eventTriggers,
      private array $extensions,
      private array $foreignDataWrappers,
      private array $languages,
      private array $publications,
      private array $schemas,
      private array $subscriptions,
    )
    {
    }
}
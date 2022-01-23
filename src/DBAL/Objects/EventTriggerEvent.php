<?php

namespace App\DBAL\Objects;

enum EventTriggerEvent {
  case DDL_COMMAND_START;
  case DDL_COMMAND_END;
  case TABLE_REWRITE;
  case SQL_DROP;
}
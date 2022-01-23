<?php
declare(strict_types=1);

namespace App\DBAL\Objects\Schema\Type;

enum StorageStrategy {
case PLAIN; // Value is always in-lined not compressed.
case EXTENDED; // The system will try to compress a long data value, and will move the value out of the main table row if it's still too long.
case EXTERNAL; // External allows the value to be moved out of the main table, but the system will not try to compress it.
case MAIN; // Main allows compression, but discourages moving the value out of the main table. (Data items with this storage strategy might still be moved out of the main table if there is no other way to make a row fit, but they will be kept in the main table preferentially over extended and external items.)
}
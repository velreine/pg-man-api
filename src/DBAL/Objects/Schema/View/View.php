<?php
declare(strict_types=1);

namespace App\DBAL\Objects\Schema\View;

use App\DBAL\DML\SelectStatement;
use App\DBAL\DML\ValuesStatement;

final class View {

  /**
   * @param string $name The name (optionally schema-qualified) of a view to be created.
   * @param SelectStatement|ValuesStatement $query A SELECT or VALUES command which will provide the columns and rows of the view.
   * @param CheckOption|null $checkOption This parameter may be either local or cascaded, and is equivalent to specifying WITH [ CASCADED | LOCAL ] CHECK OPTION (see below). This option can be changed on existing views using ALTER VIEW.
   * @param SecurityBarrierOption|null $securityBarrierOption
   * @param array $columnNames An optional list of names to be used for columns of the view. If not given, the column names are deduced from the query.
   * @param bool $temporary If specified, the view is created as a temporary view. Temporary views are automatically dropped at the end of the current session. Existing permanent relations with the same name are not visible to the current session while the temporary view exists, unless they are referenced with schema-qualified names.
      If any of the tables referenced by the view are temporary, the view is created as a temporary view (whether TEMPORARY is specified or not).
   */
  public function __construct(
      string $name,
      SelectStatement|ValuesStatement $query,
      CheckOption $checkOption = null,
      SecurityBarrierOption $securityBarrierOption = null,
      array $columnNames = [],
      bool $temporary = false,
  )
  {
  }

  public function GetDDLCreateScript() {

    /**
     * CREATE [ OR REPLACE ] [ TEMP | TEMPORARY ] [ RECURSIVE ] VIEW name [ ( column_name [, ...] ) ]
     *  [ WITH ( view_option_Name [= view_option_value] [, ... ] ) ]
     *  AS query
     *  [ WITH [ CASCADED | LOCAL ] CHECK OPTION ]
     *
     */

  }

}
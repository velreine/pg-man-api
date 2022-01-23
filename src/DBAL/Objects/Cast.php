<?php


namespace App\DBAL\Objects;


final class Cast {

  /**
   * @see https://www.postgresql.org/docs/14/sql-createcast.html
   * @param string $sourceType The name of the source data type of the cast.
   * @param string $targetType The name of the target data type of the cast.
   * @param string $function The function used to perform the cast. The function name can be schema-qualified. If it is not, the function will be looked up in the schema search path. The function's result data type must match the target type of the cast. Its arguments are discussed below. If no argument list is specified, the function name must be unique in its schema.
   * @param CastContext $context
   * @param bool $withoutFunction (True) indicates that the source type is binary-coercible to the target type, so no function is required to perform the cast.
   * @param bool $withInOut (True) indicates that the cast is an I/O conversion cast, performed by invoking the output function of the source data type, and passing the resulting string to the input function of the target data type.
   */
  public function __construct(
    private string $sourceType, // TODO: Builtin enum? How to handle User-Defined-Types.
    private string $targetType,
    private string $function,
    private bool $withoutFunction,
    private bool $withInOut,
    private CastContext $context,

  )
  {
  }

}
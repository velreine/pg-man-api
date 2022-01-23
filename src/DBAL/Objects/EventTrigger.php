<?php

namespace App\DBAL\Objects;


final class EventTrigger {

  /**
   * @see https://www.postgresql.org/docs/14/sql-createeventtrigger.html
   * @param string $name The name to give the new trigger. This name must be unique within the database.
   * @param string $event The name of the event that triggers a call to the given function. @see https://www.postgresql.org/docs/14/event-trigger-definition.html (Section 40.1) for more information on event names.
   * @param string $filterVariable The name of a variable used to filter events. This makes it possible to restrict the firing of the trigger to a subset of the cases in which it is supported. Currently the only supported filter_variable is TAG.
   * @param array $filterValue A list of values for the associated filter_variable for which the trigger should fire. For TAG, this means a list of command tags (e.g., 'DROP FUNCTION').
   * @param string $functionName A user-supplied function that is declared as taking no argument and returning type event_trigger.
      In the syntax of CREATE EVENT TRIGGER, the keywords FUNCTION and PROCEDURE are equivalent, but the referenced function must in any case be a function, not a procedure. The use of the keyword PROCEDURE here is historical and deprecated.
   */
  public function __construct(
    private string $name,
    private EventTriggerEvent $event,
    private string $functionName,
    private FilterVariable $filterVariable = FilterVariable::TAG,
    private array $filterValue = [],
  )
  {
  }

}
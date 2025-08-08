<?php

namespace Core;

class ValidationException extends \Exception
{
  public $errors;
  public $old;

  public static function throw($errors, $old)
  {

    $instance = new static('This validation is failed! ');

    $instance->errors = $errors;
    $instance->old = $old;

    throw $instance;
  }
}

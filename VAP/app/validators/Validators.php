<?php
class Validators
{
  public function required()
  {
    return [
      "validatorName" => "required",
      "validatorFn" => fn ($input) => (bool)$input,
      "params" => []
    ];
  }

  public function containLowercase()
  {
    return [
      "validatorName" => "containLowercase",
      "validatorFn" => function ($input) {

        $lowercase = preg_match('@[a-z]@', $input);

        if (!$lowercase) {
          return false;
        } else {
          return true;
        }
      },
      "params" => []
    ];
  }

  public function containSpecialChars()
  {
    return [
      "validatorName" => "containSpecialChars",
      "validatorFn" => function ($input) {

        $containsSpecialChars = preg_match('/[!@#$%^&*(),.?":{}|<>]/', $input);

        if (!$containsSpecialChars) {
          return false;
        } else {
          return true;
        }
      },
      "params" => []
    ];
  }

  public function containUppercase()
  {
    return [
      "validatorName" => "containUppercase",
      "validatorFn" => function ($input) {

        $uppercase = preg_match('@[A-Z]@', $input);

        if (!$uppercase) {
          return false;
        } else {
          return true;
        }
      },
      "params" => []
    ];
  }

  public function containNum()
  {
    return [
      "validatorName" => "containNum",
      "validatorFn" => function ($input) {

        $number = preg_match('@[0-9]@', $input);

        if (!$number) {
          return false;
        } else {
          return true;
        }
      },
      "params" => []
    ];
  }


  public function strLength($length)
  {
    return [
      "validatorName" => "strLength",
      "validatorFn" => function ($input) use ($length) {

        // Ellenőrizze, hogy két szóból áll

        // Ellenőrizze, hogy mindkét szó legalább 3 karakter hosszú
        if (strlen($input) < $length) {
          return false;
        }


        return true;
      },
      "params" => []
    ];
  }


  public function multipleWords()
  {
    return [
      "validatorName" => "multipleWords",
      "validatorFn" => function ($input) {

        // Ellenőrizze, hogy két szóból áll
        $nameParts = explode(' ', $input);
        if (count($nameParts) < 2) {
          return false;
        }


        return true;
      },
      "params" => []
    ];
  }

  public function validateAddress()
  {
    return [
      "validatorName" => "validateAddress",
      "validatorFn" => function ($input) {

        // Ellenőrizze, hogy az input legalább 5 karakter hosszú
        if (strlen($input) < 5) {
          return false;
        }

        // Ellenőrizze, hogy az input tartalmaz legalább egy számot
        if (!preg_match('@[0-9]@', $input)) {
          return false;
        }

        // Ellenőrizze, hogy az input tartalmaz legalább egy nagybetűt
        if (!preg_match('@[A-Z]@', $input)) {
          return false;
        }

        return true;
      },
      "params" => []
    ];
  }

  public function validatePhone()
  {
    return [
      "validatorName" => "validatePhone",
      "validatorFn" => function ($input) {


        // Ellenőrizze, hogy az input legalább 5 karakter hosszú
        if (strlen($input) < 9) {
          return false;
        }

        return true;
      },
      "params" => []
    ];
  }


  public function validateEmail()
  {
    return [
      "validatorName" => "validateEmail",
      "validatorFn" => function ($input) {

        $isEmail = filter_var($input, FILTER_SANITIZE_EMAIL);
        if (!$isEmail) {
          return false;
        }

        // Ellenőrizze, hogy az input legalább 5 karakter hosszú
        if (strlen($input) < 9) {
          return false;
        }

        return true;
      },
      "params" => []
    ];
  }
}

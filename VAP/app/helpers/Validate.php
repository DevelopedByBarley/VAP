<?php

require_once 'app/validators/Validators.php';


/*
  ?How to use?
  required_once app/helpers/Validate.php;
  $validator = new Validator();
  $errors = $validator->validate($schema, $_POST);
  $errorMessages = $validator->getErrorMessages($schema, errors);
   
*/

class Validator
{
  private $validators;

  public function __construct()
  {
    $this->validators =  new Validators();
  }



  public function userRegisterSchema()
  {
    $userSchema = [
      "name" => [
        $this->validators->required(),
        $this->validators->strLength(5),
        $this->validators->multipleWords()
      ],
      "email" => [
        $this->validators->required(),
        $this->validators->validateEmail()
      ],
      "password" => [
        $this->validators->required(),
        $this->validators->strLength(5),
        $this->validators->containNum(),
        $this->validators->containLowercase(),
        $this->validators->containUppercase(),
        $this->validators->containSpecialChars(),

      ],
      "address" => [
        $this->validators->required(),
        $this->validators->strLength(5),
        $this->validators->containNum(),
        $this->validators->containUppercase(),

      ],
      "mobile" => [
        $this->validators->required(), $this->validators->validatePhone()
      ],
    ];

    return $this->toSchema($userSchema);
  }

  public function userUpdateSchema()
  {
    $userSchema = [
      "name" => [
        $this->validators->required(),
        $this->validators->strLength(5),
        $this->validators->multipleWords()
      ],
      "address" => [
        $this->validators->required(),
        $this->validators->strLength(5),
        $this->validators->containNum(),
        $this->validators->containUppercase(),

      ],
      "mobile" => [
        $this->validators->required(), $this->validators->validatePhone()
      ],
    ];

    return $this->toSchema($userSchema);
  }



  public function subscriptionSchema()
  {
    $subscriptioSchema = [
      "name" => [
        $this->validators->required(),
        $this->validators->strLength(5),
        $this->validators->multipleWords()
      ],
      "email" => [
        $this->validators->required(),
        $this->validators->validateEmail()
      ],
      "address" => [
        $this->validators->required(),
        $this->validators->strLength(5),
        $this->validators->containNum(),
        $this->validators->containUppercase(),

      ],
      "mobile" => [
        $this->validators->required(), $this->validators->validatePhone()
      ],
    ];

    return $this->toSchema($subscriptioSchema);
  }

  public function forgotPwFormSchema()
  {
    $forgotPwFormSchema = [
      "email" => [
        $this->validators->required(),
        $this->validators->validateEmail()
      ],
    ];

    return $this->toSchema($forgotPwFormSchema);
  }



  private function toSchema($schema)
  {
    $ret = [];

    foreach ($schema as $fieldName => $fields) {

      foreach ($fields as $field) {
        $ret[$fieldName][$field["validatorName"]] = $field;
      }
    }
    return $ret;
  }

  public function validate($schema, $body)
  {


    $fieldNames = array_keys($schema); // Kikérjük a fieldname-eket;

    $ret = [];

    foreach ($fieldNames as $fieldName) {
      $ret[$fieldName] = [];
    }


    //Átalakitás kész

    foreach ($fieldNames as $fieldName) {
      $validators = $schema[$fieldName];
      foreach ($validators as $validator) {
        $validatorFn = $validator["validatorFn"];
        $isFieldValid = $validatorFn($body[$fieldName]);

        if (!$isFieldValid) {
          $ret[$fieldName][] = [
            "validatorName" => $validator["validatorName"],
            "value" => $body[$fieldName] ?? null
          ];
        }
      }
    }
    return $ret;
  }


  public function getErrorMessages($schema, $errors)
  {


    $validatorNameToMessage  = [
      "required" => fn () => "A mező kitöltése kötelező. <br>",
      "strLength" => fn () => "Az értéknek legalább 5 betűből kell állnia. <br>",
      "multipleWords" => fn () => "Az értéknek legalább 2 szót kell tartalmaznia. <br>",
      "containNum" => fn () => "Az értéknek tartalmaznia számot. <br>",
      "containUppercase" => fn () => "Az értéknek tartalmaznia nagy betűt. <br>",
      "containLowercase" => fn () => "Az értéknek tartalmaznia kis betűt. <br>",
      "containSpecialChars" => fn () => "Az értéknek tartalmaznia speciális karaktert. <br>",
      "checkPassword" => fn () => "Az értéknek tartalmaznia kell Nagy, Kisbetűt, Számot és Speciális karaktert. <br>",
      "validateEmail" => fn () => "Emailnek legalább 9 karakternek kell lennie!. <br>",
      "validateAddress" => fn () => "Az értéknek legalább 5 karaktert, nagybetűt és számot kell tartalmaznia. <br>",
      "validatePhone" => fn () => "Az értéknek minimum 9 karakternek kell lennie<br>",

    ];

    $ret = [];

    if (!empty($errors)) {
      foreach ($errors as $fieldName =>  $errorsForField) {
        foreach ($errorsForField as $err) {
          $toMessageFn = $validatorNameToMessage[$err["validatorName"]];
          $schemaForField = $schema[$fieldName];
          $ret[$fieldName][] = $toMessageFn($err["value"],  $schemaForField[$err["validatorName"]]["params"]);
        }
      }
    }



    return $ret;
  }
}

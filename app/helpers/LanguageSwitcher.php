<?php

function languageSwitcher($string)
{
  $lang = $_COOKIE["lang"] ?? null;
  return $string . "In" .$lang;
}

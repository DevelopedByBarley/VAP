<?php
function getStringByLang($titleInHu, $titleInEn, $titleInSp)
{
    $lang = $_COOKIE["lang"] ?? null;

    if ($lang === "Hu") {
        return $titleInHu;
    } else if ($lang === "Sp") {
        return $titleInSp;
    } else {
        return $titleInEn;
    }
}



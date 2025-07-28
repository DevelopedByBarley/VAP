<?php



function errors($key, $errors)
{
  if (isset($errors) && !empty($errors)) {
    if (isset($errors[$key]['errors'])) {
      foreach ($errors[$key]['errors'] as $error) {
        echo "<li class='list-unstyled text-danger'>{$error}</li>";
      }
    }
  }
}

function shortenName($fullName)
{
  $parts = explode(' ', $fullName);

  if (count($parts) >= 2) {
    $firstInitial = mb_substr($parts[0], 0, 1) . '.';
    $lastName = implode(' ', array_slice($parts, 1)); // handles middle names too
    return $firstInitial . ' ' . $lastName;
  }

  return $fullName; // if there's only one word, return as-is
}

function dd($value)
{
  echo "<pre>";
  var_dump($value);
  echo "</pre>";

  die();
}

function urlIs($value)
{
  return $_SERVER['REQUEST_URI'] === $value;
}

function urlContains($needle)
{
  return strpos($_SERVER['REQUEST_URI'], $needle) !== false;
}








function extractMapUrl($iframe)
{
  if (preg_match('/src="([^"]+)"/', $iframe, $matches)) {
    return $matches[1];
  }

  if (str_contains($iframe, 'https://www.google.com/maps/embed?pb=')) {
    return $iframe;
  }

  return null;
}

/**
 * Általános szűrő és szanitizáló függvény.
 *
 * @param mixed $value A bemenet, amit tisztítani szeretnél.
 * @param string $type A bemenet típusa: 'string', 'int', 'email', 'url', stb.
 * @return mixed A szűrt és tisztított érték, vagy false, ha a validáció nem sikerült.
 */
/**
 * Általános szűrő és szanitizáló függvény.
 *
 * @param mixed $value A bemenet, amit tisztítani szeretnél.
 * @return mixed A szűrt és tisztított érték, vagy az eredeti érték, ha nem támogatott típus.
 */
function sanitize($value)
{
  $type = gettype($value);

  switch ($type) {
    case 'string':
      return filter_var($value, FILTER_SANITIZE_SPECIAL_CHARS);
    case 'integer':
      return filter_var($value, FILTER_SANITIZE_NUMBER_INT);
    case 'double':
      return filter_var($value, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    case 'boolean':
      return filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
    case 'array':
      return array_map('sanitize', $value);
    case 'NULL':
      return null;
    default:
      return $value;
  }
}



function public_file($path)
{
  return "/public/{$path}";
}

function arr_to_obj($arr)
{
  return json_decode(json_encode($arr));
}

function obj_to_arr($obj)
{
  return json_decode(json_encode($obj), true);
}
function isUrl(string $expectedUrl): bool
{
  $currentUrl = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); // Csak az útvonalat vesszük
  return trim($currentUrl, '/') === trim($expectedUrl, '/');
}



function getWeekRangeByDate($date)
{
  /*   if (is_array($event_data)) {
    foreach ($event_data as $event) {
      $timestamp = strtotime($event->date_time);

      $weekStart = date('Y-m-d', strtotime('monday this week', $timestamp));
      $weekEnd = date('Y-m-d', strtotime('sunday this week', $timestamp));

      $event->week = "$weekStart - $weekEnd";
      $event->week_start = $weekStart;
      $event->week_end = $weekEnd;
    }

    return $event_data;
  } */


  $timestamp = strtotime($date);

  $week_start = date('Y-m-d', strtotime('monday this week', $timestamp));
  $week_end = date('Y-m-d', strtotime('sunday this week', $timestamp));


  return (object)[
    'week' => "$week_start - $week_end",
    'start' => $week_start,
    'end' => $week_end
  ];
}

function generateBreadcrumbs(array $breadcrumbs)
{
  echo '<nav aria-label="breadcrumb">';
  echo '<ul class="breadcrumb border p-3">';

  $totalItems = count($breadcrumbs);
  $currentIndex = 0;

  foreach ($breadcrumbs as $label => $url) {
    $currentIndex++;

    if ($currentIndex === $totalItems) {
      echo '<li class="breadcrumb-item active" aria-current="page">' . htmlspecialchars($label) . '</li>';
    } else {
      echo '<li class="breadcrumb-item"><a href="' . htmlspecialchars($url) . '">' . htmlspecialchars($label) . '</a></li>';
    }
  }

  echo '</ul>';
  echo '</nav>';
}


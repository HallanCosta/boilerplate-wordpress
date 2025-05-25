<?php
function getTheme($file, $vers = '') {
  $base_url = home_url();
  $vers = ($vers != "") ? "?{$vers}" : "";
  return "{$base_url}/wp-content/themes/wpresskit/{$file}{$vers}";
}

function getBaseUrl($slug = "") {
  $base_url = home_url();
  $a = $slug . (($slug !== '') ? '/' : '');
  return "{$base_url}/{$a}";
}

function formatDateTime($timestamp, $format) {
  $timezone = new DateTimeZone(-3);
  return (new DateTime($timestamp))->setTimezone($timezone)->format("{$format}");
}

function convertDateToBrazil($dateOrigin) {
  // Cria um objeto DateTime
  $date = new DateTime($dateOrigin);

  // Array com os nomes dos meses em português
  $month = [
      1 => 'Janeiro', 2 => 'Fevereiro', 3 => 'Março', 4 => 'Abril',
      5 => 'Maio', 6 => 'Junho', 7 => 'Julho', 8 => 'Agosto',
      9 => 'Setembro', 10 => 'Outubro', 11 => 'Novembro', 12 => 'Dezembro'
  ];

  // Extrai o mês numérico
  $monthNumber = $date->format('n');

  // Formata a data com o mês em português
  $dateFormatted = $date->format('d') . ' de ' . $month[$monthNumber] . ' de ' . $date->format('Y');

  return $dateFormatted;
}
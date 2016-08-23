<?php
class Model_Time extends \Model
{
  public static function s2h($seconds)
  {
    $hours = floor($seconds / 3600);
    $minutes = floor(($seconds / 60) % 60);
    $seconds = $seconds % 60;
    
    $hours = $hours ? $hours.'h ' : '';
    $minutes = $minutes ? $minutes.'m ' : '';
    $seconds = $seconds ? $seconds.'s ' : '';
    $hms = $hours.$minutes.$seconds;
    //$hms = sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds);
    return $hms;
  }
}
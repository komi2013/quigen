<?php
class Model_Number extends \Model
{
  public static function big_number($number) {
    if ($number < 100) {
        $format = number_format($number);
        $big = '';
    } else if ($number < 1000) {
        $format = number_format($number);
        $big = '_big';
    } else if ($number < 1000000) {
        // Anything less than a billion
        $format = number_format($number / 1000, 1) . 'K';
        $big = '_big';
    } else if ($number < 1000000000) {
        // Anything less than a billion
        $format = number_format($number / 1000000, 1) . 'M';
        $big = '_big';
    } else {
        $format = number_format($number / 1000000000, 1) . 'B';
        $big = '_big';
    }
    
    return [$number,$format,$big];
  }
}
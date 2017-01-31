<?php

  // is_blank('abcd')
  function is_blank($value='') {
    return empty($value) ? true : false;
  }

  // has_length('abcd', ['min' => 3, 'max' => 5])
  function has_length($value, $options=array()) {
    $min = 0;
    $max = 99999;

    if (isset($options['min'])) {
      $min = $options['min'];
    }

    if (isset($options['max'])) {
      $max = $options['max'];
    }

    return strlen($value) <= $max && strlen($value) >= $min ? true : false;
  }

  // has_valid_email_format('test@test.com')
  function has_valid_email_format($value) {
    return strpos($value, '@') == true ? true : false;
  }

?>

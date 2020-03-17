<?php

include 'vendor/autoload.php';

class FormElement implements ArrayAccess {

  // The form element data. TODO: replace with specific properties!
  protected $_data = [];

  /**
   * Create a new FormElement, optionally from a form element array.
   *
   * @param array $element_array
   *   The form element array
   */
  public function __construct(?array $element_array = []) {
    foreach ($element_array as $key => $value) {
      $this[$key] = $value;
    }
  }

  public function offsetExists($offset) {
    return array_key_exists($offset, $this->_data);
  }

  public function offsetGet($offset) {
    return $this->_data[$offset];
  }

  public function offsetSet($offset, $value) {
    if (is_array($value)) {
      if (isset($value['#type'])) {
        $value = new static($value);
      }
    }

    $this->_data[$offset] = $value;
  }

  public function offsetUnset($offset) {
    unset($this->_data[$offset]);
  }

}

// 1. New OO style.
$form = new FormElement();
$form['one'] = new FormElement([
  '#type' => 'details',
]);
$form['one']['two'] = new FormElement([
  '#type' => 'textfield',
]);

dump($form);

// 2. Backwards-compatible array style.
$form = new FormElement();

// Pass the $form into an old-style form constructor...

$form['one'] = [
  '#type' => 'details',
];
$form['one']['two'] = [
  '#type' => 'textfield',
];

dump($form);

// 2. Backwards-compatible handling for form classes whose builders initialise
//    the form as an array.
$form = [];
$form['one'] = [
  '#type' => 'details',
];
$form['one']['two'] = [
  '#type' => 'textfield',
];

// The form system now converts the array into a FormElement.

$form = new FormElement($form);

dump($form);



<?php

include 'vendor/autoload.php';

class FormElement implements ArrayAccess {

  // The form element data. TODO: replace with specific properties!
  protected $_data = [];

  /**
   * Create a FormElement from a form element array.
   *
   * @param array $element_array
   *   The form element array
   *
   * @return self
   *   The form element object.
   */
  public static function createFromArray(array $element_array): self {
    $form_element = new static;


    return $form_element;
  }

  public function offsetExists ($offset) {
    return array_key_exists($offset, $this->_data);
  }

  public function offsetGet ($offset) {
    return $this->_data[$offset];
  }

  public function offsetSet ($offset, $value) {
    if (is_array($value)) {
      if (isset($value['#type'])) {
        $value = static::createFromArray($value);
      }
    }

    $this->_data[$offset] = $value;
  }

  public function offsetUnset ($offset) {
    unset($this->_data[$offset]);
  }

}

// New OO style.
$form = new FormElement();
$form['one'] = new FormElement();
$form['one']['two'] = new FormElement();

dump($form);

// BC procedural style
$form = new FormElement();

$form['one'] = [
  '#type' => 'foo',
];
$form['one']['two'] = [
  '#type' => 'bar',
];
dump($form);

// BC handling for form builders that initialise the form as an array.
$form = [];
$form['one'] = [
  '#type' => 'foo',
];
$form['one']['two'] = [
  '#type' => 'bar',
];

$form = FormElement::createFromArray($form);
dump($form);


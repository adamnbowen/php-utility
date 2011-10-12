<?php
/**
 * Sanitize A class for sanitizing arrays and objects, with the additional
 * feature of returning null for nonexistent properties.
 * 
 * @author Adam Bowen <adamnbowen@gmail.com>
 * @license http://dbad-license.org/license DBAD license
 */
class Sanitize {
  /**
   * _sanitizedArray the sanitized result of the array/object passed to the
   * constructor
   * 
   * @var array
   */
  private $_sanitizedArray = array();

  /**
   * __construct Sanitize the keys and values of the $uncleanArray.
   * 
   * @param mixed $uncleanArray 
   * @return void
   */
  public function __construct($uncleanArray)
  {
    foreach ($uncleanArray as $key => $value) {
      $this->_sanitizedArray[$this->_sanitize($key)] = $this->_sanitize($value);
    }
  }

  /**
   * _sanitize Sanitize the given $input.
   *
   * Sends all inputs to _fixIncompleteObject() to ensure there are no broken
   * objects, then if $input is an object or an array, it cleans $input
   * recursively.  If $input is a string, it is simply cleaned and returned.
   * 
   * @param mixed $input 
   * @return mixed Either a simple cleaned string or a cleaned array.
   */
  private function _sanitize($input)
  {
    $input = $this->_fixIncompleteObject($input);

    if (is_array($input) || is_object($input)) {
      $output = array();
      foreach ($input as $key => $value){
        $output[$key] = $this->_sanitize($value);
      }
      return $output;
    }
    return stripslashes(htmlentities(strip_tags(trim($input))));
  }

  /**
   * _fixIncompleteObject repairs an object if it is incomplete.
   *
   * Removes the __PHP_Incomplete_Class crap from the object, so is_object()
   * will correctly identify $input as an object
   *
   * @param object $object The "broken" object
   * @return object The "fixed" object
   */
  private function _fixIncompleteObject($input) {
    if (!is_object($input) && gettype($input) == 'object') {
      return unserialize(serialize($input));
    }
    return $input;
  }

  /**
   * __get If a nonexistent property of a Sanitize object is called, this
   * function checks to see if the property corresponds to a key of
   * $this->_sanitizedArray, and returns that, otherwise it returns null.
   * 
   * @param mixed $key 
   * @return void
   */
  public function __get($key)
  {
    if (array_key_exists($key, $this->_sanitizedArray)
      && !empty($this->_sanitizedArray[$key])
    ) {
      return $this->_sanitizedArray[$key];
    } else {
      return null;
    }
  }
}

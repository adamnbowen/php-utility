<?php
/**
 * Sanitize A class for sanitizing arrays and objects, with the additional
 * feature of returning null for nonexistent properties.
 * 
 * @author Adam Bowen <adamnbowen@gmail.com>
 * @author Russell Stringer <r.stringer@gmail.com>
 * @license http://dbad-license.org/license DBAD license
 */
require_once('Filtered.php');
class Sanitize {

  /**
   * Clean Sanitize the keys and values of the $uncleanArray
   * 
   * @param mixed $uncleanArray 
   * @return Filtered object containing the sanitized values
   */
  public static function Clean($uncleanArray)
  {
    $filtered = new Filtered();
    foreach ($uncleanArray as $key => $value) {
      $sanitizedKey = self::_sanitize($key);
      $sanitizedValue = self::_sanitize($value);
      $filtered->$sanitizedKey = $sanitizedValue;
    }

    return $filtered;
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
    $input = self::_fixIncompleteObject($input);

    if (is_array($input) || is_object($input)) {
      $output = array();
      foreach ($input as $key => $value){
        $output[$key] = self::_sanitize($value);
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

}

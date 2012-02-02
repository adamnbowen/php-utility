<?php
/**
 * Filtered provides magic methods to get/set arbitrary data in an object.
 * Returns a null value for any access to a key that doesn't exist.
 * 
 * @author Russell Stringer <r.stringer@gmail.com>
 * @author Adam Bowen <adamnbowen@gmail.com>
 * @license http://dbad-license.org/license DBAD license
 */
class Filtered
{

  /**
   * _sanitizedArray the sanitized result of the array/object 
   * 
   * @var array
   */
  private $_sanitizedArray = array();

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

  public function __set($key, $value)
  {
    $this->_sanitizedArray[$key] = $value;
  }

}

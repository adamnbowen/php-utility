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
   * _filtered the object accessed via __get() and __set()
   * 
   * @var array
   */
  private $_filtered = array();

  /**
   * __get If a nonexistent property of a Filtered object is called, this
   * function checks to see if the property corresponds to a key of
   * $this->_filtered, and returns that, otherwise it returns null.
   * 
   * @param mixed $key 
   * @return void
   */
  public function __get($key)
  {
    if (array_key_exists($key, $this->_filtered)
        && !empty($this->_filtered[$key])
    ) {
      return $this->_filtered[$key];
    } else {
      return null;
    }
  }

  public function __set($key, $value)
  {
    $this->_filtered[$key] = $value;
  }

}

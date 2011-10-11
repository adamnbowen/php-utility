<?php
class Sanitize {
    private $_fields = array();

    public function __construct($uncleanArray)
    {
        foreach ($uncleanArray as $key => $value) {
            $this->_fields[$this->_sanitize($key)] = $this->_sanitize($value);
        }
    }

    private function _sanitize($input)
    {
        if (!is_object($input) && gettype($input) == 'object') {
            $input = $this->_fixObject($input);
        }
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
     * _fixObject Removes the __PHP_Incomplete_Class crap from the object, so
     * is_object() will correctly identify $input as an object
     * 
     * @param object $object The "broken" object
     * @return object The "fixed" object
     */
    private function _fixObject($object) {
        return unserialize(serialize($object));
    }


    public function __get($key)
    {
        if (array_key_exists($key, $this->_fields)
            && !empty($this->_fields[$key])
        ) {
            return $this->_fields[$key];
        } else {
            return null;
        }
    }
}
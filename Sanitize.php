<?php
class Sanitize {
    private $_sanitizedArray = array();

    public function __construct($uncleanArray)
    {
        foreach ($uncleanArray as $key => $value) {
            $this->_sanitizedArray[$this->_sanitize($key)] = $this->_sanitize($value);
        }
    }

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

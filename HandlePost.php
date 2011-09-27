<?php
class HandlePost {
    private $_fields = array();

    public function __construct($postArray)
    {
        foreach ($postArray as $key => $value) {
            $this->_fields[$this->_sanitize($key)] = $this->_sanitize($value);
        }
    }

    private function _sanitize($input)
    {
        if (is_array($input)){
            foreach ($input as $key => $value){
                $input[$key] = $this->_sanitize($value);
            }
        } else {
            $input = stripslashes(htmlentities(strip_tags(trim($input))));
        }
        return $input;
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
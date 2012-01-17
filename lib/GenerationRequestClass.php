<?php
require 'array_util.php'
require '../support/sanitize.php'
require '../external/guid.php'

class FileFamily {

	function __construct() {
		$this->params['year'] = date('Y');
		$this->params['guid'] = strtoupper(generateGUID());
		$this->params['license'] = 'bsl';
		$this->set_from_query();
	}

	public function set_from_request() {
		foreach ($this->get_known_keys() as $key) {
			if (array_has_valid_string_for_key($key, $_GET)) {
				$this->params[$key] = sanitizeFilenamePart($_GET[$key]);
			}
		}
	}
	
	public function known_to_array() {
		$ret = array()
		foreach ($this->get_known_keys() as $key) {
			if ($this->__isset($key)) {
				$ret[$key] = $this->__get($key);
			}
		}
		return $ret;
	}

	public function substitution_to_array() {
		$ret = array()
		foreach ($this->get_substitution_keys() as $key) {
			if ($this->__isset($key)) {
				$ret[$key] = $this->__get($key);
			}
		}
		return $ret;
	}

	public function __set($name, $value)
    {
        $this->params[$name] = $value;
    }

    public function __get($name)
    {
        if (array_key_exists($name, $this->data)) {
            return $this->data[$name];
        }

        $trace = debug_backtrace();
        trigger_error(
            'Undefined property via __get(): ' . $name .
            ' in ' . $trace[0]['file'] .
            ' on line ' . $trace[0]['line'],
            E_USER_NOTICE);
        return null;
    }

	public function __isset($name)
    {
        return isset($this->params[$name]);
    }

	public function get_known_keys() {
		return $this->knownkeys;
	}

	public function get_substitution_keys() {
		return $this->get_known_keys();
	}


	private $params = array();
	private $knownkeys = array('basename', 'year',  'authorlines', 'copyrightholder', 'license', 'guid');
}

class CppFileFamily extends FileFamily

	function __construct() {
		$this->headerext = 'h';
		$this->implext = 'cpp';
		parent::__construct();
	}

	public function get_known_keys() {
		return array_merge(parent::get_known_keys(), $this->knownkeys);
	}

    public function __get($name)
    {
        if (array_key_exists($name, $this->dynamic_params)) {
			return $this->dynamic_params[$name]($this);
		} else {
			return parent::__get($name);
		}
    }
	public function __isset($name)
    {
    	if (array_key_exists($name, $this->dynamic_params)) {
    		return true;
    	} else {
        	return parent::__isset($name);
        }
    }

	public function get_substitution_keys() {
		return array_merge(parent::get_substitution_keys(), array_keys($this->dynamic_params));
	}

	private $dynamic_params = array(
		'def' => function($ff) {
			return strtr('INCLUDED_' . $ff->get_param("basename") . '_' . $ff->get_param("headerext") . '_GUID_' . $ff->get_param("guid"), '-./', '___');
		}

	private $myknownkeys = array('headerext', 'implext');
}

?>

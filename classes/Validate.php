<?PHP
/**
* 
*/
class Validate
{
	private $_passed = false,
			$_errors = array();
			//$_db = null;

	public function __construct(){
		//$this->_db = DB::getInstance();
	}

	public function check($source, $items = array()) {
		$this->_passed = false;
		foreach ($items as $item => $rules) {
			foreach ($rules as $rule => $rule_value) {
				//print_r($rule);
				$value = trim($source[$item]);
				$item = escape($item);
				//echo "{$item} {$rule} must be {$rule_value}<br />";

				if($rule === 'required' && empty($value)) {
					$this->addError("{$item} is required.");
				} else if(!empty($value)){
					switch ($rule) {
						case 'min':
							if(strlen($value) < $rule_value)
							$this->addError("{$item} must be atleast {$rule_value} chars.");
							//else echo 'pass|';
							break;
						case 'max':
							if(strlen($value) > $rule_value)
							$this->addError("{$item} must be less than {$rule_value} chars.");
							//else echo 'pass|';
							# code...
							break;
						case 'matches':
							if($value != $source[$rule_value])
							$this->addError("{$item} must match {$rule_value}.");
							//else echo 'pass|';
							# code...
							break;
						case 'unique':
							if (count($rule_value) != 2) {
								$this->addError("Validation Internal Error: {$item} unique corrupt check params.");
								//echo 'notpass|';
								break;
							}
							
							//$check = $this->_db->get($rule_value['table'], [$rule_value['field'], '=', $value]);
							//if($check->count()) {
							//	$this->addError("{$item} already exists.");
							//}
							//else echo 'pass|';
							break;
					}
				}
			}
		}
		if(empty($this->_errors)) $this->_passed = true;
		
		return $this;
	}

	private function addError($error){
		$this->_errors[] = $error;
	}

	public function errors(){
		return $this->_errors;
	}

	public function passed(){
		return $this->_passed;
	}
}
?>
<?phpclass PzkForm extends PzkObject {	public $boundable = false;	public $layout = 'form';	public $ajaxable = false;
	public $redirect = false;
	public $controller = false;
	public $task = false;
	public $table = false;
	public $data = false;
	public $route = false;
	public $aliaser = false;	public $aliasField = false;
	public $alias = false;
	public $submitted = false;
	public $errors = array();
	public $elements = array();

	public function finish() {
		if ($this->scriptable == true || $this->scriptable == 'true') {
			if ($this->controller) {
				_add_js_controller($this->controller);
			}
		}
	}
	
	public function validate() {
		$this->errors = array();
		foreach($this->data as $name => $value) {
			if (($child = $this->find('@' . $name)) && is_a($child, 'PzkFormElement')) {
				if (!$child->validate($value)) {
					$this->errors[] = $child->getError();
				}
			}
		}
		
		if (count($this->errors)) {
			return false;
		}
		return true;
	}

	public function doSubmit($data) {
		$this->data = $data;
		
		if (!$this->validate()) {
			$this->showEdit();
			return false;
		}		$this->filterData();
		if ($this->controller) {
			if ($controller = _controller($this->controller)) {
				$task = pzk_or($this->task, 'submit');
				if ($controller->$task($this, $data)) {
					$this->submitted = true;
					if ($this->redirect) {
						if (strpos($this->redirect, ':') === FALSE) {
							_route()->redirect($this->redirect);
						} else {
							$rq = pzk_properties($this->redirect, array('mode' => 'str2arr'));
							$rq = http_build_query($rq);
							header('Location: /index.php?' . $rq);
						}
					}
				}
			}
		}
		return true;
	}		public function filterData() {		foreach($this->data as $name => $value) {			if (($child = $this->find('@' . $name)) && is_a($child, 'PzkFormElement')) {				$this->data['name'] = $child->filterData($value);			}		}	}

	public function doEdit($data) {
		$user = _user();
		if (!$user) return _route()->redirect('login');
		if (!@$data['id']) {
			return false;
		}
		$items = _db()->select('*')->from($this->table)->where('id=' . $data['id'])->limit(0,1)->result();
		if (!($this->data = @$items[0])) {
			_route()->redirect('index');
		}		if (@$this->data['userId'] && $this->data['userId'] != @$user['id']) {			_route()->redirect('index');		}
		
		$this->showEdit();
	}
	
	public function showEdit() {
		foreach($this->data as $name => $value) {
			if ($child = $this->find('@' . $name)) {
				if ($child->tagName == 'select') {
					if ($option = $child->find('%' . $value)){
						$option->selected = 'selected';
					}
				} else {
					$child->value = $value;
				}

			}

		}
	}

	public function doDelete($data) {
	}

	public function doAdd($data) {
	}
	
	public function doCancel($data) {
	}

}

class PzkFormElement extends PzkObject {
	public $rules = false;
	public $validateable = false;
	public $error = false;
	public function finish() {
		$form = $this->up('*form');
		if ($form) {
			$form->elements[$this->name] = $this->id;
		}
	}
	public function validate($val) {
		if ($this->validateable) {
			if ($this->rules) {
				$rules = pzk_properties($this->rules, array('mode' => 'str2arr'));
				foreach($rules as $rule => $message) {
					$ruleController = _controller($rule);
					if (!$ruleController->validate($this, $val)) {
						$this->error = $message;
						return false;
					}
				}
			}
		}
		
		return true;
	}
	
	public function getError() {
		return $this->error;
	}		public function filterData($value) {		return $value;	}
}
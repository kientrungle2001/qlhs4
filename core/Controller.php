<?php

class PzkController {

    /**
     *
     * @var PzkCoreApplication
     */
    public $app;

    /**
     * 
     * @param PzkCoreApplication $app
     */
    public function setApp(PzkCoreApplication $app) {
        $this->app = $app;
    }

    /**
     * 
     * @return PzkCoreApplication
     */
    public function getApp() {
        return $this->app;
    }
	
	public function getStructure($uri) {
		if($uri instanceof PzkObject) return $uri;
		if(strpos($uri, '<') !==false) return pzk_parse($uri);
		return pzk_parse($this->getApp()->getPageUri($uri));
	}
	
	public $masterStructure = 'masterStructure';
	public $masterPage = false;
	public $masterPosition = 'left';
	public function viewStructure($structure, $useMasterStructure = true, $display = true) {
		if($useMasterStructure) {
			$page = $this->getStructure(pzk_or($this->masterPage, $this->masterStructure));
			$request = pzk_element('request');
			if(isset($request->routeData)) {
				$title = $request->routeData['title'];
				$page->title = strip_tags($title);
				$description = @$request->routeData['brief'];
				$page->description = strip_tags($description);
			}
			$obj = $this->getStructure($structure);
			pzk_element($this->masterPosition)->append($obj);
			if($display)
				$page->display();
			else return $page;
		} else {
			$obj = $this->getStructure($structure);
			if($display)
				$obj->display();
			else
				return $obj;
		}
	}
	
	public function buildPage($page /*object*/) {
		return $this->viewStructure($page, true, false);
	}
	
	public function viewGrid($grid, $useMasterStructure = true) {
		$this->viewStructure('grid/' . $grid, $useMasterStructure);
	}
	/**
	 * @desc Hiển thị operation 
	 * @param string $op Trang chứa operation
	 * @param boolean $useMasterStructure có nhúng trong master page không
	 */
	public function viewOperation($op, $useMasterStructure = true) {
		$this->viewStructure('operation/' . $op, $useMasterStructure);
	}
	
	public function getOperationStructure($op) {
		return $this->getStructure('operation/' . $op);
	}
	
	public function getModel($model) {
		return pzk_loader()->getModel($model);
	}
	
	public function initPage() {
		$page = $this->getStructure(pzk_or($this->masterPage, $this->masterStructure));
		$this->page = $page;
		return $this;
	}
	
	public function append($obj, $position = NULL) {
		$obj = $this->getStructure($obj);
		if($position){
			pzk_element($position)->append($obj);
		} else {
			pzk_element($this->masterPosition)->append($obj);
		}
		return $this;
	}
	
	public function display() {
		$this->page->display();
		return $this;
	}
	public function render($page) {
		$this->initPage();
		$this->append($page);
		$this->display();
		return $this;
	}
	public function redirect($action, $query = false) {
		if(strpos($action, 'http') !== false) {
			pzk_request()->redirect($action);
			die();
		}
		$parts = explode('/', $action);
		if(!@$parts[1] || is_numeric(@$parts[1])) {
			pzk_request()->redirect(pzk_request()->buildAction($action, $query));
		} else {
			pzk_request()->redirect(pzk_request()->build($action, $query));
		}
		
	}
	
	public function validate($row, $validator) {
		if(isset($validator) && $validator) {
			$result = pzk_validate($row, $validator);
			if($result !== true) {
				foreach($result as $field => $messages) {
					foreach($messages as $message) {
						pzk_notifier()->addMessage($message, 'warning');
					}
				}
				return false;
			}
		}
		return true;
	}
	
	public function parse($uri) {
		return $this->getStructure($uri);
	}
	
	public $events = array();
	public function fireEvent($event, $data = NULL) {
		$eventHandlers = isset($this->events[$event]) ? $this->events[$event]: array();
		foreach ($eventHandlers as $handler) {
			$tmp = explode('.', $handler);
			$action = 'handle';
			if(@$tmp[1]) { 
				$action = $tmp[1]; 
			}
			$obj = @$tmp[0];
			if($obj == 'this') {
				$h = $this;
			} else {
				$h = pzk_element($obj);
				if(!$h) {
					$h = $this->parse($obj);
				}
			}
			if($h) {
				$h->$action($event, $data);
			}
		}
	}
	
	public function addEventListener($event, $handler){
		if(!isset($this->events[$event])) {
			$this->events[$event] = array();
		}
		$this->events[$event][] = $handler;
	}
	
	public function __call($name, $arguments) {	
		$prefix = substr($name, 0, 3);
		$property = strtolower($name[3]) . substr($name, 4);
		switch ($prefix) {
			case 'get':
				return $this->$property;
				break;
			case 'set':
				//Always set the value if a parameter is passed
				if (count($arguments) != 1) {
					throw new \Exception("Setter for $name requires exactly one parameter.");
				}
				$this->$property = $arguments[0];
				//Always return this (Even on the set)
				return $this;
		}
		
		$prefix5 = substr($name, 0, 5);
		$property5 = strtolower($name[5]) . substr($name, 6);
		switch ($prefix5) {
			case 'parse':
				return $this->parse(str_replace('_', '/', $property5));
				break;
		}
		
		$prefix6 = substr($name, 0, 6);
		$property6 = strtolower($name[6]) . substr($name, 7);
		switch ($prefix6) {
			case 'append':
				return $this->append(str_replace('_', '/', $property6));
				break;
			case 'render':
				return $this->render(str_replace('_', '/', $property6));
				break;
			default:
				throw new \Exception("Property $name doesn't exist.");
				break;
		}
	}
}

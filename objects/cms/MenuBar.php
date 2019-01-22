<?php
class PzkMenuBar extends PzkObject {
	public $boundable = false;
	public $layout = 'menuBar';
	public $model = 'Menu';
	public $mode = false;
	public $scriptable = false;
	public $first = true;
	
	public function init() {
		if ($this->scriptable != 'false' && $this->scriptable != false  && $this->mode == 'megaMenu') {
			if($page = _page()) {
				$page->addCss('/jquery/megaMenu/css/vertical_menu_basic.css');
				$page->addJs('/jquery/megaMenu/js/jquery.hoverIntent.minified.js');
				$page->addJs('/jquery/megaMenu/js/jquery.dcverticalmegamenu.1.1.js');
			}
		}
	}
	
	public function loadData() {
		if ($this->model)
			$this->items = $this->model->getMenu();
		else
			$this->items = array();
	}
	
	public function displayMenu($items) {
		$route = @$_REQUEST['route'] ? urldecode(@$_REQUEST['route']) : 'index';
		
		if (is_array($items) && count($items)) {
			echo '<ul '.(($this->first) ?'id="'.@$this->id.'" class="menu"' : '') .'>';
				$this->first = false;
				foreach ($items as $item) {
					$active = (strpos($route, $item['link']) !== false) ? 'active' : 'non-active';
					echo '<li class="menu-item-'.$item['code'].' '. $active .'"><a href="'. _app_url($item['link']) . '">' . 
						(@$item['image'] ? '<img src="'.$item['image'].'" />' : '') . $item['label'] . '</a>';
					if (isset($item['items'])) {
						$this->displayMenu($item['items']);
					}
					echo '</li>';
				}
			echo '</ul>';
		}
	}
}
?>
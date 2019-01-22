<?php
class PzkCoreShorty extends PzkObjectLightWeight {
	public function init() {
		pzk_store('shorty_' . $this->name, $this->value);
	}
}
<?php
class PzkCoreStorage extends PzkObjectLightWeight {

    public $scriptable = false;
    public $timeout = false;
    public $store = false;
    public $name = false;

    public function init() {
        $store = PzkStore::store($this->name, PzkStore::instance(pzk_or($this->store, $this->name)));
        $store->timeout = intval($this->timeout);
    }

}

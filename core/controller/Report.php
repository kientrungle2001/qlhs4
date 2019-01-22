<?php
class PzkReportController extends PzkGridAdminController {
    public $masterStructure = 'admin/home/index';
    public $masterPosition = 'left';
    public $scriptTo = 'head';
    public $customModule = false;
    public $module = 'report';
    public $selectFields = '*';
    public $groupBy = false;
    public $having = false;
    public $groupByReport = false;
    public $listFieldSettings = false;
    public $sortFields = false;
    public $showchart = false;
    public $displayReport = false;
    public $typeChart = false;


    public function highchartAction() {
        pzk_session('report_type', pzk_request('type'));

        $this->redirect('index');
    }
}
?>
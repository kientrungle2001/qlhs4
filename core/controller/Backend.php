<?php
class PzkBackendController extends PzkController
{
    public function __construct() {
        $admin = pzk_session('adminUser') ;
        $level = pzk_session('adminLevel') ;

        if(!$admin) {
            $this->redirect('admin_login/index');
        }
        elseif($admin && $level=='Administrator') {

        }
        else {
            $controller = pzk_request('controller');
            $action = pzk_request('action');
            if(isset($action) && $action != 'index') {
                $adminmodel = pzk_model('admin');
                $checkAction = $adminmodel->checkActionType($action, $controller, $level);
                if($checkAction) {
                    $view = pzk_parse('<div layout="erorr/erorr" />');
                    $view->display();
                    die();
                }
            }else {
                $adminmodel = pzk_model('admin');
                $checkLogin = $adminmodel->checkAction($controller, $level);
                if(!$checkLogin) {
                    $view = pzk_parse('<div layout="erorr/erorr" />');
                    $view->display();
                    die();
                }
            }
        }

    }
}
?>
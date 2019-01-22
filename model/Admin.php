<?php
class PzkAdminModel {
    public function getUser($username) {
        static $data = array();
        if (!$username) return false;
        if (!@$data[$username]) {
            if (is_numeric($username)) {
                $userId = $username;
                $conds = "`id`='$userId'";
            } else {
                $conds = "`username`='$username'";
            }
            $users = _db()->select('*')->from('user')
                ->where($conds)->limit(0, 1)->result();
            if ($users) $data[$username] = $users[0];
            else $data[$username] = false;
        }
        return $data[$username];
    }

    public function login($username, $password) {
        $password = md5(trim($password));
        $users = _db()->select('a.*, at.*')
            ->from('admin a')
            ->join('admin_level at', 'a.usertype_id = at.id')
            ->where("name='$username' and password='$password'")
            ->limit(0, 1);
        $users = $users->result_one();

        if ($users) {
            return $users;
        }else{
            return false;

        }
    }

    public function checkAction($action, $level) {
        $users = _db()->select('a.*')
            ->from('admin_level_action a')
            ->where("admin_action='$action' and admin_level='$level'")
            ->limit(0, 1);
        $users = $users->result();
        if ($users) {
            return true;
        }else{
            return false;

        }
    }

    public function checkActionType($type,$controller, $level) {
        $type = trim($type);
        $users = _db()->select('a.*')
            ->from('admin_level_action a')
            ->where("action_type='$type' and admin_action='$controller' and admin_level='$level'")
            ->limit(0, 1);
        $users = $users->result();
        if ($users) {
            return true;
        }else{
            return false;

        }
    }
}
?>
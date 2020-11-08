<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Model_session extends CI_Model {
    /* ========login check========== */

    public function check_login($url = NULL, $fallback = NULL) {
		
        if ($this->model_sys->get_system_state() == FALSE) {
            header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
            header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");

            header("Cache-Control: no-store, no-cache, must-revalidate");
            header("Cache-Control: post-check=0, pre-check=0", false);
            header("Pragma: no-cache");

            $this->session->sess_destroy();
            redirect(site_url('login'));
        }

        if ($this->session->userdata('login') == TRUE) {
            if ($url) {
                redirect(site_url($url));
            }
        } else {
            if ($fallback) {
                redirect(site_url('login'));
            }
        }
    }

    /* ========validate login========== */

    public function validateLogin($uName, $uPwd) {
				
		$sql = "SELECT u.userID, u.userName, u.userFname, u.userPwd, a.group_lvl,u.userAdmin,u.userDepartment
				FROM ".DBUSR." u
				JOIN ".DBGRP." a ON a.group_id =  u.group_id
				WHERE u.userName = '" .$uName . "'
				AND u.userFlag =  1
				";
		$query = $this->db->query($sql);
		
        // if available
        if ($query->num_rows()>0) {
			$user = $query->row();
				
			if (crypt($uPwd,$user->userPwd)===$user->userPwd) {
			
				$this->session->set_userdata('login', TRUE);
				$this->session->set_userdata('uID', $user->userID);
				$this->session->set_userdata('uName', $user->userName);
				$this->session->set_userdata('gID', $user->group_id);
				$this->session->set_userdata('uAdmin', $user->userAdmin);
				$this->session->set_userdata('uDepartment', $user->userDepartment);
				$this->session->set_userdata('uFname', $user->userFname);
				
				$this->setup_session_auth($user->group_lvl);
				
				return TRUE;
			}else{
				return FALSE;
			}	
        } else {
            return FALSE;
		}
    }

    /* PERMISSION */

    private function setup_session_auth($group_lvl) {
        $data = array();

        $auth = explode(',', $group_lvl);
        foreach ($auth as $key => $val) {
            $x = explode('=', $val);
            $data[$x[0]] = $x[1];
        }

        $this->session->set_userdata('auth', $data);
    }

    /* END PERMISSION */

    /*
     *  Kick user if they lack of permission
     *  $page (see: config/config.php)
     *  $role (see: config/config.php)
     */

    public function auth_page($page, $role) {
        $CI = & get_instance();
        $auth_array = $CI->config->item('auth_array');

        $permission = 0;
        $session = $this->session->userdata('auth');

        if (!isset($session[$page])) {
            return redirect(site_url('login'));
        }

        $currAuth = $session[$page];
        $roleArray = $auth_array;

        if ($role > intval($currAuth)) {
            return redirect(site_url());
        } else {
            return TRUE;
        }
    }

    /*
     *  Hide stuff if user lack of permission
     *  $page (see: config/config.php)
     *  $role (see: config/config.php)
     */

    public function auth_display($page, $role) {
        $CI = & get_instance();
        $auth_array = $CI->config->item('auth_array');

        $permission = 0;
        $session = $this->session->userdata('auth');

        if (!isset($session[$page])) {
            return FALSE;
        }

        $currAuth = $session[$page];
        $roleArray = $auth_array;

        if ($role > intval($currAuth)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    // helper displaying session
    public function _display_sess() {
        $sess_arr = $this->session->all_userdata();
        $output = '';
        $output .= '<div class="dev">';
        while (list($a, $b) = each($sess_arr)) {
            $output .= '<span class="label">' . $a . '/' . $b . '</span> ';
        }
        $output .= '</div>';
        return $output;
    }

    // TRACE ADMIN ACTIVITY
    public function log_activity($type, $changes, $data = NULL) {
        $i = 1;
        if ($data != NULL) {
            $changes .= ' Data=> ';
        }

        $this->db->set('log_ip', $this->session->userdata('ip_address'));
        $this->db->set('log_agent', $this->session->userdata('user_agent'));
        $this->db->set('log_type', $type);
        $this->db->set('ID_user', $this->session->userdata('uID'));
        $this->db->set('log_name', $this->session->userdata('uFname'));

        if (is_array($data)) {
            foreach ($data as $key => $val) {
                if ($key != $this->config->item('csrf_token_name')) {
                    if ($i != 1) {
                        $changes .= ', ';
                    }
                    $changes .= '[' . $key . '] : ' . (($val != '') ? $val : NULL);
                    $i++;
                }
            }
        } else {
            $changes .= ' ' . $data;
        }

        $this->db->set('log_activity', $changes);
        $this->db->set('log_date', 'NOW()', FALSE);
        $this->db->insert(DBLOG);
    }

    /*
     *  Kick user if they lack of permission
     *  $page (see: config/config.php)
     *  $role (see: config/config.php)
     */

    public function auth_page_check($page, $role) {
        $CI = & get_instance();
        $auth_array = $CI->config->item('auth_array');

        $permission = 0;
        $session = $this->session->userdata('auth');

        if (!isset($session[$page])) {
            return redirect(site_url());
        }

        $currAuth = $session[$page];
        $roleArray = $auth_array;

        if ($role > intval($currAuth)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

}

// end class
/* End of file model_session.php */
/* Location: ./_app/model/model_session.php */
<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Authenticate extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    function authenticate($username, $password) {
        $this->db->where('username', $username);
        $this->db->where('password', $password);
        $query = $this->db->get('sigma_users');
        if ($query->num_rows() > 0) :
            return TRUE;
        else:
            return FALSE;
        endif;
        }

    }


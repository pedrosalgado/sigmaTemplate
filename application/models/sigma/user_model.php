<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class User_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    function authenticate($username, $password) {
        $this->db->where('username', $username);
        $this->db->where('password', sha1($password));
        $this->db->where('authorized', 1);
        $query = $this->db->get('sigma_users');
        if ($query->num_rows() > 0) :
            return TRUE;
        else:
            return FALSE;
        endif;
        }

    function register($post) {
        $this->db->set('username', $post['username']);
        $this->db->set('password', sha1($post['password']));
        $this->db->set('email', $post['email']);
        $query = $this->db->insert('sigma_users');
        
        return $this->db->affected_rows() ? true : false;
        }
}


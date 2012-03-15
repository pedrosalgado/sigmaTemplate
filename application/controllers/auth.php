<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Auth extends SIGMA_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('user', 'user');
    }

    public function id($login = null) {
        if(empty($login)) $this->index(); return;
        
        //$this->texto = $this->pages->getTextos('login');
        $this->menu = $this->pages->getPagesRoot();

        $data = array('pages' => $this->menu ? $this->menu : array());

        $this->template->write_view('header', 'header',$data);
        $this->template->write_view('top', 'auth_logged');
        $this->template->write_view('sidebar', 'navigation', $data);

        $data = array('nome' => $this->nome ? $this->nome : array());
        
        $this->template->write_view('content', 'auth_user', $data);
        $this->template->write_view('footer', 'footer');
        $this->template->render();
    }

    public function register() {
        
    }

    public function unregister() {
        
    }

    public function authenticate() {
        $this->load->model('authenticate','auth');
        $user = $this->input->post('username');
        $pass = $this->input->post('password');

        if (strlen($user) > 0 && strlen($pass) > 0) {

            if ($this->auth->authenticate($user, $pass)) {
                $this->session->set_userdata('loggedin', true);
                redirect(base_url() . '');
            } else {
                redirect(base_url() . 'index.php/login');
            }
        } else {
            redirect(base_url() . 'index.php/login');
        }
    }

    public function logout() {
        $this->session->unset_userdata('loggedin');
        redirect(base_url() . 'index.php/login');
    }
}
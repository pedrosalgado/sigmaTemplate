<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of sessions
 *
 * @author Cego
 */
class Sessions extends SIGMA_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('sigma/user_model');
    }

    public function index() {
        
        $this->load->view('sigma/header', $this->data);
        $this->load->view('sessions/login', $this->data);
        $this->load->view('sessions/register', $this->data);
        $this->load->view('sigma/footer', $this->data);
//        echo $this->db->last_query();
    }

    public function login() {
        $this->load->view('sigma/header', $this->data);
        $this->load->view('sessions/login', $this->data);
        $this->load->view('sigma/footer', $this->data);
    }

    public function register() {
        $this->load->view('sigma/header', $this->data);
        $this->load->view('sessions/register', $this->data);
        $this->load->view('sigma/footer', $this->data);
    }

    public function authenticate() {
        $user = $this->input->post('username');
        $pass = $this->input->post('password');

        if (strlen($user) > 0 && strlen($pass) > 0) {

            if ($this->user_model->authenticate($user, $pass)) {
                $this->session->set_userdata('loggedin', true);
                redirect(base_url() . 'index.php/sigma/pages');
            } else {
                redirect(base_url() . 'index.php/sessions/login');
            }
        } else {
            redirect(base_url() . 'index.php/sessions/login');
        }
    }

    public function do_register() {
        $post = array(
        'username' => $this->input->post('username'),
        'password' => $this->input->post('password'),
        'email' => $this->input->post('email')
        );
        if (strlen($post['username']) > 0 && strlen($post['password']) > 0) {

            if ($this->user_model->register($post)) {
                $this->session->set_userdata('loggedin', true);
                redirect(base_url() . 'index.php/sigma/pages');
            } else {
                $this->data['error'] = "Erro de registo";
            }
        } else {
            $this->data['error'] = "Insira Nome de Utilizador ou Password correctamente";
        }
        $this->index();
    }

    public function logout() {
        $this->session->unset_userdata('loggedin');
        redirect(base_url() . 'index.php/sessions');
//        header('Location: /');
    }

}

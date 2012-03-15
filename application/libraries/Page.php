<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Page extends CI_Controller {

    var $pages;
    var $texto;

    function __construct() {
        parent::__construct();
        
        $this->load->model('pages','pages');
        
        $pages = $this->pages->getPages();
        $texto = $this->pages->getTextosFromURL('home','sigma_pages');
        $data = array('pages' => $pages,  'title' => $texto['title'],'body' => $texto['body']);

    }
    public function index() {

        $data = array('pages' => $this->pages,  'title' => $this->texto['title'],'body' => $this->texto['body']);
        $this->load->view('home',$data);
    }

    public function page($id) {

        $data = array('pages' => $this->pages,  'title' => $this->texto['title'],'body' => $this->texto['body']);
        $this->load->view('page',$data);
    }

}


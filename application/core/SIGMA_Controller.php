<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class SIGMA_Controller extends CI_Controller {

    var $header;
    var $texto = array();
    var $data = array();
    var $menu;
    
    function __construct() {
        parent::__construct();

        $this->load->model('sigma/modules_model','model');
        
        $this->data['title'] = "&Sigma;9CMS ";
        $this->data['desc'] = "";
        $this->data['keywords'] = "";
        $this->data['urlsuffix'] = "sigma/";
        $this->data['tables'] = $this->model->getTables();
        $this->data['prefixAdd'] = "records/add";
        $this->data['prefixDel'] = "records/del";
        $this->data['prefixEdit'] = "records/edit";
        $this->data['prefixConsult'] = "records/consult";
        $this->data['prefixEditTable'] = "tables/edit";
        $this->data['prefixAddTable'] = "tables/add";
        $this->data['prefixDelTable'] = "tables/do_del";
    }

    public function index() {
        $this->texto = $this->model->getTextosFromURL('home','sigma_pages');
        $this->menu = $this->model->getPagesRoot();

        $data = array('pages' => $this->menu ? $this->menu : array());

        $this->template->write_view('header', 'header', $data);
        $this->template->write_view('top', 'modules/auth');
        $this->template->write_view('sidebar', 'modules/navigation', $data);

        $data = array('content' => $this->texto ? $this->texto : array());
        $this->template->write_view('content', 'modules/page', $data);
        $this->template->write_view('footer', 'footer');
        $this->template->render();
    }

    public function id($id = '') {
        $this->texto = $this->model->getTextosFromURL(!empty($id) ? $id : '','sigma_pages');
        $this->menu = $this->model->getPagesChildren($id ? $id : '');

        $data = array('pages' => $this->menu ? $this->menu : array());

        $this->template->write_view('header', 'header',$data);
        $this->template->write_view('top', 'modules/auth');
        $this->template->write_view('sidebar', 'modules/navigation', $data);

        $data = array('content' => !$this->texto ? array() : $this->texto);
        $this->template->write_view('content', 'modules/page', $data);
        $this->template->write_view('footer', 'footer');
        $this->template->render();
    }

}


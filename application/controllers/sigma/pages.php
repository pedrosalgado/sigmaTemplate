<?php
class Pages extends SIGMA_Controller {

    function __construct() {
        parent::__construct();
        
        
        $this->load->model('sigma/pages_model','pages');
    }

    function index() {
        $this->listing();
    }
    function id($id) {
        
        $this->data['pages'] = $this->pages->getFullPages($id);
        $this->data['error'] = array();

        $this->load->view('sigma/pages/page', $this->data);
    }
    function listing() {
        
        $this->data['pages'] = $this->pages->getFullPages();
        $this->data['error'] = array();

        $this->load->view('sigma/pages/pages_list', $this->data);
    }
    function edit($id) {    
        $this->data['id_item'] = $id;
        $this->data['table_name'] = 'sigma_pages';
        
        $this->data['pages'] = $this->pages->getFullPages($id);
        $this->data['error'] = array();
        $this->data['edit'] = true;
        $this->load->view('sigma/pages/pages_form', $this->data);
    }
    function do_edit($id) {
        $this->data['id_item'] = $id;
        $this->data['table_name'] = 'sigma_pages';        
        
        $post = $this->input->post();
        $id_page = $this->pages->savePages($post,$id);
        $this->data['pages'] = $this->pages->getFullPages($id_page);        
        $this->data['error'] = '';
        $this->data['edit'] = true;

        if($id_page) :
            $this->data['error'] = "Sucesso";
        else :
            $this->data['error'] = "Houve um erro";    
        endif;
        
        $this->load->view('sigma/pages/pages_form', $this->data);
    }
    function add() {
//        $this->data['pages'] = $this->pages->getFullPages();
        $this->data['error'] = array();
        $this->data['edit'] = false;
        $this->load->view('sigma/pages/pages_form', $this->data);
    }
    function do_add() {
        $post = $this->input->post();
        $id_page = $this->pages->savePages($post);
        $this->data['pages'] = $this->pages->getFullPages($id_page);
        $this->data['error'] = array();
        $this->data['edit'] = false;
        if($id_page) :
            $this->data['error'] = "Sucesso";
        else :
            $this->data['error'] = "Houve um erro";    
        endif;
        
        $this->load->view('sigma/pages/pages_form', $this->data);
    }
    
    function del($id = null) {
        //$id = $this->input->post('id');
        if(!empty($id)) :
            $res = $this->pages->deletePage($id);
            $this->data['error'] = "Sucesso";
        else : $this->data['error'] = "Erro";
        endif;
        $this->data['pages'] = $this->pages->getFullPages();
        $this->load->view('sigma/pages/pages_list', $this->data);
    }
    
}
?>
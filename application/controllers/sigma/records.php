<?php
class Records extends SIGMA_Controller {

    function  __construct() {
        parent::__construct();
        
    }
    function index($table = '',$id = '') {

        if(strlen($table) > 0) {
            $this->data['fields'][$table] =  $this->model->getFields($table);

            $this->data['resultsArray'][$table] = $this->model->getRecords($table);
        }
        else {
            foreach($this->model->getTables() as $table) {
                $this->data['fields'][$table] =  $this->model->getFields($table);
            }
            $this->data['resultsArray'] = $this->model->getTablesRecords();
        }
        $this->load->view('sigma/index', $this->data);
    }
    function consult($table,$id) {
        $this->data['fields'][$table] =  $this->model->getFields($table);
        $this->data['results'] = $this->model->editRecord($table,$id);

        $this->load->view('sigma/records/change', $this->data);
    }
    function add($table) {
        
        $this->data['results'] = $this->model->addRecord($table);
        
        $this->load->view('sigma/records/change', $this->data);
    }
    function edit($table,$id) {
        
        $this->data['results'] = $this->model->editRecord($table,$id);
        
        $this->load->view('sigma/records/change', $this->data);
    }
    function do_add($table) {
        $post = $this->input->post();
        $this->model->do_addRecord($table,$post);
        redirect('sigma/indice');
    }
    function del($table,$id_name, $id) {
        $this->data['results'] = $this->model->delRecord($table,$id_name,$id);
        redirect('sigma/indice');
    }  
    function do_edit($table,$id) {
        $post = $this->input->post();
        $this->data['results'] = $this->model->do_editRecord($table,$post,$id);
        redirect('sigma/indice');
    }

}
?>
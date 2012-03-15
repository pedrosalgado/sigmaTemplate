<?php
class Tables extends SIGMA_Controller {

    function  __construct() {
        parent::__construct();
        
    }
    function index($table = '') {
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
    
    function edit($table) {
        
        $this->data['table'] = $table;
        $this->data['results'] = $this->model->alterTable($table);
        $this->load->view('sigma/tables/change', $this->data);
    }
    function do_edit($table) {
        $post = $this->input->post();
        $this->data['results'] = $this->model->do_alterTable($table,$post);
        redirect('sigma/tables/edit/'.$table);
    }
    function do_addTable() {
        $post = $this->input->post();
        $table_name = $this->model->do_addTable($post);
        redirect('sigma/tables/edit/'.$table_name);
    }
    function do_add($table) {
        $post = $this->input->post();
        $this->data['results'] = $this->model->do_addColTable($table,$post);
        redirect('sigma/tables/edit/'.$table);
    }
    function do_delCol($table) {
        $post = $this->input->post();        
        $this->data['results'] = $this->model->do_alterTable($table,$post);
        redirect('sigma/tables/edit/'.$table);
    }
    function do_del($table) {
        $this->data['results'] = $this->model->do_delTable($table);
        redirect('sigma/indice');
    }
}
?>
<?php
class Indice extends SIGMA_Controller {

    function  __construct() {
        parent::__construct();
        $this->load->model('sigma/modules_model','model');
    }


    function index($table = '') {
        $data['title'] = "&Sigma;9CMS - Home";
        $data['desc'] = "";
        $data['keywords'] = "";
        $data['urlsuffix'] = "sigma/";
        $data['tables'] = $this->model->getTables();
        $data['prefixAdd'] = "records/add";
        $data['prefixDel'] = "records/del";
        $data['prefixEdit'] = "records/edit";
        $data['prefixConsult'] = "records/consult";
        $data['prefixEditTable'] = "tables/edit";
        $data['prefixAddTable'] = "tables/addTable";
        $data['prefixDelTable'] = "tables/do_del";
        
        if(strlen($table) > 0) {
            $data['fields'][$table] =  $this->model->getFields($table);

            $data['resultsArray'][$table] = $this->model->getRecords($table);
        }
        else {
            foreach($this->model->getTables() as $table) {
                $data['fields'][$table] =  $this->model->getFields($table);
            }
            $data['resultsArray'] = $this->model->getTablesRecords();
        }
        $this->load->view('sigma/index', $data);
    }

}
?>
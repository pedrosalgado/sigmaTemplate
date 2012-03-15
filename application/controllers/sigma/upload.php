<?php

class Upload extends SIGMA_Controller {

    function __construct() {
        parent::__construct();

        $this->load->helper(array('form', 'url'));
    }

    function index() {

        $this->data['error'] = array();

        $this->load->view('sigma/upload/upload_add', $this->data);
    }

    function listing() {
        $this->data['files'] = $this->model->getRecords('sigma_files');
        $this->data['error'] = array();
        
        $this->load->view('sigma/upload/upload_list', $this->data);
    }

    function do_upload() {
        $this->data['error'] = array();

         $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'gif|jpg|png|doc|txt';
            $config['max_size'] = 1024 * 8;
            $config['encrypt_name'] = TRUE;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload()) {
            $this->data['error'] = $this->upload->display_errors();

            $this->load->view('sigma/upload/upload_add', $this->data);
        } else {

            $data = $this->upload->data();
            $data['nome'] = $_POST['title'];
            $this->genThumb($data);
            $this->model->do_addRecord('sigma_files', $data);
            $this->load->view('sigma/upload/upload_success', $this->data);
        }
    }

    function listing_mod($table = null,$id = null) {
        $this->data['files'] = $this->model->getRecords('sigma_files');
        $this->data['error'] = array();
        if($id && $table) $this->data['text_files'] = $this->model->getFiles($id,$table);
        $this->load->view('sigma/upload/upload_list_mod', $this->data);
    }

    function do_upload_mod() {
        $status = "";
        $msg = "";
        $file_element_name = 'userfile';
        $post = $this->input->post();
        if (empty($post['title'])) {
            $status = "error";
            $msg = "Please enter a title";
        }

        if ($status != "error") {
            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'gif|jpg|png|doc|txt';
            $config['max_size'] = 1024 * 8;
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload($file_element_name)) {
                $status = 'error';
                $msg = $this->upload->display_errors('', '');
            } else {
                $data = $this->upload->data();
                $data['sigma_files_name'] = $post['title'];
                $this->genThumb($data);
                $file_id = $this->model->do_addRecord('sigma_files', $data);
                if ($file_id) {
                    $status = "success";
                    $msg = "File successfully uploaded";
                } else {
                    unlink($data['full_path']);
                    $status = "error";
                    $msg = "Something went wrong when saving the file, please try again.";
                }
            }
            @unlink($_FILES[$file_element_name]);
        }
        echo json_encode(array('status' => $status, 'msg' => $msg));
    }

    function genThumb($data) {
        $thumb_config = array();
        $thumb_config['image_library'] = 'gd2';
        $thumb_config['source_image'] = $data['full_path'];
        $thumb_config['create_thumb'] = TRUE;
        $thumb_config['maintain_ratio'] = TRUE;
        $thumb_config['width'] = 75;
        $thumb_config['height'] = 50;

        $this->load->library('image_lib', $thumb_config);

        $this->image_lib->resize();
    }
    
    function del($id) {
        //$id = $this->input->post('id');
        $res = $this->model->delRecord('sigma_files','id', $id);
        $this->listing();
    }
}

?>

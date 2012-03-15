<?php

class Products extends SIGMA_Controller {

    function __construct() {
        parent::__construct();

        $this->load->helper(array('form', 'url'));
        $this->load->model('sigma/products_model', 'products');
    }

    function index() {
        $this->listing();
    }

    function listing() {
        $this->data['prods'] = $this->products->getProducts();
        $this->data['error'] = array();
        $this->load->view('sigma/products/products_list', $this->data);
    }

    function edit($id) {
        $this->data['id_item'] = $id;
        $this->data['table_name'] = 'sigma_products';
        
        $this->data['prods'] = $this->products->getProducts($id);
        $this->data['error'] = array();
        $this->data['edit'] = true;
        $this->load->view('sigma/products/products_form', $this->data);
    }

    function do_edit($id) {
        $this->data['id_item'] = $id;
        $this->data['table_name'] = 'sigma_products';
        
        $post = $this->input->post();
        $id_prod = $this->products->saveProds($post, $id);
        $this->data['prods'] = $this->products->getProducts($id_prod);
        $this->data['error'] = '';
        $this->data['edit'] = true;
        if ($id_prod) :
            $this->data['error'] = "Sucesso";
        else :
            $this->data['error'] = "Houve um erro";
        endif;

        $this->load->view('sigma/products/products_form', $this->data);
    }

    function add() {
        $this->data['edit'] = false;
        $this->data['error'] = array();
        $this->load->view('sigma/products/products_form', $this->data);
    }

    function do_add() {
        $post = $this->input->post();
        $id_prods = $this->products->saveProds($post);
        $this->data['error'] = array();
        $this->data['prods'] = $this->products->getProducts($id_prods);
        if ($id_prods) :
            $this->data['error'] = "Sucesso";
        else :
            $this->data['error'] = "Houve um erro";
        endif;
        $this->data['edit'] = true;
        if ($id_prods) {
            $this->load->view('sigma/products/products_form', $this->data);
        }
        $this->load->view('sigma/products/products_form', $this->data);
    }

    function del($id = null) {
        //$id = $this->input->post('id');
        if(!empty($id)) :
            $res = $this->products->deleteProds($id);
            $this->data['error'] = "Sucesso";
        else : $this->data['error'] = "Erro";
        endif;
        $this->data['prods'] = $this->products->getProducts();
        $this->load->view('sigma/products/products_list', $this->data);

    }

}

?>
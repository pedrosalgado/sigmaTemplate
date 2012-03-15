<?php

/**
 * Description of news_model
 *
 * @author Cego
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Products_Model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function getProducts($id = null) {
        $this->db->select('*,sigma_products.id as prod_id');
        if ($id) 
            $this->db->where('sigma_products', $id);
        $this->db->from('sigma_products');
        $this->db->join('sigma_products_texts', 'sigma_products.id = sigma_products_texts.sigma_products', 'left');
        $this->db->join('sigma_texts', 'sigma_products_texts.sigma_texts = sigma_texts.id', 'left');
        $this->db->join('sigma_texts_files', 'sigma_texts_files.sigma_texts = sigma_texts.id', 'left');
        $this->db->join('sigma_files', 'sigma_texts_files.sigma_files = sigma_files.id', 'left');
        $query = $this->db->get();

        return $query->num_rows() > 0 ? $query->result() : false;
    }

    function saveProds($post, $id = null) {
        $this->db->set('sigma_products_name', $post['nome']);
        if ($id) :
            $this->db->where('id', $id);
            $this->db->update('sigma_products');
        else :
            $this->db->insert('sigma_products');
            $id_prod = $this->db->insert_id();
        endif;
        $id_text = $this->model->saveTexts('sigma_products', $post, $id ? $id : $id_prod, $id);
        $ids_files = $this->model->saveFiles($post, $id_text, $id);
        return $id ? $id : $id_prod;
    }

    function deleteProds($id) {
        $this->model->delRecord('sigma_products', 'id', $id);
        $this->model->delRecord('sigma_products_texts', 'sigma_products', $id);
        $texts = $this->model->getTextos($id, 'sigma_products');
        foreach ($texts as $t) {
            $this->model->delRecord('sigma_texts', 'id', $t->sigma_texts);
            $this->model->delRecord('sigma_texts_files', 'sigma_texts', $t->sigma_texts);
        }
    }

}

?>

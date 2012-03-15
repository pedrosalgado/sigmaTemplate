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

    public function getCategories($id = null) {
        if ($id) :
            $this->db->select('*');
            $this->db->where('id', $id);
            $this->db->from('sigma_categories');
            $query = $this->db->get();
        else :
            $this->db->select('*');
            $this->db->from('sigma_categories');
            $query = $this->db->get();
        endif;
        return $query->num_rows() > 0 ? $query->result() : false;
    }
    
    public function getProducts($id = null) {
        if ($id) :
            $this->db->select('*');
            $this->db->where('sigma_products', $id);
            $this->db->from('sigma_products');
            $this->db->join('sigma_products_texts', 'sigma_products.id = sigma_products_texts.sigma_products');
            $this->db->join('sigma_texts', 'sigma_products_texts.sigma_texts = sigma_texts.id');
            $this->db->join('sigma_texts_files', 'sigma_texts_files.sigma_texts = sigma_texts.id');
            $this->db->join('sigma_files', 'sigma_texts_files.sigma_files = sigma_files.id');
            $query = $this->db->get();
        else :
            $this->db->select('*');
            $this->db->from('sigma_products');
            $this->db->join('sigma_products_texts', 'sigma_products.id = sigma_products_texts.sigma_products');
            $this->db->join('sigma_texts', 'sigma_products_texts.sigma_texts = sigma_texts.id');
            $this->db->join('sigma_texts_files', 'sigma_texts_files.sigma_texts = sigma_texts.id');
            $this->db->join('sigma_files', 'sigma_texts_files.sigma_files = sigma_files.id');
            $query = $this->db->get();
        endif;
        return $query->num_rows() > 0 ? $query->result() : false;
    }

}

?>

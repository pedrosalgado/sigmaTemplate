<?php

/**
 * Description of news_model
 *
 * @author Cego
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pages_Model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    function getPagesRoot() {
        $this->db->not_like('sigma_pages_name', 'home');
        $this->db->order_by('weight');
        $query = $this->db->get('sigma_pages');
        return $query->num_rows() > 0 ? $query->result() : false;
    }
    
    function getPagesChildren($cod) {
        $this->db->where('url', $cod);
        $query = $this->db->get('sigma_pages');
        $id = 1;
        foreach ($query->result() as $function_info) {
            $id = $function_info->id;
        }
        $this->db->where('url !=', 'home');
        $this->db->where('sigma_pages', $id);
        $this->db->order_by('weight');
        $query = $this->db->get('sigma_pages');
        return $query->num_rows() > 0 ? $query->result() : false;
    }

    public function getTextos($id = null) {
        if ($id) :
            $this->db->select('*');
            $this->db->where('url', $id);
            $this->db->from('sigma_pages');
            $this->db->join('sigma_pages_texts', 'sigma_pages.id = sigma_pages_texts.sigma_pages');
            $this->db->join('sigma_texts', 'sigma_pages_texts.sigma_texts = sigma_texts.id');
            $this->db->join('sigma_texts_files', 'sigma_texts_files.sigma_texts = sigma_texts.id');
            $this->db->join('sigma_files', 'sigma_texts_files.sigma_files = sigma_files.id');
            $query = $this->db->get();
        else :
            $this->db->select('*');
            $this->db->from('sigma_pages');
            $this->db->join('sigma_pages_texts', 'sigma_pages.id = sigma_pages_texts.sigma_pages');
            $this->db->join('sigma_texts', 'sigma_pages_texts.sigma_texts = sigma_texts.id');
            $this->db->join('sigma_texts_files', 'sigma_texts_files.sigma_texts = sigma_texts.id');
            $this->db->join('sigma_files', 'sigma_texts_files.sigma_files = sigma_files.id');
            $query = $this->db->get();
        endif;
        return $query->num_rows() > 0 ? $query->result() : false;
    }

}

?>

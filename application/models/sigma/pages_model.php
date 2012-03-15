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
        $this->load->model('sigma/modules_model', 'model');
    }

    function getFullPages($id = null) {
        if ($id) :
            $this->db->select('*,sigma_pages.id as page_id');
            $this->db->where('sigma_pages.id', $id);
            $this->db->from('sigma_pages');

        else :
            $this->db->select('*,sigma_pages.id as page_id');
            $this->db->from('sigma_pages');

        endif;
        $this->db->join('sigma_pages_texts', 'sigma_pages.id = sigma_pages_texts.sigma_pages', 'left');
        $this->db->join('sigma_texts', 'sigma_pages_texts.sigma_texts = sigma_texts.id', 'left');
        $this->db->join('sigma_texts_files', 'sigma_texts_files.sigma_texts = sigma_texts.id', 'left');
        $this->db->join('sigma_files', 'sigma_texts_files.sigma_files = sigma_files.id', 'left');
        $query = $this->db->get();
        return $query->num_rows() > 0 ? $query->result() : false;
    }

    function getPagesChildren($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('sigma_pages');
        $nid = 1;
        foreach ($query->result() as $function_info) {
            $nid = $function_info->id;
        }
        $this->db->where('sigma_pages', $nid);
        $this->db->order_by('weight');
        $query = $this->db->get('sigma_pages');
        return $query->num_rows() > 0 ? $query->result() : false;
    }

    function savePages($post, $id = null) {
        $this->db->set('sigma_pages_name', $post['nome']);
        $this->db->set('weight', $post['weight']);
        $this->db->set('url', $post['url']);
        if ($id) :
            $this->db->where('id', $id);
            $this->db->update('sigma_pages');
        else :
            $this->db->insert('sigma_pages');
            $id_page = $this->db->insert_id();
        endif;
        $id_text = $this->model->saveTexts('sigma_pages',$post, $id ? $id : $id_page, $id);
        $ids_files = $this->model->saveFiles($post, $id_text, $id);
        return $id ? $id : $id_page;
    }

    function deletePage($id) {
        $this->model->delRecord('sigma_pages', 'id', $id);
        $this->model->delRecord('sigma_pages_texts', 'sigma_pages', $id);
        $texts = $this->model->getTextos($id, 'sigma_pages');
        if ($texts)
            foreach ($texts as $t) {
                $this->model->delRecord('sigma_texts', 'id', $t->sigma_texts);
                $this->model->delRecord('sigma_texts_files', 'sigma_texts', $t->sigma_texts);
            }
    }

}

?>

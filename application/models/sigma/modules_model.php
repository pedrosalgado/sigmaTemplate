<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of adminfuncs_model
 *
 * @author Cego
 */
class Modules_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getRecords($table, $where = '', $orderby = '') {
        if (strlen($orderby) > 0)
            $this->db->orderby($orderby);
        $this->db->from($table);
        if (strlen($where) > 0)
            $this->db->where($where);
        $query = $this->db->get();
//        if($query->num_rows() > 0)
        return $query->result();
    }

    function delRecord($table, $id_name, $id) {
        $this->db->where($id_name, $id);
        $this->db->delete($table);
    }

    function addRecord($table) {

        $fields = $this->db->list_fields($table);
        $output = form_open('sigma/records/do_add/' . $table, 'class="form"');

        foreach ($fields as $field) {

            if ($field == 'id')
                ;
            else {
                $output .= '<div class="field">' . form_label($field) . '';
                if ($field == 'body')
                    $output .= form_textarea($field, '', 'class="textarea"') . '</div>';
                else if (substr($field, 0, 6) == 'sigma_') {
                    foreach ($this->getTables() as $table) {
                        if ($field == $table) {
                            $results = $this->getRecords($table);
                            $options = array();
                            $table_name = $table . '_name';
                            foreach ($results as $result)
                                $options[$result->id] = $result->$table_name;
                            $output .= form_dropdown($field, $options, $field) . '</div>';
                        }
                    }
                }
                else
                    $output .= form_input($field) . '</div><br/>';
            }
        }
        $output .= form_submit('', 'Inserir') . '<br/>';
        return $output . '</form>';
    }

    function do_addRecord($table, $post) {
        $this->db->set($post);
        $this->db->insert($table);
        return $this->db->insert_id();
    }

    function do_addRecordRelationship($relation, $tables, $ids) {
        $this->db->set($tables[0], $ids[0]);
        $this->db->set($tables[1], $ids[1]);
        $this->db->insert($relation);
        return $this->db->insert_id();
    }

    function editRecord($table, $id) {

        $records = $this->getRecords($table, 'id = ' . $id);
        $output = form_open('sigma/records/do_edit/' . $table . '/' . $id, 'class="form"');

        foreach ($records[0] as $field => $value) {
            if ($field == 'id')
                ; else {

                $output .= '<div class="field">' . form_label($field) . '';
                if ($field == 'body')
                    $output .= form_textarea($field, $value, 'class="textarea"') . '</div>';
                else if ($field == $table) {
                    $results = $this->getRecords($table);
                    $options = array();
                    foreach ($results as $result) {
                        $table_name = $table . '_name';
                        $options[$result->id] = $result->$table_name;
                    }
                    $output .= form_dropdown($field, $options, $value) . '</div>';
                }
                else
                    $output .= form_input($field, $value) . '</div>';
            }
        }
        $output .= form_submit('', 'Editar') . '<br/>';
        return $output . '</form>';
    }

    function do_editRecord($table, $post, $id) {
        $this->db->where('id', $id);
        $this->db->set($post);
        $this->db->update($table);
    }

    function getFields($table) {
        return $this->db->list_fields($table);
    }

    function getTables() {
        return $this->db->list_tables();
    }

    function getTablesRecords() {
        $output = array();
        foreach ($this->db->list_tables() as $value) {
            $records = $this->getRecords($value);
            $output[$value] = $records;
        }
        return $output;
    }

    function alterTable($table) {
        $fields = $this->db->field_data($table);
        $output = '';


        foreach ($fields as $field) {
            if ($field == 'id')
                ; else {
                $output .= form_open('sigma/tables/do_edit/' . $table, 'class="form"');
                $output .= form_hidden('old_name', $field->name);
                $output .= form_input('name', $field->name) . ' : ';
                $options = array(strtoupper($field->type) => strtoupper($field->type), 'INT' => 'INT', 'VARCHAR(100)' => 'VARCHAR(100)', 'TEXT' => 'TEXT', 'DATE' => 'DATE', 'BLOB' => 'BLOB');
                $output .= form_dropdown('type', $options, strtoupper($field->type)) . ' : ';
                $output .= form_input('primary key', $field->primary_key) . ' : ';
                $output .= form_submit('delBtn', 'Apagar') . ' : ';
                $output .= form_submit('editBtn', 'Editar') . '<br/>';
                $output .= '</form>';
            }
        }

        return $output;
    }

    function do_alterTable($table, $post) {
        $this->load->dbforge();
        if (isset($post['delBtn']))
            $this->dbforge->drop_column($table, $post['old_name']);
        else {
            $fields = array(
                $post['old_name'] => array(
                    'name' => $post['name'],
                    'type' => strtoupper($post['type'])
                )
            );
            $this->dbforge->modify_column($table, $fields);
        }
    }

    function do_addColTable($table, $post) {
        $this->load->dbforge();
        $label = $post['name'];
        $fields = array(
            $label => array('type' => 'INT')
        );
        $this->dbforge->add_column($table, $fields);
    }

    function do_delTable($table) {
        $this->load->dbforge();
        $this->dbforge->drop_table($table);
    }

    function do_addTable($post) {
        $table_name = 'sigma_' . $post['name'];
        $this->load->dbforge();

        $fields = array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            $table_name . '_name' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
        );

        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_field($fields);
        $this->dbforge->create_table($table_name, TRUE);
        return $table_name;
    }

    function saveRelation($relation, $tables, $ids) {
        $this->db->set($tables[0], $ids[0]);
        $this->db->set($tables[1], $ids[1]);
        $this->db->insert($relation);
        return $this->db->insert_id();
    }

    function updateRelation($relation, $tables, $ids) {
        $this->delRecord($relation, 'id', $ids[0]);
        return $this->saveRelation($relation, $tables, $ids);
    }

    function do_updateRecord($table, $id, $post) {
        $this->db->where('id', $id);
        $this->db->update($table, $post);
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

    public function getTextosFromURL($id = null, $table = 'sigma_pages') {
        $this->db->select('*');
        $this->db->where($table . '.url', $id);
        $this->db->from($table);
        $this->db->join($table . '_texts', $table . '.id = ' . $table . '_texts.' . $table);
        $this->db->join('sigma_texts', $table . '_texts.sigma_texts = sigma_texts.id');
        $this->db->join('sigma_texts_files', 'sigma_texts_files.sigma_texts = sigma_texts.id');
        $this->db->join('sigma_files', 'sigma_texts_files.sigma_files = sigma_files.id');
        $query = $this->db->get();
        return $query->num_rows() > 0 ? $query->result() : false;
    }

    public function getTextos($id = null, $table = null) {
        $res = $this->model->getRecords($table . '_texts', $table . ' = ' . $id);
        return $res;
    }

    function getFiles($id, $table) {
        $res = $this->model->getRecords($table . '_texts,sigma_texts_files', $table . '_texts.' . $table . ' =' . $id . ' and ' . $table . '_texts.sigma_texts = sigma_texts_files.sigma_texts');
        return $res;
    }

    function saveTexts($table, $post, $id_page, $id = null) {
        $this->db->set('title', $post['title']);
        $this->db->set('body', $post['body']);
        if ($id) :
            $this->db->where('id', $id);
            $this->db->update('sigma_texts');
            $this->model->delRecord($table . '_texts', $table, $id_page);
        else :
            $this->db->insert('sigma_texts');
            $id_text = $this->db->insert_id();
        endif;
        $tables = array($table, 'sigma_texts');
        $ids = array($id_page, $id ? $id : $id_text);
        $id_rel = $this->model->saveRelation($table . '_texts', $tables, $ids);
        return $id ? $id : $id_text;
    }

    function saveFiles($post, $id_text) {
        $tables = array('sigma_files', 'sigma_texts');
        $res = array();
        $i = 0;
        $this->model->delRecord('sigma_texts_files', 'sigma_texts', $id_text);
        foreach ($post as $key => $value) {
            if (strstr($key, "checkbox")) {
                $this->db->set($tables[0], $value);
                $this->db->set($tables[1], $id_text);
                $this->db->insert('sigma_texts_files');
                $res[] = $value;
                $i++;
            }
        }
        return $res;
    }

}

?>

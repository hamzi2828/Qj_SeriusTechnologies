<?php

class TemplateModal extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function add_template($data)
    {
        $this->db->insert('templates', $data);
        return $this->db->insert_id();
    }

    

    public function get_all_templates()
    {
        $this->db->select('*');
        $this->db->from('templates');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_template_by_id($id)
    {
        $this->db->select('*');
        $this->db->from('templates');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row();
    }


    public function update_template($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('templates', $data);
    }

    public function delete_template($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('templates');
    }
}
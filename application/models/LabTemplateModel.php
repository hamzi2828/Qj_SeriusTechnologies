<?php
defined('BASEPATH') OR exit('No direct script access allowed');

final class LabTemplateModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database(); // Ensure the database is loaded
    }

   
    public function store_template($data)
    {
        if ($this->db->insert('hmis_lab_templates', $data)) {
            return $this->db->insert_id(); // Return the last inserted ID
        }
        return false; // Return false if insertion fails
    }



  
    public function insert_template_rows($rows)
    {
        // Check if the rows array is not empty and is an array
        if (is_array($rows) && !empty($rows)) {
            // Attempt to insert the batch of rows into the database
            $insertStatus = $this->db->insert_batch('hmis_lab_template_rows', $rows);
    
            // Check if the insert was successful and return the number of affected rows
            if ($insertStatus) {
                return $this->db->affected_rows(); // Return the number of rows inserted
            } else {
                // Log an error or handle failure if needed
                log_message('error', 'Failed to insert batch rows into hmis_lab_template_rows.');
                return false;
            }
        }
    
        // Return false if the input is not valid or empty
        log_message('error', 'Empty or invalid rows array provided to insert_template_rows.');
        return false;
    }
    


    public function get_all_templates()
    {
        $this->db->select('*');
        $this->db->from('hmis_lab_templates');
        $query = $this->db->get();
        return $query->result(); 
    }

   
    // Fetch template data by template ID
    public function get_template_by_id($id)
    {
        $this->db->select('*');
        $this->db->from('hmis_lab_templates');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row(); // Return a single result row as an object
    }

    // Fetch rows associated with a template by template ID
    public function get_template_rows_by_template_id($template_id)
    {
        $this->db->select('*');
        $this->db->from('hmis_lab_template_rows');
        $this->db->where('template_id', $template_id);
        $query = $this->db->get();
        return $query->result(); // Return all rows associated with the template as an array of objects
    }

    
    public function update_template($data, $id)
    {
        $this->db->where('id', $id);
        return $this->db->update('hmis_lab_templates', $data); // Return the update status
    }


    public function delete_template($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('hmis_lab_templates'); // Return the delete status
    }
}
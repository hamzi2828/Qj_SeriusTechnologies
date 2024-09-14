<?php

final class MedicalTestTemplates extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('LabTemplateModel'); // Load the model
        $this->load->library('session'); // Load the session library
        $this->load->helper('url'); 
    }

    
    public function header ( $title ) {
        $data[ 'title' ] = $title;
        $this -> load -> view ( '/includes/admin/header', $data );
    }
    
    public function sidebar () {
        $this -> load -> view ( '/includes/admin/general-sidebar' );
    }
    
    public function footer () {
        $this -> load -> view ( '/includes/admin/footer' );
    }

    public function add_lab_template () {
        // print_r ( 'here' );
        // die();
        $title = site_name . ' - Add Medical Tests';
        $this -> header ( $title );
        $this -> sidebar ();
        $data[ 'title' ]     = 'Add Medical Tests - Lab Template';


       
        $this -> load -> view ( '/medicalLabTemplates/create_lab_template', $data );
        $this -> footer ();
    }
    
    // Function to handle form submission
    public function store_lab_template() {
        // Debugging: Print the submitted form data
        // echo "<pre>";
        // echo "Template Data:\n";
        // print_r($this->input->post());
        // echo "</pre>";
        // exit();
    
        // Collect template data from the form input
        $templateData = [
            'template_name' => $this->input->post('template_name'),
            'header_name_1' => $this->input->post('header_name_1'),
            'header_name_2' => $this->input->post('header_name_2'),
            'header_name_3' => $this->input->post('header_name_3'),
            'header_name_4' => $this->input->post('header_name_4'),
            'header_name_5' => $this->input->post('header_name_5'),
            'header_name_6' => $this->input->post('header_name_6')
        ];
    
        // Insert template data and retrieve the template ID
        $templateId = $this->LabTemplateModel->store_template($templateData);
    
        // Check if the template was successfully inserted
        if ($templateId) {
            // Prepare data for rows associated with each header
            $headers = [
                1 => ['row_name' => $this->input->post('row_name_1'), 'row_value' => $this->input->post('row_value_1')],
                2 => ['row_name' => $this->input->post('row_name_2'), 'row_value' => $this->input->post('row_value_2')],
                3 => ['row_name' => $this->input->post('row_name_3'), 'row_value' => $this->input->post('row_value_3')],
                4 => ['row_name' => $this->input->post('row_name_4'), 'row_value' => $this->input->post('row_value_4')],
                5 => ['row_name' => $this->input->post('row_name_5'), 'row_value' => $this->input->post('row_value_5')],
                6 => ['row_name' => $this->input->post('row_name_6'), 'row_value' => $this->input->post('row_value_6')]
            ];
    
            // Insert rows for each header into the database
            foreach ($headers as $headerId => $headerData) {
                if (!empty($headerData['row_name'])) {
                    $rowsData = [];
    
                    // Loop through each row name and map values
                    foreach ($headerData['row_name'] as $index => $rowName) {
                        if (!empty($rowName)) {
                            // Primary value
                            $primaryValue = isset($headerData['row_value'][$index]) ? $headerData['row_value'][$index] : '';
    
                            // Prepare row data
                            $rowsData[] = [
                                'template_id' => $templateId,
                                'header_id' => $headerId,
                                'row_name' => $rowName,
                                'row_value_1' => $primaryValue
                            ];
                        }
                    }
    
                    // Insert the collected rows into the database if not empty
                    if (!empty($rowsData)) {
                        $this->LabTemplateModel->insert_template_rows($rowsData);
                    }
                }
            }
    
            // Set a success message for the session
            $this->session->set_flashdata('response', 'Template saved successfully.');
        } else {
            // Set an error message if template insertion failed
            $this->session->set_flashdata('error', 'Failed to save the template.');
        }
    
        // Redirect to a success page or another route
        redirect('/medical-test/template/add'); // Change this to the actual success route or page
    }
    


    public function all_lab_templates(){

        $title = site_name . ' - All Medical Tests';
        $this -> header ( $title );
        $this -> sidebar ();
        $data['templates'] = $this->LabTemplateModel->get_all_templates();
        
        $data[ 'title' ] = 'All Medical Tests - Lab Template';
         $this->load->view('medicalLabTemplates/all_templates', $data);

        $this -> footer ();
    }

    public function delete_template($id)
    {
        // Check if the template exists
        $template = $this->LabTemplateModel->get_template_by_id($id);
        if (!$template) {
            $this->session->set_flashdata('error', 'Template not found.');
            redirect('medical-test/template/all'); 
        }
    
        // Perform the delete operation
        $deleted = $this->LabTemplateModel->delete_template($id);
    
        // Check if the deletion was successful
        if ($deleted) {
            $this->session->set_flashdata('response', 'Template deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete the template.');
        }
    
        // Redirect to the all templates page
        redirect('medical-test/all/templates'); // Modify as needed
    }
    
    public function edit_template($id)
    {
        $title = site_name . ' - Edit Medical Test Template';
        $this->header($title);
        $this->sidebar();
    
        $template = $this->LabTemplateModel->get_template_by_id($id);
 
        if (!$template) {
            show_404(); 
        }
    
        $rows = $this->LabTemplateModel->get_template_rows_by_template_id($id);
        // echo "<pre>";
        // echo "Template Data:\n";
        // print_r($rows);
        // echo "</pre>";
        $groupedRows = [];
        foreach ($rows as $row) {
            $groupedRows[$row->header_id][] = $row;
        }
    
        // Prepare data to pass to the view
        $data = [
            'template' => $template,
            'rows' => $groupedRows,
            'title' => 'Edit Template'
        ];
    
        // Load the edit template view with data
        $this->load->view('medicalLabTemplates/edit_lab_template', $data);
    
        // Load the footer
        $this->footer();
    }
    

    public function update_template()
    {
        // Validate form data
        $this->form_validation->set_rules('template_name', 'Template Name', 'required');
        // Add more validation rules as necessary for other fields
    
        if ($this->form_validation->run() == FALSE) {
            // If validation fails, redirect back with errors
            $this->session->set_flashdata('error', validation_errors());
            redirect('/medical-test-settings/template/edit/' . $this->input->post('template_id')); 
        } else {
            // Collect template data from the form input
            $templateData = [
                'template_name' => $this->input->post('template_name'),
                'header_name_1' => $this->input->post('header_name_1'),
                'header_name_2' => $this->input->post('header_name_2'),
                'header_name_3' => $this->input->post('header_name_3'),
                'header_name_4' => $this->input->post('header_name_4'),
                'header_name_5' => $this->input->post('header_name_5'),
                'header_name_6' => $this->input->post('header_name_6')
            ];
    
            // Get the template ID
            $templateId = $this->input->post('template_id');
    
            // Check if the template exists, and if so, delete it
            if ($templateId) {
                // Delete the existing template and its rows
                $this->LabTemplateModel->delete_template($templateId);
            }
    
            // Recreate the template with the new data
            $newTemplateId = $this->LabTemplateModel->store_template($templateData);
    
            // Check if the new template was successfully created
            if ($newTemplateId) {
                // Prepare data for rows associated with each header
                $headers = [
                    1 => ['row_name' => $this->input->post('row_name_1'), 'row_value' => $this->input->post('row_value_1')],
                    2 => ['row_name' => $this->input->post('row_name_2'), 'row_value' => $this->input->post('row_value_2')],
                    3 => ['row_name' => $this->input->post('row_name_3'), 'row_value' => $this->input->post('row_value_3')],
                    4 => ['row_name' => $this->input->post('row_name_4'), 'row_value' => $this->input->post('row_value_4')],
                    5 => ['row_name' => $this->input->post('row_name_5'), 'row_value' => $this->input->post('row_value_5')],
                    6 => ['row_name' => $this->input->post('row_name_6'), 'row_value' => $this->input->post('row_value_6')]
                ];
    
                // Insert rows for each header into the database
                foreach ($headers as $headerId => $headerData) {
                    if (!empty($headerData['row_name'])) {
                        $rowsData = [];
    
                        // Loop through each row name and map values
                        foreach ($headerData['row_name'] as $index => $rowName) {
                            if (!empty($rowName)) {
                                $primaryValue = isset($headerData['row_value'][$index]) ? $headerData['row_value'][$index] : '';
    
                                // Prepare row data
                                $rowsData[] = [
                                    'template_id' => $newTemplateId,
                                    'header_id' => $headerId,
                                    'row_name' => $rowName,
                                    'row_value_1' => $primaryValue
                                ];
                            }
                        }
    
                        // Insert the collected rows into the database if not empty
                        if (!empty($rowsData)) {
                            $this->LabTemplateModel->insert_template_rows($rowsData);
                        }
                    }
                }
    
                // Set a success message for the session
                $this->session->set_flashdata('response', 'Template updated successfully by recreating.');
            } else {
                // Set an error message if template creation failed
                $this->session->set_flashdata('error', 'Failed to recreate the template.');
            }
    
            // Redirect to a success page or another route
            redirect('medical-test-settings/template/edit/' . $newTemplateId); // Change this to the actual success route or page
        }
    }


    public function duplicate_template($id)
    {
        // Fetch the existing template data by ID
        $template = $this->LabTemplateModel->get_template_by_id($id);

        if (!$template) {
            $this->session->set_flashdata('error', 'Template not found.');
            redirect('medical-test/all/templates');
        }

        // Prepare duplicated template data, change the name to avoid conflicts
        $duplicatedTemplateData = [
            'template_name' => $template->template_name . ' - Copy',
            'header_name_1' => $template->header_name_1,
            'header_name_2' => $template->header_name_2,
            'header_name_3' => $template->header_name_3,
            'header_name_4' => $template->header_name_4,
            'header_name_5' => $template->header_name_5,
            'header_name_6' => $template->header_name_6
        ];

        // Insert the duplicated template and get the new template ID
        $newTemplateId = $this->LabTemplateModel->store_template($duplicatedTemplateData);

        // Check if the new template was successfully created
        if ($newTemplateId) {
            // Fetch all rows associated with the original template
            $rows = $this->LabTemplateModel->get_template_rows_by_template_id($id);

            // Prepare data to insert duplicated rows
            $rowsData = [];
            foreach ($rows as $row) {
                $rowsData[] = [
                    'template_id' => $newTemplateId,
                    'header_id' => $row->header_id,
                    'row_name' => $row->row_name,
                    'row_value_1' => $row->row_value_1
                ];
            }

            // Insert duplicated rows into the new template
            if (!empty($rowsData)) {
                $this->LabTemplateModel->insert_template_rows($rowsData);
            }

            $this->session->set_flashdata('response', 'Template duplicated successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to duplicate the template.');
        }

        // Redirect to the all templates page
        redirect('medical-test/all/templates');
    }

    
}

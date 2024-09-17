<?php
    
    class MedicalTests extends CI_Controller {
        
        public function __construct () {
            parent ::__construct ();
            $this -> is_logged_in ();
            $this -> load -> model ( 'MedicalTestModel' );
            $this -> load -> model ( 'CountryModel' );
            $this -> load -> model ( 'OEPModel' );
            $this->load->model('LabTemplateModel'); 
            $this->load->library('session'); 
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
        
        public function is_logged_in () {
            if ( empty( $this -> session -> userdata ( 'user_data' ) ) ) {
                return redirect ( base_url () );
            }
        }
        

        public function index () {
            $title = site_name . ' - All Medical Tests';
            $this -> header ( $title );
            $this -> sidebar ();
            
            /**********PAGINATION***********/
            $limit                          = 25;
            $config                         = array ();
            $config[ "base_url" ]           = base_url ( '/medical-tests/index' );
            $total_row                      = $this -> MedicalTestModel -> count_tests ();
            $config[ "total_rows" ]         = $total_row;
            $config[ "per_page" ]           = $limit;
            $config[ 'use_page_numbers' ]   = false;
            $config[ 'page_query_string' ]  = TRUE;
            $config[ 'reuse_query_string' ] = TRUE;
            $config[ 'num_links' ]          = 10;
            $config[ 'cur_tag_open' ]       = '&nbsp;<a class="current">';
            $config[ 'cur_tag_close' ]      = '</a>';
            $config[ 'next_link' ]          = 'Next';
            $config[ 'prev_link' ]          = 'Previous';
            
            $this -> pagination -> initialize ( $config );
            /**********END PAGINATION***********/
            
            if ( isset( $_REQUEST[ 'per_page' ] ) and $_REQUEST[ 'per_page' ] > 0 ) {
                $offset = $_REQUEST[ 'per_page' ];
            }
            else {
                $offset = 0;
            }
            
            $data[ 'tests' ] = $this -> MedicalTestModel -> all ( $config[ "per_page" ], $offset );
            $data[ 'title' ] = 'All Medical Tests';
            $str_links       = $this -> pagination -> create_links ();
            $data[ "links" ] = explode ( '&nbsp;', $str_links );
            $data[ 'oeps' ]  = $this -> OEPModel -> all ();
            $this -> load -> view ( '/medical-tests/index', $data );
            $this -> footer ();
        }
        
        public function add () {
            $title = site_name . ' - Add Medical Tests';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'title' ]     = 'Add Medical Tests';
            $data[ 'countries' ] = $this -> CountryModel -> all ();
            $data[ 'oeps' ]      = $this -> OEPModel -> all ();
            $this -> load -> view ( '/medical-tests/add', $data );
            $this -> footer ();
        }
        
        public function add_general_info () {
            $this -> form_validation -> set_rules ( 'oep-id', 'oep-id', 'required|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'name', 'name', 'required|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'identity', 'CNIC | Passport', 'required|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'trade', 'Trade | Natl', 'required|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'dob', 'DOB', 'required|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'marital-status', 'Marital Status', 'required|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'country-id', 'Country', 'required|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'spec', 'Spec. Received', 'required|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'oep', 'OEP/Ref By', 'required|trim|min_length[1]|xss_clean' );
            
            if ( $this -> form_validation -> run () ) {
                $oep = $this -> OEPModel -> get_oep ( $this -> input -> post ( 'oep-id', true ) );
                
                $info = array (
                    'user_id'        => get_logged_in_user_id (),
                    'country_id'     => $this -> input -> post ( 'country-id', true ),
                    'nationality'    => $this -> input -> post ( 'nationality', true ),
                    'oep_id'         => $this -> input -> post ( 'oep-id', true ),
                    'mr_no'          => generateUniqueNumber (),
                    'name'           => $this -> input -> post ( 'name', true ),
                    'father_name'    => $this -> input -> post ( 'father-name', true ),
                    'lab_no_prefix'  => $oep -> prefix,
                    'lab_no'         => generate_lab_no (),
                    'identity'       => $this -> input -> post ( 'identity', true ),
                    'contact'        => $this -> input -> post ( 'contact', true ),
                    'passport'       => $this -> input -> post ( 'passport', true ),
                    'trade'          => $this -> input -> post ( 'trade', true ),
                    'dob'            => date ( 'Y-m-d', strtotime ( $this -> input -> post ( 'dob', true ) ) ),
                    'gender'         => $this -> input -> post ( 'gender', true ),
                    'marital_status' => $this -> input -> post ( 'marital-status', true ),
                    'spec_received'  => date ( 'Y-m-d H:i:s', strtotime ( $this -> input -> post ( 'spec', true ) ) ),
                    'oep'            => $this -> input -> post ( 'oep', true ),
                    'image'          => upload_files ( 'image' ),
                    'image_data'     => $this -> input -> post ( 'image-data' ),
                );
                $id   = $this -> MedicalTestModel -> add ( $info );
                if ( $id > 0 ) {
                    $this -> session -> set_flashdata ( 'response', 'Success! Medical test general information added.' );
                    return redirect ( base_url ( '/medical-tests/edit/' . $id . '?tab=general-information' ) );
                }
                else {
                    $this -> session -> set_flashdata ( 'error', 'Error! Member type not added. Please try again' );
                    return false;
                }
            }
            
            return false;
        }
        
        public function edit ( $id ) {
            $title = site_name . ' - Edit Medical Tests';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'title' ]                = 'Edit Medical Tests';
            $data[ 'countries' ]            = $this -> CountryModel -> all ();
            $data[ 'test' ]                 = $this -> MedicalTestModel -> get_medical_test ( $id );
            $data[ 'history' ]              = $this -> MedicalTestModel -> get_medical_test_history ( $id );
            $data[ 'physical_examination' ] = $this -> MedicalTestModel -> get_medical_test_physical_examination ( $id );
            $data[ 'lab_investigation' ]    = $this -> MedicalTestModel -> get_medical_test_lab_investigation ( $id );
            $data['templates'] = $this->LabTemplateModel->get_all_templates();
            $data['template_rows'] = $this->MedicalTestModel->get_template_rows_by_medical_test_id($id);
          
                //  echo "<pre>";
                // echo "Template Data:\n";
                // print_r(  $data['template_rows'] );
                // echo "</pre>";
                // exit;
            $this -> load -> view ( '/medical-tests/edit', $data );
            $this -> footer ();
        }

        public function get_template() {
            $template_id = $this->input->post('template_id');
            $template = $this->LabTemplateModel->get_template_by_id($template_id);
            $template_rows = $this->LabTemplateModel->get_template_rows_by_template_id($template_id);
        
            // Check if the template exists and respond accordingly
            if ($template) {
                // Return a JSON response with status success
                echo json_encode([
                    'status' => 'success', 
                    'template' => $template,
                    'template_rows' => $template_rows,
                    'redirect_url' => base_url('desired_redirect_page') // Add redirect URL if needed
                ]);
            } else {
                // Return an error response if template not found
                echo json_encode([
                    'status' => 'error', 
                    'message' => 'Template not found.'
                ]);
            }
        
            // Terminate further script execution to ensure clean output
            exit;
        }
        
        
        
        public function edit_general_info ( $id ) {
            $this -> form_validation -> set_rules ( 'name', 'name', 'required|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'identity', 'CNIC | Passport', 'required|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'trade', 'Trade | Natl', 'required|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'dob', 'DOB', 'required|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'marital-status', 'Marital Status', 'required|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'country-id', 'Country', 'required|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'spec', 'Spec. Received', 'required|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'oep', 'OEP/Ref By', 'required|trim|min_length[1]|xss_clean' );
            
            if ( $this -> form_validation -> run () ) {
                $image_data = $this -> input -> post ( 'image-data' );
                $info       = array (
                    'user_id'        => get_logged_in_user_id (),
                    'country_id'     => $this -> input -> post ( 'country-id', true ),
                    'nationality'    => $this -> input -> post ( 'nationality', true ),
                    'name'           => $this -> input -> post ( 'name', true ),
                    'father_name'    => $this -> input -> post ( 'father-name', true ),
                    'identity'       => $this -> input -> post ( 'identity', true ),
                    'contact'        => $this -> input -> post ( 'contact', true ),
                    'trade'          => $this -> input -> post ( 'trade', true ),
                    'passport'       => $this -> input -> post ( 'passport', true ),
                    'dob'            => date ( 'Y-m-d', strtotime ( $this -> input -> post ( 'dob', true ) ) ),
                    'gender'         => $this -> input -> post ( 'gender', true ),
                    'marital_status' => $this -> input -> post ( 'marital-status', true ),
                    'spec_received'  => date ( 'Y-m-d H:i:s', strtotime ( $this -> input -> post ( 'spec', true ) ) ),
                    'oep'            => $this -> input -> post ( 'oep', true ),
                    'fit'            => $this -> input -> post ( 'fit', true ),
                );
                
                if ( !empty( trim ( $image_data ) ) )
                    $info[ 'image_data' ] = $image_data;
                
                if ( isset( $_FILES[ 'image' ][ 'tmp_name' ] ) && !empty( trim ( $_FILES[ 'image' ][ 'tmp_name' ] ) ) )
                    $info[ 'image' ] = upload_files ( 'image' );
                
                $this -> MedicalTestModel -> edit ( $info, $id );
                $this -> session -> set_flashdata ( 'response', 'Success! Medical test general information updated.' );
                return redirect ( base_url ( '/medical-tests/edit/' . $id . '?tab=general-information' ) );
            }
            
            return false;
        }
        
        public function upsert_history ( $medical_test_id ) {
            $this -> MedicalTestModel -> delete_history ( $medical_test_id );
            $info = array (
                'user_id'                         => get_logged_in_user_id (),
                'medical_test_id'                 => $medical_test_id,
                'tuberculosis'                    => $this -> input -> post ( 'tuberculosis', true ),
                'asthma'                          => $this -> input -> post ( 'asthma', true ),
                'typhoid_fever'                   => $this -> input -> post ( 'typhoid_fever', true ),
                'ulcer'                           => $this -> input -> post ( 'ulcer', true ),
                'malaria'                         => $this -> input -> post ( 'malaria', true ),
                'surgical_procedure'              => $this -> input -> post ( 'surgical_procedure', true ),
                'psychiatric_neurology_disorders' => $this -> input -> post ( 'psychiatric_neurology_disorders', true ),
                'allergy'                         => $this -> input -> post ( 'allergy', true ),
                'diabetes'                        => $this -> input -> post ( 'diabetes', true ),
                'others'                          => $this -> input -> post ( 'others', true ),
            );
            $id   = $this -> MedicalTestModel -> upsert_history ( $info );
            if ( $id > 0 ) {
                $this -> session -> set_flashdata ( 'response', 'Success! Medical test history added.' );
                return redirect ( base_url ( '/medical-tests/edit/' . $medical_test_id . '?tab=history' ) );
            }
            else {
                $this -> session -> set_flashdata ( 'error', 'Error! Member type not added. Please try again' );
                return false;
            }
        }
        
        public function upsert_general_physical_examination ( $medical_test_id ) {
            $this -> MedicalTestModel -> delete_general_physical_examination ( $medical_test_id );
            $info = array (
                'user_id'         => get_logged_in_user_id (),
                'medical_test_id' => $medical_test_id,
                'height'          => $this -> input -> post ( 'height', true ),
                'weight'          => $this -> input -> post ( 'weight', true ),
                'vision'          => $this -> input -> post ( 'vision', true ),
                'color'           => $this -> input -> post ( 'color', true ),
                'hearing'         => $this -> input -> post ( 'hearing', true ),
                'liver'           => $this -> input -> post ( 'liver', true ),
                'skin'            => $this -> input -> post ( 'skin', true ),
                'hemorrhoids'     => $this -> input -> post ( 'hemorrhoids', true ),
                'bp'              => $this -> input -> post ( 'bp', true ),
                'pulse'           => $this -> input -> post ( 'pulse', true ),
                'heart_beat'      => $this -> input -> post ( 'heart-beat', true ),
                'lungs'           => $this -> input -> post ( 'lungs', true ),
                'abdomen'         => $this -> input -> post ( 'abdomen', true ),
                'hernia'          => $this -> input -> post ( 'hernia', true ),
                'kidneys'         => $this -> input -> post ( 'kidneys', true ),
                'varicose_veins'  => $this -> input -> post ( 'varicose-veins', true ),
                'thyroid_gland'   => $this -> input -> post ( 'thyroid-gland', true ),
            );
            $id   = $this -> MedicalTestModel -> upsert_general_physical_examination ( $info );
            if ( $id > 0 ) {
                $this -> session -> set_flashdata ( 'response', 'Success! Medical test general & physical examination added.' );
                return redirect ( base_url ( '/medical-tests/edit/' . $medical_test_id . '?tab=general-physical-examination' ) );
            }
            else {
                $this -> session -> set_flashdata ( 'error', 'Error! Member type not added. Please try again' );
                return false;
            }
        }
        
        public function add_lab_investigation ( $medical_test_id ) {
            $this -> MedicalTestModel -> delete_lab_investigation ( $medical_test_id );


                // echo "<pre>";
                // echo "Template Data:\n";
                // print_r( $this->input->post() );
                // echo "</pre>";
                // exit;

                  // Check if the form is submitted as a custom lab investigation
        $is_custom = $this->input->post('is_custom', true);

        // If the investigation is custom, save data to the custom table
        if ($is_custom == 1) {
            $this->MedicalTestModel->delete_lab_investigation_custom($medical_test_id);
            // Get the template ID from the form submission
                $template_id = $this->input->post('selected_template_id', true);
            // Gather custom data
            $headers = [];
            for ($i = 1; $i <= 6; $i++) {
                $header_name = $this->input->post("header_name_$i", true);
                $row_names = $this->input->post("row_name_$i");
                $row_values = $this->input->post("row_value_$i");

                if (!empty($header_name) && !empty($row_names) && !empty($row_values)) {
                    foreach ($row_names as $index => $row_name) {
                        // Insert each row into the custom table
                        $custom_data = [
                            'user_id' => get_logged_in_user_id(),
                            'medical_test_id' => $medical_test_id,
                            'template_id' => $template_id,
                            'header_name' => $header_name,
                            'row_name' => $row_name,
                            'row_value' => $row_values[$index],
                        ];
                        // Save to custom table
                        $this->MedicalTestModel->add_custom_lab_investigation($custom_data);
                    }
                }
            }

            // Set success message and redirect
            $this->session->set_flashdata('response', 'Success! Custom lab investigations added.');
            return redirect(base_url('/medical-tests/edit/' . $medical_test_id . '?tab=lab-investigation-custom'));
        } 
        
        else {
                $info = array (
                    'user_id'         => get_logged_in_user_id (),
                    'medical_test_id' => $medical_test_id,
                    'hb'              => $this -> input -> post ( 'hb', true ),
                    'ast'             => $this -> input -> post ( 'ast', true ),
                    'urea'            => $this -> input -> post ( 'urea', true ),
                    'bsr'             => $this -> input -> post ( 'bsr', true ),
                    'creatinine'      => $this -> input -> post ( 'creatinine', true ),
                    'bilirubin'       => $this -> input -> post ( 'bilirubin', true ),
                    'alt'             => $this -> input -> post ( 'alt', true ),
                    'anti_hcv'        => $this -> input -> post ( 'anti-hcv', true ),
                    'hbsag'           => $this -> input -> post ( 'hbsag', true ),
                    'hiv'             => $this -> input -> post ( 'hiv', true ),
                    'vdrl'            => $this -> input -> post ( 'vdrl', true ),
                    'tuberculosis'    => $this -> input -> post ( 'tuberculosis', true ),
                    'blood_group'     => $this -> input -> post ( 'blood-group', true ),
                    'ph'              => $this -> input -> post ( 'ph', true ),
                    'sugar'           => $this -> input -> post ( 'sugar', true ),
                    'albumin'         => $this -> input -> post ( 'albumin', true ),
                    'pus_cells'       => $this -> input -> post ( 'pus-cells', true ),
                    'ova_cysts'       => $this -> input -> post ( 'ova-cysts', true ),
                    'rbcs'            => $this -> input -> post ( 'rbcs', true ),
                    'amphetamine'     => $this -> input -> post ( 'amphetamine', true ),
                    'benzodiazepine'  => $this -> input -> post ( 'benzodiazepine', true ),
                    'marijuana'       => $this -> input -> post ( 'marijuana', true ),
                    'methamphetamine' => $this -> input -> post ( 'methamphetamine', true ),
                    'anti_depressant' => $this -> input -> post ( 'anti-depressant', true ),
                    'barbiturate'     => $this -> input -> post ( 'barbiturate', true ),
                    'cocaine'         => $this -> input -> post ( 'cocaine', true ),
                    'methadone'       => $this -> input -> post ( 'methadone', true ),
                    'phencyclidine'   => $this -> input -> post ( 'phencyclidine', true ),
                    'x_ray_chest'     => $this -> input -> post ( 'x-ray-chest', true ),
                );
                $id   = $this -> MedicalTestModel -> add_lab_investigation ( $info );
                if ( $id > 0 ) {
                    $this -> session -> set_flashdata ( 'response', 'Success! Medical test lab investigations added.' );
                    return redirect ( base_url ( '/medical-tests/edit/' . $medical_test_id . '?tab=lab-investigation' ) );
                }
                else {
                    $this -> session -> set_flashdata ( 'error', 'Error! Member type not added. Please try again' );
                    return false;
                }
            }
        }
        
        public function destroy ( $id ) {
            $this -> MedicalTestModel -> destroy ( $id );
            $this -> session -> set_flashdata ( 'response', 'Success! Medical test has been deleted.' );
            return redirect ( base_url ( '/medical-tests/index' ) );
        }
        
        public function status ( $id ) {
            $this -> MedicalTestModel -> status ( $id );
            $this -> session -> set_flashdata ( 'response', 'Success! Medical test status has been updated.' );
            return redirect ( base_url ( '/medical-tests/index' ) );
        }
        
        public function report () {
            $title = site_name . ' - Medical Test Report';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'tests' ] = $this -> MedicalTestModel -> filter_report ();
            $data[ 'oeps' ]  = $this -> OEPModel -> all ();
            $data[ 'title' ] = 'Medical Test Report';
            $this -> load -> view ( '/medical-tests/report', $data );
            $this -> footer ();
        }
        
        public function validate_cnic () {
            $cnic     = $this -> input -> get ( 'cnic' );
            $isExists = $this -> MedicalTestModel -> validate_cnic ( $cnic );
            echo $isExists ? 'exists' : 'false';
        }
    }
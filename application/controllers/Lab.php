<?php
    
    defined ( 'BASEPATH' ) or exit( 'No direct script access allowed' );
    
    class Lab extends CI_Controller {
        
        /**
         * -------------------------
         * Lab constructor.
         * loads helpers, modal or libraries
         * -------------------------
         */
        
        public function __construct () {
            parent ::__construct ();
            $this -> is_logged_in ();
            $this -> load -> model ( 'LabModel' );
            $this -> load -> model ( 'SampleModel' );
            $this -> load -> model ( 'SectionModel' );
            $this -> load -> model ( 'TestTubeColorModel' );
            $this -> load -> model ( 'UnitModel' );
            $this -> load -> model ( 'PanelModel' );
            $this -> load -> model ( 'LocationModel' );
            $this -> load -> model ( 'AccountModel' );
            $this -> load -> model ( 'IPDModel' );
            $this -> load -> model ( 'StoreModel' );
            $this -> load -> model ( 'SpecimenModel' );
            $this -> load -> model ( 'RemarksModel' );
            $this -> load -> model ( 'DoctorModel' );
            $this -> load -> model ( 'AirlineModel' );
            $this -> load -> model ( 'PackageModel' );
            $this -> load -> model ( 'ReferenceModel' );
        }
        
        /**
         * -------------------------
         * @param $title
         * header template
         * -------------------------
         */
        
        public function header ( $title ) {
            $data[ 'title' ] = $title;
            $this -> load -> view ( '/includes/admin/header', $data );
        }
        
        /**
         * -------------------------
         * sidebar template
         * -------------------------
         */
        
        public function sidebar () {
            $this -> load -> view ( '/includes/admin/general-sidebar' );
        }
        
        /**
         * -------------------------
         * footer template
         * -------------------------
         */
        
        public function footer () {
            $this -> load -> view ( '/includes/admin/footer' );
        }
        
        /**
         * ---------------------
         * checks if user is logged in
         * ---------------------
         */
        
        public function is_logged_in () {
            if ( empty( $this -> session -> userdata ( 'user_data' ) ) ) {
                return redirect ( base_url () );
            }
        }
        
        /**
         * -------------------------
         * Lab main page
         * -------------------------
         */
        
        public function index () {
            $title = site_name . ' - Lab Tests';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'tests' ] = $this -> LabModel -> get_parent_tests ();
            $this -> load -> view ( '/lab/index', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * Add Lab main page
         * -------------------------
         */
        
        public function add () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_add_general_test_info' )
                $this -> do_add_general_test_info ( $_POST );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_add_test_detail' )
                $this -> do_add_test_detail ( $_POST );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_add_test_reference_range' )
                $this -> do_add_test_reference_range ( $_POST );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_add_test_prices' )
                $this -> do_add_test_prices ( $_POST );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_add_test_locations' )
                $this -> do_add_test_locations ( $_POST );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_add_test_regents' )
                $this -> do_add_test_regents ( $_POST );
            
            $title = site_name . ' - Add Lab Tests';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'samples' ]      = $this -> SampleModel -> get_samples ();
            $data[ 'sections' ]     = $this -> SectionModel -> get_sections ();
            $data[ 'colors' ]       = $this -> TestTubeColorModel -> get_colors ();
            $data[ 'units' ]        = $this -> UnitModel -> get_units ();
            $data[ 'panels' ]       = $this -> PanelModel -> get_panels ();
            $data[ 'locations' ]    = $this -> LocationModel -> get_locations ();
            $data[ 'parent_tests' ] = $this -> LabModel -> get_parent_tests ();
            $data[ 'regents' ]      = $this -> LabModel -> get_regents ();
            $data[ 'lab_regents' ]  = $this -> LabModel -> get_lab_regents ( @$_GET[ 'test-id' ] );
            $this -> load -> view ( '/lab/add', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * Add more regents
         * -------------------------
         */
        
        public function add_more_regents () {
            $data[ 'row' ]     = $this -> input -> post ( 'added' );
            $data[ 'regents' ] = $this -> LabModel -> get_regents ();
            $this -> load -> view ( '/lab/add-more-regents', $data );
        }
        
        /**
         * -------------------------
         * @param $POST
         * add lab test general info
         * add lab test sample info
         * -------------------------
         */
        
        function do_add_general_test_info ( $POST ) {
            $data = $POST;
            $this -> form_validation -> set_rules ( 'code', 'code', 'required|trim|min_length[1]|is_unique[tests.code]|xss_clean' );
            $this -> form_validation -> set_rules ( 'name', 'name', 'required|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'type', 'type', 'required|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'type', 'type', 'required|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'report_title', 'report title', 'required|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'report_footer', 'report footer', 'trim' );
            $this -> form_validation -> set_rules ( 'parent_id', 'parent', 'trim|xss_clean' );
            $this -> form_validation -> set_rules ( 'sample_id', 'sample', 'numeric|required|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'quantity', 'quantity', 'required|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'color_id', 'color', 'numeric|required|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'section_id', 'section', 'numeric|required|trim|min_length[1]|xss_clean' );
            
            if ( $this -> form_validation -> run () == true ) {
                $info    = array (
                    'user_id'         => get_logged_in_user_id (),
                    'parent_id'       => ( isset( $data[ 'parent_id' ] ) ) ? $data[ 'parent_id' ] : '',
                    'code'            => $data[ 'code' ],
                    'name'            => $data[ 'name' ],
                    'type'            => $data[ 'type' ],
                    'tat'             => $data[ 'tat' ],
                    'report_title'    => $data[ 'report_title' ],
                    'report_footer'   => $data[ 'report_footer' ],
                    'default_results' => $data[ 'default-result' ],
                    'date_added'      => current_date_time (),
                );
                $test_id = $this -> LabModel -> add ( $info );
                if ( $test_id > 0 ) {
                    $sample    = array (
                        'user_id'    => get_logged_in_user_id (),
                        'test_id'    => $test_id,
                        'sample_id'  => $data[ 'sample_id' ],
                        'color_id'   => $data[ 'color_id' ],
                        'section_id' => $data[ 'section_id' ],
                        'quantity'   => $data[ 'quantity' ],
                        'date_added' => current_date_time (),
                    );
                    $sample_id = $this -> LabModel -> add_sample_info ( $sample );
                    if ( $sample_id > 0 ) {
                        return redirect ( base_url ( '/lab/add?tab=detail&test-id=' . $test_id ) );
                    }
                    else {
                        $this -> session -> set_flashdata ( 'error', 'Error! Unable to add sample info. Please try again.' );
                        return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                    }
                }
                else {
                    $this -> session -> set_flashdata ( 'error', 'Error! Unable to add test. Please try again.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
            }
        }
        
        /**
         * -------------------------
         * @param $POST
         * add lab test details
         * -------------------------
         */
        
        function do_add_test_detail ( $POST ) {
            $data = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $this -> form_validation -> set_rules ( 'protocol', 'protocol', 'trim|xss_clean' );
            $this -> form_validation -> set_rules ( 'instruction', 'instruction', 'trim|xss_clean' );
            $this -> form_validation -> set_rules ( 'methodology', 'methodology', 'trim|xss_clean' );
            $this -> form_validation -> set_rules ( 'performed_method', 'performed_method', 'trim|xss_clean' );
            $this -> form_validation -> set_rules ( 'test_id', 'test id', 'numeric|required|trim|min_length[1]|xss_clean' );
            
            if ( $this -> form_validation -> run () == true ) {
                $info      = array (
                    'user_id'          => get_logged_in_user_id (),
                    'test_id'          => $data[ 'test_id' ],
                    'protocol'         => $data[ 'protocol' ],
                    'instruction'      => $data[ 'instruction' ],
                    'methodology'      => $data[ 'methodology' ],
                    'performed_method' => $data[ 'performed_method' ],
                    'date_added'       => current_date_time (),
                );
                $detail_id = $this -> LabModel -> add_test_detail ( $info );
                if ( $detail_id > 0 ) {
                    return redirect ( base_url ( '/lab/add?tab=range&test-id=' . $data[ 'test_id' ] . '&machine=default' ) );
                }
                else {
                    $this -> session -> set_flashdata ( 'error', 'Error! Unable to add test detail. Please try again.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
            }
        }
        
        /**
         * -------------------------
         * @param $POST
         * add lab test reference range
         * -------------------------
         */
        
        function do_add_test_reference_range ( $POST ) {
            $data     = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $range_id = 0;
            $this -> form_validation -> set_rules ( 'unit_id', 'unit', 'numeric|required|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'min_value', 'minimum range', 'numeric|required|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'max_value', 'maximum range', 'numeric|required|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'test_id', 'test id', 'numeric|required|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'machine-name', 'machine name', 'trim|xss_clean' );
            
            $machine      = $this -> input -> get ( 'machine' );
            $machine_name = $this -> input -> post ( 'machine-name' );
            if ( $this -> form_validation -> run () == true ) {
                $info         = array (
                    'user_id'      => get_logged_in_user_id (),
                    'test_id'      => $data[ 'test_id' ],
                    'unit_id'      => $data[ 'unit_id' ],
                    'machine'      => $machine,
                    'machine_name' => $machine_name,
                    'date_added'   => current_date_time (),
                );
                $parameter_id = $this -> LabModel -> add_test_parameters ( $info );
                if ( $parameter_id > 0 ) {
                    $panic    = array (
                        'user_id'    => get_logged_in_user_id (),
                        'test_id'    => $data[ 'test_id' ],
                        'min_value'  => $data[ 'min_value' ],
                        'max_value'  => $data[ 'max_value' ],
                        'machine'    => $machine,
                        'date_added' => current_date_time (),
                    );
                    $panic_id = $this -> LabModel -> add_test_panic_values ( $panic );
                    if ( $panic_id > 0 ) {
                        if ( count ( $data[ 'gender' ] ) > 0 ) {
                            foreach ( $data[ 'gender' ] as $key => $value ) {
                                if ( !empty( trim ( $value ) ) ) {
                                    $range    = array (
                                        'user_id'     => get_logged_in_user_id (),
                                        'test_id'     => $data[ 'test_id' ],
                                        'gender'      => $value,
                                        'min_age'     => $data[ 'min_age' ][ $key ],
                                        'max_age'     => $data[ 'max_age' ][ $key ],
                                        'start_range' => $data[ 'start_range' ][ $key ],
                                        'end_range'   => $data[ 'end_range' ][ $key ],
                                        'machine'     => $machine,
                                        'date_added'  => current_date_time (),
                                    );
                                    $range_id = $this -> LabModel -> add_test_reference_range ( $range );
                                }
                            }
                            if ( $range_id > 0 ) {
                                if ( $machine == 'default' )
                                    return redirect ( base_url ( '/lab/add?tab=range&machine=machine-1&test-id=' . $data[ 'test_id' ] ) );
                                else if ( $machine == 'machine-1' )
                                    return redirect ( base_url ( '/lab/add?tab=range&machine=machine-2&test-id=' . $data[ 'test_id' ] ) );
                                else
                                    return redirect ( base_url ( '/lab/add?tab=accounts&test-id=' . $data[ 'test_id' ] ) );
                            }
                        }
                    }
                    else {
                        $this -> session -> set_flashdata ( 'error', 'Error! Unable to add panic value. Please try again.' );
                        return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                    }
                }
                else {
                    $this -> session -> set_flashdata ( 'error', 'Error! Unable to add parameters value. Please try again.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
            }
        }
        
        /**
         * -------------------------
         * @param $POST
         * add lab test prices details
         * -------------------------
         */
        
        function do_add_test_prices ( $POST ) {
            $data     = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $price_id = 0;
            $this -> form_validation -> set_rules ( 'test_id', 'test id', 'numeric|required|trim|min_length[1]|xss_clean' );
            
            if ( $this -> form_validation -> run () == true ) {
                if ( count ( $data[ 'panel_id' ] ) > 0 ) {
                    foreach ( $data[ 'panel_id' ] as $key => $value ) {
                        if ( !empty( trim ( $value ) ) and is_numeric ( $value ) > 0 ) {
                            $info     = array (
                                'user_id'    => get_logged_in_user_id (),
                                'test_id'    => $data[ 'test_id' ],
                                'panel_id'   => $value,
                                'price'      => $data[ 'price' ][ $key ],
                                'date_added' => current_date_time (),
                            );
                            $price_id = $this -> LabModel -> add_test_price ( $info );
                        }
                    }
                }
                if ( $price_id > 0 ) {
                    return redirect ( base_url ( '/lab/add?tab=locations&test-id=' . $data[ 'test_id' ] ) );
                }
                else {
                    $this -> session -> set_flashdata ( 'error', 'Error! Unable to add test price. Please try again.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
            }
        }
        
        /**
         * -------------------------
         * @param $POST
         * add lab test locations details
         * -------------------------
         */
        
        function do_add_test_locations ( $POST ) {
            $data        = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $location_id = 0;
            $this -> form_validation -> set_rules ( 'test_id', 'test id', 'numeric|required|trim|min_length[1]|xss_clean' );
            
            if ( $this -> form_validation -> run () == true ) {
                if ( count ( $data[ 'location_id' ] ) > 0 ) {
                    foreach ( $data[ 'location_id' ] as $key => $value ) {
                        if ( !empty( trim ( $value ) ) and is_numeric ( $value ) > 0 ) {
                            $info        = array (
                                'user_id'     => get_logged_in_user_id (),
                                'test_id'     => $data[ 'test_id' ],
                                'location_id' => $value,
                                'date_added'  => current_date_time (),
                            );
                            $location_id = $this -> LabModel -> add_test_location ( $info );
                        }
                    }
                }
                if ( $location_id > 0 ) {
                    $this -> session -> set_flashdata ( 'response', 'Success! Lab test added.' );
                    return redirect ( base_url ( '/lab/add?tab=regents&test-id=' . $data[ 'test_id' ] ) );
                }
                else {
                    $this -> session -> set_flashdata ( 'error', 'Error! Unable to add test location. Please try again.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
            }
        }
        
        /**
         * -------------------------
         * delete lab test by id
         * -------------------------
         */
        
        public function delete () {
            $test_id = $this -> uri -> segment ( 3 );
            if ( !empty( trim ( $test_id ) ) and $test_id > 0 and is_numeric ( $test_id ) ) {
                $deleted = $this -> LabModel -> delete ( $test_id );
                if ( $deleted ) {
                    $this -> session -> set_flashdata ( 'response', 'Success! Test has been deleted.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
                else {
                    $this -> session -> set_flashdata ( 'error', 'Error! Please try again.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
            }
        }
        
        /**
         * -------------------------
         * Edit Lab main page
         * -------------------------
         */
        
        public function edit () {
            $test_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $test_id ) ) or $test_id < 1 and !is_numeric ( $test_id ) )
                $test_id = $_REQUEST[ 'test-id' ];
            
            if ( empty( trim ( $test_id ) ) or $test_id < 1 and !is_numeric ( $test_id ) )
                return redirect ( base_url ( '/lab/index' ) );
            
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_edit_general_test_info' )
                $this -> do_edit_general_test_info ( $_POST );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_edit_test_detail' )
                $this -> do_edit_test_detail ( $_POST );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_edit_test_reference_range' )
                $this -> do_edit_test_reference_range ( $_POST );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_edit_test_prices' )
                $this -> do_edit_test_prices ( $_POST );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_edit_test_locations' )
                $this -> do_edit_test_locations ( $_POST );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_edit_test_regents' )
                $this -> do_edit_test_regents ( $_POST );
            
            if ( isset( $_GET[ 'action' ] ) and $_GET[ 'action' ] == 'delete-regent' )
                $this -> delete_test_regents ();
            
            $title = site_name . ' - Edit Tests';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'test_id' ]      = $test_id;
            $data[ 'samples' ]      = $this -> SampleModel -> get_samples ();
            $data[ 'sections' ]     = $this -> SectionModel -> get_sections ();
            $data[ 'colors' ]       = $this -> TestTubeColorModel -> get_colors ();
            $data[ 'units' ]        = $this -> UnitModel -> get_units ();
            $data[ 'panels' ]       = $this -> PanelModel -> get_panels ();
            $data[ 'locations' ]    = $this -> LocationModel -> get_locations ();
            $data[ 'parent_tests' ] = $this -> LabModel -> get_parent_tests ();
            $data[ 'general_info' ] = $this -> LabModel -> get_test_by_id ( $test_id );
            $data[ 'sample_info' ]  = $this -> LabModel -> get_test_sample_info ( $test_id );
            $data[ 'procedure' ]    = $this -> LabModel -> get_test_procedure_info ( $test_id );
            $data[ 'parameter' ]    = $this -> LabModel -> get_test_parameters ( $test_id );
            $data[ 'panic' ]        = $this -> LabModel -> get_test_panic_values ( $test_id );
            $data[ 'ranges' ]       = $this -> LabModel -> get_test_reference_range ( $test_id );
            $data[ 'prices' ]       = $this -> LabModel -> get_test_prices ( $test_id );
            $data[ 'lab_regents' ]  = $this -> LabModel -> get_lab_regents ( $test_id );
            $data[ 'regents' ]      = $this -> LabModel -> get_regents ();
            $this -> load -> view ( '/lab/edit', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * edit lab test general info
         * edit lab test sample info
         * -------------------------
         */
        
        function do_edit_general_test_info ( $POST ) {
            $data = $POST;
            $this -> form_validation -> set_rules ( 'code', 'code', 'required|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'name', 'name', 'required|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'type', 'type', 'required|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'type', 'type', 'required|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'report_title', 'report title', 'required|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'report_footer', 'report footer', 'trim' );
            $this -> form_validation -> set_rules ( 'parent_id', 'parent', 'trim|xss_clean' );
            $this -> form_validation -> set_rules ( 'sample_id', 'sample', 'numeric|required|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'test_id', 'test id', 'numeric|required|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'quantity', 'quantity', 'required|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'color_id', 'color', 'numeric|required|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'section_id', 'section', 'numeric|required|trim|min_length[1]|xss_clean' );
            
            if ( $this -> form_validation -> run () == true ) {
                $test_id = $data[ 'test_id' ];
                $info    = array (
                    'parent_id'       => ( isset( $data[ 'parent_id' ] ) ) ? $data[ 'parent_id' ] : '',
                    'code'            => $data[ 'code' ],
                    'name'            => $data[ 'name' ],
                    'type'            => $data[ 'type' ],
                    'tat'             => $data[ 'tat' ],
                    'report_title'    => $data[ 'report_title' ],
                    'report_footer'   => $data[ 'report_footer' ],
                    'default_results' => $data[ 'default-result' ],
                );
                
                $this -> LabModel -> edit ( $info, $test_id );
                $sample = array (
                    'sample_id'  => $data[ 'sample_id' ],
                    'color_id'   => $data[ 'color_id' ],
                    'section_id' => $data[ 'section_id' ],
                    'quantity'   => $data[ 'quantity' ]
                );
                $this -> LabModel -> edit_sample_info ( $sample, $test_id );
                $this -> session -> set_flashdata ( 'response', 'Success! General & Sample information updated.' );
                return redirect ( base_url ( '/lab/edit?tab=detail&test-id=' . $test_id ) );
            }
        }
        
        /**
         * -------------------------
         * @param $POST
         * add lab test details
         * -------------------------
         */
        
        function do_edit_test_detail ( $POST ) {
            $data = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $this -> form_validation -> set_rules ( 'test_id', 'test id', 'numeric|required|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'protocol', 'protocol', 'trim|xss_clean' );
            $this -> form_validation -> set_rules ( 'instruction', 'instruction', 'trim|xss_clean' );
            $this -> form_validation -> set_rules ( 'methodology', 'methodology', 'trim|xss_clean' );
            $this -> form_validation -> set_rules ( 'performed_method', 'performed_method', 'trim|xss_clean' );
            $this -> form_validation -> set_rules ( 'test_id', 'test id', 'numeric|required|trim|min_length[1]|xss_clean' );
            
            if ( $this -> form_validation -> run () == true ) {
                $test_id = $data[ 'test_id' ];
                $info    = array (
                    'protocol'         => $data[ 'protocol' ],
                    'instruction'      => $data[ 'instruction' ],
                    'methodology'      => $data[ 'methodology' ],
                    'performed_method' => $data[ 'performed_method' ]
                );
                $this -> LabModel -> edit_test_detail ( $info, $test_id );
                $this -> session -> set_flashdata ( 'response', 'Success! Test procedure updated.' );
                return redirect ( base_url ( '/lab/edit?tab=range&test-id=' . $test_id . '&machine=default' ) );
            }
        }
        
        /**
         * -------------------------
         * @param $POST
         * edit lab test reference range
         * -------------------------
         */
        
        function do_edit_test_reference_range ( $POST ) {
            $data = $POST;
            $this -> form_validation -> set_rules ( 'unit_id', 'unit', 'numeric|required|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'min_value', 'minimum range', 'numeric|required|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'max_value', 'maximum range', 'numeric|required|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'test_id', 'test id', 'numeric|required|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'machine-name', 'machine name', 'trim|xss_clean' );
            
            if ( $this -> form_validation -> run () == true ) {
                $test_id = $data[ 'test_id' ];
                $info    = array (
                    'user_id'      => get_logged_in_user_id (),
                    'unit_id'      => $data[ 'unit_id' ],
                    'test_id'      => $data[ 'test_id' ],
                    'machine'      => $_GET[ 'machine' ],
                    'machine_name' => $_POST[ 'machine-name' ],
                );
                $this -> LabModel -> edit_test_parameters ( $info, $test_id );
                $panic = array (
                    'user_id'   => get_logged_in_user_id (),
                    'test_id'   => $data[ 'test_id' ],
                    'min_value' => $data[ 'min_value' ],
                    'max_value' => $data[ 'max_value' ],
                    'machine'   => $_GET[ 'machine' ]
                );
                $this -> LabModel -> edit_test_panic_values ( $panic, $test_id );
                if ( count ( $data[ 'gender' ] ) > 0 ) {
                    $this -> LabModel -> delete_test_reference_range ( $test_id );
                    foreach ( $data[ 'gender' ] as $key => $value ) {
                        if ( !empty( trim ( $value ) ) ) {
                            $range = array (
                                'user_id'     => get_logged_in_user_id (),
                                'test_id'     => $data[ 'test_id' ],
                                'gender'      => $value,
                                'min_age'     => $data[ 'min_age' ][ $key ],
                                'max_age'     => $data[ 'max_age' ][ $key ],
                                'start_range' => $data[ 'start_range' ][ $key ],
                                'end_range'   => $data[ 'end_range' ][ $key ],
                                'machine'     => $_GET[ 'machine' ]
                            );
                            $this -> LabModel -> add_test_reference_range ( $range );
                        }
                    }
                    $this -> session -> set_flashdata ( 'response', 'Success! Test reference range updated.' );
                    if ( $_GET[ 'machine' ] == 'default' )
                        return redirect ( base_url ( '/lab/edit?tab=range&machine=machine-1&test-id=' . $test_id ) );
                    else if ( $_GET[ 'machine' ] == 'machine-1' )
                        return redirect ( base_url ( '/lab/edit?tab=range&machine=machine-2&test-id=' . $test_id ) );
                    else
                        return redirect ( base_url ( '/lab/edit?tab=accounts&test-id=' . $test_id ) );
                }
            }
        }
        
        /**
         * -------------------------
         * @param $POST
         * edit lab test prices details
         * -------------------------
         */
        
        function do_edit_test_prices ( $POST ) {
            $data = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $this -> form_validation -> set_rules ( 'test_id', 'test id', 'numeric|required|trim|min_length[1]|xss_clean' );
            
            if ( $this -> form_validation -> run () == true ) {
                $test_id = $data[ 'test_id' ];
                if ( count ( $data[ 'panel_id' ] ) > 0 ) {
                    $this -> LabModel -> delete_test_prices ( $test_id );
                    foreach ( $data[ 'panel_id' ] as $key => $value ) {
                        if ( !empty( trim ( $value ) ) and is_numeric ( $value ) > 0 ) {
                            $info = array (
                                'user_id'  => get_logged_in_user_id (),
                                'test_id'  => $test_id,
                                'panel_id' => $value,
                                'price'    => $data[ 'price' ][ $key ]
                            );
                            $this -> LabModel -> add_test_price ( $info, $test_id );
                        }
                    }
                }
                $this -> session -> set_flashdata ( 'response', 'Success! Test prices updated.' );
                return redirect ( base_url ( '/lab/edit?tab=locations&test-id=' . $data[ 'test_id' ] ) );
            }
        }
        
        /**
         * -------------------------
         * @param $POST
         * add lab test locations details
         * -------------------------
         */
        
        function do_edit_test_locations ( $POST ) {
            $data        = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $location_id = 0;
            $this -> form_validation -> set_rules ( 'test_id', 'test id', 'numeric|required|trim|min_length[1]|xss_clean' );
            
            if ( $this -> form_validation -> run () == true ) {
                $test_id = $data[ 'test_id' ];
                if ( count ( $data[ 'location_id' ] ) > 0 ) {
                    $this -> LabModel -> delete_test_location ( $test_id );
                    foreach ( $data[ 'location_id' ] as $key => $value ) {
                        if ( !empty( trim ( $value ) ) and is_numeric ( $value ) > 0 ) {
                            $info = array (
                                'user_id'     => get_logged_in_user_id (),
                                'test_id'     => $data[ 'test_id' ],
                                'location_id' => $value,
                            );
                            $this -> LabModel -> add_test_location ( $info );
                        }
                    }
                }
                $this -> session -> set_flashdata ( 'response', 'Success! Lab test locations updated.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
        }
        
        /**
         * -------------------------
         * @param $POST
         * add lab test locations details
         * -------------------------
         */
        
        function do_edit_test_regents ( $POST ) {
            $data = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            
            $regent_id = $data[ 'regent_id' ];
            $test_id   = $data[ 'test_id' ];
            
            if ( count ( $regent_id ) > 0 ) {
                $this -> LabModel -> delete_test_regents ( $test_id );
                foreach ( $regent_id as $key => $value ) {
                    $usable_quantity = $data[ 'usable_quantity' ][ $key ];
                    if ( !empty( trim ( $usable_quantity ) ) ) {
                        $info = array (
                            'user_id'         => get_logged_in_user_id (),
                            'test_id'         => $test_id,
                            'regent_id'       => $value,
                            'usable_quantity' => $usable_quantity,
                        );
                        $this -> LabModel -> add_test_regents ( $info );
                    }
                }
            }
            $this -> session -> set_flashdata ( 'response', 'Success! Lab test regents updated.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        /**
         * -------------------------
         * @param $POST
         * add lab test locations details
         * -------------------------
         */
        
        function do_add_test_regents ( $POST ) {
            $data = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            
            $regent_id = $data[ 'regent_id' ];
            $test_id   = $data[ 'test_id' ];
            
            if ( count ( $regent_id ) > 0 ) {
                foreach ( $regent_id as $key => $value ) {
                    $usable_quantity = $data[ 'usable_quantity' ][ $key ];
                    if ( !empty( trim ( $usable_quantity ) ) ) {
                        $info = array (
                            'user_id'         => get_logged_in_user_id (),
                            'test_id'         => $test_id,
                            'regent_id'       => $value,
                            'usable_quantity' => $usable_quantity,
                        );
                        $this -> LabModel -> add_test_regents ( $info );
                    }
                }
            }
            $this -> session -> set_flashdata ( 'response', 'Success! Lab test regents added.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        /**
         * -------------------------
         * Sub lab tests main page
         * -------------------------
         */
        
        public function sub_tests () {
            
            $test_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $test_id ) ) or $test_id < 1 and !is_numeric ( $test_id ) )
                $test_id = $_REQUEST[ 'test-id' ];
            
            $title = site_name . ' - Add Lab Tests';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'tests' ] = $this -> LabModel -> get_child_tests ( $test_id );
            $this -> load -> view ( '/lab/sub-tests', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * sale lab tests main page
         * -------------------------
         */
        
        public function sale_old () {
            //        $title = site_name . ' - Sale Lab Test';
            //        $this -> header($title);
            //        $this -> sidebar();
            //        $data['sale_id'] = get_next_sale_id();
            //        $data['tests'] = $this -> LabModel -> get_parent_tests();
            //        $this -> load -> view('/lab/sale', $data);
            //        $this -> footer();
        }
        
        /**
         * -------------------------
         * sale lab tests main page
         * -------------------------
         */
        
        public function sale () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_sale_lab_test' )
                $this -> do_sale_lab_test ();
            
            $title = site_name . ' - Sale Lab Test';
            $this -> header ( $title );
            $this -> sidebar ();
//            $data[ 'tests' ] = $this -> LabModel -> get_active_parent_tests ();
            $data[ 'specimens' ] = $this -> SpecimenModel -> get_specimen ();
            $data[ 'doctors' ]   = $this -> DoctorModel -> get_doctors ();
            $this -> load -> view ( '/lab/sale-new', $data );
            $this -> footer ();
        }
        
        public function do_sale_lab_test () {
            $this -> form_validation -> set_rules ( 'patient_id', 'patient_id', 'required|min_length[1]|numeric' );
            if ( $this -> form_validation -> run () == true ) {
                $discount       = $this -> input -> post ( 'discount', true );
                $flat_discount  = $this -> input -> post ( 'flat-discount', true );
                $tests          = $this -> input -> post ( 'test_id' );
                $patient_id     = $this -> input -> post ( 'patient_id' );
                $panel_id       = $this -> input -> post ( 'panel_id' );
                $payment_method = $this -> input -> post ( 'payment-method' );
                $paid_amount    = $this -> input -> post ( 'paid_amount' );
                $comments       = $this -> input -> post ( 'comments' );
                $reference_id   = $this -> input -> post ( 'doctor-id' );
                $patient        = get_patient ( $patient_id );
                
                if ( $panel_id > 0 ) {
                    $accHeadID = get_account_head_id_by_panel_id ( $panel_id );
                    if ( empty( $accHeadID ) ) {
                        $this -> session -> set_flashdata ( 'error', 'Alert! No account head is linked against patient panel id	.' );
                        return redirect ( base_url ( '/lab/sale' ) );
                    }
                }
                
                $total_sale = calculate_total_lab_sale ( $panel_id );
                $net_sale   = $total_sale - ( $total_sale * ( $discount / 100 ) );
                $net_sale   = $net_sale - $flat_discount;
                
                $sale    = array (
                    'user_id'            => get_logged_in_user_id (),
                    'reference_id'       => $reference_id,
                    'discount'           => $discount,
                    'flat_discount'      => $flat_discount,
                    'total'              => $net_sale,
                    'show_online_report' => $this -> input -> post ( 'show_online_report' ),
                    'type'               => 'lab',
                    'payment_method'     => $payment_method,
                    'paid_amount'        => $paid_amount,
                    'comments'           => $comments,
                    'date_sale'          => current_date_time (),
                );
                $sale_id = $this -> LabModel -> add_lab_sale ( $sale );
                
                //			if ( $patient -> type == 'cash' ) {
                $description = 'Cash from lab . Sale# ' . $sale_id;
                if ( $panel_id > 0 ) {
                    $description .= ' / ' . get_panel_by_id ( $panel_id ) -> name;
                }
                
                if ( $discount < 1 and $flat_discount < 1 ) {
                    
                    $ledger = array (
                        'user_id'          => get_logged_in_user_id (),
                        'acc_head_id'      => cash_from_lab_services,
                        'invoice_id'       => $sale_id,
                        'lab_sale_id'      => $sale_id,
                        'trans_date'       => date ( 'Y-m-d' ),
                        'payment_mode'     => 'cash',
                        'paid_via'         => 'cash',
                        'credit'           => $net_sale,
                        'debit'            => 0,
                        'transaction_type' => 'credit',
                        'description'      => $description,
                    );
                    if ( $panel_id > 0 ) {
                        $accHeadID = get_account_head_id_by_panel_id ( $panel_id ) -> id;
                        if ( $accHeadID > 0 )
                            $ledger[ 'acc_head_id' ] = $accHeadID;
                    }
                    $this -> AccountModel -> add_ledger ( $ledger );
                    
                    /***********LOGS*************/
                    
                    $log = array (
                        'user_id'      => get_logged_in_user_id (),
                        'sale_id'      => $sale_id,
                        'action'       => 'lab_sale_ledger_added',
                        'log'          => json_encode ( $ledger ),
                        'after_update' => '',
                        'date_added'   => current_date_time ()
                    );
                    $this -> load -> model ( 'LogModel' );
                    $this -> LogModel -> create_log ( 'lab_sale_logs', $log );
                    
                    /***********END LOG*************/
                    
                    $ledger[ 'acc_head_id' ] = sales_lab_services;
                    $ledger[ 'credit' ]      = 0;
                    $ledger[ 'debit' ]       = $net_sale;
                    if ( $patient -> panel_id > 0 )
                        $ledger[ 'acc_head_id' ] = sales_lab_services_panel;
                    $this -> AccountModel -> add_ledger ( $ledger );
                    
                    /***********LOGS*************/
                    
                    $log = array (
                        'user_id'      => get_logged_in_user_id (),
                        'sale_id'      => $sale_id,
                        'action'       => 'lab_sale_ledger_added',
                        'log'          => json_encode ( $ledger ),
                        'after_update' => '',
                        'date_added'   => current_date_time ()
                    );
                    $this -> load -> model ( 'LogModel' );
                    $this -> LogModel -> create_log ( 'lab_sale_logs', $log );
                    
                    /***********END LOG*************/
                    
                }
                else {
                    
                    $ledger = array (
                        'user_id'          => get_logged_in_user_id (),
                        'acc_head_id'      => cash_from_lab_services,
                        'lab_sale_id'      => $sale_id,
                        'invoice_id'       => $sale_id,
                        'trans_date'       => date ( 'Y-m-d' ),
                        'payment_mode'     => 'cash',
                        'paid_via'         => 'cash',
                        'credit'           => $net_sale,
                        'debit'            => 0,
                        'transaction_type' => 'credit',
                        'description'      => $description,
                    );
                    if ( $panel_id > 0 ) {
                        $accHeadID = get_account_head_id_by_panel_id ( $panel_id ) -> id;
                        if ( $accHeadID > 0 )
                            $ledger[ 'acc_head_id' ] = $accHeadID;
                    }
                    $this -> AccountModel -> add_ledger ( $ledger );
                    
                    /***********LOGS*************/
                    
                    $log = array (
                        'user_id'      => get_logged_in_user_id (),
                        'sale_id'      => $sale_id,
                        'action'       => 'lab_sale_ledger_added',
                        'log'          => json_encode ( $ledger ),
                        'after_update' => '',
                        'date_added'   => current_date_time ()
                    );
                    $this -> load -> model ( 'LogModel' );
                    $this -> LogModel -> create_log ( 'lab_sale_logs', $log );
                    
                    /***********END LOG*************/
                    
                    $ledger[ 'acc_head_id' ] = sales_lab_services;
                    $ledger[ 'credit' ]      = 0;
                    $ledger[ 'debit' ]       = $total_sale;
                    if ( $patient -> panel_id > 0 )
                        $ledger[ 'acc_head_id' ] = sales_lab_services_panel;
                    $this -> AccountModel -> add_ledger ( $ledger );
                    
                    /***********LOGS*************/
                    
                    $log = array (
                        'user_id'      => get_logged_in_user_id (),
                        'sale_id'      => $sale_id,
                        'action'       => 'lab_sale_ledger_added',
                        'log'          => json_encode ( $ledger ),
                        'after_update' => '',
                        'date_added'   => current_date_time ()
                    );
                    $this -> load -> model ( 'LogModel' );
                    $this -> LogModel -> create_log ( 'lab_sale_logs', $log );
                    
                    /***********END LOG*************/
                    
                    
                    $ledger[ 'acc_head_id' ] = discount_lab_services;
                    $ledger[ 'credit' ]      = $total_sale - $net_sale;
                    $ledger[ 'debit' ]       = 0;
                    if ( $patient -> panel_id > 0 )
                        $ledger[ 'acc_head_id' ] = discount_lab_services_panel;
                    $this -> AccountModel -> add_ledger ( $ledger );
                    
                    /***********LOGS*************/
                    
                    $log = array (
                        'user_id'      => get_logged_in_user_id (),
                        'sale_id'      => $sale_id,
                        'action'       => 'lab_sale_ledger_added',
                        'log'          => json_encode ( $ledger ),
                        'after_update' => '',
                        'date_added'   => current_date_time ()
                    );
                    $this -> load -> model ( 'LogModel' );
                    $this -> LogModel -> create_log ( 'lab_sale_logs', $log );
                    
                    /***********END LOG*************/
                    
                }
                
                //			}
                
                
                if ( isset( $tests ) and count ( array_filter ( $tests ) ) > 0 ) {
                    foreach ( $tests as $key => $test_id ) {
                        $test      = $this -> LabModel -> get_test_by_id ( $test_id );
                        $sub_tests = $this -> LabModel -> get_active_child_tests ( $test_id );
                        
                        $info[ 'user_id' ]    = get_logged_in_user_id ();
                        $info[ 'sale_id' ]    = $sale_id;
                        $info[ 'patient_id' ] = $patient_id;
                        $info[ 'status' ]     = '1';
                        $info[ 'date_added' ] = current_date_time ();
                        
                        if ( !empty( $test ) ) {
                            $type = $test -> type;
                            if ( $type == 'profile' or count ( $sub_tests ) > 0 ) {
                                $price = get_test_price ( $test_id, $panel_id ) -> price;
                                
                                $info[ 'test_id' ]                     = $test_id;
                                $info[ 'parent_id' ]                   = NULL;
                                $info[ 'type' ]                        = 'profile';
                                $info[ 'price' ]                       = $price;
                                $info[ 'report_collection_date_time' ] = ( isset( $_POST[ 'report-collection-date-time' ][ $key ] ) && !empty( trim ( $_POST[ 'report-collection-date-time' ][ $key ] ) ) ) ? date ( 'Y-m-d H:i:s', strtotime ( $_POST[ 'report-collection-date-time' ][ $key ] ) ) : null;
                                $this -> LabModel -> assign_test ( $info );
                                foreach ( $sub_tests as $sub_test ) {
                                    $price = 0;
                                    
                                    $info[ 'test_id' ]   = $sub_test -> id;
                                    $info[ 'parent_id' ] = $test_id;
                                    $info[ 'type' ]      = 'profile';
                                    $info[ 'price' ]     = 0;
                                    
                                    $this -> LabModel -> assign_test ( $info );
                                    
                                    /***********LOGS*************/
                                    
                                    $log = array (
                                        'user_id'      => get_logged_in_user_id (),
                                        'sale_id'      => $sale_id,
                                        'action'       => 'lab_sale_added',
                                        'log'          => json_encode ( $info ),
                                        'after_update' => '',
                                        'date_added'   => current_date_time ()
                                    );
                                    $this -> load -> model ( 'LogModel' );
                                    $this -> LogModel -> create_log ( 'lab_sale_logs', $log );
                                    
                                    /***********END LOG*************/
                                    
                                }
                            }
                            else {
                                $price = get_test_price ( $test_id, $panel_id ) -> price;
                                
                                $info[ 'test_id' ]                     = $test_id;
                                $info[ 'parent_id' ]                   = NULL;
                                $info[ 'type' ]                        = 'test';
                                $info[ 'price' ]                       = $price;
                                $info[ 'report_collection_date_time' ] = date ( 'Y-m-d H:i:s', strtotime ( $_POST[ 'report-collection-date-time' ][ $key ] ) );
                                
                                $this -> LabModel -> assign_test ( $info );
                                
                                /***********LOGS*************/
                                
                                $log = array (
                                    'user_id'      => get_logged_in_user_id (),
                                    'sale_id'      => $sale_id,
                                    'action'       => 'lab_sale_added',
                                    'log'          => json_encode ( $info ),
                                    'after_update' => '',
                                    'date_added'   => current_date_time ()
                                );
                                $this -> load -> model ( 'LogModel' );
                                $this -> LogModel -> create_log ( 'lab_sale_logs', $log );
                                
                                /***********END LOG*************/
                                
                            }
                        }
                    }
                }
                
                if ( $sale_id > 0 ) {
                    $chars    = "0123456789";
                    $password = substr ( str_shuffle ( $chars ), 0, 8 );
                    
                    $onlineInvoiceInfo = array (
                        'user_id'    => get_logged_in_user_id (),
                        'patient_id' => $patient_id,
                        'sale_id'    => $sale_id,
                        'password'   => $password,
                    );
                    $this -> LabModel -> add_online_invoice_info ( $onlineInvoiceInfo );
                }
                
                $print = '<strong><a href="' . base_url ( '/invoices/lab-sale-invoice/' . $sale_id ) . '" target="_blank">Print</a></strong>';
                
                $print .= ' <strong><a href="' . base_url ( '/invoices/ticket/' . $sale_id ) . '" target="_blank">Print Ticket</a></strong>';
                
                if ( $sale_id > 0 )
                    $this -> session -> set_flashdata ( 'response', 'Success! Lab sale has been added. ' . $print );
                else
                    $this -> session -> set_flashdata ( 'error', 'Error! Please try again.' );
                
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                
            }
        }
        
        public function do_sale_lab_package () {
            $this -> form_validation -> set_rules ( 'patient_id', 'patient_id', 'required|min_length[1]|numeric' );
            
            if ( $this -> form_validation -> run () == true ) {
                
                $packages       = $this -> input -> post ( 'package_id', true );
                $discount       = $this -> input -> post ( 'discount', true );
                $flat_discount  = $this -> input -> post ( 'flat-discount', true );
                $patient_id     = $this -> input -> post ( 'patient_id' );
                $payment_method = $this -> input -> post ( 'payment-method' );
                $paid_amount    = $this -> input -> post ( 'paid_amount' );
                $comments       = $this -> input -> post ( 'comments' );
                $reference_id   = $this -> input -> post ( 'doctor-id' );
                $patient        = get_patient ( $patient_id );
                
                $total_sale = calculate_total_package_lab_sale ();
                $net_sale   = $total_sale - ( $total_sale * ( $discount / 100 ) );
                $net_sale   = $net_sale - $flat_discount;
                
                $sale    = array (
                    'user_id'            => get_logged_in_user_id (),
                    'reference_id'       => $reference_id,
                    'discount'           => $discount,
                    'flat_discount'      => $flat_discount,
                    'total'              => $net_sale,
                    'show_online_report' => $this -> input -> post ( 'show_online_report' ),
                    'type'               => 'lab',
                    'payment_method'     => $payment_method,
                    'paid_amount'        => $paid_amount,
                    'comments'           => $comments,
                    'date_sale'          => current_date_time (),
                );
                $sale_id = $this -> LabModel -> add_lab_sale ( $sale );
                
                $description = 'Cash from lab . Sale# ' . $sale_id;
                
                if ( $discount < 1 and $flat_discount < 1 ) {
                    
                    $ledger = array (
                        'user_id'          => get_logged_in_user_id (),
                        'acc_head_id'      => cash_from_lab_services,
                        'invoice_id'       => $sale_id,
                        'lab_sale_id'      => $sale_id,
                        'trans_date'       => date ( 'Y-m-d' ),
                        'payment_mode'     => 'cash',
                        'paid_via'         => 'cash',
                        'credit'           => $net_sale,
                        'debit'            => 0,
                        'transaction_type' => 'credit',
                        'description'      => $description,
                    );
                    $this -> AccountModel -> add_ledger ( $ledger );
                    
                    /***********LOGS*************/
                    
                    $log = array (
                        'user_id'      => get_logged_in_user_id (),
                        'sale_id'      => $sale_id,
                        'action'       => 'lab_sale_ledger_added',
                        'log'          => json_encode ( $ledger ),
                        'after_update' => '',
                        'date_added'   => current_date_time ()
                    );
                    $this -> load -> model ( 'LogModel' );
                    $this -> LogModel -> create_log ( 'lab_sale_logs', $log );
                    
                    /***********END LOG*************/
                    
                    $ledger[ 'acc_head_id' ] = sales_lab_services;
                    $ledger[ 'credit' ]      = 0;
                    $ledger[ 'debit' ]       = $net_sale;
                    if ( $patient -> panel_id > 0 )
                        $ledger[ 'acc_head_id' ] = sales_lab_services_panel;
                    $this -> AccountModel -> add_ledger ( $ledger );
                    
                    /***********LOGS*************/
                    
                    $log = array (
                        'user_id'      => get_logged_in_user_id (),
                        'sale_id'      => $sale_id,
                        'action'       => 'lab_sale_ledger_added',
                        'log'          => json_encode ( $ledger ),
                        'after_update' => '',
                        'date_added'   => current_date_time ()
                    );
                    $this -> load -> model ( 'LogModel' );
                    $this -> LogModel -> create_log ( 'lab_sale_logs', $log );
                    
                    /***********END LOG*************/
                    
                }
                else {
                    
                    $ledger = array (
                        'user_id'          => get_logged_in_user_id (),
                        'acc_head_id'      => cash_from_lab_services,
                        'lab_sale_id'      => $sale_id,
                        'invoice_id'       => $sale_id,
                        'trans_date'       => date ( 'Y-m-d' ),
                        'payment_mode'     => 'cash',
                        'paid_via'         => 'cash',
                        'credit'           => $net_sale,
                        'debit'            => 0,
                        'transaction_type' => 'credit',
                        'description'      => $description,
                    );
                    $this -> AccountModel -> add_ledger ( $ledger );
                    
                    /***********LOGS*************/
                    
                    $log = array (
                        'user_id'      => get_logged_in_user_id (),
                        'sale_id'      => $sale_id,
                        'action'       => 'lab_sale_ledger_added',
                        'log'          => json_encode ( $ledger ),
                        'after_update' => '',
                        'date_added'   => current_date_time ()
                    );
                    $this -> load -> model ( 'LogModel' );
                    $this -> LogModel -> create_log ( 'lab_sale_logs', $log );
                    
                    /***********END LOG*************/
                    
                    $ledger[ 'acc_head_id' ] = sales_lab_services;
                    $ledger[ 'credit' ]      = 0;
                    $ledger[ 'debit' ]       = $total_sale;
                    if ( $patient -> panel_id > 0 )
                        $ledger[ 'acc_head_id' ] = sales_lab_services_panel;
                    $this -> AccountModel -> add_ledger ( $ledger );
                    
                    /***********LOGS*************/
                    
                    $log = array (
                        'user_id'      => get_logged_in_user_id (),
                        'sale_id'      => $sale_id,
                        'action'       => 'lab_sale_ledger_added',
                        'log'          => json_encode ( $ledger ),
                        'after_update' => '',
                        'date_added'   => current_date_time ()
                    );
                    $this -> load -> model ( 'LogModel' );
                    $this -> LogModel -> create_log ( 'lab_sale_logs', $log );
                    
                    /***********END LOG*************/
                    
                    
                    $ledger[ 'acc_head_id' ] = discount_lab_services;
                    $ledger[ 'credit' ]      = $total_sale - $net_sale;
                    $ledger[ 'debit' ]       = 0;
                    if ( $patient -> panel_id > 0 )
                        $ledger[ 'acc_head_id' ] = discount_lab_services_panel;
                    $this -> AccountModel -> add_ledger ( $ledger );
                    
                    /***********LOGS*************/
                    
                    $log = array (
                        'user_id'      => get_logged_in_user_id (),
                        'sale_id'      => $sale_id,
                        'action'       => 'lab_sale_ledger_added',
                        'log'          => json_encode ( $ledger ),
                        'after_update' => '',
                        'date_added'   => current_date_time ()
                    );
                    $this -> load -> model ( 'LogModel' );
                    $this -> LogModel -> create_log ( 'lab_sale_logs', $log );
                    
                    /***********END LOG*************/
                    
                }
                
                if ( isset( $packages ) and count ( $packages ) > 0 ) {
                    foreach ( $packages as $package_id ) {
                        $tests = $this -> PackageModel -> get_lab_package_test_ids ( $package_id );
                        if ( count ( $tests ) > 0 ) {
                            foreach ( $tests as $key => $test_id ) {
                                $test      = $this -> LabModel -> get_test_by_id ( $test_id );
                                $sub_tests = $this -> LabModel -> get_active_child_tests ( $test_id );
                                
                                $info[ 'user_id' ]    = get_logged_in_user_id ();
                                $info[ 'sale_id' ]    = $sale_id;
                                $info[ 'patient_id' ] = $patient_id;
                                $info[ 'status' ]     = '1';
                                $info[ 'date_added' ] = current_date_time ();
                                
                                if ( !empty( $test ) ) {
                                    $type = $test -> type;
                                    if ( $type == 'profile' or count ( $sub_tests ) > 0 ) {
                                        $price = get_test_price ( $test_id ) -> price;
                                        
                                        $info[ 'test_id' ]                     = $test_id;
                                        $info[ 'parent_id' ]                   = NULL;
                                        $info[ 'type' ]                        = 'profile';
                                        $info[ 'price' ]                       = $price;
                                        $info[ 'report_collection_date_time' ] = date ( 'Y-m-d H:i:s', strtotime ( $_POST[ 'report-collection-date-time' ][ $key ] ) );
                                        $this -> LabModel -> assign_test ( $info );
                                        foreach ( $sub_tests as $sub_test ) {
                                            $price = 0;
                                            
                                            $info[ 'test_id' ]   = $sub_test -> id;
                                            $info[ 'parent_id' ] = $test_id;
                                            $info[ 'type' ]      = 'profile';
                                            $info[ 'price' ]     = 0;
                                            
                                            $this -> LabModel -> assign_test ( $info );
                                            
                                            /***********LOGS*************/
                                            
                                            $log = array (
                                                'user_id'      => get_logged_in_user_id (),
                                                'sale_id'      => $sale_id,
                                                'action'       => 'lab_sale_added',
                                                'log'          => json_encode ( $info ),
                                                'after_update' => '',
                                                'date_added'   => current_date_time ()
                                            );
                                            $this -> load -> model ( 'LogModel' );
                                            $this -> LogModel -> create_log ( 'lab_sale_logs', $log );
                                            
                                            /***********END LOG*************/
                                            
                                        }
                                    }
                                    else {
                                        $price = get_test_price ( $test_id ) -> price;
                                        
                                        $info[ 'test_id' ]                     = $test_id;
                                        $info[ 'parent_id' ]                   = NULL;
                                        $info[ 'type' ]                        = 'test';
                                        $info[ 'price' ]                       = $price;
                                        $info[ 'report_collection_date_time' ] = date ( 'Y-m-d H:i:s', strtotime ( $_POST[ 'report-collection-date-time' ][ $key ] ) );
                                        
                                        $this -> LabModel -> assign_test ( $info );
                                        
                                        /***********LOGS*************/
                                        
                                        $log = array (
                                            'user_id'      => get_logged_in_user_id (),
                                            'sale_id'      => $sale_id,
                                            'action'       => 'lab_sale_added',
                                            'log'          => json_encode ( $info ),
                                            'after_update' => '',
                                            'date_added'   => current_date_time ()
                                        );
                                        $this -> load -> model ( 'LogModel' );
                                        $this -> LogModel -> create_log ( 'lab_sale_logs', $log );
                                        
                                        /***********END LOG*************/
                                        
                                    }
                                }
                            }
                        }
                    }
                }
                
                if ( $sale_id > 0 ) {
                    $chars    = "0123456789";
                    $password = substr ( str_shuffle ( $chars ), 0, 8 );
                    
                    $onlineInvoiceInfo = array (
                        'user_id'    => get_logged_in_user_id (),
                        'patient_id' => $patient_id,
                        'sale_id'    => $sale_id,
                        'password'   => $password,
                    );
                    $this -> LabModel -> add_online_invoice_info ( $onlineInvoiceInfo );
                }
                
                $print = '<strong><a href="' . base_url ( '/invoices/lab-sale-invoice/' . $sale_id ) . '" target="_blank">Print</a></strong>';
                
                $print .= ' <strong><a href="' . base_url ( '/invoices/ticket/' . $sale_id ) . '" target="_blank">Print Ticket</a></strong>';
                
                if ( $sale_id > 0 )
                    $this -> session -> set_flashdata ( 'response', 'Success! Lab sale has been added. ' . $print );
                else
                    $this -> session -> set_flashdata ( 'error', 'Error! Please try again.' );
                
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                
            }
        }
        
        /**
         * -------------------------
         * add more lab tests
         * -------------------------
         */
        
        public function add_more_lab_tests () {
            $data[ 'row' ] = $this -> input -> post ( 'added' );
            $patient_id    = $this -> input -> post ( 'patient_id' );
            if ( $patient_id > 0 )
                $panel_id = get_patient ( $patient_id ) -> panel_id;
            else
                $panel_id = 0;
            $data[ 'tests' ]    = $this -> LabModel -> get_active_parent_tests ( $panel_id );
            $data[ 'panel_id' ] = $panel_id;
            $this -> load -> view ( '/lab/add-more-lab-tests', $data );
        }
        
        /**
         * -------------------------
         * add more lab pac
         * -------------------------
         */
        
        public function add_more_lab_packages () {
            $data[ 'row' ]      = $this -> input -> post ( 'added' );
            $data[ 'packages' ] = $this -> PackageModel -> get_lab_packages ();
            $this -> load -> view ( '/lab/add-more-lab-package', $data );
        }
        
        /**
         * -------------------------
         * sale lab tests main page
         * -------------------------
         */
        
        public function sale_package () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_sale_lab_package' )
                $this -> do_sale_lab_package ();
            
            $title = site_name . ' - Sale Lab Package';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'packages' ]  = $this -> PackageModel -> get_lab_packages ();
            $data[ 'specimens' ] = $this -> SpecimenModel -> get_specimen ();
            $data[ 'doctors' ]   = $this -> DoctorModel -> get_doctors ();
            $this -> load -> view ( '/lab/sale-package', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * add complete profile tests
         * add all tests when selected as complete
         * -------------------------
         */
        
        public function add_complete_profile_test () {
            exit;
            $data       = filter_var_array ( $_POST, FILTER_SANITIZE_STRING );
            $test_id    = $data[ 'test_id' ];
            $sale_id    = $data[ 'sale_id' ];
            $patient_id = $data[ 'patient_id' ];
            if ( !empty( trim ( $test_id ) ) and is_numeric ( $test_id ) > 0 and !empty( trim ( $sale_id ) ) and is_numeric ( $sale_id ) > 0 and !empty( trim ( $patient_id ) ) and is_numeric ( $patient_id ) > 0 ) {
                
                if ( $patient_id == cash_from_lab )
                    $test = get_regular_test_price ( $test_id );
                else
                    $test = get_test_price_by_patient_type ( $test_id, $patient_id );
                
                $sale = array (
                    'id'        => $sale_id,
                    'user_id'   => get_logged_in_user_id (),
                    'discount'  => 0,
                    'total'     => 0,
                    'type'      => 'lab',
                    'date_sale' => current_date_time (),
                );
                $this -> LabModel -> add_sale ( $sale, $sale_id );
                $info = array (
                    'user_id'    => get_logged_in_user_id (),
                    'sale_id'    => $sale_id,
                    'patient_id' => $patient_id,
                    'test_id'    => $test_id,
                    'type'       => 'profile',
                    'price'      => $test -> price,
                    'date_added' => current_date_time (),
                );
                $this -> LabModel -> assign_test ( $info );
                $tests = $this -> LabModel -> get_child_tests ( $test_id );
                if ( count ( $tests ) > 0 ) {
                    foreach ( $tests as $child_test ) {
                        $info = array (
                            'user_id'    => get_logged_in_user_id (),
                            'sale_id'    => $sale_id,
                            'parent_id'  => $test_id,
                            'patient_id' => $patient_id,
                            'test_id'    => $child_test -> id,
                            'type'       => 'test',
                            'price'      => 0,
                            'date_added' => current_date_time (),
                        );
                        $this -> LabModel -> assign_test ( $info );
                    }
                }
            }
        }
        
        /**
         * -------------------------
         * add tests
         * -------------------------
         */
        
        public function add_test () {
            exit;
            $data       = filter_var_array ( $_POST, FILTER_SANITIZE_STRING );
            $test_id    = $data[ 'test_id' ];
            $sale_id    = $data[ 'sale_id' ];
            $patient_id = $data[ 'patient_id' ];
            if ( !empty( trim ( $test_id ) ) and is_numeric ( $test_id ) > 0 and !empty( trim ( $sale_id ) ) and is_numeric ( $sale_id ) > 0 and !empty( trim ( $patient_id ) ) and is_numeric ( $patient_id ) > 0 ) {
                
                if ( $patient_id == cash_from_lab )
                    $test = get_regular_test_price ( $test_id );
                else
                    $test = get_test_price_by_patient_type ( $test_id, $patient_id );
                $sale = array (
                    'id'        => $sale_id,
                    'user_id'   => get_logged_in_user_id (),
                    'discount'  => 0,
                    'total'     => 0,
                    'type'      => 'lab',
                    'date_sale' => current_date_time (),
                );
                $this -> LabModel -> add_sale ( $sale, $sale_id );
                
                /***********LOGS*************/
                
                $log = array (
                    'user_id'      => get_logged_in_user_id (),
                    'sale_id'      => $sale_id,
                    'action'       => 'lab_sale_total_added',
                    'log'          => json_encode ( $sale ),
                    'after_update' => '',
                    'date_added'   => current_date_time ()
                );
                $this -> load -> model ( 'LogModel' );
                $this -> LogModel -> create_log ( 'lab_sale_logs', $log );
                
                /***********END LOG*************/
                
                $info = array (
                    'user_id'    => get_logged_in_user_id (),
                    'sale_id'    => $sale_id,
                    'patient_id' => $patient_id,
                    'test_id'    => $test_id,
                    'type'       => 'test',
                    'price'      => $test -> price,
                    'date_added' => current_date_time (),
                );
                $this -> LabModel -> assign_test ( $info );
                
                /***********LOGS*************/
                
                $log = array (
                    'user_id'      => get_logged_in_user_id (),
                    'sale_id'      => $sale_id,
                    'action'       => 'lab_sale_added',
                    'log'          => json_encode ( $info ),
                    'after_update' => '',
                    'date_added'   => current_date_time ()
                );
                $this -> load -> model ( 'LogModel' );
                $this -> LogModel -> create_log ( 'lab_sale_logs', $log );
                
                /***********END LOG*************/
                
            }
        }
        
        /**
         * -------------------------
         * load added tests
         * by sale id
         * -------------------------
         */
        
        public function load_added_tests () {
            exit;
            $sale_id = $this -> input -> post ( 'sale_id' );
            $patient = $this -> input -> post ( 'patient' );
            if ( !empty( trim ( $sale_id ) ) and $sale_id > 0 and is_numeric ( $sale_id ) ) {
                $data[ 'patient_id' ] = $patient;
                $data[ 'sale_id' ]    = $sale_id;
                $data[ 'tests' ]      = $this -> LabModel -> get_added_tests ( $sale_id );
                $this -> load -> view ( '/lab/added-tests', $data );
            }
        }
        
        /**
         * -------------------------
         * remove tests
         * -------------------------
         */
        
        public function remove_test () {
            exit;
            $test_id = $this -> input -> post ( 'test_id' );
            if ( !empty( trim ( $test_id ) ) and $test_id > 0 and is_numeric ( $test_id ) ) {
                $this -> LabModel -> remove_test ( $test_id );
                
            }
        }
        
        /**
         * -------------------------
         * add custom test
         * -------------------------
         */
        
        public function add_custom_profile_test () {
            exit;
            $sale_id = $this -> input -> post ( 'sale_id' );
            $test_id = $this -> input -> post ( 'test_id' );
            $patient = $this -> input -> post ( 'patient' );
            if ( !empty( trim ( $sale_id ) ) and $sale_id > 0 and is_numeric ( $sale_id ) and !empty( trim ( $test_id ) ) and $test_id > 0 and is_numeric ( $test_id ) ) {
                $data[ 'tests' ]   = $this -> LabModel -> get_child_tests ( $test_id );
                $data[ 'test_id' ] = $test_id;
                $data[ 'sale_id' ] = $sale_id;
                $data[ 'patient' ] = $patient;
                $this -> load -> view ( '/lab/child-tests', $data );
            }
        }
        
        /**
         * -------------------------
         * add single test
         * -------------------------
         */
        
        public function add_single_tests () {
            exit;
            $sale_id    = $this -> input -> post ( 'sale_id' );
            $patient_id = $this -> input -> post ( 'patient_id' );
            $tests      = $this -> input -> post ( 'test_id' );
            if ( count ( $tests ) > 0 ) {
                foreach ( $tests as $test_id ) {
                    if ( $patient_id == cash_from_lab )
                        $test = get_regular_test_price ( $test_id );
                    else
                        $test = get_test_price_by_patient_type ( $test_id, $patient_id );
                    $sale = array (
                        'id'        => $sale_id,
                        'user_id'   => get_logged_in_user_id (),
                        'discount'  => 0,
                        'total'     => 0,
                        'type'      => 'lab',
                        'date_sale' => current_date_time (),
                    );
                    $this -> LabModel -> add_sale ( $sale, $sale_id );
                    $info = array (
                        'user_id'    => get_logged_in_user_id (),
                        'sale_id'    => $sale_id,
                        'patient_id' => $patient_id,
                        'test_id'    => $test_id,
                        'type'       => 'test',
                        'price'      => $test -> price,
                        'date_added' => current_date_time (),
                    );
                    $this -> LabModel -> assign_test ( $info );
                }
            }
        }
        
        /**
         * -------------------------
         * update lab sale
         * print invoice
         * -------------------------
         */
        
        public function update_lab_sale () {
            $sale_id     = $this -> input -> post ( 'sale_id' );
            $discount    = $this -> input -> post ( 'discount' );
            $total_price = $this -> input -> post ( 'total_price' );
            $patient_id  = $this -> input -> post ( 'patient_id' );
            $patient     = get_patient ( $patient_id );
            if ( is_numeric ( $sale_id ) > 0 and is_numeric ( $discount ) > 0 and is_numeric ( $total_price ) > 0 ) {
                $info  = array (
                    'discount' => $discount,
                    'total'    => $total_price
                );
                $where = array (
                    'id' => $sale_id
                );
                $this -> LabModel -> update_lab_sale ( $info, $where );
                
                //$this -> LabModel -> update_test_status($sale_id);
                
                /***********LOGS*************/
                
                $log = array (
                    'user_id'      => get_logged_in_user_id (),
                    'sale_id'      => $sale_id,
                    'action'       => 'lab_sale_total_updated',
                    'log'          => ' ',
                    'after_update' => json_encode ( $info ),
                    'date_added'   => current_date_time ()
                );
                $this -> load -> model ( 'LogModel' );
                $this -> LogModel -> create_log ( 'lab_sale_logs', $log );
                
                /***********END LOG*************/
                
                if ( $patient -> type == 'cash' ) {
                    $ledger = array (
                        'user_id'          => get_logged_in_user_id (),
                        'acc_head_id'      => cash_from_lab,
                        'lab_sale_id'      => $sale_id,
                        'trans_date'       => date ( 'Y-m-d' ),
                        'payment_mode'     => 'cash',
                        'paid_via'         => 'cash',
                        'credit'           => $total_price,
                        'debit'            => 0,
                        'transaction_type' => 'credit',
                        'description'      => 'Cash from lab. Sale# ' . $sale_id,
                    );
                    $this -> AccountModel -> add_ledger ( $ledger );
                    
                    /***********LOGS*************/
                    
                    $log = array (
                        'user_id'      => get_logged_in_user_id (),
                        'sale_id'      => $sale_id,
                        'action'       => 'lab_sale_ledger_added',
                        'log'          => json_encode ( $ledger ),
                        'after_update' => '',
                        'date_added'   => current_date_time ()
                    );
                    $this -> load -> model ( 'LogModel' );
                    $this -> LogModel -> create_log ( 'lab_sale_logs', $log );
                    
                    /***********END LOG*************/
                    
                }
            }
        }
        
        /**
         * -------------------------
         * sales lab tests main page
         * -------------------------
         */
        
        public function sales () {
            $title = site_name . ' - Sales Lab Test (Cash)';
            $this -> header ( $title );
            $this -> sidebar ();
            
            /**********PAGINATION***********/
            $limit                          = 10;
            $config                         = array ();
            $config[ "base_url" ]           = base_url ( 'lab/sales' );
            $total_row                      = $this -> LabModel -> count_sales ();
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
            
            $data[ 'sales' ] = $this -> LabModel -> get_sales_by_sale_id ( false, $config[ "per_page" ], $offset );
            $str_links       = $this -> pagination -> create_links ();
            $data[ "links" ] = explode ( '&nbsp;', $str_links );
            $this -> load -> view ( '/lab/sales', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * sales lab tests main page
         * -------------------------
         */
        
        public function sales_panel () {
            $title = site_name . ' - Sales Lab Test (Panel)';
            $this -> header ( $title );
            $this -> sidebar ();
            /**********PAGINATION***********/
            $limit                          = 10;
            $config                         = array ();
            $config[ "base_url" ]           = base_url ( 'lab/sales-panel' );
            $total_row                      = $this -> LabModel -> count_sales ( true );
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
            
            $data[ 'sales' ] = $this -> LabModel -> get_sales_by_sale_id ( true, $config[ "per_page" ], $offset );
            $str_links       = $this -> pagination -> create_links ();
            $data[ "links" ] = explode ( '&nbsp;', $str_links );
            $this -> load -> view ( '/lab/sales', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * delete sale test by id
         * -------------------------
         */
        
        public function delete_sale () {
            $sale_id = $this -> uri -> segment ( 3 );
            if ( !empty( trim ( $sale_id ) ) and $sale_id > 0 and is_numeric ( $sale_id ) ) {
                $deleted = $this -> LabModel -> delete_sale ( $sale_id );
                if ( $deleted ) {
                    $this -> AccountModel -> delete_lab_sale ( $sale_id );
                    
                    /***********LOGS*************/
                    
                    $log = array (
                        'user_id'      => get_logged_in_user_id (),
                        'sale_id'      => $sale_id,
                        'action'       => 'lab_sale_deleted',
                        'log'          => json_encode ( $sale_id ),
                        'after_update' => '',
                        'date_added'   => current_date_time ()
                    );
                    $this -> load -> model ( 'LogModel' );
                    $this -> LogModel -> create_log ( 'lab_sale_logs', $log );
                    
                    /***********END LOG*************/
                    
                    $this -> session -> set_flashdata ( 'response', 'Success! Sale has been deleted.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
                else {
                    $this -> session -> set_flashdata ( 'error', 'Error! Please try again.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
            }
        }
        
        /**
         * -------------------------
         * edit sales lab tests main page
         * -------------------------
         */
        
        public function edit_sale () {
            $sale_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $sale_id ) ) or $sale_id < 1 or !is_numeric ( $sale_id ) )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $title = site_name . ' - Sales Lab Test';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'sales' ] = $this -> LabModel -> get_sale_by_sale_id ( $sale_id );
            $this -> load -> view ( '/lab/edit-sale', $data );
            $this -> footer ();
        }
        
        public function edit_reference ( $id ) {
            
            if ( $this -> input -> post ( 'action' ) == 'do_edit_sale_reference' )
                $this -> do_edit_sale_reference ();
            
            $title = site_name . ' - Edit Reference';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'sale' ]    = $this -> LabModel -> get_sale_by_id ( $id );
            $data[ 'doctors' ] = $this -> DoctorModel -> get_doctors ();
            $this -> load -> view ( '/lab/edit-reference', $data );
            $this -> footer ();
        }
        
        public function do_edit_sale_reference () {
            $id           = $this -> input -> post ( 'id' );
            $reference_id = $this -> input -> post ( 'reference-id' );
            
            if ( $id > 0 ) {
                $where = array (
                    'id' => $id,
                );
                $info  = array (
                    'reference_id' => $reference_id,
                );
                $this -> LabModel -> edit_sale ( $info, $where );
                $this -> session -> set_flashdata ( 'response', 'Success! Reference has been updated.' );
            }
            else
                $this -> session -> set_flashdata ( 'error', 'Error! No sale id exists.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        /**
         * -------------------------
         * edit sales lab tests main page
         * -------------------------
         */
        
        public function search_sale () {
            $sale_id = @$_REQUEST[ 'sale_id' ];
            $title   = site_name . ' - Edit Lab Test';
            $this -> header ( $title );
            $this -> sidebar ();
            if ( empty( trim ( $sale_id ) ) or $sale_id < 1 or !is_numeric ( $sale_id ) )
                $data[ 'sales' ] = array ();
            else
                $data[ 'sales' ] = $this -> LabModel -> get_sale_by_sale_id ( $sale_id );
            $this -> load -> view ( '/lab/search-sale', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * add lab test results
         * search by invoice or date
         * -------------------------
         */
        
        public function add_results () {
            
            if ( isset( $_POST[ 'print_selected' ] ) and $_POST[ 'print_selected' ] == '1' )
                $this -> print_selected ( $_POST );
            
            $title = site_name . ' - Add Test Results';
            $this -> header ( $title );
            $this -> sidebar ();
            if ( ( isset( $_REQUEST[ 'invoice_id' ] ) and !empty( trim ( $_REQUEST[ 'invoice_id' ] ) ) ) or ( isset( $_REQUEST[ 'date' ] ) and !empty( trim ( $_REQUEST[ 'date' ] ) ) ) )
                $data[ 'sales' ] = $this -> LabModel -> get_sale_parent_tests ();
            else
                $data[ 'sales' ] = array ();
            $this -> load -> view ( '/lab/add-results-new', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * add lab test airline details
         * -------------------------
         */
        
        public function airline_details () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'add_airline_details' )
                $this -> add_airline_details ();
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'edit_airline_details' )
                $this -> edit_airline_details ();
            
            $title = site_name . ' - Add Airline Details';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'airlines' ] = $this -> AirlineModel -> get_airlines ();
            $data[ 'travel' ]   = $this -> LabModel -> get_travel_details ( $_GET[ 'sale-id' ] );
            $this -> load -> view ( '/lab/add-airline-details', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * add lab test results
         * search by invoice or date
         * -------------------------
         */
        
        public function add_result () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_add_test_results' )
                $this -> do_add_test_results ( $_POST );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_lab_result_verify' )
                $this -> do_lab_result_verify ();
            
            $title = site_name . ' - Add Test Results';
            $this -> header ( $title );
            $this -> sidebar ();
            if ( !isset( $_REQUEST[ 'sale-id' ] ) or empty( trim ( $_REQUEST[ 'sale-id' ] ) ) )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $data[ 'sales' ]   = $this -> LabModel -> get_sale_tests_by_parent ();
            $data[ 'remarks' ] = $this -> RemarksModel -> get_remarks ();
            $data[ 'doctors' ] = $this -> DoctorModel -> get_doctors ();
            $this -> load -> view ( '/lab/add-results', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * add lab test results
         * search by invoice or date
         * -------------------------
         */
        
        public function add_ipd_result () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_add_ipd_test_results' )
                $this -> do_add_ipd_test_results ( $_POST );
            
            $title = site_name . ' - Add IPD Test Results';
            $this -> header ( $title );
            $this -> sidebar ();
            if ( !isset( $_REQUEST[ 'sale-id' ] ) or empty( trim ( $_REQUEST[ 'sale-id' ] ) ) )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $data[ 'sales' ] = $this -> IPDModel -> get_sale_tests_by_parent ();
            $this -> load -> view ( '/lab/add-ipd-results', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * do add test results
         * -------------------------
         */
        
        public function print_selected ( $POST ) {
            $data     = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $selected = @$data[ 'selected' ];
            
            if ( isset( $selected ) and count ( $selected ) > 0 ) {
                $selectedID = implode ( ',', $selected );
                return redirect ( base_url ( '/invoices/test-result-invoice/' . @$_REQUEST[ 'invoice_id' ] . '?selected=' . $selectedID ) );
            }
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        /**
         * -------------------------
         * @param $POST
         * do add test results
         * -------------------------
         */
        
        public function do_add_test_results ( $POST ) {
            $data              = $POST;
            $test_id           = $data[ 'test_id' ];
            $result            = $data[ 'result' ];
            $regents           = $data[ 'regents' ];
            $remarks           = $data[ 'remarks' ];
            $selected          = @$data[ 'selected' ];
            $result_id         = $data[ 'result_id' ];
            $parent_test_id    = $data[ 'parent_test_id' ];
            $machine           = $data[ 'machine' ];
            $doctor_id         = $data[ 'doctor_id' ];
            $last_insert_id    = 0;
            $hide_prev_results = ( isset( $data[ 'hide-previous-results' ] ) && $data[ 'hide-previous-results' ] === '1' ) ? '1' : '0';
            $abnormal          = $data[ 'abnormal' ];
            
            if ( isset( $selected ) and count ( $selected ) > 0 ) {
                $selectedID = implode ( ',', $selected );
                return redirect ( base_url ( '/invoices/test-result-invoice/' . @$_REQUEST[ 'invoice_id' ] . '?selected=' . $selectedID ) );
            }
            
            if ( count ( $test_id ) > 0 ) {
                $this -> LabModel -> delete_results ( $data[ 'invoice_id' ], $result_id, $parent_test_id );
                
                foreach ( $test_id as $key => $value ) {
                    $isTestChild  = check_if_test_is_child ( $value );
                    $isTestParent = check_if_test_has_sub_tests ( $value );
                    $info         = array (
                        'user_id'               => get_logged_in_user_id (),
                        'sale_id'               => $_REQUEST[ 'invoice_id' ],
                        'test_id'               => $value,
                        'machine'               => $machine,
                        'doctor_id'             => $doctor_id,
                        'regents'               => @$regents[ $key ],
                        'result'                => $result[ $key ],
                        'remarks'               => $remarks[ $key ],
                        'abnormal'              => isset( $abnormal[ $value ] ) ? '1' : '0',
                        'hide_previous_results' => $hide_prev_results,
                        'date_added'            => current_date_time (),
                    );
                    
                    if ( $isTestChild and $last_insert_id > 0 )
                        $info[ 'result_id' ] = $last_insert_id;
                    $last_id = $this -> LabModel -> do_add_test_results ( $info );
                    if ( $isTestParent )
                        $last_insert_id = $last_id;
                    
                    $this -> LabModel -> delete_result_remarks ( $data[ 'invoice_id' ], $value );
                    
                    $preRemarks = @$_POST[ 'predefined_remarks' ][ $value ];
                    if ( isset( $preRemarks ) and count ( $preRemarks ) > 0 ) {
                        foreach ( $preRemarks as $remark ) {
                            if ( !empty( trim ( $remark ) ) ) {
                                $remarksInfo = array (
                                    'user_id'    => get_logged_in_user_id (),
                                    'sale_id'    => $_REQUEST[ 'invoice_id' ],
                                    'remarks_id' => $remark,
                                    'test_id'    => $value,
                                );
                                $this -> LabModel -> do_add_test_result_remarks ( $remarksInfo );
                            }
                        }
                    }
                    
                    /***********LOGS*************/
                    
                    $log = array (
                        'user_id'      => get_logged_in_user_id (),
                        'sale_id'      => $_REQUEST[ 'invoice_id' ],
                        'action'       => 'lab_sale_results_added',
                        'log'          => json_encode ( $info ),
                        'after_update' => '',
                        'date_added'   => current_date_time ()
                    );
                    $this -> load -> model ( 'LogModel' );
                    $this -> LogModel -> create_log ( 'lab_sale_logs', $log );
                    
                    /***********END LOG*************/
                    
                }
                
                $patient_id = get_patient_id_by_sale_id ( $_REQUEST[ 'invoice_id' ] );
                if ( !empty( $patient_id ) and $patient_id > 0 ) {
                    $patient = get_patient ( $patient_id );
                    $number  = $patient -> mobile;
                    if ( !empty( trim ( $number ) ) )
                        send_report_ready_message ( $number, $patient -> name );
                }
                $this -> session -> set_flashdata ( 'response', 'Success! Results has been added.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
        }
        
        /**
         * -------------------------
         * @param $POST
         * do verify test results
         * -------------------------
         */
        
        public function do_lab_result_verify () {
            $sale_id   = $this -> input -> post ( 'invoice_id' );
            $result_id = $this -> input -> post ( 'result_id' );
            
            $this -> LabModel -> delete_lab_result_verify ( $sale_id, $result_id );
            if ( $sale_id > 0 and $result_id > 0 ) {
                $info = array (
                    'user_id'    => get_logged_in_user_id (),
                    'sale_id'    => $sale_id,
                    'result_id'  => $result_id,
                    'created_at' => current_date_time (),
                );
                $this -> LabModel -> do_lab_result_verify ( $info );
                $this -> session -> set_flashdata ( 'response', 'Success! Results has been verified.' );
            }
            else
                $this -> session -> set_flashdata ( 'error', 'Error! Results not verified.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        /**
         * -------------------------
         * add travel details
         * -------------------------
         */
        
        public function add_airline_details () {
            $sale_id      = $this -> input -> post ( 'sale-id' );
            $flight_no    = $this -> input -> post ( 'flight_no' );
            $airline_id   = $this -> input -> post ( 'airline-id' );
            $destination  = $this -> input -> post ( 'destination' );
            $flight_date  = $this -> input -> post ( 'flight_date' );
            $pnr          = $this -> input -> post ( 'pnr' );
            $ticket_no    = $this -> input -> post ( 'ticket_no' );
            $ref_by       = $this -> input -> post ( 'ref_by' );
            $show_picture = $this -> input -> post ( 'show_picture' );
            
            if ( $sale_id > 0 ) {
                $info = array (
                    'user_id'      => get_logged_in_user_id (),
                    'lab_sale_id'  => $sale_id,
                    'airline_id'   => $airline_id,
                    'flight_no'    => $flight_no,
                    'destination'  => $destination,
                    'flight_date'  => date ( 'Y-m-d H:i:s', strtotime ( $flight_date ) ),
                    'pnr'          => $pnr,
                    'ticket_no'    => $ticket_no,
                    'ref_by'       => $ref_by,
                    'show_picture' => $show_picture,
                );
                $this -> LabModel -> add_airline_details ( $info );
                $this -> session -> set_flashdata ( 'response', 'Success! Airline details has been added.' );
            }
            else
                $this -> session -> set_flashdata ( 'error', 'Error! No sale id exists.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        /**
         * -------------------------
         * edit travel details
         * -------------------------
         */
        
        public function edit_airline_details () {
            $sale_id      = $this -> input -> post ( 'sale-id' );
            $flight_no    = $this -> input -> post ( 'flight_no' );
            $airline_id   = $this -> input -> post ( 'airline-id' );
            $destination  = $this -> input -> post ( 'destination' );
            $flight_date  = $this -> input -> post ( 'flight_date' );
            $pnr          = $this -> input -> post ( 'pnr' );
            $ticket_no    = $this -> input -> post ( 'ticket_no' );
            $ref_by       = $this -> input -> post ( 'ref_by' );
            $show_picture = $this -> input -> post ( 'show_picture' );
            
            if ( $sale_id > 0 ) {
                $where = array (
                    'lab_sale_id' => $sale_id,
                );
                $info  = array (
                    'flight_no'    => $flight_no,
                    'airline_id'   => $airline_id,
                    'destination'  => $destination,
                    'flight_date'  => date ( 'Y-m-d H:i:s', strtotime ( $flight_date ) ),
                    'pnr'          => $pnr,
                    'ticket_no'    => $ticket_no,
                    'ref_by'       => $ref_by,
                    'show_picture' => $show_picture,
                );
                $this -> LabModel -> edit_airline_details ( $info, $where );
                $this -> session -> set_flashdata ( 'response', 'Success! Airline details has been updated.' );
            }
            else
                $this -> session -> set_flashdata ( 'error', 'Error! No sale id exists.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        /**
         * -------------------------
         * @param $POST
         * do add test results
         * -------------------------
         */
        
        public function do_add_ipd_test_results ( $POST ) {
            $data           = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $test_id        = $data[ 'test_id' ];
            $result         = $data[ 'result' ];
            $regents        = $data[ 'regents' ];
            $remarks        = $data[ 'remarks' ];
            $selected       = @$data[ 'selected' ];
            $result_id      = $data[ 'result_id' ];
            $parent_test_id = $data[ 'parent_test_id' ];
            $sale_table_id  = $data[ 'sale_table_id' ];
            $last_insert_id = 0;
            
            if ( isset( $selected ) and count ( $selected ) > 0 ) {
                $selectedID = implode ( ',', $selected );
                return redirect ( base_url ( '/invoices/test-result-invoice/' . @$_REQUEST[ 'invoice_id' ] . '?selected=' . $selectedID ) );
            }
            
            if ( count ( $test_id ) > 0 ) {
                $this -> IPDModel -> delete_ipd_results_associated_by_sale_table_id ( $data[ 'invoice_id' ], $result_id, $sale_table_id );
                foreach ( $test_id as $key => $value ) {
                    $isTestChild  = check_if_test_is_child ( $value );
                    $isTestParent = check_if_test_has_sub_tests ( $value );
                    $info         = array (
                        'user_id'       => get_logged_in_user_id (),
                        'sale_id'       => $_REQUEST[ 'invoice_id' ],
                        'test_id'       => $value,
                        'sale_table_id' => $sale_table_id,
                        'regents'       => @$regents[ $key ],
                        'result'        => $result[ $key ],
                        'remarks'       => $remarks[ $key ],
                        'date_added'    => current_date_time (),
                    );
                    if ( $isTestChild and $last_insert_id > 0 )
                        $info[ 'result_id' ] = $last_insert_id;
                    $last_id = $this -> IPDModel -> do_add_test_results ( $info );
                    if ( $isTestParent )
                        $last_insert_id = $last_id;
                    
                    /***********LOGS*************/
                    
                    $log = array (
                        'user_id'      => get_logged_in_user_id (),
                        'sale_id'      => $_REQUEST[ 'invoice_id' ],
                        'action'       => 'ipd_lab_sale_results_added',
                        'log'          => json_encode ( $info ),
                        'after_update' => '',
                        'date_added'   => current_date_time ()
                    );
                    $this -> load -> model ( 'LogModel' );
                    $this -> LogModel -> create_log ( 'lab_sale_logs', $log );
                    
                    /***********END LOG*************/
                    
                }
                $this -> session -> set_flashdata ( 'response', 'Success! Results has been added.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
        }
        
        /**
         * -------------------------
         * delete sale by sale id
         * delete ledger by sale id
         * -------------------------
         */
        
        public function delete_lab_sale () {
            $sale_id = $this -> input -> post ( 'sale_id' );
            $this -> LabModel -> delete_sale ( $sale_id );
            $this -> LabModel -> delete_sale_ledger ( $sale_id );
            
            /***********LOGS*************/
            
            $log = array (
                'user_id'      => get_logged_in_user_id (),
                'sale_id'      => $sale_id,
                'action'       => 'lab_sale_deleted',
                'log'          => json_encode ( $sale_id ),
                'after_update' => '',
                'date_added'   => current_date_time ()
            );
            $this -> load -> model ( 'LogModel' );
            $this -> LogModel -> create_log ( 'lab_sale_logs', $log );
            
            /***********END LOG*************/
            
        }
        
        /**
         * -------------------------
         * delete sale individual test by id
         * -------------------------
         */
        
        public function delete_lab_sale_test () {
            $test_id = $this -> uri -> segment ( 3 );
            $sale_id = $this -> uri -> segment ( 4 );
            if ( !empty( trim ( $test_id ) ) and $test_id > 0 and is_numeric ( $test_id ) and !empty( trim ( $sale_id ) ) and $sale_id > 0 and is_numeric ( $sale_id ) ) {
                $test    = $this -> LabModel -> get_sold_test_price ( $test_id, $sale_id );
                $price   = $test -> price;
                $deleted = $this -> LabModel -> delete_lab_sale_test ( $test_id, $sale_id );
                if ( $deleted ) {
                    $this -> LabModel -> update_general_ledger ( $sale_id, $price );
                    $this -> LabModel -> update_general_sale ( $sale_id, $price );
                    $this -> session -> set_flashdata ( 'response', 'Success! Test has been deleted.' );
                    
                    /***********LOGS*************/
                    
                    $log = array (
                        'user_id'      => get_logged_in_user_id (),
                        'sale_id'      => $sale_id,
                        'action'       => 'lab_sale_deleted',
                        'log'          => json_encode ( $sale_id ),
                        'after_update' => '',
                        'date_added'   => current_date_time ()
                    );
                    $this -> load -> model ( 'LogModel' );
                    $this -> LogModel -> create_log ( 'lab_sale_logs', $log );
                    
                    /***********END LOG*************/
                    
                    /***********LOGS*************/
                    
                    $log = array (
                        'user_id'      => get_logged_in_user_id (),
                        'sale_id'      => $sale_id,
                        'action'       => 'lab_sale_ledger_updated',
                        'log'          => ' ',
                        'after_update' => json_encode ( $price ),
                        'date_added'   => current_date_time ()
                    );
                    $this -> load -> model ( 'LogModel' );
                    $this -> LogModel -> create_log ( 'lab_sale_logs', $log );
                    
                    /***********END LOG*************/
                    
                    /***********LOGS*************/
                    
                    $log = array (
                        'user_id'      => get_logged_in_user_id (),
                        'sale_id'      => $sale_id,
                        'action'       => 'lab_sale_total_updated',
                        'log'          => ' ',
                        'after_update' => json_encode ( $price ),
                        'date_added'   => current_date_time ()
                    );
                    $this -> load -> model ( 'LogModel' );
                    $this -> LogModel -> create_log ( 'lab_sale_logs', $log );
                    
                    /***********END LOG*************/
                    
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
                else {
                    $this -> session -> set_flashdata ( 'error', 'Error! Please try again.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
            }
        }
        
        /**
         * -------------------------
         * do refund sale
         * -------------------------
         */
        
        public function refund () {
            $sale_id = $this -> uri -> segment ( 3 );
            if ( !$sale_id or !is_numeric ( $sale_id ) or $sale_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_refund_lab' )
                $this -> do_refund_lab ( $_POST );
            
            $title = site_name . ' - Refund Lab';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'lab' ]       = $this -> LabModel -> get_lab_sale ( $sale_id );
            $data[ 'lab_total' ] = $this -> LabModel -> get_lab_sales_total_by_sale_id ( $sale_id );
            $patient_id          = $this -> LabModel -> get_patient_id_by_sale_id ( $sale_id );
            $panel_id            = get_patient ( $patient_id ) -> panel_id;
            
            if ( is_lab_invoice_already_refunded ( $sale_id ) ) {
                if ( $panel_id > 0 )
                    return redirect ( base_url ( '/lab/sales-panel' ) );
                else
                    return redirect ( base_url ( '/lab/sales' ) );
            }
            
            if ( $panel_id > 0 )
                $data[ 'panel' ] = ' / ' . get_panel_by_id ( $panel_id ) -> name;
            else
                $data[ 'panel' ] = '';
            $data[ 'lab_sales_total' ] = get_lab_sales_total ( $sale_id );
            $this -> load -> view ( '/lab/refund', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * do refund sale
         * -------------------------
         */
        
        public function do_refund_lab () {
            $sale_id                 = $this -> input -> post ( 'sale_id' );
            $amount_paid_to_customer = $this -> input -> post ( 'amount_paid_to_customer' );
            $description             = $this -> input -> post ( 'description' );
            $discount                = $this -> input -> post ( 'discount' );
            $net_bill                = $this -> input -> post ( 'net_bill' );
            
            if ( !$sale_id or !is_numeric ( $sale_id ) or $sale_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $lab_sale   = (array)$this -> LabModel -> get_lab_sale ( $sale_id );
            $lab_sales  = (array)$this -> LabModel -> get_lab_sales_by_sale_id ( $sale_id );
            $ledger     = (array)$this -> AccountModel -> get_lab_sales_ledger_by_sale_id ( $sale_id );
            $date_added = date ( 'Y-m-d', strtotime ( $_POST[ 'date_added' ] ) ) . ' ' . date ( 'H:i:s' );
            $accHeadID  = 0;
            
            array_shift ( $lab_sale );
            array_shift ( $ledger );
            
            $lab_sale[ 'total' ] = -$amount_paid_to_customer;
            if ( $discount > 0 ) {
                $lab_sale[ 'total' ] = -$net_bill;
            }
            $lab_sale[ 'date_sale' ] = $date_added;
            $sale                    = $this -> LabModel -> add_lab_sale ( $lab_sale );
            
            if ( $sale > 0 ) {
                if ( count ( $lab_sales ) > 0 ) {
                    $patient_id = $lab_sales[ 0 ] -> patient_id;
                    if ( $patient_id > 0 ) {
                        $patient  = get_patient ( $patient_id );
                        $panel_id = $patient -> panel_id;
                        if ( $panel_id > 0 )
                            $accHeadID = get_account_head_id_by_panel_id ( $panel_id ) -> id;
                        else
                            $accHeadID = 0;
                    }
                    else {
                        $accHeadID = 0;
                    }
                    foreach ( $lab_sales as $lab_sale ) {
                        $s = (array)$lab_sale;
                        array_shift ( $s );
                        $s[ 'refunded' ]   = 1;
                        $s[ 'sale_id' ]    = $sale;
                        $s[ 'price' ]      = -$s[ 'price' ];
                        $s[ 'remarks' ]    = $description;
                        $s[ 'date_added' ] = $date_added;
                        //					if ( $discount > 0 ) {
                        //						$s[ 'price' ] = -$s[ 'price' ];
                        //					}
                        $this -> LabModel -> assign_test ( $s );
                    }
                }
                
                $this -> LabModel -> set_refunded_to_1 ( $sale_id );
                
                $ledger = array (
                    'user_id'          => get_logged_in_user_id (),
                    'acc_head_id'      => cash_from_lab_services,
                    'invoice_id'       => $sale,
                    'lab_sale_id'      => $sale,
                    'trans_date'       => date ( 'Y-m-d' ),
                    'payment_mode'     => 'cash',
                    'paid_via'         => 'cash',
                    'credit'           => 0,
                    'debit'            => $amount_paid_to_customer,
                    'transaction_type' => 'debit',
                    'description'      => $description,
                );
                if ( $discount > 0 ) {
                    $ledger[ 'debit' ] = $net_bill;
                }
                if ( $accHeadID > 0 ) {
                    $ledger[ 'acc_head_id' ] = $accHeadID;
                }
                $this -> AccountModel -> add_ledger ( $ledger );
                
                $ledger[ 'acc_head_id' ] = sales_lab_services;
                if ( $accHeadID > 0 ) {
                    $ledger[ 'acc_head_id' ] = sales_lab_services_panel;
                    $ledger[ 'description' ] = $description;
                }
                $ledger[ 'credit' ] = $amount_paid_to_customer;
                if ( $discount > 0 )
                    $ledger[ 'credit' ] = $_POST[ 'accounts_value' ];
                $ledger[ 'debit' ]            = 0;
                $ledger[ 'transaction_type' ] = 'credit';
                $this -> AccountModel -> add_ledger ( $ledger );
                
                if ( $discount > 0 ) {
                    $ledger[ 'acc_head_id' ] = discount_lab_services;
                    if ( $accHeadID > 0 ) {
                        $ledger[ 'acc_head_id' ] = discount_lab_services_panel;
                        $ledger[ 'description' ] = $description;
                    }
                    $ledger[ 'credit' ]           = 0;
                    $ledger[ 'debit' ]            = $_POST[ 'accounts_value' ] - $net_bill;
                    $ledger[ 'transaction_type' ] = 'debit';
                    $this -> AccountModel -> add_ledger ( $ledger );
                }
                
                /***********LOGS*************/
                
                $log = array (
                    'user_id'      => get_logged_in_user_id (),
                    'sale_id'      => $sale_id,
                    'action'       => 'lab_sale_refunded',
                    'log'          => json_encode ( $lab_sale ),
                    'after_update' => '',
                    'date_added'   => current_date_time ()
                );
                $this -> load -> model ( 'LogModel' );
                $this -> LogModel -> create_log ( 'lab_sale_logs', $log );
                
                /***********END LOG*************/
                
                /***********LOGS*************/
                
                $log = array (
                    'user_id'      => get_logged_in_user_id (),
                    'sale_id'      => $sale_id,
                    'action'       => 'lab_sale_refund_ledger_added',
                    'log'          => json_encode ( $ledger ),
                    'after_update' => '',
                    'date_added'   => current_date_time ()
                );
                $this -> load -> model ( 'LogModel' );
                $this -> LogModel -> create_log ( 'lab_sale_logs', $log );
                
                /***********END LOG*************/
                
                if ( $accHeadID > 0 )
                    return redirect ( base_url ( '/lab/sales-panel' ) );
                else
                    return redirect ( base_url ( '/lab/sales' ) );
            }
        }
        
        /**
         * -------------------------
         * get test info
         * -------------------------
         */
        
        public function get_test_info () {
            $test_id  = $this -> input -> post ( 'test_id', true );
            $panel_id = $this -> input -> post ( 'panel_id', true );
            
            if ( $test_id > 0 ) {
                $test  = get_test_by_id ( $test_id );
                $price = get_test_price ( $test_id, $panel_id );
                
                $array = array (
                    'tat'   => $test -> tat,
                    'price' => $price -> price
                );
                
                echo json_encode ( $array );
                
            }
            
        }
        
        /**
         * -------------------------
         * get test info
         * -------------------------
         */
        
        public function get_lab_package_info () {
            $package_id = $this -> input -> post ( 'package_id', true );
            
            if ( $package_id > 0 ) {
                $package = $this -> PackageModel -> get_lab_packages_by_id ( $package_id );
                
                $array = array (
                    'price' => $package -> price
                );
                
                echo json_encode ( $array );
                
            }
            
        }
        
        public function status () {
            $status = $this -> input -> get ( 'status', true );
            $id     = $this -> uri -> segment ( 3 );
            
            if ( empty( $id ) or $id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            if ( $status == '1' )
                $status = '0';
            else
                $status = '1';
            
            $info  = array (
                'status' => $status
            );
            $where = array (
                'id' => $id
            );
            
            $this -> LabModel -> update ( $info, $where );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        /**
         * -------------------------
         * add lab test results
         * search by invoice or date
         * -------------------------
         */
        
        public function add_results_ipd () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_add_test_results_ipd' )
                $this -> do_add_test_results_ipd ( $_POST );
            
            $title = site_name . ' - Add Test Results';
            $this -> header ( $title );
            $this -> sidebar ();
            if ( ( isset( $_REQUEST[ 'invoice_id' ] ) and !empty( trim ( $_REQUEST[ 'invoice_id' ] ) ) ) or ( isset( $_REQUEST[ 'date' ] ) and !empty( trim ( $_REQUEST[ 'date' ] ) ) ) )
                $data[ 'sales' ] = $this -> IPDModel -> get_sale_parent_tests ();
            else
                $data[ 'sales' ] = array ();
            $this -> load -> view ( '/lab/add-results-ipd', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * do add test results
         * -------------------------
         */
        
        public function do_add_test_results_ipd ( $POST ) {
            $data           = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $test_id        = $data[ 'test_id' ];
            $sale_table_id  = $data[ 'sale_table_id' ];
            $result         = $data[ 'result' ];
            $remarks        = $data[ 'remarks' ];
            $selected       = $data[ 'selected' ];
            $last_insert_id = 0;
            
            if ( isset( $selected ) and count ( $selected ) > 0 ) {
                $selectedID = implode ( ',', $selected );
                return redirect ( base_url ( '/invoices/ipd-test-result-invoice/' . @$_REQUEST[ 'invoice_id' ] . '?selected=' . $selectedID ) );
            }
            
            if ( count ( $test_id ) > 0 ) {
                $this -> IPDModel -> delete_results ( $data[ 'invoice_id' ] );
                foreach ( $test_id as $key => $value ) {
                    $isTestChild  = check_if_test_is_child ( $value );
                    $isTestParent = check_if_test_has_sub_tests ( $value );
                    $info         = array (
                        'user_id'       => get_logged_in_user_id (),
                        'sale_id'       => $_REQUEST[ 'invoice_id' ],
                        'test_id'       => $value,
                        'sale_table_id' => $sale_table_id[ $key ],
                        'result'        => $result[ $key ],
                        'remarks'       => $remarks[ $key ],
                        'date_added'    => current_date_time (),
                    );
                    
                    if ( $isTestChild and $last_insert_id > 0 )
                        $info[ 'result_id' ] = $last_insert_id;
                    
                    $last_id = $this -> IPDModel -> do_add_test_results ( $info );
                    if ( $isTestParent )
                        $last_insert_id = $last_id;
                    
                    /***********LOGS*************/
                    
                    $log = array (
                        'user_id'      => get_logged_in_user_id (),
                        'sale_id'      => $_REQUEST[ 'invoice_id' ],
                        'action'       => 'ipd_lab_sale_results_added',
                        'log'          => json_encode ( $info ),
                        'after_update' => '',
                        'date_added'   => current_date_time ()
                    );
                    $this -> load -> model ( 'LogModel' );
                    $this -> LogModel -> create_log ( 'lab_sale_logs', $log );
                    
                    /***********END LOG*************/
                    
                }
                $this -> session -> set_flashdata ( 'response', 'Success! Results has been added.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
        }
        
        /**
         * -------------------------
         * lab calibrations
         * -------------------------
         */
        
        public function calibrations () {
            $title = site_name . ' - Calibrations';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'calibrations' ] = $this -> LabModel -> get_calibrations ();
            $this -> load -> view ( '/lab/calibrations', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * add lab calibrations
         * -------------------------
         */
        
        public function add_calibrations () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_add_calibrations' )
                $this -> do_add_calibrations ();
            
            $title = site_name . ' - Add Calibrations';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'tests' ] = $this -> LabModel -> get_active_parent_tests ();
            $this -> load -> view ( '/lab/add-calibrations', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * add more lab tests
         * -------------------------
         */
        
        public function add_more_calibrations () {
            $data[ 'row' ]   = $this -> input -> post ( 'added' );
            $data[ 'tests' ] = $this -> LabModel -> get_active_parent_tests ( 0 );
            $this -> load -> view ( '/lab/add-more-calibrations', $data );
        }
        
        /**
         * -------------------------
         * add calibrations
         * -------------------------
         */
        
        public function do_add_calibrations () {
            $tests          = $this -> input -> post ( 'test_id' );
            $calibrated     = $this -> input -> post ( 'calibrated' );
            $calibration_id = unique_id ( 4 );
            
            if ( count ( $tests ) > 0 ) {
                foreach ( $tests as $key => $test ) {
                    if ( $test > 0 ) {
                        $info = array (
                            'user_id'        => get_logged_in_user_id (),
                            'calibration_id' => $calibration_id,
                            'test_id'        => $test,
                            'calibration'    => $calibrated[ $key ],
                        );
                        $this -> LabModel -> add_calibrations ( $info );
                    }
                }
                
                /***********LOGS*************/
                
                $log = array (
                    'user_id'      => get_logged_in_user_id (),
                    'sale_id'      => 0,
                    'action'       => 'calibration_added',
                    'log'          => json_encode ( $_POST ),
                    'after_update' => '',
                    'date_added'   => current_date_time ()
                );
                $this -> load -> model ( 'LogModel' );
                $this -> LogModel -> create_log ( 'lab_sale_logs', $log );
                
                /***********END LOG*************/
                
            }
            
            $this -> session -> set_flashdata ( 'response', 'Success! Calibration has been added. ' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        /**
         * -------------------------
         * edit lab calibrations
         * -------------------------
         */
        
        public function edit_calibration () {
            
            
            $calibration_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $calibration_id ) ) )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_edit_calibrations' )
                $this -> do_edit_calibrations ();
            
            $title = site_name . ' - Edit Calibrations';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'tests' ]        = $this -> LabModel -> get_active_parent_tests ();
            $data[ 'calibrations' ] = $this -> LabModel -> get_calibrations_by_id ( $calibration_id );
            $this -> load -> view ( '/lab/edit-calibrations', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * add calibrations
         * -------------------------
         */
        
        public function do_edit_calibrations () {
            $id         = $this -> input -> post ( 'id' );
            $tests      = $this -> input -> post ( 'test_id' );
            $calibrated = $this -> input -> post ( 'calibrated' );
            
            $this -> LabModel -> delete_calibration ( $id );
            if ( count ( $tests ) > 0 ) {
                foreach ( $tests as $key => $test ) {
                    if ( $test > 0 ) {
                        $info = array (
                            'user_id'        => get_logged_in_user_id (),
                            'calibration_id' => $id,
                            'test_id'        => $test,
                            'calibration'    => $calibrated[ $key ],
                        );
                        $this -> LabModel -> add_calibrations ( $info );
                    }
                }
                
                /***********LOGS*************/
                
                $log = array (
                    'user_id'      => get_logged_in_user_id (),
                    'sale_id'      => 0,
                    'action'       => 'calibration_updated',
                    'log'          => json_encode ( $_POST ),
                    'after_update' => '',
                    'date_added'   => current_date_time ()
                );
                $this -> load -> model ( 'LogModel' );
                $this -> LogModel -> create_log ( 'lab_sale_logs', $log );
                
                /***********END LOG*************/
                
            }
            
            $this -> session -> set_flashdata ( 'response', 'Success! Calibration has been updated. ' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        /**
         * -------------------------
         * delete calibration by id
         * -------------------------
         */
        
        public function delete_calibration () {
            $calibration_id = $this -> uri -> segment ( 3 );
            if ( !empty( trim ( $calibration_id ) ) ) {
                
                /***********LOGS*************/
                
                $data[ 'calibrations' ] = $this -> LabModel -> get_calibrations_by_id ( $calibration_id );
                $log                    = array (
                    'user_id'      => get_logged_in_user_id (),
                    'sale_id'      => 0,
                    'action'       => 'calibration_deleted',
                    'log'          => json_encode ( $data[ 'calibrations' ] ),
                    'after_update' => '',
                    'date_added'   => current_date_time ()
                );
                $this -> load -> model ( 'LogModel' );
                $this -> LogModel -> create_log ( 'lab_sale_logs', $log );
                
                /***********END LOG*************/
                
                $deleted = $this -> LabModel -> delete_calibration ( $calibration_id );
                if ( $deleted ) {
                    $this -> session -> set_flashdata ( 'response', 'Success! Calibration has been deleted.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
                else {
                    $this -> session -> set_flashdata ( 'error', 'Error! Please try again.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
            }
        }
        
        public function delete_test_regents () {
            $test_id   = $this -> input -> get ( 'test-id' );
            $regent_id = $this -> input -> get ( 'regent-id' );
            
            if ( !isset( $test_id ) or empty( trim ( $test_id ) ) or $test_id < 0 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            if ( !isset( $regent_id ) or empty( trim ( $regent_id ) ) or $regent_id < 0 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $this -> LabModel -> delete_test_regent ( $regent_id, $test_id );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
        }
        
        /**
         * -------------------------
         * edit lab balance sale
         * -------------------------
         */
        
        public function edit_lab_sale_balance () {
            $id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $id ) ) )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_edit_lab_sale_balance' )
                $this -> do_edit_lab_sale_balance ();
            
            $title = site_name . ' - Edit Lab Sale Balance';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'sale' ]     = get_lab_sale ( $id );
            $data [ 'patient' ] = get_patient ( get_patient_id_by_sale_id ( $id ) );
            $this -> load -> view ( '/lab/edit-lab-sale-balance', $data );
            $this -> footer ();
        }
        
        public function do_edit_lab_sale_balance () {
            $this -> form_validation -> set_rules ( 'id', 'id', 'required|min_length[1]|numeric' );
            
            if ( $this -> form_validation -> run () == true ) {
                $sale_id     = $this -> input -> post ( 'id', true );
                $paid_amount = $this -> input -> post ( 'paid_amount', true );
                
                $sale  = array (
                    'paid_amount' => $paid_amount,
                );
                $where = array (
                    'id' => $sale_id,
                );
                $this -> LabModel -> update_lab_sale ( $sale, $where );
                $this -> session -> set_flashdata ( 'response', 'Success! Lab sale has been updated.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
        }
        
        /**
         * -------------------------
         * sales pending results main page
         * -------------------------
         */
        
        public function sale_pending_results () {
            $title = site_name . ' - Sales Pending Results';
            $this -> header ( $title );
            $this -> sidebar ();
            
            /**********PAGINATION***********/
            $limit                          = 100;
            $config                         = array ();
            $config[ "base_url" ]           = base_url ( 'lab/sale-pending-results' );
            $total_row                      = $this -> LabModel -> count_sale_pending_results ();
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
            
            $data[ 'panels' ] = $this -> PanelModel -> get_panels ();
            $data[ 'sales' ]  = $this -> LabModel -> get_sale_pending_results ( $config[ "per_page" ], $offset );
            $str_links        = $this -> pagination -> create_links ();
            $data[ "links" ]  = explode ( '&nbsp;', $str_links );
            $this -> load -> view ( '/lab/sale-pending-results', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * sales all added results main page
         * -------------------------
         */
        
        public function all_added_test_results () {
            $title = site_name . ' - All Added Test Results';
            $this -> header ( $title );
            $this -> sidebar ();
            
            /**********PAGINATION***********/
            $limit                          = 100;
            $config                         = array ();
            $config[ "base_url" ]           = base_url ( 'lab/all-added-test-results' );
            $total_row                      = $this -> LabModel -> count_all_added_test_results ();
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
            
            $data[ 'panels' ] = $this -> PanelModel -> get_panels ();
            $data[ 'sales' ]  = $this -> LabModel -> all_added_test_results ( $config[ "per_page" ], $offset );
            $str_links        = $this -> pagination -> create_links ();
            $data[ "links" ]  = explode ( '&nbsp;', $str_links );
            $this -> load -> view ( '/lab/all-added-test-results', $data );
            $this -> footer ();
        }
        
        /**
         * ----------
         * get patient by lab sale id
         * ----------
         */
        
        public function get_patient_by_lab_sale_id () {
            $id      = $this -> input -> post ( 'id', true );
            $patient = $this -> LabModel -> get_patient_by_lab_sale_id ( $id );
            if ( !empty( $patient ) ) {
                $array = array (
                    'name' => $patient -> name,
                    'id'   => $patient -> id,
                );
                echo json_encode ( $array );
            }
            else {
                echo 'false';
            }
        }
        
        public function load_lab_tests () {
            $patient_id = $this -> input -> post ( 'patient_id' );
            if ( $patient_id > 0 )
                $panel_id = get_patient ( $patient_id ) -> panel_id;
            else
                $panel_id = 0;
            
            $data[ 'panel_id' ] = $panel_id;
            $data[ 'tests' ]    = $this -> LabModel -> get_active_parent_tests ( $panel_id );
            $this -> load -> view ( '/lab/lab-test-options', $data );
        }
        
        public function load_sale_test () {
            $test_id  = $this -> input -> post ( 'test_id', true );
            $panel_id = $this -> input -> post ( 'panel_id', true );
            $row      = $this -> input -> post ( 'row', true );
            $default_datetime = $this->input->post('default_datetime', true);
            
            if ( $test_id > 0 ) {
                $test  = get_test_by_id ( $test_id );
                $price = get_test_price ( $test_id, $panel_id );
                
                $array = array (
                    'test'  => $test,
                    'price' => !empty( $price ) ? $price -> price : '0',
                    'row'   => $row,
                    'default_datetime' => $default_datetime 
                );
                
                $this -> load -> view ( '/lab/load-sale-lab-tests', $array );
            }
        }
        
        public function protocols () {
            $title = site_name . ' - Lab Tests Protocols';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'tests' ] = $this -> LabModel -> get_test_protocols ();
            $this -> load -> view ( '/lab/protocols', $data );
            $this -> footer ();
        }
        
        public function get_patient_by_lab_sale_id_and_test_type () {
            $id         = $this -> input -> post ( 'id', true );
            $section_id = $this -> input -> post ( 'section_id', true );
            $patient    = $this -> LabModel -> get_patient_by_lab_sale_id_and_test_type ( $id, $section_id );
            if ( !empty( $patient ) ) {
                $array = array (
                    'name'      => $patient -> name,
                    'id'        => $patient -> id,
                    'doctor_id' => $patient -> doctor_id,
                );
                echo json_encode ( $array );
            }
            else {
                echo 'false';
            }
        }
        
        public function visible_to_admin_only ( $test_id ) {
            $this -> LabModel -> visible_to_admin_only ( $test_id );
            $this -> session -> set_flashdata ( 'response', 'Success! Test has been updated.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        public function all_refer_outside () {
            $title = site_name . ' - All Refer Outside';
            $this -> header ( $title );
            $this -> sidebar ();
            
            /**********PAGINATION***********/
            $limit                          = 25;
            $config                         = array ();
            $config[ "base_url" ]           = base_url ( 'lab/all-refer-outside' );
            $total_row                      = $this -> LabModel -> count_refer_outside ();
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
            
            $data[ 'sales' ]   = $this -> LabModel -> get_refer_outside ( $limit, $offset );
            $str_links         = $this -> pagination -> create_links ();
            $data[ "links" ]   = explode ( '&nbsp;', $str_links );
            $data[ 'doctors' ] = $this -> DoctorModel -> get_doctors ();
            $this -> load -> view ( '/lab/all-refer-outside', $data );
            $this -> footer ();
        }
        
        public function add_refer_outside () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_add_refer_outside' )
                $this -> do_add_refer_outside ();
            
            $title = site_name . ' - Add Refer Outside';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'doctors' ] = $this -> DoctorModel -> get_doctors ();
            $this -> load -> view ( '/lab/add-refer-outside', $data );
            $this -> footer ();
        }
        
        public function load_add_refer_outside () {
            $panel_id = 0;
            $test_id  = $this -> input -> post ( 'test_id', true );
            $row      = $this -> input -> post ( 'row', true );
            
            if ( $test_id > 0 ) {
                $test = get_test_by_id ( $test_id );
                
                $array = array (
                    'test' => $test,
                    'row'  => $row
                );
                
                $this -> load -> view ( '/lab/load-add-refer-outside', $array );
            }
        }
        
        public function do_add_refer_outside () {
            $this -> form_validation -> set_rules ( 'patient_id', 'patient_id', 'required|min_length[1]|numeric' );
            if ( $this -> form_validation -> run () == true ) {
                $tests        = $this -> input -> post ( 'test_id' );
                $patient_id   = $this -> input -> post ( 'patient_id' );
                $panel_id     = $this -> input -> post ( 'panel_id' );
                $reference_id = $this -> input -> post ( 'doctor-id' );
                $branch       = $this -> input -> post ( 'branch' );
                $sale_id      = $this -> input -> post ( 'invoice-id' );
                
                if ( $panel_id > 0 ) {
                    $accHeadID = get_account_head_id_by_panel_id ( $panel_id );
                    if ( empty( $accHeadID ) ) {
                        $this -> session -> set_flashdata ( 'error', 'Alert! No account head is linked against patient panel id	.' );
                        return redirect ( base_url ( '/lab/sale' ) );
                    }
                }
                
                $sale          = array (
                    'user_id'    => get_logged_in_user_id (),
                    'doctor_id'  => $reference_id,
                    'patient_id' => $patient_id,
                    'branch'     => $branch,
                    'sale_id'    => $sale_id,
                );
                $refer_outside = $this -> LabModel -> add_refer_outside ( $sale );
                
                
                if ( isset( $tests ) and count ( array_filter ( $tests ) ) > 0 ) {
                    foreach ( $tests as $key => $test_id ) {
                        $info[ 'refer_outside_id' ] = $refer_outside;
                        $info[ 'test_id' ]          = $test_id;
                        $this -> LabModel -> add_refer_outside_tests ( $info );
                    }
                }
                
                $print = '<strong><a href="' . base_url ( '/invoices/outside-refer-invoice/' . $refer_outside ) . '" target="_blank">Print</a></strong>';
                
                if ( $refer_outside > 0 )
                    $this -> session -> set_flashdata ( 'response', 'Success! Refer outside has been added. ' . $print );
                else
                    $this -> session -> set_flashdata ( 'error', 'Error! Please try again.' );
                
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            }
        }
        
        public function delete_refer_outside ( $id ) {
            $this -> LabModel -> delete_refer_outside ( $id );
            $this -> LabModel -> delete_refer_outside_tests ( $id );
            $this -> session -> set_flashdata ( 'response', 'Success! Refer outside has been deleted.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
    }

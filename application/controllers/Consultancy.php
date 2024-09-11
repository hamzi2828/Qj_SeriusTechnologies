<?php
    defined ( 'BASEPATH' ) or exit( 'No direct script access allowed' );
    
    class Consultancy extends CI_Controller {
        
        /**
         * -------------------------
         * Consultancy constructor.
         * loads helpers, modal or libraries
         * -------------------------
         */
        
        public function __construct () {
            parent ::__construct ();
            $this -> is_logged_in ();
            $this -> load -> model ( 'DoctorModel' );
            $this -> load -> model ( 'ConsultancyModel' );
            $this -> load -> model ( 'LabModel' );
            $this -> load -> model ( 'MedicineModel' );
            $this -> load -> model ( 'AccountModel' );
            $this -> load -> model ( 'InstructionModel' );
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
         * consultancies main page
         * -------------------------
         */
        
        public function index () {
            $title = site_name . ' - Cash Consultancy Invoices';
            $this -> header ( $title );
            $this -> sidebar ();
            
            /**********PAGINATION***********/
            $limit = 10;
            $config = array ();
            $config[ "base_url" ] = base_url ( 'consultancy/index' );
            $total_row = $this -> ConsultancyModel -> count_consultancies ();
            $config[ "total_rows" ] = $total_row;
            $config[ "per_page" ] = $limit;
            $config[ 'use_page_numbers' ] = false;
            $config[ 'page_query_string' ] = TRUE;
            $config[ 'reuse_query_string' ] = TRUE;
            $config[ 'num_links' ] = 10;
            $config[ 'cur_tag_open' ] = '&nbsp;<a class="current">';
            $config[ 'cur_tag_close' ] = '</a>';
            $config[ 'next_link' ] = 'Next';
            $config[ 'prev_link' ] = 'Previous';
            
            $this -> pagination -> initialize ( $config );
            
            /**********END PAGINATION***********/
            
            if ( isset( $_REQUEST[ 'per_page' ] ) and $_REQUEST[ 'per_page' ] > 0 ) {
                $offset = $_REQUEST[ 'per_page' ];
            }
            else {
                $offset = 0;
            }
            
            $data[ 'consultancies' ] = $this -> ConsultancyModel -> get_consultancies ( $config[ "per_page" ], $offset );
            $str_links = $this -> pagination -> create_links ();
            $data[ 'specializations' ] = $this -> DoctorModel -> get_specializations ();
            $data[ 'doctors' ] = $this -> DoctorModel -> get_doctors ();
            $data[ "links" ] = explode ( '&nbsp;', $str_links );
            $this -> load -> view ( '/consultancy/index', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * consultancies main page
         * -------------------------
         */
        
        public function panel_consultancy_invoices () {
            $title = site_name . ' - Panel Consultancy Invoices';
            $this -> header ( $title );
            $this -> sidebar ();
            
            /**********PAGINATION***********/
            $limit = 10;
            $config = array ();
            $config[ "base_url" ] = base_url ( 'consultancy/panel-consultancy-invoices' );
            $total_row = $this -> ConsultancyModel -> count_panel_consultancies ();
            $config[ "total_rows" ] = $total_row;
            $config[ "per_page" ] = $limit;
            $config[ 'use_page_numbers' ] = false;
            $config[ 'page_query_string' ] = TRUE;
            $config[ 'reuse_query_string' ] = TRUE;
            $config[ 'num_links' ] = 10;
            $config[ 'cur_tag_open' ] = '&nbsp;<a class="current">';
            $config[ 'cur_tag_close' ] = '</a>';
            $config[ 'next_link' ] = 'Next';
            $config[ 'prev_link' ] = 'Previous';
            
            $this -> pagination -> initialize ( $config );
            
            /**********END PAGINATION***********/
            
            if ( isset( $_REQUEST[ 'per_page' ] ) and $_REQUEST[ 'per_page' ] > 0 ) {
                $offset = $_REQUEST[ 'per_page' ];
            }
            else {
                $offset = 0;
            }
            
            $data[ 'consultancies' ] = $this -> ConsultancyModel -> get_panel_consultancies ( $config[ "per_page" ], $offset );
            $str_links = $this -> pagination -> create_links ();
            $data[ 'specializations' ] = $this -> DoctorModel -> get_specializations ();
            $data[ 'doctors' ] = $this -> DoctorModel -> get_doctors ();
            $data[ "links" ] = explode ( '&nbsp;', $str_links );
            $this -> load -> view ( '/consultancy/panel_consultancy_invoices', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * doctors add main page
         * -------------------------
         */
        
        public function add () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_add_consultancy' )
                $this -> do_add_consultancy ( $_POST );
            
            $title = site_name . ' - Add Consultancy';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'specializations' ] = $this -> DoctorModel -> get_specializations ();
            $this -> load -> view ( '/consultancy/add', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * add doctors
         * -------------------------
         */
        
        public function do_add_consultancy ( $POST ) {
            $data = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $this -> form_validation -> set_rules ( 'patient_id', 'patient id', 'required|numeric|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'specialization_id', 'specialization id', 'required|numeric|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'doctor_id', 'doctor id', 'required|numeric|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'available_from', 'available from', 'required|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'available_till', 'available till', 'required|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'charges', 'charges', 'required|trim|min_length[1]|xss_clean|numeric' );
            //            $this -> form_validation -> set_rules ( 'discount', 'discount', 'required|trim|min_length[1]|xss_clean|numeric' );
            $this -> form_validation -> set_rules ( 'net_bill', 'net bill', 'required|trim|min_length[1]|xss_clean|numeric' );
            
            if ( $this -> form_validation -> run () == true ) {
                $patient = get_patient ( $data[ 'patient_id' ] );
                $doc_acc_head_id = get_doctor_linked_account_head_id ( $data[ 'doctor_id' ] );
                $accHeadID = 0;
                if ( $patient -> panel_id > 0 ) {
                    $accHeadID = get_account_head_id_by_panel_id ( $patient -> panel_id );
                }
                
                if ( empty( $accHeadID ) and $patient -> panel_id > 0 ) {
                    $this -> session -> set_flashdata ( 'error', 'Alert! No account head is linked against patient panel id.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
                
                if ( $doc_acc_head_id > 0 ) {
                    
                    $doctor_info = get_doctor ( $data[ 'doctor_id' ] );
                    $info = array (
                        'user_id'           => get_logged_in_user_id (),
                        'specialization_id' => $data[ 'specialization_id' ],
                        'patient_id'        => $data[ 'patient_id' ],
                        'doctor_id'         => $data[ 'doctor_id' ],
                        'available_from'    => date ( "H:i", strtotime ( $data[ 'available_from' ] ) ),
                        'available_till'    => date ( "H:i", strtotime ( $data[ 'available_till' ] ) ),
                        'charges'           => $data[ 'charges' ],
                        'discount'          => $data[ 'discount' ],
                        'net_bill'          => $data[ 'net_bill' ],
                        'remarks'           => $data[ 'remarks' ],
                        'doctor_charges'    => $doctor_info -> doctor_share,
                        'date_added'        => current_date_time (),
                    );
                    $consultancy_id = $this -> ConsultancyModel -> add ( $info );
                    
                    $log = array (
                        'user_id'        => get_logged_in_user_id (),
                        'consultancy_id' => $consultancy_id,
                        'action'         => 'consultancy_added',
                        'log'            => json_encode ( $info ),
                        'after_update'   => '',
                        'date_added'     => current_date_time ()
                    );
                    $this -> load -> model ( 'LogModel' );
                    $this -> LogModel -> create_log ( 'consultancy_logs', $log );
                    
                    if ( $consultancy_id > 0 ) {
                        
                        
                        $description = 'Refereed to: ' . $doctor_info -> name;
                        if ( $patient -> panel_id > 0 ) {
                            $panel = get_panel_by_id ( $patient -> panel_id );
                            $description .= ' / ' . $panel -> name;
                        }
                        $ledger = array (
                            'user_id'            => get_logged_in_user_id (),
                            'acc_head_id'        => cash_from_opd_consultancy,
                            'opd_consultancy_id' => $consultancy_id,
                            'trans_date'         => date ( 'Y-m-d' ),
                            'payment_mode'       => 'cash',
                            'paid_via'           => 'cash',
                            'credit'             => $data[ 'net_bill' ],
                            'debit'              => 0,
                            'transaction_type'   => 'credit',
                            'description'        => $description,
                            'date_added'         => current_date_time (),
                        );
                        if ( $patient -> panel_id > 0 ) {
                            $accHeadID = get_account_head_id_by_panel_id ( $patient -> panel_id );
                            $ledger[ 'acc_head_id' ] = $accHeadID -> id;
                        }
                        $this -> AccountModel -> add_ledger ( $ledger );
                        
                        if ( $data[ 'discount' ] > 0 ) {
                            $share = $doctor_info -> doctor_share;
                            $doctors_share = ( $data[ 'charges' ] * $share ) / 100;
                            
                            $revenue_consultancy = array (
                                'user_id'            => get_logged_in_user_id (),
                                'acc_head_id'        => sales_consultancy_service,
                                'opd_consultancy_id' => $consultancy_id,
                                'trans_date'         => date ( 'Y-m-d' ),
                                'payment_mode'       => 'cash',
                                'paid_via'           => 'cash',
                                'credit'             => 0,
                                'debit'              => $data[ 'charges' ],
                                'transaction_type'   => 'credit',
                                'description'        => $description,
                                'date_added'         => current_date_time (),
                            );
                            if ( $patient -> panel_id > 0 ) {
                                $revenue_consultancy[ 'acc_head_id' ] = sales_consultancy_service_panel;
                            }
                            $this -> AccountModel -> add_ledger ( $revenue_consultancy );
                            
                            $doctor_share = array (
                                'user_id'            => get_logged_in_user_id (),
                                'acc_head_id'        => $doc_acc_head_id,
                                'opd_consultancy_id' => $consultancy_id,
                                'trans_date'         => date ( 'Y-m-d' ),
                                'payment_mode'       => 'cash',
                                'paid_via'           => 'cash',
                                'credit'             => 0,
                                'debit'              => $doctors_share,
                                'transaction_type'   => 'credit',
                                'description'        => $description,
                                'date_added'         => current_date_time (),
                            );
                            $this -> AccountModel -> add_ledger ( $doctor_share );
                            
                            $discount_consultancy = array (
                                'user_id'            => get_logged_in_user_id (),
                                'acc_head_id'        => discount_consultancy_service,
                                'opd_consultancy_id' => $consultancy_id,
                                'trans_date'         => date ( 'Y-m-d' ),
                                'payment_mode'       => 'cash',
                                'paid_via'           => 'cash',
                                'credit'             => $data[ 'charges' ] - $data[ 'net_bill' ],
                                'debit'              => 0,
                                'transaction_type'   => 'credit',
                                'description'        => $description,
                                'date_added'         => current_date_time (),
                            );
                            if ( $patient -> panel_id > 0 ) {
                                $discount_consultancy[ 'acc_head_id' ] = discount_consultancy_service_panel;
                            }
                            $this -> AccountModel -> add_ledger ( $discount_consultancy );
                            
                            $COS_consultancy = array (
                                'user_id'            => get_logged_in_user_id (),
                                'acc_head_id'        => COS_Consultancy_Charges,
                                'opd_consultancy_id' => $consultancy_id,
                                'trans_date'         => date ( 'Y-m-d' ),
                                'payment_mode'       => 'cash',
                                'paid_via'           => 'cash',
                                'credit'             => $doctors_share,
                                'debit'              => 0,
                                'transaction_type'   => 'credit',
                                'description'        => $description,
                                'date_added'         => current_date_time (),
                            );
                            $this -> AccountModel -> add_ledger ( $COS_consultancy );
                            
                            $log = array (
                                'user_id'        => get_logged_in_user_id (),
                                'consultancy_id' => $consultancy_id,
                                'action'         => 'discount_consultancy_ledger_added',
                                'log'            => json_encode ( $discount_consultancy ),
                                'after_update'   => '',
                                'date_added'     => current_date_time ()
                            );
                            $this -> load -> model ( 'LogModel' );
                            $this -> LogModel -> create_log ( 'consultancy_logs', $log );
                            
                        }
                        else {
                            $share = $doctor_info -> doctor_share;
                            $doctors_share = ( $data[ 'charges' ] * $share ) / 100;
                            
                            $revenue_consultancy = array (
                                'user_id'            => get_logged_in_user_id (),
                                'acc_head_id'        => sales_consultancy_service,
                                'opd_consultancy_id' => $consultancy_id,
                                'trans_date'         => date ( 'Y-m-d' ),
                                'payment_mode'       => 'cash',
                                'paid_via'           => 'cash',
                                'credit'             => 0,
                                'debit'              => $data[ 'charges' ],
                                'transaction_type'   => 'credit',
                                'description'        => $description,
                                'date_added'         => current_date_time (),
                            );
                            if ( $patient -> panel_id > 0 ) {
                                $revenue_consultancy[ 'acc_head_id' ] = sales_consultancy_service_panel;
                            }
                            $this -> AccountModel -> add_ledger ( $revenue_consultancy );
                            
                            $doctor_share = array (
                                'user_id'            => get_logged_in_user_id (),
                                'acc_head_id'        => $doc_acc_head_id,
                                'opd_consultancy_id' => $consultancy_id,
                                'trans_date'         => date ( 'Y-m-d' ),
                                'payment_mode'       => 'cash',
                                'paid_via'           => 'cash',
                                'credit'             => 0,
                                'debit'              => $doctors_share,
                                'transaction_type'   => 'credit',
                                'description'        => $description,
                                'date_added'         => current_date_time (),
                            );
                            $this -> AccountModel -> add_ledger ( $doctor_share );
                            
                            $COS_consultancy = array (
                                'user_id'            => get_logged_in_user_id (),
                                'acc_head_id'        => COS_Consultancy_Charges,
                                'opd_consultancy_id' => $consultancy_id,
                                'trans_date'         => date ( 'Y-m-d' ),
                                'payment_mode'       => 'cash',
                                'paid_via'           => 'cash',
                                'credit'             => $doctors_share,
                                'debit'              => 0,
                                'transaction_type'   => 'credit',
                                'description'        => $description,
                                'date_added'         => current_date_time (),
                            );
                            $this -> AccountModel -> add_ledger ( $COS_consultancy );
                        }
                        
                        $log = array (
                            'user_id'        => get_logged_in_user_id (),
                            'consultancy_id' => $consultancy_id,
                            'action'         => 'consultancy_ledger_added',
                            'log'            => json_encode ( $ledger ),
                            'after_update'   => '',
                            'date_added'     => current_date_time ()
                        );
                        $this -> load -> model ( 'LogModel' );
                        $this -> LogModel -> create_log ( 'consultancy_logs', $log );
                        
                        $log = array (
                            'user_id'        => get_logged_in_user_id (),
                            'consultancy_id' => $consultancy_id,
                            'action'         => 'consultancy_revenue_ledger_added',
                            'log'            => json_encode ( $revenue_consultancy ),
                            'after_update'   => '',
                            'date_added'     => current_date_time ()
                        );
                        $this -> load -> model ( 'LogModel' );
                        $this -> LogModel -> create_log ( 'consultancy_logs', $log );
                        
                        $log = array (
                            'user_id'        => get_logged_in_user_id (),
                            'consultancy_id' => $consultancy_id,
                            'action'         => 'consultancy_doctor_share_ledger_added',
                            'log'            => json_encode ( $doctor_share ),
                            'after_update'   => '',
                            'date_added'     => current_date_time ()
                        );
                        $this -> load -> model ( 'LogModel' );
                        $this -> LogModel -> create_log ( 'consultancy_logs', $log );
                        
                        
                        $this -> session -> set_flashdata ( 'response', 'Success! Consultancy added. <a href="' . base_url ( '/invoices/consultancy-invoice/' . $consultancy_id ) . '" target="_blank" style="font-weight: 800; font-size: 16px">Print</a>' );
                    }
                    else {
                        $this -> session -> set_flashdata ( 'error', 'Error! Please try again.' );
                    }
                }
                else
                    $this -> session -> set_flashdata ( 'error', 'Error! Doctor account head is either not created or not linked with account head. Please add account head first or link if there is already.' );
                return redirect ( base_url ( '/consultancy/add' ) );
            }
        }
        
        /**
         * -------------------------
         * consultancy edit main page
         * -------------------------
         */
        
        public function edit () {
            
            $consultancy_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $consultancy_id ) ) or !is_numeric ( $consultancy_id ) )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_edit_consultancy' )
                $this -> do_edit_consultancy ( $_POST );
            
            $title = site_name . ' - Edit Consultancy';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'consultancy' ] = $this -> ConsultancyModel -> get_consultancy_by_id ( $consultancy_id );
            $this -> load -> view ( '/consultancy/edit', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * edit consultancy
         * -------------------------
         */
        
        public function do_edit_consultancy ( $POST ) {
            $data = filter_var_array ( $POST, FILTER_SANITIZE_STRING );
            $this -> form_validation -> set_rules ( 'consultancy_id', 'consultancy id', 'required|numeric|trim|min_length[1]|xss_clean' );
            $this -> form_validation -> set_rules ( 'charges', 'charges', 'required|trim|min_length[1]|xss_clean|numeric' );
//            $this -> form_validation -> set_rules ( 'discount', 'discount', 'required|trim|min_length[1]|xss_clean|numeric' );
            $this -> form_validation -> set_rules ( 'net_bill', 'net bill', 'required|trim|min_length[1]|xss_clean|numeric' );
            
            $consultancy_id = $data[ 'consultancy_id' ];
            $doc_acc_head_id = get_doctor_linked_account_head_id ( $data[ 'doctor_id' ] );
            if ( $this -> form_validation -> run () == true ) {
                $info = array (
                    'charges'  => $data[ 'charges' ],
                    'discount' => $data[ 'discount' ],
                    'net_bill' => $data[ 'net_bill' ],
                    'remarks'  => $data[ 'remarks' ],
                );
                
                $log = array (
                    'user_id'        => get_logged_in_user_id (),
                    'consultancy_id' => $consultancy_id,
                    'action'         => 'consultancy_updated',
                    'log'            => json_encode ( $this -> ConsultancyModel -> get_consultancy_by_id ( $consultancy_id ) ),
                    'after_update'   => json_encode ( $info ),
                    'date_added'     => current_date_time ()
                );
                $this -> load -> model ( 'LogModel' );
                $this -> LogModel -> create_log ( 'consultancy_logs', $log );
                
                $updated = $this -> ConsultancyModel -> edit ( $info, $consultancy_id );
                $doctor_info = get_doctor ( $data[ 'doctor_id' ] );
                if ( $updated ) {
                    
                    if ( $data[ 'discount' ] > 0 ) {
                        $share = $doctor_info -> doctor_share;
                        $doctor_share = ( $data[ 'charges' ] * $share ) / 100;
                        
                        $revenue_consultancy = array (
                            'acc_head_id'        => sales_consultancy_service,
                            'opd_consultancy_id' => $consultancy_id,
                            'debit'              => $data[ 'charges' ] - $doctor_share,
                            'credit'             => 0,
                        );
                        $revenue_consultancy_where = array (
                            'acc_head_id'        => sales_consultancy_service,
                            'opd_consultancy_id' => $consultancy_id,
                        );
                        $this -> AccountModel -> update_general_ledger ( $revenue_consultancy, $revenue_consultancy_where );
                        
                        $doctor_share = array (
                            'debit'  => $doctor_share,
                            'credit' => 0,
                        );
                        
                        $doctor_share_where = array (
                            'acc_head_id'        => $doc_acc_head_id,
                            'opd_consultancy_id' => $consultancy_id,
                        );
                        $this -> AccountModel -> update_general_ledger ( $doctor_share, $doctor_share_where );
                        
                        $discount_consultancy = array (
                            'credit' => $data[ 'charges' ] - $data[ 'net_bill' ],
                            'debit'  => 0,
                        );
                        
                        $discount_consultancy_where = array (
                            'acc_head_id'        => discount_consultancy_service,
                            'opd_consultancy_id' => $consultancy_id,
                        );
                        $this -> AccountModel -> update_general_ledger ( $discount_consultancy, $discount_consultancy_where );
                        
                        $log = array (
                            'user_id'        => get_logged_in_user_id (),
                            'consultancy_id' => $consultancy_id,
                            'action'         => 'discount_consultancy_ledger_added',
                            'log'            => json_encode ( $discount_consultancy ),
                            'after_update'   => '',
                            'date_added'     => current_date_time ()
                        );
                        $this -> load -> model ( 'LogModel' );
                        $this -> LogModel -> create_log ( 'consultancy_logs', $log );
                        
                    }
                    else {
                        $share = $doctor_info -> doctor_share;
                        $doctor_share = ( $data[ 'charges' ] * $share ) / 100;
                        
                        $revenue_consultancy = array (
                            'acc_head_id'        => sales_consultancy_service,
                            'opd_consultancy_id' => $consultancy_id,
                            'debit'              => $data[ 'charges' ] - $doctor_share,
                        );
                        $revenue_consultancy_where = array (
                            'acc_head_id'        => sales_consultancy_service,
                            'opd_consultancy_id' => $consultancy_id,
                        );
                        $this -> AccountModel -> update_general_ledger ( $revenue_consultancy, $revenue_consultancy_where );
                        
                        $doctor_share = array (
                            'debit' => $doctor_share,
                        );
                        
                        $doctor_share_where = array (
                            'acc_head_id'        => $doc_acc_head_id,
                            'opd_consultancy_id' => $consultancy_id,
                        );
                        $this -> AccountModel -> update_general_ledger ( $doctor_share, $doctor_share_where );
                    }
                    
                    $log = array (
                        'user_id'        => get_logged_in_user_id (),
                        'consultancy_id' => $consultancy_id,
                        'action'         => 'consultancy_revenue_ledger_added',
                        'log'            => json_encode ( $revenue_consultancy ),
                        'after_update'   => '',
                        'date_added'     => current_date_time ()
                    );
                    $this -> load -> model ( 'LogModel' );
                    $this -> LogModel -> create_log ( 'consultancy_logs', $log );
                    
                    $log = array (
                        'user_id'        => get_logged_in_user_id (),
                        'consultancy_id' => $consultancy_id,
                        'action'         => 'consultancy_doctor_share_ledger_added',
                        'log'            => json_encode ( $doctor_share ),
                        'after_update'   => '',
                        'date_added'     => current_date_time ()
                    );
                    $this -> load -> model ( 'LogModel' );
                    $this -> LogModel -> create_log ( 'consultancy_logs', $log );
                    
                    
                    $log = array (
                        'user_id'        => get_logged_in_user_id (),
                        'consultancy_id' => $consultancy_id,
                        'action'         => 'consultancy_ledger_updated',
                        'log'            => ' ',
                        'after_update'   => json_encode ( $data[ 'net_bill' ] ),
                        'date_added'     => current_date_time ()
                    );
                    $this -> load -> model ( 'LogModel' );
                    $this -> LogModel -> create_log ( 'consultancy_logs', $log );
                    
                    $consultancy_ledger = array (
                        'credit' => $data[ 'net_bill' ],
                    );
                    
                    $consultancy_ledger_where = array (
                        'acc_head_id'        => cash_from_opd_consultancy,
                        'opd_consultancy_id' => $consultancy_id,
                    );
                    $this -> AccountModel -> update_general_ledger ( $consultancy_ledger, $consultancy_ledger_where );
                    
                    $this -> session -> set_flashdata ( 'response', 'Success! Consultancy updated.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
                else {
                    $this -> session -> set_flashdata ( 'error', 'Note! No record updated.' );
                    return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                }
            }
        }
        
        /**
         * -------------------------
         * delete consultancy
         * -------------------------
         */
        
        public function delete () {
            $consultancy_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $consultancy_id ) ) or !is_numeric ( $consultancy_id ) )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $log = array (
                'user_id'        => get_logged_in_user_id (),
                'consultancy_id' => $consultancy_id,
                'action'         => 'consultancy_deleted',
                'log'            => json_encode ( $this -> ConsultancyModel -> get_consultancy_by_id ( $consultancy_id ) ),
                'after_update'   => '',
                'date_added'     => current_date_time ()
            );
            $this -> load -> model ( 'LogModel' );
            $this -> LogModel -> create_log ( 'consultancy_logs', $log );
            
            $this -> ConsultancyModel -> delete ( $consultancy_id );
            $this -> AccountModel -> delete_opd_consultancy_ledger ( $consultancy_id );
            $this -> session -> set_flashdata ( 'response', 'Success! Consultancy deleted.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
        }
        
        /**
         * -------------------------
         * prescriptions add main page
         * -------------------------
         */
        
        public function prescriptions () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_add_prescriptions' )
                $this -> do_add_prescriptions ( $_POST );
            
            $title = site_name . ' - Prescriptions';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'consultancy' ] = $this -> ConsultancyModel -> search_consultancy ();
            $data[ 'prescription' ] = $this -> ConsultancyModel -> get_prescription ();
            $data[ 'medicines' ] = $this -> MedicineModel -> get_medicines ();
            $data[ 'tests' ] = $this -> LabModel -> get_tests ();
            $data[ 'follow_ups' ] = $this -> DoctorModel -> get_follow_up ();
            $data[ 'instructions' ] = $this -> InstructionModel -> get_instructions ();
            $data[ 'prescribed_medicines' ] = $this -> ConsultancyModel -> get_prescribed_medicines ();
            $this -> load -> view ( '/consultancy/prescriptions', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * add prescriptions
         * -------------------------
         */
        
        public function do_add_prescriptions ( $POST ) {
            $consultancy = $this -> ConsultancyModel -> search_consultancy ();
            $info = array (
                'doctor_id'      => $consultancy -> doctor_id,
                'patient_id'     => $consultancy -> patient_id,
                'consultancy_id' => $_REQUEST[ 'consultancy_id' ],
                'complaints'     => $POST[ 'complaints' ],
                'diagnosis'      => $POST[ 'diagnosis' ],
                'follow_up'      => $POST[ 'follow_up' ],
                'date_added'     => current_date_time (),
            );
            $this -> ConsultancyModel -> delete_prescriptions ( $_REQUEST[ 'consultancy_id' ] );
            $prescription_id = $this -> ConsultancyModel -> do_add_prescriptions ( $info );
            if ( $prescription_id > 0 ) {
                
                $log = array (
                    'user_id'        => get_logged_in_user_id (),
                    'consultancy_id' => $_REQUEST[ 'consultancy_id' ],
                    'action'         => 'consultancy_prescriptions_added',
                    'log'            => json_encode ( $info ),
                    'after_update'   => '',
                    'date_added'     => current_date_time ()
                );
                $this -> load -> model ( 'LogModel' );
                $this -> LogModel -> create_log ( 'consultancy_logs', $log );
                
                $this -> ConsultancyModel -> add_doctor_prescribed_medicines ( $POST, $prescription_id, $consultancy );
                $this -> ConsultancyModel -> add_doctor_prescribed_tests ( $POST, $prescription_id, $consultancy );
                
                $this -> session -> set_flashdata ( 'response', 'Success! Prescriptions added. <a href="' . base_url ( '/invoices/prescription-invoice/' . $prescription_id ) . '" target="_blank" style="font-weight: 800; font-size: 16px">Print</a>' );
            }
            else {
                $this -> session -> set_flashdata ( 'error', 'Error! Please try again.' );
            }
            return redirect ( base_url ( '/consultancy/prescriptions' ) );
        }
        
        /**
         * -------------------------
         * add more prescribed medicines
         * -------------------------
         */
        
        public function add_more_prescribed_medicines () {
            $data[ 'row' ] = $_POST[ 'added' ];
            $data[ 'medicines' ] = $this -> MedicineModel -> get_medicines ();
            $data[ 'instructions' ] = $this -> InstructionModel -> get_instructions ();
            $this -> load -> view ( '/consultancy/add_more_prescribed_medicines', $data );
        }
        
        /**
         * -------------------------
         * @param $POST
         * refund consultancy
         * -------------------------
         */
        
        public function refund () {
            
            $consultancy_id = $this -> uri -> segment ( 3 );
            if ( empty( trim ( $consultancy_id ) ) or $consultancy_id < 1 or !is_numeric ( $consultancy_id ) )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_refund_consultancy' )
                $this -> do_refund_consultancy ( $_POST );
            
            $title = site_name . ' - Refund';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'consultancy' ] = $this -> ConsultancyModel -> get_consultancy_by_id ( $consultancy_id );
            $this -> load -> view ( '/consultancy/refund', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * do refund consultancy
         * -------------------------
         */
        
        public function do_refund_consultancy () {
            $consultancy_id = $_POST[ 'consultancy_id' ];
            $net_charges = $_POST[ 'net_charges' ];
            if ( empty( trim ( $consultancy_id ) ) or $consultancy_id < 1 or !is_numeric ( $consultancy_id ) )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $consultancy = (array)$this -> ConsultancyModel -> get_consultancy_by_id ( $consultancy_id );
            $patient = get_patient ( $consultancy[ 'patient_id' ] );
            if ( !empty( $consultancy ) ) {
                $doctor_charges = $consultancy[ 'doctor_charges' ];
                $doctor_id = $consultancy[ 'doctor_id' ];
                $discount = $consultancy[ 'discount' ];
                array_shift ( $consultancy );
                $consultancy[ 'user_id' ] = get_logged_in_user_id ();
                $consultancy[ 'charges' ] = -$_POST[ 'amount_paid_to_customer' ];
                $consultancy[ 'net_bill' ] = -$_POST[ 'amount_paid_to_customer' ];
                $consultancy[ 'refunded' ] = '1';
                $consultancy[ 'refund_reason' ] = $_POST[ 'description' ];
                $consultancy[ 'date_added' ] = date ( 'Y-m-d', strtotime ( $_POST[ 'date_added' ] ) ) . ' ' . date ( 'H:i:s' );
                $new_consultancy_id = $this -> ConsultancyModel -> add ( $consultancy );
                $this -> ConsultancyModel -> edit ( array ( 'refunded' => '1' ), $consultancy_id );
                
                $log = array (
                    'user_id'        => get_logged_in_user_id (),
                    'consultancy_id' => $_REQUEST[ 'consultancy_id' ],
                    'action'         => 'consultancy_refunded',
                    'log'            => json_encode ( $consultancy ),
                    'after_update'   => '',
                    'date_added'     => current_date_time ()
                );
                $this -> load -> model ( 'LogModel' );
                $this -> LogModel -> create_log ( 'consultancy_logs', $log );
                
                $ledger[ 'user_id' ] = get_logged_in_user_id ();
                $ledger[ 'acc_head_id' ] = cash_from_opd_consultancy;
                $ledger[ 'opd_consultancy_id' ] = $new_consultancy_id;
                $ledger[ 'credit' ] = '0';
                $ledger[ 'trans_date' ] = date ( 'Y-m-d', strtotime ( $_POST[ 'date_added' ] ) );
                $ledger[ 'debit' ] = $_POST[ 'amount_paid_to_customer' ];
                $ledger[ 'description' ] = $_POST[ 'description' ];
                $ledger[ 'date_added' ] = date ( 'Y-m-d', strtotime ( $_POST[ 'date_added' ] ) ) . ' ' . date ( 'H:i:s' );
                
                if ( $patient -> panel_id > 0 ) {
                    $accHeadID = get_account_head_id_by_panel_id ( $patient -> panel_id );
                    $ledger[ 'acc_head_id' ] = $accHeadID -> id;
                }
                $this -> AccountModel -> add_ledger ( $ledger );
                
                if ( $doctor_charges > 0 ) {
                    $doc_acc_head_id = get_doctor_linked_account_head_id ( $doctor_id );
                    $description = 'Consultancy refunded. ID# ' . $consultancy_id;
                    if ( $doc_acc_head_id > 0 ) {
                        $ledger = array (
                            'user_id'            => get_logged_in_user_id (),
                            'acc_head_id'        => $doc_acc_head_id,
                            'opd_consultancy_id' => $new_consultancy_id,
                            'trans_date'         => date ( 'Y-m-d' ),
                            'payment_mode'       => 'cash',
                            'paid_via'           => 'cash',
                            'credit'             => ( ( $net_charges * $doctor_charges ) / 100 ),
                            'debit'              => 0,
                            'transaction_type'   => 'credit',
                            'description'        => $description,
                            'date_added'         => current_date_time (),
                        );
                        
                        $this -> AccountModel -> add_ledger ( $ledger );
                        
                        $ledger[ 'acc_head_id' ] = COS_Consultancy_Charges;
                        $ledger[ 'credit' ] = 0;
                        $ledger[ 'transaction_type' ] = 'debit';
                        $ledger[ 'debit' ] = ( ( $net_charges * $doctor_charges ) / 100 );
                        $this -> AccountModel -> add_ledger ( $ledger );
                    }
                }
                
                if ( $discount > 0 ) {
                    $ledger[ 'acc_head_id' ] = discount_consultancy_service;
                    $ledger[ 'credit' ] = 0;
                    $ledger[ 'transaction_type' ] = 'debit';
                    $ledger[ 'debit' ] = ( ( $net_charges * $discount ) / 100 );
                    if ( $patient -> panel_id > 0 ) {
                        $ledger[ 'acc_head_id' ] = discount_consultancy_service_panel;
                    }
                    $this -> AccountModel -> add_ledger ( $ledger );
                }
                
                $log = array (
                    'user_id'        => get_logged_in_user_id (),
                    'consultancy_id' => $_REQUEST[ 'consultancy_id' ],
                    'action'         => 'consultancy_refunded_ledger',
                    'log'            => json_encode ( $ledger ),
                    'after_update'   => '',
                    'date_added'     => current_date_time ()
                );
                $this -> load -> model ( 'LogModel' );
                $this -> LogModel -> create_log ( 'consultancy_logs', $log );
                
                $ledger[ 'acc_head_id' ] = sales_consultancy_service;
                $ledger[ 'credit' ] = $_POST[ 'net_charges' ];
                $ledger[ 'debit' ] = '0';
                $ledger[ 'transaction_type' ] = 'credit';
                $ledger[ 'description' ] = $_POST[ 'description' ];
                if ( $patient -> panel_id > 0 ) {
                    $ledger[ 'acc_head_id' ] = sales_consultancy_service_panel;
                }
                $this -> AccountModel -> add_ledger ( $ledger );
                $this -> LogModel -> create_log ( 'consultancy_logs', $log );
                
                $this -> session -> set_flashdata ( 'response', 'Success! Consultancy refunded. <a href="' . base_url ( '/invoices/consultancy-invoice/' . $new_consultancy_id ) . '" target="_blank" style="font-weight: 800; font-size: 16px">Print</a>' );
            }
            else {
                $this -> session -> set_flashdata ( 'error', 'Error! Please try again.' );
            }
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
    }

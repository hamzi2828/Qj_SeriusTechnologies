<?php
    defined ( 'BASEPATH' ) or exit( 'No direct script access allowed' );
    
    class Histopathology extends CI_Controller {
        
        /**
         * -------------------------
         * Radiology constructor.
         * loads helpers, modal or libraries
         * -------------------------
         */
        
        public function __construct () {
            parent ::__construct ();
            $this -> is_logged_in ();
            $this -> load -> model ( 'DoctorModel' );
            $this -> load -> model ( 'HistopathologyModel' );
            $this -> load -> model ( 'TemplateModel' );
            $this -> load -> model ( 'SampleModel' );
            $this -> load -> model ( 'RadiologyModel' );
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
         * reports main page
         * -------------------------
         */
        
        public function index () {
            $title = site_name . ' - Reports';
            $this -> header ( $title );
            $this -> sidebar ();
            
            /**********PAGINATION***********/
            $limit                          = 10;
            $config                         = array ();
            $config[ "base_url" ]           = base_url ( 'histopathology/histopathology/reports' );
            $total_row                      = $this -> HistopathologyModel -> count_reports ();
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
            
            $data[ 'doctors' ] = $this -> DoctorModel -> get_doctors ();
            $data[ 'reports' ] = $this -> HistopathologyModel -> get_reports ( $config[ "per_page" ], $offset );
            $str_links         = $this -> pagination -> create_links ();
            $data[ "links" ]   = explode ( '&nbsp;', $str_links );
            $this -> load -> view ( '/culture-histopathology/histopathology/index', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * add report main page
         * -------------------------
         */
        
        public function add () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_add_report' )
                $this -> process_add_report ( $_POST );
            
            $title = site_name . ' - Add Report';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'doctors' ]   = $this -> DoctorModel -> get_doctors ();
            $data[ 'templates' ] = $this -> TemplateModel -> get_histopathology_templates ();
            $data[ 'samples' ]   = $this -> SampleModel -> get_samples ();
            $this -> load -> view ( '/culture-histopathology/histopathology/add', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * add report
         * -------------------------
         */
        
        public function process_add_report ( $POST ) {
            $template = $this -> TemplateModel -> get_histopathology_template_by_id ( $POST[ 'template-id' ] );
            $data     = $POST;
            $info     = array (
                'user_id'      => get_logged_in_user_id (),
                'doctor_id'    => $data[ 'doctor_id' ],
                'sale_id'      => $data[ 'sale-id' ],
                'order_by'     => $data[ 'order_by' ],
                'sample_id'    => $data[ 'sample-id' ],
                'study'        => $data[ 'study' ],
                'report_title' => $template -> title,
                'conclusion'   => $data[ 'conclusion' ],
                'date_added'   => current_date_time ()
            );
            $id       = $this -> HistopathologyModel -> add ( $info );
            if ( $id > 0 ) {
                $this -> session -> set_flashdata ( 'response', 'Success! Report added.' );
            }
            else {
                $this -> session -> set_flashdata ( 'error', 'Error! Please try again.' );
            }
            return redirect ( '/invoices/histopathology-report?report-id=' . $id );
        }
        
        /**
         * -------------------------
         * edit reports main page
         * -------------------------
         */
        
        public function edit () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_edit_report' )
                $this -> process_edit_report ( $_POST );
            
            $title = site_name . ' - Edit Reports';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'doctors' ] = $this -> DoctorModel -> get_doctors ();
            $data[ 'report' ]  = $this -> HistopathologyModel -> search ();
            $data[ 'samples' ] = $this -> SampleModel -> get_samples ();
            $this -> load -> view ( '/culture-histopathology/histopathology/search', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * update report
         * -------------------------
         */
        
        public function process_edit_report ( $POST ) {
            $data      = $POST;
            $report_id = $data[ 'report_id' ];
            $info      = array (
                'doctor_id'    => $data[ 'doctor_id' ],
                'order_by'     => $data[ 'order_by' ],
                'sample_id'    => $data[ 'sample-id' ],
                'report_title' => $data[ 'report_title' ],
                'study'        => $data[ 'study' ],
                'conclusion'   => $data[ 'conclusion' ]
            );
            $updated   = $this -> HistopathologyModel -> update_report ( $info, $report_id );
            delete_report_verify_status ( $report_id, 'hmis_histopathology' );
            if ( $updated ) {
                $this -> session -> set_flashdata ( 'response', 'Success! Report updated.' );
            }
            else {
                $this -> session -> set_flashdata ( 'error', 'Error! Please try again.' );
            }
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        /**
         * -------------------------
         * delete report
         * by report id
         * -------------------------
         */
        
        public function delete () {
            $report_id = $this -> uri -> segment ( 4 );
            if ( empty( trim ( $report_id ) ) or !is_numeric ( $report_id ) or $report_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $this -> HistopathologyModel -> delete_report ( $report_id );
            $this -> session -> set_flashdata ( 'response', 'Success! Report deleted.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        public function verify_report () {
            $report_id = $this -> input -> get ( 'report-id' );
            if ( empty( trim ( $report_id ) ) or !is_numeric ( $report_id ) or $report_id < 1 )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $this -> RadiologyModel -> verify_report ( $report_id, 'hmis_histopathology' );
            $this -> session -> set_flashdata ( 'response', 'Success! Report verified.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
        }
    }

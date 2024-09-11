<?php
    
    defined ( 'BASEPATH' ) or exit( 'No direct script access allowed' );
    
    class IPDReporting extends CI_Controller {
        
        /**
         * -------------------------
         * GeneralReporting constructor.
         * loads helpers, modal or libraries
         * -------------------------
         */
        
        public function __construct () {
            parent ::__construct ();
            $this -> is_logged_in ();
            $this -> load -> model ( 'IPDModel' );
            $this -> load -> model ( 'PatientModel' );
            $this -> load -> model ( 'PanelModel' );
            $this -> load -> model ( 'DoctorModel' );
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
         * General summary report
         * display summary report of
         * lab, opd, ipd
         * -------------------------
         */
        
        public function general_report_cash () {
            $title = site_name . ' - IPD Reporting (Cash)';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'discharged' ] = false;
            $data[ 'sales' ] = $this -> IPDModel -> get_cash_sales_report ();
            $data[ 'patients' ] = $this -> PatientModel -> get_patients ();
            $this -> load -> view ( '/ipd-reports/general-report-cash.php', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * General summary report
         * display summary report of
         * lab, opd, ipd
         * -------------------------
         */
        
        public function general_report_panel () {
            $title = site_name . ' - IPD Reporting (Panel)';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'discharged' ] = false;
            $data[ 'sales' ] = $this -> IPDModel -> get_panel_sales_report ();
            $data[ 'patients' ] = $this -> PatientModel -> get_patients ();
            $data[ 'panels' ] = $this -> PanelModel -> get_panels ();
            $this -> load -> view ( '/ipd-reports/general-report-panel.php', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * Consultant commission report
         * -------------------------
         */
        
        public function consultant_commission () {
            $title = site_name . ' - Consultant Commission';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'discharged' ] = false;
            $data[ 'doctors' ] = $this -> DoctorModel -> get_doctors ();
            $data[ 'panels' ] = $this -> PanelModel -> get_panels ();
            $data[ 'services' ] = $this -> IPDModel -> get_all_services ();
            $data[ 'sales' ] = $this -> IPDModel -> get_consultant_commission ();
            $this -> load -> view ( '/ipd-reports/consultant-commission', $data );
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * OT Timings report
         * -------------------------
         */
        
        public function ot_timings () {
            $title = site_name . ' - OT Timings';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'timings' ] = $this -> IPDModel -> get_ot_timings_by_filter ();
            $data[ 'services' ] = $this -> IPDModel -> get_parent_services ();
            $this -> load -> view ( '/ipd-reports/ot-timings', $data );
            $this -> footer ();
        }
        
    }

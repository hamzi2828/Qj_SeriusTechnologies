<?php
    defined ( 'BASEPATH' ) or exit( 'No direct script access allowed' );
    
    class RadiologyModel extends CI_Model {
        
        /**
         * ----------------
         * RadiologyModel constructor.
         * ----------------
         */
        
        public function __construct () {
            parent ::__construct ();
        }
        
        /**
         * ----------------
         * @param $info
         * @return mixed
         * save xray report
         * ----------------
         */
        
        public function add_xray_report ( $info ) {
            $this -> db -> insert ( 'xray', $info );
            return $this -> db -> insert_id ();
        }
        
        /**
         * ----------------
         * @param $info
         * @return mixed
         * save ultrasound report
         * ----------------
         */
        
        public function add_ultrasound_report ( $info ) {
            $this -> db -> insert ( 'ultrasound', $info );
            return $this -> db -> insert_id ();
        }
        
        /**
         * ----------------
         * @param $report_id
         * @return mixed
         * get xray report by id
         * ----------------
         */
        
        public function get_xray_report_by_id ( $report_id ) {
            $report = $this -> db -> get_where ( 'xray', array ( 'id' => $report_id ) );
            return $report -> row ();
        }
        
        /**
         * ----------------
         * @param $report_id
         * @return mixed
         * get xray report by id
         * ----------------
         */
        
        public function get_ultrasound_report_by_id ( $report_id ) {
            $report = $this -> db -> get_where ( 'ultrasound', array ( 'id' => $report_id ) );
            return $report -> row ();
        }
        
        /**
         * ----------------
         * @return mixed
         * count xray reports
         * ----------------
         */
        
        public function count_xray_reports () {
            $sql = "Select COUNT(*) as totalRows from hmis_xray where 1";
            if ( isset( $_REQUEST[ 'invoice-id' ] ) and $_REQUEST[ 'invoice-id' ] > 0 ) {
                $id  = $_REQUEST[ 'invoice-id' ];
                $sql .= " and sale_id=$id";
            }
            if ( isset( $_REQUEST[ 'patient_id' ] ) and $_REQUEST[ 'patient_id' ] > 0 ) {
                $patient_id = $_REQUEST[ 'patient_id' ];
                $sql        .= " and patient_id=$patient_id";
            }
            if ( isset( $_REQUEST[ 'doctor_id' ] ) and $_REQUEST[ 'doctor_id' ] > 0 ) {
                $doctor_id = $_REQUEST[ 'doctor_id' ];
                $sql       .= " and doctor_id=$doctor_id";
            }
            if ( isset( $_REQUEST[ 'name' ] ) and !empty( trim ( $_REQUEST[ 'name' ] ) ) ) {
                $name = $_REQUEST[ 'name' ];
                $sql  .= " and patient_id IN (select id from hmis_patients where name LIKE '%$name%')";
            }
            if ( isset( $_REQUEST[ 'report_title' ] ) and !empty( trim ( $_REQUEST[ 'report_title' ] ) ) ) {
                $report_title = $_REQUEST[ 'report_title' ];
                $sql          .= " and report_title='$report_title'";
            }
            $reports = $this -> db -> query ( $sql );
            return $reports -> row () -> totalRows;
        }
        
        /**
         * ----------------
         * @param $offset
         * @param $limit
         * @return mixed
         * get xray reports
         * ----------------
         */
        
        public function get_xray_reports ( $limit, $offset ) {
            $sql = "Select * from hmis_xray where 1";
            if ( isset( $_REQUEST[ 'invoice-id' ] ) and $_REQUEST[ 'invoice-id' ] > 0 ) {
                $id  = $_REQUEST[ 'invoice-id' ];
                $sql .= " and sale_id=$id";
            }
            if ( isset( $_REQUEST[ 'patient_id' ] ) and $_REQUEST[ 'patient_id' ] > 0 ) {
                $patient_id = $_REQUEST[ 'patient_id' ];
                $sql        .= " and patient_id=$patient_id";
            }
            if ( isset( $_REQUEST[ 'doctor_id' ] ) and $_REQUEST[ 'doctor_id' ] > 0 ) {
                $doctor_id = $_REQUEST[ 'doctor_id' ];
                $sql       .= " and doctor_id=$doctor_id";
            }
            if ( isset( $_REQUEST[ 'name' ] ) and !empty( trim ( $_REQUEST[ 'name' ] ) ) ) {
                $name = $_REQUEST[ 'name' ];
                $sql  .= " and patient_id IN (select id from hmis_patients where name LIKE '%$name%')";
            }
            if ( isset( $_REQUEST[ 'report_title' ] ) and !empty( trim ( $_REQUEST[ 'report_title' ] ) ) ) {
                $report_title = $_REQUEST[ 'report_title' ];
                $sql          .= " and report_title='$report_title'";
            }
            $sql     .= " order by id DESC limit $limit offset $offset";
            $reports = $this -> db -> query ( $sql );
            return $reports -> result ();
        }
        
        /**
         * ----------------
         * @return mixed
         * count ultrasound reports
         * ----------------
         */
        
        public function count_ultrasound_reports () {
            $sql = "Select COUNT(*) as totalRows from hmis_ultrasound where 1";
            if ( isset( $_REQUEST[ 'id' ] ) and $_REQUEST[ 'id' ] > 0 ) {
                $id  = $_REQUEST[ 'id' ];
                $sql .= " and sale_id=$id";
            }
            if ( isset( $_REQUEST[ 'patient_id' ] ) and $_REQUEST[ 'patient_id' ] > 0 ) {
                $patient_id = $_REQUEST[ 'patient_id' ];
                $sql        .= " and patient_id=$patient_id";
            }
            if ( isset( $_REQUEST[ 'doctor_id' ] ) and $_REQUEST[ 'doctor_id' ] > 0 ) {
                $doctor_id = $_REQUEST[ 'doctor_id' ];
                $sql       .= " and doctor_id=$doctor_id";
            }
            if ( isset( $_REQUEST[ 'name' ] ) and !empty( trim ( $_REQUEST[ 'name' ] ) ) ) {
                $name = $_REQUEST[ 'name' ];
                $sql  .= " and patient_id IN (select id from hmis_patients where name LIKE '%$name%')";
            }
            if ( isset( $_REQUEST[ 'report_title' ] ) and !empty( trim ( $_REQUEST[ 'report_title' ] ) ) ) {
                $report_title = $_REQUEST[ 'report_title' ];
                $sql          .= " and report_title='$report_title'";
            }
            $reports = $this -> db -> query ( $sql );
            return $reports -> row () -> totalRows;
        }
        
        /**
         * ----------------
         * @param $limit
         * @param $offset
         * @return mixed
         * get ultrasound reports
         * ----------------
         */
        
        public function get_ultrasound_reports ( $limit, $offset ) {
            $sql = "Select * from hmis_ultrasound where 1";
            if ( isset( $_REQUEST[ 'id' ] ) and $_REQUEST[ 'id' ] > 0 ) {
                $id  = $_REQUEST[ 'id' ];
                $sql .= " and sale_id=$id";
            }
            if ( isset( $_REQUEST[ 'patient_id' ] ) and $_REQUEST[ 'patient_id' ] > 0 ) {
                $patient_id = $_REQUEST[ 'patient_id' ];
                $sql        .= " and patient_id=$patient_id";
            }
            if ( isset( $_REQUEST[ 'doctor_id' ] ) and $_REQUEST[ 'doctor_id' ] > 0 ) {
                $doctor_id = $_REQUEST[ 'doctor_id' ];
                $sql       .= " and doctor_id=$doctor_id";
            }
            if ( isset( $_REQUEST[ 'name' ] ) and !empty( trim ( $_REQUEST[ 'name' ] ) ) ) {
                $name = $_REQUEST[ 'name' ];
                $sql  .= " and patient_id IN (select id from hmis_patients where name LIKE '%$name%')";
            }
            if ( isset( $_REQUEST[ 'report_title' ] ) and !empty( trim ( $_REQUEST[ 'report_title' ] ) ) ) {
                $report_title = $_REQUEST[ 'report_title' ];
                $sql          .= " and report_title='$report_title'";
            }
            $sql     .= " order by id DESC limit $limit offset $offset";
            $reports = $this -> db -> query ( $sql );
            return $reports -> result ();
        }
        
        /**
         * ----------------
         * @param $report_id
         * @return mixed
         * get xray reports
         * ----------------
         */
        
        public function delete_xray_report ( $report_id ) {
            $this -> db -> delete ( 'xray', array ( 'id' => $report_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * ----------------
         * @param $report_id
         * @return mixed
         * get ultrasound reports
         * ----------------
         */
        
        public function delete_ultrasound_report ( $report_id ) {
            $this -> db -> delete ( 'ultrasound', array ( 'id' => $report_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * ----------------
         * @return mixed
         * search xray report
         * ----------------
         */
        
        public function search_xray_report () {
            $search = false;
            $sql    = "Select * from hmis_xray where 1";
            if ( isset( $_REQUEST[ 'report-id' ] ) and !empty( trim ( $_REQUEST[ 'report-id' ] ) ) ) {
                $report_id = $_REQUEST[ 'report-id' ];
                $sql       .= " and id=$report_id";
                $search    = true;
            }
            if ( isset( $_REQUEST[ 'patient_id' ] ) and !empty( trim ( $_REQUEST[ 'patient_id' ] ) ) ) {
                $patient_id = $_REQUEST[ 'patient_id' ];
                $sql        .= " and patient_id=$patient_id";
                $search     = true;
            }
            if ( isset( $_REQUEST[ 'doctor_id' ] ) and !empty( trim ( $_REQUEST[ 'doctor_id' ] ) ) ) {
                $doctor_id = $_REQUEST[ 'doctor_id' ];
                $sql       .= " and doctor_id=$doctor_id";
                $search    = true;
            }
            if ( isset( $_REQUEST[ 'order_by' ] ) and !empty( trim ( $_REQUEST[ 'order_by' ] ) ) ) {
                $order_by = $_REQUEST[ 'order_by' ];
                $sql      .= " and order_by=$order_by";
                $search   = true;
            }
            if ( isset( $_REQUEST[ 'date' ] ) and !empty( trim ( $_REQUEST[ 'date' ] ) ) ) {
                $date   = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'date' ] ) );
                $sql    .= " and DATE(date_added)='$date'";
                $search = true;
            }
            $sql    .= " order by id DESC limit 1";
            $report = $this -> db -> query ( $sql );
            if ( $search )
                return $report -> row ();
            else
                return false;
        }
        
        /**
         * ----------------
         * @return mixed
         * search ultrasound report
         * ----------------
         */
        
        public function search_ultrasound_report () {
            $search = false;
            $sql    = "Select * from hmis_ultrasound where 1";
            if ( isset( $_REQUEST[ 'report-id' ] ) and !empty( trim ( $_REQUEST[ 'report-id' ] ) ) ) {
                $search    = true;
                $report_id = $_REQUEST[ 'report-id' ];
                $sql       .= " and id=$report_id";
            }
            if ( isset( $_REQUEST[ 'patient_id' ] ) and !empty( trim ( $_REQUEST[ 'patient_id' ] ) ) ) {
                $search     = true;
                $patient_id = $_REQUEST[ 'patient_id' ];
                $sql        .= " and patient_id=$patient_id";
            }
            if ( isset( $_REQUEST[ 'doctor_id' ] ) and !empty( trim ( $_REQUEST[ 'doctor_id' ] ) ) ) {
                $search    = true;
                $doctor_id = $_REQUEST[ 'doctor_id' ];
                $sql       .= " and doctor_id=$doctor_id";
            }
            if ( isset( $_REQUEST[ 'order_by' ] ) and !empty( trim ( $_REQUEST[ 'order_by' ] ) ) ) {
                $search   = true;
                $order_by = $_REQUEST[ 'order_by' ];
                $sql      .= " and order_by=$order_by";
            }
            if ( isset( $_REQUEST[ 'date' ] ) and !empty( trim ( $_REQUEST[ 'date' ] ) ) ) {
                $search = true;
                $date   = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'date' ] ) );
                $sql    .= " and DATE(date_added)='$date'";
            }
            $sql    .= " order by id DESC limit 1";
            $report = $this -> db -> query ( $sql );
            if ( $search )
                return $report -> row ();
        }
        
        /**
         * ----------------
         * @param $info
         * @param $report_id
         * @return mixed
         * update xray report
         * ----------------
         */
        
        public function update_xray_report ( $info, $report_id ) {
            $this -> db -> update ( 'xray', $info, array ( 'id' => $report_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * ----------------
         * @param $info
         * @param $report_id
         * @return mixed
         * update ultrasound report
         * ----------------
         */
        
        public function update_ultrasound_report ( $info, $report_id ) {
            $this -> db -> update ( 'ultrasound', $info, array ( 'id' => $report_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * ----------------
         * @param $info
         * @return mixed
         * save abdomen ultrasound report of female
         * ----------------
         */
        
        public function add_abdomen_pelvis_female ( $info ) {
            $this -> db -> insert ( 'abdomen_pelvis_female', $info );
            return $this -> db -> insert_id ();
        }
        
        /**
         * ----------------
         * @param $info
         * @return mixed
         * save abdomen ultrasound report of kidney female
         * ----------------
         */
        
        public function add_abdomen_pelvis_kidney_female ( $info ) {
            $this -> db -> insert ( 'abdomen_pelvis_kidney_female', $info );
            return $this -> db -> insert_id ();
        }
        
        /**
         * ----------------
         * @param $report_id
         * @return mixed
         * get abdomen female report
         * ----------------
         */
        
        public function get_abdomen_female_report ( $report_id ) {
            $query = $this -> db -> get_where ( 'abdomen_pelvis_female', array ( 'id' => $report_id ) );
            return $query -> row ();
        }
        
        /**
         * ----------------
         * @param $report_id
         * @return mixed
         * get abdomen female kidney report
         * ----------------
         */
        
        public function get_abdomen_female_kidney_report ( $report_id ) {
            $query = $this -> db -> get_where ( 'abdomen_pelvis_kidney_female', array ( 'abdomen_pelvis_id' => $report_id ) );
            return $query -> row ();
        }
        
        /**
         * ----------------
         * @param $report_id
         * @param $info
         * @return mixed
         * update abdomen female report
         * ----------------
         */
        
        public function update_abdomen_pelvis_female ( $info, $report_id ) {
            $this -> db -> update ( 'abdomen_pelvis_female', $info, array ( 'id' => $report_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * ----------------
         * @param $report_id
         * @param $info
         * @return mixed
         * update abdomen female kidney report
         * ----------------
         */
        
        public function update_abdomen_pelvis_kidney_female ( $info, $report_id ) {
            $this -> db -> update ( 'abdomen_pelvis_kidney_female', $info, array ( 'abdomen_pelvis_id' => $report_id ) );
            return $this -> db -> affected_rows ();
        }
        
        public function get_report_verify_status ( $report_id, $table ) {
            $this -> db -> order_by ( 'id', 'DESC' );
            $this -> db -> limit ( 1 );
            $status = $this -> db -> get_where ( 'lab_reports_status', array ( 'report_id' => $report_id, '_table' => $table ) );
            return $status -> row ();
        }
        
        public function verify_report ( $report_id, $table ) {
            $this -> db -> insert ( 'lab_reports_status', array ( 'user_id' => get_logged_in_user_id (), 'report_id' => $report_id, '_table' => $table ) );
        }
        
        public function delete_report_verify_status ( $report_id, $table ) {
            $this -> db -> delete ( 'lab_reports_status', array ( 'report_id' => $report_id, '_table' => $table ) );
        }
        
        public function load_added_reports ( $invoice_id, $table ) {
            $reports = $this -> db -> get_where ( $table, array ( 'sale_id' => $invoice_id ) );
            return $reports -> result ();
        }
        
    }
<?php
    defined ( 'BASEPATH' ) or exit( 'No direct script access allowed' );
    
    class DoctorModel extends CI_Model {
        
        /**
         * -------------------------
         * DoctorModel constructor.
         * -------------------------
         */
        
        public function __construct () {
            parent ::__construct ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @return mixed
         * save doctors into database
         * -------------------------
         */
        
        public function add ( $data ) {
            $this -> db -> insert ( 'doctors', $data );
            return $this -> db -> insert_id ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @return mixed
         * save doctors services into database
         * -------------------------
         */
        
        public function add_doctor_services ( $data ) {
            $this -> db -> insert ( 'doctor_services', $data );
            return $this -> db -> insert_id ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @return mixed
         * save specializations into database
         * -------------------------
         */
        
        public function add_specialization ( $data ) {
            $this -> db -> insert ( 'specializations', $data );
            return $this -> db -> insert_id ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get all specializations
         * -------------------------
         */
        
        public function get_specializations () {
            $specializations = $this -> db -> get ( 'specializations' );
            return $specializations -> result ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get all doctors
         * -------------------------
         */
        
        public function get_doctors () {
            $doctors = $this -> db -> get ( 'doctors' );
            return $doctors -> result ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get anesthesiologists
         * -------------------------
         */
        
        public function get_anesthesiologists () {
            $doctors = $this -> db -> get_where ( 'doctors', array ( 'anesthesiologist' => '1' ) );
            return $doctors -> result ();
        }
        
        /**
         * -------------------------
         * @param $doctor_id
         * get doctor by id
         * -------------------------
         * @return mixed
         */
        
        public function get_doctor_id ( $doctor_id ) {
            $doctor = $this -> db -> get_where ( 'doctors', array ( 'id' => $doctor_id ) );
            return $doctor -> row ();
        }
        
        /**
         * -------------------------
         * @param $specialization_id
         * @return mixed
         * delete specializations
         * -------------------------
         */
        
        public function delete_specialization ( $specialization_id ) {
            $this -> db -> delete ( 'specializations', array ( 'id' => $specialization_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $specialization_id
         * get specialization by id
         * -------------------------
         * @return mixed
         */
        
        public function get_specialization_by_id ( $specialization_id ) {
            $specialization = $this -> db -> get_where ( 'specializations', array ( 'id' => $specialization_id ) );
            return $specialization -> row ();
        }
        
        /**
         * -------------------------
         * @param $info
         * @param $specialization_id
         * @return mixed
         * update specialization
         * -------------------------
         */
        
        public function edit_specialization ( $info, $specialization_id ) {
            $this -> db -> update ( 'specializations', $info, array ( 'id' => $specialization_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $info
         * @param $doctor_id
         * @return mixed
         * update doctor
         * -------------------------
         */
        
        public function edit ( $info, $doctor_id ) {
            $this -> db -> update ( 'doctors', $info, array ( 'id' => $doctor_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $doctor_id
         * @return mixed
         * delete doctor
         * -------------------------
         */
        
        public function delete ( $doctor_id ) {
            $this -> db -> delete ( 'doctors', array ( 'id' => $doctor_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $specialization_id
         * @param $panel_id
         * @return mixed
         * get doctors by specialization id
         * -------------------------
         */
        
        public function get_doctors_by_specializations ( $specialization_id, $panel_id = 0 ) {
            $sql = "Select * from hmis_doctors where specialization_id=$specialization_id";
            if ( $panel_id > 0 ) {
                $sql .= " and id IN (Select doctor_id from hmis_panel_doctors where panel_id=$panel_id)";
            }
            $doctors = $this -> db -> query ( $sql );
            return $doctors -> result ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @return mixed
         * do_add_follow_up into database
         * -------------------------
         */
        
        public function do_add_follow_up ( $data ) {
            $this -> db -> insert ( 'follow_ups', $data );
            return $this -> db -> insert_id ();
        }
        
        /**
         * -------------------------
         * @param $follow_up
         * @return mixed
         * delete_follow_up
         * -------------------------
         */
        
        public function delete_follow_up ( $follow_up ) {
            $this -> db -> delete ( 'follow_ups', array ( 'id' => $follow_up ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get_follow_up
         * -------------------------
         */
        
        public function get_follow_up () {
            $doctors = $this -> db -> get ( 'follow_ups' );
            return $doctors -> result ();
        }
        
        /**
         * -------------------------
         * @param $follow_up_id
         * @return mixed
         * get get_follow_up_by_id
         * -------------------------
         */
        
        public function get_follow_up_by_id ( $follow_up_id ) {
            $doctors = $this -> db -> get_where ( 'follow_ups', array ( 'id' => $follow_up_id ) );
            return $doctors -> row ();
        }
        
        /**
         * -------------------------
         * @param $info
         * @param $follow_up_id
         * @return mixed
         * update do_edit_follow_up_id
         * -------------------------
         */
        
        public function do_edit_follow_up_id ( $info, $follow_up_id ) {
            $this -> db -> update ( 'follow_ups', $info, array ( 'id' => $follow_up_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $doctor_id
         * @return mixed
         * get doctor services
         * -------------------------
         */
        
        public function get_doctor_services ( $doctor_id ) {
            $services = $this -> db -> get_where ( 'doctor_services', array ( 'doctor_id' => $doctor_id ) );
            return $services -> result ();
        }
        
        /**
         * -------------------------
         * @param $doctor_id
         * @return mixed
         * delete doctor services
         * -------------------------
         */
        
        public function delete_doctor_services ( $doctor_id ) {
            $this -> db -> delete ( 'doctor_services', array ( 'doctor_id' => $doctor_id ) );
        }
        
        /**
         * -------------------------
         * @param $service_id
         * @param $doctor_id
         * @return int
         * get doctor percentage value
         * -------------------------
         */
        
        public function get_doctor_percentage_value_by_service_id ( $service_id, $doctor_id ) {
            $percentage = $this -> db -> get_where ( 'doctor_services', array (
                'service_id' => $service_id,
                'doctor_id'  => $doctor_id
            ) );
            if ( $percentage -> num_rows () > 0 )
                return $percentage -> row ();
            else
                return 0;
        }
        
        /**
         * -------------------------
         * @return mixed
         * get doctors by filter
         * -------------------------
         */
        
        public function get_doctors_by_filter () {
            $search = false;
            $sql = "Select * from hmis_doctors where 1";
            if ( isset( $_REQUEST[ 'doctor_id' ] ) and !empty( trim ( $_REQUEST[ 'doctor_id' ] ) ) and $_REQUEST[ 'doctor_id' ] > 0 ) {
                $doctor_id = $_REQUEST[ 'doctor_id' ];
                $sql .= " and id=$doctor_id";
                $search = true;
            }
            $query = $this -> db -> query ( $sql );
            if ( $search )
                return $query -> result ();
            else
                return array ();
        }
        
        /**
         * -------------------------
         * @param $doctor_id
         * @param $panel_id
         * @return mixed
         * get doctor panel
         * -------------------------
         */
        
        public function get_doctor_panel ( $doctor_id, $panel_id ) {
            $panel = $this -> db -> get_where ( 'panel_doctors', array (
                'doctor_id' => $doctor_id,
                'panel_id'  => $panel_id
            ) );
            return $panel -> row ();
        }
        
    }
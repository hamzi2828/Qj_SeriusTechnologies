<?php
    
    class MedicalTestModel extends CI_Model {
        
        public function all ( $limit, $offset ) {
            $receipt_no = $this -> input -> get ( 'receipt-no', true );
            $oep_id     = $this -> input -> get ( 'oep-id', true );
            $lab_no     = $this -> input -> get ( 'lab-no', true );
            $name       = $this -> input -> get ( 'name', true );
            $cnic       = $this -> input -> get ( 'cnic', true );
            
            $this -> db -> limit ( $limit, $offset );
            $this -> db -> order_by ( 'id', 'DESC' );
            $this -> db -> select ( '*' ) -> from ( 'medical_tests' );
            
            if ( !empty( trim ( $receipt_no ) ) )
                $this -> db -> where ( "id=$receipt_no" );
            
            if ( !empty( trim ( $oep_id ) ) )
                $this -> db -> where ( "oep_id=$oep_id" );
            
            if ( !empty( trim ( $lab_no ) ) )
                $this -> db -> where ( "lab_no=$lab_no" );
            
            if ( !empty( trim ( $name ) ) )
                $this -> db -> where ( "name LIKE '%$name%'" );
            
            if ( !empty( trim ( $cnic ) ) )
                $this -> db -> where ( "identity='$cnic'" );
            
            $tests = $this -> db -> get ();
            return $tests -> result ();
        }
        
        public function count_tests () {
            $receipt_no = $this -> input -> get ( 'receipt-no', true );
            $oep_id     = $this -> input -> get ( 'oep-id', true );
            $lab_no     = $this -> input -> get ( 'lab-no', true );
            $name       = $this -> input -> get ( 'name', true );
            $cnic       = $this -> input -> get ( 'cnic', true );
            
            $this -> db -> select ( '*' ) -> from ( 'medical_tests' );
            
            if ( !empty( trim ( $receipt_no ) ) )
                $this -> db -> where ( "id=$receipt_no" );
            
            if ( !empty( trim ( $oep_id ) ) )
                $this -> db -> where ( "oep_id=$oep_id" );
            
            if ( !empty( trim ( $lab_no ) ) )
                $this -> db -> where ( "lab_no=$lab_no" );
            
            if ( !empty( trim ( $name ) ) )
                $this -> db -> where ( "name LIKE '%$name%'" );
            
            if ( !empty( trim ( $cnic ) ) )
                $this -> db -> where ( "identity='$cnic'" );
            
            $tests = $this -> db -> get ();
            return $tests -> num_rows ();
        }
        
        public function add ( $info ) {
            $this -> db -> insert ( 'medical_tests', $info );
            return $this -> db -> insert_id ();
        }
        
        public function get_medical_test ( $id ) {
            $test = $this -> db -> get_where ( 'medical_tests', array ( 'id' => $id ) );
            return $test -> row ();
        }
        
        public function get_medical_test_history ( $id ) {
            $test = $this -> db -> get_where ( 'medical_test_history', array ( 'medical_test_id' => $id ) );
            return $test -> row ();
        }
         
        public function get_medical_test_physical_examination ( $id ) {
            $test = $this -> db -> get_where ( 'medical_test_physical_examination', array ( 'medical_test_id' => $id ) );
            return $test -> row ();
        }
        
        public function get_medical_test_lab_investigation ( $id ) {
            $test = $this -> db -> get_where ( 'medical_test_lab_investigation', array ( 'medical_test_id' => $id ) );
            return $test -> row ();
        }
        
        public function edit ( $info, $id ) {
            $this -> db -> update ( 'medical_tests', $info, array ( 'id' => $id ) );
        }
        
        public function delete_history ( $medical_test_id ) {
            $this -> db -> delete ( 'medical_test_history', array ( 'medical_test_id' => $medical_test_id ) );
        }
        
        public function upsert_history ( $info ) {
            $this -> db -> insert ( 'medical_test_history', $info );
            return $this -> db -> insert_id ();
        }
        
        public function delete_general_physical_examination ( $medical_test_id ) {
            $this -> db -> delete ( 'medical_test_physical_examination', array ( 'medical_test_id' => $medical_test_id ) );
        }
        
        public function upsert_general_physical_examination ( $info ) {
            $this -> db -> insert ( 'medical_test_physical_examination', $info );
            return $this -> db -> insert_id ();
        }
        
        public function delete_lab_investigation ( $medical_test_id ) {
            $this -> db -> delete ( 'medical_test_lab_investigation', array ( 'medical_test_id' => $medical_test_id ) );
        }
        
        public function delete_lab_investigation_custom($medical_test_id) {
            // Delete rows from the custom table based on the medical_test_id
            $this->db->where('medical_test_id', $medical_test_id);
            $this->db->delete('hmis_medical_test_lab_investigation_custom');
            
            // Check if the deletion was successful
            if ($this->db->affected_rows() > 0) {
                return true;
            } else {
                return false;
            }
        }
        

        
        public function add_lab_investigation ( $info ) {
            $this -> db -> insert ( 'medical_test_lab_investigation', $info );
            return $this -> db -> insert_id ();
        }

        public function add_custom_lab_investigation($data) {
            $this->db->insert('hmis_medical_test_lab_investigation_custom', $data);
            return $this->db->insert_id();
        }
        

        
        public function destroy ( $id ) {
            $this -> db -> delete ( 'medical_tests', array ( 'id' => $id ) );
        }
        
        public function status ( $id ) {
            $test   = $this -> get_medical_test ( $id );
            $status = $test -> fit === '1' ? 0 : 1;
            $this -> db -> update ( 'medical_tests', array ( 'fit' => $status ), array ( 'id' => $id ) );
        }
        
        public function filter_report () {
            $start_date = $this -> input -> get ( 'start-date' );
            $end_date   = $this -> input -> get ( 'end-date' );
            $oep_id     = $this -> input -> get ( 'oep-id' );
            $search     = false;
            
            $tests = $this -> db -> select ( '*' ) -> from ( 'medical_tests' );
            
            if ( !empty( trim ( $start_date ) ) && !empty( trim ( $end_date ) ) ) {
                $search     = true;
                $start_date = date ( 'Y-m-d', strtotime ( $start_date ) );
                $end_date   = date ( 'Y-m-d', strtotime ( $end_date ) );
                $tests -> where ( "DATE(created_at) BETWEEN '$start_date' AND '$end_date'" );
            }
            
            if ( !empty( trim ( $oep_id ) ) ) {
                $search = true;
                $tests -> where ( "oep_id=$oep_id" );
            }
            
            $tests = $tests -> get ();
            return $search ? $tests -> result () : array ();
        }
        
        public function generate_lab_no () {
            
            $ope_id     = $this -> input -> post ( 'oep-id' );
            $sql        = $this -> db -> get_where ( 'oep', array ( 'id' => $ope_id ) );
            $ope        = $sql -> row ();
            $ope_prefix = $ope -> prefix;
            
            $this -> db -> order_by ( 'id', 'DESC' );
            $this -> db -> limit ( 1 );
            $sql = $this -> db -> get_where ( 'medical_tests', array ( 'lab_no_prefix' => $ope_prefix ) );
            
            if ( $sql -> num_rows () > 0 ) {
                $test   = $sql -> row ();
                $lab_no = $test -> lab_no;
                return ( $lab_no + 1 );
            }
            return 1000;
            
        }
        
        public function validate_cnic ( $cnic ) {
            $sql = $this -> db -> get_where ( 'medical_tests', array ( 'identity' => $cnic ) );
            return $sql -> num_rows () > 0;
        }

        public function get_template_rows_by_medical_test_id ($medical_test_id) {
            $this->db->select('*');
            $this->db->from('hmis_medical_test_lab_investigation_custom');
            $this->db->where('medical_test_id', $medical_test_id);
            $query = $this->db->get();
            return $query->result();
        }
    }
<?php
    
    class OEPModel extends CI_Model {
        
        public function all () {
            $this -> db -> order_by ( 'name', 'ASC' );
            $tests = $this -> db -> get ( 'oep' );
            return $tests -> result ();
        }
        
        public function add ( $info ) {
            $this -> db -> insert ( 'oep', $info );
            return $this -> db -> insert_id ();
        }
        
        public function get_oep ( $id ) {
            $test = $this -> db -> get_where ( 'oep', array ( 'id' => $id ) );
            return $test -> row ();
        }
        
        public function edit ( $info, $id ) {
            $this -> db -> update ( 'oep', $info, array ( 'id' => $id ) );
        }
        
        public function destroy ( $id ) {
            $this -> db -> delete ( 'oep', array ( 'id' => $id ) );
        }
        
    }
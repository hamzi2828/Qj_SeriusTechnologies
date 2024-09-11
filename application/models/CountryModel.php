<?php
    
    class CountryModel extends CI_Model {
        
        public function all () {
            $countries = $this -> db -> get ( 'countries' );
            return $countries -> result ();
        }
        
        public function get_country_by_id ( $id ) {
            $test = $this -> db -> get_where ( 'countries', array ( 'id' => $id ) );
            return $test -> row ();
        }
        
    }
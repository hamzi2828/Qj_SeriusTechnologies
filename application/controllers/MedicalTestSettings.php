<?php
    
    class MedicalTestSettings extends CI_Controller {
        
        public function __construct () {
            parent ::__construct ();
            $this -> is_logged_in ();
            $this -> load -> model ( 'OEPModel' );
            $this -> load -> model ( 'CountryModel' );
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
        
        public function all_oep () {
            $title = site_name . ' - All OEP';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'oep' ]   = $this -> OEPModel -> all ();
            $data[ 'title' ] = 'All OEP';
            $this -> load -> view ( '/medical-test-settings/oep/index', $data );
            $this -> footer ();
        }
        
        public function add_oep () {
            
            if ( $this -> input -> post ( 'action' ) && $this -> input -> post ( 'action' ) == 'store_oep' )
                $this -> store_oep ();
            
            $title = site_name . ' - Add OEP';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'title' ] = 'Add OEP';
            $this -> load -> view ( '/medical-test-settings/oep/add', $data );
            $this -> footer ();
        }
        
        public function store_oep () {
            $info = array (
                'user_id'        => get_logged_in_user_id (),
                'prefix'         => $this -> input -> post ( 'prefix', true ),
                'name'           => $this -> input -> post ( 'name', true ),
                'representative' => $this -> input -> post ( 'representative', true ),
                'contact'        => $this -> input -> post ( 'contact', true ),
                'address'        => $this -> input -> post ( 'address', true ),
                'price'          => $this->input->post('price', true),
            );
            $id   = $this -> OEPModel -> add ( $info );
            if ( $id > 0 ) {
                $this -> session -> set_flashdata ( 'response', 'Success! OEP added.' );
                return redirect ( base_url ( '/medical-test-settings/oep/create' ) );
            }
            else {
                $this -> session -> set_flashdata ( 'error', 'Error! OEP not added. Please try again' );
                return redirect ( base_url ( '/medical-test-settings/oep/create' ) );
            }
        }
        
        public function edit_oep ( $id ) {
            
            if ( $this -> input -> post ( 'action' ) && $this -> input -> post ( 'action' ) == 'update_oep' )
                $this -> update_oep ( $id );
            
            $title = site_name . ' - Edit OEP';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'title' ] = 'Edit OEP';
            $data[ 'oep' ]   = $this -> OEPModel -> get_oep ( $id );
            $this -> load -> view ( '/medical-test-settings/oep/edit', $data );
            $this -> footer ();
        }
        
        public function update_oep ( $id ) {
            $info = array (
                'prefix'         => $this -> input -> post ( 'prefix', true ),
                'name'           => $this -> input -> post ( 'name', true ),
                'representative' => $this -> input -> post ( 'representative', true ),
                'contact'        => $this -> input -> post ( 'contact', true ),
                'address'        => $this -> input -> post ( 'address', true ),
                'price'          => $this->input->post('price', true),
            );
            $this -> OEPModel -> edit ( $info, $id );
            $this -> session -> set_flashdata ( 'response', 'Success! OEP updated.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }
        
        public function delete_oep ( $id ) {
            $this -> OEPModel -> destroy ( $id );
            $this -> session -> set_flashdata ( 'response', 'Success! OEP deleted.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        }




        public function edit_template ( $id ) {
            
            var_dump($id);

        }
        
    }
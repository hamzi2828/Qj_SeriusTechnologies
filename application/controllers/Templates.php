<?php
    
    defined ( 'BASEPATH' ) or exit( 'No direct script access allowed' );
    
    class Templates extends CI_Controller {
        
        /**
         * ----------
         * Templates constructor.
         * loads helpers, modal or libraries
         * ----------
         */
        
        public function __construct () {
            parent ::__construct ();
            $this -> is_logged_in ();
            $this -> load -> model ( 'TemplateModel' );
        }
        
        /**
         * ----------
         * @param $title
         * header template
         * ----------
         */
        
        public function header ( $title ) {
            $data[ 'title' ] = $title;
            $this -> load -> view ( '/includes/admin/header', $data );
        }
        
        /**
         * ----------
         * sidebar template
         * ----------
         */
        
        public function sidebar () {
            $this -> load -> view ( '/includes/admin/general-sidebar' );
        }
        
        /**
         * ----------
         * footer template
         * ----------
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
         * ----------
         * load templates
         * ----------
         */
        
        public function index () {
            $title = site_name . ' - Templates (Ultrasound)';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'title' ] = $title;
            $data[ 'templates' ] = $this -> TemplateModel -> get_templates ();
            $this -> load -> view ( '/templates/index', $data );
            $this -> footer ();
        }
        
        /**
         * ----------
         * load templates
         * ----------
         */
        
        public function xray_templates () {
            $title = site_name . ' - Templates (X-Ray)';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'title' ] = $title;
            $data[ 'templates' ] = $this -> TemplateModel -> get_xray_templates ();
            $this -> load -> view ( '/templates/xray-templates', $data );
            $this -> footer ();
        }
        
        /**
         * ----------
         * add templates
         * ----------
         */
        
        public function add () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_add_template' )
                $this -> do_add_template ();
            
            $title = site_name . ' - Add Templates (Ultrasound)';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'title' ] = $title;
            $this -> load -> view ( '/templates/add', $data );
            $this -> footer ();
        }
        
        /**
         * ----------
         * process add template
         * ----------
         */
        
        private function do_add_template () {
            $this -> form_validation -> set_rules ( 'title', 'title (report name)', 'required|trim|is_unique[templates.title]|xss_clean' );
            $this -> form_validation -> set_rules ( 'gender', 'gender', 'xss_clean' );
            $this -> form_validation -> set_rules ( 'study', 'study', 'required|trim' );
            $this -> form_validation -> set_rules ( 'conclusion', 'conclusion', 'required|trim' );
            
            if ( $this -> form_validation -> run () ) {
                $title = $this -> input -> post ( 'title', true );
                $gender = $this -> input -> post ( 'gender', true );
                $study = $this -> input -> post ( 'study' );
                $conclusion = $this -> input -> post ( 'conclusion' );
                
                $info = array (
                    'user_id'    => get_logged_in_user_id (),
                    'title'      => $title,
                    'gender'     => $gender,
                    'study'      => $study,
                    'conclusion' => $conclusion,
                    'date_added' => current_date_time ()
                );
                $id = $this -> TemplateModel -> add ( $info );
                
                /***********LOGS*************/
                
                $log = array (
                    'user_id'    => get_logged_in_user_id (),
                    'action'     => 'template_added',
                    'log'        => json_encode ( $_POST ),
                    'date_added' => current_date_time ()
                );
                $this -> load -> model ( 'LogModel' );
                $this -> LogModel -> create_log ( 'template_logs', $log );
                
                /***********END LOG*************/
                
                $this -> session -> set_flashdata ( 'response', 'Success! Report template added.' );
                return redirect ( base_url ( '/templates/edit/?id=' . encode ( $id ) ) );
                
            }
            
        }
        
        /**
         * ----------
         * add templates
         * ----------
         */
        
        public function add_xray_templates () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_add_xray_template' )
                $this -> do_add_xray_templates ();
            
            $title = site_name . ' - Add Templates (X-Ray)';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'title' ] = $title;
            $this -> load -> view ( '/templates/add-xray-template', $data );
            $this -> footer ();
        }
        
        /**
         * ----------
         * process add xray template
         * ----------
         */
        
        private function do_add_xray_templates () {
            $this -> form_validation -> set_rules ( 'title', 'title (report name)', 'required|trim|is_unique[templates.title]|xss_clean' );
            $this -> form_validation -> set_rules ( 'study', 'study', 'required|trim' );
            $this -> form_validation -> set_rules ( 'conclusion', 'conclusion', 'required|trim' );
            
            if ( $this -> form_validation -> run () ) {
                $title = $this -> input -> post ( 'title', true );
                $study = $this -> input -> post ( 'study' );
                $conclusion = $this -> input -> post ( 'conclusion' );
                
                $info = array (
                    'user_id'    => get_logged_in_user_id (),
                    'title'      => $title,
                    'study'      => $study,
                    'conclusion' => $conclusion,
                    'date_added' => current_date_time ()
                );
                $id = $this -> TemplateModel -> add_xray_templates ( $info );
                
                /***********LOGS*************/
                
                $log = array (
                    'user_id'    => get_logged_in_user_id (),
                    'action'     => 'template_added',
                    'log'        => json_encode ( $_POST ),
                    'date_added' => current_date_time ()
                );
                $this -> load -> model ( 'LogModel' );
                $this -> LogModel -> create_log ( 'xray_template_logs', $log );
                
                /***********END LOG*************/
                
                $this -> session -> set_flashdata ( 'response', 'Success! Report template added.' );
                return redirect ( base_url ( '/templates/edit-xray-template/?id=' . encode ( $id ) ) );
                
            }
            
        }
        
        /**
         * ----------
         * edit templates
         * ----------
         */
        
        public function edit () {
            
            $id = $this -> input -> get ( 'id', true );
            if ( empty( trim ( $id ) ) or !isset( $id ) or !is_numeric ( decode ( $id ) ) )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_edit_template' )
                $this -> do_edit_template ();
            
            $title = site_name . ' - Edit Template (Ultrasound)';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'title' ] = $title;
            $data[ 'template' ] = $this -> TemplateModel -> get_template_by_id ( decode ( $id ) );
            $this -> load -> view ( '/templates/edit', $data );
            $this -> footer ();
        }
        
        /**
         * ----------
         * process edit template
         * ----------
         */
        
        private function do_edit_template () {
            $this -> form_validation -> set_rules ( 'id', 'template id', 'required|trim|numeric|xss_clean' );
            $this -> form_validation -> set_rules ( 'title', 'title (report name)', 'required|trim|xss_clean' );
            $this -> form_validation -> set_rules ( 'study', 'study', 'required|trim' );
            $this -> form_validation -> set_rules ( 'gender', 'gender', 'xss_clean' );
            $this -> form_validation -> set_rules ( 'conclusion', 'conclusion', 'required|trim' );
            
            if ( $this -> form_validation -> run () ) {
                $title = $this -> input -> post ( 'title', true );
                $study = $this -> input -> post ( 'study' );
                $gender = $this -> input -> post ( 'gender', true );
                $conclusion = $this -> input -> post ( 'conclusion' );
                $id = $this -> input -> post ( 'id', true );
                
                $info = array (
                    'title'      => $title,
                    'gender'     => $gender,
                    'study'      => $study,
                    'conclusion' => $conclusion,
                );
                $where = array (
                    'id' => $id
                );
                $this -> TemplateModel -> edit ( $info, $where );
                
                /***********LOGS*************/
                
                $log = array (
                    'user_id'    => get_logged_in_user_id (),
                    'action'     => 'template_updated',
                    'log'        => json_encode ( $_POST ),
                    'date_added' => current_date_time ()
                );
                $this -> load -> model ( 'LogModel' );
                $this -> LogModel -> create_log ( 'template_logs', $log );
                
                /***********END LOG*************/
                
                $this -> session -> set_flashdata ( 'response', 'Success! Report template updated.' );
                return redirect ( base_url ( '/templates/edit/?id=' . encode ( $id ) ) );
                
            }
            
        }
        
        /**
         * ----------
         * edit xray templates
         * ----------
         */
        
        public function edit_xray_templates () {
            
            $id = $this -> input -> get ( 'id', true );
            if ( empty( trim ( $id ) ) or !isset( $id ) or !is_numeric ( decode ( $id ) ) )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_edit_xray_template' )
                $this -> do_edit_xray_template ();
            
            $title = site_name . ' - Edit Template (X-Ray)';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'title' ] = $title;
            $data[ 'template' ] = $this -> TemplateModel -> get_xray_template_by_id ( decode ( $id ) );
            $this -> load -> view ( '/templates/edit-xray-template', $data );
            $this -> footer ();
        }
        
        /**
         * ----------
         * process edit xray template
         * ----------
         */
        
        private function do_edit_xray_template () {
            $this -> form_validation -> set_rules ( 'id', 'template id', 'required|trim|numeric|xss_clean' );
            $this -> form_validation -> set_rules ( 'title', 'title (report name)', 'required|trim|xss_clean' );
            $this -> form_validation -> set_rules ( 'study', 'study', 'required|trim' );
            $this -> form_validation -> set_rules ( 'conclusion', 'conclusion', 'required|trim' );
            
            if ( $this -> form_validation -> run () ) {
                $title = $this -> input -> post ( 'title', true );
                $study = $this -> input -> post ( 'study' );
                $conclusion = $this -> input -> post ( 'conclusion' );
                $id = $this -> input -> post ( 'id', true );
                
                $info = array (
                    'title'      => $title,
                    'study'      => $study,
                    'conclusion' => $conclusion,
                );
                $where = array (
                    'id' => $id
                );
                $this -> TemplateModel -> edit_xray_template ( $info, $where );
                
                /***********LOGS*************/
                
                $log = array (
                    'user_id'    => get_logged_in_user_id (),
                    'action'     => 'template_updated',
                    'log'        => json_encode ( $_POST ),
                    'date_added' => current_date_time ()
                );
                $this -> load -> model ( 'LogModel' );
                $this -> LogModel -> create_log ( 'xray_template_logs', $log );
                
                /***********END LOG*************/
                
                $this -> session -> set_flashdata ( 'response', 'Success! Report template updated.' );
                return redirect ( base_url ( '/templates/edit-xray-template/?id=' . encode ( $id ) ) );
                
            }
            
        }
        
        /**
         * -------------------------
         * delete templates
         * -------------------------
         */
        
        public function delete () {
            
            $id = $this -> input -> get ( 'id', true );
            if ( empty( trim ( $id ) ) or !isset( $id ) or !is_numeric ( decode ( $id ) ) )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $data[ 'template' ] = $this -> TemplateModel -> get_template_by_id ( decode ( $id ) );
            $this -> TemplateModel -> delete ( decode ( $id ) );
            
            /***********LOGS*************/
            
            $log = array (
                'user_id'    => get_logged_in_user_id (),
                'action'     => 'template_deleted',
                'log'        => json_encode ( $data ),
                'date_added' => current_date_time ()
            );
            $this -> load -> model ( 'LogModel' );
            $this -> LogModel -> create_log ( 'template_logs', $log );
            
            /***********END LOG*************/
            
            $this -> session -> set_flashdata ( 'response', 'Success! Template has been deleted.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
        }
        
        /**
         * -------------------------
         * delete xray templates
         * -------------------------
         */
        
        public function delete_xray_templates () {
            
            $id = $this -> input -> get ( 'id', true );
            if ( empty( trim ( $id ) ) or !isset( $id ) or !is_numeric ( decode ( $id ) ) )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $data[ 'template' ] = $this -> TemplateModel -> get_xray_template_by_id ( decode ( $id ) );
            $this -> TemplateModel -> delete_xray_templates ( decode ( $id ) );
            
            /***********LOGS*************/
            
            $log = array (
                'user_id'    => get_logged_in_user_id (),
                'action'     => 'template_deleted',
                'log'        => json_encode ( $data ),
                'date_added' => current_date_time ()
            );
            $this -> load -> model ( 'LogModel' );
            $this -> LogModel -> create_log ( 'xray_template_logs', $log );
            
            /***********END LOG*************/
            
            $this -> session -> set_flashdata ( 'response', 'Success! Template has been deleted.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
        }
        
        /**
         * ----------
         * get templates
         * ----------
         */
        
        public function get_template_by_id () {
            $id = $this -> input -> post ( 'id', true );
            $template = $this -> TemplateModel -> get_template_by_id ( $id );
            $array = array (
                'study'      => $template -> study,
                'conclusion' => $template -> conclusion,
            );
            echo json_encode ( $array );
        }
        
        /**
         * ----------
         * get xray templates
         * ----------
         */
        
        public function get_xray_template_by_id () {
            $id = $this -> input -> post ( 'id', true );
            $template = $this -> TemplateModel -> get_xray_template_by_id ( $id );
            $array = array (
                'study'      => $template -> study,
                'conclusion' => $template -> conclusion,
            );
            echo json_encode ( $array );
        }
        
        /**
         * ----------
         * load culture templates
         * ----------
         */
        
        public function culture_templates () {
            $title = site_name . ' - Templates (Culture)';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'title' ] = $title;
            $data[ 'templates' ] = $this -> TemplateModel -> get_culture_templates ();
            $this -> load -> view ( '/templates/culture-templates', $data );
            $this -> footer ();
        }
        
        /**
         * ----------
         * add culture templates
         * ----------
         */
        
        public function add_culture_templates () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_add_culture_template' )
                $this -> process_add_culture_template ();
            
            $title = site_name . ' - Add Templates (Culture)';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'title' ] = $title;
            $this -> load -> view ( '/templates/add-culture-template', $data );
            $this -> footer ();
        }
        
        /**
         * ----------
         * process add culture template
         * ----------
         */
        
        private function process_add_culture_template () {
            $this -> form_validation -> set_rules ( 'title', 'title (report name)', 'required|trim|is_unique[templates.title]' );
            $this -> form_validation -> set_rules ( 'study', 'study', 'required|trim' );
            $this -> form_validation -> set_rules ( 'conclusion', 'conclusion', 'required|trim' );
            
            if ( $this -> form_validation -> run () ) {
                $title = $this -> input -> post ( 'title', true );
                $study = $this -> input -> post ( 'study' );
                $conclusion = $this -> input -> post ( 'conclusion' );
                
                $info = array (
                    'user_id'    => get_logged_in_user_id (),
                    'title'      => $title,
                    'study'      => $study,
                    'conclusion' => $conclusion,
                    'date_added' => current_date_time ()
                );
                $id = $this -> TemplateModel -> add_culture_templates ( $info );
                
                /***********LOGS*************/
                
                $log = array (
                    'user_id'    => get_logged_in_user_id (),
                    'action'     => 'template_added',
                    'log'        => json_encode ( $_POST ),
                    'date_added' => current_date_time ()
                );
                $this -> load -> model ( 'LogModel' );
                $this -> LogModel -> create_log ( 'culture_template_logs', $log );
                
                /***********END LOG*************/
                
                $this -> session -> set_flashdata ( 'response', 'Success! Report template added.' );
                return redirect ( base_url ( '/templates/edit-culture-template/?id=' . encode ( $id ) . '&menu=cs-settings' ) );
                
            }
            
        }
        
        /**
         * ----------
         * edit culture templates
         * ----------
         */
        
        public function edit_culture_templates () {
            
            $id = $this -> input -> get ( 'id', true );
            if ( empty( trim ( $id ) ) or !isset( $id ) or !is_numeric ( decode ( $id ) ) )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_edit_culture_templates' )
                $this -> process_edit_culture_templates ();
            
            $title = site_name . ' - Edit Template (Culture)';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'title' ] = $title;
            $data[ 'template' ] = $this -> TemplateModel -> get_culture_template_by_id ( decode ( $id ) );
            $this -> load -> view ( '/templates/edit-culture-template', $data );
            $this -> footer ();
        }
        
        /**
         * ----------
         * process edit culture template
         * ----------
         */
        
        private function process_edit_culture_templates () {
            $this -> form_validation -> set_rules ( 'id', 'template id', 'required|trim|numeric' );
            $this -> form_validation -> set_rules ( 'title', 'title (report name)', 'required|trim' );
            $this -> form_validation -> set_rules ( 'study', 'study', 'required|trim' );
            $this -> form_validation -> set_rules ( 'conclusion', 'conclusion', 'required|trim' );
            
            if ( $this -> form_validation -> run () ) {
                $title = $this -> input -> post ( 'title', true );
                $study = $this -> input -> post ( 'study' );
                $conclusion = $this -> input -> post ( 'conclusion' );
                $id = $this -> input -> post ( 'id', true );
                
                $info = array (
                    'title'      => $title,
                    'study'      => $study,
                    'conclusion' => $conclusion,
                );
                $where = array (
                    'id' => $id
                );
                $this -> TemplateModel -> edit_culture_template ( $info, $where );
                
                /***********LOGS*************/
                
                $log = array (
                    'user_id'    => get_logged_in_user_id (),
                    'action'     => 'template_updated',
                    'log'        => json_encode ( $_POST ),
                    'date_added' => current_date_time ()
                );
                $this -> load -> model ( 'LogModel' );
                $this -> LogModel -> create_log ( 'culture_template_logs', $log );
                
                /***********END LOG*************/
                
                $this -> session -> set_flashdata ( 'response', 'Success! Report template updated.' );
                return redirect ( base_url ( '/templates/edit-culture-template/?id=' . encode ( $id ) . '&menu=cs-settings' ) );
                
            }
            
        }
        
        /**
         * -------------------------
         * delete culture templates
         * -------------------------
         */
        
        public function delete_culture_templates () {
            
            $id = $this -> input -> get ( 'id', true );
            if ( empty( trim ( $id ) ) or !isset( $id ) or !is_numeric ( decode ( $id ) ) )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $data[ 'template' ] = $this -> TemplateModel -> get_culture_template_by_id ( decode ( $id ) );
            $this -> TemplateModel -> delete_culture_templates ( decode ( $id ) );
            
            /***********LOGS*************/
            
            $log = array (
                'user_id'    => get_logged_in_user_id (),
                'action'     => 'template_deleted',
                'log'        => json_encode ( $data ),
                'date_added' => current_date_time ()
            );
            $this -> load -> model ( 'LogModel' );
            $this -> LogModel -> create_log ( 'culture_template_logs', $log );
            
            /***********END LOG*************/
            
            $this -> session -> set_flashdata ( 'response', 'Success! Template has been deleted.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
        }
        
        /**
         * ----------
         * load histopathology templates
         * ----------
         */
        
        public function histopathology_templates () {
            $title = site_name . ' - Templates (Histopathology)';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'title' ] = $title;
            $data[ 'templates' ] = $this -> TemplateModel -> get_histopathology_templates ();
            $this -> load -> view ( '/templates/histopathology-templates', $data );
            $this -> footer ();
        }
        
        /**
         * ----------
         * add histopathology templates
         * ----------
         */
        
        public function add_histopathology_templates () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_add_histopathology_templates' )
                $this -> process_add_histopathology_templates ();
            
            $title = site_name . ' - Add Templates (Histopathology)';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'title' ] = $title;
            $this -> load -> view ( '/templates/add-histopathology-template', $data );
            $this -> footer ();
        }
        
        /**
         * ----------
         * process add histopathology template
         * ----------
         */
        
        private function process_add_histopathology_templates () {
            $this -> form_validation -> set_rules ( 'title', 'title (report name)', 'required|trim|is_unique[templates.title]' );
            $this -> form_validation -> set_rules ( 'study', 'study', 'required|trim' );
            $this -> form_validation -> set_rules ( 'conclusion', 'conclusion', 'required|trim' );
            
            if ( $this -> form_validation -> run () ) {
                $title = $this -> input -> post ( 'title', true );
                $study = $this -> input -> post ( 'study' );
                $conclusion = $this -> input -> post ( 'conclusion' );
                
                $info = array (
                    'user_id'    => get_logged_in_user_id (),
                    'title'      => $title,
                    'study'      => $study,
                    'conclusion' => $conclusion,
                    'date_added' => current_date_time ()
                );
                $id = $this -> TemplateModel -> add_histopathology_templates ( $info );
                
                /***********LOGS*************/
                
                $log = array (
                    'user_id'    => get_logged_in_user_id (),
                    'action'     => 'template_added',
                    'log'        => json_encode ( $_POST ),
                    'date_added' => current_date_time ()
                );
                $this -> load -> model ( 'LogModel' );
                $this -> LogModel -> create_log ( 'histopathology_template_logs', $log );
                
                /***********END LOG*************/
                
                $this -> session -> set_flashdata ( 'response', 'Success! Report template added.' );
                return redirect ( base_url ( '/templates/edit-histopathology-template/?id=' . encode ( $id ) . '&menu=cs-settings' ) );
                
            }
            
        }
        
        /**
         * ----------
         * edit histopathology templates
         * ----------
         */
        
        public function edit_histopathology_templates () {
            
            $id = $this -> input -> get ( 'id', true );
            if ( empty( trim ( $id ) ) or !isset( $id ) or !is_numeric ( decode ( $id ) ) )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_edit_histopathology_templates' )
                $this -> process_edit_histopathology_templates ();
            
            $title = site_name . ' - Edit Template (Histopathology)';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'title' ] = $title;
            $data[ 'template' ] = $this -> TemplateModel -> get_histopathology_template_by_id ( decode ( $id ) );
            $this -> load -> view ( '/templates/edit-histopathology-template', $data );
            $this -> footer ();
        }
        
        /**
         * ----------
         * process edit histopathology template
         * ----------
         */
        
        private function process_edit_histopathology_templates () {
            $this -> form_validation -> set_rules ( 'id', 'template id', 'required|trim|numeric' );
            $this -> form_validation -> set_rules ( 'title', 'title (report name)', 'required|trim' );
            $this -> form_validation -> set_rules ( 'study', 'study', 'required|trim' );
            $this -> form_validation -> set_rules ( 'conclusion', 'conclusion', 'required|trim' );
            
            if ( $this -> form_validation -> run () ) {
                $title = $this -> input -> post ( 'title', true );
                $study = $this -> input -> post ( 'study' );
                $conclusion = $this -> input -> post ( 'conclusion' );
                $id = $this -> input -> post ( 'id', true );
                
                $info = array (
                    'title'      => $title,
                    'study'      => $study,
                    'conclusion' => $conclusion,
                );
                $where = array (
                    'id' => $id
                );
                $this -> TemplateModel -> edit_histopathology_template ( $info, $where );
                
                /***********LOGS*************/
                
                $log = array (
                    'user_id'    => get_logged_in_user_id (),
                    'action'     => 'template_updated',
                    'log'        => json_encode ( $_POST ),
                    'date_added' => current_date_time ()
                );
                $this -> load -> model ( 'LogModel' );
                $this -> LogModel -> create_log ( 'histopathology_template_logs', $log );
                
                /***********END LOG*************/
                
                $this -> session -> set_flashdata ( 'response', 'Success! Report template updated.' );
                return redirect ( base_url ( '/templates/edit-histopathology-template/?id=' . encode ( $id ) . '&menu=cs-settings' ) );
                
            }
            
        }
        
        /**
         * -------------------------
         * delete histopathology templates
         * -------------------------
         */
        
        public function delete_histopathology_templates () {
            
            $id = $this -> input -> get ( 'id', true );
            if ( empty( trim ( $id ) ) or !isset( $id ) or !is_numeric ( decode ( $id ) ) )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $data[ 'template' ] = $this -> TemplateModel -> get_histopathology_template_by_id ( decode ( $id ) );
            $this -> TemplateModel -> delete_histopathology_templates ( decode ( $id ) );
            
            /***********LOGS*************/
            
            $log = array (
                'user_id'    => get_logged_in_user_id (),
                'action'     => 'template_deleted',
                'log'        => json_encode ( $data ),
                'date_added' => current_date_time ()
            );
            $this -> load -> model ( 'LogModel' );
            $this -> LogModel -> create_log ( 'histopathology_template_logs', $log );
            
            /***********END LOG*************/
            
            $this -> session -> set_flashdata ( 'response', 'Success! Template has been deleted.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
        }
        
        /**
         * ----------
         * get templates
         * ----------
         */
        
        public function get_culture_template_by_id () {
            $id = $this -> input -> post ( 'id', true );
            $template = $this -> TemplateModel -> get_culture_template_by_id ( $id );
            $array = array (
                'study'      => $template -> study,
                'conclusion' => $template -> conclusion,
            );
            echo json_encode ( $array );
        }
        
        /**
         * ----------
         * get templates
         * ----------
         */
        
        public function get_histopathology_template () {
            $id = $this -> input -> post ( 'id', true );
            $template = $this -> TemplateModel -> get_histopathology_template_by_id ( $id );
            $array = array (
                'study'      => $template -> study,
                'conclusion' => $template -> conclusion,
            );
            echo json_encode ( $array );
        }
        
        /**
         * ----------
         * load antibiotics templates
         * ----------
         */
        
        public function antibiotic_susceptibility () {
            $title = site_name . ' - Antibiotic (Susceptibility)';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'title' ] = $title;
            $data[ 'antibiotics' ] = $this -> TemplateModel -> get_antibiotics ();
            $this -> load -> view ( '/templates/antibiotics', $data );
            $this -> footer ();
        }
        
        /**
         * ----------
         * add antibiotics templates
         * ----------
         */
        
        public function add_antibiotics () {
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'process_add_antibiotics' )
                $this -> process_add_antibiotics ();
            
            $title = site_name . ' - Add Antibiotic (Susceptibility)';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'title' ] = $title;
            $this -> load -> view ( '/templates/add-antibiotics', $data );
            $this -> footer ();
        }
        
        /**
         * ----------
         * process add antibiotics template
         * ----------
         */
        
        private function process_add_antibiotics () {
            
            $titles = $this -> input -> post ( 'title', true );
            
            if ( count ( $titles ) > 0 ) {
                foreach ( $titles as $title ) {
                    if ( !empty( trim ( $title ) ) ) {
                        $info = array (
                            'user_id'    => get_logged_in_user_id (),
                            'title'      => $title,
                            'date_added' => current_date_time ()
                        );
                        $this -> TemplateModel -> add_antibiotics ( $info );
                        
                        /***********LOGS*************/
                        
                        $log = array (
                            'user_id'    => get_logged_in_user_id (),
                            'action'     => 'antibiotic_added',
                            'log'        => json_encode ( $_POST ),
                            'date_added' => current_date_time ()
                        );
                        $this -> load -> model ( 'LogModel' );
                        $this -> LogModel -> create_log ( 'antibiotic_logs', $log );
                        
                        /***********END LOG*************/
                    }
                }
            }
            
            $this -> session -> set_flashdata ( 'response', 'Success! Antibiotic (Susceptibility) added.' );
            return redirect ( base_url ( '/templates/add-antibiotic-susceptibility/?menu=cs-settings' ) );
            
        }
        
        /**
         * ----------
         * edit antibiotics templates
         * ----------
         */
        
        public function edit_antibiotics () {
            
            $id = $this -> input -> get ( 'id', true );
            if ( empty( trim ( $id ) ) or !isset( $id ) or !is_numeric ( decode ( $id ) ) )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            if ( isset( $_POST[ 'action' ] ) and $_POST[ 'action' ] == 'do_edit_antibiotics' )
                $this -> process_edit_antibiotics ();
            
            $title = site_name . ' - Edit Antibiotic (Susceptibility)';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'title' ] = $title;
            $data[ 'antibiotic' ] = $this -> TemplateModel -> get_antibiotic_by_id ( decode ( $id ) );
            $this -> load -> view ( '/templates/edit-antibiotic', $data );
            $this -> footer ();
        }
        
        /**
         * ----------
         * process edit antibiotics template
         * ----------
         */
        
        private function process_edit_antibiotics () {
            $this -> form_validation -> set_rules ( 'id', 'id', 'required|trim|numeric' );
            $this -> form_validation -> set_rules ( 'title', 'title', 'required|trim' );
            
            if ( $this -> form_validation -> run () ) {
                $title = $this -> input -> post ( 'title', true );
                $id = $this -> input -> post ( 'id', true );
                
                $info = array (
                    'title' => $title,
                );
                $where = array (
                    'id' => $id
                );
                $this -> TemplateModel -> edit_antibiotics ( $info, $where );
                
                /***********LOGS*************/
                
                $log = array (
                    'user_id'    => get_logged_in_user_id (),
                    'action'     => 'antibiotic_updated',
                    'log'        => json_encode ( $_POST ),
                    'date_added' => current_date_time ()
                );
                $this -> load -> model ( 'LogModel' );
                $this -> LogModel -> create_log ( 'antibiotic_logs', $log );
                
                /***********END LOG*************/
                
                $this -> session -> set_flashdata ( 'response', 'Success! Antibiotic updated.' );
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
                
            }
            
        }
        
        /**
         * -------------------------
         * delete antibiotics
         * -------------------------
         */
        
        public function delete_antibiotics () {
            
            $id = $this -> input -> get ( 'id', true );
            if ( empty( trim ( $id ) ) or !isset( $id ) or !is_numeric ( decode ( $id ) ) )
                return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
            $data[ 'template' ] = $this -> TemplateModel -> get_antibiotic_by_id ( decode ( $id ) );
            $this -> TemplateModel -> delete_antibiotics ( decode ( $id ) );
            
            /***********LOGS*************/
            
            $log = array (
                'user_id'    => get_logged_in_user_id (),
                'action'     => 'antibiotic_deleted',
                'log'        => json_encode ( $data ),
                'date_added' => current_date_time ()
            );
            $this -> load -> model ( 'LogModel' );
            $this -> LogModel -> create_log ( 'antibiotic_logs', $log );
            
            /***********END LOG*************/
            
            $this -> session -> set_flashdata ( 'response', 'Success! Antibiotic has been deleted.' );
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
            
        }
        
    }

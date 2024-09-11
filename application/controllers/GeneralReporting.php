<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class GeneralReporting extends CI_Controller {

    /**
     * -------------------------
     * GeneralReporting constructor.
     * loads helpers, modal or libraries
     * -------------------------
     */

    public function __construct() {
        parent::__construct();
        $this -> is_logged_in();
        $this -> load -> model('LabModel');
        $this -> load -> model('OPDModel');
        $this -> load -> model('IPDModel');
        $this -> load -> model('ConsultancyModel');
        $this -> load -> model('MedicineModel');
    }

    /**
     * -------------------------
     * @param $title
     * header template
     * -------------------------
     */

    public function header($title) {
        $data['title'] = $title;
        $this -> load -> view('/includes/admin/header', $data);
    }

    /**
     * -------------------------
     * sidebar template
     * -------------------------
     */

    public function sidebar() {
        $this -> load -> view('/includes/admin/general-sidebar');
    }

    /**
     * -------------------------
     * footer template
     * -------------------------
     */

    public function footer() {
        $this -> load -> view('/includes/admin/footer');
    }

    /**
     * ---------------------
     * checks if user is logged in
     * ---------------------
     */

    public function is_logged_in() {
        if (empty($this -> session -> userdata('user_data'))) {
            return redirect(base_url());
        }
    }

    /**
     * -------------------------
     * General summary report
     * display summary report of
	 * lab, opd, ipd
     * -------------------------
     */

    public function general_summary_report() {
        $title = site_name . ' - Summary Report';
        $this -> header($title);
        $this -> sidebar();
        $data['consultancy_total'] 	= $this -> ConsultancyModel -> get_total_sale_by_date_range();
        $data['opd_total'] 			= $this -> OPDModel -> get_total_sale_by_date_range();
        $data['lab_total'] 			= $this -> LabModel -> get_total_sale_by_date_range();
        $data['med_total'] 			= $this -> MedicineModel -> get_total_sale_by_date_range();
        $data['ipd_total'] 			= $this -> IPDModel -> get_total_sale_by_date_range();
        $data['users'] 				= $this -> UserModel -> get_users();
        $this -> load -> view('/general-report/summary-report', $data);
        $this -> footer();
	}

}

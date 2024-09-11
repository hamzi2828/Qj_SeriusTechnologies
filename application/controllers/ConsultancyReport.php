<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ConsultancyReport extends CI_Controller {

    /**
     * -------------------------
     * ConsultancyReport constructor.
     * loads helpers, modal or libraries
     * -------------------------
     */

    public function __construct() {
        parent::__construct();
        $this -> is_logged_in();
        $this -> load -> model('DoctorModel');
        $this -> load -> model('ReportingModel');
        $this -> load -> model('PanelModel');
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
     * General report
     * display sale report
     * -------------------------
     */

    public function general_report() {
        $title = site_name . ' - General Report Cash';
        $this -> header($title);
        $this -> sidebar();
        $data['doctors'] = $this -> DoctorModel -> get_doctors();
	    $data['consultancies'] = $this -> ReportingModel -> get_consultancies();
        $this -> load -> view('/reporting/consultancy-report', $data);
        $this -> footer();
	}

    /**
     * -------------------------
     * General report
     * display sale report
     * -------------------------
     */

    public function general_report_1() {
        $title = site_name . ' - General Report Cash';
        $this -> header($title);
        $this -> sidebar();
        $data['doctors'] = $this -> DoctorModel -> get_doctors();
	    $data['consultancies'] = $this -> ReportingModel -> get_consultancies();
        $this -> load -> view('/reporting/consultancy-report-1', $data);
        $this -> footer();
	}

    /**
     * -------------------------
     * General report
     * display sale report
     * -------------------------
     */

    public function general_report_panel() {
        $title = site_name . ' - General Report Panel';
        $this -> header($title);
        $this -> sidebar();
        $data['doctors'] = $this -> DoctorModel -> get_doctors();
	    $data['consultancies'] = $this -> ReportingModel -> get_consultancies_panel();
	    $data['panels'] = $this -> PanelModel -> get_panels();
        $this -> load -> view('/reporting/general_report_panel', $data);
        $this -> footer();
	}

    /**
     * -------------------------
     * doctor consultancy report
     * display sale report
     * -------------------------
     */

    public function doctor_consultancy_report() {
        $title = site_name . ' - Doctor Consultancy Report';
        $this -> header($title);
        $this -> sidebar();
        $data['doctors'] 		= $this -> DoctorModel -> get_doctors();
        $data['filter_doctors'] 		= $this -> DoctorModel -> get_doctors_by_filter();
        $this -> load -> view('/reporting/doctor-consultancy-report', $data);
        $this -> footer();
	}

}

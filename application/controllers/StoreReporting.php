<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class StoreReporting extends CI_Controller {

    /**
     * -------------------------
     * StoreReporting constructor.
     * loads helpers, modal or libraries
     * -------------------------
     */

    public function __construct() {
        parent::__construct();
        $this -> is_logged_in();
        $this -> load -> model('UserModel');
        $this -> load -> model('MemberModel');
        $this -> load -> model('ReportingModel');
        $this -> load -> model('StoreModel');
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
        $title = site_name . ' - General Report';
        $this -> header($title);
        $this -> sidebar();
        $data['users'] = $this -> UserModel -> get_users();
	    $data['departments'] = $this -> MemberModel -> get_departments();
	    $data['sales'] = $this -> ReportingModel -> get_store_sales();
	    $data['items'] = $this -> StoreModel -> get_store();
        $this -> load -> view('/reporting/store-general-report', $data);
        $this -> footer();
	}

    /**
     * -------------------------
     * threshold report
     * display threshold report
     * -------------------------
     */

    public function threshold_report() {
        $title = site_name . ' - Threshold Report';
        $this -> header($title);
        $this -> sidebar();
        $data[ 'stores' ] = $this -> StoreModel -> get_store ();
        $this -> load -> view('/reporting/store-threshold-report', $data);
        $this -> footer();
	}

    /**
     * -------------------------
     * display stock valuation report
     * -------------------------
     */

    public function stock_valuation() {
        $title = site_name . ' - Stock Valuation Report';
        $this -> header($title);
        $this -> sidebar();
        $data[ 'stores' ] = $this -> StoreModel -> get_store ();
        $this -> load -> view('/reporting/store-stock-valuation-report', $data);
        $this -> footer();
	}

    /**
     * -------------------------
     * display purchase report
     * -------------------------
     */

    public function purchase_report() {
        $title = site_name . ' - Purchase Report';
        $this -> header($title);
        $this -> sidebar();
        $data[ 'stores' ] = $this -> StoreModel -> get_store ();
        $data[ 'stocks' ] = $this -> StoreModel -> get_purchase_report ();
        $this -> load -> view('/reporting/purchase-report', $data);
        $this -> footer();
	}

}

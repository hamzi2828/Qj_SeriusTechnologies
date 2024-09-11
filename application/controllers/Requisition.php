<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Requisition extends CI_Controller {

    /**
     * -------------------------
     * Requisition constructor.
     * loads helpers, modal or libraries
     * -------------------------
     */

    public function __construct() {
        parent::__construct();
        $this -> is_logged_in();
        $this -> load -> model('RequisitionModel');
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
     * Requisition main page
     * -------------------------
     */

    public function index() {
        $title = site_name . ' - Requisition';
        $this -> header($title);
        $this -> sidebar();
        $data['requisitions'] = $this -> RequisitionModel -> get_requisitions();
        $this -> load -> view('/requisitions/index', $data);
        $this -> footer();
	}

    /**
     * -------------------------
     * Requisition add main page
     * -------------------------
     */

    public function add() {

        if(isset($_POST['action']) and $_POST['action'] == 'do_add_requisitions')
            $this -> do_add_requisitions($_POST);

        $title = site_name . ' - Add Requisition';
        $this -> header($title);
        $this -> sidebar();
        $data['stores'] = $this -> StoreModel -> get_all_store();
        $this -> load -> view('/requisitions/add', $data);
        $this -> footer();
	}

    /**
     * -------------------------
     * @param $POST
     * add requisitions
     * -------------------------
     */

	public function do_add_requisitions($POST) {
        $data       = filter_var_array($POST, FILTER_SANITIZE_STRING);
        $store_id   = $data['store_id'];
        if(isset($store_id) and count(array_filter($store_id)) > 0) {
            $user = get_user(get_logged_in_user_id());
            $department_id = $user -> department_id;
            if(!empty(trim($department_id)) and $department_id > 0) {
                foreach ($store_id as $key => $value) {
                	if(!empty(trim($value))) {
						$info = array(
							'request_by'    =>  get_logged_in_user_id(),
							'department_id' =>  $department_id,
							'item_id'       =>  $value,
							'quantity'      =>  $data['quantity'][$key],
							'description'   =>  $data['description'][$key],
							'date_added'    =>  current_date_time(),
						);
						$this -> RequisitionModel -> add($info);
					}
                }
            }
            else {
				$this -> session -> set_flashdata('error', 'Error! User department is not set.');
				return redirect(base_url('/requisition/add'));
			}
        }
        $this -> session -> set_flashdata('response', 'Success! Requisition added.');
        return redirect(base_url('/requisition/add'));
    }

    /**
     * -------------------------
     * requisitions edit main page
     * -------------------------
     */

    public function edit() {

		$requisition_id = $this -> uri -> segment(3);
        if(empty(trim($requisition_id)) or !is_numeric($requisition_id))
            return redirect($_SERVER['HTTP_REFERER']);

        if(isset($_POST['action']) and $_POST['action'] == 'do_edit_requisition')
            $this -> do_edit_requisition($_POST);

        $title = site_name . ' - Edit requisitions';
        $this -> header($title);
        $this -> sidebar();
        $data['stores'] = $this -> StoreModel -> get_all_store();
        $data['requisition'] = $this -> RequisitionModel -> get_requisition_by_id($requisition_id);
        $this -> load -> view('/requisitions/edit', $data);
        $this -> footer();
	}

    /**
     * -------------------------
     * @param $POST
     * edit requisitions
     * -------------------------
     */

    public function do_edit_requisition($POST) {
        $data = filter_var_array($POST, FILTER_SANITIZE_STRING);
        $requisition_id = $data['requisition_id'];
        $info = array(
            'item_id'       =>  $data['store_id'],
            'quantity'      =>  $data['quantity'],
            'description'   =>  $data['description'],
        );
        $updated = $this -> RequisitionModel -> edit($info, $requisition_id);
        if($updated) {
            $this -> session -> set_flashdata('response', 'Success! Requisition updated.');
            return redirect($_SERVER['HTTP_REFERER']);
        }
        else {
            $this -> session -> set_flashdata('error', 'Note! No record updated.');
            return redirect($_SERVER['HTTP_REFERER']);
        }
    }

    /**
     * -------------------------
     * delete requisitions
     * -------------------------
     */

    public function delete() {
        $procurement_id = $this -> uri -> segment(3);
        if(empty(trim($procurement_id)) or !is_numeric($procurement_id))
            return redirect($_SERVER['HTTP_REFERER']);

        $this -> RequisitionModel -> delete($procurement_id);
        $this -> session -> set_flashdata('response', 'Success! Requisition deleted.');
        return redirect($_SERVER['HTTP_REFERER']);

    }

    /**
     * -------------------------
     * update requisitions status
     * -------------------------
     */

    public function status() {
        $requisition_id = $this -> uri -> segment(3);
        if(empty(trim($requisition_id)) or !is_numeric($requisition_id))
            return redirect($_SERVER['HTTP_REFERER']);

        $status = $_REQUEST['status'];
        $info = array(
            'status'    	=>  $status,
			'approved_by'	=>	get_logged_in_user_id()
        );
        $this -> RequisitionModel -> edit($info, $requisition_id);
        $this -> session -> set_flashdata('response', 'Success! Requisition status updated.');
        return redirect($_SERVER['HTTP_REFERER']);
    }

	/**
	 * -------------------------
	 * demands main page
	 * -------------------------
	 */

	public function demands() {

		if(isset($_POST['action']) and $_POST['action'] == 'do_add_demands')
			$this -> do_add_demands($_POST);

		$title = site_name . ' - Add other requisitions';
		$this -> header($title);
		$this -> sidebar();
		$this -> load -> view('/requisitions/demands');
		$this -> footer();
	}

	/**
	 * -------------------------
	 * add more demands main page
	 * -------------------------
	 */

	public function add_more_demands() {
		$data['row'] = $this -> input -> post('row', true);
		$this -> load -> view('/requisitions/add-more-demands', $data);
	}

	/**
	 * -------------------------
	 * @param $POST
	 * add requisition demands
	 * -------------------------
	 */

	public function do_add_demands($POST) {
		$data = filter_var_array($POST, FILTER_SANITIZE_STRING);
		$description = $data['description'];
		if(isset($description) and count(array_filter($description)) > 0) {
			foreach ($description as $key => $value) {
				$info = array(
					'request_from'		=>	get_logged_in_user_id(),
					'description'		=>	$value,
					'quantity'			=>	$data['quantity'][$key],
					'date_added'		=>	current_date_time(),
				);
				$this -> RequisitionModel -> add_demands($info);
			}
			$this -> session -> set_flashdata('response', 'Success! Requisition demand(s) added.');
			return redirect(base_url('/requisition/demands'));
		}
	}

	/**
	 * -------------------------
	 * add more requests main page
	 * -------------------------
	 */

	public function add_more_requisitions() {
		$data['stores'] = $this -> StoreModel -> get_all_store();
		$data['row'] = $this -> input -> post('row', true);
		$this -> load -> view('/requisitions/add-more-requests', $data);
	}

}

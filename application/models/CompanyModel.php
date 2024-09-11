<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CompanyModel extends CI_Model {

    /**
     * -------------------------
     * CompanyModel constructor.
     * -------------------------
     */

    public function __construct() {
        parent::__construct();
    }

    /**
     * -------------------------
     * @return mixed
     * get all companies
     * -------------------------
     */

    public function get_companies() {
        $companies = $this -> db -> get('companies');
        return $companies -> result();
    }

    /**
     * -------------------------
     * @return mixed
     * get parent companies
     * -------------------------
     */

    public function get_parent_companies() {
	$companies = $this -> db -> get_where('companies', array('parent_id'	=>	NULL));
        return $companies -> result();
    }

    /**
     * -------------------------
     * @param $data
     * @return mixed
     * insert companies
     * -------------------------
     */

    public function add($data) {
        $this -> db -> insert('companies', $data);
        return $this -> db -> insert_id();
    }

    /**
     * -------------------------
     * @return mixed
     * @param $company_id
     * get company by id
     * -------------------------
     */

    public function get_company_by_id($company_id) {
        $member = $this -> db -> get_where('companies', array('id'  =>  $company_id));
        return $member -> row();
    }

    /**
     * -------------------------
     * @param $data
     * @param $company_id
     * @return mixed
     * update company
     * -------------------------
     */

    public function edit($data, $company_id) {
        $this -> db -> update('companies', $data, array('id' =>  $company_id));
        return $this -> db -> affected_rows();
    }

    /**
     * -------------------------
     * @param $company_id
     * @return mixed
     * delete company permanently
     * -------------------------
     */

    public function delete($company_id) {
        $this -> db -> delete('companies', array('id' =>  $company_id));
        return $this -> db -> affected_rows();
    }

    /**
     * -------------------------
     * @param $company_id
     * @return mixed
     * get company members
     * -------------------------
     */

    public function get_company_members($company_id) {
        $members = $this -> db -> get_where('patients', array('company_id'  =>  $company_id));
        return $members -> result();
    }

}
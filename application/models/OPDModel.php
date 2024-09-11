<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class OPDModel extends CI_Model {

    /**
     * --------------
     * OPDModel constructor.
     * --------------
     */

    public function __construct() {
        parent::__construct();
    }

	/**
	 * --------------
	 * @param $panel_id
	 * @return mixed
	 * get all services
	 * --------------
	 */

    public function get_all_services( $panel_id = 0) {
    	$sql = "Select * from hmis_opd_services where 1";
    	if ( $panel_id > 0) {
    		$sql .= " and id IN (Select service_id from hmis_panel_opd_services where panel_id=$panel_id)";
		}
    	$sql .= " order by title ASC";
    	$services = $this -> db -> query( $sql);
    	return $services -> result();
    }

	/**
	 * --------------
	 * @return mixed
	 * get parent services
	 * --------------
	 */

    public function get_parent_services() {
		$this -> db -> order_by('title', 'ASC');
    	$services = $this -> db -> get_where('opd_services', array('parent_id'    =>  0));
    	return $services -> result();
    }

	/**
	 * --------------
	 * @return boolean
	 * @param $service_id
	 * check if service has children
	 * --------------
	 */

    public function opd_services_has_children($service_id) {
    	$services = $this -> db -> get_where('opd_services', array('parent_id'    =>  $service_id));
    	if($services -> num_rows() > 0)
    		return true;
    	else
    		return false;
    }

	/**
	 * --------------
	 * @param $info
	 * add services
	 * @return mixed
	 * --------------
	 */

    public function add($info) {
    	$this -> db -> insert('opd_services', $info);
    	return $this -> db -> insert_id();
    }

	/**
	 * --------------
	 * @param $service_id
	 * delete services
	 * @return mixed
	 * --------------
	 */

    public function delete($service_id) {
    	$this -> db -> delete('opd_services', array('id'   =>  $service_id));
    	return $this -> db -> affected_rows();
    }

	/**
	 * --------------
	 * @param $service_id
	 * get service by id
	 * @return mixed
	 * --------------
	 */

    public function get_service_by_id($service_id) {
	    $service = $this -> db -> get_where('opd_services', array('id'    =>  $service_id));
	    return $service -> row();
    }

	/**
	 * --------------
	 * @param $service_id
	 * get service price by id
	 * @return mixed
	 * --------------
	 */

    public function get_service_price_by_id($service_id) {
	    $service = $this -> db -> get_where('opd_services', array('id'    =>  $service_id));
	    return $service -> row() -> price;
    }

	/**
	 * --------------
	 * @param $service_id
	 * get sub services by id
	 * @return mixed
	 * --------------
	 */

    public function get_services_by_parent_id($service_id) {
	    $services = $this -> db -> get_where('opd_services', array('parent_id'    =>  $service_id));
	    return $services -> result();
    }

	/**
	 * --------------
	 * @param $sale_id
	 * get sale by id
	 * @return mixed
	 * --------------
	 */

    public function get_opd_sale($sale_id) {
	    $sale = $this -> db -> get_where('opd_sales', array('id'    =>  $sale_id));
	    return $sale -> row();
    }

	/**
	 * --------------
	 * @param $service_id
	 * @param $info
	 * edit services
	 * @return mixed
	 * --------------
	 */

	public function edit($info, $service_id) {
		$this -> db -> update('opd_services', $info, array('id'   =>  $service_id));
		return $this -> db -> affected_rows();
	}

	/**
	 * --------------
	 * @param $service_id
	 * @param $info
	 * edit services
	 * @return mixed
	 * --------------
	 */

	public function update_opd_sales($info, $service_id) {
		$this -> db -> update('opd_sales', $info, array('id'   =>  $service_id));
		return $this -> db -> affected_rows();
	}

	/**
	 * --------------
	 * @param $info
	 * add sale total
	 * @return mixed
	 * --------------
	 */

	public function add_opd_sale($info) {
		$this -> db -> insert('opd_sales', $info);
		return $this -> db -> insert_id();
	}

	/**
	 * --------------
	 * @param $info
	 * add sale total
	 * @return mixed
	 * --------------
	 */

	public function add_opd_sale_service($info) {
		$this -> db -> insert('opd_services_sales', $info);
		return $this -> db -> insert_id();
	}

	/**
	 * --------------
	 * @param $sale_id
	 * get sale services by id
	 * @return mixed
	 * --------------
	 */

	public function get_sales($sale_id) {
		$sales = $this -> db -> get_where('opd_services_sales', array('sale_id'    =>  $sale_id));
		return $sales -> result();
	}

	/**
	 * --------------
	 * @param $sale_id
	 * get sale services by id
	 * @return mixed
	 * --------------
	 */

	public function get_doc_id_by_sale_id($sale_id) {
		$sales = $this -> db -> query("Select doctor_id from hmis_opd_services_sales where sale_id=$sale_id");
		return $sales -> row() -> doctor_id;
	}

	/**
	 * --------------
	 * @param $sale_id
	 * get sale services by id
	 * @return mixed
	 * --------------
	 */

	public function get_sold_services($sale_id) {
		$sales = $this -> db -> get_where('opd_services_sales', array('sale_id'    =>  $sale_id));
		return $sales -> result_array();
	}

	/**
	 * --------------
	 * count sales grouped by sale id
	 * @return mixed
	 * --------------
	 */

	public function count_sales_by_sale_grouped() {
		$sql = "Select id from hmis_opd_services_sales where patient_id IN (Select id from hmis_patients where type='cash')";
		if (isset($_REQUEST['sale_id']) and $_REQUEST['sale_id'] > 0) {
			$sale_id = $_REQUEST['sale_id'];
			$sql .= " and sale_id=$sale_id";
		}
		if (isset($_REQUEST['patient_id']) and $_REQUEST['patient_id'] > 0) {
			$patient_id = $_REQUEST['patient_id'];
			$sql .= " and patient_id=$patient_id";
		}
		if (isset($_REQUEST['service_id']) and $_REQUEST['service_id'] > 0) {
			$service_id = $_REQUEST['service_id'];
			$sql .= " and service_id=$service_id";
		}
		if (isset($_REQUEST['doctor_id']) and $_REQUEST['doctor_id'] > 0) {
			$doctor_id = $_REQUEST['doctor_id'];
			$sql .= " and doctor_id=$doctor_id";
		}
		if (isset($_REQUEST['patient_name']) and !empty(trim ($_REQUEST['patient_name']))) {
			$patient_name = $_REQUEST['patient_name'];
			$sql .= " and patient_id IN (Select id from hmis_patients where name LIKE '%$patient_name%')";
		}
		$sql .= " GROUP BY sale_id";
		$sales = $this -> db -> query( $sql);
		return $sales -> num_rows();
	}

	/**
	 * --------------
	 * get sales grouped by sale id
	 * @param $limit
	 * @param $offset
	 * @return mixed
	 * --------------
	 */

	public function get_sales_by_sale_grouped($limit, $offset) {
		$sql = "Select GROUP_CONCAT(doctor_id) as doctors, patient_id, sale_id, GROUP_CONCAT(service_id) as services, GROUP_CONCAT(price) as prices, GROUP_CONCAT(discount) as discounts, GROUP_CONCAT(doctor_share) as doctor_share, SUM(net_price) as net_price, date_added from hmis_opd_services_sales where patient_id IN (Select id from hmis_patients where type='cash')";
		if ( isset( $_REQUEST[ 'sale_id' ] ) and $_REQUEST[ 'sale_id' ] > 0 ) {
			$sale_id = $_REQUEST[ 'sale_id' ];
			$sql .= " and sale_id=$sale_id";
		}
		if ( isset( $_REQUEST[ 'patient_id' ] ) and $_REQUEST[ 'patient_id' ] > 0 ) {
			$patient_id = $_REQUEST[ 'patient_id' ];
			$sql .= " and patient_id=$patient_id";
		}
		if ( isset( $_REQUEST[ 'service_id' ] ) and $_REQUEST[ 'service_id' ] > 0 ) {
			$service_id = $_REQUEST[ 'service_id' ];
			$sql .= " and service_id=$service_id";
		}
		if ( isset( $_REQUEST[ 'doctor_id' ] ) and $_REQUEST[ 'doctor_id' ] > 0 ) {
			$doctor_id = $_REQUEST[ 'doctor_id' ];
			$sql .= " and doctor_id=$doctor_id";
		}
		if ( isset( $_REQUEST[ 'patient_name' ] ) and !empty( trim ( $_REQUEST[ 'patient_name' ] ) ) ) {
			$patient_name = $_REQUEST[ 'patient_name' ];
			$sql .= " and patient_id IN (Select id from hmis_patients where name LIKE '%$patient_name%')";
		}
		$sql .= " GROUP BY sale_id order by id DESC limit $limit offset $offset";
		$sales = $this -> db -> query( $sql);
		return $sales -> result();
	}
	
	/**
	 * --------------
	 * count sales grouped by sale id
	 * @return mixed
	 * --------------
	 */
	
	public function count_panel_sales_by_sale_grouped () {
		$sql = "Select id from hmis_opd_services_sales where patient_id IN (Select id from hmis_patients where type='panel')";
		if ( isset( $_REQUEST[ 'sale_id' ] ) and $_REQUEST[ 'sale_id' ] > 0 ) {
			$sale_id = $_REQUEST[ 'sale_id' ];
			$sql .= " and sale_id=$sale_id";
		}
		if ( isset( $_REQUEST[ 'patient_id' ] ) and $_REQUEST[ 'patient_id' ] > 0 ) {
			$patient_id = $_REQUEST[ 'patient_id' ];
			$sql .= " and patient_id=$patient_id";
		}
		if ( isset( $_REQUEST[ 'service_id' ] ) and $_REQUEST[ 'service_id' ] > 0 ) {
			$service_id = $_REQUEST[ 'service_id' ];
			$sql .= " and service_id=$service_id";
		}
		if ( isset( $_REQUEST[ 'doctor_id' ] ) and $_REQUEST[ 'doctor_id' ] > 0 ) {
			$doctor_id = $_REQUEST[ 'doctor_id' ];
			$sql .= " and doctor_id=$doctor_id";
		}
		if ( isset( $_REQUEST[ 'patient_name' ] ) and !empty( trim ( $_REQUEST[ 'patient_name' ] ) ) ) {
			$patient_name = $_REQUEST[ 'patient_name' ];
			$sql .= " and patient_id IN (Select id from hmis_patients where name LIKE '%$patient_name%')";
		}
		$sql .= " GROUP BY sale_id";
		$sales = $this -> db -> query ( $sql );
		return $sales -> num_rows ();
	}

	/**
	 * --------------
	 * get sales grouped by sale id
	 * @return mixed
	 * --------------
	 */

	public function get_panel_sales_by_sale_grouped( $limit, $offset) {
		$sql = "Select GROUP_CONCAT(doctor_id) as doctors, patient_id, sale_id, GROUP_CONCAT(service_id) as services, GROUP_CONCAT(price) as prices, GROUP_CONCAT(discount) as discounts, GROUP_CONCAT(doctor_share) as doctor_share, SUM(net_price) as net_price, date_added from hmis_opd_services_sales where patient_id IN (Select id from hmis_patients where type='panel')";
		if ( isset( $_REQUEST[ 'sale_id' ] ) and $_REQUEST[ 'sale_id' ] > 0 ) {
			$sale_id = $_REQUEST[ 'sale_id' ];
			$sql .= " and sale_id=$sale_id";
		}
		if ( isset( $_REQUEST[ 'patient_id' ] ) and $_REQUEST[ 'patient_id' ] > 0 ) {
			$patient_id = $_REQUEST[ 'patient_id' ];
			$sql .= " and patient_id=$patient_id";
		}
		if ( isset( $_REQUEST[ 'service_id' ] ) and $_REQUEST[ 'service_id' ] > 0 ) {
			$service_id = $_REQUEST[ 'service_id' ];
			$sql .= " and service_id=$service_id";
		}
		if ( isset( $_REQUEST[ 'doctor_id' ] ) and $_REQUEST[ 'doctor_id' ] > 0 ) {
			$doctor_id = $_REQUEST[ 'doctor_id' ];
			$sql .= " and doctor_id=$doctor_id";
		}
		if ( isset( $_REQUEST[ 'patient_name' ] ) and !empty( trim ( $_REQUEST[ 'patient_name' ] ) ) ) {
			$patient_name = $_REQUEST[ 'patient_name' ];
			$sql .= " and patient_id IN (Select id from hmis_patients where name LIKE '%$patient_name%')";
		}
		$sql .= " GROUP BY sale_id order by id DESC limit $limit offset $offset";
		$sales = $this -> db -> query ( $sql );
		return $sales -> result ();
	}

	/**
	 * --------------
	 * @param $sale_id
	 * get sale
	 * @return mixed
	 * --------------
	 */

	public function delete_sale($sale_id) {
		$this -> db -> delete('opd_sales', array('id'  =>  $sale_id));
		return $this -> db -> affected_rows();
	}

	/**
	 * -------------------------
	 * @return mixed
	 * get opd total sale
	 * by date range
	 * -------------------------
	 */

	public function get_total_sale_by_date_range() {
		$sql = "Select SUM(net) as net from hmis_opd_sales where refund='0'";
		if(isset($_REQUEST['start_date']) and !empty(trim($_REQUEST['start_date'])) and isset($_REQUEST['end_date']) and !empty(trim($_REQUEST['end_date']))) {
			$start_date = date('Y-m-d', strtotime($_REQUEST['start_date']));
			$end_date 	= date('Y-m-d', strtotime($_REQUEST['end_date']));
			$sql .= " and DATE(date_added) Between '$start_date' and '$end_date'";
		}
		if(isset($_REQUEST['start_time']) and isset($_REQUEST['end_time']) and !empty($_REQUEST['start_time']) and !empty($_REQUEST['end_time'])) {
			$start_time = date('H:i:s', strtotime($_REQUEST['start_time']));
			$end_time 	= date('H:i:s', strtotime($_REQUEST['end_time']));
			$sql .= " and TIME(date_added) BETWEEN '$start_time' and '$end_time'";
		}
		if(isset($_REQUEST['user_id']) and $_REQUEST['user_id'] > 0) {
			$user_id = $_REQUEST['user_id'];
			$sql .= " and user_id=$user_id";
		}
		$query = $this -> db -> query($sql);
		return $query -> row();
	}
	
	public function get_opd_total_sale_value($sale_id) {
		$query = $this -> db -> query("Select SUM(price) as price from hmis_opd_services_sales where sale_id=$sale_id");
		return $query -> row() -> price;
	}

}
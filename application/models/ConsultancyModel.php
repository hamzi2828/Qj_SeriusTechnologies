<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ConsultancyModel extends CI_Model {

    /**
     * -------------------------
     * ConsultancyModel constructor.
     * -------------------------
     */

    public function __construct() {
        parent::__construct();
    }

    /**
     * -------------------------
     * @param $data
     * @return mixed
     * save consultancy into database
     * -------------------------
     */

    public function add($data) {
        $this -> db -> insert('consultancies', $data);
        return $this -> db -> insert_id();
    }

    /**
     * -------------------------
     * @return mixed
     * get cash customer consultancies
     * -------------------------
     */

    public function count_consultancies() {
        // Changes due to tables distortion
    	$sql = "Select COUNT(*) as totalRows from hmis_consultancies where patient_id IN (Select id from hmis_patients where type='cash')";
//    	$sql = "Select COUNT(*) as totalRows from hmis_consultancies where 1";
		if ( isset( $_REQUEST[ 'id' ] ) and $_REQUEST[ 'id' ] > 0 ) {
			$id = $_REQUEST[ 'id' ];
			$sql .= " and id=$id";
		}
		if ( isset( $_REQUEST[ 'patient_id' ] ) and $_REQUEST[ 'patient_id' ] > 0 ) {
			$patient_id = $_REQUEST[ 'patient_id' ];
			$sql .= " and patient_id=$patient_id";
		}
		if ( isset( $_REQUEST[ 'doctor_id' ] ) and $_REQUEST[ 'doctor_id' ] > 0 ) {
			$doctor_id = $_REQUEST[ 'doctor_id' ];
			$sql .= " and doctor_id=$doctor_id";
		}
		if ( isset( $_REQUEST[ 'specialization_id' ] ) and $_REQUEST[ 'specialization_id' ] > 0 ) {
			$specialization_id = $_REQUEST[ 'specialization_id' ];
			$sql .= " and specialization_id=$specialization_id";
		}
        $consultancies = $this -> db -> query($sql);
        return $consultancies -> row() -> totalRows;
    }

    /**
     * -------------------------
     * @return mixed
	 * @param $limit
	 * @param $offset
     * get cash customer consultancies
     * -------------------------
     */

    public function get_consultancies($limit, $offset) {
    	$sql = "Select * from hmis_consultancies where patient_id IN (Select id from hmis_patients where type='cash')";
//    	$sql = "Select * from hmis_consultancies where 1";
		if ( isset( $_REQUEST[ 'id' ] ) and $_REQUEST[ 'id' ] > 0 ) {
			$id = $_REQUEST[ 'id' ];
			$sql .= " and id=$id";
		}
		if ( isset( $_REQUEST[ 'patient_id' ] ) and $_REQUEST[ 'patient_id' ] > 0 ) {
			$patient_id = $_REQUEST[ 'patient_id' ];
			$sql .= " and patient_id=$patient_id";
		}
		if ( isset( $_REQUEST[ 'doctor_id' ] ) and $_REQUEST[ 'doctor_id' ] > 0 ) {
			$doctor_id = $_REQUEST[ 'doctor_id' ];
			$sql .= " and doctor_id=$doctor_id";
		}
		if ( isset( $_REQUEST[ 'specialization_id' ] ) and $_REQUEST[ 'specialization_id' ] > 0 ) {
			$specialization_id = $_REQUEST[ 'specialization_id' ];
			$sql .= " and specialization_id=$specialization_id";
		}
		$sql .= " order by id DESC limit $limit offset $offset";
		$consultancies = $this -> db -> query ($sql);
        return $consultancies -> result();
    }
	
	/**
	 * -------------------------
	 * @return mixed
	 * get cash customer consultancies
	 * -------------------------
	 */
	
	public function count_panel_consultancies () {
		$sql = "Select COUNT(*) as totalRows from hmis_consultancies where patient_id IN (Select id from hmis_patients where type='panel')";
		if ( isset( $_REQUEST[ 'id' ] ) and $_REQUEST[ 'id' ] > 0 ) {
			$id = $_REQUEST[ 'id' ];
			$sql .= " and id=$id";
		}
		if ( isset( $_REQUEST[ 'patient_id' ] ) and $_REQUEST[ 'patient_id' ] > 0 ) {
			$patient_id = $_REQUEST[ 'patient_id' ];
			$sql .= " and patient_id=$patient_id";
		}
		if ( isset( $_REQUEST[ 'doctor_id' ] ) and $_REQUEST[ 'doctor_id' ] > 0 ) {
			$doctor_id = $_REQUEST[ 'doctor_id' ];
			$sql .= " and doctor_id=$doctor_id";
		}
		if ( isset( $_REQUEST[ 'specialization_id' ] ) and $_REQUEST[ 'specialization_id' ] > 0 ) {
			$specialization_id = $_REQUEST[ 'specialization_id' ];
			$sql .= " and specialization_id=$specialization_id";
		}
		$consultancies = $this -> db -> query ( $sql );
		return $consultancies -> row () -> totalRows;
	}

    /**
     * -------------------------
     * @param $limit
	 * @param $offset
     * get panel customer consultancies
	 * @return mixed
     * -------------------------
	 */

    public function get_panel_consultancies( $limit, $offset) {
		$sql = "Select * from hmis_consultancies where patient_id IN (Select id from hmis_patients where type='panel')";
		if ( isset( $_REQUEST[ 'id' ] ) and $_REQUEST[ 'id' ] > 0 ) {
			$id = $_REQUEST[ 'id' ];
			$sql .= " and id=$id";
		}
		if ( isset( $_REQUEST[ 'patient_id' ] ) and $_REQUEST[ 'patient_id' ] > 0 ) {
			$patient_id = $_REQUEST[ 'patient_id' ];
			$sql .= " and patient_id=$patient_id";
		}
		if ( isset( $_REQUEST[ 'doctor_id' ] ) and $_REQUEST[ 'doctor_id' ] > 0 ) {
			$doctor_id = $_REQUEST[ 'doctor_id' ];
			$sql .= " and doctor_id=$doctor_id";
		}
		if ( isset( $_REQUEST[ 'specialization_id' ] ) and $_REQUEST[ 'specialization_id' ] > 0 ) {
			$specialization_id = $_REQUEST[ 'specialization_id' ];
			$sql .= " and specialization_id=$specialization_id";
		}
		$sql .= " order by id DESC limit $limit offset $offset";
		$consultancies = $this -> db -> query ( $sql );
		return $consultancies -> result ();
    }

    /**
     * -------------------------
     * @return mixed
     * @param $consultancy_id
     * get consultancy by id
     * -------------------------
     */

    public function get_consultancy_by_id($consultancy_id) {
        $consultancy = $this -> db -> get_where('consultancies', array('id' =>  $consultancy_id));
        return $consultancy -> row();
    }

    /**
     * -------------------------
     * @param $info
     * @param $consultancy_id
     * @return mixed
     * update consultancy
     * -------------------------
     */

    public function edit($info, $consultancy_id) {
        $this -> db -> update('consultancies', $info, array('id'   =>  $consultancy_id));
        return $this -> db -> affected_rows();
    }

    /**
     * -------------------------
     * @param $consultancy_id
     * @return mixed
     * delete consultancy
     * -------------------------
     */

    public function delete($consultancy_id) {
        $this -> db -> delete('consultancies', array('id'    =>  $consultancy_id));
        return $this -> db -> affected_rows();
    }

    /**
     * -------------------------
     * @param $consultancy_id
     * @return mixed
     * delete prescription
     * -------------------------
     */

    public function delete_prescriptions($consultancy_id) {
        $this -> db -> delete('doctor_prescriptions', array('consultancy_id'    =>  $consultancy_id));
        return $this -> db -> affected_rows();
    }

	/**
	 * -------------------------
	 * @return mixed
	 * get consultancy
	 * -------------------------
	 */

    public function search_consultancy() {
    	if(isset($_REQUEST['consultancy_id']) and !empty(trim($_REQUEST['consultancy_id'])) and is_numeric($_REQUEST['consultancy_id']) and $_REQUEST['consultancy_id'] > 0) {
    		$consultancy_id = $_REQUEST['consultancy_id'];
    		$consultancy = $this -> db -> query("Select * from hmis_consultancies where id=$consultancy_id");
    		return $consultancy -> row();
	    }
    }

	/**
	 * -------------------------
	 * @return mixed
	 * get prescription
	 * -------------------------
	 */

    public function get_prescription() {
    	if(isset($_REQUEST['consultancy_id']) and !empty(trim($_REQUEST['consultancy_id'])) and is_numeric($_REQUEST['consultancy_id']) and $_REQUEST['consultancy_id'] > 0) {
    		$consultancy_id = $_REQUEST['consultancy_id'];
    		$prescription = $this -> db -> query("Select * from hmis_doctor_prescriptions where consultancy_id=$consultancy_id");
    		return $prescription -> row();
	    }
    }

	/**
	 * -------------------------
	 * @param $patient_id
	 * get patient vitals
	 * @return mixed
	 * -------------------------
	 */

    public function get_vitals($patient_id) {
    	$date = date('Y-m-d');
    	$vitals = $this -> db -> get_where('patient_vitals', array('patient_id' =>  $patient_id,
                                                                   'DATE(date_added)'   =>  $date));
    	return $vitals -> result();
    }

	/**
	 * -------------------------
	 * @param $prescription_id
	 * get doctor prescriptions
	 * @return mixed
	 * -------------------------
	 */

    public function get_doctor_prescriptions($prescription_id) {
    	$prescription = $this -> db -> get_where('doctor_prescriptions', array('id' =>  $prescription_id));
    	return $prescription -> row();
    }

	/**
	 * -------------------------
	 * @param $info
	 * add prescriptions
	 * @return mixed
	 * -------------------------
	 */

    public function do_add_prescriptions($info) {
    	$this -> db -> insert('doctor_prescriptions', $info);
    	return $this -> db -> insert_id();
    }

	/**
	 * -------------------------
	 * @param $info
	 * @param $prescription_id
	 * @param $consultancy
	 * add doctor prescribed medicines
	 * @return mixed
	 * -------------------------
	 */

    public function add_doctor_prescribed_medicines($info, $prescription_id, $consultancy) {
    	if(isset($info['medicines']) and count(array_filter($info['medicines'])) > 0) {
    		foreach ($info['medicines'] as $key => $medicine) {
			    if ( ! empty( trim( $medicine ) ) and $medicine > 0 ) {
				    $array = array(
					    'doctor_id'       => $consultancy->doctor_id,
					    'patient_id'      => $consultancy->patient_id,
					    'consultancy_id'  => $_REQUEST['consultancy_id'],
					    'prescription_id' => $prescription_id,
					    'medicine_id'     => $medicine,
					    'dosage'          => $_POST['dosage'][ $key ],
					    'timings'         => $_POST['timings'][ $key ],
					    'days'            => $_POST['days'][ $key ],
					    'instructions'    => $_POST['instructions'][ $key ],
					    'date_added'        =>  date('Y-m-d h:i:s')
				    );
				    $this->db->insert( 'doctor_prescribed_medicines', $array );
			    }
		    }
	    }
    }

	/**
	 * -------------------------
	 * @param $info
	 * @param $prescription_id
	 * @param $consultancy
	 * add doctor prescribed tests
	 * @return mixed
	 * -------------------------
	 */

    public function add_doctor_prescribed_tests($info, $prescription_id, $consultancy) {
    	if(isset($info['tests']) and count(array_filter($info['tests'])) > 0) {
    		foreach ($info['tests'] as $tests) {
			    if ( ! empty( trim( $tests ) ) and $tests > 0 ) {
				    $array = array(
					    'doctor_id'       => $consultancy->doctor_id,
					    'patient_id'      => $consultancy->patient_id,
					    'consultancy_id'  => $_REQUEST['consultancy_id'],
					    'prescription_id' => $prescription_id,
					    'test_id'         => $tests,
					    'date_added'        =>  date('Y-m-d h:i:s')
				    );
				    $this->db->insert( 'doctor_prescribed_tests', $array );
			    }
		    }
	    }
    }

	/**
	 * -------------------------
	 * @param $info
	 * @param $prescription_id
	 * @param $consultancy
	 * add doctor rx
	 * @return mixed
	 * -------------------------
	 */

    public function add_doctor_rx($info, $prescription_id, $consultancy) {
    	if(isset($info['rx_medicines']) and count(array_filter($info['rx_medicines'])) > 0) {
    		foreach ($info['rx_medicines'] as $key => $medicine_id) {
			    if ( ! empty( trim( $medicine_id ) ) and $medicine_id > 0 ) {
				    $array = array(
					    'doctor_id'       => $consultancy->doctor_id,
					    'patient_id'      => $consultancy->patient_id,
					    'consultancy_id'  => $_REQUEST['consultancy_id'],
					    'prescription_id' => $prescription_id,
					    'medicine_id'     => $medicine_id,
					    'instruction_id'  => $info['instruction_id'][$key],
					    'date_added'      => date('Y-m-d h:i:s')
				    );
				    $this->db->insert( 'hmis_rx', $array );
			    }
		    }
	    }
    }

	/**
	 * -------------------------
	 * @param $consultancy_id
	 * @param $medicine_id
	 * check if medicine added with prescription
	 * @return bool
	 * -------------------------
	 */

    public function check_if_medicine_added_with_consultancy($consultancy_id, $medicine_id) {
    	$medicines = $this -> db -> get_where('doctor_prescribed_medicines', array('consultancy_id'  =>  $consultancy_id, 'medicine_id'  =>  $medicine_id));
    	if($medicines -> num_rows() > 0)
    		return true;
    	else
    		return false;
    }

	/**
	 * -------------------------
	 * @param $consultancy_id
	 * @param $test_id
	 * check if test added with prescription
	 * @return bool
	 * -------------------------
	 */

    public function check_if_test_added_with_consultancy($consultancy_id, $test_id) {
    	$medicines = $this -> db -> get_where('doctor_prescribed_tests', array('consultancy_id'  =>  $consultancy_id, 'test_id'  =>  $test_id));
    	if($medicines -> num_rows() > 0)
    		return true;
    	else
    		return false;
    }

	/**
	 * -------------------------
	 * @param $prescription_id
	 * get doctor prescribed medicines
	 * @return bool
	 * -------------------------
	 */

    public function get_doctor_prescribed_medicines($prescription_id) {
    	$medicines = $this -> db -> get_where('doctor_prescribed_medicines', array('prescription_id'  =>  $prescription_id));
    	return $medicines -> result();
    }

	/**
	 * -------------------------
	 * @param $prescription_id
	 * get doctor prescribed tests
	 * @return bool
	 * -------------------------
	 */

    public function get_doctor_prescribed_tests($prescription_id) {
    	$medicines = $this -> db -> get_where('doctor_prescribed_tests', array('prescription_id'  =>  $prescription_id));
    	return $medicines -> result();
    }

	/**
	 * -------------------------
	 * @return mixed
	 * get prescribed medicines
	 * -------------------------
	 */

    public function get_prescribed_medicines() {
    	if(isset($_REQUEST['consultancy_id']) and !empty(trim($_REQUEST['consultancy_id'])) and is_numeric($_REQUEST['consultancy_id'])) {
		    $consultancy_id = $_REQUEST['consultancy_id'];
		    $medicines      = $this->db->get_where( 'doctor_prescribed_medicines', array( 'consultancy_id' => $consultancy_id ) );

		    return $medicines->result();
	    }
	    else
	    	return array();
    }

	/**
	 * -------------------------
	 * @return mixed
	 * get prescribed rx
	 * -------------------------
	 */

    public function get_prescribed_rx() {
    	if(isset($_REQUEST['consultancy_id']) and !empty(trim($_REQUEST['consultancy_id'])) and is_numeric($_REQUEST['consultancy_id'])) {
		    $consultancy_id = $_REQUEST['consultancy_id'];
		    $rx      = $this->db->get_where( 'rx', array( 'consultancy_id' => $consultancy_id ) );
		    return $rx->result();
	    }
	    else
	    	return array();
    }

	/**
	 * -------------------------
	 * @param $doctor_id
	 * @return mixed
	 * get doctor consultancies
	 * -------------------------
	 */

    public function get_doctor_consultancies($doctor_id) {
    	$sql = "Select * from hmis_consultancies where doctor_id=$doctor_id";
    	if(isset($_REQUEST['start_date']) and !empty(trim($_REQUEST['start_date'])) and isset($_REQUEST['end_date']) and !empty(trim($_REQUEST['end_date']))) {
    		$start_date = date('Y-m-d', strtotime($_REQUEST['start_date']));
			$end_date = date('Y-m-d', strtotime($_REQUEST['end_date']));
    		$sql .= " and DATE(date_added) BETWEEN '$start_date' and '$end_date'";
		}
    	$query = $this -> db -> query($sql);
    	return $query -> result();
	}

	/**
	 * -------------------------
	 * @return mixed
	 * get consultancy total sale
	 * by date range
	 * -------------------------
	 */

	public function get_total_sale_by_date_range() {
    	$sql = "Select SUM(net_bill) as net from hmis_consultancies where refunded='0'";
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

}
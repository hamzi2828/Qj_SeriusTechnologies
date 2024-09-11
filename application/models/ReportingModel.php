<?php
    defined ( 'BASEPATH' ) or exit( 'No direct script access allowed' );
    
    class ReportingModel extends CI_Model {
        
        /**
         * -------------------------
         * ReportingModel constructor.
         * -------------------------
         */
        
        public function __construct () {
            parent ::__construct ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get sales report
         * -------------------------
         */
        
        public function get_sale_reports () {
            $sql = "Select GROUP_CONCAT(medicine_id) as medicine_id, user_id, GROUP_CONCAT(stock_id) as stock_id, sale_id, patient_id, GROUP_CONCAT(quantity) as quantity, GROUP_CONCAT(price) as price, SUM(net_price) as net_price, date_sold  from hmis_medicines_sold where 1";
            if ( isset( $_REQUEST[ 'start_date' ] ) and isset( $_REQUEST[ 'end_date' ] ) and !empty( $_REQUEST[ 'start_date' ] ) and !empty( $_REQUEST[ 'end_date' ] ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'start_date' ] ) );
                $end_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'end_date' ] ) );
                $sql .= " and DATE(date_sold) BETWEEN '$start_date' and '$end_date'";
            }
            if ( isset( $_REQUEST[ 'start_time' ] ) and isset( $_REQUEST[ 'end_time' ] ) and !empty( $_REQUEST[ 'start_time' ] ) and !empty( $_REQUEST[ 'end_time' ] ) ) {
                $start_time = date ( 'H:i:s', strtotime ( $_REQUEST[ 'start_time' ] ) );
                $end_time = date ( 'H:i:s', strtotime ( $_REQUEST[ 'end_time' ] ) );
                $sql .= " and TIME(date_sold) BETWEEN '$start_time' and '$end_time'";
            }
            if ( isset( $_REQUEST[ 'medicine_id' ] ) and is_numeric ( $_REQUEST[ 'medicine_id' ] ) and $_REQUEST[ 'medicine_id' ] > 0 ) {
                $medicine_id = $_REQUEST[ 'medicine_id' ];
                $sql .= " and medicine_id=$medicine_id";
            }
            if ( isset( $_REQUEST[ 'acc_head_id' ] ) and !empty( trim ( $_REQUEST[ 'acc_head_id' ] ) ) ) {
                $acc_head_id = explode ( '-', $_REQUEST[ 'acc_head_id' ] );
                $sql .= " and patient_id=$acc_head_id[1]";
            }
            if ( isset( $_REQUEST[ 'user_id' ] ) and !empty( trim ( $_REQUEST[ 'user_id' ] ) ) ) {
                $user_id = $_REQUEST[ 'user_id' ];
                $sql .= " and user_id=$user_id";
            }
            if ( isset( $_REQUEST[ 'sale_from' ] ) and is_numeric ( $_REQUEST[ 'sale_from' ] ) and $_REQUEST[ 'sale_from' ] > 0 and isset( $_REQUEST[ 'sale_to' ] ) and is_numeric ( $_REQUEST[ 'sale_to' ] ) and $_REQUEST[ 'sale_to' ] > 0 ) {
                $sale_from = $_REQUEST[ 'sale_from' ];
                $sale_to = $_REQUEST[ 'sale_to' ];
                $sql .= " and sale_id BETWEEN $sale_from and $sale_to";
            }
            $sql .= " group by sale_id order by id ASC";
            $sales = $this -> db -> query ( $sql );
            return $sales -> result ();
        }
        
        /**
         * -------------------------
         * @param $stocks
         * get sales report
         * -------------------------
         * @return mixed
         */
        
        public function get_sale_report_by_supplier_stock ( $stocks ) {
            $sql = "Select GROUP_CONCAT(medicine_id) as medicine_id, user_id, GROUP_CONCAT(stock_id) as stock_id, sale_id, patient_id, GROUP_CONCAT(quantity) as quantity, GROUP_CONCAT(price) as price, SUM(net_price) as net_price, date_sold  from hmis_medicines_sold where stock_id IN ($stocks)";
            $sql .= " group by sale_id order by id ASC";
            $sales = $this -> db -> query ( $sql );
            return $sales -> result ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get sales report ipd medication
         * -------------------------
         */
        
        public function get_sale_reports_ipd_medication () {
            $search = false;
            $sql = "Select GROUP_CONCAT(medicine_id) as medicine_id, user_id, GROUP_CONCAT(stock_id) as stock_id, sale_id, patient_id, GROUP_CONCAT(quantity) as quantity, GROUP_CONCAT(price) as price, SUM(net_price) as net_price, date_added  from hmis_ipd_medication where 1";
            if ( isset( $_REQUEST[ 'start_date' ] ) and isset( $_REQUEST[ 'end_date' ] ) and !empty( $_REQUEST[ 'start_date' ] ) and !empty( $_REQUEST[ 'end_date' ] ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'start_date' ] ) );
                $end_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'end_date' ] ) );
                $sql .= " and DATE(date_added) BETWEEN '$start_date' and '$end_date'";
                $search = true;
            }
            if ( isset( $_REQUEST[ 'start_time' ] ) and isset( $_REQUEST[ 'end_time' ] ) and !empty( $_REQUEST[ 'start_time' ] ) and !empty( $_REQUEST[ 'end_time' ] ) ) {
                $start_time = date ( 'H:i:s', strtotime ( $_REQUEST[ 'start_time' ] ) );
                $end_time = date ( 'H:i:s', strtotime ( $_REQUEST[ 'end_time' ] ) );
                $sql .= " and TIME(date_added) BETWEEN '$start_time' and '$end_time'";
                $search = true;
            }
            if ( isset( $_REQUEST[ 'medicine_id' ] ) and is_numeric ( $_REQUEST[ 'medicine_id' ] ) and $_REQUEST[ 'medicine_id' ] > 0 ) {
                $medicine_id = $_REQUEST[ 'medicine_id' ];
                $sql .= " and medicine_id=$medicine_id";
                $search = true;
            }
            if ( isset( $_REQUEST[ 'acc_head_id' ] ) and !empty( trim ( $_REQUEST[ 'acc_head_id' ] ) ) ) {
                $acc_head_id = explode ( '-', $_REQUEST[ 'acc_head_id' ] );
                $sql .= " and patient_id=$acc_head_id[1]";
                $search = true;
            }
            if ( isset( $_REQUEST[ 'patient-type' ] ) and !empty( trim ( $_REQUEST[ 'patient-type' ] ) ) ) {
                $type = $_REQUEST[ 'patient-type' ];
                if ( $type != 'cash' )
                    $sql .= " and patient_id IN (Select id from hmis_patients where panel_id=$type)";
                else
                    $sql .= " and patient_id IN (Select id from hmis_patients where panel_id < 1 OR panel_id IS NULL or panel_id='')";
                $search = true;
            }
            
            if ( isset( $_REQUEST[ 'user_id' ] ) and !empty( trim ( $_REQUEST[ 'user_id' ] ) ) ) {
                $user_id = $_REQUEST[ 'user_id' ];
                $sql .= " and user_id=$user_id";
                $search = true;
            }
            if ( isset( $_REQUEST[ 'sale_from' ] ) and is_numeric ( $_REQUEST[ 'sale_from' ] ) and $_REQUEST[ 'sale_from' ] > 0 and isset( $_REQUEST[ 'sale_to' ] ) and is_numeric ( $_REQUEST[ 'sale_to' ] ) and $_REQUEST[ 'sale_to' ] > 0 ) {
                $sale_from = $_REQUEST[ 'sale_from' ];
                $sale_to = $_REQUEST[ 'sale_to' ];
                $sql .= " and sale_id BETWEEN $sale_from and $sale_to";
                $search = true;
            }
            $sql .= " group by sale_id order by id ASC";
            $sales = $this -> db -> query ( $sql );
            if ( $search )
                return $sales -> result ();
            else
                return array ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get profit report
         * -------------------------
         */
        
        public function get_profit_reports () {
            $sql = "Select GROUP_CONCAT(medicine_id) as medicine_id, GROUP_CONCAT(stock_id) as stock_id, sale_id, patient_id, GROUP_CONCAT(quantity) as quantity, GROUP_CONCAT(price) as price, SUM(net_price) as net_price, date_sold  from hmis_medicines_sold where 1";
            if ( isset( $_REQUEST[ 'start_date' ] ) and isset( $_REQUEST[ 'end_date' ] ) and !empty( $_REQUEST[ 'start_date' ] ) and !empty( $_REQUEST[ 'end_date' ] ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'start_date' ] ) );
                $end_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'end_date' ] ) );
                $sql .= " and DATE(date_sold) BETWEEN '$start_date' and '$end_date'";
            }
            if ( isset( $_REQUEST[ 'medicine_id' ] ) and is_numeric ( $_REQUEST[ 'medicine_id' ] ) and $_REQUEST[ 'medicine_id' ] > 0 ) {
                $medicine_id = $_REQUEST[ 'medicine_id' ];
                $sql .= " and medicine_id=$medicine_id";
            }
            if ( isset( $_REQUEST[ 'acc_head_id' ] ) and !empty( trim ( $_REQUEST[ 'acc_head_id' ] ) ) ) {
                $acc_head_id = explode ( '-', $_REQUEST[ 'acc_head_id' ] );
                $sql .= " and patient_id=$acc_head_id[1]";
            }
            if ( isset( $_REQUEST[ 'sale_from' ] ) and is_numeric ( $_REQUEST[ 'sale_from' ] ) and $_REQUEST[ 'sale_from' ] > 0 and isset( $_REQUEST[ 'sale_to' ] ) and is_numeric ( $_REQUEST[ 'sale_to' ] ) and $_REQUEST[ 'sale_to' ] > 0 ) {
                $sale_from = $_REQUEST[ 'sale_from' ];
                $sale_to = $_REQUEST[ 'sale_to' ];
                $sql .= " and sale_id BETWEEN $sale_from and $sale_to";
            }
            $sql .= " group by sale_id order by id DESC";
            $sales = $this -> db -> query ( $sql );
            return $sales -> result ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get customer return profit report
         * -------------------------
         */
        
        public function get_customer_return_profit_reports () {
            $sql = "Select * from hmis_medicines_stock where returned='1'";
            if ( isset( $_REQUEST[ 'start_date' ] ) and isset( $_REQUEST[ 'end_date' ] ) and !empty( $_REQUEST[ 'start_date' ] ) and !empty( $_REQUEST[ 'end_date' ] ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'start_date' ] ) );
                $end_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'end_date' ] ) );
                $sql .= " and DATE(date_added) BETWEEN '$start_date' and '$end_date'";
            }
            if ( isset( $_REQUEST[ 'medicine_id' ] ) and is_numeric ( $_REQUEST[ 'medicine_id' ] ) and $_REQUEST[ 'medicine_id' ] > 0 ) {
                $medicine_id = $_REQUEST[ 'medicine_id' ];
                $sql .= " and medicine_id=$medicine_id";
            }
            $sql .= " order by id ASC";
            $sales = $this -> db -> query ( $sql );
            return $sales -> result ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get cash consultancies
         * -------------------------
         */
        
        public function get_consultancies () {
            $search = false;
            $sql = "Select * from hmis_consultancies where patient_id IN (Select id from hmis_patients where type='cash')";
            if ( isset( $_REQUEST[ 'doctor_id' ] ) and !empty( trim ( $_REQUEST[ 'doctor_id' ] ) ) and $_REQUEST[ 'doctor_id' ] > 0 and is_numeric ( $_REQUEST[ 'doctor_id' ] ) ) {
                $doctor_id = $_REQUEST[ 'doctor_id' ];
                $sql .= " and doctor_id=$doctor_id";
                $search = true;
            }
            if ( isset( $_REQUEST[ 'start_date' ] ) and !empty( trim ( $_REQUEST[ 'start_date' ] ) ) and isset( $_REQUEST[ 'end_date' ] ) and !empty( trim ( $_REQUEST[ 'end_date' ] ) ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'start_date' ] ) );
                $end_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'end_date' ] ) );
                $sql .= " and DATE(date_added) BETWEEN '$start_date' and '$end_date'";
                $search = true;
            }
            if ( isset( $_REQUEST[ 'start_time' ] ) and isset( $_REQUEST[ 'end_time' ] ) and !empty( $_REQUEST[ 'start_time' ] ) and !empty( $_REQUEST[ 'end_time' ] ) ) {
                $start_time = date ( 'H:i:s', strtotime ( $_REQUEST[ 'start_time' ] ) );
                $end_time = date ( 'H:i:s', strtotime ( $_REQUEST[ 'end_time' ] ) );
                $sql .= " and TIME(date_added) BETWEEN '$start_time' and '$end_time'";
                $search = true;
            }
            $consultancies = $this -> db -> query ( $sql );
            if ( $search )
                return $consultancies -> result ();
            else
                return array ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get panel consultancies
         * -------------------------
         */
        
        public function get_consultancies_panel () {
            $search = false;
            $sql = "Select * from hmis_consultancies where patient_id IN (Select id from hmis_patients where type='panel')";
            if ( isset( $_REQUEST[ 'doctor_id' ] ) and !empty( trim ( $_REQUEST[ 'doctor_id' ] ) ) and $_REQUEST[ 'doctor_id' ] > 0 and is_numeric ( $_REQUEST[ 'doctor_id' ] ) ) {
                $doctor_id = $_REQUEST[ 'doctor_id' ];
                $sql .= " and doctor_id=$doctor_id";
                $search = true;
            }
            if ( isset( $_REQUEST[ 'panel_id' ] ) and !empty( trim ( $_REQUEST[ 'panel_id' ] ) ) and $_REQUEST[ 'panel_id' ] > 0 and is_numeric ( $_REQUEST[ 'panel_id' ] ) ) {
                $panel_id = $_REQUEST[ 'panel_id' ];
                $sql .= " and  patient_id IN (Select id from hmis_patients where panel_id=$panel_id)";
                $search = true;
            }
            if ( isset( $_REQUEST[ 'start_date' ] ) and !empty( trim ( $_REQUEST[ 'start_date' ] ) ) and isset( $_REQUEST[ 'end_date' ] ) and !empty( trim ( $_REQUEST[ 'end_date' ] ) ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'start_date' ] ) );
                $end_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'end_date' ] ) );
                $sql .= " and DATE(date_added) BETWEEN '$start_date' and '$end_date'";
                $search = true;
            }
            if ( isset( $_REQUEST[ 'start_time' ] ) and isset( $_REQUEST[ 'end_time' ] ) and !empty( $_REQUEST[ 'start_time' ] ) and !empty( $_REQUEST[ 'end_time' ] ) ) {
                $start_time = date ( 'H:i:s', strtotime ( $_REQUEST[ 'start_time' ] ) );
                $end_time = date ( 'H:i:s', strtotime ( $_REQUEST[ 'end_time' ] ) );
                $sql .= " and TIME(date_added) BETWEEN '$start_time' and '$end_time'";
                $search = true;
            }
            $consultancies = $this -> db -> query ( $sql );
            if ( $search )
                return $consultancies -> result ();
            else
                return array ();
        }
        
        /**
         * --------------
         * get sales grouped by sale id
         * @return mixed
         * --------------
         */
        
        public function get_sales_by_sale_grouped () {
            $search = false;
            $sql = "Select patient_id, sale_id, GROUP_CONCAT(doctor_id) as doctors, GROUP_CONCAT(service_id) as services, GROUP_CONCAT(price) as prices, GROUP_CONCAT(discount) as discounts, SUM(net_price) as net_price, date_added from hmis_opd_services_sales where patient_id IN (Select id from hmis_patients where type='cash')";
            if ( isset( $_REQUEST[ 'service_id' ] ) and !empty( trim ( $_REQUEST[ 'service_id' ] ) ) and $_REQUEST[ 'service_id' ] > 0 and is_numeric ( $_REQUEST[ 'service_id' ] ) ) {
                $service_id = $_REQUEST[ 'service_id' ];
                $sql .= " and service_id=$service_id";
                $search = true;
            }
            if ( isset( $_REQUEST[ 'start_date' ] ) and !empty( trim ( $_REQUEST[ 'start_date' ] ) ) and isset( $_REQUEST[ 'end_date' ] ) and !empty( trim ( $_REQUEST[ 'end_date' ] ) ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'start_date' ] ) );
                $end_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'end_date' ] ) );
                $sql .= " and DATE(date_added) BETWEEN '$start_date' and '$end_date'";
                $search = true;
            }
            if ( isset( $_REQUEST[ 'start_time' ] ) and isset( $_REQUEST[ 'end_time' ] ) and !empty( $_REQUEST[ 'start_time' ] ) and !empty( $_REQUEST[ 'end_time' ] ) ) {
                $start_time = date ( 'H:i:s', strtotime ( $_REQUEST[ 'start_time' ] ) );
                $end_time = date ( 'H:i:s', strtotime ( $_REQUEST[ 'end_time' ] ) );
                $sql .= " and TIME(date_added) BETWEEN '$start_time' and '$end_time'";
                $search = true;
            }
            $sql .= " GROUP BY sale_id order by id ASC";
            $sales = $this -> db -> query ( $sql );
            if ( $search )
                return $sales -> result ();
            else
                return array ();
        }
        
        /**
         * --------------
         * get sales grouped by sale id
         * @return mixed
         * --------------
         */
        
        public function get_panel_sales_by_sale_grouped () {
            $search = false;
            $sql = "Select patient_id, sale_id, GROUP_CONCAT(service_id) as services, GROUP_CONCAT(doctor_id) as doctors, GROUP_CONCAT(price) as prices, GROUP_CONCAT(discount) as discounts, SUM(net_price) as net_price, date_added from hmis_opd_services_sales where patient_id IN (Select id from hmis_patients where type='panel')";
            if ( isset( $_REQUEST[ 'service_id' ] ) and !empty( trim ( $_REQUEST[ 'service_id' ] ) ) and $_REQUEST[ 'service_id' ] > 0 and is_numeric ( $_REQUEST[ 'service_id' ] ) ) {
                $service_id = $_REQUEST[ 'service_id' ];
                $sql .= " and service_id=$service_id";
                $search = true;
            }
            if ( isset( $_REQUEST[ 'panel_id' ] ) and !empty( trim ( $_REQUEST[ 'panel_id' ] ) ) and $_REQUEST[ 'panel_id' ] > 0 and is_numeric ( $_REQUEST[ 'panel_id' ] ) ) {
                $panel_id = $_REQUEST[ 'panel_id' ];
                $sql .= " and patient_id IN (Select id from hmis_patients where panel_id=$panel_id)";
                $search = true;
            }
            if ( isset( $_REQUEST[ 'panel_id' ] ) and !empty( trim ( $_REQUEST[ 'panel_id' ] ) ) and $_REQUEST[ 'panel_id' ] > 0 and is_numeric ( $_REQUEST[ 'panel_id' ] ) ) {
                $panel_id = $_REQUEST[ 'panel_id' ];
                $sql .= " and patient_id IN (Select id from hmis_patients where panel_id=$panel_id)";
                $search = true;
            }
            if ( isset( $_REQUEST[ 'start_date' ] ) and !empty( trim ( $_REQUEST[ 'start_date' ] ) ) and isset( $_REQUEST[ 'end_date' ] ) and !empty( trim ( $_REQUEST[ 'end_date' ] ) ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'start_date' ] ) );
                $end_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'end_date' ] ) );
                $sql .= " and DATE(date_added) BETWEEN '$start_date' and '$end_date'";
                $search = true;
            }
            if ( isset( $_REQUEST[ 'start_time' ] ) and isset( $_REQUEST[ 'end_time' ] ) and !empty( $_REQUEST[ 'start_time' ] ) and !empty( $_REQUEST[ 'end_time' ] ) ) {
                $start_time = date ( 'H:i:s', strtotime ( $_REQUEST[ 'start_time' ] ) );
                $end_time = date ( 'H:i:s', strtotime ( $_REQUEST[ 'end_time' ] ) );
                $sql .= " and TIME(date_added) BETWEEN '$start_time' and '$end_time'";
                $search = true;
            }
            $sql .= " GROUP BY sale_id order by id ASC";
            $sales = $this -> db -> query ( $sql );
            if ( $search )
                return $sales -> result ();
            else
                return array ();
        }
        
        /**
         * --------------
         * @return mixed
         * get customer return stock
         * --------------
         */
        
        public function get_customer_sale_return_reports () {
            $customer_return = return_customer;
            $sql = "Select * from hmis_medicines_stock where supplier_id=$customer_return";
            if ( isset( $_REQUEST[ 'start_date' ] ) and !empty( trim ( $_REQUEST[ 'start_date' ] ) ) and isset( $_REQUEST[ 'end_date' ] ) and !empty( trim ( $_REQUEST[ 'end_date' ] ) ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'start_date' ] ) );
                $end_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'end_date' ] ) );
                $sql .= " and DATE(date_added) BETWEEN '$start_date' and '$end_date'";
            }
            if ( isset( $_REQUEST[ 'start_time' ] ) and isset( $_REQUEST[ 'end_time' ] ) and !empty( $_REQUEST[ 'start_time' ] ) and !empty( $_REQUEST[ 'end_time' ] ) ) {
                $start_time = date ( 'H:i:s', strtotime ( $_REQUEST[ 'start_time' ] ) );
                $end_time = date ( 'H:i:s', strtotime ( $_REQUEST[ 'end_time' ] ) );
                $sql .= " and TIME(date_added) BETWEEN '$start_time' and '$end_time'";
            }
            if ( isset( $_REQUEST[ 'medicine_id' ] ) and !empty( trim ( $_REQUEST[ 'medicine_id' ] ) ) ) {
                $medicine_id = $_REQUEST[ 'medicine_id' ];
                $sql .= " and medicine_id=$medicine_id";
            }
            $returns = $this -> db -> query ( $sql );
            return $returns -> result ();
        }
        
        /**
         * --------------
         * @return mixed
         * get store sales
         * --------------
         */
        
        public function get_store_sales () {
            $search = false;
            $sql = "Select id, sale_id, sold_by, department_id, account_head, sold_to, GROUP_CONCAT(store_id) as store_id, GROUP_CONCAT(stock_id) as stock_id, GROUP_CONCAT(quantity) as quantities, date_added from hmis_store_sold_items where 1";
            if ( isset( $_REQUEST[ 'start_date' ] ) and !empty( trim ( $_REQUEST[ 'start_date' ] ) ) and isset( $_REQUEST[ 'end_date' ] ) and !empty( trim ( $_REQUEST[ 'end_date' ] ) ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'start_date' ] ) );
                $end_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'end_date' ] ) );
                $sql .= " and DATE(date_added) BETWEEN '$start_date' and '$end_date'";
                $search = true;
            }
            if ( isset( $_REQUEST[ 'user_id' ] ) and !empty( trim ( $_REQUEST[ 'user_id' ] ) ) ) {
                $user_id = $_REQUEST[ 'user_id' ];
                $sql .= " and sold_to=$user_id";
                $search = true;
            }
            if ( isset( $_REQUEST[ 'department_id' ] ) and !empty( trim ( $_REQUEST[ 'department_id' ] ) ) ) {
                $department_id = $_REQUEST[ 'department_id' ];
                $sql .= " and department_id=$department_id";
                $search = true;
            }
            if ( isset( $_REQUEST[ 'store_id' ] ) and !empty( trim ( $_REQUEST[ 'store_id' ] ) ) ) {
                $store_id = $_REQUEST[ 'store_id' ];
                $sql .= " and store_id=$store_id";
                $search = true;
            }
            if ( isset( $_REQUEST[ 'type' ] ) and !empty( trim ( $_REQUEST[ 'type' ] ) ) ) {
                $type = str_replace ( '-', ' ', $_REQUEST[ 'type' ] );
                $sql .= " and store_id IN (Select id from hmis_store where type='$type')";
                $search = true;
            }
            $sql .= " group by sale_id order by date_added DESC";
            $returns = $this -> db -> query ( $sql );
            if ( $search )
                return $returns -> result ();
            else
                return array ();
        }
        
        /**
         * --------------
         * @return mixed
         * get consultancy summary sales
         * --------------
         */
        
        public function get_consultancy_sales_summary () {
            $sql = "Select SUM(net_bill) as total from hmis_consultancies where 1";
            if ( isset( $_REQUEST[ 'start_date' ] ) and !empty( trim ( $_REQUEST[ 'start_date' ] ) ) and isset( $_REQUEST[ 'end_date' ] ) and !empty( trim ( $_REQUEST[ 'end_date' ] ) ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'start_date' ] ) );
                $end_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'end_date' ] ) );
                $sql .= " and DATE(date_added) BETWEEN '$start_date' and '$end_date'";
            }
            $returns = $this -> db -> query ( $sql );
            return $returns -> row ();
        }
        
        /**
         * --------------
         * @return mixed
         * get opd summary sales
         * --------------
         */
        
        public function get_opd_sales_summary () {
            $sql = "Select SUM(net_price) as total from hmis_opd_services_sales where 1";
            if ( isset( $_REQUEST[ 'start_date' ] ) and !empty( trim ( $_REQUEST[ 'start_date' ] ) ) and isset( $_REQUEST[ 'end_date' ] ) and !empty( trim ( $_REQUEST[ 'end_date' ] ) ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'start_date' ] ) );
                $end_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'end_date' ] ) );
                $sql .= " and DATE(date_added) BETWEEN '$start_date' and '$end_date'";
            }
            $returns = $this -> db -> query ( $sql );
            return $returns -> row ();
        }
        
        /**
         * --------------
         * @return mixed
         * get pharmacy summary sales
         * --------------
         */
        
        public function get_pharmacy_sales_summary () {
            $sql = "SELECT * FROM hmis_medicines_sold WHERE 1";
            if ( isset( $_REQUEST[ 'start_date' ] ) and !empty( trim ( $_REQUEST[ 'start_date' ] ) ) and isset( $_REQUEST[ 'end_date' ] ) and !empty( trim ( $_REQUEST[ 'end_date' ] ) ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'start_date' ] ) );
                $end_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'end_date' ] ) );
                $sql .= " and DATE(date_sold) BETWEEN '$start_date' AND '$end_date'";
            }
            $sql .= " AND sale_id IN (SELECT id FROM hmis_sales) group by sale_id";
            $returns = $this -> db -> query ( $sql );
            $records = $returns -> result ();
            $net = 0;
            if ( count ( $records ) > 0 ) {
                foreach ( $records as $record ) {
                    $sale = get_sale ( $record -> sale_id );
                    $net = $net + $sale -> total;
                }
            }
            return $net;
        }
        
        /**
         * --------------
         * @return mixed
         * get pharmacy discount
         * --------------
         */
        
        public function get_pharmacy_discount () {
            $sql = "SELECT SUM(net_price) as net, sale_id FROM hmis_medicines_sold WHERE 1";
            if ( isset( $_REQUEST[ 'start_date' ] ) and !empty( trim ( $_REQUEST[ 'start_date' ] ) ) and isset( $_REQUEST[ 'end_date' ] ) and !empty( trim ( $_REQUEST[ 'end_date' ] ) ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'start_date' ] ) );
                $end_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'end_date' ] ) );
                $sql .= " and DATE(date_sold) BETWEEN '$start_date' AND '$end_date'";
            }
            $sql .= " AND sale_id IN (SELECT id FROM hmis_sales) group by sale_id";
            $returns = $this -> db -> query ( $sql );
            $records = $returns -> result ();
            $net = 0;
            if ( count ( $records ) > 0 ) {
                foreach ( $records as $record ) {
                    $sale = get_sale ( $record -> sale_id );
                    $dis = $record -> net - $sale -> total;
                    $net += $dis;
                }
            }
            return $net;
        }
        
        /**
         * --------------
         * @return mixed
         * get sales return summary
         * --------------
         */
        
        public function get_return_sales_summary () {
            $return_customer = return_customer;
            $sql = "Select SUM(paid_to_customer) as total from hmis_medicines_stock where supplier_id=$return_customer";
            if ( isset( $_REQUEST[ 'start_date' ] ) and !empty( trim ( $_REQUEST[ 'start_date' ] ) ) and isset( $_REQUEST[ 'end_date' ] ) and !empty( trim ( $_REQUEST[ 'end_date' ] ) ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'start_date' ] ) );
                $end_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'end_date' ] ) );
                $sql .= " and DATE(date_added) BETWEEN '$start_date' and '$end_date'";
            }
            $returns = $this -> db -> query ( $sql );
            if ( $returns -> row () -> total > 0 )
                return $returns -> row () -> total;
            else
                return '0';
        }
        
        /**
         * --------------
         * @return mixed
         * get lab summary sales
         * --------------
         */
        
        public function get_lab_sales_summary () {
            $sql = "Select SUM(price) as total from hmis_test_sales where status='1'";
            if ( isset( $_REQUEST[ 'start_date' ] ) and !empty( trim ( $_REQUEST[ 'start_date' ] ) ) and isset( $_REQUEST[ 'end_date' ] ) and !empty( trim ( $_REQUEST[ 'end_date' ] ) ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'start_date' ] ) );
                $end_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'end_date' ] ) );
                $sql .= " and DATE(date_added) BETWEEN '$start_date' and '$end_date'";
            }
            $returns = $this -> db -> query ( $sql );
            return $returns -> row ();
        }
        
        /**
         * --------------
         * @return mixed
         * get bonus stock report
         * --------------
         */
        
        public function bonus_stock_report () {
            $query = $this -> db -> query ( "Select * from hmis_medicines where id IN (Select medicine_id from hmis_medicines_stock where (tp_unit='0' or tp_unit=0 or tp_unit IS NULL))" );
            return $query -> result ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get form
         * -------------------------
         */
        
        public function get_forms () {
            $sql = "Select * from hmis_forms where 1";
            if ( isset( $_REQUEST[ 'form_id' ] ) and $_REQUEST[ 'form_id' ] > 0 ) {
                $form_id = $_REQUEST[ 'form_id' ];
                $sql .= " and id=$form_id";
            }
            $sql .= " order by title ASC";
            $forms = $this -> db -> query ( $sql );
            return $forms -> result ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get form
         * -------------------------
         */
        
        public function get_forms_except_tablets_capsules () {
            $sql = "Select * from hmis_forms where id NOT IN(3, 4)";
            $sql .= " order by title ASC";
            $forms = $this -> db -> query ( $sql );
            return $forms -> result ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get form
         * -------------------------
         */
        
        public function get_forms_combined_tablets_capsules () {
            $sql = "Select * from hmis_forms where id IN(3, 4)";
            $sql .= " order by title ASC";
            $forms = $this -> db -> query ( $sql );
            return $forms -> result ();
        }
        
        /**
         * -------------------------
         * @param $form_id
         * get form
         * -------------------------
         * @return mixed
         */
        
        public function get_medicines_by_form ( $form_id ) {
            $this -> db -> order_by ( 'name', 'ASC' );
            $medicines = $this -> db -> get_where ( 'medicines', array ( 'form_id' => $form_id ) );
            return $medicines -> result ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get supplier stock
         * by supplier, and date range
         * -------------------------
         */
        
        public function get_supplier_stock () {
            $search = false;
            $sql = "Select supplier_id, GROUP_CONCAT(DISTINCT supplier_invoice) as invoices, SUM(net_price) as net_price, date_added from hmis_medicines_stock where 1";
            if ( isset( $_REQUEST[ 'supplier_id' ] ) and $_REQUEST[ 'supplier_id' ] > 0 ) {
                $supplier_id = $_REQUEST[ 'supplier_id' ];
                $sql .= " and supplier_id=$supplier_id";
                $search = true;
            }
            if ( isset( $_REQUEST[ 'start_date' ] ) and !empty( $_REQUEST[ 'start_date' ] ) and isset( $_REQUEST[ 'end_date' ] ) and !empty( $_REQUEST[ 'end_date' ] ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'start_date' ] ) );
                $end_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'end_date' ] ) );
                $sql .= " and DATE(date_added) BETWEEN '$start_date' and '$end_date'";
                $search = true;
            }
            $sql .= " group by supplier_id";
            $stock = $this -> db -> query ( $sql );
            if ( $search )
                return $stock -> result ();
            else
                return array ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get stock analysis
         * -------------------------
         */
        
        public function get_stock_analysis () {
            $search = false;
            $sql = "Select supplier_id, supplier_invoice, GROUP_CONCAT(medicine_id) as medicines, GROUP_CONCAT(quantity) as quantities, SUM(net_price) as net_price, date_added from hmis_medicines_stock where 1";
            if ( isset( $_REQUEST[ 'supplier_id' ] ) and $_REQUEST[ 'supplier_id' ] > 0 ) {
                $supplier_id = $_REQUEST[ 'supplier_id' ];
                $sql .= " and supplier_id=$supplier_id";
                $search = true;
            }
            if ( isset( $_REQUEST[ 'medicine_id' ] ) and $_REQUEST[ 'medicine_id' ] > 0 ) {
                $medicine_id = $_REQUEST[ 'medicine_id' ];
                $sql .= " and medicine_id=$medicine_id";
                $search = true;
            }
            if ( isset( $_REQUEST[ 'start_date' ] ) and !empty( $_REQUEST[ 'start_date' ] ) and isset( $_REQUEST[ 'end_date' ] ) and !empty( $_REQUEST[ 'end_date' ] ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'start_date' ] ) );
                $end_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'end_date' ] ) );
                $sql .= " and DATE(date_added) BETWEEN '$start_date' and '$end_date'";
                $search = true;
            }
            $sql .= " group by supplier_invoice";
            $stock = $this -> db -> query ( $sql );
            if ( $search )
                return $stock -> result ();
            else
                return array ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get stock analysis by sale
         * -------------------------
         */
        
        public function get_stock_analysis_by_sale () {
            $search = false;
            $sql = "Select medicine_id, SUM(quantity) as quantity, SUM(net_price) as net_price, date_sold, GROUP_CONCAT(sale_id) as sale_ids from hmis_medicines_sold where 1";
            if ( isset( $_REQUEST[ 'medicine_id' ] ) and $_REQUEST[ 'medicine_id' ] > 0 ) {
                $medicine_id = $_REQUEST[ 'medicine_id' ];
                $sql .= " and medicine_id=$medicine_id";
                $search = true;
            }
            if ( isset( $_REQUEST[ 'start_date' ] ) and !empty( $_REQUEST[ 'start_date' ] ) and isset( $_REQUEST[ 'end_date' ] ) and !empty( $_REQUEST[ 'end_date' ] ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'start_date' ] ) );
                $end_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'end_date' ] ) );
                $sql .= " and DATE(date_sold) BETWEEN '$start_date' and '$end_date'";
                $search = true;
            }
            $sql .= " group by medicine_id order by SUM(quantity) DESC";
            $stock = $this -> db -> query ( $sql );
            if ( $search )
                return $stock -> result ();
            else
                return array ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get stock analysis by sale
         * -------------------------
         */
        
        public function get_stock_analysis_by_ipd_sale () {
            $search = false;
            $sql = "Select medicine_id, SUM(quantity) as quantity, SUM(net_price) as net_price, SUM(price) as price, date_added as date_sold, GROUP_CONCAT(sale_id) as sale_ids from hmis_ipd_medication where 1";
            if ( isset( $_REQUEST[ 'medicine_id' ] ) and $_REQUEST[ 'medicine_id' ] > 0 ) {
                $medicine_id = $_REQUEST[ 'medicine_id' ];
                $sql .= " and medicine_id=$medicine_id";
                $search = true;
            }
            if ( isset( $_REQUEST[ 'start_date' ] ) and !empty( $_REQUEST[ 'start_date' ] ) and isset( $_REQUEST[ 'end_date' ] ) and !empty( $_REQUEST[ 'end_date' ] ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'start_date' ] ) );
                $end_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'end_date' ] ) );
                $sql .= " and DATE(date_added) BETWEEN '$start_date' and '$end_date'";
                $search = true;
            }
            $sql .= " group by medicine_id order by SUM(quantity) DESC";
            $stock = $this -> db -> query ( $sql );
            if ( $search )
                return $stock -> result ();
            else
                return array ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get xray reporting
         * -------------------------
         */
        
        public function get_xray_reporting () {
            $search = false;
            $sql = "Select * from hmis_xray where 1";
            if ( isset( $_REQUEST[ 'doctor_id' ] ) and $_REQUEST[ 'doctor_id' ] > 0 ) {
                $doctor_id = $_REQUEST[ 'doctor_id' ];
                $sql .= " and doctor_id=$doctor_id";
                $search = true;
            }
            if ( isset( $_REQUEST[ 'referenced_by' ] ) and $_REQUEST[ 'referenced_by' ] > 0 ) {
                $doctor_id = $_REQUEST[ 'referenced_by' ];
                $sql .= " and order_by=$doctor_id";
                $search = true;
            }
            if ( isset( $_REQUEST[ 'invoice-id' ] ) and $_REQUEST[ 'invoice-id' ] > 0 ) {
                $sale_id = $_REQUEST[ 'invoice-id' ];
                $sql .= " and sale_id=$sale_id";
                $search = true;
            }
            if ( isset( $_REQUEST[ 'start_date' ] ) and isset( $_REQUEST[ 'end_date' ] ) and !empty( trim ( $_REQUEST[ 'start_date' ] ) ) and !empty( trim ( $_REQUEST[ 'end_date' ] ) ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'start_date' ] ) );
                $end_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'end_date' ] ) );
                $sql .= " and DATE(date_added) BETWEEN '$start_date' AND '$end_date'";
                $search = true;
            }
            $sql .= " order by id DESC";
            $query = $this -> db -> query ( $sql );
            if ( $search )
                return $query -> result ();
            else
                return array ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get ultrasound reporting
         * -------------------------
         */
        
        public function get_ultrasound_reporting () {
            $search = false;
            $sql = "Select * from hmis_ultrasound where 1";
            if ( isset( $_REQUEST[ 'doctor_id' ] ) and $_REQUEST[ 'doctor_id' ] > 0 ) {
                $doctor_id = $_REQUEST[ 'doctor_id' ];
                $sql .= " and doctor_id=$doctor_id";
                $search = true;
            }
            if ( isset( $_REQUEST[ 'referenced_by' ] ) and $_REQUEST[ 'referenced_by' ] > 0 ) {
                $doctor_id = $_REQUEST[ 'referenced_by' ];
                $sql .= " and order_by=$doctor_id";
                $search = true;
            }
            if ( isset( $_REQUEST[ 'invoice-id' ] ) and $_REQUEST[ 'invoice-id' ] > 0 ) {
                $sale_id = $_REQUEST[ 'invoice-id' ];
                $sql .= " and sale_id=$sale_id";
                $search = true;
            }
            if ( isset( $_REQUEST[ 'start_date' ] ) and isset( $_REQUEST[ 'end_date' ] ) and !empty( trim ( $_REQUEST[ 'start_date' ] ) ) and !empty( trim ( $_REQUEST[ 'end_date' ] ) ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'start_date' ] ) );
                $end_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'end_date' ] ) );
                $sql .= " and DATE(date_added) BETWEEN '$start_date' AND '$end_date'";
                $search = true;
            }
            $sql .= " order by id DESC";
            $query = $this -> db -> query ( $sql );
            if ( $search )
                return $query -> result ();
            else
                return array ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get supplier stocks ids
         * -------------------------
         */
        
        public function get_supplier_stocks () {
            $sql = "Select GROUP_CONCAT(id) as stock_ids from hmis_medicines_stock where 1";
            if ( isset( $_REQUEST[ 'start_date' ] ) and isset( $_REQUEST[ 'end_date' ] ) and !empty( trim ( $_REQUEST[ 'start_date' ] ) ) and !empty( trim ( $_REQUEST[ 'end_date' ] ) ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'start_date' ] ) );
                $end_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'end_date' ] ) );
                $sql .= " and DATE(date_added) BETWEEN '$start_date' and '$end_date'";
            }
            if ( isset( $_REQUEST[ 'acc_head_id' ] ) and $_REQUEST[ 'acc_head_id' ] > 0 ) {
                $supplier_id = $_REQUEST[ 'acc_head_id' ];
                $sql .= " and supplier_id=$supplier_id";
            }
            $query = $this -> db -> query ( $sql );
            return $query -> row () -> stock_ids;
        }
        
        /**
         * -------------------------
         * @return mixed
         * get culture reporting
         * -------------------------
         */
        
        public function get_culture_reporting () {
            $search = false;
            $sql = "Select * from hmis_culture where 1";
            if ( isset( $_REQUEST[ 'doctor_id' ] ) and $_REQUEST[ 'doctor_id' ] > 0 ) {
                $doctor_id = $_REQUEST[ 'doctor_id' ];
                $sql .= " and doctor_id=$doctor_id";
                $search = true;
            }
            if ( isset( $_REQUEST[ 'referenced_by' ] ) and $_REQUEST[ 'referenced_by' ] > 0 ) {
                $doctor_id = $_REQUEST[ 'referenced_by' ];
                $sql .= " and order_by=$doctor_id";
                $search = true;
            }
            if ( isset( $_REQUEST[ 'invoice-id' ] ) and $_REQUEST[ 'invoice-id' ] > 0 ) {
                $sale_id = $_REQUEST[ 'invoice-id' ];
                $sql .= " and sale_id=$sale_id";
                $search = true;
            }
            if ( isset( $_REQUEST[ 'start_date' ] ) and isset( $_REQUEST[ 'end_date' ] ) and !empty( trim ( $_REQUEST[ 'start_date' ] ) ) and !empty( trim ( $_REQUEST[ 'end_date' ] ) ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'start_date' ] ) );
                $end_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'end_date' ] ) );
                $sql .= " and DATE(date_added) BETWEEN '$start_date' AND '$end_date'";
                $search = true;
            }
            $sql .= " order by id DESC";
            $query = $this -> db -> query ( $sql );
            if ( $search )
                return $query -> result ();
            else
                return array ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get histopathology reporting
         * -------------------------
         */
        
        public function get_histopathology_reporting () {
            $search = false;
            $sql = "Select * from hmis_histopathology where 1";
            if ( isset( $_REQUEST[ 'doctor_id' ] ) and $_REQUEST[ 'doctor_id' ] > 0 ) {
                $doctor_id = $_REQUEST[ 'doctor_id' ];
                $sql .= " and doctor_id=$doctor_id";
                $search = true;
            }
            if ( isset( $_REQUEST[ 'referenced_by' ] ) and $_REQUEST[ 'referenced_by' ] > 0 ) {
                $doctor_id = $_REQUEST[ 'referenced_by' ];
                $sql .= " and order_by=$doctor_id";
                $search = true;
            }
            if ( isset( $_REQUEST[ 'invoice-id' ] ) and $_REQUEST[ 'invoice-id' ] > 0 ) {
                $sale_id = $_REQUEST[ 'invoice-id' ];
                $sql .= " and sale_id=$sale_id";
                $search = true;
            }
            if ( isset( $_REQUEST[ 'start_date' ] ) and isset( $_REQUEST[ 'end_date' ] ) and !empty( trim ( $_REQUEST[ 'start_date' ] ) ) and !empty( trim ( $_REQUEST[ 'end_date' ] ) ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'start_date' ] ) );
                $end_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'end_date' ] ) );
                $sql .= " and DATE(date_added) BETWEEN '$start_date' AND '$end_date'";
                $search = true;
            }
            $sql .= " order by id DESC";
            $query = $this -> db -> query ( $sql );
            if ( $search )
                return $query -> result ();
            else
                return array ();
        }
        
        public function get_test_prices_report () {
//            $sql = "Select GROUP_CONCAT(panel_id) as panels, GROUP_CONCAT(price) as prices, test_id from hmis_test_price where 1";
            $sql = "Select hmis_tests.name AS test_name, hmis_tests.code AS test_code, hmis_tests.type AS test_type, hmis_tests.date_added AS date_added, GROUP_CONCAT(panel_id) as panels, GROUP_CONCAT(price) as prices, hmis_test_price.discount as discount, test_id from hmis_test_price JOIN hmis_tests ON hmis_test_price.test_id=hmis_tests.id where 1";
            if ( isset( $_GET[ 'test-id' ] ) and $_GET[ 'test-id' ] > 0 ) {
                $test_id = $_GET[ 'test-id' ];
                $sql .= " and test_id=$test_id";
            }
            if ( isset( $_GET[ 'panel-id' ] ) and $_GET[ 'panel-id' ] > 0 ) {
                $panel_id = $_GET[ 'panel-id' ];
                $sql .= " and panel_id=$panel_id";
            }
            $sql .= " group by test_id order by hmis_tests.name";
            $query = $this -> db -> query ( $sql );
            return $query -> result ();
        }
        
    }
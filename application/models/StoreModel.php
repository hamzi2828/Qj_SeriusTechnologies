<?php
    defined ( 'BASEPATH' ) or exit( 'No direct script access allowed' );
    
    class StoreModel extends CI_Model {
        
        /**
         * -------------------------
         * StoreModel constructor.
         * -------------------------
         */
        
        public function __construct () {
            parent ::__construct ();
        }
        
        /**
         * -------------------------
         * @param $info
         * @return mixed
         * add store items
         * -------------------------
         */
        
        public function add ( $info ) {
            $this -> db -> insert ( 'store', $info );
            return $this -> db -> insert_id ();
        }
        
        /**
         * -------------------------
         * @param $info
         * @return mixed
         * add store stock
         * -------------------------
         */
        
        public function add_stock ( $info ) {
            $this -> db -> insert ( 'store_stock', $info );
            return $this -> db -> insert_id ();
        }
        
        /**
         * -------------------------
         * @param $info
         * @return mixed
         * sale store stock
         * -------------------------
         */
        
        public function sale_stock ( $info ) {
            $this -> db -> insert ( 'store_sold_items', $info );
            return $this -> db -> insert_id ();
        }
        
        /**
         * -------------------------
         * @param $info
         * @return mixed
         * add store stock discount
         * -------------------------
         */
        
        public function add_stock_discount ( $info ) {
            $this -> db -> insert ( 'store_stock_discount', $info );
            return $this -> db -> insert_id ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * count all store items
         * -------------------------
         */
        
        public function count_all_store () {
            return $this -> db -> count_all_results ( 'store' );
        }
        
        /**
         * -------------------------
         * @param $limit
         * @param $offset
         * get store
         * -------------------------
         * @return mixed
         */
        
        public function get_store ( $limit = 10000, $offset = 0 ) {
            $sql = "Select * from hmis_store where 1";
            $sql .= " order by item ASC limit $limit offset $offset";
            $store = $this -> db -> query ( $sql );
            return $store -> result ();
        }
        
        /**
         * -------------------------
         * @param $store_id
         * get store by id
         * -------------------------
         * @return mixed
         */
        
        public function get_store_by_id ( $store_id ) {
            $store = $this -> db -> get_where ( 'store', array ( 'id' => $store_id ) );
            return $store -> row ();
        }
        
        /**
         * -------------------------
         * @param $info
         * validate invoice number by supplier id
         * -------------------------
         * @return bool
         */
        
        public function validate_invoice_number ( $info ) {
            $exists = $this -> db -> get_where ( 'store_stock', $info );
            if ( $exists -> num_rows () > 0 )
                return true;
            else
                return false;
        }
        
        /**
         * -------------------------
         * @return mixed
         * get all store
         * -------------------------
         */
        
        public function get_all_store () {
            $store = $this -> db -> get ( 'store' );
            return $store -> result ();
        }
        
        /**
         * -------------------------
         * @param $info
         * @param $where
         * @return mixed
         * update store item
         * -------------------------
         */
        
        public function update ( $info, $where ) {
            $this -> db -> update ( 'store', $info, $where );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $where
         * @return mixed
         * delete store item
         * -------------------------
         */
        
        public function delete ( $where ) {
            $this -> db -> delete ( 'store', $where );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $where
         * @return mixed
         * delete sold store item
         * -------------------------
         */
        
        public function delete_store_sale ( $where ) {
            $this -> db -> delete ( 'store_sold_items', $where );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $stock_id
         * @return mixed
         * delete store stock
         * -------------------------
         */
        
        public function delete_stock ( $stock_id ) {
            $this -> db -> delete ( 'store_stock', array ( 'id' => $stock_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $store_id
         * @return mixed
         * count store quantity
         * -------------------------
         */
        
        public function get_store_stock_total_quantity ( $store_id ) {
            $sql = "Select SUM(quantity) as total from hmis_store_stock where store_id=$store_id";
            if ( isset( $_GET[ 'start_date' ] ) and !empty( trim ( $_GET[ 'start_date' ] ) ) and isset( $_GET[ 'end_date' ] ) and !empty( trim ( $_GET[ 'end_date' ] ) ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $_GET[ 'start_date' ] ) );
                $end_date = date ( 'Y-m-d', strtotime ( $_GET[ 'end_date' ] ) );
                $sql .= " and DATE(date_added) BETWEEN '$start_date' and '$end_date'";
            }
            $query = $this -> db -> query($sql);
            return $query -> row () -> total;
        }
        
        /**
         * -------------------------
         * @param $stock_id
         * @return mixed
         * count stock quantity
         * -------------------------
         */
        
        public function get_stock_total_quantity ( $stock_id ) {
            $query = $this -> db -> query ( "Select SUM(quantity) as total from hmis_store_stock where id=$stock_id" );
            return $query -> row () -> total;
        }
        
        /**
         * -------------------------
         * @param $store_id
         * @return mixed
         * count store sold quantity
         * -------------------------
         */
        
        public function get_store_stock_sold_quantity ( $store_id ) {
            $sql = "Select SUM(quantity) as total from hmis_store_sold_items where store_id=$store_id";
            if (isset($_GET['start_date']) and !empty(trim ($_GET['start_date'])) and isset($_GET['end_date']) and !empty(trim ($_GET['end_date']))) {
                $start_date = date ('Y-m-d', strtotime ( $_GET[ 'start_date' ]));
                $end_date = date ('Y-m-d', strtotime ( $_GET[ 'end_date' ]));
                $sql .= " and DATE(date_added) BETWEEN '$start_date' and '$end_date'";
            }
            $query = $this -> db -> query ( $sql );
            return $query -> row () -> total;
        }
        
        /**
         * -------------------------
         * @param $stock_id
         * @return mixed
         * count stock sold quantity
         * -------------------------
         */
        
        public function get_stock_sold_quantity ( $stock_id ) {
            $query = $this -> db -> query ( "Select SUM(quantity) as total from hmis_store_sold_items where stock_id=$stock_id" );
            return $query -> row () -> total;
        }
        
        /**
         * -------------------------
         * @param $store_id
         * get stock by store id
         * @return mixed
         * -------------------------
         */
        
        public function get_stock ( $store_id ) {
            $stock = $this -> db -> get_where ( 'store_stock', array ( 'store_id' => $store_id ) );
            return $stock -> result ();
        }
        
        /**
         * -------------------------
         * @param $store_id
         * get stock by store id
         * @return mixed
         * -------------------------
         */
        
        public function get_stock_with_available_quantity ( $store_id ) {
            $stock = $this -> db -> get_where ( 'store_stock', array (
                'store_id'   => $store_id,
                'quantity >' => 0
            ) );
            return $stock -> result ();
        }
        
        /**
         * -------------------------
         * @param $stock_id
         * get stock by id
         * @return mixed
         * -------------------------
         */
        
        public function get_store_stock ( $stock_id ) {
            $stock = $this -> db -> get_where ( 'store_stock', array ( 'id' => $stock_id ) );
            return $stock -> row ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get sales
         * -------------------------
         */
        
        public function get_sales () {
            $sql = "Select * from hmis_store_sold_items where 1";
            if ( isset( $_REQUEST[ 'department_id' ] ) and !empty( trim ( $_REQUEST[ 'department_id' ] ) ) ) {
                $department_id = $_REQUEST[ 'department_id' ];
                $sql .= " and department_id=$department_id";
            }
            if ( isset( $_REQUEST[ 'sold_to' ] ) and !empty( trim ( $_REQUEST[ 'sold_to' ] ) ) ) {
                $sold_to = $_REQUEST[ 'sold_to' ];
                $sql .= " and sold_to=$sold_to";
            }
            if ( isset( $_REQUEST[ 'start_date' ] ) and !empty( trim ( $_REQUEST[ 'start_date' ] ) ) and isset( $_REQUEST[ 'end_date' ] ) and !empty( trim ( $_REQUEST[ 'end_date' ] ) ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'start_date' ] ) );
                $end_date = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'end_date' ] ) );
                $sql .= " and DATE(date_added) BETWEEN '$start_date' and '$end_date'";
            }
            $sales = $this -> db -> query ( $sql );
            return $sales -> result ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get par levels
         * -------------------------
         */
        
        public function get_par_levels () {
            $levels = $this -> db -> query ( "Select id, department_id, GROUP_CONCAT(item_id) as items, GROUP_CONCAT(allowed) as par_levels, date_added from hmis_par_levels GROUP BY department_id" );
            return $levels -> result ();
        }
        
        /**
         * -------------------------
         * @param $department_id
         * get par levels by dept
         * -------------------------
         * @return mixed
         */
        
        public function get_par_levels_by_department ( $department_id ) {
            $levels = $this -> db -> query ( "Select id, department_id, GROUP_CONCAT(item_id) as items, GROUP_CONCAT(allowed) as par_levels, date_added from hmis_par_levels where department_id=$department_id GROUP BY department_id" );
            return $levels -> result ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get par levels
         * -------------------------
         */
        
        public function get_internal_issuance_par_levels () {
            $levels = $this -> db -> query ( "Select id, department_id, GROUP_CONCAT(medicine_id) as medicines, GROUP_CONCAT(allowed) as par_levels, date_added from hmis_internal_issuance_par_levels GROUP BY department_id" );
            return $levels -> result ();
        }
        
        /**
         * -------------------------
         * @param $department_id
         * get par levels bt department id
         * -------------------------
         * @return mixed
         */
        
        public function internal_issuance_par_levels_report_by_department ( $department_id ) {
            $levels = $this -> db -> query ( "Select * from hmis_internal_issuance_par_levels where department_id=$department_id" );
            return $levels -> result ();
        }
        
        /**
         * -------------------------
         * @param $info
         * @return mixed
         * add par levels
         * -------------------------
         */
        
        public function define_par_levels ( $info ) {
            $this -> db -> insert ( 'par_levels', $info );
            return $this -> db -> insert_id ();
        }
        
        /**
         * -------------------------
         * @param $info
         * @return mixed
         * add par levels
         * -------------------------
         */
        
        public function define_internal_issuance_par_levels ( $info ) {
            $this -> db -> insert ( 'internal_issuance_par_levels', $info );
            return $this -> db -> insert_id ();
        }
        
        /**
         * -------------------------
         * @param $department_id
         * @return mixed
         * delete par levels
         * -------------------------
         */
        
        public function delete_par_level ( $department_id ) {
            $this -> db -> delete ( 'par_levels', array ( 'department_id' => $department_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $par_level
         * @return mixed
         * delete par level
         * -------------------------
         */
        
        public function delete_par_level_by_id ( $par_level ) {
            $this -> db -> delete ( 'par_levels', array ( 'id' => $par_level ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $department_id
         * @return mixed
         * delete par levels
         * -------------------------
         */
        
        public function delete_internal_issuance_medicines_par_level ( $department_id ) {
            $this -> db -> delete ( 'internal_issuance_par_levels', array ( 'department_id' => $department_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $level_id
         * @return mixed
         * delete par levels
         * -------------------------
         */
        
        public function delete_internal_issuance_par_level_by_id ( $level_id ) {
            $this -> db -> delete ( 'internal_issuance_par_levels', array ( 'id' => $level_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $department_id
         * get par levels
         * @return mixed
         * -------------------------
         */
        
        public function get_levels_by_department ( $department_id ) {
            $levels = $this -> db -> get_where ( 'par_levels', array ( 'department_id' => $department_id ) );
            return $levels -> result ();
        }
        
        /**
         * -------------------------
         * @param $department_id
         * get par levels
         * @return mixed
         * -------------------------
         */
        
        public function get_internal_issuance_levels_by_department ( $department_id ) {
            $levels = $this -> db -> get_where ( 'internal_issuance_par_levels', array ( 'department_id' => $department_id ) );
            return $levels -> result ();
        }
        
        /**
         * -------------------------
         * @param $department_id
         * @param $item_id
         * @return mixed
         * get par levels
         * -------------------------
         */
        
        public function get_par_level_by_dept_item ( $department_id, $item_id ) {
            $level = $this -> db -> get_where ( 'par_levels', array (
                'department_id' => $department_id,
                'item_id'       => $item_id
            ) );
            return $level -> row ();
        }
        
        /**
         * -------------------------
         * @param $department_id
         * @param $item_id
         * @return mixed
         * get issued items
         * -------------------------
         */
        
        public function get_issued_items_by_dept_item_id_date ( $department_id, $item_id ) {
            $date = date ( 'm' );
            $sold = $this -> db -> query ( "Select SUM(quantity) as quantity from hmis_store_sold_items where department_id=$department_id and store_id=$item_id and MONTH(date_added)='$date'" );
            return $sold -> row () -> quantity;
        }
        
        /**
         * -------------------------
         * @return mixed
         * get requests
         * -------------------------
         */
        
        public function get_requests () {
            $this -> db -> order_by ( 'id', 'DESC' );
            $requests = $this -> db -> get_where ( 'requisitions', array ( 'status' => 'approved' ) );
            return $requests -> result ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * count requests
         * -------------------------
         */
        
        public function count_store_requisition_requests () {
            $requests = $this -> db -> query ( "Select COUNT(*) as total from hmis_requisitions where status='approved'" );
            return $requests -> row () -> total;
        }
        
        /**
         * -------------------------
         * @return mixed
         * get requests
         * -------------------------
         */
        
        public function get_requests_facility_manager () {
            $this -> db -> order_by ( 'id', 'DESC' );
            $requests = $this -> db -> get ( 'requisitions' );
            return $requests -> result ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get requests
         * -------------------------
         */
        
        public function count_requests_facility_manager () {
            $requests = $this -> db -> query ( 'Select COUNT(*) as total from hmis_requisitions' );
            return $requests -> row () -> total;
        }
        
        /**
         * -------------------------
         * @return mixed
         * get stock
         * -------------------------
         */
        
        public function search_stock () {
            $sql = "Select * from hmis_store_stock where 1";
            if ( isset( $_REQUEST[ 'invoice' ] ) and !empty( trim ( $_REQUEST[ 'invoice' ] ) ) ) {
                $invoice = $_REQUEST[ 'invoice' ];
                $sql .= " and invoice='$invoice'";
            }
            if ( isset( $_REQUEST[ 'date_added' ] ) and !empty( trim ( $_REQUEST[ 'date_added' ] ) ) ) {
                $date_added = date ( 'Y-m-d', strtotime ( $_REQUEST[ 'date_added' ] ) );
                $sql .= " and DATE(date_added)='$date_added'";
            }
            $query = $this -> db -> query ( $sql );
            return $query -> result ();
        }
        
        /**
         * -------------------------
         * @param $invoice
         * get stock info
         * -------------------------
         * @return mixed
         */
        
        public function get_stock_info ( $invoice = '' ) {
            if ( empty( $invoice ) )
                $invoice = $_REQUEST[ 'invoice' ];
            $sql = "Select * from hmis_store_stock_discount where invoice LIKE '$invoice%'";
            $query = $this -> db -> query ( $sql );
            return $query -> row ();
        }
        
        /**
         * -------------------------
         * @param $stock_id
         * @return mixed
         * get individual store
         * -------------------------
         */
        
        public function get_individual_stock ( $stock_id ) {
            $stock = $this -> db -> get_where ( 'store_stock', array ( 'id' => $stock_id ) );
            return $stock -> row ();
        }
        
        /**
         * -------------------------
         * @param $stock_id
         * @return mixed
         * delete individual store
         * -------------------------
         */
        
        public function delete_individual_stock ( $stock_id ) {
            $this -> db -> delete ( 'store_stock', array ( 'id' => $stock_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $price
         * @param $invoice
         * @param $acc_head_id
         * @return mixed
         * update general ledger
         * -------------------------
         */
        
        public function update_store_stock_ledger ( $price, $invoice, $acc_head_id ) {
            $this -> db -> query ( "Update hmis_general_ledger SET debit=debit-$price where acc_head_id=$acc_head_id and stock_id='$invoice' and invoice_id='$invoice'" );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $price
         * @param $invoice
         * @return mixed
         * update store stock info
         * -------------------------
         */
        
        public function update_store_stock_total ( $price, $invoice ) {
            $this -> db -> query ( "Update hmis_store_stock_discount SET total=total-$price where invoice='$invoice'" );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get store issued items
         * -------------------------
         */
        
        public function count_issued_items () {
            $sql = "Select id from hmis_store_sold_items where 1";
            if ( isset( $_REQUEST[ 'id' ] ) and $_REQUEST[ 'id' ] > 0 ) {
                $id = $_REQUEST[ 'id' ];
                $sql .= " and id=$id";
            }
            if ( isset( $_REQUEST[ 'user_id' ] ) and $_REQUEST[ 'user_id' ] > 0 ) {
                $user_id = $_REQUEST[ 'user_id' ];
                $sql .= " and sold_to=$user_id";
            }
            if ( isset( $_REQUEST[ 'department_id' ] ) and $_REQUEST[ 'department_id' ] > 0 ) {
                $department_id = $_REQUEST[ 'department_id' ];
                $sql .= " and department_id=$department_id";
            }
            if ( isset( $_REQUEST[ 'store_id' ] ) and $_REQUEST[ 'store_id' ] > 0 ) {
                $store_id = $_REQUEST[ 'store_id' ];
                $sql .= " and store_id=$store_id";
            }
            $sql .= " group by sale_id order by date_added DESC";
            $query = $this -> db -> query ( $sql );
            return $query -> num_rows ();
        }
        
        /**
         * -------------------------
         * @param $limit
         * @param $offset
         * @return mixed
         * get store issued items
         * -------------------------
         */
        
        public function get_issued_items ( $limit, $offset ) {
            $sql = "Select id, sale_id, sold_by, department_id, account_head, sold_to, GROUP_CONCAT(store_id) as store_id, GROUP_CONCAT(stock_id) as stock_id, GROUP_CONCAT(quantity) as quantities, date_added from hmis_store_sold_items where 1";
            if ( isset( $_REQUEST[ 'id' ] ) and $_REQUEST[ 'id' ] > 0 ) {
                $id = $_REQUEST[ 'id' ];
                $sql .= " and id=$id";
            }
            if ( isset( $_REQUEST[ 'sale-id' ] ) and !empty(trim ( $_REQUEST[ 'sale-id' ])) ) {
                $id = $_REQUEST[ 'sale-id' ];
                $sql .= " and sale_id='$id'";
            }
            if ( isset( $_REQUEST[ 'user_id' ] ) and $_REQUEST[ 'user_id' ] > 0 ) {
                $user_id = $_REQUEST[ 'user_id' ];
                $sql .= " and sold_to=$user_id";
            }
            if ( isset( $_REQUEST[ 'department_id' ] ) and $_REQUEST[ 'department_id' ] > 0 ) {
                $department_id = $_REQUEST[ 'department_id' ];
                $sql .= " and department_id=$department_id";
            }
            if ( isset( $_REQUEST[ 'store_id' ] ) and $_REQUEST[ 'store_id' ] > 0 ) {
                $store_id = $_REQUEST[ 'store_id' ];
                $sql .= " and store_id=$store_id";
            }
            $sql .= " group by sale_id order by date_added DESC limit $limit offset $offset";
            $query = $this -> db -> query ( $sql );
            return $query -> result ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get store sold items
         * -------------------------
         */
        
        public function get_store_sales () {
            $search = false;
            $sql = "Select id, sale_id, sold_by, department_id, account_head, sold_to, GROUP_CONCAT(store_id) as store_id, GROUP_CONCAT(stock_id) as stock_id, GROUP_CONCAT(quantity) as quantities, date_added from hmis_store_sold_items where 1";
            if ( isset( $_GET[ 'start_date' ] ) and !empty( trim ( $_GET[ 'start_date' ] ) ) and isset( $_GET[ 'end_date' ] ) and !empty( trim ( $_GET[ 'end_date' ] ) ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $_GET[ 'start_date' ] ) );
                $end_date = date ( 'Y-m-d', strtotime ( $_GET[ 'end_date' ] ) );
                $sql .= " and DATE(date_added) BETWEEN '$start_date' and '$end_date'";
                $search = true;
            }
            $sql .= " group by sale_id order by date_added DESC";
            $query = $this -> db -> query ( $sql );
            if ( $search)
                return $query -> result ();
            else
                return array ();
        }
        
        /**
         * -------------------------
         * @param $item_id
         * get store issued item by id
         * -------------------------
         * @return mixed
         */
        
        public function get_issued_item_by_id ( $item_id ) {
            $query = $this -> db -> get_where ( 'store_sold_items', array ( 'id' => $item_id ) );
            return $query -> row ();
        }
        
        /**
         * -------------------------
         * @param $info
         * @param $where
         * update store sale
         * -------------------------
         * @return mixed
         */
        
        public function do_update_store_sale ( $info, $where ) {
            $this -> db -> update ( 'store_sold_items', $info, $where );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $item_id
         * delete store sale
         * -------------------------
         * @return mixed
         */
        
        public function delete_issued_item ( $item_id ) {
            $this -> db -> delete ( 'store_sold_items', array ( 'id' => $item_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $item_id
         * delete store sale
         * -------------------------
         * @return mixed
         */
        
        public function delete_issued_items_by_sale ( $item_id ) {
            $this -> db -> delete ( 'store_sold_items', array ( 'sale_id' => $item_id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $info
         * add store fix assets
         * -------------------------
         * @return mixed
         */
        
        public function do_add_store_fix_assets ( $info ) {
            $this -> db -> insert ( 'store_fix_assets', $info );
            return $this -> db -> insert_id ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get store fix assets
         * -------------------------
         */
        
        public function get_store_fix_assets () {
            $this -> db -> order_by ( 'id', 'DESC' );
            $assets = $this -> db -> get ( 'store_fix_assets' );
            return $assets -> result ();
        }
        
        /**
         * -------------------------
         * @param $id
         * get store fix asset by id
         * -------------------------
         * @return mixed
         */
        
        public function get_fix_asset_by_id ( $id ) {
            $asset = $this -> db -> get_where ( 'store_fix_assets', array ( 'id' => $id ) );
            return $asset -> row ();
        }
        
        /**
         * -------------------------
         * @param $info
         * @param $where
         * update store fix assets
         * -------------------------
         * @return mixed
         */
        
        public function update_store_fix_assets ( $info, $where ) {
            $this -> db -> update ( 'store_fix_assets', $info, $where );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $id
         * delete store fix assets
         * -------------------------
         * @return mixed
         */
        
        public function delete_store_fix_asset ( $id ) {
            $this -> db -> delete ( 'store_fix_assets', array ( 'id' => $id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $invoice
         * @param $grand_total_discount
         * @param $grand_total
         * delete store stock
         * -------------------------
         * @return mixed
         */
        
        public function update_store_stock_net_bill ( $invoice, $grand_total_discount, $grand_total ) {
            $this -> db -> update ( 'store_stock_discount', array (
                'discount' => $grand_total_discount,
                'total'    => $grand_total
            ), array ( 'invoice' => $invoice ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $info
         * @param $where
         * delete store stock
         * -------------------------
         * @return mixed
         */
        
        public function update_store_stock ( $info, $where ) {
            $this -> db -> update ( 'hmis_store_stock', $info, $where );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $invoice
         * @param $supplier_id
         * delete store stock
         * -------------------------
         * @return mixed
         */
        
        public function delete_store_stock ( $invoice, $supplier_id ) {
            $this -> db -> delete ( 'store_stock', array (
                'invoice'     => $invoice,
                'supplier_id' => $supplier_id
            ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $invoice_number
         * @return bool
         * validate store stock invoice number
         * -------------------------
         */
        
        public function validate_store_stock_invoice_number ( $invoice_number ) {
            $row = $this -> db -> get_where ( 'store_stock', array ( 'invoice' => $invoice_number ) );
            if ( $row -> num_rows () > 0 )
                return false;
            else
                return true;
        }
        
        /**
         * -------------------------
         * @param $invoice
         * @return mixed
         * get stock by invoice
         * -------------------------
         */
        
        public function get_stock_by_invoice ( $invoice ) {
            $stocks = $this -> db -> get_where ( 'store_stock', array ( 'invoice' => $invoice ) );
            return $stocks -> result ();
        }
        
        /**
         * -------------------------
         * @param $sale_id
         * @return mixed
         * get stock sales by sale id
         * -------------------------
         */
        
        public function get_stock_sales_by_sale_id ( $sale_id ) {
            $sales = $this -> db -> get_where ( 'store_sold_items', array ( 'sale_id' => $sale_id ) );
            return $sales -> result ();
        }
    
        /**
         * -------------------------
         * @return mixed
         * get store stocks
         * -------------------------
         */
        
        public function get_store_stocks () {
            $query = $this -> db -> query ( "Select supplier_id, GROUP_CONCAT(store_id) as store_items, invoice, GROUP_CONCAT(quantity) as quantities, GROUP_CONCAT(price) as prices, GROUP_CONCAT(discount) as discounts, GROUP_CONCAT(net_price) as net_prices, date_added from hmis_store_stock group by invoice order by id DESC" );
            return $query -> result ();
        }
    
    
        /**
         * ---------------------
         * @param $store_id
         * @return mixed
         * get sum of available stocks
         * ---------------------
         */
    
        public function get_available_stock_price ( $store_id ) {
            $total = 0;
            $sql = "Select id, quantity, price, net_price, discount from hmis_store_stock where store_id=$store_id";
            if ( isset( $_GET[ 'start_date' ] ) and !empty( trim ( $_GET[ 'start_date' ] ) ) and isset( $_GET[ 'end_date' ] ) and !empty( trim ( $_GET[ 'end_date' ] ) ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $_GET[ 'start_date' ] ) );
                $end_date = date ( 'Y-m-d', strtotime ( $_GET[ 'end_date' ] ) );
                $sql .= " and DATE(date_added) BETWEEN '$start_date' and '$end_date'";
            }
            $stocks = $this -> db -> query ( $sql ) -> result ();
            
            if ( count ( $stocks ) > 0 ) {
                foreach ( $stocks as $stock ) {
                    $sold = $this -> get_stock_sold_quantity ( $stock -> id );
                    $available = $stock -> quantity - $sold;
                    $net_price = $available * $stock -> price;
                    $total += $net_price;
                }
                return $total;
            }
            else {
                return $total;
            }
        }
    
        /**
         * ---------------------
         * @return mixed
         * purchase report
         * ---------------------
         */
        
        public function get_purchase_report() {
            $sql = "Select supplier_id, GROUP_CONCAT(store_id) as store_items, invoice, GROUP_CONCAT(quantity) as quantities, GROUP_CONCAT(price) as prices, GROUP_CONCAT(discount) as discounts, GROUP_CONCAT(net_price) as net_prices, date_added from hmis_store_stock where 1";
            if ( isset( $_GET[ 'start_date' ] ) and !empty( trim ( $_GET[ 'start_date' ] ) ) and isset( $_GET[ 'end_date' ] ) and !empty( trim ( $_GET[ 'end_date' ] ) ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( $_GET[ 'start_date' ] ) );
                $end_date = date ( 'Y-m-d', strtotime ( $_GET[ 'end_date' ] ) );
                $sql .= " and DATE(date_added) BETWEEN '$start_date' and '$end_date'";
                $search = true;
            }
            if ( isset( $_GET[ 'item-id' ] ) and !empty( trim ( $_GET[ 'item-id' ] ) ) and $_GET['item-id'] > 0  ) {
                $item_id = $_GET[ 'item-id' ];
                $sql .= " and store_id='$item_id'";
                $search = true;
            }
            $sql .= " group by invoice order by id DESC";
            $query = $this -> db -> query ( $sql );
            return $query -> result ();
        }
        
    }
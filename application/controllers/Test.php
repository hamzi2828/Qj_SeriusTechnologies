<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {

    /**
     * -------------------------
     * Test constructor.
     * loads helpers, modal or libraries
     * -------------------------
     */

    public function __construct() {
        parent::__construct();
        $this -> load -> model('AccountModel');
    }

    public function push_consultancy_to_gl() {
    	echo $small = today();
    	echo '<br>';
    	echo date('Y-m-d G:i A', strtotime($small));
    }

    public function merge_user_id() {
    	$query = $this -> db -> query("Select id, user_id, date_sale from hmis_sales where type='pharmacy' and id IN (select sale_id from hmis_medicines_sold)");
    	$users = $query -> result();
    	if(count($users) > 0) {
    		foreach ($users as $user) {
    			$info = array(
    				'user_id'	=>	$user -> user_id,
					'date_sold'	=>	$user -> date_sale
				);
    			$where = array(
    				'sale_id'	=>	$user -> id
				);
				$this -> db -> update('hmis_medicines_sold', $info, $where);
			}
		}
	}

	public function tp_1_medicines() {
    	$query = $this -> db -> query("SELECT * FROM `hmis_medicines_sold` WHERE `medicine_id` IN (142,143,144,146,151,157,160,573,1078,1379,1096,1534,711,1636,1644,1078,1713,805,1579,1595,1684)");
    	$medicines = $query -> result();
    	if (count($medicines) > 0) {
    		foreach ($medicines as $sale) {
    			unset($sale -> id);
    			unset($sale -> patient_id);
    			$sale -> user_id = base_url('/user/edit/'.$sale -> user_id);
    			$sale -> medicine_id = base_url('/medicines/edit/'.$sale -> medicine_id);
    			print_data($sale);
    			print_data('*************************************************************');
			}
		}
	}

	public function stock_sum() {
    	$query = $this -> db -> query("Select supplier_id, supplier_invoice, SUM(net_price) as net_price_stock, date_added from hmis_medicines_stock where returned='0' group by supplier_invoice order by supplier_invoice ASC");
    	$stock_sum = $query -> result();

    	$query_2 = $this -> db -> query("Select invoice_number, grand_total from hmis_stock_invoice_discount order by invoice_number ASC");
    	$stock_total = $query_2 -> result_array();


    	foreach ($stock_sum as $key => $item) {
    		$net_price_stock = (int)($item -> net_price_stock);
    		if($net_price_stock < (int)($stock_total[$key]['grand_total'])) {
    			print_data('Supplier: ' . get_supplier($item -> supplier_id) -> title . ' - ' . $item -> supplier_id);
    			print_data('Actual Total From Stock: ' . $net_price_stock);
    			print_data('Total From Stock Discount: ' . $stock_total[$key]['grand_total']);
    			print_data('Invoice: ' . $stock_total[$key]['invoice_number']);
    			print_data('Date: ' . $item -> date_added);
    			print_data('----------------------------------------------------');

    			// update stock total discount table

//				$info = array(
//    				'grand_total'		=>	$net_price_stock
//				);
//    			$w = array(
//					'invoice_number'	=>	$stock_total[$key]['invoice_number']
//				);
//
//				$this -> AccountModel -> update_general_stock_discount($info, $w);
//
//				// update general ledger table against same invoice id and supplier
//
//    			$ledger = array(
//    				'debit'		=>	$net_price_stock
//				);
//    			$where = array(
//    				'acc_head_id'	=>	$item -> supplier_id,
//					'invoice_id'	=>	$stock_total[$key]['invoice_number']
//				);
//
//				$this -> AccountModel -> update_general_ledger($ledger, $where);
			}
		}

	}

}

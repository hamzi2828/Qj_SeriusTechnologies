<?php
    defined ('BASEPATH') or exit('No direct script access allowed');
    
    class Accounts extends CI_Controller {
        
        /**
         * -------------------------
         * Accounts constructor.
         * loads helpers, modal or libraries
         * -------------------------
         */
        
        public function __construct () {
            parent ::__construct ();
            $this -> is_logged_in ();
            $this -> load -> model ('AccountModel');
            $this -> load -> model ('SupplierModel');
            $this -> load -> model ('DoctorModel');
            $this -> load -> model ('PanelModel');
        }
        
        /**
         * -------------------------
         * @param $title
         * header template
         * -------------------------
         */
        
        public function header ( $title ) {
            $data[ 'title' ] = $title;
            $this -> load -> view ('/includes/admin/header', $data);
        }
        
        /**
         * -------------------------
         * sidebar template
         * -------------------------
         */
        
        public function sidebar () {
            $this -> load -> view ('/includes/admin/general-sidebar');
        }
        
        /**
         * -------------------------
         * footer template
         * -------------------------
         */
        
        public function footer () {
            $this -> load -> view ('/includes/admin/footer');
        }
        
        /**
         * ---------------------
         * checks if user is logged in
         * ---------------------
         */
        
        public function is_logged_in () {
            if ( empty($this -> session -> userdata ('user_data')) ) {
                return redirect (base_url ());
            }
        }
        
        /**
         * -------------------------
         * Chart of accounts
         * -------------------------
         */
        
        public function chart_of_accounts () {
            $title = site_name . ' - Chart of accounts';
            $this -> header ($title);
            $this -> sidebar ();
            $data[ 'account_heads' ] = $this -> AccountModel -> get_all_account_heads ();
            $this -> load -> view ('/accounts/chart-of-accounts', $data);
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * Chart of accounts
         * -------------------------
         */
        
        public function sub_account_heads () {
            
            $acc_head_id = $this -> uri -> segment (3);
            if ( empty(trim ($acc_head_id)) or !is_numeric ($acc_head_id) )
                return redirect ('/accounts/chart-of-accounts');
            
            $title = site_name . ' - Chart of accounts';
            $this -> header ($title);
            $this -> sidebar ();
            $data[ 'account_heads' ] = $this -> AccountModel -> get_sub_account_heads ($acc_head_id);
            $data[ 'account' ] = $this -> AccountModel -> get_account_head_by_id ($acc_head_id);
            $this -> load -> view ('/accounts/sub-account-heads', $data);
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * Add account heads
         * -------------------------
         */
        
        public function add_account_head () {
            
            if ( isset($_POST[ 'action' ]) and $_POST[ 'action' ] == 'do_add_account_head' )
                $this -> do_add_account_head ($_POST);
            
            $title = site_name . ' - Add account heads';
            $this -> header ($title);
            $this -> sidebar ();
            $data[ 'account_heads' ] = $this -> AccountModel -> get_main_account_heads ();
            $data[ 'roles' ] = $this -> AccountModel -> get_roles ();
            $data[ 'doctors' ] = $this -> DoctorModel -> get_doctors ();
            $data[ 'panels' ] = $this -> PanelModel -> get_panels ();
            $this -> load -> view ('/accounts/add-account-head', $data);
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * add account head
         * -------------------------
         */
        
        public function do_add_account_head ( $POST ) {
            $data = filter_var_array ($POST, FILTER_SANITIZE_STRING);
            $doctor_id = $data[ 'doctor_id' ];
            $panel_id = $data[ 'panel_id' ];
            $this -> form_validation -> set_rules ('name', 'name', 'required|trim|min_length[1]|is_unique[account_heads.title]');
            if ( $this -> form_validation -> run () == true ) {
                if ( !is_doctor_already_linked_with_account_head ($doctor_id) and !is_panel_already_linked_with_account_head ($panel_id) ) {
                    $info = array (
                        'title'          => $data[ 'name' ],
                        'parent_id'      => $data[ 'parent_id' ],
                        'role_id'        => $data[ 'role_id' ],
                        'doctor_id'      => $data[ 'doctor_id' ],
                        'panel_id'       => $data[ 'panel_id' ],
                        'contact_person' => $data[ 'contact_person' ],
                        'phone'          => $data[ 'phone' ],
                        'status'         => $data[ 'status' ],
                        'type'           => $data[ 'type' ],
                        'description'    => $data[ 'description' ],
                        'date_added'     => current_date_time (),
                    );
                    $account_id = $this -> AccountModel -> insert ($info);
                    
                    /***********LOGS*************/
                    
                    $log = array (
                        'user_id'      => get_logged_in_user_id (),
                        'account_id'   => $account_id,
                        'action'       => 'account_head_added',
                        'log'          => json_encode ($info),
                        'after_update' => '',
                        'date_added'   => current_date_time ()
                    );
                    $this -> load -> model ('LogModel');
                    $this -> LogModel -> create_log ('accounts_logs', $log);
                    
                    /***********END LOG*************/
                    
                    if ( $account_id > 0 ) {
                        $this -> session -> set_flashdata ('response', 'Success! Account head created');
                        return redirect ($_SERVER[ 'HTTP_REFERER' ]);
                    }
                    else {
                        $this -> session -> set_flashdata ('error', 'Error! Please try again.');
                        return redirect (base_url ('/accounts/add-account-head'));
                    }
                }
                else {
                    if ( is_doctor_already_linked_with_account_head ($doctor_id) )
                        $this -> session -> set_flashdata ('error', 'Error! Doctor is already linked with another account head.');
                    if ( is_panel_already_linked_with_account_head ($panel_id) )
                        $this -> session -> set_flashdata ('error', 'Error! Panel is already linked with another account head.');
                    return redirect ($_SERVER[ 'HTTP_REFERER' ]);
                }
            }
        }
        
        /**
         * -------------------------
         * @return mixed
         * edit page of account head
         * -------------------------
         */
        
        public function edit () {
            $acc_head_id = $this -> uri -> segment (3);
            if ( empty(trim ($acc_head_id)) or !is_numeric ($acc_head_id) or $acc_head_id < 1 )
                return rediect ('/accounts/chart-of-accounts');
            
            if ( isset($_POST[ 'action' ]) and $_POST[ 'action' ] == 'do_edit_account_head' )
                $this -> do_edit_account_head ($_POST);
            
            $title = site_name . ' - Edit account heads';
            $this -> header ($title);
            $this -> sidebar ();
            $data[ 'account_heads' ] = $this -> AccountModel -> get_main_account_heads ();
            $data[ 'single_account_head' ] = $this -> AccountModel -> get_account_head_by_id ($acc_head_id);
            $data[ 'roles' ] = $this -> AccountModel -> get_roles ();
            $data[ 'doctors' ] = $this -> DoctorModel -> get_doctors ();
            $data[ 'panels' ] = $this -> PanelModel -> get_panels ();
            $this -> load -> view ('/accounts/edit-account-head', $data);
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * do update account head
         * -------------------------
         */
        
        public function do_edit_account_head ( $POST ) {
            $data = filter_var_array ($POST, FILTER_SANITIZE_STRING);
            $acc_head_id = $data[ 'acc_id' ];
            $info = array (
                'title'          => $data[ 'name' ],
                'parent_id'      => $data[ 'parent_id' ],
                'role_id'        => $data[ 'role_id' ],
                'doctor_id'      => $data[ 'doctor_id' ],
                'panel_id'       => $data[ 'panel_id' ],
                'contact_person' => $data[ 'contact_person' ],
                'phone'          => $data[ 'phone' ],
                'status'         => $data[ 'status' ],
                'type'           => $data[ 'type' ],
                'description'    => $data[ 'description' ],
            );
            $updated = $this -> AccountModel -> edit ($info, $acc_head_id);
            if ( $updated ) {
                
                /***********LOGS*************/
                
                $log = array (
                    'user_id'      => get_logged_in_user_id (),
                    'account_id'   => $acc_head_id,
                    'action'       => 'account_head_updated',
                    'log'          => ' ',
                    'after_update' => json_encode ($info),
                    'date_added'   => current_date_time ()
                );
                $this -> load -> model ('LogModel');
                $this -> LogModel -> create_log ('accounts_logs', $log);
                
                /***********END LOG*************/
                
                $this -> session -> set_flashdata ('response', 'Success! Account head updated');
                return redirect ($_SERVER[ 'HTTP_REFERER' ]);
            }
            else {
                $this -> session -> set_flashdata ('error', 'Note! Account head already updated.');
                return redirect ($_SERVER[ 'HTTP_REFERER' ]);
            }
        }
        
        /**
         * -------------------------
         * @return mixed
         * inactive account head
         * -------------------------
         */
        
        public function delete () {
            $acc_head_id = $this -> uri -> segment (3);
            if ( empty(trim ($acc_head_id)) or !is_numeric ($acc_head_id) or $acc_head_id < 1 )
                return rediect ('/accounts/chart-of-accounts');
            
            $this -> AccountModel -> delete_acc_head ($acc_head_id);
            
            /***********LOGS*************/
            
            $log = array (
                'user_id'      => get_logged_in_user_id (),
                'account_id'   => $acc_head_id,
                'action'       => 'account_head_deleted',
                'log'          => json_encode ($acc_head_id),
                'after_update' => '',
                'date_added'   => current_date_time ()
            );
            $this -> load -> model ('LogModel');
            $this -> LogModel -> create_log ('accounts_logs', $log);
            
            /***********END LOG*************/
            
            $this -> session -> set_flashdata ('response', 'Success! Account head deleted.');
            return redirect ($_SERVER[ 'HTTP_REFERER' ]);
        }
        
        /**
         * -------------------------
         * @return mixed
         * activate account head
         * -------------------------
         */
        
        public function reactivate () {
            $acc_head_id = $this -> uri -> segment (3);
            if ( empty(trim ($acc_head_id)) or !is_numeric ($acc_head_id) or $acc_head_id < 1 )
                return rediect ('/accounts/chart-of-accounts');
            
            $info = array (
                'status' => '1'
            );
            $updated = $this -> AccountModel -> delete ($info, $acc_head_id);
            
            if ( $updated ) {
                $this -> session -> set_flashdata ('response', 'Success! Account head active.');
                return redirect ($_SERVER[ 'HTTP_REFERER' ]);
            }
            else {
                $this -> session -> set_flashdata ('error', 'Note! Account head already updated.');
                return redirect ($_SERVER[ 'HTTP_REFERER' ]);
            }
        }
        
        /**
         * -------------------------
         * add transactions page
         * load all account heads
         * load banks
         * -------------------------
         */
        
        public function add_transactions () {
            
            if ( isset($_POST[ 'action' ]) and $_POST[ 'action' ] == 'do_add_transaction' )
                $this -> do_add_transaction ($_POST);
            
            $title = site_name . ' - Add Transactions';
            $this -> header ($title);
            $this -> sidebar ();
            $data[ 'account_heads' ] = $this -> AccountModel -> get_main_account_heads ();
            $data[ 'banks' ] = $this -> AccountModel -> get_banks (bank_id);
            $this -> load -> view ('/accounts/add-transaction', $data);
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * do add transaction
         * -------------------------
         */
        
        public function do_add_transaction ( $POST ) {
            $data = filter_var_array ($POST, FILTER_SANITIZE_STRING);
            $this -> form_validation -> set_rules ('acc_head_id', 'account head', 'trim|required|min_length[1]|numeric|xss_clean');
            $this -> form_validation -> set_rules ('amount', 'amount', 'trim|required|min_length[1]|numeric|xss_clean');
            $this -> form_validation -> set_rules ('trans_date', 'trans_date', 'trim|required|min_length[1]|date|xss_clean');
            $this -> form_validation -> set_rules ('transaction_type', 'transaction type', 'trim|required|min_length[1]|xss_clean');
            $this -> form_validation -> set_rules ('description', 'description', 'trim|required|min_length[1]|xss_clean');
            //        $this -> form_validation -> set_rules('voucher_number', 'voucher number', 'trim|required|min_length[1]|xss_clean');
            
            if ( $this -> form_validation -> run () == true ) {
                $voucher_number = generate_voucher_number ($data[ 'voucher_number' ]);
                $info = array (
                    'user_id'          => get_logged_in_user_id (),
                    'acc_head_id'      => $data[ 'acc_head_id' ],
                    'voucher_number'   => $voucher_number,
                    'trans_date'       => date ('Y-m-d', strtotime ($data[ 'trans_date' ])),
                    'payment_mode'     => $data[ 'payment_mode' ],
                    'transaction_type' => $data[ 'transaction_type' ],
                    'description'      => $data[ 'description' ],
                    'date_added'       => current_date_time (),
                );
                if ( $data[ 'transaction_type' ] == 'credit' ) {
                    $info[ 'credit' ] = $data[ 'amount' ];
                }
                if ( $data[ 'transaction_type' ] == 'debit' ) {
                    $info[ 'debit' ] = $data[ 'amount' ];
                }
                
                /*********** IF BANK ID EXISTS *************/
                
                if ( isset($data[ 'acc_head_id_2' ]) and !empty(trim ($data[ 'acc_head_id_2' ])) ) {
                    $bank_trans = array (
                        'user_id'          => get_logged_in_user_id (),
                        'acc_head_id'      => $data[ 'acc_head_id_2' ],
                        'voucher_number'   => $voucher_number,
                        'trans_date'       => date ('Y-m-d', strtotime ($data[ 'trans_date' ])),
                        'payment_mode'     => $data[ 'payment_mode' ],
                        'transaction_type' => $data[ 'transaction_type_2' ],
                        'description'      => $data[ 'description' ],
                        'date_added'       => current_date_time (),
                    );
                    if ( $data[ 'transaction_type_2' ] == 'credit' ) {
                        $bank_trans[ 'credit' ] = $data[ 'amount' ];
                    }
                    if ( $data[ 'transaction_type_2' ] == 'debit' ) {
                        $bank_trans[ 'debit' ] = $data[ 'amount' ];
                    }
                    $bank_trans_id = $this -> AccountModel -> add_ledger ($bank_trans);
                    
                    /***********LOGS*************/
                    
                    $log = array (
                        'user_id'      => get_logged_in_user_id (),
                        'account_id'   => $bank_trans_id,
                        'action'       => 'bank_transaction_added',
                        'log'          => json_encode ($bank_trans),
                        'after_update' => '',
                        'date_added'   => current_date_time ()
                    );
                    $this -> load -> model ('LogModel');
                    $this -> LogModel -> create_log ('accounts_logs', $log);
                    
                    /***********END LOG*************/
                    
                }
                /*********** IF BANK ID EXISTS *************/
                
                $trans_id = $this -> AccountModel -> add_ledger ($info);
                
                /***********LOGS*************/
                
                $log = array (
                    'user_id'      => get_logged_in_user_id (),
                    'account_id'   => $trans_id,
                    'action'       => 'transaction_added',
                    'log'          => json_encode ($info),
                    'after_update' => '',
                    'date_added'   => current_date_time ()
                );
                $this -> load -> model ('LogModel');
                $this -> LogModel -> create_log ('accounts_logs', $log);
                
                /***********END LOG*************/
                
                $response = 'Transaction ID# ' . $trans_id . '<a href="' . base_url ('/invoices/transaction/' . $trans_id) . '" style="margin-left: 15px;text-decoration: underline;">Print Invoice</a><br>';
                if ( !empty($bank_trans_id) )
                    $response .= 'Second Transaction ID# ' . $bank_trans_id . '<br>';
                if ( $trans_id > 0 ) {
                    $this -> session -> set_flashdata ('response', $response);
                    return redirect (base_url ('/accounts/add-transactions'));
                }
                else {
                    $this -> session -> set_flashdata ('error', 'Error! Please try again.');
                    return redirect (base_url ('/accounts/add-transactions'));
                }
            }
        }
        
        /**
         * -------------------------
         * opening balances
         * main page
         * -------------------------
         */
        
        public function opening_balances () {
            $title = site_name . ' - Opening Balances';
            $this -> header ($title);
            $this -> sidebar ();
            $data[ 'account_heads' ] = $this -> AccountModel -> get_main_account_heads ();
            $data[ 'balances' ] = $this -> AccountModel -> get_opening_balances ();
            $this -> load -> view ('/accounts/opening-balances', $data);
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * add opening balance
         * -------------------------
         */
        
        public function add_opening_balances () {
            
            if ( isset($_POST[ 'action' ]) and $_POST[ 'action' ] == 'do_add_opening_balances' )
                $this -> do_add_opening_balances ($_POST);
            
            $title = site_name . ' - Add Opening Balances';
            $this -> header ($title);
            $this -> sidebar ();
            $data[ 'account_heads' ] = $this -> AccountModel -> get_main_account_heads ();
            $this -> load -> view ('/accounts/add-opening-balance', $data);
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * add opening balance
         * -------------------------
         */
        
        public function do_add_opening_balances ( $POST ) {
            $data = filter_var_array ($POST, FILTER_SANITIZE_STRING);
            $this -> form_validation -> set_rules ('acc_head_id', 'account head', 'trim|required|min_length[1]|numeric|xss_clean');
            $this -> form_validation -> set_rules ('amount', 'amount', 'trim|required|min_length[1]|numeric|xss_clean');
            $this -> form_validation -> set_rules ('date_added', 'transaction date', 'trim|required|xss_clean');
            $this -> form_validation -> set_rules ('transaction_type', 'transaction type', 'trim|required|min_length[1]|xss_clean');
            
            if ( $this -> form_validation -> run () == true ) {
                $info = array (
                    'user_id'          => get_logged_in_user_id (),
                    'acc_head_id'      => $data[ 'acc_head_id' ],
                    'trans_date'       => date ('Y-m-d', strtotime ($data[ 'date_added' ])),
                    'payment_mode'     => 'opening_balance',
                    'paid_via'         => '',
                    'transaction_type' => 'opening_balance',
                    'description'      => 'opening balance',
                    'date_added'       => current_date_time (),
                );
                $parent_account = get_account_head ($data[ 'acc_head_id' ]);
                
                /*********** IF ACCOUNT HEAD PARENT IS BANK ****************/
                if ( $parent_account -> parent_id == bank_id ) {
                    if ( $data[ 'transaction_type' ] == 'credit' ) {
                        $info[ 'credit' ] = $data[ 'amount' ];
                    }
                    if ( $data[ 'transaction_type' ] == 'debit' ) {
                        $info[ 'debit' ] = $data[ 'amount' ];
                    }
                }
                /*********** IF ACCOUNT HEAD PARENT IS SUPPLIER ****************/
                else {
                    if ( $data[ 'transaction_type' ] == 'credit' ) {
                        $info[ 'credit' ] = $data[ 'amount' ];
                    }
                    if ( $data[ 'transaction_type' ] == 'debit' ) {
                        $info[ 'debit' ] = $data[ 'amount' ];
                    }
                }
                $balance_id = $this -> AccountModel -> add_opening_balance ($info);
                
                /***********LOGS*************/
                
                $log = array (
                    'user_id'      => get_logged_in_user_id (),
                    'account_id'   => $balance_id,
                    'action'       => 'opening_balance_added',
                    'log'          => json_encode ($info),
                    'after_update' => '',
                    'date_added'   => current_date_time ()
                );
                $this -> load -> model ('LogModel');
                $this -> LogModel -> create_log ('accounts_logs', $log);
                
                /***********END LOG*************/
                
                if ( $balance_id > 0 ) {
                    $this -> session -> set_flashdata ('response', 'Success! Opening balance added.');
                    return redirect (base_url ('/accounts/add-opening-balance'));
                }
                else {
                    $this -> session -> set_flashdata ('error', 'Error! Please try again.');
                    return redirect (base_url ('/accounts/add-opening-balance'));
                }
            }
        }
        
        /**
         * -------------------------
         * delete opening balance
         * -------------------------
         */
        
        public function delete_opening_balance () {
            $balance_id = $this -> uri -> segment (3);
            if ( empty(trim ($balance_id)) or !is_numeric ($balance_id) or $balance_id < 1 )
                return rediect ('/accounts/opening-balances');
            
            $this -> AccountModel -> delete_opening_balance ($balance_id);
            
            /***********LOGS*************/
            
            $log = array (
                'user_id'      => get_logged_in_user_id (),
                'account_id'   => $balance_id,
                'action'       => 'opening_balance_deleted',
                'log'          => json_encode ($balance_id),
                'after_update' => '',
                'date_added'   => current_date_time ()
            );
            $this -> load -> model ('LogModel');
            $this -> LogModel -> create_log ('accounts_logs', $log);
            
            /***********END LOG*************/
            
            $this -> session -> set_flashdata ('response', 'Success! Balance removed from system.');
            return redirect ($_SERVER[ 'HTTP_REFERER' ]);
        }
        
        /**
         * -------------------------
         * get remaining balance
         * -------------------------
         */
        
        public function get_remaining_balance () {
            $acc_head_id = $this -> input -> post ('acc_head_id');
            if ( !empty(trim ($acc_head_id)) and is_numeric ($acc_head_id) ) {
                echo $this -> AccountModel -> get_remaining_balance ($acc_head_id);
            }
        }
        
        /**
         * -------------------------
         * general ledger page
         * search ledgers
         * -------------------------
         */
        
        public function general_ledger () {
            $title = site_name . ' - General Ledger';
            $this -> header ($title);
            $this -> sidebar ();
            $data[ 'account_heads' ] = $this -> AccountModel -> get_main_account_heads ();
            $data[ 'ledgers' ] = $this -> AccountModel -> get_ledgers ();
            $this -> load -> view ('/accounts/general-ledger', $data);
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * general ledger page
         * search transactions
         * -------------------------
         */
        
        public function search_transaction () {
            $title = site_name . ' - Search Transactions';
            $this -> header ($title);
            $this -> sidebar ();
            
            if ( isset($_REQUEST[ 'transaction_number' ]) and !empty(trim ($_REQUEST[ 'transaction_number' ])) and is_numeric ($_REQUEST[ 'transaction_number' ]) and $_REQUEST[ 'transaction_number' ] > 0 )
                $transaction_id = $_REQUEST[ 'transaction_number' ];
            else
                $transaction_id = 0;
            
            if ( isset($_POST[ 'action' ]) and $_POST[ 'action' ] == 'do_update_transaction' )
                $this -> do_update_transaction ($_POST);
            
            $data[ 'account_heads' ] = $this -> AccountModel -> get_main_account_heads ();
            $data[ 'banks' ] = $this -> AccountModel -> get_banks (bank_id);
            $data[ 'transaction' ] = $this -> AccountModel -> get_transaction_by_id ($transaction_id);
            $this -> load -> view ('/accounts/search-transaction', $data);
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * @param $POST
         * do update transaction
         * -------------------------
         */
        
        public function do_update_transaction ( $POST ) {
            $data = filter_var_array ($POST, FILTER_SANITIZE_STRING);
            $this -> form_validation -> set_rules ('acc_head_id', 'account head', 'trim|required|min_length[1]|xss_clean');
            $this -> form_validation -> set_rules ('amount', 'amount', 'trim|required|min_length[1]|numeric|xss_clean');
            $this -> form_validation -> set_rules ('trans_date', 'trans_date', 'trim|required|min_length[1]|date|xss_clean');
            $this -> form_validation -> set_rules ('payment_mode', 'payment_mode', 'trim|required|min_length[1]|xss_clean');
            
            $this -> form_validation -> set_rules ('transaction_type', 'transaction type', 'trim|required|min_length[1]|xss_clean');
            $this -> form_validation -> set_rules ('description', 'description', 'trim|required|min_length[1]|xss_clean');
            //		$this -> form_validation -> set_rules('voucher_number', 'voucher number', 'trim|required|min_length[1]|xss_clean');
            
            $transaction_id = $data[ 'transaction_id' ];
            $acc_head_id = $data[ 'acc_head_id' ];
            
            if ( is_numeric ($acc_head_id) > 0 ) {
                $id = $acc_head_id;
            }
            else {
                $exp = explode ('-', $acc_head_id);
                $id = $exp[ 1 ];
            }
            
            $data[ 'acc_head_id' ] = $id;
            
            $parent = $this -> AccountModel -> get_account_head_parent ($id);
            if ( $this -> form_validation -> run () == true ) {
                if ( $parent == bank_id )
                    $this -> update_bank_transaction ($data, $transaction_id, $id);
                else
                    $this -> update_current_transaction ($data, $transaction_id, $id);
                
                $this -> session -> set_flashdata ('response', 'Success! Transaction updated');
                return redirect (base_url ('/accounts/search-transaction?transaction_number=' . $transaction_id));
            }
        }
        
        /**
         * -------------------------
         * @param $data
         * @param $transaction_id
         * update current transaction
         * -------------------------
         */
        
        public function update_current_transaction ( $data, $transaction_id ) {
            $voucher_number = $data[ 'voucher_number' ];
            $info = array (
                'user_id'          => get_logged_in_user_id (),
                'acc_head_id'      => $data[ 'acc_head_id' ],
                'payment_mode'     => $data[ 'payment_mode' ],
                'transaction_type' => $data[ 'transaction_type' ],
                'trans_date'       => date ('Y-m-d', strtotime ($data[ 'trans_date' ])),
                'voucher_number'   => $voucher_number,
                'description'      => $data[ 'description' ],
            );
            if ( $data[ 'transaction_type' ] == 'credit' ) {
                $info[ 'debit' ] = $data[ 'amount' ];
                $info[ 'credit' ] = 0;
            }
            if ( $data[ 'transaction_type' ] == 'debit' ) {
                $info[ 'credit' ] = $data[ 'amount' ];
                $info[ 'debit' ] = 0;
            }
            do_create_log ($info, $transaction_id, '');
            $this -> AccountModel -> update_ledger ($info, $transaction_id);
            
            /***********LOGS*************/
            
            $log = array (
                'user_id'      => get_logged_in_user_id (),
                'account_id'   => $data[ 'acc_head_id' ],
                'action'       => 'transaction_updated',
                'log'          => ' ',
                'after_update' => json_encode ($info),
                'date_added'   => current_date_time ()
            );
            $this -> load -> model ('LogModel');
            $this -> LogModel -> create_log ('accounts_logs', $log);
            
            /***********END LOG*************/
            
            $bank_transaction = $this -> AccountModel -> check_if_bank_trans_exists ($transaction_id);
            if ( !empty(trim ($bank_transaction)) and $bank_transaction > 0 ) {
                $this -> do_update_bank_running_balance ($data, $bank_transaction);
            }
        }
        
        /**
         * -------------------------
         * @param $data
         * @param $transaction_id
         * update current transaction
         * -------------------------
         */
        
        public function update_bank_transaction ( $data, $transaction_id, $acc_head_id ) {
            $voucher_number = $data[ 'voucher_number' ];
            $info = array (
                'user_id'          => get_logged_in_user_id (),
                'acc_head_id'      => $data[ 'acc_head_id' ],
                'payment_mode'     => $data[ 'payment_mode' ],
                'transaction_type' => $data[ 'transaction_type' ],
                'voucher_number'   => $voucher_number,
                'description'      => $data[ 'description' ],
            );
            if ( $data[ 'transaction_type' ] == 'credit' ) {
                $info[ 'debit' ] = $data[ 'amount' ];
            }
            if ( $data[ 'transaction_type' ] == 'debit' ) {
                $info[ 'credit' ] = $data[ 'amount' ];
            }
            do_create_log ($info, $transaction_id, '');
            $this -> AccountModel -> update_ledger ($info, $transaction_id);
            
            /***********LOGS*************/
            
            $log = array (
                'user_id'      => get_logged_in_user_id (),
                'account_id'   => $data[ 'acc_head_id' ],
                'action'       => 'bank_transaction_updated',
                'log'          => ' ',
                'after_update' => json_encode ($info),
                'date_added'   => current_date_time ()
            );
            $this -> load -> model ('LogModel');
            $this -> LogModel -> create_log ('accounts_logs', $log);
            
            /***********END LOG*************/
            
        }
        
        /**
         * -------------------------
         * @param $data
         * @param $transaction_id
         * update bank transactions
         * -------------------------
         */
        
        public function do_update_bank_running_balance ( $data, $transaction_id ) {
            $transaction = $this -> AccountModel -> get_transaction_by_id ($transaction_id);
            $acc_head_id = $transaction -> acc_head_id;
            $info = array (
                'user_id'          => get_logged_in_user_id (),
                'acc_head_id'      => $acc_head_id,
                'payment_mode'     => $data[ 'payment_mode' ],
                'transaction_type' => $data[ 'transaction_type' ],
                'description'      => $data[ 'description' ],
            );
            if ( $data[ 'transaction_type' ] == 'credit' ) {
                $info[ 'debit' ] = $data[ 'amount' ];
            }
            if ( $data[ 'transaction_type' ] == 'debit' ) {
                $info[ 'credit' ] = $data[ 'amount' ];
            }
            do_create_log ($info, $transaction_id, $transaction);
            $this -> AccountModel -> update_ledger ($info, $transaction_id);
            
            /***********LOGS*************/
            
            $log = array (
                'user_id'      => get_logged_in_user_id (),
                'account_id'   => $data[ 'acc_head_id' ],
                'action'       => 'bank_opening_balance_updated',
                'log'          => ' ',
                'after_update' => json_encode ($info),
                'date_added'   => current_date_time ()
            );
            $this -> load -> model ('LogModel');
            $this -> LogModel -> create_log ('accounts_logs', $log);
            
            /***********END LOG*************/
            
        }
        
        /**
         * -------------------------
         * supplier invoices page
         * search by supplier, date
         * -------------------------
         */
        
        public function supplier_invoices () {
            $title = site_name . ' - Supplier Invoice';
            $this -> header ($title);
            $this -> sidebar ();
            $data[ 'suppliers' ] = $this -> SupplierModel -> get_active_suppliers ();
            $data[ 'invoices' ] = $this -> AccountModel -> get_supplier_invoices ();
            $this -> load -> view ('/accounts/supplier-invoice', $data);
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * revert transaction by voucher number
         * -------------------------
         */
        
        public function revert_transaction () {
            $voucher_number = $this -> uri -> segment (3);
            if ( !empty(trim ($voucher_number)) ) {
                $reverted = $this -> AccountModel -> revert_transaction ($voucher_number);
                if ( $reverted ) {
                    
                    /***********LOGS*************/
                    
                    $log = array (
                        'user_id'      => get_logged_in_user_id (),
                        'account_id'   => $voucher_number,
                        'action'       => 'transaction_reverted_via_voucher_number',
                        'log'          => ' ',
                        'after_update' => json_encode ($voucher_number),
                        'date_added'   => current_date_time ()
                    );
                    $this -> load -> model ('LogModel');
                    $this -> LogModel -> create_log ('accounts_logs', $log);
                    
                    /***********END LOG*************/
                    
                    $this -> session -> set_flashdata ('response', 'Transaction has been reverted.');
                    return redirect (base_url ('/accounts/search-transaction'));
                }
                else {
                    $this -> session -> set_flashdata ('error', 'Error! Please try again.');
                }
            }
            return redirect ($_SERVER[ 'HTTP_REFERER' ]);
        }
        
        /**
         * -------------------------
         * check if voucher number exists
         * echo 'true', else 'false'
         * -------------------------
         */
        
        public function validate_voucher_number () {
            $voucher_number = $this -> input -> post ('voucher_number', true);
            if ( isset($voucher_number) and !empty(trim ($voucher_number)) ) {
                $exists = $this -> AccountModel -> validate_voucher_number ($voucher_number);
                if ( $exists )
                    echo 'exists';
                else
                    echo 'false';
            }
        }
        
        /**
         * -------------------------
         * add multiple transactions page
         * load all account heads
         * load banks
         * -------------------------
         */
        
        public function add_transactions_multiple () {
            
            if ( isset($_POST[ 'action' ]) and $_POST[ 'action' ] == 'add_transactions_multiple' )
                $this -> do_add_transactions_multiple ($_POST);
            
            $title = site_name . ' - Add Transactions - Multiple';
            $this -> header ($title);
            $this -> sidebar ();
            $data[ 'account_heads' ] = $this -> AccountModel -> get_main_account_heads ();
            $data[ 'banks' ] = $this -> AccountModel -> get_banks (bank_id);
            $this -> load -> view ('/accounts/add-transaction-multiple', $data);
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * add multiple transactions page
         * load all account heads
         * load banks
         * -------------------------
         */
        
        public function add_more_transactions () {
            $data[ 'account_heads' ] = $this -> AccountModel -> get_main_account_heads ();
            $data[ 'banks' ] = $this -> AccountModel -> get_banks (bank_id);
            $data[ 'row' ] = $_POST[ 'added' ];
            $this -> load -> view ('/accounts/add-more-transaction-multiple', $data);
        }
        
        /**
         * -------------------------
         * check if doctor is linked with ACC
         * -------------------------
         */
        
        public function check_if_doctor_is_linked_with_account_head () {
            $doctor_id = $_POST[ 'doctor_id' ];
            $isLinked = $this -> AccountModel -> check_if_doctor_is_linked_with_account_head ($doctor_id);
            if ( $isLinked )
                echo 'true';
            else
                echo 'false';
        }
        
        /**
         * -------------------------
         * @param $POST
         * do add multiple transactions
         * -------------------------
         */
        
        public function do_add_transactions_multiple ( $POST ) {
            $data = filter_var_array ($POST, FILTER_SANITIZE_STRING);
            $this -> form_validation -> set_rules ('trans_date', 'trans_date', 'trim|required|min_length[1]|date|xss_clean');
            $this -> form_validation -> set_rules ('description', 'description', 'trim|required|min_length[1]|xss_clean');
            $this -> form_validation -> set_rules ('voucher_number', 'voucher number', 'trim|required|min_length[1]|xss_clean');
            
            
            if ( $this -> form_validation -> run () == true ) {
                
                $voucher_number = generate_voucher_number ($data[ 'voucher_number' ]);
                $trans_date = date ('Y-m-d', strtotime ($data[ 'trans_date' ]));
                $acc_head_id = $data[ 'acc_head_id' ];
                $user_id = get_logged_in_user_id ();
                
                if ( isset($acc_head_id) and count ($acc_head_id) > 0 ) {
                    foreach ( $acc_head_id as $key => $value ) {
                        $info = array (
                            'user_id'          => $user_id,
                            'acc_head_id'      => $value,
                            'voucher_number'   => $voucher_number,
                            'trans_date'       => $trans_date,
                            'payment_mode'     => 'cash',
                            'transaction_type' => $data[ 'transaction_type' ][ $key ],
                            'description'      => $data[ 'description' ],
                            'date_added'       => current_date_time (),
                        );
                        
                        if ( $data[ 'transaction_type' ][ $key ] == 'credit' ) {
                            $info[ 'credit' ] = $data[ 'amount' ][ $key ];
                        }
                        if ( $data[ 'transaction_type' ][ $key ] == 'debit' ) {
                            $info[ 'debit' ] = $data[ 'amount' ][ $key ];
                        }
                        $this -> AccountModel -> add_ledger ($info);
                        
                        /***********LOGS*************/
                        
                        $log = array (
                            'user_id'      => get_logged_in_user_id (),
                            'account_id'   => $value,
                            'action'       => 'multiple_transactions_added',
                            'log'          => json_encode ($info),
                            'after_update' => ' ',
                            'date_added'   => current_date_time ()
                        );
                        $this -> load -> model ('LogModel');
                        $this -> LogModel -> create_log ('accounts_logs', $log);
                        
                        /***********END LOG*************/
                        
                    }
                }
                $this -> session -> set_flashdata ('response', 'Success! Multiple transactions are added with voucher number: ' . $voucher_number);
                return redirect ($_SERVER[ 'HTTP_REFERER' ]);
            }
        }
        
        /**
         * -------------------------
         * check account type
         * -------------------------
         */
        
        public function check_account_type () {
            $acc_head_id = $this -> input -> post ('acc_head_id', true);
            if ( $acc_head_id > 0 ) {
                $account = get_account_head ($acc_head_id);
                if ( !empty($account) ) {
                    $role_id = $account -> role_id;
                    if ( $role_id > 0 ) {
                        if ( $role_id == assets )
                            echo 'debit';
                        if ( $role_id == liabilities )
                            echo 'credit';
                        if ( $role_id == capitals )
                            echo 'credit';
                        if ( $role_id == income )
                            echo 'debit';
                        if ( $role_id == expenditure )
                            echo 'credit';
                    }
                    else
                        echo 'false';
                }
                else
                    echo 'false';
            }
            else
                echo 'false';
        }
        
        /**
         * -------------------------
         * trial balance sheet
         * -------------------------
         */
        
        public function trial_balance () {
            $title = site_name . ' - Trial Balance Sheet';
            $this -> header ($title);
            $this -> sidebar ();
            $data[ 'account_heads' ] = $this -> AccountModel -> get_account_heads_not_in (local_purchase);
            $this -> load -> view ('/accounts/trial-balance', $data);
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * profit loss statement
         * -------------------------
         */
        
        public function profit_loss_statement () {
            $title = site_name . ' - Profit Loss Statement';
            $this -> header ($title);
            $this -> sidebar ();
            $data[ 'sales_account_head' ] = $this -> AccountModel -> get_specific_account_heads (sales_id);
            $data[ 'returns_allowances_account_head' ] = get_account_head (Returns_and_Allowances);
            $data[ 'fee_discounts_account_head' ] = $this -> AccountModel -> get_specific_account_heads (Fee_Discounts);
            $data[ 'Direct_Costs_account_head' ] = $this -> AccountModel -> get_specific_account_heads (Direct_Costs);
            $data[ 'expenses_account_head' ] = $this -> AccountModel -> get_specific_account_heads (expense_id);
            $data[ 'Finance_Cost_account_head' ] = get_account_head (Finance_Cost);
            $data[ 'Tax_account_head' ] = get_account_head (Tax);
            $this -> load -> view ('/accounts/profit-loss-statement', $data);
            $this -> footer ();
        }
        
        /**
         * -------------------------
         * trial balance sheet
         * -------------------------
         */
        
        public function balance_sheet () {
            $title = site_name . ' - Balance Sheet';
            $this -> header ($title);
            $this -> sidebar ();
            $data[ 'cash_balances' ] = $this -> AccountModel -> get_balance_sheet (cash_balances);
            $data[ 'banks' ] = $this -> AccountModel -> get_balance_sheet (banks);
            $data[ 'receivable_accounts' ] = $this -> AccountModel -> get_balance_sheet (receivable_accounts);
            $data[ 'inventory' ] = $this -> AccountModel -> get_balance_sheet (inventory);
            $data[ 'furniture_fixture' ] = $this -> AccountModel -> get_balance_sheet (furniture_fixture);
            $data[ 'intangible_assets' ] = $this -> AccountModel -> get_balance_sheet (intangible_assets);
            $data[ 'bio_medical_surgical_items' ] = $this -> AccountModel -> get_balance_sheet (bio_medical_surgical_items);
            $data[ 'machinery_equipment' ] = $this -> AccountModel -> get_balance_sheet (machinery_equipment);
            $data[ 'electrical_equipment' ] = $this -> AccountModel -> get_balance_sheet (electrical_equipment);
            $data[ 'it_equipment' ] = $this -> AccountModel -> get_balance_sheet (it_equipment);
            $data[ 'office_equipment' ] = $this -> AccountModel -> get_balance_sheet (office_equipment);
            $data[ 'land_building' ] = $this -> AccountModel -> get_balance_sheet (land_building);
            $data[ 'accumulated_depreciation' ] = $this -> AccountModel -> get_balance_sheet (accumulated_depreciation);
            $data[ 'payable_accounts' ] = $this -> AccountModel -> get_balance_sheet (payable_accounts);
            $data[ 'accrued_expenses' ] = $this -> AccountModel -> get_balance_sheet (accrued_expenses);
            $data[ 'unearned_revenue' ] = $this -> AccountModel -> get_balance_sheet (unearned_revenue);
            $data[ 'WHT_payable' ] = $this -> AccountModel -> get_balance_sheet (WHT_payable);
            $data[ 'long_term_debt' ] = $this -> AccountModel -> get_balance_sheet (long_term_debt);
            $data[ 'other_long_term_liabilities' ] = $this -> AccountModel -> get_balance_sheet (other_long_term_liabilities);
            $data[ 'capital' ] = $this -> AccountModel -> get_balance_sheet (capital);
            
            // to calculate net profit
            if (isset($_REQUEST['trans_date']) and !empty(trim ($_REQUEST['trans_date'])))
                $data['calculate_net_profit'] = $this -> AccountModel -> balance_sheet_net_profit ();
            else
                $data[ 'calculate_net_profit' ] = 0;
            
            $this -> load -> view ('/accounts/balance-sheet', $data);
            $this -> footer ();
        }
        
    }

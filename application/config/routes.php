<?php
    defined ( 'BASEPATH' ) or exit( 'No direct script access allowed' );
    
    /*
    | -------------------------------------------------------------------------
    | URI ROUTING
    | -------------------------------------------------------------------------
    | This file lets you re-map URI requests to specific controller functions.
    |
    | Typically there is a one-to-one relationship between a URL string
    | and its corresponding controller class/method. The segments in a
    | URL normally follow this pattern:
    |
    |	example.com/class/method/id/
    |
    | In some instances, however, you may want to remap this relationship
    | so that a different class/function is called than the one
    | corresponding to the URL.
    |
    | Please see the user guide for complete details:
    |
    |	https://codeigniter.com/user_guide/general/routing.html
    |
    | -------------------------------------------------------------------------
    | RESERVED ROUTES
    | -------------------------------------------------------------------------
    |
    | There are three reserved routes:
    |
    |	$route['default_controller'] = 'welcome';
    |
    | This route indicates which controller class should be loaded if the
    | URI contains no data. In the above example, the "welcome" class
    | would be loaded.
    |
    |	$route['404_override'] = 'errors/page_missing';
    |
    | This route will tell the Router which controller/method to use if those
    | provided in the URL cannot be matched to a valid route.
    |
    |	$route['translate_uri_dashes'] = FALSE;
    |
    | This is not exactly a route, but allows you to automatically route
    | controller and method names that contain dashes. '-' isn't a valid
    | class or method name character, so it requires translation.
    | When you set this option to TRUE, it will replace ALL dashes in the
    | controller and method URI segments.
    |
    | Examples:	my-controller/index	-> my_controller/index
    |		my-controller/my-method	-> my_controller/my_method
    */
    $route[ 'default_controller' ]                                       = 'Login/index';
    $route[ 'register' ]                                                 = 'Login/register';
    $route[ 'forget-password' ]                                          = 'Login/forget_password';
    $route[ 'activate' ]                                                 = 'Login/activate_account';
    $route[ 'dashboard' ]                                                = 'Dashboard/index';
    $route[ 'stats-dashboard' ]                                          = 'Dashboard/stats_dashboard';
    $route[ 'logout' ]                                                   = 'Dashboard/Logout';
    $route[ 'consultancy/panel-consultancy-invoices' ]                   = 'Consultancy/panel_consultancy_invoices';
    $route[ 'patients/add-panel-patient' ]                               = 'Patients/add_panel_patient';
    $route[ 'patients/edit-panel/(:any)' ]                               = 'Patients/edit_panel/$1';
    $route[ 'patients/edit-cash/(:any)' ]                                = 'Patients/edit_cash/$1';
    $route[ 'medicines/add-medicines-stock' ]                            = 'Medicines/add_stock';
    $route[ 'medicines/edit-stock/(:any)' ]                              = 'Medicines/edit_stock/$1';
    $route[ 'medicines/delete-stock/(:any)' ]                            = 'Medicines/delete_stock/$1';
    $route[ 'medicines/delete-stock-permanently/(:any)' ]                = 'Medicines/delete_stock_permanently/$1';
    $route[ 'medicines/activate-stock/(:any)' ]                          = 'Medicines/activate_stock/$1';
    $route[ 'medicines/discard-expired-medicine' ]                       = 'Medicines/discard_expired_medicine';
    $route[ 'medicines/discarded-expired-medicines' ]                    = 'Medicines/discarded_expired_medicines';
    $route[ 'settings/add-members' ]                                     = 'Settings/add_members';
    $route[ 'settings/add-companies' ]                                   = 'Settings/add_companies';
    $route[ 'settings/edit-member/(:any)' ]                              = 'Settings/edit_member/$1';
    $route[ 'settings/delete-member/(:any)' ]                            = 'Settings/delete_member/$1';
    $route[ 'settings/edit-company/(:any)' ]                             = 'Settings/edit_company/$1';
    $route[ 'settings/delete-company/(:any)' ]                           = 'Settings/delete_company/$1';
    $route[ 'settings/add-panel' ]                                       = 'Settings/add_panel';
    $route[ 'settings/edit-panel/(:any)' ]                               = 'Settings/edit_panel/$1';
    $route[ 'settings/delete-panel/(:any)' ]                             = 'Settings/delete_panel/$1';
    $route[ 'settings/add-generic' ]                                     = 'Settings/add_generic';
    $route[ 'settings/edit-generic/(:any)' ]                             = 'Settings/edit_generic/$1';
    $route[ 'settings/delete-generic/(:any)' ]                           = 'Settings/delete_generic/$1';
    $route[ 'settings/add-strength' ]                                    = 'Settings/add_strength';
    $route[ 'settings/edit-strength/(:any)' ]                            = 'Settings/edit_strength/$1';
    $route[ 'settings/delete-strength/(:any)' ]                          = 'Settings/delete_strength/$1';
    $route[ 'settings/add-form' ]                                        = 'Settings/add_form';
    $route[ 'settings/edit-form/(:any)' ]                                = 'Settings/edit_form/$1';
    $route[ 'settings/delete-form/(:any)' ]                              = 'Settings/delete_form/$1';
    $route[ 'settings/add-location' ]                                    = 'Settings/add_location';
    $route[ 'settings/edit-location/(:any)' ]                            = 'Settings/edit_location/$1';
    $route[ 'settings/delete-location/(:any)' ]                          = 'Settings/delete_location/$1';
    $route[ 'settings/add-unit' ]                                        = 'Settings/add_unit';
    $route[ 'settings/edit-unit/(:any)' ]                                = 'Settings/edit_unit/$1';
    $route[ 'settings/delete-unit/(:any)' ]                              = 'Settings/delete_unit/$1';
    $route[ 'settings/add-section' ]                                     = 'Settings/add_section';
    $route[ 'settings/edit-section/(:any)' ]                             = 'Settings/edit_section/$1';
    $route[ 'settings/delete-section/(:any)' ]                           = 'Settings/delete_section/$1';
    $route[ 'settings/test-tube-colors' ]                                = 'Settings/test_tube_colors';
    $route[ 'settings/add-test-tube-colors' ]                            = 'Settings/add_test_tube_colors';
    $route[ 'settings/edit-test-tube-colors/(:any)' ]                    = 'Settings/edit_test_tube_colors/$1';
    $route[ 'settings/delete-test-tube-colors/(:any)' ]                  = 'Settings/delete_test_tube_colors/$1';
    $route[ 'settings/add-sample' ]                                      = 'Settings/add_sample';
    $route[ 'settings/edit-sample/(:any)' ]                              = 'Settings/edit_sample/$1';
    $route[ 'settings/delete-sample/(:any)' ]                            = 'Settings/delete_sample/$1';
    $route[ 'settings/company-members/(:any)' ]                          = 'Settings/company_members/$1';
    $route[ 'settings/add-manufacturers' ]                               = 'Settings/add_manufacturers';
    $route[ 'settings/edit-manufacturer/(:any)' ]                        = 'Settings/edit_manufacturers/$1';
    $route[ 'settings/delete-manufacturer/(:any)' ]                      = 'Settings/delete_manufacturers/$1';
    $route[ 'settings/opd-services' ]                                    = 'Settings/opd_services';
    $route[ 'settings/add-opd-services' ]                                = 'Settings/add_opd_services';
    $route[ 'settings/add-opd-services' ]                                = 'Settings/add_opd_services';
    $route[ 'settings/delete-service/(:any)' ]                           = 'Settings/delete_service/$1';
    $route[ 'settings/edit-service/(:any)' ]                             = 'Settings/edit_service/$1';
    $route[ 'settings/sub-services/(:any)' ]                             = 'Settings/sub_services/$1';
    $route[ 'settings/add-departments' ]                                 = 'Settings/add_departments';
    $route[ 'settings/edit-department/(:any)' ]                          = 'Settings/edit_department/$1';
    $route[ 'settings/delete-department/(:any)' ]                        = 'Settings/delete_department/$1';
    $route[ 'settings/par-levels' ]                                      = 'Settings/par_levels';
    $route[ 'settings/add-par-levels' ]                                  = 'Settings/add_par_levels';
    $route[ 'settings/edit-par-levels/(:any)' ]                          = 'Settings/edit_par_levels/$1';
    $route[ 'settings/delete-par-levels/(:any)' ]                        = 'Settings/delete_par_levels/$1';
    $route[ 'settings/add-ipd-services' ]                                = 'Settings/add_ipd_services';
    $route[ 'settings/ipd-services' ]                                    = 'Settings/ipd_services';
    $route[ 'settings/edit-ipd-service/(:any)' ]                         = 'Settings/edit_ipd_services/$1';
    $route[ 'settings/delete-ipd-service/(:any)' ]                       = 'Settings/delete_ipd_services/$1';
    $route[ 'settings/sub-ipd-service/(:any)' ]                          = 'Settings/sub_ipd_services/$1';
    $route[ 'settings/ipd-packages' ]                                    = 'Settings/ipd_packages';
    $route[ 'settings/add-ipd-packages' ]                                = 'Settings/add_ipd_packages';
    $route[ 'settings/ipd-packages' ]                                    = 'Settings/ipd_packages';
    $route[ 'settings/delete-ipd-package/(:any)' ]                       = 'Settings/delete_ipd_packages/$1';
    $route[ 'settings/add-internal-issuance-medicines-par-levels' ]      = 'Settings/add_internal_issuance_medicines_par_levels';
    $route[ 'settings/internal-issuance-medicines-par-levels' ]          = 'Settings/internal_issuance_medicines_par_levels';
    $route[ 'settings/delete-internal-issuance-par-levels/(:any)' ]      = 'Settings/delete_issuance_medicines_par_levels/$1';
    $route[ 'settings/edit-internal-issuance-par-levels/(:any)' ]        = 'Settings/edit_issuance_medicines_par_levels/$1';
    $route[ 'settings/pack-sizes' ]                                      = 'Settings/pack_sizes';
    $route[ 'settings/add-pack-size' ]                                   = 'Settings/add_pack_sizes';
    $route[ 'settings/delete-pack/(:any)' ]                              = 'Settings/delete_pack/$1';
    $route[ 'settings/edit-pack/(:any)' ]                                = 'Settings/edit_pack/$1';
    $route[ 'settings/add-city' ]                                        = 'Settings/add_city';
    $route[ 'settings/delete-city/(:any)' ]                              = 'Settings/delete_city/$1';
    $route[ 'settings/edit-city/(:any)' ]                                = 'Settings/edit_city/$1';
    $route[ 'settings/site-settings' ]                                   = 'Settings/site_settings';
    $route[ 'accounts/chart-of-accounts' ]                               = 'Accounts/chart_of_accounts';
    $route[ 'accounts/add-account-head' ]                                = 'Accounts/add_account_head';
    $route[ 'accounts/sub-account-heads/(:any)' ]                        = 'Accounts/sub_account_heads/$1';
    $route[ 'accounts/add-transactions' ]                                = 'Accounts/add_transactions';
    $route[ 'accounts/add-transactions-multiple' ]                       = 'Accounts/add_transactions_multiple';
    $route[ 'accounts/opening-balances' ]                                = 'Accounts/opening_balances';
    $route[ 'accounts/add-opening-balance' ]                             = 'Accounts/add_opening_balances';
    $route[ 'accounts/general-ledger' ]                                  = 'Accounts/general_ledger';
    $route[ 'accounts/delete-opening-balance/(:any)' ]                   = 'Accounts/delete_opening_balance/$1';
    $route[ 'accounts/search-transaction' ]                              = 'Accounts/search_transaction';
    $route[ 'accounts/supplier-invoices' ]                               = 'Accounts/supplier_invoices';
    $route[ 'accounts/trial-balance' ]                                   = 'Accounts/trial_balance';
    $route[ 'accounts/profit-loss-statement' ]                           = 'Accounts/profit_loss_statement';
    $route[ 'invoices/sale-invoice/(:any)' ]                             = 'Invoices/sale_invoice/$1';
    $route[ 'invoices/print-invoice/(:any)' ]                            = 'Invoices/print_invoice/$1';
    $route[ 'invoices/stock-return-invoice/(:any)' ]                     = 'Invoices/stock_return_invoice/$1';
    $route[ 'invoices/general-report' ]                                  = 'Invoices/general_report';
    $route[ 'invoices/stock-evaluation-report' ]                         = 'Invoices/stock_evaluation_report';
    $route[ 'invoices/store-stock-evaluation-report' ]                   = 'Invoices/store_stock_evaluation_report';
    $route[ 'invoices/stock-evaluation-report-sale-price' ]              = 'Invoices/stock_evaluation_report_sale_price';
    $route[ 'invoices/stock-evaluation-report-available-qty-report' ]    = 'Invoices/stock_evaluation_report_available_qty_report';
    $route[ 'invoices/threshold-report' ]                                = 'Invoices/threshold_report';
    $route[ 'invoices/expired-medicine-report' ]                         = 'Invoices/expired_medicine_report';
    $route[ 'invoices/purchase-order-invoice/(:any)' ]                   = 'Invoices/purchase_order_invoice/$1';
    $route[ 'invoices/lab-sale-invoice/(:any)' ]                         = 'Invoices/lab_sale_invoice/$1';
    $route[ 'invoices/test-result-invoice/(:any)' ]                      = 'Invoices/test_result_invoice/$1';
    $route[ 'invoices/ipd-test-result-invoice/(:any)' ]                  = 'Invoices/ipd_test_result_invoice/$1';
    $route[ 'invoices/stock-invoice/(:any)' ]                            = 'Invoices/stock_invoice/$1';
    $route[ 'invoices/profit-report' ]                                   = 'Invoices/profit_report/$1';
    $route[ 'invoices/profit-report-ipd-medication' ]                    = 'Invoices/profit_report_ipd_medication';
    $route[ 'invoices/consultancy-invoice/(:any)' ]                      = 'Invoices/consultancy_invoice/$1';
    $route[ 'invoices/prescription-invoice/(:any)' ]                     = 'Invoices/prescription_invoice/$1';
    $route[ 'invoices/detailed-stock-report' ]                           = 'Invoices/detailed_stock_report';
    $route[ 'invoices/opd-service-invoice/(:any)' ]                      = 'Invoices/opd_sale_invoice';
    $route[ 'invoices/consultancy-general-report' ]                      = 'Invoices/consultancy_general_report';
    $route[ 'invoices/consultancy-general-report-panel' ]                = 'Invoices/consultancy_general_report_panel';
    $route[ 'invoices/opd-general-report' ]                              = 'Invoices/opd_general_report';
    $route[ 'invoices/opd-general-report-panel' ]                        = 'Invoices/opd_general_report_panel';
    $route[ 'invoices/general-report-customer-return' ]                  = 'Invoices/general_report_customer_return';
    $route[ 'invoices/summary-report' ]                                  = 'Invoices/summary_report';
    $route[ 'invoices/general-ledger' ]                                  = 'Invoices/general_ledger';
    $route[ 'invoices/xray-report' ]                                     = 'Invoices/xray_report';
    $route[ 'invoices/lab-general-invoice' ]                             = 'Invoices/lab_general_invoice';
    $route[ 'invoices/regents-consumption-invoice' ]                     = 'Invoices/regents_consumption_invoice';
    $route[ 'invoices/regents-consumption-invoice-ipd' ]                 = 'Invoices/regents_consumption_invoice_ipd';
    $route[ 'invoices/lab-general-invoice-ipd' ]                         = 'Invoices/lab_general_invoice_ipd';
    $route[ 'invoices/bonus-stock-report' ]                              = 'Invoices/bonus_stock_report';
    $route[ 'invoices/form-wise-report' ]                                = 'Invoices/form_wise_report';
    $route[ 'invoices/form-wise-report-c' ]                              = 'Invoices/form_wise_report_c';
    $route[ 'invoices/ipd-invoice' ]                                     = 'Invoices/ipd_invoice';
    $route[ 'invoices/ipd-invoice-consolidated' ]                        = 'Invoices/ipd_invoice_consolidated';
    $route[ 'invoices/ipd-invoice-combined' ]                            = 'Invoices/ipd_invoice_combined';
    $route[ 'invoices/supplier-wise-report' ]                            = 'Invoices/supplier_wise_report';
    $route[ 'invoices/analysis-report' ]                                 = 'Invoices/analysis_report';
    $route[ 'invoices/internal-medicine-issuance' ]                      = 'Invoices/internal_medicine_issuance';
    $route[ 'invoices/internal-issuance-par-levels-report' ]             = 'Invoices/internal_issuance_par_levels_report';
    $route[ 'invoices/doctor-consultancy-report' ]                       = 'Invoices/doctor_consultancy_report';
    $route[ 'invoices/payment-invoice/(:any)/(:any)' ]                   = 'Invoices/payment_invoice/$1/$1';
    $route[ 'invoices/payments-invoice/(:any)' ]                         = 'Invoices/payments_invoice/$1';
    $route[ 'invoices/ipd-admission-slip/(:any)' ]                       = 'Invoices/ipd_admission_slip/$1';
    $route[ 'invoices/initial-deposit-invoice/(:any)' ]                  = 'Invoices/initial_deposit_invoice/$1';
    $route[ 'invoices/general-summary-report' ]                          = 'Invoices/general_summary_report';
    $route[ 'invoices/local-purchase' ]                                  = 'Invoices/local_purchase';
    $route[ 'invoices/ipd-lab-test/(:any)' ]                             = 'Invoices/ipd_lab_test/$1';
    $route[ 'invoices/ipd-lab-tests' ]                                   = 'Invoices/ipd_lab_tests';
    $route[ 'invoices/ipd-medication-invoices' ]                         = 'Invoices/ipd_medication_invoice';
    $route[ 'invoices/adjustment-invoice/(:any)' ]                       = 'Invoices/adjustment_invoice/$1';
    $route[ 'invoices/general-report-ipd-medication' ]                   = 'Invoices/general_report_ipd_medication';
    $route[ 'invoices/ipd-general-report-cash' ]                         = 'Invoices/ipd_general_report_cash';
    $route[ 'invoices/ipd-general-report-panel' ]                        = 'Invoices/ipd_general_report_panel';
    $route[ 'invoices/analysis-report-sale' ]                            = 'Invoices/analysis_report_sale';
    $route[ 'invoices/analysis-report-ipd-sale' ]                        = 'Invoices/analysis_report_ipd_sale';
    $route[ 'invoices/print-par-level/(:any)' ]                          = 'Invoices/print_par_level/$1';
    $route[ 'invoices/store-items' ]                                     = 'Invoices/store_items';
    $route[ 'invoices/discharge-summary-invoice/(:any)' ]                = 'Invoices/discharge_summary_invoice/$1';
    $route[ 'invoices/admission-order-invoice/(:any)' ]                  = 'Invoices/admission_order_invoice/$1';
    $route[ 'invoices/store-stock-invoice' ]                             = 'Invoices/store_stock_invoice';
    $route[ 'invoices/store-issuance-invoice' ]                          = 'Invoices/store_issuance_invoice';
    $route[ 'invoices/patient-invoice/(:any)' ]                          = 'Invoices/patient_invoice/$1';
    $route[ 'invoices/ultrasound-report' ]                               = 'Invoices/ultrasound_report';
    $route[ 'invoices/ipd-invoice-customer' ]                            = 'Invoices/ipd_customer_invoice';
    $route[ 'invoices/return-customer-invoice/(:any)' ]                  = 'Invoices/return_customer_invoice/$1';
    $route[ 'invoices/trial-balance-sheet' ]                             = 'Invoices/trial_balance_sheet';
    $route[ 'invoices/profit-loss-statement' ]                           = 'Invoices/profit_loss_statement';
    $route[ 'invoices/ipd-single-service/(:any)' ]                       = 'Invoices/ipd_single_service_invoice/$1';
    $route[ 'invoices/ot-timings' ]                                      = 'Invoices/ot_timings';
    $route[ 'medicines/edit-sale' ]                                      = 'Medicines/edit_sale';
    $route[ 'medicines/edit-adjustment' ]                                = 'Medicines/edit_adjustment';
    $route[ 'medicines/return-stock' ]                                   = 'Medicines/return_stock';
    $route[ 'medicines/return-customer' ]                                = 'Medicines/return_customer';
    $route[ 'medicines/delete-sale/(:any)' ]                             = 'Medicines/delete_sale/$1';
    $route[ 'medicines/delete-entire-sale/(:any)' ]                      = 'Medicines/delete_entire_sale/$1';
    $route[ 'medicines/local-purchase' ]                                 = 'Medicines/local_purchase';
    $route[ 'medicines/edit-return-customer' ]                           = 'Medicines/edit_return_customer';
    $route[ 'medicines/edit-local-purchase' ]                            = 'Medicines/edit_local_purchase';
    $route[ 'medicines/local-purchases' ]                                = 'Medicines/local_purchases';
    $route[ 'medicines/ipd-requisitions' ]                               = 'Medicines/ipd_requisitions';
    $route[ 'medicines/add-adjustments' ]                                = 'Medicines/add_adjustments';
    $route[ 'purchase-order/add' ]                                       = 'PurchaseOrder/add';
    $route[ 'purchase-order/index' ]                                     = 'PurchaseOrder/index';
    $route[ 'purchase-order/received/(:any)' ]                           = 'PurchaseOrder/received/$1';
    $route[ 'purchase-order/pending/(:any)' ]                            = 'PurchaseOrder/pending/$1';
    $route[ 'purchase-order/delete/(:any)' ]                             = 'PurchaseOrder/delete/$1';
    $route[ 'purchase-order/edit/(:any)' ]                               = 'PurchaseOrder/edit/$1';
    $route[ 'stock-return/stock-returns' ]                               = 'StockReturn/index';
    $route[ 'stock-return/add-stock-returns' ]                           = 'StockReturn/add';
    $route[ 'stock-return/edit/(:any)' ]                                 = 'StockReturn/edit/$1';
    $route[ 'stock-return/delete/(:any)' ]                               = 'StockReturn/delete/$1';
    $route[ 'stock-return/delete-return/(:any)' ]                        = 'StockReturn/delete_return/$1';
    $route[ 'reporting/general-report' ]                                 = 'Reporting/general_report';
    $route[ 'reporting/general-report-ipd-medication' ]                  = 'Reporting/general_report_ipd_medication';
    $route[ 'reporting/profit-report-ipd-medication' ]                   = 'Reporting/profit_report_ipd_medication';
    $route[ 'reporting/stock-valuation-report' ]                         = 'Reporting/stock_valuation_report';
    $route[ 'reporting/stock-valuation-report-sale-price' ]              = 'Reporting/stock_valuation_report_sale_price';
    $route[ 'reporting/threshold-report' ]                               = 'Reporting/threshold_report';
    $route[ 'reporting/expired-medicine-report' ]                        = 'Reporting/expired_medicine_report';
    $route[ 'reporting/lab-general-report' ]                             = 'Reporting/lab_general_reporting';
    $route[ 'reporting/lab-cash-balance-report' ]                        = 'Reporting/lab_cash_balance_report';
    $route[ 'reporting/lab-general-report-ipd' ]                         = 'Reporting/lab_general_reporting_ipd';
    $route[ 'reporting/regents-consumption-report' ]                     = 'Reporting/regents_consumption_report';
    $route[ 'reporting/regents-consumption-report-ipd' ]                 = 'Reporting/regents_consumption_report_ipd';
    $route[ 'reporting/profit-report' ]                                  = 'Reporting/profit_report';
    $route[ 'reporting/detailed-stock-report' ]                          = 'Reporting/detailed_stock_report';
    $route[ 'reporting/bonus-stock-report' ]                             = 'Reporting/bonus_stock_report';
    $route[ 'reporting/general-report-customer-return' ]                 = 'Reporting/general_report_customer_return';
    $route[ 'reporting/summary-report' ]                                 = 'Reporting/summary_report';
    $route[ 'reporting/form-wise-report' ]                               = 'Reporting/form_wise_report';
    $route[ 'reporting/supplier-wise-report' ]                           = 'Reporting/supplier_wise_report';
    $route[ 'reporting/analysis-report' ]                                = 'Reporting/analysis_report';
    $route[ 'reporting/analysis-report-sale' ]                           = 'Reporting/analysis_report_sale';
    $route[ 'reporting/analysis-report-ipd-sale' ]                       = 'Reporting/analysis_report_ipd_sale';
    $route[ 'reporting/internal-issuance-medicines-general-report' ]     = 'Reporting/internal_issuance_medicines_general_report';
    $route[ 'reporting/sale-report-against-supplier' ]                   = 'Reporting/sale_report_against_supplier';
    $route[ 'lab/sub-tests/(:any)' ]                                     = 'Lab/sub_tests/$1';
    $route[ 'lab/delete-sale/(:any)' ]                                   = 'Lab/delete_sale/$1';
    $route[ 'lab/edit-sale/(:any)' ]                                     = 'Lab/edit_sale/$1';
    $route[ 'lab/add-result' ]                                           = 'Lab/add_results';
    $route[ 'lab/add-results' ]                                          = 'Lab/add_result';
    $route[ 'lab/add-ipd-results' ]                                      = 'Lab/add_ipd_result';
    $route[ 'lab/add-ipd-test-result' ]                                  = 'Lab/add_results_ipd';
    $route[ 'lab/add-calibrations' ]                                     = 'Lab/add_calibrations';
    $route[ 'lab/delete-calibration/(:any)' ]                            = 'Lab/delete_calibration/$1';
    $route[ 'lab/edit-calibration/(:any)' ]                              = 'Lab/edit_calibration/$1';
    $route[ 'lab/search-sale' ]                                          = 'Lab/search_sale';
    $route[ 'lab/sales-panel' ]                                          = 'Lab/sales_panel';
    $route[ 'specialization/add-specialization' ]                        = 'Doctors/add_specialization';
    $route[ 'specialization/specializations' ]                           = 'Doctors/specializations';
    $route[ 'specialization/delete/(:any)' ]                             = 'Doctors/delete_specialization/$1';
    $route[ 'specialization/edit/(:any)' ]                               = 'Doctors/edit_specialization/$1';
    $route[ 'doctors/follow-up' ]                                        = 'Doctors/follow_up';
    $route[ 'doctors/add-follow-up' ]                                    = 'Doctors/add_follow_up';
    $route[ 'doctors/edit-follow-up/(:any)' ]                            = 'Doctors/edit_follow_up/$1';
    $route[ 'doctors/delete-follow-up/(:any)' ]                          = 'Doctors/delete_follow_up/$1';
    $route[ 'store/add-stock' ]                                          = 'Store/add_stock';
    $route[ 'store/edit-stock' ]                                         = 'Store/edit_stock';
    $route[ 'store/add-store-fix-assets' ]                               = 'Store/add_store_fix_assets';
    $route[ 'store/store-fix-assets' ]                                   = 'Store/store_fix_assets';
    $route[ 'store/edit-store-fix-asset/(:any)' ]                        = 'Store/edit_store_fix_assets/$1';
    $route[ 'ConsultancyReport/general-report' ]                         = 'ConsultancyReport/general_report';
    $route[ 'ConsultancyReport/general-report-1' ]                       = 'ConsultancyReport/general_report_1';
    $route[ 'ConsultancyReport/general-report-panel' ]                   = 'ConsultancyReport/general_report_panel';
    $route[ 'ConsultancyReport/doctor-consultancy-report' ]              = 'ConsultancyReport/doctor_consultancy_report';
    $route[ 'OpdReport/general-report' ]                                 = 'OpdReport/general_report';
    $route[ 'OpdReport/general-report-panel' ]                           = 'OpdReport/general_report_panel';
    $route[ 'StoreReporting/general-report' ]                            = 'StoreReporting/general_report';
    $route[ 'StoreReporting/stock-valuation' ]                           = 'StoreReporting/stock_valuation';
    $route[ 'internal-issuance/issue' ]                                  = 'InternalIssuance/issue';
    $route[ 'internal-issuance/issuance' ]                               = 'InternalIssuance/issuance';
    $route[ 'internal-issuance/delete-issuance/(:any)' ]                 = 'InternalIssuance/delete/$1';
    $route[ 'internal-issuance/edit-issuance' ]                          = 'InternalIssuance/edit';
    $route[ 'internal-issuance/delete-single-issuance/(:any)' ]          = 'InternalIssuance/delete_single_issuance/$1';
    $route[ 'internal-issuance/search-issuance' ]                        = 'InternalIssuance/search';
    $route[ 'radiology/x-ray/add-xray-report' ]                          = 'Radiology/add_xray_report';
    $route[ 'radiology/x-ray/xray-reports' ]                             = 'Radiology/xray_reports';
    $route[ 'radiology/x-ray/delete-xray-report/(:any)' ]                = 'Radiology/delete_xray_report/$1';
    $route[ 'radiology/x-ray/search-xray-report' ]                       = 'Radiology/search_xray_report';
    $route[ 'radiology/x-ray/verify-xray-report' ]                       = 'Radiology/verify_xray_report';
    $route[ 'radiology/x-ray/verify-ultrasound-report' ]                 = 'Radiology/verify_ultrasound_report';
    $route[ 'radiology/ultrasound/search-ultrasound-report' ]            = 'Radiology/search_ultrasound_report';
    $route[ 'radiology/ultrasound/add-ultrasound-report' ]               = 'Radiology/add_ultrasound_report';
    $route[ 'radiology/ultrasound/edit-ultrasound-report' ]              = 'Radiology/edit_ultrasound_report';
    $route[ 'radiology/ultrasound/ultrasound-reports' ]                  = 'Radiology/ultrasound_reports';
    $route[ 'radiology/ultrasound/delete-ultrasound-report/(:any)' ]     = 'Radiology/delete_ultrasound_report/$1';
    $route[ 'IPD/delete-sale/(:any)' ]                                   = 'IPD/delete_sale/$1';
    $route[ 'IPD/edit-sale' ]                                            = 'IPD/edit_sale';
    $route[ 'IPD/mo/add-admission-order' ]                               = 'IPD/add_admission_order';
    $route[ 'IPD/mo/mo-admission-orders' ]                               = 'IPD/mo_admission_orders';
    $route[ 'IPD/mo/delete-mo-order/(:any)' ]                            = 'IPD/delete_admission_order/$1';
    $route[ 'IPD/mo/edit-admission-order/(:any)' ]                       = 'IPD/edit_admission_order/$1';
    $route[ 'IPD/mo/delete-admission-order-order' ]                      = 'IPD/delete_admission_order_order';
    $route[ 'IPD/mo/add-physical-examination' ]                          = 'IPD/add_physical_examination';
    $route[ 'IPD/mo/all-physical-examination' ]                          = 'IPD/all_physical_examination';
    $route[ 'IPD/mo/delete-physical-examination/(:any)' ]                = 'IPD/delete_physical_examination/$1';
    $route[ 'IPD/mo/edit-physical-examination/(:any)' ]                  = 'IPD/edit_physical_examination/$1';
    $route[ 'IPD/mo/add-progress-notes' ]                                = 'IPD/add_progress_notes';
    $route[ 'IPD/mo/all-progress-notes' ]                                = 'IPD/all_progress_notes';
    $route[ 'IPD/mo/delete-progress-notes/(:any)' ]                      = 'IPD/delete_progress_notes/$1';
    $route[ 'IPD/mo/edit-progress-notes/(:any)' ]                        = 'IPD/edit_progress_notes/$1';
    $route[ 'IPD/mo/delete-progress-note/(:any)' ]                       = 'IPD/delete_progress_note/$1';
    $route[ 'IPD/mo/add-blood-transfusion' ]                             = 'IPD/add_blood_transfusion';
    $route[ 'IPD/mo/all-blood-transfusions' ]                            = 'IPD/all_blood_transfusion';
    $route[ 'IPD/mo/delete-blood-transfusion/(:any)' ]                   = 'IPD/delete_blood_transfusion/$1';
    $route[ 'IPD/mo/edit-blood-transfusion/(:any)' ]                     = 'IPD/edit_blood_transfusion/$1';
    $route[ 'IPD/mo/add-discharge-slip' ]                                = 'IPD/add_discharge_slip';
    $route[ 'IPD/mo/all-discharge-slips' ]                               = 'IPD/all_discharge_slips';
    $route[ 'IPD/mo/all-discharge-slips' ]                               = 'IPD/all_discharge_slips';
    $route[ 'IPD/discharge-patient/(:any)' ]                             = 'IPD/discharge_patient/$1';
    $route[ 'IPD/delete-payment/(:any)' ]                                = 'IPD/delete_payment/$1';
    $route[ 'IPD/mo/add-diagnostic-flow-sheet' ]                         = 'IPD/add_diagnostic_flow_sheet';
    $route[ 'IPD/mo/all-diagnostic-flow-sheet' ]                         = 'IPD/all_diagnostic_flow_sheet';
    $route[ 'IPD/mo/delete-diagnostic-flow-sheet/(:any)' ]               = 'IPD/delete_diagnostic_flow_sheet/$1';
    $route[ 'IPD/mo/edit-diagnostic-flow-sheet/(:any)' ]                 = 'IPD/edit_diagnostic_flow_sheet/$1';
    $route[ 'IPD/mo/delete-diagnostic/(:any)' ]                          = 'IPD/delete_diagnostic/$1';
    $route[ 'IPD/mo/add-discharge-summary' ]                             = 'IPD/add_discharge_summary';
    $route[ 'IPD/mo/all-discharge-summary' ]                             = 'IPD/all_discharge_summary';
    $route[ 'IPD/mo/delete-discharge-summary/(:any)' ]                   = 'IPD/delete_discharge_summary/$1';
    $route[ 'IPD/panel-sales' ]                                          = 'IPD/panel_sales';
    $route[ 'general-reporting/general-summary-report' ]                 = 'GeneralReporting/general_summary_report';
    $route[ 'ipd-reporting/general-report' ]                             = 'IPDReporting/general_report_cash';
    $route[ 'ipd-reporting/general-report-panel' ]                       = 'IPDReporting/general_report_panel';
    $route[ 'RadiologyReport/general-report-xray' ]                      = 'RadiologyReport/general_report_xray';
    $route[ 'RadiologyReport/general-report-ultrasound' ]                = 'RadiologyReport/general_report_ultrasound';
    $route[ 'invoices/general-report-xray' ]                             = 'Invoices/general_report_xray';
    $route[ 'invoices/general-report-ultrasound' ]                       = 'Invoices/general_report_ultrasound';
    $route[ 'invoices/sale-report-against-supplier' ]                    = 'Invoices/sale_report_against_supplier';
    $route[ 'invoices/print-salary-sheet/(:any)' ]                       = 'Invoices/print_salary_sheet/$1';
    $route[ 'invoices/salary-slips' ]                                    = 'Invoices/salary_slips';
    $route[ 'invoices/employee-loan-details' ]                           = 'Invoices/employee_loans';
    $route[ 'invoices/print-lab-single-invoice' ]                        = 'Invoices/print_lab_single_invoice';
    $route[ 'account-settings/index' ]                                   = 'AccountSettings/index';
    $route[ 'account-settings/add' ]                                     = 'AccountSettings/add';
    $route[ 'account-settings/delete/(:any)' ]                           = 'AccountSettings/delete/$1';
    $route[ 'account-settings/edit/(:any)' ]                             = 'AccountSettings/edit/$1';
    $route[ 'account-settings/financial-year' ]                          = 'AccountSettings/financial_year';
    $route[ 'accounts/balance-sheet' ]                                   = 'Accounts/balance_sheet';
    $route[ 'invoices/balance-sheet' ]                                   = 'Invoices/balance_sheet';
    $route[ 'medicines/return-customer-invoices' ]                       = 'Medicines/return_customer_invoices';
    $route[ 'StoreReporting/threshold-report' ]                          = 'StoreReporting/threshold_report';
    $route[ 'invoices/store-threshold-report' ]                          = 'Invoices/store_threshold_report';
    $route[ 'store/store-stock' ]                                        = 'Store/store_stock';
    $route[ 'ipd-reporting/consultant-commission' ]                      = 'IPDReporting/consultant_commission';
    $route[ 'ipd-reporting/ot-timings' ]                                 = 'IPDReporting/ot_timings';
    $route[ 'invoices/print-panel' ]                                     = 'Invoices/print_panel';
    $route[ 'settings/panel-status' ]                                    = 'Settings/panel_status';
    $route[ 'IPD/mo/edit-discharge-slip/(:any)' ]                        = 'IPD/edit_discharge_slip/$1';
    $route[ 'invoices/print-discharge-slip' ]                            = 'Invoices/print_discharge_slip';
    $route[ 'invoices/consultant-commission' ]                           = 'Invoices/consultant_commission';
    $route[ 'StoreReporting/purchase-report' ]                           = 'StoreReporting/purchase_report';
    $route[ 'invoices/purchase-report' ]                                 = 'Invoices/purchase_report';
    $route[ 'birth-certificates/index' ]                                 = 'BirthCertificates/index';
    $route[ 'birth-certificates/add' ]                                   = 'BirthCertificates/add';
    $route[ 'birth-certificates/edit' ]                                  = 'BirthCertificates/edit';
    $route[ 'birth-certificates/delete' ]                                = 'BirthCertificates/delete';
    $route[ 'invoices/birth-certificate' ]                               = 'Invoices/birth_certificate';
    $route[ 'settings/add-specimen' ]                                    = 'Settings/add_specimen';
    $route[ 'settings/edit-specimen/(:any)' ]                            = 'Settings/edit_specimen/$1';
    $route[ 'settings/delete-specimen/(:any)' ]                          = 'Settings/delete_specimen/$1';
    $route[ 'settings/remarks' ]                                         = 'Settings/remarks';
    $route[ 'settings/add-remarks' ]                                     = 'Settings/add_remarks';
    $route[ 'settings/edit-remarks/(:any)' ]                             = 'Settings/edit_remarks/$1';
    $route[ 'settings/delete-remarks/(:any)' ]                           = 'Settings/delete_remarks/$1';
    $route[ 'lab/edit-lab-sale-balance/(:any)' ]                         = 'Lab/edit_lab_sale_balance/$1';
    $route[ 'invoices/lab-cash-balance-report' ]                         = 'Invoices/lab_cash_balance_report';
    $route[ 'lab/airline-details' ]                                      = 'Lab/airline_details';
    $route[ 'lab/sale-pending-results' ]                                 = 'Lab/sale_pending_results';
    $route[ 'lab/all-added-test-results' ]                               = 'Lab/all_added_test_results';
    $route[ 'templates/add-xray-templates' ]                             = 'Templates/add_xray_templates';
    $route[ 'templates/edit-xray-template' ]                             = 'Templates/edit_xray_templates';
    $route[ 'templates/xray-templates' ]                                 = 'Templates/xray_templates';
    $route[ 'templates/delete-xray-template' ]                           = 'Templates/delete_xray_templates';
    $route[ 'settings/add-airlines' ]                                    = 'Settings/add_airlines';
    $route[ 'settings/edit-airline/(:any)' ]                             = 'Settings/edit_airlines/$1';
    $route[ 'settings/delete-airline/(:any)' ]                           = 'Settings/delete_airlines/$1';
    $route[ 'templates/culture-templates' ]                              = 'Templates/culture_templates';
    $route[ 'templates/add-culture-templates' ]                          = 'Templates/add_culture_templates';
    $route[ 'templates/edit-culture-template' ]                          = 'Templates/edit_culture_templates';
    $route[ 'templates/delete-culture-template' ]                        = 'Templates/delete_culture_templates';
    $route[ 'templates/histopathology-templates' ]                       = 'Templates/histopathology_templates';
    $route[ 'templates/add-histopathology-templates' ]                   = 'Templates/add_histopathology_templates';
    $route[ 'templates/edit-histopathology-template' ]                   = 'Templates/edit_histopathology_templates';
    $route[ 'templates/delete-histopathology-template' ]                 = 'Templates/delete_histopathology_templates';
    $route[ 'culture/culture/add' ]                                      = 'Culture/add';
    $route[ 'culture/culture/reports' ]                                  = 'Culture/index';
    $route[ 'culture/culture/edit' ]                                     = 'Culture/edit';
    $route[ 'culture/culture/search' ]                                   = 'Culture/edit';
    $route[ 'culture/culture/delete/(:any)' ]                            = 'Culture/delete/$1';
    $route[ 'invoices/culture-report' ]                                  = 'Invoices/culture_report';
    $route[ 'histopathology/histopathology/add' ]                        = 'Histopathology/add';
    $route[ 'histopathology/histopathology/reports' ]                    = 'Histopathology/index';
    $route[ 'histopathology/histopathology/edit' ]                       = 'Histopathology/edit';
    $route[ 'histopathology/histopathology/search' ]                     = 'Histopathology/edit';
    $route[ 'histopathology/histopathology/delete/(:any)' ]              = 'Histopathology/delete/$1';
    $route[ 'invoices/histopathology-report' ]                           = 'Invoices/histopathology_report';
    $route[ 'ChReport/general-report-culture' ]                          = 'ChReport/general_report_culture';
    $route[ 'ChReport/general-report-histopathology' ]                   = 'ChReport/general_report_histopathology';
    $route[ 'invoices/general-report-culture' ]                          = 'Invoices/general_report_culture';
    $route[ 'invoices/general-report-histopathology' ]                   = 'Invoices/general_report_histopathology';
    $route[ 'templates/antibiotic-susceptibility' ]                      = 'Templates/antibiotic_susceptibility';
    $route[ 'templates/add-antibiotic-susceptibility' ]                  = 'Templates/add_antibiotics';
    $route[ 'templates/edit-antibiotic-susceptibility' ]                 = 'Templates/edit_antibiotics';
    $route[ 'templates/delete-antibiotic-susceptibility' ]               = 'Templates/delete_antibiotics';
    $route[ 'invoices/test-results-report' ]                             = 'Invoices/test_results_report';
    $route[ 'reporting/test-prices-report' ]                             = 'Reporting/test_prices_report';
    $route[ 'invoices/test-prices-report' ]                              = 'Invoices/test_prices_report';
    $route[ 'settings/add-packages' ]                                    = 'Settings/add_packages';
    $route[ 'settings/edit-packages/(:any)' ]                            = 'Settings/edit_packages/$1';
    $route[ 'settings/delete-lab-package-test' ]                         = 'Settings/delete_lab_package_test';
    $route[ 'settings/delete-packages/(:any)' ]                          = 'Settings/delete_package/$1';
    $route[ 'lab/sale-package' ]                                         = 'Lab/sale_package';
    $route[ 'lab/load-lab-tests' ]                                       = 'Lab/load_lab_tests';
    $route[ 'lab/visible-to-admin-only/(:any)' ]                         = 'Lab/visible_to_admin_only/$1';
    $route[ 'medical-tests/index' ]                                       = 'MedicalTests/index';
    $route[ 'medical-tests/add' ]                                        = 'MedicalTests/add';
    $route[ 'medical-tests/add-general-info' ]                           = 'MedicalTests/add_general_info';
    $route[ 'medical-tests/edit/(:any)' ]                                = 'MedicalTests/edit/$1';

    $route['MedicalTests/get_template']                                     = 'MedicalTests/get_template';



    $route[ 'medical-tests/edit-general-info/(:any)' ]                   = 'MedicalTests/edit_general_info/$1';
    $route[ 'medical-tests/upsert-history/(:any)' ]                      = 'MedicalTests/upsert_history/$1';
    $route[ 'medical-tests/upsert-general-physical-examination/(:any)' ] = 'MedicalTests/upsert_general_physical_examination/$1';
    $route[ 'medical-tests/add-lab-investigation/(:any)' ]               = 'MedicalTests/add_lab_investigation/$1';
    $route[ 'medical-tests/destroy/(:any)' ]                             = 'MedicalTests/destroy/$1';
    $route[ 'medical-tests/status/(:any)' ]                              = 'MedicalTests/status/$1';
    $route[ 'medical-tests/validate-cnic' ]                              = 'MedicalTests/validate_cnic';
    $route[ 'medical-tests/report' ]                                     = 'MedicalTests/report';
    $route[ 'invoices/medical-test/(:any)' ]                             = 'Invoices/medical_test_report/$1';
    $route[ 'invoices/medical-receipt/(:any)' ]                          = 'Invoices/medical_test_receipt/$1';
    $route[ 'invoices/medical-test-report' ]                             = 'Invoices/medical_test_reports';
    $route[ 'invoices/medical-test-ticket/(:any)' ]                      = 'Invoices/medical_test_ticket/$1';
    $route[ 'medical-test-settings/oep/index' ]                          = 'MedicalTestSettings/all_oep';
    $route[ 'medical-test-settings/oep/create' ]                         = 'MedicalTestSettings/add_oep';
    $route[ 'medical-test-settings/oep/edit/(:any)' ]                    = 'MedicalTestSettings/edit_oep/$1';
    $route[ 'medical-test-settings/oep/destroy/(:any)' ]                 = 'MedicalTestSettings/delete_oep/$1';
   

 
    $route['medical-test/template/add']                                   = 'MedicalTestTemplates/add_lab_template';
    $route['medical-test-settings/template/create']                       = 'MedicalTestTemplates/store_lab_template';
    $route['medical-test/all/templates']                                  = 'MedicalTestTemplates/all_lab_templates';
    $route['medical-test-settings/template/edit/(:any)' ]                 = 'MedicalTestTemplates/edit_template/$1';
    $route['medical-test/template/delete/(:any)']                         = 'MedicalTestTemplates/delete_template/$1';
    $route['medical-test-settings/template/update']                       = 'MedicalTestTemplates/update_template';
    $route['medical-test/template/duplicate/(:any)']                      = 'MedicalTestTemplates/duplicate_template/$1';





   
   
   
   
   
   
    $route[ 'settings/add-references' ]                                  = 'Settings/add_references';
    $route[ 'settings/delete-reference/(:any)' ]                         = 'Settings/delete_reference/$1';
    $route[ 'settings/edit-reference/(:any)' ]                           = 'Settings/edit_reference/$1';
    $route[ 'lab/all-refer-outside' ]                                    = 'Lab/all_refer_outside';
    $route[ 'lab/add-refer-outside' ]                                    = 'Lab/add_refer_outside';
    $route[ 'lab/delete-outside-refer/(:any)' ]                          = 'Lab/delete_refer_outside/$1';
    $route[ 'invoices/outside-refer-invoice/(:any)' ]                    = 'Invoices/outside_refer_invoice/$1';
    $route[ 'lab/edit-reference/(:any)' ]                                = 'Lab/edit_reference/$1';
    $route[ '404_override' ]                                             = '';
    $route[ 'translate_uri_dashes' ]                                     = FALSE;

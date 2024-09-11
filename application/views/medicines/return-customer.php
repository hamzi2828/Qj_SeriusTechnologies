<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <?php if(validation_errors() != false) { ?>
            <div class="alert alert-danger validation-errors">
                <?php echo validation_errors(); ?>
            </div>
        <?php } ?>
        <?php if($this -> session -> flashdata('error')) : ?>
            <div class="alert alert-danger">
                <?php echo $this -> session -> flashdata('error') ?>
            </div>
        <?php endif; ?>
        <?php if($this -> session -> flashdata('response')) : ?>
            <div class="alert alert-success">
                <?php echo $this -> session -> flashdata('response') ?>
            </div>
        <?php endif; ?>
        <form method="post">
            <div class="form-group col-lg-4">
                <label for="exampleInputEmail1">Account Head</label>
                <select name="supplier_id" class="form-control select2me" required="required">
                    <option value="<?php echo return_customer ?>" selected="selected">
                        <?php echo get_account_head ( return_customer) -> title ?>
                    </option>
			        <?php
			        /*if(count($suppliers) > 0) {
				        foreach ($suppliers as $supplier) {
					        ?>
                            <option value="<?php echo $supplier -> id ?>" <?php if($supplier -> id == return_customer) echo 'selected="selected"' ?>>
						        <?php echo $supplier -> title ?>
                            </option>
					        <?php
				        }
			        }*/
			        ?>
                </select>
            </div>
            <div class="form-group col-lg-4">
                <label for="exampleInputEmail1">Auto System Invoice</label>
                <input type="text" name="supplier_invoice" readonly="readonly" class="form-control" value="<?php echo unique_id(4); ?>">
            </div>
            <div class="form-group col-lg-4">
                <label for="exampleInputEmail1">Date</label>
                <input type="text" name="date_added" class="form-control date-picker" value="<?php echo date('m/d/Y') ?>">
            </div>
        <!-- BEGIN SAMPLE FORM PORTLET-->
            <div class="portlet box blue">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-reorder"></i> Customer Return Stock Without Slip
                    </div>
                </div>
                <div class="portlet-body form">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" id="csrf_token">
                    <input type="hidden" name="action" value="do_return_customer">
                    <div class="form-body">
                    <?php for ($i = 1; $i <= 5; $i++) : ?>
                        <div class="row">
                            <div class="form-group col-lg-3">
                                <label for="exampleInputEmail1">Medicine</label>
                                <select name="medicine_id[]" class="form-control select2me" onchange="get_medicine_last_return_record(this.value, <?php echo $i ?>)">
                                    <option value="">Select Medicine</option>
                                    <?php
                                    if(count($medicines) > 0) {
                                        foreach ($medicines as $medicine) {
                                            if($medicine -> strength_id > 1)
                                                $strength = get_strength($medicine -> strength_id) -> title;
                                            else
                                                $strength = '';
                                            if($medicine -> form_id > 1)
                                                $form = get_form($medicine -> form_id) -> title;
                                            else
                                                $form = '';
                                            ?>
                                            <option value="<?php echo $medicine -> id ?>">
                                                <?php
                                                echo $medicine -> name . ' ' . $strength . ' ' . $form;
                                                ?>
                                            </option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group col-lg-1">
                                <label for="exampleInputEmail1">Batch</label>
                                <input type="text" name="batch[]" readonly="readonly" class="form-control" value="<?php echo str_pad(rand(0, pow(10, 4)-1), 4, '0', STR_PAD_LEFT); ?>">
                            </div>
                            <div class="form-group col-lg-2">
                                <label for="exampleInputEmail1">Expiry Date</label>
                                <input type="text" name="expiry_date[]" class="form-control date-picker">
                            </div>
                            <div class="form-group col-lg-1">
                                <label for="exampleInputEmail1">Quantity</label>
                                <input type="text" name="quantity[]" class="form-control">
                            </div>
                            <div class="form-group col-lg-2">
                                <label for="exampleInputEmail1">Purchase/Unit</label>
                                <input type="text" name="tp_unit[]" class="form-control tp-unit-<?php echo $i ?>">
                            </div>
                            <div class="form-group col-lg-1">
                                <label for="exampleInputEmail1">Sale/Unit</label>
                                <input type="text" name="sale_unit[]" class="form-control sale-unit-<?php echo $i ?>">
                            </div>
                            <div class="form-group col-lg-2">
                                <label for="exampleInputEmail1">Paid To Customer</label>
                                <input type="text" name="paid_to_customer[]" class="form-control paid-to-customer paid-customer-<?php echo $i ?>" onchange="calculate_paid_to_customer()">
                            </div>
                        </div>
                    <?php endfor; ?>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="col-lg-offset-9 col-lg-1"><p class="text-right" style="padding-top: 9px;font-weight: 600">G.Total</p></div>
                                <div class="col-lg-2" style="padding-right: 0; padding-left: 25px">
                                    <input type="text" class="form-control" readonly="readonly" id="total">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn blue" id="sales-btn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>
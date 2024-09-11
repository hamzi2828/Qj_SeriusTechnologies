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
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-reorder"></i> Add Return Stock
                </div>
            </div>
            <div class="portlet-body form">
                <div class="alert alert-danger expiry-response" style="display: none"></div>
                <div class="alert alert-danger type-response" style="display: none"></div>
                <form role="form" method="post" autocomplete="off">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" id="csrf_token">
                    <input type="hidden" name="action" value="do_add_return_stock">
                    <div class="form-body" style="overflow: auto; background: transparent">
                        <div class="form-group col-lg-6">
                            <label for="exampleInputEmail1">Supplier</label>
                            <select name="supplier_id" class="form-control select2me" required="required" id="supplier_id">
                                <option value="">Select Supplier</option>
                                <?php
                                if(count($suppliers) > 0) {
                                    foreach ($suppliers as $supplier) {
                                        ?>
                                        <option value="<?php echo $supplier -> id ?>">
                                            <?php echo $supplier -> title ?>
                                        </option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="exampleInputEmail1">Invoice#</label>
                            <input type="text" class="form-control" name="invoice" onchange="check_invoice_exists(this.value)">
                        </div>
                        <?php for($return = 1; $return <= 5; $return++) : ?>
                        <div class="sale-<?php echo $return ?> sale-fields">
                            <div class="form-group col-lg-4">
                                <label for="exampleInputEmail1">Medicine</label>
                                <select name="medicine_id[]" class="form-control select2me" onchange="get_stock_for_return(this.value, <?php echo $return ?>)">
                                    <option value="">Select Medicine</option>
                                    <?php
                                    if(count($medicines) > 0) {
                                        foreach ($medicines as $medicine) {
                                            ?>
                                            <option value="<?php echo $medicine -> id ?>">
                                                <?php echo $medicine -> name ?> (<?php echo get_form($medicine -> form_id) -> title ?> - <?php echo get_strength($medicine -> strength_id) -> title ?>)
                                            </option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group col-lg-2">
                                <label for="exampleInputEmail1">Batch</label>
                                <div class="batch">
                                    <input type="text" class="form-control" readonly="readonly">
                                </div>
                            </div>
                            <div class="form-group col-lg-1">
                                <label for="exampleInputEmail1">Available</label>
                                <input type="text" class="form-control" readonly="readonly" id="available-qty">
                            </div>
                            <div class="form-group col-lg-1">
                                <label for="exampleInputEmail1">Return Qty</label>
                                <input type="text" class="form-control" name="return_qty[]" onkeyup="calculate_net_price_return_stock(this.value, <?php echo $return ?>)">
                            </div>
                            <div class="form-group col-lg-2">
                                <label for="exampleInputEmail1">Cost/Unit</label>
                                <input type="text" class="form-control" name="cost_unit[]" id="price">
                            </div>
                            <div class="form-group col-lg-2">
                                <label for="exampleInputEmail1">Net Price</label>
                                <input type="text" class="form-control net-price" readonly="readonly" name="net_price[]">
                            </div>
                        </div>
                        <?php endfor; ?>
                        <div class="col-lg-1 col-lg-offset-9">
                            <strong class="total-net-price">Total</strong>
                        </div>
                        <div class="col-lg-2">
                            <input type="text" name="total" id="total-net-price" readonly="readonly" class="form-control grand_total">
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn blue" id="return-btn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>
<style>
    .total-net-price {
        float: right;
        padding-top: 8px;
        font-size: 16px;
    }
    .sale-fields {
        width: 100%;
        display: block;
        float: left;
    }
</style>
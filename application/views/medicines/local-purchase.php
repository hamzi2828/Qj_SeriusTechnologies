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
            <div class="form-group col-lg-6">
                <label for="exampleInputEmail1">Supplier Invoice</label>
                <input type="text" name="supplier_invoice" readonly="readonly" class="form-control" value="<?php echo unique_id(4); ?>">
            </div>
            <div class="form-group col-lg-6">
                <label for="exampleInputEmail1">Date</label>
                <input type="text" name="date_added" class="form-control date-picker" value="<?php echo date('m/d/Y') ?>">
            </div>
        <!-- BEGIN SAMPLE FORM PORTLET-->
            <div class="portlet box blue">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-reorder"></i> Local Purchase
                    </div>
                </div>
                <div class="portlet-body form">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" id="csrf_token">
                    <input type="hidden" name="action" value="do_add_local_purchase">
                    <div class="form-body">
                    <?php for ($i = 1; $i <= 5; $i++) : ?>
                        <div class="row">
                            <div class="form-group col-lg-2">
                                <label for="exampleInputEmail1">Medicine</label>
                                <select name="medicine_id[]" class="form-control select2me">
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
                                <input type="text" name="batch[]" readonly="readonly" class="form-control" value="<?php echo unique_id(4); ?>">
                            </div>
                            <div class="form-group col-lg-2">
                                <label for="exampleInputEmail1">Expiry Date</label>
                                <input type="text" name="expiry_date[]" class="form-control date-picker">
                            </div>
                            <div class="form-group col-lg-1">
                                <label for="exampleInputEmail1">Box QTY.</label>
                                <input type="number" name="box_qty[]" class="form-control" id="box-qty-1" min="1">
                            </div>
                            <div class="form-group col-lg-1">
                                <label for="exampleInputEmail1">T.Units</label>
                                <input type="text" name="quantity[]" class="form-control t-units-<?php echo $i ?>" >
                            </div>
                            <div class="form-group col-lg-1">
                                <label for="exampleInputEmail1">Purchase/Unit</label>
                                <input type="text" name="tp_unit[]" class="form-control purchase-per-unit-<?php echo $i ?>" onchange="calculate_net_local_purchase(<?php echo $i ?>)">
                            </div>
<!--                            onchange="calculate_total_purchase_price()"-->
                            <div class="form-group col-lg-1">
                                <label for="exampleInputEmail1">P.Total</label>
                                <input type="text" readonly="readonly" class="form-control purchase-total purchase-total-<?php echo $i ?>">
                            </div>
                            <div class="form-group col-lg-1">
                                <label for="exampleInputEmail1">Sale/Unit</label>
                                <input type="text" name="sale_unit[]" class="form-control">
                            </div>
                            <div class="form-group col-lg-2">
                                <label for="exampleInputEmail1">Description</label>
                                <textarea rows="5" name="description[]" class="form-control"></textarea>
                            </div>
                        </div>
                    <?php endfor; ?>
                        <div class="row">
                            <div class="col-lg-offset-6 col-lg-3 text-right" style="padding-top: 8px;">
                                <strong>G. Total:</strong>
                            </div>
                            <div class="col-lg-3">
                                <input type="text" class="form-control net_amount" readonly="readonly">
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
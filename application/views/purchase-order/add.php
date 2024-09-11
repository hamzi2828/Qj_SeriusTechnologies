<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <?php if ( validation_errors () != false ) { ?>
            <div class="alert alert-danger validation-errors">
                <?php echo validation_errors (); ?>
            </div>
        <?php } ?>
        <?php if ( $this -> session -> flashdata ( 'error' ) ) : ?>
            <div class="alert alert-danger">
                <?php echo $this -> session -> flashdata ( 'error' ) ?>
            </div>
        <?php endif; ?>
        <?php if ( $this -> session -> flashdata ( 'response' ) ) : ?>
            <div class="alert alert-success">
                <?php echo $this -> session -> flashdata ( 'response' ) ?>
            </div>
        <?php endif; ?>
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-reorder"></i> Add Purchase Order
                </div>
            </div>
            <div class="portlet-body" style="overflow: auto;overflow-x: hidden;">
                <form role="form" method="post" autocomplete="off">
                    <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                           value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
                    <input type="hidden" name="action" value="do_add_purchase_order">
                    <input type="hidden" id="added" value="1">
                    
                    <div class="row">
                        <div class="form-group col-lg-offset-3 col-lg-6">
                            <label for="exampleInputEmail1">Supplier</label>
                            <select name="supplier_id" class="form-control select2me" required="required" <?php if (isset($_GET['supplier-list']) and $_GET['supplier-list'] == 'true') : ?>onchange="get_low_threshold_medicines(this.value)" <?php endif ?>>
                                <option value="">Select Supplier</option>
                                <?php
                                    if ( count ( $suppliers ) > 0 ) {
                                        foreach ( $suppliers as $supplier ) {
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
                    </div>
                    <div class="low-threshold-medicines"></div>
                    <div class="form-group col-lg-4">
                        <label for="exampleInputEmail1">Medicine</label>
                        <select name="medicine_id[]" class="form-control select2me"
                                onchange="get_medicine_threshold_value(this.value, 1)">
                            <option value="">Select Medicine</option>
                            <?php
                                if ( count ( $medicines ) > 0 ) {
                                    foreach ( $medicines as $medicine ) {
                                        ?>
                                        <option value="<?php echo $medicine -> id ?>">
                                            <?php
                                                echo $medicine -> name . ' ' . get_strength ( $medicine -> strength_id ) -> title . ' (' . get_form ( $medicine -> form_id ) -> title . ')';
                                            ?>
                                        </option>
                                        <?php
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group col-lg-1">
                        <label for="exampleInputEmail1">Pack Size</label>
                        <input type="text" class="form-control pack-size-1" readonly="readonly">
                    </div>
                    <div class="form-group col-lg-1">
                        <label for="exampleInputEmail1">Available (Unit)</label>
                        <input type="text" class="form-control available-1" readonly="readonly">
                    </div>
                    <div class="form-group col-lg-1">
                        <label for="exampleInputEmail1">Threshold (Unit)</label>
                        <input type="text" class="form-control threshold-1" readonly="readonly">
                    </div>
                    <div class="form-group col-lg-2">
                        <label for="exampleInputEmail1">Order Qty (Box)</label>
                        <input type="number" name="box_qty[]" class="form-control quantity-1"
                               onchange="calculate_purchase_order_total_by_quantity(this.value, 1)">
                    </div>
                    <div class="form-group col-lg-1">
                        <label for="exampleInputEmail1">TP/Box</label>
                        <input type="text" name="tp[]" class="form-control tp-1"
                               onchange="calculate_purchase_order_total(this.value, 1)" readonly="readonly">
                    </div>
                    <div class="form-group col-lg-2">
                        <label for="exampleInputEmail1">App Amount</label>
                        <input type="text" name="total[]" class="form-control total-1 net-total">
                    </div>
                    <div class="add-more-purchase-order"></div>
                    <div class="form-group col-lg-offset-9 col-lg-3">
                        <label for="exampleInputEmail1"><b>Net Amount</b></label>
                        <input type="text" name="net_amount" class="form-control net_amount" value="0"
                               readonly="readonly">
                    </div>
                    <div class="form-actions col-lg-12">
                        <button type="submit" class="btn blue" id="submit-btn">Submit</button>
                        <button type="button" class="btn purple" onclick="add_more_purchase_order()">Add More</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>
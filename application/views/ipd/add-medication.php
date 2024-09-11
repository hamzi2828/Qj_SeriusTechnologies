<form role="form" method="post" autocomplete="off">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" id="csrf_token">
    <input type="hidden" name="selected" value="" id="selected_batch">
    <input type="hidden" name="action" value="do_add_ipd_medication">
    <input type="hidden" id="added" value="<?php echo count($medication); ?>">
    <input type="hidden" name="sale_id" value="<?php echo $sale -> sale_id ?>">
    <input type="hidden" name="patient_id" value="<?php echo $sale -> patient_id ?>">
    <input type="hidden" name="deleted_medication" id="deleted_medication">
    <div class="form-body" style="overflow:auto;">
        <div class="form-group col-lg-4">
            <label for="exampleInputEmail1">Patient EMR#</label>
            <input type="text" name="patient_id" class="form-control" placeholder="Add patient EMR#" autofocus="autofocus" value="<?php echo $sale -> patient_id ?>" required="required" onchange="get_patient(this.value)" readonly="readonly">
        </div>
        <div class="form-group col-lg-4">
            <label for="exampleInputEmail1">Name</label>
            <input type="text" class="form-control name" id="patient-name" readonly="readonly" value="<?php echo get_patient($sale -> patient_id) -> name ?>">
        </div>
        <div class="form-group col-lg-4">
            <label for="exampleInputEmail1">CNIC</label>
            <input type="text" class="form-control cnic" id="patient-cnic" readonly="readonly" value="<?php echo get_patient($sale -> patient_id) -> cnic ?>">
        </div>
        <div class="sale-0 sale-fields">
            <div class="form-group col-lg-3">
                <label for="exampleInputEmail1">Medicine</label>
                <select name="medicine_id[]" class="form-control medicines-list-0 select2me" required="required"
                        onchange="get_stock(this.value, 0)">
                    <option value="">Select Medicine</option>
                    <?php
                    if (count($medicines) > 0) {
                        foreach ($medicines as $medicine) {
                            ?>
                            <option value="<?php echo $medicine->id ?>">
                                <?php echo $medicine->name ?>
                                <?php if ($medicine->form_id > 1 or $medicine->strength_id > 1) : ?>
                                    (<?php echo get_form($medicine->form_id)->title ?> - <?php echo get_strength($medicine->strength_id)->title ?>)
                                <?php endif ?>
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
            <div class="form-group col-lg-2">
                <label for="exampleInputEmail1">Sale Qty.</label>
                <input type="text" class="form-control" name="quantity[]"
                       onchange="calculate_net_ipd_medication_price(this.value, 0)" id="quantity"
                       required="required">
            </div>
            <div class="form-group col-lg-2">
                <label for="exampleInputEmail1">Price</label>
                <input type="text" class="form-control" readonly="readonly" name="price[]" id="price">
            </div>
            <div class="form-group col-lg-2">
                <label for="exampleInputEmail1">Net Price</label>
                <input type="text" class="form-control net-price" readonly="readonly" name="net_price[]"
                       value="">
            </div>
        </div>
    <div id="sale-more-ipd-medicine"></div>
    </div> <br>
    <div class="row">
        <div class="form-group col-lg-offset-9 col-lg-3">
            <label for="exampleInputEmail1">Medication Section Total</label>
            <div class="doctor">
                <input type="text" class="form-control" value="<?php echo number_format ($total_medication, 2) ?>" readonly="readonly">
            </div>
        </div>
    </div>
    <div class="">
        <div class="row">
            <div class="form-group col-lg-offset-9 col-lg-3">
                <label for="exampleInputEmail1">Total</label>
                <div class="doctor">
                    <input type="text" class="total form-control" name="total" value="<?php echo $sale_billing -> total ?>" readonly="readonly">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-lg-offset-9 col-lg-3">
                <label for="exampleInputEmail1">Discount <small>(Flat)</small></label>
                <div class="doctor">
                    <input type="text" class="discount form-control" onchange="calculate_ipd_net_bill()" name="discount" value="<?php echo $sale_billing -> discount ?>" readonly="readonly">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-lg-offset-9 col-lg-3">
                <label for="exampleInputEmail1">Net Total</label>
                <div class="doctor">
                    <input type="text" class="net-total form-control" name="net_total" value="<?php echo $sale_billing -> net_total ?>" readonly="readonly">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-lg-offset-9 col-lg-3">
                <label for="exampleInputEmail1">Initial Deposit</label>
                <div class="doctor">
                    <input type="text" class="form-control" name="initial_deposit" value="<?php echo $sale_billing -> initial_deposit ?>">
                </div>
            </div>
        </div>
    </div>
    <div class="form-actions">
        <button type="submit" class="btn blue" id="sales-btn">Update</button>
        <button type="button" class="btn green" onclick="add_more_ipd_medication_sale()">Add More</button>
    </div>
</form>
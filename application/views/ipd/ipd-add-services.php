<form role="form" method="post" autocomplete="off">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" id="csrf_token">
    <input type="hidden" name="action" value="do_add_ipd_services">
    <input type="hidden" id="added" value="<?php echo count($ipd_associated_services) ?>">
    <input type="hidden" name="sale_id" value="<?php echo $sale -> sale_id ?>">
    <input type="hidden" name="patient_id" value="<?php echo $sale -> patient_id ?>">
    <input type="hidden" name="deleted_ipd_services" id="deleted_ipd_services">
    <div class="form-body" style="overflow:auto;">
        <div class="form-group col-lg-4">
            <label for="exampleInputEmail1">Patient EMR#</label>
            <input type="text" name="patient_id" class="form-control" placeholder="Add patient EMR#" autofocus="autofocus" value="<?php echo $sale -> patient_id ?>" required="required" onchange="get_patient(this.value)" readonly="readonly" id="patient_id">
        </div>
        <div class="form-group col-lg-4">
            <label for="exampleInputEmail1">Name</label>
            <input type="text" class="form-control name" id="patient-name" readonly="readonly" value="<?php echo get_patient($sale -> patient_id) -> name ?>">
        </div>
        <div class="form-group col-lg-4">
            <label for="exampleInputEmail1">CNIC</label>
            <input type="text" class="form-control cnic" id="patient-cnic" readonly="readonly" value="<?php echo get_patient($sale -> patient_id) -> cnic ?>">
        </div>
        <div class="assign-services">
            <div class="service-0" style="display: block;float: left;width: 100%;">
                <div class="form-group col-lg-3">
                    <label for="exampleInputEmail1">Service</label>
                    <select name="service_id[]" class="form-control select2me"
                            onchange="get_service_parameters(this.value, 0)">
                        <option value="">Select</option>
                        <?php
                        if (count($services) > 0) {
                            foreach ($services as $service) {
                                $has_parent = check_if_service_has_child($service->id);
                                ?>
                                <option value="<?php echo $service->id ?>" class="<?php if ($has_parent)
                                    echo 'has-child' ?>">
                                    <?php echo $service->title ?>
                                </option>
                                <?php
                                echo get_sub_child($service->id, false, 0, $patient -> panel_id);
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="parameters"></div>
            </div>
            <div class="assign-more-services" style="display: block;float: left;width: 100%;"></div>
        </div>
    </div> <br>
    <div class="row">
        <div class="form-group col-lg-offset-9 col-lg-3">
            <label for="exampleInputEmail1">IPD Section Total</label>
            <div class="doctor">
                <input type="text" class="form-control" value="<?php echo get_ipd_services_total ($sale -> sale_id) ?>"
                       readonly="readonly">
            </div>
        </div>
    </div>
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
    <div class="form-actions">
        <button type="submit" class="btn blue">Update</button>
        <button type="button" class="btn green" onclick="add_more_ipd_sale_services(<?php echo $patient -> panel_id ?>)">Add More</button>
    </div>
</form>
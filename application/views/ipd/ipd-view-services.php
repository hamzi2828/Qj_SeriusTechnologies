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
            <?php
            $ipd_total  = 0;
            $c = 0;
            if(count($ipd_associated_services)) {
                $counter    = 0;
                foreach ($ipd_associated_services as $ipd_associated_service) {
                    $c++;
                    $ipd_total = $ipd_total + $ipd_associated_service -> net_price;
                    $assigned_by = get_user ($ipd_associated_service -> user_id);
                    ?>
                    <input type="hidden" name="ipd_service_id[]" value="<?php echo $ipd_associated_service -> id ?>">
                    <div class="service-<?php echo $counter ?>" style="display: block;float: left;width: 100%;">
                        <div class="form-group col-lg-3">
                            <div class="counter"><?php echo $c ?></div>
                            <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'delete_added_ipd_services', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                <a href="javascript:void(0)" onclick="remove_ipd_row(<?php echo $counter ?>, <?php echo $ipd_associated_service -> id ?>)">
                                    <i class="fa fa-trash"></i>
                                </a>
                            <?php endif; ?>
                            <a href="<?php echo base_url ('/invoices/ipd-single-service/'.$ipd_associated_service -> id) ?>">
                                <i class="fa fa-print"></i>
                            </a>
                            <label for="exampleInputEmail1">Service</label>
                            <label class="pull-right" style="font-size: 12px; font-style: italic; margin-bottom: 0; padding-top: 7px;">
                                <?php echo date_setter ( $ipd_associated_service -> date_added ) ?> <br/>
                                <?php echo $assigned_by -> name ?>
                            </label>
                            <input type="hidden" name="service_id[]" value="<?php echo $ipd_associated_service -> service_id ?>">
                            <select disabled="disabled" class="form-control select2me" onchange="get_service_parameters(this.value, <?php echo $counter ?>)">
                                <option value="">Select</option>
                                <?php
                                if(count($services) > 0) {
                                    foreach ($services as $service) {
                                        $has_parent = check_if_service_has_child($service -> id);
                                        ?>
                                        <option value="<?php echo $service -> id ?>" class="<?php if($has_parent) echo 'has-child' ?>" <?php if($ipd_associated_service -> service_id == $service -> id) echo 'selected="selected"' ?>>
                                            <?php echo $service -> title ?>
                                        </option>
                                        <?php
                                        echo get_sub_child($service -> id, false, $ipd_associated_service -> service_id);
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <div class="col-lg-1">
                            <label for="exampleInputEmail1">Price</label>
                            <input type="text" name="price[]" class="price form-control" value="<?php echo ( $patient -> panel_id > 0) ? $ipd_associated_service -> net_price : $ipd_associated_service -> price ?>" required="required" onchange="update_ipd_net_price(this.value, <?php echo $counter ?>)" readonly="readonly">
                        </div>

                        <?php if($ipd_associated_service -> doctor_id > 0) : ?>
                            <div class="col-lg-2">
                                <label for="exampleInputEmail1">Doctor</label>
                                <select name="doctor_id[]" class="form-control select2me" required="required">
                                    <option value="">Select</option>
                                    <?php
                                    if(count($doctors) > 0) {
                                        foreach ($doctors as $doctor) {
                                            ?>
                                            <option value="<?php echo $doctor -> id ?>" <?php if($ipd_associated_service -> doctor_id == $doctor -> id) echo 'selected="selected"' ?>>
                                                <?php echo $doctor -> name ?>
                                            </option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        <?php else : ?>
                            <input type="hidden" name="doctor_id[]" value="0">
                        <?php endif; ?>

                        <?php
                        if($ipd_associated_service -> charge_per == 'day')  {
                            $label = 'Days';
                            $class = 'no-of-days';
                            $placeholder = 'Days';
                            $charge_per = 'day';
                        }
                        else if($ipd_associated_service -> charge_per == 'hour') {
                            $label = 'Hours';
                            $class = 'no-of-hours';
                            $placeholder = 'Hours';
                            $charge_per = 'hour';
                        }
                        else if($ipd_associated_service -> charge_per == 'minute') {
                            $label = 'Minutes';
                            $class = 'no-of-minutes';
                            $placeholder = 'Minutes';
                            $charge_per = 'minute';
                        }
                        else {
                            $label = '';
                            $charge_per = '';
                        }
                        if(!empty($label)) {
                            ?>
                            <div class="col-lg-1">
                                <label for="exampleInputEmail1"><?php echo $label ?></label>
                                <input type="text" name="charge_per_value[]" class="<?php echo $class ?> form-control" placeholder="<?php echo $placeholder ?>" required="required" onchange="update_ipd_sale_net_price(this.value, <?php echo $counter ?>)" value="<?php echo $ipd_associated_service -> charge_per_value ?>">
                            </div>
                            <?php
                        }
                        else {
                            ?>
                            <input type="hidden" name="charge_per_value[]" value="1">
                            <?php
                        }
                        ?>
                        <input type="hidden" name="charge_per[]" class="charge_per" value="<?php echo $charge_per ?>">

                        <?php if($ipd_associated_service -> doctor_id > 0) : ?>
                            <div class="col-lg-2">
                                <label for="exampleInputEmail1">Doctor Dis. (Flat)</label>
                                <input type="text" name="doctor_discount[]" class="doctor-disc form-control" value="<?php echo $ipd_associated_service -> doctor_discount ?>" required="required" onchange="add_discount(this.value, <?php echo $counter ?>)">
                            </div>
                        <?php else : ?>
                            <input type="hidden" name="doctor_discount[]" class="form-control" value="0" required="required">
                        <?php endif; ?>

                        <div class="col-lg-2">
                            <label for="exampleInputEmail1">Hospital Dis. (Flat)</label>
                            <input type="text" name="hospital_discount[]" class="hospital-disc form-control" value="<?php echo $ipd_associated_service -> hospital_discount ?>" required="required" onchange="add_discount(this.value, <?php echo $counter ?>)" readonly="readonly">
                        </div>

                        <div class="col-lg-1">
                            <label for="exampleInputEmail1">Net Price</label>
                            <input type="text" name="net_price[]" class="net-price form-control" value="<?php echo $ipd_associated_service -> net_price ?>" required="required" readonly="readonly">
                        </div>


                    </div>
            <?php
                    $counter++;
                }
            }
            ?>
            <div class="assign-more-services" style="display: block;float: left;width: 100%;"></div>
        </div>
    </div> <br>
    <div class="row">
        <div class="form-group col-lg-offset-9 col-lg-3">
            <label for="exampleInputEmail1">IPD Section Total</label>
            <div class="doctor">
                <input type="text" class="form-control" value="<?php echo get_ipd_services_total ($sale -> sale_id) ?>" readonly="readonly">
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
    </div>
</form>
<!-- BEGIN PAGE CONTENT-->
<?php $access = get_user_access ( get_logged_in_user_id () ); ?>
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-reorder"></i> Edit Consultancy
                </div>
            </div>
            <div class="portlet-body form">
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
                <div class="alert alert-danger" id="patient-info" style="display: none"></div>
                <form role="form" method="post" autocomplete="off">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" id="csrf_token">
                    <input type="hidden" name="action" value="do_edit_consultancy">
                    <input type="hidden" name="consultancy_id" value="<?php echo $consultancy -> id ?>">
                    <input type="hidden" name="doctor_id" value="<?php echo $consultancy -> doctor_id ?>">
                    <div class="form-body" style="overflow:auto;">
                        <div class="form-group col-lg-4">
                            <label for="exampleInputEmail1">Patient EMR#</label>
                            <input type="text" class="form-control" value="<?php echo $consultancy -> patient_id ?>" readonly="readonly">
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="exampleInputEmail1">Name</label>
                            <input type="text" class="form-control" readonly="readonly" value="<?php echo get_patient($consultancy -> patient_id) -> name ?>">
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="exampleInputEmail1">CNIC</label>
                            <input type="text" class="form-control" readonly="readonly" value="<?php echo get_patient($consultancy -> patient_id) -> cnic ?>">
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="exampleInputEmail1">Medical Department</label>
                            <input type="text" class="form-control" readonly="readonly" value="<?php echo get_specialization_by_id($consultancy -> specialization_id) -> title ?>">
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="exampleInputEmail1">Doctor</label>
                            <input type="text" class="form-control" readonly="readonly" value="<?php echo get_doctor($consultancy -> doctor_id) -> name ?>">
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="exampleInputEmail1">Available From</label>
                            <input type="text" class="form-control available_from" readonly="readonly" value="<?php echo $consultancy -> available_from ?>">
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="exampleInputEmail1">Available Till</label>
                            <input type="text" class="form-control available_till" readonly="readonly" value="<?php echo $consultancy -> available_till ?>">
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="exampleInputEmail1">Charges</label>
                            <input type="text" class="form-control charges" name="charges" readonly="readonly" value="<?php echo $consultancy -> charges ?>">
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="exampleInputEmail1">Discount</label>
                            <input type="text" name="discount" class="form-control" placeholder="Add discount"  required="required" onkeyup="calculate_consultancy_discount(this.value)" value="<?php echo $consultancy -> discount ?>" <?php if ( !in_array ( 'add_consultancy_discount', explode ( ',', $access -> access ) ) ) : ?> readonly="readonly" <?php endif ?>>
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="exampleInputEmail1">Net Bill</label>
                            <input type="text" class="form-control net_bill" name="net_bill" readonly="readonly"value="<?php echo $consultancy -> net_bill ?>">
                        </div>
                        <div class="form-group col-lg-12">
                            <label for="exampleInputEmail1">Remarks<sup style="color: #FF0000; font-weight: 700">*</sup></label>
                            <textarea class="form-control" name="remarks" rows="5"><?php echo $consultancy -> remarks ?></textarea>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn blue" id="sales-btn">Update</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>
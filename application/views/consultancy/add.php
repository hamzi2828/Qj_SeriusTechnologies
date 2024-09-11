<!-- BEGIN PAGE CONTENT-->
<?php $access = get_user_access ( get_logged_in_user_id () ); ?>
<div class="row">
    <div class="col-md-12">
        <div class="alert alert-danger panel-info hidden"></div>
<!--        <div class="alert alert-danger panel-discount-info hidden"></div>-->
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
                    <i class="fa fa-reorder"></i> Add Consultancy
                </div>
            </div>
            <div class="portlet-body form">
                <div class="alert alert-danger" id="patient-info" style="display: none"></div>
                <form role="form" method="post" autocomplete="off">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" id="csrf_token">
                    <input type="hidden" name="action" value="do_add_consultancy">
                    <div class="form-body" style="overflow:auto;">
                        <div class="form-group col-lg-4">
                            <label for="exampleInputEmail1">Patient EMR#</label>
                            <input type="text" name="patient_id" class="form-control" placeholder="Add patient EMR#" autofocus="autofocus" value="<?php echo set_value('patient_id') ?>" required="required" id="patient_id" onchange="get_patient(this.value)">
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="exampleInputEmail1">Name</label>
                            <input type="text" class="form-control name" id="patient-name" readonly="readonly">
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="exampleInputEmail1">CNIC</label>
                            <input type="text" class="form-control cnic" id="patient-cnic" readonly="readonly">
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="exampleInputEmail1">Medical Department</label>
                            <select class="form-control select2me" name="specialization_id" required="required" onchange="get_doctors_by_specializations(this.value)">
                                <option value="">Select Department</option>
                                <?php
                                if(count($specializations) > 0) {
                                    foreach ($specializations as $specialization) {
                                        ?>
                                        <option value="<?php echo $specialization -> id ?>">
                                            <?php echo $specialization -> title ?>
                                        </option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="exampleInputEmail1">Doctor</label>
                            <div class="doctor">
                                <select class="form-control select2me doctors" name="doctor_id" required="required"></select>
                            </div>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="exampleInputEmail1">Available From</label>
                            <input type="text" class="form-control available_from" name="available_from" readonly="readonly">
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="exampleInputEmail1">Available Till</label>
                            <input type="text" class="form-control available_till" name="available_till" readonly="readonly">
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="exampleInputEmail1">Charges</label>
                            <input type="text" class="form-control charges" name="charges" readonly="readonly">
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="exampleInputEmail1">Discount</label>
                            <input type="text" name="discount" class="form-control" placeholder="Add discount"  value="<?php echo set_value('discount') ?>" required="required" onkeyup="calculate_consultancy_discount(this.value)" <?php if ( !in_array ( 'add_consultancy_discount', explode ( ',', $access -> access ) ) ) : ?> readonly="readonly" <?php endif ?>>
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="exampleInputEmail1">Net Bill</label>
                            <input type="text" class="form-control net_bill" name="net_bill" readonly="readonly">
                        </div>
                        <div class="form-group col-lg-12">
                            <label for="exampleInputEmail1">Remarks<sup style="color: #FF0000; font-weight: 700">*</sup></label>
                            <textarea class="form-control" name="remarks" rows="5"></textarea>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="button" class="btn blue" id="sales-btn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>
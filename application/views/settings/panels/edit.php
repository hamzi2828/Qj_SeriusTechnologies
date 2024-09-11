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
                    <i class="fa fa-reorder"></i> Edit Panel
                </div>
            </div>
            <div class="portlet-body form">
                <form role="form" method="post" autocomplete="off">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" id="csrf_token">
                    <input type="hidden" name="action" value="do_edit_panel">
                    <input type="hidden" name="panel_id" value="<?php echo $panel -> id; ?>">
                    <input type="hidden" id="added" value="1">
                    <div class="form-body" style="overflow: auto">
                        <div class="col-lg-4">
                            <label for="exampleInputEmail1">Code</label>
                            <input type="text" name="code" class="form-control" placeholder="Add code" autofocus="autofocus" value="<?php echo $panel -> code ?>">
                        </div>
                        <div class="col-lg-4">
                            <label for="exampleInputEmail1">Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Add name" value="<?php echo $panel -> name ?>">
                        </div>
                        <div class="col-lg-4">
                            <label for="exampleInputEmail1">Contact No.</label>
                            <input type="text" name="contact_no" class="form-control" placeholder="Add Contact" value="<?php echo $panel -> contact_no ?>">
                        </div>
                        <div class="col-lg-6">
                            <label for="exampleInputEmail1">Email Address</label>
                            <input type="text" name="email" class="form-control" placeholder="Add Email" value="<?php echo $panel -> email ?>">
                        </div>
                        <div class="col-lg-6">
                            <label for="exampleInputEmail1">NTN#</label>
                            <input type="text" name="ntn" class="form-control" placeholder="Add NTN" value="<?php echo $panel -> ntn ?>">
                        </div>
                        <div class="col-lg-6">
                            <label for="exampleInputEmail1">Address</label>
                            <input type="text" name="address" class="form-control" placeholder="Add Address" value="<?php echo $panel -> address ?>">
                        </div>
                        <div class="col-lg-4">
                            <label for="exampleInputEmail1">Companies</label>
                            <select name="company_id[]" class="form-control select2me" multiple="multiple" autocomplete="1">
                                <?php
                                if(count($companies) > 0) {
                                    foreach ($companies as $company) {
                                        $panel_company = get_panel_company($panel -> id, $company -> id);
                                        ?>
                                        <option value="<?php echo $company -> id ?>" <?php if($panel_company and $panel_company -> company_id == $company -> id) echo 'selected="selected"' ?> class="<?php if($company -> parent_id > 0) echo 'child' ?>">
                                            <?php echo $company -> name ?>
                                        </option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-lg-12">
                            <label for="exampleInputEmail1">Description</label>
                            <textarea rows="5" name="description" class="form-control" placeholder="Add Description"><?php echo $panel -> description ?></textarea>
                        </div>
                        <div class="col-lg-12">
                            <h3 style="font-weight: 600 !important;text-decoration: underline;"> IPD Services </h3>
                        </div>
                        <div class="add-more-services">
                            <?php
                                $ipdCounter = 1;
                            if(count($ipd_services) > 0) {
								foreach ($ipd_services as $ipd_service) {
									?>
                                    <div class="col-sm-3">
                                        <a href="<?php echo base_url('/settings/delete_panel_ipd_service/'.$ipd_service -> id) ?>" onclick="return confirm('Are you sure?')">
                                            <label style="font-size: 16px; font-weight: 700; position: absolute; left: -10px; top: -7px; color: #000000"><?php echo $ipdCounter++ ?></label>
                                            <i class="fa fa-trash"></i>
                                        </a>
                                        <label> Service </label>
                                        <select name="service_id[]" class="form-control select2me">
                                            <option value="">Select</option>
											<?php
											if (count($services) > 0) {
												foreach ($services as $service) {
													?>
                                                    <option value="<?php echo $service -> id ?>" <?php if($ipd_service -> service_id == $service -> id) echo 'selected="selected"' ?>><?php echo $service -> title ?></option>
													<?php
												}
											}
											?>
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <label>Panel Charges</label>
                                        <input type="text" name="service_price[]" value="<?php echo $ipd_service -> price ?>" placeholder="Panel Charges" class="form-control">
                                    </div>
                                    <div class="col-sm-3">
                                        <label>Discount</label>
                                        <input type="text" name="discount[]" class="form-control" value="<?php echo $ipd_service -> discount ?>">
                                    </div>
                                    <div class="col-sm-3">
                                        <label>Discount Type</label>
                                        <select name="type[]" class="form-control">
                                            <option value="flat" <?php if($ipd_service -> type == 'flat') echo 'selected="selected"' ?>>Flat</option>
                                            <option value="percent" <?php if($ipd_service -> type == 'percent') echo 'selected="selected"' ?>>Percent</option>
                                        </select>
                                    </div>
									<?php
								}
							}
                            else
                                echo '<h3> No services added. </h3>';
                            ?>
                        </div>
                        <div class="add-more-service"></div>
                        <button type="button" class="btn btn-xs pull-right purple" onclick="add_more_panel_services()" style="margin: 15px;">Add More</button>

                        <div class="col-lg-12">
                            <h3 style="font-weight: 600 !important;text-decoration: underline;"> OPD Services </h3>
                        </div>
                        <div class="add-more-services">
                            <?php
                                $opdCounter = 1;
                            if(count($added_opd_services) > 0) {
								foreach ($added_opd_services as $added_opd_service) {
									?>
                                    <div class="col-sm-3">
                                        <a href="<?php echo base_url('/settings/delete_panel_opd_service/'.$added_opd_service -> id) ?>" onclick="return confirm('Are you sure?')">
                                            <label style="font-size: 16px; font-weight: 700; position: absolute; left: -10px; top: -7px; color: #000000"><?php echo $opdCounter++ ?></label>
                                            <i class="fa fa-trash"></i>
                                        </a>
                                        <label> Service </label>
                                        <select name="opd_service_id[]" class="form-control select2me">
                                            <option value="">Select</option>
											<?php
											if (count($opd_services) > 0) {
												foreach ($opd_services as $service) {
													?>
                                                    <option value="<?php echo $service -> id ?>" <?php if($added_opd_service -> service_id == $service -> id) echo 'selected="selected"' ?>><?php echo $service -> title ?></option>
													<?php
												}
											}
											?>
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <label>Panel Charges</label>
                                        <input type="text" name="opd_service_price[]" value="<?php echo $added_opd_service -> price ?>" placeholder="Panel Charges" class="form-control">
                                    </div>
                                    <div class="col-sm-3">
                                        <label>Discount</label>
                                        <input type="text" name="opd_discount[]" class="form-control" value="<?php echo $added_opd_service -> discount ?>">
                                    </div>
                                    <div class="col-sm-3">
                                        <label>Discount Type</label>
                                        <select name="opd_type[]" class="form-control">
                                            <option value="flat" <?php if($added_opd_service -> type == 'flat') echo 'selected="selected"' ?>>Flat</option>
                                            <option value="percent" <?php if($added_opd_service -> type == 'percent') echo 'selected="selected"' ?>>Percent</option>
                                        </select>
                                    </div>
									<?php
								}
							}
							else
								echo '<h3> No services added. </h3>';
                            ?>
                        </div>
                        <div class="add-more-opd-service"></div>
                        <button type="button" class="btn btn-xs pull-right purple" onclick="add_more_panel_opd_services()" style="margin: 15px;">Add More</button>


                        <div class="col-lg-12">
                            <h3 style="font-weight: 600 !important;text-decoration: underline;"> Consultancy Doctors </h3>
                        </div>
                        <div class="add-more-services">
                            <?php
                                $consultancy = 1;
                            if(count($panel_doctors) > 0) {
								foreach ($panel_doctors as $panel_doctor) {
									?>
                                    <div class="col-sm-3">
                                        <a href="<?php echo base_url('/settings/delete_panel_ipd_doctor/'.$panel_doctor -> id) ?>" onclick="return confirm('Are you sure?')">
                                            <label style="font-size: 16px; font-weight: 700; position: absolute; left: -10px; top: -7px; color: #000000"><?php echo $consultancy++ ?></label>
                                            <i class="fa fa-trash"></i>
                                        </a>
                                        <label> Doctor </label>
                                        <select name="doctor_id[]" class="form-control select2me">
                                            <option value="">Select</option>
											<?php
											if (count($doctors) > 0) {
												foreach ($doctors as $doctor) {
													?>
                                                    <option value="<?php echo $doctor -> id ?>" <?php if($panel_doctor -> doctor_id == $doctor -> id) echo 'selected="selected"' ?>><?php echo $doctor -> name ?></option>
													<?php
												}
											}
											?>
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <label> Panel Charges </label>
                                        <input type="text" name="consultancy_price[]" value="<?php echo $panel_doctor -> price ?>" placeholder="Panel Charges" class="form-control">
                                    </div>
                                    <div class="col-sm-3">
                                        <label>Discount</label>
                                        <input type="text" name="doc_discount[]" class="form-control" value="<?php echo $panel_doctor -> discount ?>">
                                    </div>
                                    <div class="col-sm-3">
                                        <label>Discount Type</label>
                                        <select name="doc_disc_type[]" class="form-control">
                                            <option value="flat" <?php if($panel_doctor -> type == 'flat') echo 'selected="selected"' ?>>Flat</option>
                                            <option value="percent" <?php if($panel_doctor -> type == 'percent') echo 'selected="selected"' ?>>Percent</option>
                                        </select>
                                    </div>
									<?php
								}
							}
							else
								echo '<h3> No doctors added. </h3>';
                            ?>
                        </div>
                        <div class="add-more-doctors"></div>
                        <button type="button" class="btn btn-xs pull-right purple" onclick="add_more_panel_doctors()" style="margin: 15px;">Add More</button>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn blue">Update</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>
<style>
    .add-more-services {
        width: 100%;
        float: left;
        margin-top: 15px;
    }
    .add-more-service {
        width: 100%;
        float: left;
    }
</style>
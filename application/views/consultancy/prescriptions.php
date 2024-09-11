<!-- BEGIN PAGE CONTENT-->
<div class="row">
	<div class="col-md-12">
		<form role="form" method="get" autocomplete="off">
			<div class="form-body" style="overflow:auto;">
				<div class="form-group col-lg-11">
					<label for="exampleInputEmail1">Consultancy ID#</label>
					<input type="text" name="consultancy_id" class="form-control" placeholder="Enter consultancy ID" autofocus="autofocus" value="<?php echo @$_REQUEST['consultancy_id'] ?>">
				</div>
				<div class="form-group col-lg-1">
					<button type="submit" class="btn blue" style="margin-top: 25px;">Search</button>
				</div>
			</div>
		</form>
		<!-- BEGIN SAMPLE FORM PORTLET-->
		<div class="portlet box blue">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-reorder"></i> Add Prescriptions
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
				<?php
				$patient = '';
				$vitals = array();
				if(!empty($consultancy)) {
					$patient = get_patient($consultancy -> patient_id);
					$vitals = get_vitals($consultancy -> patient_id);
				}
				?>
				<form role="form" method="post" autocomplete="off">
					<input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" id="csrf_token">
					<input type="hidden" name="action" value="do_add_prescriptions">
					<input type="hidden" id="added" value="1">
					<div class="form-body" style="overflow:auto;">
						<div class="form-group col-lg-5">
							<label for="exampleInputEmail1">Patient Name</label>
							<input type="text" readonly="readonly" class="form-control" value="<?php echo @$patient -> name ?>">
						</div>
						<div class="form-group col-lg-3">
							<label for="exampleInputEmail1">Patient Phone</label>
							<input type="text" class="form-control" readonly="readonly" value="<?php echo @$patient -> mobile ?>">
						</div>
						<div class="form-group col-lg-2">
							<label for="exampleInputEmail1">Patient Gender</label>
							<input type="text" class="form-control" readonly="readonly" value="<?php echo (@$patient -> gender == 1) ? 'Male' : 'Female'; ?>">
						</div>
						<div class="form-group col-lg-2">
							<label for="exampleInputEmail1">Patient Age</label>
							<input type="text" class="form-control" readonly="readonly" value="<?php echo @$patient -> age ?>">
						</div>
						<?php if(count($vitals) > 0) : ?>
						<div class="form-group col-lg-12" style="background: #fff;padding: 10px 15px;">
							<label style="display: block; float: left; width: 100%; font-size: 18px; font-weight: 900">Patient Vitals</label>
							<?php
							foreach ( $vitals as $vital ) {
								echo '<strong> ' . $vital->vital_key . ' </strong>: ' . $vital->vital_value . '<br>';
							}
							?>
						</div>
						<?php else  : if(count($vitals) < 1 and isset($_REQUEST['consultancy_id'])) : ?>
                        <p style="display: block; float: left; width: 100%; font-size: 18px; font-weight: 900;padding-left: 15px;margin-bottom: 15px;color: #FF0000">Patient vitals not found.</p>
                        <?php endif; endif; ?>
						<div class="form-group col-lg-12">
							<label style="display: block; width: 100%; font-size: 18px; font-weight: 900">Complaints</label>
							<textarea class="ckeditor form-control" name="complaints" rows="10"><?php echo @$prescription -> complaints ?></textarea>
						</div>
						<div class="form-group col-lg-12">
							<label style="display: block; width: 100%; font-size: 18px; font-weight: 900">Diagnoses</label>
							<textarea class="ckeditor form-control" name="diagnosis" rows="10"><?php echo @$prescription -> diagnosis ?></textarea>
						</div>
						<?php
						if(count($prescribed_medicines) > 0) {
							foreach ($prescribed_medicines as $prescribed_medicine) {
								?>
                                <div class="form-group col-lg-12" style="padding: 0">
									<?php if(count($medicines) > 0) : ?>
                                        <div class="form-group col-lg-3">
                                            <label style="display: block; float: left; width: 100%; font-size: 18px; font-weight: 900">Medicines</label>
                                            <select name="medicines[]" class="form-control select2me">
                                                <option value="">Select</option>
												<?php
												foreach ( $medicines as $medicine ) {
													?>
                                                    <option value="<?php echo $medicine -> id ?>" <?php if($prescribed_medicine -> medicine_id == $medicine -> id) echo 'selected="selected"' ?>>
														<?php echo $medicine -> name ?>
                                                        <?php if ( $medicine -> form_id > 1 or $medicine -> strength_id > 1 ) : ?>
                                                            (<?php echo get_form ( $medicine -> form_id ) -> title ?> - <?php echo get_strength ( $medicine -> strength_id ) -> title ?>)
                                                        <?php endif ?>
                                                    </option>
													<?php
												}
												?>
                                            </select>
                                        </div>
									<?php endif; ?>
                                    <div class="form-group col-lg-2">
                                        <label>Dosage</label>
                                        <input type="text" name="dosage[]" class="form-control" value="<?php echo $prescribed_medicine -> dosage ?>">
                                    </div>
                                    <div class="form-group col-lg-2">
                                        <label>Timings</label>
                                        <input type="text" name="timings[]" class="form-control" value="<?php echo $prescribed_medicine -> timings ?>">
                                    </div>
                                    <div class="form-group col-lg-2">
                                        <label>Days</label>
                                        <input type="text" name="days[]" class="form-control" value="<?php echo $prescribed_medicine -> days ?>">
                                    </div>
                                    <div class="form-group col-lg-3">
                                        <label>Instructions</label>
                                        <select name="instructions[]" class="form-control select2me">
                                            <option value="">Select</option>
											<?php
											if(count($instructions) > 0) {
												foreach ($instructions as $instruction) {
													?>
                                                    <option value="<?php echo $instruction->id ?>" <?php if (@$prescribed_medicine->instructions == $instruction->id) echo 'selected="selected"'; ?>>
														<?php echo $instruction->instruction ?>
                                                    </option>
													<?php
												}
											}
											?>
                                        </select>
                                    </div>
                                </div>
								<?php
							}
						}
						?>
                        <div class="form-group col-lg-12" style="padding: 0">
							<?php if(count($medicines) > 0) : ?>
                                <div class="form-group col-lg-3">
                                    <label style="display: block; float: left; width: 100%; font-size: 18px; font-weight: 900">Medicines</label>
                                    <select name="medicines[]" class="form-control select2me">
                                        <option value="">Select</option>
										<?php
										foreach ( $medicines as $medicine ) {
											?>
                                            <option value="<?php echo $medicine -> id ?>">
												<?php echo $medicine -> name ?>
                                                <?php if ( $medicine -> form_id > 1 or $medicine -> strength_id > 1 ) : ?>
                                                    (<?php echo get_form ( $medicine -> form_id ) -> title ?> - <?php echo get_strength ( $medicine -> strength_id ) -> title ?>)
                                                <?php endif ?>
                                            </option>
											<?php
										}
										?>
                                    </select>
                                </div>
							<?php endif; ?>
                            <div class="form-group col-lg-2">
                                <label>Dosage</label>
                                <input type="text" name="dosage[]" class="form-control">
                            </div>
                            <div class="form-group col-lg-2">
                                <label>Timings</label>
                                <input type="text" name="timings[]" class="form-control">
                            </div>
                            <div class="form-group col-lg-2">
                                <label>Days</label>
                                <input type="text" name="days[]" class="form-control">
                            </div>
                            <div class="form-group col-lg-3">
                                <label>Instructions</label>
                                <select name="instructions[]" class="form-control select2me">
                                    <option value="">Select</option>
									<?php
                                    if(count($instructions) > 0) {
										foreach ($instructions as $instruction) {
											?>
                                            <option value="<?php echo $instruction->id ?>">
												<?php echo $instruction->instruction ?>
                                            </option>
											<?php
										}
									}
									?>
                                </select>
                            </div>
                        </div>
                        <div class="add-more"></div>
                        <div class="add-more-btn">
                            <a href="javascript:void(0)" class="pull-right btn btn-xs purple" onclick="add_more_prescribed_medicines()" style="margin-right: 15px;">Add more</a>
                        </div>
						<?php if(count($tests) > 0) : ?>
                            <div class="form-group col-lg-12">
                                <label style="display: block; float: left; width: 100%; font-size: 18px; font-weight: 900">Lab Tests</label>
                                <select name="tests[]" class="form-control select2me" multiple="multiple">
                                    <option value="">Select</option>
									<?php
									foreach ( $tests as $test ) {
										?>
                                        <option value="<?php echo $test -> id ?>" <?php if(check_if_test_added_with_consultancy(@$_REQUEST['consultancy_id'], $test -> id)) echo 'selected="selected"'; ?>>
											<?php echo $test -> name ?>
                                        </option>
										<?php
									}
									?>
                                </select>
                            </div>
						<?php endif; ?>
						<?php if(count($follow_ups) > 0) : ?>
                            <div class="form-group col-lg-12">
                                <label style="display: block; float: left; width: 100%; font-size: 18px; font-weight: 900">Follow Up</label>
                                <select name="follow_up" class="form-control select2me">
                                    <option value="">Select</option>
									<?php
									foreach ( $follow_ups as $follow_up ) {
										?>
                                        <option value="<?php echo $follow_up -> id ?>" <?php if(@$prescription -> follow_up == $follow_up -> id) echo 'selected="selected"'; ?>>
											<?php echo $follow_up -> title ?>
                                        </option>
										<?php
									}
									?>
                                </select>
                            </div>
						<?php endif; ?>
					</div>
					<?php if(!empty($patient)) : ?>
					<div class="form-actions">
						<button type="submit" class="btn blue" id="sales-btn">Submit</button>
						<?php if(!empty($prescription)) : ?>
                        <a href="<?php echo base_url('/invoices/prescription-invoice/'.$prescription -> id); ?>" target="_blank" class="btn purple">Print</a>
						<?php endif; ?>
					</div>
					<?php endif; ?>
				</form>
			</div>
		</div>
		<!-- END SAMPLE FORM PORTLET-->
	</div>
</div>
<style>
    a.btn.purple {
        display: inline-block;
        margin-top: 5px;
    }
</style>
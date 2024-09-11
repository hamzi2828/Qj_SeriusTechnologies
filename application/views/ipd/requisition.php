<div class="tab-pane <?php if(isset($current_tab) and $current_tab == 'requisition') echo 'active' ?>">
	<form role="form" method="post" autocomplete="off">
		<input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" id="csrf_token">
		<input type="hidden" name="action" value="do_add_ipd_requisitions">
		<input type="hidden" id="added" value="<?php echo count($requisitions); ?>">
		<input type="hidden" name="sale_id" value="<?php echo $sale -> sale_id ?>">
		<input type="hidden" name="patient_id" value="<?php echo $sale -> patient_id ?>">
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
            <?php
            if(count($requisitions) > 0) {
                $req_counter = 0;
				foreach ($requisitions as $requisition) {
				    $medicine   = get_medicine($requisition -> medicine_id);
					?>
                    <div class="sale-<?php echo $req_counter ?> sale-fields">
                        <div class="form-group col-lg-4">
                            <a href="javascript:void(0)" onclick="remove_ipd_medication_row(<?php echo $req_counter ?>)" style="position: absolute;left: 0;top: 30px;">
                                <i class="fa fa-trash-o"></i>
                            </a>
                            <label for="exampleInputEmail1">Medicine</label>
                            <select name="medicine_id[]" class="form-control select2me" required="required">
                                <option value="<?php echo $requisition -> medicine_id ?>">
                                    <?php echo $medicine->name ?>
                                    <?php if ($medicine->form_id > 1 or $medicine->strength_id > 1) : ?>
                                        (<?php echo get_form($medicine->form_id)->title ?> - <?php echo get_strength($medicine->strength_id)->title ?>)
                                    <?php endif ?>
                                </option>
                            </select>
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="exampleInputEmail1">Frequency</label>
                            <select name="frequency[]" class="form-control select2me" required="required">
                                <option value="OD" <?php if($requisition -> frequency == 'OD') echo 'selected="selected"' ?>>OD</option>
                                <option value="BID" <?php if($requisition -> frequency == 'BID') echo 'selected="selected"' ?>>BID</option>
                                <option value="TID" <?php if($requisition -> frequency == 'TID') echo 'selected="selected"' ?>>TID</option>
                                <option value="QID" <?php if($requisition -> frequency == 'QID') echo 'selected="selected"' ?>>QID</option>
                                <option value="HS" <?php if($requisition -> frequency == 'HS') echo 'selected="selected"' ?>>HS</option>
                                <option value="STAT" <?php if($requisition -> frequency == 'STAT') echo 'selected="selected"' ?>>STAT</option>
                                <option value="SOS" <?php if($requisition -> frequency == 'SOS') echo 'selected="selected"' ?>>SOS</option>
                            </select>
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="exampleInputEmail1">Quantity</label>
                            <input type="text" class="form-control" name="quantity[]" id="quantity" required="required" value="<?php echo $requisition -> quantity ?>">
                        </div>
                    </div>
					<?php
					$req_counter++;
				}
			}
			else {
				?>
                <div class="sale-0 sale-fields">
                    <div class="form-group col-lg-4">
                        <label for="exampleInputEmail1">Medicine</label>
                        <select name="medicine_id[]" class="form-control select2me" required="required">
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
                    <div class="form-group col-lg-4">
                        <label for="exampleInputEmail1">Frequency</label>
                        <select name="frequency[]" class="form-control select2me" required="required">
                            <option value="OD">OD</option>
                            <option value="BID">BID</option>
                            <option value="TID">TID</option>
                            <option value="QID">QID</option>
                            <option value="HS">HS</option>
                            <option value="STAT">STAT</option>
                            <option value="SOS">SOS</option>
                        </select>
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="exampleInputEmail1">Quantity</label>
                        <input type="text" class="form-control" name="quantity[]" id="quantity" required="required">
                    </div>
                </div>
				<?php
			}
            ?>
            <div id="sale-more-medicine"></div>
		</div>
		<div class="form-actions">
			<button type="submit" class="btn blue">Update</button>
			<button type="button" class="btn green" onclick="add_more_ipd_requisitions()">Add More</button>
		</div>
	</form>
</div>
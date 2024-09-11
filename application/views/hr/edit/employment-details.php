<div class="col-lg-12 text-center bg-dark" style="margin: 15px 0;">
    <h3 style="margin: 0; padding: 10px;"> Employment Details </h3>
</div>
<div class="form-group col-lg-3">
    <label for="exampleInputEmail1">Employee Post/Designation</label>
    <select name="department_id" class="form-control select2me">
        <option value="">Select</option>
		<?php
		if (count($departments) > 0) {
			foreach ($departments as $department) {
				?>
                <option value="<?php echo $department -> id ?>" <?php if($personal -> department_id == $department -> id) echo 'selected=selected"' ?>>
					<?php echo $department -> name ?>
                </option>
				<?php
			}
		}
		?>
    </select>
</div>
<div class="form-group col-lg-3">
    <label for="exampleInputEmail1">Hiring Date</label>
    <input type="text" name="hiring_date" class="form-control date-picker" placeholder="Add employee hiring date" value="<?php echo date('m/d/Y', strtotime($personal -> hiring_date)) ?>" required="required">
</div>
<div class="form-group col-lg-3">
    <label for="exampleInputEmail1">Contract Date</label>
    <input type="text" name="contract_date" class="form-control date-picker" placeholder="Add employee contract date" value="<?php echo date('m/d/Y', strtotime($personal -> contract_date)) ?>" required="required">
</div>
<div class="form-group col-lg-3">
    <label for="exampleInputEmail1">Basic Pay</label>
    <input type="text" name="basic_pay" class="form-control" placeholder="Add employee basic pay" value="<?php echo $personal -> basic_pay ?>">
</div>
<div class="form-group col-lg-3">
    <label for="exampleInputEmail1">Medical Allowance</label>
    <input type="text" name="medical_allowance" class="form-control" placeholder="Add employee medical allowance" value="<?php echo $personal -> medical_allowance ?>">
</div>
<div class="form-group col-lg-3">
    <label for="exampleInputEmail1">Transport Allowance</label>
    <input type="text" name="transport_allowance" class="form-control" placeholder="Add employee transport allowance" value="<?php echo $personal -> transport_allowance ?>">
</div>
<div class="form-group col-lg-3">
    <label for="exampleInputEmail1">Accommodation Allowance</label>
    <input type="text" name="rent_allowance" class="form-control" placeholder="Add employee house rent allowance" value="<?php echo $personal -> rent_allowance ?>">
</div>
<div class="form-group col-lg-3">
    <label for="exampleInputEmail1">Mobile Allowance</label>
    <input type="text" name="mobile_allowance" class="form-control" placeholder="Add employee mobile allowance" value="<?php echo $personal -> mobile_allowance ?>">
</div>
<div class="form-group col-lg-6">
    <label for="exampleInputEmail1">Food Allowance</label>
    <input type="text" name="food_allowance" class="form-control" placeholder="Add employee food allowance" value="<?php echo $personal -> food_allowance ?>">
</div>
<div class="form-group col-lg-6">
    <label for="exampleInputEmail1">Other Allowance</label>
    <input type="text" name="other_allowance" class="form-control" placeholder="Add employee other allowance" value="<?php echo $personal -> other_allowance ?>">
</div>
<div class="form-group col-lg-4">
	<label for="exampleInputEmail1">Working Hours</label>
	<input type="text" name="working_hours" class="form-control" value="<?php echo $personal -> working_hours ?>">
</div>

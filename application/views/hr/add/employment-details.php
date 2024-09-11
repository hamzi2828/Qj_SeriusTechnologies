<div class="col-lg-12 text-center bg-dark" style="margin: 15px 0;">
    <h3 style="margin: 0; padding: 10px;"> Employment Details </h3>
</div>
<div class="form-group col-lg-3">
    <label for="exampleInputEmail1">Department</label>
    <select name="department_id" class="form-control select2me">
        <option value="">Select</option>
		<?php
		if (count($departments) > 0) {
			foreach ($departments as $department) {
				?>
                <option value="<?php echo $department -> id ?>">
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
    <input type="text" name="hiring_date" class="form-control date-picker" value="<?php echo set_value('hiring_date') ?>" required="required">
</div>
<div class="form-group col-lg-3">
    <label for="exampleInputEmail1">Contract Date</label>
    <input type="text" name="contract_date" class="form-control date-picker" value="<?php echo set_value('contract_date') ?>" required="required">
</div>
<div class="form-group col-lg-3">
    <label for="exampleInputEmail1">Basic Pay</label>
    <input type="text" name="basic_pay" class="form-control" value="<?php echo set_value('basic_pay') ?>">
</div>
<div class="form-group col-lg-3">
    <label for="exampleInputEmail1">Medical Allowance</label>
    <input type="text" name="medical_allowance" class="form-control" value="<?php echo set_value('medical_allowance') ?>">
</div>
<div class="form-group col-lg-3">
    <label for="exampleInputEmail1">Transport Allowance</label>
    <input type="text" name="transport_allowance" class="form-control" value="<?php echo set_value('transport_allowance') ?>">
</div>
<div class="form-group col-lg-3">
    <label for="exampleInputEmail1">Accommodation Allowance</label>
    <input type="text" name="rent_allowance" class="form-control" value="<?php echo set_value('rent_allowance') ?>">
</div>
<div class="form-group col-lg-3">
    <label for="exampleInputEmail1">Mobile Allowance</label>
    <input type="text" name="mobile_allowance" class="form-control" value="<?php echo set_value('mobile_allowance') ?>">
</div>
<div class="form-group col-lg-4">
    <label for="exampleInputEmail1">Food Allowance</label>
    <input type="text" name="food_allowance" class="form-control" value="<?php echo set_value('food_allowance') ?>">
</div>
<div class="form-group col-lg-4">
    <label for="exampleInputEmail1">Other Allowance</label>
    <input type="text" name="other_allowance" class="form-control" value="<?php echo set_value('other_allowance') ?>">
</div>
<div class="form-group col-lg-4">
    <label for="exampleInputEmail1">Working Hours</label>
    <input type="text" name="working_hours" class="form-control" value="<?php echo set_value('working_hours') ?>">
</div>

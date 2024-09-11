<div class="add-more-services">
    <div class="col-sm-3">
        <label> Doctor </label>
        <select name="doctor_id[]" class="form-control js-example-basic-single-<?php echo $row ?>">
            <option value="">Select</option>
			<?php
			if(count($doctors) > 0) {
				foreach ($doctors as $doctor) {
					?>
                    <option value="<?php echo $doctor -> id ?>"><?php echo $doctor -> name ?></option>
					<?php
				}
			}
			?>
        </select>
    </div>
    <div class="col-sm-3">
        <label> Panel Charges </label>
        <input type="text" name="consultancy_price[]" value="0" placeholder="Panel Charges" class="form-control">
    </div>
    <div class="col-sm-3">
        <label>Discount</label>
        <input type="text" name="doc_discount[]" class="form-control">
    </div>
    <div class="col-sm-3">
        <label>Discount Type</label>
        <select name="doc_disc_type[]" class="form-control">
            <option value="flat">Flat</option>
            <option value="percent">Percent</option>
        </select>
    </div>
</div>
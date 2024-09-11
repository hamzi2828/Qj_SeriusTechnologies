<div class="add-more-services">
    <div class="col-sm-3">
        <label> Service </label>
        <select name="opd_service_id[]" class="form-control js-example-basic-single-<?php echo $row ?>">
            <option value="">Select</option>
			<?php
			if(count($opd_services) > 0) {
				foreach ($opd_services as $service) {
					?>
                    <option value="<?php echo $service -> id ?>"><?php echo $service -> title ?></option>
					<?php
				}
			}
			?>
        </select>
    </div>
    <div class="col-sm-3">
        <label> Panel Charges </label>
        <input type="text" name="opd_service_price[]" value="0" placeholder="Panel Charges" class="form-control">
    </div>
    <div class="col-sm-3">
        <label>Discount</label>
        <input type="text" name="opd_discount[]" class="form-control">
    </div>
    <div class="col-sm-3">
        <label>Discount Type</label>
        <select name="opd_type[]" class="form-control">
            <option value="flat">Flat</option>
            <option value="percent">Percent</option>
        </select>
    </div>
</div>
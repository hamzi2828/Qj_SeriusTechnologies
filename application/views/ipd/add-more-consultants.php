<div class="sale-<?php echo $added ?> sale-fields">
    <div class="form-group col-lg-4">
        <a href="javascript:void(0)" onclick="remove_ipd_medication_row(<?php echo $added ?>, 0)" style="position: absolute;left: 0;top: 30px;">
            <i class="fa fa-trash-o"></i>
        </a>
        <label for="exampleInputEmail1">Service</label>
        <select name="service_id[]" class="form-control consultants-<?php echo $added ?>">
            <option value="">Select</option>
			<?php
			if (count($services) > 0) {
				foreach ($services as $service) {
					$has_parent = check_if_service_has_child($service->id);
					?>
                    <option value="<?php echo $service->id ?>" class="<?php if ($has_parent)
						echo 'has-child' ?>">
						<?php echo $service->title ?>
                    </option>
					<?php
					echo get_sub_child($service->id);
				}
			}
			?>
        </select>
    </div>
    <div class="form-group col-lg-4">
        <label for="exampleInputEmail1">Doctor</label>
        <select name="doctor_id[]" class="form-control consultants-<?php echo $added ?>">
            <option value="">Select</option>
			<?php
			if (count($doctors) > 0) {
				foreach ($doctors as $doctor) {
					?>
                    <option value="<?php echo $doctor->id ?>">
						<?php echo $doctor->name ?>
                    </option>
					<?php
				}
			}
			?>
        </select>
    </div>
    <div class="form-group col-lg-4">
        <label for="Commission">Commission</label>
        <input type="text" class="form-control" name="commission[]" required="required">
    </div>
</div>
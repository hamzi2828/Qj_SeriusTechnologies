<?php
    $price = $service -> price;
    if(!empty($discount)) {
		if ( $discount -> price > 0 ) {
			$new_price = $discount -> price;
		}
		else {
			if ( $discount -> type == 'flat' )
				$new_price = $price - $discount -> discount;
			else
				$new_price = $price - ( $price * ( $discount -> discount / 100 ) );
		}
	}
    else
		$new_price = $price;
    
?>
<div class="col-lg-1">
    <label for="exampleInputEmail1">Price</label>
    <input type="text" name="price[]" class="price form-control" value="<?php echo $new_price ?>" required="required" onchange="update_ipd_net_price(this.value, <?php echo $row ?>)">
</div>

<?php if($service -> requires_doctor == '1') : ?>
    <div class="col-lg-2">
        <label for="exampleInputEmail1">Doctor</label>
        <select name="doctor_id[]" class="form-control doctor-<?php echo $row ?>" required="required">
            <option value="">Select</option>
			<?php
			if(count($doctors) > 0) {
				foreach ($doctors as $doctor) {
					?>
                    <option value="<?php echo $doctor -> id ?>">
						<?php echo $doctor -> name ?>
                    </option>
					<?php
				}
			}
			?>
        </select>
    </div>
<?php else : ?>
    <input type="hidden" name="doctor_id[]" value="0">
<?php endif; ?>

<?php
    if($service -> charge == 'day')  {
        $label = 'Days';
        $class = 'no-of-days';
        $placeholder = 'Days';
        $charge_per = 'day';
    }
    else if($service -> charge == 'hour') {
        $label = 'Hours';
		$class = 'no-of-hours';
		$placeholder = 'Hours';
		$charge_per = 'hour';
    }
    else if($service -> charge == 'minute') {
        $label = 'Minutes';
		$class = 'no-of-minutes';
		$placeholder = 'Minutes';
		$charge_per = 'minute';
    }
    else {
        $label = '';
        $charge_per = '';
    }
    if(!empty($label)) {
		?>
        <div class="col-lg-1">
            <label for="exampleInputEmail1"><?php echo $label ?></label>
            <input type="text" name="charge_per_value[]" class="<?php echo $class ?> form-control"
                   placeholder="<?php echo $placeholder ?>" required="required" onchange="update_ipd_sale_net_price(this.value, <?php echo $row ?>)">
        </div>
		<?php
	}
	else {
	    ?>
        <input type="hidden" name="charge_per_value[]" value="1">
<?php
    }
?>
<input type="hidden" name="charge_per[]" class="charge_per" value="<?php echo $charge_per ?>">

<?php if($service -> requires_doctor == '1') : ?>
    <div class="col-lg-2">
        <label for="exampleInputEmail1">Doctor Dis. (Flat)</label>
        <input type="text" name="doctor_discount[]" class="doctor-disc form-control" value="0" required="required" onchange="add_discount(this.value, <?php echo $row ?>)">
    </div>
<?php else : ?>
    <input type="hidden" name="doctor_discount[]" class="form-control" value="0" required="required">
<?php endif; ?>

<div class="col-lg-2">
    <label for="exampleInputEmail1">Hospital Dis. (Flat)</label>
    <input type="text" name="hospital_discount[]" class="hospital-disc form-control" value="0" required="required" onchange="add_discount(this.value, <?php echo $row ?>)">
</div>

<div class="col-lg-1">
    <label for="exampleInputEmail1">Net Price</label>
    <input type="text" name="net_price[]" class="net-price form-control" value="<?php echo $new_price ?>" required="required">
</div>

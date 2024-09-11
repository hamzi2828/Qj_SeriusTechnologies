<select name="stock_id[]" id="batch-<?php echo $row ?>" class="form-control batches-<?php echo $row ?>" onchange="get_store_stock_available_quantity_return(this.value, <?php echo $row ?>)" required="required">
	<?php
	if(count($batches) > 0) {
		foreach ($batches as $batch) {
			$available = $batch -> quantity - get_stock_sold_quantity ( $batch -> id );
		    if(!in_array($batch->id, $stock) and $available > 0) {
				?>
                <option value="<?php echo $batch -> id ?>">
					<?php echo ucwords($batch -> batch) ?>
                </option>
				<?php
			}
		}
	}
	?>
</select>
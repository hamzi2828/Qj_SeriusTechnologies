<label for="exampleInputEmail1">Issue To</label>
<select name="sold_to" class="form-control users-dropdown" required="required">
    <option value="">Select</option>
	<?php
	if(count($users) > 0) {
	    foreach ($users as $user) {
	?>
    <option value="<?php echo $user -> id ?>">
		<?php echo $user -> name ?>
    </option>
<?php
        }
    }
?>
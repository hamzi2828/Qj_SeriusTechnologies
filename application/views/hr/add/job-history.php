<div class="col-lg-12 text-center bg-dark" style="margin: 15px 0;">
    <h3 style="margin: 0; padding: 10px;"> Last Employment Details </h3>
</div>

<div class="form-group col-lg-3">
    <label for="exampleInputEmail1">Company Name</label>
    <input name="company" class="form-control" value="<?php echo set_value('company') ?>">
</div>

<div class="form-group col-lg-3">
    <label for="exampleInputEmail1">Address</label>
    <input name="address" class="form-control" value="<?php echo set_value('address') ?>">
</div>

<div class="form-group col-lg-3">
    <label for="exampleInputEmail1">Contact No.</label>
    <input name="contact" class="form-control" value="<?php echo set_value('contact') ?>">
</div>

<div class="form-group col-lg-3">
    <label for="exampleInputEmail1">Post/Designation</label>
    <input name="designation" class="form-control" value="<?php echo set_value('designation') ?>">
</div>

<div class="form-group col-lg-4">
    <label for="exampleInputEmail1">Duration of Job</label>
    <input name="duration" class="form-control" value="<?php echo set_value('duration') ?>">
</div>

<div class="form-group col-lg-4">
    <label for="exampleInputEmail1">Salary Package</label>
    <input name="salary" class="form-control" value="<?php echo set_value('salary') ?>">
</div>

<div class="form-group col-lg-4">
    <label for="exampleInputEmail1">Benefits </label>
    <input name="benefits" class="form-control" value="<?php echo set_value('benefits') ?>">
</div>

<div class="form-group col-lg-12">
    <label for="exampleInputEmail1">Reason for Leaving Job </label>
    <textarea name="leaving_reason" class="form-control" rows="5"><?php echo set_value('leaving_reason') ?></textarea>
</div>
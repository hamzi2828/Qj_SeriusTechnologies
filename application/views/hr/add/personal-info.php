<div class="col-lg-12 text-center bg-dark" style="margin: 15px 0;">
    <h3 style="margin: 0; padding: 10px;"> Personal Information </h3>
</div>
<div class="form-group col-lg-2">
    <label for="exampleInputEmail1">Employee Code</label>
    <input type="text" name="code" class="form-control" autofocus="autofocus" value="<?php echo set_value('code') ?>" maxlength="100" required="required">
</div>
<div class="form-group col-lg-3">
    <label for="exampleInputEmail1">Name</label>
    <input type="text" name="name" class="form-control" autofocus="autofocus" value="<?php echo set_value('name') ?>" maxlength="100" required="required">
</div>
<div class="form-group col-lg-3">
    <label for="exampleInputEmail1">Father Name</label>
    <input type="text" name="father_name" class="form-control" value="<?php echo set_value('father_name') ?>" maxlength="100" required="required">
</div>
<div class="form-group col-lg-4">
    <label for="exampleInputEmail1">Mother Name</label>
    <input type="text" name="mother_name" class="form-control" value="<?php echo set_value('mother_name') ?>" maxlength="100">
</div>
<div class="form-group col-lg-2">
    <label for="exampleInputEmail1">Gender</label>
    <select name="gender" class="form-control select2me">
        <option value="1">Male</option>
        <option value="0">Female</option>
    </select>
</div>
<div class="form-group col-lg-3">
    <label for="exampleInputEmail1">Date of Birth</label>
    <input type="text" name="dob" class="form-control date-picker" value="<?php echo set_value('dob') ?>">
</div>
<div class="form-group col-lg-3">
    <label for="exampleInputEmail1">Place of Birth</label>
    <input type="text" name="birth_place" class="form-control" value="<?php echo set_value('birth_place') ?>">
</div>
<div class="form-group col-lg-2">
    <label for="exampleInputEmail1">Martial Status</label>
    <select name="martial_status" class="form-control select2me">
        <option value="Single">Single</option>
        <option value="Married">Married</option>
        <option value="Divorced">Divorced</option>
    </select>
</div>
<div class="form-group col-lg-2">
    <label for="exampleInputEmail1">Religion</label>
    <select name="religion" class="form-control select2me">
        <option value="Muslim">Muslim</option>
        <option value="Christan">Christan</option>
        <option value="Hindu">Hindu</option>
    </select>
</div>
<div class="form-group col-lg-3">
    <label for="exampleInputEmail1">Nationality</label>
    <input type="text" name="nationality" class="form-control" maxlength="13" value="<?php echo set_value('nationality') ?>">
</div>
<div class="form-group col-lg-3">
    <label for="exampleInputEmail1">CNIC</label>
    <input type="text" name="cnic" class="form-control" maxlength="13" value="<?php echo set_value('cnic') ?>" required="required">
</div>
<div class="form-group col-lg-3">
    <label for="exampleInputEmail1">Tel (Land Line)</label>
    <input type="text" name="residence_mobile" class="form-control" value="<?php echo set_value('residence_mobile') ?>">
</div>
<div class="form-group col-lg-3">
    <label for="exampleInputEmail1">Mobile #1</label>
    <input type="text" name="mobile" class="form-control" value="<?php echo set_value('mobile') ?>">
</div>
<div class="form-group col-lg-3">
    <label for="exampleInputEmail1">Mobile #2</label>
    <input type="text" name="mobile_2" class="form-control" value="<?php echo set_value('mobile_2') ?>">
</div>
<div class="form-group col-lg-3">
    <label for="exampleInputEmail1">Email Address</label>
    <input type="email" name="email" class="form-control" value="<?php echo set_value('email') ?>">
</div>
<div class="form-group col-lg-6">
    <label for="exampleInputEmail1">Residential Address</label>
    <input type="text" name="permanent_address" class="form-control" required="required" value="<?php echo set_value('permanent_address') ?>">
</div>
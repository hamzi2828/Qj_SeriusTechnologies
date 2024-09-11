<div class="col-lg-12 text-center bg-dark" style="margin: 15px 0;">
    <h3 style="margin: 0; padding: 10px;"> Personal Information </h3>
</div>
<div class="form-group col-lg-2">
    <label for="exampleInputEmail1">Employee Code</label>
    <input type="text" name="code" class="form-control" placeholder="Add employee code" autofocus="autofocus" value="<?php echo $personal -> code ?>" maxlength="100" required="required">
</div>
<div class="form-group col-lg-3">
    <label for="exampleInputEmail1">Name</label>
    <input type="text" name="name" class="form-control" placeholder="Add employee name" autofocus="autofocus" value="<?php echo $personal -> name ?>" maxlength="100" required="required">
</div>
<div class="form-group col-lg-3">
    <label for="exampleInputEmail1">Father Name</label>
    <input type="text" name="father_name" class="form-control" placeholder="Add employee father name" value="<?php echo $personal -> father_name ?>" maxlength="100" required="required">
</div>
<div class="form-group col-lg-4">
    <label for="exampleInputEmail1">Mother Name</label>
    <input type="text" name="mother_name" class="form-control" placeholder="Add employee mother name" value="<?php echo $personal -> mother_name ?>" maxlength="100">
</div>
<div class="form-group col-lg-2">
    <label for="exampleInputEmail1">Gender</label>
    <select name="gender" class="form-control select2me">
        <option value="1" <?php if($personal -> gender == '1') echo 'selected="selected"' ?>>Male</option>
        <option value="0" <?php if($personal -> gender == '0') echo 'selected="selected"' ?>>Female</option>
    </select>
</div>
<div class="form-group col-lg-3">
    <label for="exampleInputEmail1">Date of Birth</label>
    <input type="text" name="dob" class="form-control date-picker" placeholder="Add employee date of birth" value="<?php echo date('m/d/Y', strtotime($personal -> dob)) ?>">
</div>
<div class="form-group col-lg-3">
    <label for="exampleInputEmail1">Place of Birth</label>
    <input type="text" name="birth_place" class="form-control" placeholder="Add employee place of birth" value="<?php echo $personal -> birth_place ?>">
</div>
<div class="form-group col-lg-2">
    <label for="exampleInputEmail1">Martial Status</label>
    <select name="martial_status" class="form-control select2me">
        <option value="Single" <?php if($personal -> martial_status == 'Single') echo 'selected="selected"' ?>>Single</option>
        <option value="Married" <?php if($personal -> martial_status == 'Married') echo 'selected="selected"' ?>>Married</option>
        <option value="Divorced" <?php if($personal -> martial_status == 'Divorced') echo 'selected="selected"' ?>>Divorced</option>
    </select>
</div>
<div class="form-group col-lg-2">
    <label for="exampleInputEmail1">Religion</label>
    <select name="religion" class="form-control select2me">
        <option value="Muslim" <?php if($personal -> religion == 'Muslim') echo 'selected="selected"' ?>>Muslim</option>
        <option value="Christan" <?php if($personal -> religion == 'Christan') echo 'selected="selected"' ?>>Christan</option>
        <option value="Hindu" <?php if($personal -> religion == 'Hindu') echo 'selected="selected"' ?>>Hindu</option>
    </select>
</div>
<div class="form-group col-lg-3">
    <label for="exampleInputEmail1">Nationality</label>
    <input type="text" name="nationality" class="form-control" placeholder="Add employee nationality" maxlength="13" value="<?php echo $personal -> nationality ?>">
</div>
<div class="form-group col-lg-3">
    <label for="exampleInputEmail1">CNIC</label>
    <input type="text" name="cnic" class="form-control" placeholder="Add employee cnic" maxlength="13" value="<?php echo $personal -> cnic ?>" required="required">
</div>
<div class="form-group col-lg-3">
    <label for="exampleInputEmail1">Tel (Land Line)</label>
    <input type="text" name="residence_mobile" class="form-control" placeholder="Add employee residence mobile" value="<?php echo $personal -> residence_mobile ?>">
</div>
<div class="form-group col-lg-3">
    <label for="exampleInputEmail1">Mobile #1</label>
    <input type="text" name="mobile" class="form-control" placeholder="Add employee mobile" value="<?php echo $personal -> mobile ?>">
</div>
<div class="form-group col-lg-3">
    <label for="exampleInputEmail1">Mobile #2</label>
    <input type="text" name="mobile_2" class="form-control" placeholder="Add employee mobile" value="<?php echo $personal -> mobile_2 ?>">
</div>
<div class="form-group col-lg-3">
    <label for="exampleInputEmail1">Email Address</label>
    <input type="email" name="email" class="form-control" placeholder="Add employee email" value="<?php echo $personal -> email ?>">
</div>
<div class="form-group col-lg-6">
    <label for="exampleInputEmail1">Residential Address</label>
    <input type="text" name="permanent_address" class="form-control" placeholder="Employee residential address" required="required" value="<?php echo $personal -> permanent_address ?>">
</div>
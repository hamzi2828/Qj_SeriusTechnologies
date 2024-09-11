<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <?php if ( validation_errors () != false ) { ?>
            <div class="alert alert-danger validation-errors">
                <?php echo validation_errors (); ?>
            </div>
        <?php } ?>
        <?php if ( $this -> session -> flashdata ( 'error' ) ) : ?>
            <div class="alert alert-danger">
                <?php echo $this -> session -> flashdata ( 'error' ) ?>
            </div>
        <?php endif; ?>
        <?php if ( $this -> session -> flashdata ( 'response' ) ) : ?>
            <div class="alert alert-success">
                <?php echo $this -> session -> flashdata ( 'response' ) ?>
            </div>
        <?php endif; ?>
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-reorder"></i> Edit Panel Patient
                </div>
            </div>
            <div class="portlet-body form">
                <div class="alert alert-danger" id="patient-info" style="display: none"></div>
                <form role="form" method="post" autocomplete="off">
                    <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                           value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
                    <input type="hidden" name="action" value="do_edit_patient">
                    <input type="hidden" name="patient_id" value="<?php echo $patient -> id ?>">
                    <div class="form-body" style="overflow: auto">
                        <input type="hidden" name="type" value="panel">
                        <div class="form-group col-lg-2">
                            <label for="exampleInputEmail1">Prefix</label>
                            <select name="prefix" class="form-control select2me">
                                <option value="Mr." <?php if ( $patient -> prefix == 'Mr.' )
                                    echo 'selected="selected"' ?>>Mr.
                                </option>
                                <option value="Mrs." <?php if ( $patient -> prefix == 'Mrs.' )
                                    echo 'selected="selected"' ?>>Mrs.
                                </option>
                                <option value="Ms." <?php if ( $patient -> prefix == 'Ms.' )
                                    echo 'selected="selected"' ?>>Ms.
                                </option>
                                <option value="Master." <?php if ( $patient -> prefix == 'Master.' )
                                    echo 'selected="selected"' ?>>Master.
                                </option>
                                <option value="Mst." <?php if ( $patient -> prefix == 'Mst.' )
                                    echo 'selected="selected"' ?>>Mst.
                                </option>
                            </select>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="exampleInputEmail1">Patient Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Add patient name"
                                   autofocus="autofocus" value="<?php echo $patient -> name ?>" maxlength="100"
                                   required="required">
                        </div>
                        <div class="form-group col-lg-2">
                            <label for="exampleInputEmail1">Relationship</label>
                            <select name="relationship" class="form-control select2me">
                                <option value="S/O" <?php echo ( $patient -> relationship == 'S/O' ) ? 'selected="selected"' : '' ?>>
                                    S/O
                                </option>
                                <option value="D/O" <?php echo ( $patient -> relationship == 'D/O' ) ? 'selected="selected"' : '' ?>>
                                    D/O
                                </option>
                                <option value="F/O" <?php echo ( $patient -> relationship == 'F/O' ) ? 'selected="selected"' : '' ?>>
                                    F/O
                                </option>
                                <option value="W/O" <?php echo ( $patient -> relationship == 'W/O' ) ? 'selected="selected"' : '' ?>>
                                    W/O
                                </option>
                                <option value="M/O" <?php echo ( $patient -> relationship == 'M/O' ) ? 'selected="selected"' : '' ?>>
                                    M/O
                                </option>
                            </select>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="exampleInputEmail1">Guardian Name</label>
                            <input type="text" name="father_name" class="form-control" placeholder="Guardian Name"
                                   value="<?php echo $patient -> father_name ?>">
                        </div>
                        <div class="form-group col-lg-2">
                            <label for="exampleInputEmail1">Martial Status</label>
                            <select name="martial_status" class="form-control">
                                <option value="single" <?php if ( $patient -> martial_status == 'single' )
                                    echo 'selected="selected"' ?>>Single
                                </option>
                                <option value="married" <?php if ( $patient -> martial_status == 'married' )
                                    echo 'selected="selected"' ?>>Married
                                </option>
                                <option value="divorced" <?php if ( $patient -> martial_status == 'divorced' )
                                    echo 'selected="selected"' ?>>Divorced
                                </option>
                            </select>
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="exampleInputEmail1">Blood Group</label>
                            <select name="blood_group" class="form-control">
                                <option>Select</option>
                                <option value="A-" <?php if ( $patient -> blood_group == 'A-' )
                                    echo 'selected="selected"' ?>>A-
                                </option>
                                <option value="A+" <?php if ( $patient -> blood_group == 'A+' )
                                    echo 'selected="selected"' ?>>A+
                                </option>
                                <option value="B-" <?php if ( $patient -> blood_group == 'B-' )
                                    echo 'selected="selected"' ?>>B-
                                </option>
                                <option value="B+" <?php if ( $patient -> blood_group == 'B+' )
                                    echo 'selected="selected"' ?>>B+
                                </option>
                                <option value="AB-" <?php if ( $patient -> blood_group == 'AB-' )
                                    echo 'selected="selected"' ?>>AB-
                                </option>
                                <option value="AB+" <?php if ( $patient -> blood_group == 'AB+' )
                                    echo 'selected="selected"' ?>>AB+
                                </option>
                                <option value="O-" <?php if ( $patient -> blood_group == 'O-' )
                                    echo 'selected="selected"' ?>>O-
                                </option>
                                <option value="O+" <?php if ( $patient -> blood_group == 'O+' )
                                    echo 'selected="selected"' ?>>O+
                                </option>
                            </select>
                        </div>
                        <div class="form-group col-lg-4 hidden">
                            <label for="exampleInputEmail1">Religion</label>
                            <input type="text" name="religion" class="form-control" placeholder="Religion"
                                   value="<?php echo $patient -> religion ?>">
                        </div>
                        <div class="form-group col-lg-4">
                            <label class="">Patient Gender</label>
                            <div class="radio-list">
                                <label class="radio-inline">
                                    <input type="radio" name="gender" id="optionsRadios4"
                                           value="1" <?php if ( $patient -> gender == '1' )
                                        echo 'checked="checked"' ?>> Male
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="gender" id="optionsRadios5"
                                           value="0" <?php if ( $patient -> gender == '0' )
                                        echo 'checked="checked"' ?>> Female
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="gender" id="optionsRadios5"
                                           value="2" <?php if ( $patient -> gender == '2' )
                                        echo 'checked="checked"' ?>> MC
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="gender" id="optionsRadios5"
                                           value="3" <?php if ( $patient -> gender == '3' )
                                        echo 'checked="checked"' ?>> FC
                                </label>
                            </div>
                        </div>
                        <div class="form-group col-lg-2">
                            <label for="exampleInputEmail1">Age</label>
                            <input type="number" name="age" class="form-control" placeholder="Age"
                                   maxlength="3" value="<?php echo $patient -> age ?>"
                                   required="required">
                        </div>
                        <div class="form-group col-lg-2">
                            <label for="exampleInputEmail1">Year/Month</label>
                            <select name="age_year_month" class="form-control">
                                <option value="years" <?php if ( $patient -> age_year_month == 'years' )
                                    echo 'selected="selected"' ?>>Years
                                </option>
                                <option value="year" <?php if ( $patient -> age_year_month == 'year' )
                                    echo 'selected="selected"' ?>>Year
                                </option>
                                <option value="months" <?php if ( $patient -> age_year_month == 'months' )
                                    echo 'selected="selected"' ?>>Months
                                </option>
                                <option value="month" <?php if ( $patient -> age_year_month == 'month' )
                                    echo 'selected="selected"' ?>>Month
                                </option>
                                <option value="days" <?php if ( $patient -> age_year_month == 'days' )
                                    echo 'selected="selected"' ?>>Days
                                </option>
                                <option value="day" <?php if ( $patient -> age_year_month == 'day' )
                                    echo 'selected="selected"' ?>>Day
                                </option>
                            </select>
                        </div>
                        <div class="form-group col-lg-2">
                            <label for="exampleInputEmail1">Date of Birth</label>
                            <input type="text" name="dob" class="form-control" placeholder="Date of birth"
                                   readonly="readonly"
                                   value="<?php echo $patient -> dob != '0000-00-00' ? date ( 'm/d/Y', strtotime ( $patient -> dob ) ) : '' ?>">
                        </div>
                        <div class="form-group col-lg-2">
                            <label for="exampleInputEmail1">Patient CNIC</label>
                            <input type="text" name="cnic" class="form-control cnic" placeholder="Add patient cnic"
                                   maxlength="15" value="<?php echo $patient -> cnic ?>"
                                   onchange="check_customer_exists_by_cnic(this.value)"
                                   data-inputmask="'mask': '99999-9999999-9'">
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="exampleInputEmail1">Passport</label>
                            <input type="text" name="passport" class="form-control" placeholder="Passport"
                                   maxlength="11" value="<?php echo $patient -> passport ?>">
                        </div>
                        <div class="form-group col-lg-2">
                            <label for="exampleInputEmail1">Country</label>
                            <input type="text" name="country" class="form-control" placeholder="Country"
                                   value="<?php echo 'Pakistan' ?>">
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="exampleInputEmail1">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Add patient email"
                                   value="<?php echo $patient -> email ?>">
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="exampleInputEmail1">Company</label>
                            <select name="company_id" class="form-control select2me" required="required"
                                    onchange="get_company_panels(this.value)">
                                <option value=""></option>
                                <?php
                                    if ( count ( $companies ) > 0 ) {
                                        foreach ( $companies as $company ) {
                                            ?>
                                            <option value="<?php echo $company -> id ?>" <?php if ( $patient -> company_id == $company -> id )
                                                echo 'selected="selected"' ?>>
                                                <?php echo $company -> name ?>
                                            </option>
                                            <?php
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-lg-6 panels">
                            <label for="exampleInputEmail1">Panel</label>
                            <select name="panel_id" class="form-control select2me" required="required">
                                <?php if ( is_numeric ( $patient -> panel_id ) && $patient -> panel_id > 0 ) : ?>
                                    <option value="<?php echo $patient -> panel_id ?>">
                                        <?php echo get_panel_by_id ( $patient -> panel_id ) -> name ?>
                                    </option>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="exampleInputEmail1">Patient Phone</label>
                            <input type="text" name="phone" class="form-control" placeholder="Add patient phone"
                                   maxlength="11" value="<?php echo $patient -> mobile ?>">
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="exampleInputEmail1">City</label>
                            <select name="city" class="form-control select2me">
                                <option value="">Select</option>
                                <?php
                                    if ( count ( $cities ) > 0 ) {
                                        foreach ( $cities as $city ) {
                                            ?>
                                            <option value="<?php echo $city -> id ?>" <?php if ( $patient -> city == $city -> id )
                                                echo 'selected="selected"' ?>>
                                                <?php echo $city -> title ?>
                                            </option>
                                            <?php
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="exampleInputEmail1">Consultant</label>
                            <select name="doctor_id" class="form-control select2me">
                                <option value="">Select</option>
                                <?php
                                    if ( count ( $doctors ) > 0 ) {
                                        foreach ( $doctors as $doctor ) {
                                            ?>
                                            <option value="<?php echo $doctor -> id ?>" <?php if ( $patient -> doctor_id == $doctor -> id )
                                                echo 'selected="selected"' ?>><?php echo $doctor -> name ?></option>
                                            <?php
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="exampleInputEmail1">OPD Service</label>
                            <select name="service_id" class="form-control select2me">
                                <option value="">Select</option>
                                <?php
                                    if ( count ( $services ) > 0 ) {
                                        foreach ( $services as $service ) {
                                            ?>
                                            <option value="<?php echo $service -> id ?>" <?php if ( $patient -> service_id == $service -> id )
                                                echo 'selected="selected"' ?>><?php echo $service -> title ?></option>
                                            <?php
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-lg-12">
                            <h3 style="font-weight: 600 !important;"> Permanent Address </h3>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="exampleInputEmail1">Nationality</label>
                            <input type="text" name="nationality" class="form-control" placeholder="Nationality"
                                   value="<?php echo 'Pakistani' ?>">
                        </div>
                        <div class="form-group col-lg-5">
                            <label for="exampleInputEmail1">Address</label>
                            <textarea class="form-control" rows="5"
                                      name="address"><?php echo $patient -> address ?></textarea>
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="exampleInputEmail1">Picture</label>
                            <?php if ( !empty( trim ( $patient -> picture ) ) ) : ?>
                                <img src="<?php echo $patient -> picture ?>"
                                     style="width: 100px; display: block; margin-bottom: 10px;">
                            <?php endif ?>
                            <input type="file" class="form-control" name="picture">
                            <p style="margin-top: 5px; color: #FF0000;">Upload Image (Max. 2MB)</p>
                        </div>
                        <div class="col-lg-12">
                            <h3 style="font-weight: 600 !important;"> Emergency Address </h3>
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="exampleInputEmail1">Name</label>
                            <input type="text" name="emergency_person_name" class="form-control" placeholder="Name"
                                   value="<?php echo $patient -> emergency_person_name ?>">
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="exampleInputEmail1">Number</label>
                            <input type="text" name="emergency_person_number" class="form-control"
                                   placeholder="Mobile Number"
                                   value="<?php echo $patient -> emergency_person_number ?>">
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="exampleInputEmail1">Relation</label>
                            <input type="text" name="emergency_person_relation" class="form-control"
                                   placeholder="Relation" value="<?php echo $patient -> emergency_person_relation ?>">
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn blue" id="patient-reg-btn">Update</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>
<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-reorder"></i> Edit Patient
                </div>
            </div>
            <div class="portlet-body form">
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
                <div class="alert alert-danger" id="patient-info" style="display: none"></div>
                <form role="form" method="post" autocomplete="off">
                    <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                           value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
                    <input type="hidden" name="action" value="do_edit_patient">
                    <input type="hidden" name="patient_id" value="<?php echo $patient -> id ?>">
                    <div class="form-body" style="overflow: auto">
                        <div class="form-group col-lg-4">
                            <label class="">Patient Type</label>
                            <div class="radio-list">
                                <label class="radio-inline">
                                    <input type="radio" name="type" value="cash"
                                           onchange="load_form(this.value)" <?php echo ( $patient -> type == 'cash' ) ? 'checked="checked"' : '' ?>> Cash
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="type" value="panel"
                                           onchange="load_form(this.value)" <?php echo ( $patient -> type == 'panel' ) ? 'checked="checked"' : '' ?>> Panel
                                </label>
                            </div>
                        </div>
                        <div class="form-group col-lg-4">
                            <label class="">Patient Gender</label>
                            <div class="radio-list">
                                <label class="radio-inline">
                                    <input type="radio" name="gender" id="optionsRadios4"
                                           value="1" <?php echo ( $patient -> gender == '1' ) ? 'checked="checked"' : '' ?>> Male
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="gender" id="optionsRadios5"
                                           value="0" <?php echo ( $patient -> gender == '0' ) ? 'checked="checked"' : '' ?>> Female
                                </label>
                            </div>
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="exampleInputEmail1">Patient Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Add patient name"
                                   autofocus="autofocus" value="<?php echo $patient -> name ?>" maxlength="100"
                                   required="required">
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="exampleInputEmail1">Patient CNIC</label>
                            <input type="text" name="cnic" class="form-control cnic" placeholder="Add patient cnic"
                                   maxlength="15" value="<?php echo $patient -> cnic ?>"
                                   data-inputmask="'mask': '99999-9999999-9'">
                        </div>
                        <div id="panel-detail-fields"></div>
                        <div class="form-group col-lg-3">
                            <label for="exampleInputEmail1">Patient Phone</label>
                            <input type="text" name="phone" class="form-control" placeholder="Add patient phone"
                                   maxlength="11" value="<?php echo $patient -> mobile ?>">
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="exampleInputEmail1">Patient Age</label>
                            <input type="text" name="age" class="form-control" placeholder="Add patient age"
                                   value="<?php echo $patient -> age ?>" required="required">
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
                                                echo 'selected="selected"' ?>><?php echo $city -> title ?></option>
                                            <?php
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-lg-12">
                            <label for="exampleInputEmail1">Address</label>
                            <textarea class="form-control" rows="5" name="address"></textarea>
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
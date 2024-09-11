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
                    <i class="fa fa-reorder"></i> Add User
                </div>
            </div>
            <div class="portlet-body form">
                <form role="form" method="post" autocomplete="off">
                    <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                           value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
                    <input type="hidden" name="action" value="do_register_member">
                    <div class="form-body" style="overflow: auto">
                        <div class="form-group col-lg-4">
                            <label for="exampleInputEmail1">Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Add member name"
                                   autofocus="autofocus" value="<?php echo set_value ( 'name' ) ?>" maxlength="100"
                                   required="required">
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="exampleInputEmail1">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Add member name"
                                   value="<?php echo set_value ( 'email' ) ?>" maxlength="100">
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="exampleInputEmail1">Phone</label>
                            <input type="text" name="phone" class="form-control" placeholder="Add member name"
                                   value="<?php echo set_value ( 'phone' ) ?>" maxlength="100">
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="exampleInputEmail1">Password</label>
                            <input type="password" name="password" class="form-control"
                                   placeholder="Add member password" required="required">
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="exampleInputEmail1">CNIC</label>
                            <input type="text" name="cnic" class="form-control" placeholder="Add member cnic"
                                   maxlength="13" value="<?php echo set_value ( 'cnic' ) ?>">
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="exampleInputEmail1">Gender</label>
                            <select name="gender" class="form-control select2me">
                                <option value="">Select Gender</option>
                                <option value="1">Male</option>
                                <option value="0">Female</option>
                            </select>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="exampleInputEmail1">Department</label>
                            <select name="department_id" class="form-control select2me">
                                <option value="">Select</option>
                                <?php
                                    if ( count ( $departments ) > 0 ) {
                                        foreach ( $departments as $department ) {
                                            ?>
                                            <option value="<?php echo $department -> id ?>">
                                                <?php echo $department -> name ?>
                                            </option>
                                            <?php
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-lg-12">
                            <label for="exampleInputEmail1">Address</label>
                            <textarea name="address" class="form-control" rows="5"
                                      placeholder="Member address"><?php echo set_value ( 'address' ) ?></textarea>
                        </div>
                        <?php require_once 'access.php'; ?>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn blue" id="patient-reg-btn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>
<style>
    .table-bordered > thead > tr > th, .table-bordered > tbody > tr > th, .table-bordered > tfoot > tr > th, .table-bordered > thead > tr > td, .table-bordered > tbody > tr > td, .table-bordered > tfoot > tr > td {
        border: 1px solid #ddd;
        text-transform: capitalize;
    }
</style>
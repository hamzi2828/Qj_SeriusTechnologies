<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <div class="alert alert-danger panel-info hidden"></div>
        <div class="alert alert-danger panel-discount-info hidden"></div>
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
        <form method="post">
            <input type="hidden" name="action" value="do_add_refer_outside">
            <input type="hidden" id="panel_id" name="panel_id" value="">
            <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                   value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
            <input type="hidden" id="added" value="1">
            
            <div class="portlet box green">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-globe"></i> Add Refer Outside
                    </div>
                </div>
                <div class="portlet-body" style="overflow: hidden">
                    <div class="row">
                        <div style="display: flex; width: 100%; border-bottom: 1px solid #d5d5d5; float: left; margin-bottom: 15px;">
                            <div class="form-group col-lg-2" style="position: relative">
                                <label for="exampleInputEmail1">MR No.</label>
                                <input type="text" name="patient_id" class="form-control patient-id"
                                       placeholder="Enter MR after <?php echo emr_prefix ?> e.g 5240"
                                       autofocus="autofocus"
                                       style="padding-left: 85px;"
                                       value="<?php echo @$_GET[ 'patient' ] ?>"
                                       required="required" id="prn"
                                       onchange="get_patient_and_load_tests ( this.value )">
                                <label style="position: absolute;top: 25px;background: #e3e3e3;padding: 7px 25px;">MR-</label>
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="exampleInputEmail1">Patient Name</label>
                                <input type="text" class="form-control" readonly="readonly" id="patient-name">
                            </div>
                            <div class="form-group col-lg-2">
                                <label for="exampleInputEmail1">Patient CNIC</label>
                                <input type="text" class="form-control" readonly="readonly" id="patient-cnic">
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="exampleInputEmail1">Reference</label>
                                <select name="doctor-id" class="form-control select2me">
                                    <option value="">Select</option>
                                    <?php
                                        if ( count ( $doctors ) > 0 ) {
                                            foreach ( $doctors as $doctor ) {
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
                            <div class="form-group col-lg-2">
                                <label for="exampleInputEmail1">Branch</label>
                                <input type="text" class="form-control" name="branch"
                                       value="<?php echo set_value ( 'branch' ) ?>">
                            </div>
                            <div class="form-group col-lg-2">
                                <label for="exampleInputEmail1">Invoice ID#</label>
                                <input type="text" class="form-control" name="invoice-id"
                                       value="<?php echo set_value ( 'invoice-id' ) ?>">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <select class="form-control" required="required" id="lab-tests-sale"
                                    data-placeholder="Select"
                                    onchange="add_refer_outside(this.value)">
                                <option></option>
                            </select>
                        </div>
                        
                        <div class="col-md-8">
                            <div class="add-more"></div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="form-actions">
                            <button type="submit" class="btn blue">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
<style>
    .form-actions {
        float: left;
        width: 100%;
    }
</style>
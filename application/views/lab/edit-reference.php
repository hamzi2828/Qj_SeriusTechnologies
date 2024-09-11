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
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="col-sm-12" style="padding-left: 0">
            <div class="portlet box green">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-globe"></i> Edit Reference Sale# <?php echo $sale -> id ?>
                    </div>
                </div>
                <div class="portlet-body">
                    <form role="form" method="post" autocomplete="off">
                        <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                               value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
                        <input type="hidden" name="action" value="do_edit_sale_reference">
                        <input type="hidden" name="id" value="<?php echo $sale -> id ?>">
                        
                        <div class="form-body" style="background: #FFFFFF">
                            <div class="row">
                                <div class="form-group col-lg-4">
                                    <label for="exampleInputEmail1">Referred By</label>
                                    <select name="reference-id" class="form-control select2me" data-placeholder="Select"
                                            required="required">
                                        <option></option>
                                        <?php
                                            if ( count ( $doctors ) > 0 ) {
                                                foreach ( $doctors as $doctor ) {
                                                    ?>
                                                    <option value="<?php echo $doctor -> id ?>"
                                                        <?php echo $doctor -> id == $sale -> reference_id ? 'selected="selected"' : '' ?>>
                                                        <?php echo $doctor -> name ?>
                                                    </option>
                                                    <?php
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn blue" id="patient-reg-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
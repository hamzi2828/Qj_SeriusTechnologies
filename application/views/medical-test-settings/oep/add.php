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
                    <i class="fa fa-reorder"></i> <?php echo $title ?>
                </div>
            </div>
            <div class="portlet-body form">
                <form role="form" method="post" autocomplete="off">
                    <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                           value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
                    <input type="hidden" name="action" value="store_oep">
                    
                    <div class="form-body" style="background: #FFFFFF !important;">
                        <div class="row">
                            <div class="form-group col-lg-3">
                                <label for="prefix">Prefix</label>
                                <input type="text" name="prefix" class="form-control" id="prefix"
                                       autofocus="autofocus" value="<?php echo set_value ( 'prefix', 'QJ-' ) ?>"
                                       required="required">
                            </div>
                            
                            <div class="form-group col-lg-3">
                                <label for="name">Name</label>
                                <input type="text" name="name" class="form-control" id="name"
                                       value="<?php echo set_value ( 'name' ) ?>"
                                       required="required">
                            </div>
                            
                            <div class="form-group col-lg-3">
                                <label for="representative">Representative</label>
                                <input type="text" name="representative" class="form-control" id="representative"
                                       value="<?php echo set_value ( 'representative' ) ?>">
                            </div>
                            
                            <div class="form-group col-lg-3">
                                <label for="contact">Contact</label>
                                <input type="text" name="contact" class="form-control" id="contact"
                                       value="<?php echo set_value ( 'contact' ) ?>">
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="price">Price</label>
                                <input type="number" name="price" class="form-control" id="price" step="0.01"
                                    value="<?php echo set_value('price') ?>" required="required">
                            </div>

                            <div class="form-group col-lg-12 mb-0">
                                <label for="address">Address</label>
                                <textarea name="address" class="form-control" rows="5" id="address"
                                          placeholder="Member address"><?php echo set_value ( 'address' ) ?></textarea>
                            </div>
                            
                        </div>
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
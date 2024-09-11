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
            <input type="hidden" name="action" value="do_edit_lab_sale_balance">
            <input type="hidden" name="id" value="<?php echo $sale -> id ?>">
            <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                   value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet box green">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-globe"></i> Edit Lab Sale Balance
                    </div>
                </div>
                <div class="portlet-body" style="overflow: auto">
                    <div class="form-group col-lg-3" style="padding-left: 0">
                        <label>Patient EMR</label>
                        <input type="text" class="form-control" value="<?php echo $patient -> id ?>"
                               readonly="readonly">
                    </div>
                    <div class="form-group col-lg-3">
                        <label>Patient Name</label>
                        <input type="text" class="form-control" value="<?php echo $patient -> name ?>"
                               readonly="readonly">
                    </div>
                    <div class="form-group col-lg-3">
                        <label>Patient Contact No</label>
                        <input type="text" class="form-control" value="<?php echo $patient -> mobile ?>"
                               readonly="readonly">
                    </div>
                    <div class="form-group col-lg-3">
                        <label>Invoice ID</label>
                        <input type="text" class="form-control" value="<?php echo $sale -> id ?>"
                               readonly="readonly">
                    </div>
                    <div class="form-group col-lg-3" style="padding-left: 0">
                        <label>Total Amount</label>
                        <input type="text" class="form-control"
                               value="<?php echo number_format ( $sale -> total, 2 ) ?>"
                               readonly="readonly">
                    </div>
                    <div class="form-group col-lg-3">
                        <label>Discount</label>
                        <input type="text" class="form-control"
                               value="<?php echo $sale -> discount ?>"
                               readonly="readonly">
                    </div>
                    <div class="form-group col-lg-3">
                        <label>Paid Amount</label>
                        <input type="text" class="form-control"
                               value="<?php echo $sale -> paid_amount ?>" name="paid_amount" autofocus="autofocus">
                    </div>
                    <div class="form-group col-lg-3">
                        <label>Balance</label>
                        <input type="text" class="form-control"
                               value="<?php echo number_format ( $sale -> total - $sale -> paid_amount, 2 ) ?>"
                               readonly="readonly">
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn blue">Update</button>
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
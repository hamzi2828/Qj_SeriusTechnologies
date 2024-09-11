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
        
        <form method="get" autocomplete="off">
            <div class="sale">
                <div class="form-group col-lg-3" style="position: relative">
                    <label for="patient-name">Patient Name</label>
                    <input type="text" name="patient-name" class="form-control" id="patient-name"
                           autofocus="autofocus" value="<?php echo $this -> input -> get ( 'patient-name' ) ?>">
                </div>
                <div class="form-group col-lg-2" style="position: relative">
                    <label for="invoice-id">Invoice ID#</label>
                    <input type="text" name="invoice-id" class="form-control" id="invoice-id"
                           value="<?php echo $this -> input -> get ( 'invoice-id' ) ?>">
                </div>
                <div class="form-group col-lg-3" style="position: relative">
                    <label for="branch">Branch</label>
                    <input type="text" name="branch" class="form-control" id="branch"
                           value="<?php echo $this -> input -> get ( 'branch' ) ?>">
                </div>
                <div class="form-group col-lg-3" style="position: relative">
                    <label for="reference-id">Reference</label>
                    <select name="reference-id" class="form-control select2me" id="reference-id">
                        <option value="">Select</option>
                        <?php
                            if ( count ( $doctors ) > 0 ) {
                                foreach ( $doctors as $doctor ) {
                                    ?>
                                    <option value="<?php echo $doctor -> id ?>"
                                        <?php echo $this -> input -> get ( 'reference-id' ) == $doctor -> id ? 'selected="selected"' : '' ?>>
                                        <?php echo $doctor -> name ?>
                                    </option>
                                    <?php
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group col-lg-1">
                    <button type="submit" class="btn btn-primary" style="margin-top: 25px;">Search</button>
                </div>
            </div>
        </form>
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="col-sm-12" style="padding-left: 0">
            <div class="portlet box green">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-globe"></i> All Refer Outside
                    </div>
                </div>
                <div class="portlet-body">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                            <th> Sr. No</th>
                            <th> EMR#</th>
                            <th> Patient Name</th>
                            <th> Patient Type</th>
                            <th> Reference</th>
                            <th> Date</th>
                            <th> Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            $counter = 1 + ( isset( $_REQUEST[ 'per_page' ] ) ? $_REQUEST[ 'per_page' ] : 0 );
                            if ( count ( $sales ) > 0 ) {
                                foreach ( $sales as $sale ) {
                                    $patient  = get_patient ( $sale -> patient_id );
                                    $panel_id = $patient -> panel_id;
                                    ?>
                                    <tr>
                                        <td><?php echo $counter++; ?></td>
                                        <td><?php echo $sale -> patient_id; ?></td>
                                        <td><?php echo $patient -> name; ?></td>
                                        <td>
                                            <?php
                                                echo ucfirst ( $patient -> type );
                                                echo ( $panel_id > 0 ) ? ' / ' . get_panel_by_id ( $panel_id ) -> name : '';
                                            ?>
                                        </td>
                                        <td><?php echo @get_doctor ( $sale -> doctor_id ) -> name; ?></td>
                                        <td><?php echo date_setter ( $sale -> created_at ) ?></td>
                                        <td class="btn-group-xs">
                                            <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'print-refer-outside', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                                <a href="<?php echo base_url ( 'invoices/outside-refer-invoice/' . $sale -> id ) ?>"
                                                   class="btn purple" target="_blank">
                                                    Print
                                                </a>
                                            <?php endif; ?>
                                            
                                            <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'delete-refer-outside', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                                <a href="<?php echo base_url ( '/lab/delete-outside-refer/' . $sale -> id ) ?>"
                                                   onclick="confirm('Are you sure? Action will be permanent.')"
                                                   class="btn red">
                                                    Delete
                                                </a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                        ?>
                        </tbody>
                    </table>
                </div>
                <div id="pagination">
                    <ul class="tsc_pagination">
                        <!-- Show pagination links -->
                        <?php foreach ( $links as $link ) {
                            echo "<li>" . $link . "</li>";
                        } ?>
                </div>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
<style>
    tr.refunded td {
        background-color: rgb(228 242 11 / 63%) !important;
    }
</style>
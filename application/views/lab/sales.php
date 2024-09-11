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
            <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                   value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
            <div class="sale">
                <div class="form-group col-lg-2" style="position: relative">
                    <label for="exampleInputEmail1">Sale ID#</label>
                    <input type="text" name="sale_id" class="form-control" placeholder="Enter sale number"
                           autofocus="autofocus" value="<?php echo @$_REQUEST[ 'sale_id' ] ?>">
                </div>
                <div class="form-group col-lg-2" style="position: relative">
                    <label for="exampleInputEmail1">Patient EMR</label>
                    <input type="text" name="patient_id" class="form-control" placeholder="Enter patient EMR"
                           autofocus="autofocus" value="<?php echo @$_REQUEST[ 'patient_id' ] ?>">
                </div>
                <div class="form-group col-lg-3" style="position: relative">
                    <label for="exampleInputEmail1">Patient Name</label>
                    <input type="text" name="patient_name" class="form-control" placeholder="Enter patient name"
                           autofocus="autofocus" value="<?php echo @$_REQUEST[ 'patient_name' ] ?>">
                </div>
                <div class="form-group col-lg-2">
                    <label for="exampleInputEmail1">Start Date</label>
                    <input type="text" name="start_date" class="form-control date-picker"
                           value="<?php echo ( isset( $_REQUEST[ 'start_date' ] ) and !empty( trim ( $_REQUEST[ 'start_date' ] ) ) ) ? date ( 'm/d/Y', strtotime ( $_REQUEST[ 'start_date' ] ) ) : '' ?>">
                </div>
                <div class="form-group col-lg-2">
                    <label for="exampleInputEmail1">End Date</label>
                    <input type="text" name="end_date" class="form-control date-picker"
                           value="<?php echo ( isset( $_REQUEST[ 'end_date' ] ) and !empty( trim ( $_REQUEST[ 'end_date' ] ) ) ) ? date ( 'm/d/Y', strtotime ( $_REQUEST[ 'end_date' ] ) ) : '' ?>">
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
                        <i class="fa fa-globe"></i> Sale Tests
                    </div>
                </div>
                <div class="portlet-body">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                            <th> Sr. No</th>
                            <th> Sale ID</th>
                            <th> EMR#</th>
                            <th> Patient Name</th>
                            <th> Patient Type</th>
                            <th> Reference</th>
                            <th> Code</th>
                            <th> Name</th>
                            <th> TAT</th>
                            <th> Price</th>
                            <th> Discount(%)</th>
                            <th> Net Price</th>
                            <th> Remarks</th>
                            <th> Date</th>
                            <th> Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            if ( count ( $sales ) > 0 ) {
                                $counter = 1;
                                foreach ( $sales as $sale ) {
                                    $sale_info = get_lab_sale ( $sale -> sale_id );
                                    $patient   = get_patient ( $sale -> patient_id );
                                    $saleTotal = get_lab_sales_total ( $sale -> sale_id );
                                    $panel_id  = $patient -> panel_id;
                                    ?>
                                    <tr class="<?php echo $sale -> refunded == '1' ? 'refunded' : '' ?>">
                                        <td><?php echo $counter++; ?></td>
                                        <td><?php echo $sale -> sale_id; ?></td>
                                        <td><?php echo $sale -> patient_id; ?></td>
                                        <td>
                                            <?php
                                                echo $patient -> name;
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                                echo ucfirst ( $patient -> type );
                                                if ( $panel_id > 0 )
                                                    echo ' / ' . get_panel_by_id ( $panel_id ) -> name;
                                            ?>
                                        </td>
                                        <td>
                                            <?php echo @get_doctor ( $sale_info -> reference_id ) -> name ?>
                                        </td>
                                        <td>
                                            <?php
                                                $tests = explode ( ',', $sale -> tests );
                                                if ( count ( $tests ) > 0 ) {
                                                    foreach ( $tests as $test_id ) {
                                                        $test = get_test_by_id ( $test_id );
                                                        echo $test -> code . '<br>';
                                                    }
                                                }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                                $tests = explode ( ',', $sale -> tests );
                                                if ( count ( $tests ) > 0 ) {
                                                    foreach ( $tests as $test_id ) {
                                                        $test = get_test_by_id ( $test_id );
                                                        echo $test -> name . '<br>';
                                                    }
                                                }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                                $tests = explode ( ',', $sale -> tests );
                                                if ( count ( $tests ) > 0 ) {
                                                    foreach ( $tests as $test_id ) {
                                                        $test = get_test_by_id ( $test_id );
                                                        echo $test -> tat . '<br>';
                                                    }
                                                }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                                if ( $sale -> refunded == '1' and !empty( trim ( $sale -> remarks ) ) )
                                                    echo $saleTotal;
                                                else
                                                    echo $sale -> price;
                                            ?>
                                        </td>
                                        <td><?php echo $sale_info -> discount ?></td>
                                        <td><?php echo $sale_info -> total ?></td>
                                        <td><?php echo $sale -> remarks ?></td>
                                        <td><?php echo date_setter ( $sale -> date_added ) ?></td>
                                        <td class="btn-group-xs">
                                            <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'print_lab_sale_invoices', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                                <a href="<?php echo base_url ( '/invoices/lab-sale-invoice/' . $sale -> sale_id . '?logo=false' ) ?>"
                                                   class="btn purple" target="_blank">
                                                    Print
                                                </a>
                                                
                                                <a href="<?php echo base_url ( '/invoices/lab-sale-invoice/' . $sale -> sale_id . '?logo=true' ) ?>"
                                                   class="btn purple" target="_blank">
                                                    L-Print
                                                </a>
                                                
                                                <a href="<?php echo base_url ( '/invoices/ticket/' . $sale -> sale_id ) ?>"
                                                   class="btn green" target="_blank">
                                                    Print Ticket
                                                </a>
                                            <?php endif; ?>
                                            <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'view_lab_sale_invoices', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                                <a href="<?php echo base_url ( '/lab/edit-sale/' . $sale -> sale_id ) ?>"
                                                   class="btn red">
                                                    View
                                                </a>
                                            <?php endif; ?>
                                            <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'edit_lab_sale_reference', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                                <a href="<?php echo base_url ( '/lab/edit-reference/' . $sale -> sale_id ) ?>"
                                                   class="btn red">
                                                    Edit Ref.
                                                </a>
                                            <?php endif; ?>
                                            <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'delete_lab_sale_invoices', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                                <a href="<?php echo base_url ( '/lab/delete-sale/' . $sale -> sale_id ) ?>"
                                                   onclick="confirm('Are you sure? Action will be permanent.')"
                                                   class="btn red">
                                                    Delete
                                                </a>
                                            <?php endif; ?>
                                            <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'refund_lab_sales', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) and $sale -> refunded == '0' ) : ?>
                                                <a href="<?php echo base_url ( '/lab/refund/' . $sale -> sale_id ) ?>"
                                                   class="btn purple">
                                                    Refund
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
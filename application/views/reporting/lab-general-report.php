<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <form role="form" method="get" autocomplete="off">
            <div class="form-body" style="overflow: auto">
                <div class="form-group col-lg-1">
                    <label for="exampleInputEmail1">Sale ID#</label>
                    <input type="text" name="sale_id" class="form-control"
                           value="<?php echo @$_REQUEST[ 'sale_id' ]; ?>">
                </div>
                <div class="form-group col-lg-4">
                    <label for="exampleInputEmail1">Test</label>
                    <select name="test_id" class="form-control select2me">
                        <option value="">Select Test</option>
                        <?php
                            if ( count ( $tests ) > 0 ) {
                                foreach ( $tests as $test ) {
                                    ?>
                                    <option value="<?php echo $test -> id ?>" <?php if ( $test -> id == $_REQUEST[ 'test_id' ] )
                                        echo 'selected="selected"' ?>>
                                        <?php echo $test -> name ?>
                                    </option>
                                    <?php
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group col-lg-3">
                    <label for="exampleInputEmail1">Referred By</label>
                    <select name="doctor_id" class="form-control select2me">
                        <option value="">Select</option>
                        <?php
                            if ( count ( $doctors ) > 0 ) {
                                foreach ( $doctors as $doctor ) {
                                    ?>
                                    <option value="<?php echo $doctor -> id ?>" <?php if ( $doctor -> id == $_REQUEST[ 'doctor_id' ] )
                                        echo 'selected="selected"' ?>><?php echo $doctor -> name ?></option>
                                    <?php
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group col-lg-2">
                    <label for="exampleInputEmail1">Start Date</label>
                    <input type="text" name="start_date" class="form-control date date-picker"
                           value="<?php echo ( isset( $_REQUEST[ 'start_date' ] ) and !empty( $_REQUEST[ 'start_date' ] ) ) ? date ( 'm/d/Y', strtotime ( @$_REQUEST[ 'start_date' ] ) ) : ''; ?>">
                </div>
                <div class="form-group col-lg-2">
                    <label for="exampleInputEmail1">End Date</label>
                    <input type="text" name="end_date" class="form-control date date-picker"
                           value="<?php echo ( isset( $_REQUEST[ 'end_date' ] ) and !empty( $_REQUEST[ 'end_date' ] ) ) ? date ( 'm/d/Y', strtotime ( @$_REQUEST[ 'end_date' ] ) ) : ''; ?>">
                </div>
                <div class="form-group col-lg-2">
                    <label for="exampleInputEmail1">Start Time</label>
                    <select class="form-control" name="start_time">
                        <option value="">Select</option>
                        <?php
                            $times = create_time_range ( '01:00', '23:00', '60 mins', '24' );
                            foreach ( $times as $time ) :
                                ?>
                                <option value="<?php echo $time ?>" <?php if ( $time == @$_REQUEST[ 'start_time' ] )
                                    echo 'selected="selected"' ?>><?php echo $time ?></option>
                            <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group col-lg-2">
                    <label for="exampleInputEmail1">End Time</label>
                    <select class="form-control" name="end_time">
                        <option value="">Select</option>
                        <?php
                            $times = create_time_range ( '01:00', '23:00', '60 mins', '24' );
                            foreach ( $times as $time ) :
                                ?>
                                <option value="<?php echo $time ?>" <?php if ( $time == @$_REQUEST[ 'end_time' ] )
                                    echo 'selected="selected"' ?>><?php echo $time ?></option>
                            <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group col-lg-4">
                    <label for="exampleInputEmail1">Panel</label>
                    <select class="form-control select2me" name="panel-id">
                        <option value="">Select</option>
                        <option value="cash">Regular Cash</option>
                        <?php
                            if ( count ( $panels ) > 0 ) {
                                foreach ( $panels as $panel ) {
                                    ?>
                                    <option value="<?php echo $panel -> id ?>" <?php if ( $panel -> id == @$_REQUEST[ 'panel-id' ] )
                                        echo 'selected="selected"' ?>><?php echo $panel -> name ?></option>
                                    <?php
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group col-lg-3">
                    <label for="exampleInputEmail1">Order By</label>
                    <select class="form-control" name="order">
                        <option value="descending" <?php if ( @$_REQUEST[ 'order' ] == 'descending' )
                            echo 'selected="selected"' ?>>Descending
                        </option>
                        <option value="ascending" <?php if ( @$_REQUEST[ 'order' ] == 'ascending' )
                            echo 'selected="selected"' ?>>Ascending
                        </option>
                    </select>
                </div>
                <div class="form-group col-lg-1">
                    <button type="submit" class="btn btn-block btn-primary" style="margin-top: 25px;">Search</button>
                </div>
            </div>
        </form>
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-reorder"></i> General Report
                </div>
                <?php if ( count ( $reports ) > 0 ) : ?>
                    <a href="<?php echo base_url ( '/invoices/lab-general-invoice?' . $_SERVER[ 'QUERY_STRING' ] ) ?>"
                       class="pull-right print-btn">Print</a>
                <?php endif ?>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th> Sr. No</th>
                        <th> Sale ID#</th>
                        <th> Test</th>
                        <th> Patient</th>
                        <th> Patient Type</th>
                        <th> Price</th>
                        <th> Discount(%)</th>
                        <th> Net Price</th>
                        <th> Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        if ( count ( $reports ) > 0 ) {
                            $counter = 1;
                            $total   = 0;
                            $p_total = 0;
                            foreach ( $reports as $report ) {
                                $patient = get_patient ( $report -> patient_id );
                                $sale    = get_lab_sale ( $report -> sale_id );
                                $total   = $total + $sale -> total;
                                $p_total = $p_total + $report -> price;
                                $tests   = explode ( ',', $report -> tests );
                                ?>
                                <tr class="<?php echo $report -> refunded == '1' ? 'refunded' : '' ?>">
                                    <td> <?php echo $counter++ ?> </td>
                                    <td> <?php echo $report -> sale_id ?> </td>
                                    <td>
                                        <?php
                                            if ( count ( $tests ) > 0 ) {
                                                foreach ( $tests as $test ) {
                                                    if ( !check_if_test_is_child ( $test ) )
                                                        echo get_test_by_id ( $test ) -> name . '<br>';
                                                }
                                            } ?>
                                    </td>
                                    <td> <?php echo $patient -> name ?> </td>
                                    <td>
                                        <?php
                                            echo ucfirst ( $patient -> type );
                                            if ( $patient -> panel_id > 0 )
                                                echo ' / ' . get_panel_by_id ( $patient -> panel_id ) -> name;
                                        ?>
                                    </td>
                                    <td> <?php echo $report -> price ?> </td>
                                    <td> <?php echo $sale -> discount ?> </td>
                                    <td> <?php echo $sale -> total ?> </td>
                                    <td> <?php echo date_setter ( $report -> date_added ) ?> </td>
                                </tr>
                                <?php
                            }
                            ?>
                            <tr>
                                <td colspan="5" class="text-right"><b>Total</b></td>
                                <td><?php echo $p_total ?></td>
                                <td class="text-right"><b>Net Total</b></td>
                                <td><?php echo $total ?></td>
                                <td></td>
                            </tr>
                            <?php
                        }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>
<style>
    tr.refunded td {
        background-color: rgb(228 242 11 / 63%) !important;
    }
</style>
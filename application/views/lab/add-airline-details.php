<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN SAMPLE FORM PORTLET-->
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
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-reorder"></i> Add Airline Details
                </div>
            </div>
            <div class="portlet-body form">
                <form role="form" method="post" autocomplete="off" enctype="multipart/form-data">
                    <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                           value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
                    <?php if ( !empty( $travel ) ) : ?>
                        <input type="hidden" name="action" value="edit_airline_details">
                    <?php else : ?>
                        <input type="hidden" name="action" value="add_airline_details">
                    <?php endif; ?>
                    <input type="hidden" name="sale-id" value="<?php echo $_REQUEST[ 'sale-id' ] ?>">
                    <div class="form-body" style="overflow: auto">
                        
                        <div class="form-group col-lg-2">
                            <label for="exampleInputEmail1">Invoice ID</label>
                            <input type="text" class="form-control" value="<?php echo $_REQUEST[ 'sale-id' ] ?>"
                                   readonly="readonly">
                        </div>
                        
                        <div class="form-group col-lg-2">
                            <label for="exampleInputEmail1">Flight No</label>
                            <input type="text" name="flight_no" class="form-control" autofocus="autofocus"
                                   value="<?php echo @$travel -> flight_no ?>" required="required">
                        </div>
                        
                        <div class="form-group col-lg-4">
                            <label for="exampleInputEmail1">Airline Name</label>
                            <select name="airline-id" class="form-control select2me">
                                <option value="0">Select</option>
                                <?php
                                    if ( count ( $airlines ) > 0 ) {
                                        foreach ( $airlines as $airline ) {
                                            ?>
                                            <option value="<?php echo $airline -> id ?>" <?php if ( $airline -> id == @$travel -> airline_id )
                                                echo 'selected="selected"'; ?>>
                                                <?php echo $airline -> title ?>
                                            </option>
                                            <?php
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                        
                        <div class="form-group col-lg-4">
                            <label for="exampleInputEmail1">Destination</label>
                            <input type="text" name="destination" class="form-control"
                                   value="<?php echo @$travel -> destination ?>" required="required">
                        </div>
                        
                        <div class="form-group col-lg-3">
                            <label for="exampleInputEmail1" style="width: 100%">
                                Flight Date
                                <span class="pull-right">
                                    <?php echo @date ( 'Y-m-d g:i A', strtotime ( $travel -> flight_date ) ) ?>
                                </span>
                            </label>
                            <input type="datetime-local" name="flight_date" class="form-control"
                                   value="" required="required">
                        </div>
                        
                        <div class="form-group col-lg-2">
                            <label for="exampleInputEmail1">PNR</label>
                            <input type="text" name="pnr" class="form-control"
                                   value="<?php echo @$travel -> pnr ?>" required="required">
                        </div>
                        
                        <div class="form-group col-lg-2">
                            <label for="exampleInputEmail1">Ticket No</label>
                            <input type="text" name="ticket_no" class="form-control"
                                   value="<?php echo @$travel -> ticket_no ?>" required="required">
                        </div>
                        
                        <div class="form-group col-lg-2">
                            <label for="exampleInputEmail1">Ref By</label>
                            <input type="text" name="ref_by" class="form-control"
                                   value="<?php echo @$travel -> ref_by ?>">
                        </div>
                        
                        <div class="form-group col-lg-3">
                            <label for="exampleInputEmail1">Show Picture on Report</label>
                            <select name="show_picture" class="form-control">
                                <option value="0" <?php if ( @$travel -> show_picture == '0' )
                                    echo 'selected="selected"' ?>>No
                                </option>
                                <option value="1" <?php if ( @$travel -> show_picture == '1' )
                                    echo 'selected="selected"' ?>>Yes
                                </option>
                            </select>
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
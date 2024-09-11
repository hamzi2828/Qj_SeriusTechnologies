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
                        <i class="fa fa-globe"></i> Add Test Results
                    </div>
                    <?php if ( isset( $_GET[ 'sale-id' ] ) and $_GET[ 'sale-id' ] > 0 ) : ?>
                        <a href="<?php echo base_url ( '/lab/airline-details/?sale-id=' . $_GET[ 'sale-id' ] ) ?>"
                           target="_blank"
                           class="pull-right print-btn">Add Airline Details</a>
                    <?php endif ?>
                </div>
                <div class="portlet-body">
                    <?php $testResult = @get_test_results ( $_REQUEST[ 'sale-id' ], $_REQUEST[ 'parent-id' ] ); ?>
                    <form method="post">
                        <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                               value="<?php echo $this -> security -> get_csrf_hash (); ?>">
                        <?php
                            $access = get_user_access ( get_logged_in_user_id () );
                            if ( !empty( $access ) and in_array ( 'lab_result_verify_button', explode ( ',', $access -> access ) ) ) {
                                ?>
                                <input type="hidden" name="action" value="do_lab_result_verify">
                                <?php
                            }
                            else {
                                ?>
                                <input type="hidden" name="action" value="do_add_test_results">
                                <?php
                            }
                        ?>
                        <input type="hidden" name="invoice_id" value="<?php echo @$_REQUEST[ 'sale-id' ] ?>">
                        <input type="hidden" name="result_id" value="<?php echo @$testResult -> id ?>">
                        <input type="hidden" name="parent_test_id"
                               value="<?php echo @$testResult -> id > 0 ? @$testResult -> id : @$_REQUEST[ 'test-id' ] ?>">
                        <?php $results = @get_test_results ( $_REQUEST[ 'sale-id' ], $_REQUEST[ 'parent-id' ] ); ?>
                        <div class="col-lg-4 pull-right hidden" style="padding-bottom: 15px">
                            <label><strong>Referred By</strong></label>
                            <select name="doctor_id" class="form-control select2me">
                                <option value="">Select</option>
                                <?php
                                    if ( count ( $doctors ) > 0 ) {
                                        foreach ( $doctors as $doctor ) {
                                            ?>
                                            <option value="<?php echo $doctor -> id ?>" <?php if ( $doctor -> id == @$results -> doctor_id )
                                                echo 'selected="selected"' ?>>
                                                <?php echo $doctor -> name ?>
                                            </option>
                                            <?php
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                        
                        <div class="col-lg-4 pull-right" style="padding-bottom: 15px">
                            <label><strong>Choose Machine</strong></label>
                            <select name="machine" class="form-control select2me" onchange="load_test_url(this.value)">
                                <option value="default" <?php echo $_REQUEST[ 'machine' ] == 'default' ? 'selected="selected"' : '' ?>>
                                    Default
                                    <?php
                                        $machine = get_machine_name ( $_GET[ 'test-id' ], 'default' );
                                        if ( !empty( $machine ) && !empty( trim ( $machine -> machine_name ) ) )
                                            echo ' (' . $machine -> machine_name . ')';
                                    ?>
                                </option>
                                <option value="machine-1" <?php echo $_REQUEST[ 'machine' ] == 'machine-1' ? 'selected="selected"' : '' ?>>
                                    Machine 1
                                    <?php
                                        $machine = get_machine_name ( $_GET[ 'test-id' ], 'machine-1' );
                                        if ( !empty( $machine ) && !empty( trim ( $machine -> machine_name ) ) )
                                            echo ' (' . $machine -> machine_name . ')';
                                    ?>
                                </option>
                                <option value="machine-2" <?php echo $_REQUEST[ 'machine' ] == 'machine-2' ? 'selected="selected"' : '' ?>>
                                    Machine 2
                                    <?php
                                        $machine = get_machine_name ( $_GET[ 'test-id' ], 'machine-2' );
                                        if ( !empty( $machine ) && !empty( trim ( $machine -> machine_name ) ) )
                                            echo ' (' . $machine -> machine_name . ')';
                                    ?>
                                </option>
                                <option value="machine-3" <?php echo $_REQUEST[ 'machine' ] == 'machine-3' ? 'selected="selected"' : '' ?>>
                                    Machine 3
                                    <?php
                                        $machine = get_machine_name ( $_GET[ 'test-id' ], 'machine-3' );
                                        if ( !empty( $machine ) && !empty( trim ( $machine -> machine_name ) ) )
                                            echo ' (' . $machine -> machine_name . ')';
                                    ?>
                                </option>
                                <option value="machine-4" <?php echo $_REQUEST[ 'machine' ] == 'machine-4' ? 'selected="selected"' : '' ?>>
                                    Machine 4
                                    <?php
                                        $machine = get_machine_name ( $_GET[ 'test-id' ], 'machine-4' );
                                        if ( !empty( $machine ) && !empty( trim ( $machine -> machine_name ) ) )
                                            echo ' (' . $machine -> machine_name . ')';
                                    ?>
                                </option>
                                <option value="machine-5" <?php echo $_REQUEST[ 'machine' ] == 'machine-5' ? 'selected="selected"' : '' ?>>
                                    Machine 5
                                    <?php
                                        $machine = get_machine_name ( $_GET[ 'test-id' ], 'machine-5' );
                                        if ( !empty( $machine ) && !empty( trim ( $machine -> machine_name ) ) )
                                            echo ' (' . $machine -> machine_name . ')';
                                    ?>
                                </option>
                            </select>
                        </div>
                        
                        <ul style="list-style-type: none; padding: 25px 0 15px 0;">
                            <li>
                                <input type="checkbox" name="hide-previous-results" value="1"
                                       id="previous-results" <?php if ( !empty ( $results ) && $results -> hide_previous_results === '1' ) echo 'checked="checked"'; ?>>
                                <label for="previous-results">Hide Previous Results</label>
                            </li>
                        </ul>
                        
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th> Sr. No</th>
                                <th> Test</th>
                                <th> Results</th>
                                <th> No. of Times Performed</th>
                                <th> Remarks</th>
                                <th> Abnormal</th>
                                <th> Units</th>
                                <th> Ref. Ranges</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                                $counter = 1;
                                if ( count ( $sales ) > 0 and isset( $_REQUEST[ 'parent-id' ] ) and $_REQUEST[ 'parent-id' ] > 0 ) {
                                    $parentTest = get_test_by_id ( $_REQUEST[ 'parent-id' ] );
                                    $results    = @get_test_results ( $_REQUEST[ 'sale-id' ], $_REQUEST[ 'parent-id' ] );
                                    $unit_id    = @get_test_unit_id_by_id ( $_REQUEST[ 'parent-id' ] );
                                    $unit       = @get_unit_by_id ( $unit_id );
                                    $ranges     = @get_reference_ranges_by_test_id ( $_REQUEST[ 'parent-id' ] );
                                    $test       = @get_test_by_id ( $_REQUEST[ 'parent-id' ] );
                                    ?>
                                    <input type="hidden" name="test_id[]"
                                           value="<?php echo $_REQUEST[ 'parent-id' ] ?>">
                                    <tr class="odd gradeX">
                                        <td>
                                            <?php echo $counter++ ?>
                                        </td>
                                        <td><?php echo $parentTest -> name ?></td>
                                        <td>
                                            <textarea name="result[]" class="form-control" rows="5"
                                                      placeholder="Add result"><?php echo !empty( $results ) ? $results -> result : $test -> default_results ?></textarea>
                                        </td>
                                        <td>
                                            <select name="regents[]" class="select2me form-control">
                                                <option value="">Select</option>
                                                <?php for ( $regent = 1; $regent <= 10; $regent++ ) : ?>
                                                    <option value="<?php echo $regent ?>" <?php if ( $regent == @$results -> regents )
                                                        echo 'selected="selected"' ?>><?php echo $regent ?></option>
                                                <?php endfor; ?>
                                            </select>
                                        </td>
                                        <td>
                                            <select name="predefined_remarks[<?php echo $_REQUEST[ 'parent-id' ] ?>][]"
                                                    class="form-control select2me" multiple="multiple"
                                                    style="margin-bottom: 10px">
                                                <option value="" disabled="disabled">Select</option>
                                                <?php
                                                    if ( count ( $remarks ) > 0 ) {
                                                        foreach ( $remarks as $remark ) {
                                                            $isRemarkAdded = check_if_remark_added ( $remark -> id, $_REQUEST[ 'sale-id' ], $_REQUEST[ 'parent-id' ] )
                                                            ?>
                                                            <option value="<?php echo $remark -> id ?>" <?php if ( $isRemarkAdded )
                                                                echo 'selected="selected"' ?>>
                                                                <?php echo $remark -> remarks ?>
                                                            </option>
                                                            <?php
                                                        }
                                                    }
                                                ?>
                                            </select>
                                            <textarea name="remarks[]" class="form-control" rows="5"
                                                      placeholder="Add remarks"><?php echo @$results -> remarks ?></textarea>
                                        </td>
                                        <td>
                                            <input type="checkbox" name="abnormal[<?php echo $parentTest -> id ?>]"
                                                   class="form-control"
                                                   value="1" <?php echo @$results -> abnormal == '1' ? 'checked="checked"' : '' ?>>
                                            Yes
                                        </td>
                                        <td><?php echo $unit ?></td>
                                        <td>
                                            <?php
                                                if ( count ( $ranges ) > 0 ) {
                                                    foreach ( $ranges as $range ) {
                                                        echo '<b>Age</b>: ' . $range -> min_age . '-' . $range -> max_age . '<br>';
                                                        echo '<b>Range</b>: ' . $range -> start_range . '-' . $range -> end_range . '<br>';
                                                        echo '<hr style="margin: 5px 0 0 0;">';
                                                    }
                                                }
                                            ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                if ( count ( $sales ) > 0 ) {
                                    foreach ( $sales as $sale ) {
                                        $results = @get_test_results ( $_REQUEST[ 'sale-id' ], $sale -> test_id );
                                        $test    = @get_test_by_id ( $sale -> test_id );
                                        $unit_id = @get_test_unit_id_by_id ( $sale -> test_id );
                                        $unit    = @get_unit_by_id ( $unit_id );
                                        $ranges  = @get_reference_ranges_by_test_id ( $sale -> test_id );
                                        if ( $sale -> patient_id == cash_from_lab )
                                            $patient = 'Cash customer';
                                        else
                                            $patient = get_patient ( $sale -> patient_id ) -> name;
                                        $isParent = check_if_test_has_sub_tests ( $sale -> test_id );
                                        ?>
                                        <input type="hidden" name="test_id[]" value="<?php echo $sale -> test_id ?>">
                                        <tr class="odd gradeX">
                                            <td>
                                                <?php echo $counter++ ?>
                                            </td>
                                            <td><?php echo $test -> name ?></td>
                                            <td>
                                            <textarea name="result[]" class="form-control" rows="5"
                                                      placeholder="Add result"><?php echo !empty( $results ) ? $results -> result : $test -> default_results ?></textarea>
                                            </td>
                                            <td>
                                                <?php if ( !$isParent and $test -> parent_id < 1 ) : ?>
                                                    <select name="regents[]" class="select2me form-control">
                                                        <option value="">Select</option>
                                                        <?php for ( $regent = 1; $regent <= 10; $regent++ ) : ?>
                                                            <option value="<?php echo $regent ?>" <?php if ( $regent == @$results -> regents )
                                                                echo 'selected="selected"' ?>><?php echo $regent ?></option>
                                                        <?php endfor; ?>
                                                    
                                                    </select>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php
                                                    if ( $isParent or $test -> parent_id < 1 ) {
                                                        ?>
                                                        <select name="predefined_remarks[<?php echo $sale -> test_id ?>][]"
                                                                class="form-control select2me"
                                                                multiple="multiple" style="margin-bottom: 10px">
                                                            <option value="" disabled="disabled">Select</option>
                                                            <?php
                                                                if ( count ( $remarks ) > 0 ) {
                                                                    foreach ( $remarks as $remark ) {
                                                                        $isRemarkAdded = check_if_remark_added ( $remark -> id, $_REQUEST[ 'sale-id' ], $sale -> test_id )
                                                                        ?>
                                                                        <option value="<?php echo $remark -> id ?>" <?php if ( $isRemarkAdded )
                                                                            echo 'selected="selected"' ?>>
                                                                            <?php echo $remark -> remarks ?>
                                                                        </option>
                                                                        <?php
                                                                    }
                                                                }
                                                            ?>
                                                        </select>
                                                        <?php
                                                    }
                                                ?>
                                                <textarea name="remarks[]" class="form-control" rows="5"
                                                          placeholder="Add remarks"><?php echo @$results -> remarks ?></textarea>
                                            </td>
                                            <td>
                                                <input type="checkbox" name="abnormal[<?php echo $sale -> test_id ?>]"
                                                       class="form-control"
                                                       value="1" <?php echo @$results -> abnormal == '1' ? 'checked="checked"' : '' ?>>
                                                Yes
                                            </td>
                                            <td><?php echo $unit ?></td>
                                            <td>
                                                <?php
                                                    if ( count ( $ranges ) > 0 ) {
                                                        foreach ( $ranges as $range ) {
                                                            echo '<b>Age</b>: ' . $range -> min_age . '-' . $range -> max_age . '<br>';
                                                            echo '<b>Range</b>: ' . $range -> start_range . '-' . $range -> end_range . '<br>';
                                                            echo '<hr style="margin: 5px 0 0 0;">';
                                                        }
                                                    }
                                                ?>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                            ?>
                            </tbody>
                            <?php
                                if ( !empty( $access ) and in_array ( 'lab_result_verify_and_add_result_button', explode ( ',', $access -> access ) ) ) {
                                    ?>
                                    <tfoot>
                                    <tr>
                                        <td colspan="6"></td>
                                        <td>
                                            <button type="submit" class="btn btn-primary btn-block"
                                                    style="padding: 10px; border-radius: 4px !important;">Add Results
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="6"></td>
                                        <td>
                                            <button type="submit" class="btn btn-danger btn-block" name="action"
                                                    value="do_lab_result_verify"
                                                    style="padding: 10px; border-radius: 4px !important;">
                                                Verify Results
                                            </button>
                                        </td>
                                    </tr>
                                    </tfoot>
                                    <?php
                                }
                                else if ( !empty( $access ) and in_array ( 'lab_result_verify_button', explode ( ',', $access -> access ) ) ) {
                                    ?>
                                    <tfoot>
                                    <tr>
                                        <td colspan="5"></td>
                                        <td>
                                            <button type="submit" class="btn btn-primary btn-block">
                                                Verify Results
                                            </button>
                                        </td>
                                    </tr>
                                    </tfoot>
                                    <?php
                                }
                                else if ( count ( $sales ) > 0 ) {
                                    ?>
                                    <tfoot>
                                    <tr>
                                        <td colspan="6"></td>
                                        <td>
                                            <button type="submit" class="btn btn-primary btn-block">Add Results</button>
                                        </td>
                                    </tr>
                                    </tfoot>
                                    <?php
                                }
                            ?>
                        </table>
                    </form>
                </div>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
<script type="text/javascript">
    function load_test_url ( value ) {
        window.location.href = "<?php echo base_url ( '/lab/add-results/?sale-id=' . $_REQUEST[ 'sale-id' ] . '&parent-id=' . $_REQUEST[ 'parent-id' ] . '&test-id=' . $_REQUEST[ 'test-id' ] . '&machine=' ) ?>" + value;
    }
</script>
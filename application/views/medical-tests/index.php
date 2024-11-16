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
        
        <div class="search" style="padding-bottom: 0">
            <form method="get" autocomplete="off">
                <div class="sale">
                    <div class="form-group col-lg-2">
                        <label for="receipt-no">Receipt No.</label>
                        <input type="text" name="receipt-no" class="form-control" id="receipt-no"
                               value="<?php echo $this -> input -> get ( 'receipt-no' ) ?>">
                    </div>
                    <div class="form-group col-lg-3">
                        <label for="oep-id">OEP</label>
                        <select name="oep-id" class="form-control select2me" id="oep-id" data-placeholder="Select">
                            <option></option>
                            <?php
                                if ( count ( $oeps ) > 0 ) {
                                    foreach ( $oeps as $oep ) {
                                        ?>
                                        <option value="<?php echo $oep -> id ?>" <?php echo $this -> input -> get ( 'oep-id' ) == $oep -> id ? 'selected="selected"' : '' ?>>
                                            <?php echo $oep -> name ?>
                                        </option>
                                        <?php
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group col-lg-2">
                        <label for="lab-no">Lab No.</label>
                        <input type="text" name="lab-no" class="form-control" id="lab-no"
                               value="<?php echo $this -> input -> get ( 'lab-no' ) ?>">
                    </div>
                    <div class="form-group col-lg-3">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control" id="name"
                               value="<?php echo $this -> input -> get ( 'name' ) ?>">
                    </div>
                    <div class="form-group col-lg-3">
                        <label for="cnic">CNIC</label>
                        <input type="text" name="cnic" class="form-control" id="cnic"
                               value="<?php echo $this -> input -> get ( 'cnic' ) ?>">
                    </div>
                    <div class="form-group col-lg-1">
                        <button type="submit" class="btn btn-primary btn-block" style="margin-top: 25px;">Search</button>
                    </div>
                </div>
            </form>
        </div>
        
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i> <?php echo $title ?>
                </div>
            </div>
            <div class="portlet-body" style="overflow: auto">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th> Sr. No</th>
                        <th> Receipt No</th>
                        <th> Lab No</th>
                        <th> Name</th>
                        <th> CNIC | Passport</th>
                        <th> Trade | Natl</th>
                        <th> Age | Gen (DOB)</th>
                        <th> Marital Status</th>
                        <th> Country to Visit</th>
                        <th> Spec. Received</th>
                        <th> OEP/Ref By</th>
                        <th> Payment Methods</th>
                        <th> Payments</th>
                        <th> Status</th>
                        <th> Date Added</th>
                        <th> Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $counter = 1 + ( isset( $_REQUEST[ 'per_page' ] ) ? $_REQUEST[ 'per_page' ] : 0 );
                        if ( count ( $tests ) > 0 ) {
                            foreach ( $tests as $test ) {
                                $country     = get_country_by_id ( $test -> country_id );
                                $age         = calculateAge ( $test -> dob );
                                $nationality = get_country_by_id ( $test -> nationality );
                                ?>
                                <tr>
                                    <td><?php echo $counter++ ?></td>
                                    <td><?php echo $test -> id ?></td>
                                    <td><?php echo $test -> lab_no_prefix . '-' . $test -> lab_no ?></td>
                                    <td><?php echo $test -> name ?></td>
                                    <td>
                                        <?php
                                            if ( !empty( trim ( $test -> identity ) ) )
                                                echo $test -> identity;
                                            
                                            if ( !empty( trim ( $test -> passport ) ) )
                                                echo '|' . $test -> passport;
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            if ( !empty( trim ( $test -> trade ) ) )
                                                echo $test -> trade;
                                            
                                            if ( !empty( trim ( $test -> nationality ) ) )
                                                echo '|' . $nationality -> title;
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            echo $age;
                                            if ( !empty( trim ( $test -> gender ) ) )
                                                echo '|' . ucwords ( $test -> gender )
                                        ?>
                                    </td>
                                    <td><?php echo ucwords ( $test -> marital_status ) ?></td>
                                    <td><?php echo !empty( $country ) ? $country -> title : '-' ?></td>
                                    <td><?php echo date_setter ( $test -> spec_received ) ?></td>
                                    <td><?php echo $test -> oep ?></td>
                                    <td>
                                        <?php 
                                        echo !empty($test->payment_method) ? ucwords($test->payment_method) : 'Not Specified'; 
                                        ?>
                                    </td>
                                    <td>
                                            <?php 
                                            // Ensure the model is loaded
                                            $this->load->model('MedicalTestModel'); 

                                            // Fetch the details for the OEP
                                            $oep_details = $this->MedicalTestModel->get_details_of_oep_by_id($test->oep_id); 

                                            // Display the price or a fallback message
                                            echo isset($oep_details->price) ? $oep_details->price : 'Price not available';
                                            ?>
                                        </td>


                                    <td>
                                        <?php
                                            if ( $test -> fit === '0' )
                                                echo '<span class="badge badge-danger">UnFit</span>';
                                            else if ( $test -> fit === '1' )
                                                echo '<span class="badge badge-success">Fit</span>';
                                            else if ( $test -> fit === '2' )
                                                echo '<span class="badge badge-warning">Pending</span>';
                                            else if ( $test -> fit === '3' )
                                                echo '<span class="badge badge-primary">Defer</span>';
                                            else if ( $test -> fit === '5' )
                                                echo '<span class="badge badge-primary">Hold</span>';
                                        ?>
                                    </td>
                                    <td><?php echo date_setter ( $test -> created_at, 5 ) ?></td>
                                    <td class="btn-group-xs">
                                        <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'edit-medical-tests', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                            <a class="btn blue"
                                               href="<?php echo base_url ( 'medical-tests/edit/' . $test -> id . '/?tab=general-information' ) ?>">Edit</a>
                                        <?php endif; ?>
                                        
                                        <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'delete-medical-tests', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                            <a class="btn red" onclick="return confirm('Are you sure?')"
                                               href="<?php echo base_url ( 'medical-tests/destroy/' . $test -> id ) ?>">Delete</a>
                                        <?php endif; ?>
                                        
                                        <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'print-medical-test-receipt', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                            <a class="btn btn-block dark" target="_blank" style="margin-bottom: 5px;"
                                               href="<?php echo base_url ( '/invoices/medical-receipt/' . $test -> id . '/?logo=true' ) ?>">Receipt</a>
                                        <?php endif; ?>
                                        
                                        <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'print-medical-tests', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                            <a class="btn purple" target="_blank"
                                               href="<?php echo base_url ( '/invoices/medical-test/' . $test -> id . '/?logo=true' ) ?>">L-Print</a>
                                            
                                            <a class="btn purple" target="_blank"
                                               href="<?php echo base_url ( '/invoices/medical-test/' . $test -> id . '/?logo=false' ) ?>">Print</a>

                                            <a class="btn purple" target="_blank"
                                            href="<?php echo base_url ( '/invoices/medical-test/' . $test -> id . '/?custom=true&logo=false' ) ?>">Print-C</a>
                                            
                                            <a class="btn purple" target="_blank"
                                            href="<?php echo base_url ( '/invoices/medical-test/' . $test -> id . '/?custom=true&logo=true' ) ?>">L-Print-C</a>

                                        <?php endif; ?>
                                        
                                        <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'print-medical-test-ticket', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                            <a href="<?php echo base_url ( '/invoices/medical-test-ticket/' . $test -> id ) ?>"
                                               class="btn green" target="_blank">
                                                Print Ticket
                                            </a>
                                        <?php endif; ?>
                                        
                                        
                                        <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'mark-fit-unfit-medical-tests', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                            <a class="btn <?php echo $test -> fit === '0' ? 'green' : 'red' ?>"
                                               onclick="return confirm('Are you sure?')"
                                               href="<?php echo base_url ( 'medical-tests/status/' . $test -> id ) ?>">
                                                Mark <?php echo $test -> fit === '0' ? 'Fit' : 'UnFit' ?>
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
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
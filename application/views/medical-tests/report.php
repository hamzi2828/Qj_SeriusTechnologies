<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <div class="search">
            <form method="get" autocomplete="off">
                <div class="form-group col-lg-3 col-lg-offset-1">
                    <label for="start-date">Start Date</label>
                    <input type="text" name="start-date" id="start-date" class="date date-picker form-control"
                           placeholder="Start date" required="required"
                           value="<?php echo $this -> input -> get ( 'start-date' ) ?>">
                </div>
                <div class="form-group col-lg-3">
                    <label for="end-date">End Date</label>
                    <input type="text" name="end-date" class="date date-picker form-control" placeholder="End date"
                           required="required" id="end-date"
                           value="<?php echo $this -> input -> get ( 'end-date' ) ?>">
                </div>
                <div class="col-lg-3 form-group">
                    <label for="oep-id">OEP</label>
                    <select name="oep-id" class="form-control select2me" id="oep-id"
                            required="required"
                            data-placeholder="Select">
                        <option></option>
                        <?php
                            if ( count ( $oeps ) > 0 ) {
                                foreach ( $oeps as $oep ) {
                                    ?>
                                    <option value="<?php echo $oep -> id ?>" <?php echo $this -> input -> get ( 'oep-id' ) === $oep -> id ? 'selected="selected"' : '' ?>>
                                        <?php echo $oep -> name ?>
                                    </option>
                                    <?php
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="col-lg-1" style="padding-top: 25px">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </form>
        </div>
        
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i> <?php echo $title ?>
                </div>
                <?php if ( count ( $tests ) > 0 ) : ?>
                    <a href="<?php echo base_url ( '/invoices/medical-test-report?' . $_SERVER[ 'QUERY_STRING' ] ) ?>"
                       target="_blank"
                       class="pull-right print-btn">Print</a>
                <?php endif ?>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th> Sr. No</th>
                        <th> Receipt No</th>
                        <th> Lab No</th>
                        <th> Name</th>
                        <th> Father Name</th>
                        <th> CNIC | Passport</th>
                        <th> Trade | Natl</th>
                        <th> Age | Gen (DOB)</th>
                        <th> Marital Status</th>
                        <th> Country to Visit</th>
                        <th> Spec. Received</th>
                        <th> OEP/Ref By</th>
                        <th> Status</th>
                        <th> Date Added</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $counter = 1;
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
                                    <td><?php echo $test -> father_name ?></td>
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
                                            if ( $test -> fit === '1' )
                                                echo '<span class="badge badge-success">Fit</span>';
                                            else if ( $test -> fit === '2' )
                                                echo '<span class="badge badge-warning">Pending</span>';
                                            else if ( $test -> fit === '3' )
                                                echo '<span class="badge badge-primary">Defer</span>';
                                            else if ( $test -> fit === '0' )
                                                echo '<span class="badge badge-danger">UnFit</span>';
                                        ?>
                                    </td>
                                    <td><?php echo date_setter ( $test -> created_at ) ?></td>
                                </tr>
                                <?php
                            }
                        }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
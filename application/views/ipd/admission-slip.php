<div class="tab-pane <?php if ( !isset( $current_tab ) or $current_tab == 'admission-slip' )
    echo 'active' ?>">
    <form role="form" method="post" autocomplete="off">
        <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
               value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
        <input type="hidden" name="action" value="do_update_admission_slip">
        <input type="hidden" id="sale_id" name="sale_id" value="<?php echo $sale -> sale_id ?>">
        <div class="form-body" style="overflow:auto;">
            <div class="form-group col-lg-3">
                <label for="exampleInputEmail1">Patient EMR#</label>
                <input type="text" name="patient_id" class="form-control" placeholder="Add patient EMR#"
                       autofocus="autofocus" value="<?php echo $sale -> patient_id ?>" required="required"
                       onchange="get_patient(this.value)" readonly="readonly">
            </div>
            <div class="form-group col-lg-3">
                <label for="exampleInputEmail1">Name</label>
                <input type="text" class="form-control name" id="patient-name" readonly="readonly"
                       value="<?php echo get_patient ( $sale -> patient_id ) -> name ?>">
            </div>
            <div class="form-group col-lg-3">
                <label for="exampleInputEmail1">Age</label>
                <input type="text" class="form-control" readonly="readonly"
                       value="<?php echo get_patient ( $sale -> patient_id ) -> age ?>">
            </div>
            <div class="form-group col-lg-3">
                <label for="exampleInputEmail1">Gender</label>
                <input type="text" class="form-control" readonly="readonly"
                       value="<?php echo get_patient ( $sale -> patient_id ) -> gender == '1' ? 'Male' : 'Female' ?>">
            </div>
            <div class="form-group col-lg-3">
                <label for="exampleInputEmail1">Panel/PVT</label>
                <?php
                    $panel_id = get_patient ( $sale -> patient_id ) -> panel_id;
                    if ( $panel_id > 0 ) {
                        $panel = get_panel_by_id ( $panel_id ) -> name;
                    }
                    else
                        $panel = @$admission_slip -> panel_pvt;
                ?>
                <input type="text" class="form-control" name="panel_pvt" required="required"
                       value="<?php echo @$panel ?>">
            </div>
            <div class="form-group col-lg-3">
                <label for="exampleInputEmail1">Package</label>
                <input type="text" class="form-control" name="package" required="required"
                       value="<?php echo @$admission_slip -> package ?>">
            </div>
            <div class="form-group col-lg-3">
                <label for="exampleInputEmail1">Room No.</label>
                <input type="text" class="form-control" name="room_no" required="required"
                       value="<?php echo @$admission_slip -> room_no ?>">
            </div>
            <div class="form-group col-lg-3">
                <label for="exampleInputEmail1">Bed No.</label>
                <input type="text" class="form-control" name="bed_no" required="required"
                       value="<?php echo @$admission_slip -> bed_no ?>">
            </div>
            <div class="form-group col-lg-6">
                <label for="exampleInputEmail1">Consultant</label>
                <select name="doctor_id" class="form-control select2me" required="required">
                    <option value="">Select</option>
                    <?php
                        if ( count ( $doctors ) > 0 ) {
                            foreach ( $doctors as $doctor ) {
                                ?>
                                <option value="<?php echo $doctor -> id ?>" <?php if ( @$admission_slip -> doctor_id == $doctor -> id )
                                    echo 'selected="selected"' ?>>
                                    <?php echo $doctor -> name ?>
                                </option>
                                <?php
                            }
                        }
                    ?>
                </select>
            </div>
            <div class="form-group col-lg-6">
                <label for="exampleInputEmail1">Admission No.</label>
                <input type="text" class="form-control" name="admission_no" required="required"
                       value="<?php echo !empty( @$admission_slip -> admission_no ) ? $admission_slip -> admission_no : $_REQUEST[ 'sale_id' ] ?>"
                       readonly="readonly">
            </div>
            <div class="form-group col-lg-4">
                <label for="exampleInputEmail1">Date of Admission.</label>
                <input type="text" class="form-control date date-picker" name="admission_date" required="required"
                       value="<?php echo !empty( trim ( @$admission_slip -> admission_date ) ) ? date ( 'm/d/Y', strtotime ( @$admission_slip -> admission_date ) ) : date ( 'm/d/Y' ) ?>">
            </div>
            <div class="form-group col-lg-4">
                <label for="exampleInputEmail1">Contact No.</label>
                <input type="text" class="form-control"
                       name="contact_no" <?php if ( empty( trim ( get_patient ( $sale -> patient_id ) -> mobile ) ) )
                    echo 'required="required"';
                else echo 'readonly="readonly"'; ?>
                       value="<?php echo get_patient ( $sale -> patient_id ) -> mobile ?>">
            </div>
            <div class="form-group col-lg-4">
                <label for="exampleInputEmail1">Admitted To</label>
                <select class="form-control" name="admitted_to">
                    <option value="ipd" <?php if ( @$admission_slip -> admitted_to == 'ipd' )
                        echo 'selected="selected"' ?>>IPD
                    </option>
                    <option value="icu" <?php if ( @$admission_slip -> admitted_to == 'icu' )
                        echo 'selected="selected"' ?>>ICU
                    </option>
                </select>
            </div>
            <div class="form-group col-lg-12">
                <label for="exampleInputEmail1">Remarks</label>
                <textarea rows="5" class="form-control"
                          name="remarks"><?php echo !empty( @$admission_slip -> remarks ) ? $admission_slip -> remarks : '' ?></textarea>
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn blue">Update</button>
            <?php if ( !empty( $admission_slip ) ) : ?>
                <a type="button" class="btn purple"
                   href="<?php echo base_url ( '/invoices/ipd-admission-slip/' . $admission_slip -> sale_id ) ?>"
                   style="display: inline">Print</a>
            <?php endif; ?>
        </div>
    </form>
</div>
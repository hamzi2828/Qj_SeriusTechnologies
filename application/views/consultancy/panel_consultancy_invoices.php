<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
		<?php if(validation_errors() != false) { ?>
            <div class="alert alert-danger validation-errors">
				<?php echo validation_errors(); ?>
            </div>
		<?php } ?>
		<?php if($this -> session -> flashdata('error')) : ?>
            <div class="alert alert-danger">
				<?php echo $this -> session -> flashdata('error') ?>
            </div>
		<?php endif; ?>
		<?php if($this -> session -> flashdata('response')) : ?>
            <div class="alert alert-success">
				<?php echo $this -> session -> flashdata('response') ?>
            </div>
		<?php endif; ?>
        <!-- BEGIN EXAMPLE TABLE PORTLET-->

        <div class="search">
            <form method="get">
                <div class="col-sm-2">
                    <label>Receipt No.</label>
                    <input type="text" class="form-control" value="<?php echo @$_GET[ 'id' ] ?>" name="id">
                </div>
                <div class="col-sm-2">
                    <label>Patient EMR</label>
                    <input type="text" class="form-control" value="<?php echo @$_GET[ 'patient_id' ] ?>" name="patient_id">
                </div>
                <div class="col-sm-3">
                    <label>Doctor</label>
                    <select name="doctor_id" class="form-control select2me">
                        <option value="">Select</option>
						<?php
						if ( count ( $doctors ) > 0 ) {
							foreach ( $doctors as $doctor ) {
								?>
                                <option value="<?php echo $doctor -> id ?>" <?php echo ( isset( $_REQUEST[ 'doctor_id' ] ) and $_REQUEST[ 'doctor_id' ] > 0 and $_REQUEST[ 'doctor_id' ] == $doctor -> id ) ? 'selected="selected"' : ''; ?>><?php echo $doctor -> name ?></option>
								<?php
							}
						}
						?>
                    </select>
                </div>
                <div class="col-sm-3">
                    <label>Department</label>
                    <select name="specialization_id" class="form-control select2me">
                        <option value="">Select</option>
						<?php
						if ( count ( $specializations ) > 0 ) {
							foreach ( $specializations as $specialization ) {
								?>
                                <option value="<?php echo $specialization -> id ?>" <?php echo ( isset( $_REQUEST[ 'specialization_id' ] ) and $_REQUEST[ 'specialization_id' ] > 0 and $_REQUEST[ 'specialization_id' ] == $specialization -> id ) ? 'selected="selected"' : ''; ?>><?php echo $specialization -> title ?></option>
								<?php
							}
						}
						?>
                    </select>
                </div>
                <div class="col-sm-2">
                    <button type="submit" style="margin-top: 25px" class="btn btn-primary btn-block">Search</button>
                </div>
            </form>
        </div>
        
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i> Panel Consultancy Invoices
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th> Sr. No </th>
                        <th> Receipt No. </th>
                        <th> Patient EMR </th>
                        <th> Patient </th>
                        <th> Doctor </th>
                        <th> Department </th>
                        <th> Panel </th>
                        <th> Actual Charges </th>
                        <th> Panel Discount </th>
                        <th> Charges </th>
                        <th> Discount </th>
                        <th> Net Bill </th>
                        <th> Refunded </th>
                        <th> Refund Remarks </th>
                        <th> Date Added </th>
                        <th> Actions </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if(count($consultancies) > 0) {
                        $counter = 1 + ( isset( $_REQUEST[ 'per_page' ] ) ? $_REQUEST[ 'per_page' ] : 0 );
                        foreach ($consultancies as $consultancy) {
                            $specialization = get_specialization_by_id($consultancy -> specialization_id);
                            $doctor = get_doctor($consultancy -> doctor_id);
                            $patient = get_patient($consultancy -> patient_id);
                            $refunded = ($consultancy -> refunded == '1') ? 'Yes' : '';
                            $panel  = get_panel_by_id($patient -> panel_id);
                            $panel_discount = get_panel_doctor_discount($consultancy -> doctor_id, $patient -> panel_id);
                            ?>
                            <tr class="odd gradeX">
                                <td> <?php echo $counter++ ?> </td>
                                <td><?php echo $consultancy -> id ?></td>
                                <td><?php echo $consultancy -> patient_id ?></td>
                                <td><?php echo $patient -> name ?></td>
                                <td><?php echo $doctor -> name ?></td>
                                <td><?php echo $specialization -> title ?></td>
                                <td><?php echo $panel -> name ?></td>
                                <td><?php echo $doctor -> hospital_charges ?></td>
                                <td>
                                    <?php
							        if(!empty($panel_discount)) {
										echo $panel_discount -> discount;
//										if ($panel_discount -> type == 'percent')
//											echo '%';
//										else
//											echo 'Rs';
									}
                                    ?>
                                </td>
                                <td><?php echo $consultancy -> charges ?></td>
                                <td><?php echo $consultancy -> discount ?></td>
                                <td><?php echo $consultancy -> net_bill ?></td>
                                <td><?php echo $refunded ?></td>
                                <td><?php echo $consultancy -> refund_reason ?></td>
                                <td><?php echo date_setter($consultancy -> date_added) ?></td>
                                <td class="btn-group-xs">
							<?php if(get_user_access(get_logged_in_user_id()) and in_array('print_consultancy', explode(',', get_user_access(get_logged_in_user_id()) -> access))) : ?>
                                    <a type="button" class="btn purple" href="<?php echo base_url('/invoices/consultancy-invoice/'.$consultancy -> id) ?>" target="_blank">Print</a>
							<?php endif; ?>
                            <?php if(get_user_access(get_logged_in_user_id()) and in_array('edit_consultancy', explode(',', get_user_access(get_logged_in_user_id()) -> access))) : ?>
                                    <a type="button" class="btn blue" href="<?php echo base_url('/consultancy/edit/'.$consultancy -> id) ?>">Edit</a>
							<?php endif; ?>
									<?php if(get_user_access(get_logged_in_user_id()) and in_array('refund_consultancy', explode(',', get_user_access(get_logged_in_user_id()) -> access)) and $consultancy -> refunded != '1') : ?>
                                        <a type="button" class="btn green" href="<?php echo base_url('/consultancy/refund/'.$consultancy -> id) ?>">Refund</a>
									<?php endif; ?>
                            <?php if(get_user_access(get_logged_in_user_id()) and in_array('delete_consultancy', explode(',', get_user_access(get_logged_in_user_id()) -> access))) : ?>
                                    <a type="button" class="btn red" href="<?php echo base_url('/consultancy/delete/'.$consultancy -> id) ?>" onclick="return confirm('Are you sure to delete?')">Delete</a>
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
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
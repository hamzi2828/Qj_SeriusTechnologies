<!-- BEGIN PAGE CONTENT-->
<div class="row">
	<div class="col-md-12">
		<form role="form" method="get" autocomplete="off">
			<div class="form-body" style="overflow: auto">
				<div class="form-group col-lg-2">
					<label for="exampleInputEmail1">Start Date</label>
					<input type="text" name="start_date" class="form-control date date-picker" value="<?php echo (isset($_REQUEST['start_date']) and !empty($_REQUEST['start_date'])) ? date('m/d/Y', strtotime(@$_REQUEST['start_date'])) : ''; ?>">
				</div>
				<div class="form-group col-lg-2">
					<label for="exampleInputEmail1">End Date</label>
					<input type="text" name="end_date" class="form-control date date-picker" value="<?php echo (isset($_REQUEST['end_date']) and !empty($_REQUEST['start_date'])) ? date('m/d/Y', strtotime(@$_REQUEST['end_date'])) : ''; ?>">
				</div>
				<div class="form-group col-lg-3">
					<label for="exampleInputEmail1">Consultant</label>
					<select name="doctor-id" class="form-control select2me">
						<option value="">Select</option>
						<?php
						if(count($doctors) > 0) {
							foreach ( $doctors as $doctor) {
							    $specialization = get_specialization_by_id ($doctor -> specialization_id);
								?>
								<option value="<?php echo $doctor -> id ?>" <?php echo @$_REQUEST[ 'doctor-id' ] == $doctor -> id ? 'selected="selected"' : '' ?>>
									<?php
                                        echo $doctor -> name . ' (' . $specialization -> title . ')';
                                    ?>
								</option>
						<?php
							}
						}
						?>
					</select>
				</div>
                <div class="form-group col-lg-2">
                    <label for="exampleInputEmail1">Procedure</label>
                    <select name="service-id" class="form-control select2me">
                        <option value="">Select</option>
			            <?php
			            if(count($services) > 0) {
				            foreach ( $services as $service) {
					            ?>
                                <option value="<?php echo $service -> id ?>" <?php echo @$_REQUEST['service-id'] == $service -> id ? 'selected="selected"' : '' ?>>
						            <?php echo $service -> title . '(' . $service -> code . ')'; ?>
                                </option>
					            <?php
				            }
			            }
			            ?>
                    </select>
                </div>
                <div class="form-group col-lg-2">
                    <label for="exampleInputEmail1">Cash/Panel</label>
                    <select name="panel_id" class="form-control select2me">
                        <option value="">Select</option>
                        <option value="cash" <?php echo @$_REQUEST[ 'panel_id' ] == 'cash' ? 'selected="selected"' : '' ?>>Cash</option>
			            <?php
			            if(count($panels) > 0) {
				            foreach ($panels as $panel) {
					            ?>
                                <option value="<?php echo $panel -> id ?>" <?php echo @$_REQUEST['panel_id'] == $panel -> id ? 'selected="selected"' : '' ?>>
						            <?php echo $panel -> name ?>
                                </option>
					            <?php
				            }
			            }
			            ?>
                    </select>
                </div>
				<div class="form-group col-lg-1">
					<button type="submit" class="btn btn-block btn-primary" style="margin-top: 25px;">Search</button>
				</div>
			</div>
		</form>
		<!-- BEGIN EXAMPLE TABLE PORTLET-->
		<div class="portlet box green">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-globe"></i> Consultant Commission
				</div>
				<?php if(count($sales) > 0) : ?>
                    <a href="<?php echo base_url('/invoices/consultant-commission?'.$_SERVER['QUERY_STRING']); ?>" class="pull-right print-btn">Print</a>
				<?php endif ?>
			</div>
			<div class="portlet-body">
				<table class="table table-striped table-bordered table-hover">
					<thead>
					<tr>
						<th> Sr. No </th>
						<th> Patient EMR </th>
						<th> Patient Name </th>
						<th> Cash/Panel </th>
						<th> Sale ID </th>
						<th> Consultant Name </th>
						<th> Service(s) </th>
						<th> Commission</th>
						<th> Medication</th>
						<th> Lab</th>
						<th> Date Added</th>
					</tr>
					</thead>
					<tbody>
					<?php
                    $counter = 1;
                    $net = 0;
                    $medicationNet = 0;
                    $labNet = 0;
					if(count($sales) > 0) {
						foreach ($sales as $sale) {
							$patient 		=	get_patient($sale -> patient_id);
                            $net = $net + $sale -> commission;
                            $medication = get_ipd_medication_net_price($sale -> sale_id);
                            $lab = get_ipd_lab_net_price($sale -> sale_id);
                            $medicationNet = $medicationNet + $medication;
                            $labNet = $labNet + $lab;
							?>
							<tr class="odd gradeX">
								<td> <?php echo $counter++ ?> </td>
								<td><?php echo $patient -> id ?></td>
								<td><?php echo $patient -> name ?></td>
                                <td><?php echo (get_panel_by_id ( $patient -> panel_id )) ? get_panel_by_id ( $patient -> panel_id ) -> name : 'Cash' ?></td>
								<td><?php echo $sale -> sale_id ?></td>
								<td><?php echo @get_doctor( $sale -> doctor_id) -> name . '<br>'; ?></td>
								<td><?php echo @get_ipd_service_by_id( $sale -> service_id) -> title ?></td>
								<td><?php echo number_format ( $sale -> commission, 2) ?></td>
								<td><?php echo number_format ($medication, 2) ?></td>
								<td><?php echo number_format ($lab, 2) ?></td>
								<td><?php echo date_setter ($sale -> date_added) ?></td>
							</tr>
							<?php
						}
					}
					?>
					</tbody>
                    <tfoot>
                        <tr>
                            <td colspan="7"></td>
                            <td><strong><?php echo number_format ($net, 2) ?></strong></td>
                            <td><strong><?php echo number_format ($medicationNet, 2) ?></strong></td>
                            <td><strong><?php echo number_format ($labNet, 2) ?></strong></td>
                            <td></td>
                        </tr>
                    </tfoot>
				</table>
			</div>
		</div>
		<!-- END EXAMPLE TABLE PORTLET-->
	</div>
</div>
<style>
	.input-xsmall {
		width: 100px !important;
	}
</style>
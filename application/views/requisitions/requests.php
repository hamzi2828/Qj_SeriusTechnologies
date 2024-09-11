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
		<div class="portlet box green">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-globe"></i> Requisitions Requests
				</div>
			</div>
			<div class="portlet-body">
				<table class="table table-striped table-bordered table-hover" id="sample_1">
					<thead>
					<tr>
						<th> Sr. No </th>
						<th> Request From </th>
						<th> Department </th>
						<th> Par Level </th>
						<th> Item </th>
						<th> Quantity </th>
						<th> Description </th>
						<th> Status </th>
						<th> Date Added </th>
						<th> Actions </th>
					</tr>
					</thead>
					<tbody>
					<?php
					if(count($requests) > 0) {
						$counter = 1;
						foreach ($requests as $requisition) {
							$user           = get_user($requisition -> request_by);
							$department     = get_department($requisition -> department_id);
							$item           = get_store($requisition -> item_id);
							?>
							<tr class="odd gradeX">
								<td> <?php echo $counter++ ?> </td>
								<td><?php echo $user -> name ?></td>
								<td><?php echo $department -> name ?></td>
								<td><?php echo get_par_level_by_dept_item($requisition -> department_id, $requisition -> item_id) ?></td>
								<td><?php echo $item -> item ?></td>
								<td><?php echo $requisition -> quantity ?></td>
								<td><?php echo $requisition -> description ?></td>
								<td><?php echo ucfirst($requisition -> status) ?></td>
								<td><?php echo date_setter($requisition -> date_added) ?></td>
								<td class="btn-group-xs">
							<?php if(!empty($access) and in_array('approve_fm_request', explode(',', $access -> access))) : ?>
									<a type="button" class="btn green" href="<?php echo base_url('/requisition/status/'.$requisition -> id.'?status=approved') ?>">Approve</a>
                            <?php endif ?>
							<?php if(!empty($access) and in_array('reject_fm_request', explode(',', $access -> access))) : ?>
									<a type="button" class="btn blue" href="<?php echo base_url('/requisition/status/'.$requisition -> id.'?status=rejected') ?>">Reject</a>
							<?php endif ?>
							<?php if(!empty($access) and in_array('delete_fm_request', explode(',', $access -> access))) : ?>
									<a type="button" class="btn red" href="<?php echo base_url('/requisition/delete/'.$requisition -> id) ?>" onclick="return confirm('Are you sure to delete?')">Delete</a>
							<?php endif ?>
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
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
                    <i class="fa fa-globe"></i> Progress Notes
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover" id="sample_1">
                    <thead>
                    <tr>
                        <th> Sr. No </th>
                        <th> Patient </th>
                        <th> Admission No </th>
                        <th> Room/Bed No. </th>
                        <th> Date Added </th>
                        <th> Actions </th>
                    </tr>
                    </thead>
                    <tbody>
					<?php
					if(count($notes) > 0) {
						$counter = 1;
						foreach ($notes as $note) {
							$patient    = get_patient($note -> patient_id);
							?>
                            <tr class="odd gradeX">
                                <td> <?php echo $counter++ ?> </td>
                                <td><?php echo $patient -> name ?></td>
                                <td><?php echo $note -> admission_no ?></td>
                                <td><?php echo $note -> room ?></td>
                                <td><?php echo date_setter($note -> date_added) ?></td>
                                <td class="btn-group-xs">
									<?php if(get_user_access(get_logged_in_user_id()) and in_array('edit_progress_notes', explode(',', get_user_access(get_logged_in_user_id()) -> access))) : ?>
                                        <a type="button" class="btn-block btn green" href="<?php echo base_url('/IPD/mo/edit-progress-notes/'.$note -> id) ?>">Edit</a>
									<?php endif; ?>
									<?php if(get_user_access(get_logged_in_user_id()) and in_array('delete_progress_notes', explode(',', get_user_access(get_logged_in_user_id()) -> access))) : ?>
                                        <a type="button" class="btn-block btn red" href="<?php echo base_url('/IPD/mo/delete-progress-notes/'.$note -> id) ?>" onclick="return confirm('Are you sure you want to delete?')">Delete</a>
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
<style>
    .input-xsmall {
        width: 100px !important;
    }
</style>
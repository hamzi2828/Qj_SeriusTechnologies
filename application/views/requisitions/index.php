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
                    <i class="fa fa-globe"></i> Requisitions
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover" id="sample_1">
                    <thead>
                    <tr>
                        <th> Sr. No </th>
                        <th> Request From </th>
                        <th> Department </th>
                        <th> Item </th>
                        <th> Quantity </th>
                        <th> Description </th>
                        <th> Status </th>
                        <th> Remarks </th>
                        <th> Date Added </th>
                        <th> Actions </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if(count($requisitions) > 0) {
                        $counter = 1;
                        foreach ($requisitions as $requisition) {
                            $user           = get_user($requisition -> request_by);
                            $department     = get_department($requisition -> department_id);
                            $item           = get_store($requisition -> item_id);
                            ?>
                            <tr class="odd gradeX">
                                <td> <?php echo $counter++ ?> </td>
                                <td><?php echo $user -> name ?></td>
                                <td><?php echo $department -> name ?></td>
                                <td><?php echo $item -> item ?></td>
                                <td><?php echo $requisition -> quantity ?></td>
                                <td><?php echo $requisition -> description ?></td>
                                <td><?php echo ucfirst($requisition -> status) ?></td>
                                <td><?php echo $requisition -> remarks ?></td>
                                <td><?php echo date_setter($requisition -> date_added) ?></td>
                                <td class="btn-group-xs">
							    <?php if(get_user_access(get_logged_in_user_id()) and in_array('edit_all_requisitions', explode(',', get_user_access(get_logged_in_user_id()) -> access))) : ?>
                                    <a type="button" class="btn blue" href="<?php echo base_url('/requisition/edit/'.$requisition -> id) ?>" <?php if($requisition -> status != 'pending') echo 'disabled="disabled"' ?>>Edit</a>
                                <?php endif; ?>
                                <?php if(get_user_access(get_logged_in_user_id()) and in_array('delete_all_requisitions', explode(',', get_user_access(get_logged_in_user_id()) -> access))) : ?>
                                        <a type="button" class="btn red" href="<?php echo base_url('/requisition/delete/'.$requisition -> id) ?>" <?php if($requisition -> status != 'pending') echo 'disabled="disabled"' ?> onclick="return confirm('Are you sure to delete?')">Delete</a>
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
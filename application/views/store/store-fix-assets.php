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
                    <i class="fa fa-globe"></i> All Store - Fix Assets
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover" id="sample_1">
                    <thead>
                    <tr>
                        <th> Sr. No </th>
                        <th> Item </th>
                        <th> Account Head </th>
                        <th> Department </th>
                        <th> Invoice </th>
                        <th> Value </th>
                        <th> Date Added </th>
                        <th> Actions </th>
                    </tr>
                    </thead>
                    <tbody>
					<?php
					if(count($assets) > 0) {
						$counter = 1;
						foreach ($assets as $asset) {
                            $item       = get_store($asset -> store_id);
                            $acc_head   = get_account_head($asset -> account_head_id);
                            $department = get_department($asset -> department_id);
							?>
                            <tr class="odd gradeX">
                                <td> <?php echo $counter++ ?> </td>
                                <td><?php echo $item -> item ?></td>
                                <td><?php echo $acc_head -> title ?></td>
                                <td><?php echo $department -> name ?></td>
                                <td><?php echo $asset -> invoice ?></td>
                                <td><?php echo $asset -> value ?></td>
                                <td><?php echo date_setter($asset -> date_added) ?></td>
                                <td>
                                    <a type="button" class="btn-xs btn blue" href="<?php echo base_url('/store/edit-store-fix-asset/'.$asset -> id) ?>">
                                        Edit
                                    </a>
                                    <a type="button" class="btn-xs btn red" href="<?php echo base_url('/store/delete_store_fix_asset/'.$asset -> id) ?>" onclick="return confirm('Are you sure?')">
                                        Delete
                                    </a>
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
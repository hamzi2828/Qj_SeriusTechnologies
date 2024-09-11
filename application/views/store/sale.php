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
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-reorder"></i> Issue Store Stock
                </div>
            </div>
            <div class="portlet-body form" style="overflow: AUTO;">
                <form role="form" method="post" autocomplete="off">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" id="csrf_token">
                    <input type="hidden" name="action" value="do_sale_store_stock">
                    <input type="hidden" name="selected_batch" id="selected_batch" value="">
                    <input type="hidden" id="added" value="1">
                    <div class="form-body" style="overflow: auto">

                        <div class="col-lg-3 col-lg-offset-3">
                            <label for="exampleInputEmail1">Department</label>
                            <select name="department_id" class="form-control select2me" onchange="get_department_users(this.value)" id="department" required="required">
                                <option value="">Select Item</option>
								<?php
								if(count($departments) > 0) {
									foreach ($departments as $department) {
										?>
                                        <option value="<?php echo $department -> id ?>">
											<?php echo $department -> name ?>
                                        </option>
										<?php
									}
								}
								?>
                            </select>
                        </div>

                        <div class="col-lg-2 users">
                            <label for="exampleInputEmail1">Issue To</label>
                            <input type="text" readonly="readonly" class="form-control">
                        </div>

                        <div class="col-lg-2">
                            <label for="exampleInputEmail1">Issue Date</label>
                            <input type="text" class="form-control date-picker" required="required" name="issue_date" value="<?php echo date('m/d/Y') ?>">
                        </div>

                        <div class="issue" style="margin-top: 25px">
                            <div class="form-group col-lg-4">
                                <label for="exampleInputEmail1">Store Item</label>
                                <select name="store_id[]" class="form-control select2me" onchange="get_store_batch(this.value, 1)">
                                    <option value="">Select Item</option>
                                    <?php
                                    if(count($stores) > 0) {
                                        foreach ($stores as $store) {
                                            ?>
                                            <option value="<?php echo $store -> id ?>">
                                                <?php echo $store -> item ?>
                                            </option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group col-lg-2">
                                <label for="exampleInputEmail1">Stock.No</label>
                                <div class="batch show-batch-1">
                                    <input type="text" readonly="readonly" class="form-control">
                                </div>
                            </div>
                            <div class="form-group col-lg-2">
                                <label for="exampleInputEmail1">Available</label>
                                <input type="text" readonly="readonly" class="form-control available-1">
                            </div>
                            <div class="form-group col-lg-2">
                                <label for="exampleInputEmail1">Par Level</label>
                                <input type="text" readonly="readonly" class="form-control par-level-1">
                            </div>
                            <div class="form-group col-lg-2">
                                <label for="exampleInputEmail1">Quantity</label>
                                <input type="text" name="quantity[]" class="form-control" onkeyup="validate_sale_quantity(this.value, 1)">
                            </div>
                            <div class="form-group col-lg-3 hidden">
                                <label for="exampleInputEmail1">Account Head</label>
                                <select name="account_head[]" class="form-control select2me">
                                    <option value="">Select Item</option>
									<?php
									if(count($account_heads) > 0) {
										foreach ($account_heads as $account_head) {
											?>
                                            <option value="<?php echo $account_head -> id ?>">
												<?php echo $account_head -> title ?>
                                            </option>
											<?php
										}
									}
									?>
                                </select>
                            </div>
                        </div>
                        <div class="add-more"></div>
                    </div>
                    <div class="form-actions col-lg-12">
                        <button type="submit" class="btn blue" id="submit-btn">Submit</button>
                        <a type="button" class="btn purple" onclick="add_more_store_sale()" style="display: inline">Add More</a>
                    </div>
                </form>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>
<style>
    .issue {
        display: block;
        width: 100%;
        display: block;
        float: left;
    }
</style>
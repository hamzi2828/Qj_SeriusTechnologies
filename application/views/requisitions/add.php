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
                    <i class="fa fa-reorder"></i> Add Requisitions
                </div>
            </div>
            <div class="portlet-body form" style="overflow: AUTO;">
                <form role="form" method="post" autocomplete="off">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" id="csrf_token">
                    <input type="hidden" name="action" value="do_add_requisitions">
                    <input type="hidden" id="added" value="1">
                    <div class="form-body" style="overflow: auto">
                        <div class="form-group col-lg-4">
                            <label for="exampleInputEmail1">Store Item</label>
                            <select name="store_id[]" class="form-control select2me">
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
                        <div class="form-group col-lg-4">
                            <label for="exampleInputEmail1">Quantity</label>
                            <input type="text" name="quantity[]" class="form-control">
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="exampleInputEmail1">Description</label>
                            <textarea name="description[]" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="issue"></div>
                    </div>
                    <div class="form-actions col-lg-12">
                        <button type="submit" class="btn blue" id="submit-btn">Submit</button>
                        <button type="button" class="btn purple" onclick="add_more_requisitions()">Add More</button>
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
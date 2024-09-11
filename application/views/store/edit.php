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
                    <i class="fa fa-reorder"></i> Edit Store Item
                </div>
            </div>
            <div class="portlet-body form">
                <form role="form" method="post" autocomplete="off">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" id="csrf_token">
                    <input type="hidden" name="action" value="do_edit_store">
                    <input type="hidden" name="store_id" value="<?php echo $store -> id ?>">
                    <div class="form-body" style="overflow: auto">
                        <div class="form-group col-lg-3">
                            <label for="exampleInputEmail1">Name</label>
                            <input type="text" name="item" class="form-control" placeholder="Add item name" autofocus="autofocus" value="<?php echo $store -> item ?>" maxlength="255" required="required">
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="exampleInputEmail1">Threshold</label>
                            <input type="text" name="threshold" class="form-control" placeholder="Add item threshold" value="<?php echo $store -> threshold ?>" maxlength="255" required="required">
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="exampleInputEmail1">Type</label>
                            <select name="type" class="form-control select2me">
                                <option value="consumable-lab" <?php if($store -> type == 'consumable-lab') echo 'selected="selected"' ?>>Consumable (Lab)</option>
                                <option value="consumable" <?php if($store -> type == 'consumable') echo 'selected="selected"' ?>>Consumable (General)</option>
                                <option value="fix assets" <?php if($store -> type == 'fix assets') echo 'selected="selected"' ?>>Fix Assets</option>
                            </select>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="exampleInputEmail1">Regent Quantity (ML)</label>
                            <input type="text" name="regent_quantity" class="form-control"
                                   placeholder="Add Regent Quantity (ML)"
                                   value="<?php echo $store -> regent_quantity ?>">
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn blue" id="patient-reg-btn">Update</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>
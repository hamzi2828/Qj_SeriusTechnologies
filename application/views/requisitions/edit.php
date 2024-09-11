<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-reorder"></i> Edit Requisition
                </div>
            </div>
            <div class="portlet-body form" style="overflow: AUTO;">
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
                <form role="form" method="post" autocomplete="off">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" id="csrf_token">
                    <input type="hidden" name="action" value="do_edit_requisition">
                    <input type="hidden" name="requisition_id" value="<?php echo $requisition -> id ?>">
                    <div class="form-body" style="overflow: auto">
                        <div class="form-group col-lg-4">
                            <label for="exampleInputEmail1">Store Item</label>
                            <select name="store_id" class="form-control select2me">
                                <option value="">Select Item</option>
                                <?php
                                if(count($stores) > 0) {
                                    foreach ($stores as $store) {
                                        ?>
                                        <option value="<?php echo $store -> id ?>" <?php if(@$requisition -> item_id == $store -> id) echo 'selected="selected"' ?>>
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
                            <input type="text" name="quantity" class="form-control" value="<?php echo @$requisition -> quantity ?>">
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="exampleInputEmail1">Description</label>
                            <textarea name="description" class="form-control" rows="3"><?php echo @$requisition -> description ?></textarea>
                        </div>
                    </div>
                    <div class="form-actions col-lg-12">
                        <button type="submit" class="btn blue" id="submit-btn">Update</button>
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
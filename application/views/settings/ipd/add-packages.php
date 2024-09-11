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
					<i class="fa fa-reorder"></i> Add Packages
				</div>
			</div>
			<div class="portlet-body form">
				<form role="form" method="post" autocomplete="off">
					<input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" id="csrf_token">
					<input type="hidden" name="action" value="do_add_ipd_packages">
					<input type="hidden" id="added" value="1">
					<div class="form-body" style="overflow: auto">
                        <div class="form-group col-lg-9">
                            <label for="exampleInputEmail1">Title</label>
                            <input type="text" name="title" class="form-control" placeholder="Add title" autofocus="autofocus" value="<?php echo set_value('title') ?>" required="required">
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="exampleInputEmail1">Price</label>
                            <input type="text" name="price" class="form-control" placeholder="Add price"  value="<?php echo set_value('price') ?>">
                        </div>
						<div class="form-group col-lg-4">
							<label for="exampleInputEmail1">Service</label>
							<select name="service_id[]" class="form-control select2me">
								<option value="">Select</option>
								<?php
								if(count($services) > 0) {
									foreach ($services as $service) {
										?>
										<option value="<?php echo $service -> id ?>">
											<?php echo $service -> title ?>
										</option>
								<?php
									}
								}
								?>
							</select>
						</div>
						<div class="form-group col-lg-4">
							<label for="exampleInputEmail1">Service</label>
							<select name="service_id[]" class="form-control select2me">
								<option value="">Select</option>
								<?php
								if(count($services) > 0) {
									foreach ($services as $service) {
										?>
										<option value="<?php echo $service -> id ?>">
											<?php echo $service -> title ?>
										</option>
								<?php
									}
								}
								?>
							</select>
						</div>
						<div class="form-group col-lg-4">
							<label for="exampleInputEmail1">Service</label>
							<select name="service_id[]" class="form-control select2me">
								<option value="">Select</option>
								<?php
								if(count($services) > 0) {
									foreach ($services as $service) {
										?>
										<option value="<?php echo $service -> id ?>">
											<?php echo $service -> title ?>
										</option>
								<?php
									}
								}
								?>
							</select>
						</div>
                        <div class="services"></div>
					</div>
					<div class="form-actions">
						<button type="submit" class="btn blue" id="sales-btn">Submit</button>
						<button type="button" class="btn purple" onclick="add_more_ipd_services()">Add More</button>
					</div>
				</form>
			</div>
		</div>
		<!-- END SAMPLE FORM PORTLET-->
	</div>
</div>
<style>
    .services {
        width: 100%;
        float: left;
        display: block;
    }
</style>
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
					<i class="fa fa-reorder"></i> Add Store Stock
				</div>
			</div>
			<div class="portlet-body form">
				<form role="form" method="post" autocomplete="off">
					<input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" id="csrf_token">
					<input type="hidden" name="action" value="do_add_store_stock">
					<input type="hidden" id="added" value="1">
					<div class="form-body">

						<div class="row">
							<div class="form-group col-lg-4">
								<label for="exampleInputEmail1">Account Head</label>
								<select name="supplier_id" class="form-control select2me" id="supplier_id">
									<option value="<?php echo store_supplier ?>">
                                        <?php echo @get_account_head(store_supplier) -> title ?>
                                    </option>
								</select>
							</div>
							<div class="form-group col-lg-4">
								<label for="exampleInputEmail1">Supplier Invoice</label>
								<input type="text" name="invoice" class="form-control invoice" onchange="validate_store_stock_invoice_number(this.value)" required="required">
							</div>
							<div class="form-group col-lg-4">
								<label for="exampleInputEmail1">Date</label>
								<input type="text" name="date_added" class="date date-picker form-control" value="<?php echo date('m/d/Y') ?>">
							</div>
						</div>

						<div class="row" style="border-bottom: 10px solid #fff;padding-top: 10px;border-top: 10px solid #ffff;">
							<div class="form-group col-lg-3">
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
							<div class="form-group col-lg-2">
								<label for="exampleInputEmail1">Stock.No</label>
								<input type="text" name="batch[]" class="form-control" value="<?php echo unique_id(4) ?>">
							</div>
							<div class="form-group col-lg-2">
								<label for="exampleInputEmail1">Expiry Date</label>
								<input type="text" name="expiry[]" class="date date-picker form-control">
							</div>
							<div class="form-group col-lg-1">
								<label for="exampleInputEmail1">Quantity</label>
								<input type="text" name="quantity[]" class="form-control quantity-1" onchange="calculate_store_stock_net_price(1)">
							</div>
							<div class="form-group col-lg-1">
								<label for="exampleInputEmail1">Price</label>
								<input type="text" name="price[]" class="form-control price-1" onchange="calculate_store_stock_net_price(1)">
							</div>
							<div class="form-group col-lg-1">
								<label for="exampleInputEmail1">Discount</label>
								<input type="text" name="discount[]" class="form-control discount-1" onchange="calculate_store_stock_net_price(1)">
							</div>
							<div class="form-group col-lg-2">
								<label for="exampleInputEmail1">Net</label>
								<input type="text" name="net_price[]" class="form-control net-1 net-price" readonly="readonly">
							</div>
						</div>
						<div class="add-more-store-stock"></div>
						<div class="row" style="border-bottom: 10px solid #fff;padding-bottom: 15px;">
							<button class="btn btn-primary pull-right" type="button" onclick="add_more_store_stock()" style="margin-top: 15px">Add More Stock</button>
						</div>
						<div class="row">
							<div class="col-md-1 col-md-offset-9" style="text-align: right; margin-top: 10px">
								<strong>Disc. (%)</strong>
							</div>
							<div class="col-md-2" style="margin-top: 10px">
								<input type="text" name="grand_total_discount" class="form-control grand_total_discount" onchange="calculate_grand_total_discount(this.value)">
							</div>
						</div>
						<div class="row">
							<div class="col-md-1 col-md-offset-9" style="text-align: right; margin-top: 10px">
								<strong>G.Total</strong>
							</div>
							<div class="col-md-2" style="margin-top: 10px">
								<input type="text" name="grand_total" class="form-control grand_total" readonly="readonly">
							</div>
						</div>
					</div>
					<div class="form-actions col-lg-12">
						<button type="submit" class="btn blue" id="submit-btn">Submit</button>
					</div>
				</form>
			</div>
		</div>
		<!-- END SAMPLE FORM PORTLET-->
	</div>
</div>
<style>
	.form {
		width: 100%;
		display: block;
		overflow-x: hidden;
		/* float: left; */
		clear: both;
		overflow-y: hidden;
	}
	.stock-rows {
		display: block;
		width: 100%;
		float: left;
		background: #e3e3e3;
		padding: 10px 0;
	}
</style>
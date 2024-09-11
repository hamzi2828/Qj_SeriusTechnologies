<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <form role="form" method="get" autocomplete="off">
            <div class="form-body" style="overflow: auto">
                <div class="form-group col-lg-3">
                    <label for="exampleInputEmail1">Supplier</label>
                    <select name="supplier_id" class="form-control select2me">
                        <option value="0">All</option>
						<?php
						if(count($suppliers) > 0) {
							foreach ($suppliers as $supplier) {
								?>
                                <option value="<?php echo $supplier -> id ?>" <?php echo @$_REQUEST['supplier_id'] == $supplier -> id ? 'selected="selected"' : '' ?>>
									<?php echo $supplier -> title ?>
                                </option>
								<?php
							}
						}
						?>
                    </select>
                </div>
                <div class="form-group col-lg-4">
                    <label for="exampleInputEmail1">Medicine</label>
                    <select name="medicine_id" class="form-control select2me">
                        <option value="0">All</option>
						<?php
						if(count($medicines) > 0) {
							foreach ($medicines as $medicine) {
								?>
                                <option value="<?php echo $medicine -> id ?>" <?php echo @$_REQUEST['medicine_id'] == $medicine -> id ? 'selected="selected"' : '' ?>>
									<?php
									if($medicine -> strength_id > 1)
										$strength = get_strength($medicine -> strength_id) -> title;
									else
										$strength = '';
									if($medicine -> form_id > 1)
										$form = get_form($medicine -> form_id) -> title;
									else
										$form = '';
									echo $medicine -> name . ' ' . $strength . ' ' . $form;
                                    ?>
                                </option>
								<?php
							}
						}
						?>
                    </select>
                </div>
                <div class="form-group col-lg-2">
                    <label for="exampleInputEmail1">Start Date</label>
                    <input type="text" name="start_date" class="form-control date date-picker" value="<?php echo (isset($_REQUEST['start_date']) and !empty($_REQUEST['start_date'])) ? date('m/d/Y', strtotime(@$_REQUEST['start_date'])) : ''; ?>">
                </div>
                <div class="form-group col-lg-2">
                    <label for="exampleInputEmail1">End Date</label>
                    <input type="text" name="end_date" class="form-control date date-picker" value="<?php echo (isset($_REQUEST['end_date']) and !empty($_REQUEST['end_date'])) ? date('m/d/Y', strtotime(@$_REQUEST['end_date'])) : ''; ?>">
                </div>
                <div class="form-group col-lg-1">
                    <button type="submit" class="btn btn-primary" style="margin-top: 25px;">Search</button>
                </div>
            </div>
        </form>
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i> Analysis Report - Purchase
                </div>
				<?php if(count($analysis) > 0) : ?>
                    <a href="<?php echo base_url('/invoices/analysis-report?'.$_SERVER['QUERY_STRING']); ?>" class="pull-right print-btn">Print</a>
				<?php endif ?>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th> Sr. No </th>
                            <th> Supplier </th>
                            <th> Invoice </th>
                            <th> Medicines </th>
                            <th> Quantity </th>
                            <th> Total </th>
                            <th> Date </th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    if(count($analysis) > 0) {
                        $counter    = 1;
						$total      = 0;
						$total_quantity   = 0;
                        foreach ($analysis as $stock) {
                            $medicines      = explode(',', $stock -> medicines);
                            $quantities     = explode(',', $stock -> quantities);
							$total          = $total + $stock -> net_price;
                            ?>
                            <tr>
                                <td> <?php echo $counter; ?> </td>
                                <td> <?php echo get_supplier($stock -> supplier_id) -> title ?> </td>
                                <td> <?php echo $stock -> supplier_invoice ?> </td>
                                <td>
                                    <?php
                                    if(count($medicines) > 0) {
                                        foreach ($medicines as $medicine) {
											$med = get_medicine($medicine);
											if($med -> strength_id > 1)
												$strength = get_strength($med -> strength_id) -> title;
											else
												$strength = '';
											if($med -> form_id > 1)
												$form = get_form($med -> form_id) -> title;
											else
												$form = '';
											echo $med -> name . ' ' . $strength . ' ' . $form . '<br>';
                                        }
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if(count($quantities) > 0) {
                                        foreach ($quantities as $quantity) {
											$total_quantity += $quantity;
											echo $quantity . '<br>';
                                        }
                                    }
                                    ?>
                                </td>
                                <td> <?php echo number_format($stock -> net_price, 2) ?> </td>
                                <td> <?php echo date_setter($stock -> date_added) ?> </td>
                            </tr>
                    <?php
							$counter++;
                        }
                        ?>
                        <tr>
                            <td colspan="5" align="right">
                                <strong><?php echo number_format($total_quantity, 2); ?></strong>
                            </td>
                            <td><strong><?php echo number_format($total, 2); ?></strong></td>
                            <td></td>
                        </tr>
                    <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <form role="form" method="get" autocomplete="off">
            <div class="form-body" style="overflow: auto">
                <div class="form-group col-lg-3">
                    <label for="exampleInputEmail1">Services</label>
                    <select name="service_id" class="form-control select2me">
                        <option value="">Select</option>
			            <?php
			            if(count($services) > 0) {
				            foreach ($services as $service) {
					            ?>
                                <option value="<?php echo $service -> id ?>" <?php echo @$_REQUEST['service_id'] == $service -> id ? 'selected="selected"' : '' ?>>
						            <?php echo $service -> title ?>
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
                    <input type="text" name="end_date" class="form-control date date-picker" value="<?php echo (isset($_REQUEST['end_date']) and !empty($_REQUEST['start_date'])) ? date('m/d/Y', strtotime(@$_REQUEST['end_date'])) : ''; ?>">
                </div>
                <div class="form-group col-lg-2">
                    <label for="exampleInputEmail1">Start Time</label>
                    <select class="form-control" name="start_time">
                        <option value="">Select</option>
						<?php
						$times = create_time_range('01:00', '23:00', '60 mins', '24');
						foreach ($times as $time) :
							?>
                            <option value="<?php echo $time ?>" <?php if($time == @$_REQUEST['start_time']) echo 'selected="selected"' ?>><?php echo $time ?></option>
						<?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group col-lg-2">
                    <label for="exampleInputEmail1">End Time</label>
                    <select class="form-control" name="end_time">
                        <option value="">Select</option>
						<?php
						$times = create_time_range('01:00', '23:00', '60 mins', '24');
						foreach ($times as $time) :
							?>
                            <option value="<?php echo $time ?>" <?php if($time == @$_REQUEST['end_time']) echo 'selected="selected"' ?>><?php echo $time ?></option>
						<?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group col-lg-1">
                    <button type="submit" class="btn btn-primary" style="margin-top: 25px;">Search</button>
                </div>
            </div>
        </form>
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-reorder"></i> General Report (Cash)
                </div>
	            <?php if(count($sales) > 0) : ?>
                    <a href="<?php echo base_url('/invoices/opd-general-report?'.$_SERVER['QUERY_STRING']); ?>" class="pull-right print-btn">Print</a>
	            <?php endif ?>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th> Sr. No </th>
                        <th> Sale ID </th>
                        <th> Patient </th>
						<th> Doctor(s) </th>
                        <th> Service(s) </th>
                        <th> Price </th>
                        <th> Discount/Service </th>
                        <th> Total </th>
                        <th> Net Discount </th>
                        <th> Net Price </th>
                        <th> Date Added </th>
                    </tr>
                    </thead>
                    <tbody>
		            <?php
		            if(count($sales) > 0) {
			            $counter = 1;
			            $total = 0;
			            foreach ($sales as $sale) {
				            $patient = get_patient($sale -> patient_id);
				            $sale_info = get_opd_sale($sale -> sale_id);
				            $total = $total + $sale_info -> net;
				            ?>
                            <tr class="odd gradeX">
                                <td> <?php echo $counter++ ?> </td>
                                <td><?php echo $sale -> sale_id ?></td>
                                <td><?php echo $patient -> name ?></td>
								<td>
                                    <?php
                                    $doctors = explode(',', $sale -> doctors);
									if (count($doctors) > 0) {
										foreach ($doctors as $doctor) {
										    if($doctor > 0)
											    echo get_doctor($doctor) -> name . '<br>';
										    else
										        echo '-'.'<br>';
										}
									}
									?>
                                </td>
                                <td>
						            <?php
						            $services = explode(',', $sale -> services);
						            if(count($services) > 0) {
							            foreach ($services as $service) {
								            echo get_service_by_id($service) -> title . '<br>';
							            }
						            }
						            ?>
                                </td>
                                <td>
						            <?php
						            $prices = explode(',', $sale -> prices);
						            if(count($prices) > 0) {
							            foreach ($prices as $price) {
								            echo $price . '<br>';
							            }
						            }
						            ?>
                                </td>
                                <td>
						            <?php
						            $discounts = explode(',', $sale -> discounts);
						            if(count($discounts) > 0) {
							            foreach ($discounts as $discount) {
								            echo $discount . '<br>';
							            }
						            }
						            ?>
                                </td>
                                <td><?php echo $sale -> net_price ?></td>
                                <td><?php echo $sale_info -> discount.'%' ?></td>
                                <td><?php echo $sale_info -> net ?></td>
                                <td><?php echo date_setter($sale -> date_added) ?></td>
                            </tr>
				            <?php
			            }
			            ?>
                            <tr>
                                <td colspan="9"></td>
                                <td>
                                    <strong><?php echo $total ?></strong>
                                </td>
                                <td></td>
                            </tr>
                    <?php
		            }
		            ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>
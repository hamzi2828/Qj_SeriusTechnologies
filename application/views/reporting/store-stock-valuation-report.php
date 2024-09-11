<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <form role="form" method="get" autocomplete="off">
            <div class="form-body" style="overflow: auto">
                <div class="form-group col-lg-5">
                    <label for="exampleInputEmail1">Start Date</label>
                    <input type="text" name="start_date" class="form-control date date-picker" value="<?php echo (isset($_REQUEST['start_date']) and !empty($_REQUEST['start_date'])) ? date('m/d/Y', strtotime(@$_REQUEST['start_date'])) : ''; ?>">
                </div>
                <div class="form-group col-lg-5">
                    <label for="exampleInputEmail1">End Date</label>
                    <input type="text" name="end_date" class="form-control date date-picker" value="<?php echo (isset($_REQUEST['end_date']) and !empty($_REQUEST['start_date'])) ? date('m/d/Y', strtotime(@$_REQUEST['end_date'])) : ''; ?>">
                </div>
                <div class="form-group col-lg-2">
                    <button type="submit" class="btn-block btn btn-primary" style="margin-top: 25px;">Search</button>
                </div>
            </div>
        </form>
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i> Stock Evaluation Report
                </div>
                <?php if(count($stores) > 0) : ?>
                    <a href="<?php echo base_url('/invoices/store-stock-evaluation-report?'.$_SERVER['QUERY_STRING']); ?>" class="pull-right print-btn">Print</a>
                <?php endif ?>
				<?php if(count( $stores) > 0) : ?>
                    <a href="<?php echo base_url('/invoices/store-stock-evaluation-report?'.$_SERVER['QUERY_STRING'].'&only-available=true'); ?>" class="pull-right print-btn" style="    margin-right: 15px;">Print Available Quantity Only</a>
				<?php endif ?>
            </div>
            <div class="portlet-body" style="overflow: auto;">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th> Sr. No </th>
                        <th> Name </th>
                        <th> Total Qty. </th>
                        <th> Sold Qty. </th>
                        <th> Available Qty. </th>
                        <th> Net Value </th>
                        <th> Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $total = 0;
                    $counter = 1;
                    if(count($stores) > 0) {
                        foreach ( $stores as $store) {
                            $sold = get_store_stock_sold_quantity( $store -> id);
                            $quantity = get_store_stock_total_quantity( $store -> id);
							$available = $quantity - $sold;
                            $net_value = get_available_stock_price( $store -> id);
                            $total = $total + $net_value;
                            
                            ?>
                            <tr class="odd gradeX">
                                <td> <?php echo $counter++ ?> </td>
                                <td><?php echo $store -> item ?></td>
                                <td><?php echo $quantity > 0 ? $quantity : 0 ?></td>
                                <td><?php echo $sold > 0 ? $sold : 0 ?></td>
                                <td><?php echo $available ?></td>
                                <td><?php echo number_format($net_value, 2) ?></td>
                                <td class="btn-group-xs">
                                    <a type="button" class="btn green" href="<?php echo base_url('/store/stock/'. $store -> id) ?>">Stock</a>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                        <tr>
                            <td colspan="5" class="text-right">
                                <strong>Total:</strong>
                            </td>
                            <td>
                                <strong><?php echo number_format($total, 2) ?></strong>
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
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
<style>
    .input-xsmall {
        width: 100px !important;
    }
</style>

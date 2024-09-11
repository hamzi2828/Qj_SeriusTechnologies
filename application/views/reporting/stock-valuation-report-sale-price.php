<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i> Stock Evaluation Report (Sale Price Wise)
                </div>
                <?php if(count($medicines) > 0) : ?>
                    <a href="<?php echo base_url('/invoices/stock-evaluation-report-sale-price'); ?>" class="pull-right print-btn">Print</a>
                <?php endif ?>
            </div>
            <div class="portlet-body" style="overflow: auto">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th> Sr. No </th>
                        <th> Name </th>
                        <th> Generic </th>
                        <th> Form </th>
                        <th> Strength </th>
                        <th> Type </th>
                        <th> Total Qty. </th>
                        <th> Sold Qty. </th>
                        <th> Returned Customer. </th>
                        <th> Returned Supplier. </th>
                        <th> Expired Qty. </th>
                        <th> Internally Issued Qty. </th>
                        <th> IPD Issued Qty. </th>
                        <th> Adjustment Qty. </th>
                        <th> Available Qty. </th>
                        <th> Net Value </th>
                        <th> Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if(count($medicines) > 0) {
                        $counter = 1;
                        $total = 0;
                        foreach ($medicines as $medicine) {
                            $sold       = get_sold_quantity($medicine -> id);
                            $quantity   = get_stock_quantity($medicine -> id);
                            $expired    = get_expired_quantity_medicine_id($medicine -> id);
                            $generic    = get_generic($medicine -> generic_id);
                            $form       = get_form($medicine -> form_id);
                            $strength   = get_strength($medicine -> strength_id);
                            $returned   = get_medicine_returned_quantity($medicine -> id);
                            $issued     = get_issued_quantity($medicine -> id);
							$ipd_issuance   = get_ipd_issued_medicine_quantity($medicine -> id);
							$return_supplier = get_returned_medicines_quantity_by_supplier($medicine -> id);
							$adjustment_qty     = get_total_adjustments_by_medicine_id($medicine -> id);
                            $available  = $quantity - $sold - $expired - $issued - $ipd_issuance - $return_supplier - $adjustment_qty;
                            
                            $net_value  = get_all_stock_sale_price_by_medicine_id($medicine -> id, $counter);
                            $total      = $total + $net_value;
                            ?>
                            <tr class="odd gradeX">
                                <td> <?php echo $counter++ ?> </td>
                                <td><?php echo $medicine -> name ?></td>
                                <td><?php echo $generic -> title ?></td>
                                <td><?php echo $form -> title ?></td>
                                <td><?php echo $strength -> title ?></td>
                                <td><?php echo ucfirst($medicine -> type) ?></td>
                                <td><?php echo $quantity > 0 ? $quantity : 0 ?></td>
                                <td><?php echo $sold > 0 ? $sold : 0 ?></td>
                                <td><?php echo $returned > 0 ? $returned : 0 ?></td>
                                <td><?php echo $return_supplier > 0 ? $return_supplier : 0 ?></td>
                                <td><?php echo $expired > 0 ? $expired : 0 ?></td>
                                <td><?php echo $issued > 0 ? $issued : 0 ?></td>
                                <td><?php echo $ipd_issuance > 0 ? $ipd_issuance : 0 ?></td>
                                <td><?php echo $adjustment_qty > 0 ? $adjustment_qty : 0 ?></td>
                                <td><?php echo $available ?></td>
                                <td><?php echo number_format($net_value, 2) ?></td>
                                <td class="btn-group-xs">
                                    <a type="button" class="btn green" href="<?php echo base_url('/medicines/stock/'.$medicine -> id) ?>">Stock</a>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                        <tr>
                            <td colspan="15" class="text-right">
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

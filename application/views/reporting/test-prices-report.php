<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <form role="form" method="get" autocomplete="off">
            <div class="form-body" style="overflow: auto">
                <div class="form-group col-lg-5">
                    <label for="exampleInputEmail1">Test</label>
                    <select class="form-control select2me" name="test-id">
                        <option value="">Select</option>
                        <?php
                            if ( count ( $tests ) > 0 ) {
                                foreach ( $tests as $test ) {
                                    ?>
                                    <option value="<?php echo $test -> id ?>" <?php if ( $test -> id == @$_REQUEST[ 'test-id' ] )
                                        echo 'selected="selected"' ?>><?php echo $test -> name ?></option>
                                    <?php
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group col-lg-5">
                    <label for="exampleInputEmail1">Panel</label>
                    <select class="form-control select2me" name="panel-id">
                        <option value="">Select</option>
                        <?php
                            if ( count ( $panels ) > 0 ) {
                                foreach ( $panels as $panel ) {
                                    ?>
                                    <option value="<?php echo $panel -> id ?>" <?php if ( $panel -> id == @$_REQUEST[ 'panel-id' ] )
                                        echo 'selected="selected"' ?>><?php echo $panel -> name ?></option>
                                    <?php
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group col-lg-2">
                    <button type="submit" class="btn btn-primary btn-block" style="margin-top: 25px;">Search</button>
                </div>
            </div>
        </form>
        
        <form role="form" method="post" autocomplete="off">
            <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                   value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
            <input type="hidden" name="action" value="do_add_test_prices_discount">
            <div class="form-body" style="overflow: auto">
                <div class="form-group col-lg-5">
                    <label for="exampleInputEmail1">Discount (%)</label>
                    <input type="number" step="0.01" class="form-control" name="test-price-discount" required="required"
                           min="0" max="100"
                           value="<?php echo ( count ( $reports ) > 0 ) ? $reports[ 0 ] -> discount : 0 ?>">
                </div>
                <div class="form-group col-lg-2">
                    <button type="submit" class="btn btn-primary btn-block" style="margin-top: 25px;">Add Discount
                    </button>
                </div>
            </div>
        </form>
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-reorder"></i> Test Prices Report
                </div>
                <?php if ( count ( $reports ) > 0 ) : ?>
                    <a href="<?php echo base_url ( '/invoices/test-prices-report?' . $_SERVER[ 'QUERY_STRING' ] ) ?>"
                       class="pull-right print-btn" target="_blank">Print</a>
                <?php endif ?>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th> Sr. No</th>
                        <th> Code</th>
                        <th> Name</th>
                        <th> Type</th>
                        <th> Panel</th>
                        <th> Price</th>
                        <th> Discounted Price</th>
                        <th> Date Added</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $counter = 1;
                        $net = 0;
                        $discount_net = 0;
                        if ( count ( $reports ) > 0 ) {
                            foreach ( $reports as $report ) {
//                                $test = get_test_by_id ( $report -> test_id );
                                $prices = explode ( ',', $report -> prices );
                                $panels = explode ( ',', $report -> panels );
                                ?>
                                <tr>
                                    <td> <?php echo $counter++ ?> </td>
                                    <td> <?php echo $report -> test_code ?> </td>
                                    <td> <?php echo $report -> test_name ?> </td>
                                    <td> <?php echo ucwords ( $report -> test_type ) ?> </td>
                                    <td>
                                        <?php
                                            if ( count ( $panels ) > 0 ) {
                                                foreach ( $panels as $panel ) {
                                                    $panelInfo = get_panel_by_id ( $panel );
                                                    echo $panelInfo -> name . '<br/>';
                                                }
                                            } ?>
                                    </td>
                                    <td>
                                        <?php
                                            if ( count ( $prices ) > 0 ) {
                                                foreach ( $prices as $price ) {
                                                    $net = $net + $price;
                                                    echo number_format ( $price, 2 ) . '<br/>';
                                                }
                                            } ?>
                                    </td>
                                    <td>
                                        <?php
                                            if ( count ( $prices ) > 0 ) {
                                                foreach ( $prices as $price ) {
                                                    $discounted_price = $price - ( $price * ( $report -> discount / 100 ) );
                                                    $discount_net = $discount_net + $discounted_price;
                                                    echo number_format ( $discounted_price, 2 ) . '<br/>';
                                                }
                                            } ?>
                                    </td>
                                    <td> <?php echo date_setter ( $report -> date_added ) ?> </td>
                                </tr>
                                <?php
                            }
                        }
                    ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="5" align="right">
                            <strong>Total</strong>
                        </td>
                        <td><?php echo number_format ( $net, 2 ) ?></td>
                        <td colspan="2"><?php echo number_format ( $discount_net, 2 ) ?></td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>
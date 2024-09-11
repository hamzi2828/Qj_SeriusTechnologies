<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
    
        <div class="search">
            <form method="get">
                <div class="form-group col-md-5">
                    <label>Invoice#</label>
                    <input type="text" name="invoice" class="form-control" placeholder="Invoice#"
                           value="<?php echo @$_REQUEST[ 'invoice' ] ?>" autofocus="autofocus">
                </div>
                <div class="form-group col-md-3">
                    <label>Start Date</label>
                    <input type="text" name="start-date" class="form-control date-picker"
                           value="<?php echo @$_REQUEST[ 'start-date' ] ?>">
                </div>
                <div class="form-group col-md-3">
                    <label>End Date</label>
                    <input type="text" name="end-date" class="form-control date-picker"
                           value="<?php echo @$_REQUEST[ 'end-date' ] ?>">
                </div>
                <div class="form-group col-md-1">
                    <button type="submit" class="btn btn-primary btn-block" style="margin-top: 25px">Search</button>
                </div>
            </form>
        </div>
        
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
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i>
                    <?php echo $title ?>
                </div>
            </div>
            <div class="portlet-body" style="overflow: auto">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th> Sr. No </th>
                            <th> Invoice# </th>
                            <th> Name </th>
                            <th> Generic </th>
                            <th> Returned Qty. </th>
                            <th> Net Price </th>
                            <th> Date Returned</th>
                            <th> Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    if(count($returns) > 0) {
                        $counter = 1 + ( isset( $_REQUEST[ 'per_page' ] ) ? $_REQUEST[ 'per_page' ] : 0 );
                        foreach ( $returns as $return) {
                            $medicines = explode (',', $return -> medicines);
                            $quantities = explode (',', $return -> quantities);
                            $net_prices = explode (',', $return -> paid_to_customer);
                            $quantities = explode (',', $return -> quantities);
                            
                            ?>
                            <tr class="odd gradeX">
                                <td> <?php echo $counter++ ?> </td>
                                <td> <?php echo $return -> supplier_invoice ?> </td>
                                <td>
                                    <?php
                                        if (count ($medicines) > 0) {
                                            foreach ($medicines as $medicine) {
                                                $medicineInfo = get_medicine ( $medicine );
                                                echo $medicineInfo -> name . '<br/>';
                                            }
                                        }
                                        ?>
                                </td>
                                <td>
                                    <?php
                                        if ( count ( $medicines ) > 0 ) {
                                            foreach ( $medicines as $medicine ) {
                                                $medicineInfo = get_medicine ( $medicine );
                                                if ( $medicineInfo -> generic_id > 0) {
                                                    $genericInfo = get_generic ( $medicineInfo -> generic_id );
                                                    echo $genericInfo -> title . '<br/>';
                                                }
                                                else
                                                    echo '- <br/>';
                                            }
                                        }
                                        ?>
                                </td>
                                <td>
                                    <?php
                                        if ( count ( $quantities ) > 0 ) {
                                            foreach ( $quantities as $quantity ) {
                                                echo $quantity . '<br/>';
                                            }
                                        }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                        if ( count ( $net_prices ) > 0 ) {
                                            foreach ( $net_prices as $net_price ) {
                                                echo number_format ( $net_price, 2) . '<br/>';
                                            }
                                        }
                                    ?>
                                </td>
                                <td>
                                    <?php echo date_setter ($return -> date_added) ?>
                                </td>
                                <td>
                                    <a href="<?php echo base_url ( '/invoices/return-customer-invoice/' . $return -> supplier_invoice ); ?>" class="btn btn-xs purple" target="_blank">
                                        Print
                                    </a>
                                </td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                    </tbody>
                </table>
            </div>
            <div id="pagination">
                <ul class="tsc_pagination">
                    <!-- Show pagination links -->
					<?php foreach ( $links as $link ) {
						echo "<li>" . $link . "</li>";
					} ?>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
<style>
    .input-xsmall {
        width: 100px !important;
    }
    .portlet.box > .portlet-body {
        background-color: #fff;
        padding: 10px;
        overflow-y: auto;
        overflow-x: hidden;
    }
</style>
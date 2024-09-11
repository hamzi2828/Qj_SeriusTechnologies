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
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i> Discarded Expired Medicines
                </div>
            </div>
            <div class="portlet-body" style="overflow: auto">
                <table class="table table-striped table-bordered table-hover" id="sample_1">
                    <thead>
                        <tr>
                            <th> Sr. No </th>
                            <th> Name </th>
                            <th> Generic </th>
                            <th> Form </th>
                            <th> Strength </th>
                            <th> Type </th>
                            <th> Batch No </th>
                            <th> Quantity </th>
                            <th> Net Cost </th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    if(count($medicines) > 0) {
                        $counter = 1;
                        foreach ($medicines as $medicine) {
                            $med                = get_medicine ($medicine -> medicine_id);
                            $sold               = get_sold_quantity($medicine -> medicine_id);
                            $quantity           = get_stock_quantity($medicine -> medicine_id);
                            $generic            = get_generic( $med -> generic_id);
                            $form               = get_form( $med -> form_id);
                            $strength           = get_strength( $med -> strength_id);
                            ?>
                            <tr class="odd gradeX">
                                <td> <?php echo $counter++ ?> </td>
                                <td><?php echo $med -> name ?></td>
                                <td><?php if( $med -> generic_id > 1) echo $generic -> title ?></td>
                                <td><?php if( $med -> form_id > 1) echo  $form -> title ?></td>
                                <td><?php if( $med -> strength_id > 1) echo  $strength -> title ?></td>
                                <td><?php echo ucfirst( $med -> type) ?></td>
                                <td><?php echo $medicine -> batch_no ?></td>
                                <td><?php echo $medicine -> quantity ?></td>
                                <td><?php echo $medicine -> net_cost ?></td>
                            </tr>
                            <?php
                        }
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
    .portlet.box > .portlet-body {
        background-color: #fff;
        padding: 10px;
        overflow-y: auto;
        overflow-x: hidden;
    }
</style>
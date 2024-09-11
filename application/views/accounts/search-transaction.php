<!-- BEGIN PAGE CONTENT-->
<style>
    .search {
        width: 100%;
        display: block;
        float: left;
        background: #f5f5f5;
        padding: 15px 0 0 0;
        margin-bottom: 15px;
    }
</style>
<div class="row">
    <div class="col-lg-12">
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
        <div class="alert alert-info">
            <i class="fa fa-exclamation-circle"></i>
            <strong>Note!</strong> If you update the one transaction it is important to also update the second transaction if there is any. Second transaction will be shown below if it exists.
        </div>
    </div>
    <div class="col-md-12">
        <div class="search">
            <form method="get" autocomplete="off">
                <div class="form-group col-lg-3">
                    <label for="exampleInputEmail1">Transaction No#</label>
                    <input type="text" name="transaction_number" class="form-control" placeholder="Transaction No#"  required="required" value="<?php echo @$_REQUEST['transaction_number'] ?>">
                </div>
                <div class="col-lg-2" style="padding-top: 25px">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </form>
        </div>
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i> Search Transactions
                </div>
            </div>
            <div class="portlet-body form">
                <?php $double_entry = check_id_double_entry(@$transaction -> voucher_number, @$transaction -> id); ?>
                <form role="form" method="post" autocomplete="off">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" id="csrf_token">
                    <input type="hidden" name="action" value="do_update_transaction">
                    <input type="hidden" name="transaction_id" value="<?php echo @$transaction -> id ?>">
                    <input type="hidden" name="acc_head_id" value="<?php echo @$transaction -> acc_head_id ?>">
                    <div class="form-body" style="overflow:auto;">
                        <div class="form-group col-lg-3">
                            <label for="exampleInputEmail1">Choose Account Head</label>
                            <select name="acc_head_id" class="form-control select2me" required="required" id="acc_head_id">
                                <option value="0">Select Account Head</option>
                                <?php
                                if(count($account_heads) > 0) {
                                    foreach ($account_heads as $account_head) {
                                        $child = if_has_child($account_head -> id);
                                        ?>
                                        <option value="<?php echo $account_head -> id ?>" class="<?php if($child > 0) echo 'has-child' ?>" <?php if(@$transaction -> acc_head_id == $account_head -> id) echo 'selected' ?>>
                                            <?php echo $account_head -> title ?>
                                        </option>
                                        <?php
                                        echo get_child_account_heads($account_head -> id, @$transaction -> acc_head_id);
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-lg-2">
                            <label class="">Transaction Type</label>
                            <div class="radio-list">
                                <label class="radio-inline">
                                    <input type="radio" name="transaction_type" value="debit" <?php if(@$transaction -> transaction_type == 'debit') echo 'checked="checked"' ?>> Debit
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="transaction_type" value="credit" <?php if(@$transaction -> transaction_type == 'credit') echo 'checked="checked"' ?>> Credit
                                </label>
                            </div>
                        </div>
                        <div class="form-group col-lg-1">
                            <label for="exampleInputEmail1">Amount</label>
                            <input type="text" name="amount" class="form-control" placeholder="Add amount" value="<?php echo @$transaction -> debit + @$transaction -> credit ?>" required>
                        </div>
                        <?php /* <div class="form-group col-lg-3">
                            <label for="exampleInputEmail1">Remaining Balance</label>
                            <input type="text" class="form-control" id="remaining-balance" readonly="readonly">
                        </div> */ ?>
                        <div class="form-group col-lg-2">
                            <label for="exampleInputEmail1">Date</label>
                            <input type="text" name="trans_date" class="date date-picker form-control" placeholder="Transaction date"  required="required" value="<?php echo date('m/d/Y', strtotime(@$transaction -> trans_date)) ?>">
                        </div>
                        <div class="form-group col-lg-2">
                            <label for="exampleInputEmail1">Payment Mode</label>
                            <select name="payment_mode" class="form-control">
                                <option value="cash" <?php if(@$transaction -> payment_mode == 'cash') echo 'selected="selected"' ?>>Cash</option>
                                <option value="cheque" <?php if(@$transaction -> payment_mode == 'cheque') echo 'selected="selected"' ?>>Cheque</option>
                                <option value="online" <?php if(@$transaction -> payment_mode == 'online') echo 'selected="selected"' ?>>Online</option>
                            </select>
                        </div>
                        <div class="form-group col-lg-2">
                            <label for="exampleInputEmail1">Voucher Number</label>
                            <input type="text" name="voucher_number" class="form-control" value="<?php echo @$transaction -> voucher_number ?>" readonly="readonly">
                        </div>
                        <div class="form-group col-lg-12">
                            <label class="">Description</label>
                            <textarea name="description" rows="5" class="form-control"><?php echo @$transaction -> description ?></textarea>
                        </div>
                        <?php if(count($double_entry) > 0) :
                            $i = 2;
							foreach ($double_entry as $trans) { ?>
                            <div class="col-lg-12">
                                <h4 style="font-weight: 800 !important;border-bottom: 1px dashed #000;"> <?php echo ordinal($i) ?> Transaction </h4>
                                    <p>
                                        <strong>Transaction ID: </strong> <?php echo $trans -> id ?>
                                    </p>
                                    <p>
                                        <strong>Account
                                            Head: </strong> <?php echo get_account_head(@$trans -> acc_head_id) -> title ?>
                                    </p>
                                    <p>
                                        <strong>Transaction Type: </strong>
                                        <?php
                                        if (@$trans -> credit > 0)
                                            echo 'Debit';
                                        else
                                            echo 'Credit';
                                        ?>
                                    </p>
                                    <p>
                                        <strong>Debit: </strong> <?php echo @$trans -> credit ?>
                                    </p>
                                    <p>
                                        <strong>Credit: </strong> <?php echo @$trans -> debit ?>
                                    </p>
                                    <p>
                                        <strong>Voucher Number: </strong> <?php echo @$trans -> voucher_number ?>
                                    </p>
                                    <p>
                                        <strong>Description: </strong> <?php echo @$trans -> description ?>
                                    </p>
                                    <p>
                                        <strong>Date: </strong> <?php echo date_setter(@$trans -> date_added) ?>
                                    </p>
                                </div>
								<?php
								$i++;
							}
                        endif; ?>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn blue" <?php if(empty($transaction)) echo 'disabled="disabled"' ?> id="add-transaction">Update</button>
                        <?php if(!empty($transaction)) : ?>
                            <a href="<?php echo base_url('/invoices/transaction/'.@$transaction -> id) ?>" class="btn purple">Print Invoice</a>
                        <?php endif ?>
                        <?php if(!empty($transaction) and check_if_voucher_is_double_entry($transaction -> voucher_number) > 1) : ?>
                            <a href="<?php echo base_url('/invoices/voucher_transaction/'.@$transaction -> voucher_number) ?>" class="btn green">Print Voucher</a>
                        <?php endif ?>
						<?php if($double_entry and !empty($double_entry)) : ?>
                            <a href="<?php echo base_url('/accounts/revert_transaction/'.@$transaction -> voucher_number) ?>" class="btn red" onclick="return confirm('Are you sure? Once deleted can not be recover.')">Revert Transaction <small>(Delete)</small></a>
                        <?php endif ?>
                    </div>
                </form>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
<style>
    .has-child {
        font-weight: 600;
    }
    .child {
        padding-left: 15px;
    }
    .sub-child {
        padding-left: 30px;
    }
    .has-sub-child {
        font-weight: 600;
        padding-left: 15px;
    }
    .input-xsmall {
        width: 100px !important;
    }
    a.btn {
        display: inline-block;
        margin-bottom: 0;
    }
</style>
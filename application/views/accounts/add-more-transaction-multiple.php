<div class="sale-<?php echo $row ?>" style="position: relative;width: 100%;float: left;display: block;">
    <a href="javascript:void(0)" onclick="remove_row(<?php echo $row ?>)" style="position: absolute;left: 0;top: 30px;z-index: 9999">
        <i class="fa fa-trash-o"></i>
    </a>
    <div class="form-group col-lg-5">
        <label for="exampleInputEmail1">Choose Account Head</label>
        <select name="acc_head_id[]" class="form-control acc-heads-<?php echo $row ?>" id="acc_head_id" onchange="check_account_type(this.value, <?php echo $row ?>)">
            <option value="0">Select Account Head</option>
            <?php
            if(count($account_heads) > 0) {
                foreach ($account_heads as $account_head) {
                    $child = if_has_child($account_head -> id);
                    ?>
                    <option value="<?php echo $account_head -> id ?>" class="<?php if($child > 0) echo 'has-child' ?>">
                        <?php echo $account_head -> title ?>
                    </option>
                    <?php
                    echo get_child_account_heads($account_head -> id, '-1');
                }
            }
            ?>
        </select>
    </div>
    <div class="form-group col-lg-3">
        <label class="">Transaction Type</label>
        <div class="radio-list" style="">
            <label class="radio-inline">
                <input type="radio" name="transaction_type[]_<?php echo $row ?>" id="debit-<?php echo $row ?>" value="credit" required="required"> Debit
            </label>
            <label class="radio-inline">
                <input type="radio" name="transaction_type[]_<?php echo $row ?>" id="credit-<?php echo $row ?>" value="debit" required="required"> Credit
            </label>
        </div>
    </div>
    <div class="form-group col-lg-4">
        <label for="exampleInputEmail1">Amount</label>
        <input type="text" name="amount[]" class="form-control price" placeholder="Add amount" value="<?php echo set_value('amount') ?>" onchange="sum_transaction_amount()">
    </div>
</div>
<style>
    .add-more {
        width: 100%;
        float: left;
        display: block;
    }
</style>
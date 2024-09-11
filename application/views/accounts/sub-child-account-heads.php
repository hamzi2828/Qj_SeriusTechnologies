<?php
if(count($account_heads) > 0) {
    foreach ($account_heads as $account_head) {
        ?>
        <option value="<?php if($single_account_head != '-1') { echo 'sc-'.$account_head -> id; } else { echo $account_head -> id; } ?>" class="sub-child" <?php if($single_account_head == $account_head -> id) echo 'selected' ?>><?php echo $account_head -> title ?></option>
<?php
    }
}
?>
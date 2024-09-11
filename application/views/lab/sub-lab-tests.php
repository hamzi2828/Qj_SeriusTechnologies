<?php
    if(count ($tests) > 0) {
        foreach ($tests as $test) {
            $hasChild = check_if_test_has_sub_tests ($test -> id);
            $price = get_test_price ( $test -> id, $panel_id );
            ?>
            <option value="<?php echo $test -> id ?>" class="child <?php if($hasChild) echo 'has-child'; ?>">
                <?php echo '('.$test -> code.') '.$test -> name ?>
                (<?php echo $price -> price > 0 ? $price -> price : '0' ?>)
            </option>
    <?php
            echo get_sub_lab_tests($test -> id, $panel_id);
        }
    }
?>
<option></option>
<?php
    if ( count ( $tests ) > 0 ) {
        foreach ( $tests as $test ) {
            $hasChild = check_if_test_has_sub_tests ( $test -> id );
            $price = get_test_price ( $test -> id, $panel_id )
            ?>
            <option value="<?php echo $test -> id ?>"
                    class="<?php if ( $hasChild ) echo 'has-child'; ?> test-option-<?php echo $test -> id ?>">
                <?php echo '(' . $test -> code . ') ' . $test -> name . ' (' . $price -> price . ' Rs)' ?>
            </option>
            <?php
        }
    }
?>
<ul style="padding: 0; list-style-type: none;">
    <li style="padding: 15px 15px 0 15px">Following reports already added against this invoice:</li>
    <?php
        if ( count ( $reports ) > 0 ) {
            foreach ( $reports as $report ) {
                ?>
                <li style="padding: 15px;">
                    <h5 style="margin-top: 0; font-weight: 700 !important; text-decoration: underline;"><?php echo $report -> report_title ?></h5>
                    <span style="font-style: italic; font-size: 12px;">Added By: <?php echo get_user ( $report -> user_id ) -> name ?></span>
                </li>
                <?php
            }
        }
    ?>
</ul>
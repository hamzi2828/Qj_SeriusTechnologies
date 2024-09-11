<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <?php if ( validation_errors () != false ) { ?>
            <div class="alert alert-danger validation-errors">
                <?php echo validation_errors (); ?>
            </div>
        <?php } ?>
        <?php if ( $this -> session -> flashdata ( 'error' ) ) : ?>
            <div class="alert alert-danger">
                <?php echo $this -> session -> flashdata ( 'error' ) ?>
            </div>
        <?php endif; ?>
        <?php if ( $this -> session -> flashdata ( 'response' ) ) : ?>
            <div class="alert alert-success">
                <?php echo $this -> session -> flashdata ( 'response' ) ?>
            </div>
        <?php endif; ?>
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i> <?php echo $title ?>
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover" id="sample_1">
                    <thead>
                    <tr>
                        <th> Sr. No</th>
                        <th> Prefix</th>
                        <th> Name</th>
                        <th> Representative</th>
                        <th> Contact</th>
                        <th> Date Added</th>
                        <th> Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $counter = 1;
                        if ( count ( $oep ) > 0 ) {
                            foreach ( $oep as $person ) {
                                ?>
                                <tr>
                                    <td><?php echo $counter++ ?></td>
                                    <td><?php echo $person -> prefix ?></td>
                                    <td><?php echo $person -> name ?></td>
                                    <td><?php echo $person -> representative ?></td>
                                    <td><?php echo $person -> contact ?></td>
                                    <td><?php echo date_setter ( $person -> created_at, 5 ) ?></td>
                                    <td class="btn-group-xs">
                                        <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'edit-oep', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                            <a class="btn blue"
                                               href="<?php echo base_url ( '/medical-test-settings/oep/edit/' . $person -> id ) ?>">Edit</a>
                                        <?php endif; ?>
                                        
                                        <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'delete-oep', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                            <a class="btn red" onclick="return confirm('Are you sure?')"
                                               href="<?php echo base_url ( '/medical-test-settings/oep/destroy/' . $person -> id ) ?>">Delete</a>
                                        <?php endif; ?>
                                    </td>
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
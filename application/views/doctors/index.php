<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <?php
            if ( validation_errors () != false ) { ?>
                <div class="alert alert-danger validation-errors">
                    <?php
                        echo validation_errors (); ?>
                </div>
            <?php
            } ?>
        <?php
            if ( $this -> session -> flashdata ( 'error' ) ) : ?>
                <div class="alert alert-danger">
                    <?php
                        echo $this -> session -> flashdata ( 'error' ) ?>
                </div>
            <?php
            endif; ?>
        <?php
            if ( $this -> session -> flashdata ( 'response' ) ) : ?>
                <div class="alert alert-success">
                    <?php
                        echo $this -> session -> flashdata ( 'response' ) ?>
                </div>
            <?php
            endif; ?>
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i> Doctors
                </div>
            </div>
            <div class="portlet-body horizontal-scroll">
                <table class="table table-striped table-bordered table-hover table-responsive" id="sample_1">
                    <thead>
                    <tr>
                        <th> Sr. No</th>
                        <th> Name</th>
                        <th> Phone</th>
                        <th> CNIC</th>
                        <th> Specialization</th>
                        <th> Availability</th>
                        <th> Date Added</th>
                        <th> Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        if ( count ( $doctors ) > 0 ) {
                            $counter = 1;
                            foreach ( $doctors as $doctor ) {
                                $specialization = get_specialization_by_id ( $doctor -> specialization_id );
                                ?>
                                <tr class="odd gradeX">
                                    <td> <?php
                                            echo $counter ++ ?> </td>
                                    <td><?php
                                            echo $doctor -> name ?></td>
                                    <td><?php
                                            echo $doctor -> phone ?></td>
                                    <td><?php
                                            echo $doctor -> cnic ?></td>
                                    <td><?php
                                            echo $specialization -> title ?></td>
                                    <td>
                                        <?php
                                            echo date ( 'g:i a', strtotime ( $doctor -> available_from ) ) ?> -
                                        <?php
                                            echo date ( 'g:i a', strtotime ( $doctor -> available_till ) ) ?>
                                    </td>
                                    <td><?php
                                            echo date_setter ( $doctor -> date_added ) ?></td>
                                    <td class="btn-group-xs">
                                        <?php
                                            if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'view_doctors', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                                <a type="button" class="btn purple" href="<?php
                                                    echo base_url ( '/doctors/view/' . $doctor -> id ) ?>">View</a>
                                            <?php
                                            endif; ?>
                                        <?php
                                            if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'edit_doctors', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                                <a type="button" class="btn blue" href="<?php
                                                    echo base_url ( '/doctors/edit/' . $doctor -> id ) ?>">Edit</a>
                                            <?php
                                            endif; ?>
                                        <?php
                                            if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'delete_doctors', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                                <a type="button" class="btn red" href="<?php
                                                    echo base_url ( '/doctors/delete/' . $doctor -> id ) ?>"
                                                   onclick="return confirm('Are you sure to delete?')">Delete</a>
                                            <?php
                                            endif; ?>
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
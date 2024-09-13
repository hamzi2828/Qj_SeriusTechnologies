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
                    <th>Sr. No</th>
                    <th>Template Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                foreach ($templates as $template) {
                    ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $template->template_name; ?></td>
                       
                        <td>
                            <a href="<?php echo base_url ( '/medical-test-settings/template/edit/' . $template -> id ) ?>" class="btn btn-sm btn-success">Edit</a>
									
                            <a href="<?php echo base_url('/medical-test/template/delete/'.$template->id); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this template?');">Delete</a>
                        </td>
                    </tr>
                    <?php
                    $i++;
                }
                ?>
           </tbody>
        </table>

            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
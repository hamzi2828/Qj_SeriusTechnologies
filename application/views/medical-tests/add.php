<style>
    .nav-tabs {
        border: 1px solid #e3e3e3;
    }

    .nav-tabs a {
        margin: 0 !important;
    }

    .nav-tabs > li.active {
        border-top: 3px solid #d12610;
        border-bottom: 1px solid #e3e3e3;
        margin-top: 0;
        position: relative;
    }
</style>
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
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-body form">
                <?php require_once 'tabs.php'; ?>
                <div class="tab-content">
                    <?php require_once 'general-information.php'; ?>
                </div>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>
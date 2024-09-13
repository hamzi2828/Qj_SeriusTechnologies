<?php
    $parent_uri    = $this -> uri -> segment ( 1 );
    $child_uri     = $this -> uri -> segment ( 2 );
    $sub_child_uri = $this -> uri -> segment ( 3 );
    $access        = get_user_access ( get_logged_in_user_id () );
?>
<!-- BEGIN SIDEBAR -->
<div class="page-sidebar-wrapper">
    <div class="page-sidebar navbar-collapse collapse">
        <!-- BEGIN SIDEBAR MENU -->
        <ul class="page-sidebar-menu" id="nav">
            
            <li class="sidebar-toggler-wrapper">
                <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                <div class="sidebar-toggler hidden-phone">
                </div>
                <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
            </li>
            
            <li class="sidebar-search-wrapper">
                <!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
                <form class="sidebar-search" method="POST">
                    <div class="form-container">
                        <div class="input-box">
                            <a href="javascript:void(0);" class="remove"></a>
                            <input type="text" placeholder="Search..." readonly="readonly" />
                            <input type="button" class="submit" value="" disabled="disabled" />
                        </div>
                    </div>
                </form>
                <!-- END RESPONSIVE QUICK SEARCH FORM -->
            </li>
            
            <?php if ( !empty( $access ) and in_array ( 'dashboard', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $parent_uri == 'dashboard' )
                    echo 'start active'; ?>">
                    <a href="<?php echo base_url () ?>">
                        <i class="fa fa-home"></i>
                        <span class="title">
						Dashboard
					</span>
                    </a>
                </li>
            <?php endif; ?>
            
            <?php if ( !empty( $access ) and in_array ( 'stats-dashboard', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $parent_uri == 'stats-dashboard' )
                    echo 'start active'; ?>">
                    <a href="<?php echo base_url ( '/stats-dashboard' ) ?>">
                        <i class="fa fa-line-chart"></i>
                        <span class="title">
						Stats Dashboard
					</span>
                    </a>
                </li>
            <?php endif; ?>
            
            <?php if ( !empty( $access ) and in_array ( 'metrics-analysis', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $parent_uri == 'analysis' )
                    echo 'start active'; ?>">
                    <a href="javascript:void(0);">
                        <i class="fa fa-bar-chart"></i>
                        <span class="title"> Metrics Analysis </span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <?php if ( !empty( $access ) and in_array ( 'patients_analysis', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'patients' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/analysis/patients' ) ?>">
                                    Patients Analysis
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
            
            <?php if ( !empty( $access ) and in_array ( 'patients', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $parent_uri == 'patients' )
                    echo 'start active'; ?>">
                    <a href="javascript:void(0);">
                        <i class="fa fa-user"></i>
                        <span class="title"> Patients </span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <?php if ( !empty( $access ) and in_array ( 'all_patients', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'index' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/patients/index' ) ?>">
                                    All Patients
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'add_patient', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'add' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/patients/add' ) ?>">
                                    Add Patient (Cash)
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'add_patient_panel', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'add-panel-patient' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/patients/add-panel-patient' ) ?>">
                                    Add Patient (Panel)
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
            
            <?php if ( !empty( $access ) and in_array ( 'consultancy', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $parent_uri == 'consultancy' and $child_uri != 'prescriptions' )
                    echo 'start active'; ?>">
                    <a href="javascript:void(0);">
                        <i class="fa fa-handshake-o" aria-hidden="true"></i>
                        <span class="title"> Consultancy </span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <?php if ( !empty( $access ) and in_array ( 'cash_consultancies', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'index' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/consultancy/index' ) ?>">
                                    Consultancy Invoices (Cash)
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'panel_consultancies', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'panel-consultancy-invoices' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/consultancy/panel-consultancy-invoices' ) ?>">
                                    Consultancy Invoices (Panel)
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'add_consultancies', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'add' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/consultancy/add' ) ?>">
                                    Add Consultancy
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
            
            <?php if ( !empty( $access ) and in_array ( 'consultancy-reporting', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $parent_uri == 'ConsultancyReport' )
                    echo 'start active'; ?>">
                    <a href="javascript:void(0);">
                        <i class="fa fa-search"></i>
                        <span class="title"> Consultancy Reporting </span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <?php if ( !empty( $access ) and in_array ( 'consultancy_general_reporting', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'general-report' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/ConsultancyReport/general-report' ) ?>">
                                    General Report (Cash)
                                </a>
                            </li>
                            <li class="<?php if ( $child_uri == 'general-report-1' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/ConsultancyReport/general-report-1' ) ?>">
                                    General Report 1
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'consultancy_general_reporting_panel', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'general-report-panel' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/ConsultancyReport/general-report-panel' ) ?>">
                                    General Report (Panel)
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'doctor_consultancy_reporting', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'doctor-consultancy-report' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/ConsultancyReport/doctor-consultancy-report' ) ?>">
                                    Doctor Wise Report
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
            
            <?php if ( !empty( $access ) and in_array ( 'doctor-prescriptions', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'prescriptions' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/consultancy/prescriptions' ) ?>">
                        <i class="fa fa-user-md" aria-hidden="true"></i>
                        <span class="title"> Doctor Prescriptions </span>
                    </a>
                </li>
            <?php endif; ?>
            
            <?php if ( !empty( $access ) and in_array ( 'nursing_station', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $parent_uri == 'vitals' )
                    echo 'start active'; ?>">
                    <a href="javascript:void(0);">
                        <i class="fa fa-stethoscope" aria-hidden="true"></i>
                        <span class="title"> Nursing Station </span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <?php if ( !empty( $access ) and in_array ( 'vitals', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'index' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/vitals/index' ) ?>">
                                    All Vitals
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'add_vitals', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'add' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/vitals/add' ) ?>">
                                    Add Patient Vitals
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
            
            <?php if ( !empty( $access ) and in_array ( 'doctor_settings', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $parent_uri == 'doctors' or $parent_uri == 'specialization' or $parent_uri == 'instructions' )
                    echo 'start active'; ?>">
                    <a href="javascript:void(0);">
                        <i class="fa fa-user-md" aria-hidden="true"></i>
                        <span class="title"> Doctor Settings </span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <?php if ( !empty( $access ) and in_array ( 'all_doctors', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'index' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/doctors/index' ) ?>">
                                    All Doctors
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'add_doctors', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'add' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/doctors/add' ) ?>">
                                    Add Doctor
                                </a>
                            </li>
                        <?php endif; ?>
                        <hr style="margin: 0 auto;border-bottom: 0;width: 100%;border-top: 1px solid #5c5c5c;">
                        <?php if ( !empty( $access ) and in_array ( 'all_specializations', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'specializations' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/specialization/specializations' ) ?>">
                                    All Specializations
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'add_specializations', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'add-specialization' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/specialization/add-specialization' ) ?>">
                                    Add Specialization
                                </a>
                            </li>
                        <?php endif; ?>
                        <hr style="margin: 0 auto;border-bottom: 0;width: 100%;border-top: 1px solid #5c5c5c;">
                        <?php if ( !empty( $access ) and in_array ( 'all_follow_ups', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'follow-up' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/doctors/follow-up' ) ?>">
                                    All Follow Ups
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'add_follow_up', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'add-follow-up' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/doctors/add-follow-up' ) ?>">
                                    Add Follow Up
                                </a>
                            </li>
                        <?php endif; ?>
                        <hr style="margin: 0 auto;border-bottom: 0;width: 100%;border-top: 1px solid #5c5c5c;">
                        <?php if ( !empty( $access ) and in_array ( 'medicine_rx', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'index' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/instructions/index' ) ?>">
                                    Medicines R<sub>x</sub>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'add_medicine_rx', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'add' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/instructions/add' ) ?>">
                                    Add Medicine R<sub>x</sub>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
            
            <?php if ( !empty( $access ) and in_array ( 'radiology', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $parent_uri == 'radiology' )
                    echo 'start active'; ?>">
                    <a href="javascript:void(0);">
                        <i class="fas fa-x-ray"></i>
                        <span class="title"> Radiology </span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <?php if ( !empty( $access ) and in_array ( 'xray', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'x-ray' )
                                echo 'start active'; ?>">
                                <a href="javascript:void(0);" style="<?php if ( $child_uri == 'x-ray' )
                                    echo 'background: #e02222 !important;'; ?>">
                                    <i class="fas fa-fingerprint"></i>
                                    <span class="title"> X-Ray </span>
                                    <span class="arrow "></span>
                                </a>
                                <ul class="sub-menu">
                                    <?php if ( !empty( $access ) and in_array ( 'add_xray_report', explode ( ',', $access -> access ) ) ) : ?>
                                        <li class="<?php if ( $sub_child_uri == 'add-xray-report' )
                                            echo 'active'; ?>">
                                            <a href="<?php echo base_url ( 'radiology/x-ray/add-xray-report' ) ?>">
                                                Add Report
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if ( !empty( $access ) and in_array ( 'search_xray_report', explode ( ',', $access -> access ) ) ) : ?>
                                        <li class="<?php if ( $sub_child_uri == 'search-xray-report' )
                                            echo 'active'; ?>">
                                            <a href="<?php echo base_url ( 'radiology/x-ray/search-xray-report' ) ?>">
                                                Search Report
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if ( !empty( $access ) and in_array ( 'all_xray_reports', explode ( ',', $access -> access ) ) ) : ?>
                                        <li class="<?php if ( $sub_child_uri == 'xray-reports' )
                                            echo 'active'; ?>">
                                            <a href="<?php echo base_url ( 'radiology/x-ray/xray-reports' ) ?>">
                                                All Reports
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'ultrasound', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'ultrasound' )
                                echo 'active'; ?>">
                                <a href="javascript:void(0);" style="<?php if ( $child_uri == 'ultrasound' )
                                    echo 'background: #e02222 !important;'; ?>">
                                    <i class="fas fa-syringe"></i>
                                    <span class="title"> Ultrasound </span>
                                    <span class="arrow "></span>
                                </a>
                                <ul class="sub-menu">
                                    <?php if ( !empty( $access ) and in_array ( 'add_ultrasound_report', explode ( ',', $access -> access ) ) ) : ?>
                                        <li class="<?php if ( $sub_child_uri == 'add-ultrasound-report' )
                                            echo 'active'; ?>">
                                            <a href="<?php echo base_url ( 'radiology/ultrasound/add-ultrasound-report' ) ?>">
                                                Add Report
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if ( !empty( $access ) and in_array ( 'search_ultrasound_report', explode ( ',', $access -> access ) ) ) : ?>
                                        <li class="<?php if ( $sub_child_uri == 'search-ultrasound-report' )
                                            echo 'active'; ?>">
                                            <a href="<?php echo base_url ( 'radiology/ultrasound/search-ultrasound-report' ) ?>">
                                                Search Report
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if ( !empty( $access ) and in_array ( 'all_ultrasound_reports', explode ( ',', $access -> access ) ) ) : ?>
                                        <li class="<?php if ( $sub_child_uri == 'ultrasound-reports' )
                                            echo 'active'; ?>">
                                            <a href="<?php echo base_url ( 'radiology/ultrasound/ultrasound-reports' ) ?>">
                                                All Reports
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
            
            <?php if ( !empty( $access ) and in_array ( 'radiology-reporting', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $parent_uri == 'RadiologyReport' )
                    echo 'start active'; ?>">
                    <a href="javascript:void(0);">
                        <i class="fa fa-search"></i>
                        <span class="title"> Radiology Reporting </span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <?php if ( !empty( $access ) and in_array ( 'xray_general_reporting', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'general-report-xray' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/RadiologyReport/general-report-xray' ) ?>">
                                    General Report (X-Ray)
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'ultrasound_general_reporting', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'general-report-ultrasound' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/RadiologyReport/general-report-ultrasound' ) ?>">
                                    General Report (UltraSound)
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
            
            <?php if ( !empty( $access ) and in_array ( 'radiology-settings', explode ( ',', $access -> access ) ) and !isset( $_GET[ 'menu' ] ) ) : ?>
                <li class="<?php if ( $parent_uri == 'templates' )
                    echo 'start active'; ?>">
                    <a href="javascript:void(0);">
                        <i class="fa fa-cog"></i>
                        <span class="title"> Radiology Settings </span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <?php if ( !empty( $access ) and in_array ( 'templates', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'templates' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/templates/index' ) ?>">
                                    All Templates (Ultrasound)
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'add-templates', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'add' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/templates/add' ) ?>">
                                    Add Templates (Ultrasound)
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'templates-xray', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'xray-templates' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/templates/xray-templates' ) ?>">
                                    All Templates (X-Ray)
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'add-templates-xray', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'add-xray-templates' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/templates/add-xray-templates' ) ?>">
                                    Add Templates (X-Ray)
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
            
            <?php if ( !empty( $access ) and in_array ( 'opd', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $parent_uri == 'OPD' or $parent_uri == 'settings' and !isset( $_REQUEST[ 'settings' ] ) )
                    echo 'start active'; ?>">
                    <a href="javascript:void(0);">
                        <i class="fa fa-opera" aria-hidden="true"></i>
                        <span class="title"> OPD </span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <?php if ( !empty( $access ) and in_array ( 'all_opd_services', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'opd-services' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/settings/opd-services' ) ?>">
                                    All Services
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'sale_opd_services', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'sale' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/OPD/sale' ) ?>">
                                    Sale Services
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'sale_opd_invoices', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'sales' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/OPD/sales' ) ?>">
                                    Sale Invoices (Cash)
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'panel_sale_opd_invoices', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'panel_sales' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/OPD/panel_sales' ) ?>">
                                    Sale Invoices (Panel)
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
            
            <?php if ( !empty( $access ) and in_array ( 'opd-reporting', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $parent_uri == 'OpdReport' )
                    echo 'start active'; ?>">
                    <a href="javascript:void(0);">
                        <i class="fa fa-search"></i>
                        <span class="title"> OPD Reporting </span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <?php if ( !empty( $access ) and in_array ( 'opd_general_reporting', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'general-report' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/OpdReport/general-report' ) ?>">
                                    General Report (Cash)
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'opd_general_reporting_panel', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'general-report-panel' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/OpdReport/general-report-panel' ) ?>">
                                    General Report (Panel)
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
            
            <?php /*if(!empty($access) and in_array('opd_settings', explode(',', $access -> access))) : ?>
            <li class="<?php if($parent_uri == 'settings' and @$_REQUEST['settings'] == 'opd') echo 'start active'; ?>">
                <a href="javascript:void(0);">
                    <i class="fa fa-cog" aria-hidden="true"></i>
                    <span class="title"> OPD Settings </span>
                    <span class="arrow "></span>
                </a>
                <ul class="sub-menu">
					<?php if(!empty($access) and in_array('add_opd_services', explode(',', $access -> access))) : ?>
                    <li class="<?php if($child_uri == 'add-opd-services') echo 'active'; ?>">
                        <a href="<?php echo base_url('/settings/add-opd-services?settings=opd') ?>">
                            Add Services
                        </a>
                    </li>
					<?php endif; ?>
                </ul>
            </li>
            <?php endif; */ ?>
            
            <?php if ( !empty( $access ) and in_array ( 'ipd', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $parent_uri == 'IPD' )
                    echo 'start active'; ?>">
                    <a href="javascript:void(0);">
                        <i class="fa fa-italic"></i>
                        <span class="title"> IPD </span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <?php if ( !empty( $access ) and in_array ( 'ipd_register_patient', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'sale' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/IPD/sale' ) ?>">
                                    Admin. & Discharge
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'ipd_invoice', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'sales' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/IPD/sales' ) ?>">
                                    IPD Invoices (Cash)
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'ipd_invoice_panel', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'panel-sales' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/IPD/panel-sales' ) ?>">
                                    IPD Invoices (Panel)
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'ipd_discharged_patient', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'discharged' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/IPD/discharged' ) ?>">
                                    Discharged Patients
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'ipd_mo', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'mo' )
                                echo 'active'; ?>">
                                <a href="javascript:void(0);" style="<?php if ( $child_uri == 'mo' )
                                    echo 'background: #e02222 !important;'; ?>">
                                    <i class="fas fa-user-md"></i>
                                    <span class="title"> MO </span>
                                    <span class="arrow "></span>
                                </a>
                                <ul class="sub-menu">
                                    <?php if ( !empty( $access ) and in_array ( 'ipd_mo_add_admissions', explode ( ',', $access -> access ) ) ) : ?>
                                        <li class="<?php if ( $sub_child_uri == 'add-admission-order' )
                                            echo 'active'; ?>">
                                            <a href="<?php echo base_url ( 'IPD/mo/add-admission-order' ) ?>">
                                                Add Admission Orders
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if ( !empty( $access ) and in_array ( 'ipd_mo_admissions', explode ( ',', $access -> access ) ) ) : ?>
                                        <li class="<?php if ( $sub_child_uri == 'mo-admission-orders' )
                                            echo 'active'; ?>">
                                            <a href="<?php echo base_url ( 'IPD/mo/mo-admission-orders' ) ?>">
                                                All Admission Orders
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <hr style="margin: 0 auto;border-bottom: 0;width: 100%;border-top: 1px solid #5c5c5c;">
                                    <?php if ( !empty( $access ) and in_array ( 'physical_examination', explode ( ',', $access -> access ) ) ) : ?>
                                        <li class="<?php if ( $sub_child_uri == 'add-physical-examination' )
                                            echo 'active'; ?>">
                                            <a href="<?php echo base_url ( 'IPD/mo/add-physical-examination' ) ?>">
                                                Add Physical Examination
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if ( !empty( $access ) and in_array ( 'all_physical_examination', explode ( ',', $access -> access ) ) ) : ?>
                                        <li class="<?php if ( $sub_child_uri == 'all-physical-examination' )
                                            echo 'active'; ?>">
                                            <a href="<?php echo base_url ( 'IPD/mo/all-physical-examination' ) ?>">
                                                All Physical Examinations
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <hr style="margin: 0 auto;border-bottom: 0;width: 100%;border-top: 1px solid #5c5c5c;">
                                    <?php if ( !empty( $access ) and in_array ( 'add_progress_notes', explode ( ',', $access -> access ) ) ) : ?>
                                        <li class="<?php if ( $sub_child_uri == 'add-progress-notes' )
                                            echo 'active'; ?>">
                                            <a href="<?php echo base_url ( 'IPD/mo/add-progress-notes' ) ?>">
                                                Add Progress Notes
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if ( !empty( $access ) and in_array ( 'all_progress_notes', explode ( ',', $access -> access ) ) ) : ?>
                                        <li class="<?php if ( $sub_child_uri == 'all-progress-notes' )
                                            echo 'active'; ?>">
                                            <a href="<?php echo base_url ( 'IPD/mo/all-progress-notes' ) ?>">
                                                All Progress Notes
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <hr style="margin: 0 auto;border-bottom: 0;width: 100%;border-top: 1px solid #5c5c5c;">
                                    <?php if ( !empty( $access ) and in_array ( 'add_diagnostic_flow_sheet', explode ( ',', $access -> access ) ) ) : ?>
                                        <li class="<?php if ( $sub_child_uri == 'add-diagnostic-flow-sheet' )
                                            echo 'active'; ?>">
                                            <a href="<?php echo base_url ( 'IPD/mo/add-diagnostic-flow-sheet' ) ?>">
                                                Add Diagnostics
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if ( !empty( $access ) and in_array ( 'all_diagnostic_flow_sheet', explode ( ',', $access -> access ) ) ) : ?>
                                        <li class="<?php if ( $sub_child_uri == 'all-diagnostic-flow-sheet' )
                                            echo 'active'; ?>">
                                            <a href="<?php echo base_url ( 'IPD/mo/all-diagnostic-flow-sheet' ) ?>">
                                                All Diagnostics
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <hr style="margin: 0 auto;border-bottom: 0;width: 100%;border-top: 1px solid #5c5c5c;">
                                    <?php if ( !empty( $access ) and in_array ( 'add_blood_transfusion', explode ( ',', $access -> access ) ) ) : ?>
                                        <li class="<?php if ( $sub_child_uri == 'add-blood-transfusion' )
                                            echo 'active'; ?>">
                                            <a href="<?php echo base_url ( 'IPD/mo/add-blood-transfusion' ) ?>">
                                                Add Blood Transfusion
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if ( !empty( $access ) and in_array ( 'all_blood_transfusion', explode ( ',', $access -> access ) ) ) : ?>
                                        <li class="<?php if ( $sub_child_uri == 'all-blood-transfusions' )
                                            echo 'active'; ?>">
                                            <a href="<?php echo base_url ( 'IPD/mo/all-blood-transfusions' ) ?>">
                                                All Blood Transfusions
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <hr style="margin: 0 auto;border-bottom: 0;width: 100%;border-top: 1px solid #5c5c5c;">
                                    <?php if ( !empty( $access ) and in_array ( 'add_discharge_slip', explode ( ',', $access -> access ) ) ) : ?>
                                        <li class="<?php if ( $sub_child_uri == 'add-discharge-slip' )
                                            echo 'active'; ?>">
                                            <a href="<?php echo base_url ( 'IPD/mo/add-discharge-slip' ) ?>">
                                                Add Discharge Slip
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if ( !empty( $access ) and in_array ( 'all_discharge_slips', explode ( ',', $access -> access ) ) ) : ?>
                                        <li class="<?php if ( $sub_child_uri == 'all-discharge-slips' )
                                            echo 'active'; ?>">
                                            <a href="<?php echo base_url ( 'IPD/mo/all-discharge-slips' ) ?>">
                                                All Discharge Slips
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <hr style="margin: 0 auto;border-bottom: 0;width: 100%;border-top: 1px solid #5c5c5c;">
                                    <?php if ( !empty( $access ) and in_array ( 'add_discharge_summary', explode ( ',', $access -> access ) ) ) : ?>
                                        <li class="<?php if ( $sub_child_uri == 'add-discharge-summary' )
                                            echo 'active'; ?>">
                                            <a href="<?php echo base_url ( 'IPD/mo/add-discharge-summary' ) ?>">
                                                Add Discharge Summary
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if ( !empty( $access ) and in_array ( 'all_discharge_summary', explode ( ',', $access -> access ) ) ) : ?>
                                        <li class="<?php if ( $sub_child_uri == 'all-discharge-summary' )
                                            echo 'active'; ?>">
                                            <a href="<?php echo base_url ( 'IPD/mo/all-discharge-summary' ) ?>">
                                                All Discharge Summary
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
            
            <?php if ( !empty( $access ) and in_array ( 'ipd-reporting', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $parent_uri == 'ipd-reporting' )
                    echo 'start active'; ?>">
                    <a href="javascript:void(0);">
                        <i class="fa fa-search"></i>
                        <span class="title"> IPD Reporting </span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <?php if ( !empty( $access ) and in_array ( 'ipd_general_report', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'general-report' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/ipd-reporting/general-report' ) ?>">
                                    General Report (Cash)
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'ipd_general_report_panel', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'general-report-panel' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/ipd-reporting/general-report-panel' ) ?>">
                                    General Report (Panel)
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'consultant_commission', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'consultant-commission' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/ipd-reporting/consultant-commission' ) ?>">
                                    Consultant Commission
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'ot_timings_report', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'ot-timings' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/ipd-reporting/ot-timings' ) ?>">
                                    OT Timings Report
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
            
            <?php if ( !empty( $access ) and in_array ( 'ipd-settings', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $parent_uri == 'settings' and @$_REQUEST[ 'settings' ] == 'ipd' )
                    echo 'start active'; ?>">
                    <a href="javascript:void(0);">
                        <i class="fa fa-cog"></i>
                        <span class="title"> IPD - OPD Settings </span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <?php if ( !empty( $access ) and in_array ( 'ipd_services', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'ipd-services' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/settings/ipd-services?settings=ipd' ) ?>">
                                    Services
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'add_ipd_services', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'add-ipd-services' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/settings/add-ipd-services?settings=ipd' ) ?>">
                                    Add Services
                                </a>
                            </li>
                        <?php endif; ?>
                        <hr style="margin: 0 auto;border-bottom: 0;width: 100%;border-top: 1px solid #5c5c5c;">
                        <?php if ( !empty( $access ) and in_array ( 'ipd_packages', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'ipd-packages' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/settings/ipd-packages?settings=ipd' ) ?>">
                                    Packages
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'add_ipd_packages', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'add-ipd-packages' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/settings/add-ipd-packages?settings=ipd' ) ?>">
                                    Add Packages
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
            
            <?php if ( !empty( $access ) and in_array ( 'internal-issuance', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( ( $parent_uri == 'internal-issuance' or $parent_uri == 'stock-return' ) and !isset( $_REQUEST[ 'active' ] ) )
                    echo 'start active'; ?>">
                    <a href="javascript:void(0);">
                        <i class="fas fa-door-open"></i>
                        <span class="title">
						Internal Issuance (Med)
					</span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <?php if ( !empty( $access ) and in_array ( 'issue_internal_medicine', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'issue' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/internal-issuance/issue' ) ?>">
                                    Issue Medicine
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'search_internal_issuance', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'search-issuance' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/internal-issuance/search-issuance' ) ?>">
                                    Search Issuance
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'all_internal_issuance', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'issuance' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/internal-issuance/issuance' ) ?>">
                                    All Issuance
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
            
            <?php if ( !empty( $access ) and in_array ( 'internal-issuance-medicines-settings', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $parent_uri == 'settings' and @$_REQUEST[ 'settings' ] == 'internal-issuance-medicines-settings' )
                    echo 'start active'; ?>">
                    <a href="javascript:void(0);">
                        <i class="fa fa-cog" aria-hidden="true"></i>
                        <span class="title"> Internal Issuance (Med) Settings </span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <?php if ( !empty( $access ) and in_array ( 'internal_issuance_par_levels', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'internal-issuance-medicines-par-levels' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/settings/internal-issuance-medicines-par-levels?settings=internal-issuance-medicines-settings' ) ?>">
                                    All Par Levels
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'add_internal_issuance_par_levels', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'add-internal-issuance-medicines-par-levels' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/settings/add-internal-issuance-medicines-par-levels?settings=internal-issuance-medicines-settings' ) ?>">
                                    Add Par Level
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
            
            <?php if ( !empty( $access ) and in_array ( 'internal-issuance-medicines-reporting', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $parent_uri == 'reporting' and $child_uri == 'internal-issuance-medicines-general-report' )
                    echo 'start active'; ?>">
                    <a href="javascript:void(0);">
                        <i class="fa fa-cog" aria-hidden="true"></i>
                        <span class="title"> Internal Issuance Reporting </span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <?php if ( !empty( $access ) and in_array ( 'internal-issuance-medicines-general-report', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'internal-issuance-medicines-general-report' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/reporting/internal-issuance-medicines-general-report?active=false' ) ?>">
                                    General Report
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
            
            <?php if ( !empty( $access ) and in_array ( 'pharmacy', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( ( $parent_uri == 'medicines' or $parent_uri == 'stock-return' ) and !isset( $_REQUEST[ 'active' ] ) )
                    echo 'start active'; ?>">
                    <a href="javascript:void(0);">
                        <i class="fa fa-medkit"></i>
                        <span class="title">
						Pharmacy
					</span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <?php if ( !empty( $access ) and in_array ( 'sale_medicine', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'sale' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/medicines/sale' ) ?>" oncontextmenu="return false;">
                                    Sale Medicine
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'sale_invoices', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'sales' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/medicines/sales' ) ?>">
                                    Sale Invoices
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'edit_medicine_sale', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'edit-sale' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/medicines/edit-sale' ) ?>">
                                    Edit Sale
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'return_customer_invoices', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'return-customer-invoices' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/medicines/return-customer-invoices' ) ?>">
                                    All Return Customer Invoices
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'return_customer', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'return-customer' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/medicines/return-customer' ) ?>">
                                    Add Return Customer
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'edit_return_customer', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'edit-return-customer' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/medicines/edit-return-customer' ) ?>">
                                    Edit Return Customer
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'local_purchases', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'local-purchases' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/medicines/local-purchases' ) ?>">
                                    All Local Purchase
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'add_local_purchases', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'local-purchase' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/medicines/local-purchase' ) ?>">
                                    Add Local Purchase
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'edit_local_purchases', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'edit-local-purchase' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/medicines/edit-local-purchase' ) ?>">
                                    Edit Local Purchase
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'medicines', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'index' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/medicines/index' ) ?>">
                                    All Medicines
                                    <span class="badge badge-roundless badge-important">
								<?php echo count_medicines (); ?>
							</span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'add_medicines_stock', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'add-medicines-stock' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/medicines/add-medicines-stock' ) ?>">
                                    Add Medicines Stock
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'edit_medicines_stock', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'return-stock' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/medicines/return-stock' ) ?>">
                                    Edit Medicine Stock
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'all_medicine_stock_returns', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'stock-returns' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/stock-return/stock-returns' ) ?>">
                                    All Returns (Supplier)
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'add_medicine_stock_returns', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'add-stock-returns' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/stock-return/add-stock-returns' ) ?>">
                                    Add Stock Return (Supplier)
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'ipd_requisitions', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'ipd-requisitions' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/medicines/ipd-requisitions' ) ?>">
                                    IPD Requisitions
                                    <span class="badge badge-roundless badge-important">
								<?php echo count_new_ipd_requisitions (); ?>
							</span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'adjustments', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'adjustments' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/medicines/adjustments' ) ?>">
                                    All Adjustments (Decrease)
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'add_adjustments', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'add-adjustments' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/medicines/add-adjustments' ) ?>">
                                    Add Adjustments (Decrease)
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'discarded_expired_medicines', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'discarded-expired-medicines' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/medicines/discarded-expired-medicines' ) ?>">
                                    Discarded Expired Medicines
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
            
            <?php if ( !empty( $access ) and in_array ( 'pharmacy_reporting', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $parent_uri == 'reporting' and !isset( $_REQUEST[ 'active' ] ) )
                    echo 'start active'; ?>">
                    <a href="javascript:void(0);">
                        <i class="fa fa-search"></i>
                        <span class="title"> Pharmacy Reporting </span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <?php if ( !empty( $access ) and in_array ( 'general_report_ipd_medication', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'general-report-ipd-medication' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/reporting/general-report-ipd-medication' ) ?>">
                                    General Report (IPD Med)
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'sales_general_report', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'general-report' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/reporting/general-report' ) ?>">
                                    General Report (Sales)
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'returns_general_report', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'general-report-customer-return' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/reporting/general-report-customer-return' ) ?>">
                                    General Report (Return)
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'sale_report_against_supplier', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'sale-report-against-supplier' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/reporting/sale-report-against-supplier' ) ?>">
                                    Sale Report Against Supplier
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'stock_valuation_report_tp_wise', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'stock-valuation-report' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/reporting/stock-valuation-report' ) ?>">
                                    Stock Valuation Report (TP Wise)
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'stock_valuation_report_sale_wise', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'stock-valuation-report-sale-price' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/reporting/stock-valuation-report-sale-price' ) ?>">
                                    Stock Valuation Report (Sale Price Wise)
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'threshold_report', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'threshold-report' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/reporting/threshold-report' ) ?>">
                                    Threshold Report
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'expired_medicine_report', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'expired-medicine-report' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/reporting/expired-medicine-report' ) ?>">
                                    Expired Medicine Report
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'profit_report', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'profit-report' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/reporting/profit-report' ) ?>">
                                    Profit Report
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'profit_report_ipd_medication', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'profit-report-ipd-medication' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/reporting/profit-report-ipd-medication' ) ?>">
                                    Profit Report (IPD Med)
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'detailed_stock_report', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'detailed-stock-report' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/reporting/detailed-stock-report' ) ?>">
                                    Detailed Stock Report
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'bonus_stock_report', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'bonus-stock-report' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/reporting/bonus-stock-report' ) ?>">
                                    Bonus Stock Report
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'form_wise_report', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'form-wise-report' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/reporting/form-wise-report' ) ?>">
                                    Form Wise Report
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'supplier_wise_report', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'supplier-wise-report' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/reporting/supplier-wise-report' ) ?>">
                                    Supplier Wise Report
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'analysis_report', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'analysis-report' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/reporting/analysis-report' ) ?>">
                                    Analysis Report (Purchase)
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'analysis_report_sale', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'analysis-report-sale' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/reporting/analysis-report-sale' ) ?>">
                                    Analysis Report (Sale)
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'analysis_report_ipd_sale', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'analysis-report-ipd-sale' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/reporting/analysis-report-ipd-sale' ) ?>">
                                    Analysis Report (IPD Sale)
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'summary_report', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'summary-report' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/reporting/summary-report' ) ?>">
                                    Summary Report
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
            
            <?php if ( !empty( $access ) and in_array ( 'pharmacy_settings', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( ( $parent_uri == 'settings' and @$_REQUEST[ 'settings' ] == 'pharmacy' ) or ( $parent_uri == 'medicines' and @$_REQUEST[ 'settings' ] == 'pharmacy' ) )
                    echo 'start active'; ?>">
                    <a href="javascript:void(0);">
                        <i class="fa fa-cog"></i>
                        <span class="title"> Pharmacy Settings </span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <?php if ( !empty( $access ) and in_array ( 'add_medicines', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'add' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/medicines/add?active=false&settings=pharmacy' ) ?>">
                                    Add Medicines
                                </a>
                            </li>
                        <?php endif; ?>
                        <hr style="margin: 0 auto;border-bottom: 0;width: 100%;border-top: 1px solid #5c5c5c;">
                        <?php if ( !empty( $access ) and in_array ( 'generics', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'generic' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/settings/generic?settings=pharmacy' ) ?>">
                                    Generics
                                </a>
                            </li>
                        <?php endif; ?>
                        <hr style="margin: 0 auto;border-bottom: 0;width: 100%;border-top: 1px solid #5c5c5c;">
                        <?php if ( !empty( $access ) and in_array ( 'add_generics', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'add-generic' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/settings/add-generic?settings=pharmacy' ) ?>">
                                    Add Generic
                                </a>
                            </li>
                        <?php endif; ?>
                        <hr style="margin: 0 auto;border-bottom: 0;width: 100%;border-top: 1px solid #5c5c5c;">
                        <?php if ( !empty( $access ) and in_array ( 'strength', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'strength' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/settings/strength?settings=pharmacy' ) ?>">
                                    Strength
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'add_strength', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'add-strength' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/settings/add-strength?settings=pharmacy' ) ?>">
                                    Add Strength
                                </a>
                            </li>
                        <?php endif; ?>
                        <hr style="margin: 0 auto;border-bottom: 0;width: 100%;border-top: 1px solid #5c5c5c;">
                        <?php if ( !empty( $access ) and in_array ( 'forms', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'form' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/settings/forms?settings=pharmacy' ) ?>">
                                    Forms
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'add_forms', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'add-form' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/settings/add-form?settings=pharmacy' ) ?>">
                                    Add Form
                                </a>
                            </li>
                        <?php endif; ?>
                        <hr style="margin: 0 auto;border-bottom: 0;width: 100%;border-top: 1px solid #5c5c5c;">
                        <?php if ( !empty( $access ) and in_array ( 'manufacturers', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'manufacturers' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/settings/manufacturers?settings=pharmacy' ) ?>">
                                    Manufacturers
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'add_manufacturers', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'add-manufacturers' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/settings/add-manufacturers?settings=pharmacy' ) ?>">
                                    Add Manufacturer
                                </a>
                            </li>
                        <?php endif; ?>
                        <hr style="margin: 0 auto;border-bottom: 0;width: 100%;border-top: 1px solid #5c5c5c;">
                        <?php if ( !empty( $access ) and in_array ( 'pack_size', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'pack-sizes' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/settings/pack-sizes?settings=pharmacy' ) ?>">
                                    Pack Sizes
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'add_pack_size', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'add-pack-size' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/settings/add-pack-size?settings=pharmacy' ) ?>">
                                    Add Pack Size
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
            
            <?php if ( !empty( $access ) and in_array ( 'lab', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $parent_uri == 'lab' or $parent_uri == 'reporting' )
                    echo 'start active'; ?>">
                    <a href="javascript:void(0);">
                        <i class="fa fa-flask"></i>
                        <span class="title"> Lab </span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <?php if ( !empty( $access ) and in_array ( 'sale_test', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'sale' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/lab/sale' ) ?>">
                                    Sale Test (General)
                                </a>
                            </li>
                        <?php endif; ?>
                        
                        <?php if ( !empty( $access ) and in_array ( 'sale_test_package', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'sale-package' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/lab/sale-package' ) ?>">
                                    Sale Test (Package)
                                </a>
                            </li>
                        <?php endif; ?>
                        
                        <?php if ( !empty( $access ) and in_array ( 'sale_invoices_cash', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'sales' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/lab/sales' ) ?>">
                                    Sale Invoices (Cash)
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'sale_invoices_panel', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'sales-panel' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/lab/sales-panel' ) ?>">
                                    Sale Invoices (Panel)
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'lab-cash-balance-report', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'lab-cash-balance-report' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/reporting/lab-cash-balance-report' ) ?>">
                                    Sale Invoices (Cash-Balance)
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'lab_sale_pending_results', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'sale-pending-results' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/lab/sale-pending-results' ) ?>">
                                    Pending Results
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'lab_all_added_test_results', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'all-added-test-results' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/lab/all-added-test-results' ) ?>">
                                    All Added Test Results
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'edit_lab_sale', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'search-sale' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/lab/search-sale' ) ?>">
                                    Edit Sale
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'all_lab_tests', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'index' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/lab/index' ) ?>">
                                    All Tests
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'add_lab_tests', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'add' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/lab/add' ) ?>">
                                    Add Lab Test
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'lab_test_protocols', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'add' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/lab/protocols' ) ?>">
                                    Test Protocols
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'add_test_results', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'add-result' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/lab/add-result' ) ?>">
                                    Add Result
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'add_ipd_test_results', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'add-ipd-test-result' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/lab/add-ipd-test-result' ) ?>">
                                    Add Result (IPD)
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'calibrations', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'calibrations' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/lab/calibrations' ) ?>">
                                    All Calibrations
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'add_calibrations', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'add-calibrations' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/lab/add-calibrations' ) ?>">
                                    Add Calibrations
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'all-refer-outside', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'all-refer-outside' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/lab/all-refer-outside' ) ?>">
                                    All Refer Outside
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'add-refer-outside', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'add-refer-outside' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/lab/add-refer-outside' ) ?>">
                                    Add Refer Outside
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
            
            <?php if ( !empty( $access ) and in_array ( 'lab_reporting', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $parent_uri == 'lab-reporting' )
                    echo 'start active'; ?>">
                    <a href="javascript:void(0);">
                        <i class="fa fa-search"></i>
                        <span class="title"> Lab Reporting </span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <?php if ( !empty( $access ) and in_array ( 'lab_general_reporting', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'lab-general-report' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/reporting/lab-general-report' ) ?>">
                                    General Report
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'lab_general_reporting_ipd', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'lab-general-report-ipd' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/reporting/lab-general-report-ipd' ) ?>">
                                    General Report (IPD)
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'regents_consumption_report', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'regents-consumption-report' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/reporting/regents-consumption-report' ) ?>">
                                    Regents Consumption Report (Cash)
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'regents_consumption_report_ipd', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'regents-consumption-report-ipd' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/reporting/regents-consumption-report-ipd' ) ?>">
                                    Regents Consumption Report (IPD)
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'test_prices_report', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'test-prices-report' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/reporting/test-prices-report/?menu=lab' ) ?>">
                                    Test Prices Report
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
            
            <?php if ( !empty( $access ) and in_array ( 'lab_settings', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $parent_uri == 'settings' and @$_REQUEST[ 'settings' ] == 'lab' )
                    echo 'start active'; ?>">
                    <a href="javascript:void(0);">
                        <i class="fa fa-cog"></i>
                        <span class="title"> Lab Settings </span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <?php if ( !empty( $access ) and in_array ( 'locations', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'locations' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/settings/locations?settings=lab' ) ?>">
                                    All Locations
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'add_locations', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'add-location' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/settings/add-location?settings=lab' ) ?>">
                                    Add Location
                                </a>
                            </li>
                        <?php endif; ?>
                        <hr style="margin: 0 auto;border-bottom: 0;width: 100%;border-top: 1px solid #5c5c5c;">
                        <?php if ( !empty( $access ) and in_array ( 'units', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'units' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/settings/units?settings=lab' ) ?>">
                                    All Units
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'add_units', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'add-unit' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/settings/add-unit?settings=lab' ) ?>">
                                    Add Units
                                </a>
                            </li>
                        <?php endif; ?>
                        <hr style="margin: 0 auto;border-bottom: 0;width: 100%;border-top: 1px solid #5c5c5c;">
                        <?php if ( !empty( $access ) and in_array ( 'sections', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'sections' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/settings/sections?settings=lab' ) ?>">
                                    All Sections
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'add_sections', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'add-section' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/settings/add-section?settings=lab' ) ?>">
                                    Add Sections
                                </a>
                            </li>
                        <?php endif; ?>
                        <hr style="margin: 0 auto;border-bottom: 0;width: 100%;border-top: 1px solid #5c5c5c;">
                        <?php if ( !empty( $access ) and in_array ( 'test_tube_colors', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'test-tube-colors' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/settings/test-tube-colors?settings=lab' ) ?>">
                                    All Test Tube Colors
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'add_test_tube_colors', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'add-test-tube-colors' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/settings/add-test-tube-colors?settings=lab' ) ?>">
                                    Add Test Tube Colors
                                </a>
                            </li>
                        <?php endif; ?>
                        <hr style="margin: 0 auto;border-bottom: 0;width: 100%;border-top: 1px solid #5c5c5c;">
                        <?php if ( !empty( $access ) and in_array ( 'samples', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'samples' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/settings/samples?settings=lab' ) ?>">
                                    All Samples
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'add_samples', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'add-sample' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/settings/add-sample?settings=lab' ) ?>">
                                    Add Samples
                                </a>
                            </li>
                        <?php endif; ?>
                        <hr style="margin: 0 auto;border-bottom: 0;width: 100%;border-top: 1px solid #5c5c5c;">
                        <?php if ( !empty( $access ) and in_array ( 'specimen', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'specimen' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/settings/specimen?settings=lab' ) ?>">
                                    All Specimen
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'add_specimen', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'add-specimen' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/settings/add-specimen?settings=lab' ) ?>">
                                    Add Specimen
                                </a>
                            </li>
                        <?php endif; ?>
                        <hr style="margin: 0 auto;border-bottom: 0;width: 100%;border-top: 1px solid #5c5c5c;">
                        <?php if ( !empty( $access ) and in_array ( 'remarks', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'remarks' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/settings/remarks?settings=lab' ) ?>">
                                    All Remarks
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'add_remarks', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'add-remarks' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/settings/add-remarks?settings=lab' ) ?>">
                                    Add Remarks
                                </a>
                            </li>
                        <?php endif; ?>
                        <hr style="margin: 0 auto;border-bottom: 0;width: 100%;border-top: 1px solid #5c5c5c;">
                        <?php if ( !empty( $access ) and in_array ( 'airlines', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'airlines' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/settings/airlines?settings=lab' ) ?>">
                                    All Airlines
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'add-airlines', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'add-airlines' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/settings/add-airlines?settings=lab' ) ?>">
                                    Add Airlines
                                </a>
                            </li>
                        <?php endif; ?>
                        <hr style="margin: 0 auto;border-bottom: 0;width: 100%;border-top: 1px solid #5c5c5c;">
                        <?php if ( !empty( $access ) and in_array ( 'packages', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'packages' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/settings/packages?settings=lab' ) ?>">
                                    All Packages
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'add-packages', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'add-packages' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/settings/add-packages?settings=lab' ) ?>">
                                    Add Packages
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
            
            <?php if ( !empty( $access ) and in_array ( 'culture-histopathology', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $parent_uri == 'culture' or $parent_uri == 'histopathology' )
                    echo 'start active'; ?>">
                    <a href="javascript:void(0);">
                        <i class="fas fa-x-ray"></i>
                        <span class="title"> Culture / Histopathology </span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <?php if ( !empty( $access ) and in_array ( 'culture', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'culture' )
                                echo 'start active'; ?>">
                                <a href="javascript:void(0);" style="<?php if ( $child_uri == 'x-ray' )
                                    echo 'background: #e02222 !important;'; ?>">
                                    <i class="fas fa-fingerprint"></i>
                                    <span class="title"> Culture </span>
                                    <span class="arrow "></span>
                                </a>
                                <ul class="sub-menu">
                                    <?php if ( !empty( $access ) and in_array ( 'add-culture-report', explode ( ',', $access -> access ) ) ) : ?>
                                        <li class="<?php if ( $sub_child_uri == 'add' )
                                            echo 'active'; ?>">
                                            <a href="<?php echo base_url ( 'culture/culture/add' ) ?>">
                                                Add Report
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if ( !empty( $access ) and in_array ( 'search-culture-report', explode ( ',', $access -> access ) ) ) : ?>
                                        <li class="<?php if ( $sub_child_uri == 'search' )
                                            echo 'active'; ?>">
                                            <a href="<?php echo base_url ( 'culture/culture/search' ) ?>">
                                                Search Report
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if ( !empty( $access ) and in_array ( 'culture-reports', explode ( ',', $access -> access ) ) ) : ?>
                                        <li class="<?php if ( $sub_child_uri == 'reports' )
                                            echo 'active'; ?>">
                                            <a href="<?php echo base_url ( 'culture/culture/reports' ) ?>">
                                                All Reports
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'histopathology', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'histopathology' )
                                echo 'active'; ?>">
                                <a href="javascript:void(0);" style="<?php if ( $child_uri == 'ultrasound' )
                                    echo 'background: #e02222 !important;'; ?>">
                                    <i class="fas fa-syringe"></i>
                                    <span class="title"> Histopathology </span>
                                    <span class="arrow "></span>
                                </a>
                                <ul class="sub-menu">
                                    <?php if ( !empty( $access ) and in_array ( 'add-histopathology-report', explode ( ',', $access -> access ) ) ) : ?>
                                        <li class="<?php if ( $sub_child_uri == 'add' )
                                            echo 'active'; ?>">
                                            <a href="<?php echo base_url ( 'histopathology/histopathology/add' ) ?>">
                                                Add Report
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if ( !empty( $access ) and in_array ( 'search-histopathology-report', explode ( ',', $access -> access ) ) ) : ?>
                                        <li class="<?php if ( $sub_child_uri == 'search' )
                                            echo 'active'; ?>">
                                            <a href="<?php echo base_url ( 'histopathology/histopathology/search' ) ?>">
                                                Search Report
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if ( !empty( $access ) and in_array ( 'histopathology-reports', explode ( ',', $access -> access ) ) ) : ?>
                                        <li class="<?php if ( $sub_child_uri == 'reports' )
                                            echo 'active'; ?>">
                                            <a href="<?php echo base_url ( 'histopathology/histopathology/reports' ) ?>">
                                                All Reports
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
            
            <?php if ( !empty( $access ) and in_array ( 'culture-histopathology-reporting', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $parent_uri == 'ChReport' )
                    echo 'start active'; ?>">
                    <a href="javascript:void(0);">
                        <i class="fa fa-search"></i>
                        <span class="title"> Culture / Histopathology Reporting </span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <?php if ( !empty( $access ) and in_array ( 'culture-general-reporting', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'general-report-culture' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/ChReport/general-report-culture' ) ?>">
                                    General Report (Culture)
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'histopathology-general-reporting', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'general-report-histopathology' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/ChReport/general-report-histopathology' ) ?>">
                                    General Report (Histopathology)
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
            
            <?php if ( !empty( $access ) and in_array ( 'culture-histopathology-settings', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $parent_uri == 'templates' and @$_GET[ 'menu' ] == 'cs-settings' )
                    echo 'start active'; ?>">
                    <a href="javascript:void(0);">
                        <i class="fa fa-cog"></i>
                        <span class="title"> Culture / Histopathology Settings </span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <?php if ( !empty( $access ) and in_array ( 'culture-templates', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'culture-templates' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/templates/culture-templates/?menu=cs-settings' ) ?>">
                                    All Templates (Culture)
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'add-culture-templates', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'add-culture-templates' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/templates/add-culture-templates/?menu=cs-settings' ) ?>">
                                    Add Templates (Culture)
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'templates-histopathology', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'histopathology-templates' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/templates/histopathology-templates/?menu=cs-settings' ) ?>">
                                    All Templates (Histopathology)
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'add-templates-histopathology', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'add-histopathology-templates' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/templates/add-histopathology-templates/?menu=cs-settings' ) ?>">
                                    Add Templates (Histopathology)
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'antibiotic-susceptibility', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'antibiotic-susceptibility' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/templates/antibiotic-susceptibility/?menu=cs-settings' ) ?>">
                                    All Antibiotic (Susceptibility)
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'add-antibiotic-susceptibility', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'add-antibiotic-susceptibility' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/templates/add-antibiotic-susceptibility/?menu=cs-settings' ) ?>">
                                    Add Antibiotic (Susceptibility)
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
            
            <?php if ( !empty( $access ) and in_array ( 'medical-tests', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $parent_uri == 'medical-tests' )
                    echo 'start active'; ?>">
                    <a href="javascript:void(0);">
                        <i class="fas fa-file-medical-alt"></i>
                        <span class="title"> Medical Tests </span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <?php if ( !empty( $access ) and in_array ( 'all-medical-tests', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'companies' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/medical-tests/index' ) ?>">
                                    All Medical Tests
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'add-medical-tests', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'add-companies' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/medical-tests/add' ) ?>">
                                    Add Medical Tests
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'medical-test-report', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'medical-test-report' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/medical-tests/report' ) ?>">
                                    Report
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>





            
            <?php if ( !empty( $access ) and in_array ( 'medical-test-settings', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $parent_uri == 'medical-test-settings' )
                    echo 'start active'; ?>">
                    <a href="javascript:void(0);">
                        <i class="fa fa-cog"></i>
                        <span class="title"> Medical test Settings </span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <?php if ( !empty( $access ) and in_array ( 'all-oep', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'oep' && $sub_child_uri == 'index' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/medical-test-settings/oep/index' ) ?>">
                                    All OEP
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'add-oep', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'oep' && $sub_child_uri == 'create' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/medical-test-settings/oep/create' ) ?>">
                                    Add OEP
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>




            <?php if ( !empty( $access ) and in_array ( 'medical-test-settings', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $parent_uri == 'medical-test-settings' )
                    echo 'start active'; ?>">
                    <a href="javascript:void(0);">
                        <i class="fa fa-cog"></i>
                        <span class="title"> Medical test Settings </span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">

                    <?php if ( !empty( $access ) and in_array ( 'all-oep', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'oep' && $sub_child_uri == 'index' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( 'medical-test/all/templates' ) ?>">
                                    All Templates
                                </a>
                            </li>
                        <?php endif; ?>
                      
                        <?php if ( !empty( $access ) and in_array ( 'add-oep', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'oep' && $sub_child_uri == 'create' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( 'medical-test/template/add' ) ?>">
                                    Add Template
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>



            
            <?php if ( !empty( $access ) and in_array ( 'general_settings', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $parent_uri == 'settings' and @$_REQUEST[ 'settings' ] == 'general' )
                    echo 'start active'; ?>">
                    <a href="javascript:void(0);">
                        <i class="fa fa-cog"></i>
                        <span class="title"> General Settings </span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <?php if ( !empty( $access ) and in_array ( 'companies', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'companies' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/settings/companies?settings=general' ) ?>">
                                    Companies
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'add_companies', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'add-companies' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/settings/add-companies?settings=general' ) ?>">
                                    Add Company
                                </a>
                            </li>
                        <?php endif; ?>
                        <hr style="margin: 0 auto;border-bottom: 0;width: 100%;border-top: 1px solid #5c5c5c;">
                        <?php if ( !empty( $access ) and in_array ( 'panels', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'panels' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/settings/panels?settings=general' ) ?>">
                                    Panels
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'add_panels', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'add-panel' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/settings/add-panel?settings=general' ) ?>">
                                    Add Panel
                                </a>
                            </li>
                        <?php endif; ?>
                        <hr style="margin: 0 auto;border-bottom: 0;width: 100%;border-top: 1px solid #5c5c5c;">
                        <?php if ( !empty( $access ) and in_array ( 'member_types', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'members' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/settings/members?settings=general' ) ?>">
                                    Member Types
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'add_member_types', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'add-members' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/settings/add-members?settings=general' ) ?>">
                                    Add Member Type
                                </a>
                            </li>
                        <?php endif; ?>
                        <hr style="margin: 0 auto;border-bottom: 0;width: 100%;border-top: 1px solid #5c5c5c;">
                        <?php if ( !empty( $access ) and in_array ( 'cities', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'cities' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/settings/cities?settings=general' ) ?>">
                                    All Cities
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'add_city', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'add-city' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/settings/add-city?settings=general' ) ?>">
                                    Add City
                                </a>
                            </li>
                        <?php endif; ?>
                        <hr style="margin: 0 auto;border-bottom: 0;width: 100%;border-top: 1px solid #5c5c5c;">
                        <?php if ( !empty( $access ) and in_array ( 'references', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'references' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/settings/references?settings=general' ) ?>">
                                    All References
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'add-references', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'add-references' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/settings/add-references?settings=general' ) ?>">
                                    Add References
                                </a>
                            </li>
                        <?php endif; ?>
                        <hr style="margin: 0 auto;border-bottom: 0;width: 100%;border-top: 1px solid #5c5c5c;">
                        <?php if ( !empty( $access ) and in_array ( 'site_settings', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'site-settings' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/settings/site-settings?settings=general' ) ?>">
                                    Site Settings
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
            
            <?php if ( !empty( $access ) and in_array ( 'general_reporting', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $parent_uri == 'general-reporting' )
                    echo 'start active'; ?>">
                    <a href="javascript:void(0);">
                        <i class="fa fa-search"></i>
                        <span class="title"> General Reporting </span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <?php if ( !empty( $access ) and in_array ( 'general_summary_report', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'general-summary-report' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/general-reporting/general-summary-report' ) ?>">
                                    Summary Report
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
            
            <?php if ( !empty( $access ) and in_array ( 'accounts', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $parent_uri == 'accounts' )
                    echo 'start active'; ?>">
                    <a href="javascript:void(0);">
                        <i class="fa fa-briefcase"></i>
                        <span class="title"> Accounts </span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <?php if ( !empty( $access ) and in_array ( 'chart_of_accounts', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'chart-of-accounts' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/accounts/chart-of-accounts' ) ?>">
                                    Chart of Accounts
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'add_account_head', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'add-account-head' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/accounts/add-account-head' ) ?>">
                                    Add Account Head
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'add_transactions', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'add-transactions' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/accounts/add-transactions' ) ?>">
                                    Add Transactions
                                </a>
                            </li>
                            <?php /*<li class="<?php if($child_uri == 'opening-balances') echo 'active'; ?>">
                        <a href="<?php echo base_url('/accounts/opening-balances') ?>">
                            Opening Balances
                        </a>
                    </li>*/ ?>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'add_transactions_multiple', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'add-transactions-multiple' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/accounts/add-transactions-multiple' ) ?>">
                                    Add Transactions (Multiple)
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'add_opening_balance', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'add-opening-balance' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/accounts/add-opening-balance' ) ?>">
                                    Add Opening Balances
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'general_ledger', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'general-ledger' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/accounts/general-ledger' ) ?>">
                                    General Ledger
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'search_transactions', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'search-transaction' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/accounts/search-transaction' ) ?>">
                                    Search Transaction
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'supplier_invoices', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'supplier-invoices' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/accounts/supplier-invoices' ) ?>">
                                    Supplier Invoices
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'trial_balance_sheet', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'trial-balance' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/accounts/trial-balance' ) ?>">
                                    Trial Balance Sheet
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'balance_sheet', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'balance-sheet' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/accounts/balance-sheet' ) ?>">
                                    Balance Sheet
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'profit_loss_statement', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'profit-loss-statement' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/accounts/profit-loss-statement' ) ?>">
                                    Profit and Loss Statement
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
            
            <?php if ( !empty( $access ) and in_array ( 'account_settings', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $parent_uri == 'account-settings' )
                    echo 'start active'; ?>">
                    <a href="javascript:void(0);">
                        <i class="fa fa-cog"></i>
                        <span class="title"> Account Settings </span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <?php if ( !empty( $access ) and in_array ( 'all_roles', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'index' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/account-settings/index' ) ?>">
                                    All Roles
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'add_roles', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'add' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/account-settings/add' ) ?>">
                                    Add Roles
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'financial_year', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'add' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/account-settings/financial-year' ) ?>">
                                    Financial Year
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
            
            <?php if ( !empty( $access ) and in_array ( 'purchase_orders', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $parent_uri == 'purchase-order' )
                    echo 'start active'; ?>">
                    <a href="javascript:void(0);">
                        <i class="fa fa-shopping-cart"></i>
                        <span class="title"> Purchase Orders </span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <?php if ( !empty( $access ) and in_array ( 'all_purchase_orders', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'index' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/purchase-order/index' ) ?>">
                                    All Purchase Orders
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'add_purchase_orders', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'add' and isset( $_GET[ 'supplier-list' ] ) and $_GET[ 'supplier-list' ] == 'false' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/purchase-order/add/?supplier-list=false' ) ?>">
                                    Add Purchase Orders
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'add_purchase_orders', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'add' and isset( $_GET[ 'supplier-list' ] ) and $_GET[ 'supplier-list' ] == 'true' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/purchase-order/add/?supplier-list=true' ) ?>">
                                    Add Purchase Orders (Supplier Wise)
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
            
            <?php if ( !empty( $access ) and in_array ( 'store', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $parent_uri == 'store' )
                    echo 'start active'; ?>">
                    <a href="javascript:void(0);">
                        <i class="fa fa-shopping-cart"></i>
                        <span class="title"> Store </span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <?php if ( !empty( $access ) and in_array ( 'issue_items', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'sale' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/store/sale' ) ?>">
                                    Issue Item
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'sold_items', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'sales' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/store/sales' ) ?>">
                                    All Issued Items
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'edit_issue_items', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'search' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/store/search' ) ?>">
                                    Edit Issued Items
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'all_issued_items', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'index' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/store/index' ) ?>">
                                    All Items
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'add_store_items', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'add' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/store/add' ) ?>">
                                    Add Item
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'add_store_stock', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'add-stock' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/store/add-stock' ) ?>">
                                    Add Stock
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'all_store_stock', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'store-stock' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/store/store-stock' ) ?>">
                                    All Stock
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'edit_store_stock', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'edit-stock' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/store/edit-stock' ) ?>">
                                    Edit Stock
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'requisition_store', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'requests' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/store/requests' ) ?>">
                                    Requisition (Store)
                                    <span class="badge badge-roundless badge-important"><?php echo count_store_requisition_requests () ?></span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'requisition_others', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'demands' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/store/demands' ) ?>">
                                    Requisitions (Others)
                                    <span class="badge badge-roundless badge-important"><?php echo count_requisition_demands_store () ?></span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'store_fix_assets', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'store-fix-assets' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/store/store-fix-assets' ) ?>">
                                    All Store (Fix Assets)
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'add_store_fix_assets', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'add-store-fix-assets' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/store/add-store-fix-assets' ) ?>">
                                    Add Store (Fix Assets)
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
            
            <?php if ( !empty( $access ) and in_array ( 'store-reporting', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $parent_uri == 'StoreReporting' )
                    echo 'start active'; ?>">
                    <a href="javascript:void(0);">
                        <i class="fa fa-search"></i>
                        <span class="title"> Store Reporting </span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <?php if ( !empty( $access ) and in_array ( 'store-stock-valuation-report', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'stock-valuation' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/StoreReporting/stock-valuation' ) ?>">
                                    Stock Valuation Report
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'store_general_report', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'general-report' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/StoreReporting/general-report' ) ?>">
                                    Issuance Report
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'store-threshold-report', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'threshold-report' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/StoreReporting/threshold-report' ) ?>">
                                    Threshold Report
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'store-purchase-report', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'purchase-report' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/StoreReporting/purchase-report' ) ?>">
                                    Purchase Report
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
            
            <?php if ( !empty( $access ) and in_array ( 'store-settings', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $parent_uri == 'settings' and @$_REQUEST[ 'settings' ] == 'store-settings' )
                    echo 'start active'; ?>">
                    <a href="javascript:void(0);">
                        <i class="fa fa-cog" aria-hidden="true"></i>
                        <span class="title"> Store Settings </span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <?php if ( !empty( $access ) and in_array ( 'store_par_levels', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'par-levels' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/settings/par-levels?settings=store-settings' ) ?>">
                                    All Par Levels
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'add_store_par_levels', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'add-par-levels' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/settings/add-par-levels?settings=store-settings' ) ?>">
                                    Add Par Level
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
            
            <?php if ( !empty( $access ) and in_array ( 'facility-manager', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $parent_uri == 'FacilityManager' )
                    echo 'start active'; ?>">
                    <a href="javascript:void(0);">
                        <i class="fa fa-male"></i>
                        <span class="title"> Facility Manager </span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <?php if ( !empty( $access ) and in_array ( 'facility_manager_store_requisition', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'requests' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/FacilityManager/requests' ) ?>">
                                    Requisitions (Store)
                                    <span class="badge badge-roundless badge-important"><?php echo count_requests_facility_manager () ?></span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'facility_manager_other_requisition', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'demands' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/FacilityManager/demands' ) ?>">
                                    Requisitions (Others)
                                    <span class="badge badge-roundless badge-important"><?php echo count_requisition_demands () ?></span>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
            
            <?php if ( !empty( $access ) and in_array ( 'requisition', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $parent_uri == 'requisition' )
                    echo 'start active'; ?>">
                    <a href="javascript:void(0);">
                        <i class="fa fa-first-order" aria-hidden="true"></i>
                        <span class="title"> Requisitions </span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <?php if ( !empty( $access ) and in_array ( 'all_requisitions', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'index' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/requisition/index' ) ?>">
                                    All Requisitions
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'add_store_requisitions', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'add' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/requisition/add' ) ?>">
                                    Add Requisitions (Store)
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'add_other_requisitions', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'demands' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/requisition/demands' ) ?>">
                                    Add Requisitions (Other)
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
            
            <?php if ( !empty( $access ) and in_array ( 'hr', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $parent_uri == 'hr' )
                    echo 'start active'; ?>">
                    <a href="javascript:void(0);">
                        <i class="fa fa-user-plus"></i>
                        <span class="title"> HR </span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <?php if ( !empty( $access ) and in_array ( 'hr_members', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'index' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/hr/index' ) ?>">
                                    All Employees
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'add_hr_members', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'add' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/hr/add' ) ?>">
                                    Add Employee
                                </a>
                            </li>
                        <?php endif; ?>
                        <hr style="margin: 0 auto;border-bottom: 0;width: 100%;border-top: 1px solid #5c5c5c;">
                        <?php if ( !empty( $access ) and in_array ( 'all_salary_sheets', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'sheets' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/hr/sheets' ) ?>">
                                    All Salary Sheets
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'salary_sheet', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'sheet' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/hr/sheet' ) ?>">
                                    Add Salary Sheet
                                </a>
                            </li>
                        <?php endif; ?>
                        <hr style="margin: 0 auto;border-bottom: 0;width: 100%;border-top: 1px solid #5c5c5c;">
                        <?php if ( !empty( $access ) and in_array ( 'search_salary_sheet', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'search' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/hr/search' ) ?>">
                                    Search Salary Sheet
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
            
            <?php if ( !empty( $access ) and in_array ( 'loan', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $parent_uri == 'loan' )
                    echo 'start active'; ?>">
                    <a href="javascript:void(0);">
                        <i class="fa fa-money" aria-hidden="true"></i>
                        <span class="title"> Loans </span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <?php if ( !empty( $access ) and in_array ( 'all_loans', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'index' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/loan/index' ) ?>">
                                    All Loans
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'add_loan', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'add' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/loan/add' ) ?>">
                                    Add Loan
                                </a>
                            </li>
                        <?php endif; ?>
                        <hr style="margin: 0 auto;border-bottom: 0;width: 100%;border-top: 1px solid #5c5c5c;">
                        <?php if ( !empty( $access ) and in_array ( 'paid_loans', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'paid' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/loan/paid' ) ?>">
                                    All Paid Loans
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'pay_loan', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'pay' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/loan/pay' ) ?>">
                                    Pay Loan
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
            
            <?php if ( !empty( $access ) and in_array ( 'complains', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $parent_uri == 'complaints' )
                    echo 'start active'; ?>">
                    <a href="javascript:void(0);">
                        <i class="fa fa-bug"></i>
                        <span class="title"> Complaints </span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <?php if ( !empty( $access ) and in_array ( 'all_complains', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'index' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/complaints/index' ) ?>">
                                    All Complaints
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'add_complains', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'add' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/complaints/add' ) ?>">
                                    Add Complaints
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
            
            <?php if ( !empty( $access ) and in_array ( 'members', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $parent_uri == 'user' )
                    echo 'start active'; ?>">
                    <a href="javascript:void(0);">
                        <i class="fa fa-users"></i>
                        <span class="title"> Members </span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <li class="<?php if ( $child_uri == 'all_members' )
                            echo 'active'; ?>">
                            <a href="<?php echo base_url ( '/user/index' ) ?>">
                                All Members
                            </a>
                        </li>
                        <li class="<?php if ( $child_uri == 'add_members' )
                            echo 'active'; ?>">
                            <a href="<?php echo base_url ( '/user/add' ) ?>">
                                Add Member
                            </a>
                        </li>
                    </ul>
                </li>
            <?php endif; ?>
            
            <?php if ( !empty( $access ) and in_array ( 'member-settings', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $parent_uri == 'settings' and @$_REQUEST[ 'settings' ] == 'member-settings' )
                    echo 'start active'; ?>">
                    <a href="javascript:void(0);">
                        <i class="fa fa-cog" aria-hidden="true"></i>
                        <span class="title"> Department Settings </span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <?php if ( !empty( $access ) and in_array ( 'all_departments', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'departments' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/settings/departments?settings=member-settings' ) ?>">
                                    All Departments
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'add_departments', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'add-departments' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/settings/add-departments?settings=member-settings' ) ?>">
                                    Add Departments
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
            
            <?php if ( !empty( $access ) and in_array ( 'birth-certificates', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $parent_uri == 'birth-certificates' )
                    echo 'start active'; ?>">
                    <a href="javascript:void(0);">
                        <i class="fa fa-address-card"></i>
                        <span class="title"> Birth Certificates </span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <?php if ( !empty( $access ) and in_array ( 'all-birth-certificates', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'index' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/birth-certificates/index' ) ?>">
                                    All Certificates
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'add-birth-certificates', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $child_uri == 'add' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( '/birth-certificates/add' ) ?>">
                                    Add Certificates
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
        </ul>
        <!-- END SIDEBAR MENU -->
    </div>
</div>
<!-- END SIDEBAR -->
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                <h3 class="page-title">
                    <?php echo ucwords ( str_replace ( '-', ' ', $this -> uri -> segment ( 1 ) ) ) ?>
                    <small><?php echo site_name ?></small>
                </h3>
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo base_url ( '/dashboard' ) ?>">Dashboard</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <?php echo str_replace ( '-', ' ', ucwords ( $this -> uri -> segment ( 1 ) ) ) ?>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <?php echo str_replace ( '-', ' ', ucwords ( $this -> uri -> segment ( 2 ) ) ) ?>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <?php echo str_replace ( '-', ' ', ucwords ( $this -> uri -> segment ( 3 ) ) ) ?>
                    </li>
                </ul>
                <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
        </div>
        <!-- END PAGE HEADER-->

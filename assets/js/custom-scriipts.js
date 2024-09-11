$ ( "#lab-tests-sale" ).select2 ( {
    closeOnSelect: false,
} );

function get_patient_and_load_tests ( patient_id ) {
    var csrf_token = jQuery ( '#csrf_token' ).val ();
    request = jQuery.ajax ( {
        url: path + 'Medicines/get_patient',
        type: 'POST',
        data: {
            hmis_token: csrf_token,
            patient_id: patient_id
        },
        beforeSend: function () {
            jQuery ( '.loader' ).show ();
        },
        success: function ( response ) {
            if ( response != 'false' ) {
                var obj = JSON.parse ( response );
                jQuery ( '#patient-name' ).val ( obj.name );
                jQuery ( '#patient-cnic' ).val ( obj.cnic );
                jQuery ( '#sex' ).val ( obj.gender );
                jQuery ( '#admission_no' ).val ( obj.admission_no );
                jQuery ( '#patient-mobile' ).val ( obj.mobile );
                jQuery ( '#patient-city' ).val ( obj.city );
                jQuery ( '#panel_id' ).val ( obj.panel_id );
                jQuery ( '#sales-btn' ).prop ( 'disabled', false );
                if ( obj.panel_patient == 'yes' ) {
                    jQuery ( '.panel-info' ).removeClass ( 'hidden' );
                    jQuery ( '.panel-info' ).html ( '<strong>Note!</strong> Patient is a panel patient' );
                } else {
                    jQuery ( '.panel-info' ).addClass ( 'hidden' );
                    jQuery ( '.panel-info' ).html ( '' );
                }
                
                load_lab_test_options ( patient_id );
                
            } else {
                alert ( 'No record found' );
                jQuery ( '#patient-name' ).val ( 'No record found' );
                jQuery ( '#patient-cnic' ).val ( 'No record found' );
                jQuery ( '#sales-btn' ).prop ( 'disabled', true );
            }
            jQuery ( '.loader' ).hide ();
        },
        error: function ( jqXHr, exception ) {
            alert ( jqXHr );
            jQuery ( '#sales-btn' ).prop ( 'disabled', true );
            jQuery ( '.loader' ).hide ();
        }
    } )
}

function load_lab_test_options ( patient_id = 0 ) {
    let csrf_token = jQuery ( '#csrf_token' ).val ();
    
    request = jQuery.ajax ( {
        url: path + 'lab/load-lab-tests',
        type: 'POST',
        data: {
            hmis_token: csrf_token,
            patient_id: patient_id
        },
        beforeSend: function () {
            jQuery ( '.loader' ).show ();
        },
        success: function ( response ) {
            jQuery ( '.loader' ).hide ();
            jQuery ( '#lab-tests-sale' ).html ( response );
            jQuery ( '#lab-tests-sale' ).select2 ( 'open' );
        },
        error: function ( jqXHr, exception ) {
            alert ( jqXHr );
            jQuery ( '#sales-btn' ).prop ( 'disabled', true );
            jQuery ( '.loader' ).hide ();
        }
    } )
}

function load_sale_test ( test_id ) {
    let iSum = 0;
    let disc = 0;
    let csrf_token = jQuery ( '#csrf_token' ).val ();
    let panel_id = jQuery ( '#panel_id' ).val ();
    let added = jQuery ( '#added' ).val ();
    added = parseInt ( added ) + 1;
    jQuery ( '#added' ).val ( added )
    request = jQuery.ajax ( {
        url: path + 'lab/load_sale_test',
        type: 'POST',
        data: {
            hmis_token: csrf_token,
            test_id: test_id,
            panel_id: panel_id,
            row: added,
        },
        beforeSend: function () {
            jQuery ( '.loader' ).show ();
        },
        success: function ( response ) {
            jQuery ( '.add-more' ).prepend ( response );
            jQuery ( '.test-option-' + test_id ).prop ( 'disabled', true );
            jQuery ( '.loader' ).hide ();
            jQuery ( '.price' ).each ( function () {
                if ( jQuery ( this ).val () != '' && jQuery ( this ).val () >= 0 )
                    iSum = iSum + parseFloat ( jQuery ( this ).val () );
            } );
            jQuery ( '.total' ).val ( iSum.toFixed ( 2 ) );
            disc = jQuery ( '#discount' ).val ();
            var net = iSum - ( iSum * ( disc / 100 ) );
            jQuery ( '.net-price' ).val ( net.toFixed ( 2 ) );
            jQuery ( '#lab-tests-sale' ).select2 ( 'open' );
        },
        error: function ( jqXHr, exception ) {
            alert ( jqXHr );
            jQuery ( '#sales-btn' ).prop ( 'disabled', true );
            jQuery ( '.loader' ).hide ();
            jQuery ( '#lab-tests-sale' ).select2 ( 'open' );
        }
    } )
}

function get_patient_by_lab_sale_id_and_test_type ( id, section_id = null, table = '' ) {
    if ( parseFloat ( id ) > 0 ) {
        let csrf_token = jQuery ( '#csrf_token' ).val ();
        request = jQuery.ajax ( {
            url: path + 'lab/get_patient_by_lab_sale_id_and_test_type',
            type: 'POST',
            data: {
                id,
                section_id,
                hmis_token: csrf_token,
            },
            beforeSend: function () {
                jQuery ( '.loader' ).show ();
            },
            success: function ( response ) {
                if ( response != 'false' ) {
                    let obj = JSON.parse ( response );
                    jQuery ( '#patient-name' ).val ( obj.name );
                    jQuery ( '#patient-id' ).val ( obj.id );
                    jQuery ( 'form button' ).prop ( 'disabled', false );
                    
                    if ( parseInt ( obj.doctor_id ) > 0 )
                        jQuery ( '#referred-by' ).val ( obj.doctor_id ).trigger ( 'change' );
                    
                } else {
                    alert ( 'No record found' );
                    jQuery ( '#patient-name' ).val ( 'No record found' );
                    jQuery ( '#patient-id' ).val ( 'No record found' );
                    jQuery ( 'form button' ).prop ( 'disabled', true );
                }
                jQuery ( '.loader' ).hide ();
                load_added_reports ( id, table );
            }
        } )
    }
}

function load_added_reports ( invoice_id, table ) {
    if ( parseFloat ( invoice_id ) > 0 && table !== '' && table.length > 0 ) {
        let csrf_token = jQuery ( '#csrf_token' ).val ();
        request = jQuery.ajax ( {
            url: path + 'radiology/load_added_reports',
            type: 'POST',
            data: {
                invoice_id,
                table,
                hmis_token: csrf_token,
            },
            success: function ( response ) {
                if ( response !== 'false' ) {
                    $ ( '#patient-info' ).show ();
                    $ ( '#patient-info' ).html ( response );
                }
            }
        } )
    }
}

document.addEventListener ( 'DOMContentLoaded', () => {
    const video = document.getElementById ( 'webcam' );
    const canvas = document.getElementById ( 'canvas' );
    const captureBtn = document.getElementById ( 'captureBtn' );
    const context = canvas.getContext ( '2d' );
    
    navigator.mediaDevices.getUserMedia ( { video: true } )
        .then ( ( stream ) => {
            video.srcObject = stream;
            video.play ();
        } )
        .catch ( ( err ) => console.error ( 'Error accessing webcam:', err ) );
    
    captureBtn.addEventListener ( 'click', () => {
        $ ( '#canvas' ).css ( 'display', 'block' );
        context.drawImage ( video, 0, 0, canvas.width, canvas.height );
        const imageData = canvas.toDataURL ( 'image/jpeg' );
        $ ( '#image-data' ).val ( imageData );
        // Send the captured image data to the server
        //     fetch ( 'save_image.php', {
        //         method: 'POST',
        //         headers: {
        //             'Content-Type': 'application/x-www-form-urlencoded',
        //         },
        //         body: `imageData=${ encodeURIComponent ( imageData ) }`,
        //     } )
        //         .then ( ( response ) => response.json () )
        //         .then ( ( data ) => console.log ( data ) )
        //         .catch ( ( error ) => console.error ( 'Error saving image:', error ) );
    } );
} );

function add_refer_outside ( test_id ) {
    let iSum = 0;
    let disc = 0;
    let csrf_token = jQuery ( '#csrf_token' ).val ();
    let panel_id = 0;
    let added = jQuery ( '#added' ).val ();
    added = parseInt ( added ) + 1;
    jQuery ( '#added' ).val ( added )
    request = jQuery.ajax ( {
        url: path + 'lab/load_add_refer_outside',
        type: 'POST',
        data: {
            hmis_token: csrf_token,
            test_id: test_id,
            panel_id: panel_id,
            row: added,
        },
        beforeSend: function () {
            jQuery ( '.loader' ).show ();
        },
        success: function ( response ) {
            jQuery ( '.add-more' ).prepend ( response );
            jQuery ( '.test-option-' + test_id ).prop ( 'disabled', true );
            jQuery ( '.loader' ).hide ();
            jQuery ( '#lab-tests-sale' ).select2 ( 'open' );
        },
        error: function ( jqXHr, exception ) {
            alert ( jqXHr );
            jQuery ( '#sales-btn' ).prop ( 'disabled', true );
            jQuery ( '.loader' ).hide ();
            jQuery ( '#lab-tests-sale' ).select2 ( 'open' );
        }
    } )
}

function validateCNIC ( cnic ) {
    request = jQuery.ajax ( {
        url: path + 'medical-tests/validate-cnic',
        type: 'GET',
        data: {
            cnic,
        },
        beforeSend: function () {
            jQuery ( '.loader' ).show ();
        },
        success: function ( response ) {
            jQuery ( '#sales-btn' ).prop ( 'disabled', false );
            jQuery ( '.loader' ).hide ();
            
            if ( response === 'exists' )
                alert ( 'CNIC is already associated with patient.' );
        },
        error: function ( jqXHr, exception ) {
            alert ( jqXHr );
            jQuery ( '#sales-btn' ).prop ( 'disabled', true );
            jQuery ( '.loader' ).hide ();
        }
    } )
}
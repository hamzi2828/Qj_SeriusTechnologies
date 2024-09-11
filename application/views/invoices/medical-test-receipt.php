<?php header ( 'Content-Type: application/pdf' ); ?>
<?php require 'vendor/autoload.php'; ?>
<html>
<head>
    <style>
        @page {
            size: auto;
            header: myheader;
            footer: myfooter;
        }

        body {
            font-family: sans-serif;
            font-size: 10pt;
        }

        td {
            vertical-align: top;
            border: 0;
        }

        th {
            border-left: 0;
            border-right: 0;
            border-top: 0;
        }
    </style>
</head>
<body>

<!--mpdf
<htmlpageheader name="myheader"></htmlpageheader>
<sethtmlpageheader name="myheader" page="all" value="on" show-this-page="1" />
mpdf-->
<table width="100%" style="font-size: 28pt; border-collapse: collapse; margin-top: 10px" cellpadding="0"
       border="0">
    <tbody>
    <tr>
        <td align="right">
            <strong><?php echo $test -> lab_no_prefix . '-' . $test -> lab_no ?></strong>
        </td>
    </tr>
    </tbody>
</table>

<table width="100%" style="font-size: 8pt; border-collapse: collapse; margin-top: 10px" cellpadding="0"
       border="0">
    
    <tbody>
    <tr>
        <td width="100%">
            <table width="100%">
                <tbody>
                <tr>
                    <td width="20%" align="left">
                        <strong>Name:</strong>
                    </td>
                    <td width="30%" align="left">
                        <?php echo $test -> name ?>
                    </td>
                    
                    <td width="20%" align="left">
                        <strong>Father Name:</strong>
                    </td>
                    <td width="30%" align="left">
                        <?php echo $test -> father_name ?>
                    </td>
                </tr>
                
                <tr>
                    <td width="20%" align="left">
                        <strong>Lab No.:</strong>
                    </td>
                    <td width="30%" align="left">
                        <?php echo $test -> lab_no_prefix . '-' . $test -> lab_no ?>
                    </td>
                    
                    <td width="20%" align="left">
                        <strong>CNIC | Passport:</strong>
                    </td>
                    <td width="30%" align="left">
                        <?php echo $test -> identity ?>
                        <?php echo !empty( trim ( $test -> passport ) ) ? '|' . $test -> passport : '' ?>
                    </td>
                </tr>
                
                <tr>
                    <td width="20%" align="left">
                        <strong>Contact No:</strong>
                    </td>
                    <td width="30%" align="left">
                        <?php echo $test -> contact ?>
                    </td>
                    
                    <td width="20%" align="left">
                        <strong>Trade | Natl.:</strong>
                    </td>
                    <td width="30%" align="left">
                        <?php echo $test -> trade ?>
                        <?php echo !empty( trim ( $test -> nationality ) ) ? '|' . get_country_by_id ( $test -> nationality ) -> title : '' ?>
                    </td>
                </tr>
                
                <tr>
                    <td width="20%" align="left">
                        <strong>Age | Gen (DOB):</strong>
                    </td>
                    <td width="30%" align="left">
                        <?php echo calculateAge ( $test -> dob ) ?>
                        <?php echo '|' . ucwords ( $test -> gender ) ?>
                        <?php echo $test -> dob ?>
                    </td>
                    
                    <td width="20%" align="left">
                        <strong>Marital Status:</strong>
                    </td>
                    <td width="30%" align="left">
                        <?php echo $test -> marital_status ?>
                    </td>
                </tr>
                
                <tr>
                    <td width="20%" align="left">
                        <strong>Country to Visit:</strong>
                    </td>
                    <td width="30%" align="left">
                        <?php echo get_country_by_id ( $test -> country_id ) -> title ?>
                    </td>
                    
                    <td width="20%" align="left">
                        <strong>Spec. Received:</strong>
                    </td>
                    <td width="30%" align="left">
                        <?php echo date_setter ( $test -> spec_received ) ?>
                    </td>
                </tr>
                
                <tr>
                    <td width="20%" align="left">
                        <strong>OEP/ Ref By:</strong>
                    </td>
                    <td width="30%" align="left">
                        <?php echo $test -> oep ?>
                    </td>
                    
                    <td width="20%" align="left">
                        <strong>Reported On:</strong>
                    </td>
                    <td width="30%" align="left">
                        <?php echo date_setter ( $test -> created_at, 5 ) ?>
                    </td>
                </tr>
                
                <tr>
                    <td width="20%" align="left">
                        <strong>Printed By:</strong>
                    </td>
                    <td align="left" colspan="3">
                        <?php echo $user -> name . ' | ' . date ( 'm/d/Y H:i:s A' ) ?>
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>

</table>

</body>
</html>
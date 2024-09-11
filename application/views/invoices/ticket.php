<?php header ( 'Content-Type: application/pdf' ); ?>
<html>
<head>
    <style>
        @page {
            sheet-size: 2.794in 1.5in;
        }

        body {
            font-family: sans-serif;
            font-size: 12pt;
        }
        
        table td {
            font-size: 12px;
        }
    </style>
</head>
<body>

<table width="100%" float="left">
    <tbody>
    <tr>
        <td width="100%" style="height: 100%">
            <strong><?php echo $sale_id ?></strong>
        </td>
    </tr>
    <tr>
        <td width="100%" style="height: 100%">
            <strong><?php echo $patient -> prefix . ' ' . $patient -> name ?></strong>
        </td>
    </tr>
    <tr>
        <td width="100%" style="height: 100%">
            <strong><?php echo @$patient -> age . ' ' . ucwords ( $patient -> age_year_month ) ?></strong>
        </td>
    </tr>
    <tr>
        <td width="100%" style="height: 100%">
            <strong>
                <?php
                    if ( $patient -> gender == '1' )
                        echo 'Male';
                    else if ( $patient -> gender == '0' )
                        echo 'Female';
                    else if ( $patient -> gender == '2' )
                        echo 'MC';
                    else if ( $patient -> gender == '3' )
                        echo 'FC';
                ?>
            </strong>
        </td>
    </tr>
    <tr>
        <td width="100%" style="height: 100%">
            <strong><?php echo date_setter ( date ( 'Y-m-d H:i:s' ) ) ?></strong>
        </td>
    </tr>
    </tbody>
</table>

</body>
</html>
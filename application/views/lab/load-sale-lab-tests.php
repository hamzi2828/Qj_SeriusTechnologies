<div class="sale-<?php echo $row ?>" style="display: block; float: left; width: 100%; background: #f5f5f5; padding: 10px 0 0 15px; margin-bottom: 15px; position: relative">
    <div class="form-group col-lg-5" style="padding-left: 0">
        <a href="javascript:void(0)" onclick="remove_lab_row(<?php echo $row ?>)">
            <i class="fa fa-trash"></i>
        </a>
        <label>Lab Test</label>
        <input type="hidden" name="test_id[]" value="<?php echo $test -> id ?>">
        <input type="text" class="form-control" readonly="readonly" value="<?php echo '('.$test -> code.') '.$test -> name ?>">
    </div>
    
    <div class="form-group col-lg-2" style="padding-left: 0">
        <label>Price</label>
        <input type="text" class="form-control price" readonly="readonly" name="price[]" value="<?php echo $price ?>">
    </div>
    
    <div class="form-group col-lg-2" style="padding-left: 0;"> 
        <label>TAT</label>
        <input type="text" class="form-control tat-<?php echo $row ?>" value="<?php echo $test -> tat ?>" readonly="readonly">
    </div>
    
    <!-- <div class="col-lg-3">
        <label><strong>Collection Date & Time</strong></label>
        <input type="datetime-local" name="report-collection-date-time[]" class="form-control">
    </div> -->

    <div class="col-lg-3">
        <label><strong>Collection Date & Time</strong></label>
        <input type="datetime-local" name="report-collection-date-time[]" class="form-control"
               value="<?php echo isset($default_datetime) ? $default_datetime : '' ?>">
    </div>
</div>
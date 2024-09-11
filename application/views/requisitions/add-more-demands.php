<div class="sale-<?php echo $row ?>">
    <div class="form-group col-lg-8">
        <a href="javascript:void(0)" onclick="remove_row(<?php echo $row ?>)">
            <i class="fa fa-trash-o"></i>
        </a>
        <label for="exampleInputEmail1">Description</label>
        <textarea name="description[]" class="form-control" rows="3"></textarea>
    </div>
    <div class="form-group col-lg-4">
        <label for="exampleInputEmail1">Quantity</label>
        <input type="text" name="quantity[]" class="form-control">
    </div>
</div>
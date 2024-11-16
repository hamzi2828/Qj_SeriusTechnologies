<div class="tab-pane fade active in">
    <form role="form" method="post" action="<?php echo base_url ( '/medical-tests/add-general-info' ) ?>"
          enctype="multipart/form-data"
          autocomplete="off">
        <div class="form-body" style="background: transparent;">
            <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                   value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
            
            <div class="row">
                <div class="col-md-10">
                    <div class="row">
  

                    
                    <div class="col-lg-4 form-group">
                        <label for="oep-id">OEP</label>
                        <select name="oep-id" class="form-control select2me" id="oep-id" required="required" data-placeholder="Select">
                            <option value="">Select OEP</option>
                            <?php
                            if (count($oeps) > 0) {
                                foreach ($oeps as $oep) {
                                    ?>
                                    <option value="<?php echo $oep->id; ?>" data-price="<?php echo $oep->price; ?>">
                                        <?php echo $oep->name; ?>
                                    </option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="col-lg-4 form-group">
                        <label for="oep-price">OEP Price</label>
                        <input type="text" id="oep-price" class="form-control" readonly="readonly" placeholder="Price will be displayed here" />
                    </div>






                        
                        <div class="col-lg-4 form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" class="form-control" required="required" id="name"
                                   value="<?php echo set_value ( 'name' ) ?>" autofocus="autofocus">
                        </div>
                        
                        <div class="col-lg-4 form-group">
                            <label for="father-name">Father Name</label>
                            <input type="text" name="father-name" class="form-control" id="father-name"
                                   value="<?php echo set_value ( 'father-name' ) ?>">
                        </div>
                        
                        <div class="col-lg-3 form-group">
                            <label for="identity">CNIC</label>
                            <input type="text" name="identity" class="form-control" required="required" id="identity"
                                   maxlength="15" onchange="validateCNIC(this.value)"
                                   value="<?php echo set_value ( 'identity' ) ?>">
                        </div>
                        
                        <div class="col-lg-3 form-group">
                            <label for="contact">Contact</label>
                            <input type="text" name="contact" class="form-control" required="required" id="contact"
                                   value="<?php echo set_value ( 'contact' ) ?>">
                        </div>
                        
                        <div class="col-lg-3 form-group">
                            <label for="passport">Passport</label>
                            <input type="text" name="passport" class="form-control" required="required" id="passport"
                                   value="<?php echo set_value ( 'passport' ) ?>">
                        </div>
                        
                        <div class="col-lg-3 form-group">
                            <label for="trade">Trade</label>
                            <input type="text" name="trade" class="form-control" required="required" id="trade"
                                   value="<?php echo set_value ( 'trade' ) ?>">
                        </div>
                        
                        <div class="col-lg-3 form-group">
                            <label for="nationality">Nationality</label>
                            <select name="nationality" class="form-control select2me" id="nationality"
                                    required="required"
                                    data-placeholder="Select">
                                <option></option>
                                <?php
                                    if ( count ( $countries ) > 0 ) {
                                        foreach ( $countries as $country ) {
                                            ?>
                                            <option value="<?php echo $country -> id ?>" <?php echo $this -> input -> post ( 'nationality' ) === $country -> id ? 'selected="selected"' : '' ?>>
                                                <?php echo $country -> title ?>
                                            </option>
                                            <?php
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                        
                        <div class="col-lg-3 form-group">
                            <label for="dob">Date of Birth</label>
                            <input type="date" name="dob" class="form-control" required="required" id="dob"
                                   value="<?php echo set_value ( 'dob' ) ?>">
                        </div>
                        
                        <div class="col-lg-3 form-group">
                            <label for="gender">Gender</label>
                            <select name="gender" class="form-control select2me" id="gender"
                                    required="required"
                                    data-placeholder="Select">
                                <option></option>
                                <option value="male" <?php echo $this -> input -> post ( 'gender' ) === 'male' ? 'selected="selected"' : '' ?>>
                                    Male
                                </option>
                                <option value="female" <?php echo $this -> input -> post ( 'gender' ) === 'female' ? 'selected="selected"' : '' ?>>
                                    Female
                                </option>
                            </select>
                        </div>
                        
                        <div class="col-lg-3 form-group">
                            <label for="marital-status">Marital Status</label>
                            <select name="marital-status" class="form-control select2me" id="marital-status"
                                    required="required"
                                    data-placeholder="Select">
                                <option></option>
                                <option value="single" <?php echo $this -> input -> post ( 'marital-status' ) === 'single' ? 'selected="selected"' : '' ?>>
                                    Single
                                </option>
                                <option value="married" <?php echo $this -> input -> post ( 'marital-status' ) === 'married' ? 'selected="selected"' : '' ?>>
                                    Married
                                </option>
                                <option value="divorced" <?php echo $this -> input -> post ( 'marital-status' ) === 'divorced' ? 'selected="selected"' : '' ?>>
                                    Divorced
                                </option>
                                <option value="widow" <?php echo $this -> input -> post ( 'marital-status' ) === 'widow' ? 'selected="selected"' : '' ?>>
                                    Widow
                                </option>
                            </select>
                        </div>
                        
                        <div class="col-lg-3 form-group">
                            <label for="country">Country to Visit</label>
                            <select name="country-id" class="form-control select2me" id="country" required="required"
                                    data-placeholder="Select">
                                <option></option>
                                <?php
                                    if ( count ( $countries ) > 0 ) {
                                        foreach ( $countries as $country ) {
                                            ?>
                                            <option value="<?php echo $country -> id ?>" <?php echo $this -> input -> post ( 'country-id' ) === $country -> id ? 'selected="selected"' : '' ?>>
                                                <?php echo $country -> title ?>
                                            </option>
                                            <?php
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                        
                        <div class="col-lg-3 form-group">
                            <label for="spec">Spec. Received</label>
                            <input type="datetime-local" name="spec" class="form-control" required="required" id="spec"
                                   value="<?php echo set_value ( 'spec' ) ?>">
                        </div>
                        
                        <div class="col-lg-3 form-group">
                            <label for="oep">OEP/Ref By</label>
                            <input type="text" name="oep" class="form-control" required="required" id="oep"
                                   value="<?php echo set_value ( 'oep' ) ?>">
                        </div>

                        <div class="col-lg-4 form-group">
                            <label for="payment-method">Payment Method</label>
                            <select name="payment-method" id="payment-method" class="form-control" required>
                                <option value="" disabled selected>Select Payment Method</option>
                                <option value="cash">Cash</option>
                                <option value="panel">Panel</option>
                            </select>
                            <small class="text-danger" id="payment-method-error" style="display: none;">
                                Please select a payment method.
                            </small>
                        </div>


                    </div>
                </div>
                <div class="col-md-2">
                    <div class="row">
                        <div class="form-group col-lg-12">
                            <video id="webcam" style="width: 100%; height: 180px"></video>
                            <button id="captureBtn" class="btn btn-primary btn-sm" type="button">Capture</button>
                            <canvas id="canvas" width="170" height="150" style="display: none"></canvas>
                            <textarea name="image-data" style="display: none" cols="30" rows="10"
                                      id="image-data"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-lg-12">
                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                <div class="fileupload-new thumbnail" style="width: 100%; height: auto;">
                                    <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt="" />
                                </div>
                                <div class="fileupload-preview fileupload-exists thumbnail"
                                     style="max-width: 200px; max-height: 150px; line-height: 20px;">
                                </div>
                                <div style="display: flex; justify-content: start; align-items: center; gap: 10px;">
                                    <span class="btn default btn-file">
                                        <span class="fileupload-new">
                                            <i class="fa fa-paper-clip"></i> Select image
                                        </span>
                                        <span class="fileupload-exists">
                                            <i class="fa fa-undo"></i> Change
                                        </span>
                                        <input type="file" class="default" name="image" />
                                    </span>
                                    <a href="#" class="btn red fileupload-exists" data-dismiss="fileupload">
                                        <i class="fa fa-trash-o"></i> Remove
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
        </div>
        <div class="form-actions">
            <button type="submit" class="btn blue">Submit</button>
        </div>
    </form>
</div>



<script>
    document.addEventListener('DOMContentLoaded', function () {
        console.log('Page loaded and script initialized.');

        const oepDropdown = $('#oep-id'); // Use jQuery for Select2 compatibility
        const priceInput = $('#oep-price'); // Get the input field for displaying the price

        // Initialize Select2
        oepDropdown.select2();

        // Handle change event
        oepDropdown.on('change', function () {
            const selectedOption = $(this).find('option:selected'); // Get the selected option
            const price = selectedOption.data('price'); // Use .data() to fetch the data-price attribute

            // console.log('Selected option:', selectedOption);
            // console.log('Selected value:', selectedOption.val());
            // console.log('Selected price:', price);

            if (selectedOption.val()) {
                if (price) {
                    priceInput.val(price); // Set the price in the read-only input
                } else {
                    priceInput.val('No price available'); // Handle missing price
                }
            } else {
                priceInput.val(''); // Clear the input field if no valid OEP is selected
            }
        });
    });
</script>

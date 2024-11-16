<div class="tab-pane fade <?php echo $this -> input -> get ( 'tab' ) === 'general-information' ? 'active in' : '' ?>">
    <form role="form" method="post"
          action="<?php echo base_url ( '/medical-tests/edit-general-info/' . $test -> id ) ?>"
          enctype="multipart/form-data"
          autocomplete="off">
        <div class="form-body" style="background: transparent;">
            <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                   value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
            
            <div class="row">
                <div class="col-md-10">
                    <div class="row">
                        <div class="col-lg-3 form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" class="form-control" required="required" id="name"
                                   value="<?php echo set_value ( 'name', $test -> name ) ?>" autofocus="autofocus">
                        </div>
                        
                        <div class="col-lg-3 form-group">
                            <label for="father-name">Father Name</label>
                            <input type="text" name="father-name" class="form-control" id="father-name"
                                   value="<?php echo set_value ( 'father-name', $test -> father_name ) ?>">
                        </div>
                        
                        <div class="col-lg-3 form-group">
                            <label for="identity">CNIC</label>
                            <input type="text" name="identity" class="form-control" required="required" id="identity"
                                   value="<?php echo set_value ( 'identity', $test -> identity ) ?>">
                        </div>
                        
                        <div class="col-lg-3 form-group">
                            <label for="contact">Contact</label>
                            <input type="text" name="contact" class="form-control" required="required" id="contact"
                                   value="<?php echo set_value ( 'contact', $test -> contact ) ?>">
                        </div>
                        
                        <div class="col-lg-3 form-group">
                            <label for="passport">Passport</label>
                            <input type="text" name="passport" class="form-control" required="required" id="passport"
                                   value="<?php echo set_value ( 'passport', $test -> passport ) ?>">
                        </div>
                        
                        <div class="col-lg-3 form-group">
                            <label for="trade">Trade</label>
                            <input type="text" name="trade" class="form-control" required="required" id="trade"
                                   value="<?php echo set_value ( 'trade', $test -> trade ) ?>">
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
                                            <option value="<?php echo $country -> id ?>" <?php echo $test -> nationality === $country -> id ? 'selected="selected"' : '' ?>>
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
                                   value="<?php echo set_value ( 'dob', $test -> dob ) ?>">
                        </div>
                        
                        <div class="col-lg-3 form-group">
                            <label for="gender">Gender</label>
                            <select name="gender" class="form-control select2me" id="gender"
                                    required="required"
                                    data-placeholder="Select">
                                <option></option>
                                <option value="male" <?php echo $test -> gender === 'male' ? 'selected="selected"' : '' ?>>
                                    Male
                                </option>
                                <option value="female" <?php echo $test -> gender === 'female' ? 'selected="selected"' : '' ?>>
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
                                <option value="single" <?php echo $test -> marital_status === 'single' ? 'selected="selected"' : '' ?>>
                                    Single
                                </option>
                                <option value="married" <?php echo $test -> marital_status === 'married' ? 'selected="selected"' : '' ?>>
                                    Married
                                </option>
                                <option value="divorced" <?php echo $test -> marital_status === 'divorced' ? 'selected="selected"' : '' ?>>
                                    Divorced
                                </option>
                                <option value="widow" <?php echo $test -> marital_status === 'widow' ? 'selected="selected"' : '' ?>>
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
                                            <option value="<?php echo $country -> id ?>" <?php echo $test -> country_id === $country -> id ? 'selected="selected"' : '' ?>>
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
                                   value="<?php echo set_value ( 'spec', date ( 'Y-m-d\TH:i', strtotime ( $test -> spec_received ) ) ) ?>">
                        </div>
                        
                        <div class="col-lg-3 form-group">
                            <label for="oep">OEP/Ref By</label>
                            <input type="text" name="oep" class="form-control" required="required" id="oep"
                                   value="<?php echo set_value ( 'oep', $test -> oep ) ?>">
                        </div>
                        
                        <div class="col-lg-3 form-group">
                            <label for="fit">Fit/Unfit</label>
                            <select name="fit" class="form-control select2me" id="fit"
                                    data-allow-clear="true"
                                    data-placeholder="Select">
                                <option></option>
                                <option value="5" <?php echo $test -> fit === '5' ? 'selected="selected"' : '' ?>>
                                    Hold
                                </option>
                                <option value="1" <?php echo $test -> fit === '1' ? 'selected="selected"' : '' ?>>
                                    Fit
                                </option>
                                <option value="0" <?php echo $test -> fit === '0' ? 'selected="selected"' : '' ?>>
                                    Unfit
                                </option>
                                <option value="3" <?php echo $test -> fit === '3' ? 'selected="selected"' : '' ?>>
                                    Defer
                                </option>
                            </select>
                        </div>

                        <div class="col-lg-3 form-group">
                                <label for="payment-method">Payment Method</label>
                                <select name="payment-method" id="payment-method" class="form-control" required>
                                    <option value="cash" <?php echo $test->payment_method === 'cash' ? 'selected' : ''; ?>>Cash</option>
                                    <option value="panel" <?php echo $test->payment_method === 'panel' ? 'selected' : ''; ?>>Panel</option>
                                </select>
                            </div>


                            <?php
                        // Ensure the model is loaded
                        $this->load->model('MedicalTestModel'); 

                        // Call the function and pass the oep_id
                        $oep_details = $this->MedicalTestModel->get_details_of_oep_by_id($test->oep_id); 
                    ?>

                    <div class="col-lg-3 form-group">
                        <label for="oep-price">OEP Price</label>
                        <input type="text" name="oep-price" id="oep-price" class="form-control" readonly="readonly"
                            value="<?php echo isset($oep_details->price) ? $oep_details->price : 'No price available'; ?>"
                            placeholder="Price will be displayed here">
                    </div>

                    </div>
                </div>
                <div class="col-md-2">
                    <div class="row">
                        <div class="form-group col-lg-12">
                            <video id="webcam" style="width: 100%; height: 180px"></video>
                            <button id="captureBtn" class="btn btn-primary btn-sm" type="button">Capture</button>
                            <canvas id="canvas" width="170" height="150" style="display: none"></canvas>
                            <textarea name="image-data" style="display: none" cols="30" rows="10" id="image-data"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-lg-12">
                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                <div class="fileupload-new thumbnail" style="width: 100%; height: auto;">
                                    <?php
                                        $image = 'http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image';
                                        if (!empty(trim ($test -> image_data)))
                                            $image = $test -> image_data;
                                        if (!empty(trim ($test -> image)))
                                            $image = $test -> image;
                                    ?>
                                    <img src="<?php echo $image ?>"
                                         alt="" />
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
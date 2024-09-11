<div class="tab-pane fade <?php echo $this -> input -> get ( 'tab' ) === 'general-physical-examination' ? 'active in' : '' ?>">
    <form role="form" method="post"
          action="<?php echo base_url ( '/medical-tests/upsert-general-physical-examination/' . $test -> id ) ?>"
          autocomplete="off">
        <div class="form-body" style="background: transparent;">
            <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                   value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
            
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                            <th colspan="2" align="center" class="text-center" style="font-size: 14pt">
                                GENERAL PHYSICAL EXAMINATION
                            </th>
                        </tr>
                        <tr>
                            <th align="left">
                                Type of Examination
                            </th>
                            <th align="left">
                                Result
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td width="40%">
                                <label for="height">Height</label>
                            </td>
                            <td>
                                <input type="text" id="height" name="height" class="form-control" autofocus="autofocus"
                                       value="<?php echo set_value ( 'height', !empty( $physical_examination ) ? $physical_examination -> height : 'cm' ) ?>">
                            </td>
                        </tr>
                        
                        <tr>
                            <td width="40%">
                                <label for="weight">Weight</label>
                            </td>
                            <td>
                                <input type="text" id="weight" name="weight" class="form-control"
                                       value="<?php echo set_value ( 'height', !empty( $physical_examination ) ? $physical_examination -> weight : 'Kg' ) ?>">
                            </td>
                        </tr>
                        
                        <tr>
                            <td width="40%">
                                <label for="vision">Vision (Both Side)</label>
                            </td>
                            <td>
                                <input type="text" id="vision" name="vision" class="form-control"
                                       value="<?php echo set_value ( 'height', !empty( $physical_examination ) ? $physical_examination -> vision : 'RT. 6/6 LT.6/6' ) ?>">
                            </td>
                        </tr>
                        
                        <tr>
                            <td width="40%">
                                <label for="color">Color Vision</label>
                            </td>
                            <td>
                                <input type="text" id="color" name="color" class="form-control"
                                       value="<?php echo set_value ( 'height', !empty( $physical_examination ) ? $physical_examination -> color : 'Normal' ) ?>">
                            </td>
                        </tr>
                        
                        <tr>
                            <td width="40%">
                                <label for="hearing">Hearing</label>
                            </td>
                            <td>
                                <input type="text" id="hearing" name="hearing" class="form-control"
                                       value="<?php echo set_value ( 'height', !empty( $physical_examination ) ? $physical_examination -> hearing : 'Normal' ) ?>">
                            </td>
                        </tr>
                        
                        <tr>
                            <td width="40%">
                                <label for="liver">Liver</label>
                            </td>
                            <td>
                                <input type="text" id="liver" name="liver" class="form-control"
                                       value="<?php echo set_value ( 'height', !empty( $physical_examination ) ? $physical_examination -> liver : 'Normal' ) ?>">
                            </td>
                        </tr>
                        
                        <tr>
                            <td width="40%">
                                <label for="skin">Skin</label>
                            </td>
                            <td>
                                <input type="text" id="skin" name="skin" class="form-control"
                                       value="<?php echo set_value ( 'height', !empty( $physical_examination ) ? $physical_examination -> skin : 'Normal' ) ?>">
                            </td>
                        </tr>
                        
                        <tr>
                            <td width="40%">
                                <label for="hemorrhoids">Hemorrhoids</label>
                            </td>
                            <td>
                                <input type="text" id="hemorrhoids" name="hemorrhoids" class="form-control"
                                       
                                       value="<?php echo set_value ( 'height', !empty( $physical_examination ) ? $physical_examination -> hemorrhoids : 'Not seen' ) ?>">
                            </td>
                        </tr>
                        
                        <tr>
                            <td width="40%">
                                <label for="bp">BP</label>
                            </td>
                            <td>
                                <input type="text" id="bp" name="bp" class="form-control"
                                       value="<?php echo set_value ( 'height', !empty( $physical_examination ) ? $physical_examination -> bp : '' ) ?>">
                            </td>
                        </tr>
                        
                        <tr>
                            <td width="40%">
                                <label for="pulse">Pulse</label>
                            </td>
                            <td>
                                <input type="text" id="pulse" name="pulse" class="form-control"
                                       value="<?php echo set_value ( 'height', !empty( $physical_examination ) ? $physical_examination -> pulse : 'Normal' ) ?>">
                            </td>
                        </tr>
                        
                        <tr>
                            <td width="40%">
                                <label for="heart-beat">Heart Beat</label>
                            </td>
                            <td>
                                <input type="text" id="heart-beat" name="heart-beat" class="form-control"
                                       
                                       value="<?php echo set_value ( 'height', !empty( $physical_examination ) ? $physical_examination -> heart_beat : 'Normal' ) ?>">
                            </td>
                        </tr>
                        
                        <tr>
                            <td width="40%">
                                <label for="lungs">Lungs</label>
                            </td>
                            <td>
                                <input type="text" id="lungs" name="lungs" class="form-control"
                                       value="<?php echo set_value ( 'height', !empty( $physical_examination ) ? $physical_examination -> lungs : 'Normal' ) ?>">
                            </td>
                        </tr>
                        
                        <tr>
                            <td width="40%">
                                <label for="abdomen">Abdomen</label>
                            </td>
                            <td>
                                <input type="text" id="abdomen" name="abdomen" class="form-control"
                                       value="<?php echo set_value ( 'height', !empty( $physical_examination ) ? $physical_examination -> abdomen : 'Normal' ) ?>">
                            </td>
                        </tr>
                        
                        <tr>
                            <td width="40%">
                                <label for="hernia">Hernia</label>
                            </td>
                            <td>
                                <input type="text" id="hernia" name="hernia" class="form-control"
                                       value="<?php echo set_value ( 'height', !empty( $physical_examination ) ? $physical_examination -> hernia : 'Absent' ) ?>">
                            </td>
                        </tr>
                        
                        <tr>
                            <td width="40%">
                                <label for="kidneys">Kidneys</label>
                            </td>
                            <td>
                                <input type="text" id="kidneys" name="kidneys" class="form-control"
                                       value="<?php echo set_value ( 'height', !empty( $physical_examination ) ? $physical_examination -> kidneys : 'Normal' ) ?>">
                            </td>
                        </tr>
                        
                        <tr>
                            <td width="40%">
                                <label for="varicose-veins">Varicose Veins</label>
                            </td>
                            <td>
                                <input type="text" id="varicose-veins" name="varicose-veins" class="form-control"
                                       
                                       value="<?php echo set_value ( 'height', !empty( $physical_examination ) ? $physical_examination -> varicose_veins : 'Absent' ) ?>">
                            </td>
                        </tr>
                        
                        <tr>
                            <td width="40%">
                                <label for="thyroid-gland">Thyroid Gland</label>
                            </td>
                            <td>
                                <input type="text" id="thyroid-gland" name="thyroid-gland" class="form-control"
                                       
                                       value="<?php echo set_value ( 'height', !empty( $physical_examination ) ? $physical_examination -> thyroid_gland : 'Not Enlarged' ) ?>">
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        
        </div>
        <div class="form-actions">
            <button type="submit" class="btn blue">Submit</button>
        </div>
    </form>
</div>
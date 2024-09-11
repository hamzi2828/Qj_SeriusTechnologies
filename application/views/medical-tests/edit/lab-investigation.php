<div class="tab-pane fade <?php echo $this -> input -> get ( 'tab' ) === 'lab-investigation' ? 'active in' : '' ?>">
    <form role="form" method="post"
          action="<?php echo base_url ( '/medical-tests/add-lab-investigation/' . $test -> id ) ?>"
          autocomplete="off">
        <div class="form-body" style="background: transparent;">
            <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                   value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
            
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                            <th colspan="2" style="font-size: 14pt">
                                HEMATOLOGY AND CHEMISTRY
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td width="40%">
                                <label for="hb">HB</label>
                            </td>
                            <td>
                                <input type="text" id="hb" name="hb" class="form-control" autofocus="autofocus"
                                       
                                       value="<?php echo set_value ( 'hb', !empty( $lab_investigation ) ? $lab_investigation -> hb : 'g/dl' ) ?>">
                            </td>
                        </tr>
                        
                        <tr>
                            <td width="40%">
                                <label for="ast">AST</label>
                            </td>
                            <td>
                                <input type="text" id="ast" name="ast" class="form-control"
                                       
                                       value="<?php echo set_value ( 'ast', !empty( $lab_investigation ) ? $lab_investigation -> ast : '' ) ?>">
                            </td>
                        </tr>
                        
                        <tr>
                            <td width="40%">
                                <label for="urea">UREA</label>
                            </td>
                            <td>
                                <input type="text" id="urea" name="urea" class="form-control"
                                       
                                       value="<?php echo set_value ( 'urea', !empty( $lab_investigation ) ? $lab_investigation -> urea : '' ) ?>">
                            </td>
                        </tr>
                        
                        <tr>
                            <td width="40%">
                                <label for="bsr">BSR</label>
                            </td>
                            <td>
                                <input type="text" id="bsr" name="bsr" class="form-control"
                                       
                                       value="<?php echo set_value ( 'bsr', !empty( $lab_investigation ) ? $lab_investigation -> bsr : 'mg/dl' ) ?>">
                            </td>
                        </tr>
                        
                        <tr>
                            <td width="40%">
                                <label for="creatinine">Creatinine</label>
                            </td>
                            <td>
                                <input type="text" id="creatinine" name="creatinine" class="form-control"
                                       
                                       value="<?php echo set_value ( 'creatinine', !empty( $lab_investigation ) ? $lab_investigation -> creatinine : '' ) ?>">
                            </td>
                        </tr>
                        
                        <tr>
                            <td width="40%">
                                <label for="bilirubin">Bilirubin</label>
                            </td>
                            <td>
                                <input type="text" id="bilirubin" name="bilirubin" class="form-control"
                                       
                                       value="<?php echo set_value ( 'bilirubin', !empty( $lab_investigation ) ? $lab_investigation -> bilirubin : '' ) ?>">
                            </td>
                        </tr>
                        
                        <tr>
                            <td width="40%">
                                <label for="alt">ALT</label>
                            </td>
                            <td>
                                <input type="text" id="alt" name="alt" class="form-control"
                                       
                                       value="<?php echo set_value ( 'alt', !empty( $lab_investigation ) ? $lab_investigation -> alt : 'U/l' ) ?>">
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                            <th colspan="2" style="font-size: 14pt">
                                SEROLOGY AND VENEREAL DISEASES
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td width="40%">
                                <label for="anti-hcv">Anti HCV</label>
                            </td>
                            <td>
                                <select name="anti-hcv" id="anti-hcv" class="form-control select2me">
                                    <option value="Negative" <?php echo ( !empty( $lab_investigation ) && $lab_investigation -> anti_hcv === 'Negative' ) ? 'selected="selected"' : '' ?>>
                                        Negative
                                    </option>
                                    <option value="POSITIVE*" <?php echo ( !empty( $lab_investigation ) && $lab_investigation -> anti_hcv === 'Positive' ) ? 'selected="selected"' : '' ?>>
                                        POSITIVE*
                                    </option>
                                </select>
                            </td>
                        </tr>
                        
                        <tr>
                            <td width="40%">
                                <label for="hbsag">HbsAg</label>
                            </td>
                            <td>
                                <select name="hbsag" id="hbsag" class="form-control select2me">
                                    <option value="Negative" <?php echo ( !empty( $lab_investigation ) && $lab_investigation -> hbsag === 'Negative' ) ? 'selected="selected"' : '' ?>>
                                        Negative
                                    </option>
                                    <option value="POSITIVE*" <?php echo ( !empty( $lab_investigation ) && $lab_investigation -> hbsag === 'Positive' ) ? 'selected="selected"' : '' ?>>
                                        POSITIVE*
                                    </option>
                                </select>
                            </td>
                        </tr>
                        
                        <tr>
                            <td width="40%">
                                <label for="hiv">HIV</label>
                            </td>
                            <td>
                                <select name="hiv" id="hiv" class="form-control select2me">
                                    <option value="Negative" <?php echo ( !empty( $lab_investigation ) && $lab_investigation -> hiv === 'Negative' ) ? 'selected="selected"' : '' ?>>
                                        Negative
                                    </option>
                                    <option value="POSITIVE*" <?php echo ( !empty( $lab_investigation ) && $lab_investigation -> hiv === 'Positive' ) ? 'selected="selected"' : '' ?>>
                                        POSITIVE*
                                    </option>
                                </select>
                            </td>
                        </tr>
                        
                        <tr>
                            <td width="40%">
                                <label for="vdrl">VDRL</label>
                            </td>
                            <td>
                                <select name="vdrl" id="vdrl" class="form-control select2me">
                                    <option value="Negative" <?php echo ( !empty( $lab_investigation ) && $lab_investigation -> vdrl === 'Negative' ) ? 'selected="selected"' : '' ?>>
                                        Negative
                                    </option>
                                    <option value="POSITIVE*" <?php echo ( !empty( $lab_investigation ) && $lab_investigation -> vdrl === 'Positive' ) ? 'selected="selected"' : '' ?>>
                                        POSITIVE*
                                    </option>
                                </select>
                            </td>
                        </tr>
                        
                        <tr>
                            <td width="40%">
                                <label for="tuberculosis">Tuberculosis</label>
                            </td>
                            <td>
                                <select name="tuberculosis" id="tuberculosis" class="form-control select2me">
                                    <option value="Negative" <?php echo ( !empty( $lab_investigation ) && $lab_investigation -> tuberculosis === 'Negative' ) ? 'selected="selected"' : '' ?>>
                                        Negative
                                    </option>
                                    <option value="POSITIVE*" <?php echo ( !empty( $lab_investigation ) && $lab_investigation -> tuberculosis === 'Positive' ) ? 'selected="selected"' : '' ?>>
                                        POSITIVE*
                                    </option>
                                </select>
                            </td>
                        </tr>
                        
                        <tr>
                            <td width="40%">
                                <label for="blood-group">Blood Group</label>
                            </td>
                            <td>
                                <select name="blood-group" id="blood-group" class="form-control select2me">
                                    <option>Select</option>
                                    <option value="A-" <?php echo ( !empty( $lab_investigation ) && $lab_investigation -> blood_group === 'A-' ) ? 'selected="selected"' : '' ?>>
                                        A-
                                    </option>
                                    <option value="A+" <?php echo ( !empty( $lab_investigation ) && $lab_investigation -> blood_group === 'A+' ) ? 'selected="selected"' : '' ?>>
                                        A+
                                    </option>
                                    <option value="B-" <?php echo ( !empty( $lab_investigation ) && $lab_investigation -> blood_group === 'B-' ) ? 'selected="selected"' : '' ?>>
                                        B-
                                    </option>
                                    <option value="B+" <?php echo ( !empty( $lab_investigation ) && $lab_investigation -> blood_group === 'B+' ) ? 'selected="selected"' : '' ?>>
                                        B+
                                    </option>
                                    <option value="AB-" <?php echo ( !empty( $lab_investigation ) && $lab_investigation -> blood_group === 'AB-' ) ? 'selected="selected"' : '' ?>>
                                        AB-
                                    </option>
                                    <option value="AB+" <?php echo ( !empty( $lab_investigation ) && $lab_investigation -> blood_group === 'AB+' ) ? 'selected="selected"' : '' ?>>
                                        AB+
                                    </option>
                                    <option value="O-" <?php echo ( !empty( $lab_investigation ) && $lab_investigation -> blood_group === 'O-' ) ? 'selected="selected"' : '' ?>>
                                        O-
                                    </option>
                                    <option value="O+" <?php echo ( !empty( $lab_investigation ) && $lab_investigation -> blood_group === 'O+' ) ? 'selected="selected"' : '' ?>>
                                        O+
                                    </option>
                                </select>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                            <th colspan="2" style="font-size: 14pt">
                                URINE ANALYSIS
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td width="40%">
                                <label for="ph">PH</label>
                            </td>
                            <td>
                                <input type="text" id="ph" name="ph" class="form-control"
                                       autofocus="autofocus"
                                       
                                       value="<?php echo set_value ( 'ph', !empty( $lab_investigation ) ? $lab_investigation -> ph : '' ) ?>">
                            </td>
                        </tr>
                        
                        <tr>
                            <td width="40%">
                                <label for="sugar">Sugar</label>
                            </td>
                            <td>
                                <input type="text" id="sugar" name="sugar" class="form-control"
                                       
                                       value="<?php echo set_value ( 'sugar', !empty( $lab_investigation ) ? $lab_investigation -> sugar : 'Nil' ) ?>">
                            </td>
                        </tr>
                        
                        <tr>
                            <td width="40%">
                                <label for="albumin">Albumin</label>
                            </td>
                            <td>
                                <input type="text" id="albumin" name="albumin" class="form-control"
                                       
                                       value="<?php echo set_value ( 'albumin', !empty( $lab_investigation ) ? $lab_investigation -> albumin : 'Nil' ) ?>">
                            </td>
                        </tr>
                        
                        <tr>
                            <td width="40%">
                                <label for="pus-cells">Pus Cells</label>
                            </td>
                            <td>
                                <input type="text" id="pus-cells" name="pus-cells" class="form-control"
                                       
                                       value="<?php echo set_value ( 'pus-cells', !empty( $lab_investigation ) ? $lab_investigation -> pus_cells : 'Nil' ) ?>">
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                            <th colspan="2" style="font-size: 14pt">
                                STOOL EXAMINATION
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td width="40%">
                                <label for="ova-cysts">OVA/Cysts</label>
                            </td>
                            <td>
                                <input type="text" id="ova-cysts" name="ova-cysts" class="form-control"
                                       autofocus="autofocus"
                                       
                                       value="<?php echo set_value ( 'ova-cysts', !empty( $lab_investigation ) ? $lab_investigation -> ova_cysts : 'Not seen' ) ?>">
                            </td>
                        </tr>
                        
                        <tr>
                            <td width="40%">
                                <label for="rbcs">RBCs</label>
                            </td>
                            <td>
                                <input type="text" id="rbcs" name="rbcs" class="form-control"
                                       
                                       value="<?php echo set_value ( 'rbcs', !empty( $lab_investigation ) ? $lab_investigation -> rbcs : 'Not seen' ) ?>">
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                            <th colspan="2" style="font-size: 14pt">
                                URINE FOR DRUGS OF ABUSE
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td width="40%">
                                <label for="amphetamine">Amphetamine (AMP)</label>
                            </td>
                            <td>
                                <input type="text" id="amphetamine" name="amphetamine" class="form-control"
                                       autofocus="autofocus"
                                       
                                       value="<?php echo set_value ( 'amphetamine', !empty( $lab_investigation ) ? $lab_investigation -> amphetamine : 'Negative' ) ?>">
                            </td>
                        </tr>
                        
                        <tr>
                            <td width="40%">
                                <label for="benzodiazepine">Benzodiazepine (BZO)</label>
                            </td>
                            <td>
                                <input type="text" id="benzodiazepine" name="benzodiazepine" class="form-control"
                                       
                                       value="<?php echo set_value ( 'benzodiazepine', !empty( $lab_investigation ) ? $lab_investigation -> benzodiazepine : 'Negative' ) ?>">
                            </td>
                        </tr>
                        
                        <tr>
                            <td width="40%">
                                <label for="marijuana">Marijuana (THC)</label>
                            </td>
                            <td>
                                <input type="text" id="marijuana" name="marijuana" class="form-control"
                                       
                                       value="<?php echo set_value ( 'marijuana', !empty( $lab_investigation ) ? $lab_investigation -> marijuana : 'Negative' ) ?>">
                            </td>
                        </tr>
                        
                        <tr>
                            <td width="40%">
                                <label for="methamphetamine">Methamphetamine (MET)</label>
                            </td>
                            <td>
                                <input type="text" id="methamphetamine" name="methamphetamine" class="form-control"
                                       
                                       value="<?php echo set_value ( 'methamphetamine', !empty( $lab_investigation ) ? $lab_investigation -> methamphetamine : 'Negative' ) ?>">
                            </td>
                        </tr>
                        
                        <tr>
                            <td width="40%">
                                <label for="anti-depressant">Anti Depressant</label>
                            </td>
                            <td>
                                <input type="text" id="anti-depressant" name="anti-depressant" class="form-control"
                                       
                                       value="<?php echo set_value ( 'anti-depressant', !empty( $lab_investigation ) ? $lab_investigation -> anti_depressant : 'Negative' ) ?>">
                            </td>
                        </tr>
                        
                        <tr>
                            <td width="40%">
                                <label for="barbiturate">Barbiturate (BAR)</label>
                            </td>
                            <td>
                                <input type="text" id="barbiturate" name="barbiturate" class="form-control"
                                       
                                       value="<?php echo set_value ( 'anti-depressant', !empty( $lab_investigation ) ? $lab_investigation -> barbiturate : 'Negative' ) ?>">
                            </td>
                        </tr>
                        
                        <tr>
                            <td width="40%">
                                <label for="cocaine">Cocaine (COC)</label>
                            </td>
                            <td>
                                <input type="text" id="cocaine" name="cocaine" class="form-control"
                                       
                                       value="<?php echo set_value ( 'cocaine', !empty( $lab_investigation ) ? $lab_investigation -> cocaine : 'Negative' ) ?>">
                            </td>
                        </tr>
                        
                        <tr>
                            <td width="40%">
                                <label for="methadone">Methadone (MTD)</label>
                            </td>
                            <td>
                                <input type="text" id="methadone" name="methadone" class="form-control"
                                       
                                       value="<?php echo set_value ( 'methadone', !empty( $lab_investigation ) ? $lab_investigation -> methadone : 'Negative' ) ?>">
                            </td>
                        </tr>
                        
                        <tr>
                            <td width="40%">
                                <label for="phencyclidine">Phencyclidine (PCP)</label>
                            </td>
                            <td>
                                <input type="text" id="phencyclidine" name="phencyclidine" class="form-control"
                                       
                                       value="<?php echo set_value ( 'phencyclidine', !empty( $lab_investigation ) ? $lab_investigation -> phencyclidine : 'Negative' ) ?>">
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                            <th colspan="2" style="font-size: 14pt">
                                X-RAY CHEST
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td width="40%">
                                <label for="x-ray-chest">X-RAY CHEST (P/A VIEW)</label>
                            </td>
                            <td>
                                <input type="text" id="x-ray-chest" name="x-ray-chest" class="form-control"
                                       autofocus="autofocus"
                                       
                                       value="<?php echo set_value ( 'x-ray-chest', !empty( $lab_investigation ) ? $lab_investigation -> x_ray_chest : 'Normal' ) ?>">
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
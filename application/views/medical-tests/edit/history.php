<div class="tab-pane fade <?php echo $this -> input -> get ( 'tab' ) === 'history' ? 'active in' : '' ?>">
    <form role="form" method="post"
          action="<?php echo base_url ( '/medical-tests/upsert-history/' . $test -> id ) ?>"
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
                                HISTORY OF CANDIDATE
                            </th>
                        </tr>
                        <tr>
                            <th align="left">
                                (About any Present of Pass illness)
                            </th>
                            <th align="left">
                                Result
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td width="40%">Tuberculosis</td>
                            <td>
                                <div class="radio-list">
                                    <label class="radio-inline">
                                        <input type="radio" name="tuberculosis"
                                               value="1" <?php echo ( !empty( $history ) && $history -> tuberculosis === '1' ) ? 'checked="checked"' : '' ?>>
                                        Yes
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="tuberculosis"
                                               value="0" <?php if ( !empty( $history ) && $history -> tuberculosis === '0' ) echo 'checked="checked"'; else if ( empty( $history ) ) echo 'checked="checked"' ?>>
                                        No
                                    </label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Asthma</td>
                            <td>
                                <div class="radio-list">
                                    <label class="radio-inline">
                                        <input type="radio" name="asthma"
                                               value="1" <?php echo ( !empty( $history ) && $history -> asthma === '1' ) ? 'checked="checked"' : '' ?>>
                                        Yes
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="asthma"
                                               value="0" <?php if ( !empty( $history ) && $history -> asthma === '0' ) echo 'checked="checked"'; else if ( empty( $history ) ) echo 'checked="checked"' ?>>
                                        No
                                    </label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Typhoid Fever</td>
                            <td>
                                <div class="radio-list">
                                    <label class="radio-inline">
                                        <input type="radio" name="typhoid_fever"
                                               value="1" <?php echo ( !empty( $history ) && $history -> typhoid_fever === '1' ) ? 'checked="checked"' : '' ?>>
                                        Yes
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="typhoid_fever"
                                               value="0" <?php if ( !empty( $history ) && $history -> typhoid_fever === '0' ) echo 'checked="checked"'; else if ( empty( $history ) ) echo 'checked="checked"' ?>>
                                        No
                                    </label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Ulcer</td>
                            <td>
                                <div class="radio-list">
                                    <label class="radio-inline">
                                        <input type="radio" name="ulcer"
                                               value="1" <?php echo ( !empty( $history ) && $history -> ulcer === '1' ) ? 'checked="checked"' : '' ?>>
                                        Yes
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="ulcer"
                                               value="0" <?php if ( !empty( $history ) && $history -> ulcer === '0' ) echo 'checked="checked"'; else if ( empty( $history ) ) echo 'checked="checked"' ?>>
                                        No
                                    </label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Malaria</td>
                            <td>
                                <div class="radio-list">
                                    <label class="radio-inline">
                                        <input type="radio" name="malaria"
                                               value="1" <?php echo ( !empty( $history ) && $history -> malaria === '1' ) ? 'checked="checked"' : '' ?>>
                                        Yes
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="malaria"
                                               value="0" <?php if ( !empty( $history ) && $history -> malaria === '0' ) echo 'checked="checked"'; else if ( empty( $history ) ) echo 'checked="checked"' ?>>
                                        No
                                    </label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Surgical Procedure</td>
                            <td>
                                <div class="radio-list">
                                    <label class="radio-inline">
                                        <input type="radio" name="surgical_procedure"
                                               value="1" <?php echo ( !empty( $history ) && $history -> surgical_procedure === '1' ) ? 'checked="checked"' : '' ?>>
                                        Yes
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="surgical_procedure"
                                               value="0" <?php if ( !empty( $history ) && $history -> surgical_procedure === '0' ) echo 'checked="checked"'; else if ( empty( $history ) ) echo 'checked="checked"' ?>>
                                        No
                                    </label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>(Psychiatric / Neurology Disorders)</td>
                            <td>
                                <div class="radio-list">
                                    <label class="radio-inline">
                                        <input type="radio" name="psychiatric_neurology_disorders"
                                               value="1" <?php echo ( !empty( $history ) && $history -> psychiatric_neurology_disorders === '1' ) ? 'checked="checked"' : '' ?>>
                                        Yes
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="psychiatric_neurology_disorders" value="0"
                                            <?php if ( !empty( $history ) && $history -> psychiatric_neurology_disorders === '0' ) echo 'checked="checked"'; else if ( empty( $history ) ) echo 'checked="checked"' ?>>
                                        No
                                    </label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Allergy</td>
                            <td>
                                <div class="radio-list">
                                    <label class="radio-inline">
                                        <input type="radio" name="allergy"
                                               value="1" <?php echo ( !empty( $history ) && $history -> allergy === '1' ) ? 'checked="checked"' : '' ?>>
                                        Yes
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="allergy"
                                               value="0" <?php if ( !empty( $history ) && $history -> allergy === '0' ) echo 'checked="checked"'; else if ( empty( $history ) ) echo 'checked="checked"' ?>>
                                        No
                                    </label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Diabetes</td>
                            <td>
                                <div class="radio-list">
                                    <label class="radio-inline">
                                        <input type="radio" name="diabetes"
                                               value="1" <?php echo ( !empty( $history ) && $history -> diabetes === '1' ) ? 'checked="checked"' : '' ?>>
                                        Yes
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="diabetes"
                                               value="0" <?php if ( !empty( $history ) && $history -> diabetes === '0' ) echo 'checked="checked"'; else if ( empty( $history ) ) echo 'checked="checked"' ?>>
                                        No
                                    </label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Others</td>
                            <td>
                                <div class="radio-list">
                                    <label>
                                        <input type="text" name="others" class="form-control"
                                               value="<?php echo !empty( $history ) ? $history -> others : 'No' ?>">
                                    </label>
                                </div>
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
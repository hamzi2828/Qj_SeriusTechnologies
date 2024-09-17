<div class="tab-pane fade <?php echo $this->input->get('tab') === 'lab-investigation-custom' ? 'active in' : '' ?>">
<form role="form" method="post"
          action="<?php echo base_url ( '/medical-tests/add-lab-investigation/' . $test -> id ) ?>"
          autocomplete="off">

    <!-- CSRF token is stored in a hidden input -->
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" 
           value="<?php echo $this->security->get_csrf_hash(); ?>" id="csrf_token">

           <!-- Hidden input to indicate the form is custom -->
        <input type="hidden" name="is_custom" value="1">

        <!-- Hidden input to hold the selected template_id -->
<input type="hidden" name="selected_template_id" id="selected_template_id" value="">


    <select name="template_id" id="template_id" class="form-control select2me" onchange="submitTemplate()">
        <option value="">Select a Template</option>
        <?php if (!empty($templates)) : ?>
            <?php foreach ($templates as $template) : ?>
                <option value="<?php echo $template->id; ?>">
                    <?php echo $template->template_name; ?>
                </option>
            <?php endforeach; ?>
        <?php else : ?>
            <option value="">No templates available</option>
        <?php endif; ?>
    </select>

    <div class="form-body" style="background: transparent;">
        <h3>
            <input placeholder="Template Name" type="text" name="template_name" class="form-control" id="template_name" value="No template selected yet" readonly>
        </h3>

        <!-- Section 1 -->
        <div class="row">
            <div class="col-md-12">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th colspan="2">
                                <input type="text" name="header_name_1" class="form-control" id="header_name_1" placeholder="Header Name 1" value="No template selected yet" readonly>
                            </th>
                            <th style="text-align: right;">
                                <button type="button" class="btn btn-success btn-custom" id="addRowButton1" disabled>+</button>
                            </th>
                        </tr>
                    </thead>
                    <tbody id="tableBody1">
                        <tr>
                            <td colspan="4">No template selected yet</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Section 2 -->
        <div class="row">
            <div class="col-md-12">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th colspan="2">
                                <input type="text" name="header_name_2" class="form-control" id="header_name_2" placeholder="Header Name 2" value="No template selected yet" readonly>
                            </th>
                            <th style="text-align: right;">
                                <button type="button" class="btn btn-success btn-custom" id="addRowButton2" disabled>+</button>
                            </th>
                        </tr>
                    </thead>
                    <tbody id="tableBody2">
                        <tr>
                            <td colspan="4">No template selected yet</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Section 3 -->
        <div class="row">
            <div class="col-md-12">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th colspan="2">
                                <input type="text" name="header_name_3" class="form-control" id="header_name_3" placeholder="Header Name 3" value="No template selected yet" readonly>
                            </th>
                            <th style="text-align: right;">
                                <button type="button" class="btn btn-success btn-custom" id="addRowButton3" disabled>+</button>
                            </th>
                        </tr>
                    </thead>
                    <tbody id="tableBody3">
                        <tr>
                            <td colspan="4">No template selected yet</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Section 4 -->
        <div class="row">
            <div class="col-md-12">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th colspan="2">
                                <input type="text" name="header_name_4" class="form-control" id="header_name_4" placeholder="Header Name 4" value="No template selected yet" readonly>
                            </th>
                            <th style="text-align: right;">
                                <button type="button" class="btn btn-success btn-custom" id="addRowButton4" disabled>+</button>
                            </th>
                        </tr>
                    </thead>
                    <tbody id="tableBody4">
                        <tr>
                            <td colspan="4">No template selected yet</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Section 5 -->
        <div class="row">
            <div class="col-md-12">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th colspan="2">
                                <input type="text" name="header_name_5" class="form-control" id="header_name_5" placeholder="Header Name 5" value="No template selected yet" readonly>
                            </th>
                            <th style="text-align: right;">
                                <button type="button" class="btn btn-success btn-custom" id="addRowButton5" disabled>+</button>
                            </th>
                        </tr>
                    </thead>
                    <tbody id="tableBody5">
                        <tr>
                            <td colspan="4">No template selected yet</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Section 6 -->
        <div class="row">
            <div class="col-md-12">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th colspan="2">
                                <input type="text" name="header_name_6" class="form-control" id="header_name_6" placeholder="Header Name 6" value="No template selected yet" readonly>
                            </th>
                            <th style="text-align: right;">
                                <button type="button" class="btn btn-success btn-custom" id="addRowButton6" disabled>+</button>
                            </th>
                        </tr>
                    </thead>
                    <tbody id="tableBody6">
                        <tr>
                            <td colspan="4">No template selected yet</td>
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

<script>
    function submitTemplate() {
        const templateId = document.getElementById('template_id').value;
        const csrfToken = document.getElementById('csrf_token').value;
          // Set the selected template ID to the hidden input field
        document.getElementById('selected_template_id').value = templateId;

        if (templateId) {
            $.ajax({
                url: "<?php echo base_url('MedicalTests/get_template'); ?>",
                type: "POST",
                data: {
                    template_id: templateId,
                    '<?php echo $this->security->get_csrf_token_name(); ?>': csrfToken
                },
                success: function(response) {
                    const result = JSON.parse(response);

                    if (result.status === 'success') {

                        // Populate the template fields with data from the response
                        $('#template_name').val(result.template.template_name);
                        $('#header_name_1').val(result.template.header_name_1);
                        $('#header_name_2').val(result.template.header_name_2);
                        $('#header_name_3').val(result.template.header_name_3);
                        $('#header_name_4').val(result.template.header_name_4);
                        $('#header_name_5').val(result.template.header_name_5);
                        $('#header_name_6').val(result.template.header_name_6);

                        // Enable buttons
                        $('#addRowButton1, #addRowButton2, #addRowButton3, #addRowButton4, #addRowButton5, #addRowButton6').prop('disabled', false);

                        // Clear previous rows
                        $('#tableBody1, #tableBody2, #tableBody3, #tableBody4, #tableBody5, #tableBody6').html('');

                        // Populate rows based on header_id
                        result.template_rows.forEach(row => {
                            const rowHtml = `
                                <tr>
                                    <td></td>
                                    <td><input type="text" name="row_name_${row.header_id}[]" class="form-control" value="${row.row_name}" placeholder="Name"></td>
                                    <td><input type="text" name="row_value_${row.header_id}[]" class="form-control row-value" value="${row.row_value_1}" placeholder="Value"></td>
                                    <td style="text-align: right;">
                                        <button type="button" class="btn btn-danger btn-custom removeRowButton">-</button>
                                    </td>
                                </tr>
                            `;

                            // Append row to the correct table body based on header_id
                            $(`#tableBody${row.header_id}`).append(rowHtml);
                        });

                        // Update row numbering
                        updateRowNumbers();
                    } else {
                        alert('Error: ' + result.message);
                    }
                },
                error: function(xhr, status, error) {
                    alert('An error occurred while processing the request.');
                    console.error('Error details:', error);
                }
            });
        } else {
            alert('Please select a template.');
        }
    }
    // Function to update row numbers after rows are added
    function updateRowNumbers() {
        for (let i = 1; i <= 6; i++) {
            $(`#tableBody${i} tr`).each(function (index) {
                $(this).find('td:first').text(index + 1);
            });
        }
    }

</script>

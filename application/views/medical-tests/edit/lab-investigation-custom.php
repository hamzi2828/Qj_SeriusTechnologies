<div class="tab-pane fade <?php echo $this->input->get('tab') === 'lab-investigation-custom' ? 'active in' : '' ?>">
    <div class="form-body" style="background: transparent;">

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

             <!-- Check if template_rows is not empty, if true disable the select dropdown -->
             <select name="template_id" id="template_id" class="form-control select2me" onchange="submitTemplate()" 
                    <?php echo !empty($template_rows) ? 'disabled' : ''; ?>>
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
            
            <div id="dynamic-template-data">
                <?php 
                // Check if template_rows exists, is an array, and no template is selected
                if (!empty($template_rows) && is_array($template_rows)) :
                    // Group rows by headings
                    $groupedRows = [];
                    foreach ($template_rows as $row) {
                        $groupedRows[$row->header_name][] = $row;
                    }

                    // Iterate through each group and dynamically generate sections
                    $sectionNumber = 1;
                    foreach ($groupedRows as $header => $rows) : 
                ?>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                    <th><strong>Tittle</strong></th>
                                        <th colspan="2">
                                            <input type="text" name="header_name_<?php echo $sectionNumber; ?>" class="form-control" 
                                                   id="header_name_<?php echo $sectionNumber; ?>" 
                                                   placeholder="Header Name <?php echo $sectionNumber; ?>" 
                                                   value="<?php echo $header; ?>" readonly>
                                        </th>
                                       
                                    </tr>
                                </thead>
                                <tbody id="tableBody<?php echo $sectionNumber; ?>">
                                    <?php foreach ($rows as $index => $row) : ?>
                                        <tr>
                                            <td><?php echo $index + 1; ?></td>
                                            <td>
                                                <input type="text" name="row_name_<?php echo $sectionNumber; ?>[]" class="form-control" value="<?php echo $row->row_name; ?>" placeholder="Name">
                                            </td>
                                            <td>
                                                <input type="text" name="row_value_<?php echo $sectionNumber; ?>[]" class="form-control row-value" value="<?php echo $row->row_value; ?>" placeholder="Value">
                                            </td>
                                          
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php 
                    $sectionNumber++;
                    endforeach;
                else :
                ?>
                    <p>No template data available.</p>
                <?php 
                endif; 
                ?>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn blue">Submit</button>
            </div>
        </form>
    </div>
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
                        // Clear current template data section
                        $('#dynamic-template-data').html('');

                        // Dynamically generate the sections based on the response
                        let sectionNumber = 1;
                        let groupedRows = {};

                        // Group rows by header_name based on header_id
                        result.template_rows.forEach(row => {
                            const header = result.template[`header_name_${row.header_id}`];
                            if (!groupedRows[header]) {
                                groupedRows[header] = [];
                            }
                            groupedRows[header].push(row);
                        });

                        // Create sections dynamically
                        for (const [header, rows] of Object.entries(groupedRows)) {
                            let sectionHtml = `
                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="table table-striped table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th colspan="2">
                                                        <input type="text" name="header_name_${sectionNumber}" class="form-control" 
                                                               id="header_name_${sectionNumber}" 
                                                               placeholder="Header Name ${sectionNumber}" 
                                                               value="${header}" readonly>
                                                    </th>
                                                 
                                                </tr>
                                            </thead>
                                            <tbody id="tableBody${sectionNumber}">`;

                            // Add rows for each header section
                            rows.forEach((row, index) => {
                                sectionHtml += `
                                    <tr>
                                        <td>${index + 1}</td>
                                        <td><input type="text" name="row_name_${sectionNumber}[]" class="form-control" value="${row.row_name}" placeholder="Name"></td>
                                        <td><input type="text" name="row_value_${sectionNumber}[]" class="form-control row-value" value="${row.row_value_1}" placeholder="Value"></td>
                                       
                                    </tr>`;
                            });

                            sectionHtml += `</tbody></table></div></div>`;

                            // Append the generated section HTML to the container
                            $('#dynamic-template-data').append(sectionHtml);
                            sectionNumber++;
                        }

                        // Update row numbering after new rows are added
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

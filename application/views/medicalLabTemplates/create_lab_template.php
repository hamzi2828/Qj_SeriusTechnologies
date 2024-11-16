<style>
        .value-container {
            display: flex;
            align-items: center;
        }

        .value-container input {
            flex: 1;
            margin-right: 5px;
        }

        .removeValueButton {
            background-color: red;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 3px;
            cursor: pointer;
        }

        .addValueButton {
            background-color: #6c757d;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 3px;
            cursor: pointer;
        }
   
        .btn-custom {
            font-size: 18px; 
            padding: 10px 15px; 
            margin: 0;
        }
</style>

<!-- Display Validation Errors -->
<?php if (validation_errors()) : ?>
    <div class="alert alert-danger validation-errors">
        <strong>Error:</strong> Please correct the following issues:
        <ul>
            <?php echo validation_errors('<li>', '</li>'); ?>
        </ul>
    </div>
<?php endif; ?>

<!-- Display Error Messages -->
<?php if ($this->session->flashdata('error')) : ?>
    <div class="alert alert-danger">
        <strong>Error:</strong> <?php echo $this->session->flashdata('error'); ?>
    </div>
<?php endif; ?>

<!-- Display Success Response Messages -->
<?php if ($this->session->flashdata('response')) : ?>
    <div class="alert alert-success">
        <strong>Success:</strong> <?php echo $this->session->flashdata('response'); ?>
    </div>
<?php endif; ?>


<div class="container mt-4">
    <form action="<?php echo base_url ( '/medical-test-settings/template/create' ) ?>" method="post" id="templateForm">
        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
      

        <div class="form-body" style="background: transparent;">
            <h3>
                <input placeholder="Template Name" type="text" name="template_name" class="form-control" autofocus="autofocus" required>
            </h3>

            <!-- Section 1 -->
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                            <th><strong>Tittle: 1</strong></th>
                                <th colspan="2">
                                    <input type="text" name="header_name_1" class="form-control" placeholder="Header Name 1">
                                </th>
                                <th style="text-align: right;">
                                    <button type="button" class="btn btn-success btn-custom" id="addRowButton">+</button>
                                </th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                            <!-- Rows will be added here -->
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
                            <th><strong>Tittle: 2</strong></th>
                                <th colspan="2">
                                    <input type="text" name="header_name_2" class="form-control" placeholder="Header Name 2">
                                </th>
                                <th style="text-align: right;">
                                    <button type="button" class="btn btn-success btn-custom" id="addRowButton2">+</button>
                                </th>
                            </tr>
                        </thead>
                        <tbody id="tableBody2">
                            <!-- Rows will be added here -->
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
                            <th><strong>Tittle: 3</strong></th>
                                <th colspan="2">
                                    <input type="text" name="header_name_3" class="form-control" placeholder="Header Name 3">
                                </th>
                                <th style="text-align: right;">
                                    <button type="button" class="btn btn-success btn-custom" id="addRowButton3">+</button>
                                </th>
                            </tr>
                        </thead>
                        <tbody id="tableBody3">
                            <!-- Rows will be added here -->
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
                            <th><strong>Tittle: 4</strong></th>
                                <th colspan="2">
                                    <input type="text" name="header_name_4" class="form-control" placeholder="Header Name 4">
                                </th>
                                <th style="text-align: right;">
                                    <button type="button" class="btn btn-success btn-custom" id="addRowButton4">+</button>
                                </th>
                            </tr>
                        </thead>
                        <tbody id="tableBody4">
                            <!-- Rows will be added here -->
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
                            <th><strong>Tittle: 5</strong></th>
                                <th colspan="2">
                                    <input type="text" name="header_name_5" class="form-control" placeholder="Header Name 5">
                                </th>
                                <th style="text-align: right;">
                                    <button type="button" class="btn btn-success btn-custom" id="addRowButton5">+</button>
                                </th>
                            </tr>
                        </thead>
                        <tbody id="tableBody5">
                            <!-- Rows will be added here -->
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
                            <th><strong>Tittle: 6</strong></th>
                                <th colspan="2">
                                    <input type="text" name="header_name_6" class="form-control" placeholder="Header Name 6">
                                </th>
                                <th style="text-align: right;">
                                    <button type="button" class="btn btn-success btn-custom" id="addRowButton6">+</button>
                                </th>
                            </tr>
                        </thead>
                        <tbody id="tableBody6">
                            <!-- Rows will be added here -->
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="form-actions mt-4">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>
</div>


<script>
    // Function to update row numbers
    function updateRowNumbers(section) {
        var rows = document.querySelectorAll(`#${section} tr`);
        rows.forEach(function (row, index) {
            row.querySelector('td').textContent = index + 1;
        });
    }

    // Add row button event listeners for each section
    document.getElementById('addRowButton').addEventListener('click', function () {
        addRow('tableBody', 'row_name_1[]', 'row_value_1[]');
    });

    document.getElementById('addRowButton2').addEventListener('click', function () {
        addRow('tableBody2', 'row_name_2[]', 'row_value_2[]');
    });

    document.getElementById('addRowButton3').addEventListener('click', function () {
        addRow('tableBody3', 'row_name_3[]', 'row_value_3[]', 4);
    });

    document.getElementById('addRowButton4').addEventListener('click', function () {
        addRow('tableBody4', 'row_name_4[]', 'row_value_4[]', 2);
    });

    document.getElementById('addRowButton5').addEventListener('click', function () {
        addRow('tableBody5', 'row_name_5[]', 'row_value_5[]', 9);
    });

    document.getElementById('addRowButton6').addEventListener('click', function () {
        addRow('tableBody6', 'row_name_6[]', 'row_value_6[]', 1);
    });

    // General function to add a row in a table section
    function addRow(tableBodyId, rowName, rowValue, maxRows = 100) {
        var tableBody = document.getElementById(tableBodyId);
        var rows = tableBody.getElementsByTagName('tr');

        if (rows.length < maxRows) {
            var newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td></td>
                <td>
                    <input type="text" name="${rowName}" class="form-control" placeholder="Name">
                </td>
                <td>
                    <input type="text" name="${rowValue}" class="form-control row-value" placeholder="Value">
                </td>
                <td style="text-align: right;">
                    <button type="button" class="btn btn-danger btn-custom removeRowButton">-</button>
                </td>
            `;
            tableBody.appendChild(newRow);
            updateRowNumbers(tableBodyId);
        } else {
            alert(`Maximum of ${maxRows} rows allowed.`);
        }
    }

    // Handle dynamically added buttons and inputs
    document.addEventListener('click', function (event) {
        if (event.target.classList.contains('removeRowButton')) {
            var row = event.target.closest('tr');
            var tableBodyId = row.closest('tbody').id;
            row.remove();
            updateRowNumbers(tableBodyId);
        }
    });
</script>

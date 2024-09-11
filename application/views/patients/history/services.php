<div class="tab-pane <?php if(isset($current_tab) and $current_tab == 'services') echo 'active' ?>">
    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th> Sr. No </th>
            <th> Patient EMR </th>
            <th> Patient Name </th>
            <th> Services </th>
            <th> Prices </th>
            <th> Discounts </th>
            <th> Net Price </th>
            <th> Net Discount </th>
            <th> Net Total </th>
            <th> Date Added </th>
        </tr>
        </thead>
        <tbody>
		<?php
		if(count($services) > 0) {
			$counter = 1;
			$total = 0;
			foreach ($services as $service) {
				$patient = get_patient($service -> patient_id);
				$service_net = get_opd_sale($service -> sale_id);
				$total = $total + $service_net -> net;
				?>
                <tr class="odd gradeX">
                    <td> <?php echo $counter++ ?> </td>
                    <td><?php echo $patient -> id ?></td>
                    <td><?php echo $patient -> name ?></td>
                    <td>
						<?php
						$services_info = explode(',', $service -> services);
						if(count($services_info) > 0) {
							foreach ($services_info as $key => $value) {
								$service_details = get_service_by_id($value);
								echo $service_details -> title . '<br>';
							}
						}
						?>
                    </td>
                    <td>
						<?php
						$prices = explode(',', $service -> prices);
						if(count($prices) > 0) {
							foreach ($prices as $price) {
								echo $price . '<br>';
							}
						}
						?>
                    </td>
                    <td>
						<?php
						$discounts = explode(',', $service -> discounts);
						if(count($discounts) > 0) {
							foreach ($discounts as $discount) {
								echo $discount . '<br>';
							}
						}
						?>
                    </td>
                    <td>
						<?php
						$net_prices = explode(',', $service -> net_prices);
						if(count($net_prices) > 0) {
							foreach ($net_prices as $net_price) {
								echo $net_price . '<br>';
							}
						}
						?>
                    </td>
                    <td>
                        <?php echo $service_net -> discount ?>
                    </td>
                    <td>
                        <?php echo $service_net -> net ?>
                    </td>
                    <td><?php echo date_setter($service -> date_added) ?></td>
                </tr>
				<?php
			}
			?>
                <tr>
                    <td colspan="8"></td>
                    <td>
                        <strong><?php echo $total ?></strong>
                    </td>
                    <td></td>
                </tr>
        <?php
		}
		?>
        </tbody>
    </table>
</div>
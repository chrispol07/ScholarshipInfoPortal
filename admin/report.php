<?php $event_id = isset($_GET['id']) ? $_GET['id'] : ''; ?>

<div class="col-lg-12">
	<div class="callout callout-info">
		<div class="d-flex w-100 justify-content-center align-items-center">
			<label for="events">Select Events</label>
			<div class=" mx-2 col-md-4">
				<select name="" id="event_id" class="form-control form-control-sm select2">
					<option value=""></option>
					<?php
					$events = $conn->query("SELECT * FROM event_list");
					$events_list = array();
					$event_names = array();
					while ($row = $events->fetch_assoc()) :
						$events_list[$row['id']] = $row;
						$org_name[$row['id']] = $row['title'];
					?>
						<option value="<?php echo $row['id'] ?>" <?php echo isset($event_id) && $event_id == $row['id'] ? "selected" : "" ?>><?php echo ucwords($row['title']) ?></option>
					<?php endwhile; ?>
				</select>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12 mb-1">
			<div class="d-flex justify-content-end w-100">
				<button class="btn btn-sm btn-success bg-gradient-success" style="display:none" id="print-btn"><i class="fa fa-print"></i> Print</button>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="callout callout-info" id="printable">
				<div>
					<h3 class="text-center">Evaluation Report</h3>
					<hr>
					<table width="100%">
						<tr>
							<td width="100%">
								<p><b>Event Title: <span id="event_title"></span></b></p>
							</td>							
						</tr>
					</table>
					<p class=""><b>Total Student Evaluated: <span id="tse"></span></b></p>
				</div>
				<fieldset class="border border-info p-2 w-100">
					<legend class="w-auto">Rating Legend</legend>
					<p>5 = Strongly Agree, 4 = Agree, 3 = Uncertain, 2 = Disagree, 1 = Strongly Disagree</p>
				</fieldset>
				<?php
					$q_arr = array();

					if(array_key_exists($event_id,$events_list)) :
						$criteria = $conn->query("SELECT * FROM criteria_list where id in (SELECT criteria_id FROM question_list where event_id = {$event_id} ) order by abs(order_by) asc ");
						while ($crow = $criteria->fetch_assoc()) : ?>
						<table class="table table-condensed wborder">
							<thead>
								<tr class="bg-gradient-secondary">
									<th class=" p-1"><b><?php echo $crow['criteria'] ?></b></th>
									<th width="5%" class="text-center">1</th>
									<th width="5%" class="text-center">2</th>
									<th width="5%" class="text-center">3</th>
									<th width="5%" class="text-center">4</th>
									<th width="5%" class="text-center">5</th>
								</tr>
							</thead>
							<tbody class="tr-sortable">
								<?php
								$questions = $conn->query("SELECT * FROM question_list where criteria_id = {$crow['id']} and event_id = {$event_id} order by abs(order_by) asc ");
								while ($row = $questions->fetch_assoc()) :
									$q_arr[$row['id']] = $row;
								?>
									<tr class="bg-white">
										<td class="p-1" width="40%">
											<?php echo $row['question'] ?>
										</td>
										<?php for ($c = 1; $c <= 5; $c++) : ?>
											<td class="text-center">
												<span class="rate_<?php echo $c . '_' . $row['id'] ?> rates"></span>
											</div>
										</td>
		<?php endfor; ?>
		</tr>
	<?php endwhile; ?>
	</tbody>
	</table>
<?php endwhile;?>
<?php endif;?>

		</div>
	</div>
</div>
</div>
<style>
	.list-group-item:hover {
		color: black !important;
		font-weight: 700 !important;
	}
</style>
<noscript>
	<style>
		table {
			width: 100%;
			border-collapse: collapse;
		}

		table.wborder tr,
		table.wborder td,
		table.wborder th {
			border: 1px solid gray;
			padding: 3px
		}

		table.wborder thead tr {
			background: #6c757d linear-gradient(180deg, #828a91, #6c757d) repeat-x !important;
			color: #fff;
		}

		.text-center {
			text-align: center;
		}

		.text-right {
			text-align: right;
		}

		.text-left {
			text-align: left;
		}
	</style>
</noscript>
<script>
	$(document).ready(function() {

		$('#event_id').change(function() {
			if ($(this).val() > 0) {
				location.href ='./index.php?page=report&id=' + $(this).val();
			}
		})
		if ($('#event_id').val() > 0) {
			load_eval()
		}
	})

	function load_eval() {
		// start_load()
		var event_list = <?php echo json_encode($events_list) ?>;
		$('#event_title').text(event_list[$('#event_id').val()]['title'])
		console.log(event_list);
		load_report($('#event_id').val())
	}


	function load_report($event_id) {
		if ($('#preloader2').length <= 0)
			start_load()
		$.ajax({
			url: 'ajax.php?action=get_report',
			method: "POST",
			data: {
				event_id: $event_id
			},
			error: function(err) {
				console.log(err)
				alert_toast("An Error Occured.", "error");
				end_load()
			},
			success: function(resp) {
				if (resp) {
					resp = JSON.parse(resp)
					if (Object.keys(resp).length <= 0) {
						$('.rates').text('')
						$('#tse').text('')
						$('#print-btn').hide()
					} else {
						$('#print-btn').show()
						$('#tse').text(resp.tse)
						$('.rates').text('-')
						var data = resp.data
						Object.keys(data).map(q => {
							Object.keys(data[q]).map(r => {
								console.log($('.rate_' + r + '_' + q), data[q][r])
								$('.rate_' + r + '_' + q).text(data[q][r] + '%')
							})
						})
					}

				}
			},
			complete: function() {
				end_load()
			}
		})
	}
	$('#print-btn').click(function() {
		start_load()
		var ns = $('noscript').clone()
		var content = $('#printable').html()
		ns.append(content)
		var nw = window.open("Report", "_blank", "width=900,height=700")
		nw.document.write(ns.html())
		nw.document.close()
		nw.print()
		setTimeout(function() {
			nw.close()
			end_load()
		}, 750)
	})
</script>
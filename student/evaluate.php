<?php


$events_list = $conn->query("SELECT * FROM event_list");
$org_list = $conn->query("SELECT * FROM org_list")->fetch_array();
$events = array();
while ($row = $events_list->fetch_assoc()) {
	$restriction = $conn->query("SELECT * FROM restriction_list where event_id = {$row['id']}");
	while ($row2 = $restriction->fetch_assoc()) {
		if ($row2['org'] != 0 && $row2['org'] != $_SESSION['login_org_id']) {
			continue;
		}
		if ($row2['year'] != 0 && $row2['year'] != $_SESSION['login_year']) {
			continue;
		}
		if ($row2['course'] != 0 && $row2['course'] != $_SESSION['login_course_id']) {
			continue;
		}
		if (!in_array($row, $events)) {
			$student_verify = $conn->query("SELECT * FROM `evaluation_list` WHERE `student_id` = {$_SESSION['login_school_id']} AND `event_id` = {$row['id']}")->num_rows;
			if (empty($student_verify)) {
				$row['org'] = $row2['org'];
				$events[] = $row;
			}
		}
	}
}
if (isset($_GET['id']))
	$event_id = $_GET['id'];
else
	$event_id = 0;
?>

<div class="col-lg-12">
	<div class="row">
		<div class="col-md-3">
			<div class="list-group">
				<?php
				$i = 0;
				while ($i < count($events)) :
				?>
					<a class="list-group-item list-group-item-action <?php echo isset($event_id) && $event_id == $i ? 'active' : '' ?>" href="./index.php?page=evaluate&id=<?php echo $i ?>"><?php echo $events[$i]['title'] ?></a>
				<?php $i++;
				endwhile; ?>
			</div>
		</div>
		<div class="col-md-9">
			<?php
			if ((empty($events) ? 1 : 0) == 0) :
			
			$event_title = $events[$event_id]['title'];
			$event_description = $events[$event_id]['description'];
			$event_org = ($events[$event_id]['org'] == 0 ? 'Admission of Scholarship Office' : $org_list[$events[$event_id]['org']]);
			?>
			<div class="card card-outline card-info">
				<div class="card-header">
					<b>Evaluation </b>
					<div class="card-tools">
						<button class="btn btn-sm btn-flat btn-primary bg-gradient-primary mx-1" form="manage-evaluation">Submit Evaluation</button>
					</div>
				</div>
				<div class="card-body">
					<fieldset class="px-2 w-100 g-0">
						<legend class="w-auto"><?php echo $event_title ?></legend>
						<p class="m-0"><span class="fw-bolder">Description:</span> <?php echo $event_description ?></p>
						<p>Organized by <?php echo $event_org ?></p>
					</fieldset>
					<fieldset class="border border-info p-2 w-100">
						<legend class="w-auto">Rating Legend</legend>
						<p>5 = Strongly Agree, 4 = Agree, 3 = Uncertain, 2 = Disagree, 1 = Strongly Disagree</p>
					</fieldset>
					<form id="manage-evaluation">
						<input type="hidden" name="student_id" value="<?php echo $_SESSION['login_school_id'] ?>">
						<input type="hidden" name="event_id" value="<?php echo $events[$event_id]['id'] ?>">
						<div class="clear-fix mt-2"></div>
						<?php
						$q_arr = array();
						$criteria = $conn->query("SELECT * FROM criteria_list where id in (SELECT criteria_id FROM question_list where event_id = {$events[$event_id]['id']} ) order by abs(order_by) asc ");
						while ($crow = $criteria->fetch_assoc()) :
						?>
							<table class="table table-condensed">
								<thead>
									<tr class="bg-gradient-secondary">
										<th class=" p-1"><b><?php echo $crow['criteria'] ?></b></th>
										<th class="text-center">1</th>
										<th class="text-center">2</th>
										<th class="text-center">3</th>
										<th class="text-center">4</th>
										<th class="text-center">5</th>
									</tr>
								</thead>
								<tbody class="tr-sortable">
									<?php
									$questions = $conn->query("SELECT * FROM question_list where criteria_id = {$crow['id']} and event_id = {$events[$event_id]['id']} order by abs(order_by) asc ");
									while ($row = $questions->fetch_assoc()) :
										$q_arr[$row['id']] = $row;
									?>
										<tr class="bg-white">
											<td class="p-1" width="40%">
												<?php echo $row['question'] ?>
												<input type="hidden" name="qid[]" value="<?php echo $row['id'] ?>">
											</td>
											<?php for ($c = 1; $c <= 5; $c++) : ?>
												<td class="text-center">
													<div class="icheck-success d-inline">
														<input type="radio" name="rate[<?php echo $row['id'] ?>]" <?php echo $c == 5 ? "checked" : '' ?> id="qradio<?php echo $row['id'] . '_' . $c ?>" value="<?php echo $c ?>">
														<label for="qradio<?php echo $row['id'] . '_' . $c ?>">
														</label>
													</div>
												</td>
											<?php endfor; ?>
										</tr>
									<?php endwhile; ?>
								</tbody>
							</table>
						<?php endwhile; ?>
					</form>
				</div>
			</div>
			<?php endif;?>
		</div>
	</div>
</div>
<script>
	$(document).ready(function() {
		if (<?php echo empty($events) ? 1 : 0 ?> == 1)
			uni_modal("Information", "<?php echo $_SESSION['login_view_folder'] ?>done.php")
	})
	$('#manage-evaluation').submit(function(e) {
		e.preventDefault();
		start_load()
		$.ajax({
			url: 'ajax.php?action=save_evaluation',
			method: 'POST',
			data: $(this).serialize(),
			success: function(resp) {
				if (resp == 1) {
					alert_toast("Data successfully saved.", "success");
					setTimeout(function() {
						location.reload()
					}, 1750)
				}
			}
		})
	})
</script>
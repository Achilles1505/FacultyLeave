<html>
	<head>
		<title>Welcome</title>
		<link rel="stylesheet" href="css/bootstrap.min.css">	
		<link rel="stylesheet" href="css/styles.css">
		<script src="js/jquery.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<style>
			.tabbable-panel {
				border:1px solid #eee;
				padding: 10px;
			}
			.tabbable-line > .nav-tabs {
				border: none;
				margin: 0px;
			}
			.tabbable-line > .nav-tabs > li {
				margin-right: 2px;
			}
			.tabbable-line > .nav-tabs > li > a {
				border: 0;
				margin-right: 0;
				color: #737373;
			}
			.tabbable-line > .nav-tabs > li > a > i {
				color: #a6a6a6;
			}
			.tabbable-line > .nav-tabs > li.open, .tabbable-line > .nav-tabs > li:hover {
				border-bottom: 4px solid #fbcdcf;
			}
			.tabbable-line > .nav-tabs > li.open > a, .tabbable-line > .nav-tabs > li:hover > a {
				border: 0;
				background: none !important;
				color: #333333;
			}
			.tabbable-line > .nav-tabs > li.open > a > i, .tabbable-line > .nav-tabs > li:hover > a > i {
				color: #a6a6a6;
			}
			.tabbable-line > .nav-tabs > li.open .dropdown-menu, .tabbable-line > .nav-tabs > li:hover .dropdown-menu {
				margin-top: 0px;
			}
			.tabbable-line > .nav-tabs > li.active {
				border-bottom: 4px solid #f3565d;
				position: relative;
			}
			.tabbable-line > .nav-tabs > li.active > a {
				border: 0;
				color: #333333;
			}
			.tabbable-line > .nav-tabs > li.active > a > i {
				color: #404040;
			}
			.tabbable-line > .tab-content {
				margin-top: -3px;
				background-color: #fff;
				border: 0;
				border-top: 1px solid #eee;
				padding: 15px 0;
			}
			.portlet .tabbable-line > .tab-content {
				padding-bottom: 0;
			}
			.tabbable-line.tabs-below > .nav-tabs > li {
				border-top: 4px solid transparent;
			}
			.tabbable-line.tabs-below > .nav-tabs > li > a {
				margin-top: 0;
			}
			.tabbable-line.tabs-below > .nav-tabs > li:hover {
				border-bottom: 0;
				border-top: 4px solid #fbcdcf;
			}
			.tabbable-line.tabs-below > .nav-tabs > li.active {
				margin-bottom: -2px;
				border-bottom: 0;
				border-top: 4px solid #f3565d;
			}
			.tabbable-line.tabs-below > .tab-content {
				margin-top: -10px;
				border-top: 0;
				border-bottom: 1px solid #eee;
				padding-bottom: 15px;
			}
			.button{
				background-color: #008CBA;
				border: none;
				color: white;
				padding: 15px 32px;
				text-align: center;
				text-decoration: none;
				display: inline-block;
				font-size: 16px;
			}
			.card {
				box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
				transition: 0.3s;
				display: inline-block;
				padding: 15px 32px;
				
			}
			.table-fixed thead {
				width: 100%;
			}
			.table-fixed tbody {
				height: 230px;
				overflow-y: auto;
				width: 100%;
			}
			.table-fixed thead, .table-fixed tbody, .table-fixed tr, .table-fixed td, .table-fixed th {
				display: block;
			}
			.table-fixed tbody td, .table-fixed thead > tr> th {
				float: left;
				align: left;
				border-bottom-width: 0;
			}
		</style>
	</head>
	<body>
		<?php
			$dbhost = "localhost:3306";
			$dbuser = "root";
			$dbpass = "";
			
			$conn = mysqli_connect($dbhost, $dbuser, $dbpass);
			
			mysqli_select_db($conn, "leave_management");
			
			session_start();
			$user = $_SESSION["user"];
			$tb=1;
			$status=3;
			
		?>
		
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<?php
						$sql = 'SELECT firstname, dept_id FROM faculty_details WHERE fid = '.$user.'';
						$result = mysqli_query($conn, $sql);
						$name = mysqli_fetch_assoc($result);
						echo '<h3>Welcome '.$name["firstname"].'</h3><a href="login.php">Log Out</a>';
						$dept_id = $name["dept_id"];
						$sql = 'SELECT dept_name FROM department WHERE dept_id = '.$dept_id.'';
						$result = mysqli_query($conn, $sql);
						$a = mysqli_fetch_assoc($result);
						$dept_name = $a["dept_name"];
					?>
					<div class="tabbable-panel">
						<div class="tabbable-line">
							<ul class="nav nav-tabs ">
								<li class="active">
									<a href="#tab_default_1" data-toggle="tab">
										Pending Tasks
									</a>
								</li>
								
								<li>
									<a href="#tab_default_5" data-toggle="tab">
										Faculty Leave Record
									</a>
								</li>
								
								<li>
									<a href="#tab_default_6" data-toggle="tab">
										Assign role
									</a>
								</li>
							</ul>
							<div class="tab-content">
								<div class="tab-pane active" id="tab_default_1">
									<br><br>
									<div class="container" style="width: 95%">
										<div class="panel-group" id="accordion">
											<?php
												
												
												
												$sql = 'SELECT app_no FROM pending_tasks WHERE role = "Director" AND complete = FALSE';
												$result = mysqli_query($conn, $sql);
												$i=0; $j=0;
												while($row = mysqli_fetch_assoc($result)){
													if(isset($_POST['approve'.$i.''])){
														
														$sql = 'UPDATE pending_tasks SET complete = TRUE where app_no = '.$row["app_no"].'';
														if(mysqli_query($conn, $sql)){
															echo "Pending Tasks changed successfully";
														}
														else{
															echo "Pending Tasks did not change.";
														}
														
														
													
															$sql = 'UPDATE leave_record SET status = 1 WHERE app_no = '.$row["app_no"].'';
														
														if(mysqli_query($conn, $sql))
															echo "Leave record updated.";
														else
															echo "Could not update leave record.";
														
														$sql = 'SELECT start, end, fid, leave_id FROM leave_record WHERE app_no = '.$row["app_no"].'';
														$result3 = mysqli_query($conn, $sql);
														$dates = mysqli_fetch_assoc($result3);
														$sdate = date_create($dates["start"]);
														$edate = date_create($dates["end"]);
														$today = date_create(date("Y-m-d"));
														
														$diff = date_diff($sdate, $edate);
														$d = $diff->format("%R%a");
														
														$sql = 'SELECT number FROM faculty_leaves WHERE fid = '.$dates["fid"].' AND leave_id = '.$dates["leave_id"].'';
														$result3 = mysqli_query($conn, $sql);
														$num = mysqli_fetch_assoc($result3);
														$newnum = $num["number"] - $d;
														
														$sql = 'UPDATE faculty_leaves SET number = '.$newnum.' WHERE fid = '.$dates["fid"].' AND leave_id = '.$dates["leave_id"].'';
														mysqli_query($conn, $sql);
														
														$sql = 'DELETE FROM work_flow WHERE app_no = '.$row["app_no"].'';
														if(mysqli_query($conn, $sql))
															echo "Deleted from work_flow";
														else
															echo "Could not delete";
														unset($_POST['approve'.$i.'']);
														
														$sql = 'DELETE FROM pending_tasks WHERE app_no = '.$row["app_no"].'';
														if(!mysqli_query($conn, $sql))
															echo "Could not delete from pending_tasks";
														
														
													}
													else if(isset($_POST['forward'.$i.''])){
														$sql = 'UPDATE pending_tasks SET complete = TRUE where app_no = '.$row["app_no"].'';
														if(mysqli_query($conn, $sql)){
															echo "Pending Tasks changed successfully";
														}
														else{
															echo "Pending Tasks did not change.";
														}
														
														$sql = 'SELECT role1 FROM work_flow WHERE app_no = '.$row["app_no"].'';
														$result2 = mysqli_query($conn, $sql);
														$role1 = mysqli_fetch_assoc($result2);
														
														
														
														$sql = 'INSERT INTO pending_tasks VALUES ("Dealing Clerk", '.$row["app_no"].', NULL, FALSE)';
														if(mysqli_query($conn, $sql))
															echo "Inserted in pending tasks";
														else
															echo "Could not insert into pending tasks";
														
														$sql = 'UPDATE work_flow SET role1 = "Director", role2 = "Dealing Clerk" WHERE app_no = '.$row["app_no"].'';
														if(mysqli_query($conn, $sql))
															echo "Updated Successfully";
														else
															echo "Could not update.";
													}
													else if(isset($_POST['reject'.$i.''])){
														$sql = 'UPDATE pending_tasks SET complete = TRUE where app_no = '.$row["app_no"].'';
														if(mysqli_query($conn, $sql)){
															echo "Pending Tasks changed successfully";
														}
														else{
															echo "Pending Tasks did not change.";
														}
														
														$sql = 'UPDATE leave_record SET status = 0 WHERE app_no = '.$row["app_no"].'';
														if(mysqli_query($conn, $sql))
															echo "Updated leave record.";
														else
															echo "Could not update record.";
														
														$sql = 'DELETE FROM work_flow WHERE app_no = '.$row["app_no"].'';
														if(mysqli_query($conn, $sql))
															echo "Deleted from work_flow";
														else
															echo "Could not delete";
													}
													else{
													?>
															<div class="panel panel-default">
																<div class="panel-heading">
																	<h4 class="panel-title">
																	<?php
																		echo '<a data-toggle="collapse" data-parent="#accordion" href="#collapse'.$i.'">';
																		
																		$sql = 'SELECT leave_type FROM leaves WHERE leave_id = (SELECT leave_id FROM leave_record WHERE app_no = '.$row["app_no"].')';
																		$result2 = mysqli_query($conn, $sql);
																		$row2 = mysqli_fetch_assoc($result2);
																		
																		echo $row2["leave_type"];
																		
																	?>						
																			
																		</a>
																	</h4>
																</div>
																<?php
																if($i==0)
																	echo '<div id="collapse'.$i.'" class="panel-collapse collapse in">';
																else
																	echo '<div id="collapse'.$i.'" class="panel-collapse collapse">';
																?>
																	<div class="panel-body">
																		<!-- Insert queries for faculty details-->
																		<?php
														$sql = 'SELECT * FROM faculty_details WHERE fid = (SELECT fid FROM leave_record WHERE app_no = '.$row["app_no"].')';
														$result_details = mysqli_query($conn, $sql);
														
														$details = mysqli_fetch_assoc($result_details);
														echo '<table>';
														echo '<tr>';
														echo '<td>Applicant ID: </td>';
														echo '<td>'.$details["fid"].'</td>';
														echo '</tr>';
														echo '<tr>';
														echo '<td>Applicant Name: </td>';
														echo '<td>'.$details["firstname"].' '.$details["middlename"].' '.$details["lastname"].'</td>';
														
														$sql = 'SELECT number FROM faculty_leaves WHERE fid = '.$details["fid"].' AND leave_id = (SELECT leave_id FROM leave_record WHERE app_no = '.$row["app_no"].')';
														$result_details = mysqli_query($conn, $sql);
														
														$leave_number = mysqli_fetch_assoc($result_details);
														echo '<tr>';
														echo '<td>Remaining Number of leaves: </td>';
														echo '<td>'.$leave_number["number"].'</td>';
														echo '</tr>';
														echo '</table>';
													?>
																		<form action = "welcome_director.php" method = "post">
																		<?php
																			if(strcmp($row2["leave_type"], "Casual")==0)
																				echo '<button type = "submit" class = "button" name = "approve'.$i.'">Approve</button>';
																			else
																				echo '<button type = "submit" class = "button" name = "forward'.$i.'">Forward</button>';
																		echo '<button type = "submit" class = "button" name = "reject'.$i.'">Reject</button>';
																		?>
																		</form>
																	</div>
																</div>
															</div>
												<?php
														$j++;
													}
													$i++;
												}?>
														</div>
									
									</div>
								</div>
								
								<div class="tab-pane" id="tab_default_5">
									<div class="container" style="width: 95%">
										<div class="row">
											<div class="panel panel-default">
												<table class="table table-fixed">
													<thead>
														<tr>
															<th class="col-xs-1">Faculty ID</th><th class="col-xs-1">App. No.</th><th class="col-xs-3">Role</th><th class="col-xs-1">Leave</th><th class="col-xs-2">Start Date</th><th class="col-xs-2">End Date</th><th class="col-xs-2">Status</th>
														</tr>
													</thead>
													<tbody>
														<?php
															$i=1;
															$sql = 'SELECT fid, role FROM faculty_details WHERE role != "Faculty" AND role != "Director"';
															$result2 = mysqli_query($conn, $sql);
															
															while($row2 = mysqli_fetch_assoc($result2)){
																$days = "%";
																$app = "%";
																$st = 5;
																if(isset($_POST["fltr"])){
															
																	
																	$inif = 1;
																	if(strlen($_POST["app_filter"])==0)
																		$app = "%";
																	else
																		$app = $_POST["app_filter"];
																	if(strcmp($_POST["leave_filter"], "Select")==0)
																		$leave_id = "%";
																	else{
																		$leave_id = $_POST["leave_filter"];
																	}
																	
																	if(strcmp($_POST["date_filter"], "")==0)
																		$st = 0;
																	else{
																		$st = 1;
																		$date_filter = $_POST["date_filter"];
																	}
																	if(strlen($_POST["days_filter"])==0)
																		$days = "%";
																	else
																		$days = $_POST["days_filter"];
															
																	if(strcmp($_POST["status_filter"], "Select")==0)
																		$stat = "%";
																	else{
																		$stat = $_POST["status_filter"];
																
																	}
																	if($st==0)
																		$sql = 'SELECT * FROM leave_record WHERE fid = '.$row2["fid"].' AND app_no LIKE "'.$app.'"AND leave_id LIKE "'.$leave_id.'" AND status LIKE "'.$stat.'"';
																	else if($st==1)
																		$sql = 'SELECT * FROM leave_record WHERE fid = '.$row2["fid"].' AND app_no LIKE "'.$app.'"AND leave_id LIKE "'.$leave_id.'" AND status LIKE "'.$stat.'" AND start <= "'.$date_filter.'" AND end >= "'.$date_filter.'"';
																	$result = mysqli_query($conn, $sql);
																	
																}
																else{
																	$inif=0;
																	$sql = 'SELECT * FROM leave_record WHERE fid = '.$row2["fid"].'';
																	$result = mysqli_query($conn, $sql);
																
																}
																while($row = mysqli_fetch_assoc($result)){

																	$sql = 'SELECT leave_type FROM leaves WHERE leave_id = '.$row["leave_id"].'';
																	$result2 = mysqli_query($conn, $sql);
																	$lt = mysqli_fetch_assoc($result2);
																
																	if(strcmp($days, "%")!=0){
																	$start = date_create($row["start"]);
																	$end = date_create($row["end"]);
																	$diff = date_diff($start, $end);
																	$d = $diff->format("%R%a");
																	}
																
																	if(strcmp($days, "%")==0 || $d==$days){
																	echo '<tr>';
																	echo '<td class="col-xs-1">'.$row2["fid"].'</td>';
																	echo '<td class="col-xs-1">'.$row["app_no"].'</td>';
																	echo '<td class="col-xs-3">'.$row2["role"].'</td>';
																	echo '<td class="col-xs-1">'.$lt["leave_type"].'</td>';
																	echo '<td class="col-xs-2">'.$row["start"].'</td>';
																	echo '<td class="col-xs-2">'.$row["end"].'</td>';
																	
																
																	if($row["status"]==1)
																		echo '<td class="col-xs-2">Approved</td>';
																	else if($row["status"]==0)
																		echo '<td class="col-xs-2">Rejected</td>';
																	else if($row["status"]==3){
																		$sql = 'SELECT role2 FROM work_flow WHERE app_no = '.$row["app_no"].'';
																		$result2 = mysqli_query($conn, $sql);
																		$lt = mysqli_fetch_assoc($result2);
																		echo '<td class="col-xs-2">Pending ('.$lt["role2"].')';
																	}
																	echo '</tr>';
																	$i++;
																	if($inif==1)
																		unset($_POST["fltr"]);
																	}
																}
															}
														?>
													</tbody>
												</table>
											</div>
										</div>
									</div>
									
									Filter using:
									<form action = "welcome_director.php" method = "post">
										<input type = "text" placeholder = "Application Number" name = "app_filter"><br><br>
										<?php
											$sql = 'SELECT leave_type, leave_id FROM leaves';
											$result = mysqli_query($conn, $sql);
											echo '<label>Type of Leave: </label>';
											echo '<select name = "leave_filter">';
											echo '<option value = "Select">Select</option>';
											while($row = mysqli_fetch_assoc($result)){
												echo '<option value = "'.$row["leave_id"].'">'.$row["leave_type"].'</option>';
												$i++;
											}
										?>
										</select>
										<br><br>
										<input type = "text" placeholder = "Number of days" name = "days_filter"><br><br>
										<label>Date: </label>
										<input type = "date" name = "date_filter"><br><br>
										<?php
											if($st == 4)
												echo "Start date should not exceed end date.";
										?>
										<label>Status: </label>
										<select name = "status_filter">
										<option value = "Select">Select</option>
										<option value = "0">Rejected</option>
										<option value = "1">Accepted</option>
										<option value = "3">Pending</option>
										</select>
										<br><br>
										<button class="btn btn-lg btn-primary btn" name = "fltr" type="submit">
										Search</button>
									</form>
									
								</div>
								
								
								
								
								<?php
									if(isset($_POST["assign"])){
										$sql = 'SELECT role FROM faculty_details WHERE fid = '.$_POST["new_role"].'';
										$result = mysqli_query($conn, $sql);
										$old_role = mysqli_fetch_assoc($result);
										$sql = 'INSERT INTO roles VALUES ("Director", '.$_POST["new_role"].', "'.$_POST["start_role"].'", "'.$_POST["end_role"].'", '.$user.', '.$old_role["role"].')';
										if(mysqli_query($conn, $sql)){
											$sql = 'UPDATE faculty_details SET role = "Director" WHERE fid = '.$_POST["new_role"].'';
											echo 'Successfully transferred role.';
										}
										else
											echo 'Could not transfer role.';
										unset($_POST["assign"]);
									}
								?>
								<div class="tab-pane" id="tab_default_6">
									<form action = "welcome_director.php" method = "post">
										Assign role to: <input type = "text" placeholder = "Faculty ID" name = "new_role"><br><br>
										From: <input type = "date" name = "start_role"><br><br>
										To: <input type = "date" name = "end_role"><br><br>
										<button type = "submit" class = "button" name = "assign">Assign</button>
									</form>
								</div>
								
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
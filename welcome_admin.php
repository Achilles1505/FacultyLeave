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
			
			$status = 0;
			
			if(isset($_POST['addNow'])){
					$sql = 'INSERT INTO department VALUES ("'.$_POST['dept_id'].'", "'.$_POST['dept_name'].'")';
					if(mysqli_query($conn, $sql))
						$status = 1;
					else
						$status = 2;
					unset($_POST['addNow']);
			}
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
										Department
									</a>
								</li>
								<li>
									<a href="#tab_default_2" data-toggle="tab">
										Faculty Details
									</a>
								</li>
								<li>
									<a href="#tab_default_3" data-toggle="tab">
										Leaves
									</a>
								</li>
							</ul>
							<div class="tab-content">
								<div class="tab-pane active" id="tab_default_1">
									<div class="container" style="width: 95%">
										<div class="row">
											<div class="panel panel-default">
												<table class="table table-fixed">
													<thead>
														<tr>
															<th class="col-xs-2">Select</th><th class="col-xs-8">Department ID</th><th class="col-xs-2">Department Name</th>
														</tr>
													</thead>
													<tbody>
														<?php
															$sql = 'SELECT * FROM department';
															$result = mysqli_query($conn, $sql);
			
															if(!$result)
																echo 'Query not executed.';
															
															$i = 0; $j = 0;
															echo '<form action = "welcome_admin.php" method = "post">';
															while($row = mysqli_fetch_assoc($result)){
																if(isset($_POST["$j"]) && isset($_POST['del'])){
																	$sql = 'DELETE FROM department WHERE dept_id = '.$row["dept_id"].'';
																	if(mysqli_query($conn, $sql)){
																		$status = 3;
																	}
																	else
																		$status = 4;
																}
																else{
																	echo '<tr>';
																	echo '<td class="col-xs-2">';
																	echo '<input type = "checkbox" name = "'.$i.'" value = "set">';
																	echo '</td>';
						
																	echo '<td class="col-xs-8">'.$row["dept_id"].'</td>';
																	echo '<td class="col-xs-2">'.$row["dept_name"].'</td>';
																	echo '</tr>';
																	$i++;
																}
																$j++;
															}
														?>
													</tbody>
												</table>
											</div>
										</div>
									</div>
									<?php
										if($status == 0)
											echo '<br>';
										else if($status == 1)
											echo 'Record inserted successfully.';
										else if($status == 2)
											echo "Error: Record not inserted.";
										else if($status == 3)
											echo 'Record(s) deleted successfully.';
										else if($status == 4)
											echo 'Error: Could not delete record(s).';
										if(isset($_POST['add'])){
									?>
									<form action = "welcome_admin.php" method = "post">
										Department ID: <input type = "text" placeholder = "Department ID" name = "dept_id"><br><br>
										Department Name: <input type = "text" placeholder = "Department Name" name = "dept_name"><br><br>
										<button type = "submit" name = "addNow" class = "button">Add</button>
									</form>
									<?php
										}
										else{
									?>
									<center>
										<button type = "submit" name = "add" class="button">Add new Department</button> &nbsp <button type = "submit" name = "del" class="button">Delete existing Department</button>
									</center>
								</form>
								
								<?php
										unset($_POST['add']);
										unset($_POST['del']);
									}
								?>

								
								</div>
								<div class="tab-pane" id="tab_default_2">
									
									<div class="container" style="width: 95%">
										<div class="row">
											<div class="panel panel-default">
												<table class="table table-fixed">
													<thead>
														<tr>
															<th class="col-xs-1">Select</th><th class="col-xs-1">Faculty ID</th><th class="col-xs-1">First Name</th><th class="col-xs-1">Middle Name</th><th class="col-xs-1">Last Name</th><th class="col-xs-1">Password</th><th class="col-xs-1">Dept ID</th><th class="col-xs-4">Email ID</th><th class="col-xs-1">Role</th>
														</tr>
													</thead>
													<tbody>
														<?php
															$status_fd = 0;
			
															if(isset($_POST['addNow_fd'])){
																$sql = 'INSERT INTO faculty_details VALUES ('.$_POST['fid'].', "'.$_POST['firstname'].'", "'.$_POST['middlename'].'", "'.$_POST['lastname'].'", "'.$_POST['password'].'", "'.$_POST['dept_id_fd'].'", "'.$_POST['email'].'", "'.$_POST['role'].'")';
																if(mysqli_query($conn, $sql)){
																	$status_fd = 1;
																	$sql = 'SELECT leave_id, days FROM leaves';
																	$result = mysqli_query($conn, $sql);	
																	while($row = mysqli_fetch_assoc($result)){
																		$sql = 'INSERT INTO faculty_leaves VALUES('.$_POST['fid'].', '.$row['leave_id'].', '.$row['days'].')';
																		mysqli_query($conn, $sql);
																	}
																}
																else
																	$status_fd = 2;
																unset($_POST['addNow_fd']);
															}
															
															$sql = 'SELECT * FROM faculty_details';
															$result = mysqli_query($conn, $sql);
															
															$i_fd = 0; $j_fd = 0;
															echo '<form action = "welcome_admin.php" method = "post">';
															while($row = mysqli_fetch_assoc($result)){
																if(isset($_POST["$j_fd"]) && isset($_POST['del_fd'])){
																	$sql = 'DELETE FROM faculty_details WHERE fid = '.$row["fid"].'';
																	if(mysqli_query($conn, $sql)){
																		$status = 3;
																	}
																	else
																		$status = 4;
																}
																else{
																	echo '<tr>';
																	echo '<td class="col-xs-1">';
																	echo '<input type = "checkbox" name = "'.$i_fd.'" value = "set">';
																	echo '</td>';
						
																	echo '<td class="col-xs-1">'.$row["fid"].'</td>';
																	echo '<td class="col-xs-1">'.$row["firstname"].'</td>';
																	echo '<td class="col-xs-1">'.$row["middlename"].'</td>';
																	echo '<td class="col-xs-1">'.$row["lastname"].'</td>';
																	echo '<td class="col-xs-1">'.$row["password"].'</td>';
																	echo '<td class="col-xs-1">'.$row["dept_id"].'</td>';
																	echo '<td class="col-xs-4">'.$row["email"].'</td>';
																	echo '<td class="col-xs-1">'.$row["role"].'</td>';
																	echo '</tr>';
																	$i_fd++;
																}
																$j_fd++;
															}
														?>
													</tbody>
												</table>
											</div>
										</div>
									</div>
									
									<?php
										if($status_fd == 0)
											echo '<br>';
										else if($status_fd == 1)
											echo 'Record inserted successfully.';
										else if($status_fd == 2)
											echo "Error: Record not inserted.";
										else if($status_fd == 3)
											echo 'Record(s) deleted successfully.';
										else if($status_fd == 4)
											echo 'Error: Could not delete record(s).';
										if(isset($_POST['add_fd'])){
									?>
									<form action = "faculty_details.php" method = "post">
										Faculty ID: <input type = "text" placeholder = "Faculty ID" name = "fid"><br><br>
										First Name: <input type = "text" placeholder = "First Name" name = "firstname"><br><br>
										Middle Name: <input type = "text" placeholder = "Middle Name" name = "middlename"><br><br>
										Last Name: <input type = "text" placeholder = "Last Name" name = "lastname"><br><br>
										Password: <input type = "text" placeholder = "Password" name = "password"><br><br>
										Department ID: <input type = "text" placeholder = "Department ID" name = "dept_id_fd"><br><br>
										Email ID: <input type = "text" placeholder = "Email ID" name = "email"><br><br>
										Role: <input type = "text" placeholder = "Role" name = "role"><br><br>
										<button type = "submit" name = "addNow_fd" class = "button">Add</button>
									</form>
									<?php
										}
										else{
									?>
									<center>
										<button type = "submit" name = "add_fd" class="button">Add new Faculty</button> &nbsp <button type = "submit" name = "del_fd" class="button">Delete existing Faculty</button>
									</center>
								</form>
							
								<?php
									unset($_POST['add_fd']);
									unset($_POST['del_fd']);
								}
								?>
									
									
								</div>
								<div class="tab-pane" id="tab_default_3">
									<div class="container" style="width: 95%">
										<div class="row">
											<div class="panel panel-default">
												<table class="table table-fixed">
													<thead>
														<tr>
															<th class="col-xs-2">Select</th><th class="col-xs-2">Leave ID</th><th class="col-xs-6">Leave Type</th><th class="col-xs-2">Days</th>
														</tr>
													</thead>
													<tbody>
														<?php
														
															$status_l = 0;
			
															if(isset($_POST['addNow_l'])){
																$sql = 'INSERT INTO leaves VALUES ('.$_POST['leave_id'].', "'.$_POST['leave_type'].'", '.$_POST['days'].')';
																if(mysqli_query($conn, $sql))
																	$status = 1;
																else
																	$status = 2;
																unset($_POST['addNow_l']);
															}
															$sql = 'SELECT * FROM leaves';
															$result = mysqli_query($conn, $sql);
			
															if(!$result)
																echo 'Query not executed.';
															
															$i_l = 0; $j_l = 0;
															echo '<form action = "welcome_admin.php" method = "post">';
															while($row = mysqli_fetch_assoc($result)){
																if(isset($_POST["$j_l"]) && isset($_POST['del_l'])){
																	$sql = 'DELETE FROM leaves WHERE leave_id = '.$row["leave_id"].'';
																	if(mysqli_query($conn, $sql)){
																		$status = 3;
																	}
																	else
																		$status = 4;
																}
																else{
																	echo '<tr>';
																	echo '<td class="col-xs-2">';
																	echo '<input type = "checkbox" name = "'.$i_l.'" value = "set">';
																	echo '</td>';
						
																	echo '<td class="col-xs-2">'.$row["leave_id"].'</td>';
																	echo '<td class="col-xs-6">'.$row["leave_type"].'</td>';
																	echo '<td class="col-xs-2">'.$row["days"].'</td>';
																	echo '</tr>';
																	$i_l++;
																}
																$j_l++;
															}	
														?>
													</tbody>
												</table>
											</div>
										</div>
									</div>
									<?php
										if($status_l == 0)
											echo '<br>';
										else if($status_l == 1)
											echo 'Record inserted successfully.';
										else if($status_l == 2)
											echo "Error: Record not inserted.";
										else if($status_l == 3)
											echo 'Record(s) deleted successfully.';
										else if($status_l == 4)
											echo 'Error: Could not delete record(s).';
										if(isset($_POST['add_l'])){
									?>
									<form action = "welcome_admin.php" method = "post">
										Leave ID: <input type = "text" placeholder = "Leave ID" name = "leave_id"><br><br>
										Leave Type: <input type = "text" placeholder = "Leave Type" name = "leave_type"><br><br>
										Number of Days: <input type = "text" placeholder = "Number of Days" name = "days"><br><br>
										<button type = "submit" name = "addNow_l" class = "button">Add</button>
									</form>
									<?php
										}
										else{
									?>
									<center>
										<button type = "submit" name = "add_l" class="button">Add new Leave</button> &nbsp <button type = "submit" name = "del_l" class="button">Delete existing Leave</button></form>
									</center>
									
									<?php
										unset($_POST['add_l']);
										unset($_POST['del_l']);
									}
									?>
									
								</div>
								
								
								
								
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
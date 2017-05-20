<html>
	<head>
		<title>Login</title>
		<link rel="stylesheet" href="css/bootstrap.min.css">	
		<link rel="stylesheet" href="css/styles.css">
		<script src="js/jquery.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<style>
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
			.form-signin
			{
				max-width: 330px;
				padding: 15px;
				margin: 0 auto;
			}
			.form-signin .form-signin-heading, .form-signin .checkbox
			{
				margin-bottom: 10px;
			}
			.form-signin .checkbox
			{
				font-weight: normal;
			}
			.form-signin .form-control
			{
				position: relative;
				font-size: 16px;
				height: auto;
				padding: 10px;
				-webkit-box-sizing: border-box;
				-moz-box-sizing: border-box;
				box-sizing: border-box;
			}
			.form-signin .form-control:focus
			{
				z-index: 2;
			}
			.form-signin input[type="text"]
			{
				margin-bottom: -1px;
				border-bottom-left-radius: 0;
				border-bottom-right-radius: 0;
			}
			.form-signin input[type="password"]
			{
				margin-bottom: 10px;
				border-top-left-radius: 0;
				border-top-right-radius: 0;
			}
			.account-wall
			{
				margin-top: 20px;
				padding: 40px 0px 20px 0px;
				background-color: #f7f7f7;
				-moz-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
				-webkit-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
				box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
			}
			.login-title
			{
				color: #555;
				font-size: 18px;
				font-weight: 400;
				display: block;
			}
			.profile-img
			{
				width: 96px;
				height: 96px;
				margin: 0 auto 10px;
				display: block;
				-moz-border-radius: 50%;
				-webkit-border-radius: 50%;
				border-radius: 50%;
			}
			.need-help
			{
				margin-top: 10px;
			}
			.new-account
			{
				display: block;
				margin-top: 10px;
			}
			
			
		</style>
	</head>
	<body>
		<?php
			$dbhost = "localhost:3306";
			$dbuser = "root";
			$dbpass = "";
			session_start();
			
			$conn = mysqli_connect($dbhost, $dbuser, $dbpass);
			
			mysqli_select_db($conn, "leave_management");
			
			$status = 0;
			
			if(isset($_POST['log'])){
				$sql = 'SELECT password FROM faculty_details WHERE fid = "'.$_POST["fid"].'"';
				$result = mysqli_query($conn, $sql);
				$row = mysqli_fetch_assoc($result);
				if(strcmp($row["password"], $_POST["password"])==0 && mysqli_num_rows($result)>0){
					$sql = 'SELECT role, dept_name FROM faculty_details, department WHERE fid = "'.$_POST["fid"].'" and department.dept_id = faculty_details.dept_id';
					$result = mysqli_query($conn, $sql);
					$row = mysqli_fetch_assoc($result);
					$_SESSION["user"] = $_POST["fid"];
					
					if(strcmp($row["role"], "Admin")==0){
						header('Location: welcome_admin.php');
					}
					else if(strcmp($row["role"], "Faculty")==0){
						header('Location: welcome_faculty.php');
					}
					else if(strcmp($row["role"], "Assistant Registrar")==0){
						header('Location: welcome_ar.php');
					}
					else if(strcmp($row["role"], "Dean")==0){
						header('Location: welcome_dean.php');
					}
					else if(strcmp($row["role"], "Dealing Clerk")==0){
						header('Location: welcome_dealingclerk.php');
					}
					else if(strcmp($row["role"], "Director")==0){
						header('Location: welcome_director.php');
					}
					else{
						header('Location: welcome_hod.php');
					}
				}
				else
					$status = 1;
				unset($_POST['log']);
			}
		
		?>
		<div class="container">
    <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4">
            <h1 class="text-center login-title">Sign in</h1>
            <div class="account-wall">
                <form class="form-signin" action="login.php" method="post">
                <input type="text" class="form-control" placeholder="Faculty ID" name = "fid" required autofocus>
                <input type="password" class="form-control" placeholder="Password" name = "password" required>
				<?php
				if($status == 1)
					echo "Invalid username or password<br>";
				?>
                <button class="btn btn-lg btn-primary btn-block" name = "log" type="submit">
                    Sign in</button>
                
				
                </form>
            </div>
        </div>
    </div>
</div>
	</body>
</html>
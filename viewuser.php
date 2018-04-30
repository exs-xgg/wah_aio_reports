<html>
	<head>
		<title>Query Browser</title>
			<link rel="stylesheet" type="text/css" href="./bootstrap.min.css">
	</head>

	<body>
		<div class="container">

			<nav class="navbar navbar-expand-lg navbar-light bg-light">
			  <a class="navbar-brand" href="#">Query Brower</a>
			  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			    <span class="navbar-toggler-icon"></span>
			  </button>

			  <div class="collapse navbar-collapse" id="navbarSupportedContent">
			    <ul class="navbar-nav mr-auto">
			      <li class="nav-item active">
			        <a class="nav-link" href="query.php">Home <span class="sr-only">(current)</span></a>
			      </li>
			      <li class="nav-item">
			        <a class="nav-link" href="viewuser.php">View User</a>
			      </li>
			    </ul>
			  </div>
			</nav>
			<br>
			
					<form action="viewuser.php" method="get">
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label>Search By:</label>
									<input type="text" class="form-control" name="filteredBy">
								</div>	
							</div>	
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label>Select Activation:</label>
									<select class="form-control" name="activation">
										<option></option>
										<option value="Y">Active</option>
										<option value="N">Inactive</option>
									</select>
								</div>
							</div>
						</div>	
						<button type="submit" class="btn btn-outline-primary btn-block">Click</button>
					</form>
				
			<h2>USER LIST</h2>
			<table class="table table-bordered" id="report">
			<thead>
				<tr>
					<td>#</td>
					<td>Name</td>
					<td>Gender</td>
					<td>Email</td>
					<td>Mobile Number</td>
					<td>Designation</td>
					<td>Is Active</td>
				</tr>
			</thead>
			<tbody>
					<?php
					include './class/mySqlConnect.php';

					$activation = " ";

					if (isset($_GET['activation']) && $_GET['activation'] !== "") {
						$activation = " (is_active='" . $_GET['activation'] . "') and " ;
					}



					if (isset($_GET['filteredBy'])) {

					$filteredBy = $_GET['filteredBy'];
					$userAccount = "SELECT last_name,first_name,middle_name,gender,email,mobile_number,designation,is_active FROM `user` where $activation (last_name 
						OR last_name like '%$filteredBy%' 
						OR first_name like '%$filteredBy%'
						OR middle_name like '%$filteredBy%'
						OR gender like '%$filteredBy%'
						OR email like '%$filteredBy%'
						OR mobile_number like '%$filteredBy%'
						OR designation like '%$filteredBy%')
						";	
					
				
				}else{
					$userAccount = "select * from user";
				}
				$getUserList = $database->_dbQuery($userAccount);

					$x=1;
					while($result=$database->_dbFetch($getUserList))
					{ 
						echo "<tr>";
							
							echo '<td>'.$x++.'</td>';
							echo '<td>'.$result['first_name']." ".substr_replace($result['middle_name'],'.',1)." ".$result['last_name'].'</td>';
							echo '<td>'.$result['gender'].'</td>';
							echo '<td>'.$result['email'].'</td>';
							echo '<td>'.$result['mobile_number'].'</td>';
							echo '<td>'.$result['designation'].'</td>';
							echo '<td>'.$result['is_active'].'</td>';
						echo  "</tr>";
					}	
			 	?>
			</tbody>
		</table>
		</div>
	</body>
</html>

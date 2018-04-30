
<html>
	<head>
		<title>Query Browser</title>
			<link rel="stylesheet" type="text/css" href="./bootstrap.min.css">
	</head>

	<body>
		<div class="container">
			<br>

			<nav class="navbar navbar-expand-lg navbar-light bg-light">
			  <a class="navbar-brand" href="#">Query Brower</a>
			  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			    <span class="navbar-toggler-icon"></span>
			  </button>

			  <div class="collapse navbar-collapse" id="navbarSupportedContent">
			    <ul class="navbar-nav mr-auto">
			      <li class="nav-item active">
			        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
			      </li>
			      <li class="nav-item">
			        <a class="nav-link" href="viewuser.php">View User</a>
			      </li>
			    </ul>
			  </div>
			</nav>
			<hr>
				<form action="./query.php" method="GET">
					<div class="row">
						<div class="col">
							<div class="form-group">
								<label>Select Category:</label>
								<select class="form-control" name="cat" required>
									<option selected>Select</option>
									<option>Profiled</option>
									<option>Enlisted</option>
									<!-- <option>No-Enlisted</option> -->
								</select>
							</div>
						</div>
						<div class="col">
							<div class="form-group">
								<label>Start Date:</label>
								<input class="form-control"  type="date" name="start" value="<?php echo $_GET['start'];?>"/>
							</div>
						</div>
						<div class="col">
							<div class="form-group">
								<label>End Date:</label>
								<input class="form-control"  type="date" name="end"  value="<?php echo $_GET['end'];?>"/>
							</div>
						</div>	
					</div>
					<button type="submit" class="btn btn-outline-primary btn-block">Click</button>
				</form>
				<h2><?php echo isset($_GET['cat']) ? $_GET['cat'] : "Query Browser"
				?> (<span id="nums"></span>)</h2>
			<table class="table table-bordered" id="report">
			<thead>
				<tr>
					<td><b>#</b></td>
					<td><b>First Name</b></td> 
					<td><b>Middle Name</b></td>
					<td><b>Last Name</b></td>
					
				<?php
					include './class/mySqlConnect.php';

					if (isset($_GET['start'])) {
						$start = $_GET['start'];
						$end = $_GET['end'];

			 if($_GET['cat'] == "Profiled")	{


			 	?>

			 	<td><b>Created at/ Updated at</b></td>
					
				</tr>
			</thead>
			<tbody>	<?php
									$profiled = "SELECT a.last_name,a.first_name,a.middle_name,d.updated_at FROM patient a 
	JOIN patient_philhealth b ON a.id = b.patient_id 
	JOIN patient_history c ON a.id = c.patient_id 
	JOIN consult d ON a.id = d.patient_id 
WHERE d.consult_end BETWEEN date('$start') AND date('$end') 
GROUP BY a.id ORDER BY d.consult_end ASC";	

									$getQuery = $database->_dbQuery($profiled);
							$x=1;
						while($result=$database->_dbFetch($getQuery))
						{ 
							echo "<tr>";
								
								echo '<td>'.$x++.'</td>';
								echo '<td>'.$result['first_name'].'</td>';
								echo '<td>'.$result['middle_name'].'</td>';
								echo '<td>'.$result['last_name'].'</td>';
								echo '<td>'.$result['updated_at'].'</td>';
									
							echo  "</tr>";
						}
			 }else{
			 	?>

			 		<td><b>PhilHealth ID</b></td>
					<td><b>Member Type</b></td>
					<td><b>Member Category</b></td>
					<td><b>Enlistment Date</b></td>
					<td><b>Expiry Date</b></td>
				</tr>
			</thead>
			<tbody>
				<?php
			 	$enlisted = "SELECT a.first_name,a.middle_name,a.last_name,b.philhealth_id,b.enlistment_date,b.expiry_date,c.member_type,d.memb+er_cat_desc FROM patient a 
						LEFT JOIN patient_philhealth b JOIN lib_philhealth_membership_type c ON b.member_id = c.member_id JOIN lib_philhealth_membership_cat d 
						ON b.member_cat_id = d.member_cat_id
						ON a.id = b.patient_id 
						WHERE b.enlistment_date 
						BETWEEN date('$start') AND date('$end')
						GROUP BY a.id ORDER BY b.enlistment_date";
					$getQuery = $database->_dbQuery($enlisted);
							$x=1;
						while($result=$database->_dbFetch($getQuery))
						{ 
							echo "<tr>";
								
								echo '<td>'.$x++.'</td>';
								echo '<td>'.$result['first_name'].'</td>';
								echo '<td>'.$result['middle_name'].'</td>';
								echo '<td>'.$result['last_name'].'</td>';
								echo '<td>'.$result['philhealth_id'].'</td>';
								echo '<td>'.$result['member_type'].'</td>';
								echo '<td>'.$result['member_cat_desc'].'</td>';
								echo '<td>'.$result['enlistment_date'].'</td>';
								echo '<td>'.$result['expiry_date'].'</td>';
									
							echo  "</tr>";
						}
			 }
				
			}

				?>
			</tbody>
		</table>
<!-- 		<table class="table table-bordered" id="report">
			<thead>
				<tr>
					<td><b>#</b></td>
					<td><b>First Name</b></td> 
					<td><b>Middle Name</b></td>
					<td><b>Last Name</b></td>
				</tr>
			</thead>
			<tbody>
			<?php

			if (isset($_GET['cat'])	) {
				if($_GET['cat'] == "No-Enlisted")	{
						$noenlisted = "SELECT a.first_name,a.middle_name,a.last_name FROM patient a 
						LEFT JOIN patient_philhealth b
						ON a.id = b.patient_id 
						WHERE b.philhealth_id = ''
						GROUP BY a.id ORDER BY b.enlistment_date";
					$getQuery = $database->_dbQuery($noenlisted);
							$x=1;
						while($result=$database->_dbFetch($getQuery))
						{ 
							echo "<tr>";
								
								echo '<td>'.$x++.'</td>';
								echo '<td>'.$result['first_name'].'</td>';
								echo '<td>'.$result['middle_name'].'</td>';
								echo '<td>'.$result['last_name'].'</td>';
							echo  "</tr>";
						}
				}
			}

			?>
			</tbody>
		</table> -->
		</div>
	</body>

	<script type="text/javascript">
		var total = document.getElementById('report').rows.length -1;
		document.getElementById('nums').innerHTML = total;
	</script>
</html>

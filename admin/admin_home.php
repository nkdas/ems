<?php
require('header.php');
?>
<body>
	<nav class="navbar navbar-inverse" data-spy="affix">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#homeNavbar">
					<span class="icon-bar"></span> 
					<span class="icon-bar"></span> 
					<span class="icon-bar"></span> 
				</button>
				<a class="navbar-brand" href="#">Admin</a> 
			</div>
			<div>
				<div class="collapse navbar-collapse" id="homeNavbar">
					<ul class="nav navbar-nav">
					</ul>
				</div>
			</div>
		</div>
	</nav>
	<div id="section1" class="container-fluid">
		<div class="row">
			<div class="col-md-12">

				<!-- Modal -->
				<div id="myModal" class="modal fade container-fluid" role="dialog">
					<div class="modal-dialog">
						<!-- Modal content-->
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title"></h4>
							</div>
							<div class="modal-body">
							</div>
						</div>
					</div>
				</div>

				<div class="table-responsive">
					<table id="employee" class="display table" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th>Username</th>
								<th>Firstname</th>
								<th>Middlename</th>
								<th>Lastname</th>
								<th>Suffix</th>
								<th>Gender</th>
								<th>DOB</th>
								<th>Marital Status</th>
								<th>Employement Status</th>
								<th>Employer</th>
								<th>Email</th>
								<th>Street</th>
								<th>City</th>
								<th>State</th>
								<th>ZIP</th>
								<th>Telephone</th>
								<th>Mobile</th>
								<th>Fax</th>
								<th>Edit</th>
								<th>Delete</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>
</body>
<?php require('footer.php');?>
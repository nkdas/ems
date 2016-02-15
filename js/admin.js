$(document).ready(function() {
	$.fn.dataTable.ext.order['dom-text'] = function  ( settings, col )
	{
	    return this.api().column( col, {order:'index'} ).nodes().map( function ( td, i ) {
	        return $('input', td).val();
	    } );
	}
	
	dat = $('#employee').DataTable({
		paging: true,
		searching: true,
		retrieve: true,
		"ajax": "fetch_records.php",
        "columnDefs": [
		    { "orderDataType": "dom-text", type: "string", 
		    "targets": [ 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18 ] },
		]
	});
});

function confirmDeletion(userName) {
	$('.modal-title').html("Are you sure? You want to delete this Record!");
	$modalContent = "<input type='button' onclick='deleteRecord(\"" + userName + "\")' class='btn btn-primary' value='YES'>" +
		"&nbsp<input type='button' class='btn btn-primary' value='NO' data-dismiss='modal'>";

	$('.modal-body').html($modalContent);
	$('#myModal').modal('show');
}

function deleteRecord(userName) {
	$.ajax({
		type: "POST",
		dataType: "json",
		url: "delete.php",
		data: "userName=" + userName,
		success: function(data) {
			if (data.status == '1') {
				$('#myModal').modal('hide');
				dat.ajax.reload();
			}
			else {
				console.log("unable to delete");
			}
		},
		error: function() {
			
		},
	});
}

function editRecord(record) {
	$('.modal-title').html("Edit Record");

	$modalContent = "<form name='modalForm' action='admin_home.php' method='post'>" +
	"<input name='id' type='text' class='hidden-div' value='" + record['id'] + "'>" +
	"<input name='userName' type='text' class='hidden-div' value='" + record['userName'] + "'>" + 
	"<label>First name</label><input name='firstName' type='text' class='form-control' value='" + record['firstName'] + "'>" +
	"<label>Middle name</label><input name='middleName' type='text' class='form-control' value='" + record['middleName'] + "'>" +
	"<label>Last name</label><input name='lastName' type='text' class='form-control' value='" + record['lastName'] + "'>" +
	
	"<label>Role</label>" +
	"<select name='role_id' class='form-control' id='role_id'>" +
	"<option value='5'>Principal</option>" +
	"<option value='6'>Teacher</option>" +
	"<option value='7'>Student</option></select>" +
	
	"<label>Suffix</label>" +
	"<select name='suffix' class='form-control' id='suffix'>" +
	"<option value='M.Tech'>M.Tech</option>" +
	"<option value='B.Tech'>B.Tech</option>" +
	"<option value='M.B.A'>M.B.A</option>" +
	"<option value='B.B.A'>B.B.A</option>" +
	"<option value='M.C.A'>M.C.A</option>" +
	"<option value='B.C.A'>B.C.A</option>" +
	"<option value='Ph.D'>Ph.D</option></select>" +

	"<label>Gender</label>" +
	"<select name='gender' class='form-control' id='gender'>" +
	"<option value='1'>Male</option>" +
	"<option value='2'>Female</option></select>" +

	"<label>dateOfBirth</label><input name='dateOfBirth' type='text' class='form-control' value='" + record['dateOfBirth'] + "'>" +

	"<label>maritalStatus status</label>" +
	"<select id='maritalStatus' name='maritalStatus' class='form-control'>" +
	"<option value='Single'>Single</option>" +
	"<option value='Married'>Married</option>" +
	"<option value='Separated'>Separated</option>" +
	"<option value='Divorced'>Divorced</option>" +
	"<option value='Widowed'>Widowed</option></select>" +

	"<label>Employment status</label>" +
	"<select name='employmentStatus' class='form-control' id='employmentStatus'>" +
	"<option value='Student'>Student</option>" +
	"<option value='Self-employed'>Self-employed</option>" +
	"<option value='Unemployed'>Unemployed</option></select>" +

	"<label>Employer</label><input name='employer' type='text' class='form-control' value='" + record['employer'] + "'>" +
	"<label>Email</label><input name='email' type='text' class='form-control' value='" + record['email'] + "'>" +
	"<label>Street</label><input name='street' type='text' class='form-control' value='" + record['street'] + "'>" + 
	"<label>City</label><input name='city' type='text' class='form-control' value='" + record['city'] + "'>" +
	"<label>State</label><input name='state' type='text' class='form-control' value='" + record['state'] + "'>" +
	"<label>ZIP</label><input name='zip' type='text' class='form-control' value='" + record['zip'] + "'>" +
	"<label>Telephone</label><input name='telephone' type='text' class='form-control' value='" + record['telephone'] + "'>" +
	"<label>Mobile</label><input name='mobile' type='text' class='form-control' value='" + record['mobile'] + "'>" +
	"<label>FAX</label><input name='fax' type='text' class='form-control' value='" + record['fax'] + "'><br>" +
	"<input name='submit' type='submit' class='btn btn-primary' value='Update'></form>";

	$('.modal-body').html($modalContent);
	$('#myModal').modal('show');
	$("#role_id option[value='" + record['role_id'] + "']").attr('selected','selected'); 
	$("#suffix option[value='" + record['suffix'] + "']").attr('selected','selected'); 
	$("#gender option[value='" + record['gender'] + "']").attr('selected','selected'); 
	$("#maritalStatus option[value='" + record['maritalStatus'] + "']").attr('selected','selected'); 
	$("#employmentStatus option[value='" + record['employmentStatus'] + "']").attr('selected','selected'); 
}

function updateRecord(id,name,element) {
	name = '#'+name;
	var value = $(name).val();
	
	$.ajax({
		type: "POST",
		dataType: "json",
		url: "inline_update.php",
		data: "id=" + id + "&element=" + element + "&value=" + value,
		success: function(data) {
			if ('success' == data.status) {
				dat.ajax.reload();
			}
			else {
				alert('updation failed');
			}
		},
		error: function() {
			
		},
	});
}

function saveData() {
	var form=$("#myform");
	$.ajax({
		type: "POST",
		dataType: "json",
		url: "save_privileges.php",
		data: form.serialize(),
		success: function(data) {
			if ('success' == data.status) {
				alert('success');
			}
			else {
				alert('fail');
			}
		},
		error: function() {
			
		},
	});
}

function initializeAcl() {
	getRolesSelect();
	displayRoles();
	displayResources();
	getResourcePrivilege();
}

function getResourcePrivilege() {
	$.ajax({
		type: "POST",
		dataType: "html",
		url: "getResourcePrivilege.php",
		data: "role=" + $('#roleSelect').val(),
		success: function(data) {
			$('#tableContent').html(data);
		},
		error: function() {
			
		},
	});
}

function getRolesSelect() {
	$.ajax({
		type: "POST",
		dataType: "html",
		url: "createHtml.php",
		data: "item=roleSelect",
		success: function(data) {
			$('#roleSelect').html(data);
		},
		error: function() {
			
		},
	});
}

function displayRoles() {	
	$.ajax({
		type: "POST",
		dataType: "html",
		url: "createHtml.php",
		data: "item=role",
		success: function(data) {
			$('#roleContent').html(data);
		},
		error: function() {
			
		},
	});
}

function displayResources() {	
	$.ajax({
		type: "POST",
		dataType: "html",
		url: "createHtml.php",
		data: "item=resource",
		success: function(data) {
			$('#resourceContent').html(data);
		},
		error: function() {
			
		},
	});
}

function addRole() {	
	$.ajax({
		type: "POST",
		dataType: "html",
		url: "add.php",
		data: "role=" + $('#roleBox').val(),
		success: function(data) {
			if('success' == data) {
				displayRoles();
				getRolesSelect();
			}
			else {
				alert('A Role should be unique, '+
					'make sure the role you are adding is not already added');
			}
		},
		error: function() {
			
		},
	});
}

function addResource() {	
	$.ajax({
		type: "POST",
		dataType: "text",
		url: "add.php",
		data: "resource=" + $('#resourceBox').val(),
		success: function(data) {
			if('success' == data) {
				displayResources();
				getResourcePrivilege();
			}
			else {
				alert('A Resource should be unique, '+
					'make sure the resource you are adding is not already added');
			}
			
		},
		error: function() {
			
		},
	});
}
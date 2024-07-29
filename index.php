<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="author" content="Bayu Saputra">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Project_UAS_CRUD_BAYU</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link href="https://cdn.datatables.net/v/bs4/dt-2.0.8/datatables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"/>
</head>
<body>
  
<nav class="navbar navbar-expand-md bg-dark navbar-dark">
  <a class="navbar-brand" href="#"><i class="fa-solid fa-feather-pointed"></i>Ceylon</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="collapsibleNavbar">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
      <li class="nav-item"><a class="nav-link" href="#">Blog</a></li>
      <li class="nav-item"><a class="nav-link" href="#">About</a></li>
      <li class="nav-item"><a class="nav-link" href="#">Kontak</a></li>
    </ul>
  </div>
</nav>

<div class="container">
  <div class="row">
    <div class="col-lg-12">
      <h4 class="text-center text-danger font-weight-normal my-3">CRUD APPLICATION</h4>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-6">
      <h4 class="mt-2 text-primary">All users in database</h4>
    </div>
    <div class="col-lg-6">
      <button type="button" class="btn btn-primary m-1 float-right" data-toggle="modal" data-target="#addModal"><i class="fas fa-user-plus fa-lg"></i> Add New User</button>
      
      <a href="action.php?export=excel" class="btn btn-success  m-1
       float-right"><i class="fas fa-table fa-lg"></i>Export to Excel</a>

    </div>
  </div>
  <hr class="my-1">
  <div class="row">
    <div class="col-lg-12">
      <div class="table-responsive" id="showUser">
        <h3 class="text-center text-success" style="margin-top:150px;">
        Loading Mohon Sabar...</h3>
        <!-- Table will be inserted here -->
      </div>
    </div>
  </div>
</div>

<!-- Add New User Modal -->
<div class="modal fade" id="addModal">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">    
      <div class="modal-header">
        <h4 class="modal-title">Add New User</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>       
      <div class="modal-body px-4">
      <form action="" method="post" id="form-data">
  <div class="form-group">
    <input type="text" name="fname" class="form-control" placeholder="First Name" required>
  </div>
  <div class="form-group">
    <input type="text" name="lname" class="form-control" placeholder="Last Name" required>
  </div>
  <div class="form-group">
    <input type="email" name="email" class="form-control" placeholder="E-Mail" required>
  </div>
  <div class="form-group">
    <input type="tel" name="phone" class="form-control" placeholder="Phone" required>
  </div>
  <div class="form-group">
    <input type="submit" name="insert" id="insert" value="Add User" class="btn btn-danger btn-block">
  </div>
</form>
      </div>       
    </div>
  </div>
</div>

<!-- Edit User Modal -->
<div class="modal fade" id="editModal">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Edit User</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body px-4">
        <form action="" method="post" id="edit-form-data">
          <input type="hidden" name="id" id="id">
          <div class="form-group">
            <input type="text" name="fname" class="form-control" id="fname" required>
          </div>
          <div class="form-group">
            <input type="text" name="lname" class="form-control" id="lname" required>
          </div>
          <div class="form-group">
            <input type="email" name="email" class="form-control" id="email" required>
          </div>
          <div class="form-group">
            <input type="tel" name="phone" class="form-control" id="phone" required>
          </div>
          <div class="form-group">
            <input type="submit" name="update" id="update" value="Update User" class="btn btn-primary btn-block">
          </div>
        </form>
      </div>       
    </div>
  </div>
</div>

<!-- jQuery library -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
<!-- Latest compiled JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/v/bs4/dt-2.0.8/datatables.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> 

<script type="text/javascript">
   $(document).ready(function(){
    
    showAllUsers();

    function showAllUsers(){
      $.ajax({ 
        url: "action.php",
        type: "POST",
        data: {action:"view"},
        success:function(response){
          // console.log(response);
          $("#showUser").html(response);
          $("table").DataTable({
            order: [0, 'desc']
          });
        }
      });
    }

    // Insert ajax request
    $("#insert").click(function(e){
      if($("#form-data")[0].checkValidity()){
        e.preventDefault();
        $.ajax({
          url: "action.php",
          type: "POST",
          data: $("#form-data").serialize()+"&action=insert",
          success:function(response){
            Swal.fire({
              title: 'User added successfully!',
              icon: 'success'
            })
            $("#addModal").modal('hide');
            $("#form-data")[0].reset();
            showAllUsers();          
          },
        });
      }
    });

    // Edit User
    $("body").on("click", ".editBtn", function(e){
      e.preventDefault();
      var edit_id = $(this).attr('id');
      $.ajax({
        url: "action.php",
        type: "POST",
        data: {edit_id: edit_id},
        success: function(response){
          var data = JSON.parse(response);
          $("#id").val(data.id);
          $("#fname").val(data.first_name);
          $("#lname").val(data.last_name);
          $("#email").val(data.email);
          $("#phone").val(data.phone);
          $("#editModal").modal('show'); 
        }
      });
    });

    // Update ajax request
    $("#update").click(function(e){
      if($("#edit-form-data")[0].checkValidity()){
        e.preventDefault();
        $.ajax({
          url: "action.php",
          type: "POST",
          data: $("#edit-form-data").serialize()+"&action=update",
          success:function(response){
            Swal.fire({
              title: 'User updated successfully!',
              icon: 'success'
            })
            $("#editModal").modal('hide');
            $("#edit-form-data")[0].reset();
            showAllUsers(); 
          }
        });
      }
    });

    // Delete ajax request
    $("body").on("click", ".delBtn", function(e){
      e.preventDefault();
      var del_id = $(this).attr('id');
      var tr = $(this).closest('tr');
      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if(result.value){
          $.ajax({
            url: "action.php",
            type: "POST",
            data: {del_id: del_id},
            success:function(response){
              tr.css('background-color','#ff6666');
              Swal.fire(
                'Deleted!',
                'User deleted successfully!',
                'success'
              )
              showAllUsers();
            }
          });
        }
      });
    });
    // show user details
    $("body").on("click", ".infoBtn", function(e){
  e.preventDefault();
  info_id = $(this).attr('id');
  $.ajax({
    url:"action.php",
    type:"POST",
    data:{info_id:info_id},
    success:function(response){
      data = JSON.parse(response);
      Swal.fire({
        title: '<strong>User Info : ID('+data.id+')</strong>',
        icon: 'info',  // Use 'icon' instead of 'type' for SweetAlert2
        html: '<b>First Name :</b>' + data.first_name + '<br><b>Last Name : </b>' + data.last_name + '<br><b>Email : </b>' + data.email + '<br><b>Phone : </b>' + data.phone,
        showCancelButton: true,
      })
    }
  });
});

  });
</script>
</body>

</html>

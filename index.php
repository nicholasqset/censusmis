<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Census MIS</title>
        <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    </head>
    <body>
        <?php
            require_once 'db.php';
            global $db;
            
            $table = '';
            
            $rs = $db->Execute("select * from census order by dob desc");
            if($rs->RecordCount() > 0){
                $table .= "<table class=\"table\">";
                
                $table .= "<tr>";
                $table .= "<td>#</td>";
                $table .= "<td>First Name</td>";
                $table .= "<td>Middle Name</td>";
                $table .= "<td>Last Name</td>";
                $table .= "<td>Date of birth</td>";
                $table .= "<td>Gender</td>";
                $table .= "<td>Location</td>";
                $table .= "<td>Edit</td>";
                $table .= "<td>Delete</td>";
                $table .= "</tr>";
                
                $count = 0;
                
                while (!$rs->EOF){
                    $count++;
                    
                    $id = $rs->fields['id'];
                    $firstname = $rs->fields['firstname'];
                    $middlename = $rs->fields['middlename'];
                    $lastname = $rs->fields['lastname'];
                    $dob = $rs->fields['dob'];
                    $gender = $rs->fields['gender'];
                    $location = $rs->fields['location'];
                    
                    $edit = "<a href=\"\" onclick=\"edit({$id})\">edit</a>";
                    $delete = "<a href=\"\" onclick=\"purge({$id})\">delete</a>";
                    
                    
                    $table .= "<tr>";
                    $table .= "<td>{$count}</td>";
                    $table .= "<td>{$firstname}</td>";
                    $table .= "<td>{$middlename}</td>";
                    $table .= "<td>{$lastname}</td>";
                    $table .= "<td>{$dob}</td>";
                    $table .= "<td>{$gender}</td>";
                    $table .= "<td>{$location}</td>";
                    $table .= "<td>{$edit}</td>";
                    $table .= "<td>{$delete}</td>";
                    $table .= "</tr>";
                    
                    $rs->MoveNext();
                }
                $table .= "</table>";
            }
            
            
        
        ?>
        
        <section class="container-fluid" style="">
            <div class="container py-5" style=" " id="join">
                <div class="row ">
                    <div class="col-9">
                        <h2>Census Entry Form</h2>
                        <form class="mt-3" name="frmModule" id="frmModule" method="post" action="void%200" onsubmit="return false;">
                            <input type="hidden" id="id" name="id">
                            <div class="row row-cols-1  my-2 g-3">
                                <div class="col">
                                    <label for="firstname">First Name</label>
                                    <input type="text" class="form-control" id="firstname" name="firstname" placeholder="First Name *" >
                                </div>
                            </div>
                            <div class="row row-cols-1  my-2 g-3">
                                <div class="col">
                                    <label for="firstname">Middle Name</label>
                                    <input type="text" class="form-control" id="middlename" name="middlename" placeholder="Middle Name *" >
                                </div>
                            </div>
                            <div class="row row-cols-1  my-2 g-3">
                                <div class="col">
                                    <label for="lastname">Last Name</label>
                                    <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Last Name *" >
                                </div>
                            </div>
                            
                            
                            <div class="row row-cols-1  my-2 g-3">
                                <div class="col">
                                    <label for="dob">Date of birth</label>
                                    <input type="datetime-local" class="form-control" id="dob" name="dob"" >
                                </div>                        
                            </div>
                            
                            <div class="row row-cols-1 row-cols-md-4 my-2 g-3">
                                  <div class="col">
                                    <label for="gender">Gender</label>
                                    <select class="form-control" id="gender" name="gender">
                                        <option value="Female">Female</option>
                                        <option value="Male">Male</option>
                                    </select>
                                </div>                              
                            </div>
                            
                            <div class="row row-cols-1  my-2 g-3">
                                <div class="col">
                                    <label for="nationalid">National ID</label>
                                    <input type="text" class="form-control" id="nationalid" name="nationalid" placeholder="National ID *" >
                                </div>
                            </div>
                            
                             <div class="row row-cols-1  my-2 g-3">
                                <div class="col">
                                    <label for="location">Location</label>
                                    <input type="text" class="form-control" id="location" name="location" placeholder="Location *" >
                                </div>
                            </div>

                            <div class="row my-4">
                                <div class="col-12">
                                    <button class="btn btn-success btn-sm text-white shadow" type="button" onclick="save()">ADD</button>
                                    <button class="btn btn-success btn-sm text-white shadow" type="button" onclick="update()">UPDATE</button>
                                </div>
                            </div>
                        </form>
                        
                        <div id="dv_data_grid">
                            <?php echo $table; ?>
                        </div>
                    </div>
                    <div class="col-3">

                    </div>
                </div>
            </div>
        </section>
        <script type="text/javascript" src="assets/jquery/jquery.js"></script>
        <script type="text/javascript" src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="assets/sweetalert/node_modules/sweetalert/dist/sweetalert.min.js"></script>
        <script>
            $(function() {
                
            });
            
            function save(){
                let firstname = $('#firstname').val();
                let middlename = $('#middlename').val();
                let lastname = $('#lastname').val();
                let dob = $('#dob').val();
                
                if (firstname.trim().length === 0) {
                    alert('First Name cannot be empty');
                    return;
                }

                if (middlename.trim().length === 0) {
                    alert('Middle name cannot be empty');
                    return;
                }
                
                if (lastname.trim().length === 0) {
                    alert('Last name cannot be empty');
                    return;
                }

                if (dob.trim().length === 0) {
                    alert('DOB cannot be empty');
                    return;
                }

                var data = $('#frmModule').serialize();

                $.ajax({
                    url: 'parser/',
                    type: "POST",
                    data: 'function=save&' + data,
                    success: function (response) {
                        response = JSON.parse(response);

                        if (response.status === 1) {
                            swal('', 'Task successfully saved', 'success');
                            location.reload();
                        } else {
                            console.log('error');
                            console.log(response.message);
                            alert(response.message);
                        }
                    },
                    error: function (error) {
                        console.log("error: " + JSON.stringify(error));
                    }
                });
            }
            
            function update(){
                let firstname = $('#firstname').val();
                let middlename = $('#middlename').val();
                let lastname = $('#lastname').val();
                let dob = $('#dob').val();
                
                if (firstname.trim().length === 0) {
                    alert('first Name cannot be empty');
                    return;
                }

                if (middlename.trim().length === 0) {
                    alert('middle name cannot be empty');
                    return;
                }
                
                if (lastname.trim().length === 0) {
                    alert('lastname name cannot be empty');
                    return;
                }

                if (dob.trim().length === 0) {
                    alert('dob cannot be empty');
                    return;
                }

                var data = $('#frmModule').serialize();

                $.ajax({
                    url: 'parser/',
                    type: "POST",
                    data: 'function=save&' + data,
                    success: function (response) {
                        response = JSON.parse(response);

                        if (response.status === 1) {
                            swal('', 'Task successfully updated', 'success');
                            location.reload();
                        } else {
                            console.log('error');
                            console.log(response.message);
                            alert(response.message);
                        }
                    },
                    error: function (error) {
                        console.log("error: " + JSON.stringify(error));
                    }
                });
            }
            
            function edit(id, firstname, middlename, lastname, dob){
                $('#firstname').value = firstname;
                $('#middlename').value = middlename;
                $('#lastname').value = lastname;
                $('#dob').value = dob;
                $('#id').value = id;
            }
            
            function purge(id){
                var data = 'id='+ id;

                $.ajax({
                    url: 'parser/',
                    type: "POST",
                    data: 'function=delete&' + data,
                    success: function (response) {
                        response = JSON.parse(response);

                        if (response.status === 1) {
                            swal('', 'Task successfully deleted', 'success');
                            location.reload();
                        } else {
                            console.log('error');
                            console.log(response.message);
                            alert(response.message);
                        }
                    },
                    error: function (error) {
                        console.log("error: " + JSON.stringify(error));
                    }
                });
            }
        </script>
    </body>
</html>


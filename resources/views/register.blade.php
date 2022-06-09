<!DOCTYPE html>
<html>
<head>
<title>Registration Form</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
<link rel="stylesheet" href="https:////cdn.datatables.net/1.10.9/css/jquery.dataTables.min.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-9 col-lg-8 mx-auto">
                <h3 class="login-heading mb-4">Registration Form</h3>
                <div class="" id="UserMessage"></div>
                <form action="user/add" method="POST" id="adduser" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="form-label-group">
                <label for="name">Name</label>    
                <input type="text" id="name" name="name" class="form-control" placeholder="Name">
                </div> 
                <div class="form-label-group">
                <label for="email">Email </label>  
                <input type="email" name="email" id="email" class="form-control" placeholder="Email" >
                </div> 
                <div class="form-label-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                </div>
                <div>
                    <label for="filename">Resume upload</label>
                    <input id="filename" type="file" name="filename">
                </div>
                <button class="btn btn-lg btn-primary btn-block btn-login text-uppercase font-weight-bold mb-2" type="submit">Sign Up</button>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-md-9 col-lg-8 mx-auto">
                <table id='userTable' class='table table-bordered'>
                    <thead>
                        <tr>
                        <th>S.no</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Resume</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
    <script>

        var table;
        $(document).ready(function() {

            userRecords();

            $("#adduser").validate({
                rules : {
                    name : {
                        required : true,
                    },
                    email : {
                        required : true,
                        email : true
                    },
                    password: {
                        required: true,
                }

                },
                messages : {
                    name : "Please enter name!",
                    email : "Please enter a valid email address",
                    password:"Please enter password"                
                },

                submitHandler : function(e) {

                    var formData = $("#adduser").serialize();

                    //console.log(formData);
                            
                    $.ajax({
                        type : "POST",
                        url : "{{asset('user/add')}}",
                        data : formData,
                        dataType: 'json',

                        success : function(data) {
                            console.log("Data " +data);
                            if(data.status == "200" ){
                                table.ajax.reload(null, false);
                                $('#UserMessage').show();
								$('#UserMessage').removeClass().addClass('alert alert-success').html(data.message);
								$('#UserMessage').delay(3200).fadeOut(300);
                            }
                            else{
                                $('#UserMessage').show();
								$('#UserMessage').removeClass().addClass('alert alert-error').html(data.message);
								$('#UserMessage').delay(3200).fadeOut(300);
                            }                            
                        }
                    })
                }
            });

            function userRecords(){
                table =  $('#userTable').DataTable({
				retrieve: true,				
                ajax : {
                      "url" : 'getUsers',
                      "type" : 'Get'
                    },
                columns: [
                    { data: "id"},
                    { data: "name"},
                    { data: "email"},
                    { data: "resume_link"}                   
                ],
                 "order": [[ 1, 'desc' ]]
                });
                table.on( 'order.dt', function () {
			        table.column(0, {order:'applied'}).nodes().each( function (cell, i) {
			            cell.innerHTML = i+1;
			        } );
			    } ).draw();
            }

        });
    </script>
</body>
</html>

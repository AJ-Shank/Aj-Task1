<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>User Profiles</title>

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
  <link rel="stylesheet" href="/assets/css/starter.css">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
  <!-- <script src = "/assets/jquery-3.2.1.min.js"></script> -->

  </head>

  <body>
    <nav class="navbar navbar-toggleable-md navbar-inverse bg-inverse fixed-top">
          <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <a class="navbar-brand" href="#">Navbar</a>

          <div class="collapse navbar-collapse" id="navbarsExampleDefault">
              <li class="nav-item active">
                <ul class="navbar-nav mr-auto">
                <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
              </li>
            </ul>
          </div>
        </nav>

        <div class="container">
          <div class="starter-template">
            <table class="table table-bordered table-striped">
              <thead class="thead-inverse">
                <tr>
                  <th>#</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Age</th>
                  <th>Date of Birth</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($details as $user) {
                  ?>
                  <tr>
                    <th scope="row"><?=$user['id']?></th>
                    <td><?=$user['name']?></td>
                    <td><?=$user['email']?></td>
                    <td><input id='age' type="number" value="<?=$user['profile']['age']?>" onchange="changeData('<?=$user['id']?>','age',this.value)"></td>
                    <td><input id='dob' type="date" value="<?=$user['profile']['DOB']?>" onchange="changeData('<?=$user['id']?>','dob',this.value)"></td>
                  </tr>
                  <?php
                } ?>

              </tbody>
            </table>
            <center>
              <a class='btn btn-default' href='<?=$prev?>'><span class="fa fa-chevron-left"> </span> Prev </a>
              <a class='btn btn-default' href='<?=$next?>'> Next <span class="fa fa-chevron-right"></span></a>
            </center>
          </div>
        </div><!-- /.container -->
        <div id='msg' class="alert alert-danger" role="alert" style="position:absolute;bottom:25px;margin-left:auto;margin-right:auto;width:100%;text-align:center;visibility:hidden;">
        </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>

    <script>
      function changeData(id,record,value){
        console.log("user=" + id+ "&record="+record+"&value="+value);
        $.ajax({

                type:'PUT',
                url:'/user-profiles/'+id,
                data:{'record':record,'value':value, "_token": "{{ csrf_token() }}"},
                success:function(data){
                  $("#msg").css('visibility','visible');
                   $("#msg").html(record+' of user '+id+' changed to '+value);
                   setTimeout(function(){ $("#msg").css('visibility','hidden'); }, 2000);
                }
             });
      }
    </script>

  </body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>User Profiles</title>

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
  <link rel="stylesheet" href="/assets/css/starter.css">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
  <!-- <script src = "/assets/jquery-3.2.1.min.js"></script> -->

</head>

<body onload="getdata('','')">
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
      <?php if(!isset($id)){?>
        <div class="container">
          <div class="row">
            <div class="col-md-9"><input class="form-control" placeholder="Search" id='search' ></div>
            <div class="col-md-3"><button type="submit" class="btn btn-success btn-block" >Submit</button></div>
          </div>
          <label for="amount">Age range:</label>
          <input type="text" id="lower" name="lower" readonly style="border:0; color:#f6931f; font-weight:bold; width:25px;"> Years
          <strong>-</strong>
          <input type="text" id="upper" name="upper" readonly style="border:0; color:#f6931f; font-weight:bold; width:25px;">Years
          <div class="row" ><div class="col-md-9" id="slider-range"></div>
          <div class="col-md-3"><button class="btn btn-default" type="submit">Add Filter</button> </div>
        </div>
      </div>
      <?php } ?>
      <div class="container" style="padding-top:20px">
        <table class="table table-bordered table-striped">
          <thead class="thead-inverse">
            <tr>
              <th><a href="#" onclick="getdata('sort','')" >#</a></th>
              <th><a href="#" onclick="getdata('sort','name')" >Name</a></th>
              <th>Email</th>
              <th>Age</th>
              <th><a href="#" onclick="getdata('sort','dob')" >Date of Birth</a></th>
            </tr>
          </thead>
          <tbody id=usertable>
          </tbody>
        </table>
      </div>
      <center>
        <a class='btn btn-default' href='#'><span class="fa fa-chevron-left"> </span> Prev </a>
        <a class='btn btn-default' href='#'> Next <span class="fa fa-chevron-right"></span></a>
      </center>
    </div>
  </div><!-- /.container -->
  <div id='msg' class="alert alert-danger" role="alert" style="position:absolute;bottom:25px;margin-left:auto;margin-right:auto;width:100%;text-align:center;visibility:hidden;">
  </div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
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
        $("#age_"+id).html(data['age']);
        $("#msg").html(record+' of user '+id+' changed to '+value+' and new age is '+data['age']);
        setTimeout(function(){ $("#msg").css('visibility','hidden'); }, 2000);
      }
    });
  }
  function getdata(key,value){
    var x = window.location.search.substring(1,window.location.search.length);
    var y = x.split('&');
    var prev={};
    for (var i=0;i<y.length;i++){
      var z=y[i].split('=');
      prev[z[0]]=z[1];
    }
    prev[key]=value;
    // console.log(prev);
    $.ajax({
      type:'get',
      url:'/ajax-profiles/<?php if(isset($id)) echo $id; ?>',
      data:prev,
      success:function(data){
        window.history.pushState('', 'Filtered Data', data['url']);
        var content = '';
        for(var i=0;i<data['data'].length;i++){
          content+='<tr>';
          content+='<th scope="row"><a href="/user-profiles/'+data['data'][i]['id']+'">'+data['data'][i]['id']+'</a></th>';
          content+='<td>'+data['data'][i]['name']+'</td>';
          content+='<td>'+data['data'][i]['email']+'</td>';
          content+='<td id="age_'+data['data'][i]['id']+'">'+data['data'][i]['profile']['age']+'</td>';
          content+='<td><input id="dob" type="date" value="'+data['data'][i]['profile']['DOB']+'" onchange="changeData(\''+data['data'][i]['id']+'\',\'dob\',this.value)"></td>'
          content+='</tr>'
        }
        $("#usertable").html('');
        $("#usertable").html(content);
      }
    });
  }
  </script>
  <script>
  $( function() {
    $( "#slider-range" ).slider({
      range: true,
      min: 0,
      max: 120,
      values: [ 10, 70 ],
      slide: function( event, ui ) {
        $( "#lower" ).val( ui.values[ 0 ] );
        $( "#upper" ).val( ui.values[ 1 ] );
      }
    });
    $( "#amount" ).val( "$" + $( "#slider-range" ).slider( "values", 0 ) +
    " - $" + $( "#slider-range" ).slider( "values", 1 ) );
  } );
  </script>
</body>
</html>

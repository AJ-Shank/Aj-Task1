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
            <div class="col-md-3"><button for="search" type="submit" class="btn btn-success btn-block"  onclick="getdata('search',document.getElementById('search').value)">Submit</button></div>
          </div>
          <label for="amount">Age range:</label>
          <input type="text" id="lower" name="lower" value="10" readonly style="border:0; color:#f6931f; font-weight:bold; width:25px;"> Years
          <strong>-</strong>
          <input type="text" id="upper" name="upper" value="70" readonly style="border:0; color:#f6931f; font-weight:bold; width:25px;">Years
          <div class="row" ><div class="col-md-8" id="slider-range"></div>
          <div class="col-md-2"><button class="btn btn-default" type="submit" onclick="ageRange()">Add Filter</button> </div>
          <div class="col-md-2"><button class="btn btn-warning" type="submit" onclick="removefilter()">Remove all Filters</button> </div>
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
        <a class='btn btn-default' id=prev href='#'><span class="fa fa-chevron-left"> </span> Prev </a>
        <a class='btn btn-default' id=next href='#'> Next <span class="fa fa-chevron-right"></span></a>
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
  function removefilter(){
    window.history.pushState('','','/user-profiles');
    getdata('','');
  }
  function ageRange(){
     window.history.pushState('', '', window.location.search+'&lower='+ document.getElementById('lower').value);
    getdata('upper',document.getElementById('upper').value);
  }
  function changeData(id,record,value){
    console.log("user=" + id+ "&record="+record+"&value="+value);
    $.ajax({

      type:'PUT',
      url:'/user-profiles/'+id,
      data:{'record':record,'value':value, "_token": "{{ csrf_token() }}"},
      success:function(data){
        $("#msg").css('visibility','visible');
        if(data['status']=='success'){
          $("#age_"+id).html(data['update']['age']);
          $("#msg").removeClass();
          $("#msg").addClass('alert alert-success')
          $("#msg").html(data['msg']);
        }else{
          $("#msg").removeClass();
          $("#msg").addClass('alert alert-danger')
          $("#msg").html(data['msg']);
        }
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
    if(key=='sort' && prev.hasOwnProperty(key)){
      if(prev[key]==value){
        if(!prev.hasOwnProperty('order')) prev['order']='desc';
        else {
          if(prev['order']=='desc') prev['order']='asc';
          else prev['order']='desc';
        }
      }else{
        prev['order']='asc'
      }
    }
    prev[key]=value;
    console.log(prev);
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
          content+='<td><input class="userdob" id="dob" type="date" max="2017-01-01" value="'+data['data'][i]['profile']['DOB']+'" onchange="changeData(\''+data['data'][i]['id']+'\',\'dob\',this.value)"></td>'
          content+='</tr>'
        }
        $("#usertable").html('');
        $("#usertable").html(content);
        $("#prev").attr('href',data['prev']);
        $("#next").attr('href',data['next']);
      }
    });
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1; //January is 0!
    var yyyy = today.getFullYear();
     if(dd<10){
            dd='0'+dd
        }
      if(mm<10){
          mm='0'+mm
      }
    today = yyyy+'-'+mm+'-'+dd;
    var c = document.getElementsByClassName('userdob');
    for(var i=0;i<c.length;i++){
      c[i].setAttribute("max", today);
    }
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

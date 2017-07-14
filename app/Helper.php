<?php
  function buildGetQuery($key,$value){
    $data=Request::all();
    $data[$key]=$value;
    return Request::url().'?'.http_build_query($data);
  }
 ?>

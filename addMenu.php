<?php 
  $file = fopen("./menuList.txt", 'r');
  $menuList = fread($file,filesize("./menuList.txt"));
  $new_menu = $_GET['menu'];
  
  if ($menuList=="") {
    $menuList .= $new_menu;
  } else {
    $menuList .= " ,".$new_menu;
  }
  fwrite($file, $$menuList);

  fclose($file);
  
  echo $menuList;
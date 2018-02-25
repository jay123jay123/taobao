<?php
session_start();
header('Content-type:text/html;charset=utf-8');   
if(isset($_SESSION['username']) && $_SESSION['username']==='1016'){
    header('location:/sales/');
}

if(isset($_POST['submit'])){
    if(isset($_POST['username']) && isset($_POST['password']) && $_POST['username']=='1016' && $_POST['password']=='1119' ){
            $_SESSION['username']=$_POST['username'];
            header('location:/sales/');
        
    }  else {
        header('location:/sales/2/');
    }
}


?>

<div class="container">
  <div class="row shadow-sm pb-md-4 pt-md-4 mb-4 border">
        <div class="col-md-3 text-center  ">
            <h3>Unsaidstuff</h3>
        </div>
        
        <div class="col-md-5 text-right">
            <form class="form-inline" action="<?php echo base_url('home/search') ?>">
                <div class="input-group col-md-12 pl-md-0">
                    <input type="text" class="form-control" placeholder="Search by Firstname Lastname" name="search">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit"><i class="fas fa-search fa-lg"></i></button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-4">
            <ul class="nav justify-content-end">
            <?php if(!empty($_SESSION['user'])) { ?>
            
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url() ?>">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url("user/".$_SESSION['user']['user_id']) ?>">My Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url("home/logout") ?>">Sign out</a>
                </li>
                <!--<li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">Profile</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="<?php echo base_url("user/".$_SESSION['user']['user_id']) ?>">My Profile</a>
                        <a class="dropdown-item" href="<?php echo base_url("home/logout") ?>">Sign out</a>
                </li>-->
            
            <?php } else { ?> 
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url('login') ?>">Login</a>
                </li>        
            <?php } ?>
            </ul>
      </div>
  </div>  
  <br>
  <?php
  if(!empty($_SESSION['msg'])) {
  ?>
  <div class="row">
      <div class="col-md-12">
        <div class="alert alert-danger text-center lead font-weight-bold">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <?php echo $_SESSION['msg'] ?>
        </div>
      </div>
  </div>
  <?php
  $_SESSION['msg']='';    
  }
  ?>

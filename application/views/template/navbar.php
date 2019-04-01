<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="<?php echo site_url('UserCtrl/index');?>">AUMS</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">
            <li><a href="<?php echo site_url('UserCtrl/index');?>">Home</a></li>
            <li><a href="<?php echo site_url('UserCtrl/profile/'.$this->session->userdata('user_id'));?>">Profile</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <?php if($this->session->userdata('username') != ''): ?>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $this->session->userdata('username');?> <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo site_url('UserCtrl/deleteAccount/'.$this->session->userdata('user_id'));?>">Delete account</a></li>
                        <li><a href="<?php echo site_url('UserCtrl/logout');?>">Logout</a></li>
                    </ul>
                </li>
                <?php else: ?>
                <li>
                    <a href="<?php echo site_url('UserCtrl/register');?>" class="btn btn-link" style="display:inline-block">Register</a>
                </li>
                <li>
                    <a href="<?php echo site_url('UserCtrl/login');?>" class="btn btn-link">Login</a>                
                </li>
            <?php endif; ?>
        </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
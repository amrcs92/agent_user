<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h2 class="panel-title text-center"><strong>Login</strong></h2>
                </div>
                <div class="panel-body">
                    <?php if($this->session->flashdata('success')): ?>
                        <div class="alert alert-success" role="alert">
                            <h5><?php echo $this->session->flashdata('success'); ?></h5>
                        </div>
                    <?php endif;?>
                    <?php if($this->session->flashdata('error')): ?>
                        <div class="alert alert-danger" role="alert">
                            <h5><?php echo $this->session->flashdata('error'); ?></h5>                    
                        </div>
                    <?php endif; ?>
                    <?php if($this->session->flashdata('file_check')): ?>
                        <div class="alert alert-danger" role="alert">
                            <h5><?php echo $this->session->flashdata('file_check'); ?></h5>                    
                        </div>
                    <?php endif; ?>
                    <?php echo form_open('UserCtrl/getUser');?>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" name="username" id="username" class="form-control" value="<?php if(get_cookie('username')){ echo get_cookie('username'); }?>" placeholder="Please enter your username">
                            <span class="text-danger"><?php echo form_error('username')?></span>
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" class="form-control" value="<?php if(get_cookie('password')){ echo get_cookie('password'); }?>" placeholder="Please enter you password">
                            <span class="text-danger"><?php echo form_error('password')?></span>
                        </div>
                        <div class="form-group">
                            <a href="<?php echo site_url('UserCtrl/forgetPass');?>" class="text-primary col-md-4">Forgot password ?</a>
                            <a href="<?php echo site_url('UserCtrl/register');?>" class="text-secondary col-md-4">Not Registered ?</a>                
                            <div class="form-check col-md-4" style="display:inline-block;">
                                <input type="checkbox" name="remember_me" id="remember_me" class="form-check-input" value="Remember me">
                                <label for="remember_me">Remember me</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <button name="login" class="btn btn-success btn-lg btn-block">Login</button>
                        </div>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</div>
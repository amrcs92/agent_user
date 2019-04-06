<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-warning">
                <div class="panel-heading">
                    <h2 class="panel-title text-center"><strong>Change your forgot password !!</strong></h2>        
                </div>
                <div class="panel-body">
                    <?php if(isset($data['error'])): ?>
                        <div class="alert alert-danger text-center">
                            <i class="glyphicon glyphicon-exclamation-sign"></i> <?php echo $data['error']; ?>
                        </div>    
                    <?php endif;?>
                    <?php if(isset($token_expired)):?>
                        <div class="alert alert-danger text-center">
                            <strong><i class="glyphicon glyphicon-exclamation-sign"></i> <?php echo $token_expired; ?></strong>
                        </div>
                        <?php else: ?>
                        <div class="alert alert-info text-center">
                            <strong><i class="glyphicon glyphicon-info-sign"></i> <?php echo $token_will_expire; ?></strong>
                        </div>
                    <?php endif;?>

                    <?php echo form_open('UserCtrl/changeForgetPassword/'.$this->uri->segment('3').'/'.$this->uri->segment('4').'/'.$this->uri->segment('5')); ?>
                        <div class="form-group">
                            <label for="new_pass">New Password <span class="text-danger">*</span></label>
                            <input type="password" name="new_password" id="new_pass" class="form-control" placeholder="Enter your new password..">
                            <span class="text-danger"><?php echo form_error('new_password')?></span>
                        </div>
                        <div class="form-group">
                            <label for="same_pass">New Password again <span class="text-danger">*</span></label>
                            <input type="password" name="same_password" id="same_pass" class="form-control" placeholder="Enter your new password again..">
                            <span class="text-danger"><?php echo form_error('same_password')?></span>
                        </div>
                        <button type="submit" class="btn btn-danger btn-block" name="change_pass">Change Password</button>
                    </form>
                </div>    
            </div>
        </div>    
    </div>
</div>
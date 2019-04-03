<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-warning">
                <div class="panel-heading">
                    <h2 class="panel-title text-center"><strong>Change your forgot password !!</strong></h2>        
                </div>
                <div class="panel-body">
                    <?php if(isset($data['error'])):?>
                        <?php echo $data['error']; ?>
                    <?php endif;?>

                    <?php echo form_open('UserCtrl/changePassword/'.$this->uri->segment('3').'/'.$this->uri->segment('4')); ?>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control" value="<?php echo $this->uri->segment('3'); ?>">
                        </div>
                        <div class="form-group">
                            <label for="new_pass">New Password <span class="text-danger">*</span></label>
                            <input type="password" name="new_password" id="new_pass" class="form-control" placeholder="Enter your new password..">
                        </div>
                        <div class="form-group">
                            <label for="same_pass">New Password again <span class="text-danger">*</span></label>
                            <input type="password" name="same_password" id="same_pass" class="form-control" placeholder="Enter your new password again..">
                        </div>
                        <button class="btn btn-danger btn-block" name="change_pass">Change Password</button>
                    </form>
                </div>    
            </div>
        </div>    
    </div>
</div>
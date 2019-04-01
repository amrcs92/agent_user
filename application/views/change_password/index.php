<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-warning">
                <div class="panel-heading">
                    <h2 class="panel-title text-center"><strong>Change your password !!</strong></h2>        
                </div>
                <div class="panel-body">
                    <div class="form-group text-center">
                        <?php if($this->session->flashdata('wrong_old_password')):?>
                            <span class="alert alert-danger"><?php echo $this->session->flashdata('wrong_old_password'); ?></span>
                        <?php endif; ?>
                         <?php if($this->session->flashdata('old_match_new')):?>
                            <span class="alert alert-danger"><?php echo $this->session->flashdata('old_match_new'); ?></span>
                        <?php endif; ?>
                    </div>
                    <?php echo form_open('UserCtrl/changePassword/'.$this->session->userdata('user_id')); ?>
                        <div class="form-group">
                            <label for="old_pass">Current Password <span class="text-danger">*</span></label>
                            <input type="password" name="old_password" id="old_pass" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="new_pass">New Password <span class="text-danger">*</span></label>
                            <input type="password" name="new_password" id="new_pass" class="form-control">
                        </div>
                        <button class="btn btn-danger btn-block" name="change_pass">Change Password</button>
                    </form>
                </div>    
            </div>
        </div>    
    </div>
</div>
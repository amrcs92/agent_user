<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Your Profile
                        <a href="<?php echo site_url('UserCtrl/editProfile');?>" style="margin-top:-8px;" class="btn btn-link pull-right"><i class="glyphicon glyphicon-pencil"></i> Edit profile</a>
                    </h3>                    
                </div>
                <div class="panel-body text-center">
                    <?php if($this->session->flashdata('update_success')):?>
                        <span class="alert alert-success"><?php echo $this->session->flashdata('update_success');?></span>
                    <?php endif;?>
                    <?php if($this->session->flashdata('password_changed')):?>
                        <span class="alert alert-success"><?php echo $this->session->flashdata('password_changed')?></span>
                    <?php endif;?>
                    <img class="img-rounded" src="<?php echo $company_logo?base_url().'application/uploads/'.$company_logo:'https://via.placeholder.com/230x200'; ?>" height="200">
                    <h3 class="text-center"><?php echo $username; ?></h3>
                    <h4 class="text-center"><?php echo $email; ?></h4>
                    <h4 class="text-center"><?php echo $company_name?></h4>
                    <h4 class="text-center"><?php echo $phone?></h4>
                    <h4 class="text-center"><?php echo $mobile1?></h4>
                    <h4 class="text-center"><?php echo $mobile2?></h4>
                    <h4 class="text-center"><?php echo $address?></h4>
                    <h4 class="text-center"><?php echo $postal_code?></h4>
                    <h4 class="text-center"><?php echo $country?></h4>
                    <h4 class="text-center"><?php echo $state?></h4>
                </div>
            </div>
        </div>        
    </div>
</div>
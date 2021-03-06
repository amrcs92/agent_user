<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h2 class="panel-title text-center"><strong>Register</strong></h2>        
                </div>
                <div class="panel-body light-grey-bg">
                    <?php echo form_open_multipart('UserCtrl/createUser'); ?>
                        <div class="form-group col-md-6">
                            <label for="username">Username <span class="text-danger">*</span></label>
                            <input type="text" id="username" name="username" value="<?php echo set_value('username');?>" placeholder="Enter your username" class="form-control">
                            <span class="text-danger"><?php echo form_error('username');?></span>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="email">Email <span class="text-danger">*</span></label>
                            <input type="email" id="email" name="email" value="<?php echo set_value('email');?>" placeholder="Enter your email address" class="form-control">
                            <span class="text-danger"><?php echo form_error('email');?></span>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="password">Password <span class="text-danger">*</span></label>
                            <input type="password" id="password" name="password" value="<?php echo set_value('password');?>" placeholder="Enter your Password (8 characters at least)" class="form-control">
                            <span class="text-danger"><?php echo form_error('password');?></span>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="agent_name">First & last name <small>(optional)</small></label>
                            <input type="text" id="agent_name" name="agent_name" value="<?php echo set_value('agent_name');?>" placeholder="Enter your First & last name" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="company_name">Company name <span class="text-danger">*</span></label>
                            <input type="text" id="company_name" name="company_name" value="<?php echo set_value('company_name');?>" placeholder="Enter your company name" class="form-control">
                            <span class="text-danger"><?php echo form_error('company_name');?></span>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="company_logo">Company Logo <small>(optional)</small></label>
                            <input type="file" id="company_logo" name="company_logo" value="<?php echo set_value('company_logo');?>" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="phone">Phone <small>(optional)</small></label>
                            <input type="text" id="phone" name="phone" placeholder="Enter your phone number" value="<?php echo set_value('phone');?>" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="mobile1">Mobile 1 <small>(optional)</small></label>
                            <input type="text" id="mobile1" name="mobile1" placeholder="Enter your 1st mobile number" value="<?php echo set_value('mobile1');?>" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="mobile2">Mobile 2 <small>(optional)</small></label>
                            <input type="text" id="mobile2" name="mobile2" placeholder="Enter your 2nd mobile number" value="<?php echo set_value('mobile2');?>" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="address">Address <small>(optional)</small></label>
                            <input type="text" id="address" name="address" placeholder="Enter your address" value="<?php echo set_value('address');?>" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="postal_code">Postal Code <small>(optional)</small></label>
                            <input type="text" id="postal_code" name="postal_code" placeholder="Enter your postal code" value="<?php echo set_value('postal_code');?>" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="country">Country <small>(optional)</small></label>
                            <select id="country" name="country" class="form-control">
                                <option value="">-- Please Select Country --</option>
                                <option value="egypt">Egypt</option>
                                <option value="usa">USA</option>                
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="state">State <small>(optional)</small></label>
                            <select id="state" name="state" class="form-control">
                                <option value="">-- Please Select State --</option>
                                <option value="alexandria">Alexandria</option>
                                <option value="cairo">Cairo</option>
                                <option value="alabama">Alabama</option>
                                <option value="kentucky">Kentucky</option>
                                <option value="florida">Florida</option>
                            </select>
                        </div>
                        <div class="form-group col-md-12">
                            <button class="btn btn-primary btn-block" id="register" name="register">Register</button>
                        </div>
                    </form>                
                </div>
            </div>        
        </div>
    </div>
</div>
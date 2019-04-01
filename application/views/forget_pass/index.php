<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-danger">
                <div class="panel-heading">
                    <h3 class="panel-title">-:Reset your account:-</h3>
                </div>    
                <div class="panel-body">
                    <?php echo form_open('UserCtrl/resetPass'); ?>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="your-mail@example.com">
                        </div>
                        <div class="form-group text-center">
                            <button name="reset" class="btn btn-block btn-success"><i class="glyphicon glyphicon-refresh"></i> Reset Password</button>
                        </div>
                    </form>
                </div>
            </div>    
        </div>
    </div>
</div>
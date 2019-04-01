<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-danger">
                <div class="panel-heading">
                    <h2 class="panel-title text-center"><strong>Remove Account (Danger Zone !!!)</strong></h2>        
                </div>
                <div class="panel-body">
                    <p style="padding-top:10px"></p> 
                    <?php echo form_open('UserCtrl/deleteUser/'.$this->session->userdata('user_id'), array('class'=>'text-center'))?>
                        <button class="btn btn-danger"><i class="glyphicon glyphicon-trash"></i> Delete Account</button>
                    </form>   
                    <p style="padding-bottom:10px"></p> 
                </div>
            </div>    
        </div>
    </div>
</div>
<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Welcome to User Agent Management system</h1>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <tr>
                        <td><b>IP Address</b></td>
                        <td><?php echo $ip_address; ?></td>
                    </tr>
                    <tr>
                        <td><b>Operating System</b></td>
                        <td><?php echo $device_type; ?></td>
                    </tr>
                    <tr>
                        <td><b>Browser Details</b></td>
                        <td><?php echo $browser_details; ?></td>
                    </tr>
                    <tr>
                        <td><b>Last time loggedin</b></td>
                        <td><?php echo $last_login; ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

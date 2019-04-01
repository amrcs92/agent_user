<script src="<?php echo base_url().'public/js/jquery.min.js'?>"></script>
<script src="<?php echo base_url().'public/js/bootstrap.min.js'?>"></script>
<script>
    $(document).ready(function(){
        var selected_option = $('#country option:selected');
        if(selected_option){
            $('#country').val("<?php echo $country??''; ?>");
        }
        var selected_option = $('#state option:selected');
        if(selected_option){
            $('#state').val("<?php echo $state??''; ?>");
        }
    });
</script>
</body>
</html>
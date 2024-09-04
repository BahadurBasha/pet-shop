<style>
    #uni_modal .modal-content>.modal-footer,#uni_modal .modal-content>.modal-header{
        display:none;
    }
</style>
<div class="container-fluid">
    <form action="" id="registration">
        <div class="row">
        
        <h3 class="text-center">Create New Account
            <span class="float-right">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </span>
        </h3>
            <hr>
        </div>
        <div class="row  align-items-center h-100">
            
            <div class="col-lg-5 border-right">
                
                <div class="form-group">
                    <label for="" class="control-label">Firstname</label>
                    <input type="text" class="form-control form-control-sm form" name="firstname" required>
                </div>
                <div class="form-group">
                    <label for="" class="control-label">Lastname</label>
                    <input type="text" class="form-control form-control-sm form" name="lastname" required>
                </div>
                <div class="form-group">
                    <label for="" class="control-label">Contact</label>
                    <input type="number" class="form-control form-control-sm form" name="contact" required>
                </div>
                <div class="form-group">
                    <label for="" class="control-label">Gender</label>
                    <select name="gender" id="" class="custom-select select" required>
                        <option>Male</option>
                        <option>Female</option>
                    </select>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="form-group">
                    <label for="" class="control-label">Default Delivery Address</label>
                    <textarea class="form-control form" rows='3' name="default_delivery_address"></textarea>
                </div>
                <div class="form-group">
                    <label for="" class="control-label">Email</label>
                    <input type="email" class="form-control form-control-sm form" name="email" required>
                </div>
                <div class="form-group">
                    <label for="" class="control-label">Password</label>
                    <input type="password" class="form-control form-control-sm form" name="password" required>
                </div>
                <div class="form-group d-flex justify-content-between">
                    <a href="javascript:void()" id="login-show">Already have an Account</a>
                    <button class="btn btn-primary btn-flat">Register</button>
                </div>
            </div>
        </div>
    </form>

</div>
<script>
    $(function(){
        $('#login-show').click(function(){
            uni_modal("","login.php");
        });

        $('#registration').submit(function(e){
            e.preventDefault();
            start_loader();

            if($('.err-msg').length > 0)
                $('.err-msg').remove();

            // Form Validation
            var valid = true;

            // Validation for Firstname and Lastname
            var nameRegex = /^[a-zA-Z]+$/;
            var firstname = $('[name="firstname"]').val().trim();
            var lastname = $('[name="lastname"]').val().trim();
            
            if (!nameRegex.test(firstname) || !nameRegex.test(lastname)) {
                var nameErrorMsg = $('<div>').addClass("alert alert-danger err-msg").text("Invalid name. Please use only letters.");
                $('[name="lastname"]').after(nameErrorMsg);
                valid = false;
            }

            // Validation for Email
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            var email = $('[name="email"]').val().trim();

            if (!emailRegex.test(email)) {
                var emailErrorMsg = $('<div>').addClass("alert alert-danger err-msg").text("Invalid email address.");
                $('[name="email"]').after(emailErrorMsg);
                valid = false;
            }

            if (!valid) {
                end_loader();
                return;
            }

            // Continue with the form submission
            $.ajax({
                url: _base_url_ + "classes/Master.php?f=register",
                method: "POST",
                data: $(this).serialize(),
                dataType: "json",
                error: err => {
                    console.log(err);
                    alert_toast("An error occurred", 'error');
                    end_loader();
                },
                success: function(resp){
                    if (typeof resp == 'object' && resp.status == 'success'){
                        alert_toast("Account successfully registered", 'success');
                        setTimeout(function(){
                            location.reload();
                        }, 2000);
                    } else if (resp.status == 'failed' && !!resp.msg){
                        var _err_el = $('<div>').addClass("alert alert-danger err-msg").text(resp.msg);
                        $('[name="password"]').after(_err_el);
                        end_loader();
                    } else {
                        console.log(resp);
                        alert_toast("An error occurred", 'error');
                        end_loader();
                    }
                }
            });
        });
    });
    /*$(function(){
        $('#login-show').click(function(){
            uni_modal("","login.php")
        })
        $('#registration').submit(function(e){
            e.preventDefault();
            start_loader()
            if($('.err-msg').length > 0)
                $('.err-msg').remove();
            $.ajax({
                url:_base_url_+"classes/Master.php?f=register",
                method:"POST",
                data:$(this).serialize(),
                dataType:"json",
                error:err=>{
                    console.log(err)
                    alert_toast("an error occured",'error')
                    end_loader()
                },
                success:function(resp){
                    if(typeof resp == 'object' && resp.status == 'success'){
                        alert_toast("Account succesfully registered",'success')
                        setTimeout(function(){
                            location.reload()
                        },2000)
                    }else if(resp.status == 'failed' && !!resp.msg){
                        var _err_el = $('<div>')
                            _err_el.addClass("alert alert-danger err-msg").text(resp.msg)
                        $('[name="password"]').after(_err_el)
                        end_loader()
                        
                    }else{
                        console.log(resp)
                        alert_toast("an error occured",'error')
                        end_loader()
                    }
                }
            })
        })
       
    })*/
</script>
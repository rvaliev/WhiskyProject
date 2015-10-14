jQuery(function(){

    /**
     * Trigger pop-up windows
     */
    jQuery("a.show-login").click(function(event){
        event.preventDefault();
        jQuery(".lightbox-panel-register").fadeOut(300);
        jQuery(".lightbox-panel-recover").fadeOut(300);
        jQuery(".lightbox-panel-login").fadeIn(300);
        //return false; // instead of event.preventDefault() because preventDefault doesn't work in Firefox properly
    });

    jQuery("a.show-register").click(function(event){
        event.preventDefault();
        jQuery(".lightbox-panel-login").fadeOut(300);
        jQuery(".lightbox-panel-recover").fadeOut(300);
        jQuery(".lightbox-panel-register").fadeIn(300);
        //return false;
    });

    jQuery("a.close-panel-login").click(function(event){
        event.preventDefault();
        jQuery(".lightbox-panel-login").fadeOut(300);
        //return false;
    });

    jQuery("a.close-panel-register").click(function(event){
        event.preventDefault();
        jQuery(".lightbox-panel-register").fadeOut(300);
        //return false;
    });

    /**
     * Handle authorization.
     */
    jQuery('#login_form').submit(function(e) {
        e.preventDefault();
        jQuery.ajax({
            type:"POST",
            async:false,
            url:"authorization.php",
            data: jQuery("#login_form").serialize(),
            success: function(response){
                jQuery(".error_reporting").addClass('result').css('visibility','visible');
                jQuery(".result").html(response);

            }
        });
    }); // End Handle authorization



    /**
     * Handle registration.
     */
    jQuery('#register_form').submit(function(e) {
        e.preventDefault();
        jQuery.ajax({
            type:"POST",
            async:false,
            url:"registration.php",
            data: jQuery("#register_form").serialize(),
            success: function(response){
                jQuery(".error_reporting_registration").addClass('result_registration').css('visibility','visible');
                jQuery(".result_registration").html(response);

            }
        });
    }); // End Handle registration




    /**
     * Password section
     * Triggering 'change password' button
     */
    // Triggering 'change password' button
    jQuery(".changePass").click(function(){
        event.preventDefault(); // prevents link to open page
        jQuery("#passwordBlock").fadeToggle(300);
        jQuery('.passClass').attr('disabled', function(i, v) { return !v; }); // toggles 'disabled' attribute in password input fields
        jQuery('.dontChangePass').css('display', 'table');
        jQuery(this).css('display', 'none');
    });

    // Triggering 'don't change password' button
    jQuery(".dontChangePass").click(function(){
        event.preventDefault(); // prevents link to open page
        jQuery("#passwordBlock").fadeToggle(300);
        jQuery('.passClass').attr('disabled', function(i, v) { return !v; }); // toggles 'disabled' attribute in password input fields
        jQuery('.changePass').css('display', 'table');
        jQuery(this).css('display', 'none');
    });


    /**
     * Show selected image in 'uploadFile' block
     */
    var imageUploader = document.getElementById("imgUploader");
    if(typeof(imageUploader) != "undefined" && imageUploader !== null) {
        document.getElementById("imgUploader").onchange = function () {
            document.getElementById("uploadFile").value = this.value.substring(12);
            document.getElementById("uploadFile").style.display = "block";
        };
    }


    /**
     * USER INPUT DATA VALIDATION
     */
    validatedEmail = false;
    validatedPassword = false;
    validatedPasswordRepeat = false;
    validatedName = false;
    validatedUsername = false;

    // E-mail validation
    jQuery('.email').keyup(function(){
        var email = jQuery(this).val().trim();

        if(is.email(email))
        {
            jQuery(this).removeClass('red').addClass('green');
            validatedEmail = true;
        }
        else
        {
            jQuery(this).removeClass('green').addClass('red');
            validatedEmail = false;
        }
    });


    // Password validation
    jQuery('.password').keyup(function(){
        passwordOne = jQuery(this).val().trim();
        validatedPassword = validatePassword(passwordOne, jQuery(this));
    });

    // PasswordRepeat validation
    jQuery('.passwordRepeat').keyup(function(){
        passwordRepeat = jQuery(this).val().trim();
        validatedPasswordRepeat = validatePassword(passwordRepeat, jQuery(this));
    });

    function validatePassword(password, passwordObject)
    {
        var passRegExp = password.match(/^.*(?=.{8,})(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).*$/);

        if(passRegExp == password)
        {
            passwordObject.removeClass('red').addClass('green');
            return true;
        }
        else
        {
            passwordObject.removeClass('green').addClass('red');
            return false;
        }
    }




    // Enable button on log in window if all fields are filled correctly
    jQuery('.password, .email').keyup(function(){

        if((validatedEmail == true) && (validatedPassword == true))
        {
            jQuery('.submitBtn').prop('disabled', false);
        }
        else
        {
            jQuery('.submitBtn').prop('disabled', true);
        }
    });



    // Firstname, lastname validation
    jQuery('.name').keyup(function(){

        var name = jQuery(this).val().trim();
        var nameRegExp = name.match(/^([A-Za-z '`-éèçàëê]{2,30})$/gm);  // https://regex101.com

        if(name == nameRegExp)
        {
            jQuery(this).removeClass('red').addClass('green');
            validatedName = true;
        }
        else
        {
            jQuery(this).removeClass('green').addClass('red');
            validatedName = false;
        }
    });


    // username validation - alphanumeric
    jQuery('.username').keyup(function (){
        var userName = jQuery(this).val().trim();

        if(is.alphaNumeric(userName))
        {
            jQuery(this).removeClass('red').addClass('green');
            validatedUsername = true;
        }
        else
        {
            jQuery(this).removeClass('green').addClass('red');
            validatedUsername = false;
        }
    });



    // Enable registration button if all fields are filled with correct data
    jQuery('.name, .email, .username, .password, .passwordRepeat').keyup(function(){

        // Check if both passwords match
        if ((typeof passwordOne !== "undefined" && passwordOne) && (typeof passwordRepeat !== "undefined" && passwordRepeat)) {
            if(passwordOne === passwordRepeat)
            {
                validatedPassword = true;
                jQuery('.passwordRepeat').removeClass('red').addClass('green');
            }
            else
            {
                validatedPassword = false;
                jQuery('.passwordRepeat').removeClass('green').addClass('red');
            }
        }


        // Enable registration button if all fields are filled with correct data
        if((validatedName == true) && (validatedUsername == true) && (validatedEmail == true) && (validatedPassword == true) && (validatedPasswordRepeat == true))
        {
            jQuery('.registrationBtn').prop('disabled', false);
        }
        else
        {
            jQuery('.registrationBtn').prop('disabled', true);
        }
    });

}); //END FUNCTION



<script>
    jQuery(document).ready(function($) {
        var form = $('#question_form');
        var form_message = $('.form-message');
        //form validation rules
        form.validate({
            ignore: ".ignore",
            rules: {
                user_email: {
                    required: true,
                    email: true
                },
                first_name: "required",
                subject: "required",
                _question : {
                    required: true,
                    maxlength: 500,
                    minlength: 25
                },
                _age: {
                    number: true
                },
                hiddenRecaptcha: {
                    required: function () {
                        if (grecaptcha.getResponse() == '') {
                            return true;
                        } else {
                            return false;
                        }
                    }
                }
            },
            messages: {
                user_email: {
                    required : "Email cannot be empty",
                    email : "Please enter valid email"
                },
                first_name: "First Name is required",
                subject : "Subject is required to submit your question",
                _question : {
                    required: "Please enter your question to continue",
                    maxlength: "Maximum 500 characters allowed"
                },
                hiddenRecaptcha: {
                    required: "Captcha verification failed. Please choose \"I'm  not robot\" "
                }
            },
            submitHandler: function(form) {
                $.ajax({
                    url: "<?php echo admin_url('admin-ajax.php'); ?>",
                    type: form.method,
                    data: $(form).serialize(),
                    dataType: 'JSON',
                    beforeSend: function() {
                        $('.form-submit-loader').show();
                        form_message.hide();
                        form_message.removeClass('alert-success');
                        form_message.removeClass('alert-danger');
                        $('form#form_submit').attr('disabled', true);
                    },
                    success: function(response) {
                        $('.form-submit-loader').hide();
                        form_message.html(response.message);
                        if(response.status) {
                            form_message.addClass('alert-success');
                            form.reset();
                            $('form#form_submit').attr('disabled', false);
                        }
                        if(!response.status) form_message.addClass('alert-danger');
                        form_message.show();
                        $('html,body').animate({scrollTop:form_message.offset().top - 130}, '500', 'swing');
                    }
                });
                return false;
            }
        });
    })
</script>

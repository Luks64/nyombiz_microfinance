var Script = function () {

    $.validator.setDefaults({
        submitHandler: function() { $("#signupForm").submit(); }
    });

    $().ready(function() {
        // validate the comment form when it is submitted
        $("#commentForm").validate();

        // validate signup form on keyup and submit
        $("#signupForm").validate({
            rules: {
                firstname: "required",
                lastname: "required",
                gender: "required",
                telephone: "required",
                security1: "required",
                datewhenaquired: "required",
                dateofissue: "required",
                guarantor1_name: "required",
                guarantor2_name: "required",
                paymentmode: "required",
                username: {
                    required: true,
                    minlength: 2
                },
                password: {
                    required: true,
                    minlength: 5
                },
                confirm_password: {
                    required: true,
                    minlength: 5,
                    equalTo: "#password"
                },
                email: {
                    required: true,
                    email: true
                },
                topic: {
                    required: "#newsletter:checked",
                    minlength: 2
                },
                agree: "required",
                amountappliedfor: {
                  required: true,
                  number: true
                },
                amountgiven: {
                  required: true,
                  number: true
                },
                period: {
                  required: true,
                  number: true
                },
                interest: {
                  required: true,
                  number: true
                },
                security1_value: {
                  required: true,
                  number: true
                },
                guarantor1_phone: {
                  required: true,
                  number: true
                },
                guarantor2_phone: {
                  required: true,
                  number: true
                }
            },
            messages: {
                firstname: "Please enter your firstname",
                lastname: "Please enter your lastname",
                username: {
                    required: "Please enter a username",
                    minlength: "Your username must consist of at least 2 characters"
                },
                password: {
                    required: "Please provide a password",
                    minlength: "Your password must be at least 5 characters long"
                },
                confirm_password: {
                    required: "Please provide a password",
                    minlength: "Your password must be at least 5 characters long",
                    equalTo: "Please enter the same password as above"
                },
                email: "Please enter a valid email address",
                agree: "Please accept our policy",
                amountappliedfor: "Only numbers are required",
                amountgiven: "Only numbers are required",
                perriod: "Only numbers are required"
            }
        });

        // propose username by combining first- and lastname
        $("#username").focus(function() {
            var firstname = $("#firstname").val();
            var lastname = $("#lastname").val();
            if(firstname && lastname && !this.value) {
                this.value = firstname + "." + lastname;
            }
        });

        //code to hide topic selection, disable for demo
        var newsletter = $("#newsletter");
        // newsletter topics are optional, hide at first
        var inital = newsletter.is(":checked");
        var topics = $("#newsletter_topics")[inital ? "removeClass" : "addClass"]("gray");
        var topicInputs = topics.find("input").attr("disabled", !inital);
        // show when newsletter is checked
        newsletter.click(function() {
            topics[this.checked ? "removeClass" : "addClass"]("gray");
            topicInputs.attr("disabled", !this.checked);
        });
    });


}();
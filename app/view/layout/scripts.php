<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script>
    let passwordStrength = 0;

    {
        $(function() {

            $("#createPassword").keyup(function() {
                $('#password-test-msg').html(checkStrength($('#createPassword').val()))
            });

            function checkStrength(password) {


                if (password.length <= 7) {
                    $('#password-test-msg').removeClass().addClass('alert').addClass('alert-danger');

                    return 'Password too short';
                }

                if (password.length > 7) passwordStrength += 1;

                if (password.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/)) passwordStrength += 1;

                if (password.match(/([a-zA-Z])/) && password.match(/([0-9])/)) passwordStrength += 1;

                if (password.match(/([!,%,&,@,#,$,^,*,?,_,~])/)) passwordStrength += 1;

                if (password.match(/(.*[!,%,&,@,#,$,^,*,?,_,~].*[!,",%,&,@,#,$,^,*,?,_,~])/)) passwordStrength += 1

                if (passwordStrength < 2) {
                    $('#password-test-msg').removeClass().addClass('alert').addClass('alert-warning');
                    return 'Password too Weak'

                } else if (passwordStrength == 2) {
                    $('#password-test-msg').removeClass().addClass('alert').addClass('alert-primary');
                    return 'Good Password'

                } else {
                    $('#password-test-msg').removeClass().addClass('alert').addClass('alert-success');
                    return 'Strong password'
                }



            }




            $(".btn-delete").click(function(e) {

                e.preventDefault();

                let deleteprompt = confirm("Are you sure you wish to delete this user?");

                if (deleteprompt) {
                    window.location.href = $(this).attr("href");
                }

            });


        });
        $(".create-user").submit(function(e) {
            if (passwordStrength < 2) {
                e.preventDefault();

            }
        });

        $(".eidt-user").click(function(e) {
            e.preventDefault();
            let pass1 = $("#createPassword").val()
            let pass2 = $("#createPassword2").val()
            if (e.currentTarget.form.reportValidity()) if (pass1 == pass2) {
                e.currentTarget.form.submit()
            }
            else {
                $('#password-test-msg').text("password skal være the sammme")
            }
            
        });
    }
</script>
$(document).ready(function () {
    $('#loginValid').removeClass('invalid').addClass('valid').hide();
    $('#loginInValid').removeClass('invalid').addClass('valid').hide();
    var acceptLogin = 0;

    //
    $('input[type=text]').keyup(function () {

        var login = $(this).val();
        if (login.length > 1) {
            var wartosc = $("#username").val();

            $.post("http://localhost/mwo/validUsername.php", {username: wartosc}).done(function (data) {
                if (data == '1') {
                    $('#loginValid').removeClass('invalid').addClass('valid').hide();
                    $('#loginInValid').removeClass('invalid').addClass('valid').show();
                    acceptLogin = 1;
                } else {
                    $('#loginValid').removeClass('valid').addClass('invalid').show();
                    $('#loginInValid').removeClass('valid').addClass('invalid').hide();
                    acceptLogin = 0;
                }
            });
        }
    });
    //


    $('input[type=password]').keyup(function () {
        var pswd = $(this).val();
        var acceptPassword = 0;

        if (pswd.length < 10) {
            $('#length').removeClass('valid').addClass('invalid');
        } else {
            $('#length').removeClass('invalid').addClass('valid');
            acceptPassword = acceptPassword + 1;
        }

        if (pswd.match(/[A-z]/)) {
            $('#letter').removeClass('invalid').addClass('valid');
            acceptPassword = acceptPassword + 1;
        } else {
            $('#letter').removeClass('valid').addClass('invalid');
        }

        if (pswd.match(/[A-Z]/)) {
            $('#capital').removeClass('invalid').addClass('valid');
            acceptPassword = acceptPassword + 1;
        } else {
            $('#capital').removeClass('valid').addClass('invalid');
        }

        if (pswd.match(/\d/)) {
            $('#number').removeClass('invalid').addClass('valid');
            acceptPassword = acceptPassword + 1;
        } else {
            $('#number').removeClass('valid').addClass('invalid');
        }

        //---------------
        if ((acceptPassword >= 4) && (acceptLogin == 1)) {
            //$('#send_form').show();
            $('#send_form').removeClass('invalid');
            $('#send_form').attr("disabled", false);
        } else {
            //$('#send_form').hide();
            $('#send_form').attr("disabled", true);
            $('#send_form').addClass('invalid');
        }
        //---------------	

    }).focus(function () {
        $('#pswd_info').show();
    }).blur(function () {
        $('#pswd_info').hide();
    });

});
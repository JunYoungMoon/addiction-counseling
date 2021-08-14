$(document).ready(function() {
    var InitialEmail = $('#email').val();
    $('#password2').blur(function() {
        var password1 = $("#password1").val();
        var password2 = $("#password2").val();
        if ($('#password1').val() != $('#password2').val()) {
            if ($('#password2').val() != '') {
                $('#password_check').text('비밀번호가 일치하지 않습니다. :)');
                $('#password_check').css('color', 'red');
                $('#password2').val('');
                $('#password2').focus()
            }
        } else {
            $("#password_check").text("")
        }
    });
    $('#email').blur(function() {
        if (InitialEmail != $('#email').val()) {
            var emailJ = /^([0-9a-zA-Z_\.-]+)@([0-9a-zA-Z_-]+)(\.[0-9a-zA-Z_-]+){1,2}$/;
            var user_email = $('#email').val();
            $.ajax({
                url: '/overLapCheck',
                type: 'get',
                data: {
                    email: user_email,
                    gubun: "email"
                },
                success: function(data) {
                    if (data == '중복') {
                        $("#email_check").text("사용중인 이메일입니다. 아이디/패스워드를 찾아주세요.");
                        $("#email_check").css("color", "red");
                        $('#email').focus()
                    } else if (data == '중복되지않음') {
                        if (emailJ.test(String(user_email))) {
                            $('#email_check').text("")
                        } else if (user_email == "") {
                            $('#email_check').text('이메일을 입력해주세요.');
                            $('#email_check').css('color', 'red');
                            $('#email').focus()
                        } else {
                            $('#email_check').text('이메일 형식이 잘못되었습니다.');
                            $('#email_check').css('color', 'red');
                            $('#email').focus()
                        }
                    }
                },
                error: function() {
                    console.log("실패")
                }
            })
        }
    });
    $("#myInfo_btn").click(function() {
        if (!$("#password").val()) {
            alert("현재비밀번호를 입력해 주세요.");
            $('#password').focus();
            return false
        } else if (!$("#password1").val()) {
            alert("새비밀번호를 입력해 주세요.");
            $('#password1').focus();
            return false
        } else if (!$("#password2").val()) {
            alert("새비밀번호 확인을 입력해 주세요.");
            $('#password2').focus();
            return false
        } else if (!$("#email").val()) {
            alert("이메일을 입력해 주세요.");
            $('#email').focus();
            return false
        }
        if (!($('#password_check').text() == "")) {
            alert("비밀번호를 확인해 주세요.");
            return false
        } else if (!($('#email_check').text() == "")) {
            alert("이메일을 확인해 주세요.");
            return false
        }
        $("#changeInformation_form").submit()
    })
});
$(document).ready(function() {
    $('#id').blur(function() {
        var idJ = /^[a-z]+[a-z0-9]{5,19}$/g;
        var user_id = $('#id').val();
        $.ajax({
            url: '/overLapCheck',
            type: 'get',
            data: {
                id: user_id,
                gubun: "id"
            },
            success: function(data) {
                if (data == '중복') {
                    $("#id_check").text("사용중인 아이디입니다.");
                    $("#id_check").css("color", "red");
                    $('#id').focus()
                } else if (data == '중복되지않음') {
                    if (idJ.test(String(user_id))) {
                        $("#id_check").text("")
                    } else if (user_id == "") {
                        $('#id_check').text('아이디를 입력해주세요.');
                        $('#id_check').css('color', 'red');
                        $('#id').focus()
                    } else {
                        $('#id_check').text("아이디는 영문자로 시작하는 6~20자로 영문자 또는 숫자이어야 합니다.");
                        $('#id_check').css('color', 'red');
                        $('#id').focus()
                    }
                }
            },
            error: function() {
                console.log("실패")
            }
        })
    });
    $('#password2').blur(function() {
        var password1 = $("#password1").val();
        var password2 = $("#password2").val();
        if ($('#password1').val() != $('#password2').val()) {
            if ($('#password2').val() != '') {
                $('#password_check').text('비밀번호가 일치하지 않습니다.');
                $('#password_check').css('color', 'red');
                $('#password2').val('');
                $('#password2').focus()
            }
        } else {
            $("#password_check").text("")
        }
    });
    $('#email').blur(function() {
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
    });
    $("#signUp_btn").click(function() {
        if (!$("#id").val()) {
            alert("아이디를 입력해 주세요.");
            $('#id').focus();
            return false
        } else if (!$("#password1").val()) {
            alert("비밀번호를 입력해 주세요.");
            $('#password1').focus();
            return false
        } else if (!$("#password2").val()) {
            alert("비밀번호 확인을 입력해 주세요.");
            $('#password2').focus();
            return false
        } else if (!$("#email").val()) {
            alert("이메일을 입력해 주세요.");
            $('#email').focus();
            return false
        }
        if (!($('#id_check').text() == "")) {
            alert("아이디를 확인해 주세요.");
            return false
        } else if (!($('#password_check').text() == "")) {
            alert("비밀번호를 확인해 주세요.");
            return false
        } else if (!($('#email_check').text() == "")) {
            alert("이메일을 확인해 주세요.");
            return false
        }
        $("#signUp_form").submit()
    })
});
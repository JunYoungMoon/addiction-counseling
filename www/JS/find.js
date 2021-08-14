$(document).ready(function() {
    $('#email').blur(function() {
        var emailJ = /^([0-9a-zA-Z_\.-]+)@([0-9a-zA-Z_-]+)(\.[0-9a-zA-Z_-]+){1,2}$/;
        var user_email = $('#email').val();
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
    });
    $("#find_btn").click(function() {
        if (!$("#email").val()) {
            alert("이메일을 입력해 주세요.");
            $('#email').focus();
            return false
        }
        if (!($('#email_check').text() == "")) {
            alert("이메일을 확인해 주세요.");
            return false
        }
        $("#find_form").submit()
    })
});
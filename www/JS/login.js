$(document).ready(function() {
    $("#login_btn").click(function() {
        var idJ = /^[a-z]+[a-z0-9]{5,19}$/g;
        var user_id = $('#id').val();
        var user_pw = $("#password").val();
        if (user_id == "") {
            alert("아이디를 입력해 주세요.");
            $('#id').focus()
        } else if (user_pw == "") {
            alert("비밀번호를 입력해 주세요.");
            $('#password').focus()
        } else if (!idJ.test(String(user_id))) {
            alert("아이디 형식이 올바르지 않습니다.");
            $('#id').focus()
        } else {
            $("#login_form").submit()
        }
    });
    $(".enterkey").keyup(function(e) {
        if (e.keyCode == 13) {
            var idJ = /^[a-z]+[a-z0-9]{5,19}$/g;
            var user_id = $('#id').val();
            var user_pw = $("#password").val();
            if (user_id == "") {
                alert("아이디를 입력해 주세요.");
                $('#id').focus()
            } else if (!idJ.test(String(user_id))) {
                alert("아이디 형식이 올바르지 않습니다.:)\n아이디는 영문자로 시작하는 6~20자로 영문자 또는 숫자이어야 합니다.");
                $('#id').focus()
            } else if (user_pw == "") {
                alert("비밀번호를 입력해 주세요.");
                $('#password').focus()
            } else {
                $("#login_form").submit()
            }
        }
    })
});
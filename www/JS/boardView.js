$(document).ready(function() {
    $(document).on('click', '#replyWrite_btn', function() {
        if ($("#replyWriteContent").val() == "") {
            alert("댓글을 입력해주세요.");
            return false
        } else {
            var boardId = document.location.pathname.split("/")[2];

            $.ajax({
                url: '/replyWriteContent',
                type: 'post',
                data: {
                    id: $("#id").val(),
                    content: $("#replyWriteContent").val(),
                    boardId: boardId
                },
                dataType: 'json',
                success: function(data) {
                    $("#reply").empty();
                    var txt = "<div style='text-align: left; margin-left:5%; font-size: 20px; padding-top: 20px;'>댓글</div>";
                    $.each(data, function(index, item) {
                        txt += "<div style='padding-right: 30px; padding-left: 30px;''>";
                        txt += "<hr>";
                        txt += "<div id='" + data[index].replyId + "'>";
                        txt += "<div style='text-align: left; float: left; font-weight: 700'>" + data[index].id + "</div>";
                        txt += "<div style='text-align: right;'>" + data[index].created + "</div>";
                        txt += "<div style='text-align: left; word-break:break-all;'>" + data[index].content;
                        txt += "&nbsp;<i class='fas fa-pencil-alt' style='cursor:pointer'></i><i class='far fa-trash-alt' style='cursor:pointer'></i>";
                        txt += "</div>";
                        txt += "<hr>";
                        txt += "</div>";
                        $("#reply").append(txt);
                        txt = ""
                    })
                },
                error: function() {
                    alert("댓글 등록에 실패 하였습니다.");
                    return false
                }
            })
        }
    });
    $(document).on('click', '#replyModify_btn', function() {
        if ($("#replyModifyContent").val() == "") {
            alert("댓글을 입력해주세요.");
            return false
        } else {
            var replyId = $(this).parent().parent().attr('id');
            $.ajax({
                url: '/replyModifyContent',
                type: 'post',
                data: {
                    id: $("#id").val(),
                    content: $("#replyModifyContent").val(),
                    replyId: replyId
                },
                dataType: 'json',
                success: function(data) {
                    $('#' + data[0].replyId).children().eq(2).text(data[0].content);
                    $('#' + data[0].replyId).children().eq(2).append("<i class='fas fa-pencil-alt' style='cursor:pointer'></i><i class='far fa-trash-alt' style='cursor:pointer'></i>");            
                    $('#' + data[0].replyId).children().eq(3).remove();
                    let textarea = $('<div id="replyArea"><textarea id="replyWriteContent" cols="60" rows="5" style="width: 85%"></textarea><input type="button" id="replyWrite_btn" class="fadeIn fourth zero-raduis pc" value="댓글작성"></div>');
                    $('#reply').append(textarea)
                },
                error: function() {
                    alert("댓글 수정에 실패 하였습니다.");
                    return false
                }
            })
        }
    });
    $(document).on('click', '.fa-pencil-alt', function() {
        $("#replyArea").remove();            
        var replyId = $(this).parent().parent().attr('id');
        let textarea = $('<div id="replyArea"><textarea id="replyModifyContent" cols="60" rows="5" style="width: 85%">' + $(this).parent().text() + '</textarea><input type="button" id="replyModify_btn" class="zero-raduis pc" value="댓글수정"></div>');
        $(this).parent().parent().append(textarea);
    });
    $(document).on('click', '.fa-trash-alt', function() {
        if (confirm("정말 댓글을 삭제 하시겠습니까?")) {
            var replyId = $(this).parent().parent().attr('id');
            var boardId = document.location.pathname.split("/")[2];
            $.ajax({
                url: '/replyDeleteContent',
                type: 'post',
                data: {
                    id: $("#id").val(),
                    replyId: replyId,
                    boardId: boardId
                },
                dataType: 'json',
                success: function(data) {
                    $("#reply").empty();
                    var txt = "<div style='text-align: left; margin-left:5%; font-size: 20px; padding-top: 20px;'>댓글</div>";
                    $.each(data, function(index, item) {
                        txt += "<div style='padding-right: 30px; padding-left: 30px;''>";
                        txt += "<hr>";
                        txt += "<div id='" + data[index].replyId + "'>";
                        txt += "<div style='text-align: left; float: left; font-weight: 700'>" + data[index].id + "</div>";
                        txt += "<div style='text-align: right;'>" + data[index].created + "</div>";
                        txt += "<div style='text-align: left; word-break:break-all;'>" + data[index].content;
                        txt += "&nbsp;<i class='fas fa-pencil-alt' style='cursor:pointer'></i><i class='far fa-trash-alt' style='cursor:pointer'></i>";
                        txt += "</div>";
                        txt += "<hr>";
                        txt += "</div>";
                        $("#reply").append(txt);
                        txt = ""
                    })
                },
                error: function() {
                    alert("댓글 삭제에 실패 하였습니다.");
                    return false
                }
            })
        }
    })
});
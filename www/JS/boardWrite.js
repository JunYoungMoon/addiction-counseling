$(document).ready(function() {
    var oEditors = [];
    var tempGubun = "first";
    $(function() {
        nhn.husky.EZCreator.createInIFrame({
            oAppRef: oEditors,
            elPlaceHolder: "content",
            sSkinURI: "/smartEditor2/SmartEditor2Skin.html",
            htParams: {
                bUseToolbar: true,
                bUseVerticalResizer: true,
                bUseModeChanger: true,
                fOnBeforeUnload: function() {}
            },
            fOnAppLoad: function() {},
            fCreator: "createSEditor2"
        })
    });
    $("#boardWrite_btn").click(function() {
        oEditors.getById["content"].exec("UPDATE_CONTENTS_FIELD", []);
        if ($("#title").val() == "") {
            alert("제목을 입력 해주세요.");
            return false
        } else if ($("#content").val() == "" || $("#content").val() == "<br>") {
            alert("내용을 입력 해주세요.");
            return false
        }
        if (doubleSubmitCheck()) {
            alert("중복 클릭 하였습니다.")
        } else {
            window.onbeforeunload = function() {}
            $("#boardWrite_form").submit()
        }
    });
    window.onbeforeunload = function() {
        return 0
    }
    $(".btn_temp_save").click(function() {
        oEditors.getById["content"].exec("UPDATE_CONTENTS_FIELD", []);
        if ($("#title").val() == "") {
            alert("제목을 입력 해주세요.")
        } else {
            $.ajax({
                url: '/setTempContent',
                type: 'post',
                data: {
                    id: $("#id").val(),
                    title: $("#title").val(),
                    content: $("#content").val(),
                    gubun: tempGubun
                },
                success: function(data) {
                    if (data != "FAIL") {
                        $(".TempSaveCount").text(data);
                        tempGubun = "otherThan";
                        alert("작성글을 임시등록 하였습니다.");
                        return false
                    } else if (data == "FAIL") {
                        alert("임시등록에 실패 하였습니다.");
                        return false
                    }
                },
                error: function() {
                    alert("임시등록에 실패 하였습니다.");
                    return false
                }
            })
        }
    });
    $(".btn_temp_count").click(function() {
        $.ajax({
            url: '/getTempList',
            type: 'post',
            data: {
                id: $("#id").val()
            },
            dataType: 'json',
            success: function(data) {
                if (data != "FAIL") {
                    if (data.length - 1 != 0) {
                        $(".modal-body").empty();
                        var txt = "";
                        $.each(data.slice(0, data.length - 1), function(index, item) {
                            txt += "<li class='modal-list'>";
                            txt += "<div class='modal-left'>";
                            txt += "<a href='#' class='temp_link' data-id='" + item["boardTempId"] + "'>";
                            txt += item["title"];
                            txt += "</a>";
                            txt += "</div>";
                            txt += "<div class='modal-right'>";
                            txt += "<span class='modal-date'>";
                            txt += item["created"];
                            txt += "</span>";
                            txt += "<a href='#' class='far fa-trash-alt' data-id='" + item["boardTempId"] + "'></a>";
                            txt += "</div>";
                            txt += "</li>";
                            txt += "<div class='modal-underline'></div>"
                        });
                        $(".modal-body").append(txt)
                    }
                } else if (data == "FAIL") {
                    alert("리스트를 불러오지 못했습니다.");
                    return false
                }
            },
            error: function() {
                alert("리스트를 불러오지 못했습니다.");
                return false
            }
        })
    });
    $(document).on('click', '.temp_link', function() {
        $.ajax({
            url: '/getTempListContent',
            type: 'post',
            data: {
                id: $("#id").val(),
                boardTempId: $(this).attr('data-id')
            },
            dataType: 'json',
            success: function(data) {
                if (data != "FAIL") {
                    if (confirm("내용을 불러오면 작성된 내용은 모두 사라집니다.")) {
                        $('#title').val('');
                        $('#title').val(data['title']);
                        oEditors.getById["content"].exec("SET_IR", [""]);
                        oEditors.getById["content"].exec("PASTE_HTML", [data['content']]);
                        $('#tempListModal').modal("hide")
                    }
                } else if (data == "FAIL") {
                    alert("내용을 불러오지 못했습니다.");
                    return false
                }
            },
            error: function() {
                alert("내용을 실패 하였습니다.");
                return false
            }
        })
    });
    $(document).on('click', '.fa-trash-alt', function() {
        $.ajax({
            url: '/getTempDelete',
            type: 'post',
            data: {
                id: $("#id").val(),
                boardTempId: $(this).attr('data-id')
            },
            dataType: 'json',
            success: function(data) {
                $('.btn_temp_count').text('');
                $('.btn_temp_count').text(data[data.length - 1]);
                if (data != "FAIL") {
                    if (data.length - 1 != 0) {
                        $(".modal-body").empty();
                        var txt = "";
                        $.each(data.slice(0, data.length - 1), function(index, item) {
                            txt += "<li class='modal-list'>";
                            txt += "<div class='modal-left'>";
                            txt += "<a href='#' class='temp_link' data-id='" + item["boardTempId"] + "'>";
                            txt += item["title"];
                            txt += "</a>";
                            txt += "</div>";
                            txt += "<div class='modal-right'>";
                            txt += "<span class='modal-date'>";
                            txt += item["create"];
                            txt += "</span>";
                            txt += "<a href='#' class='far fa-trash-alt' data-id='" + item["boardTempId"] + "'></a>";
                            txt += "</div>";
                            txt += "</li>";
                            txt += "<div class='modal-underline'></div>"
                        });
                        $(".modal-body").append(txt)
                    } else {
                        $(".modal-body").empty()
                    }
                } else if (data == "FAIL") {
                    alert("선택한 내용을 삭제하지 못했습니다.");
                    return false
                }
            },
            error: function() {
                alert("선택한 내용을 삭제하지 못했습니다.");
                return false
            }
        })
    });
    $(document).on('click', '.btn_temp_all_delete', function() {
        if (confirm("저장된 임시등록 리스트를 모두 삭제 하시겠습니까?")) {
            $.ajax({
                url: '/getTempAllDelete',
                type: 'post',
                data: {
                    id: $("#id").val()
                },
                dataType: 'json',
                success: function(data) {
                    if (data != "FAIL") {
                        $(".modal-body").empty();
                        $('.btn_temp_count').text('0');
                        alert("임스등록 리스트를 모두 삭제 하였습니다.")
                    } else if (data == "FAIL") {
                        alert("임스등록 리스트를 삭제하지 못했습니다.");
                        return false
                    }
                },
                error: function() {
                    alert("임스등록 리스트를 삭제하지 못했습니다.");
                    return false
                }
            })
        }
    })
});
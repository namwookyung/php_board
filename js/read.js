$(document).ready(function() {
    $("#reply_edit_btn").click(function() {
        let reply_edit = $("#reply_edit");
    
        if(reply_edit.hasClass("on")) { // 수정 활성화 상태
            reply_edit.removeClass("on");
            reply_edit.css({ "background-color": "green" });
            reply_edit.css({ "border": "1px solid green" });
            $(this).text("수정 완료");
        } else {
            reply_edit.addClass("on");
            reply_edit.css({ "background-color": "cornflowerblue" });
            reply_edit.css({ "border": "1px solid cornflowerblue" });
            $(this).text("수정");
        }
    })

    // $("#reply_delete_btn").click(function() {
    
    // })
})

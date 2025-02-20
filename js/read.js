document.addEventListener('DOMContentLoaded', function() {
    // 게시글 삭제 함수
    function deleteConfirm(post_idx){
        isConfirm = confirm('삭제하시겠습니까?');
        if(isConfirm == true) {
            var url="/php_board/api/post/delete.php?post_idx=" + post_idx;
            location.href = url;
        }
    }

    // 좋아요/싫어요 업데이트 함수
    function updateThumb(action, post_idx) {
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "/php_board/api/post/thumb_update.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function() {
            if(xhr.readyState === 4 && xhr.status === 200) {
                let response = JSON.parse(xhr.responseText);
                if(response.success) {
                    document.getElementById("thumb_up_count").innerText = response.up;
                    document.getElementById("thumb_down_count").innerText = response.down;
                } else {
                    alert("오류 발생 : " + response.message);
                }
            }
        };
        xhr.send("action=" + action + "&post_idx=" + post_idx);
    }

    // 전역 스코프에서 함수 호출 가능하게 window 객체에 등록
    window.deleteConfirm = deleteConfirm;
    window.updateThumb = updateThumb;
});

$(document).ready(function() {
    // 댓글 수정 버튼 이벤트 함수
    $(document).on('click', '.reply_edit_btn', function() {
        const replyId = $(this)[0].dataset.replyId.slice(15);   // 클릭한 댓글의 ID 가져오기
        const replyContentDiv = $(`#reply_content_${replyId}`); // 해당 댓글의 내용 div 선택
        const currentContent = replyContentDiv.text();  // 현재 댓글 내용
        const replyPwDiv = $(`#reply_pw_${replyId}`);   // 비밀번호 div 선택
        const delBtn = $(`#reply_delete_btn_${replyId}`);   // 해당 댓글의 삭제 버튼

        if(!$(this).hasClass("editing")) {  // 수정 모드로 변경
            replyContentDiv.html(`<textarea id="textarea_${replyId}"
                style="margin-top: 5px; border: 1px solid rgba(0, 0, 0, 0.3);
                border-radius: 5px; width:100%; padding:10px; height:10vh;"
                placeholder="내용">${currentContent}</textarea>`);
            replyPwDiv.css({"display":"block"});
            delBtn.css({"display":"none"});
            $(this).addClass("editing").text("수정 완료");
        } else {    // 수정 완료 상태로 변경
            const updatedContent = $(`#textarea_${replyId}`).val(); // 수정된 내용 가져오기
            replyContentDiv.html(updatedContent);   // 수정된 내용을 다시 텍스트로 표시
            const replyPw = $(`#reply_pw_${replyId}`).val();
            replyPwDiv.css({"display":"none"});
            delBtn.css({"display":"block"});
            $(this).removeClass("editing").text("수정");

            // AJAX로 서버에 수정된 내용 전송
            $.ajax({
                url: "/php_board/api/reply/reply_modify_ok.php",
                type: "POST",
                data: {
                    reply_idx: replyId,
                    reply_content: updatedContent,
                    reply_pw: replyPw
                },
                success: function(response) {
                    alert("수정 완료");
                },
                error: function() {
                    alert("수정 실패");
                    console.error("Edit Error : ", error);
                }
            })
        }
    });
    
    // 댓글 삭제 버튼 이벤트 함수
    $(document).on('click', '.reply_delete_btn', function() {
        const replyId = $(this)[0].dataset.replyId.slice(17);   // 삭제할 댓글 ID
        const replyPwDiv = $(`#reply_pw_${replyId}`);   // 삭제할 댓글 비밀번호
        const post_idx = $(`#post_idx_${replyId}`).val();   // 글 번호
        const editBtn = $(`#reply_edit_btn_${replyId}`);    // 해당 댓글의 수정 버튼

        if(!$(this).hasClass("deleting")) { // 삭제 모드로 변경(비밀번호 입력창 보이기)
            replyPwDiv.css({"display":"block"});    // 비밀번호 입력란 보이기
            editBtn.css({"display":"none"});    // 수정 버튼 숨기기
            $(this).addClass("deleting").text("삭제 완료");
        } else {    // 삭제 완료 상태로 변경
            const replyPw = $(`#reply_pw_${replyId}`).val();    // 비밀번호 가져오기
            editBtn.css({"display":"block"});   // 수정 버튼 보이기
            $(this).removeClass("deleting").text("삭제");

            if(confirm("삭제하시겠습니까?")) {
                $.ajax({
                    url: "/php_board/api/reply/reply_delete.php",
                    type: "POST",
                    data: {
                        reply_idx: replyId,
                        reply_pw: replyPw,
                        post_idx: post_idx
                    },
                    success: function(response) {
                        alert("삭제 완료");
                        $(`#reply_content_${replyId}`).closest('.dap_lo').remove(); // 삭제된 댓글을 화면에서 제거
                    },
                    error: function() {
                        alert("삭제 실패");
                        console.error("Delete Error: ", error);
                    }
                })
            } else {
                return;
            }
        }
    });
})
//summernote
$(document).ready(function (){
    $('#post_content').summernote({
        tabsize: 2,
        height: 350,
        lang: 'ko-KR', // default: 'en-US'
        callbacks: {	//여기 부분이 이미지를 첨부하는 부분
            onImageUpload : function(files) {
                uploadSummernoteImageFile(files[0],this);
            }
        }
    });
});
//썸모노트 이미지 업로드
function uploadSummernoteImageFile(file, editor) {
    data = new FormData();
    data.append("file", file);
    data.append("csrf_test_name", cb_csrf_hash)
    $.ajax({
        data : data,
        type : "POST",
        // enctype: 'multipart/form-data',
        url : cb_url+"/fileupload/do_upload",
        contentType : false,
        processData : false,
        success : function(data) {
            console.log(data)
            //항상 업로드된 파일의 url이 있어야 한다.
            $(editor).summernote('insertImage', cb_url+'/uploads/editor/'+data.imgData.file_name);
        }
    });
}
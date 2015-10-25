define(function(require, exports, module) {
    var $modal = $('#issue-create-modal');

    $modal.on('shown.bs.modal', function() {
        console.log('show');
        var html = "";
        html += '<div class="issue-image" tabindex="1"><div class="empty-text">请粘贴图片</div></div>';
        $modal.find('.issue-image-box').html(html);

        $modal.find('.issue-image').pastableNonInputable();

        $modal.find('.issue-image').on('pasteImage', function(ev, data) {
            console.log('paste');

            var blobUrl = URL.createObjectURL(data.blob);

            var html = "";
            html += '<a href="' + blobUrl + '" target="_blank" class="image-link">';
            html += '  <img src="' + data.dataURL + '" class="img-responsive">';
            html += '</a>';

            $(this).html(html);

            var fd = new FormData();
            fd.append('image', data.blob);

            $.ajax({
                url: "/image/upload",
                type: 'POST',
                data: fd,
                contentType: false,
                processData: false,
                success: function(response) {
                    console.log(response);
                    $modal.find('[name=image]').val(response.image);
                    console.log('success');
                },
                error: function() {
                    alert('图片上传失败！');
                }
            });


        });

    });

    $modal.on('hide.bs.modal', function() {
        console.log('hide');
        $modal.find('.issue-image').remove();
        $modal.find('textarea').val('');
        $modal.find('[name=image]').val('');

    });


    $("#issue-save-btn").on('click', function() {
        console.log('save');
        var issue = {};
        issue.image = $modal.find('[name=image]').val();
        issue.note = $modal.find('textarea').val();
        issue.priority = $modal.find('[name=priority]:checked').val();

        $.post('/issue_create', issue, function(html) {
            $modal.modal('hide');
            if($('#current-issue-status').val() == 'todo'){
                $('.bug-grids').prepend(html);
                $('.bug-grids').children('.col-md-3').first().addClass('animated jello').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
                    $(this).removeClass('animated jello');
                });
            }else{
                $('.issues-status-todo-btn').addClass('animated bounceIn').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
                    $(this).removeClass('animated bounceIn');
                });
            }
        });

    });
});
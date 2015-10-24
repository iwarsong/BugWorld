define(function(require, exports, module) {

    $.material.init();

    require('paste.js');
    var Keypress = require('keypress');

    var Dnd = require('arale-dnd');

    require('./userlist-floatbar.js');
    require('./main.js');

    exports.run = function() {

        var $modal = $('#issue-create-modal');

        $('#issue-create-modal .issue-image').pastableNonInputable();

        $('#issue-create-modal .issue-image')


        $('#issue-create-modal').on('shown.bs.modal', function () {
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
                html += '  <img src="' + data.dataURL +'" class="img-responsive">';
                html += '</a>';

                $(this).html(html);

            });

        });

        $('#issue-create-modal').on('hide.bs.modal', function () {
            console.log('hide');
            $modal.find('.issue-image').remove();
            $modal.find('textarea').val('');

        });

        // $('*').pastableNonInputable();

        // $('*').on('pasteImage', function(ev, data) {
        //     console.log("dataURL: " + data.dataURL);
        //     console.log("width: " + data.width);
        //     console.log("height: " + data.height);
        //     console.log(data.blob);

        //     var fd = new FormData();
        //     fd.append('image', data.blob);

        //     $.ajax({
        //       url :  "/image/upload",
        //       type: 'POST',
        //       data: fd,
        //       contentType: false,
        //       processData: false,
        //       success: function(data) {
        //         console.log('success');
        //       },    
        //       error: function() {
        //         console.log('error');
        //       }
        //     });


        // }).on('pasteText', function(ev, data) {
        //     console.log("text: " + data.text);
        // });

        // var listener = new Keypress.Listener();

        // listener.simple_combo("cmd v", function() {
        //     console.log("You pressed shift and s");
        // });

    };

});
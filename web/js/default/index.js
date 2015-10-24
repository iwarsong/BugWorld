define(function(require, exports, module) {

    $.material.init();

    require('paste.js');
    var Keypress = require('keypress');

    var Dnd = require('arale-dnd');

    require('./userlist-floatbar.js');
    require('./main.js');

    exports.run = function() {

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
define(function(require, exports, module) {

    $.material.init();

    require('paste.js');
    var Keypress = require('keypress');

    var Dnd = require('arale-dnd');

    require('./userlist-floatbar.js');
    require('./main.js');

    require('./issue-create.js');

    exports.run = function() {


        // }).on('pasteText', function(ev, data) {
        //     console.log("text: " + data.text);
        // });

        // var listener = new Keypress.Listener();

        // listener.simple_combo("cmd v", function() {
        //     console.log("You pressed shift and s");
        // });

    };

});
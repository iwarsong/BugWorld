define(function(require, exports, module) {

    exports.run = function() {

        var $container = $('#address-list');

        $container.on('click', '.delete-btn', function(){
            var $tr = $(this).parents('tr');
            var id = $(this).data('id');
            $.post($(this).data('url'), {ids:[id]}, function(response) {
                if (response.status == 'ok') {
                    $tr.remove();
                }
            });
        });

        $container.on('click', '.trash-btn', function() {
            var $tr = $(this).parents('tr');
            var id = $(this).data('id');
            $.post($(this).data('url'), {ids:[id]}, function(response) {
                if (response.status == 'ok') {
                    $tr.remove();
                }
            });
        });

        require('../common/batch-select')($container);
        require('../common/batch-delete')($container);
    };

});
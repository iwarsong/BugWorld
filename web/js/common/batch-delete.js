define(function(require, exports, module) {

    module.exports = function($element) {
        
        $element.on('click', '[data-role=batch-delete]', function() {
            
            var $btn = $(this);
                name = $btn.data('name');

            var ids = [];
            $element.find('[data-role=batch-item]:checked').each(function(){
                ids.push(this.value);
            });

            if (ids.length == 0) {
                Notify.danger('未选中任何' + name);
                return ;
            }

            if (!confirm('确定要删除选中的' + ids.length + '条' + name + '吗？')) {
                return ;
            }

            $element.find('.btn').addClass('disabled');

            $.post($btn.data('url'), {ids:ids}, function(){
                window.location.reload();
            });

        });

    };

});
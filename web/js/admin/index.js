define(function(require, exports, module) {

    exports.run = function() {


	$("#admin-list").on('click', '.lock-btn', function() {
	    if (!confirm('您真的要锁定此管理员')) {
	        return ;
	    }

	    $.post($(this).data('url'), function(){
	        window.location.reload();
	    });
	});

	$("#admin-list").on('click', '.unlock-btn', function() {
	    if (!confirm('您真的要解锁此管理员')) {
	        return ;
	    }

	    $.post($(this).data('url'), function(){
	        window.location.reload();
	    });
	});
 };
    
});
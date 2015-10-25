define(function(require, exports, module) {
	var Dnd = require('arale-dnd');
	var proxy = document.createElement('img');
	var dnd = null;

	$('.bug-grids').bind('issuesIsRefresh', function(isRefresh) {
		if(!isRefresh)return;

		var $issueGrid = $('.issue-grid');
		dnd = new Dnd('.userlist-flotbar .userlist-user ', {
			drops: $issueGrid,
			proxy: proxy,
			visible: false,
			revert: true
		});

		// dataTransfer为拖放数据，传输信息
		dnd.on('dragstart', function(dataTransfer, proxy){
		;
			// console.log(dataTransfer.data);
		});
		dnd.on('dragenter', function(proxy, drop){
			// drop.addClass('over') ;
		});
		dnd.on('dragleave', function(proxy, drop){
			// drop.removeClass('over') ;
		});
		dnd.on('drop', function(dataTransfer, proxy, drop){
			// alert(dataTransfer.data);
		});
		dnd.on('dragend', function(element, drop){
			if(drop === null)return;
			$.ajax({
				type:'POST',
				url:element.data('url'),
				data:{userId:element.data('id'),issueId:drop.data('id')},
				success: function(src){
					var html = "\<img src=\"" +src +  "\">";
					drop.find('.douser-avatar').html(html);
					drop.find('.douser-avatar').addClass('animated bounceIn').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
                		$(this).removeClass('animated bounceIn');
            		});
				},
				dataType: "json"
			});
			// if(drop) drop.removeClass('over') ;
		})
	});
	$(proxy).css('width', 50);
	$(proxy).css('height', 50);
	proxy.src = 'move.svg';


});
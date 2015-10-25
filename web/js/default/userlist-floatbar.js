define(function(require, exports, module) {
	var Dnd = require('arale-dnd');
	var proxy = document.createElement('img');
	var dnd = null;
	$(proxy).css('width', 50);
	$(proxy).css('height', 50);

	$('.userlist-user').hover(function(){
			var $this = $(this);
			var src = $this.find('img').attr('src');
			proxy.src = src;
			proxy.id = $this.data('id');
			$(proxy).data('url', $this.data('url'));
		}
	);
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
			dataTransfer.data = {src:proxy.attr('src'),id:proxy.attr('id'),url:proxy.data('url')};
			// console.log(dataTransfer.data);
		});
		dnd.on('drop', function(dataTransfer, proxy, drop){

			if(typeof(dataTransfer.data) !== 'undefined'){
				if(drop === null)return;
				var url = dataTransfer.data['url'];
				var src = dataTransfer.data['src'];
				var userId = dataTransfer.data['id'];

				$.ajax({
					type:'POST',
					url:url,
					data:{userId:userId,issueId:drop.data('id')},
					success: function(){
						var html = "\<img src=\"" +src +  "\">";
						drop.find('.douser-avatar').html(html);
						drop.find('.douser-avatar').addClass('animated bounceIn').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
							$(this).removeClass('animated bounceIn');
						});
					},
					dataType: "json"
				});
			}
		});

	});



});
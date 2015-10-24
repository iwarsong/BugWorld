define(function(require, exports, module) {

	seajs.use(['arale-dnd', 'jquery'], function(Dnd, $) {
    	var proxy = document.createElement('img');
	    var dnd = null;

	    $(proxy).on('load', function() {
	        dnd = new Dnd('.userlist-flotbar .userlist-user ', {
	            drops: $('.bug-grids .issue-grid'),
	            proxy: proxy,
	            visible: false, 
	            revert: true
	        });

	        // dataTransfer为拖放数据，传输信息
	        dnd.on('dragstart', function(dataTransfer, proxy){
	            dataTransfer.data = dnd.element;
	        })
	        dnd.on('dragenter', function(proxy, drop){
	            // drop.addClass('over') ;
	        })
	        dnd.on('dragleave', function(proxy, drop){
	            // drop.removeClass('over') ;
	        })
	        dnd.on('drop', function(dataTransfer, proxy, drop){
	            // alert(dataTransfer.data);	           
	        })
	        dnd.on('dragend', function(element, drop){
	        	$.ajax({
	        		type:'POST',
	        		url:element.data('url'),
	        		data:{userId:element.data('id'),issueId:drop.data('id')},
	        		success: function(src){
	        			var html = "\<img src=\"" +src +  "\">";
						drop.find('.douser-avatar').html(html);
	        		},
  					dataType: "json"
	        	});
	            // if(drop) drop.removeClass('over') ;
	        })
	    })
	    $(proxy).css('width', 50);
	    $(proxy).css('height', 50);
	    proxy.src = 'http://tp3.sinaimg.cn/1748374882/180/40020642911/1';
	});

});
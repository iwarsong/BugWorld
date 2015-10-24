define(function(require, exports, module) {

    function SearchIssues(){
        this.isOnlyMe = false;
        this.sort = 'createdTime';
        this.sortMode = 'time';
        this.url = '/issues/todo';
        this.callback = function(html){
            $('.bug-grids').html(html);
        };
        this.search = function(method, url, callback){
            if(!method in ['POST', 'GET']){
                throw new Error('method should be POST or GET');
            }
            switch(method){
                case 'POST':
                    $.post(url, callback);
                    break;
                case 'GET':
                    $.get(url, callback);
                    break;
                default :
                    break;
            }
        }
    }

    var searchIssues = new SearchIssues();

    $('.only-me').on('click',function(){
        searchIssues.isOnlyMe = !searchIssues.isOnlyMe;
        search('GET');
    });

    $('.issues-status').on('click', function(){
        var $this = $(this);
        var sort = $this.data('sort');
        var url = $this.data('url');
        searchIssues.sort = sort;
        searchIssues.url = url;
        search('GET');
    });

    $('.issues-sort-mode').on('click', function(){
        searchIssues.sortMode = $(this).data('mode');
        search('GET');
    });

    function getUrl() {
        return searchIssues.url + '?onlyMe=' + searchIssues.isOnlyMe
                + '&sort=' + searchIssues.sort
                + '&sortMode=' + searchIssues.sortMode
    }

    function search(method){
        searchIssues.search(method, getUrl(), searchIssues.callback);
    }

});
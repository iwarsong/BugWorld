define(function(require, exports, module) {

    function SearchIssues(){
        this.isOnlyMe = false;
        this.sort = 'createdTime';
        this.sortMode = 'time';
        this.url = '/issues/todo';
        this.callback = function(html){
            $('.bug-grids').html(html);
            $('.bug-grids').trigger('issuesIsRefresh', true);

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
    $('.bug-grids').trigger('issuesIsRefresh', true);
    $('.only-me').on('click',function(){
        searchIssues.isOnlyMe = !searchIssues.isOnlyMe;
        search('GET');
    });

    $('.issues-status').on('click', function(){
        var $this = $(this);
        var sort = $this.data('sort');
        var url = $this.data('url');
        var splitedUrl = url.split('/');
        $('#current-issue-status').val(splitedUrl[2]);
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

    var IssueModal = function(){
        this.grid;
        this.setGrid = function($issueGrid){this.grid = $issueGrid};
        this.getGrid = function(){return this.grid};
        this.getLastGrid = function(){
            if (this.getGrid() === undefined){
                return;
            }
            return this.getGrid().parent().prev().children('.issue-grid');
        };
        this.getNextGrid = function(){
            if (this.getGrid() === undefined){
                return;
            }
            return this.getGrid().parent().next().children('.issue-grid');
        }
    };

    var Keypress = require('keypress');
    var issueModal = new IssueModal();

    $('.issue-image').on('click', function(){
        var $this = $(this);
        var $issueGrid = $this.parent('.issue-grid');
        issueModal.setGrid($issueGrid);

        var listener = new Keypress.Listener();
        listener.simple_combo('left', function(){
            var lastGrid = issueModal.getLastGrid();
            if(lastGrid.length == 0){
                return ;
            }

            issueModal.setGrid(lastGrid);
            var $grid = issueModal.getGrid();
            $.get($grid.children('.issue-image').data('url'), {id:$grid.data('id')}, function(html){
                $('#issue-show-modal').html(html);
            });
        });

        listener.simple_combo('right', function(){
            var nextGrid = issueModal.getNextGrid();
            if(nextGrid.length == 0){
                return ;
            }

            issueModal.setGrid(nextGrid);
            var $grid = issueModal.getGrid();
            $.get($grid.children('.issue-image').data('url'), {id:$grid.data('id')}, function(html){
                $('#issue-show-modal').html(html);
            });
        });
    });

});
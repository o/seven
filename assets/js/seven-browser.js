var Seven = {
    currentMode : 'timeline',
    currentRepositoryId : false,
    ajaxUrl : 'ajax.php',

    getRepositoryList: function(){
        var repositoryListDiv = $('#repository-list');
        var repositoryListInner = $('#repository-list-inner');
        
        $.ajax({
            url: this.ajaxUrl,
            type: 'POST',
            dataType: 'json',
            data: {
                'action' : 'repositories'
            },
            success: function(data) {
                if (data.length > 0) {
                    for (var i in data){
                        repositoryListInner.append('<li>\n\
                                                <a href="javascript:void(0)" rel="'+ i +'">' + data[i].name + '</a>\n\
                                                <br>\n\
                                                <span class="quiet">' + data[i].url + '</span>\n\
                                                </li>');
                    }
                    return true;
                } else {
                    repositoryListDiv.html('No repositories found.');
                    return false;
                }
            },
            error: function() {
                repositoryListDiv.html('An error occured when fetching repository list.');
                return false;
            }
        })
    },

    setRepositoryId: function(repository_id) {
        this.currentRepositoryId = repository_id;
        return true;
    },

    getRepositoryId: function() {
        return this.currentRepositoryId;
    },
    
    setMode: function(mode) {
        this.currentMode = mode;
        $('#modes a').each(function() {
            $(this).removeClass('selected');
        });
        $('#' + mode).addClass('selected');
        return true
    },
    
    getMode: function() {
        return this.currentMode;
    },
    
    action : function() {
        switch (Seven.getMode()) {
            case 'timeline':
                Timeline.getRepositoryLog($(this).attr('rel'));
                break;
                
            case 'browse':
                Browse.getFileList($(this).attr('rel'));
                break;
            
            default:
                break;
        }
    }
    
}

var Timeline = {
    
    getRepositoryLog: function(repository_id){
        if (Seven.getRepositoryId() != repository_id) {
            $('#revision').val('');
        }
        Seven.setRepositoryId(repository_id);
        var contentDiv = $('#content');
        contentDiv.html('<div class="success">Fetching logs..</div>');
        $.ajax({
            url: Seven.ajaxUrl,
            type: 'POST',
            dataType: 'json',
            data: {
                'action' : 'log',
                'repository_id' : repository_id,
                'limit' : $('#limit').val(),
                'revision' : $('#revision').val()
            },
            success: function(data) {
                if (data.length > 0) {
                    contentDiv.empty();
                    for (var i in data){
                        contentDiv.append('<div id="revision-log-' + data[i].revision + '" class="revision-log clearfix"></div>');
                        $('#revision-log-' + data[i].revision).append('<div class="revision-number span-2 colborder">' + data[i].revision + '</div>');
                        $('#revision-log-' + data[i].revision).append('<div class="revision-author span-5 quiet">' + data[i].author + ', ' + data[i].date + '</div>');
                        $('#revision-log-' + data[i].revision).append('<div class="revision-message span-10 last">' + data[i].message + '</div>');
                        if (data[i].files.length > 0) {
                            var files = data[i].files;
                            contentDiv.append('<ul id="revision-log-' + data[i].revision + '-files" class="revision-files clearfix"></div>');
                            for (var j in files) {
                                $('#revision-log-' + data[i].revision + '-files').append('<li>' + files[j].filename + ', ' + files[j].action + '</li>');
                            }
                        }
                    }
                    return true;
                } else {
                    contentDiv.html('<div class="notice">No commit log found.</div>');
                    return false;
                }
            },
            error: function() {
                $(contentDiv).html('<div class="error">An error occured when fetching commit logs.</div>');
                return false;
            }
        });
    }    
    
}

var Browse = {
    
    getFileList: function(repository_id){
        if (Seven.getRepositoryId() != repository_id) {
            $('#revision').val('');
        }        
        Seven.setRepositoryId(repository_id);
        var contentDiv = $('#content');
        contentDiv.html('<div class="success">Fetching files..</div>');
        $.ajax({
            url: Seven.ajaxUrl,
            type: 'POST',
            dataType: 'json',
            data: {
                'action' : 'ls',
                'repository_id' : repository_id,
                'revision' : $('#revision').val()
            },
            success: function(data) {
                if (data.length > 0) {
                    contentDiv.empty();
                    for (var i in data){
                        contentDiv.append('<div id="repository-file-' + i + '" class="repository-file clearfix"></div>');
                        $('#repository-file-' + i).append('<div class="file-kind span-1"><img src="assets/img/' + data[i].kind + '.png"</div>');                        
                        $('#repository-file-' + i).append('<div class="file-name span-8">' + data[i].name + '</div>');                        
                        $('#repository-file-' + i).append('<div class="file-size span-2">' + data[i].size + '</div>');                        
                        $('#repository-file-' + i).append('<div class="file-revision span-2">r' + data[i].revision + '</div>');                        
                        $('#repository-file-' + i).append('<div class="file-author span-5 quite last">' + data[i].author + ', ' + data[i].date + '</div>');                        
                    }
                    return true;
                } else {
                    return false;
                }
            },
            error: function() {
                return false;
            }
        });        
    }
    
}


// Stuff to do as soon as the DOM is ready;

$(document).ready(function() {
    Seven.setMode('timeline');
    Seven.getRepositoryList();
    $('#refresh').click(function () {
        Seven.action();
        })
    $('#revision').focus(function() {
        $('#revision-notice').fadeIn(1000)
    });
    $('ul#repository-list-inner > li a').live('click', function(){
        Seven.action();
    });
    $('#modes a').live('click', function(){
        Seven.setMode($(this).attr('rel'));
    });


});


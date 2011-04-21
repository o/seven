var Browser = {
    currentRepository : false,
    currentRevision : false,
    ajaxUrl : 'ajax.php',

    getRepositories: function(){
        var repositoryListDiv = '#repository-list';
        $.ajax({
            url: this.ajaxUrl,
            type: 'POST',
            dataType: 'json',
            data: {
                'action' : 'repositories'
            },
            success: function(data) {
                if (data.length > 0) {

                    $(repositoryListDiv).html('<ul></ul>')
                    var repositoryListUl = $(repositoryListDiv +' ul');

                    for (var i = data.length - 1; i >= 0; i--){
                        repositoryListUl.append('<li>\n\
                                                <a href="#" onclick="Browser.getRepositoryLog('+ i +')">' + data[i].name + '</a>\n\
                                                <br>\n\
                                                <span class="quiet">' + data[i].url + '</span>\n\
                                                </li>')
                    }

                } else {
                    $(repositoryListDiv).html('No repositories found.')
                }
            },
            error: function() {
                $(repositoryListDiv).html('An error occured when fetching repository list.')
            }
        })
    },

    getRepositoryLog: function(repository_id){
        var contentDiv = '#content';
        $.ajax({
            url: this.ajaxUrl,
            type: 'POST',
            dataType: 'json',
            data: {
                'action' : 'log',
                'repository_id' : repository_id,
                'limit' : $('#limit').val(),
                'revision-start' : $('#revision-start').val(),
                'revision-end' : $('#revision-end').val()
            },
            success: function(data) {
                if (data.length > 0) {

                    $(contentDiv).empty()
                    for (var i = data.length - 1; i >= 0; i--){
                        $(contentDiv).append('<div id="revision-log-' + data[i].revision + '" class="revision-log"></div>')

                        $('#revision-log-' + data[i].revision).html('<span class="revision-number span-2">' + data[i].revision + '</span>\n\
                                                          <span class="revision-author span-4">' + data[i].author + '</span>\n\
                                                          <span class="revision-message span-6">' + data[i].message + '</span>\n\
                                                          <span class="revision-date span-6 last">' + data[i].date + '</span>')

                        
                    }

                } else {
                    $(contentDiv).html('No commit log found.')
                }
            },
            error: function() {
                $(contentDiv).html('An error occured when fetching commit logs.')
            }
        })
    }
}

// Stuff to do as soon as the DOM is ready;

$(document).ready(function() {
    Browser.getRepositories()
});
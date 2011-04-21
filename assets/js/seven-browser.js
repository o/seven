var Browser = {
    currentRepository : false,
	currentRevision : false,
	ajaxUrl : 'ajax.php',

	getRepositories: function(){
	    $.ajax({
	        url: this.ajaxUrl,
	        type: 'POST',
	        dataType: 'json',
	        data: {
	            'action' : 'repositories'
	        },
	        success: function(data) {
	            if (data.length > 0) {

	                $('#repository-list').html('<ul></ul>')
	                var repositoryListUl = $('#repository-list ul');

	                for (var i = data.length - 1; i >= 0; i--){
	                    repositoryListUl.append('<li><a href="#" onclick="Browser.getRepositoryLog('+ i +')">' + data[i].name + '</a><br><span class="quiet">' + data[i].url + '</span></li>')
	                }

	            } else {
	                $('#repository-list').html('No repositories found.')
	            }
	        },
	        error: function() {
	            $('#repository-list').html('An error occured when fetching repository list.')
	        }
	    })
	},

	getRepositoryLog: function(repository_id){
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

	                $('#content').empty()
	                for (var i = data.length - 1; i >= 0; i--){
	                    $('#content').append(data[i].revision)
	                }

	            } else {
	                $('#content').html('No commit log found.')
	            }
	        },
	        error: function() {
	            $('#content').html('An error occured when fetching commit logs.')
	        }
	    })
	}
}


// Stuff to do as soon as the DOM is ready;

$(document).ready(function() {
	Browser.getRepositories()
});
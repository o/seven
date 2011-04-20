var currentRepository = false;
var currentRevision = false;
function getRepositories() {
    var repositoryListDiv = $("#repository-list");

    $.ajax({
        url: 'ajax.php',
        type: 'POST',
        dataType: 'json',
        data: {
            "action" : "repositories"
        },
        success: function(data) {
            if (data.length > 0) {

                repositoryListDiv.html('<ul></ul>')
                var repositoryListUl = $('#repository-list ul');

                for (var i = data.length - 1; i >= 0; i--){
                    repositoryListUl.append('<li><a onclick="changeRepository('+ i +')">' + data[i].name + '</a><br><span class="quiet">' + data[i].url + '</span></li>')
                }
                
            } else {
                repositoryListDiv.html('No repositories found.')
            }
        },
        error: function() {
        repositoryListDiv.html('An error occured when fetching repository list.')
        }
    });

}

function getRepositoryLog() {
    
}

function toggleLogOptions() {
    $('#log-options').toggle('slow', function() {
        // Animation complete.
        });
}
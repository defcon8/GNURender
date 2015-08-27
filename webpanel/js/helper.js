/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function editTrigger(id) {
    $("#triggerscontainer").load("data.php?controller=triggers&view=edit&id=" + id);
}

function createProject() {
    //showLoading();        
    //$('#content').load("data.php?controller=projects&view=create");
    window.location = "index.php?controller=projects&view=create";
}

function showProjectDetails(id) {
    showLoading();
    $('#content').load("data.php?controller=projects&view=details&projid=" + id);
}

function showTaskDetails(id) {
    showLoading();
    $('#content').load("data.php?controller=tasks&view=details&taskid=" + id);
}

function deleteProject(id) {
    if (confirm('Are you sure you want to delete this project?')) {
        showLoading();
        $('#content').load("data.php?controller=projects&view=overview&action=delete&projid=" + id);
    }
}

function movieScaleSwitch() {
    var checked = $('#scale').prop('checked');
    $('#scalewidth').prop('disabled', !checked);
    $('#scaleheight').prop('disabled', !checked);
}

function createTrigger(projid) {
    $('#triggerscontainer').load("data.php?controller=triggers&view=create&projid=" + projid);
}

function deleteTrigger(projid, id) {
    $('#triggerscontainer').load("data.php?controller=triggers&action=delete&view=overview&projid=" + projid + "&id=" + id);
}

function showTriggersOverview(projid) {
    $('#triggerscontainer').load("data.php?controller=triggers&view=overview&projid=" + projid);
}

function createMovie(projid) {
    $('#moviescontainer').load("data.php?controller=movies&view=create&projid=" + projid);
}

function deleteMovie(projid, id) {
    if (confirm('Are you sure you want to delete this movie?')) {
        $('#moviescontainer').load("data.php?controller=movies&view=overview&action=delete&projid=" + projid + "&id=" + id);
    }
}

function downloadMovie(id) {
    window.location.href = "data.php?controller=tasks&view=data&action=getmovie&taskid=" + id;
}

function addNode() {
    showLoading();
    $('#content').load("data.php?controller=nodes&view=add");
}

function showLoading() {
    $('#content').html('<img class="loadingimage" src="images/loader.gif">');
}

//menu

function menuProjects() {
    showLoading();
    $('#content').load("data.php?controller=projects");
}

function menuNodes() {
    showLoading();
    $('#content').load("data.php?controller=nodes");
}

function menuLogbook() {
    showLoading();
    $('#content').load("data.php?controller=logbook");
}

function menuSettings() {
    showLoading();
    $('#content').load("data.php?controller=settings");
}

function menuHelp() {
    showLoading();
    $('#content').load("data.php?controller=help");
}

function menuCredits() {
    showLoading();
    $('#content').load("data.php?controller=credits");
}

function editNode(id) {

}

function forgetNode(id) {
    if (confirm('Are you sure you want to forget this node?')) {
        $.ajax({
            url: "data.php?controller=nodes&action=forget&id=" + id,
            context: document.body
        }).done(function() {
            $('#content').load("data.php?controller=nodes");
        });
        
    }
}

function generateAPIKey() {
    $('#apikey').val(token());
}

var rand = function() {
    return Math.random().toString(36).substr(2); // remove `0.`
};

var token = function() {
    return rand() + rand(); // to make it longer
};
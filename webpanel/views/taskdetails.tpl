<ul id="tabs" class="nav nav-tabs" data-tabs="tabs">
    <li><a href="#overview" data-toggle="tab">{TASK_OVER}: {TaskId}</a></li>
    <li><a href="#render" data-toggle="tab">{TASK_RNDR}</a></li>
    <li><a href="#procoutput" data-toggle="tab">{TASK_PROO}</a></li>  
    <li><a href="#logbook" data-toggle="tab">{TASK_LOGB}</a></li>
    <li><a href="#control" data-toggle="tab">{TASK_CTRL}</a></li>
</ul>

<div id="tab-content" class="tab-content">
    <div class="tab-pane active" id="overview">
        <div style="padding-left:15px;padding-top:15px;">
            <div>{TASK_OVER_PROI}: {ProjId}</div>
            <div>{TASK_OVER_FRMN}: {FrameNr}</div>
            <div>{TASK_OVER_PROC}: {Node}</div>
        </div>
    </div>
    <div class="tab-pane active" id="render">
        <div style="padding-left:15px;padding-top:15px;">
            <div>{ImgData}</div>
        </div>
    </div>
    <div class="tab-pane active" id="procoutput">
        <div style="padding-left:15px;padding-top:15px;">
            <div>{ProcOutput}</div>
        </div>
    </div>
    <div class="tab-pane" id="logbook">
        <div style="padding-left:15px;padding-top:15px;">
            {TaskLogbook}
        </div>
    </div>
    <div class="tab-pane" id="control">
        <div style="padding-left:15px;padding-top:15px;">
            <a href="index.php?controller=tasks&view=details&action=rerender&taskid={TaskId}" class="btn btn-warning"><i class="glyphicon glyphicon-refresh"></i> {BUTTON_TASK_CTRL_RREN}</a>
            <a href="index.php?controller=tasks&view=overview&action=delete&taskid={TaskId}" class="btn btn-danger"><i class="glyphicon glyphicon-trash"></i> {BUTTON_TASK_CTRL_DELE}</a>
            <a href="{DownloadLink}" class="btn btn-success"><i class="glyphicon glyphicon-cloud-download"></i> {BUTTON_TASK_CTRL_DWNL}</a>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('#tabs a').click(function(e){
        e.preventDefault()
        $(this).tab('show')
    })
    $('#tabs a:first').tab('show')
</script>

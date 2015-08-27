<ul id="tabs" class="nav nav-tabs" data-tabs="tabs">
    <li class="active"><a href="#overview" data-toggle="tab">{PROJ_OVER}: {ProjId}</a></li>
    <li><a href="#render" data-toggle="tab">{PROJ_RNDR}</a></li>
    <li><a href="#movies" data-toggle="tab">{PROJ_MOVS}</a></li>
    <li><a href="#tasks" data-toggle="tab">{PROJ_TASK}</a></li>
    <li><a href="#logbook" data-toggle="tab">{PROJ_LOGB}</a></li>
    <li><a href="#triggers" data-toggle="tab">{PROJ_TRIG}</a></li>
    <li><a href="#control" data-toggle="tab">{PROJ_CTRL}</a></li>
</ul>

<div class="tab-content" id="my-tab-content">
    <div class="tab-pane active" id="overview">
        <div style="padding-left:15px;padding-top:15px;">
            <div style="height: 15px;"></div>
            <div>{PROJ_OVER_ID}: {ProjId}</div>
            <div>{PROJ_OVER_NAME}: {Name}</div>
            <div>{PROJ_OVER_PROG}: {PercDone}%</div>
            <div>{PROJ_OVER_FRAO}:</div>
            <div>{FrameOverview}</div>
	    <div>
		<canvas id="framesCanvas" width="500" height="500"
			style="border:1px solid #000000;">
		</canvas>
	    </div>
        </div>
    </div>
    <div class="tab-pane" id="render">
        <div style="padding-left:15px;padding-top:15px;">
            <div>{PROJ_RNDR_LAST}:</div>
            <div>{LastRenderedFrame}</div>
        </div>
    </div>
    <div class="tab-pane" id="movies">
        <div id="moviescontainer" style="padding-left:15px;padding-top:15px;">            
    	    {MoviesOverview}
	</div>
    </div>
    <div class="tab-pane" id="tasks">
        <div style="padding-left:15px;padding-top:15px;">
            <div>{TasksTable}</div>
        </div>
    </div>

    <div class="tab-pane" id="logbook">
        <div style="padding-left:15px;padding-top:15px;">    
            {TaskLogbook}
        </div>
    </div>

    <div class="tab-pane" id="triggers">
        <div id="triggerscontainer" style="padding-left:15px;padding-top:15px;">
            {Triggers}
        </div>
    </div>        

    <div class="tab-pane" id="control">
        <div style="padding-left:15px;padding-top:15px;">
            <a href="javascript:deleteProject({ProjId});" class="btn btn-danger"><i class="glyphicon glyphicon-trash"></i> {BUTTON_PROJ_CTRL_DELP}</a>
            <a href="index.php?controller=projects&view=overview&action=retryfailed&projid={ProjId}" class="btn btn-warning"><i class="glyphicon glyphicon-refresh"></i> {BUTTON_PROJ_CTRL_RETF}</a>
        </div>
    </div>
</div>

<script type="text/javascript">
    jQuery(document).ready(function ($) {
	$('#tabs').tab();
	draw();
    });

    function draw(){
	var c = document.getElementById("framesCanvas");
	var ctx = c.getContext("2d");
	ctx.fillStyle = "#FF0000";
	//x,y,width,height
	var zebra;
	for(frame=0;frame < 20; frame++){
	    ctx.fillStyle = zebra ? "#BBBBBB" : "#AAAAAA";
	    zebra = !zebra;
	    ctx.fillRect(frame*20,0,20,20);
	}
    }



</script>

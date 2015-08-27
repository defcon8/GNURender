
<ul id="tabs" class="nav nav-tabs" data-tabs="tabs">
    <li><a href="#users" data-toggle="tab">{SETT_USRS}</a></li>
</ul>

<div id="tab-content" class="tab-content">
    <div class="tab-pane active" id="settings">
        <div style="padding-left:15px;padding-top:15px;">
            <a href="index.php?controller=settings&action=createuser" class="btn btn-primary"><i class="glyphicon glyphicon-user"></i> {BUTTON_USRS_CREA}</a>
            {UsersTable}
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

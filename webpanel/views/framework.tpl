<div class="navbar">
    <div class="navbar-inner">
        <ul class="nav pull-right">
            <li id="fat-menu" class="dropdown">
                <a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-user"></i> <span id="Username">{UserName}</span>
                    <i class="fa fa sign-out"></i>
                </a>
                <ul class="dropdown-menu">
                    <li id="Profile"><a tabindex="0" href="index.php?controller=settings&view=profile">{LOGIN_PROF}</a></li>
                    <li id="LogOut"><a tabindex="-1" href="data.php?controller=login&action=bye">{LOGIN_LOUT}</a></li>
                    <li id="LogOn" style="display:none"><a href="#Logon" role="button" data-toggle="modal">Logon</a></li>
                </ul>
            </li>
        </ul>
        <a class="brand" href="index.php"><img src="images/logo.png"></a>
    </div>
</div>

<div class="sidebar-nav">
    <a href="#dashboard-menu" class="nav-header" data-toggle="collapse">{MENU_DASH}</a>
    <ul id="dashboard-menu" class="nav nav-list collapse in">
        <li><a href="javascript:menuProjects();">{MENU_PROJ}</a></li>
        <li><a href="javascript:menuNodes();">{MENU_NODE}</a></li>
        <li><a href="javascript:menuLogbook();">{MENU_LOGB}</a></li>
        <li><a href="javascript:menuSettings();">{MENU_SETT}</a></li>
        <li><a href="javascript:menuHelp();">{MENU_HELP}</a></li>
        <li><a href="javascript:menuCredits();">{MENU_CRED}</a></li>
    </ul>            
</div>

<div id="content" class="content">
    {Content}
</div>
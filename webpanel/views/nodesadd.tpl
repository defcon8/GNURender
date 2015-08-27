
<div style="padding-left:15px;padding-top:15px;">
    <form class="form-horizontal" action="index.php?controller=nodes" method="post">
    <input type="hidden" name="action" value="add">    
    <ul id="tabs" class="nav nav-tabs" data-tabs="tabs">
        <li class="active"><a href="#general" data-toggle="tab">General</a></li>
        <li><a href="#other" data-toggle="tab">Other</a></li>
    </ul>    
    <div class="tab-content" id="my-tab-content">
            <div class="tab-pane active" id="general"><!-- general -->  
                <div style="padding-left:15px;padding-top:15px;">
                    <fieldset>
                        <div class="form-group">
                            <label for="name" class="control-label col-xs-2">Name</label>
                            <div class="col-xs-4">
                                <input type="text" class="form-control" name="name" id="name" placeholder="ex. Node001">
                                <p class="help-block">Short name of the node.</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="apikey" class="control-label col-xs-2">API Key</label>
                            <div class="col-xs-4">
                                <input type="text" class="form-control" name="apikey" id="apikey" placeholder=""> <button onClick='javascript:generateAPIKey();return false;'>Generate</button>
                                <p class="help-block">This key is needed by the node to authenticate.</p>
                            </div>
                        </div>
                    </fieldset>  
                </div>
            </div>   <!-- end general -->
            <div class="tab-pane" id="other">
                <div style="padding-left:15px;padding-top:15px;">
                    <fieldset>
                        <div class="form-group">
                            <label for="host" class="control-label col-xs-2">Host</label>
                            <div class="col-xs-4">
                                <input type="text" class="form-control" name="host" id="host" placeholder="ex. 192.168.2.1">
                                <p class="help-block">Host- or IP address of machine.</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="port" class="control-label col-xs-2">SSH Port</label>
                            <div class="col-xs-4">
                                <input type="text" class="form-control" name="port" id="port" placeholder="ex. 22">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="user" class="control-label col-xs-2">SSH User</label>
                            <div class="col-xs-4">
                                <input type="text" class="form-control" name="user" id="user" placeholder="ex. root">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="pass" class="control-label col-xs-2">SSH Password</label>
                            <div class="col-xs-4">
                                <input type="text" class="form-control" name="pass" id="pass" placeholder="ex. xxxxxx">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="path" class="control-label col-xs-2">Node path</label>
                            <div class="col-xs-4">
                                <input type="text" class="form-control" name="path"  id="path" placeholder="ex. /opt/node">
                                <p class="help-block">The node will be installed automaticaly in this path.</p>
                            </div>
                        </div>

                         <div class="form-group">
                            <label for="os" class="control-label col-xs-2">OS</label>
                            <div class="col-xs-4">
                                <select id="distro" name="os" id="os" class="input-xlarge">
                                    <option>Debian 7 (Wheezy)</option>
                                </select>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
        </div>
    </div>  
    <div class="form-group">
      <div class="col-xs-offset-2 col-xs-10">
          <button type="submit" class="btn btn-primary">Save</button>
      </div>
    </div>
</form> 
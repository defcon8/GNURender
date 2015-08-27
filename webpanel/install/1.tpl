<div style="padding-left:15px;padding-top:15px;">
    <form class="form-horizontal" action="index.php?step=2" method="post">
        <fieldset>

            <!-- Form Name -->
            <legend>Database installer</legend>

            <!-- Text input-->
            <div class="control-group">
                <label class="control-label" for="host">MySQL Host</label>
                <div class="controls">
                    <input id="host" name="host" type="text" placeholder="localhost" class="input-xlarge" required="">
                    <p class="help-block">The IP or hostname address of the database server.</p>
                </div>
            </div>

            <!-- Text input-->
            <div class="control-group">
                <label class="control-label" for="user">MySQL User</label>
                <div class="controls">
                    <input id="user" name="user" type="text" placeholder="gnurender" class="input-xlarge" required="">
                    <p class="help-block">ex. gnurender</p>
                </div>
            </div>

            <!-- Text input-->
            <div class="control-group">
                <label class="control-label" for="password">MySQL Password</label>
                <div class="controls">
                    <input id="password" name="password" type="text" placeholder="mypassword" class="input-xlarge" required="">
                    <p class="help-block">Password for DB User</p>
                </div>
            </div>

            <!-- Text input-->
            <div class="control-group">
                <label class="control-label" for="database">MySQL Database name</label>
                <div class="controls">
                    <input id="database" name="database" type="text" placeholder="gnurender" class="input-xlarge" required="">
                    <p class="help-block">The name of the database. Please note that the empty database must exist, it is not created automatically.</p>
                </div>
            </div>

            <!-- Text input-->
            <div class="control-group">
                <label class="control-label" for="adminuser">Username</label>
                <div class="controls">
                    <input id="adminuser" name="adminuser" type="text" placeholder="admin" class="input-xlarge" required="" value="admin" disabled>
                    <p class="help-block">Username for Administrator. (note: cannot be changed)</p>
                </div>
            </div>

            <!-- Text input-->
            <div class="control-group">
                <label class="control-label" for="adminpass">Password</label>
                <div class="controls">
                    <input id="adminpass" name="adminpass" type="text" placeholder="mypassword" class="input-xlarge" required="">
                    <p class="help-block">Desired password for Administrator</p>
                </div>
            </div>

            <!-- Text input-->
            <div class="control-group">
                <label class="control-label" for="adminemail">E-Mail</label>
                <div class="controls">
                    <input id="adminemail" name="adminemail" type="text" placeholder="johndoe@corp.com" class="input-xlarge" required="">
                    <p class="help-block">E-Mail address of Administrator.</p>
                </div>
            </div>

            <!-- Button -->
            <div class="control-group">
                <label class="control-label" for="singlebutton"></label>
                <div class="controls">
                    <button id="singlebutton" name="singlebutton" class="btn btn-primary">Install</button>
                </div>
            </div>

        </fieldset>
    </form>
</div>

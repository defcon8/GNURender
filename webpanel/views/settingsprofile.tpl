<div style="padding-left:15px;padding-top:15px;">
    <form class="form-horizontal" action="index.php?controller=settings&action=saveprofile" method="post">
        <fieldset>

            <!-- Form Name -->
            <legend>{PROF_TITL}</legend>

            <!-- Text input-->
            <div class="control-group">
                <label class="control-label" for="user">{PROF_USRN}</label>
                <div class="controls">
                    <input id="user" name="user" type="text" placeholder="" class="input-xlarge" required="" value="{UserName}">
                    <p class="help-block">{PROF_USRN_DESC}</p>
                </div>
            </div>

            <!-- Text input-->
            <div class="control-group">
                <label class="control-label" for="fullname">{PROF_FUNA}</label>
                <div class="controls">
                    <input id="fullname" name="fullname" type="text" placeholder="John Doe" class="input-xlarge" required="" value="{FullName}">
                    <p class="help-block">{PROF_FUNA_DESC}</p>
                </div>
            </div>

            <!-- Password input-->
            <div class="control-group">
                <label class="control-label" for="password">{PROF_PASS}</label>
                <div class="controls">
                    <input id="password" name="password" type="password" placeholder="*******" class="input-xlarge" required="" value="{Password}">
                    <p class="help-block">{PROF_PASS_DESC}</p>
                </div>
            </div>

            <!-- Text input-->
            <div class="control-group">
                <label class="control-label" for="email">{PROF_MAIL}</label>
                <div class="controls">
                    <input id="email" name="email" type="text" placeholder="johndoe@corp.com" class="input-xlarge" required="" value="{EMail}">
                    <p class="help-block">{PROF_MAIL_DESC}</p>
                </div>
            </div>

            <!-- Select Basic -->
            <div class="control-group">
                <label class="control-label" for="language">{PROF_LANG}</label>
                <div class="controls">
                    {LangSelect}
                </div>
            </div>

            <!-- Button -->
            <div class="control-group">
                <label class="control-label" for="singlebutton"></label>
                <div class="controls">
                    <button id="singlebutton" name="singlebutton" class="btn btn-success">{BUTTON_PROF_SUBM}</button>
                </div>
            </div>

        </fieldset>
    </form>

</div>

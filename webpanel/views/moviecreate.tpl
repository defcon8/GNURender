<form id="moviecreateform" class="form-horizontal" action="data.php?controller=movies&action=submit" method="post">
    <input type="hidden" name="projid" value="{ProjId}">
    <fieldset>

        <!-- Form Name -->
        <legend>{MOVI_CREA_TITL}</legend>

        <!-- Text input-->
        <div class="control-group">
            <label class="control-label" for="fps">{MOVI_CREA_FPS}</label>
            <div class="controls">
                <input id="fps" name="fps" type="text" placeholder="25" class="input-xlarge" required="">
                <p class="help-block">{MOVI_CREA_FPS_DESC}</p>
            </div>
        </div>

        <!-- Select Basic -->
        <div class="control-group">
            <label class="control-label" for="codec">{MOVI_CREA_CODC}</label>
            <div class="controls">
                <select id="codec" name="codec" class="input-xlarge">
                    <option value="libx264">x264</option>
                    <option>cinepak</option>
                    <option>exr</option>
                    <option>h261</option>
                    <option>h263</option>
                    <option>h264</option>
                    <option>indeo2</option>
                    <option>indeo3</option>
                    <option>indeo4</option>
                    <option>indeo5</option>
                    <option>mpeg1video</option>
                    <option>mpeg2video</option>
                    <option>mpeg4</option>
                    <option>rawvideo</option>
                    <option>targa</option>
                    <option>tiff</option>
                    <option>vp9</option>
                    <option>wmv1</option>
                    <option>wmv2</option>
                    <option>wmv3</option>
                </select>
            </div>
        </div>

        <!-- Select Basic -->
        <div class="control-group">
            <label class="control-label" for="preset">{MOVI_CREA_PRES}</label>
            <div class="controls">
                <select id="preset" name="preset" class="input-xlarge">
                    <option>veryslow</option>
                    <option>slower</option>
                    <option>slow</option>
                    <option>medium</option>
                    <option>fast</option>
                    <option>faster</option>
                    <option>veryfast</option>
                    <option>superfast</option>
                    <option>ultrafast</option>
                </select>
            </div>
        </div>


        <!-- Multiple Checkboxes (inline) -->
        <div class="control-group">
            <label class="control-label" for="">{MOVI_CREA_SCAL}</label>
            <div class="controls">
                <label class="checkbox inline" for="-0">
                    <input type="checkbox" name="scale" id="scale" onChange="javascript:movieScaleSwitch();">
                    {MOVI_CREA_ENAB}
                </label>
            </div>
        </div>

        <!-- Text input-->
        <div class="control-group">
            <label class="control-label" for="scalewidth">{MOVI_CREA_SCAL_WIDT}</label>
            <div class="controls">
                <input id="scalewidth" name="scalewidth" type="text" placeholder="1024" class="input-xlarge" disabled>
                <p class="help-block">{MOVI_CREA_SCAL_WIDT_DESC}</p>
            </div>
        </div>

        <!-- Text input-->
        <div class="control-group">
            <label class="control-label" for="scaleheight">{MOVI_CREA_SCAL_HEIG}</label>
            <div class="controls">
                <input id="scaleheight" name="scaleheight" type="text" placeholder="768" class="input-xlarge" disabled>
                <p class="help-block">{MOVI_CREA_SCAL_HEIG_DESC}</p>
            </div>
        </div>

        <!-- Button -->
        <div class="control-group">
            <label class="control-label" for="submit"></label>
            <div class="controls">
                <button id="submit" name="submit" class="btn btn-primary">{BUTTON_MOVI_SUBM}</button>
            </div>
        </div>

    </fieldset>
</form>

<script>
    jQuery('#moviecreateform').submit(function(){

        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            data: $(this).serialize(),
            success: function(response){
                jQuery('#moviescontainer').html(response);
            }
        });

        return false;
    });
</script>
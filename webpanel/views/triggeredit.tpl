<form method="GET" action="data.php" id="edittriggerform" class="form-horizontal">
    <input type='hidden' name='controller' value='triggers'>
    <input type='hidden' name='action' value='savetrigger'>
    <input type='hidden' name='id' value='{triggerid}'>
    <input type='hidden' name='projid' value='{projid}'>
    
    <fieldset>

        <!-- Form Name -->
        <legend>Edit Trigger: {triggerid}</legend>

        <!-- Select Basic -->
        <div class="control-group">
            <label class="control-label" for="triggertypeid">On event:</label>
            <div class="controls">
                <select id="triggertypeid" name="triggertypeid" class="input-xlarge">
                    {triggertypeoptions}
                </select>
            </div>
        </div>

        <!-- Select Basic -->
        <div class="control-group">
            <label class="control-label" for="actionid">Do Action:</label>
            <div class="controls">
                <select id="actionid" name="actionid" class="input-xlarge">
                    {actiontypeoptions}
                </select>
            </div>
        </div>

        <!-- Select Basic -->
        <div class="control-group">
            <label class="control-label" for="stateid">State</label>
            <div class="controls">
                <select id="stateid" name="stateid" class="input-xlarge">
                    {triggerstateoptions}
                </select>
            </div>
        </div>

        <!-- Button -->
        <div class="control-group">
            <label class="control-label" for="singlebutton"></label>
            <div class="controls">
                <button id="singlebutton" name="singlebutton" class="btn btn-primary">Save</button>
                <button id="singlebutton" name="singlebutton" type="button" class="btn btn-danger" onClick="javascript:deleteTrigger({projid},{triggerid});return false;">Delete</button>
            </div>
        </div>

    </fieldset>
</form>

<script> 
    jQuery('#edittriggerform').submit( function() {

        $.ajax({
            url     : $(this).attr('action'),
            type    : $(this).attr('method'),
            data    : $(this).serialize(),
            success : function( response ) {
                        jQuery('#triggerscontainer').html(response);
                      }
        });

        return false;
    });		
</script>

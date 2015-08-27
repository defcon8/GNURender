<ul id="tabs" class="nav nav-tabs" data-tabs="tabs">
    <li><a href="#general" data-toggle="tab">{PROJ_CREA_GENE}</a></li>
    <li><a href="#script" data-toggle="tab">{PROJ_CREA_SCRP}</a></li>
</ul>

<div id="tab-content" class="tab-content">
    <div class="tab-pane active" id="general">
        <!-- General Tab -->
        <div class="offset4 span2" style="padding-left:15px;padding-top:15px;">
            <div>
                <div>
                    <fieldset>

                        <legend>{PROJ_CREA_TITL}</legend>
                        <form action="index.php?controller=projects&action=submit" method="post" class="form-horizontal" enctype="multipart/form-data" onsubmit="getVal();">

                            <div class="control-group">
                                <label class="control-label" for="name">{PROJ_CREA_NAME}</label>
                                <div class="controls">
                                    <input id="name" name="name" type="text" placeholder="{PROJ_CREA_NAME_TT}" class="input-xlarge" required="">
                                    <p class="help-block">{PROJ_CREA_NAME_DESC}</p>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="resourcefile">{PROJ_CREA_RESF}</label>
                                <div class="controls">
                                    <input id="resourcefile" name="resourcefile" class="input-file" type="file">
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="format">{PROJ_CREA_OFOR}</label>
                                <div class="controls">
                                    <select id="format" name="format" class="input-xlarge">
                                        <option>PNG</option>
                                        <option>TGA</option>
                                        <option>IRIS</option>
                                        <option>HAMX</option>
                                        <option>FTYPE</option>
                                        <option>JPEG</option>
                                        <option>MOVIE</option>
                                        <option>IRIZ</option>
                                        <option>RAWTGA</option>
                                        <option>AVIRAW</option>
                                        <option>AVIJPEG</option>
                                        <option>BMP</option>
                                        <option>FRAMESERVER</option>
                                    </select>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="engine">{PROJ_CREA_RENG}</label>
                                <div class="controls">
                                    <select id="engine" name="engine" class="input-xlarge">
                                        <option>{COMB_PROJ_CREA_RENG_UNDE}</option>
                                        <option>Blender Render</option>
                                        <option>Blender Game</option>
                                        <option>Cycles</option>
                                    </select>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="frames">{PROJ_CREA_FRMS}</label>
                                <div class="controls">
                                    <input id="frames" name="frames" type="text" placeholder="{PROJ_CREA_FRMS_TT}" class="input-xlarge" required="">
                                    <p class="help-block">{PROJ_CREA_FRMS_DESC}</p>
                                </div>
                            </div>

                    </fieldset>
                </div>
            </div>
        </div>
    </div>
    <div class="tab-pane active" id="script">
        <div style="padding-left:15px;padding-top:15px;">
            <style type="text/css" media="screen">
                body {
                    overflow: hidden;
                }

                #editor {
                    margin: 0;
                    position: relative;
                    top: 0;
                    bottom: 0;
                    left: 0;
                    right: 0;
                    height: 80%;
                }
            </style>
            <input type="hidden" name="renderscript" id="renderscript">
            <div id="editor">import bpy

            </div>
        </div>
    </div>

    <div style="padding-left:15px;padding-top:15px;">
        <div class="control-group">
            <label class="control-label" for="submit"></label>
            <div class="controls">
                <button id="submit" name="submit" class="btn btn-success glyphicon glyphicon-fire"> {BUTTON_PROJ_CREA_SUBM}</button>
            </div>
        </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    $('#tabs a').click(function(e){
        e.preventDefault()
        $(this).tab('show')
    })
    $('#tabs a:first').tab('show')
</script>

<script src="lib/ace/src-noconflict/ace.js" type="text/javascript" charset="utf-8"></script>
<script>
    var editor = ace.edit("editor");
    editor.setTheme("ace/theme/twilight");
    editor.getSession().setMode("ace/mode/python");
</script>
<script>
    function getVal()
    {
        var editor = ace.edit("editor");
        var code = editor.getSession().getValue();
        document.getElementById('renderscript').value = code;
    }
</script>

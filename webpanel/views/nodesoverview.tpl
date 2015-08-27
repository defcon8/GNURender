<div style="padding-left:15px;padding-top:15px;">
    <a href="javascript:addNode();" class="btn btn-primary"><i class="glyphicon glyphicon-plus-sign"></i> {BUTTON_NODE_ADD}</a>
    <div id="nodespace"> 
          <div class="nodescontainer">
              {NodesBlocks}
          </div>
    </div>
</div>
<script>
    
var lastclickednode=-1;
var menu = [{
        name: 'Edit',
        img: 'images/update.png',
        title: 'Edit',
        fun: function (e) {
            editNode(lastclickednode);
        }
    }, {
        name: 'Forget',
        img: 'images/delete.png',
        title: 'Forget',
        fun: function (e) {
            forgetNode(lastclickednode);
        }
    }];
    $('.nodeblock').contextMenu(menu);
</script>


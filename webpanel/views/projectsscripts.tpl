<script>
    $.ajaxSetup({
        cache: false
    });

    function reloadDiv(){
        $('#projspace').load('data.php?controller=projects&view=data').fadeIn("slow");
        setTimeout(reloadDiv, 20000);
    }

    var auto_refresh;
    if(auto_refresh == undefined){
        $(function(){
            reloadDiv();
        });
    }
</script>
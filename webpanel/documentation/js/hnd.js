jQuery.fn.highlight = function(a){
    function d(b, a){
        var e = 0;
        if(b.nodeType == 3){
            var c = b.data.toUpperCase().indexOf(a);
            if(c >= 0){
                e = document.createElement("span");
                e.className = "highlight";
                c = b.splitText(c);
                c.splitText(a.length);
                var g = c.cloneNode(!0);
                e.appendChild(g);
                c.parentNode.replaceChild(e, c);
                e = 1
            }
        }else if(b.nodeType == 1 && b.childNodes && !/(script|style)/i.test(b.tagName))
            for(c = 0; c < b.childNodes.length; ++c)
                c += d(b.childNodes[c], a);
        return e
    }
    return this.each(function(){
        d(this, a.toUpperCase())
    })
};
jQuery.fn.removeHighlight = function(){
    return this.find("span.highlight").each(function(){
        with(this.parentNode)
            replaceChild(this.firstChild, this), normalize()
    }).end()
};
$.extend({getUrlVars: function(){
        for(var a = [], d, b = document.location.href.slice(document.location.href.indexOf("?") + 1).split("&"), f = 0; f < b.length; f++)
            d = b[f].split("="), a.push(d[0]), a[d[0]] = d[1];
        return a
    }, getUrlVar: function(a){
        return $.getUrlVars()[a]
    }});
$(document).ready(function(){
    var a = $.getUrlVar("search");
    a && a != "" && (a = unescape(a)) && $.each(a.split(" "), function(a, b){
        b != "AND" && b != "NOT" && b != "OR" && b != "" && b != " " && $("#topic_content").highlight(b) && $("#topic_header_text").highlight(b) && $("#topic_footer_content").highlight(b)
    })
});
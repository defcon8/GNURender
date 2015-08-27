function HndJsSeResultScore(){
    this.aScores = []
}
HndJsSeResultScore.prototype.Clear = function(){
    this.aScores.length = 0
};
HndJsSeResultScore.prototype.AddTopics = function(a){
    for(var b = 0; b < a.length; b++){
        for(var c = !1, d = 0; d < this.aScores.length; d++)
            if(this.aScores[d][0] == a[b][0]){
                this.aScores[d][1] += a[b][1];
                c = !0;
                break
            }
        c || this.aScores.push(a[b])
    }
};
HndJsSeResultScore.prototype.ExcludeTopics = function(a){
    this.aScores = $.grep(this.aScores, function(b, c){
        for(var d = 0; d < a.length; d++)
            if(b[0] == a[d][0])
                return!1;
        return!0
    })
};
HndJsSeResultScore.prototype.SortByScore = function(){
    this.aScores.sort(function(a, b){
        return a[1] > b[1] ? -1 : a[1] < b[1] ? 1 : 0
    })
};
function HndJsSe(){
    this.sInput = "";
    this.aResults = [];
    this.aResultScoreIncluded = new HndJsSeResultScore;
    this.aResultScoreMandatory = new HndJsSeResultScore;
    this.aResultScoreExcluded = new HndJsSeResultScore;
    this.aInputIncluded = [];
    this.aInputMandatory = [];
    this.aInputExcluded = []
}
HndJsSe.prototype.ParseInput = function(a){
    var b = /[-+]?"[^"]+"|[-+]?[^"\s]+/g, c;
    this.aInputIncluded.length = 0;
    this.aInputMandatory.length = 0;
    this.aInputExcluded.length = 0;
    for(this.sInput = a; a = b.exec(this.sInput); )
        if(a[0] && (a = $.trim(a[0]).toLowerCase(), "" != a)){
            c = "";
            if("-" === a[0] || "+" === a[0])
                c = a[0], a = a.substr(1);
            '"' === a[0] && (a = a.substr(1));
            '"' === a[a.length - 1] && (a = a.substr(0, a.length - 1));
            "-" === c ? this.aInputExcluded.push(a) : "+" === c ? this.aInputMandatory.push(a) : this.aInputIncluded.push(a)
        }
};
HndJsSe.prototype.AddTopics = function(a, b){
    for(var c = 0; c < a.length; c++){
        for(var d = !1, e = 0; e < b.length; e++)
            if(b[e][0] == a[c][0]){
                b[e][1] += a[c][1];
                d = !0;
                break
            }
        d || b.push(a[c])
    }
};
HndJsSe.prototype.PerformSearch = function(){
    this.aResults.length = 0;
    this.aResultScoreIncluded.Clear();
    this.aResultScoreMandatory.Clear();
    this.aResultScoreExcluded.Clear();
    for(var a = 0; a < oWl.length - 1; a += 2){
        for(var b = 0; b < this.aInputIncluded.length; b++)
            -1 !== oWl[a].indexOf(this.aInputIncluded[b]) && this.aResultScoreIncluded.AddTopics(oWl[a + 1]);
        for(b = 0; b < this.aInputMandatory.length; b++)
            -1 !== oWl[a].indexOf(this.aInputMandatory[b]) && this.aResultScoreMandatory.AddTopics(oWl[a + 1]);
        for(b = 0; b < this.aInputExcluded.length; b++)
            -1 !==
                    oWl[a].indexOf(this.aInputExcluded[b]) && this.aResultScoreExcluded.AddTopics(oWl[a + 1])
    }
    this.aResultScoreIncluded.AddTopics(this.aResultScoreMandatory.aScores);
    this.aResultScoreIncluded.ExcludeTopics(this.aResultScoreExcluded.aScores);
    this.aResultScoreIncluded.SortByScore();
    this.aResults = this.aResultScoreIncluded.aScores
};

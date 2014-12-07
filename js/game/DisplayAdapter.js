/**
 * Created by Ariel Lothlorien on 12/6/14.
 */

nop = "nope";

var DisplayAdapter = function(game){
    //Set Stuff Up Vars and functions. (the "this" Scope)
    var object = {
        font: "‘Lucida Console’, Monaco,monospace",
        size: 14,
        dispNumCols: 79,
        dispNumRows: 23,
        dispOffsetX: 60,
        dispOffsetY: 165,
        game: "nogame",
        clear: function(){
            this.text="";

            //Prime raw text
            for(var y= 0; y<this.dispNumRows; y++){
                this.text+=y+":";
                for(var x = 0; x-3< this.dispNumCols; x++){
                    this.text += " ";
                }
                this.text+="\n";
            }

            //Prime color array
            for (var i = 0, len = this.text.length; i < len; i++) {
                this.tcolor[i] = 0;
            }

            //Prime Split color array
            for (var i = 0, len = this.colors.length; i < len; i++) {
                this.texts[i] = this.text;
                if(typeof this.textOBJs[i] === "undefined"){
                    this.textOBJs[i] = this.game.add.text(this.dispOffsetX, this.dispOffsetY, this.text, { font: this.size+"px "+this.font, fill: "#"+this.colors[i], align: "left"} );
                    //console.log('this.game.add.text('+this.dispOffsetX+', '+this.dispOffsetY+', "'+this.text+'", { font: "'+this.size+'px '+this.font+'", fill: "#'+this.colors[i]+'", align: "left"} )')
                }
                this.needsUpdate[i]=true;
                this.textOBJs[i].setText(this.text);
            }
        },
        set: function(stringythingy, color, startIndex){
            var arr = Array.isArray(color); //check arr
            if(!arr && isNaN(color)) color = 0; //Default
            var posOffset=0;
            for (var i = 0, len = stringythingy.length; i < len; i++) {
                if(stringythingy[i]=="\n") posOffset+=this.dispNumCols;
                if(arr) this._setChar(startIndex+i+posOffset, stringythingy[i], color[i]);
                else this._setChar(startIndex+i+posOffset, stringythingy[i], color);
            }
        },
        get: function(startIndex, endIndex){},
        setChar: function(x, y,char,color){
            this._setChar(this.getIndex(x,y),char,color);
        },
        _setChar: function(i,char,color){
            if(i<this.text.length){
                if(this.texts[color][i]!=char){
                    this.needsUpdate[color] = true;
                    this.texts[color]=this._setCharAt(this.texts[color],i,char);
                }
            }
        },
        getIndex:function(x, y){
            if(y!=0) return x+((this.dispNumCols+1)*y)+1;
            return x+((this.dispNumCols)+1*y);
        },
        text: "",
        texts: [],
        textOBJs: [],
        tcolor: [],
        colors: ["2D882D","88CC88","55AA55","116611","004400","00BB1C"],
        needsUpdate: [false,false,false,false,false,false],
        tick: function(){
            for (var i = 0, len = this.texts.length; i < len; i++) {
                if(this.needsUpdate[i]){
                    this.textOBJs[i].setText(this.texts[i]);
                }
            }
        },

        _setCharAt: function(str,index,chr) {
            if(index > str.length-1) return str;
            if(index == 0) return chr + str.substr(1);
            return str.substr(0,index) + chr + str.substr(index+1);
        }
    };

    //Do Constructor
    object.game = game; //pass in the game var.

    //prime the text arrays and text char color array
    object.clear();

    game.add.sprite(0, 0, 'GameMask');

    //setup the actual text render objects
    //for (var i = 0, len = this.colors.length; i < len; i++) {
    //    object.textOBJs[i] = game.add.text(this.dispOffsetX, this.dispOffsetY, this.text, { font: this.Size+"px "+this.font, fill: this.colors[i], align: "left"} );
    //}


    //return object "instance"
    return object;
}
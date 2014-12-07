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
            this.text=[];

            //Prime raw text
            for(var y= 0; y<this.dispNumRows; y++){
                //this.text+=y+":";
                this.text[y]=[];
                for(var x = 0; x< this.dispNumCols; x++){
                    this.text[y][x] = " ";
                }
                //this.text+="\n";
            }

            //Prime color array
            for(var y= 0; y<this.dispNumRows; y++){
                this.tcolor[y]=[];
                for(var x = 0; x< this.dispNumCols; x++){
                    this.tcolor[y][x] = 0;
                }
            }

            //Prime Split color array
            for (var i = 0, len = this.colors.length; i < len; i++) {
                if(typeof this.textOBJs[i] === "undefined"){
                    this.textOBJs[i] = this.game.add.text(this.dispOffsetX, this.dispOffsetY, "", { font: this.size+"px "+this.font, fill: "#"+this.colors[i], align: "left"} );
                    //console.log('this.game.add.text('+this.dispOffsetX+', '+this.dispOffsetY+', "'+this.text+'", { font: "'+this.size+'px '+this.font+'", fill: "#'+this.colors[i]+'", align: "left"} )')
                }
                this.needsUpdate[i]=true;
            }
        },
        set: function(stringythingy, color, startX, startY){
            var arr = Array.isArray(color); //check arr
            if(!arr && isNaN(color)) color = 0; //Default
            var posOffsetX= 0, posOffsetY=0;
            for (var i = 0, len = stringythingy.length; i < len; i++) {
                if(stringythingy[i]=="\n") {
                    posOffsetX = 0;
                    posOffsetY++;
                } else {
                    if(arr) this.setChar(startX+posOffsetX, startY+posOffsetY, stringythingy[i], color[i]);
                    else this.setChar(startX+posOffsetX, startY+posOffsetY, stringythingy[i], color);
                    posOffsetX++;
                }
            }
        },
        get: function(startX, startY, len){},
        setChar: function(x, y,char,color){
            if(x>=0 && x<this.dispNumCols && y>=0 && y<this.dispNumRows){
                if(this.text[y][x]!=char || this.tcolor[y][x]== color){
                    this.needsUpdate[color] = true;
                    if(this.text[y][x]!=" ") this.needsUpdate[this.tcolor[y][x]]=true;
                    this.text[y][x]=char[0];
                }
            }
        },
        getIndex:function(x, y){
            if(y!=0) return x+((this.dispNumCols+1)*y)+1;
            return x+((this.dispNumCols)+1*y);
        },
        text: [],
        textOBJs: [],
        tcolor: [],
        colors: ["2D882D","88CC88","55AA55","116611","004400","00BB1C"],
        needsUpdate: [false,false,false,false,false,false],
        tick: function(){
            for (var i = 0, len = this.colors.length; i < len; i++) {
                if(this.needsUpdate[i]){
                    var temp = "";
                    for(var y= 0; y<this.dispNumRows; y++){
                        for(var x = 0; x< this.dispNumCols; x++){
                            if(this.tcolor[y][x]==i) temp+=this.text[y][x];
                            else temp+=" ";
                        }
                        temp+="\n";
                    }
                    this.textOBJs[i].setText(temp);
                }
            }
        }
    };

    //Do Constructor
    object.game = game; //pass in the game var.

    //prime the text arrays and text char color array
    object.clear();

    //game.add.sprite(0, 0, 'GameMask');

    //setup the actual text render objects
    //for (var i = 0, len = this.colors.length; i < len; i++) {
    //    object.textOBJs[i] = game.add.text(this.dispOffsetX, this.dispOffsetY, this.text, { font: this.Size+"px "+this.font, fill: this.colors[i], align: "left"} );
    //}


    //return object "instance"
    return object;
}
/**
 * Created by Ariel Lothlorien on 12/6/14.
 */

nop = "nope";

var TerminalDriver = function(theDisplayAdapter){
    //Set Stuff Up Vars and functions. (the "this" Scope)
    var object = {
        da: nop,
        t: nop,

        cursor: {x:0,y:0},
        color: 0,
        data: nop, //Used for data that is read in when data is read in.
        readingInput: false,
        readingMask: nop,

        create:function(){
            //  Capture all key presses
            //this.da.game.input.keyboard.addCallbacks(this, this.input, null, null);

            //this.t = this.da.game.time.create(false);
            //  Start the timer running - this is important!
            //  It won't start automatically, allowing you to hook it to button events and the like.
            //this.t.start();
        },

        write:function(string, color){
            if(isNaN(color)) color = this.color; //Default
            var newpos = this.da.set(string, color, this.cursor.x, this.cursor.y);
            this.cursor.x=newpos.x;
            this.cursor.y=newpos.y;
        },

        readLine:function(mask){
            this.data = "";
            this.readingInput = true;
            if(typeof mask ==="undefined") this.readingMask = nop;
            else this.readingMask = mask;
        },

        clear: function(){
            this.cursor.x = 0;
            this.cursor.y = 0;
            this.da.clear();
        },

        input: function(input){
            if(this.readingInput){
                if(input === "\n" || input === "\r"){
                    this.readingInput = false;
                } else if(input === "\b"){
                    if(this.data.length > 0){
                        this.cursor.x--;
                        this.write(" ");
                        this.cursor.x--;
                        this.data = this.data.substring(0, this.data.length-1);
                    }
                } else{
                    this.data += input;
                    if(this.readingMask==nop) {
                        this.write(input);
                    }
                    else {
                        this.write(this.readingMask);
                    }
                }
            }
        },

        slowPrint:function(minTime, maxTime, str){
            this.bufferedWriting[this.bufferedWriting.length] = new TermTypeout(this, minTime, maxTime, str);
            return this.bufferedWriting[this.bufferedWriting.length-1];
        },

        bufferedWriting:[],

        tick: function(){
            if(this.bufferedWriting.length>0){
                if(this.bufferedWriting[0] instanceof TermTypeout){
                    if(this.bufferedWriting[0].t.expired) {
                        this.bufferedWriting[0].shift();
                        this.bufferedWriting[0].t.start();
                    }
                }
                if(typeof this.bufferedWriting[0] === "function"){
                    Phaser.Easing.Quintic.InOut()
                }
            }
        }
    };

    //Do Constructor
    object.da = theDisplayAdapter; //pass in the game var.
    object.create();

    //return object "instance"
    return object;
}
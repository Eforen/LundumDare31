/**
 * Created by Ariel Lothlorien on 12/6/14.
 */

nop = "nope";

var TermTypeout = function(terminal, minTime, maxTime, str){
    //Set Stuff Up Vars and functions. (the "this" Scope)
    var object = {
        term: nop,
        t: nop,
        isDone: false,
        str: "",
        strPos:0,
        create:function(minTime, maxTime, str){
            this.t = this.term.da.game.time.create(true);

            var time = 0;
            this.str = str;

            for (var i = 0, len = str.length; i < len; i++) {
                time+= Math.random()*(maxTime - minTime) + minTime;
                this.t.add(time,function(){
                    this.term.write(this.str[this.strPos]);
                    this.strPos++;
                },this);
            }

            //  Start the timer running - this is important!
            //  It won't start automatically.
            //this.t.start();
        },

        tick: function(){
            console.log("wtf");
            this.term.write(this.str[this.strPos]);
            this.strPos++;
        }
    };

    //Do Constructor
    object.term = terminal; //pass in the game var.
    object.create(minTime, maxTime, str);

    //return object "instance"
    return object;
}
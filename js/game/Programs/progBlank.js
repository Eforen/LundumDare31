/**
 * Created by Ariel Lothlorien on 12/7/14.
 */

nop = "nope";

var progBlank = function(terminal){
    //Set Stuff Up Vars and functions. (the "this" Scope)
    var object = {
        term: nop,
        running: true,

        create:function(){
        },

        tick: function(){
            this.running = false;
        }
    };

    //Do Constructor
    object.term = terminal; //pass in the game var.
    object.create();

    //return object "instance"
    return object;
}
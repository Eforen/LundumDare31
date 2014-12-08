/**
 * Created by Ariel Lothlorien on 12/7/14.
 */

nop = "nope";

var progBlank = function(computer){
    //Set Stuff Up Vars and functions. (the "this" Scope)
    var object = {
        comp: nop,
        running: true,

        create:function(){
        },

        tick: function(){
            this.running = false;
        }
    };

    //Do Constructor
    object.comp = computer; //pass in the game var.
    object.create();

    //return object "instance"
    return object;
}
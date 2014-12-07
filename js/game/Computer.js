/**
 * Created by Ariel Lothlorien on 12/7/14.
 */

nop = "nope";

var computer = function(game){
    //Set Stuff Up Vars and functions. (the "this" Scope)
    var object = {
        game: nop,
        term: nop,
        display: nop,
        crp: nop, //current running program
        create:function(game){
            this.game = game;
            this.display = new DisplayAdapter(game);
            this.term = new TerminalDriver(this.display);
            this.cpr = new progBoot(term);
        },

        tick: function(){
           if(!this.crp.running){
               this.crp = new progCMD(term);
           }
        }
    };

    //Do Constructor
    object.term = terminal; //pass in the game var.
    object.create(minTime, maxTime, str);

    //return object "instance"
    return object;
}
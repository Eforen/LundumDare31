/**
 * Created by Ariel Lothlorien on 12/7/14.
 */

nop = "nope";

var Computer = function(game){
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
            this.crp = new progBoot(this);
            //this.crp = new progRegister(this);
        },

        input: function (input){
            this.term.input(input);
        },

        tick: function(){
            this.term.tick();
            this.display.tick();

            this.crp.tick();

            if(!this.crp.running){
                this.crp = new progCMD(this);
            }
        }
    };

    //Do Constructor
    //object.term = game; //pass in the game var.
    object.create(game);

    //return object "instance"
    return object;
}
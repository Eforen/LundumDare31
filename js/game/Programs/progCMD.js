/**
 * Created by Ariel Lothlorien on 12/7/14.
 */

nop = "nope";

var progCMD = function(computer){
    //Set Stuff Up Vars and functions. (the "this" Scope)
    var object = {
        comp: nop,
        running: true,

        create:function(){
            this.comp.term.write("\nEnter your command.\n> ");
            this.comp.term.readLine();
        },

        tick: function(){
            //this.running = false;
            if(!this.comp.term.readingInput) {
                switch(this.comp.term.data.toLowerCase()){
                    case "hack":
                        this.comp.term.write("\n");
                        this.comp.crp= new progHack(this.comp);
                        break;
                    default:
                        this.comp.term.write("\nCommand not recognised try \"hack {ip}\"...\n> ");
                        this.comp.term.readLine();
                }
            }
        }
    };

    //Do Constructor
    object.comp = computer; //pass in the game var.
    object.create();

    //return object "instance"
    return object;
}
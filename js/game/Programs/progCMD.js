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
                switch(this.comp.term.data.toLowerCase().split(" ")[0]){
                    case "hack":
                        this.comp.term.write("\n");
                        this.comp.crp= new progHack(this.comp);
                        break;
                    case "secret":
                        this.comp.term.clear();
                        this.comp.term.write("\nThe hack feature was a last minute implementation of the api and stuff.\n\nSo it is unfortunately mostly smoke and mirrors! \n\nWhat really happens is that no mater what you type after hack it just does rand(-4000, 5000) on the server then adds that you the player files money and makes sure it is not less then 0. \n\nThe only reason I did this was I ran out of time. I programmed a very robust system that can to so much more then this! Yet it just runs this simple program.\n\nThe kicker is that every player has a unique IP address that is stored in a global IP Map");
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
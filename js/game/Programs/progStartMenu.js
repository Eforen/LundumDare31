/**
 * Created by Ariel Lothlorien on 12/7/14.
 */

nop = "nope";

var progStartMenu = function(computer){
    //Set Stuff Up Vars and functions. (the "this" Scope)
    var object = {
        comp: nop,
        running: true,

        create:function(){
            this.comp.term.clear();
            this.comp.term.write("\n\n\n\nWould you like to Login(L) or Register(R): ");
            this.comp.term.readLine();
        },

        tick: function(){
            //this.running = false;
            if(!this.comp.term.readingInput) {
                switch(this.comp.term.data.toLowerCase()){
                    case "l":
                    case "login":
                    case "log":
                        this.comp.crp= new progLogin(this.comp);
                        break;
                    case "r":
                    case "register":
                    case "reg":
                        this.comp.crp= new progRegister(this.comp);
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
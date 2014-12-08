/**
 * Created by Ariel Lothlorien on 12/7/14.
 */

nop = "nope";

var progHack = function(computer){
    //Set Stuff Up Vars and functions. (the "this" Scope)
    var object = {
        comp: nop,
        running: true,

        create:function(){
            this.comp.term.clear();
            this.comp.term.write("\n\nHacking the all the tubes in the interwebz!");
            this.hack();
        },

        write: function(){
            if(this.running) this.comp.term.write(".");
        },

        tick: function(){
        },
        hack: function(){
            $.ajax("http://ld.ubersoftech.com/api/hack.php", {
                context:this,
                success: function(data) {
                    //this.comp.term.write(data);
                    if(data.indexOf("NOPE")!=-1){
                        this.comp.term.write("\n\nYou are so not so 1337 you get locked out of the bank servers and no one cares!");
                        this.comp.crp= new progCMD(this.comp);
                    } else {
                        r = data.split("|");
                        if(r[1]>0) this.comp.term.write("\n\nYou are so 1337 you p0wn the all the internetz and get all the Po0n!\n\nYou managed to get $"+Number(r[1]).toLocaleString()+" Your so awesome you now have $"+Number(r[2]).toLocaleString());
                        if(r[1]==0) this.comp.term.write("\n\nYou did not get squat");
                        if(r[1]<0) {
                            this.comp.term.write("\n\nYou are so not 1337 you accidentally p0wn your own bank account and lose $"+Number((r[1]*-1)).toLocaleString()+".");
                            if(r[2] >0) this.comp.term.write(" You still have have $"+Number(r[2]).toLocaleString()+" so its ok... Right?..");
                            if(r[2] == 0) this.comp.term.write(" Your totally out of $ soo much suck!! UNLUCKY!!!");
                        }
                        this.running = false;
                    }
                },
                error: function() {
                    this.comp.term.write("Comm Error trying again...\n");
                    this.hack();
                }
            });
        }
    };

    //Do Constructor
    object.comp = computer; //pass in the game var.
    object.create();

    //return object "instance"
    return object;
}
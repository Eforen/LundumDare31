/**
 * Created by Ariel Lothlorien on 12/7/14.
 */

nop = "nope";

var progBoot = function(computer){
    //Set Stuff Up Vars and functions. (the "this" Scope)
    var object = {
        comp: nop,
        running: true,
        firstRun: nop,

        create:function(){
            this.firstRun = this.comp.term.slowPrint(1,20, "╒════════════════════╗\n" +
                "│  Welcome to JackIn ║\n"+
                "╘════════════════════╝\n"+
                "Blue Hornet BIOS v17.2.532.15PCmQ, Lois Turns\n"+
                "Copyright (C) 1523-1616, Yolo Software, Inc\n"+
                "\n"+
                "ASF1-B1EASG14QQ5WR-696S2 RQx\n"+
                "\n"+
                "Processor : RND Phanom(tm) IXV X16 270\n"+
                "<CPUID:05546F54 Patch ID:D0082>\n"+
                "Memory Testing : 4192316K OK\n"+
                "Memory information : DQR5 1066 Unfeathered Mode, 64-lip\n"+
                "IRD Channel 0: 14bit Modem QRc Nx\n"+
                "IRD Channel 1: Internal 56Krbit HRD\n"+
                "IRD Channel 2: \n"+
                "IRD Channel 3: \n"+
                ""
            );
            this.firstRun.t.start();
        },

        tick: function(){
            if(this.firstRun.t.expired){
                this.comp.term.clear();
                this.running = false;
                this.comp.crp = new progStartMenu(this.comp);
            }
        }
    };

    //Do Constructor
    object.comp = computer; //pass in the game var.
    object.create();

    //return object "instance"
    return object;
}
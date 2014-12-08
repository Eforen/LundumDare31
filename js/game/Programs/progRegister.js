/**
 * Created by Ariel Lothlorien on 12/7/14.
 */

nop = "nope";

var progRegister = function(computer){
    //Set Stuff Up Vars and functions. (the "this" Scope)
    var object = {
        comp: nop,
        running: true,
        username: nop,
        password: nop,
        password2: nop,
        waiting: true,

        create:function(){
            this.comp.term.write("\nPlease Provide a Login Name: ");
            this.comp.term.readLine();
        },

        tick: function(){
            //this.running = false;
            if(this.waiting && !this.comp.term.readingInput) {
                if(this.username == nop) {
                    this.username = this.comp.term.data;
                    this.comp.term.write("\n\nWARNING: Please do not use a normal password you use anywhere else\n" +
                    "the password you enter here can be stolen ingame with enough skill and luck\n\n" +
                    "So what password would you like? ");
                    this.comp.term.readLine("*");
                } else if(this.password == nop) {
                    this.password = this.comp.term.data;
                    this.comp.term.write("\n\nConfirm Password: ");
                    this.comp.term.readLine("*");
                } else if(this.password2 == nop) {
                    this.password2 = this.comp.term.data;
                    this.comp.term.write("\n\nConnecting...\n");
                    this.reg();
                    this.waiting=false;
                }
            }
        },
        reg: function(){
            $.ajax("http://ld.ubersoftech.com/api/reg.php?username="+this.username+"&password="+this.password+"&pa="+this.password2, {
                context:this,
                success: function(data) {
                    this.comp.term.write(data);
                    if(data.substr(0,4)==="NOPE"){
                        this.comp.term.clear();
                        this.comp.crp=new progRegister(this.comp);
                    } else {
                        this.comp.crp=new progStartMenu(this.comp);
                    }
                },
                error: function() {
                    this.comp.term.write("Comm Error trying again...\n");
                    this.reg()
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
/**
 * Created by Ariel Lothlorien on 12/7/14.
 */

nop = "nope";

var progLogin = function(computer){
    //Set Stuff Up Vars and functions. (the "this" Scope)
    var object = {
        comp: nop,
        running: true,
        username: nop,
        password: nop,
        ip: nop,
        waiting: true,

        create:function(){
            this.comp.term.write("\nLogin: ");
            this.comp.term.readLine();
        },

        tick: function(){
            //this.running = false;
            if(this.waiting && !this.comp.term.readingInput) {
                if(this.username == nop) {
                    this.username = this.comp.term.data;
                    this.comp.term.write("\nPass: ");
                    this.comp.term.readLine("*");
                } else if(this.password == nop) {
                    this.password = this.comp.term.data;
                    this.comp.term.write("\n\nConnecting...\n");
                    this.login();
                    this.waiting=false;
                }
            }
        },
        login: function(){
            $.ajax("http://ld.ubersoftech.com/api/login.php?u="+this.username+"&p="+this.password, {
                context:this,
                success: function(data) {
                    this.comp.term.write(data);
                    if(data.substr(0,4)==="NOPE"){
                        this.comp.crp=new progLogin(this.comp);
                    } else {
                        this.comp.term.write("\n");
                        this.running = false;
                    }
                },
                error: function() {
                    this.comp.term.write("Comm Error trying again...\n");
                    this.login();
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
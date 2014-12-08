<?PHP
include_once("./core/init.php");
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>JackIn Jam</title>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script type="text/javascript" src="js/phaser.js"></script>
    <script type="text/javascript" src="js/game/DisplayAdapter.js"></script>
    <script type="text/javascript" src="js/game/TerminalDrivers/TermTypeout.js"></script>
    <script type="text/javascript" src="js/game/TerminalDriver.js"></script>
    <script type="text/javascript" src="js/game/Programs/progBoot.js"></script>
    <script type="text/javascript" src="js/game/Programs/progLogin.js"></script>
    <script type="text/javascript" src="js/game/Programs/progRegister.js"></script>
    <script type="text/javascript" src="js/game/Programs/progCMD.js"></script>
    <script type="text/javascript" src="js/game/Programs/progHack.js"></script>
    <script type="text/javascript" src="js/game/Programs/progStartMenu.js"></script>
    <script type="text/javascript" src="js/game/Computer.js"></script>
    <style type="text/css">
        body {
            margin: 0;
        }
    </style>
</head>
<body>

<script type="text/javascript">

    var game = new Phaser.Game(800, 600, Phaser.AUTO, '', { preload: preload, create: create, update: update });
    var comp;

    var ScreenArea = {w:650, h:315}
    var DefaultConsoleSettings = {Size:14, w:79, h:23}
    var BigConsoleSettings = {Size:27, w:49, h:11}

    function preload() {
        //game.stage.scaleMode = Phaser.StageScaleMode.SHOW_ALL; //resize your window to see the stage resize too
        //game.stage.scale.setShowAll();
        //game.stage.scale.refresh();
        game.load.image('GameMask', 'assets/GameAreaMid.png');
        game.load.image('MonitorCover', 'assets/GameAreaTop.png');
        //game.load.audio('sfx', 'assets/sounds/140773__qubodup__computer-beep-sfx-for-videogames.wav');
    }

    var text;
    var cursors;

    var keySpace, keyPlus, keyMinus;

    //var fx;

    var crp; //Currently Running Program

    function boop(){
        //fx.play();
    }

    function create() {
        //text = this.game.add.text(60, 165, "00:╒════╗\n01:│▲►▼◄║\n02:╘════╝\n03:********\n04:* ▲►▼◄ *\n05:********\n06:\n07:\n08:\n09:\n10:\n11:\n12:\n13:\n14:\n15:\n16:\n17:\n18:\n19:\n20:\n21:\n22:\n23:\n24:\n25:", { font: DefaultConsoleSettings.Size+"px ‘Lucida Console’, Monaco,monospace", fill: "#00BB1C", align: "left"} );
        //this.display = new DisplayAdapter(game);
        //this.term = new TerminalDriver(this.display);

        //this.display.set("00:╒════╗\n01:│▲►▼◄║\n02:╘════╝\n03:********\n04:* ▲►▼◄ *\n05:********\n06:\n07:\n08:\n09:\n10:\n11:\n12:\n13:\n14:\n15:\n16:\n17:\n18:\n19:\n20:\n21:\n22:\n23:\n24:\n25:", [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,2,3,4,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0], 0, 0);

        this.comp = new Computer(this.game);
        this.game.add.sprite(0, 0, 'GameMask');
        this.game.add.sprite(0, 0, 'MonitorCover');

        //cursors = game.input.keyboard.createCursorKeys();
        this.game.input.keyboard.addCallbacks(this, inputRAW, null, wtfinput);


        //this.keySpace = game.input.keyboard.addKey(Phaser.Keyboard.SPACEBAR);
        //this.keyBackspace = game.input.keyboard.addKey(Phaser.Keyboard.BACKSPACE);
        game.input.keyboard.addKeyCapture([Phaser.Keyboard.BACKSPACE,Phaser.Keyboard.SPACEBAR,Phaser.Keyboard.ENTER]);
        this.keyPlus = game.input.keyboard.addKey(Phaser.Keyboard.NUMPAD_ADD);
        this.keyMinus = game.input.keyboard.addKey(Phaser.Keyboard.NUMPAD_SUBTRACT);

        //fx = game.add.audio('sfx');
    }

    var lastMove= "zomgwtf", movetime = 1;

    var first =true;

    function inputRAW(event){
        if(event.keyCode == Phaser.Keyboard.BACKSPACE) {
            this.comp.input("\b");
        }
        if(event.keyCode == Phaser.Keyboard.ENTER) {
            this.comp.input("\r");
        }
    }

    function wtfinput(char){
        this.comp.input(char);
    }

    function update() {
        if(first){
            first=false;
            //fx.play();
        }
        if(lastMove=="zomgwtf") lastMove=game.time.now;

        this.comp.tick();
        /*
        //  For example this checks if the up or down keys are pressed and moves the camera accordingly.
        if (cursors.up.isDown && game.time.elapsedSecondsSince(lastMove)>movetime)
        {
            if (cursors.down.shiftKey) text.fontSize += 1;
            else text.y -=5
            lastMove= game.time.now;
        }
        if (cursors.down.isDown && game.time.elapsedSecondsSince(lastMove)>movetime)
        {
            if (cursors.down.shiftKey) text.fontSize -= 1;
            else text.y +=5
            lastMove= game.time.now;
        }

        if (cursors.left.isDown && game.time.elapsedSecondsSince(lastMove)>movetime)
        {
            text.x -= 5;
            lastMove= game.time.now;
        }
        else if (cursors.right.isDown && game.time.elapsedSecondsSince(lastMove)>movetime)
        {
            text.x += 5;
            lastMove= game.time.now;
        }
        */

        if(this.keyPlus.isDown) {
            text.fontSize=BigConsoleSettings.Size;
        }else if(this.keyMinus.isDown){
            text.fontSize=DefaultConsoleSettings.Size;
        }
        /*
        if(this.keySpace.isDown) {
            var temp = "";
            for(var y= 0; y<DefaultConsoleSettings.h; y++){
                temp+=y+":";
                for(var x = 0; x-3< DefaultConsoleSettings.w; x++){
                    temp += "*";
                }
                temp+="\n";
            }
            text.setText(temp);
        }
        else text.setText("00:╒════╗1234567890-qwertyuiop@asdfghjkl;:zxcvbnm,./.,mnbvcxz]:;lkjhgfdsa[@poiuytrewq^-0987654321\n01:│▲►▼◄║\n02:╘════╝\n03:********\n04:* ▲►▼◄ *\n05:********\n06: X:"+text.x+" F:"+text.fontSize+"\n07:\n08:\n09:\n10:\n11:\n12:\n13:\n14:\n15:\n16:\n17:\n18:\n19:\n20:\n21:\n22:\n23:\n24:\n25:");
        */
    }

</script>

</body>
</html>
<ul class="rslides">
    <?php
    $dir = "pictures/";// az adott mappának az értékeit adja meg
    $files = scandir($dir);//Scandir rendezesi opcio ami alapjan rendezi a fajlokat pl most  kepmeghivas
    $allowed = array("png","jpg");//array szukseges mert atraktuk mert atraktuk egz masik valtozoba az ertekeket
    for($i = 0; $i < count($files); $i++)//ertek egyello 0,ertek kisebb a megszamolt fajloknal, novelje eggyel
    {
        $name = explode (".",$files[$i]);//kiirja azt amit kidob a
        if($files[$i] != ".." && $files[$i] != "." && in_array(end($name),$allowed) )
        {
            echo '<li><img src="'.$dir.$files[$i].'" alt="méz '.$i.'"/></li>';
        }
    }
    ?>
</ul>
<script type="text/javascript">
    $(".rslides").responsiveSlides({
        auto: true,             // Boolean: Animate automatically, true or false
        speed: 0.1,            // Integer: Speed of the transition, in milliseconds
        timeout: 10000,          // Integer: Time between slide transitions, in milliseconds
        pager: false,           // Boolean: Show pager, true or false
        nav: false,             // Boolean: Show navigation, true or false
        random: false,          // Boolean: Randomize the order of the slides, true or false
        pause: true,           // Boolean: Pause on hover, true or false
        pauseControls: true,    // Boolean: Pause when hovering controls, true or false
        prevText: "Previous",   // String: Text for the "previous" button
        nextText: "Next",       // String: Text for the "next" button
        maxwidth: "",           // Integer: Max-width of the slideshow, in pixels
        navContainer: "",       // Selector: Where controls should be appended to, default is after the 'ul'
        manualControls: "",     // Selector: Declare custom pager navigation
        namespace: "rslides",   // String: Change the default namespace used
        before: function(){},   // Function: Before callback
        after: function(){}     // Function: After callback
    });
</script>
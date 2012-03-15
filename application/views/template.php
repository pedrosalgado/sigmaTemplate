<!DOCTYPE html>
<html lang="en">
    <head>
        <?= $header ?>
    </head>
    <body>
        <div class="background back"></div>
        <div class="background front"></div>
        <div id="wrapper">
            <div id="header">
                <?= $top ?>
            </div>

            <div id="container">
                <div class="sidebar">
                    <?= $sidebar ?>
                </div>	
                <div class="content">
                    <?= $content ?>
                </div>
                <br style="clear:both"/>
            </div>
            <?= $footer ?>
        </div>
    </body>
</html>
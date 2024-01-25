<!DOCTYPE html>
<html>
    <head>
    <?php include_once __DIR__ . "/components/common/head.php" ?>
    </head>
    <body class="calendar">
    <?php include_once __DIR__ . "/components/common/header.php" ?>
        <main class="Calendar">
        <?php for($i = 0; $i < 63;$i++) { ?>
            <div class="Day <?php if($i % 7 == 0) echo "start" ?>">
                <div class="Header">
                    <button>01/01</button>
                </div>
                <div class="Body">

                </div>
            </div>
        <?php } ?>
        </main>
    </body>
</html>
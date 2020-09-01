<!-- item -->
<?php
// error_reporting(-1);
// ini_set('display_errors', true); 
try {
    require_once "../../oop/controller/Dependency.php";
    Dependency::requireControllerDependencies("../../");

?>
    <html lang="en">

    <head>
        <title>Document</title>
        <meta name="description" content="">
        <?php
        $controller = new Controller(651853948);
        echo $controller->getHeadDatas();
        echo $controller->getGeneralFiles();
        ?>
        <script src="outside/js/item.js"></script>
        <link rel="stylesheet" href="outside/css/item.css">
    </head>

    <body>
        <header>
            <?php
            echo $controller->getComputerHeader();
            echo $controller->getMobileHeader();
            echo $controller->getConstants();
            ?>
        </header>

        <div class="item_page-container">
            <div id="ctr_item_content">
            <?php
            echo $controller->getItemPage();
        } catch (\Throwable $th) {
            echo $th;
        }

            ?>

            </div>
        </div>





    </body>

    </html>
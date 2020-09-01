<?php //error_reporting(-1); ?>
<?php //ini_set('display_errors', true); ?>
<!-- grid -->
<?php

require_once "../../oop/controller/Dependency.php";
Dependency::requireControllerDependencies("../../");

?>
<html lang="en">

<head>
    <title>Document</title>
    <meta name="description" content="">
    <?php
    $controller = new Controller();
    echo $controller->getHeadDatas();
    echo $controller->getGeneralFiles();
    ?>
    <script src="outside/js/grid.js"></script>
    <link rel="stylesheet" href="outside/css/grid.css">
</head>

<body>
    <header>
        <?php
        echo $controller->getComputerHeader();
        echo $controller->getMobileHeader();
        echo $controller->getConstants();
        ?>
    </header>

    <div class="grid-container">
        <div id="ctr_grid_content">
            <?php 
            try {
                echo $controller->getGridPage(); 
            } catch (\Throwable $th) {
                echo $th;
            }
            
            ?>
        </div>
    </div>

</body>

</html>
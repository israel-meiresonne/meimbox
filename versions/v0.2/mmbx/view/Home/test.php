<?php
// $this->head = $cssFile;
        $datasEmail = [
            "cssFile" => $cssFile,
        ];
echo $this->generateFile('view/EmailTemplates/orderConfirmation.php', $datasEmail);

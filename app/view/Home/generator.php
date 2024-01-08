<?php

/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param string $btnLink   link to place in the button link
 */

$messageDatas = [
    "title" => null,
    "content" => ucfirst("clic bellow"),
    "btnText" => "new profile",
    "btnLink" => $btnLink,
    "linkAttr" => 'target="_blank"'
];
echo $this->generatefile('view/Template/files/message.php', $messageDatas);
/*————————————————————————————— Config View DOWN ————————————————————————————*/
$headDatas = [
    "tags" => [
        self::META_BOT_NO_INDEX,
        '<link rel="stylesheet" href="' . self::$PATH_CSS . 'er.css">',
        '<script> const jx = () => {}; </script>'
    ]
];
$this->head = $this->generatefile('view/Template/files/head.php', $headDatas);
$this->header = 'emptyHeader.php';
/*————————————————————————————— Config View UP ——————————————————————————————*/
?>
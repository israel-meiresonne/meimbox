<?php

/**
 * @param string $btnLink           link to place in the button link
 */
/**
 * @var Translator */
$translator = $this->translator;
$messageDatas = [
    "title" => $translator->translateStation("US108"),
    "content" => ucfirst($translator->translateStation("US109"))."<br><br>".ucfirst($translator->translateStation("US110")),
    "btnText" => $translator->translateStation("US111"),
    "btnLink" => $btnLink
];
echo $this->generatefile('view/Template/files/message.php', $messageDatas);
$headDatas = [
    "additionals" => [
        self::META_BOT_NO_INDEX,
        '<link rel="stylesheet" href="'.self::$PATH_CSS .'er.css">'
    ]
];
$this->head = $this->generatefile('view/Checkout/files/head.php', $headDatas);
// $this->header = "emptyHeader.php";
$this->title = "Success";

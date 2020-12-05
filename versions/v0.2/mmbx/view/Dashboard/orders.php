<?php

/**
 * @param string $btnLink           link to place in the button link
 */
/**
 * @var Translator */
$translator = $this->translator;
$title = $translator->translateStation("US113");
$content = 
ucfirst($translator->translateStation("US112"))
."<br><br>".
ucfirst($translator->translateStation("US114"))
."<br><br>".
ucfirst($translator->translateStation("US72"));
$messageDatas = [
    "title" => $title,
    "content" => $content,
    "btnText" => $translator->translateStation("US105"),
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
$this->title = ucwords($title);

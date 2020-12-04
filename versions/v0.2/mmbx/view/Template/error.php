<?php
/**
 * @param string $webRoot the the root the web site
 * @param string $content the content to display
 */
/**
 * @var Translator */
$translator = $this->translator;
$isoLang = $translator->getLanguage()->getIsoLang();
$webRoot = $webRoot;
$title = $this->title;
$head = $this->head;
?>
<!DOCTYPE html>
<html lang="<?= $isoLang ?>">

<head>
    <meta charset="UTF-8">
    <meta name="robots" content="noindex">
    <meta name="googlebot" content="noindex">
    <base href="<?= $webRoot ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <?= self::FONT_FAM_SPARTAN ?>
    <?= $head ?>
    <link rel="stylesheet" href="<?= self::$PATH_CSS ?>root.css">
    <link rel="stylesheet" href="<?= self::$PATH_CSS ?>elements.css">
    <link rel="stylesheet" href="<?= self::$PATH_CSS ?>er.css">
</head>

<body>
    <div class="template-content">
        <?= $content ?>
    </div>
</body>

</html>
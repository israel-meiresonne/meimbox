<?php
/**
 * @param string $webRoot the the root the web site
 * @param string $content the content to display
 */
/**
 * @var Translator */
// $translator = $this->translator;
$translator = $this->getTranslator();
$isoLang = $translator->getLanguage()->getIsoLang();
$webRoot = $webRoot;
$title = $this->title;
$head = $this->head;
?>
<!DOCTYPE html>
<html lang="<?= $isoLang ?>">
<head>
    <meta charset="UTF-8">
    <base href="<?= $webRoot ?>">
    <title><?= $title ?></title>
    <?= self::META_BOT_NO_INDEX ?>
    <?= self::META_DEVICE ?>
    <?= self::STYLE_W3SCHOOL ?>
    <?= self::FONT_FAM_SPARTAN ?>
    <link rel="icon" type="image/png" href="<?= self::$DIR_STATIC_FILES ?>favicon-meimbox.png">
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
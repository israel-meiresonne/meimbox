<?php

/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param string[] $styles path to css files
 * @param string $html configured html content
 */
array_push(
    $styles,
    self::$PATH_CSS . "root.css",
    self::$PATH_CSS . "elements.css"
);
$css = "";
foreach ($styles as $file) {
    $content = $this->generateFile($file, []);
    $css .= $this->replaceCssVar($content);
    $css .= "\n";
}

$email = $this->htmlToEmail($html, $css);
echo $email;

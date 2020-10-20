<?php

/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param string[] $styles dirs to cess files
 * @param string $html confugured html content
 */
array_push(
    $styles,
    self::CSS_ROOT,
    self::CSS_ELEMENTS
);
$css = "";
foreach ($styles as $file) {
    $content = $this->generateFile($file, []);
    $css .= $this->replaceCssVar($content);
    $css .= "\n";
}

$email = $this->htmlToEmail($html, $css);
echo $email;

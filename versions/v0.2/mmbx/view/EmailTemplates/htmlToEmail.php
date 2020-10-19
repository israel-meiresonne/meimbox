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
//  if(!empty($styles)){
foreach ($styles as $file) {
    $content = $this->generateFile($file, []);
    $css .= $this->replaceCssVar($content);
    $css .= "\n";
}
//  }
// $css .= $this->generateFile(self::CSS_ROOT, []);
// $css .= "\n";
// $css .= $this->generateFile(self::CSS_ELEMENTS, []);

$email = $this->htmlToEmail($html, $css);
echo $email;

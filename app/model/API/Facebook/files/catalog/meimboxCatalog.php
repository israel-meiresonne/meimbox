<?php

/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param string                        $url_DomainWebroot  url like https://domain.dom/web/root/
 * @param string                        $url_file           domain's url i.e: https://domain.dom/my/file
 * @param Box[]                         $boxSamples         samples of each box ordable
 * @param BasketProduct[]|BoxProduct[]  $products           products of the catalog
 * @param Map                           $company            datas about company
 * @param Language                      $language           language for the product
 * @param Country                       $country            country where to sell the product
 * @param Currency                      $currency           currency of the product
 */
echo '<?xml version="1.0" encoding="utf-8"?>';
?>
<rss version="2.0" xmlns:g="http://base.google.com/ns/1.0" xmlns:atom="http://www.w3.org/2005/Atom">
    <channel>
        <title>FB-CAT</title>
        <description>Product Feed for Facebook</description>
        <link><?= $url_DomainWebroot ?></link>
        <atom:link href="<?= $url_file ?>" rel="self" type="application/rss+xml" />
        <?php
        foreach ($products as $product) {
            $datas = [
                "url_DomainWebroot" => $url_DomainWebroot,
                "product" => $product,
                "company" => $company,
                "language" => $language,
                "country" => $country,
                "currency" => $currency
            ];
            echo self::generateFile('model/API/Facebook/files/catalog/files/catalogItem.php', $datas);
        }
        ?>

    </channel>
</rss>
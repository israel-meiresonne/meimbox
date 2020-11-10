<?php

/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param string    $domainUrl  domain's url i.e: https://domain.dom
 * @param string    $fileUrl    domain's url i.e: https://domain.dom/my/file
 * @param Product   $products   products of the catalog
 */
?>
<?xml version="1.0" encoding="utf-8"?>
<rss version="2.0" xmlns:g="http://base.google.com/ns/1.0" xmlns:atom="http://www.w3.org/2005/Atom">
    <channel>
        <title>FB-CAT</title>
        <description>Product Feed for Facebook</description>
        <!-- <link>https://www.iandmeim.com</link> -->
        <link><?= $domainUrl ?></link>
        <!-- <atom:link href="https://www.iandmeim.com/plnned.php/print-fb-catalog.php" rel="self" type="application/rss+xml" /> -->
        <atom:link href="<?= $fileUrl ?>" rel="self" type="application/rss+xml" />
        <?php
        foreach($products as $product){
            
        }
        ?>

    </channel>
</rss>
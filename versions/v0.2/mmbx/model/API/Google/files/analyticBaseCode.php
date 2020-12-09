<?php
/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param string $tagID Google's measure ID
 */
?>
<script async src="https://www.googletagmanager.com/gtag/js?id=<?= $tagID ?>"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', '<?= $tagID ?>');
</script>
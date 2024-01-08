<?php
/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param string $tagID Google's measure ID
 * @param string $debug set true to activate debug mode else false
 */
?>
<script async src="https://www.googletagmanager.com/gtag/js?id=<?= $tagID ?>"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', '<?= $tagID ?>'<?= ($debug)? ",{'debug_mode':true}" : null?>);
</script>
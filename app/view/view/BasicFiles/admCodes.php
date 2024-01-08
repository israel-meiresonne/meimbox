<?php

/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param bool $isAdm set true if Visitor is a Administrator account else false
 */
?>
<script id='adm' type='text/javascript'>
    const ADM = 1 == <?= (int) $isAdm ?>;
</script>
<?php

/**
 * ——————————————————————————————— NEED —————————————————————————————————————
 * @param string[] $tags additional tags to add in template's head
 */
if(!empty($tags)){
    foreach($tags as $tag){
        echo $tag;
    }
}

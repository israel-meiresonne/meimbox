    <?php
    // require_once 'model/special/Map.php';
    /**
     * ——————————————————————————————— NEED —————————————————————————————————————
     * @param string|null $inpId input's id
     * @param string $inpType input's type
     * @param string $inpName input's name
     * @param string $inpTxt input's displayed message and placeholder
     * @param string $errortype View::ER_TYPE_[...]
     */
    $inpTypes = new Map();
    $inpTypes->put("color", Map::color);
    $inpTypes->put("date", Map::date);
    $inpTypes->put("email", Map::email);
    $inpTypes->put("file", Map::file);
    $inpTypes->put("image", Map::image);
    $inpTypes->put("month", Map::month);
    $inpTypes->put("number", Map::number);
    $inpTypes->put("password", Map::password);
    $inpTypes->put("range", Map::range);
    $inpTypes->put("reset", Map::reset);
    $inpTypes->put("search", Map::search);
    $inpTypes->put("submit", Map::submit);
    $inpTypes->put("tel", Map::tel);
    $inpTypes->put("text", Map::text);
    $inpTypes->put("time", Map::time);
    $inpTypes->put("url", Map::url);
    $inpTypes->put("week", Map::week);
    if(empty($inpTypes->get($inpType))){
        throw new Exception("The input's type can't be empty");
    } else {
        $Taginptype = 'type="' . $inpTypes->get($inpType) . '"';
    }
    
    if(!empty($inpId)){
        $TagInpId ='id="' . $inpId . '"';
        $TagLabelFor ='for="' . $inpId . '"';
    } else {
        $TagInpId = null;
        $TagLabelFor =null;
    }

    $errorid = ModelFunctionality::generateDateCode(25);
    $errorx = "#$errorid";
    ?>
    <div class="input-wrap">
        <label class="input-label" <?= $TagLabelFor ?> ><?= $inpTxt ?></label>
        <input <?= $TagInpId ?> class="input-tag" <?= $Taginptype ?> name="<?= $inpName ?>" placeholder="<?= $inpTxt ?>" data-errorx="<?= $errorx ?>" data-errortype="<?= $errortype?>">
        <p id="<?= $errorid ?>" class="comment"></p>
    </div>
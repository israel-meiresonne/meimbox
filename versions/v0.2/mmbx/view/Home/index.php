<?php
$this->title = "home";
$this->lang = "fr";
$this->description = "home page";
$this->head = "<!-- <script src='" . self::$PATH_JS . "qr.js'></script> -->";
echo $this->translator->translateStation("US1");
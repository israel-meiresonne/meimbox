<?php

class Controller
{
    /**
     * Holds the model interface
     * @var Model $model model interface
     */
    private $model;

    /**
     * @var ViewInterface
     */
    private $view;

    function __construct()
    {
        date_default_timezone_set('Europe/Paris');
        $this->model = new Facade();

        $dbMap = $this->model->getDbMap();
        $language = $this->model->getLanguage();
        $this->view = new View($language, $dbMap);
    }

    //————————————————————————————————————————————— MODEL METHODS DOWN —————————————————————————————————————————————
    /**
     * Getter of the database's map
     * @return string[string[...]] $dbMap The database tables in mapped format 
     * specified in file oop/model/special/dbMap.txt
     */
    public function getDbMap()
    {
        return $this->model->getDbMap();
    }

    /**
     * Add a new measure to Visitor if input are correct
     * @return Response contain results or Myerrrors
     */
    public function addMeasure()
    {
        $response = $this->model->addMeasure();
        $response = $this->view->getMeasureManagerContent($response);
        return $response;
    }

    /**
     * Delete from database and Visitor the Visitor's measure with the measure id posted($_POST)
     * @return Response contain results or Myerrrors
     */
    public function deleteMeasure()
    {
        $response = $this->model->deleteMeasure();
        $response = $this->view->getMeasureManagerElements($response);
        return $response;
    }

    /**
     * Update on database and Visitor the Visitor's measure with the measure id posted($_POST)
     * @return Response contain results or Myerrrors
     */
    public function updateMeasure()
    {
        $response = $this->model->updateMeasure();
        $response = $this->view->getMeasureManagerContent($response);
        return $response;
    }

    //————————————————————————————————————————————— MODEL METHODS DOUPWN ———————————————————————————————————————————
    //————————————————————————————————————————————— VIEW METHODS DOWN ——————————————————————————————————————————————
    /**
     * To get head's datas (meta-data, link and script tags) shared by all the 
     * web pages
     * @return string meta-data, link and script tags
     */
    public function getHeadDatas()
    {
        return $this->view->getHeadDatas();
    }

    /**
     * To get files used in all web page (css link and script tags)
     * @return string css link and script tags
     */
    public function getGeneralFiles()
    {
        return $this->view->getGeneralFiles();
    }

    /**
     * To get constants needed in js code. NOTE: each constant is named 
     * following their class name and their value name (ex: VARNAME_CLASSNAME)
     * @return string constants needed in js code.
     */
    public function getConstants()
    {
        return $this->view->getConstants();
    }

    /**
     * To get the navigation bar of computer screen
     * @return string the html navbar tag of computer screen
     */
    public function getComputerHeader()
    {
        return $this->view->getComputerHeader();
    }

    /**
     * To get the navigation bar of mobile screen
     * @return string the html navbar tag of mobile screen
     */
    public function getMobileHeader()
    {
        return $this->view->getMobileHeader();
    }

    /**
     * To get the content of the grid page following the URL params
     * @return string grid page following the URL params in a displayable 
     * format
     */
    public function getGridPage()
    {
        $search = $this->model->getGETSearch($this->model->getDbMap());
        return $this->view->getGridPage($search, $this->model);
    }

    /**
     * This method handle Visitor's filter request and provid an array cantaining 
     * the stickers list and the grid products in a HTML displayable format
     * @return Response grid page and its stickers following the Search criteriion
     */
    public function getFilterPOSTSearch()
    {
        $search = $this->model->getPOSTSearch();
        $response = $this->view->getFilterPOSTSearch($search, $this->model);
        return $response;
    }

    /**
     * To get the content of the item page following the URL params
     * @return string item page following the URL params in a displayable 
     * format
     */
    public function getItemPage()
    {
        $search = $this->model->getGETSearch();
        $a =  $this->view->getItemPage($search, $this->model);
        // var_dump(memory_get_usage()/(1024**2));
        return $a;
    }

    /**
     * To get selected brand's html sticker
     * @param Model $model model interface
     * @return Response contain sticker or a MyError
     */
    public function getBrandSticker()
    {
        $response = $this->view->getBrandSticker($this->model);
        return $response;
    }

    /**
     * To get selected measure's html sticker
     * @param Model $model model interface
     * @return Response contain sticker or a MyError
     */
    public function getMeasureSticker()
    {
        $response = $this->view->getMeasureSticker($this->model);
        return $response;
    }

    /**
     * To get the content of Measure adder pop-up with the measure id posted($_POST)
     * @return Response contain results or Myerrrors
     */
    public function getMeasureAdderContent()
    {
        $response = $this->model->getMeasurePOST();
        $dbMap = $this->model->getDbMap();
        $response = $this->view->getMeasureAdderContent($response, $dbMap);
        return $response;
    }
    
    /**
     * To get the content of Measure adder pop-up with the measure id posted($_POST)
     * @return Response contain results or Myerrrors
     */
    public function getMeasureAdderContentEmpty()
    {
        // $response = $this->model->getMeasurePOST();
        $dbMap = $this->model->getDbMap();
        $response = $this->view->getMeasureAdderContent(new Response(), $dbMap);
        return $response;
    }
    //————————————————————————————————————————————— VIEW METHODS UP ————————————————————————————————————————————————

    public function __toString()
    {
        $this->model->__toString();
    }
}

<?php

interface ViewInterface
{
    /**
     * To get head's datas (meta-data, css link and script tags) shared by all the 
     * web pages
     * @return string meta-data, link and script tags
     */
    public function getHeadDatas();

    /**
     * To get files used in all web page (css link and script tags)
     * @return string css link and script tags
     */
    public function getGeneralFiles();

    /**
     * To get constants needed in js code. NOTE: each constant is named 
     * following their class name and their value name (ex: VARNAME_CLASSNAME)
     * @return string constants needed in js code.
     */
    public function getConstants();

    /**
     * To get the navigation bar of computer screen
     * @return string the html navbar tag of computer screen
     */
    public function getComputerHeader();

    /**
     * To get the navigation bar of mobile screen
     * @return string the html navbar tag of mobile screen
     */
    public function getMobileHeader();

    /**
     * To get the content of the grid page following the URL params
     * @param Search $search the search that content all the criterion of the search, 
     * its Products result and a map where is ordered each product by criterion
     * @param Model $model model interface
     * @return string grid page following the search criteriion
     */
    public function getGridPage($search, $model);

    /**
     * To make sticker with search's criterions into HTML displayable format
     * @param Search $search the search that content all the criterion of the 
     * search, its Products result and a map where is ordered each product by 
     * criterion
     * @param Model $model model interface
     * @return Response grid page and its stickers following the Search criteriion
     */
    public function getFilterPOSTSearch($search, $model);

    /**
     * To get the content of the item page following the URL params
     * @param Search $search the search that content all the criterion of the search, 
     * its Products result and a map where is ordered each product by criterion
     * @param Model $model model interface
     * @return string grid page following the search criteriion
     */
    public function getItemPage($search, $model);

    /**
     * To get selected brand's html sticker
     * @param Model $model model interface
     * @return Response contain sticker or a MyError
     */
    public function getBrandSticker($model);

    /**
     * To get selected measure's html sticker
     * @param Model $model model interface
     * @return Response contain sticker or a MyError
     */
    public function getMeasureSticker($model);

    /**
     * To get measure manager's content
     * @param Response $response contain Visitor's measures
     * @return Response contain measure manager's content or a MyError
     */
    public function getMeasureManagerContent($response);
  
    /**
     * To get elements inside Measure Manager
     * @param Response $response contain Visitor's measures
     * @return Response contain measure manager's content or a MyError
     */
    public function getMeasureManagerElements($response);

    /**
     * To get measure adder's content
     * @param Response $response contain Visitor's measures
     * @param string[string[...]] $dbMap The database tables in mapped format specified in file 
     * oop/model/special/dbMap.txt
     * @return Response contain measure manager's content or a MyError
     */
    public function getMeasureAdderContent($response, $dbMap);
}

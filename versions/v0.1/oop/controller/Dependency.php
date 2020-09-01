<?php

class Dependency
{
    public static function requireControllerDependencies($dir)
    {
        // controller dependencies
        require_once $dir . "oop/controller/ctr.php";
        require_once $dir . "oop/model/Model.php";
        require_once $dir . "oop/view/ViewInterface.php";
        require_once $dir . "oop/view/View.php";

        // view-manager package
        require_once $dir . "oop/model/view-management/Translator.php";
        require_once $dir . "oop/model/view-management/PageContent.php";
        
        // speciale package
        require_once $dir . "oop/model/special/Helper.php";
        require_once $dir . "oop/model/special/GeneralCode.php";
        require_once $dir . "oop/model/special/Search.php";
        require_once $dir . "oop/model/special/Response.php";
        require_once $dir . "oop/model/special/Query.php";
        require_once $dir . "oop/model/special/MyError.php";

        // users-manager package
        require_once $dir . "oop/model/users-management/Facade.php";
        require_once $dir . "oop/model/users-management/Action.php";
        require_once $dir . "oop/model/users-management/Address.php";
        require_once $dir . "oop/model/users-management/Visitor.php";
        require_once $dir . "oop/model/users-management/User.php";
        require_once $dir . "oop/model/users-management/Administrator.php";
        require_once $dir . "oop/model/users-management/Client.php";
        require_once $dir . "oop/model/users-management/Country.php";
        require_once $dir . "oop/model/users-management/Currency.php";
        require_once $dir . "oop/model/users-management/Database_Connection.php";
        require_once $dir . "oop/model/users-management/Database.php";
        require_once $dir . "oop/model/users-management/Device.php";
        require_once $dir . "oop/model/users-management/Language.php";
        require_once $dir . "oop/model/users-management/Location.php";
        require_once $dir . "oop/model/users-management/Navigation.php";
        require_once $dir . "oop/model/users-management/Page.php";
        require_once $dir . "oop/model/users-management/Parameter.php";
        require_once $dir . "oop/model/users-management/Measure.php";
        require_once $dir . "oop/model/users-management/MeasureUnit.php";

        // boxes-manager package
        require_once $dir . "oop/model/boxes-management/Basket.php";
        require_once $dir . "oop/model/boxes-management/Box.php";
        require_once $dir . "oop/model/boxes-management/Product.php";
        require_once $dir . "oop/model/boxes-management/BasketProduct.php";
        require_once $dir . "oop/model/boxes-management/BoxProduct.php";
        require_once $dir . "oop/model/boxes-management/DiscountCode.php";
        require_once $dir . "oop/model/boxes-management/Discount.php";
        require_once $dir . "oop/model/boxes-management/Price.php";
        require_once $dir . "oop/model/boxes-management/Shipping.php";
        require_once $dir . "oop/model/boxes-management/Size.php";
    }
}

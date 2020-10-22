<?php
require_once 'ControllerSecure.php';

class ControllerWebhook extends ControllerSecure
{
    /**
     * Holds actions function
     */
    public const ACTION_STRIPEWEBHOOK = "stripeWebhook";

    public function index()
    {
    }

    /**
     * To handle Stripe's events
     */
    public function stripeWebhook()
    {
        $response = new Response();
        /**
         * @var User */
        $person = $this->person;
        $event =  $person->handleStripeEvents($response);
        switch ($event) {
            case StripeAPI::EVENT_CHECKOUT_COMPLETED:
                $firstname = $person->getFirstname();
                $lastname = $person->getLastname();
                $toName = ($firstname . " " . $lastname);
                $toEmail = $person->getEmail();
                $templateFile = 'view/EmailTemplates/orderConfirmation/orderConfirmation.php';
                // $company = $person->getCompanyInfos();
                $company = new Map(Configuration::getFromJson(Configuration::JSON_KEY_COMPANY));

                /**
                 * @var Order */
                $order = $person->getLastOrder();
                $datasViewMap = new Map();
                $datasViewMap->put($toName, Map::name);
                $datasViewMap->put($toEmail, Map::email);
                $datasViewMap->put($templateFile, Map::templateFile);
                $datasViewMap->put($company, Map::company);
                $datasViewMap->put($firstname, Map::firstname);
                $datasViewMap->put($lastname, Map::lastname);
                $datasViewMap->put($order, Map::order);
                try {
                    $this->sendEmail($response, $person, BlueAPI::class, BlueAPI::FUNC_ORDER_CONFIRM, $datasViewMap);
                    $order->getBasketOrdered()->empty($response);        //🔋enable
                } catch (\Throwable $th) {
                    $response->addError($th->__toString(), MyError::ADMIN_ERROR);
                }
                break;
        }
        (!$response->containError()) ? $response->addResult(self::ACTION_STRIPEWEBHOOK, true) : null;
        $this->generateJsonView([], $response, $person);
    }
}

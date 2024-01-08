<?php

/**
 * Restrict access to user holding access key as param or cookie
 */
class Access
{
    /**
     * @var string Path to config file
     */
    private const FILE_CONFIG = "./model/special/Access/access-conf.json";

    /**
     * Initialize user's access if he has an access key else expel him
     */
    public static function initialize()
    {
        $json = self::getJson(true);
        $cookieName = $json->cookies->access->name;
        $cookieValue = $json->cookies->access->value;
        $inviteParamValue = self::getElement($_GET, $cookieName);
        $inputCookieValue = self::getElement($_COOKIE, $cookieName);
        $hasInviteParam = $inviteParamValue == $cookieValue;
        $hasCookieAccess = $inputCookieValue == $cookieValue;
        if (false) {
            var_dump('inviteParamValue: ', $inviteParamValue);
            echo '<br>';
            var_dump('$hasInviteParam: ', $hasInviteParam);
            echo '<br>';
            var_dump('inputCookieValue: ', $inputCookieValue);
            echo '<br>';
            var_dump('$hasCookieAccess: ', $hasCookieAccess);
            echo '<br>';
            // var_dump('$xss: ', $_GET['xss']);
            var_dump('$xss: ', self::getElement($_GET, 'xss'));
            echo '<br>';
        }
        $httpStr = 'http://';
        if (!$hasCookieAccess && !$hasInviteParam) {
            header("Location: " . $httpStr . $json->cookies->access->redirect);
        } else if (!$hasCookieAccess) {
            $domain = self::getRootDomain($httpStr . $_SERVER['SERVER_NAME']);
            setcookie(
                $cookieName,
                $cookieValue,
                (time() + $json->cookies->access->period),
                $json->cookies->access->path,
                $domain,
                $json->cookies->access->secure > 0 ? true : false,
                $json->cookies->access->httponly > 0 ? true : false
            );
        }
    }

    private static function getJson(bool $toObject = false)
    {
        $jsonFile = self::FILE_CONFIG;
        if (!file_exists($jsonFile)) {
            throw new ErrorException("Can't find file " . $jsonFile);
        }
        $jsonStr = file_get_contents($jsonFile);
        $json = json_decode($jsonStr, !$toObject);
        return $json;
    }

    /**
     * To extract from url its root domain
     * * Support HTTP and HTTPS urls
     * Examples:
     * --------
     * ```
     * - http://www.example.com -> example.com
     * - https://www.example.com -> example.com
     * - http://mail.example.co.uk -> example.co.uk
     * - https://192.168.0.14:7443 -> 192.168.0.14
     * - https://israelmeiresonne.localhost:7443 -> localhost
     * ```
     * 
     * @param string The Url to get domain root from
     * @throws ErrorException If url don't start with 'http://' or ''https://''
     * @return string The root domain name of the given url
     */
    private static function getRootDomain(string $url): string
    {
        if (!preg_match('/^https?:\/\//i', $url)) {
            throw new ErrorException("Url must start with 'http://' or 'https://', instead url='" . $url . "'");
        }
        $pieces = parse_url($url);
        $host = isset($pieces['host']) ? $pieces['host'] : '';
        $regex1 = '/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i';
        $regex2 = '/(([\w\-]+\.)*(?P<domain>localhost))$/i';
        $domain = preg_match($regex1, $host, $matches1) ? $matches1['domain'] : null;
        $domain = is_null($domain) && preg_match($regex2, $host, $matches2) ? $matches2['domain'] : $domain;
        if (is_null($domain)) {
            $domain = $host;
        }
        return $domain;
    }

    /**
     * To get cleaned access to element of a dictionary
     * 
     * @var array Dictionary of element
     * @var array Key of the element to get
     */
    private static function getElement(array $elements, string $key)
    {
        $element = null;
        if (isset($elements[$key])) {
            $element = self::clean($elements[$key]);
        }
        return $element;
    }

    /** 
     * Clean data of all undesirable characters
     * @param string $data data to clean
     * @return string data cleaned
     */
    private static function clean($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        $data = strip_tags($data);
        $data = addslashes($data);
        // $data = html_entity_decode($data); // ❗️Don't Uncomment in production
        return $data;
    }
}

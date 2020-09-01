<?php

class Helper
{
    /**
     * Loop recursively a array to print key and value
     * If arrray contain array so this method recall himself
     * @param string $label is the name of the value
     * @param array|string if it an array this method recall 
     * himsel like printLabelValue($key, array[$key])
     */
    public static function printLabelValue($label, $value)
    {
        echo "<hr>";
        self::printLabelValueRec($label, $value);
        echo "<hr>";
    }

    private function printLabelValueRec($label, $value)
    {
        if ((gettype($value) == "array") && (count($value) > 0)) {
            foreach ($value as $key => $data) {
                echo $key . " => ";
                $indent .= ".   ";
                Helper::printLabelValueRec($key, $value[$key]);
            }
        } else {
            // switch (gettype($value)) {
            //     case "object":
            //         echo get_class($value) . " => ";
            //         $value->__toString();
            //         break;
            //     default:
            echo $label . "  ";
            var_dump($value);
            echo "<br>";
            // }
        }
    }
}

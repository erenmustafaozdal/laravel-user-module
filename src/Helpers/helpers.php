<?php
/*
|--------------------------------------------------------------------------
| ucfirst with turkish support
|--------------------------------------------------------------------------
*/
if( ! function_exists('ucfirst_tr'))
{
    /**
     * @param string $value
     * @param bool|true $lower_str_end
     * @param string $encoding
     * @return string
     */
    function ucfirst_tr($value, $lower_str_end = true, $encoding = 'UTF-8') {
        $values = explode(' ', $value);
        $values_len = count($values);

        $result = [];
        for ($i=0; $i<$values_len; $i++)
        {
            $first_letter = mb_strtoupper(mb_substr(str_replace(array('İ','i'),array('İ','İ'),$values[$i]), 0, 1, $encoding), $encoding);

            $value_end = "";
            if ($lower_str_end)
            {
                $value_end = mb_strtolower(mb_substr($values[$i], 1, mb_strlen($values[$i], $encoding), $encoding), $encoding);
            }
            else
            {
                $value_end = mb_substr($values[$i], 1, mb_strlen($values[$i], $encoding), $encoding);
            }

            array_push($result, $first_letter . $value_end);
        }

        return implode(' ', $result);
    }
}



/*
|--------------------------------------------------------------------------
| strtoupper with turkish support
|--------------------------------------------------------------------------
*/
if( ! function_exists('strtoupper_tr'))
{
    /**
     * @param string $value
     * @param bool|false $lower_str_end
     * @param string $encoding
     * @return mixed|string
     */
    function strtoupper_tr($value, $lower_str_end = false, $encoding = 'UTF-8') {
        return mb_strtoupper(str_replace(array('İ','i'),array('İ','İ'),$value), $encoding);
    }
}

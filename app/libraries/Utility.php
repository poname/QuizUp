<?php
namespace QUIZUP\Libraries;

class Utility {

    public static function isHomePage() {
        return false;
//        return Yii::app()->controller->id == 'site' && Yii::app()->controller->action->id == 'index';
    }

    public static function seoName($string) {
        //Unwanted:  {UPPERCASE} ; / ? : @ & = + $ , . ! ~ * ' ( )
        $string = strtolower($string);
        //Strip any unwanted characters
        $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
        //Clean multiple dashes or whitespaces
        $string = preg_replace("/[\s-]+/", " ", $string);
        //Convert whitespaces and underscore to dash
        $string = preg_replace("/[\s_]+/", "-", $string);
        return $string;
    }

    public static function uniqueUsername($string) {
        $string = strtolower($string);

        $emailValidator = new CEmailValidator();
        if ($emailValidator->validateValue($string)) {
            $string = substr($string, 0, strpos($string, '@'));
        }

        $string = preg_replace("/[^a-z0-9._]/", "", $string);
        $i = 1;
        $username = $string;
        while (User::model()->exists('username = :username', array(':username' => $username))) {
            $username = $string . $i;
        }
        return $username;
    }

    public static function hasFlash($type = 'error') {
        return Yii::app()->user->hasFlash($type);
    }

    public static function setFlash($message, $type = 'error') {
        $messages = (array) Yii::app()->user->getFlash($type);
        $messages[] = $message;
        Yii::app()->user->setFlash($type, $messages);
    }

    public static function getFlash($type = 'error') {
        $messages = Yii::app()->user->getFlash($type);
        return $messages;
    }

    public static function tableHead($link, $header, $options = array()) {
        $out = '';

        $page = (int) Yii::app()->request->getQuery('page');
        $page = $page > 0 ? $page : 1;
        $sort = Yii::app()->request->getQuery('sort');
        $sort = empty($sort) ? 'asc' : $sort;
        $order = Yii::app()->request->getQuery('order');

        foreach ($header as $field => $title) {
            $th_attrs = array();
            if (is_array($title)) {
                $th_attrs = isset($title[1]) ? $title[1] : array();
                $title = $title[0];
            }

            $params = array(
                'order' => $field,
                'sort' => ($sort == 'asc' ? 'desc' : 'asc')
            );

            if (isset($options['page']) && $options['page']) {
                $params['page'] = $page;
            }

            if (isset($options['query']) && is_array($options['query'])) {
                $params = array_merge($params, $options['query']);
            }
            $out .= '<th' . CHtml::renderAttributes($th_attrs) . '>';
            if (is_string($field)) {
                $out .= '<a href="' . Yii::app()->createUrl($link, $params) . '">';
            }
            $out .= $title;

            if (is_string($field)) {
                if ($order == $field) {
                    $out .= $sort == 'asc' ? ' <i class="icon-chevron-up"></i>' : ' <i class="icon-chevron-down"></i>';
                }
                $out .= '</a>';
            }
            $out .= '</th>';
        }

        return $out;
    }

    public static function beginsWith($str, $search) {
        if (substr($str, 0, strlen($search)) == $search) {
            return true;
        }

        return false;
    }

    public static function endsWith($str, $search) {
        $search = is_array($search) ? $search : array($search);

        foreach ($search as $v) {
            if (substr($str, -strlen($v)) == $v) {
                return true;
            }
        }

        return false;
    }

    public static function getUniqueString() {
        return bin2hex(openssl_random_pseudo_bytes(3));
    }

    public static function getUniqueId() {
        return hexdec(static::getUniqueString());
    }

    public static function getTagFromID($integer, $base = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ') {
        $length = strlen($base);
        $out = '';
        while ($integer > $length - 1) {
            $out = $base[(int) fmod($integer, $length)] . $out;
            $integer = (int) floor($integer / $length);
        }
        return $base[$integer] . $out;
    }

    public static function getIDFromTag($string, $base = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ') {
        $length = strlen($base);
        $size = strlen($string) - 1;
        $string = str_split($string);
        $out = strpos($base, array_pop($string));
        foreach ($string as $i => $char) {
            $out += strpos($base, $char) * pow($length, $size - $i);
        }
        return $out;
    }

    /**
     * @param string $color
     * @return array
     */
    public static function hex2dec($color) {
        $color = str_replace('#', '', $color);
        return array(hexdec(substr($color, 0, 2)), hexdec(substr($color, 2, 2)), hexdec(substr($color, 4, 2)));
    }

    public static function utf8Text($text) {
        $text = mb_convert_encoding($text, 'HTML-ENTITIES', "UTF-8");
// Convert HTML entities into ISO-8859-1
        $text = html_entity_decode($text, ENT_NOQUOTES, "ISO-8859-1");
// Convert characters > 127 into their hexidecimal equivalents
        $out = "";
        for ($i = 0; $i < strlen($text); $i++) {
            $letter = $text[$i];
            $num = ord($letter);
            if ($num > 127) {
                $out .= "&#$num;";
            } else {
                $out .= $letter;
            }
        }

        return $out;
    }

    public static function getUrlFromAlias($alias) {
        $alias = str_replace('.', '/', $alias);
        $alias = str_replace('webroot/', Yii::app()->getBaseUrl(true) . '/', $alias);
        $alias = rtrim($alias, '/');
        return $alias . '/';
    }

    public static function getUrlFromPath($path) {
        return "hasankachal" . $path;
//        return Yii::app()->baseUrl . '/' . substr($path, strlen(Yii::getPathOfAlias('webroot')) + 1);
    }

    public static function fetchImageSizes($images, $withContent = false, $withIm = false) {
        $headers = array(
            'jpeg' => array('format' => 'A3test', 'test' => "\xFF\xD8\xFF"),
            'jpg' => array('format' => 'A3test', 'test' => "\xFF\xD8\xFF"),
            'gif' => array('format' => 'A3test', 'test' => "GIF"),
            'png' => array('format' => 'A8test', 'test' => "\x89\x50\x4e\x47\x0d\x0a\x1a\x0a"),
        );

        $imagesBySize = array();
        $contents = array();
        $totalImages = count($images);
        foreach ($images as $img) {
            if (function_exists('curl_init')) {
                $ch = curl_init($img);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($ch, CURLOPT_AUTOREFERER, true);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
                curl_setopt($ch, CURLOPT_TIMEOUT, 60);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:5.0) Gecko/20110619 Firefox/5.0');

                $contents[$img] = curl_exec($ch);
            } else {
                $contents[$img] = file_get_contents($img);
            }
        }

        foreach ($images as $img) {
            $is_img = false;
            $content = is_object($contents[$img]) ? $contents[$img]->data : $contents[$img];
            if (!$content) {
                continue;
            }
            $ext = strtolower(substr($img, strrpos($img, '.') + 1));
            $is_gif = $ext == 'gif';
            // test for valid image
            foreach ($headers as $type => $head) {
                $r = unpack($head['format'], $content);
                if ($r['test'] == $head['test']) {
                    $is_img = true;
                    break;
                }
            }

            if ($is_img && $im = @imagecreatefromstring($content)) {
                $arr = array(
                    'width' => imagesx($im),
                    'height' => imagesy($im),
                    'ext' => $ext,
                );

                if ($is_gif) {
                    preg_match_all('#\x00\x21\xF9\x04.{4}\x00\x2C#s', $content, $matches);
                    $arr['frames'] = isset($matches[0]) ? count($matches[0]) : 1;
                }

                if ($withContent) {
                    $arr['content'] = $content;
                }
                if ($withIm) {
                    $arr['im'] = &$im;
                }
                $imagesBySize[$img] = $arr;
            }
        }

        return $imagesBySize;
    }

    public static function filterByImages($images) {
        $filtered = array();
        foreach ($images as $img) {
            $comps = parse_url($img);
            if (preg_match('/\.(jpe?g|gif|png)$/', $comps['path'])) {
                $filtered[] = $img;
            }
        }

        return $filtered;
    }

    public static function getAspectHeight($destination_width, $original_width, $original_height) {
        $r = $destination_width/$original_width;
        return round($original_height * $r);
    }

    public static function getAspectWidth($destination_height, $original_width, $original_height) {
        $r = $destination_height/$original_height;
        return round($original_width * $r);
    }
    
    /**
     * 
     * @param resource $img
     * @param bool $is_width
     */
    public static function resize($img, $size, $is_width = true) {
        $w = imagesx($img);
        $h = imagesy($img);
        $nw = $is_width ? $size : self::getAspectWidth($size, $w, $h);
        $nh = $is_width ? self::getAspectHeight($size, $w, $h) : $size;
        
        $nw_img = imagecreatetruecolor($nw, $nh);
        imagefill($nw_img, 0, 0, imagecolorallocatealpha($nw_img, 255, 255, 255, 127));
        imagecopyresampled($nw_img, $img, 0, 0, 0, 0, $nw, $nh, $w, $h);
        return $nw_img;
    }

    public static function getValue(array $arr, $key, $default) {
        if (isset($arr[$key])) {
            return $arr[$key];
        }

        return $default;
    }

    public static function cleanFileName($str) {
        $slug = preg_replace('@[\s!:;_\?=\\\+\*/%&#]+@', '-', $str);

        //convert string to lowercase
        if (function_exists('mb_strtolower'))
            $slug = mb_strtolower($slug);

        //this will replace all non alphanumeric char with '-'
        $slug = trim($slug, '-');

        return $slug;
    }
    
    public static function rawToFriendly($name) {
        return ucwords(trim(strtolower(str_replace(array('-','_','.'),' ',preg_replace('/(?<![A-Z])[A-Z]/', ' \0', $name)))));
    }

    public static function toCamelCase($str, $capitalise_first_char = false){
        if($capitalise_first_char) {
            $str[0] = strtoupper($str[0]);
        }
        $func = create_function('$c', 'return strtoupper($c[1]);');
        return preg_replace_callback('/_([a-z])/', $func, $str);
    }

    public static function isValidParam($param){
        return $param && isset($param) & !empty($param);
    }
    /**
     * Get human readable time difference between 2 dates
     *
     * Return difference between 2 dates in year, month, hour, minute or second
     * The $precision caps the number of time units used: for instance if
     * $time1 - $time2 = 3 days, 4 hours, 12 minutes, 5 seconds
     * - with precision = 1 : 3 days
     * - with precision = 2 : 3 days, 4 hours
     * - with precision = 3 : 3 days, 4 hours, 12 minutes
     *
     * From: http://www.if-not-true-then-false.com/2010/php-calculate-real-differences-between-two-dates-or-timestamps/
     *
     * @param mixed $time1 a time (string or timestamp)
     * @param mixed $time2 a time (string or timestamp)
     * @param integer $precision Optional precision
     * @return string time difference
     */
    public static function get_date_diff( $time1, $time2, $trans,$precision = 2 ) {
        // If not numeric then convert timestamps
        $ago_or_left = 'AGO';
        if( !is_int( $time1 ) ) {
            $time1 = strtotime( $time1 );
        }
        if( !is_int( $time2 ) ) {
            $time2 = strtotime( $time2 );
        }

        // If time1 > time2 then swap the 2 values
        if( $time1 > $time2 ) {
            $ago_or_left = 'LEFT';
            list( $time1, $time2 ) = array( $time2, $time1 );
        }

        // Set up intervals and diffs arrays
        $intervals = array( 'year', 'month', 'day', 'hour', 'minute', 'second' );
        $diffs = array();

        foreach( $intervals as $interval ) {
            // Create temp time from time1 and interval
            $ttime = strtotime( '+1 ' . $interval, $time1 );
            // Set initial values
            $add = 1;
            $looped = 0;
            // Loop until temp time is smaller than time2
            while ( $time2 >= $ttime ) {
                // Create new temp time from time1 and interval
                $add++;
                $ttime = strtotime( "+" . $add . " " . $interval, $time1 );
                $looped++;
            }

            $time1 = strtotime( "+" . $looped . " " . $interval, $time1 );
            $diffs[ $interval ] = $looped;
        }

        $count = 0;
        $times = array();
        foreach( $diffs as $interval => $value ) {
            // Break if we have needed precission
            if( $count >= $precision ) {
                break;
            }
            // Add value and interval if value is bigger than 0
            if( $value > 0 ) {
                // Add value and interval to times array
                $times[] = $value . " " . $trans->_(strtoupper($interval));
                $count++;
            }
        }

        // Return string with times
        return implode( ' '.$trans->_('AND').' ', $times).' '.$trans->_($ago_or_left);
    }

    public static function getProperQrInstance($normal_or_transparent){
        if(empty($normal_or_transparent) || !in_array($normal_or_transparent,array('NORMAL','TRANSPARENT'))){
            $normal_or_transparent = 'NORMAL';
        }
        $qrTypeClassName = 'QUIZUP\Models\Custom\QrVisualType'.ucfirst(strtolower($normal_or_transparent));
        return new $qrTypeClassName();

    }

    public static function getProperQrInstanceFromModel($modelObj ){
        if(!$modelObj)
            return $modelObj;
        $data = json_decode($modelObj->getData(),true);
        $instance = self::getProperQrInstance($data['normal_or_transparent']);
        $instance->buildFromPost($data);
        $instance->setId($modelObj->getId());
        $instance->setUserPackageId($modelObj->getUserPackageId());
        $instance->setQrTypeId($modelObj->getQrTypeId());
        $instance->setCreateDate($modelObj->getCreateDate());
        $instance->setModifyDate($modelObj->getModifyDate());
        $instance->setTitle($modelObj->getTitle());
        $instance->setisLive($modelObj->getisLive());
        $instance->setUserEnable($modelObj->getUserEnable());
        $instance->setAdminEnable($modelObj->getAdminEnable());
        $instance->setData($modelObj->getData());
        return $instance;
    }

    public static function generateRandomNumber($digits = 6){
        return rand(pow(10, $digits-1), pow(10, $digits)-1);
    }

}
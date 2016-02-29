<?php
/**
 * Created by IntelliJ IDEA.
 * User: mohammad
 * Date: 8/7/15
 * Time: 12:51 PM
 */

namespace QUIZUP\Libraries;


use Phalcon\Filter;
use Phalcon\Mvc\User\Component;

class JsonPost extends Component {
    private $content_arr = null;
    private $filter_instance = null;

    function __construct($content_arr)
    {
        if(is_array($content_arr))
            $this->content_arr = $content_arr;
        else
            $this->content_arr = json_decode($content_arr, true);
    }

    public function get($index = null ,$filter = null ,$default = null){
        if (is_null($index))
            return $this->content_arr;

        if (!array_key_exists($index, $this->content_arr))
            return $default;

        $ret = $this->content_arr[$index];
        if (!is_null($filter)){
            $ret = $this->getFilterInstance()->sanitize($ret, $filter);
        }

        return $ret;
    }

    private function getFilterInstance(){
        if(is_null($this->filter_instance)){
            $this->filter_instance = new Filter();
        }
        return $this->filter_instance;
    }

}
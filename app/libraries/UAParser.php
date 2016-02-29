<?php
/**
 * Created by IntelliJ IDEA.
 * User: mohammad
 * Date: 8/13/15
 * Time: 11:29 AM
 */

namespace QUIZUP\Libraries;

require_once __DIR__ . '/ua-parser/vendor/autoload.php';

use Phalcon\Mvc\User\Component;
use UAParser\Parser;

class UAParser extends Component{
    private $result;

    function __construct()
    {
        $di = $this->getDI();
        $this->result = Parser::create()->parse($di['request']->getUserAgent());
    }

    public function getResult() {
        return $this->result;
    }
}
<?php
/**
 * Created by IntelliJ IDEA.
 * User: mohammad
 * Date: 8/6/15
 * Time: 12:19 PM
 */

namespace QUIZUP\Libraries\Exceptions;


class AuthException extends Exception {
    function __construct($message)
    {
        parent::__construct($message);
    }

}
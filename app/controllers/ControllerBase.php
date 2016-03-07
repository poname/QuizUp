<?php

namespace QUIZUP\Controllers;

use Phalcon\Tag;
use QUIZUP\Libraries\JsonPost;
use QUIZUP\Models\AppLog;
use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{
    protected $_jsonPost = null;

    public function initialize(){
        Tag::setTitle($this->translator->_('SITE_MAIN_TITLE'));
        Tag::setTitleSeparator('|');
        $this->view->setVar('base_uri', $this->url->getBaseUri());
        $this->view->setVar('t', $this->translator);
    }

    protected function jsonResponse($success,array $data = array()){
        $this->view->disable();
        $response = new \Phalcon\Http\Response();
        $response->setContentType('application/json', 'UTF-8');
        $response->setContent(json_encode(array(
            'success' => $success,
            'data' => $data
        )));
        return $response;
    }

    protected function jsonPost(){
        if(is_null($this->_jsonPost)){
            $this->_jsonPost = new JsonPost(file_get_contents("php://input"));
        }
        return $this->_jsonPost;
    }

    protected function addAppLog(array $data,$type="ERROR"){
        $user = $this->auth->getUser();
        $app_log = new AppLog();
        $app_log->setUserId($user ? $user->getId() : 0);
        $app_log->setRequestUri($this->request->getURI());
        $app_log->setType($type);
        $app_log->setData(json_encode($data));
        $app_log->save();
    }

    public static function isPrivate()
    {
        return false;
    }
}

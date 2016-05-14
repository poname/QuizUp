<?php
/**
 * Created by IntelliJ IDEA.
 * User: asus
 * Date: 5/3/2016
 * Time: 8:55 PM
 */
namespace QUIZUP\Controllers;

class ApiController extends ControllerBase {
    public function initialize(){
        parent::initialize();
    }
    public function indexAction(){


        //return $this->response->redirect('main/');
    }
	
	
	//http://localhost/api/getQuiz/2313/123213/123123

    public function generateNewQuizAction(){
		return  $this-> jsonResponse(true,array('test'=>1));

    }
	public function saveResultAction()
	{
		if ($this->request->isPost()) {
            return  $this-> jsonResponse(true,array('test'=>1));
			// Access POST data
			//stomerName = $this->request->getPost("name");
		//	$customerBorn = $this->request->getPost("born");

		}
	}

    public function show503(){
        echo '503';
		
    }
}
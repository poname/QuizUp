var adapter = require('./PhalconAdapter.js');
var config = require('./config');

var quizModule = (function() {

    var questionInterval = config.waitInterval;
    var quizes = []; //private
    var sendQuestion ;
    var sendFinished ;
    var news ;

    function generateNextQuestionInfo(quiz){
        // TO DO
        // make an object containing question body, choices, quiz id, question no
        // don't forget to update currentQuestion no for each request
        // if questions are finished, clear quiz interval and call finishQuiz(quiz)
        if(quiz.currentQuestion == quiz.questions.length-1) {
            quiz.timer ? clearTimeout(quiz.timer) : null ;
            finishQuiz(quiz);
        }else{
            quiz.currentQuestion = quiz.currentQuestion + 1;

            var qInstance = quiz.questions[quiz.currentQuestion];
            // delete qInstance.correct; //@TODO we should do something here!
            sendQuestion(quiz.socket1,quiz.socket2,qInstance);

        }
    }

    function finishQuiz(quiz){ 
        // TO DO
        //when a quiz is finished call this method
        //remove quiz from quizes and tell adapter to saveResult call adapter.saveResult(quiz);
        //call sendFinished(quiz.socket1, quiz.socket2, quiz.result)
        for (var i = 0; i < quizes.length; i++) {
            if(quiz.id == quizes[i].id){
                quizes.splice(i);
            }

        }

        //TO DO NOW
        //we must calculate result by questions correct choices and player choosed choices
        //quiz.result = ....
        var user1CorrectAnswers = 0;
        var user2CorrectAnswers = 0;

        for (var i = 0; i < quiz.questions.length; i++) {
            var q = quiz.questions[i];
            if(q.correct == q.user1Choice) user1CorrectAnswers++;
            if(q.correct == q.user2Choice) user2CorrectAnswers++;
        }

        quiz.score1 = user1CorrectAnswers;
        quiz.score2 = user2CorrectAnswers;

        if(user1CorrectAnswers==user2CorrectAnswers){
            quiz.result = 0;
        }else if(user1CorrectAnswers>user2CorrectAnswers){
            quiz.result = 1;
        }else if(user1CorrectAnswers<user2CorrectAnswers){
            quiz.result = 2;
        }else{
            quiz.result = -1; // i think it'll never happen , but just for clarification
        }
        adapter.saveResult(quiz,function(){
            sendFinished(quiz);
        });
    }

    return { //exposed to public
        init: function(sendFn_callback, finishFn_callback, news_callback){
            sendQuestion = sendFn_callback;
            sendFinished = finishFn_callback;
            news = news_callback;
        },
        newQuiz: function(user1,user1Info, user2,user2Info, cat, socket1, socket2) {
            adapter.getQuiz(user1,user1Info, user2,user2Info, cat, socket1, socket2,function(state,quiz){
                if(state == true){
                    quizes.push(quiz);

                    quiz.timer = setInterval(function(){
                        generateNextQuestionInfo(quiz);
                    }, questionInterval); //every question interval milliseconds call generateNextQuestionInfo

                    //say who is playing with who
                    news(socket1, user2Info);
                    news(socket2, user1Info);
                }else{
                    console.log('we should warn the user that quiz creation was failed');
                }
            });
            //questionInfo of all questions of this quiz will generate and send automatically
        },
        pushAnswer: function(sock, ansInfo){
            //TO DO
            var quizObj = null;
            for (var i = 0; i < quizes.length; i++) {
                if(quizes[i].quizId === ansInfo.quizId){
                    quizObj = quizes[i];
                }
            }
            if(!quizObj){
                console.log("quizId (" + ansInfo.quizId + ") not found in quizes list, STRANGE!!!");
                return;
            }

            if(quizObj.socket1 == sock){
            //if(quizObj.user1 == sock.username){
                quizObj.questions[quizObj.currentQuestion].user1Choice = ansInfo.choosed;
            }
            else if(quizObj.socket2 == sock){
                quizObj.questions[quizObj.currentQuestion].user2Choice = ansInfo.choosed;
            }else{
                console.log("NEITHER socket1 nor socket2 was equal to quizObject sockets! STRANGE!!");
            }
            //when an answer arrives, it has a quizId and we check if the quiz associated with this id is alreay in quizes
            //this ansInfo also includes question no, so we can add userXchoice to the question associated in quiz

            /*
                information ::

                quiz object
                { 
                    user1:user1, 
                    user2:user2, 
                    category:cat,
                    socket1:sock1,
                    socket2:sock2,
                    currentQuestion:0, //refers to which question client is answering 
                    questions:questions, //array of question objects
                    quizId:id,
                    score1:0,
                    score2:0, 
                    result:0 // 0::inprocess, 1::user1 win, 2::user2 win, -1::equal, -2::failed 
                }

                question object
                {
                    body:'how are you?', 
                    choices:{ 1:'fine', 2:'bad', 3:'moody' }, 
                    correct:3, 
                    user1Choice:0, 
                    user2Choice:0
                }

                questionInfo object
                {
                    body:..., 
                    choices:..., 
                    quizId:..., 
                    questionNo:...
                }
            */
        }
    }
}());

module.exports = quizModule;
var quiz = require('./Quiz.js');
var queue = require('./Queue.js');

var gatewayModule = (function() {

    // Setup basic express server
    var express = require('express');
    var app = express();
    var server = require('http').createServer(app);
    var io = require('socket.io')(server);
    var port = process.env.PORT || 3000;
    server.listen(port, function() {
        console.log('Server listening at port %d', port);
    });

    // Routing
    app.use(express.static(__dirname + '/public'));

    function bipbip(){
        console.log('+++++++++++++ bip bip');
    }

    function finishGame(quiz){
        var sendObj1 = {
            result: 0,
            score: quiz.score1
        };
        var sendObj2 = {
            result: 0,
            score: quiz.score2
        };

        if(quiz.result == 1){
            sendObj1.result = 1;
            sendObj2.result = -1;
        }
        else if(quiz.result === 2){
            sendObj1.result = -1;
            sendObj2.result = 1;
        }
        quiz.socket1.emit('result', sendObj1);
        quiz.socket2.emit('result', sendObj2);
    }

    var sendQuestion =  function(socket1, socket2, questionInfo){
        console.log('-------------', 'Sending questions');
        socket1.emit('question', questionInfo);
        socket2.emit('question', questionInfo);
    };

    var news = function(sock, userInfo){
        sock.emit('news', userInfo.name+" "+userInfo.family);
    };

    quiz.init(sendQuestion, finishGame, news);

    var waiting = function(sock){
        sock.emit('wait', '');
    };
    queue.init(waiting, quiz.newQuiz);

    io.on('connection', function (socket) {
        console.log('someone connected');
        
        socket.on('hi', function (data) {
            console.log(data);
        });

        socket.on('request', function (data) {
            console.log('game request:', data.username, data.category);
            //socket.emit('question', { 
            //    question: 'esmet chie ?' , 
            //    choices: { 1:'ziad', 2:'kam', 3:'b to che' }
            //});
            //var q = quiz.newQuiz(1, 2, 'bad', socket, socket, sendQuestion);
            //socket.username = username;
            queue.addRequest(data.username,data.userInfo, data.category, socket);
        });

        socket.on('answer', function (ansInfo) {
            console.log(ansInfo);
            //if(ansInfo.choosed === '3')
            //    socket.emit('result', 'Yeeeesss');
            //else
            //    socket.emit('result', 'ridii :)');
            quiz.pushAnswer(socket, ansInfo);
        });
    });



    return { //exposed to public
        //waiting: function(sock){
        //    sock.emit('wait', '');
        //},
        //finishGame: function(socket1, socket2, result){

        //},
        //sendQuestion: function(socket1, socket2, questionInfo){
        //    console.log('-------------', questionInfo);
        //},
        //sayJoon: function(){

        //}
    }
}());

module.exports = gatewayModule;
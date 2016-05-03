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

    function finishGame(socket1, socket2, result){
        var looser = "you loose";
        var winner = "you won";
        var equal = 'mosav';
        var err = 'error occured'; 
        if(result == 1){
            socket1.emit('result', winner);
            socket2.emit('result', looser);  
        }
        else if(result === 2){
            socket2.emit('result', winner);
            socket1.emit('result', looser); 
        }
        else if(result === 0){
            socket2.emit('result', equal);
            socket1.emit('result', equal); 
        }
        else{
            socket2.emit('result', err);
            socket1.emit('result', err); 
        }
    }

    var sendQuestion =  function(socket1, socket2, questionInfo){
        console.log('-------------', 'Sending questions');
        socket1.emit('question', questionInfo);
        socket2.emit('question', questionInfo);
    }

    var news = function(sock, data){
        sock.emit('news', data);
    }

    quiz.init(sendQuestion, finishGame, news);

    var waiting = function(sock){
        sock.emit('wait', '');
    }
    queue.init(waiting, quiz.newQuiz);

    io.on('connection', function (socket) {
        console.log('somone connected');
        
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
            queue.addRequest(data.username, data.category, socket);
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
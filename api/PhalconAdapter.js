var adapterModule = (function() {
    var config = require('./config');

    function quizInfoGenerate(user1,user1Info, user2,user2Info, cat, sock1, sock2, questions, id){
        //gateway.sendQuestion(sock1, sock2, 'jhoon');
        return { 
            user1:user1,
            user1Info:user1Info,
            user2:user2,
            user2Info:user2Info,
            category:cat,
            socket1:sock1,
            socket2:sock2,
            currentQuestion:-1, //refers to which question client is answering 
            questions:questions, 
            quizId:id,
            score1:0,
            score2:0,
            result:0, // 0::inprocess, 1::user1 win, 2::user2 win, -1::equal, -2::failed
            timer:null
        };
    }

    return { //exposed to public
        validate: function(user, cat) {

           return true; 
        },
        getQuiz: function(user1,user1Info, user2,user2Info, cat, socket1, socket2 , callback) {
            //fn();
            var http = require("http");
            var options = {
                host: config.backendHost,
                port: config.backendPort,
                path: config.backendUri+config.apiPath+'/generateNewQuiz?uid1='+user1+'&uid2='+user2+'&cat='+cat,
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json'
                }
            };
            var req = http.request(options, function(res)
            {
                var output = '';
                console.log(options.host + ':' + res.statusCode);
                res.setEncoding('utf8');

                res.on('data', function (chunk) {
                    output += chunk;
                });

                res.on('end', function() {
                    var obj = JSON.parse(output);
                    if(callback){
                         var q = [];
                         for(var idx in obj.data.questions){
                             q.push({
                                 body: obj.data.questions[idx].body,
                                 choices: obj.data.questions[idx].choices,
                                 correct: obj.data.questions[idx].correct,
                                 user1Choice:0, user2Choice:0, quizId:obj.data.quizId,
                                 qNo:idx
                             });
                         }
                        var newQuiz = quizInfoGenerate(user1,user1Info,user2,user2Info,cat,socket1,socket2,q,obj.data.quizId)
                        console.log('new generated quiz : ',newQuiz.quizId);
                        callback(true, newQuiz);
                    }else{
                        console.log('request successful but there\'s no callback! wierd!');
                    }
                });
            });

            req.on('error', function(err) {
                console.log('error occured in request ')
                if(callback){
                    callback(true,err)
                }else{
                    console.log('request was usuccessful but there\'s no callback!');
                }

            });

            req.end();
            console.log('ajax done!');
            return true;
        },
        saveResult: function(quizInfo,callback){
            var request = require("request");
            var extend = require('util')._extend;

            //we don't need sockets to be posted
            var quizInfoToPost = extend({},quizInfo);
            delete quizInfoToPost.socket1;
            delete quizInfoToPost.socket2;
            delete quizInfoToPost.timer;
            //-----------------------------------

            request.post(
                {
                    url:config.backendUri+config.apiPath+'/saveResult',
                    form:quizInfoToPost
                }, function(err, res, body) {
                if (!err && res.statusCode === 200) {
                    callback(true, body);
                }
                else{
                    console.log("error: " + err+" res: "+res+" body: "+body);
                    callback(false, err);
                }
            });
            return true;
        }
    }
}());

module.exports = adapterModule;
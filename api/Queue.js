var adapter = require('./PhalconAdapter.js');

var queueModule = (function() {
    var list = []; //private

    var waiting;
    var newQuiz;

    function makeRequest(user,userInfo, cat, sock){
        return { username:user,userInfo:userInfo, category:cat, socket:sock} ;
    }

    return {
        addRequest: function(user,userInfo, cat, sock) {
            var request = makeRequest(user,userInfo, cat, sock);
            if(adapter.validate(user,cat)){
                var opponentFound = false;
                for (var i = 0; i < list.length; i++) {
                    if(list[i].category == cat){
                        var opponent = list[i];
                        opponentFound = true;
                        newQuiz(user,userInfo,opponent.username,opponent.userInfo, cat, sock, opponent.socket);

                        list.splice(i, 1);
                    }
                }

                if(!opponentFound){
                    list.push(request);
                    waiting(sock);
                }
                else{
                     waiting(sock); //second user starts waiting for start delay
                }
            }
        },
        init: function(waitingFn_callback, newQuizFn_callback){
            waiting = waitingFn_callback;
            newQuiz = newQuizFn_callback;
        }
    }
}());

module.exports = queueModule;
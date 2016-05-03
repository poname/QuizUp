var adapter = require('./PhalconAdapter.js');

var queueModule = (function() {
    var list = []; //private

    var waiting;
    var newQuiz;

    function makeRequest(user, cat, sock){
        return { username:user, category:cat, socket:sock} ;
    }

    return {
        addRequest: function(user, cat, sock) {
            var request = makeRequest(user, cat, sock);
            if(adapter.validate(user,cat)){
                var opponentFound = false;
                for (var i = 0; i < list.length; i++) {
                    if(list[i].category == cat){
                        var opponent = list[i];
                        opponentFound = true;
                        newQuiz(user, opponent.username, cat, socket, user.socket);
                        list.splice(i, 1);
                    }
                }

                if(!opponentFound){
                    list.push(request);
                    waiting(sock);
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
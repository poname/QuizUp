var adapterModule = (function() {

    function quizInfoGenerate(user1, user2, cat, sock1, sock2, questions, id){
        //gateway.sendQuestion(sock1, sock2, 'jhoon');
        return { 
            user1:user1, 
            user2:user2, 
            category:cat,
            socket1:sock1,
            socket2:sock2,
            currentQuestion:0, //refers to which question client is answering 
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
        getQuiz: function(user1, user2, cat, socket1, socket2) {
            //fn();
            var q = [];
            q.push({body:'how are you?', choices:{1:'fine', 2:'bad', 3:'moody'}, correct:3, user1Choice:0, user2Choice:0});
            q.push({body:'sky color?  ', choices:{1:'blue', 2:'red', 3:'brown'}, correct:1, user1Choice:0, user2Choice:0});

            return quizInfoGenerate(user1, user2, cat, socket1, socket2, q, 1000);
        },
        saveResult: function(quizInfo){
            console.log('game between', quizInfo.user1, quizInfo.user2, 'finished');
            //console.log(quizInfo);
            return true;
        }
    }
}());

module.exports = adapterModule;
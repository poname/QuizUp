$(function() {

	// Initialize variables

	var countdown = $("#countdown").countdown360({
    	radius: 60,
    	seconds: 10,
    	label: ['sec', 'secs'],
    	fontColor: '#FFFFFF',
    	autostart: false,
    	onComplete: function () {
      	//console.log('done');
    	}
	});

	var timmer = $("#countdown") ;
	timmer.hide();

	var $doButton = $('.do');

	var $requestButton = $('.request');

	var $answerButton = $('.answer');
		$answerButton.hide();

	var $note = $('.note');

	var $choices = $('.choices');

	var $result = $('.result');

	var $spin = $('#spin');
		$spin.hide();

	var $alert = $('#alert');
		$alert.hide();

	// Prompt for setting a username;
	var socket = io();

	var qid = -1 ;
	

	$doButton.click(function(){
		socket.emit('hi', {name:'dani'});
	});

	socket.on('news', function(data) {
		//alert(data.hello);
		$alert.text("You VS " + data) ;
		$alert.show();
	});

	$requestButton.click(function(){
		$requestButton.hide();
		//user click play button, send a request to server
		$result.text("");
		var $user = $('#user').val().trim() ;
		var $cat = $('#cat').val().trim();
		//alert($user, $cat);
		socket.emit('request', {username:$user, category:$cat});
	});

	socket.on('question', function(questionInfo) {

		timmer.show();
		countdown.start();
		//countdown.extendTimer(10);

		$spin.hide();
		$alert.hide();
		//alert(questionInfo);
		//when server sends question to you
		$note.text(questionInfo.qNo + '- ' + questionInfo.body);
		var txt = "" ;
		var id = 1;
		for(var i in questionInfo.choices){
			//txt += i + ':' + questionInfo.choices[i] + '\n' ;
			$('#choice' + id).text(questionInfo.choices[i]) ;

			id++;
		}
		//$choices.text(txt);

		$answerButton.show();

		$qid = questionInfo.quizId ;

		$answerButton.prop('disabled', false);
	});

	$answerButton.click(function(){
		//when user clicked the choice button
		socket.emit('answer', { quizId:$qid, choosed: $(this).attr('value') });
		//$answerButton.hide();
		$answerButton.prop('disabled', true);
	});

	socket.on('result', function(data) {
		//show the result of match, data is a string
		$note.hide();
		$result.text(data);
		$answerButton.hide();
		timmer.hide();
	});

	socket.on('disconnect', function(data) {
		alert('server F');
	});

	socket.on('error', function(data) {
		alert('error occured');
	});

	socket.on('wait', function(data) {
		//wait until another user be ready for game
		//alert('please wait');
		$spin.show();
	});

});
$(function() {

	// Initialize variables

	var $doButton = $('.do');

	var $requestButton = $('.request');

	var $answerButton = $('.answer');
		$answerButton.hide();

	var $note = $('.note');

	var $choices = $('.choices');

	var $result = $('.result');

	// Prompt for setting a username;
	var socket = io();
	

	$doButton.click(function(){
		socket.emit('hi', {name:'dani'});
	});

	socket.on('news', function(data) {
		alert(data.hello);
	});

	$requestButton.click(function(){
		//user click play button, send a request to server
		$result.text("");
		socket.emit('request', {username:'akbar', category:'posture'});
	});

	socket.on('question', function(questionInfo) {
		//when server sends question to you
		$note.text(questionInfo.question);
		var txt = "" ;
		var id = 1;
		for(var i in questionInfo.choices){
			//txt += i + ':' + questionInfo.choices[i] + '\n' ;
			$('#choice' + id).text(questionInfo.choices[i]) ;

			id++;
		}
		//$choices.text(txt);

		$answerButton.show();
	});

	$answerButton.click(function(){
		//when user clicked the choice button
		socket.emit('answer', {choosed: $(this).attr('value')});
		$answerButton.hide();
	});

	socket.on('result', function(data) {
		//show the result of match, data is a string
		$result.text(data);
	});

	socket.on('disconnect', function(data) {
		alert('server fucked');
	});

	socket.on('error', function(data) {
		alert('error occured');
	});

	socket.on('waiting', function(data) {
		//wait until another user be ready for game
		alert('please wait');
	});

});
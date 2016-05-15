$(function() {
	
	var $answerButton = $('.answer');
	var $requestButton = $('.request');
	var showMask = function(state){
		$('.segment').dimmer(state === true ? 'show' : 'hide');
	}
	var quizId = null;

	var steps = [
		{
			id: "selectCategory",
			onRequestButtonClicked:function(){
				var $user = _USER_INFO.id;
				var $cat = $('input[name=category]:checked', '#selectCategory form').val();
				if($user && $cat){
					_SOCKET.emit('request', {username:$user, category:$cat});
					nextStep();
				}else{
					console.log($user, $cat, 'something is not right');
				}

			}
		},
		{
			id: "waiting",
			init: function () {
				showMask(true);
			},
			onOtherPlaySpecified:function(opponent_name){
				showMask(false);
				$('#opponent_name').html(opponent_name);
			},
			onQuestion:function(questionInfo){
				steps[currentStep + 1].onQuestion(questionInfo);
				nextStep();
			}
		},
		{
			id: "game",
			onQuestion:function(questionInfo){
				$('#game .form').trigger("reset");

				$('#question-text').text(questionInfo.body);
				$('#answer-1 label').html(questionInfo.choices[1])
				$('#answer-2 label').html(questionInfo.choices[2])
				$('#answer-3 label').html(questionInfo.choices[3])
				$('#answer-4 label').html(questionInfo.choices[4])
				$answerButton.show();
				quizId = questionInfo.quizId ;
			},
			onAnswerButtonClicked:function(){
				var selected = $("#game input[type='radio']:checked");
				if(selected) {
					_SOCKET.emit('answer', {quizId: quizId, choosed: selected.val()});
					$answerButton.hide();
				}
			},
			onResult:function(data){
				$('#result p.show-result').html(data);
				// //show the result of match, data is a string
				// $note.hide();
				// $result.text(data);
				// $answerButton.hide();
				nextStep();

			}
		},
		{
			id: "result"
		}
	];
	var currentStep = 0;
	var nextStep = function () {

		//noinspection JSJQueryEfficiency
		$('#' + steps[currentStep].id).hide();

		currentStep++;

		//noinspection JSJQueryEfficiency
		$('#' + steps[currentStep].id).show();
		if (steps[currentStep].init) {
			steps[currentStep].init();
		}
	};

	$requestButton.click(function(e){
		e.preventDefault();
		steps[currentStep].onRequestButtonClicked();
	});
	$answerButton.click(function(e){
		e.preventDefault();
		steps[currentStep].onAnswerButtonClicked();
	});

	_SOCKET.on('news', function(data) {
		if(steps[currentStep].onOtherPlaySpecified(data));
	});
	_SOCKET.on('question', function(questionInfo) {
		if(steps[currentStep].onQuestion){
			steps[currentStep].onQuestion(questionInfo);
		}else{
			console.log('something is wrong somewhere!!',currentStep,steps);
		}
	});
	_SOCKET.on('result', function(data) {
		if(steps[currentStep].onResult){
			steps[currentStep].onResult(data);
		}else{
			console.log('something is wrong somewhere!!',currentStep,steps);
		}
	});
	_SOCKET.on('disconnect', function(data) {
		alert('server fucked');
	});
	_SOCKET.on('error', function(data) {
		alert('error occured');
	});
	// _SOCKET.on('wait', function(data) {
	// 	//wait until another user be ready for game
	// 	//alert('please wait');
	// 	$spin.show();
	// });

});
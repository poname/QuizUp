$(function() {
	
	var $answerButton = $('.answer');
	var $requestButton = $('.request');
	var $timer = $('#timer');
	var _timer_refrence = null;
	var showMask = function (state) {
		$('.segment').dimmer(state === true ? 'show' : 'hide');
	};

	$timer.progress();

	var stopTimer = function () {
		if (_timer_refrence) {
			clearTimeout(_timer_refrence);
		}
	};
	var startTimer = function () {
		_timer_refrence = setTimeout(function () {
			$timer.progress('decrement',1);
			startTimer();
		}, _WAIT_INTERVAL/100);
	};
	var restartTimer = function () {
		stopTimer();
		$timer.progress({
			percent:100
		})
		startTimer();
	};
	var quizId = null;

	var steps = [
		{
			id: "selectCategory",
			onRequestButtonClicked:function(){
				var $user = _USER_INFO.id;
				var $cat = $('input[name=category]:checked', '#selectCategory form').val();
				if($user && $cat){
					_SOCKET.emit('request', {username:$user,userInfo:_USER_INFO, category:$cat});
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
				restartTimer();
			},
			onQuestion:function(questionInfo){
				steps[currentStep + 1].onQuestion(questionInfo);
				nextStep();
			}
		},
		{
			id: "game",
			onQuestion:function(questionInfo){
				restartTimer();
				$('#game .form').trigger("reset");

				$('#question-text').text(questionInfo.body);
				$('#answer-1 label').html(questionInfo.choices[1])
				$('#answer-2 label').html(questionInfo.choices[2])
				$('#answer-3 label').html(questionInfo.choices[3])
				$('#answer-4 label').html(questionInfo.choices[4])
				$answerButton.removeClass('disabled');
				quizId = questionInfo.quizId ;
			},
			onAnswerButtonClicked:function(){
				var selected = $("#game input[type='radio']:checked");
				if(selected) {
					_SOCKET.emit('answer', {quizId: quizId, choosed: selected.val()});
					$answerButton.addClass('disabled');
				}
			},
			onResult:function(data){
				stopTimer();
				debugger;
				if(data.result == 1){
					$('#result .winner .earned_points').html(data.score);
					$('#result .winner').show();
				}else if(data.result == -1){
					$('#result .looser .earned_points').html(data.score);
					$('#result .looser').show();
				}else if(data.result == 0){
					$('#result .draw .earned_points').html(data.score);
					$('#result .draw').show();
				}
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
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
		});
		startTimer();
	};
	var quizId = null;
	var correct = null;

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
				$answerButton.removeClass('primary');
				$answerButton.removeClass('green');
				$answerButton.removeClass('red');
				$answerButton.removeClass('disabled');
				$answerButton.removeClass('active');
				$('#question-text').text(questionInfo.body);
				$('#answer-1').html(questionInfo.choices[1]);
				$('#answer-2').html(questionInfo.choices[2]);
				$('#answer-3').html(questionInfo.choices[3]);
				$('#answer-4').html(questionInfo.choices[4]);

				quizId = questionInfo.quizId ;
				correct = questionInfo.correct;
				//alert(correct + "--" + questionInfo.correct);
			},
			onAnswerButtonClicked:function(selected_button){
				var selected = false;
				if(selected_button.is('#answer-1')){
					selected=1;
				}else if(selected_button.is('#answer-2')) {
					selected=2;
				}else if(selected_button.is('#answer-3')) {
					selected=3;
				}else if(selected_button.is('#answer-4')){
					selected=4;
				}
				if(selected) {
					//alert(correct + "++" + selected);
					//selected_button.addClass('primary');
					// say answer is correct or not immediately after answering
					if(selected == correct){
						selected_button.addClass('green');
					}
					else{
						selected_button.addClass('red');
						$('#answer-' + correct).addClass('green');
					}

					$answerButton.addClass('disabled');
					_SOCKET.emit('answer', {quizId: quizId, choosed: selected});
				}
			},
			onResult:function(data){
				stopTimer();
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
		steps[currentStep].onAnswerButtonClicked($(this));
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
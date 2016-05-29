<div id="header">
    {% include "include/header.volt" %}
</div>

<div class="ui middle aligned center aligned grid">
    <div class="column">
        <div class="ui segment left aligned" id="main-segment" style="min-height: 100px">
            <div class="ui inverted dimmer" id="loading-wrapper">
                <div class="ui text loader">{{ t('LOADING') }}</div>
            </div>
            <div class="ui top attached progress indicating" id="timer" data-percent="100">
                <div class="bar"></div>
            </div>
            <div class="step0 content invisible no-take-place">
                <p>{{ t('QUIZ_OPENING_TEXT') }}</p>
                <div class="ui fluid large start button fa submit answer">{{ t('LETS_GO') }}</div>
            </div>
            <div class="step1-5 content invisible no-take-place">
                <form class="ui large form" action="" method="post">
                    <div class="grouped fields">
                        <label id="question-text">question texts</label>
                        <div class="answer-container"><button class="ui fluid button answer fa" id="answer-1">Answ1</button></div>
                        <div class="answer-container"><button class="ui fluid button answer fa" id="answer-2">Answ2</button></div>
                        <div class="answer-container"><button class="ui fluid button answer fa" id="answer-3">Answ3</button></div>
                        <div class="answer-container"><button class="ui fluid button answer fa" id="answer-4">Answ4</button></div>
                    </div>
                </form>
            </div>
            <div class="step6 content invisible no-take-place">
                <p>{{ t('QUIZ_IS_FINISHED') }}</p>
                <p>{{ t('NUMBER_OF_CORRECT_ANSWERS') }}: <span id="correct_answers_count">{{ correct_answers_count }}</span></p>
                <p>{{ t('EARNED_POINTS') }}: <span id="earned_points">{{ earned_points }}</span></p>
                <a class="fluid ui button fa" href="{{ url('login/success') }}">{{ t('GO_TO_USER_PANEL') }}</a>
                <a class="fluid ui button fa" href="{{ url('ranking') }}">{{ t('GO_TO_RANKING_PAGE') }}</a>
                <a class="fluid ui button fa" href="{{ url('quiz/doitnow') }}">{{ t('TAKE_ANOTHER_QUIZ') }}</a>
            </div>
        </div>
    </div>
</div>
<script>
    var step = {{ step }};
    var quiz_id = {{ quiz_id }};
    var passed_mmseconds = (10-{{ remaining_seconds }}) * 10;
    var $answerButton = $('.answer');

    function get_step_content_selector(stepIndex){
        if(stepIndex!=0 && stepIndex != 6) return '.step1-5';
        return '.step'+stepIndex
    }
    function active_step_indicator(stepIndex,prevIcons){
        $(".step:nth-child(" + (stepIndex + 1) + ")").removeClass('disabled').addClass('active');
    }
    $(document).ready(function () {
        for(var sIterator =0 ; sIterator<=step ; sIterator++){
            active_step_indicator(sIterator);
        }
        //setup remaining seconds
        $(get_step_content_selector(step)).show();

        $answerButton.click(function(e){
            e.preventDefault();
            var answer = null; //@TODO get the answer!!
            var selected = false;
            var selected_button = $(this);
            if(selected_button.is('#answer-1')){
                selected=1;
            }else if(selected_button.is('#answer-2')) {
                selected=2;
            }else if(selected_button.is('#answer-3')) {
                selected=3;
            }else if(selected_button.is('#answer-4')){
                selected=4;
            }
            if (selected || step==0) {
                answer = selected;
                $('.segment').dimmer('show');
                $.post(
                        '{{ url('quiz/answer') }}',
                        {
                            step:step,
                            quiz_id:quiz_id,
                            answer:answer
                        },
                        function( data ) {
//                            if(!data.success){
//                                alert(data.data.message);
//                            }
                            if (data.data.current_question) {
                                $('#question-text').html(data.data.current_question.description)
                                $('#answer-1').html(data.data.current_question.ans1)
                                $('#answer-2').html(data.data.current_question.ans2)
                                $('#answer-3').html(data.data.current_question.ans3)
                                $('#answer-4').html(data.data.current_question.ans4)
                                $answerButton.removeClass('primary');
                                $answerButton.removeClass('disabled');
                                $answerButton.removeClass('active');
                            }
                            if(data.data.correct_answers_count){
                                $("#correct_answers_count").html(data.data.correct_answers_count);
                            }
                            if(data.data.earned_points){
                                $("#earned_points").html(data.data.earned_points);
                            }
                            $('.segment').dimmer('hide');
                            $(get_step_content_selector(step)).hide();
                            step++;
                            $(get_step_content_selector(step)).show();

                        }
                );
            }else{
                alert('SELECT_ONE_ANSWER');
            }
        })
    });
</script>
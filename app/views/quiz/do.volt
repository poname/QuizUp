<div class="ui seven top attached steps">
    <div class="disabled step">
        <i class="sound icon"></i>
        <div class="content">
            <div class="title fa">{{ t('START') }}</div>
            <div class="description">{{ t('PREPARE_YOUR_SELF!') }}</div>
        </div>
    </div>
    <div class="disabled step">
        <i class="help circle icon"></i>
        <div class="content">
            <div class="title fa">{{ t('FIRST') ~ ' ' ~ t('QUESTION') }}</div>
        </div>
    </div>
    <div class="disabled step">
        <i class="help circle icon"></i>
        <div class="content">
            <div class="title fa">{{ t('SECOND') ~ ' ' ~ t('QUESTION') }}</div>
        </div>
    </div>
    <div class="disabled step">
        <i class="help circle icon"></i>
        <div class="content">
            <div class="title fa">{{ t('THIRD') ~ ' ' ~ t('QUESTION') }}</div>
        </div>
    </div>
    <div class="disabled step">
        <i class="help circle icon"></i>
        <div class="content">
            <div class="title fa">{{ t('FOURTH') ~ ' ' ~ t('QUESTION') }}</div>
        </div>
    </div>
    <div class="disabled step">
        <i class="help circle icon"></i>
        <div class="content">
            <div class="title fa">{{ t('FIFTH') ~ ' ' ~ t('QUESTION') }}</div>
        </div>
    </div>
    <div class="disabled step">
        <i class="flag icon"></i>
        <div class="content">
            <div class="title fa">{{ t('FINISH') }}</div>
            <div class="description">{{ t('THE_FINAL_RESULT') }}</div>
        </div>
    </div>
</div>
<div class="ui attached segment">
    {#LOADING WRAPPER#}
    <div class="ui inverted dimmer" id="loading-wrapper">
        <div class="ui text loader">{{ t('LOADING') }}</div>
    </div>

    {#TOP PROGRESS BAR#}
    <div class="ui top attached progress" id="timer" data-value="{{ (10-remaining_seconds)*10 }}" data-total="100">
        <div class="bar"></div>
    </div>

    <div class="step0 content invisible no-take-place">
        <p>{{ t('QUIZ_OPENING_TEXT') }}</p>
        <div class="ui fluid large red start button fa submit">{{ t('LETS_GO') }}</div>
    </div>
    <div class="step1-5 content invisible no-take-place">
        <form class="ui large form" action="" method="post">
            <div class="grouped fields">
                <label id="question-text">question texts</label>
                <div class="field" id="answer-1">
                    <div class="ui radio checkbox">
                        <input type="radio" name="answer" value="1">
                        <label>Answ1</label>
                    </div>
                </div>
                <div class="field" id="answer-2">
                    <div class="ui radio checkbox">
                        <input type="radio" name="answer" value="2">
                        <label>Answ2</label>
                    </div>
                </div>
                <div class="field" id="answer-3">
                    <div class="ui radio checkbox">
                        <input type="radio" name="answer" value="2">
                        <label>Answ3</label>
                    </div>
                </div>
                <div class="field" id="answer-4">
                    <div class="ui radio checkbox">
                        <input type="radio" name="answer" value="2">
                        <label>Answ4</label>
                    </div>
                </div>
            </div>
            <div class="ui fluid large red submit button fa">{{ t('ANSWER') }}</div>
        </form>
    </div>
    <div class="step6 content invisible no-take-place">
        <p>{{ t('QUIZ_IS_FINISHED') }}</p>
        <a class="ui red button fa" href="{{ url('login/success') }}">{{ t('GO_TO_USER_PANEL') }}</a>
    </div>
</div>
<script>
    var step = {{ step }};
    var quiz_id = {{ quiz_id }};
    var passed_mmseconds = (10-{{ remaining_seconds }}) * 10;

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

        $('.button.submit').click(function(e){
            e.preventDefault();
            var answer = null; //@TODO get the answer!!
            var selected = $("input[type='radio']:checked");
            if (selected.length > 0 || step==0) {
                answer = selected.val();
                $('.segment').dimmer('show');
                $.post(
                        '{{ url('quiz/answer') }}',
                        {
                            step:step,
                            quiz_id:quiz_id,
                            answer:answer
                        },
                        function( data ) {
                            if(!data.success){
                                alert(data.data.message);
                                $
                            }else{

                            }
                            if (data.data.new_question) {
                                $('#question-text').html(data.data.new_question.description)
                                $('#answer-1 label').html(data.data.new_question.ans1)
                                $('#answer-2 label').html(data.data.new_question.ans2)
                                $('#answer-3 label').html(data.data.new_question.ans3)
                                $('#answer-4 label').html(data.data.new_question.ans4)
                                $('.form').trigger("reset");
                            }
                            $('.segment').dimmer('hide');
                            $(get_step_content_selector(step)).hide();
                            step++;
                            $(".step:nth-child("+(step+1)+")").removeClass('disabled').addClass('active')
                            if(step){
                                $(".step:nth-child(" + (step) + ") i").removeClass('help').removeClass('circle').addClass(data.success?'check circle' : 'remove circle');
                            }
                            $(get_step_content_selector(step)).show();
                        }
                );
            }else{
                alert('SELECT_ONE_ANSWER');
            }
        })
    });
</script>
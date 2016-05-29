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
            {#empty form action means here(quiz/selectCategory)#}
            <div id="selectCategory">
                <form class="ui large form" action="" method="post">
                    <div class="grouped fields">
                        <label>{{ t('SELECT_ONE_OF_CATEGORIES_BELOW_TO_START') }}</label>
                        {% for category in categories %}
                            <div class="field">
                                <div class="ui radio checkbox">
                                    <input type="radio" name="category" value="{{ category.cid }}">
                                    <label>{{ t(category.name) }}</label>
                                </div>
                            </div>
                        {% endfor %}
                    </div>
                    <button class="ui fluid large  submit button fa request">{{ t('SELECT_CATEGORY_AND_START_THE_GAME') }}</button>
                </form>
            </div>
            <div id="waiting" class="invisible no-take-place" >
                <div class="ui middle aligned center aligned grid">
                    <div class="seven wide column" ><h4></h4>{{ t('YOU') }}</div>
                    <div class="two wide column grey"> مقابل </div>
                    <div class="seven wide column" id="opponent_name"></div>
                </div>
            </div>
            <div id="game" class="invisible no-take-place">
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
            <div id="result" class="invisible no-take-place">
                <div class="ui grid winner invisible no-take-place">
                    <div class="five wide column">
                        <i class="icon cocktail green" style="line-height: 100%;font-size: 9em;"></i>
                    </div>
                    <div class="ten wide column">
                        <p>{{ t('CONGRATULATIONS') }}</p>
                        <p>{{ t('YOU_WON') }}</p>
                        <p>{{ t('EARNED_POINTS') }}: <span class="earned_points"></span></p>
                    </div>
                </div>
                <div class="ui grid looser invisible no-take-place">
                    <div class="five wide column">
                        <i class="icon frown gray" style="line-height: 100%;font-size: 9em;"></i>
                    </div>
                    <div class="ten wide column">
                        <p>{{ t('SORRY') }}</p>
                        <p>{{ t('YOU_LOST') }}</p>
                        <p>{{ t('EARNED_POINTS') }}: <span class="earned_points"></span></p>
                    </div>
                </div>
                <div class="ui grid draw invisible no-take-place">
                    <div class="five wide column">
                        <i class="icon coffee grey" style="line-height: 100%;font-size: 9em;"></i>
                    </div>
                    <div class="ten wide column">
                        <p>{{ t('WE_ARE_ALL_EVEN') }}</p>
                        <p>{{ t('SO_AS_YOU_AND_YOUR_OPPONENT') }}</p>
                        <p>{{ t('EARNED_POINTS') }}: <span class="earned_points"></span></p>
                    </div>
                </div>
                <div style="margin-top:10px">
                    <a class="fluid ui button fa" href="{{ url('login/success') }}">{{ t('GO_TO_USER_PANEL') }}</a>
                    <a class="fluid ui button fa" href="{{ url('ranking') }}">{{ t('GO_TO_RANKING_PAGE') }}</a>
                    <a class="fluid ui button fa" href="{{ url('quiz/doitnow') }}">{{ t('TAKE_ANOTHER_QUIZ') }}</a>
                </div>
            </div>
        </div>
        <div id="too-long" class="invisible no-take-place">
            <div class="ui segment middle aligned center aligned grid">
                <p>
                    <a href="#" id="take-offline-quiz-link">{{ t('TAKING_TOO_LONG?YOU_CAN_TAKE THE QUIZ OFFLINE HERE') }}</a>
                </p>
            </div>
        </div>
    </div>
</div>
<script>
    var _SOCKET = io('{{ websocketURL }}');
    var _WAIT_INTERVAL = {{ waitInterval }};
    var _OFFLINE_QUIZ_LINK = '{{ url('quiz/offlineSelectCategory') }}';
</script>

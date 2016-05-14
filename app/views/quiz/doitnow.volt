<div id="content">
    <div class="ui middle aligned center aligned grid">
        <div class="column">
            {{ flashSession.output() }}
            <div class="ui segment" id="selectCategory">
                {#empty form action means here(quiz/selectCategory)#}
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
                    <button class="ui fluid large red submit button fa request">{{ t('SELECT_CATEGORY_AND_START_THE_GAME') }}</button>
                </form>
            </div>
            <div class="ui segment" id="waiting">
                <p>YOU</p>
                <p>VS</p>
                <p id="opponent_name"></p>
            </div>
            <div class="ui segment" id="game">
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
                    <div class="ui fluid large red submit button fa answer">{{ t('ANSWER') }}</div>
                </form>
            </div>
            <div class="ui segment" id="result">
                RESULT
            </div>
        </div>
    </div>
</div>
<script>
    var _SELECT_CATEGORY_URL = '{{ url('quiz/selectCategory') }}';
    var _WAITING_URL = '{{ url('quiz/waiting') }}';
    var _QUIZ_DOING_URL = '{{ url('quiz/do') }}';
    var _QUIZ_WINNER_URL = '{{ url('quiz/winner') }}';
    var _QUIZ_LOOSER_URL = '{{ url('quiz/looser') }}';
    var _SOCKET = io('{{ websocketURL }}');
</script>

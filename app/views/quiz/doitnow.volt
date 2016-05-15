<div id="content">
    <div class="ui middle aligned center aligned grid">
        <div class="column">
            <div class="ui segment" style="min-height: 100px">
                <div class="ui inverted dimmer" id="loading-wrapper">
                    <div class="ui text loader">{{ t('LOADING') }}</div>
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
                        <button class="ui fluid large red submit button fa request">{{ t('SELECT_CATEGORY_AND_START_THE_GAME') }}</button>
                    </form>
                </div>
                <div id="waiting" class="invisible no-take-place">
                    <p>YOU</p>
                    <p>VS</p>
                    <p id="opponent_name"></p>
                </div>
                <div id="game" class="invisible no-take-place">
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
                <div id="result" class="invisible no-take-place">
                    <p class="show-result"></p>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var _SOCKET = io('{{ websocketURL }}');
    var _WAIT_INTERVAL = {{ waitInterval }};
</script>

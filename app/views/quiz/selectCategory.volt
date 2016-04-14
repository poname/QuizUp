<div class="ui middle aligned center aligned grid">
    <div class="column">
        <div class="ui segment">
            <form class="ui large form" action="{{ url('quiz/selectCategory') }}" method="post">
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
                <div class="ui fluid large red submit button fa">{{ t('SELECT_CATEGORY_AND_START_THE_GAME') }}</div>
            </form>
        </div>
    </div>
</div>
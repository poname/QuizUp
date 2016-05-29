<div id="header">
    {% include "include/header.volt" %}
</div>

<div class="ui fluid aligned center aligned grid">
    <div class="column myTop">
        <h2 class="ui red image header">
            <img src="{{ url('img/logo.png') }}" class="image">
            <div class="content">
                {{ t('CREATE_QUESTION') }}
            </div>
        </h2>
        <form class="ui large form" action="{{ url('question/create') }}" method="post">
            {{ flashSession.output() }}
            <div class="ui stacked segment">
                <div class="field">
                    <label>{{ t('CATEGORY') }}</label>
                    <select style="padding-top: 2px" name="cid" class="ui fluid dropdown">
                        {% for category in categories %}
                            <option value="{{ category.cid }}">{{ t(category.name) }}</option>
                        {% endfor %}
                    </select>
                </div>
                <div class="field">
                    <label>{{ t('DESCRIPTION') }}</label>
                    <textarea name="description" rows="3"></textarea>
                </div>
                <div class="field">
                    <label>{{ t('FIRST_CHOICE') }}</label>
                    <input name="ans1" type="text">
                </div>
                <div class="field">
                    <label>{{ t('SECOND_CHOICE') }}</label>
                    <input name="ans2" type="text">
                </div>
                <div class="field">
                    <label>{{ t('THIRD_CHOICE') }}</label>
                    <input name="ans3" type="text">
                </div>
                <div class="field">
                    <label>{{ t('FOURTH_CHOICE') }}</label>
                    <input name="ans4" type="text">
                </div>
                <div class="grouped fields">
                    <label for="fruit">{{ t('CORRECT_CHOICE') }}</label>
                    <div class="field">
                        <div class="ui radio checkbox">
                            <input type="radio" name="correct" value="1" tabindex="0" checked="checked">
                            <label>1</label>
                        </div>
                    </div>
                    <div class="field">
                        <div class="ui radio checkbox">
                            <input type="radio" name="correct" value="2" tabindex="0">
                            <label>2</label>
                        </div>
                    </div>
                    <div class="field">
                        <div class="ui radio checkbox">
                            <input type="radio" name="correct" value="3" tabindex="0">
                            <label>3</label>
                        </div>
                    </div>
                    <div class="field">
                        <div class="ui radio checkbox">
                            <input type="radio" name="correct" value="4" tabindex="0">
                            <label>4</label>
                        </div>
                    </div>
                </div>
                <div class="buttons ">
                    <div class="ui fluid large red submit button"><p>{{ t('ADD') }}</p></div>
                    <a class="ui fluid large green button" href="{{ url('question/list') }}"><p>{{ t('QUESTIONS') }}</p></a>
                </div>
            </div>

            <div class="ui error message"></div>

        </form>

    </div>
</div>
<script>
    $(document)
            .ready(function () {
                $('.ui.form')
                        .form({
                            fields: {
                                email: {
                                    identifier: 'name',
                                    rules: [
                                        {
                                            type: 'empty',
                                            prompt: 'Please enter name'
                                        }
                                    ]
                                }
                            }
                        })
                ;
            })
    ;
</script>

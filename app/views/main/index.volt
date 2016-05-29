<div class="ui stripe community vertical segment">
    <div class="ui two column center aligned divided very relaxed stackable grid container">
        <div class="row">
            <div class="column">
                <div class="ui piled segment" style="margin-top: 70px">
                    <h2 class="ui icon header">
                        <p>{{ t('WHAT_IS_QUIZUP') }}</p>
                    </h2>
                    <p>{{ t('ABOUT_QUIZUP') }}</p>
                    <p>:))))</p>
                    <h3><p>{{ t('ABOUT_QUIZUP_2') }}</p></h3>
                    <h3><p>{{ t('ABOUT_QUIZUP_3') }}</p></h3>
                    <h3><p>{{ t('ABOUT_QUIZUP_4') }}</p></h3>
                    <a class="ui red large basic button button" style="margin-top: 20px" href="{{ url('login') }}"><p>{{ t('ENTER_GAME') }}</p></a>
                </div>
                <!--
                <div class="ui piled segment">
                    <h2 class="ui icon header">
                        <p>{{ t('MANAGE_CATEGORY') }}</p>
                    </h2>
                    <p></p>
                    <a class="ui violet large basic button button" href="{{ url('category/create') }}"><p>{{ t('CREATE_CATEGORY') }}</p></a>
                    <a class="ui green large basic button button" href="{{ url('category/list') }}"><p>{{ t('CATEGORIES') }}</p></a>
                </div>
                <div class="ui piled segment">
                    <h2 class="ui icon header">
                        <p>{{ t('MANAGE_QUESTIONS') }}</p>
                    </h2>
                    <p></p>
                    <a class="ui pink large basic button button" href="{{ url('question/create') }}"><p>{{ t('CREATE_QUESTION') }}</p></a>
                    <a class="ui brown large basic button button" href="{{ url('question/list') }}"><p>{{ t('QUESTIONS') }}</p></a>
                </div>
                -->
            </div>
            <div class="column">
                <div class="ui middle aligned center aligned grid">
                    <div class="column">
                        <h2 class="ui red image header">
                            <img src="{{ url('img/logo.png') }}" class="image">
                            <div class="content">
                                {{ t('SIGNUP_AN_ACCOUNT') }}
                            </div>
                        </h2>
                        <form class="ui large form" action="{{ url('signup/do') }}" method="POST">
                            {{ flashSession.output() }}
                            <div class="ui stacked segment">
                                <div class="field">
                                    <div class="ui left icon input">
                                        <i class="user icon"></i>
                                        <input type="text" name="name" placeholder="{{ t('NAME') }}">
                                    </div>
                                </div>
                                <div class="field">
                                    <div class="ui left icon input">
                                        <i class="user icon"></i>
                                        <input type="text" name="family" placeholder="{{ t('FAMILY_NAME') }}">
                                    </div>
                                </div>
                                <div class="field">
                                    <div class="ui left icon input">
                                        <i class="user icon"></i>
                                        <input type="text" name="email" placeholder="{{ t('EMAIL') }}">
                                    </div>
                                </div>
                                <div class="field">
                                    <div class="ui left icon input">
                                        <i class="lock icon"></i>
                                        <input type="password" name="password" placeholder="{{ t('PASSWORD') }}">
                                    </div>
                                </div>
                                <div class="field">
                                    <div class="ui left icon input">
                                        <i class="lock icon"></i>
                                        <input type="password" name="password_repeat" placeholder="{{ t('REPEAT_PASSWORD') }}">
                                    </div>
                                </div>
                                <div class="field">
                                    <label>
                                        {{ t('COUNTRY') }}
                                    </label>
                                    <div class="ui left icon input">
                                        <i class="lock icon"></i>
                                        <select style="padding-top: 2px" name="cid" class="ui fluid dropdown">
                                            {% for country in countries %}
                                                <option value="{{ country.cid }}">{{ t(country.name) }}</option>
                                            {% endfor %}
                                        </select>
                                    </div>
                                </div>
                                <div class="field">
                                    <label>
                                        {{ t('GENDER') }}
                                    </label>
                                    <div class="ui left icon input">
                                        <i class="lock icon"></i>
                                        <select style="padding-top: 2px" name="gender" class="ui fluid dropdown">
                                            <option value="MALE">{{ t('MALE') }}</option>
                                            <option value="FEMALE">{{ t('FEMALE') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="ui fluid large red submit button"><p>{{ t('SIGNUP') }}</p></div>
                            </div>
                            <div class="ui error message"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
       <div id="footer">
           {% include "include/footer.volt" %}
       </div>
    </div>
</div>




    <script type="text/javascript">
        $(".bg").interactive_bg();
    </script>


<script>
    $(document)
            .ready(function () {
                $('.ui.form')
                        .form({
                            fields: {
                                email: {
                                    identifier: 'email',
                                    rules: [
                                        {
                                            type: 'empty',
                                            prompt: "{{ t('ENTER_VALID_EMAIL') }}"
                                        },
                                        {
                                            type: 'email',
                                            prompt: 'Please enter a valid e-mail'
                                        }
                                    ]
                                },
                                password: {
                                    identifier: 'password',
                                    rules: [
                                        {
                                            type: 'empty',
                                            prompt: 'Please enter your password'
                                        },
                                        {
                                            type: 'length[6]',
                                            prompt: 'Your password must be at least 6 characters'
                                        }
                                    ]
                                },
                                password_repeat: {
                                    identifier: 'password_repeat',
                                    rules: [
                                        {
                                            type: 'match[password]',
                                            prompt: "{{ t('PASSWORD_AND_REPEAT_SHOULD_MATCH') }}"
                                        }
                                    ]
                                }
                            }
                        })
                ;
            })
    ;
</script>
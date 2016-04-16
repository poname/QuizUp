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

<div id="footer">
    {% include "include/footer.volt" %}
</div>

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

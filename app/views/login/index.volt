<div class="ui middle aligned center aligned grid">
    <div class="column">
        <h2 class="ui red image header">
            <img src="{{ url('img/logo.png') }}" class="image">
            <div class="content">
                {{ t('LOGIN_TO_ACCOUNT') }}
            </div>
        </h2>
        <form class="ui large form" action="{{ url('login/do') }}" method="post">
            {{ flashSession.output() }}
            <div class="ui stacked segment">
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
                <div class="ui fluid large red submit button"><p>{{ t('LOGIN') }}</p></div>
            </div>

            <div class="ui error message"></div>

        </form>

        <div class="ui message">
            {{ t('NEW_TO_US') }}<a href="{{ url('signup/') }}"> {{ t('SIGNUP') }}</a>
        </div>
    </div>
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
                                            prompt: 'Please enter your e-mail'
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
                                }
                            }
                        })
                ;
            })
    ;
</script>

<div class="ui middle aligned center aligned grid">
    <div class="column">
        <div class="ui message positive">
            {{ t('LOGIN_SUCCESS_MESSAGE') }}
        </div>
        <div class="ui message">
            <a href="{{ url('login/logout') }}">{{ t('LOGOUT') }}</a>
        </div>
    </div>
</div>
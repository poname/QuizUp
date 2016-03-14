<div class="ui middle aligned center aligned grid">
    <div class="column">
        <div class="ui message positive">
            {{ t('LOGIN_SUCCESS_MESSAGE') }}
        </div>
        <div class="ui message">
            <a href="{{ url('login/logout') }}">{{ t('LOGOUT') }}</a>
        </div>
        <div class="ui message negative">
            <a href="{{ url('category/add') }}">{{ t('CREATE_CATEGORY') }}</a>
        </div>
    </div>
</div>
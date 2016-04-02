<div class="menu">
    <div class="pusher">
        <div class="full height">
            <div class="toc">

            </div>
            <div class="article">
                <div class="ui main container">

                </div>
            </div>
        </div>
    </div>

</div>

<div class="ui grid container">
    <div class="four wide column">
        <div class="ui vertical inverted menu">
            <div class="item">
                <div class="header">{{ t('CATEGORIES') }}</div>
                <div class="menu">
                    <a href="/category/create" class="item">{{ t('CREATE') }}</a>
                    <a href="/category/list" class="item">{{ t('LIST') }}</a>
                </div>
            </div>
            <div class="item">
                <div class="header">{{ t('QUESTIONS') }}</div>
                <div class="menu">
                    <a href="/question/create" class="item">{{ t('CREATE') }}</a>
                    <a href="/question/list" class="item">{{ t('LIST') }}</a>
                </div>
            </div>
        </div>
    </div>
    <div class="eight wide column">
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
                <div class="ui message negative">
                    <a href="{{ url('category/list') }}">{{ t('CATEGORIES') }}</a>
                </div>
                <div class="ui message">
                    <a href="{{ url('question/create') }}">{{ t('CREATE_QUESTION') }}</a>
                </div>
                <div class="ui message">
                    <a href="{{ url('question/list') }}">{{ t('QUESTIONS') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>


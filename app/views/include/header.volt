<div class="ui red inverted menu" style="background-color: #FF5252">
    <div class="item">
        <img src="/img/logo.png">
        {{t('SITE_MAIN_TITLE')}}
    </div>

    <div class="item">

        <a class="ui icon button" href="/main/index"><i class="home icon"></i>{{t('HOME')}}</a>
    </div>

    <div class="item">
        <a>{{ t('YOUR_SCORE') }} : {{ session.get('user').getPoints() }}</a>
    </div>

    <div class="right item">
        <div class="right ui simple dropdown item">
            <i class="user icon"></i>
            {#<span class="text">{{ full_name }}</span>#}
            <i class="dropdown icon"></i>
            <div class="menu">
                <a class="item" href="{{ url('quiz/selectCategory') }}">{{ t('START') }}</a>
                <a class="item" href="{{ url('category/list') }}">{{ t('CATEGORIES') }}</a>
                <a class="item" href="{{ url('question/list') }}">{{ t('QUESTIONS') }}</a>
                <a class="item" href="{{ url('category/create') }}">{{ t('CREATE_CATEGORY') }}</a>
                <a class="item" href="{{ url('question/create  ') }}">{{ t('CREATE_QUESTION') }}</a>
                <a class="item" href="{{ url('login/logout') }}"><i class="sign out icon"></i>{{ t('LOGOUT') }}</a>
            </div>
        </div>
    </div>
</div>
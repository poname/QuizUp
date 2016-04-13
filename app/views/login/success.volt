<div class="ui red inverted menu">
    <div class="item">
        <img src="/img/logo.png">
        کوییز آپ
    </div>

    <div class="item">

        <a class="ui icon button" href="/main/index"><i class="home icon"></i>خانه</a>
    </div>

    <div class="right item">
        <div class="right ui simple dropdown item">
            <i class="user icon"></i>
            {#<span class="text">{{ full_name }}</span>#}
            <i class="dropdown icon"></i>
            <div class="menu">
                <a class="item" href="/category/list">{{ t('CATEGORIES') }}</a>
                <a class="item" href="/question/list">{{ t('QUESTIONS') }}</a>
                <a class="item" href="/category/create">{{ t('CREATE_CATEGORY') }}</a>
                <a class="item" href="/question/create">{{ t('CREATE_QUESTION') }}</a>

                <a class="item" href="{{ url('login/logout') }}"><i class="sign out icon"></i>{{ t('LOGOUT') }}</a>
            </div>
        </div>
    </div>
</div>


<div class="ui stripe community vertical segment"><a class="item">
</a>
    <div class="ui red two column center aligned divided very relaxed stackable grid container">
        <div class="row">
            <div class="column"><a class="item">
            </a>
                <div class="ui red segment">
                    <h2 class="ui icon header fa">{{ t('READY_TO_START?') }}</h2>
                    <p>{{ t('START_A_QUIZ_NOW') }}</p>
                    <div class="ui divider"></div>
                    <a class="ui red button fa" href="{{ url('quiz/start') }}">{{ t('START') }}</a>
                </div>
                <div class="ui segment">
                    <h2 class="ui icon header">
                        <p>مدیریت دسته بندی ها</p>
                    </h2>
                    <p></p>
                    <a class="ui violet large basic button button" href="/category/create"><p>ایجاد دسته بندی جدید</p>
                    </a>
                    <a class="ui green large basic button button" href="/category/list"><p>دسته بندی ها</p></a>
                </div>
                <div class="ui segment">
                    <h2 class="ui icon header">
                        <p>مدیریت سوالات</p>
                    </h2>
                    <p></p>
                    <a class="ui pink large basic button button" href="/question/create"><p>ایجاد سوال جدید</p></a>
                    <a class="ui brown large basic button button" href="/question/list"><p>سوالات</p></a>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="ui vertical footer segment">
                <div class="ui horizontal small divided link list">
                    <a class="item" href="#">ارتباط با ما</a>
                    <a class="item" href="#"><p>درباره ما</p></a>
                    <a class="item" href="#"><p>قوانین استفاده</p></a>
                    <a class="item" href="#"><p>سیاست حفظ اطلاعات</p></a>
                </div>
            </div>
        </div>
    </div>


</div>
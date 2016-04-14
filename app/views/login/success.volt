<div id="header">
    {% include "include/header.volt" %}
</div>

<div class="ui stripe community vertical segment"><a class="item"></a>
    <div class="ui red two column center aligned divided very relaxed stackable grid container">
        <div class="row">
            <div class="column"><a class="item">
            </a>
                <div class="ui red segment">
                    <h2 class="ui icon header fa">{{ t('READY_TO_START?') }}</h2>
                    <p>{{ t('START_A_QUIZ_NOW') }}</p>
                    <div class="ui divider"></div>
                    <a class="ui red button fa" href="{{ url('quiz/selectCategory') }}">{{ t('START') }}</a>
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
    </div>
</div>

<div id="footer">
    {% include "include/footer.volt" %}
</div>
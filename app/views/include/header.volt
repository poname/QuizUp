<div class="ui fixed inverted menu" style="background-color: #FF5252">
    <div class="ui container">
        <a class="item" style="margin-right:30%">
            <img src="{{ url('img/logo.png') }}">
                 <a style="color: rgba(255,255,255,.9)">{{t('SITE_MAIN_TITLE')}}</a>
        </a>


         <a href="{{ url('login/success') }}" class="item" style="background-color: #FF5252 "><i class="home icon"></i>
            <a style="color: rgba(255,255,255,.9)">{{t('HOME')}}</a>
         </a>



        <a class="item">
            <a style="color: rgba(255,255,255,.9)">{{ t('YOUR_SCORE') }} : {{ session.get('user').getPoints() }}</a>
        </a>


        <div class="right ui simple dropdown item"><i class="alarm icon"></i>
            <div class="menu">
                <a class="item">achieved : {{ achievements }}</a>
            </div>
        </div>

        <a class="item" href="{{ url('category/list') }}" style="background-color: #FF5252"> <a style="color: rgba(255,255,255,.9)"><i class="list icon"></i>
            {{ t('CATEGORIES') }}</a>
        </a>

        <div class="right ui simple dropdown item">
            <i class="user icon"></i>
            <span class="text">{{session.get('user').getName() }}</span>
            <i class="dropdown icon"></i>
            <div class="menu" style="background-color: rgba(0,0,0,.87)">
                <a class="item" href="{{ url('quiz/doitnow') }}">{{ t('START') }}</a>

                <a class="item" href="{{ url('question/list') }}"><a style="color: rgba(255,255,255,.9)">{{ t('QUESTIONS') }}</a></a>
                <a class="item" href="{{ url('category/create') }}"><a style="color: rgba(255,255,255,.9)">{{ t('CREATE_CATEGORY') }}</a></a>
                <a class="item" href="{{ url('question/create') }}"><a style="color: rgba(255,255,255,.9)">{{ t('CREATE_QUESTION') }}</a></a>
                <a class="item" href="{{ url('ranking/index') }}"><a style="color: rgba(255,255,255,.9)">{{ t('SEE_BEST_RANKINGS') }}</a></a>
                <a class="item" href="{{ url('login/logout') }}"><a style="color: rgba(255,255,255,.9)"><i class="sign out icon"></i>{{ t('LOGOUT') }}</a></a>
            </div>
        </div>



    </div>

</div>
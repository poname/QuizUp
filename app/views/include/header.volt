<div class="ui inverted menu" style="background-color: #FF5252">
    <div class="ui container">
        <div class="item" style="margin-right:30%">
            <img src="{{ url('img/logo.png') }}">
                 <a style="color: rgba(255,255,255,.9);line-height: 3.5">{{t('SITE_MAIN_TITLE')}}</a>
        </div>


         <div href="{{ url('login/success') }}" class="item" style="background-color: #FF5252 ;line-height: 3.5"><i class="home icon"></i>
            <a style="color: rgba(255,255,255,.9)">{{t('HOME')}}</a>
         </div>



        <div class="item">
            <a style="color: rgba(255,255,255,.9);line-height: 3.5">{{ t('YOUR_SCORE') }} : {{ session.get('user').getPoints() }}</a>
        </div>


        <div class="right ui simple dropdown item"><i class="alarm icon"></i>
            <div class="menu">
                <a class="item">achieved : {{ achievements }}</a>
            </div>
        </div>

        <div class="item" href="{{ url('category/list') }}" style="background-color: #FF5252"> <a style="color: rgba(255,255,255,.9);
  line-height: 3.5"><i class="list icon"></i>
            {{ t('CATEGORIES') }}</a></a>
        </div>

        <div class="right ui simple dropdown item">
            <i class="user icon"></i>
            <span class="text">{{session.get('user').getName() }}</span>
            <i class="dropdown icon"></i>
            <div class="menu" style="background-color: rgba(0,0,0,.87)">
                <div class="item"><a href="{{ url('quiz/doitnow') }} style="color: rgba(255,255,255,.9)">{{ t('START') }}</a></a>

                <div class="item" ><a href="{{ url('question/list') }}" style="color: rgba(255,255,255,.9)">{{ t('QUESTIONS') }}</a></div>
                <div class="item" ><a href="{{ url('category/create') }}" style="color: rgba(255,255,255,.9)">{{ t('CREATE_CATEGORY') }}</a></div>
                <div class="item"><a href="{{ url('question/create') }}" style="color: rgba(255,255,255,.9)">{{ t('CREATE_QUESTION') }}</a></div>
                <div class="item"><a href="{{ url('ranking/index') }}" style="color: rgba(255,255,255,.9)">{{ t('SEE_BEST_RANKINGS') }}</a></div>
                <div class="item" ><a href="{{ url('login/logout') }}" style="color: rgba(255,255,255,.9)"><i class="sign out icon"></i>{{ t('LOGOUT') }}</a></div>
            </div>
        </div>



    </div>

</div>
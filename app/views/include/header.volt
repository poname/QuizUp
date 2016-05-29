<div class="ui inverted menu" style="background-color: #FF5252">
    <div class="ui container">
        <div class="item" style="margin-right:10%">
            <img src="{{ url('img/logo.png') }}">
                 <a style="color: rgba(255,255,255,.9);line-height: 3.5">{{t('SITE_MAIN_TITLE')}}</a>
        </div>


         <div  class="item" style="background-color: #FF5252 "><i class="home icon"></i>
            <a href="{{ url('login/success') }}" style="color: rgba(255,255,255,.9) ;line-height: 3.5">{{t('HOME')}}</a>
         </div>



        <div class="item">
            <a style="color: rgba(255,255,255,.9);line-height: 3.5">{{ t('YOUR_SCORE') }} : {{ session.get('user').getPoints() }}</a>
        </div>

        <div class="item" style="background-color: #FF5252"> <a href="{{ url('category/list') }}"; style="color: rgba(255,255,255,.9);
  line-height: 3.5"><i class="list icon"></i>
            {{ t('CATEGORIES') }}</a></a>
        </div>

        <div class=" ui simple dropdown item" style="margin-right:20%"><i class="alarm icon"></i>
                     <span class="text">{{t('NOTIFICATIONS') }}</span>
                     <i class="dropdown icon"></i>
                    <div class="menu" style="background-color: rgba(0,0,0,.87)">

                        {% for achiv in achives %}
                            {% if(achiv == "tenQuiz") %}
                                <div class="item">
                                    <a href="#" style="color: rgba(255,255,255,.9)">{{ t('TEN_QUIZES') }}</a>
                                </div>
                            {% endif %}
                            {% if(achiv == 'iranian') %}
                                <div class="item">
                                    <a href="#" style="color: rgba(255,255,255,.9)">{{ t('IRANIAN') }}</a>
                                </div>
                        {#    {% else %}
                                <div class="item">
                                    <a href="#" style="color: rgba(255,255,255,.9)">{{ achiv }}</a>
                                </div>
                        #}
                            {% endif %}
                            {% if(achiv == "first") %}
                                <div class="item">
                                    <a href="#" style="color: rgba(255,255,255,.9)">{{ t('FIRST_PLACE') }}</a>
                                </div>
                            {% endif %}
                            {% if(achiv == "second") %}
                                <div class="item">
                                    <a href="#" style="color: rgba(255,255,255,.9)">{{ t('SECOND_PLACE') }}</a>
                                </div>
                            {% endif %}
                            {% if(achiv == "third") %}
                                <div class="item">
                                    <a href="#" style="color: rgba(255,255,255,.9)">{{ t('THIRD_PLACE') }}</a>
                                </div>
                            {% endif %}
                        {% endfor %}
                    </div>
                </div>

        <div class="ui simple dropdown item">
            <i class="user icon"></i>
            <span class="text">{{session.get('user').getName() }}</span>
            <i class="dropdown icon"></i>
            <div class="menu" style="background-color: rgba(0,0,0,.87)">
                <div class="item"><a href="{{ url('quiz/doitnow') }}" style="color: rgba(255,255,255,.9)">{{ t('START') }}</a></div>

                <div class="item" ><a href="{{ url('question/list') }}" style="color: rgba(255,255,255,.9)">{{ t('QUESTIONS') }}</a></div>
                <div class="item" ><a href="{{ url('category/create') }}" style="color: rgba(255,255,255,.9)">{{ t('CREATE_CATEGORY') }}</a></div>
                <div class="item"><a href="{{ url('question/create') }}" style="color: rgba(255,255,255,.9)">{{ t('CREATE_QUESTION') }}</a></div>
                <div class="item"><a href="{{ url('ranking/index') }}" style="color: rgba(255,255,255,.9)">{{ t('SEE_BEST_RANKINGS') }}</a></div>
                <div class="item" ><a href="{{ url('login/logout') }}" style="color: rgba(255,255,255,.9)"><i class="sign out icon"></i>{{ t('LOGOUT') }}</a></div>
            </div>
        </div>



    </div>

</div>
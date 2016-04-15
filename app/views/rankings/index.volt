<div class="ui red inverted menu">
    <div class="item">
        <img src="/img/logo.png">
{{t('SITE_MAIN_TITLE')}}
    </div>
	 <div class="item">

        <a class="ui icon button" href="/main/index"><i class="home icon"></i>{{t('HOME')}}</a>
    </div>

    <div class="right item">
        <div class="right ui simple dropdown item">
            <i class="user icon"></i>
            {#<span class="text">{{ full_name }}</span>#}
            <i class="dropdown icon"></i>
            <div class="menu">
             <a class="item" href="{{ url('quiz/selectCategory') }}">{{ t('START') }}</a>
                <a class="item" href="/category/list">{{ t('CATEGORIES') }}</a>
                <a class="item" href="/question/list">{{ t('QUESTIONS') }}</a>
                <a class="item" href="/category/create">{{ t('CREATE_CATEGORY') }}</a>
                <a class="item" href="/question/create">{{ t('CREATE_QUESTION') }}</a>

                <a class="item" href="{{ url('login/logout') }}"><i class="sign out icon"></i>{{ t('LOGOUT') }}</a>
            </div>
        </div>
    </div>
</div>
	<div>
	<table class="ui inverted blue table">
  <thead>
    <tr><th>{{t('NAME')}}</th>
    <th>{{t('FAMILY_NAME')}}</th>
    <th>{{t('POINT')}}</th>
  </tr></thead><tbody>
 {% for user in rankings %}
    <tr>
      <td>{{ user.name }}</td>
      <td>{{ user.family }}</td>
      <td>{{ user.points }}</td>
    </tr>

	<tr>
	<button class="fluid ui red button" id='hide' href="{{ url('rankings/more') }}>{{t('MORE')}}</button>
	</tr>
  </tbody>
 
  
  </div>
</table>

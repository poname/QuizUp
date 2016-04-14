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
    <tr>
      <td>حسن</td>
      <td>حسینی</td>
      <td>6000</td>
    </tr>
    <tr>
      <td>اصغر</td>
      <td>حبیبی</td>
      <td>5600</td>
    </tr>
	<tr>
      <td>فرهاد</td>
      <td>مجیدی</td>
      <td>5200</td>
    </tr>
	<tr>
      <td>زهرا</td>
      <td>ملکشاهی</td>
      <td>4700</td>
    </tr>
	<tr id='show'>
      <td>فرناز</td>
      <td>الوندی</td>
      <td>4100</td>
    </tr>
	<tr id='show'>
      <td>سحر</td>
      <td>بزرگمهر</td>
      <td>3900</td>
    </tr>
	<tr id='show'>
      <td>علی</td>
      <td>صداقت</td>
      <td>3700</td>
    </tr>
	<tr id='show'>
      <td>سعید</td>
      <td>فاطمی</td>
      <td>3400</td>
    </tr>
	<tr id='show'>
      <td>محمد</td>
      <td>جلالی</td>
      <td>3000</td>
    </tr>
	<tr>
	<button class="fluid ui red button" id='hide'>{{t('MORE')}}</button>
	</tr>
  </tbody>
 
  
  </div>
</table>
<script>
    $(document)
            .ready(function (){
    $("#show").hide();

    $("button").click(function(){
        $("#show").show();
		 $("#hide").hide();
    });
});
</script>
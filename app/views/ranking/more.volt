<div id="header">
    {% include "include/header.volt" %}
</div>
	<div>
	<table class="ui inverted blue table">
  <thead>
    <tr><th>{{t('NAME')}}</th>
    <th>{{t('FAMILY_NAME')}}</th>
    <th>{{t('POINTS')}}</th>
  </tr></thead><tbody>
 {% for user in rankings %}
    <tr>
      <td>{{ user.name }}</td>
      <td>{{ user.family }}</td>
      <td>{{ user.points }}</td>
    </tr>
  {% endfor %}
  </tbody>


  </div>
</table>
<div class="ui middle aligned center">
    {{ flashSession.output() }}
<table class="ui celled table">
    <thead>
    <tr>
        <th>{{ t('CATEGORY_NAME') }}</th>
        <th>Edit</th>
        <th>Delete</th>
    </tr>
    </thead>
    <tbody>
    {% for item in categories %}
    <tr>
        <td>{{ item.name }}</td>
        <td class="selectable positive">
            <a href="./edit?id={{ item.cid }}">{{ t('EDIT') }}</a>
        </td>
        <td class="selectable negative">
            <a href="./delete?id={{ item.cid }}">{{ t('DELETE') }}</a>
        </td>
    </tr>
    {% endfor %}
    </tbody>
</table>
    </div>
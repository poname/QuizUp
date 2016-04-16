<div id="header">
    {% include "include/header.volt" %}
</div>

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
                <td id="{{ 'C' ~ item.cid }}">{{ item.name }}</td>
                 <td class="selectable positive"  onclick="editAction({{ item.cid }})">
                     <!-- <a href="./edit?id={{ item.cid }}">{{ t('EDIT') }}</a> -->
                     <a href="javascript:void(0)">{{ t('EDIT') }}</a>
                 </td>
                 <td class="selectable negative" onclick="deleteAction({{ item.cid }})">
                    <!-- <a href="./delete?id={{ item.cid }}">{{ t('DELETE') }}</a> -->
                     <a href="javascript:void(0)">{{ t('DELETE') }}</a>
                 </td>
            </tr>
        {% endfor %}
        </tbody>
    </table>
    <div id="footer">
        {% include "include/footer.volt" %}
    </div>
</div>

<div id="deleteModal" class="ui modal">
    <i class="close icon"></i>

    <div class="content">

        <div class="description">
            <div class="ui header center aligned"><p>{{ t('DELETE_CONFIRM') }}</p></div>


        </div>
    </div>

    <div class="actions">
        <div class="two fluid ui inverted buttons">
            <div class="ui black deny button">
                <p> {{ t('NO') }}</p>
            </div>
            <div id="deleteConfirm" class="ui positive right labeled icon button" onclick="deleteConfirm()">
                <p>{{ t('YES') }}</p>
                <i class="checkmark icon"></i>
            </div>
        </div>
    </div>
</div>

<div id="editModal" class="ui modal" style="display: block !important; top: 2360px;">
    <i class="close icon"></i>
    <div class="header">
        <p>{{ t('EDIT_CATEGORY') }}</p>
    </div>
    <div class="content">
        <div id="editForm" class="ui form">
            <div class="field">
                <label>{{ t('CATEGORY_NAME') }}</label>
                <input id="subject" type="text">
            </div>
        </div>
    </div>
    <div class="actions">
        <div class="ui deny button"><p>{{ t('CANCEL') }}</p></div>
        <div class="ui green button" onclick="editConfirm()"><p>{{ t('SAVE') }}</p></div>
    </div>
</div>

<script src="{{ url('js/CategoryList.js') }}"></script>
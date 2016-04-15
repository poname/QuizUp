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
                <a class="item" href="/question/list">{{ t('QUESTIONS') }}</a>
                <a class="item" href="/category/create">{{ t('CREATE_CATEGORY') }}</a>
                <a class="item" href="/question/create">{{ t('CREATE_QUESTION') }}</a>

                <a class="item" href="{{ url('login/logout') }}"><i class="sign out icon"></i>{{ t('LOGOUT') }}</a>
            </div>
        </div>
    </div>
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

<script>
    var cursor = 0;
    function deleteAction(categoryId){
        $('#deleteModal').modal('show', categoryId);
        cursor = categoryId;
    }
    function deleteConfirm(){
        //window.location.replace("delete?id=" + cursor);

        var formData = {
            cid:cursor
        }; //Array

        $.ajax({
            url : "delete",
            type: "POST",
            data : formData,
            success: function(data, textStatus, jqXHR)
            {
                window.location.replace("list");
                //data - response from server
                //alert(data);
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                //window.location.replace("list");
                //alert('error')
            }
        });
    }

    function editAction(categoryId){
        //alert($('#Q' + id + 'C').text());
        $('#editModal').modal('show');
        cursor = categoryId;

        $("#subject").val($('#C' + categoryId).text());
    }

    function editConfirm(){
        //window.location.replace("delete?id=" + cursor);

        var formData = {
            cid:cursor,
            newName:$('#subject').val()
        }; //Array

        $.ajax({
            url : "edit",
            type: "POST",
            data : formData,
            success: function(data, textStatus, jqXHR)
            {
                window.location.replace("list");
                //data - response from server
                //alert(data);
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                //window.location.replace("list");
                //alert('error')
            }
        });
    }
</script>
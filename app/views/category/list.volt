<div class="ui middle aligned center">
    {{ flashSession.output() }}
    <table class="ui celled table">
        <thead>
        <tr>
            <th>{{ t('CATEGORY_NAME') }}</th>
            <th>{{ t('OPERATION') }}</th>
        </tr>
        </thead>
        <tbody>
        {% for item in categories %}
            <tr>
                <td id="{{ 'C' ~ item.cid }}">{{ item.name }}</td>
                <td class="collapsing">
                                <div class="ui vertical labeled icon buttons">
                                    <a id="deleteButton" class="ui red button" onclick="deleteAction({{ question.qid }})"> <!--href="question/delete?id={{ question.cid }}"-->
                                        <i class="delete icon"></i>
                                        <p>{{ t('DELETE') }}</p>

                                    </a>
                                    <a class="ui blue button" onclick="editAction({{ question.qid }})" ><!--href="question/edit?id={{ question.cid }}">-->
                                        <i class="edit icon"></i>
                                        <p>{{ t('EDIT') }}</p>
                                    </a>
                                </div>
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
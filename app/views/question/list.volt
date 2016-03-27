<div class="ui center floated">
    {{ flashSession.output() }}
    <table class="ui green celled table">
        <thead>
        <tr><th>{{ t('ID') }}</th>
            <th>{{ t('CATEGORY') }}</th>
            <th>{{ t('DESCRIPTION') }}</th>
            <th>{{ t('OPERATION') }}</th>
            <th>{{ t('CHOICES') }}</th>
            <th>{{ t('CORRECT_CHOICE') }}</th>
        </tr></thead>
        <tbody>
        {% for question in questions %}
        <tr>
            <td class="collapsing">
                <div class="ui black label">{{ question.qid }}</div>
            </td>
            <td class="collapsing">{{ question.cid }}</td>
            <td>{{ question.description }}</td>
            <td class="collapsing">
                <div class="ui vertical labeled icon buttons">
                    <a id="deleteButton" class="ui red button" onclick="deleteAction({{ question.qid }})"> <!--href="question/delete?id={{ question.cid }}"-->
                        <i class="delete icon"></i>
                        <p>{{ t('DELETE') }}</p>

                    </a>
                    <a class="ui blue button" href="question/edit?id={{ question.cid }}">
                        <i class="edit icon"></i>
                        <p>{{ t('EDIT') }}</p>
                    </a>
                </div>
            </td>
            <td>
                <div class="ui divided list">
                    <div class="item">
                        <div class="ui teal horizontal label">1</div>
                        {{ question.ans1 }}
                    </div>
                    <div class="item">
                        <div class="ui purple horizontal label">2</div>
                        {{ question.ans2 }}
                    </div>
                    <div class="item">
                        <div class="ui brown horizontal label">3</div>
                        {{ question.ans3 }}
                    </div>
                    <div class="item">
                        <div class="ui yellow horizontal label">4</div>
                        {{ question.ans4 }}
                    </div>
                </div>
            </td>
            <td class="collapsing">{{ question.correct }}</td>
        </tr>
        {% endfor %}
        </tbody>
        <tfoot>
        <tr><th colspan="6">
                <div class="ui right floated pagination menu">
                    <a class="icon item">
                        <i class="left chevron icon"></i>
                    </a>
                    <a class="item">1</a>
                    <a class="item">2</a>
                    <a class="item">3</a>
                    <a class="item">4</a>
                    <a class="icon item">
                        <i class="right chevron icon"></i>
                    </a>
                </div>
            </th>
        </tr></tfoot>
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

<script>
    var cursor = 0;
    function deleteAction(names){
        $('#deleteModal').modal('show', names);
        cursor = names;
    }
    function deleteConfirm(){
        window.location.replace("delete?id=" + cursor);
    }
</script>
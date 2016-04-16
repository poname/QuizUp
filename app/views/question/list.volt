<div id="header">
    {% include "include/header.volt" %}
</div>

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
        <tr id="{{ 'Q' ~ question.qid }}">
            <td class="collapsing">
                <div class="ui black label">{{ question.qid }}</div>
            </td>
            <td class="collapsing">{{ question.cid }}</td>
            <td id="{{ 'Q' ~ question.qid ~ 'D' }}">{{ question.description }}</td>
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
            <td>
                <div class="ui divided list">
                    <div class="item">
                        <div class="ui teal horizontal label">1</div>
                        <div id="{{ "Q" ~ question.qid  ~ "A1" }}">
                            {{ question.ans1 }}
                        </div>
                    </div>
                    <div class="item">
                        <div class="ui purple horizontal label">2</div>
                        <div id="{{ "Q" ~ question.qid  ~ "A2" }}">
                            {{ question.ans2 }}
                        </div>
                    </div>
                    <div class="item">
                        <div class="ui brown horizontal label">3</div>
                        <div id="{{ "Q" ~ question.qid  ~ "A3" }}">
                            {{ question.ans3 }}
                        </div>
                    </div>
                    <div class="item">
                        <div class="ui yellow horizontal label">4</div>
                        <div id="{{ "Q" ~ question.qid  ~ "A4" }}">
                            {{ question.ans4 }}
                        </div>
                    </div>
                </div>
            </td>
            <td id="{{ 'Q' ~ question.qid ~ 'C' }}" class="collapsing">{{ question.correct }}</td>
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

<div id="footer">
    {% include "include/footer.volt" %}
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
        <p>{{ t('EDIT_QUESTION') }}</p>
    </div>
    <div class="content">
        <div id="editForm" class="ui form">

            <div class="field">
                <label>{{ t('DESCRIPTION') }}</label>
                <textarea id="d" rows="3"></textarea>
            </div>
            <div class="field">
                <label>{{ t('FIRST_CHOICE') }}</label>
                <input id="a1" type="text">
            </div>
            <div class="field">
                <label>{{ t('SECOND_CHOICE') }}</label>
                <input id="a2" name="ans2" type="text">
            </div>
            <div class="field">
                <label>{{ t('THIRD_CHOICE') }}</label>
                <input id="a3" name="ans3" type="text">
            </div>
            <div class="field">
                <label>{{ t('FOURTH_CHOICE') }}</label>
                <input id="a4" name="ans4" type="text">
            </div>
            <div id="c" class="inline fields">
                <label for="fruit">{{ t('CORRECT_CHOICE') }}</label>
                <div class="field">
                    <div class="ui radio checkbox">
                        <input id="1" type="radio" name="correct" value="1" tabindex="0">
                        <label>1</label>
                    </div>
                </div>
                <div class="field">
                    <div class="ui radio checkbox">
                        <input id="2" type="radio" name="correct" value="2" tabindex="0">
                        <label>2</label>
                    </div>
                </div>
                <div class="field">
                    <div class="ui radio checkbox">
                        <input id="3" type="radio" name="correct" value="3" tabindex="0">
                        <label>3</label>
                    </div>
                </div>
                <div class="field">
                    <div class="ui radio checkbox">
                        <input id="4" type="radio" name="correct" value="4" tabindex="0">
                        <label>4</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="actions">
        <div class="ui deny button"><p>{{ t('CANCEL') }}</p></div>
        <div class="ui green button" onclick="editConfirm()"><p>{{ t('SAVE') }}</p></div>
    </div>
</div>

<script src="{{ url('js/QuestionList.js') }}"></script>
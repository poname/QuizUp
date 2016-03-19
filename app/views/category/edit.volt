<div class="ui middle aligned center aligned grid">
    <div class="column">
        <h2 class="ui red image header">
            <img src="{{ url('img/logo.png') }}" class="image">
            <div class="content">
                {{ t('EDIT_CATEGORY') }}
            </div>
        </h2>
        <form class="ui large form" action="{{ url('category/edit') }}" method="get">
            {{ flashSession.output() }}
            <div class="ui stacked segment">
                <div class="field">
                    <div class="ui large label">
                        {{ t('CATEGORY_NAME') }} : {{ catName }}
                    </div>
                </div>
                <div class="field">
                    <div class="ui left icon input">
                        <i class="user icon"></i>
                        <input type="text" name="newName" placeholder="{{ t('NEW_NAME') }}">
                    </div>
                </div>
                <div class="ui fluid large red submit button"><p>{{ t('SUBMIT') }}</p></div>
                <a class="ui fluid large green button" href="{{ url('category/list') }}"><p>{{ t('CATEGORIES') }}</p></a>
            </div>

            <div class="ui error message"></div>
            <div class="hidden">
                <input type="text" name="op" value="change">
                <input type="text" name="id" value="{{ catId }}">
            </div>
        </form>

    </div>
</div>
<script>
    $(document)
            .ready(function () {
                $('.ui.form')
                        .form({
                            fields: {
                                email: {
                                    identifier: 'newName',
                                    rules: [
                                        {
                                            type: 'empty',
                                            prompt: 'Please enter new name'
                                        }
                                    ]
                                }
                            }
                        })
                ;
            })
    ;
</script>

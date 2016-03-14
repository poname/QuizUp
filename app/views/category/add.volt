<div class="ui middle aligned center aligned grid">
    <div class="column">
        <h2 class="ui red image header">
            <img src="{{ url('img/logo.png') }}" class="image">
            <div class="content">
                {{ t('CREATE_CATEGORY') }}
            </div>
        </h2>
        <form class="ui large form" action="{{ url('category/create') }}" method="post">
            {{ flashSession.output() }}
            <div class="ui stacked segment">
                <div class="field">
                    <div class="ui left icon input">
                        <i class="user icon"></i>
                        <input type="text" name="name" placeholder="{{ t('CATEGORY_NAME') }}">
                    </div>
                </div>
                <div class="ui fluid large red submit button"><p>{{ t('ADD') }}</p></div>
            </div>

            <div class="ui error message"></div>

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
                                    identifier: 'name',
                                    rules: [
                                        {
                                            type: 'empty',
                                            prompt: 'Please enter name'
                                        }
                                    ]
                                }
                            }
                        })
                ;
            })
    ;
</script>

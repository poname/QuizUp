<div class="ui middle aligned center aligned grid">
    <div class="column">
        <h2 class="ui red image header">
            <img src="<?php echo $this->url->get('img/logo.png'); ?>" class="image">
            <div class="content">
                <?php echo $this->translator->_('LOGIN_TO_ACCOUNT'); ?>
            </div>
        </h2>
        <form class="ui large form" action="<?php echo $this->url->get('login/do'); ?>" method="post">
            <?php echo $this->flashSession->output(); ?>
            <div class="ui stacked segment">
                <div class="field">
                    <div class="ui left icon input">
                        <i class="user icon"></i>
                        <input type="text" name="email" placeholder="<?php echo $this->translator->_('EMAIL'); ?>">
                    </div>
                </div>
                <div class="field">
                    <div class="ui left icon input">
                        <i class="lock icon"></i>
                        <input type="password" name="password" placeholder="<?php echo $this->translator->_('PASSWORD'); ?>">
                    </div>
                </div>
                <div class="ui fluid large red submit button"><?php echo $this->translator->_('LOGIN'); ?></div>
            </div>

            <div class="ui error message"></div>

        </form>

        <div class="ui message">
            <?php echo $this->translator->_('NEW_TO_US'); ?><a href="<?php echo $this->url->get('signup/'); ?>"> <?php echo $this->translator->_('SIGNUP'); ?></a>
        </div>
    </div>
</div>
<script>
    $(document)
            .ready(function () {
                $('.ui.form')
                        .form({
                            fields: {
                                email: {
                                    identifier: 'email',
                                    rules: [
                                        {
                                            type: 'empty',
                                            prompt: 'Please enter your e-mail'
                                        },
                                        {
                                            type: 'email',
                                            prompt: 'Please enter a valid e-mail'
                                        }
                                    ]
                                },
                                password: {
                                    identifier: 'password',
                                    rules: [
                                        {
                                            type: 'empty',
                                            prompt: 'Please enter your password'
                                        },
                                        {
                                            type: 'length[6]',
                                            prompt: 'Your password must be at least 6 characters'
                                        }
                                    ]
                                }
                            }
                        })
                ;
            })
    ;
</script>

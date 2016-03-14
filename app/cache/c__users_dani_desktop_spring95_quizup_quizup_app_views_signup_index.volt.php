<div class="ui middle aligned center aligned grid">
    <div class="column">
        <h2 class="ui red image header">
            <img src="<?php echo $this->url->get('img/logo.png'); ?>" class="image">
            <div class="content">
                <?php echo $this->translator->_('SIGNUP_AN_ACCOUNT'); ?>
            </div>
        </h2>
        <form class="ui large form" action="<?php echo $this->url->get('signup/do'); ?>" method="POST">
            <?php echo $this->flashSession->output(); ?>
            <div class="ui stacked segment">
                <div class="field">
                    <div class="ui left icon input">
                        <i class="user icon"></i>
                        <input type="text" name="name" placeholder="<?php echo $this->translator->_('NAME'); ?>">
                    </div>
                </div>
                <div class="field">
                    <div class="ui left icon input">
                        <i class="user icon"></i>
                        <input type="text" name="family" placeholder="<?php echo $this->translator->_('FAMILY_NAME'); ?>">
                    </div>
                </div>
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
                <div class="field">
                    <div class="ui left icon input">
                        <i class="lock icon"></i>
                        <input type="password" name="password_repeat" placeholder="<?php echo $this->translator->_('REPEAT_PASSWORD'); ?>">
                    </div>
                </div>
                <div class="field">
                    <div class="ui left icon input">
                        <i class="lock icon"></i>
                        <select name="cid" class="ui fluid dropdown">
                            <?php foreach ($countries as $country) { ?>
                                <option value="<?php echo $country->cid; ?>"><?php echo $country->name; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="field">
                    <div class="ui left icon input">
                        <i class="lock icon"></i>
                        <select name="gender" class="ui fluid dropdown">
                            <option value="MALE">Male</option>
                            <option value="FEMALE">Female</option>
                        </select>
                    </div>
                </div>
                <div class="ui fluid large red submit button"><?php echo $this->translator->_('SIGNUP'); ?></div>
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
                                    identifier: 'email',
                                    rules: [
                                        {
                                            type: 'empty',
                                            prompt: "<?php echo $this->translator->_('ENTER_VALID_EMAIL'); ?>"
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
                                },
                                password_repeat: {
                                    identifier: 'password_repeat',
                                    rules: [
                                        {
                                            type: 'match[password]',
                                            prompt: "<?php echo $this->translator->_('PASSWORD_AND_REPEAT_SHOULD_MATCH'); ?>"
                                        }
                                    ]
                                }
                            }
                        })
                ;
            })
    ;
</script>

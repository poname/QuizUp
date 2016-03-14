<div class="ui middle aligned center aligned grid">
    <div class="column">
        <div class="ui message positive">
            <?php echo $this->translator->_('LOGIN_SUCCESS_MESSAGE'); ?>
        </div>
        <div class="ui message">
            <a href="<?php echo $this->url->get('login/logout'); ?>"><?php echo $this->translator->_('LOGOUT'); ?></a>
        </div>
        <div class="ui message negative">
            <a href="<?php echo $this->url->get('category/add'); ?>"><?php echo $this->translator->_('CREATE_CATEGORY'); ?></a>
        </div>
    </div>
</div>
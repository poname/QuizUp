<div class="ui red inverted menu" style="background-color: #FF5252">
    <div class="item">
        <img src="/img/logo.png">
        کوییز آپ
    </div>

    <div class="item">

        <a class="ui icon button" href="/main/index"><i class="home icon"></i>خانه</a>
    </div>

    <div class="right item">
        <div class="right ui simple dropdown item">
            <i class="user icon"></i>
            
            <i class="dropdown icon"></i>
            <div class="menu">
                <a class="item" href="<?php echo $this->url->get('category/list'); ?>"><?php echo $this->translator->_('CATEGORIES'); ?></a>
                <a class="item" href="<?php echo $this->url->get('question/list'); ?>"><?php echo $this->translator->_('QUESTIONS'); ?></a>
                <a class="item" href="<?php echo $this->url->get('category/create'); ?>"><?php echo $this->translator->_('CREATE_CATEGORY'); ?></a>
                <a class="item" href="<?php echo $this->url->get('question/create  '); ?>"><?php echo $this->translator->_('CREATE_QUESTION'); ?></a>
                <a class="item" href="<?php echo $this->url->get('login/logout'); ?>"><i class="sign out icon"></i><?php echo $this->translator->_('LOGOUT'); ?></a>
            </div>
        </div>
    </div>
</div>
<header class="bg-light">
  <nav class="navbar navbar-expand-lg navbar-light  container">
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item <?php if(currLoc() ==  route('main')){ echo 'active'; } ?>">
          <a class="nav-link" id="main_page" href="<?php echo  route('main') ?>"><?php echo __("main_title"); ?></a>
        </li>
        <li class="nav-item <?php if(currLoc() ==  route('/users')){ echo 'active'; } ?>">
          <a class="nav-link"  href="<?php echo route('/users') ?>">Пользователи</a>
        </li>
        <li class="nav-item <?php if(currLoc() == route('/phonebook')){ echo 'active'; } ?>">
          <a class="nav-link" id="phonebook_page" href="javascript:void(0);"><?php echo __("phonebook_title"); ?></a>
        </li>
        <?php if ($user = Auth()) { ?>
           <li class="nav-item <?php if(currLoc() == route('/contact')){ echo 'active'; } ?>">
            <a class="nav-link" id="mycontact_page" href="javascript:void(0);"><?php echo __("contact_title"); ?></a>
          </li>
        <?php } ?>
      </ul>
    </div>
    <div class="d-flex">
      <ul class="navbar-nav">
        <?php if (Auth()) { ?>
           <li class="nav-item <?php if(currLoc() == route('/logout')){ echo 'active'; } ?>">
            <a class="nav-link" href="<?php echo route('/logout') ?>"><?php echo __("logout_title"); ?></a>
          </li>
        <?php }else{ ?>
          <li class="nav-item <?php if(currLoc() == route('/login')){ echo 'active'; } ?>">
            <a class="nav-link" href="<?php echo route('/login') ?>"><?php echo __("login_title"); ?></a>
          </li>
          <li class="nav-item <?php if(currLoc() == route('/register')){ echo 'active'; } ?>">
            <a class="nav-link" href="<?php echo route('/register') ?>"><?php echo __("signin_title"); ?></a>
          </li> 
        <?php } ?>
      </ul>

       <?php app\components\widgets\Lang::widget(); ?> 
    </div>
  </nav>
</header>

<?php route('/users'); ?>
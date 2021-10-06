<header class="bg-light">
  <nav class="navbar navbar-expand-lg navbar-light  container">
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item <?php if(currLoc() == url('')){ echo 'active'; } ?>">
          <a class="nav-link" id="main_page" href="<?php echo url('') ?>"><?php echo __("main_title"); ?></a>
        </li>
        <li class="nav-item <?php if(currLoc() == url('phonebook')){ echo 'active'; } ?>">
          <a class="nav-link" id="phonebook_page" href="javascript:void(0);"><?php echo __("phonebook_title"); ?></a>
        </li>
        <?php if ($user = Auth()) { ?>
           <li class="nav-item <?php if(currLoc() == url('contact')){ echo 'active'; } ?>">
            <a class="nav-link" id="mycontact_page" href="javascript:void(0);"><?php echo __("contact_title"); ?></a>
          </li>
        <?php } ?>
      </ul>
    </div>
    <div class="d-flex">
      <ul class="navbar-nav">
        <?php if (Auth()) { ?>
           <li class="nav-item <?php if(currLoc() == url('logout')){ echo 'active'; } ?>">
            <a class="nav-link" href="<?php echo url('logout') ?>"><?php echo __("logout_title"); ?></a>
          </li>
        <?php }else{ ?>
          <li class="nav-item <?php if(currLoc() == url('login')){ echo 'active'; } ?>">
            <a class="nav-link" href="<?php echo url('login') ?>"><?php echo __("login_title"); ?></a>
          </li>
          <!-- <li class="nav-item <?php if(currLoc() == url('register')){ echo 'active'; } ?>">
            <a class="nav-link" href="<?php echo url('register') ?>"><?php echo __("signin_title"); ?></a>
          </li> -->
        <?php } ?>
      </ul>

       <?php framework\widgets\Lang::widget(); ?> 
    </div>
  </nav>
</header>
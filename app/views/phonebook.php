<h2><?php echo __("title"); ?></h2>
<?php if (!empty($contacts)) { ?>
  <div class="container-fluid">
    <?php foreach ($contacts as $key => $contact) { ?>
      <div class="contact_item row">
        <div class="col-md-4">
          <span><?php echo $key; ?>.</span>
          <span><?php echo $contact['name']; ?></span>
          <span>
            <?php if(!empty($contact['phones'])){
               echo $contact['phones'][0];
              }?>
          </span>
          <span class="hide_btn" data-hide-text='<?php echo __("hide_text"); ?>' data-show-text='<?php echo __("show_text"); ?>'><?php echo __("show_text"); ?></span>
        </div>  
        <div class="full_info col-md-12 d-none">
            <div class="col-md-4">
              <span>Address</span>
              <div>
                <?php echo $contact['address']; ?><br>
                <?php echo $contact['city']; ?><br>
                <?php echo $contact['country']; ?>
              </div>
             </div>
            <div class="col-md-4 phones">
              <span>Phone numbers</span>
              <div>
                <?php foreach ($contact['phones'] as $key => $phone) { ?>
                 <div> <?php echo $phone; ?></div>
                <?php } ?>
              </div>
            </div>
            <div class="col-md-4 emails">
              <span>Emails</span>
              <div>
                <?php foreach ($contact['emails'] as $key => $email) { ?>
                  <div> <?php echo $email; ?></div>
                <?php } ?>
              </div>
            </div>
        </div>


      </div>

    <?php } ?>
  </div>
<?php }else{ ?>

  <span>No contacts</span>

<?php } ?>

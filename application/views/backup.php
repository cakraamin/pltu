<div class="topcolumn">
            <div class="logo"></div>
                            <ul  id="shortcut">  
                                <?php $notif = $this->globals->notification($this->session->userdata('user_id')); ?>                                 
                            </ul>
          </div>           
          <div class="clear"></div> 
          <?php echo $this->message->display(); ?>
<div class="onecolumn" >
                    <div class="header">
                    <span ><span class="ico  gray spreadsheet"></span> Backup Database </span>
                    </div><!-- End header --> 
                    <div class=" clear"></div>
                    <div class="content" >                      
                    <a href="<?php echo base_url(); ?>backup/bekup" class="uibutton special">Backup Database</a>
          </div>
</div>
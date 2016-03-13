<div class="topcolumn">
            <div class="logo"></div>
                            <ul  id="shortcut">
                                <?php $notif = $this->globals->notification($this->session->userdata('user_id')); ?>
                                <li> <a href="<?php echo base_url(); ?><?php echo $back; ?>" title="Back To home"> <img src="<?=base_url()?>assets/template/fingers/images/icon/shortcut/home.png" alt="home" width="40px"/><strong>Daftar</strong> </a> </li>
                                <li> <a href="<?php echo base_url() ?>transaksi/import" title="Import Timbangan"> <img src="<?php echo base_url(); ?>assets/template/fingers/images/icon/shortcut/import.png" alt="import" width="40" /><strong>Import</strong></a></li>
                                <li> <a href="<?php echo base_url() ?>berita/unread/<?php echo $notif['detail']; ?>" title="Messages"> <img src="<?php echo base_url(); ?>assets/template/fingers/images/icon/shortcut/mail.png" alt="messages" /><strong>Message</strong></a><?php echo $notif['jml']; ?></li>
                            </ul>      
          </div>  
          <div class="clear"></div>          
                    <div class="clear"></div>
                        
                  <div class="onecolumn" >
                  <div class="header"><span ><span class="ico  gray user"></span><?php echo $ket;?></span> </div><!-- End header --> 
                  <div class="clear"></div>
                  <div class="content" >                      
                    <div class="tab_container" >

                          <div id="tab1" class="tab_content"> 
                              <div class="load_page">                        
                                 
                                <div class="formEl_b">  
                                <form id="validation" action="<?php echo base_url();?><?php echo $link;?>" method="POST" enctype="multipart/form-data"> 
                                <fieldset >
                                <legend><?php echo $ket;?> <span class="small s_color">( <?php echo $jenis;?> )</span></legend>                                                                
                                      <div class="section">
                                      <label> Jenis Limbah  <small>Jenis</small></label>
                                      <div> 
                                          <?
                                          $jsbrg = "  data-placeholder='Nama Barang...'' class='chzn-select' ";                                          
                                          echo form_dropdown('kodebrg', $barang, '',$jsbrg);
                                          ?>
                                      </div>
                                      </div>
                                      <div class="section">
                                      <label> Import File  <small>Import</small></label>
                                      <div> 
                                          <input type="file" class="fileupload" name="userfile" />
                                      </div>
                                      </div>
                                      <div class="section last">
                                              <div>
                                                <a class="uibutton submit_form" >Import</a><a class="uibutton special"   onClick="ResetForm()" title="Reset  Form"   >Reset Form</a>
                                             </div>
                                             </div>
                                      <a href="<?php echo base_url(); ?>uploads/sample/import.xlsx">Sample Format</a>
                                </fieldset>                                                                                          
                                </div>
                              </div>  
                          </div><!--tab1-->                                                                                                      
                  </div>                  
                  <div class="clear"/></div>                  
                  </div>
                  </div>
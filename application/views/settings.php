<div class="topcolumn">

            <div class="logo"></div>                            
            <ul  id="shortcut">        
                <?php $notif = $this->globals->notification($this->session->userdata('user_id')); ?>                
                <li> <a href="<?php echo base_url() ?>berita/unread/<?php echo $notif['detail']; ?>" title="Messages"> <img src="<?php echo base_url(); ?>assets/template/fingers/images/icon/shortcut/mail.png" alt="messages" /><strong>Message</strong></a><?php echo $notif['jml']; ?></li>
            </ul>   
          </div>  

          <div class="clear"></div>          

                    <div class="clear"></div>

                  <?php echo $this->message->display(); ?>

                  <div class="onecolumn" >

                  <div class="header"><span ><span class="ico  gray user"></span><?php echo $ket;?></span> </div><!-- End header --> 

                  <div class="clear"></div>

                  <div class="content" >                      

                    <div class="tab_container" >



                          <div id="tab1" class="tab_content"> 

                              <div class="load_page">                        

                                 

                                <div class="formEl_b">  

                                <form id="validation" action="<?php echo base_url(); ?>import/simpan" method="POST" enctype="multipart/form-data"> 

                                <fieldset >

                                <legend><?php echo $ket; ?> <span class="small s_color">( <?php echo $jenis;?> )</span></legend>
                                      <div class="section">
                                      <label> Alamat IP </label>
                                      <div>
                                      <input type="text" name="alamat" id="alamat"  class="medium" value="<?php echo $data[0]; ?>" placeholder="IP Address"/>
                                      </div>
                                      </div>
                                      <div class="section">
                                      <label> Username </label>
                                      <div>
                                      <input type="text" name="username" id="username"  class="medium" value="<?php echo $data[1]; ?>" placeholder="Username FTP"/>
                                      </div>
                                      </div>
                                      <div class="section">
                                      <label> Password </label>
                                      <div>
                                      <input type="text" name="password" id="password"  class="medium" value="<?php echo $data[2]; ?>" placeholder="Password FTP"/>
                                      </div>
                                      </div>
                                      <div class="section">
                                      <label> Port </label>
                                      <div>
                                      <input type="text" name="port" id="port"  class="small" value="<?php echo $data[3]; ?>" placeholder="Port FTP"/>
                                      </div>
                                      </div>
                                      <div class="section last">
                                      <div>
                                        <a class="uibutton submit_form" >Simpan</a><a class="uibutton special"   onClick="ResetForm()" title="Reset  Form"   >Reset Form</a>
                                     </div>

                                     </div>

                                </fieldset>

                                </form>

                                </div>

                              </div>  

                          </div><!--tab1-->                                                                                                      

                  </div>                  

                  <div class="clear"/></div>                  

                  </div>

                  </div>
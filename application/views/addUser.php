<div class="topcolumn">

            <div class="logo"></div>

                            <ul  id="shortcut">
                                <?php $notif = $this->globals->notification($this->session->userdata('user_id')); ?>
                                <li> <a href="<?php echo base_url(); ?>manajemen/users" title="Back To home"> <img src="<?php echo base_url();?>assets/template/fingers/images/icon/shortcut/home.png" alt="home" width="40px"/><strong>Daftar</strong> </a> </li>

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

                                <form id="validation" action="<?php echo base_url();?>manajemen/<?php echo $link; ?>" method="POST"> 

                                <fieldset >

                                <legend><?php echo $ket; ?> <span class="small s_color">( <?php echo $jenis; ?> )</span></legend>                                                                                                             

                                      <div class="section">

                                      <label> Login  Account  <small>Text custom</small></label>

                                      <div>

                                      <input type="text"  name="username" id="username"  class="validate[required,minSize[3],maxSize[20],] medium"  /><label>Username</label>

                                      <span class="f_help"> Username login or register. <br />Should be between 3 and not more than 20 characters.</span> 

                                      </div>

                                      <div>

                                      <input type="password"  class="validate[required,minSize[3]] medium"  name="password" id="password"  /><label>Password</label>

                                      </div>

                                      <div>

                                      <input type="password" class="validate[required,equals[password]] medium"  name="passwordCon" id="passwordCon"  /><label>Confirm Password</label>

                                            <span class="f_help"> Your password should be at least 6 characters.</span>

                                      </div>

                                      </div>

                                      <div class="section">

                                            <label>Level User <small>Pilih salah satu</small></label>   

                                            <div>                      

                                              <?php

                                              $jpl = "data-placeholder='Level User...'";           

                                              echo form_dropdown('level', $level, '',$jpl);

                                              ?>

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
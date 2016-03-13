<div class="topcolumn">
            <div class="logo"></div>
                            <ul  id="shortcut">
                                <?php $notif = $this->globals->notification($this->session->userdata('user_id')); ?>                                
                            </ul>      
          </div>  
          <div class="clear"></div>          
                    <div class="clear"></div>
                        
                  <div class="onecolumn" >
                  <div class="header"><span ><span class="ico  gray user"></span>Import Database</span> </div><!-- End header --> 
                  <div class="clear"></div>
                  <div class="content" >                      
                    <div class="tab_container" >

                          <div id="tab1" class="tab_content"> 
                              <div class="load_page">                        
                                 
                                <div class="formEl_b">  
                                <form id="validation" action="<?php echo base_url();?>backup/restor" method="POST" enctype="multipart/form-data"> 
                                <fieldset >
                                <legend>Import Database <span class="small s_color">( Import )</span></legend>                                                                                                                                          
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
                                </fieldset>                                                                                          
                                </div>
                              </div>  
                          </div><!--tab1-->                                                                                                      
                  </div>                  
                  <div class="clear"/></div>                  
                  </div>
                  </div>
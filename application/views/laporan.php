<script type="text/javascript">
function pilih(){
  var nilai = $('#jenis').val();
  if(nilai == 1){
    $('.tgl').hide();
    $('#harians').show();
  }else if(nilai == 2){
    $('.tgl').hide();
    $('#bulanan').show();
  }else if(nilai == 3){
    $('.tgl').hide();
    $('#tahunan').show();
  }else if(nilai == 4){
    $('.tgl').hide();  
     $('#custom').show();  
  }else if(nilai == 5){
    $('.tgl').hide();
    $('#bulanan').hide();
  }else
  {
    $('.tgl').hide();
    $('#bulanan').show();
  }
}
</script>
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
                  <div class="header"><span ><span class="ico  gray spreadsheet"></span>Rekap Laporan</span> </div><!-- End header --> 
                  <div class="clear"></div>
                  <div class="content" >                                      
                              <div class="load_page">                        
                                 
                                <div class="formEl_b">  
                                <form id="validation" action="<?php echo base_url();?>laporan/generate" method="POST"> 
                                <fieldset >
                                <legend>Generate Laporan <span class="small s_color">( Laporan )</span></legend>                                                                                                             
                                      <div class="section">
                                          <label>Jenis Laporan </label>   
                                          <div>
                                              <?php
                                              $jpj = "data-placeholder='Jenis Laporan...' onChange='pilih()' id='jenis'";
                                              echo form_dropdown('jenis', $jenis, '',$jpj);
                                              ?>
                                      </div>
                                      </div>                                      
                                      <div class="section tgl" id="harian" style="display:none;">
                                          <label>Tanggal Laporan <small>Pilih Tanggal</small></label>   
                                          <div><input type="text"  id="daily" class=" birthday  small " name="daily"  />
                                      </div>
                                      </div>
                                      <div class="section tgl" id="bulanan" style="display:none;">
                                          <label>Bulan Laporan <small>Pilih Bulan</small></label>   
                                          <div>
                                              <?php
                                              $jpb = "data-placeholder='Pilih Bulan...'";
                                              echo form_dropdown('bulan', $bulan, '',$jpb);
                                              ?>
                                          </div>
                                          <label>Tahun Laporan <small>Pilih Tahun</small></label>   
                                          <div>
                                              <?php
                                              $jpt = "data-placeholder='Pilih Tahun...'";
                                              echo form_dropdown('thn', $tahun, '',$jpt);
                                              ?>
                                          </div>
                                      </div>
                                      <div class="section tgl" id="tahunan" style="display:none;">
                                          <label>Tahun Laporan <small>Pilih Tahun</small></label>   
                                          <div>
                                              <?php
                                              $jpt = "data-placeholder='Pilih Tahun...'";
                                              echo form_dropdown('tahun', $tahun, '',$jpt);
                                              ?>
                                          </div>
                                      </div>    
                                      <div class="section tgl" id="custom" style="display:none;">
                                          <label>Tanggal </label>   
                                          <div>
                                              <input type="text"  id="rawal" class=" birthday  small " name="rawal"  />                                              
                                      </div>
                                      </div>
                                      <div class="section tgl" id="harians">
                                          <label>Tanggal </label>   
                                          <div>
                                              <input type="text"  id="lawal" class=" birthday  small " name="lawal"  />
                                              <input type="text"  id="lakhir" class=" birthday  small " name="lakhir"  />
                                      </div>
                                      </div>
                                      <div class="section last">
                                      <div>
                                        <a class="uibutton submit_form" >Generate Report</a>
                                     </div>
                                     </div>                                     
                                </fieldset>
                                </form>
                                </div>                                                                                                    
                  </div>                  
                  <div class="clear"/></div>                  
                  </div>
                  </div>
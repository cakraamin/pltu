<form action="<?=base_url()?>masters/all_umur" method="POST" enctype="multipart/form-data">
<div class="topcolumn">
            <div class="logo"></div>
                            <ul  id="shortcut">
                                <li> <a href="<?=base_url()?>masters/tambah_umur" title="Back To home"> <img src="<?=base_url()?>assets/template/fingers/images/icon/shortcut/add.png" alt="home" width="40px"/><strong>Tambah</strong> </a> </li>
                                <li> <input type="image" src="<?=base_url()?>assets/template/fingers/images/icon/shortcut/Delete.png" name="image" width="40" height="40" style="margin-top:9.5px; margin-left:17px;"><br/><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Hapus</strong></li>
                            </ul>
          </div>           
          <div class="clear"></div> 
          <?=$this->message->display();?>
<div class="onecolumn" >
                    <div class="header">
                    <span ><span class="ico  gray spreadsheet"></span> Daftar Batas Umur Siswa Sekolah </span>
                    </div><!-- End header --> 
                    <div class=" clear"></div>
                    <div class="content" >                      
                              <table class="display " id="static">
                                <thead>
                                  <tr>
                                    <th width="35" ><input type="checkbox" id="checkAll1"  class="checkAll"/></th>
                                    <th>Jenjang</th>                                
                                    <th>Batas Umur</th>
                                    <th width="150">Tingkat</th>
                                    <th width="199" >Management</th>
                                  </tr>
                                </thead>
                                <tbody>                                
                                <?                                
                                $no = 1;
                                foreach($kueri as $dt_kueri)
                                {                      
                                ?>
                                  <tr>
                                    <td  width="35" ><input type="checkbox" name="check[]" class="chkbox"  id="check<?=$no?>" value="<?=$dt_kueri['id_umur']?>"/></td>
                                    <td  align="left"><?
                                    $i = 1;
                                    foreach ($dt_kueri['detil'] as $detail) 
                                    {
                                        $hub = ($i == count($dt_kueri['detil']))?"":", ";
                                        echo $this->arey->getJenjang($detail->jenjang_school).$hub;
                                        $i++;
                                    }
                                    ?></td>
                                    <td  align="left"><?=$dt_kueri['batas']?></td>
                                    <td  align="left"><?=$dt_kueri['id_tingkat']?></td>                                    
                                    <td >          
                                      <span class="tip" >
                                          <a  title="Edit Batas Umur" href="<?=base_url()?>masters/edit_umur/<?=$dt_kueri['id_umur']?>" >
                                              <img src="<?=base_url()?>assets/template/fingers/images/icon/icon_edit.png" >
                                          </a>
                                      </span> 
                                      <span class="tip" >
                                          <a id="<?=$no?>" class="Delete"  name="Band ring" title="Delete Umur" href="<?=base_url()?>masters/hapus_umur/<?=$dt_kueri['id_umur']?>"  >
                                              <img src="<?=base_url()?>assets/template/fingers/images/icon/icon_delete.png" >
                                          </a>
                                      </span> 
                                        </td>
                                  </tr>                                  
                                  <? 
                                  $no++;
                                  } 
                                  ?>
                                </tbody>
                              </table>
</form>
<?=$paging?>
          </div>
</div>
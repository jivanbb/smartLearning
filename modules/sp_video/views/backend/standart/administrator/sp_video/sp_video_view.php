<script type="text/javascript">
function domo(){
   $('*').bind('keydown', 'Ctrl+e', function() {
      $('#btn_edit').trigger('click');
       return false;
   });

   $('*').bind('keydown', 'Ctrl+x', function() {
      $('#btn_back').trigger('click');
       return false;
   });
}

jQuery(document).ready(domo);
</script>
<section class="content-header">
   <h1>
      Sp Materials      <small><?= cclang('detail', ['Sp Materials']); ?> </small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class=""><a  href="<?= admin_site_url('/sp_materials'); ?>">Sp Materials</a></li>
      <li class="active"><?= cclang('detail'); ?></li>
   </ol>
</section>
<section class="content">
   <div class="row" >
     
      <div class="col-md-12">
         <div class="box box-warning">
            <div class="box-body ">

               <div class="box box-widget widget-user-2">
                  <div class="widget-user-header ">
                     <div class="widget-user-image">
                        <img class="img-circle" src="<?= BASE_ASSET; ?>/img/view.png" alt="User Avatar">
                     </div>
                     <h3 class="widget-user-username">Sp Materials</h3>
                     <h5 class="widget-user-desc">Detail Sp Materials</h5>
                     <hr>
                  </div>

                 
                  <div class="form-horizontal form-step" name="form_sp_materials" id="form_sp_materials" >
                  
                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Id </label>

                        <div class="col-sm-8">
                        <span class="detail_group-id"><?= _ent($sp_materials->id); ?></span>
                        </div>
                    </div>
                                        
                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Course Id </label>

                        <div class="col-sm-8">
                        <span class="detail_group-course_id"><?= _ent($sp_materials->course_id); ?></span>
                        </div>
                    </div>
                                        
                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Chapter Id </label>

                        <div class="col-sm-8">
                        <span class="detail_group-chapter_id"><?= _ent($sp_materials->chapter_id); ?></span>
                        </div>
                    </div>
                                        
                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Topic Id </label>

                        <div class="col-sm-8">
                        <span class="detail_group-topic_id"><?= _ent($sp_materials->topic_id); ?></span>
                        </div>
                    </div>
                                        
                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label"> Materials </label>
                        <div class="col-sm-8">
                             <?php if (!empty($sp_materials->materials)): ?>
                             <?php foreach (explode(',', $sp_materials->materials) as $filename): ?>
                               <?php if (is_image($sp_materials->materials)): ?>
                                <a class="fancybox" rel="group" href="<?= BASE_URL . 'uploads/sp_materials/' . $filename; ?>">
                                  <img src="<?= BASE_URL . 'uploads/sp_materials/' . $filename; ?>" class="image-responsive" alt="image sp_materials" title="materials sp_materials" width="40px">
                                </a>
                                <?php else: ?>
                                <label>
                                  <a href="<?= ADMIN_BASE_URL . '/file/download/sp_materials/' . $filename; ?>">
                                   <img src="<?= get_icon_file($filename); ?>" class="image-responsive" alt="image sp_materials" title="materials <?= $filename; ?>" width="40px"> 
                                 <?= $filename ?>
                               </a>
                               </label>
                              <?php endif; ?>
                            <?php endforeach; ?>
                          <?php endif; ?>
                        </div>
                    </div>
                  
                                      
                    <br>
                    <br>


                     
                         
                    <div class="view-nav">
                        <?php is_allowed('sp_materials_update', function() use ($sp_materials){?>
                        <a class="btn btn-flat btn-info btn_edit btn_action" id="btn_edit" data-stype='back' title="edit sp_materials (Ctrl+e)" href="<?= admin_site_url('/sp_materials/edit/'.$sp_materials->id); ?>"><i class="fa fa-edit" ></i> <?= cclang('update', ['Sp Materials']); ?> </a>
                        <?php }) ?>
                        <a class="btn btn-flat btn-default btn_action" id="btn_back" title="back (Ctrl+x)" href="<?= admin_site_url('/sp_materials/'); ?>"><i class="fa fa-undo" ></i> <?= cclang('go_list_button', ['Sp Materials']); ?></a>
                     </div>
                    
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>

<script>
$(document).ready(function(){

    "use strict";
    
   
   });
</script>
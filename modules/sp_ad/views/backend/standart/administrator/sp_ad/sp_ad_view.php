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
      Sp Ad      <small><?= cclang('detail', ['Sp Ad']); ?> </small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class=""><a  href="<?= admin_site_url('/sp_ad'); ?>">Sp Ad</a></li>
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
                     <h3 class="widget-user-username">Sp Ad</h3>
                     <h5 class="widget-user-desc">Detail Sp Ad</h5>
                     <hr>
                  </div>

                 
                  <div class="form-horizontal form-step" name="form_sp_ad" id="form_sp_ad" >
                  
                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Id </label>

                        <div class="col-sm-8">
                        <span class="detail_group-id"><?= _ent($sp_ad->id); ?></span>
                        </div>
                    </div>
                                        
                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Title </label>

                        <div class="col-sm-8">
                        <span class="detail_group-title"><?= _ent($sp_ad->title); ?></span>
                        </div>
                    </div>
                                        
                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label"> Image </label>
                        <div class="col-sm-8">
                             <?php if (is_image($sp_ad->image)): ?>
                              <a class="fancybox" rel="group" href="<?= BASE_URL . 'uploads/sp_ad/' . $sp_ad->image; ?>">
                                <img src="<?= BASE_URL . 'uploads/sp_ad/' . $sp_ad->image; ?>" class="image-responsive" alt="image sp_ad" title="image sp_ad" width="40px">
                              </a>
                              <?php else: ?>
                              <label>
                                <a href="<?= ADMIN_BASE_URL . '/file/download/sp_ad/' . $sp_ad->image; ?>">
                                 <img src="<?= get_icon_file($sp_ad->image); ?>" class="image-responsive" alt="image sp_ad" title="image <?= $sp_ad->image; ?>" width="40px"> 
                               <?= $sp_ad->image ?>
                               </a>
                               </label>
                              <?php endif; ?>
                        </div>
                    </div>
                                      
                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Link </label>

                        <div class="col-sm-8">
                        <span class="detail_group-link"><?= _ent($sp_ad->link); ?></span>
                        </div>
                    </div>
                                        
                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Order </label>

                        <div class="col-sm-8">
                        <span class="detail_group-order"><?= _ent($sp_ad->order); ?></span>
                        </div>
                    </div>
                                        
                    <br>
                    <br>


                     
                         
                    <div class="view-nav">
                        <?php is_allowed('sp_ad_update', function() use ($sp_ad){?>
                        <a class="btn btn-flat btn-info btn_edit btn_action" id="btn_edit" data-stype='back' title="edit sp_ad (Ctrl+e)" href="<?= admin_site_url('/sp_ad/edit/'.$sp_ad->id); ?>"><i class="fa fa-edit" ></i> <?= cclang('update', ['Sp Ad']); ?> </a>
                        <?php }) ?>
                        <a class="btn btn-flat btn-default btn_action" id="btn_back" title="back (Ctrl+x)" href="<?= admin_site_url('/sp_ad/'); ?>"><i class="fa fa-undo" ></i> <?= cclang('go_list_button', ['Sp Ad']); ?></a>
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
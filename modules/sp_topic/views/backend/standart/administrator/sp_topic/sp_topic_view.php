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
      Sp Topic      <small><?= cclang('detail', ['Sp Topic']); ?> </small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class=""><a  href="<?= admin_site_url('/sp_topic'); ?>">Sp Topic</a></li>
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
                     <h3 class="widget-user-username">Sp Topic</h3>
                     <h5 class="widget-user-desc">Detail Sp Topic</h5>
                     <hr>
                  </div>

                 
                  <div class="form-horizontal form-step" name="form_sp_topic" id="form_sp_topic" >
                  
                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Id </label>

                        <div class="col-sm-8">
                        <span class="detail_group-id"><?= _ent($sp_topic->id); ?></span>
                        </div>
                    </div>
                                        
                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Course Id </label>

                        <div class="col-sm-8">
                           <?= _ent($sp_topic->sp_course_name); ?>
                        </div>
                    </div>
                                        
                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Chapter Id </label>

                        <div class="col-sm-8">
                           <?= _ent($sp_topic->sp_chapter_name); ?>
                        </div>
                    </div>
                                        
                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Topic No </label>

                        <div class="col-sm-8">
                        <span class="detail_group-topic_no"><?= _ent($sp_topic->topic_no); ?></span>
                        </div>
                    </div>
                                        
                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Name </label>

                        <div class="col-sm-8">
                        <span class="detail_group-name"><?= _ent($sp_topic->name); ?></span>
                        </div>
                    </div>
                                        
                    <br>
                    <br>


                     
                         
                    <div class="view-nav">
                        <?php is_allowed('sp_topic_update', function() use ($sp_topic){?>
                        <a class="btn btn-flat btn-info btn_edit btn_action" id="btn_edit" data-stype='back' title="edit sp_topic (Ctrl+e)" href="<?= admin_site_url('/sp_topic/edit/'.$sp_topic->id); ?>"><i class="fa fa-edit" ></i> <?= cclang('update', ['Sp Topic']); ?> </a>
                        <?php }) ?>
                        <a class="btn btn-flat btn-default btn_action" id="btn_back" title="back (Ctrl+x)" href="<?= admin_site_url('/sp_topic/'); ?>"><i class="fa fa-undo" ></i> <?= cclang('go_list_button', ['Sp Topic']); ?></a>
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
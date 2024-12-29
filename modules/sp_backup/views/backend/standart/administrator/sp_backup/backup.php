<script type="text/javascript">
   function domo() {

      $('*').bind('keydown', 'Ctrl+a', function() {
         window.location.href = ADMIN_BASE_URL + '/Sp_level/add';
         return false;
      });

      $('*').bind('keydown', 'Ctrl+f', function() {
         $('#sbtn').trigger('click');
         return false;
      });

      $('*').bind('keydown', 'Ctrl+x', function() {
         $('#reset').trigger('click');
         return false;
      });

      $('*').bind('keydown', 'Ctrl+b', function() {

         $('#reset').trigger('click');
         return false;
      });
   }

   jQuery(document).ready(domo);
</script>
<section class="content-header">
   <h1>Backup</h1>
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active"><?= cclang('backup') ?></li>
   </ol>
</section>
<!-- Main content -->
<section class="content">
   <div class="row">

      <div class="col-md-12">
         <div class="box box-warning">
            <div class="box-body ">
               <div class="box box-widget widget-user-2">
                  <div class="row ">
                     <div class="col-md-12">
                        <?php if (check_role_exist_or_not(24, array("add"))) { ?>
                           <a class="btn btn-flat btn-success btn_add_new pull-right" id="btn_add_new" title="<?= cclang('add_new_button', [cclang('backup')]); ?>  (Ctrl+a)" href="<?= admin_site_url('/sp_backup/add'); ?>"><i class="fa fa-plus-square-o"></i> <?= cclang('backup'); ?></a>
                        <?php } ?>

                     </div>
                  </div>
                  <div class="table-responsive">

                     <br>
                     <table class="table table-bordered table-striped dataTable">
                        <thead>
                           <tr class="">
                              <th>S.N.</th>
                              <th>Backup Date</th>
                              <th>Backup File</th>
                              <th>Action</th>
                           </tr>
                        </thead>
                        <tbody id="tbody_oms_backup">
                           <?php if (!empty($fileList)) {
                              $sn = 1;
                              foreach ($fileList as $file) {
                                 $fileInfo = pathinfo($file);
                                 $fileName = $fileInfo['filename'];
                                 $createdTime = DateTime::createFromFormat('Y-m-d_H-i-s', str_replace('backup_', '', $fileInfo['filename']));    ?>
                                 <tr>
                                    <td><?php echo $sn++; ?></td>
                                    <td><?php echo $createdTime->format('F j, Y g:i a'); ?></td>
                                    <td><?php echo $fileInfo['basename']; ?></td>
                                    <td>
                                       <?php if (check_role_exist_or_not(24, array("add", "edit", "view", "list"))) { ?>
                                          <a href="<?php echo site_url('administrator/sp_backup/download_backup/' . $fileName); ?>"><i
                                                class="fa fa-download"></i></a>
                                       <?php } ?>
                                       <?php if (check_role_exist_or_not(24, array("delete"))) { ?>
                                          <a class="delete_backup"
                                             href="<?php echo site_url('administrator/sp_backup/delete_backup/' . $fileName); ?>"><i
                                                class="fa fa-trash"></i></a>
                                       <?php } ?>
                                    </td>
                                 </tr>
                              <?php
                              }
                           } else { ?>
                              <tr>
                                 <td colspan="100">
                                    No Backups available.
                                 </td>
                              </tr>
                           <?php }  ?>
                        </tbody>
                     </table>
                  </div>
               </div>
               <hr>

            </div>
         </div>
      </div>
   </div>
</section>

<script>
   $(document).ready(function() {

      $('.delete_backup').on('click', function() {

         var url = this.href;

         swal({
               title: "<?= cclang('are_you_sure'); ?>",
               text: "<?= cclang('data_to_be_deleted_can_not_be_restored'); ?>",
               type: "warning",
               showCancelButton: true,
               confirmButtonColor: "#DD6B55",
               confirmButtonText: "<?= cclang('yes_delete_it'); ?>",
               cancelButtonText: "<?= cclang('no_cancel_plx'); ?>",
               closeOnConfirm: true,
               closeOnCancel: true
            },
            function(isConfirm) {
               if (isConfirm) {
                  document.location.href = url;
               }
            });

         return false;
      });


   }); /*end appliy click*/
</script>
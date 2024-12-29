<link href="<?= BASE_ASSET; ?>/fine-upload/fine-uploader-gallery.min.css" rel="stylesheet">
<script src="<?= BASE_ASSET; ?>/fine-upload/jquery.fine-uploader.js"></script>
<?php $this->load->view('core_template/fine_upload'); ?>
<script type="text/javascript">
   function domo() {

      $('*').bind('keydown', 'Ctrl+a', function() {
         window.location.href = ADMIN_BASE_URL + '/Sp_video/add';
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
   <h1>
      <?= cclang('sp_video') ?>Materials
   </h1>
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active"><?= cclang('sp_video') ?> Materials</li>
   </ol>
</section>
<!-- Main content -->
<section class="content">
   <div class="row">

      <div class="col-md-12">
         <div class="box box-warning">
            <div class="box-body ">
               <div class="box box-widget widget-user-2">
                  <form name="form_sp_video" id="form_sp_video" action="<?= admin_base_url('sp_video'); ?>">
                     <button type="button" class="btn btn-flat btn-success btn_add_new pull-right" data-toggle="modal" data-target="#new_topic"><i class="fa fa-plus-square-o"></i> <?= cclang('video'); ?></button>
                     <div class="row">
                        <div class="col-md-10">
                           <div class="col-sm-2 padd-left-0 ">
                              <select type="text" class="form-control chosen chosen-select board_id" name="board_id">
                                 <option value="">Board/University</option>
                                 <?php foreach (db_get_all_data('sp_board', ['created_by' => $user_id, 'is_deleted' => 0]) as $row): ?>
                                    <option <?= $row->id == @$filter['board_id'] ? 'selected' : ''; ?> value="<?= $row->id ?>"><?= $row->name; ?></option>
                                 <?php endforeach; ?>
                              </select>
                           </div>
                           <div class="col-sm-2 padd-left-0 ">
                              <select type="text" class="form-control " name="course_id" id="course_id">
                                 <option value=""><?= cclang('course'); ?></option>
                                 <?php if (@$filter['course_id']) {
                                    $courses = get_courses(@$filter['board_id']);
                                    foreach ($courses as $course) { ?>
                                       <option <?= $course->id == @$filter['course_id'] ? 'selected' : ''; ?> value="<?php echo $course->id; ?>"><?php echo $course->name ?></option>
                                 <?php }
                                 } ?>
                              </select>
                           </div>
                           <div class="col-sm-3 padd-left-0 ">
                              <select type="text" class="form-control " name="chapter_id" id="chapter_id">
                                 <option value=""><?= cclang('chapter'); ?></option>
                                 <?php if (@$filter['chapter_id']) {
                                    $chapters = get_chapters(@$filter['course_id']);
                                    foreach ($chapters as $chapter) { ?>
                                       <option <?= $chapter->id == @$filter['chapter_id'] ? 'selected' : ''; ?> value="<?php echo $chapter->id; ?>"><?php echo $chapter->name ?></option>
                                 <?php }
                                 } ?>
                              </select>
                           </div>
                           <div class="col-sm-2 padd-left-0 ">
                              <select class="form-control " name="topic_id" id="topic_id" data-placeholder="Select Topic">
                                 <option value=""><?= cclang('topic'); ?></option>
                                 <?php if(@$filter['topic_id']){
                                    $topics =get_topics( @$filter['chapter_id']);
                                    foreach($topics as $topic){?>
                                      <option <?= $topic->id == @$filter['topic_id'] ? 'selected' : ''; ?> value="<?php echo $topic->id; ?>"><?php echo $topic->name ?></option>
                                    <?php }}?>
                              </select>
                           </div>
                           <div class="col-sm-1 padd-left-0 ">
                              <button type="submit" class="btn btn-flat" name="sbtn" id="sbtn" value="Apply" title="<?= cclang('filter_search'); ?>">
                                 Filter
                              </button>
                           </div>
                           <div class="col-sm-1 padd-left-2 ">
                              <a class="btn btn-default btn-flat" name="reset" id="reset" value="Apply" href="<?= admin_base_url('/sp_video'); ?>" title="<?= cclang('reset_filter'); ?>">
                                 <i class="fa fa-undo"></i>
                              </a>
                           </div>
                        </div>
                     </div>
                  </form>
                  <div class="table-responsive">

                     <br>
                     <table class="table table-bordered table-striped dataTable">
                        <thead>
                           <tr class="">
                              <!-- <th>
                                    <input type="checkbox" class="flat-red toltip" id="check_all" name="check_all" title="check all">
                                 </th> -->
                              <th data-field="course_id" data-sort="1" data-primary-key="0"> <?= cclang('course') ?></th>
                              <th data-field="chapter_id" data-sort="1" data-primary-key="0"> <?= cclang('chapter') ?></th>
                              <th data-field="topic_id" data-sort="1" data-primary-key="0"> <?= cclang('topic') ?></th>
                              <th data-field="materials" data-sort="1" data-primary-key="0"> <?= cclang('video').' '. cclang('materials') ?></th>
                              <th>Action</th>
                           </tr>
                        </thead>
                        <tbody id="tbody_sp_video">
                           <?= $tables ?>
                        </tbody>
                     </table>
                  </div>
               </div>
               <hr>

            </div>
            </form>
         </div>
      </div>
   </div>
</section>
<div id="new_topic" class="modal fade new-july-design" role="dialog">

   <div class="modal-dialog modal-md">
      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Create Video Materials</h4>
         </div>
         <div class="modal-body new-july-design">
            <?= form_open('', [
               'name' => 'form_sp_video_add',
               'class' => 'form-horizontal',
               'id' => 'form_sp_video_add',
               'enctype' => 'multipart/form-data',
               'method' => 'POST'
            ]); ?>
            <div class="row">
               <div class="col-md-6">
                  <div class="form-group group-course_id ">
                     <label for="course_id" class="col-sm-3 control-label">Course <i class="required">*</i>
                     </label>
                     <div class="col-sm-9">
                        <select class="form-control chosen chosen-select-deselect" name="course_id" id="module_course_id" data-placeholder="Select Course">
                           <option value=""></option>
                           <?php $conditions = ['created_by' => $user_id, 'is_deleted' => 0];  ?>

                           <?php foreach (db_get_all_data('sp_course', $conditions) as $row): ?>
                              <option value="<?= $row->id ?>"><?= $row->name; ?></option>
                           <?php endforeach; ?>
                        </select>
                        <small class="info help-block">
                        </small>
                     </div>
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="form-group group-chapter_id ">
                     <label for="chapter_id" class="col-sm-3 control-label">Chapter </label>
                     <div class="col-sm-9">
                        <select class="form-control " name="chapter_id" id="module_chapter_id" data-placeholder="Select Chapter">
                           <option value=""></option>
                        </select>
                        <small class="info help-block">
                        </small>
                     </div>
                  </div>
               </div>

            </div>
            <div class="row">
               <div class="col-md-6">
                  <div class="form-group group-topic_id ">
                     <label for="chapter_id" class="col-sm-3 control-label">Topic </label>
                     <div class="col-sm-9">
                        <select class="form-control " name="topic_id" id="module_topic_id" data-placeholder="Select Topic">
                           <option value=""></option>
                        </select>
                        <small class="info help-block">
                        </small>
                     </div>
                  </div>
               </div>

            </div>
            <div class="row">
               <div class="col-md-12">
                  <div class="form-group group-materials ">
                     <label for="materials" class="col-sm-3 control-label">Upload Video <i class="required">*</i>
                     </label>
                     <div class="col-sm-9">
                        <div id="sp_video_materials_galery"></div>
                        <div id="sp_video_materials_galery_listed"></div>
                        <small class="info help-block">
                        </small>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="modal-footer pr-5p">
            <button class="btn  btn-primary btn_save  btn_action " id="btn_save" data-stype='stay'> <?= cclang('save'); ?>
               <button type="button" class="btn   btn-close" data-dismiss="modal">Close</button>
         </div>
         <?= form_close(); ?>

      </div>
   </div>

</div>
<!-- <script>
   var module_name = "sp_video"
   var use_ajax_crud = false
</script>
<script src="<?= BASE_ASSET ?>js/filter.js"></script> -->


<script>
   $(document).ready(function() {

      "use strict";



      // if (use_ajax_crud == false) {

         $(document).on('click', 'a.remove-data', function() {

            var url = $(this).attr('data-href');

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
      // }



      $(document).on('click', '#apply', function() {

         var bulk = $('#bulk');
         var serialize_bulk = $('#form_sp_video').serialize();

         if (bulk.val() == 'delete') {
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
                     document.location.href = ADMIN_BASE_URL + '/sp_video/delete?' + serialize_bulk;
                  }
               });

            return false;

         } else if (bulk.val() == '') {
            swal({
               title: "Upss",
               text: "<?= cclang('please_choose_bulk_action_first'); ?>",
               type: "warning",
               showCancelButton: false,
               confirmButtonColor: "#DD6B55",
               confirmButtonText: "Okay!",
               closeOnConfirm: true,
               closeOnCancel: true
            });

            return false;
         }

         return false;

      }); /*end appliy click*/

      $('.board_id').change(function() {
         var board_id = $(this).val();
         if (board_id !== '') {

            $.ajax({
               type: 'GET',
               data: board_id,
               dataType: 'html',
               url: BASE_URL + 'administrator/sp_mcq_question/getCourseByUniversity/' + board_id,
               success: function(html) {
                  $('#course_id').html(html);
               }
            });
         }
      });

      $('#course_id').change(function() {
         $('#chapter_id').empty();
         var course_id = $(this).val();
         if (course_id !== '') {

            $.ajax({
               type: 'GET',
               data: course_id,
               dataType: 'html',
               url: BASE_URL + '/administrator/sp_mcq_question/getChapter/' + course_id,
               success: function(html) {
                  $('#chapter_id').html(html);
               }
            });
         }
      });

      $('#chapter_id').change(function() {
         $('#topic_id').empty();
         var chapter_id = $(this).val();
         if (chapter_id !== '') {

            $.ajax({
               type: 'GET',
               data: chapter_id,
               dataType: 'html',
               url: BASE_URL + '/administrator/sp_mcq_question/getTopic/' + chapter_id,
               success: function(html) {
                  $('#topic_id').html(html);
               }
            });

         }
      });

      $('#module_course_id').change(function() {
         var course_id = $(this).val();
         if (course_id !== '') {

            $.ajax({
               type: 'GET',
               data: course_id,
               dataType: 'html',
               url: BASE_URL + '/administrator/sp_mcq_question/getChapter/' + course_id,
               success: function(html) {
                  $('#module_chapter_id').html(html);
               }
            });
         }
      });

      $('#module_chapter_id').change(function() {
         var chapter_id = $(this).val();
         if (chapter_id !== '') {

            $.ajax({
               type: 'GET',
               data: chapter_id,
               dataType: 'html',
               url: BASE_URL + '/administrator/sp_mcq_question/getTopic/' + chapter_id,
               success: function(html) {
                  $('#module_topic_id').html(html);
               }
            });
         }
      });

      $('.btn_save').click(function() {
    var form_sp_video = $('#form_sp_video_add');
    var data_post = form_sp_video.serializeArray();
    $.ajax({
            url: ADMIN_BASE_URL + '/sp_video/add_save',
            type: 'POST',
            dataType: 'json',
            data: data_post,
        })
        .done(function(res) {
            $('form').find('.form-group').removeClass('has-error');
            $('.steps li').removeClass('error');
            $('form').find('.error-input').remove();
            if (res.success) {
               showStatusMessage('success', 'Success', res.message);
                  setTimeout(() => {
                     window.location.reload(true);
                  });
            $('#sp_video_materials_galery').find('li').each(function() {
                $('#sp_video_materials_galery').fineUploader('deleteFile', $(this).attr('qq-file-id'));
            });
            $('.chosen option').prop('selected', false).trigger('chosen:updated');
            
            } else {
                showValidationMessage(`${res.message}`);
            }

        })
        .fail(function() {
         showStatusMessage('error', 'Error', 'Error save data');
        })
        .always(function() {
            $('.loading').hide();
            $('html, body').animate({
                scrollTop: $(document).height()
            }, 2000);
        });

    return false;
    }); /*end btn save*/

      $('#form_sp_video').on('click', '.btn_add_new', function() {
         var params = {};
         params[csrf] = token;

         $('#sp_video_materials_galery').fineUploader({
            template: 'qq-template-gallery',
            request: {
               endpoint: ADMIN_BASE_URL + '/sp_video/upload_materials_file',
               params: params
            },
            deleteFile: {
               enabled: true,
               endpoint: ADMIN_BASE_URL + '/sp_video/delete_materials_file',
            },
            thumbnails: {
               placeholders: {
                  waitingPath: BASE_URL + '/asset/fine-upload/placeholders/waiting-generic.png',
                  notAvailablePath: BASE_URL + '/asset/fine-upload/placeholders/not_available-generic.png'
               }
            },
            validation: {
               allowedExtensions: ["mp4|avi|mov|flv|wmv|mkv"],
               sizeLimit: 0,

            },
            showMessage: function(msg) {
               toastr['error'](msg);
            },
            callbacks: {
               onComplete: function(id, name, xhr) {
                  if (xhr.success) {
                     var uuid = $('#sp_video_materials_galery').fineUploader('getUuid', id);
                     $('#sp_video_materials_galery_listed').append('<input type="hidden" class="listed_file_uuid" name="sp_video_materials_uuid[' + id + ']" value="' + uuid + '" /><input type="hidden" class="listed_file_name" name="sp_video_materials_name[' + id + ']" value="' + xhr.uploadName + '" />');
                  } else {
                     toastr['error'](xhr.error);
                  }
               },
               onDeleteComplete: function(id, xhr, isError) {
                  if (isError == false) {
                     $('#sp_video_materials_galery_listed').find('.listed_file_uuid[name="sp_video_materials_uuid[' + id + ']"]').remove();
                     $('#sp_video_materials_galery_listed').find('.listed_file_name[name="sp_video_materials_name[' + id + ']"]').remove();
                  }
               }
            }
         }); /*end materials galery*/
      });
      // initSortableAjax('sp_video', $('table.dataTable'));
   }); /*end doc ready*/
</script>
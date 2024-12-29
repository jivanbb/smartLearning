<script type="text/javascript">
   function domo() {
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
      MCQ Exam
   </h1>
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class=""><a href="<?= admin_site_url('/sp_mcq_exam'); ?>">MCQ Exam</a></li>
      <li class="active"><?= cclang('detail'); ?></li>
   </ol>
</section>
<section class="content">
   <div class="row">

      <div class="col-md-12">
         <div class="box box-warning">
            <div class="box-body ">

               <div class="box box-widget widget-user-2">
                  <!-- <div class="widget-user-header ">
                     <div class="widget-user-image">
                        <img class="img-circle" src="<?= BASE_ASSET; ?>/img/view.png" alt="User Avatar">
                     </div>
                     <h3 class="widget-user-username">Sq Mcq Question</h3>
                     <h5 class="widget-user-desc">Detail Sq Mcq Question</h5>
                     <hr>
                  </div> -->


                  <div class="form-horizontal form-step" name="form_data" id="form_sp_mcq_question">
                      <div class="row">
                        <div class="col-md-3">
                           <div class="form-group ">
                              <label for="content" class="col-sm-3 control-label">Course: </label>

                              <div class="col-sm-9">
                                 <?php echo $mcq_exam->course_name; ?>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-3">
                           <div class="form-group ">
                              <label for="content" class="col-sm-7 control-label">No of Question: </label>

                              <div class="col-sm-5">
                                 <?php echo $mcq_exam->total_questions; ?>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-3">
                           <div class="form-group ">
                              <label for="content" class="col-sm-7 control-label">Full Marks: </label>

                              <div class="col-sm-5">
                                 <?php echo $mcq_exam->full_marks; ?>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-3">
                           <div class="form-group ">
                              <label for="content" class="col-sm-7 control-label">Pass Marks: </label>

                              <div class="col-sm-5">
                                 <span class="detail_group-no_of_options"><?= _ent($mcq_exam->pass_marks); ?></span>
                              </div>
                           </div>
                        </div>
                     </div> 
                     <hr>
                     <div class="row">
                        <?php $sn = 0;
                        foreach ($question_detail as $data) {
                           $sn++; ?>
                           <div class="col-md-12">
                              <table>
                                 <tbody>
                                    <tr>
                                       <td><?php echo $sn . ')  '; ?></td>
                                       <td colspan="2"><?php echo $data->question; ?></td>
                                    </tr>
                                    <tr>
                                       <td></td>
                                       <td>
                                          <p class="options-para"><input type="radio" <?php if($data->correct_option ==1){ echo "checked";}?>> <?php echo $data->option_1; ?></p>
                                       </td>
                                    </tr>
                                    <?php if ($data->no_of_options == 2 || $data->no_of_options == 3 || $data->no_of_options == 4) { ?>
                                    <tr>
                                       <td></td>
                                       <td>
                                          <p class="options-para"><input type="radio" <?php if($data->correct_option ==2){ echo "checked";}?>> <?php echo $data->option_2; ?></p>
                                       </td>
                                    </tr>
                                    <?php }?>
                                    <?php if ($data->no_of_options == 3 || $data->no_of_options == 4) { ?>
                                    <tr>
                                       <td></td>
                                       <td>
                                          <p class="options-para"><input type="radio" <?php if($data->correct_option ==3){ echo "checked";}?>> <?php echo $data->option_3; ?></p>
                                       </td>
                                    </tr>
                                    <?php }?>
                                    <?php if ($data->no_of_options == 4) { ?>
                                    <tr>
                                       <td></td>
                                       <td>
                                          <p class="options-para"><input type="radio" <?php if($data->correct_option ==4){ echo "checked";}?>> <?php echo $data->option_4; ?></p>
                                       </td>
                                    </tr>
                                    
                                    <?php } if($data->explanation){?>
                                    <tr>
                                       <td>Explain:</td>
                                       <td><?php echo $data->explanation; ?> </td>
                                    </tr>
                                    <?php }?>
                                 </tbody>
                              </table>
                           </div>
                           <hr>
                        <?php } ?>


                     </div>


                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>

<script>
   $(document).ready(function() {

      "use strict";


   });
</script>
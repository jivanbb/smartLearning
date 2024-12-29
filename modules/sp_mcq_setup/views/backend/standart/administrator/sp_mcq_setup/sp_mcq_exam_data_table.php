<?php foreach($sp_mcq_questions as $sp_mcq_question): ?>
    <tr>
                <!-- <td width="5">
            <input type="checkbox" class="flat-red check" name="id[]" value="<?= $sp_mcq_question->id; ?>">
        </td> -->
                
        <!-- <td><?php if  ($sp_mcq_question->course_id) {

            echo  $sp_mcq_question->sp_course_name; }?> </td> -->
             <td><span class="list_group-id"><?= _ent(++$offset); ?></span></td> 
        <td><span class="list_group-chapter_id"><?= _ent($sp_mcq_question->course_name); ?></span></td>
        <td><?= _ent($sp_mcq_question->time); ?> </td> 
        <td><?= _ent($sp_mcq_question->total_questions); ?> </td>
        <td><span class="list_group-questions"><?php echo $sp_mcq_question->question_marks;?></span></td> 
        <td><?= _ent($sp_mcq_question->full_marks); ?> </td>
        <td><span class="list_group-no_of_options"><?= _ent($sp_mcq_question->pass_marks); ?></span></td> 
        <td width="200">
         <?php if (check_role_exist_or_not(18, array("view"))) { ?>
        <a href="<?= admin_site_url('/sp_mcq_setup/view/' . $sp_mcq_question->id); ?>" data-id="<?= $sp_mcq_question->id ?>" class="label-default btn-act-edit"><i class="fa fa-eye "></i> </a>
        <?php }?> 
         <?php if (check_role_exist_or_not(18, array("edit"))) { ?>
            <a href="<?= admin_site_url('/sp_mcq_setup/edit/' . $sp_mcq_question->id); ?>" data-id="<?= $sp_mcq_question->id ?>" class="label-default btn-act-edit"><i class="fa fa-edit "></i> </a>
            <?php } if (check_role_exist_or_not(18, array("delete"))) { ?>
            <a href="javascript:void(0);" data-href="<?= admin_site_url('/sp_mcq_setup/delete/' . $sp_mcq_question->id); ?>" class="label-default remove-data"><i class="fa fa-close"></i> </a>
            <?php } if($sp_mcq_question->is_publish ==0){?> 
            <button class="publish" data-id="<?php echo $sp_mcq_question->id; ?>" >Publish</button>
            <?php }?>
        </td>    </tr>
    <?php endforeach; ?>
    <?php if ($sp_mcq_question_counts == 0) :?>
        <tr>
        <td colspan="100">
         Mcq Exam data is not available
        </td>
        </tr>
    <?php endif; ?>
<?php foreach ($sp_mcq_questions as $sp_mcq_question):
    $questions = get_no_of_question($sp_mcq_question->id); ?>
    <tr>
        <!-- <td width="5">
            <input type="checkbox" class="flat-red check" name="id[]" value="<?= $sp_mcq_question->id; ?>">
        </td> -->

        <!-- <td><?php if ($sp_mcq_question->course_id) {

                        echo  $sp_mcq_question->sp_course_name;
                    } ?> </td> -->
        <td><span class="list_group-id"><?= _ent(++$offset); ?></span></td>
        <td><span class="list_group-course_id"><?= _ent($sp_mcq_question->sp_course_name); ?></span></td>
        <td><span class="list_group-chapter_id"><?= _ent($sp_mcq_question->chapter_name); ?></span></td>
        <td><?php if ($sp_mcq_question->topic_id) {

                echo  $sp_mcq_question->sp_topic_name;
            } ?> </td>

        <td><span class="list_group-no_of_options"><?= _ent($sp_mcq_question->no_of_options); ?></span></td>
        <td><span class="list_group-questions"><?php echo $questions; ?></span></td>
        <td width="220">
            <a href="<?= admin_site_url('/sp_mcq_question/question/' . $sp_mcq_question->id); ?>" data-id="<?= $sp_mcq_question->id ?>" class="btn btn-flat btn-success btn_add_new"><i class="fa fa-plus-square-o "></i> <?= cclang('question') ?> </a>
            <?php if ($sp_mcq_question->is_publish == 0) { ?>
                <button class="publish_practise" data-id="<?php echo $sp_mcq_question->id; ?>">Publish</button>
            <?php } ?>
            <?php if (check_role_exist_or_not(13, array("edit"))) { ?>
                <a href="<?= admin_site_url('/sp_mcq_question/edit/' . $sp_mcq_question->id); ?>" data-id="<?= $sp_mcq_question->id ?>" class="label-default btn-act-edit"><i class="fa fa-edit "></i> </a>
            <?php }
            if (check_role_exist_or_not(13, array("delete"))) { ?>
                <a href="javascript:void(0);" data-href="<?= admin_site_url('/sp_mcq_question/delete/' . $sp_mcq_question->id); ?>" class="label-default remove-data"><i class="fa fa-close"></i> </a>
            <?php } ?>
        </td>
    </tr>
<?php endforeach; ?>
<?php if ($sp_mcq_question_counts == 0) : ?>
    <tr>
        <td colspan="100">
            Mcq data is not available
        </td>
    </tr>
<?php endif; ?>
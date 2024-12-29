<?php foreach ($sp_topics as $sp_topic): ?>
    <tr>
        <!-- <td width="5">
            <input type="checkbox" class="flat-red check" name="id[]" value="<?= $sp_topic->id; ?>">
        </td> -->

        <!-- <td><?php if ($sp_topic->course_id) {

                        echo  $sp_topic->sp_course_name;
                    } ?> </td> -->
        <td><span class="list_group-id"><?= _ent(++$offset); ?></span></td>
        <td><?php echo $sp_topic->sp_course_name;?></td>
        <td><?php if ($sp_topic->chapter_id) {

                echo  $sp_topic->sp_chapter_name;
            } ?> </td>

        <td><span class="list_group-topic_no"><?= _ent($sp_topic->topic_no); ?></span></td>
        <td><span class="list_group-name"><?= _ent($sp_topic->name); ?></span></td>
        <td width="200">
            <?php if (check_role_exist_or_not(11, array("edit"))) { ?>
                <a href="<?= admin_site_url('/sp_topic/edit/' . $sp_topic->id); ?>" data-id="<?= $sp_topic->id ?>" class="label-default btn-act-edit"><i class="fa fa-edit "></i> </a>
            <?php } ?>
            <?php if (check_role_exist_or_not(11, array("delete"))) { ?>
                <a href="javascript:void(0);" data-href="<?= admin_site_url('/sp_topic/delete/' . $sp_topic->id); ?>" class="label-default remove-data"><i class="fa fa-close"></i> </a>
            <?php } ?>

        </td>
    </tr>
<?php endforeach; ?>
<?php if ($sp_topic_counts == 0) : ?>
    <tr>
        <td colspan="100">
            Topic data is not available
        </td>
    </tr>
<?php endif; ?>
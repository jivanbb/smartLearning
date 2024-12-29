<?php foreach ($sp_courses as $sp_course): ?>
    <tr>

        <!-- <td><span class="list_group-id"><?= _ent($sp_course->id); ?></span></td>  -->
        <td><span class="list_group-board_university"><?= _ent($sp_course->board_name); ?></span></td>
        <td><span class="list_group-name"><?= _ent($sp_course->name); ?></span></td>
        <td><span class="list_group-amount"><?= _ent($sp_course->amount); ?></span></td>
        <td><span class="list_group-valid_days"><?= _ent($sp_course->valid_days); ?></span></td>
        <td> <?php if (!empty($sp_course->image)): ?>
                <?php if (is_image($sp_course->image)): ?>
                    <a class="fancybox" rel="group" href="<?= BASE_URL . 'uploads/sp_course/' . $sp_course->image; ?>">
                        <img src="<?= BASE_URL . 'uploads/sp_course/' . $sp_course->image; ?>" class="image-responsive" alt="image sp_course" title="image sp_course" width="40px">
                    </a>
                <?php else: ?>
                    <a href="<?= BASE_URL . 'uploads/sp_course/' . $sp_course->image; ?>" target="blank">
                        <img src="<?= get_icon_file($sp_course->image); ?>" class="image-responsive image-icon" alt="image sp_course" title="image <?= $sp_course->image; ?>" width="40px">
                    </a>
                <?php endif; ?>
            <?php endif; ?></td>
        <td>                  <?php if (check_role_exist_or_not(9, array( "edit"))) { ?>
             <a href="<?= admin_site_url('/sp_course/edit/' . $sp_course->id); ?>" data-id="<?= $sp_course->id ?>" class="label-default btn-act-edit"><i class="fa fa-edit "></i> </a>
             <?php }?>
             <?php if (check_role_exist_or_not(9, array( "delete"))) { ?>
            <a href="javascript:void(0);" data-href="<?= admin_site_url('/sp_course/delete/' . $sp_course->id); ?>" class="label-default remove-data"><i class="fa fa-close"></i> </a>
            <?php }?>
        </td>
    </tr>
<?php endforeach; ?>
<?php if ($sp_course_counts == 0) : ?>
    <tr>
        <td colspan="100">
            Course data is not available
        </td>
    </tr>
<?php endif; ?>
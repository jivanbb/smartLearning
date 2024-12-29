<?php foreach ($sp_chapters as $sp_chapter): ?>
    <tr>
        <!-- <td width="5">
            <input type="checkbox" class="flat-red check" name="id[]" value="<?= $sp_chapter->id; ?>">
        </td> -->

        <td><?php if ($sp_chapter->course_id) {

                echo  $sp_chapter->sp_course_name;
            } ?> </td>

        <td><span class="list_group-name"><?= _ent($sp_chapter->name); ?></span></td>
        <td width="200">

            <?php if (check_role_exist_or_not(10, array("edit"))) { ?>
                <a href="<?= admin_site_url('/sp_chapter/edit/' . $sp_chapter->id); ?>" data-id="<?= $sp_chapter->id ?>" class="label-default btn-act-edit"><i class="fa fa-edit "></i> </a>
            <?php } ?>
            <?php if (check_role_exist_or_not(10, array("delete"))) { ?>
                <a href="javascript:void(0);" data-href="<?= admin_site_url('/sp_chapter/delete/' . $sp_chapter->id); ?>" class="label-default remove-data"><i class="fa fa-close"></i> </a>
            <?php } ?>

        </td>
    </tr>
<?php endforeach; ?>
<?php if ($sp_chapter_counts == 0) : ?>
    <tr>
        <td colspan="100">
            Chapter data is not available
        </td>
    </tr>
<?php endif; ?>
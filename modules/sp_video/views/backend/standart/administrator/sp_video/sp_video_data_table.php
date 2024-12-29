<?php foreach($sp_videos as $sp_video): ?>
    <tr>
                <!-- <td width="5">
            <input type="checkbox" class="flat-red check" name="id[]" value="<?= $sp_video->id; ?>">
        </td> -->
                
        <td><span class="list_group-course_id"><?= _ent($sp_video->course_name); ?></span></td> 
        <td><span class="list_group-chapter_id"><?= _ent($sp_video->chapter_name); ?></span></td> 
        <td><span class="list_group-topic_id"><?= _ent($sp_video->topic_name); ?></span></td> 
        <td>
            <?php foreach (explode(',', $sp_video->materials) as $file): ?>
            <?php if (!empty($file)): ?>
            <?php if (is_image($file)): ?>
            <a class="fancybox" rel="group" href="<?= BASE_URL . 'uploads/sp_video/' . $file; ?>">
                <img src="<?= BASE_URL . 'uploads/sp_video/' . $file; ?>" class="image-responsive" alt="image sp_video" title="materials sp_video" width="40px">
            </a>
            <?php else: ?>
                <a href="<?= BASE_URL . 'uploads/sp_video/' . $file; ?>" target="blank">
                <img src="<?= get_icon_file($file); ?>" class="image-responsive image-icon" alt="image sp_video" title="materials <?= $file; ?>" width="40px"> 
                </a>
            <?php endif; ?>
            <?php endif; ?>
            <?php endforeach; ?>
        </td>
         
        <td width="200">
            <?php if (check_role_exist_or_not(26, array("edit"))) {?>
            <a href="<?= admin_site_url('/sp_video/edit/' . $sp_video->id); ?>" data-id="<?= $sp_video->id ?>" class="label-default btn-act-edit"><i class="fa fa-edit "></i></a>
            <?php }if (check_role_exist_or_not(26, array("delete"))) { ?>
            <a href="javascript:void(0);" data-href="<?= admin_site_url('/sp_video/delete/' . $sp_video->id); ?>" class="label-default remove-data"><i class="fa fa-close"></i> </a>
            <?php } ?>

        </td>    </tr>
    <?php endforeach; ?>
    <?php if ($sp_video_counts == 0) :?>
        <tr>
        <td colspan="100">
         Materials data is not available
        </td>
        </tr>
    <?php endif; ?>
<?php foreach($sp_materialss as $sp_materials): ?>
    <tr>
                <!-- <td width="5">
            <input type="checkbox" class="flat-red check" name="id[]" value="<?= $sp_materials->id; ?>">
        </td> -->
                
        <td><span class="list_group-course_id"><?= _ent($sp_materials->course_name); ?></span></td> 
        <td><span class="list_group-chapter_id"><?= _ent($sp_materials->chapter_name); ?></span></td> 
        <td><span class="list_group-topic_id"><?= _ent($sp_materials->topic_name); ?></span></td> 
        <td>
            <?php foreach (explode(',', $sp_materials->materials) as $file): ?>
            <?php if (!empty($file)): ?>
            <?php if (is_image($file)): ?>
            <a class="fancybox" rel="group" href="<?= BASE_URL . 'uploads/sp_materials/' . $file; ?>">
                <img src="<?= BASE_URL . 'uploads/sp_materials/' . $file; ?>" class="image-responsive" alt="image sp_materials" title="materials sp_materials" width="40px">
            </a>
            <?php else: ?>
                <a href="<?= BASE_URL . 'uploads/sp_materials/' . $file; ?>" target="blank">
                <img src="<?= get_icon_file($file); ?>" class="image-responsive image-icon" alt="image sp_materials" title="materials <?= $file; ?>" width="40px"> 
                </a>
            <?php endif; ?>
            <?php endif; ?>
            <?php endforeach; ?>
        </td>
         
        <td width="200">
            <?php if (check_role_exist_or_not(16, array("edit"))) {?>
            <a href="<?= admin_site_url('/sp_materials/edit/' . $sp_materials->id); ?>" data-id="<?= $sp_materials->id ?>" class="label-default btn-act-edit"><i class="fa fa-edit "></i></a>
            <?php }if (check_role_exist_or_not(16, array("delete"))) { ?>
            <a href="javascript:void(0);" data-href="<?= admin_site_url('/sp_materials/delete/' . $sp_materials->id); ?>" class="label-default remove-data"><i class="fa fa-close"></i> </a>
            <?php } ?>

        </td>    </tr>
    <?php endforeach; ?>
    <?php if ($sp_materials_counts == 0) :?>
        <tr>
        <td colspan="100">
         Materials data is not available
        </td>
        </tr>
    <?php endif; ?>
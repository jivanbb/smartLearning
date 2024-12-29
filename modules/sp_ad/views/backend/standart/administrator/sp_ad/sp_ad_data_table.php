<?php foreach ($sp_ads as $sp_ad): ?>
    <tr>
        <td><span class="list_group-title"><?= _ent($sp_ad->title); ?></span></td>
        <td>
            <?php if (!empty($sp_ad->image)): ?>
                <?php if (is_image($sp_ad->image)): ?>
                    <a class="fancybox" rel="group" href="<?= BASE_URL . 'uploads/sp_ad/' . $sp_ad->image; ?>">
                        <img src="<?= BASE_URL . 'uploads/sp_ad/' . $sp_ad->image; ?>" class="image-responsive" alt="image sp_ad" title="image sp_ad" width="40px">
                    </a>
                <?php else: ?>
                    <a href="<?= BASE_URL . 'uploads/sp_ad/' . $sp_ad->image; ?>" target="blank">
                        <img src="<?= get_icon_file($sp_ad->image); ?>" class="image-responsive image-icon" alt="image sp_ad" title="image <?= $sp_ad->image; ?>" width="40px">
                    </a>
                <?php endif; ?>
            <?php endif; ?>
        </td>

        <td><span class="list_group-link"><?= _ent($sp_ad->link); ?></span></td>
        <td><span class="list_group-order"><?= _ent($sp_ad->order); ?></span></td>
        <td><?= _ent($sp_ad->type); ?></td>
        <td width="200">
                <a href="<?= admin_site_url('/sp_ad/edit/' . $sp_ad->id); ?>" data-id="<?= $sp_ad->id ?>" class="label-default btn-act-edit"><i class="fa fa-edit "></i> </a>
                <a href="javascript:void(0);" data-href="<?= admin_site_url('/sp_ad/delete/' . $sp_ad->id); ?>" class="label-default remove-data"><i class="fa fa-close"></i> </a>

        </td>
    </tr>
<?php endforeach; ?>
<?php if ($sp_ad_counts == 0) : ?>
    <tr>
        <td colspan="100">
            Advertisement data is not available
        </td>
    </tr>
<?php endif; ?>
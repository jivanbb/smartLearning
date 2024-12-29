<?php foreach($sp_levels as $sp_level): ?>
    <tr>
                <td width="5">
            <input type="checkbox" class="flat-red check" name="id[]" value="<?= $sp_level->id; ?>">
        </td>
                
        <td><span class="list_group-name"><?= _ent($sp_level->name); ?></span></td> 
        <td width="200">
        

            <?php is_allowed('sp_level_update', function() use ($sp_level){?>
            <a href="<?= admin_site_url('/sp_level/edit/' . $sp_level->id); ?>" data-id="<?= $sp_level->id ?>" class="label-default btn-act-edit"><i class="fa fa-edit "></i> </a>
            <?php }) ?>
            <?php is_allowed('sp_level_delete', function() use ($sp_level){?>
            <a href="javascript:void(0);" data-href="<?= admin_site_url('/sp_level/delete/' . $sp_level->id); ?>" class="label-default remove-data"><i class="fa fa-close"></i> </a>
            <?php }) ?>

        </td>    </tr>
    <?php endforeach; ?>
    <?php if ($sp_level_counts == 0) :?>
        <tr>
        <td colspan="100">
         Level data is not available
        </td>
        </tr>
    <?php endif; ?>
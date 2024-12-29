<?php foreach($sp_sets as $sp_set): ?>
    <tr>  
    <td><span class="list_group-id"><?= _ent(++$offset); ?></span></td>           
        <td><span class="list_group-name"><?= _ent($sp_set->name); ?></span></td> 
        <td><?= _ent($sp_set->no_of_question); ?></td>
        <td width="200">
        
        <?php if (check_role_exist_or_not(21, array( "edit"))) { ?>
            <a href="<?= admin_site_url('/sp_set/edit/' . $sp_set->id); ?>" data-id="<?= $sp_set->id ?>" class="label-default btn-act-edit"><i class="fa fa-edit "></i> </a>
             <?php } ?> 
             <?php if (check_role_exist_or_not(21, array( "delete"))) { ?>
            <a href="javascript:void(0);" data-href="<?= admin_site_url('/sp_set/delete/' . $sp_set->id); ?>" class="label-default remove-data"><i class="fa fa-close"></i> </a>
             <?php } ?> 

        </td>    </tr>
    <?php endforeach; ?>
    <?php if ($sp_set_counts == 0) :?>
        <tr>
        <td colspan="100">
        set data is not available
        </td>
        </tr>
    <?php endif; ?>
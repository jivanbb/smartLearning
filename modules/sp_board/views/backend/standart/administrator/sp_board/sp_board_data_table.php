<?php foreach($sp_boards as $sp_board): ?>
    <tr>  
    <td><span class="list_group-id"><?= _ent(++$offset); ?></span></td>           
        <td><span class="list_group-name"><?= _ent($sp_board->name); ?></span></td> 
        <td width="200">
        
        <?php if (check_role_exist_or_not(8, array( "edit"))) { ?>
            <a href="<?= admin_site_url('/sp_board/edit/' . $sp_board->id); ?>" data-id="<?= $sp_board->id ?>" class="label-default btn-act-edit"><i class="fa fa-edit "></i> </a>
             <?php } ?> 
             <?php if (check_role_exist_or_not(8, array( "delete"))) { ?>
            <a href="javascript:void(0);" data-href="<?= admin_site_url('/sp_board/delete/' . $sp_board->id); ?>" class="label-default remove-data"><i class="fa fa-close"></i> </a>
             <?php } ?> 

        </td>    </tr>
    <?php endforeach; ?>
    <?php if ($sp_board_counts == 0) :?>
        <tr>
        <td colspan="100">
        Board data is not available
        </td>
        </tr>
    <?php endif; ?>
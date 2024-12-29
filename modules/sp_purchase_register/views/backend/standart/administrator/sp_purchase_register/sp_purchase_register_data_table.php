<?php foreach($sp_purchase_registers as $purchase): ?>
    <tr>  
    <td><span class="list_group-id"><?= _ent(++$offset); ?></span></td>           
        <td><?php echo $purchase->pan_no?></td> 
        <td><?php echo $purchase->name?></td> 
        <td><?php echo $purchase->year?></td>
        <td><?php echo $purchase->tax_period?></td>
        <td width="200">
        
        <?php if (check_role_exist_or_not(29, array( "view"))) { ?>
            <a href="<?= admin_site_url('/sp_purchase_register/view/' . $purchase->id); ?>" data-id="<?= $purchase->id ?>" class="label-default btn-act-edit"><i class="fa fa-eye "></i> </a>
             <?php } ?> 
             <?php if (check_role_exist_or_not(29, array( "edit"))) { ?>
            <a href="<?= admin_site_url('/sp_purchase_register/edit/' . $purchase->id); ?>" data-id="<?= $purchase->id ?>" class="label-default btn-act-edit"><i class="fa fa-edit "></i> </a>
             <?php } ?> 
             <?php if (check_role_exist_or_not(29, array( "delete"))) { ?>
            <a href="javascript:void(0);" data-href="<?= admin_site_url('/sp_sales/delete/' . $purchase->id); ?>" class="label-default remove-data"><i class="fa fa-close"></i> </a>
             <?php } ?> 

        </td>    </tr>
    <?php endforeach; ?>
    <?php if ($sp_purchase_register_counts == 0) :?>
        <tr>
        <td colspan="100">
       Purchase Register data is not available
        </td>
        </tr>
    <?php endif; ?>
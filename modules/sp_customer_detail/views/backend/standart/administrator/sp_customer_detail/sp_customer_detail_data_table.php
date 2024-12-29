<?php foreach($sp_customer_details as $customer_detail): ?>
    <tr>  
    <td><span class="list_group-id"><?= _ent(++$offset); ?></span></td>           
        <td><span class="list_group-name"><?= _ent($customer_detail->name); ?></span></td> 
        <td><span class="list_group-pan_no"><?= _ent($customer_detail->pan_no); ?></span></td> 
        <td><span class="list_group-address"><?= _ent($customer_detail->address); ?></span></td>
        <td><span class="list_group-is_client"><?php if($customer_detail->is_client){ echo "Yes";}else{ echo "No";} ?></span></td>
        <td><?= _ent($customer_detail->email); ?></td>
        <td><?= _ent($customer_detail->phone_no); ?></td>
        <td width="200">
        
        <?php if (check_role_exist_or_not(28, array( "edit"))) { ?>
            <a href="<?= admin_site_url('/sp_customer_detail/edit/' . $customer_detail->id); ?>" data-id="<?= $customer_detail->id ?>" class="label-default btn-act-edit"><i class="fa fa-edit "></i> </a>
             <?php } ?> 
             <?php if (check_role_exist_or_not(28, array( "delete"))) { ?>
            <a href="javascript:void(0);" data-href="<?= admin_site_url('/sp_customer_detail/delete/' . $customer_detail->id); ?>" class="label-default remove-data"><i class="fa fa-close"></i> </a>
             <?php } ?> 

        </td>    </tr>
    <?php endforeach; ?>
    <?php if ($sp_customer_detail_counts == 0) :?>
        <tr>
        <td colspan="100">
        Customer Detail data is not available
        </td>
        </tr>
    <?php endif; ?>
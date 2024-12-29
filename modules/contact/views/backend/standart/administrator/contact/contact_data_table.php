<?php foreach($contacts as $contact): ?>
    <tr>     
        <td><span class="list_group-name"><?= _ent($contact->name); ?></span></td> 
        <td><span class="list_group-email"><?= _ent($contact->email); ?></span></td> 
        <td><span class="list_group-phone_no"><?= _ent($contact->phone_no); ?></span></td> 
        <td><span class="list_group-subject"><?= _ent($contact->subject); ?></span></td> 
        <td><span class="list_group-description"><?= _ent($contact->description); ?></span></td> 
    </tr>
    <?php endforeach; ?>
    <?php if ($contact_counts == 0) :?>
        <tr>
        <td colspan="100">
    Contact data is not available
        </td>
        </tr>
    <?php endif; ?>
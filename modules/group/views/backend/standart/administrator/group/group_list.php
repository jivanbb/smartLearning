<section class="content-header">
   <h1>
      Role
      <small><?= cclang('list_all'); ?></small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Role</li>
   </ol>
</section>

<section class="content">
   <div class="row">
      <div class="col-md-12">
         <div class="box box-warning">
            <div class="box-body ">
               <div class="box box-widget widget-user-2">
                  <div class="widget-user-header ">

                  <form name="form_group" id="form_group" action="<?= admin_base_url('/group/index'); ?>">

                     <div class="table-responsive">
                        <table class="table table-bordered table-striped dataTable">
                           <thead>
                              <tr>
                                 <th data-field="name" data-sort="1">Name</th>
                                 <th data-field="definition" data-sort="1">Definition</th>
                                 <!-- <th>Action</th> -->
                              </tr>
                           </thead>
                           <tbody id="tbody_group">
                              <?php foreach ($groups as $group) : ?>
                                 <tr>
   
                                    <td><?= _ent($group->name); ?></td>
                                    <td><?= _ent($group->definition); ?></td>
                                    <!-- <td width="200">
                                       <?php is_allowed('group_view', function () use ($group) { ?>
                                          <a href="<?= admin_site_url('/group/view/' . $group->id); ?>" class="label-default"><i class="fa fa-newspaper-o"></i> <?= cclang('view_button'); ?>
                                          <?php }) ?>

                                          <?php is_allowed('group_update', function () use ($group) { ?>
                                             <a href="<?= admin_site_url('/group/edit/' . $group->id); ?>" class="label-default"><i class="fa fa-edit "></i> <?= cclang('update_button'); ?></a>
                                          <?php }) ?>

                                          <?php is_allowed('group_delete', function () use ($group) { ?>
                                             <a href="javascript:void(0);" data-href="<?= admin_site_url('/group/delete/' . $group->id); ?>" class="label-default remove-data"><i class="fa fa-close"></i> <?= cclang('remove_button'); ?></a>
                                          <?php }) ?>
                                    </td> -->
                                 </tr>
                              <?php endforeach; ?>
                              <?php if ($group_counts == 0) : ?>
                                 <tr>
                                    <td colspan="100">
                                       <?= cclang('data_is_not_avaiable', 'Group'); ?>
                                    </td>
                                 </tr>
                              <?php endif; ?>
                           </tbody>
                        </table>
                     </div>
               </div>
               <hr>

               <!-- <div class="row">
                  <div class="col-md-8">
                     <div class="col-sm-2 padd-left-0 ">
                        <select type="text" class="form-control chosen chosen-select" name="bulk" id="bulk" placeholder="Site Email">
                           <option value="">Bulk</option>
                           <option value="delete"><?= cclang('delete'); ?></option>
                        </select>
                     </div>
                     <div class="col-sm-2 padd-left-0 ">
                        <button type="button" class="btn btn-flat" name="apply" id="apply" title="apply bulk actions"><?= cclang('apply_button'); ?></button>
                     </div>
                     <div class="col-sm-3 padd-left-0  ">
                        <input type="text" class="form-control" name="q" id="filter" placeholder="Filter" value="<?= $this->input->get('q'); ?>">
                     </div>
                     <div class="col-sm-3 padd-left-0 ">
                        <select type="text" class="form-control chosen chosen-select" name="f" id="field">
                           <option value=""><?= cclang('all'); ?></option>
                           <option <?= $this->input->get('f') == 'id' ? 'selected' : ''; ?> value="id">ID</option>
                           <option <?= $this->input->get('f') == 'name' ? 'selected' : ''; ?> value="name">Name</option>
                           <option <?= $this->input->get('f') == 'definition' ? 'selected' : ''; ?> value="definition">Definition</option>
                        </select>
                     </div>
                     <div class="col-sm-1 padd-left-0 ">
                        <button type="submit" class="btn btn-flat" name="sbtn" id="sbtn" value="Apply" title="<?= cclang('filter_search'); ?>">
                           Filter
                        </button>
                     </div>
                     <div class="col-sm-1 padd-left-0 ">
                        <a class="btn btn-default btn-flat" name="reset" id="reset" value="Apply" href="<?= admin_base_url('/group'); ?>" title="<?= cclang('reset_filter'); ?>">
                           <i class="fa fa-undo"></i>
                        </a>
                     </div>
                  </div>
                  <?= form_close(); ?>
                  <div class="col-md-4">
                     <div class="dataTables_paginate paging_simple_numbers pull-right" id="example2_paginate">
                        <?= $pagination; ?>
                     </div>
                  </div>
               </div> -->
            </div>
         </div>
      </div>
   </div>
</section>


<script src="<?= BASE_ASSET ?>js/page/group/group-list.js"></script>
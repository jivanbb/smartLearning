<link href="<?= BASE_ASSET ?>fine-upload/fine-uploader-gallery.min.css" rel="stylesheet">
<script src="<?= BASE_ASSET ?>fine-upload/jquery.fine-uploader.js"></script>

<?php $this->load->view('core_template/fine_upload'); ?>

<section class="content-header">
    <h1>
        User
        <small><?= cclang('update', 'Profile'); ?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?= admin_site_url('/user'); ?>">User</a></li>
        <li class="active"><?= cclang('update', 'Profile'); ?></li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-warning">
                <div class="box-body ">

                    <div class="box box-widget widget-user-2">

                        <!-- <div class="widget-user-header ">
                            <div class="widget-user-image">
                                <img class="img-circle" src="<?= BASE_ASSET ?>img/add2.png" alt="User Avatar">
                            </div>

                            <h3 class="widget-user-username">User</h3>
                            <h5 class="widget-user-desc"><?= cclang('update', 'Profile'); ?></h5>
                            <hr>
                        </div> -->
                        <?= form_open(admin_base_url('/user/edit_profile_save/' . $this->uri->segment(4)), [
                            'name'    => 'form_user',
                            'class'   => 'form-horizontal',
                            'id'      => 'form_user',
                            'enctype' => 'multipart/form-data',
                            'method'  => 'POST'
                        ]); ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label for="username" class="col-sm-3 control-label">Username <i class="required">*</i></label>

                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="username" id="username" placeholder="Username" value="<?= set_value('username', $user->username); ?>">

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label for="email" class="col-sm-3 control-label">Email <i class="required">*</i></label>

                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="email" id="email" placeholder="Email" value="<?= set_value('email', $user->email); ?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label for="full_name" class="col-sm-3 control-label">Full Name <i class="required">*</i></label>

                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="full_name" id="full_name" placeholder="Full Name" value="<?= set_value('full_name', $user->full_name); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label for="full_name" class="col-sm-3 control-label">Phone <i class="required">*</i></label>

                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="phone_no" id="phone" placeholder="Phone" value="<?= set_value('phone', $user->phone_no); ?>">
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <?php if (!empty($user->education)) { ?>
                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label for="full_name" class="col-sm-3 control-label">Education </label>

                                        <div class="col-sm-9">
                                            <select class="form-control chosen chosen-select-deselect" name="education" id="education" data-placeholder="Select Education">
                                                <option value=""></option>
                                                <?php $conditions = []; ?>
                                                <?php foreach (db_get_all_data('sp_education', $conditions) as $row): ?>
                                                    <option <?= $user->education == $row->id ? 'selected' : ''; ?> value="<?= $row->id ?>"><?= $row->name; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            <?php }
                            if (!empty($user->specialization)) { ?>
                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label for="full_name" class="col-sm-3 control-label">Specialization </label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="specialization" id="specialization" placeholder="Specialization" value="<?= set_value('specialization', $user->specialization); ?>">
                                        </div>
                                    </div>
                                </div>
                        </div>
                    <?php }  ?>
                    <div class="row">
                        <?php if (!empty($user->experience)) { ?>
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label for="full_name" class="col-sm-3 control-label">Experience </label>

                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="experience" id="experience" placeholder="Experience" value="<?= set_value('experience', $user->experience); ?>">
                                    </div>
                                </div>
                            </div>
                        <?php }
                        if (!empty($user->address)) { ?>
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label for="full_name" class="col-sm-3 control-label">Address </label>

                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="address" id="address" placeholder="Address" value="<?= set_value('address', $user->address); ?>">
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <?php if (!empty($user->address)) { ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="topic_id" class="col-sm-2 control-label">Description </label>
                                    <div class="col-sm-10">
                                        <textarea name="description" rows="2" cols="140"><?php echo $user->address; ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="form-group ">
                        <label for="username" class="col-sm-2 control-label">Avatar </label>

                        <div class="col-sm-8">
                            <div id="user_avatar_galery" src="<?= BASE_URL . 'uploads/user/' . $user->avatar; ?>"></div>
                            <input name="user_avatar_uuid" id="user_avatar_uuid" type="hidden" value="<?= set_value('user_avatar_uuid'); ?>">
                            <input name="user_avatar_name" id="user_avatar_name" type="hidden" value="<?= set_value('user_avatar_name', $user->avatar); ?>">
                            <small class="info help-block">
                                Format file must PNG, JPEG.
                            </small>
                        </div>
                    </div>

                    <div class="message">
                    </div>

                    <div class="row-fluid col-md-7">
                        <button class="btn btn-flat btn-primary btn_save btn_action" id="btn_save" data-stype='stay' title="save (Ctrl+s)"><i class="fa fa-save"></i> <?= cclang('save_button'); ?></button>
                        <a class="btn btn-flat btn-info btn_save btn_action btn_save_back" id="btn_save" data-stype='back' title="<?= cclang('save_and_go_the_list_button'); ?> (Ctrl+d)"><i class="ion ion-ios-list-outline"></i> <?= cclang('save_and_go_the_list_button'); ?></a>
                        <a class="btn btn-flat btn-default btn_action" id="btn_cancel" title="<?= cclang('cancel_button'); ?> (Ctrl+x)"><i class="fa fa-undo"></i> <?= cclang('cancel_button'); ?></a>
                        <span class="loading loading-hide"><img src="<?= BASE_ASSET ?>img/loading-spin-primary.svg"> <i><?= cclang('loading_saving_data'); ?></i></span>
                    </div>
                    <?= form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="<?= BASE_ASSET ?>js/page/user/user-update-profile.js"></script>
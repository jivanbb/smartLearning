<script src="<?= BASE_ASSET; ?>/js/jquery.hotkeys.js"></script>
<script type="text/javascript">
    function domo() {

    // Binding keys
    $('*').bind('keydown', 'Ctrl+s', function assets() {
        $('#btn_save').trigger('click');
        return false;
    });

    $('*').bind('keydown', 'Ctrl+x', function assets() {
        $('#btn_cancel').trigger('click');
        return false;
    });

    $('*').bind('keydown', 'Ctrl+d', function assets() {
        $('.btn_save_back').trigger('click');
        return false;
    });

}

jQuery(document).ready(domo);
</script>
<!-- Content Header (Page header) -->
<section class="content-header new-july-design">

    <div class="row">
        <div class="col-lg-8">
            <ul class="nav nav-pills tabs-account" id="myTab">
                <!-- <li role="presentation" class="dropdown active">
            <a href="<?php echo base_url(); ?>administrator/oms_party" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Setup<span class="caret"></span></a>
            <ul class="dropdown-menu">
             <li><a href="<?php echo base_url(); ?>administrator/oms_day_close_ledger">Day close Ledger</a></li>
             <li><a href="<?php echo base_url(); ?>administrator/oms_fiscal_year">Fiscal Year</a></li>
             <li><a href="<?= base_url('administrator/oms_voucher_type');?>">Voucher Type</a></li>
              <li><a href="<?= base_url('administrator/oms_ledger_group');?>">Group Creation</a></li>
<li><a href="<?= base_url('administrator/oms_ledger');?>">Ledger Creation</a></li>
             <li><a href="<?= base_url('administrator/oms_opening_ledger');?>">Opening Ledger</a></li>
           </ul>
       </li> -->
       <li><a href="<?= base_url('administrator/user');?>">User</a></li>
       <li class="active"><a href="<?= base_url('administrator/oms_module');?>">Module</a></li>
       <li><a href="<?= base_url('administrator/role');?>">Role</a></li>
   </ul>
</div>

</div>

</section>
<!-- Main content -->
<div class="tab-content new-july-design">
    <div class="tab-pane fade in active">
        <div class="col-lg-12">
            <section class="content">
                <div class="row">
                    <div class="col-md-12 p-0">
                        <div class="box box-warning">
                            <div class="box-body ">
                                <!-- Widget: user widget style 1 -->
                                <div class="box box-widget widget-user-2">
                                    <!-- Add the bg color to the header using any of the bg-* classes -->
                                    <div class="widget-user-header ">
                                        <div class="widget-user-image">
                                            <img class="img-circle" src="<?= BASE_ASSET; ?>/img/add2.png"
                                            alt="User Avatar">
                                        </div>
                                        <!-- /.widget-user-image -->
                                        <h3 class="widget-user-username">Module</h3>
                                        <h5 class="widget-user-desc"><?= cclang('new', ['Module']); ?></h5>
                                        <hr>
                                    </div>
                                    <?= form_open('', [
                                        'name'    => 'form_oms_module', 
                                        'class'   => 'form-horizontal', 
                                        'id'      => 'form_oms_module', 
                                        'enctype' => 'multipart/form-data', 
                                        'method'  => 'POST'
                                    ]); ?>
                                    <input type="hidden" value="<?= $menu_type_id; ?>" name="menu_type_id">


                                    <div class="form-group menu-only">
                                        <label for="content" class="col-sm-2 control-label"><?= cclang('label') ?>
                                    </label>

                                    <div class="col-sm-8">
                                        <input type="hidden" name="icon" id="icon">

                                        <div class="icon-preview">
                                            <span class="icon-preview-item"><i class="fa fa-rss fa-lg"></i></span>
                                        </div>

                                        <br>

                                        <a
                                        class="btn btn-default btn-select-icon btn-flat"><?= cclang('select_icon') ?></a>

                                        <select class="chosen  chosen-select-deselect" name="icon_color"
                                        id="icon_color" tabi-ndex="5" data-placeholder="Select Color">
                                        <option value="default">Default</option>
                                        <?php foreach ($color_icon as $color): ?>
                                            <option value="<?= $color; ?>"><?= ucwords($color); ?></option>
                                        <?php endforeach; ?>
                                    </select>

                                </div>
                            </div>
                       <!--              <div class="form-group">
                                        <label class="col-sm-2 control-label">Parent</label>
                                        <div class="col-sm-8">
                                            <select class="form form-control" name="parent">
                                                <option value="">Select</option>
                                                <?php 
                    foreach ($modules as $key => $module) { 

                      ?>
                                                <option value="<?php echo $module->id ?>"><?php echo $module->name; ?>
                                                </option>
                                                <?php getSubmodule($module->sub); ?>
                                                <?php
                    } ?>
                                            </select>
                                        </div>
                                    </div> -->

                                    <div class="form-group ">
                                      <label for="content"
                                      class="col-sm-2 control-label"><?= cclang('parent') ?></label>

                                      <div class="col-sm-8">
                                        <select class="form-control chosen  chosen-select-deselect" name="parent"
                                        id="parent" tabi-ndex="5" data-placeholder="Select Parent">
                                        <option value=""></option>
                                        < <?php foreach (get_custom_menu($this->model_menu->get_id_menu_type_by_flag('side-menu')) as $row): ?>
                                        <option value="<?= $row->id; ?>"><?= ucwords($row->name); ?>
                                    </option>
                                    <?php if (isset($row->children) and count($row->children)): ?>
                                    <?php create_childern($row->children, 0, 1); ?>
                                <?php endif ?>
                            <?php endforeach; ?>

                        </select>


                        <small class="info help-block">
                          Select one or more groups.
                      </small>
                  </div>
              </div> 
              <div class="form-group ">
                <label for="label" class="col-sm-2 control-label"><?= cclang('label') ?> <i
                    class="required">*</i></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="name" id="label"
                        placeholder="Label" value="<?= set_value('label'); ?>">
                        <small class="info help-block">The label of menu.</small>
                    </div>
                </div>


                <div class="form-group ">
                    <label for="link" class="col-sm-2 control-label"><?= cclang('link') ?> <i
                        class="required">*</i></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="link" id="link"
                            placeholder="Link" value="<?= set_value('link'); ?>">
                            <small class="info help-block">The link of menu <i>Example :
                            administrator/blog</i>.
                            short code <code>{{admin_url}}</code></small>
                        </div>
                    </div>


                    <div class="form-group ">
                        <label for="content"
                        class="col-sm-2 control-label"><?= cclang('menu_type') ?></label>

                        <div class="col-sm-8">
                            <label class="col-md-2 padding-left-0">
                                <input type="radio" name="type" class="flat-green menu_type"
                                value="menu" checked>
                                <?= cclang('menu') ?>
                            </label>
                            <label>
                                <input type="radio" name="type" class="flat-green menu_type"
                                value="label">
                                <?= cclang('label') ?>
                            </label>
                            <small class="info help-block">
                                Type Of Menu.
                            </small>
                        </div>
                    </div>
                        <div class="form-group">
                        <label for="content" class="col-sm-2 control-label label-part">
                     Role</label>
                        <div class="col-sm-8 ">
                             <div class="input-field-part">                     
                            <div class="row">
                                <div class="col-sm-2 ">
                                <label for="content" class="control-label label-part">Add</label>
                                <input type="checkbox"  name="add" value="1">
                                </div>
                                <div class="col-sm-2 ">
                                <label for="content" class=" control-label label-part">List</label>
                            <input type="checkbox"  name="list" value="1">
                                </div>
                                <div class="col-sm-2 ">
                                <label for="content" class=" control-label label-part">View</label>
                            <input type="checkbox"  name="view" value="1">
                                </div>
                                <div class="col-sm-2 ">
                                <label for="content" class=" control-label label-part">Edit</label>
                            <input type="checkbox"  name="edit" value="1">
                                </div>
                                <div class="col-sm-2 ">
                                <label for="content" class=" control-label label-part">Delete</label>
                            <input type="checkbox"  name="delete" value="1">
                                </div>                         
                                </div>                           
                            </div>
                        </div>
                        </div>
                      
                        <!-- <div class="form-group">
                        <label for="content" class="col-sm-2 control-label label-part">
                        Mobile Menu</label>
                        <div class="col-sm-8 ">
                            <div class="input-field-part">
                            <input type="checkbox"  name="mobile" value="1">
                            </div>
                        </div>
                        </div>
                        <div class="form-group">
                        <label for="content" class="col-sm-2 control-label label-part">
                        Self Only</label>
                        <div class="col-sm-8 ">
                            <div class="input-field-part">
                            <input type="checkbox"  name="self_only" value="1">
                            </div>
                        </div>
                        </div> -->
                                    <!-- 
            <div class="form-group">
              <label class="col-sm-2 control-label">Parent</label>
              <div class="col-sm-8">
                <select class="form form-control" name="parent" >
                  <option value="">Select</option>
                  <?php 
                  foreach ($modules as $key => $module) { 

                    ?>
                    <option value="<?php echo $module->id ?>"><?php echo $module->label; ?></option>
                    <?php getSubmodule($module->sub); ?>
                    <?php
                  } ?>
                </select>
              </div>
          </div> -->

          <!-- row end -->
          <div class="message"></div>
          <div class="row-fluid col-md-7">
            <button class="btn btn-flat btn-primary btn_save btn_action" id="btn_save"
            data-stype='stay' title="<?= cclang('save'); ?> (Ctrl+s)">
            <?= cclang('save'); ?>
        </button>
        <a class="btn btn-flat btn-info btn_save btn_action btn_save_back" id="btn_save"
        data-stype='back' title="<?= cclang('list'); ?> (Ctrl+d)">
        <?= cclang('save_and_list'); ?>
    </a>
    <a class="btn btn-flat btn-default btn_action" id="btn_cancel"
    title="<?= cclang('cancel'); ?> (Ctrl+x)">
    <?= cclang('cancel'); ?>
</a>
<span class="loading loading-hide">
    <img src="<?= BASE_ASSET; ?>/img/loading-spin-primary.svg">
    <i><?= cclang('loading_saving_data'); ?></i>
</span>
</div>
<?= form_close(); ?>
</div>
</div>
<!--/box body -->
</div>
<!--/box -->
</div>
</div>
</section>
</div>
<div class="clearfix"></div>
</div>
</div>
<div class="modal fade " tabindex="-1" role="dialog" id="modalIcon">
    <div class="modal-dialog full-width" role="document">
        <div class="modal-content">

            <div class="modal-body">
                <?php $this->load->view('backend/standart/administrator/sp_module/partial_icon'); ?>


            </div>
            <div class="modal-footer">
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- /.content -->
<script src="<?= BASE_ASSET; ?>ckeditor/ckeditor.js"></script>
<!-- Page script -->
<script>
    $(document).ready(function() {

        var parent = '<?= $this->input->get('parent') ?>';

        if (parent) {
            $('#parent').val(parent);
        }

        $('input[type="radio"].flat-green').iCheck({
            checkboxClass: 'icheckbox_minimal-red',
            radioClass: 'iradio_minimal-red'
        });
        /*icon*/


        $('.btn-select-icon').click(function(event) {
            event.preventDefault();

            $('#modalIcon').modal('show');
        });

        $('.icon-container').click(function(event) {
            $('#modalIcon').modal('hide');
            var icon = $(this).find('.icon-class').html();

            icon = $.trim(icon);

            $('#icon').val(icon);

            $('.icon-preview-item .fa').attr('class', 'fa fa-lg ' + icon);
        });

        $('#icon_color').change(function(event) {
            $('.icon-preview-item').attr('class', 'icon-preview-item ' + $(this).val());
        });

        function group_select() {
            var type = $('#category-icon-filter').val();
            $('.category-icon').hide();
            $('.category-icon#' + type).show();

            if (type == 'all') {
                $('.category-icon').show();
            }
        }

        $('#find-icon').keyup(function(event) {
            $('.icon-container').hide();
            $('.category-icon').show();
            $('#category-icon-filter').val('all')
            var search = $(this).val();

            $('.icon-class').each(function(index, el) {
                var str = $(this).html();
                var patt = new RegExp(search);
                var res = patt.test(str);

                if (res) {
                    $(this).parent('.icon-container').show();
                }
            });
            $('.category-icon').each(function(index, el) {
                if ($(this).find('.icon-container:visible').length) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });

        });

        $('.category-icon').each(function(index) {
            $('#category-icon-filter').append('<option value="' + $(this).attr('id') + '">' + $(this).attr(
                'id') + '</option>');
        });

        $('#category-icon-filter').change(function(event) {
            group_select();
        });

        $('#btn_cancel').click(function() {
            swal({
                title: "<?= cclang('are_you_sure'); ?>",
                text: "<?= cclang('data_to_be_deleted_can_not_be_restored'); ?>",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes!",
                cancelButtonText: "No!",
                closeOnConfirm: true,
                closeOnCancel: true
            },
            function(isConfirm) {
                if (isConfirm) {
                    window.location.href = BASE_URL + 'administrator/oms_module';
                }
            });

            return false;
        }); /*end btn cancel*/

        $('.btn_save').click(function() {
            $('.message').fadeOut();

            var form_oms_module = $('#form_oms_module');
            var data_post = form_oms_module.serializeArray();
            var save_type = $(this).attr('data-stype');

            data_post.push({
                name: 'save_type',
                value: save_type
            });

            $('.loading').show();

            $.ajax({
                url: BASE_URL + '/administrator/sp_module/add_save',
                type: 'POST',
                dataType: 'json',
                data: data_post,
            })
            .done(function(res) {
                if (res.success) {

                    if (save_type == 'back') {
                        window.location.href = res.redirect;
                        return;
                    }

                    $('.message').printMessage({
                        message: res.message
                    });
                    $('.message').fadeIn().delay(1000).fadeOut();
                    resetForm();
                    $('.chosen option').prop('selected', false).trigger('chosen:updated');

                } else {
                    $('.message').printMessage({
                        message: res.message,
                        type: 'warning'
                    });
                }

            })
            .fail(function() {
                $('.message').printMessage({
                    message: 'Error save data',
                    type: 'warning'
                });
            })
            .always(function() {
                $('.loading').hide();
                $('html, body').animate({
                    scrollTop: $(document).height()
                }, 2000);
            });

            return false;
        }); /*end btn save*/






    }); /*end doc ready*/
</script>

<?php 
function getSubmodule($sub_group,$sub_mark = '-') {

   foreach ($sub_group as $key => $data) {
      echo '<option value="'.$data->id.'">&nbsp; &nbsp; &nbsp; &nbsp;'.$sub_mark.' '.$data->name.'</option>';
      getSubmodule($data->sub,$sub_mark.' - ');
  }
} 

?>
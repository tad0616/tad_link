<h2 class="my"><{$smarty.const._MA_TADLINK_CATE_FORM}><{$smarty.const._TAD_FOR}><{$cate_title|default:''}></h2>
<form action="main.php" method="post" id="myForm" enctype="multipart/form-data" role="form">
    <div class="row">
        <{if $get_tad_link_cate_options|default:false}>
            <div class="col-sm-2">
                <div class="form-group mb-3">
                    <label class="form-label">
                        <{$smarty.const._MA_TADLINK_OF_CATE_SN}>
                    </label>
                    <select name="of_cate_sn" size=1 class="form-control form-select">
                        <option value=""></option>
                        <{$get_tad_link_cate_options|default:''}>
                    </select>
                </div>
            </div>
        <{/if}>
        <div class="col-sm-2">
            <div class="form-group mb-3">
                <label class="form-label">
                    <{$smarty.const._MA_TADLINK_CATE_TITLE}>
                </label>
                <input type="text" name="cate_title" value="<{$cate_title|default:''}>" id="cate_title" class="validate[required] form-control">
            </div>
        </div>

        <div class="col-sm-2">
            <div class="form-group mb-3">
                <label class="form-label">
                    <{$smarty.const._MA_TADLINK_CATE_BG}>
                </label>
                <div class="input-group">
                    <input type="text" name="cate_bg" class="form-control color-picker" value="<{$cate_bg|default:''}>" id="cate_bg" data-hex="true">
                </div>
            </div>
        </div>

        <div class="col-sm-2">
            <div class="form-group mb-3">
                <label class="form-label">
                    <{$smarty.const._MA_TADLINK_CATE_COLOR}>
                </label>
                <div class="input-group">
                    <input type="text" name="cate_color" id="cate_color" value="<{$cate_color|default:''}>" class="form-control color-picker" data-hex="true">
                </div>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="form-group">
                <label class="form-label">
                    <{$smarty.const._MA_TADLINK_SET_POST_POWER}>
                </label>
                <{$enable_post_group|default:''}>
            </div>
        </div>
        <div class="col-sm-2">
            <input type="hidden" name="cate_sn" value="<{$cate_sn|default:''}>">
            <input type="hidden" name="cate_sort" value="<{$cate_sort|default:''}>">
            <input type="hidden" name="op" value="<{$next_op|default:''}>">
            <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-disk" aria-hidden="true"></i> <{$smarty.const._TAD_EDIT}></button>
        </div>
    </div>
</form>
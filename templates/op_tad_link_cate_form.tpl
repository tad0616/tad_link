<h2 class="my"><{$cate_title}> <{$smarty.const._MA_TADLINK_CATE_FORM}></h2>
<form action="main.php" method="post" id="myForm" enctype="multipart/form-data" role="form" class="form-horizontal">
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group row mb-3">
                <label class="col-sm-4 control-label col-form-label text-sm-right">
                    <{$smarty.const._MA_TADLINK_OF_CATE_SN}>
                </label>
                <div class="col-sm-8">
                    <select name="of_cate_sn" size=1 class="form-control">
                        <option value=""></option>
                        <{$get_tad_link_cate_options}>
                    </select>
                </div>
            </div>
            <div class="form-group row mb-3">
                <label class="col-sm-4 control-label col-form-label text-sm-right">
                    <{$smarty.const._MA_TADLINK_CATE_TITLE}>
                </label>
                <div class="col-sm-8">
                    <input type="text" name="cate_title" value="<{$cate_title}>" id="cate_title" class="validate[required] form-control">
                </div>
            </div>

            <div class="form-group row mb-3">
                <label class="col-sm-4 control-label col-form-label text-sm-right">
                    <{$smarty.const._MA_TADLINK_CATE_BG}>
                </label>
                <div class="col-sm-8">
                    <input type="text" name="cate_bg" class="form-control color" value="<{$cate_bg}>" id="cate_bg" data-text="hidden" data-hex="true">
                </div>
            </div>
            <div class="form-group row mb-3">
                <label class="col-sm-4 control-label col-form-label text-sm-right">
                    <{$smarty.const._MA_TADLINK_CATE_COLOR}>
                </label>
                <div class="col-sm-8">
                    <input type="text" name="cate_color" class="form-control color" value="<{$cate_color}>" id="cate_color" data-text="hidden" data-hex="true">
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label class="control-label col-form-label text-sm-right">
                    <{$smarty.const._MA_TADLINK_SET_POST_POWER}>
                </label>
                <div>
                    <{$enable_post_group}>
                </div>
            </div>
            <div>
                <input type="hidden" name="cate_sn" value="<{$cate_sn}>">
                <input type="hidden" name="cate_sort" value="<{$cate_sort}>">
                <input type="hidden" name="op" value="<{$next_op}>">
                <button type="submit" class="btn btn-primary"><{$smarty.const._TAD_SAVE}></button>
            </div>
        </div>
    </div>


    <!--分類編號-->

</form>
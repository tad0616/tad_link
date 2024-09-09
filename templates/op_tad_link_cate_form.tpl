<h2 class="my"><{$cate_title}> <{$smarty.const._MA_TADLINK_CATE_FORM}></h2>
<form action="main.php" method="post" id="myForm" enctype="multipart/form-data" role="form">
    <div class="row">
        <{if $get_tad_link_cate_options}>
            <div class="col-sm-2">
                <div class="form-group mb-3">
                    <label class="form-label">
                        <{$smarty.const._MA_TADLINK_OF_CATE_SN}>
                    </label>
                    <select name="of_cate_sn" size=1 class="form-select">
                        <option value=""></option>
                        <{$get_tad_link_cate_options}>
                    </select>
                </div>
            </div>
        <{/if}>
        <div class="col-sm-2">
            <div class="form-group mb-3">
                <label class="form-label">
                    <{$smarty.const._MA_TADLINK_CATE_TITLE}>
                </label>
                <input type="text" name="cate_title" value="<{$cate_title}>" id="cate_title" class="validate[required] form-control">
            </div>
        </div>

        <div class="col-sm-2">
            <div class="form-group mb-3">
                <label class="form-label">
                    <{$smarty.const._MA_TADLINK_CATE_BG}>
                </label>
                <div class="input-group">
                    <input type="text" name="cate_bg" class="form-control color-picker" value="<{$cate_bg}>" id="cate_bg" data-hex="true">
                </div>
            </div>
        </div>

        <div class="col-sm-2">
            <div class="form-group mb-3">
                <label class="form-label">
                    <{$smarty.const._MA_TADLINK_CATE_COLOR}>
                </label>
                <div class="input-group">
                    <input type="text" name="cate_color" id="cate_color" value="<{$cate_color}>" class="form-control color-picker" data-hex="true">
                </div>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="form-group">
                <label class="form-label">
                    <{$smarty.const._MA_TADLINK_SET_POST_POWER}>
                </label>
                <{$enable_post_group}>
            </div>
        </div>
        <div class="col-sm-2">
            <input type="hidden" name="cate_sn" value="<{$cate_sn}>">
            <input type="hidden" name="cate_sort" value="<{$cate_sort}>">
            <input type="hidden" name="op" value="<{$next_op}>">
            <button type="submit" class="btn btn-primary"><{$smarty.const._TAD_SAVE}></button>
        </div>
    </div>


    <!--分類編號-->

</form>
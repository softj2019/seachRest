<div class="new-dt clearfix">
    <h2>많이 찾는 병원</h2>
    <ul class="dt-ul">
    <?php
    // parse to php object
    $data_object = json_decode($view["board"]["extravars"],true);

    if (element('latest', $view)) {
        foreach (element('latest', $view) as $key => $value) {
        ?>
        <li>
            <a href="<?php echo element('url', $value); ?>" class="thumbnail">
                <div class="dt-img" style="background-image: url(<?=my_base_url(element('layout_skin_url', $layout));?>/assets/img/new-icon.png);"></div>
                <div class="dt-txt">
                    <p class="dt-tit">
                        <?php if(element('category', $value)){?> [<?php echo html_escape(element('bca_value',element('category', $value))); ?>]<?php } ?>
                        <span><?php echo element('store_name',element('extravars', $value)); ?></span>
                    </p>
                    <div class="star-i flexcenter">
                        <i class="<?=round(element('post_review_average', $value))>=1?"ri-star-fill":"ri-star-line"?> yell"></i>
                        <i class="<?=round(element('post_review_average', $value))>=2?"ri-star-fill":"ri-star-line"?> yell"></i>
                        <i class="<?=round(element('post_review_average', $value))>=3?"ri-star-fill":"ri-star-line"?> yell"></i>
                        <i class="<?=round(element('post_review_average', $value))>=4?"ri-star-fill":"ri-star-line"?> yell"></i>
                        <i class="<?=round(element('post_review_average', $value))>=5?"ri-star-fill":"ri-star-line"?> yell"></i>
                        <p class="rev-s"><?=round(element('post_review_average', $value))?> <span>(리뷰 <?=element('post_review_count', $value)?>)</span></p>
                    </div>
                </div>
            </a>
        </li>

    <?php
        }
    }
    ?>
    </ul>
</div>

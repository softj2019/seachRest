<div class="new-dt clearfix">
    <h2>새로운 소식</h2>
    <ul class="new-ul">
    <?php
    // parse to php object
    $data_object = json_decode($view["board"]["extravars"],true);

    if (element('latest', $view)) {
        foreach (element('latest', $view) as $key => $value) {
        ?>
        <li>
            <a href="<?php echo element('url', $value); ?>" class="" title="<?php echo html_escape(element('title', $value)); ?>">
                <div class="new-img" style="background-image: url(<?php echo element('thumb_url', $value); ?>");"></div>
                <div class="new-in">
                    <p class="new-tit"><?php echo element('store_name',element('extravars', $value)); ?></p>
                    <p class="new-name"><?php echo element('doctor_name',element('extravars', $value)); ?> <span><?php echo element('job_title',element('extravars', $value)); ?> </span></p>
                    <p class="new-lot flexcenter"><i class="src-si"></i><span class="resultDistance">주엽역 220m</span></p>
                    <input type="hidden" name="address[]" class="addressData" value="<?php echo element('address',element('extravars', $value)); ?>">
                </div>
            </a>
        </li>
    <?php
        }
    }
    ?>
    </ul>
</div>

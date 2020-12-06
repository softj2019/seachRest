
<div class="chart flexwrap">
    <p>실시간차트</p>
    <div class="slide2">
        <div class="swiper-wrapper">
            <?php
            // parse to php object
            $data_object = json_decode($view["board"]["extravars"],true);

            if (element('latest', $view)) {
                $i=0;
            foreach (element('latest', $view) as $key => $value) {
                $i++;
            ?>
            <div class="swiper-slide"><a href="<?php echo element('url', $value); ?>"><span><?=$i?>.</span><?php echo element('store_name',element('extravars', $value)); ?><i class="chart-i"></i></a></div>
                <?php
            }
            }
            ?>
        </div>
    </div>
</div>
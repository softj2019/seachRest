<div>
    <h3 class="flexwrap"><?php echo html_escape(element('board_name', element('board', $view))); ?>
        <a href="<?php echo board_url(element('brd_key', element('board', $view))); ?>" title="<?php echo html_escape(element('board_name', element('board', $view))); ?>">더보기<i class="plus-i"></i></a>
    </h3>
    <ul class="comm-ul">
    <?php
        $i = 0;
        if (element('latest', $view)) {
            foreach (element('latest', $view) as $key => $value) {
        ?>
                <li>
                    <a href="<?php echo element('url', $value); ?>" title="<?php echo html_escape(element('title', $value)); ?>"><?php echo html_escape(element('title', $value)); ?></a>

                    <span><?php echo element('display_datetime', $value); ?></span>
                </li>
        <?php
            $i++;
            }
        }
        while ($i < element('latest_limit', $view)) {
            ?>
           <li>게시물이 없습니다</li>
            <?php
            $i++;
        }
        ?>
    </ul>
</div>

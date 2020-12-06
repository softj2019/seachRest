<div class="alert alert-auto-close alert-dismissible alert-cmall-review-list-message" style="display:none;"><button type="button" class="close alertclose">×</button><span class="alert-cmall-review-list-message-content"></span></div>

        <ul class="review-box">
        <?php
        $i = 0;
        if (element('list', element('data', $view))) {
            foreach (element('list', element('data', $view)) as $result) {
        ?>
            <li><!--201027 수정-->
                <div class="tab2-tit flexwrap">
                    <p><a href=""><?php echo element('display_name', $result); ?></a></p>
                    <div class="star-i flexcenter">
                        <i class="ri-star-fill yell"></i><p class="rev-s"><?php echo element('cre_score', $result); ?></p>
                    </div>
                </div>
                <div class="review-btn">
                    <div class="tab2-name flexwrap">
                        <p>
                            <?php if (element('can_update', $result)) { ?>
                                <a href="javascript:;" class="blue-b-btn2" onClick="window.open('<?php echo site_url('cmall/review_write/' . element('cit_id', $view) . '/' . element('cre_id', $result) . '?page=' . $this->input->get('page')); ?>', 'review_popup', 'width=750,height=770,scrollbars=1'); return false;">수정</a>
                            <?php } ?>
                            <?php if (element('can_delete', $result)) { ?>
                                <a href="javascript:;" class="blue-b-btn2" onClick="delete_cmall_review('<?php echo element('cre_id', $result); ?>', '<?php echo element('cit_id', $result); ?>', '<?php echo element('page', $view); ?>');">삭제</a>
                            <?php } ?>
                        </p>
                        <p class="tab2-date">등록일<span class="flexcenter"><?php echo element('display_datetime', $result); ?></span></p>
                    </div>
                    <div class="tab2-re">
                        <p><?php echo element('content', $result); ?></p>
                    </div>
                </div>
            </li>
                <?php
            }
        } else {
            ?>
            <li>아직 등록된 방문후기가 없습니다</li>
        <?php
        }
        ?>
        </ul>


    <?php if(element('paging', $view)){?>
        <a href="/board_post/review_all_list/<?=element('post_id', $view)?>"class="con-btn">리뷰 전체보기</a>
    <?php
    }
    ?>


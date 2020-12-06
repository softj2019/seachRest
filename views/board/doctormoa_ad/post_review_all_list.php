<div class="alert alert-auto-close alert-dismissible alert-cmall-review-list-message" style="display:none;"><button type="button" class="close alertclose">×</button><span class="alert-cmall-review-list-message-content"></span></div>
<div class="content1">
    <div class="info-in2 page-in2 box-sd">
    <h3 class="info-tit flexcenter magin-1 pd1">리뷰 모아보기</h3>
    <div class="pd1">
<!--        <form action="" class="flexcenter in2-form">-->
<!--            <select name="" id="">-->
<!--                <option value="">전체</option>-->
<!--                <option value="">기본</option>-->
<!--                <option value="">최신순</option>-->
<!--                <option value="">평점 높은순</option>-->
<!--                <option value="">평점 낮은순</option>-->
<!--            </select>-->
<!--            <input type="text">-->
<!--            <button type="button"></button>-->
<!--        </form>-->
        <div class="star-box">
            <p>별점평균</p>
            <div class="flexwrap">
                <div class="star-i top flexcenter">
                    <i class="ri-star-line yell"></i>
                    <i class="ri-star-line yell"></i>
                    <i class="ri-star-line yell"></i>
                    <i class="ri-star-line yell"></i>
                    <i class="ri-star-line yell"></i>
                    <p class="rev-s"><span><?=round(element('post_review_average', element('post', $view)))?> </span></p>
                </div>
                <div class="g-icon flexcenter">
                    <p class="sm-icon" id="btn-post-like" onClick="post_like('<?php echo element('post_id', element('post', $view)); ?>', '1', 'post-like');"><span><?php echo number_format(element('post_like', element('post', $view))); ?></span></p>
                    <p class="bad-icon" id="btn-post-dislike" onClick="post_like('<?php echo element('post_id', element('post', $view)); ?>', '2', 'post-dislike');"><span><?php echo number_format(element('post_dislike', element('post', $view))); ?></span></p>
                </div>
            </div>
        </div>
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

    </div>
        <?php echo element('paging', $view); ?>
</div>
    <script>

        var average = '<?=round(element('post_review_average', element('post', $view)))?>';
        //평점평균

        $('.star-i.top i').removeClass("ri-star-fill");
        $('.star-i.top i').addClass("ri-star-line");
        if(average === '1'){
            $('.star-i.top i').eq(0).removeClass("ri-star-line");
            $('.star-i.top i').eq(0).addClass("ri-star-fill");
        }
        if(average === '2'){
            $('.star-i.top i').eq(1).removeClass("ri-star-line").prevAll("i").removeClass("ri-star-line");
            $('.star-i.top i').eq(1).addClass("ri-star-fill").prevAll("i").addClass("ri-star-fill");
        }
        if(average === '3'){
            $('.star-i.top i').eq(2).removeClass("ri-star-line").prevAll("i").removeClass("ri-star-line");
            $('.star-i.top i').eq(2).addClass("ri-star-fill").prevAll("i").addClass("ri-star-fill");
        }
        if(average === '4'){
            $('.star-i.top i').eq(3).removeClass("ri-star-line").prevAll("i").removeClass("ri-star-line");
            $('.star-i.top i').eq(3).addClass("ri-star-fill").prevAll("i").addClass("ri-star-fill");
        }
        if(average === '5'){
            $('.star-i.top i').eq(4).removeClass("ri-star-line").prevAll("i").removeClass("ri-star-line");
            $('.star-i.top i').eq(4).addClass("ri-star-fill").prevAll("i").addClass("ri-star-fill");
        }
    </script>


<?php

?>
<header class="m-header">
    <div class="in-hd sub-hd">
        <div class="logo-box">
            <button type="button" class="left-btn">이전</button>
            <h1 class="logo"><a href="/">닥터모아</a></h1>
        </div>
        <div class="src-out">
            <p class="blue-txt">진료선택</p>
            <button type="button" class="ham-btn"></button>
        </div>
    </div>
</header>
<div class="menu-box clearfix">
    <h3 class="c-tit">진료선택</h3>
    <p><a href="/board/b-a-1">모든진료</a></p>
    <?php
    $category = element('category',$view);
    function ca_select($p = '', $category = '', $category_id = '')
    {
        $return = '';

        if ($p && is_array($p)) {
            //마지막 요소 빼낸뒤 활용하고
            $last_pop = array_pop($p);
            //다시 줘버린다.
            array_push($p,$last_pop);
            $i=0;
            foreach ($p as $result) {

                $i++;$mod = ($i+1) % 3;
                $lasClass ='';
                if($mod == 0){
                    $lasClass ='class="lastCategory"';
                }

                $exp = explode('.', element('bca_key', $result));
                $len = (element(1, $exp)) ? strlen(element(1, $exp)) : 0;
                $space = str_repeat('-', $len);
                if (element('bca_parent', $result) == "0"){
                    $return .= '' .
                        '<p '.$lasClass.'>' .
                        '<a href="/board/b-a-1?category_id='.element('bca_id', $result).'">' . $space . html_escape(element('bca_value', $result)) . '</a>';
                }else{
                    if (element('bca_parent', $result) === $category_id) {
                        $return .= '<a href="/board/b-a-1?category_id='.element('bca_id', $result).'">' . $space . html_escape(element('bca_value', $result)) .'</a>';
                        $return.='</p>';
                    }else{
                        $return.='</p>';
                    }
                }


                if($last_pop['bca_id']==element('bca_id', $result) && $mod == 1)$return.='<p>&nbsp;</p><p class="lastCategory">&nbsp;</p>';
                if($last_pop['bca_id']==element('bca_id', $result) && $mod == 2)$return.='<p class="lastCategory">&nbsp;</p>';

                $parent = element('bca_key', $result);
                $return .= ca_select(element($parent, $category), $category, element('bca_id', $result));
            }
        }
        return $return;
    }
    echo ca_select(element(0, $category), $category, $this->input->get('category_id'));
    ?>

    <p class="select-p flexwrap clearfix">지역별</p>
    <ul class="menu-box-tree clearfix">
        <?php
        $sido=$this->Post_extra_vars_model->get_all_sido();
        foreach ($sido as $key =>$resultSido) {
           ?>

        <li>
            <a href="/search?sfield=address&skeyword=<?=element('sido', $resultSido)?>"><?=element('sido', $resultSido)?></a>
            <ul class="menu-box-tree2">
                <?php
                $addressList[$key]=$this->Post_extra_vars_model->get_all_address(element('sido', $resultSido));
                foreach ($addressList[$key] as $result) {
                    echo '<li><a href="/search?sfield=address&skeyword='.element('sigun', $result).'">'.element('sigun', $result).'</a></li>';
                }
                ?>
            </ul>
        </li>
            <?php
        }
        ?>
    </ul>
</div>
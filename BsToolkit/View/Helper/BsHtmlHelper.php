<?php
/**
 * Description of BsHtmlHelper
 *
 * @author masa
 */
App::uses('AppHelper', 'View/Helper');
class BsHtmlHelper extends AppHelper {
    var $helpers = array('Html');
    var $selected;

    /**
     * サイドメニュー等に入れるliを作る
     * メンバ変数のselectedに値が入っていると、それとメニューのアクション名を比較してactiveにする。
     * （アクション名は変わってしまうけど、activeは維持したいというときに使う）
     * 
     * @param type $title       リンクの文字
     * @param type $action      紐付いたaction名。リンクやactiveクラスを当てるキーにもなる
     * @param type $options     リンクに設定するオプション
     */
    public function li($title, $action, $options = array()) {
        if (empty($this->selected)) {
            $nowAction = $this->action;
        } else {
            $nowAction = $this->selected;
        }
        echo '<li' . ($nowAction == $action ? ' class="active">' : '>') . $this->Html->link($title, array('action' => $action), $options) . '</li>';
    }
    
    public function pagingNavi($paginator, $options = array()) {
        $result = '<div class="pagination pagination-centered"><ul>';
        
        // prevリンク生成
        $result .= $paginator->prev('« 前へ', array('tag' => 'li'), null, array('class' => 'disabled', 'tag' => 'li', 'disabledTag' => 'span'));
        
        // numbersリンク生成
        $numbersOptions = array(
            'separator' => '', 
            'tag' => 'li', 
            'currentClass' => 'active', 
            'currentTag' => 'span', 
            'ellipsis' => '<li class="disabled"><a href="#">...</a></li>'
            );
        
        if (isset($options['numbers'])) {
            $numbersOptions = am($numbersOptions,$options['numbers']);
        }
        
        $result .= $paginator->numbers($numbersOptions);
        
        // nextリンク生成
        $result .= $paginator->next('次へ »', array('tag' => 'li'), null, array('class' => 'disabled', 'tag' => 'li', 'disabledTag' => 'span'));
        $result .= '</ul></div>';

        return $result;
    }
    
    
}

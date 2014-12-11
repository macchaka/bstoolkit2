<?php
/**
 * BsHtmlHelper
 *
 * @author masa
 * @version 0.1.1
 */

App::uses('AppHelper', 'View/Helper');
class BsHtmlHelper extends AppHelper {
    var $helpers = array('Html', 'Form');

    /**
     * サイドメニュー等に入れるliを作る
     *
     * @param type $title        リンクの文字
     * @param type $targetAction 定義した
     * @param type $activeAction [description]
     * @param type $action      紐付いたaction名。リンクやactiveクラスを当てるキーにもなる
     * @param type $options     リンクに設定するオプション
     */
    public function li($title, $targetAction, $activeAction, $options = array()) {
        echo '<li' . ($activeAction === $targetAction ? ' class="active">' : '>') . $this->Html->link($title, array('action' => $targetAction), $options) . '</li>';
    }

    public function pagingNavi($paginator, $options = array()) {
        $result = '<div class="pagination pagination-centered"><ul>';

        // prevリンク生成コメント
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

    public function link2View($id = 0, $action = 'view') {
        return $this->Html->link('<i class="icon-eye-open"></i>', array('action' => $action, $id), array(
            'escape' => false,
            'class' => 'btn btn-small')
        );
    }
    public function link2Edit($id = 0, $action = 'edit') {
        return $this->Html->link('<i class="icon-edit"></i>', array('action' => $action, $id), array(
            'escape' => false,
            'class' => 'btn btn-small')
        );
    }
    public function link2Delete($id = 0, $message = '', $action = 'delete') {
        return $this->Form->postLink('<i class="icon-trash"></i>', array('action' => $action, $id), array(
                'escape' => false,
                'class' => 'btn btn-small'),
            $message);
    }
    public function link($id = 0, $icon = '', $title = '', $action = '') {
        $label = '';
        if ($icon) { $label = '<i class="' . $icon . '"></i>'; }
        if ($icon && $title) { $label .= '&nbsp;'; }
        $label .= $title;

        return $this->Html->link($label, array('action' => $action, $id), array(
            'escape' => false,
            'class' => 'btn btn-small')
        );
    }
    public function postlink($id = 0, $icon = '', $title = '', $action = '', $message = '') {
        $label = '';
        if ($icon) { $label = '<i class="' . $icon . '"></i>'; }
        if ($icon && $title) { $label .= '&nbsp;'; }
        $label .= $title;

        return $this->Form->postlink($label, array('action' => $action, $id), array(
            'escape' => false,
            'class' => 'btn btn-small'),
            $message);
    }


}

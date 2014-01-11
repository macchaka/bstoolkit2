<?php
/**
 * Description of BsFormHelper
 *
 * @author masa
 */
App::uses('AppHelper', 'View/Helper');
class BsFormHelper extends AppHelper {
    var $helpers = array('Html', 'Form');
    var $selected;

    /**
     * Formヘルパーの代わりに、Bootstrap用のタグを書き出す
     * 
     * @param type $fieldName
     * @param type $displayName
     * @param type $options
     * @param type $afterWords
     * @return string
     */
    public function input($fieldName, $displayName ='', $options = array(), $afterWords = '') {
        if (empty($displayName)) {
            $displayName = $fieldName;
        }
        
        
        $out = array();
        $out[] = $this->Form->label($fieldName, $displayName, array('class' => 'control-label'));

        $text = $this->Form->input($fieldName, am($options, array(
            'div' => false, 
            'label' => false,
            'error' => array(
                'attributes' => array(
                    'wrap' => 'span',
                    'class' => 'help-inline'
                )
            )
            )));
        if ($afterWords) {
            $text .= $this->Html->tag('div', $afterWords);
        }
        
        $out[] = $this->Html->div('controls', $text);

        $class = 'control-group';
        if ($this->Form->error($fieldName)) { $class .= ' error'; }

        return $this->Html->tag('div', implode("\n", $out), compact('class'));
    }

    
    public function select($fieldName, $displayName ='', $options = array(), $attributes = array(), $afterWords = '') {
        if (empty($displayName)) {
            $displayName = $fieldName;
        }
        $result = '<div class="control-group">' . $this->Form->label($fieldName, $displayName, array('class' => 'control-label'));
        $result .= '<div class="controls">' . $this->Form->select($fieldName, $options, $attributes);
        if ($afterWords) {
            $result .= $afterWords;
        }
        $result .= '</div></div>';

        return $result;
    }

    /**
     * フォームタグを用いないスタティックテキストのフィールドを生成する
     * 
     * @param type $fieldName       データのフィールド名
     * @param type $displayName     labelタグに出す項目名
     * @param type $option          
     * - class => spanタグに生成するクラス名（uneditable-inputは自動で付加されるので、主にフィールドサイズ）
     * - encoding => ここで指定したエンコードからApp.encodingにエンコード変換して表示
     * - h => FALSEでhtmlspecialcharsを無効にする。
     * @return string
     */
    public function value($fieldName, $displayName ='', $options = array(), $afterWords = '') {
        if (empty($displayName)) {
            $displayName = $fieldName;
        }
        $class = (isset($options['class'])) ? ($options['class']) : 'input';
            
        if (isset($options['encoding'])) {
            $value = mb_convert_encoding($this->Form->value($fieldName),Configure::read('App.encoding'), $options['encoding']);
        } else {
            $value = $this->Form->value($fieldName);
        }
        
        $value = (isset($options['h']) && $options['h'] == FALSE) ? ($value) : (h($value));

        $result ='<div class="control-group">' . $this->Form->label($fieldName, $displayName, array('class' => 'control-label'));
        $result .=  '<div class="controls"><span id="' . $this->Form->domId($fieldName) . '" class="' . $class . ' uneditable-input">' . $value . '</span>';
        if ($afterWords) {
            $result .= $afterWords;
        }
        $result .= '</div></div>';

        return $result;
    }
    
    /**
     * 
     * @param type $fieldName
     * @param type $displayName
     * @param type $option
     * @return string
     */
    public function date($fieldName, $displayName ='', $option = array(), $afterWords = '') {
        if (empty($displayName)) {
            $displayName = $fieldName;
        }
        $result ='<div class="control-group">' . $this->Form->label($fieldName, $displayName, array('class' => 'control-label'));
        $result .= '<div class="controls"><div class="input-append date">';
        $result .= $this->Form->text($fieldName, am($option, array('div' => false, 'label' => false)));
        $result .= '<span class="add-on"><i class="icon-th"></i></span></div>';
        if ($afterWords) {
            $result .= $afterWords;
        }
        $result .= '</div></div>';

        return $result;
        
    }
    public function datetime($fieldName, $displayName ='', $option = array(), $afterWords = '') {
        if (empty($displayName)) {
            $displayName = $fieldName;
        }
        $result ='<div class="control-group">' . $this->Form->label($fieldName, $displayName, array('class' => 'control-label'));
        $result .= '<div class="controls"><div class="input-append datetime">';
        $result .= $this->Form->text($fieldName, am($option, array('div' => false, 'label' => false)));
        $result .= '<span class="add-on"><i class="icon-th"></i></span></div>';
        if ($afterWords) {
            $result .= $afterWords;
        }
        $result .= '</div></div>';

        return $result;
        
    }

    
    
}
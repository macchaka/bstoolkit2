<?php
/**
 * Formヘルパーの代わりに、Bootstrap用のタグを書き出すヘルパー
 * Bsでフォームを出すときには色々なタグを出力する必要があるが、それを自動化する。
 *
 * @author masa
 */
App::uses('AppHelper', 'View/Helper');
class BsFormHelper extends AppHelper 
{
    var $helpers = array('Html', 'Form');
    var $selected;

    /**
     * inputタグ相当。
     *
     * @param type $fieldName
     * @param type $displayName
     * @param type $options
     * @param type $afterWords
     * @return string
     */
    public function input($fieldName, $displayName ='', $options = array(), $afterWords = '') 
    {
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
            $text .= $afterWords;
        }

        $out[] = $this->Html->div('controls', $text);

        $class = 'control-group';
        if ($this->Form->error($fieldName)) { $class .= ' error'; }

        return $this->Html->tag('div', implode("\n", $out), compact('class'));
    }

    public function select($fieldName, $displayName ='', $options = array(), $attributes = array(), $afterWords = '') 
    {
        if (empty($displayName)) {
            $displayName = $fieldName;
        }
        $out = '<div class="control-group">' . $this->Form->label($fieldName, $displayName, array('class' => 'control-label'));
        $out .= '<div class="controls">' . $this->Form->select($fieldName, $options, $attributes);
        if ($afterWords) {
            $out .= $afterWords;
        }
        $out .= '</div></div>';

        return $out;
    }

    /**
     * マルチ選択可能なチェックボックスを生成
     * 
     * @param type $fieldName
     * @param type $displayName
     * @param type $options
     * @param type $attributes
     * @param type $afterWords
     * @return string
     */
    public function checkbox($fieldName, $displayName ='', $options = array(), $attributes = array(), $afterWords = '') 
    {
        if (empty($displayName)) {
            $displayName = $fieldName;
        }

        $attributes = $this->_optionMerge($attributes, array(
            'type' => 'select',
            'multiple' => 'checkbox',
            'label' => false,
            'class' => 'checkbox',
            'options' => $options,
            ));

        $controlsClass = 'controls';
        if (isset($attributes['controls'])) {
            $controlsClass .= ' ' . $attributes['controls'];
        }

        $out = '<div class="control-group">' . $this->Form->label($fieldName, $displayName, array('class' => 'control-label'));
        $out .= '<div class="' . $controlsClass . '">' . $this->Form->input($fieldName, $attributes);
        if ($afterWords) {
            $out .= $afterWords;
        }
        $out .= '</div></div>';

        return $out;
    }

    
    /**
     * １行１つのチェックボックスを生成する
     * checkboxの方ではチェックボックスに連番が振られてしまうため、それが気持ち悪い時にどうぞ
     * 
     * @param type $fieldName
     * @param type $displayName
     * @param type $options
     * @param type $afterWords
     */
    public function checkboxSolo($fieldName, $labelName ='', $title = '', $options = array()) 
    {
        $out = array();

//        $out[] = $this->Form->label('', $title, array('class' => 'control-label'));
        $out[] = '<span class="control-label">' . $title . '</span>';

        $text = $this->Form->input($fieldName, am($options, array(
            'class' => 'input-small', 
            'type' => 'checkbox',
            'div' => false,
            'label' => false,
            'error' => array(
                'attributes' => array(
                    'wrap' => 'span',
                    'class' => 'help-inline'
                )
            )
            )));
//        $text .= '<span class="act-form-vertical-align">&nbsp;完了</span>';
        $text .= $this->Form->label($fieldName, $labelName, $options);

        $out[] = $this->Html->div('controls', $text);

        $class = 'control-group';
        if ($this->Form->error($fieldName)) { $class .= ' error'; }

        return $this->Html->tag('div', implode("\n", $out), compact('class'));
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
    public function bsvalue($fieldName, $displayName ='', $options = array(), $afterWords = '') 
    {
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

        $out = '<span id="' . $this->Form->domId($fieldName) . '" class="' . $class . ' uneditable-input">' . $value . '</span>';
        if ($afterWords) {
            $out .= $afterWords;
        }

        if (!isset($options['div']) || $options['div'] == true) {
            //divで出力
            $out ='<div class="control-group"><span class="control-label">' . $displayName . '</span><div class="controls">' . $out;
            $out .= '</div></div>';
        }

        return $out;
    }

    /**
     *
     * @param type $fieldName
     * @param type $displayName
     * @param type $option
     * @return string
     */
    public function date($fieldName, $displayName ='', $option = array(), $uniqueId = 'datepicker', $afterWords = '') 
    {
        if (empty($displayName)) {
            $displayName = $fieldName;
        }

        //validateエラーが発生していた場合
        $class = 'control-group';
        if ($this->Form->error($fieldName)) {
            $class .= ' error';
            $afterWords .= '<span class="help-inline">' . $this->Form->error($fieldName) . '</span>';
        }

        $out ='<div class="' . $class . '">' . $this->Form->label($fieldName, $displayName, array('class' => 'control-label'));
        $out .= '<div class="controls"><div id="' . $uniqueId . '" class="input-append date">';
        $out .= $this->Form->text($fieldName, am($option, array('div' => false, 'label' => false)));
        $out .= '<span class="add-on"><i class="icon-th"></i></span></div>';
        if ($afterWords) {
            $out .= $afterWords;
        }
        $out .= '</div></div>';

        return $out;

    }
    
    
    public function datetime($fieldName, $displayName ='', $option = array(), $uniqueId = 'datetimepicker', $afterWords = '') 
    {
        if (empty($displayName)) {
            $displayName = $fieldName;
        }
        $out ='<div class="control-group">' . $this->Form->label($fieldName, $displayName, array('class' => 'control-label'));
        $out .= '<div class="controls"><div id="' . $uniqueId . '" class="input-append datetime">';
        $out .= $this->Form->text($fieldName, am($option, array('div' => false, 'label' => false)));
        $out .= '<span class="add-on"><i class="icon-th"></i></span></div>';
        if ($afterWords) {
            $out .= $afterWords;
        }
        $out .= '</div></div>';

        return $out;

    }
    
    
    public function time($fieldName, $displayName ='', $option = array(), $uniqueId = 'timepicker', $afterWords = '') 
    {
        if (empty($displayName)) {
            $displayName = $fieldName;
        }
        $out ='<div class="control-group">' . $this->Form->label($fieldName, $displayName, array('class' => 'control-label'));
        $out .= '<div class="controls"><div id="' . $uniqueId . '" class="input-append time">';
        $out .= $this->Form->text($fieldName, am($option, array('div' => false, 'label' => false)));
        $out .= '<span class="add-on"><i class="icon-th"></i></span></div>';
        if ($afterWords) {
            $out .= $afterWords;
        }
        $out .= '</div></div>';

        return $out;

    }

    /**
     * viewから渡ってきたオプションをマージさせる際に、classを上書きではなく結合させる
     * （ただしこれを使うのは、このヘルパー内でclassを決め打ちする必要がある場合のみでよい）
     * @param  array  $paramOptions
     * @param  array  $appendOptions
     * @return [array] merged options
     */
    private function _optionMerge($paramOptions = array(), $appendOptions = array()) 
    {
        $srcClass = array();
        $appendClass = array();

        if (isset($paramOptions['class']))
            { $srcClass = explode(' ', $paramOptions['class']); }
        if (isset($appendOptions['class']))
            { $appendClass = explode(' ', $appendOptions['class']); }

        $mergedClass = array_unique(am($srcClass, $appendClass));
        $mergedOptions = am($paramOptions, $appendOptions);
        $mergedOptions['class'] = implode(' ', $mergedClass);
        return $mergedOptions;
    }


}

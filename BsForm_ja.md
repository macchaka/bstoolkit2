BsToolkit BsForm
=================

BsFormは、CakePHPの純正Formヘルパーを拡張し、Bootstrapに準じた効率的なタグ生成を行います。
Formタグと同名のメソッドは、フォームタグについて、ほぼ同名のFormヘルパーを呼び出します。
従って、オプション等もそのまま利用することができます。しかし、日本語環境に使いやすくしたり、BsFormがform系タグのみならず、周辺のタグ（親タグ）も生成するために、運用上扱いやすいようにオプションを拡張しているものがあります。

Input
-----------------
($fieldName, $displayName ='', $options = array(), $afterWords = '')
Form->Inputと同等にinputタグを作成します。
inputタグだけではなく、labelタグも生成します。

```php
$this->BsForm->input('fieldname', '項目名', array('class' => 'span5'))
```


select
-----------------
($fieldName, $displayName ='', $options = array(), $attributes = array(), $afterWords = '')

```
$this->BsForm->select('', '担当指図書', array('あいう', 'かきく'), array('class' => 'span5'))
````


value
-----------------
フォームタグを用いないスタティックテキストのフィールドを生成する
($fieldName, $displayName ='', $options = array(), $afterWords = '')

date
-----------------
($fieldName, $displayName ='', $option = array(), $afterWords = '')

datetime
-----------------
($fieldName, $displayName ='', $option = array(), $afterWords = '')

time
-----------------
($fieldName, $displayName ='', $option = array(), $afterWords = '')
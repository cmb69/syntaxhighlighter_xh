<?php

namespace Syntaxhighlighter;

/**
 * @var View $this
 * @var string $version
 * @var list<array{state:string,label:string,stateLabel:string}> $checks
 */
?>

<h1>Syntaxhighlighter <?=$this->escape($version)?></h1>
<div class="syntaxhighlighter_syscheck">
  <h2><?=$this->text('syscheck_title')?></h2>
<?php foreach ($checks as $check):?>
  <p class="xh_<?=$this->escape($check['state'])?>"><?=$this->text('syscheck_message', $check['label'], $check['stateLabel'])?></p>
<?php endforeach?>
</div>

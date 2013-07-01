<?php
namespace simtpl\controls;

?><h3>Default label</h3><?
echo new label("Simple label");?>
<br /><br />
<pre>echo new label("Simple label");</pre>
<hr /><?

?><h3>Colored label</h3><?
echo new label("Simple green label", label::COLOR_GREEN);?>
<br /><br />
<pre>echo new label("Simple green label", label::COLOR_GREEN);</pre>
<hr /><?

?><h3>Default badge</h3><?
echo new label("5", label::COLOR_GRAY, label::TYPE_BADGE);?>
<br /><br />
<pre>echo new label("5", label::COLOR_GRAY, label::TYPE_BADGE);</pre>
<hr /><?

?><h3>Colored badge</h3><?
echo new label("5", label::COLOR_GREEN, label::TYPE_BADGE);?>
<br /><br />
<pre>echo new label("Simple green badge", label::COLOR_GREEN, label::TYPE_BADGE);</pre>
<hr /><?

?><h3>Label without content</h3><?
echo new label("");?>
<br /><br />
<pre>echo new label("");</pre>
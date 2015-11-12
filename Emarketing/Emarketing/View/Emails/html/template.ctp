<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Universidade Castelo Branco :: <?php echo $subject ?></title>
</head>
<body>
<?php
$pathApp = Router::url('/', true);
$filename = strtolower($subject);
$title = Inflector::slug($subject, '-');

$link = $pathApp . 'uploads' . '/' . 'marketing' . '/' . $title . '/' . $title . '.html';

?>
	<p align="center">
		<font size="1">Caso não consiga visualizar este email, <?php echo $this->Html->link('acesse aqui',$link, array('title'=>$subject,'escape'=>false))?></font>
	</p>
	<div align="center" width="600">
		<?php  echo $content ?>
	</div>
</body>
</html>
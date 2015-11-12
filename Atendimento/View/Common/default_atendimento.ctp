<?php
$pageTitle = (isset($title_for_layout) ? $title_for_layout : '&nbsp;');
$pageTitle = (isset($page['Title']) ? $page['Title'] : $pageTitle);
?>
<section class="content-header">
    <h1>
        <?php echo $pageTitle;?>
    </h1>
    <?php
    echo $this->Html->getCrumbList(
        array(
            'class'=>'breadcrumb',
            'lastClass'=>'active',
        ),
        array(
            'text' => '<i class="fa fa-home"></i> HOME',
            'url' => 'http://ucbweb2.castelobranco.br/webcaf/entrar?ctrl=1',
            'escape' => false,
        )
    );
    ?>
</section>

<!-- Main content -->
<section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-xs-12">
           <?php echo $this->element('e/sessionflash'); ?>
            <?php echo $this->fetch('content'); ?>
        </div>
    </div>
</section>
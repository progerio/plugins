<style type="ttext/css">
    .artigosConteudo{padding:5px;border:1px solid #ccc;font-size:12px;}
</style>
<?php echo $edicaoAtual['Edition']['banner']; ?>
<h1>Artigos</h1>

<div class="textoPadrao">
    <?php
    
    if (sizeof($edicaoAtual['Artigo']) > 0) {
        foreach ($edicaoAtual['Artigo'] as $artigo):
            echo '<div class="artigosBloco">';
            echo '<h3>' . $artigo['titulo'] . '</h3>';
            echo '<div class="artigosAutor">' . $artigo['autores'] . '</div>';
            echo $this->Html->link('Veja o artigo completo', '/uploads/revista/'.$artigo['edicao_id'].'/'.$artigo['arquivo'], array('target' => '_blank', 'class' => 'botaoPdf'));
            echo '</div>';
        endforeach;
    }
    ?>

</div>
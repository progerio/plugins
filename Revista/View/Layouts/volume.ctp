<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>Revista Eletrônica - Novo Enfoque</title>
        <?php echo $this->Html->css('Revista.novo_enfoque'); ?>
    </head>
    <body>
        <div id="central">
            <div id="topo">
                <?php echo $this->Html->link($this->Html->image('Revista.topoLogo.jpg', array('width' => 279, 'height' => 61, 'alt' => 'Logo', 'id' => 'topoLogo', 'escape' => false)), '/', array('escape' => false)); ?>
                <div id="topoBox">
                    <?php if (in_array($edicaoAtual['Edition']['id'], array(1, 2))) { ?>
                    <div id="TopoBox_01" style="font-size:20px;margin:-5px 0 0 40px">  <?php echo strip_tags($edicaoAtual['Edition']['descricao']); ?></div>
                    <?php } else { ?>
                        <div id="TopoBox_01"><?php echo $edicaoAtual['Edition']['mes'] ?></div>
                        <div id="TopoBox_02">
                            <?php echo $edicaoAtual['Edition']['descricao']; ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div id="barra"></div>
            <div id="corpoFundo">
                <div id="corpo">
                    <div id="menuLeft">
                        <?php
                        echo $this->element('Revista.links_esquerdo');
                        echo $this->element('Revista.menu_esquerdo');
                        ?>
                    </div>

                    <div id="content">
                        <?php echo $this->fetch('content') ?>
                    </div>
                </div>
                <br style="clear:both;" />
            </div>
            <div id="down">
                <?php echo $this->Html->image('Revista.downDivis.jpg', array('width' => 770, 'height' => 23, 'alt' => 'rodape', 'escape' => false)); ?>
                Revista Eletrônica Novo Enfoque<br />
                Universidade Castelo Branco 1996-2013
            </div>
        </div>
        <br />
    </body>
</html>
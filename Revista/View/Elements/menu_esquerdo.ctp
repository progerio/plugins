<?php
$edAtual = $edicaoAtual['Edition']['id'];
if (isset($menuEdicoes)) {
    $size = count($menuEdicoes);
    foreach ($menuEdicoes as $k => $menu) {
        echo '<div class="edicoesAntigas">';
        echo $this->Html->link('Edição - '. $menu['edicao'], array('plugin'=>'revista','controller'=>'editions','action'=>'index','edicao'=>$menu['edicao']), array('class' => 'edicoesTopo', 'escape' => false));
        echo $this->Html->link('<span class"txtBranco">' . $menu['titulo'] . '</span>', array('plugin'=>'revista','controller'=>'editions','action'=>'index','edicao'=>$menu['edicao']), array('class' => 'edicoesTxt', 'escape' => false));
        echo '</div>';
    }
}
?>

<?php
    if(in_array($edAtual, array(1,2))){
 ?>
    <div id="links">
        <h3>Pesquisa e a UCB</h3>
        <?php
           echo $this->Html->link('Apresentação','/paginas/apresentacao/edicao:'.$edAtual,array('escape'=>false));
           echo $this->Html->link('Competências da Coordenação de Pesquisa','/paginas/competencia-da-coordenacao-de-pesquisa/edicao:'.$edAtual,array('escape'=>false));
           echo $this->Html->link('Histórico da Pesquisa na Castelo Branco','/paginas/historico-da-pesquisa-na-castelo-branco/edicao:'.$edAtual,array('escape'=>false));
           echo $this->Html->link('Principais Atividades das Pesquisas Desenvolvidas','/paginas/principais-atividades-das-pesquisas-desenvolvidas/edicao:'.$edAtual,array('escape'=>false));
           echo $this->Html->link('Representações da pro-Reitoria de Pesquisa e Pós-Graduação','/paginas/representacao-da-pro-reitoria-de-pesquisa-e-pos-graduacao/edicao:'.$edAtual,array('escape'=>false));
           echo $this->Html->link('Linha de pesquisa nas diferentes áreas do conhecimento','/paginas/linha-de-pesquisa-nas-diferentes-areas-do-conhecimento/edicao:'.$edAtual,array('escape'=>false));
           echo $this->Html->link('Produção científica da UCB','/paginas/producao-cientifica-da-ucb/edicao:'.$edAtual,array('escape'=>false));
           echo $this->Html->link('Prêmio Castelo branco','/paginas/premio-castelo-branco/edicao:'.$edAtual,array('escape'=>false));
           echo $this->Html->link('Informe','/paginas/informativo/edicao:'.$edAtual,array('escape'=>false));
        ?>
    </div>
<?php
}
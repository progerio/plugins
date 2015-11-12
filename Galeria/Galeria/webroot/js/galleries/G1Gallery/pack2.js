(function($) {
	$.fn.menuHorizontal = function() {
		return this.each(function() {
			var $this = $(this);
			var $ul = $this.find('ul.menu-itens');
			var $lis = $ul.find('> li');
			$lis.each(function() {
				var $this = $(this);
				var $menuSubitens = $this.find('.menu-subitens').hide();
				if ($menuSubitens.length) {
					$menuSubitens.css('width', $menuSubitens.find(
							'> .conteudo-subitens > ul').size() * 160);
					$this.mouseenter(function() {
						$menuSubitens.show();
					}).mouseleave(function() {
						$menuSubitens.hide();
					});
				}
			});
		});
	};
	$('#glb-menu').menuHorizontal();
})(jQuery);
(function($) {
	var methods = {
		init : function(options) {
			var $this = $(this);
			var settings = {
				rss : "",
				vejaMais : "",
				dados : "",
				layout : "4colunas"
			};
			if (options) {
				$.extend(settings, options);
			}
			$this.addClass("widget").addClass("widget-plantao");
			if ($.browser.msie && parseFloat($.browser.version) < 7) {
				$this.addClass("ie6");
			} else if ($.browser.msie && parseFloat($.browser.version) < 8) {
				$this.addClass("ie7");
			}
			$(this).html(methods.carregarConteudo(settings));
			if (settings.rss !== "" && settings.rss !== null) {
				var head = '<link rel="alternate" type="application/rss+xml" title="Feed" href="'
						+ settings.rss + '" />';
				$("head").append(settings.rss);
			}
		},
		carregarConteudo : function(settings) {
			var template = '<span class="canto-caixa-ce"></span>'
					+ '<span class="canto-caixa-cd"></span>'
					+ '<span class="canto-caixa-re"></span>'
					+ '<span class="canto-caixa-rd"></span>';
			template += '<div class="widget-titulo">'
					+ '<strong>últimas notícias</strong>';
			if (settings.rss !== "" && settings.rss !== null) {
				template += '<a class="rss" href="' + settings.rss
						+ '"><img src="' + SETTINGS.MEDIA_URL
						+ 'common/img/icones/icoRss.gif"></a>';
			}
			var corpo8Colunas = "";
			if (settings.layout === "8colunas") {
				corpo8Colunas = "widget-corpo-plantao-wide";
			}
			template += '</div>' + '<div class="widget-corpo-plantao '
					+ corpo8Colunas + '">' + '<ul class="lista-data-plantao">';
			for ( var i = 0; i < settings.dados.length; i++) {
				template += '<li class="item-data-plantao">'
						+ '<p class="data">' + settings.dados[i].data + '</p>'
						+ '<ul class="lista-noticia-plantao">';
				for ( var j = 0; j < settings.dados[i].materias.length; j++) {
					template += methods.carregarMateria(
							settings.dados[i].materias[j], settings);
				}
				template += '</ul>' + '</li>';
			}
			template += '</ul>' + '</div>';
			if (settings.vejaMais !== "") {
				template += '<div class="widget-rodape">' + '<a href="'
						+ settings.vejaMais
						+ '">veja mais notícias &raquo;</a>' + '</div>';
			}
			return template;
		},
		carregarMateria : function(materia, settings) {
			var widthThumb = "60";
			var heightThumb = "45";
			if (settings.layout === "8colunas") {
				widthThumb = "90";
				heightThumb = "68";
			}
			var template = '<li class="chamada item-noticia-plantao">'
					+ '    <div class="item-noticia-hora">' + materia.hora
					+ '</div>' + '    <div class="item-noticia-chamada">';
			var classThumb = "chamada-sem-foto";
			if (materia.thumbnail !== "" && materia.thumbnail !== null
					&& materia.thumbnail !== undefined) {
				template += '            <div class="item-noticia-thumbnail">'
						+ '                <span class="canto-ce"></span><span class="canto-cd"></span><span class="canto-re"></span><span class="canto-rd"></span>'
						+ '                <a href="' + materia.permalink
						+ '" class="borda-interna"><img width="' + widthThumb
						+ '" height="' + heightThumb + '" src="'
						+ materia.thumbnail + '"></a>' + '            </div>';
				classThumb = "chamada-com-foto";
			}
			template += '        <div class="item-noticia-conteudo '
					+ classThumb + '">';
			if (settings.layout !== "8colunas") {
				if (materia.nome_folder !== "" && materia.nome_folder !== null
						&& materia.nome_folder !== undefined) {
					template += '            <p class="chapeu">'
							+ materia.nome_folder + '</p>';
				}
			}
			template += '            <a href="' + materia.permalink
					+ '" class="titulo">' + materia.label + '</a>';
			if (settings.layout === "8colunas") {
				template += '<p class="subtitulo">' + materia.subtitulo
						+ '</p>';
			}
			template += '        </div>' + '    </div>' + '    <br>' + '</li>';
			return template;
		},
		loadingInit : function($context) {
			var template = '<div class="widget widget-plantao widget-semantico widget-loading">'
					+ '<img src="ajax_loader_white.gif" alt="carregando..." />'
					+ '</div>';
			$context.html(template);
		},
		loadingStop : function($context) {
			$(".widget-loading", $context).remove();
		}
	};
	$.fn.widgetPlantaoSemanticoHome = function(method) {
		if ($(this).length > 0) {
			if (methods[method]) {
				return methods[method].apply(this, Array.prototype.slice.call(
						arguments, 1));
			} else if (typeof method === 'object' || !method) {
				return methods.init.apply(this, arguments);
			} else {
				$.error('Method ' + method
						+ ' does not exist on widgetPlantaoSemanticoHome');
			}
		} else {
			$.error('selector not found on widgetPlantaoSemanticoHome');
		}
	};
})(jQuery);
(function(global, $) {
	var widthAtivo = 128;
	var widthInativo = 2;
	var opaco = {
		opacity : 1
	};
	var semiOpaco = {
		opacity : 0.8
	};
	var invisivel = {
		opacity : 0
	};
	var ativo = {
		width : widthAtivo
	};
	var inativo = {
		width : widthInativo
	};
	var ativoOpaco = {
		width : widthAtivo,
		opacity : 1
	};
	var ativoTranslucido = {
		width : widthAtivo,
		opacity : 0.5
	};
	var inativoOpaco = {
		width : widthInativo,
		opacity : 1
	};
	$
			.widget(
					'ge.carrossel',
					{
						options : {
							identificador : 'globocarrossel',
							duracaoAnimacao : 200,
							intervalo : 6000,
							indiceInicial : 0,
							zIndex : 99
						},
						_create : function() {
							this.timer = null;
							this.indice = this.options.indiceInicial;
							this.passos = this.element
									.find('.globo-carrossel-passo');
							this.numeroDePassos = this.passos.length;
							this.navegacao = this.element
									.find('.globo-carrossel-navegacao');
							this.tituloFundo = this.element
									.find('span.globo-carrossel-titulo-fundo');
							this.thumbs = this.element
									.find('.globo-carrossel-thumbs');
							this.ctThumbs = this.element
									.find('.globo-carrossel-thumbs-container');
							this.itensNavegacaoLi = this.navegacao.find('li');
							this.itensNavegacao = this.navegacao.find('a');
							this.itensNavegacaoBgAtivo = this.itensNavegacao
									.filter('.globo-carrossel-navegacao-item-bg-ativo');
							this.thumbs = this.element
									.find('.globo-carrossel-thumb');
							this.validaQuantidadeItens();
							if ($.browser.msie) {
								this._sombraIE();
							}
							this._ativar();
							this.iniciarCiclo();
							this._adicionarEventosNavegacao();
							this._adicionarEventosHover();
							this.element.removeClass('carregando');
							this.markLengthThumbs();
						},
						markLengthThumbs : function() {
							var $thumbsContainer = $('.globo-carrossel-thumbs',
									$(this.element));
							var qtnThumbs = $('.globo-carrossel-thumb',
									$thumbsContainer).length;
							$thumbsContainer.addClass('qtn-' + qtnThumbs
									+ '-thumbs');
						},
						validaQuantidadeItens : function() {
							var qntThumbs = this.thumbs.length;
							$('li', this.navegacao).eq(qntThumbs - 1).addClass(
									'ultimo-item');
							if (qntThumbs < 5) {
								this.navegacao.addClass('nav-itens-'
										+ qntThumbs);
								this.ctThumbs.addClass('thumb-itens-'
										+ qntThumbs);
							}
						},
						iniciarCiclo : function() {
							if (this.timer) {
								return;
							}
							if (this.numeroDePassos > 1) {
								this.timer = setInterval($.proxy(
										this.incrementaPasso, this),
										this.options.intervalo);
							}
						},
						cancelarCiclo : function() {
							clearInterval(this.timer);
							this.timer = null;
						},
						_ativar : function() {
							var primeiroBgAtivo = this.itensNavegacaoBgAtivo
									.first();
							this.itensNavegacaoLi.first().removeClass(
									'globo-carrossel-navegacao-item-ativo');
							$('.globo-carrossel-navegacao li:first').addClass(
									'lista-atual');
						},
						_adicionarEventosNavegacao : function() {
							var self = this;
							var tamanhoNav = this.itensNavegacaoLi.length;
							if ($.browser.msie
									&& parseInt($.browser.version, 10) <= 9) {
								$('.globo-carrossel-thumb').die('click').live(
										'click',
										function(event) {
											event.preventDefault();
											var elClick = $(this).attr(
													'data-index');
											$('.item-' + elClick).click();
										});
								$('.globo-carrossel-thumb').mouseenter(
										function(event) {
											var elItem = $(this).attr(
													'data-index');
											$('.item-' + elItem).trigger(
													'mouseenter');
										}).mouseleave(function(event) {
									var elItem = $(this).attr('data-index');
									$('.item-' + elItem).trigger('mouseleave');
								});
							}
							;
							this.itensNavegacaoLi
									.each(function(i, el) {
										var item = $(this);
										var bgAtivo = self.itensNavegacaoBgAtivo;
										var thumbs = self.thumbs;
										var duracaoAnimacao = self.options.duracaoAnimacao;
										item.addClass('item-' + (i + 1));
										if ((i + 1) == tamanhoNav) {
											$(thumbs[i]).addClass(
													'ultimo-thumb');
										}
										self
												._bind(
														item,
														'click',
														function() {
															if (!$(this)
																	.hasClass(
																			'lista-atual')) {
																$(
																		'.globo-carrossel-navegacao li a')
																		.removeClass(
																				'destaque-ativo');
																$('a', $(this))
																		.addClass(
																				'destaque-ativo');
																if (self.indice == i) {
																	return;
																}
																self
																		.trocaPasso(
																				self.indice,
																				i);
															}
														});
									});
							this._bind(this.itensNavegacao, 'click',
									function(e) {
										e.preventDefault();
									});
						},
						_adicionarEventosHover : function() {
							var self = this;
							this._bind(this.element, 'mouseenter', function() {
								self.cancelarCiclo();
							});
							this._bind(this.element, 'mouseleave', function() {
								self.iniciarCiclo();
							});
							this.itensNavegacaoLi.mouseenter(
									function() {
										var $self = $(this);
										var indiceAtual = $self.attr('class')
												.match(/\d+/);
										$self.addClass('hover');
										$('div a', this.itensNavegacaoLi)
												.removeClass('destaque-ativo');
										$('div a', $self).addClass(
												'destaque-ativo');
										$('div', this.thumbs).removeClass(
												'thumb-hover');
										$('.thumb-' + indiceAtual, this.thumbs)
												.addClass('thumb-hover');
										$(
												"img",
												$(".globo-carrossel-thumb")
														.not(".thumb-hover")
														.not('.thumb-atual'))
												.stop().animate({
													opacity : 0.5
												}, "fast");
									}).mouseleave(
									function() {
										var $self = $(this);
										$self.removeClass('hover');
										$('div a', this.itensNavegacaoLi)
												.removeClass('destaque-ativo');
										$('div', this.thumbs).removeClass(
												'thumb-hover');
										$(".globo-carrossel-thumb-content img")
												.stop().animate({
													opacity : 1
												}, "fast");
									});
						},
						incrementaPasso : function() {
							var indiceAnterior = this.indice;
							this.indice = (this.indice + 1)
									% this.numeroDePassos;
							this.trocaPasso(indiceAnterior, this.indice);
						},
						trocaPasso : function(indiceAnterior, indiceAtual) {
							this.indice = indiceAtual;
							this.animacao(indiceAnterior, indiceAtual);
						},
						animacao : function(indiceAnterior, indiceAtual) {
							var self = this;
							var passoAnterior = this.passos.eq(indiceAnterior);
							var passoAtual = this.passos.eq(indiceAtual);
							var navegacaoAnterior = this.itensNavegacaoBgAtivo
									.eq(indiceAnterior);
							var navegacaoAtual = this.itensNavegacaoBgAtivo
									.eq(indiceAtual);
							var onNavegacao = function() {
								if (!$.browser.msie) {
									self.passos.css('z-index',
											self.options.zIndex - 1);
									passoAnterior.css('z-index',
											self.options.zIndex + 1);
									passoAtual.css({
										'opacity' : 1,
										'z-index' : self.options.zIndex
									}).show();
									passoAnterior
											.stop()
											.animate(
													invisivel,
													{
														'duration' : self.options.duracaoAnimacao,
														'complete' : function() {
															$(this)
																	.css(
																			'z-index',
																			self.options.zIndex - 1);
														}
													});
								} else {
									passoAnterior.hide();
									passoAtual.show();
								}
							};
							$('li', self.navegacao).removeClass('lista-atual');
							self.thumbs.removeClass('thumb-atual');
							$('li.item-' + (indiceAtual + 1), self.navegacao)
									.addClass('lista-atual');
							$('.thumb-' + (indiceAtual + 1)).addClass(
									'thumb-atual');
							onNavegacao();
						},
						_bind : function(el, event, fn) {
							el.bind(event + '.' + this.options.identificador,
									fn);
						},
						_sombraIE : function() {
							var $titulos = $(
									'.globo-carrossel-titulo-texto, '
											+ '.globo-carrossel-subtitulo-texto, .globo-carrossel-chapeu-texto',
									this.element);
							$titulos.each(function(indx, elm) {
								var $elm = $(elm);
								$elm.append('<span class="sombra-ie">'
										+ $elm.html() + '</span>');
							});
						}
					});
	$('#globo_destaque_carrossel').carrossel();
})(this, jQuery);
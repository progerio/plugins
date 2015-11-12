(function($) {
	$.fn.widgetBarraPlantao = function(settings) {
		$(".widget-ticker-noticias .social a").mediaShare();
		var $self = this;
		var options = {
			url : '',
			qtdFeeds : 5,
			truncarTexto : 72,
			delayAtualizacao : 10000,
			delayTransicao : 9000,
			delayAnimacao : 300,
			tamanhoLi : 40,
			width : 800,
			height : 600,
			validarResolucao : true
		};
		op = $.extend(options, settings);
		if (op.validarResolucao) {
			(function(a) {
				isMobile = /android|avantgo|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i
						.test(a)
						|| /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|e\-|e\/|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(di|rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|xda(\-|2|g)|yas\-|your|zeto|zte\-/i
								.test(a.substr(0, 4));
			})(window.navigator.userAgent || window.navigator.vendor
					|| window.opera);
			if (screen.width < op.width && screen.height < op.height
					|| isMobile) {
				$self.hide();
				return false;
			}
		}
		var dataOld = {};
		var atualizar = false;
		var novosFeeds = 0;
		var $abrirBarra = $('.barra-fechada .marca a', $self);
		var $fecharBarra = $('.fechar a', $self);
		var $anterior = $('.navegacao .seta-anterior a', $self);
		var $proximo = $('.navegacao .seta-proximo a', $self);
		var metodosBarra = {
			init : function() {
				this.tooltip();
				this.cookieBarra();
				this.ajustarRodape();
				this.recuperarDadosBarra();
				this.iniciarAtualizacaoBarra();
				this.iniciarTransicaoFeed();
			},
			tooltip : function() {
				$('.marca a, .fechar a, .social a', $self)
						.hover(
								function() {
									var texto = $(this).html();
									$(this)
											.parent()
											.append(
													'<div class="tooltip"><p>'
															+ texto
															+ '</p><div class="detalhe"></div></div>');
								}, function() {
									var $target = $(this).parent();
									$('.tooltip', $target).remove();
								});
			},
			recuperarDadosBarra : function() {
				$.ajax({
					url : op.url,
					type : "GET",
					dataType : "jsonp",
					jsonp : false,
					jsonpCallback : "plantao_jsonp",
					success : function(data) {
						metodosBarra.atualizarBarra(data);
					},
					error : function() {
					}
				});
			},
			atualizarBarra : function(data) {
				var contFeeds = op.qtdFeeds - 1;
				if (atualizar === true) {
					for (i = contFeeds; i != -1; i--) {
						if (data.noticias[i].timestamp > dataOld.noticias[0].timestamp) {
							if ($('.barra-fechada .contador', $self).text() === "") {
								x = 0;
							}
							if (x <= contFeeds) {
								x++;
							}
							if ($.cookie('__statusTicker') === 0) {
								$('.barra-fechada .contador', $self).show()
										.html(x);
							}
						}
					}
					for (i = contFeeds; i != -1; i--) {
						if (data.noticias[i].timestamp > dataOld.noticias[0].timestamp) {
							metodosBarra.popularBarra(data);
							dataOld = data;
							return false;
						}
					}
				} else {
					metodosBarra.popularBarra(data);
				}
				dataOld = data;
				atualizar = true;
			},
			popularBarra : function(data) {
				$('.noticias ul', $self).empty();
				$
						.each(
								data,
								function(item) {
									data_item = data[item];
									$
											.each(
													data_item,
													function(indice) {
														var hora = metodosBarra
																.tratarData(data.noticias[indice].primeira_publicacao);
														var chapeu = data.noticias[indice].editoria_principal;
														var titulo = data.noticias[indice].titulo;
														var url = data.noticias[indice].link_original;
														var truncate = metodosBarra
																.truncarTexto(titulo);
														$('.noticias ul', $self)
																.append(
																		'<li '
																				+ truncate
																				+ '>'
																				+ '<div class="informacoes"><span class="hora">'
																				+ hora
																				+ '</span> <span class="editoria">'
																				+ chapeu
																				+ '</span></div>'
																				+ '<a title="'
																				+ titulo
																				+ '" class="titulo" href="'
																				+ url
																				+ '">'
																				+ titulo
																				+ '</a>'
																				+ '</li>');
													});
								});
				metodosBarra.popularShare();
			},
			iniciarAtualizacaoBarra : function() {
				window.setInterval(function() {
					metodosBarra.recuperarDadosBarra();
				}, op.delayAtualizacao);
			},
			cookieBarra : function() {
				if ($.cookie('__statusTicker') === null) {
					metodosBarra.abrirBarra();
				} else if ($.cookie('__statusTicker') == 1) {
					metodosBarra.abrirBarra();
				} else if ($.cookie('__statusTicker') == 0) {
					metodosBarra.fecharBarra();
				}
			},
			abrirBarra : function() {
				$('.barra-fechada .contador', $self).empty().hide();
				$('.barra-aberta', $self).show();
				$('.barra-fechada', $self).hide();
				$.cookie('__statusTicker', '1');
			},
			fecharBarra : function(target) {
				$('.barra-aberta', $self).hide();
				$('.barra-fechada', $self).show();
				$.cookie('__statusTicker', '0');
			},
			anteriorFeed : function() {
				var tamanhoTop = '+=' + op.tamanhoLi;
				var ultimo = $('.noticias ul li:last', $self).clone();
				$('.noticias ul', $self).prepend(ultimo);
				$('.noticias ul', $self).css('top', '-' + op.tamanhoLi + 'px');
				$('.noticias ul li:last', $self).remove();
				$('.noticias ul', $self).stop().animate({
					top : tamanhoTop
				}, op.delayAnimacao, function() {
				});
				metodosBarra.popularShare();
			},
			proximoFeed : function() {
				var tamanhoTop = '-=' + op.tamanhoLi;
				$('.noticias ul', $self).stop().animate({
					top : tamanhoTop
				}, op.delayAnimacao, function() {
					var primeiro = $('.noticias ul li:first').clone();
					$('.noticias ul', $self).append(primeiro);
					$('.noticias ul', $self).css('top', '0');
					$('.noticias ul li:first', $self).remove();
					metodosBarra.popularShare();
				});
			},
			iniciarTransicaoFeed : function() {
				var self = this;
				self.timerHandler = window.setInterval(function() {
					metodosBarra.proximoFeed(false);
				}, op.delayTransicao);
			},
			pararTransicaoFeed : function() {
				var self = this;
				window.clearInterval(self.timerHandler);
			},
			tratarData : function(date) {
				date = date.split(" ");
				date = date[3].substring(0, 5);
				var hora = date.replace(":", "h");
				return hora;
			},
			truncarTexto : function(titulo) {
				var tituloTruncado = titulo;
				if (tituloTruncado.length > op.truncarTexto) {
					tituloTruncado = 'class="truncate"';
					return tituloTruncado;
				} else {
					return "";
				}
			},
			ajustarRodape : function() {
				$('#glb-rodape').css('paddingBottom', '58px');
			},
			popularShare : function() {
				var texto = $('.noticias ul li:first a').text();
				var link = $('.noticias ul li:first a').attr("href");
				var hashtag = 'globoesporte';
				try {
					hashtag = link.split('.')[0].split("//")[1];
				} catch (err) {
					console.debug('error parsing link');
				}
				$('.widget-ticker-noticias .social-facebook a').attr(
						"data-text", texto + ": " + link + " #" + hashtag);
				$('.widget-ticker-noticias .social-facebook a').attr(
						"data-url", link);
				$('.widget-ticker-noticias .social-twitter a').attr(
						"data-text", texto + " %23" + hashtag);
				$('.widget-ticker-noticias .social-twitter a').attr("data-url",
						link);
			}
		};
		$anterior.click(function() {
			metodosBarra.anteriorFeed();
			metodosBarra.pararTransicaoFeed();
			metodosBarra.iniciarTransicaoFeed();
			return false;
		});
		$proximo.click(function() {
			metodosBarra.proximoFeed();
			metodosBarra.pararTransicaoFeed();
			metodosBarra.iniciarTransicaoFeed();
			return false;
		});
		$abrirBarra.click(function() {
			metodosBarra.abrirBarra();
			metodosBarra.iniciarTransicaoFeed();
			return false;
		});
		$fecharBarra.click(function() {
			metodosBarra.fecharBarra();
			metodosBarra.pararTransicaoFeed();
			return false;
		});
		metodosBarra.init();
	};
})(jQuery);
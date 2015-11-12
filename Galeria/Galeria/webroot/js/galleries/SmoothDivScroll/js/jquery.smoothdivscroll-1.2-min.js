﻿(function(a) {
	a
			.widget(
					"thomaskahn.smoothDivScroll",
					{
						options : {
							scrollingHotSpotLeftClass : "scrollingHotSpotLeft",
							scrollingHotSpotRightClass : "scrollingHotSpotRight",
							scrollableAreaClass : "scrollableArea",
							scrollWrapperClass : "scrollWrapper",
							hiddenOnStart : false,
							ajaxContentURL : "",
							countOnlyClass : "",
							startAtElementId : "",
							hotSpotScrolling : true,
							hotSpotScrollingStep : 15,
							hotSpotScrollingInterval : 10,
							hotSpotMouseDownSpeedBooster : 3,
							visibleHotSpotBackgrounds : "onstart",
							hotSpotsVisibleTime : 5e3,
							easingAfterHotSpotScrolling : true,
							easingAfterHotSpotScrollingDistance : 10,
							easingAfterHotSpotScrollingDuration : 300,
							easingAfterHotSpotScrollingFunction : "easeOutQuart",
							mousewheelScrolling : false,
							mousewheelScrollingStep : 70,
							easingAfterMouseWheelScrolling : true,
							easingAfterMouseWheelScrollingDuration : 300,
							easingAfterMouseWheelScrollingFunction : "easeOutQuart",
							manualContinuousScrolling : false,
							autoScrollingMode : "",
							autoScrollingDirection : "endlessloopright",
							autoScrollingStep : 1,
							autoScrollingInterval : 10,
							scrollToAnimationDuration : 1e3,
							scrollToEasingFunction : "easeOutQuart"
						},
						_create : function() {
							var b = this, c = this.options, d = this.element;
							d.wrapInner(
									"<div class='" + c.scrollableAreaClass
											+ "'>").wrapInner(
									"<div class='" + c.scrollWrapperClass
											+ "'>");
							d
									.prepend("<div class='"
											+ c.scrollingHotSpotLeftClass
											+ "'></div><div class='"
											+ c.scrollingHotSpotRightClass
											+ "'></div>");
							d.data("scrollWrapper", d.find("."
									+ c.scrollWrapperClass));
							d.data("scrollingHotSpotRight", d.find("."
									+ c.scrollingHotSpotRightClass));
							d.data("scrollingHotSpotLeft", d.find("."
									+ c.scrollingHotSpotLeftClass));
							d.data("scrollableArea", d.find("."
									+ c.scrollableAreaClass));
							d.data("speedBooster", 1);
							d.data("scrollXPos", 0);
							d.data("hotSpotWidth", d.data(
									"scrollingHotSpotLeft").innerWidth());
							d.data("scrollableAreaWidth", 0);
							d.data("startingPosition", 0);
							d.data("rightScrollingInterval", null);
							d.data("leftScrollingInterval", null);
							d.data("autoScrollingInterval", null);
							d.data("hideHotSpotBackgroundsInterval", null);
							d.data("previousScrollLeft", 0);
							d.data("pingPongDirection", "right");
							d.data("getNextElementWidth", true);
							d.data("swapAt", null);
							d.data("startAtElementHasNotPassed", true);
							d.data("swappedElement", null);
							d.data("originalElements", d.data("scrollableArea")
									.children(c.countOnlyClass));
							d.data("visible", true);
							d.data("enabled", true);
							d.data("scrollableAreaHeight", d.data(
									"scrollableArea").height());
							d.data("scrollerOffset", d.offset());
							d.data("initialAjaxContentLoaded", false);
							d
									.data("scrollingHotSpotRight")
									.bind(
											"mousemove",
											function(a) {
												var b = a.pageX
														- (this.offsetLeft + d
																.data("scrollerOffset").left);
												d
														.data(
																"scrollXPos",
																Math
																		.round(b
																				/ d
																						.data("hotSpotWidth")
																				* c.hotSpotScrollingStep));
												if (d.data("scrollXPos") === Infinity) {
													d.data("scrollXPos", 0)
												}
											});
							d
									.data("scrollingHotSpotRight")
									.bind(
											"mouseover",
											function() {
												d.data("scrollWrapper").stop(
														true, false);
												b.stopAutoScrolling();
												d
														.data(
																"rightScrollingInterval",
																setInterval(
																		function() {
																			if (d
																					.data("scrollXPos") > 0
																					&& d
																							.data("enabled")) {
																				d
																						.data(
																								"scrollWrapper")
																						.scrollLeft(
																								d
																										.data(
																												"scrollWrapper")
																										.scrollLeft()
																										+ d
																												.data("scrollXPos")
																										* d
																												.data("speedBooster"));
																				if (c.manualContinuousScrolling) {
																					b
																							._checkContinuousSwapRight()
																				}
																				b
																						._showHideHotSpots()
																			}
																		},
																		c.hotSpotScrollingInterval));
												b
														._trigger("mouseOverRightHotSpot")
											});
							d
									.data("scrollingHotSpotRight")
									.bind(
											"mouseout",
											function() {
												clearInterval(d
														.data("rightScrollingInterval"));
												d.data("scrollXPos", 0);
												if (c.easingAfterHotSpotScrolling
														&& d.data("enabled")) {
													d
															.data(
																	"scrollWrapper")
															.animate(
																	{
																		scrollLeft : d
																				.data(
																						"scrollWrapper")
																				.scrollLeft()
																				+ c.easingAfterHotSpotScrollingDistance
																	},
																	{
																		duration : c.easingAfterHotSpotScrollingDuration,
																		easing : c.easingAfterHotSpotScrollingFunction
																	})
												}
											});
							d.data("scrollingHotSpotRight").bind(
									"mousedown",
									function() {
										d.data("speedBooster",
												c.hotSpotMouseDownSpeedBooster)
									});
							a("body").bind("mouseup", function() {
								d.data("speedBooster", 1)
							});
							d.data("scrollingHotSpotLeft").bind(
									"mousemove",
									function(a) {
										var b = this.offsetLeft
												+ d.data("scrollerOffset").left
												+ d.data("hotSpotWidth")
												- a.pageX;
										d.data("scrollXPos", Math.round(b
												/ d.data("hotSpotWidth")
												* c.hotSpotScrollingStep));
										if (d.data("scrollXPos") === Infinity) {
											d.data("scrollXPos", 0)
										}
									});
							d
									.data("scrollingHotSpotLeft")
									.bind(
											"mouseover",
											function() {
												d.data("scrollWrapper").stop(
														true, false);
												b.stopAutoScrolling();
												d
														.data(
																"leftScrollingInterval",
																setInterval(
																		function() {
																			if (d
																					.data("scrollXPos") > 0
																					&& d
																							.data("enabled")) {
																				d
																						.data(
																								"scrollWrapper")
																						.scrollLeft(
																								d
																										.data(
																												"scrollWrapper")
																										.scrollLeft()
																										- d
																												.data("scrollXPos")
																										* d
																												.data("speedBooster"));
																				if (c.manualContinuousScrolling) {
																					b
																							._checkContinuousSwapLeft()
																				}
																				b
																						._showHideHotSpots()
																			}
																		},
																		c.hotSpotScrollingInterval));
												b
														._trigger("mouseOverLeftHotSpot")
											});
							d
									.data("scrollingHotSpotLeft")
									.bind(
											"mouseout",
											function() {
												clearInterval(d
														.data("leftScrollingInterval"));
												d.data("scrollXPos", 0);
												if (c.easingAfterHotSpotScrolling
														&& d.data("enabled")) {
													d
															.data(
																	"scrollWrapper")
															.animate(
																	{
																		scrollLeft : d
																				.data(
																						"scrollWrapper")
																				.scrollLeft()
																				- c.easingAfterHotSpotScrollingDistance
																	},
																	{
																		duration : c.easingAfterHotSpotScrollingDuration,
																		easing : c.easingAfterHotSpotScrollingFunction
																	})
												}
											});
							d.data("scrollingHotSpotLeft").bind(
									"mousedown",
									function() {
										d.data("speedBooster",
												c.hotSpotMouseDownSpeedBooster)
									});
							d
									.data("scrollableArea")
									.mousewheel(
											function(a, e) {
												if (d.data("enabled")
														&& c.mousewheelScrolling) {
													a.preventDefault();
													b.stopAutoScrolling();
													var f = Math
															.round(c.mousewheelScrollingStep
																	* e);
													b.move(f)
												}
											});
							if (c.mousewheelScrolling) {
								d.data("scrollingHotSpotLeft").add(
										d.data("scrollingHotSpotRight"))
										.mousewheel(function(a, b) {
											a.preventDefault()
										})
							}
							a(window).bind("resize", function() {
								b._showHideHotSpots();
								b._trigger("windowResized")
							});
							if (c.ajaxContentURL.length > 0) {
								b.changeContent(c.ajaxContentURL, "", "html",
										"replace")
							}
							if (c.hiddenOnStart) {
								b.hide()
							}
							a(window)
									.load(
											function() {
												if (!c.hiddenOnStart) {
													b
															.recalculateScrollableArea()
												}
												if (c.autoScrollingMode.length > 0
														&& !c.hiddenOnStart) {
													b.startAutoScrolling()
												}
												if (c.autoScrollingMode !== "always") {
													switch (c.visibleHotSpotBackgrounds) {
													case "always":
														b
																.showHotSpotBackgrounds();
														break;
													case "onstart":
														b
																.showHotSpotBackgrounds();
														d
																.data(
																		"hideHotSpotBackgroundsInterval",
																		setTimeout(
																				function() {
																					b
																							.hideHotSpotBackgrounds("slow")
																				},
																				c.hotSpotsVisibleTime));
														break;
													default:
														break
													}
												}
											})
						},
						_setOption : function(a, b) {
							var c = this, d = this.options, e = this.element;
							d[a] = b;
							if (a === "hotSpotScrolling") {
								if (b === true) {
									c._showHideHotSpots()
								} else {
									e.data("scrollingHotSpotLeft").hide();
									e.data("scrollingHotSpotRight").hide()
								}
							} else if (a === "autoScrollingStep"
									|| a === "easingAfterHotSpotScrollingDistance"
									|| a === "easingAfterHotSpotScrollingDuration"
									|| a === "easingAfterMouseWheelScrollingDuration") {
								d[a] = parseInt(b, 10)
							} else if (a === "autoScrollingInterval") {
								d[a] = parseInt(b, 10);
								c.startAutoScrolling()
							}
						},
						showHotSpotBackgrounds : function(a) {
							var b = this, c = this.element;
							if (a !== undefined) {
								c.data("scrollingHotSpotLeft").add(
										c.data("scrollingHotSpotRight")).css(
										"opacity", "0.0");
								c.data("scrollingHotSpotLeft").addClass(
										"scrollingHotSpotLeftVisible");
								c.data("scrollingHotSpotRight").addClass(
										"scrollingHotSpotRightVisible");
								c.data("scrollingHotSpotLeft").add(
										c.data("scrollingHotSpotRight"))
										.fadeTo(a, .35)
							} else {
								c.data("scrollingHotSpotLeft").addClass(
										"scrollingHotSpotLeftVisible");
								c.data("scrollingHotSpotLeft").removeAttr(
										"style");
								c.data("scrollingHotSpotRight").addClass(
										"scrollingHotSpotRightVisible");
								c.data("scrollingHotSpotRight").removeAttr(
										"style")
							}
							b._showHideHotSpots()
						},
						hideHotSpotBackgrounds : function(a) {
							var b = this.element;
							if (a !== undefined) {
								b
										.data("scrollingHotSpotLeft")
										.fadeTo(
												a,
												0,
												function() {
													b
															.data(
																	"scrollingHotSpotLeft")
															.removeClass(
																	"scrollingHotSpotLeftVisible")
												});
								b
										.data("scrollingHotSpotRight")
										.fadeTo(
												a,
												0,
												function() {
													b
															.data(
																	"scrollingHotSpotRight")
															.removeClass(
																	"scrollingHotSpotRightVisible")
												})
							} else {
								b.data("scrollingHotSpotLeft").removeClass(
										"scrollingHotSpotLeftVisible")
										.removeAttr("style");
								b.data("scrollingHotSpotRight").removeClass(
										"scrollingHotSpotRightVisible")
										.removeAttr("style")
							}
						},
						_showHideHotSpots : function() {
							var a = this, b = this.element, c = this.options;
							if (c.manualContinuousScrolling
									&& c.hotSpotScrolling) {
								b.data("scrollingHotSpotLeft").show();
								b.data("scrollingHotSpotRight").show()
							} else if (c.autoScrollingMode !== "always"
									&& c.hotSpotScrolling) {
								if (b.data("scrollableAreaWidth") <= b.data(
										"scrollWrapper").innerWidth()) {
									b.data("scrollingHotSpotLeft").hide();
									b.data("scrollingHotSpotRight").hide()
								} else if (b.data("scrollWrapper").scrollLeft() === 0) {
									b.data("scrollingHotSpotLeft").hide();
									b.data("scrollingHotSpotRight").show();
									a._trigger("scrollerLeftLimitReached");
									clearInterval(b
											.data("leftScrollingInterval"));
									b.data("leftScrollingInterval", null)
								} else if (b.data("scrollableAreaWidth") <= b
										.data("scrollWrapper").innerWidth()
										+ b.data("scrollWrapper").scrollLeft()) {
									b.data("scrollingHotSpotLeft").show();
									b.data("scrollingHotSpotRight").hide();
									a._trigger("scrollerRightLimitReached");
									clearInterval(b
											.data("rightScrollingInterval"));
									b.data("rightScrollingInterval", null)
								} else {
									b.data("scrollingHotSpotLeft").show();
									b.data("scrollingHotSpotRight").show()
								}
							} else {
								b.data("scrollingHotSpotLeft").hide();
								b.data("scrollingHotSpotRight").hide()
							}
						},
						_setElementScrollPosition : function(b, c) {
							var d = this, e = this.element, f = this.options, g = 0;
							switch (b) {
							case "first":
								e.data("scrollXPos", 0);
								return true;
							case "start":
								if (f.startAtElementId !== "") {
									if (e.data("scrollableArea").has(
											"#" + f.startAtElementId)) {
										g = a("#" + f.startAtElementId)
												.position().left;
										e.data("scrollXPos", g);
										return true
									}
								}
								return false;
							case "last":
								e.data("scrollXPos", e
										.data("scrollableAreaWidth")
										- e.data("scrollWrapper").innerWidth());
								return true;
							case "number":
								if (!isNaN(c)) {
									g = e.data("scrollableArea").children(
											f.countOnlyClass).eq(c - 1)
											.position().left;
									e.data("scrollXPos", g);
									return true
								}
								return false;
							case "id":
								if (c.length > 0) {
									if (e.data("scrollableArea").has("#" + c)) {
										g = a("#" + c).position().left;
										e.data("scrollXPos", g);
										return true
									}
								}
								return false;
							default:
								return false
							}
						},
						jumpToElement : function(a, b) {
							var c = this, d = this.element;
							if (d.data("enabled")) {
								if (c._setElementScrollPosition(a, b)) {
									d.data("scrollWrapper").scrollLeft(
											d.data("scrollXPos"));
									c._showHideHotSpots();
									switch (a) {
									case "first":
										c._trigger("jumpedToFirstElement");
										break;
									case "start":
										c._trigger("jumpedToStartElement");
										break;
									case "last":
										c._trigger("jumpedToLastElement");
										break;
									case "number":
										c._trigger("jumpedToElementNumber",
												null, {
													elementNumber : b
												});
										break;
									case "id":
										c._trigger("jumpedToElementId", null, {
											elementId : b
										});
										break;
									default:
										break
									}
								}
							}
						},
						scrollToElement : function(a, b) {
							var c = this, d = this.element, e = this.options, f = false;
							if (d.data("enabled")) {
								if (c._setElementScrollPosition(a, b)) {
									if (d.data("autoScrollingInterval") !== null) {
										c.stopAutoScrolling();
										f = true
									}
									d.data("scrollWrapper").stop(true, false);
									d
											.data("scrollWrapper")
											.animate(
													{
														scrollLeft : d
																.data("scrollXPos")
													},
													{
														duration : e.scrollToAnimationDuration,
														easing : e.scrollToEasingFunction,
														complete : function() {
															if (f) {
																c
																		.startAutoScrolling()
															}
															c
																	._showHideHotSpots();
															switch (a) {
															case "first":
																c
																		._trigger("scrolledToFirstElement");
																break;
															case "start":
																c
																		._trigger("scrolledToStartElement");
																break;
															case "last":
																c
																		._trigger("scrolledToLastElement");
																break;
															case "number":
																c
																		._trigger(
																				"scrolledToElementNumber",
																				null,
																				{
																					elementNumber : b
																				});
																break;
															case "id":
																c
																		._trigger(
																				"scrolledToElementId",
																				null,
																				{
																					elementId : b
																				});
																break;
															default:
																break
															}
														}
													})
								}
							}
						},
						move : function(a) {
							var b = this, c = this.element, d = this.options;
							c.data("scrollWrapper").stop(true, true);
							if (a < 0
									&& c.data("scrollWrapper").scrollLeft() > 0
									|| a > 0
									&& c.data("scrollableAreaWidth") > c.data(
											"scrollWrapper").innerWidth()
											+ c.data("scrollWrapper")
													.scrollLeft()) {
								if (d.easingAfterMouseWheelScrolling) {
									c
											.data("scrollWrapper")
											.animate(
													{
														scrollLeft : c
																.data(
																		"scrollWrapper")
																.scrollLeft()
																+ a
													},
													{
														duration : d.easingAfterMouseWheelScrollingDuration,
														easing : d.easingAfterMouseWheelFunction,
														complete : function() {
															b
																	._showHideHotSpots();
															if (d.manualContinuousScrolling) {
																if (a > 0) {
																	b
																			._checkContinuousSwapRight()
																} else {
																	b
																			._checkContinuousSwapLeft()
																}
															}
														}
													})
								} else {
									c.data("scrollWrapper").scrollLeft(
											c.data("scrollWrapper")
													.scrollLeft()
													+ a);
									b._showHideHotSpots();
									if (d.manualContinuousScrolling) {
										if (a > 0) {
											b._checkContinuousSwapRight()
										} else {
											b._checkContinuousSwapLeft()
										}
									}
								}
							}
						},
						changeContent : function(b, c, d, e) {
							var f = this, g = this.element;
							switch (c) {
							case "flickrFeed":
								a
										.getJSON(
												b,
												function(b) {
													function n(b, j) {
														var k = b.media.m;
														var p = k.replace("_m",
																c[j].letter);
														var q = a("<img />")
																.attr("src", p);
														q
																.load(function() {
																	if (this.height < g
																			.data("scrollableAreaHeight")) {
																		if (j + 1 < c.length) {
																			n(
																					b,
																					j + 1)
																		} else {
																			o(this)
																		}
																	} else {
																		o(this)
																	}
																	if (m === l) {
																		switch (d) {
																		case "add":
																			if (e === "first") {
																				g
																						.data(
																								"scrollableArea")
																						.children(
																								":first")
																						.before(
																								h)
																			} else {
																				g
																						.data(
																								"scrollableArea")
																						.children(
																								":last")
																						.after(
																								h)
																			}
																			break;
																		default:
																			g
																					.data(
																							"scrollableArea")
																					.html(
																							h);
																			break
																		}
																		if (g
																				.data("initialAjaxContentLoaded")) {
																			f
																					.recalculateScrollableArea()
																		} else {
																			g
																					.data(
																							"initialAjaxContentLoaded",
																							true)
																		}
																		f
																				._showHideHotSpots();
																		f
																				._trigger(
																						"addedFlickrContent",
																						null,
																						{
																							addedElementIds : i
																						})
																	}
																})
													}
													function o(b) {
														var c = g
																.data("scrollableAreaHeight")
																/ b.height;
														var d = Math
																.round(b.width
																		* c);
														var e = a(b)
																.attr("src")
																.split("/");
														var f = e.length - 1;
														e = e[f].split(".");
														a(b).attr("id", e[0]);
														a(b)
																.css(
																		{
																			height : g
																					.data("scrollableAreaHeight"),
																			width : d
																		});
														i.push(e[0]);
														h.push(b);
														m++
													}
													var c = [ {
														size : "small square",
														pixels : 75,
														letter : "_s"
													}, {
														size : "thumbnail",
														pixels : 100,
														letter : "_t"
													}, {
														size : "small",
														pixels : 240,
														letter : "_m"
													}, {
														size : "medium",
														pixels : 500,
														letter : ""
													}, {
														size : "medium 640",
														pixels : 640,
														letter : "_z"
													}, {
														size : "large",
														pixels : 1024,
														letter : "_b"
													} ];
													var h = [];
													var i = [];
													var j = [];
													var k;
													var l = b.items.length;
													var m = 0;
													if (g
															.data("scrollableAreaHeight") <= 75) {
														k = 0
													} else if (g
															.data("scrollableAreaHeight") <= 100) {
														k = 1
													} else if (g
															.data("scrollableAreaHeight") <= 240) {
														k = 2
													} else if (g
															.data("scrollableAreaHeight") <= 500) {
														k = 3
													} else if (g
															.data("scrollableAreaHeight") <= 640) {
														k = 4
													} else {
														k = 5
													}
													a.each(b.items, function(a,
															b) {
														n(b, k)
													})
												});
								break;
							default:
								a
										.get(
												b,
												function(a) {
													switch (d) {
													case "add":
														if (e === "first") {
															g
																	.data(
																			"scrollableArea")
																	.children(
																			":first")
																	.before(a)
														} else {
															g
																	.data(
																			"scrollableArea")
																	.children(
																			":last")
																	.after(a)
														}
														break;
													default:
														g
																.data(
																		"scrollableArea")
																.html(a);
														break
													}
													if (g
															.data("initialAjaxContentLoaded")) {
														f
																.recalculateScrollableArea()
													} else {
														g
																.data(
																		"initialAjaxContentLoaded",
																		true)
													}
													f._showHideHotSpots();
													f
															._trigger("addedHtmlContent")
												})
							}
						},
						recalculateScrollableArea : function() {
							var b = 0, c = false, d = this.options, e = this.element, f = this;
							e
									.data("scrollableArea")
									.children(d.countOnlyClass)
									.each(
											function() {
												if (d.startAtElementId.length > 0
														&& a(this).attr("id") === d.startAtElementId) {
													e.data("startingPosition",
															b);
													c = true
												}
												b = b
														+ a(this).outerWidth(
																true)
											});
							if (!c) {
								e.data("startAtElementId", "")
							}
							e.data("scrollableAreaWidth", b);
							e.data("scrollableArea").width(
									e.data("scrollableAreaWidth"));
							e.data("scrollWrapper").scrollLeft(
									e.data("startingPosition"));
							e.data("scrollXPos", e.data("startingPosition"))
						},
						stopAutoScrolling : function() {
							var a = this, b = this.element;
							if (b.data("autoScrollingInterval") !== null) {
								clearInterval(b.data("autoScrollingInterval"));
								b.data("autoScrollingInterval", null);
								a._showHideHotSpots();
								a._trigger("autoScrollingStopped")
							}
						},
						startAutoScrolling : function() {
							var a = this, b = this.element, c = this.options;
							if (b.data("enabled")) {
								a._showHideHotSpots();
								clearInterval(b.data("autoScrollingInterval"));
								b.data("autoScrollingInterval", null);
								a._trigger("autoScrollingStarted");
								b
										.data(
												"autoScrollingInterval",
												setInterval(
														function() {
															if (!b
																	.data("visible")
																	|| b
																			.data("scrollableAreaWidth") <= b
																			.data(
																					"scrollWrapper")
																			.innerWidth()) {
																clearInterval(b
																		.data("autoScrollingInterval"));
																b
																		.data(
																				"autoScrollingInterval",
																				null)
															} else {
																b
																		.data(
																				"previousScrollLeft",
																				b
																						.data(
																								"scrollWrapper")
																						.scrollLeft());
																switch (c.autoScrollingDirection) {
																case "right":
																	b
																			.data(
																					"scrollWrapper")
																			.scrollLeft(
																					b
																							.data(
																									"scrollWrapper")
																							.scrollLeft()
																							+ c.autoScrollingStep);
																	if (b
																			.data("previousScrollLeft") === b
																			.data(
																					"scrollWrapper")
																			.scrollLeft()) {
																		a
																				._trigger("autoScrollingRightLimitReached");
																		clearInterval(b
																				.data("autoScrollingInterval"));
																		b
																				.data(
																						"autoScrollingInterval",
																						null);
																		a
																				._trigger("autoScrollingIntervalStopped")
																	}
																	break;
																case "left":
																	b
																			.data(
																					"scrollWrapper")
																			.scrollLeft(
																					b
																							.data(
																									"scrollWrapper")
																							.scrollLeft()
																							- c.autoScrollingStep);
																	if (b
																			.data("previousScrollLeft") === b
																			.data(
																					"scrollWrapper")
																			.scrollLeft()) {
																		a
																				._trigger("autoScrollingLeftLimitReached");
																		clearInterval(b
																				.data("autoScrollingInterval"));
																		b
																				.data(
																						"autoScrollingInterval",
																						null);
																		a
																				._trigger("autoScrollingIntervalStopped")
																	}
																	break;
																case "backandforth":
																	if (b
																			.data("pingPongDirection") === "right") {
																		b
																				.data(
																						"scrollWrapper")
																				.scrollLeft(
																						b
																								.data(
																										"scrollWrapper")
																								.scrollLeft()
																								+ c.autoScrollingStep)
																	} else {
																		b
																				.data(
																						"scrollWrapper")
																				.scrollLeft(
																						b
																								.data(
																										"scrollWrapper")
																								.scrollLeft()
																								- c.autoScrollingStep)
																	}
																	if (b
																			.data("previousScrollLeft") === b
																			.data(
																					"scrollWrapper")
																			.scrollLeft()) {
																		if (b
																				.data("pingPongDirection") === "right") {
																			b
																					.data(
																							"pingPongDirection",
																							"left");
																			a
																					._trigger("autoScrollingRightLimitReached")
																		} else {
																			b
																					.data(
																							"pingPongDirection",
																							"right");
																			a
																					._trigger("autoScrollingLeftLimitReached")
																		}
																	}
																	break;
																case "endlessloopright":
																	b
																			.data(
																					"scrollWrapper")
																			.scrollLeft(
																					b
																							.data(
																									"scrollWrapper")
																							.scrollLeft()
																							+ c.autoScrollingStep);
																	a
																			._checkContinuousSwapRight();
																	break;
																case "endlessloopleft":
																	b
																			.data(
																					"scrollWrapper")
																			.scrollLeft(
																					b
																							.data(
																									"scrollWrapper")
																							.scrollLeft()
																							- c.autoScrollingStep);
																	a
																			._checkContinuousSwapLeft();
																	break;
																default:
																	break
																}
															}
														},
														c.autoScrollingInterval))
							}
						},
						_checkContinuousSwapRight : function() {
							var b = this, c = this.element, d = this.options;
							if (c.data("getNextElementWidth")) {
								if (d.startAtElementId.length > 0
										&& c.data("startAtElementHasNotPassed")) {
									c.data("swapAt",
											a("#" + d.startAtElementId)
													.outerWidth(true));
									c.data("startAtElementHasNotPassed", false)
								} else {
									c.data("swapAt", c.data("scrollableArea")
											.children(":first")
											.outerWidth(true))
								}
								c.data("getNextElementWidth", false)
							}
							if (c.data("swapAt") <= c.data("scrollWrapper")
									.scrollLeft()) {
								c.data("swappedElement", c.data(
										"scrollableArea").children(":first")
										.detach());
								c.data("scrollableArea").append(
										c.data("swappedElement"));
								var e = c.data("scrollWrapper").scrollLeft();
								c.data("scrollWrapper").scrollLeft(
										e
												- c.data("swappedElement")
														.outerWidth(true));
								c.data("getNextElementWidth", true)
							}
						},
						_checkContinuousSwapLeft : function() {
							var b = this, c = this.element, d = this.options;
							if (c.data("getNextElementWidth")) {
								if (d.startAtElementId.length > 0
										&& c.data("startAtElementHasNotPassed")) {
									c.data("swapAt",
											a("#" + d.startAtElementId)
													.outerWidth(true));
									c.data("startAtElementHasNotPassed", false)
								} else {
									c.data("swapAt", c.data("scrollableArea")
											.children(":first")
											.outerWidth(true))
								}
								c.data("getNextElementWidth", false)
							}
							if (c.data("scrollWrapper").scrollLeft() === 0) {
								c.data("swappedElement", c.data(
										"scrollableArea").children(":last")
										.detach());
								c.data("scrollableArea").prepend(
										c.data("swappedElement"));
								c.data("scrollWrapper").scrollLeft(
										c.data("scrollWrapper").scrollLeft()
												+ c.data("swappedElement")
														.outerWidth(true));
								c.data("getNextElementWidth", true)
							}
						},
						restoreOriginalElements : function() {
							var a = this, b = this.element;
							b.data("scrollableArea").html(
									b.data("originalElements"));
							a.recalculateScrollableArea();
							a.jumpToElement("first")
						},
						show : function() {
							var a = this.element;
							a.data("visible", true);
							a.show()
						},
						hide : function() {
							var a = this.element;
							a.data("visible", false);
							a.hide()
						},
						enable : function() {
							var a = this.element;
							a.data("enabled", true)
						},
						disable : function() {
							var a = this, b = this.element;
							a.stopAutoScrolling();
							clearInterval(b.data("rightScrollingInterval"));
							clearInterval(b.data("leftScrollingInterval"));
							clearInterval(b
									.data("hideHotSpotBackgroundsInterval"));
							b.data("enabled", false)
						},
						destroy : function() {
							var b = this, c = this.element;
							b.stopAutoScrolling();
							clearInterval(c.data("rightScrollingInterval"));
							clearInterval(c.data("leftScrollingInterval"));
							clearInterval(c
									.data("hideHotSpotBackgroundsInterval"));
							c.data("scrollingHotSpotRight").unbind("mouseover");
							c.data("scrollingHotSpotRight").unbind("mouseout");
							c.data("scrollingHotSpotRight").unbind("mousedown");
							c.data("scrollingHotSpotLeft").unbind("mouseover");
							c.data("scrollingHotSpotLeft").unbind("mouseout");
							c.data("scrollingHotSpotLeft").unbind("mousedown");
							c.data("scrollingHotSpotRight").remove();
							c.data("scrollingHotSpotLeft").remove();
							c.data("scrollableArea").remove();
							c.data("scrollWrapper").remove();
							c.html(c.data("originalElements"));
							a.Widget.prototype.destroy.apply(this, arguments)
						}
					})
})(jQuery)

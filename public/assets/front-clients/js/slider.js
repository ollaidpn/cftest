!(function(t, e, i, s) {
    function o(e, i) {
        (this.settings = null),
            (this.options = t.extend({}, o.Defaults, i)),
            (this.$element = t(e)),
            (this.drag = t.extend({}, a)),
            (this.state = t.extend({}, l)),
            (this.e = t.extend({}, c)),
            (this._plugins = {}),
            (this._supress = {}),
            (this._current = null),
            (this._speed = null),
            (this._coordinates = []),
            (this._breakpoint = null),
            (this._width = null),
            (this._items = []),
            (this._clones = []),
            (this._mergers = []),
            (this._invalidated = {}),
            (this._pipe = []),
            t.each(
                o.Plugins,
                t.proxy(function(t, e) {
                    this._plugins[t[0].toLowerCase() + t.slice(1)] = new e(
                        this
                    );
                }, this)
            ),
            t.each(
                o.Pipe,
                t.proxy(function(e, i) {
                    this._pipe.push({
                        filter: i.filter,
                        run: t.proxy(i.run, this)
                    });
                }, this)
            ),
            this.setup(),
            this.initialize();
    }
    function n(t) {
        if (t.touches !== s)
            return { x: t.touches[0].pageX, y: t.touches[0].pageY };
        if (t.touches === s) {
            if (t.pageX !== s) return { x: t.pageX, y: t.pageY };
            if (t.pageX === s) return { x: t.clientX, y: t.clientY };
        }
    }
    function r(t) {
        var e,
            s,
            o = i.createElement("div"),
            n = t;
        for (e in n)
            if (((s = n[e]), void 0 !== o.style[s])) return (o = null), [s, e];
        return [!1];
    }
    var a, l, c;
    (a = {
        start: 0,
        startX: 0,
        startY: 0,
        current: 0,
        currentX: 0,
        currentY: 0,
        offsetX: 0,
        offsetY: 0,
        distance: null,
        startTime: 0,
        endTime: 0,
        updatedX: 0,
        targetEl: null
    }),
        (l = {
            isTouch: !1,
            isScrolling: !1,
            isSwiping: !1,
            direction: !1,
            inMotion: !1
        }),
        (c = {
            _onDragStart: null,
            _onDragMove: null,
            _onDragEnd: null,
            _transitionEnd: null,
            _resizer: null,
            _responsiveCall: null,
            _goToLoop: null,
            _checkVisibile: null
        }),
        (o.Defaults = {
            items: 3,
            loop: !1,
            center: !1,
            mouseDrag: !0,
            touchDrag: !0,
            pullDrag: !0,
            freeDrag: !1,
            margin: 0,
            stagePadding: 0,
            merge: !1,
            mergeFit: !0,
            autoWidth: !1,
            startPosition: 0,
            rtl: !1,
            smartSpeed: 250,
            fluidSpeed: !1,
            dragEndSpeed: !1,
            responsive: {},
            responsiveRefreshRate: 200,
            responsiveBaseElement: e,
            responsiveClass: !1,
            fallbackEasing: "swing",
            info: !1,
            nestedItemSelector: !1,
            itemElement: "div",
            stageElement: "div",
            themeClass: "owl-theme",
            baseClass: "owl-carousel",
            itemClass: "owl-item",
            centerClass: "center",
            activeClass: "active"
        }),
        (o.Width = { Default: "default", Inner: "inner", Outer: "outer" }),
        (o.Plugins = {}),
        (o.Pipe = [
            {
                filter: ["width", "items", "settings"],
                run: function(t) {
                    t.current =
                        this._items &&
                        this._items[this.relative(this._current)];
                }
            },
            {
                filter: ["items", "settings"],
                run: function() {
                    var t = this._clones;
                    (this.$stage.children(".cloned").length !== t.length ||
                        (!this.settings.loop && t.length > 0)) &&
                        (this.$stage.children(".cloned").remove(),
                        (this._clones = []));
                }
            },
            {
                filter: ["items", "settings"],
                run: function() {
                    var t,
                        e,
                        i = this._clones,
                        s = this._items,
                        o = this.settings.loop
                            ? i.length - Math.max(2 * this.settings.items, 4)
                            : 0;
                    for (t = 0, e = Math.abs(o / 2); e > t; t++)
                        o > 0
                            ? (this.$stage
                                  .children()
                                  .eq(s.length + i.length - 1)
                                  .remove(),
                              i.pop(),
                              this.$stage
                                  .children()
                                  .eq(0)
                                  .remove(),
                              i.pop())
                            : (i.push(i.length / 2),
                              void 0 !== s[i[i.length - 1]] &&
                                  this.$stage.append(
                                      s[i[i.length - 1]]
                                          .clone()
                                          .addClass("cloned")
                                  ),
                              i.push(s.length - 1 - (i.length - 1) / 2),
                              void 0 !== s[i[i.length - 1]] &&
                                  this.$stage.prepend(
                                      s[i[i.length - 1]]
                                          .clone()
                                          .addClass("cloned")
                                  ));
                }
            },
            {
                filter: ["width", "items", "settings"],
                run: function() {
                    var t,
                        e,
                        i,
                        s = this.settings.rtl ? 1 : -1,
                        o = (this.width() / this.settings.items).toFixed(3),
                        n = 0;
                    for (
                        this._coordinates = [],
                            e = 0,
                            i = this._clones.length + this._items.length;
                        i > e;
                        e++
                    )
                        (t = this._mergers[this.relative(e)]),
                            (t =
                                (this.settings.mergeFit &&
                                    Math.min(t, this.settings.items)) ||
                                t),
                            (n +=
                                (this.settings.autoWidth
                                    ? this._items[this.relative(e)].width() +
                                      this.settings.margin
                                    : o * t) * s),
                            this._coordinates.push(n);
                }
            },
            {
                filter: ["width", "items", "settings"],
                run: function() {
                    var e,
                        i,
                        s = (this.width() / this.settings.items).toFixed(3),
                        o = {
                            width:
                                Math.abs(
                                    this._coordinates[
                                        this._coordinates.length - 1
                                    ]
                                ) +
                                2 * this.settings.stagePadding,
                            "padding-left": this.settings.stagePadding || "",
                            "padding-right": this.settings.stagePadding || ""
                        };
                    if (
                        (this.$stage.css(o),
                        ((o = {
                            width: this.settings.autoWidth
                                ? "auto"
                                : s - this.settings.margin
                        })[
                            this.settings.rtl ? "margin-left" : "margin-right"
                        ] = this.settings.margin),
                        !this.settings.autoWidth &&
                            t.grep(this._mergers, function(t) {
                                return t > 1;
                            }).length > 0)
                    )
                        for (e = 0, i = this._coordinates.length; i > e; e++)
                            (o.width =
                                Math.abs(this._coordinates[e]) -
                                Math.abs(this._coordinates[e - 1] || 0) -
                                this.settings.margin),
                                this.$stage
                                    .children()
                                    .eq(e)
                                    .css(o);
                    else this.$stage.children().css(o);
                }
            },
            {
                filter: ["width", "items", "settings"],
                run: function(t) {
                    t.current &&
                        this.reset(this.$stage.children().index(t.current));
                }
            },
            {
                filter: ["position"],
                run: function() {
                    this.animate(this.coordinates(this._current));
                }
            },
            {
                filter: ["width", "position", "items", "settings"],
                run: function() {
                    var t,
                        e,
                        i,
                        s,
                        o = this.settings.rtl ? 1 : -1,
                        n = 2 * this.settings.stagePadding,
                        r = this.coordinates(this.current()) + n,
                        a = r + this.width() * o,
                        l = [];
                    for (i = 0, s = this._coordinates.length; s > i; i++)
                        (t = this._coordinates[i - 1] || 0),
                            (e = Math.abs(this._coordinates[i]) + n * o),
                            ((this.op(t, "<=", r) && this.op(t, ">", a)) ||
                                (this.op(e, "<", r) && this.op(e, ">", a))) &&
                                l.push(i);
                    this.$stage
                        .children("." + this.settings.activeClass)
                        .removeClass(this.settings.activeClass),
                        this.$stage
                            .children(":eq(" + l.join("), :eq(") + ")")
                            .addClass(this.settings.activeClass),
                        this.settings.center &&
                            (this.$stage
                                .children("." + this.settings.centerClass)
                                .removeClass(this.settings.centerClass),
                            this.$stage
                                .children()
                                .eq(this.current())
                                .addClass(this.settings.centerClass));
                }
            }
        ]),
        (o.prototype.initialize = function() {
            var e, i, o;
            if (
                (this.trigger("initialize"),
                this.$element
                    .addClass(this.settings.baseClass)
                    .addClass(this.settings.themeClass)
                    .toggleClass("owl-rtl", this.settings.rtl),
                this.browserSupport(),
                this.settings.autoWidth && !0 !== this.state.imagesLoaded) &&
                ((e = this.$element.find("img")),
                (i = this.settings.nestedItemSelector
                    ? "." + this.settings.nestedItemSelector
                    : s),
                (o = this.$element.children(i).width()),
                e.length && 0 >= o)
            )
                return this.preloadAutoWidthImages(e), !1;
            this.$element.addClass("owl-loading"),
                (this.$stage = t(
                    "<" + this.settings.stageElement + ' class="owl-stage"/>'
                ).wrap('<div class="owl-stage-outer">')),
                this.$element.append(this.$stage.parent()),
                this.replace(
                    this.$element.children().not(this.$stage.parent())
                ),
                (this._width = this.$element.width()),
                this.refresh(),
                this.$element.removeClass("owl-loading").addClass("owl-loaded"),
                this.eventsCall(),
                this.internalEvents(),
                this.addTriggerableEvents(),
                this.trigger("initialized");
        }),
        (o.prototype.setup = function() {
            var e = this.viewport(),
                i = this.options.responsive,
                s = -1,
                o = null;
            i
                ? (t.each(i, function(t) {
                      e >= t && t > s && (s = Number(t));
                  }),
                  delete (o = t.extend({}, this.options, i[s])).responsive,
                  o.responsiveClass &&
                      this.$element
                          .attr("class", function(t, e) {
                              return e.replace(/\b owl-responsive-\S+/g, "");
                          })
                          .addClass("owl-responsive-" + s))
                : (o = t.extend({}, this.options)),
                (null === this.settings || this._breakpoint !== s) &&
                    (this.trigger("change", {
                        property: { name: "settings", value: o }
                    }),
                    (this._breakpoint = s),
                    (this.settings = o),
                    this.invalidate("settings"),
                    this.trigger("changed", {
                        property: { name: "settings", value: this.settings }
                    }));
        }),
        (o.prototype.optionsLogic = function() {
            this.$element.toggleClass("owl-center", this.settings.center),
                this.settings.loop &&
                    this._items.length < this.settings.items &&
                    (this.settings.loop = !1),
                this.settings.autoWidth &&
                    ((this.settings.stagePadding = !1),
                    (this.settings.merge = !1));
        }),
        (o.prototype.prepare = function(e) {
            var i = this.trigger("prepare", { content: e });
            return (
                i.data ||
                    (i.data = t("<" + this.settings.itemElement + "/>")
                        .addClass(this.settings.itemClass)
                        .append(e)),
                this.trigger("prepared", { content: i.data }),
                i.data
            );
        }),
        (o.prototype.update = function() {
            for (
                var e = 0,
                    i = this._pipe.length,
                    s = t.proxy(function(t) {
                        return this[t];
                    }, this._invalidated),
                    o = {};
                i > e;

            )
                (this._invalidated.all ||
                    t.grep(this._pipe[e].filter, s).length > 0) &&
                    this._pipe[e].run(o),
                    e++;
            this._invalidated = {};
        }),
        (o.prototype.width = function(t) {
            switch ((t = t || o.Width.Default)) {
                case o.Width.Inner:
                case o.Width.Outer:
                    return this._width;
                default:
                    return (
                        this._width -
                        2 * this.settings.stagePadding +
                        this.settings.margin
                    );
            }
        }),
        (o.prototype.refresh = function() {
            if (0 === this._items.length) return !1;
            new Date().getTime(),
                this.trigger("refresh"),
                this.setup(),
                this.optionsLogic(),
                this.$stage.addClass("owl-refresh"),
                this.update(),
                this.$stage.removeClass("owl-refresh"),
                (this.state.orientation = e.orientation),
                this.watchVisibility(),
                this.trigger("refreshed");
        }),
        (o.prototype.eventsCall = function() {
            (this.e._onDragStart = t.proxy(function(t) {
                this.onDragStart(t);
            }, this)),
                (this.e._onDragMove = t.proxy(function(t) {
                    this.onDragMove(t);
                }, this)),
                (this.e._onDragEnd = t.proxy(function(t) {
                    this.onDragEnd(t);
                }, this)),
                (this.e._onResize = t.proxy(function(t) {
                    this.onResize(t);
                }, this)),
                (this.e._transitionEnd = t.proxy(function(t) {
                    this.transitionEnd(t);
                }, this)),
                (this.e._preventClick = t.proxy(function(t) {
                    this.preventClick(t);
                }, this));
        }),
        (o.prototype.onThrottledResize = function() {
            e.clearTimeout(this.resizeTimer),
                (this.resizeTimer = e.setTimeout(
                    this.e._onResize,
                    this.settings.responsiveRefreshRate
                ));
        }),
        (o.prototype.onResize = function() {
            return (
                !!this._items.length &&
                this._width !== this.$element.width() &&
                !this.trigger("resize").isDefaultPrevented() &&
                ((this._width = this.$element.width()),
                this.invalidate("width"),
                this.refresh(),
                void this.trigger("resized"))
            );
        }),
        (o.prototype.eventsRouter = function(t) {
            var e = t.type;
            "mousedown" === e || "touchstart" === e
                ? this.onDragStart(t)
                : "mousemove" === e || "touchmove" === e
                ? this.onDragMove(t)
                : "mouseup" === e || "touchend" === e
                ? this.onDragEnd(t)
                : "touchcancel" === e && this.onDragEnd(t);
        }),
        (o.prototype.internalEvents = function() {
            var i =
                ("ontouchstart" in e || navigator.msMaxTouchPoints,
                e.navigator.msPointerEnabled);
            this.settings.mouseDrag
                ? (this.$stage.on(
                      "mousedown",
                      t.proxy(function(t) {
                          this.eventsRouter(t);
                      }, this)
                  ),
                  this.$stage.on("dragstart", function() {
                      return !1;
                  }),
                  (this.$stage.get(0).onselectstart = function() {
                      return !1;
                  }))
                : this.$element.addClass("owl-text-select-on"),
                this.settings.touchDrag &&
                    !i &&
                    this.$stage.on(
                        "touchstart touchcancel",
                        t.proxy(function(t) {
                            this.eventsRouter(t);
                        }, this)
                    ),
                this.transitionEndVendor &&
                    this.on(
                        this.$stage.get(0),
                        this.transitionEndVendor,
                        this.e._transitionEnd,
                        !1
                    ),
                !1 !== this.settings.responsive &&
                    this.on(e, "resize", t.proxy(this.onThrottledResize, this));
        }),
        (o.prototype.onDragStart = function(s) {
            var o, r, a, l;
            if (
                3 === (o = s.originalEvent || s || e.event).which ||
                this.state.isTouch
            )
                return !1;
            if (
                ("mousedown" === o.type && this.$stage.addClass("owl-grab"),
                this.trigger("drag"),
                (this.drag.startTime = new Date().getTime()),
                this.speed(0),
                (this.state.isTouch = !0),
                (this.state.isScrolling = !1),
                (this.state.isSwiping = !1),
                (this.drag.distance = 0),
                (r = n(o).x),
                (a = n(o).y),
                (this.drag.offsetX = this.$stage.position().left),
                (this.drag.offsetY = this.$stage.position().top),
                this.settings.rtl &&
                    (this.drag.offsetX =
                        this.$stage.position().left +
                        this.$stage.width() -
                        this.width() +
                        this.settings.margin),
                this.state.inMotion && this.support3d)
            )
                (l = this.getTransformProperty()),
                    (this.drag.offsetX = l),
                    this.animate(l),
                    (this.state.inMotion = !0);
            else if (this.state.inMotion && !this.support3d)
                return (this.state.inMotion = !1), !1;
            (this.drag.startX = r - this.drag.offsetX),
                (this.drag.startY = a - this.drag.offsetY),
                (this.drag.start = r - this.drag.startX),
                (this.drag.targetEl = o.target || o.srcElement),
                (this.drag.updatedX = this.drag.start),
                ("IMG" === this.drag.targetEl.tagName ||
                    "A" === this.drag.targetEl.tagName) &&
                    (this.drag.targetEl.draggable = !1),
                t(i).on(
                    "mousemove.owl.dragEvents mouseup.owl.dragEvents touchmove.owl.dragEvents touchend.owl.dragEvents",
                    t.proxy(function(t) {
                        this.eventsRouter(t);
                    }, this)
                );
        }),
        (o.prototype.onDragMove = function(t) {
            var i, o, r, a, l, c;
            this.state.isTouch &&
                (this.state.isScrolling ||
                    ((o = n((i = t.originalEvent || t || e.event)).x),
                    (r = n(i).y),
                    (this.drag.currentX = o - this.drag.startX),
                    (this.drag.currentY = r - this.drag.startY),
                    (this.drag.distance =
                        this.drag.currentX - this.drag.offsetX),
                    this.drag.distance < 0
                        ? (this.state.direction = this.settings.rtl
                              ? "right"
                              : "left")
                        : this.drag.distance > 0 &&
                          (this.state.direction = this.settings.rtl
                              ? "left"
                              : "right"),
                    this.settings.loop
                        ? this.op(
                              this.drag.currentX,
                              ">",
                              this.coordinates(this.minimum())
                          ) && "right" === this.state.direction
                            ? (this.drag.currentX -=
                                  (this.settings.center &&
                                      this.coordinates(0)) -
                                  this.coordinates(this._items.length))
                            : this.op(
                                  this.drag.currentX,
                                  "<",
                                  this.coordinates(this.maximum())
                              ) &&
                              "left" === this.state.direction &&
                              (this.drag.currentX +=
                                  (this.settings.center &&
                                      this.coordinates(0)) -
                                  this.coordinates(this._items.length))
                        : ((a = this.coordinates(
                              this.settings.rtl
                                  ? this.maximum()
                                  : this.minimum()
                          )),
                          (l = this.coordinates(
                              this.settings.rtl
                                  ? this.minimum()
                                  : this.maximum()
                          )),
                          (c = this.settings.pullDrag
                              ? this.drag.distance / 5
                              : 0),
                          (this.drag.currentX = Math.max(
                              Math.min(this.drag.currentX, a + c),
                              l + c
                          ))),
                    (this.drag.distance > 8 || this.drag.distance < -8) &&
                        (i.preventDefault !== s
                            ? i.preventDefault()
                            : (i.returnValue = !1),
                        (this.state.isSwiping = !0)),
                    (this.drag.updatedX = this.drag.currentX),
                    (this.drag.currentY > 16 || this.drag.currentY < -16) &&
                        !1 === this.state.isSwiping &&
                        ((this.state.isScrolling = !0),
                        (this.drag.updatedX = this.drag.start)),
                    this.animate(this.drag.updatedX)));
        }),
        (o.prototype.onDragEnd = function(e) {
            var s, o;
            if (this.state.isTouch) {
                if (
                    ("mouseup" === e.type &&
                        this.$stage.removeClass("owl-grab"),
                    this.trigger("dragged"),
                    this.drag.targetEl.removeAttribute("draggable"),
                    (this.state.isTouch = !1),
                    (this.state.isScrolling = !1),
                    (this.state.isSwiping = !1),
                    0 === this.drag.distance && !0 !== this.state.inMotion)
                )
                    return (this.state.inMotion = !1), !1;
                (this.drag.endTime = new Date().getTime()),
                    (s = this.drag.endTime - this.drag.startTime),
                    (Math.abs(this.drag.distance) > 3 || s > 300) &&
                        this.removeClick(this.drag.targetEl),
                    (o = this.closest(this.drag.updatedX)),
                    this.speed(
                        this.settings.dragEndSpeed || this.settings.smartSpeed
                    ),
                    this.current(o),
                    this.invalidate("position"),
                    this.update(),
                    this.settings.pullDrag ||
                        this.drag.updatedX !== this.coordinates(o) ||
                        this.transitionEnd(),
                    (this.drag.distance = 0),
                    t(i).off(".owl.dragEvents");
            }
        }),
        (o.prototype.removeClick = function(i) {
            (this.drag.targetEl = i),
                t(i).on("click.preventClick", this.e._preventClick),
                e.setTimeout(function() {
                    t(i).off("click.preventClick");
                }, 300);
        }),
        (o.prototype.preventClick = function(e) {
            e.preventDefault ? e.preventDefault() : (e.returnValue = !1),
                e.stopPropagation && e.stopPropagation(),
                t(e.target).off("click.preventClick");
        }),
        (o.prototype.getTransformProperty = function() {
            var t;
            return !0 !==
                (16 ===
                    (t = (t = e
                        .getComputedStyle(this.$stage.get(0), null)
                        .getPropertyValue(this.vendorName + "transform"))
                        .replace(/matrix(3d)?\(|\)/g, "")
                        .split(",")).length)
                ? t[4]
                : t[12];
        }),
        (o.prototype.closest = function(e) {
            var i = -1,
                s = this.width(),
                o = this.coordinates();
            return (
                this.settings.freeDrag ||
                    t.each(
                        o,
                        t.proxy(function(t, n) {
                            return (
                                e > n - 30 && n + 30 > e
                                    ? (i = t)
                                    : this.op(e, "<", n) &&
                                      this.op(e, ">", o[t + 1] || n - s) &&
                                      (i =
                                          "left" === this.state.direction
                                              ? t + 1
                                              : t),
                                -1 === i
                            );
                        }, this)
                    ),
                this.settings.loop ||
                    (this.op(e, ">", o[this.minimum()])
                        ? (i = e = this.minimum())
                        : this.op(e, "<", o[this.maximum()]) &&
                          (i = e = this.maximum())),
                i
            );
        }),
        (o.prototype.animate = function(e) {
            this.trigger("translate"),
                (this.state.inMotion = this.speed() > 0),
                this.support3d
                    ? this.$stage.css({
                          transform: "translate3d(" + e + "px,0px, 0px)",
                          transition: this.speed() / 1e3 + "s"
                      })
                    : this.state.isTouch
                    ? this.$stage.css({ left: e + "px" })
                    : this.$stage.animate(
                          { left: e },
                          this.speed() / 1e3,
                          this.settings.fallbackEasing,
                          t.proxy(function() {
                              this.state.inMotion && this.transitionEnd();
                          }, this)
                      );
        }),
        (o.prototype.current = function(t) {
            if (t === s) return this._current;
            if (0 === this._items.length) return s;
            if (((t = this.normalize(t)), this._current !== t)) {
                var e = this.trigger("change", {
                    property: { name: "position", value: t }
                });
                e.data !== s && (t = this.normalize(e.data)),
                    (this._current = t),
                    this.invalidate("position"),
                    this.trigger("changed", {
                        property: { name: "position", value: this._current }
                    });
            }
            return this._current;
        }),
        (o.prototype.invalidate = function(t) {
            this._invalidated[t] = !0;
        }),
        (o.prototype.reset = function(t) {
            (t = this.normalize(t)) !== s &&
                ((this._speed = 0),
                (this._current = t),
                this.suppress(["translate", "translated"]),
                this.animate(this.coordinates(t)),
                this.release(["translate", "translated"]));
        }),
        (o.prototype.normalize = function(e, i) {
            var o = i
                ? this._items.length
                : this._items.length + this._clones.length;
            return !t.isNumeric(e) || 1 > o
                ? s
                : (e = this._clones.length
                      ? ((e % o) + o) % o
                      : Math.max(
                            this.minimum(i),
                            Math.min(this.maximum(i), e)
                        ));
        }),
        (o.prototype.relative = function(t) {
            return (
                (t = this.normalize(t)),
                (t -= this._clones.length / 2),
                this.normalize(t, !0)
            );
        }),
        (o.prototype.maximum = function(t) {
            var e,
                i,
                s,
                o = 0,
                n = this.settings;
            if (t) return this._items.length - 1;
            if (!n.loop && n.center) e = this._items.length - 1;
            else if (n.loop || n.center)
                if (n.loop || n.center) e = this._items.length + n.items;
                else {
                    if (!n.autoWidth && !n.merge)
                        throw "Can not detect maximum absolute position.";
                    for (
                        revert = n.rtl ? 1 : -1,
                            i = this.$stage.width() - this.$element.width();
                        (s = this.coordinates(o)) && !(s * revert >= i);

                    )
                        e = ++o;
                }
            else e = this._items.length - n.items;
            return e;
        }),
        (o.prototype.minimum = function(t) {
            return t ? 0 : this._clones.length / 2;
        }),
        (o.prototype.items = function(t) {
            return t === s
                ? this._items.slice()
                : ((t = this.normalize(t, !0)), this._items[t]);
        }),
        (o.prototype.mergers = function(t) {
            return t === s
                ? this._mergers.slice()
                : ((t = this.normalize(t, !0)), this._mergers[t]);
        }),
        (o.prototype.clones = function(e) {
            var i = this._clones.length / 2,
                o = i + this._items.length,
                n = function(t) {
                    return t % 2 == 0 ? o + t / 2 : i - (t + 1) / 2;
                };
            return e === s
                ? t.map(this._clones, function(t, e) {
                      return n(e);
                  })
                : t.map(this._clones, function(t, i) {
                      return t === e ? n(i) : null;
                  });
        }),
        (o.prototype.speed = function(t) {
            return t !== s && (this._speed = t), this._speed;
        }),
        (o.prototype.coordinates = function(e) {
            var i = null;
            return e === s
                ? t.map(
                      this._coordinates,
                      t.proxy(function(t, e) {
                          return this.coordinates(e);
                      }, this)
                  )
                : (this.settings.center
                      ? ((i = this._coordinates[e]),
                        (i +=
                            ((this.width() -
                                i +
                                (this._coordinates[e - 1] || 0)) /
                                2) *
                            (this.settings.rtl ? -1 : 1)))
                      : (i = this._coordinates[e - 1] || 0),
                  i);
        }),
        (o.prototype.duration = function(t, e, i) {
            return (
                Math.min(Math.max(Math.abs(e - t), 1), 6) *
                Math.abs(i || this.settings.smartSpeed)
            );
        }),
        (o.prototype.to = function(i, s) {
            if (this.settings.loop) {
                var o = i - this.relative(this.current()),
                    n = this.current(),
                    r = this.current(),
                    a = this.current() + o,
                    l = 0 > r - a,
                    c = this._clones.length + this._items.length;
                a < this.settings.items && !1 === l
                    ? ((n = r + this._items.length), this.reset(n))
                    : a >= c - this.settings.items &&
                      !0 === l &&
                      ((n = r - this._items.length), this.reset(n)),
                    e.clearTimeout(this.e._goToLoop),
                    (this.e._goToLoop = e.setTimeout(
                        t.proxy(function() {
                            this.speed(this.duration(this.current(), n + o, s)),
                                this.current(n + o),
                                this.update();
                        }, this),
                        30
                    ));
            } else
                this.speed(this.duration(this.current(), i, s)),
                    this.current(i),
                    this.update();
        }),
        (o.prototype.next = function(t) {
            (t = t || !1), this.to(this.relative(this.current()) + 1, t);
        }),
        (o.prototype.prev = function(t) {
            (t = t || !1), this.to(this.relative(this.current()) - 1, t);
        }),
        (o.prototype.transitionEnd = function(t) {
            return (
                (t === s ||
                    (t.stopPropagation(),
                    (t.target || t.srcElement || t.originalTarget) ===
                        this.$stage.get(0))) &&
                ((this.state.inMotion = !1), void this.trigger("translated"))
            );
        }),
        (o.prototype.viewport = function() {
            var s;
            if (this.options.responsiveBaseElement !== e)
                s = t(this.options.responsiveBaseElement).width();
            else if (e.innerWidth) s = e.innerWidth;
            else {
                if (!i.documentElement || !i.documentElement.clientWidth)
                    throw "Can not detect viewport width.";
                s = i.documentElement.clientWidth;
            }
            return s;
        }),
        (o.prototype.replace = function(e) {
            this.$stage.empty(),
                (this._items = []),
                e && (e = e instanceof jQuery ? e : t(e)),
                this.settings.nestedItemSelector &&
                    (e = e.find("." + this.settings.nestedItemSelector)),
                e
                    .filter(function() {
                        return 1 === this.nodeType;
                    })
                    .each(
                        t.proxy(function(t, e) {
                            (e = this.prepare(e)),
                                this.$stage.append(e),
                                this._items.push(e),
                                this._mergers.push(
                                    1 *
                                        e
                                            .find("[data-merge]")
                                            .andSelf("[data-merge]")
                                            .attr("data-merge") || 1
                                );
                        }, this)
                    ),
                this.reset(
                    t.isNumeric(this.settings.startPosition)
                        ? this.settings.startPosition
                        : 0
                ),
                this.invalidate("items");
        }),
        (o.prototype.add = function(t, e) {
            (e = e === s ? this._items.length : this.normalize(e, !0)),
                this.trigger("add", { content: t, position: e }),
                0 === this._items.length || e === this._items.length
                    ? (this.$stage.append(t),
                      this._items.push(t),
                      this._mergers.push(
                          1 *
                              t
                                  .find("[data-merge]")
                                  .andSelf("[data-merge]")
                                  .attr("data-merge") || 1
                      ))
                    : (this._items[e].before(t),
                      this._items.splice(e, 0, t),
                      this._mergers.splice(
                          e,
                          0,
                          1 *
                              t
                                  .find("[data-merge]")
                                  .andSelf("[data-merge]")
                                  .attr("data-merge") || 1
                      )),
                this.invalidate("items"),
                this.trigger("added", { content: t, position: e });
        }),
        (o.prototype.remove = function(t) {
            (t = this.normalize(t, !0)) !== s &&
                (this.trigger("remove", {
                    content: this._items[t],
                    position: t
                }),
                this._items[t].remove(),
                this._items.splice(t, 1),
                this._mergers.splice(t, 1),
                this.invalidate("items"),
                this.trigger("removed", { content: null, position: t }));
        }),
        (o.prototype.addTriggerableEvents = function() {
            var e = t.proxy(function(e, i) {
                return t.proxy(function(t) {
                    t.relatedTarget !== this &&
                        (this.suppress([i]),
                        e.apply(this, [].slice.call(arguments, 1)),
                        this.release([i]));
                }, this);
            }, this);
            t.each(
                {
                    next: this.next,
                    prev: this.prev,
                    to: this.to,
                    destroy: this.destroy,
                    refresh: this.refresh,
                    replace: this.replace,
                    add: this.add,
                    remove: this.remove
                },
                t.proxy(function(t, i) {
                    this.$element.on(
                        t + ".owl.carousel",
                        e(i, t + ".owl.carousel")
                    );
                }, this)
            );
        }),
        (o.prototype.watchVisibility = function() {
            function i(t) {
                return t.offsetWidth > 0 && t.offsetHeight > 0;
            }
            i(this.$element.get(0)) ||
                (this.$element.addClass("owl-hidden"),
                e.clearInterval(this.e._checkVisibile),
                (this.e._checkVisibile = e.setInterval(
                    t.proxy(function() {
                        i(this.$element.get(0)) &&
                            (this.$element.removeClass("owl-hidden"),
                            this.refresh(),
                            e.clearInterval(this.e._checkVisibile));
                    }, this),
                    500
                )));
        }),
        (o.prototype.preloadAutoWidthImages = function(e) {
            var i, s, o, n;
            (i = 0),
                (s = this),
                e.each(function(r, a) {
                    (o = t(a)),
                        ((n = new Image()).onload = function() {
                            i++,
                                o.attr("src", n.src),
                                o.css("opacity", 1),
                                i >= e.length &&
                                    ((s.state.imagesLoaded = !0),
                                    s.initialize());
                        }),
                        (n.src =
                            o.attr("src") ||
                            o.attr("data-src") ||
                            o.attr("data-src-retina"));
                });
        }),
        (o.prototype.destroy = function() {
            for (var s in (this.$element.hasClass(this.settings.themeClass) &&
                this.$element.removeClass(this.settings.themeClass),
            !1 !== this.settings.responsive && t(e).off("resize.owl.carousel"),
            this.transitionEndVendor &&
                this.off(
                    this.$stage.get(0),
                    this.transitionEndVendor,
                    this.e._transitionEnd
                ),
            this._plugins))
                this._plugins[s].destroy();
            (this.settings.mouseDrag || this.settings.touchDrag) &&
                (this.$stage.off("mousedown touchstart touchcancel"),
                t(i).off(".owl.dragEvents"),
                (this.$stage.get(0).onselectstart = function() {}),
                this.$stage.off("dragstart", function() {
                    return !1;
                })),
                this.$element.off(".owl"),
                this.$stage.children(".cloned").remove(),
                (this.e = null),
                this.$element.removeData("owlCarousel"),
                this.$stage
                    .children()
                    .contents()
                    .unwrap(),
                this.$stage.children().unwrap(),
                this.$stage.unwrap();
        }),
        (o.prototype.op = function(t, e, i) {
            var s = this.settings.rtl;
            switch (e) {
                case "<":
                    return s ? t > i : i > t;
                case ">":
                    return s ? i > t : t > i;
                case ">=":
                    return s ? i >= t : t >= i;
                case "<=":
                    return s ? t >= i : i >= t;
            }
        }),
        (o.prototype.on = function(t, e, i, s) {
            t.addEventListener
                ? t.addEventListener(e, i, s)
                : t.attachEvent && t.attachEvent("on" + e, i);
        }),
        (o.prototype.off = function(t, e, i, s) {
            t.removeEventListener
                ? t.removeEventListener(e, i, s)
                : t.detachEvent && t.detachEvent("on" + e, i);
        }),
        (o.prototype.trigger = function(e, i, s) {
            var o = {
                    item: { count: this._items.length, index: this.current() }
                },
                n = t.camelCase(
                    t
                        .grep(["on", e, s], function(t) {
                            return t;
                        })
                        .join("-")
                        .toLowerCase()
                ),
                r = t.Event(
                    [e, "owl", s || "carousel"].join(".").toLowerCase(),
                    t.extend({ relatedTarget: this }, o, i)
                );
            return (
                this._supress[e] ||
                    (t.each(this._plugins, function(t, e) {
                        e.onTrigger && e.onTrigger(r);
                    }),
                    this.$element.trigger(r),
                    this.settings &&
                        "function" == typeof this.settings[n] &&
                        this.settings[n].apply(this, r)),
                r
            );
        }),
        (o.prototype.suppress = function(e) {
            t.each(
                e,
                t.proxy(function(t, e) {
                    this._supress[e] = !0;
                }, this)
            );
        }),
        (o.prototype.release = function(e) {
            t.each(
                e,
                t.proxy(function(t, e) {
                    delete this._supress[e];
                }, this)
            );
        }),
        (o.prototype.browserSupport = function() {
            if (
                ((this.support3d = r([
                    "perspective",
                    "webkitPerspective",
                    "MozPerspective",
                    "OPerspective",
                    "MsPerspective"
                ])[0]),
                this.support3d)
            ) {
                this.transformVendor = r([
                    "transform",
                    "WebkitTransform",
                    "MozTransform",
                    "OTransform",
                    "msTransform"
                ])[0];
                (this.transitionEndVendor = [
                    "transitionend",
                    "webkitTransitionEnd",
                    "transitionend",
                    "oTransitionEnd"
                ][
                    r([
                        "transition",
                        "WebkitTransition",
                        "MozTransition",
                        "OTransition"
                    ])[1]
                ]),
                    (this.vendorName = this.transformVendor.replace(
                        /Transform/i,
                        ""
                    )),
                    (this.vendorName =
                        "" !== this.vendorName
                            ? "-" + this.vendorName.toLowerCase() + "-"
                            : "");
            }
            this.state.orientation = e.orientation;
        }),
        (t.fn.owlCarousel = function(e) {
            return this.each(function() {
                t(this).data("owlCarousel") ||
                    t(this).data("owlCarousel", new o(this, e));
            });
        }),
        (t.fn.owlCarousel.Constructor = o);
})(window.Zepto || window.jQuery, window, document),
    (function(t, e) {
        var i = function(e) {
            (this._core = e),
                (this._loaded = []),
                (this._handlers = {
                    "initialized.owl.carousel change.owl.carousel": t.proxy(
                        function(e) {
                            if (
                                e.namespace &&
                                this._core.settings &&
                                this._core.settings.lazyLoad &&
                                ((e.property &&
                                    "position" == e.property.name) ||
                                    "initialized" == e.type)
                            )
                                for (
                                    var i = this._core.settings,
                                        s =
                                            (i.center &&
                                                Math.ceil(i.items / 2)) ||
                                            i.items,
                                        o = (i.center && -1 * s) || 0,
                                        n =
                                            ((e.property && e.property.value) ||
                                                this._core.current()) + o,
                                        r = this._core.clones().length,
                                        a = t.proxy(function(t, e) {
                                            this.load(e);
                                        }, this);
                                    o++ < s;

                                )
                                    this.load(r / 2 + this._core.relative(n)),
                                        r &&
                                            t.each(
                                                this._core.clones(
                                                    this._core.relative(n++)
                                                ),
                                                a
                                            );
                        },
                        this
                    )
                }),
                (this._core.options = t.extend(
                    {},
                    i.Defaults,
                    this._core.options
                )),
                this._core.$element.on(this._handlers);
        };
        (i.Defaults = { lazyLoad: !1 }),
            (i.prototype.load = function(i) {
                var s = this._core.$stage.children().eq(i),
                    o = s && s.find(".owl-lazy");
                !o ||
                    t.inArray(s.get(0), this._loaded) > -1 ||
                    (o.each(
                        t.proxy(function(i, s) {
                            var o,
                                n = t(s),
                                r =
                                    (e.devicePixelRatio > 1 &&
                                        n.attr("data-src-retina")) ||
                                    n.attr("data-src");
                            this._core.trigger(
                                "load",
                                { element: n, url: r },
                                "lazy"
                            ),
                                n.is("img")
                                    ? n
                                          .one(
                                              "load.owl.lazy",
                                              t.proxy(function() {
                                                  n.css("opacity", 1),
                                                      this._core.trigger(
                                                          "loaded",
                                                          {
                                                              element: n,
                                                              url: r
                                                          },
                                                          "lazy"
                                                      );
                                              }, this)
                                          )
                                          .attr("src", r)
                                    : (((o = new Image()).onload = t.proxy(
                                          function() {
                                              n.css({
                                                  "background-image":
                                                      "url(" + r + ")",
                                                  opacity: "1"
                                              }),
                                                  this._core.trigger(
                                                      "loaded",
                                                      { element: n, url: r },
                                                      "lazy"
                                                  );
                                          },
                                          this
                                      )),
                                      (o.src = r));
                        }, this)
                    ),
                    this._loaded.push(s.get(0)));
            }),
            (i.prototype.destroy = function() {
                var t, e;
                for (t in this.handlers)
                    this._core.$element.off(t, this.handlers[t]);
                for (e in Object.getOwnPropertyNames(this))
                    "function" != typeof this[e] && (this[e] = null);
            }),
            (t.fn.owlCarousel.Constructor.Plugins.Lazy = i);
    })(window.Zepto || window.jQuery, window, document),
    (function(t) {
        var e = function(i) {
            (this._core = i),
                (this._handlers = {
                    "initialized.owl.carousel": t.proxy(function() {
                        this._core.settings.autoHeight && this.update();
                    }, this),
                    "changed.owl.carousel": t.proxy(function(t) {
                        this._core.settings.autoHeight &&
                            "position" == t.property.name &&
                            this.update();
                    }, this),
                    "loaded.owl.lazy": t.proxy(function(t) {
                        this._core.settings.autoHeight &&
                            t.element.closest(
                                "." + this._core.settings.itemClass
                            ) ===
                                this._core.$stage
                                    .children()
                                    .eq(this._core.current()) &&
                            this.update();
                    }, this)
                }),
                (this._core.options = t.extend(
                    {},
                    e.Defaults,
                    this._core.options
                )),
                this._core.$element.on(this._handlers);
        };
        (e.Defaults = { autoHeight: !1, autoHeightClass: "owl-height" }),
            (e.prototype.update = function() {
                this._core.$stage
                    .parent()
                    .height(
                        this._core.$stage
                            .children()
                            .eq(this._core.current())
                            .height()
                    )
                    .addClass(this._core.settings.autoHeightClass);
            }),
            (e.prototype.destroy = function() {
                var t, e;
                for (t in this._handlers)
                    this._core.$element.off(t, this._handlers[t]);
                for (e in Object.getOwnPropertyNames(this))
                    "function" != typeof this[e] && (this[e] = null);
            }),
            (t.fn.owlCarousel.Constructor.Plugins.AutoHeight = e);
    })(window.Zepto || window.jQuery, window, document),
    (function(t, e, i) {
        var s = function(e) {
            (this._core = e),
                (this._videos = {}),
                (this._playing = null),
                (this._fullscreen = !1),
                (this._handlers = {
                    "resize.owl.carousel": t.proxy(function(t) {
                        this._core.settings.video &&
                            !this.isInFullScreen() &&
                            t.preventDefault();
                    }, this),
                    "refresh.owl.carousel changed.owl.carousel": t.proxy(
                        function() {
                            this._playing && this.stop();
                        },
                        this
                    ),
                    "prepared.owl.carousel": t.proxy(function(e) {
                        var i = t(e.content).find(".owl-video");
                        i.length &&
                            (i.css("display", "none"),
                            this.fetch(i, t(e.content)));
                    }, this)
                }),
                (this._core.options = t.extend(
                    {},
                    s.Defaults,
                    this._core.options
                )),
                this._core.$element.on(this._handlers),
                this._core.$element.on(
                    "click.owl.video",
                    ".owl-video-play-icon",
                    t.proxy(function(t) {
                        this.play(t);
                    }, this)
                );
        };
        (s.Defaults = { video: !1, videoHeight: !1, videoWidth: !1 }),
            (s.prototype.fetch = function(t, e) {
                var i = t.attr("data-vimeo-id") ? "vimeo" : "youtube",
                    s = t.attr("data-vimeo-id") || t.attr("data-youtube-id"),
                    o = t.attr("data-width") || this._core.settings.videoWidth,
                    n =
                        t.attr("data-height") ||
                        this._core.settings.videoHeight,
                    r = t.attr("href");
                if (!r) throw new Error("Missing video URL.");
                if (
                    (s = r.match(
                        /(http:|https:|)\/\/(player.|www.)?(vimeo\.com|youtu(be\.com|\.be|be\.googleapis\.com))\/(video\/|embed\/|watch\?v=|v\/)?([A-Za-z0-9._%-]*)(\&\S+)?/
                    ))[3].indexOf("youtu") > -1
                )
                    i = "youtube";
                else {
                    if (!(s[3].indexOf("vimeo") > -1))
                        throw new Error("Video URL not supported.");
                    i = "vimeo";
                }
                (s = s[6]),
                    (this._videos[r] = { type: i, id: s, width: o, height: n }),
                    e.attr("data-video", r),
                    this.thumbnail(t, this._videos[r]);
            }),
            (s.prototype.thumbnail = function(e, i) {
                var s,
                    o,
                    n =
                        i.width && i.height
                            ? 'style="width:' +
                              i.width +
                              "px;height:" +
                              i.height +
                              'px;"'
                            : "",
                    r = e.find("img"),
                    a = "src",
                    l = "",
                    c = this._core.settings,
                    d = function(t) {
                        '<div class="owl-video-play-icon"></div>',
                            (s = c.lazyLoad
                                ? '<div class="owl-video-tn ' +
                                  l +
                                  '" ' +
                                  a +
                                  '="' +
                                  t +
                                  '"></div>'
                                : '<div class="owl-video-tn" style="opacity:1;background-image:url(' +
                                  t +
                                  ')"></div>'),
                            e.after(s),
                            e.after('<div class="owl-video-play-icon"></div>');
                    };
                return (
                    e.wrap('<div class="owl-video-wrapper"' + n + "></div>"),
                    this._core.settings.lazyLoad &&
                        ((a = "data-src"), (l = "owl-lazy")),
                    r.length
                        ? (d(r.attr(a)), r.remove(), !1)
                        : void ("youtube" === i.type
                              ? ((o =
                                    "http://img.youtube.com/vi/" +
                                    i.id +
                                    "/hqdefault.jpg"),
                                d(o))
                              : "vimeo" === i.type &&
                                t.ajax({
                                    type: "GET",
                                    url:
                                        "http://vimeo.com/api/v2/video/" +
                                        i.id +
                                        ".json",
                                    jsonp: "callback",
                                    dataType: "jsonp",
                                    success: function(t) {
                                        (o = t[0].thumbnail_large), d(o);
                                    }
                                }))
                );
            }),
            (s.prototype.stop = function() {
                this._core.trigger("stop", null, "video"),
                    this._playing.find(".owl-video-frame").remove(),
                    this._playing.removeClass("owl-video-playing"),
                    (this._playing = null);
            }),
            (s.prototype.play = function(e) {
                this._core.trigger("play", null, "video"),
                    this._playing && this.stop();
                var i,
                    s,
                    o = t(e.target || e.srcElement),
                    n = o.closest("." + this._core.settings.itemClass),
                    r = this._videos[n.attr("data-video")],
                    a = r.width || "100%",
                    l = r.height || this._core.$stage.height();
                "youtube" === r.type
                    ? (i =
                          '<iframe width="' +
                          a +
                          '" height="' +
                          l +
                          '" src="http://www.youtube.com/embed/' +
                          r.id +
                          "?autoplay=1&v=" +
                          r.id +
                          '" frameborder="0" allowfullscreen></iframe>')
                    : "vimeo" === r.type &&
                      (i =
                          '<iframe src="http://player.vimeo.com/video/' +
                          r.id +
                          '?autoplay=1" width="' +
                          a +
                          '" height="' +
                          l +
                          '" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>'),
                    n.addClass("owl-video-playing"),
                    (this._playing = n),
                    (s = t(
                        '<div style="height:' +
                            l +
                            "px; width:" +
                            a +
                            'px" class="owl-video-frame">' +
                            i +
                            "</div>"
                    )),
                    o.after(s);
            }),
            (s.prototype.isInFullScreen = function() {
                var s =
                    i.fullscreenElement ||
                    i.mozFullScreenElement ||
                    i.webkitFullscreenElement;
                return (
                    s &&
                        t(s)
                            .parent()
                            .hasClass("owl-video-frame") &&
                        (this._core.speed(0), (this._fullscreen = !0)),
                    !(s && this._fullscreen && this._playing) &&
                        (this._fullscreen
                            ? ((this._fullscreen = !1), !1)
                            : !this._playing ||
                              this._core.state.orientation === e.orientation ||
                              ((this._core.state.orientation = e.orientation),
                              !1))
                );
            }),
            (s.prototype.destroy = function() {
                var t, e;
                for (t in (this._core.$element.off("click.owl.video"),
                this._handlers))
                    this._core.$element.off(t, this._handlers[t]);
                for (e in Object.getOwnPropertyNames(this))
                    "function" != typeof this[e] && (this[e] = null);
            }),
            (t.fn.owlCarousel.Constructor.Plugins.Video = s);
    })(window.Zepto || window.jQuery, window, document),
    (function(t, e, i, s) {
        var o = function(e) {
            (this.core = e),
                (this.core.options = t.extend(
                    {},
                    o.Defaults,
                    this.core.options
                )),
                (this.swapping = !0),
                (this.previous = s),
                (this.next = s),
                (this.handlers = {
                    "change.owl.carousel": t.proxy(function(t) {
                        "position" == t.property.name &&
                            ((this.previous = this.core.current()),
                            (this.next = t.property.value));
                    }, this),
                    "drag.owl.carousel dragged.owl.carousel translated.owl.carousel": t.proxy(
                        function(t) {
                            this.swapping = "translated" == t.type;
                        },
                        this
                    ),
                    "translate.owl.carousel": t.proxy(function() {
                        this.swapping &&
                            (this.core.options.animateOut ||
                                this.core.options.animateIn) &&
                            this.swap();
                    }, this)
                }),
                this.core.$element.on(this.handlers);
        };
        (o.Defaults = { animateOut: !1, animateIn: !1 }),
            (o.prototype.swap = function() {
                if (1 === this.core.settings.items && this.core.support3d) {
                    this.core.speed(0);
                    var e,
                        i = t.proxy(this.clear, this),
                        s = this.core.$stage.children().eq(this.previous),
                        o = this.core.$stage.children().eq(this.next),
                        n = this.core.settings.animateIn,
                        r = this.core.settings.animateOut;
                    this.core.current() !== this.previous &&
                        (r &&
                            ((e =
                                this.core.coordinates(this.previous) -
                                this.core.coordinates(this.next)),
                            s
                                .css({ left: e + "px" })
                                .addClass("animated owl-animated-out")
                                .addClass(r)
                                .one(
                                    "webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend",
                                    i
                                )),
                        n &&
                            o
                                .addClass("animated owl-animated-in")
                                .addClass(n)
                                .one(
                                    "webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend",
                                    i
                                ));
                }
            }),
            (o.prototype.clear = function(e) {
                t(e.target)
                    .css({ left: "" })
                    .removeClass("animated owl-animated-out owl-animated-in")
                    .removeClass(this.core.settings.animateIn)
                    .removeClass(this.core.settings.animateOut),
                    this.core.transitionEnd();
            }),
            (o.prototype.destroy = function() {
                var t, e;
                for (t in this.handlers)
                    this.core.$element.off(t, this.handlers[t]);
                for (e in Object.getOwnPropertyNames(this))
                    "function" != typeof this[e] && (this[e] = null);
            }),
            (t.fn.owlCarousel.Constructor.Plugins.Animate = o);
    })(window.Zepto || window.jQuery, window, document),
    (function(t, e, i) {
        var s = function(e) {
            (this.core = e),
                (this.core.options = t.extend(
                    {},
                    s.Defaults,
                    this.core.options
                )),
                (this.handlers = {
                    "translated.owl.carousel refreshed.owl.carousel": t.proxy(
                        function() {
                            this.autoplay();
                        },
                        this
                    ),
                    "play.owl.autoplay": t.proxy(function(t, e, i) {
                        this.play(e, i);
                    }, this),
                    "stop.owl.autoplay": t.proxy(function() {
                        this.stop();
                    }, this),
                    "mouseover.owl.autoplay": t.proxy(function() {
                        this.core.settings.autoplayHoverPause && this.pause();
                    }, this),
                    "mouseleave.owl.autoplay": t.proxy(function() {
                        this.core.settings.autoplayHoverPause &&
                            this.autoplay();
                    }, this)
                }),
                this.core.$element.on(this.handlers);
        };
        (s.Defaults = {
            autoplay: !1,
            autoplayTimeout: 5e3,
            autoplayHoverPause: !1,
            autoplaySpeed: !1
        }),
            (s.prototype.autoplay = function() {
                this.core.settings.autoplay && !this.core.state.videoPlay
                    ? (e.clearInterval(this.interval),
                      (this.interval = e.setInterval(
                          t.proxy(function() {
                              this.play();
                          }, this),
                          this.core.settings.autoplayTimeout
                      )))
                    : e.clearInterval(this.interval);
            }),
            (s.prototype.play = function() {
                return !0 === i.hidden ||
                    this.core.state.isTouch ||
                    this.core.state.isScrolling ||
                    this.core.state.isSwiping ||
                    this.core.state.inMotion
                    ? void 0
                    : !1 === this.core.settings.autoplay
                    ? void e.clearInterval(this.interval)
                    : void this.core.next(this.core.settings.autoplaySpeed);
            }),
            (s.prototype.stop = function() {
                e.clearInterval(this.interval);
            }),
            (s.prototype.pause = function() {
                e.clearInterval(this.interval);
            }),
            (s.prototype.destroy = function() {
                var t, i;
                for (t in (e.clearInterval(this.interval), this.handlers))
                    this.core.$element.off(t, this.handlers[t]);
                for (i in Object.getOwnPropertyNames(this))
                    "function" != typeof this[i] && (this[i] = null);
            }),
            (t.fn.owlCarousel.Constructor.Plugins.autoplay = s);
    })(window.Zepto || window.jQuery, window, document),
    (function(t) {
        "use strict";
        var e = function(i) {
            (this._core = i),
                (this._initialized = !1),
                (this._pages = []),
                (this._controls = {}),
                (this._templates = []),
                (this.$element = this._core.$element),
                (this._overrides = {
                    next: this._core.next,
                    prev: this._core.prev,
                    to: this._core.to
                }),
                (this._handlers = {
                    "prepared.owl.carousel": t.proxy(function(e) {
                        this._core.settings.dotsData &&
                            this._templates.push(
                                t(e.content)
                                    .find("[data-dot]")
                                    .andSelf("[data-dot]")
                                    .attr("data-dot")
                            );
                    }, this),
                    "add.owl.carousel": t.proxy(function(e) {
                        this._core.settings.dotsData &&
                            this._templates.splice(
                                e.position,
                                0,
                                t(e.content)
                                    .find("[data-dot]")
                                    .andSelf("[data-dot]")
                                    .attr("data-dot")
                            );
                    }, this),
                    "remove.owl.carousel prepared.owl.carousel": t.proxy(
                        function(t) {
                            this._core.settings.dotsData &&
                                this._templates.splice(t.position, 1);
                        },
                        this
                    ),
                    "change.owl.carousel": t.proxy(function(t) {
                        if (
                            "position" == t.property.name &&
                            !this._core.state.revert &&
                            !this._core.settings.loop &&
                            this._core.settings.navRewind
                        ) {
                            var e = this._core.current(),
                                i = this._core.maximum(),
                                s = this._core.minimum();
                            t.data =
                                t.property.value > i
                                    ? e >= i
                                        ? s
                                        : i
                                    : t.property.value < s
                                    ? i
                                    : t.property.value;
                        }
                    }, this),
                    "changed.owl.carousel": t.proxy(function(t) {
                        "position" == t.property.name && this.draw();
                    }, this),
                    "refreshed.owl.carousel": t.proxy(function() {
                        this._initialized ||
                            (this.initialize(), (this._initialized = !0)),
                            this._core.trigger("refresh", null, "navigation"),
                            this.update(),
                            this.draw(),
                            this._core.trigger("refreshed", null, "navigation");
                    }, this)
                }),
                (this._core.options = t.extend(
                    {},
                    e.Defaults,
                    this._core.options
                )),
                this.$element.on(this._handlers);
        };
        (e.Defaults = {
            nav: !1,
            navRewind: !0,
            navText: ["prev", "next"],
            navSpeed: !1,
            navElement: "div",
            navContainer: !1,
            navContainerClass: "owl-nav",
            navClass: ["owl-prev", "owl-next"],
            slideBy: 1,
            dotClass: "owl-dot",
            dotsClass: "owl-dots",
            dots: !0,
            dotsEach: !1,
            dotData: !1,
            dotsSpeed: !1,
            dotsContainer: !1,
            controlsClass: "owl-controls"
        }),
            (e.prototype.initialize = function() {
                var e,
                    i,
                    s = this._core.settings;
                for (i in (s.dotsData ||
                    (this._templates = [
                        t("<div>")
                            .addClass(s.dotClass)
                            .append(t("<span>"))
                            .prop("outerHTML")
                    ]),
                (s.navContainer && s.dotsContainer) ||
                    (this._controls.$container = t("<div>")
                        .addClass(s.controlsClass)
                        .appendTo(this.$element)),
                (this._controls.$indicators = s.dotsContainer
                    ? t(s.dotsContainer)
                    : t("<div>")
                          .hide()
                          .addClass(s.dotsClass)
                          .appendTo(this._controls.$container)),
                this._controls.$indicators.on(
                    "click",
                    "div",
                    t.proxy(function(e) {
                        var i = t(e.target)
                            .parent()
                            .is(this._controls.$indicators)
                            ? t(e.target).index()
                            : t(e.target)
                                  .parent()
                                  .index();
                        e.preventDefault(), this.to(i, s.dotsSpeed);
                    }, this)
                ),
                (e = s.navContainer
                    ? t(s.navContainer)
                    : t("<div>")
                          .addClass(s.navContainerClass)
                          .prependTo(this._controls.$container)),
                (this._controls.$next = t("<" + s.navElement + ">")),
                (this._controls.$previous = this._controls.$next.clone()),
                this._controls.$previous
                    .addClass(s.navClass[0])
                    .html(s.navText[0])
                    .hide()
                    .prependTo(e)
                    .on(
                        "click",
                        t.proxy(function() {
                            this.prev(s.navSpeed);
                        }, this)
                    ),
                this._controls.$next
                    .addClass(s.navClass[1])
                    .html(s.navText[1])
                    .hide()
                    .appendTo(e)
                    .on(
                        "click",
                        t.proxy(function() {
                            this.next(s.navSpeed);
                        }, this)
                    ),
                this._overrides))
                    this._core[i] = t.proxy(this[i], this);
            }),
            (e.prototype.destroy = function() {
                var t, e, i, s;
                for (t in this._handlers)
                    this.$element.off(t, this._handlers[t]);
                for (e in this._controls) this._controls[e].remove();
                for (s in this.overides) this._core[s] = this._overrides[s];
                for (i in Object.getOwnPropertyNames(this))
                    "function" != typeof this[i] && (this[i] = null);
            }),
            (e.prototype.update = function() {
                var t,
                    e,
                    i = this._core.settings,
                    s = this._core.clones().length / 2,
                    o = s + this._core.items().length,
                    n =
                        i.center || i.autoWidth || i.dotData
                            ? 1
                            : i.dotsEach || i.items;
                if (
                    ("page" !== i.slideBy &&
                        (i.slideBy = Math.min(i.slideBy, i.items)),
                    i.dots || "page" == i.slideBy)
                )
                    for (this._pages = [], t = s, e = 0, 0; o > t; t++)
                        (e >= n || 0 === e) &&
                            (this._pages.push({
                                start: t - s,
                                end: t - s + n - 1
                            }),
                            (e = 0),
                            0),
                            (e += this._core.mergers(this._core.relative(t)));
            }),
            (e.prototype.draw = function() {
                var e,
                    i,
                    s = "",
                    o = this._core.settings,
                    n =
                        (this._core.$stage.children(),
                        this._core.relative(this._core.current()));
                if (
                    (!o.nav ||
                        o.loop ||
                        o.navRewind ||
                        (this._controls.$previous.toggleClass(
                            "disabled",
                            0 >= n
                        ),
                        this._controls.$next.toggleClass(
                            "disabled",
                            n >= this._core.maximum()
                        )),
                    this._controls.$previous.toggle(o.nav),
                    this._controls.$next.toggle(o.nav),
                    o.dots)
                ) {
                    if (
                        ((e =
                            this._pages.length -
                            this._controls.$indicators.children().length),
                        o.dotData && 0 !== e)
                    ) {
                        for (
                            i = 0;
                            i < this._controls.$indicators.children().length;
                            i++
                        )
                            s += this._templates[this._core.relative(i)];
                        this._controls.$indicators.html(s);
                    } else
                        e > 0
                            ? ((s = new Array(e + 1).join(this._templates[0])),
                              this._controls.$indicators.append(s))
                            : 0 > e &&
                              this._controls.$indicators
                                  .children()
                                  .slice(e)
                                  .remove();
                    this._controls.$indicators
                        .find(".active")
                        .removeClass("active"),
                        this._controls.$indicators
                            .children()
                            .eq(t.inArray(this.current(), this._pages))
                            .addClass("active");
                }
                this._controls.$indicators.toggle(o.dots);
            }),
            (e.prototype.onTrigger = function(e) {
                var i = this._core.settings;
                e.page = {
                    index: t.inArray(this.current(), this._pages),
                    count: this._pages.length,
                    size:
                        i &&
                        (i.center || i.autoWidth || i.dotData
                            ? 1
                            : i.dotsEach || i.items)
                };
            }),
            (e.prototype.current = function() {
                var e = this._core.relative(this._core.current());
                return t
                    .grep(this._pages, function(t) {
                        return t.start <= e && t.end >= e;
                    })
                    .pop();
            }),
            (e.prototype.getPosition = function(e) {
                var i,
                    s,
                    o = this._core.settings;
                return (
                    "page" == o.slideBy
                        ? ((i = t.inArray(this.current(), this._pages)),
                          (s = this._pages.length),
                          e ? ++i : --i,
                          (i = this._pages[((i % s) + s) % s].start))
                        : ((i = this._core.relative(this._core.current())),
                          (s = this._core.items().length),
                          e ? (i += o.slideBy) : (i -= o.slideBy)),
                    i
                );
            }),
            (e.prototype.next = function(e) {
                t.proxy(this._overrides.to, this._core)(
                    this.getPosition(!0),
                    e
                );
            }),
            (e.prototype.prev = function(e) {
                t.proxy(this._overrides.to, this._core)(
                    this.getPosition(!1),
                    e
                );
            }),
            (e.prototype.to = function(e, i, s) {
                var o;
                s
                    ? t.proxy(this._overrides.to, this._core)(e, i)
                    : ((o = this._pages.length),
                      t.proxy(this._overrides.to, this._core)(
                          this._pages[((e % o) + o) % o].start,
                          i
                      ));
            }),
            (t.fn.owlCarousel.Constructor.Plugins.Navigation = e);
    })(window.Zepto || window.jQuery, window, document),
    (function(t, e) {
        "use strict";
        var i = function(s) {
            (this._core = s),
                (this._hashes = {}),
                (this.$element = this._core.$element),
                (this._handlers = {
                    "initialized.owl.carousel": t.proxy(function() {
                        "URLHash" == this._core.settings.startPosition &&
                            t(e).trigger("hashchange.owl.navigation");
                    }, this),
                    "prepared.owl.carousel": t.proxy(function(e) {
                        var i = t(e.content)
                            .find("[data-hash]")
                            .andSelf("[data-hash]")
                            .attr("data-hash");
                        this._hashes[i] = e.content;
                    }, this)
                }),
                (this._core.options = t.extend(
                    {},
                    i.Defaults,
                    this._core.options
                )),
                this.$element.on(this._handlers),
                t(e).on(
                    "hashchange.owl.navigation",
                    t.proxy(function() {
                        var t = e.location.hash.substring(1),
                            i = this._core.$stage.children(),
                            s =
                                (this._hashes[t] && i.index(this._hashes[t])) ||
                                0;
                        return !!t && void this._core.to(s, !1, !0);
                    }, this)
                );
        };
        (i.Defaults = { URLhashListener: !1 }),
            (i.prototype.destroy = function() {
                var i, s;
                for (i in (t(e).off("hashchange.owl.navigation"),
                this._handlers))
                    this._core.$element.off(i, this._handlers[i]);
                for (s in Object.getOwnPropertyNames(this))
                    "function" != typeof this[s] && (this[s] = null);
            }),
            (t.fn.owlCarousel.Constructor.Plugins.Hash = i);
    })(window.Zepto || window.jQuery, window, document),
    (function(t) {
        "use strict";
        "function" == typeof define && define.amd
            ? define(["jquery"], t)
            : "undefined" != typeof exports
            ? (module.exports = t(require("jquery")))
            : t(jQuery);
    })(function(t) {
        "use strict";
        var e = window.Slick || {};
        ((e = (function() {
            var e = 0;
            return function(i, s) {
                var o,
                    n = this;
                (n.defaults = {
                    accessibility: !0,
                    adaptiveHeight: !1,
                    appendArrows: t(i),
                    appendDots: t(i),
                    arrows: !0,
                    asNavFor: null,
                    prevArrow:
                        '<button class="slick-prev" aria-label="Previous" type="button">Previous</button>',
                    nextArrow:
                        '<button class="slick-next" aria-label="Next" type="button">Next</button>',
                    autoplay: !1,
                    autoplaySpeed: 3e3,
                    centerMode: !1,
                    centerPadding: "50px",
                    cssEase: "ease",
                    customPaging: function(e, i) {
                        return t('<button type="button" />').text(i + 1);
                    },
                    dots: !1,
                    dotsClass: "slick-dots",
                    draggable: !0,
                    easing: "linear",
                    edgeFriction: 0.35,
                    fade: !1,
                    focusOnSelect: !1,
                    focusOnChange: !1,
                    infinite: !0,
                    initialSlide: 0,
                    lazyLoad: "ondemand",
                    mobileFirst: !1,
                    pauseOnHover: !0,
                    pauseOnFocus: !0,
                    pauseOnDotsHover: !1,
                    respondTo: "window",
                    responsive: null,
                    rows: 1,
                    rtl: !1,
                    slide: "",
                    slidesPerRow: 1,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    speed: 500,
                    swipe: !0,
                    swipeToSlide: !1,
                    touchMove: !0,
                    touchThreshold: 5,
                    useCSS: !0,
                    useTransform: !0,
                    variableWidth: !1,
                    vertical: !1,
                    verticalSwiping: !1,
                    waitForAnimate: !0,
                    zIndex: 1e3
                }),
                    (n.initials = {
                        animating: !1,
                        dragging: !1,
                        autoPlayTimer: null,
                        currentDirection: 0,
                        currentLeft: null,
                        currentSlide: 0,
                        direction: 1,
                        $dots: null,
                        listWidth: null,
                        listHeight: null,
                        loadIndex: 0,
                        $nextArrow: null,
                        $prevArrow: null,
                        scrolling: !1,
                        slideCount: null,
                        slideWidth: null,
                        $slideTrack: null,
                        $slides: null,
                        sliding: !1,
                        slideOffset: 0,
                        swipeLeft: null,
                        swiping: !1,
                        $list: null,
                        touchObject: {},
                        transformsEnabled: !1,
                        unslicked: !1
                    }),
                    t.extend(n, n.initials),
                    (n.activeBreakpoint = null),
                    (n.animType = null),
                    (n.animProp = null),
                    (n.breakpoints = []),
                    (n.breakpointSettings = []),
                    (n.cssTransitions = !1),
                    (n.focussed = !1),
                    (n.interrupted = !1),
                    (n.hidden = "hidden"),
                    (n.paused = !0),
                    (n.positionProp = null),
                    (n.respondTo = null),
                    (n.rowCount = 1),
                    (n.shouldClick = !0),
                    (n.$slider = t(i)),
                    (n.$slidesCache = null),
                    (n.transformType = null),
                    (n.transitionType = null),
                    (n.visibilityChange = "visibilitychange"),
                    (n.windowWidth = 0),
                    (n.windowTimer = null),
                    (o = t(i).data("slick") || {}),
                    (n.options = t.extend({}, n.defaults, s, o)),
                    (n.currentSlide = n.options.initialSlide),
                    (n.originalSettings = n.options),
                    void 0 !== document.mozHidden
                        ? ((n.hidden = "mozHidden"),
                          (n.visibilityChange = "mozvisibilitychange"))
                        : void 0 !== document.webkitHidden &&
                          ((n.hidden = "webkitHidden"),
                          (n.visibilityChange = "webkitvisibilitychange")),
                    (n.autoPlay = t.proxy(n.autoPlay, n)),
                    (n.autoPlayClear = t.proxy(n.autoPlayClear, n)),
                    (n.autoPlayIterator = t.proxy(n.autoPlayIterator, n)),
                    (n.changeSlide = t.proxy(n.changeSlide, n)),
                    (n.clickHandler = t.proxy(n.clickHandler, n)),
                    (n.selectHandler = t.proxy(n.selectHandler, n)),
                    (n.setPosition = t.proxy(n.setPosition, n)),
                    (n.swipeHandler = t.proxy(n.swipeHandler, n)),
                    (n.dragHandler = t.proxy(n.dragHandler, n)),
                    (n.keyHandler = t.proxy(n.keyHandler, n)),
                    (n.instanceUid = e++),
                    (n.htmlExpr = /^(?:\s*(<[\w\W]+>)[^>]*)$/),
                    n.registerBreakpoints(),
                    n.init(!0);
            };
        })()).prototype.activateADA = function() {
            this.$slideTrack
                .find(".slick-active")
                .attr({ "aria-hidden": "false" })
                .find("a, input, button, select")
                .attr({ tabindex: "0" });
        }),
            (e.prototype.addSlide = e.prototype.slickAdd = function(e, i, s) {
                var o = this;
                if ("boolean" == typeof i) (s = i), (i = null);
                else if (i < 0 || i >= o.slideCount) return !1;
                o.unload(),
                    "number" == typeof i
                        ? 0 === i && 0 === o.$slides.length
                            ? t(e).appendTo(o.$slideTrack)
                            : s
                            ? t(e).insertBefore(o.$slides.eq(i))
                            : t(e).insertAfter(o.$slides.eq(i))
                        : !0 === s
                        ? t(e).prependTo(o.$slideTrack)
                        : t(e).appendTo(o.$slideTrack),
                    (o.$slides = o.$slideTrack.children(this.options.slide)),
                    o.$slideTrack.children(this.options.slide).detach(),
                    o.$slideTrack.append(o.$slides),
                    o.$slides.each(function(e, i) {
                        t(i).attr("data-slick-index", e);
                    }),
                    (o.$slidesCache = o.$slides),
                    o.reinit();
            }),
            (e.prototype.animateHeight = function() {
                var t = this;
                if (
                    1 === t.options.slidesToShow &&
                    !0 === t.options.adaptiveHeight &&
                    !1 === t.options.vertical
                ) {
                    var e = t.$slides.eq(t.currentSlide).outerHeight(!0);
                    t.$list.animate({ height: e }, t.options.speed);
                }
            }),
            (e.prototype.animateSlide = function(e, i) {
                var s = {},
                    o = this;
                o.animateHeight(),
                    !0 === o.options.rtl &&
                        !1 === o.options.vertical &&
                        (e = -e),
                    !1 === o.transformsEnabled
                        ? !1 === o.options.vertical
                            ? o.$slideTrack.animate(
                                  { left: e },
                                  o.options.speed,
                                  o.options.easing,
                                  i
                              )
                            : o.$slideTrack.animate(
                                  { top: e },
                                  o.options.speed,
                                  o.options.easing,
                                  i
                              )
                        : !1 === o.cssTransitions
                        ? (!0 === o.options.rtl &&
                              (o.currentLeft = -o.currentLeft),
                          t({ animStart: o.currentLeft }).animate(
                              { animStart: e },
                              {
                                  duration: o.options.speed,
                                  easing: o.options.easing,
                                  step: function(t) {
                                      (t = Math.ceil(t)),
                                          !1 === o.options.vertical
                                              ? ((s[o.animType] =
                                                    "translate(" +
                                                    t +
                                                    "px, 0px)"),
                                                o.$slideTrack.css(s))
                                              : ((s[o.animType] =
                                                    "translate(0px," +
                                                    t +
                                                    "px)"),
                                                o.$slideTrack.css(s));
                                  },
                                  complete: function() {
                                      i && i.call();
                                  }
                              }
                          ))
                        : (o.applyTransition(),
                          (e = Math.ceil(e)),
                          !1 === o.options.vertical
                              ? (s[o.animType] =
                                    "translate3d(" + e + "px, 0px, 0px)")
                              : (s[o.animType] =
                                    "translate3d(0px," + e + "px, 0px)"),
                          o.$slideTrack.css(s),
                          i &&
                              setTimeout(function() {
                                  o.disableTransition(), i.call();
                              }, o.options.speed));
            }),
            (e.prototype.getNavTarget = function() {
                var e = this.options.asNavFor;
                return e && null !== e && (e = t(e).not(this.$slider)), e;
            }),
            (e.prototype.asNavFor = function(e) {
                var i = this.getNavTarget();
                null !== i &&
                    "object" == typeof i &&
                    i.each(function() {
                        var i = t(this).slick("getSlick");
                        i.unslicked || i.slideHandler(e, !0);
                    });
            }),
            (e.prototype.applyTransition = function(t) {
                var e = this,
                    i = {};
                !1 === e.options.fade
                    ? (i[e.transitionType] =
                          e.transformType +
                          " " +
                          e.options.speed +
                          "ms " +
                          e.options.cssEase)
                    : (i[e.transitionType] =
                          "opacity " +
                          e.options.speed +
                          "ms " +
                          e.options.cssEase),
                    !1 === e.options.fade
                        ? e.$slideTrack.css(i)
                        : e.$slides.eq(t).css(i);
            }),
            (e.prototype.autoPlay = function() {
                var t = this;
                t.autoPlayClear(),
                    t.slideCount > t.options.slidesToShow &&
                        (t.autoPlayTimer = setInterval(
                            t.autoPlayIterator,
                            t.options.autoplaySpeed
                        ));
            }),
            (e.prototype.autoPlayClear = function() {
                this.autoPlayTimer && clearInterval(this.autoPlayTimer);
            }),
            (e.prototype.autoPlayIterator = function() {
                var t = this,
                    e = t.currentSlide + t.options.slidesToScroll;
                t.paused ||
                    t.interrupted ||
                    t.focussed ||
                    (!1 === t.options.infinite &&
                        (1 === t.direction &&
                        t.currentSlide + 1 === t.slideCount - 1
                            ? (t.direction = 0)
                            : 0 === t.direction &&
                              ((e = t.currentSlide - t.options.slidesToScroll),
                              t.currentSlide - 1 == 0 && (t.direction = 1))),
                    t.slideHandler(e));
            }),
            (e.prototype.buildArrows = function() {
                var e = this;
                !0 === e.options.arrows &&
                    ((e.$prevArrow = t(e.options.prevArrow).addClass(
                        "slick-arrow"
                    )),
                    (e.$nextArrow = t(e.options.nextArrow).addClass(
                        "slick-arrow"
                    )),
                    e.slideCount > e.options.slidesToShow
                        ? (e.$prevArrow
                              .removeClass("slick-hidden")
                              .removeAttr("aria-hidden tabindex"),
                          e.$nextArrow
                              .removeClass("slick-hidden")
                              .removeAttr("aria-hidden tabindex"),
                          e.htmlExpr.test(e.options.prevArrow) &&
                              e.$prevArrow.prependTo(e.options.appendArrows),
                          e.htmlExpr.test(e.options.nextArrow) &&
                              e.$nextArrow.appendTo(e.options.appendArrows),
                          !0 !== e.options.infinite &&
                              e.$prevArrow
                                  .addClass("slick-disabled")
                                  .attr("aria-disabled", "true"))
                        : e.$prevArrow
                              .add(e.$nextArrow)
                              .addClass("slick-hidden")
                              .attr({
                                  "aria-disabled": "true",
                                  tabindex: "-1"
                              }));
            }),
            (e.prototype.buildDots = function() {
                var e,
                    i,
                    s = this;
                if (!0 === s.options.dots) {
                    for (
                        s.$slider.addClass("slick-dotted"),
                            i = t("<ul />").addClass(s.options.dotsClass),
                            e = 0;
                        e <= s.getDotCount();
                        e += 1
                    )
                        i.append(
                            t("<li />").append(
                                s.options.customPaging.call(this, s, e)
                            )
                        );
                    (s.$dots = i.appendTo(s.options.appendDots)),
                        s.$dots
                            .find("li")
                            .first()
                            .addClass("slick-active");
                }
            }),
            (e.prototype.buildOut = function() {
                var e = this;
                (e.$slides = e.$slider
                    .children(e.options.slide + ":not(.slick-cloned)")
                    .addClass("slick-slide")),
                    (e.slideCount = e.$slides.length),
                    e.$slides.each(function(e, i) {
                        t(i)
                            .attr("data-slick-index", e)
                            .data("originalStyling", t(i).attr("style") || "");
                    }),
                    e.$slider.addClass("slick-slider"),
                    (e.$slideTrack =
                        0 === e.slideCount
                            ? t('<div class="slick-track"/>').appendTo(
                                  e.$slider
                              )
                            : e.$slides
                                  .wrapAll('<div class="slick-track"/>')
                                  .parent()),
                    (e.$list = e.$slideTrack
                        .wrap('<div class="slick-list"/>')
                        .parent()),
                    e.$slideTrack.css("opacity", 0),
                    (!0 !== e.options.centerMode &&
                        !0 !== e.options.swipeToSlide) ||
                        (e.options.slidesToScroll = 1),
                    t("img[data-lazy]", e.$slider)
                        .not("[src]")
                        .addClass("slick-loading"),
                    e.setupInfinite(),
                    e.buildArrows(),
                    e.buildDots(),
                    e.updateDots(),
                    e.setSlideClasses(
                        "number" == typeof e.currentSlide ? e.currentSlide : 0
                    ),
                    !0 === e.options.draggable && e.$list.addClass("draggable");
            }),
            (e.prototype.buildRows = function() {
                var t,
                    e,
                    i,
                    s,
                    o,
                    n,
                    r,
                    a = this;
                if (
                    ((s = document.createDocumentFragment()),
                    (n = a.$slider.children()),
                    a.options.rows > 1)
                ) {
                    for (
                        r = a.options.slidesPerRow * a.options.rows,
                            o = Math.ceil(n.length / r),
                            t = 0;
                        t < o;
                        t++
                    ) {
                        var l = document.createElement("div");
                        for (e = 0; e < a.options.rows; e++) {
                            var c = document.createElement("div");
                            for (i = 0; i < a.options.slidesPerRow; i++) {
                                var d =
                                    t * r + (e * a.options.slidesPerRow + i);
                                n.get(d) && c.appendChild(n.get(d));
                            }
                            l.appendChild(c);
                        }
                        s.appendChild(l);
                    }
                    a.$slider.empty().append(s),
                        a.$slider
                            .children()
                            .children()
                            .children()
                            .css({
                                width: 100 / a.options.slidesPerRow + "%",
                                display: "inline-block"
                            });
                }
            }),
            (e.prototype.checkResponsive = function(e, i) {
                var s,
                    o,
                    n,
                    r = this,
                    a = !1,
                    l = r.$slider.width(),
                    c = window.innerWidth || t(window).width();
                if (
                    ("window" === r.respondTo
                        ? (n = c)
                        : "slider" === r.respondTo
                        ? (n = l)
                        : "min" === r.respondTo && (n = Math.min(c, l)),
                    r.options.responsive &&
                        r.options.responsive.length &&
                        null !== r.options.responsive)
                ) {
                    for (s in ((o = null), r.breakpoints))
                        r.breakpoints.hasOwnProperty(s) &&
                            (!1 === r.originalSettings.mobileFirst
                                ? n < r.breakpoints[s] && (o = r.breakpoints[s])
                                : n > r.breakpoints[s] &&
                                  (o = r.breakpoints[s]));
                    null !== o
                        ? null !== r.activeBreakpoint
                            ? (o !== r.activeBreakpoint || i) &&
                              ((r.activeBreakpoint = o),
                              "unslick" === r.breakpointSettings[o]
                                  ? r.unslick(o)
                                  : ((r.options = t.extend(
                                        {},
                                        r.originalSettings,
                                        r.breakpointSettings[o]
                                    )),
                                    !0 === e &&
                                        (r.currentSlide =
                                            r.options.initialSlide),
                                    r.refresh(e)),
                              (a = o))
                            : ((r.activeBreakpoint = o),
                              "unslick" === r.breakpointSettings[o]
                                  ? r.unslick(o)
                                  : ((r.options = t.extend(
                                        {},
                                        r.originalSettings,
                                        r.breakpointSettings[o]
                                    )),
                                    !0 === e &&
                                        (r.currentSlide =
                                            r.options.initialSlide),
                                    r.refresh(e)),
                              (a = o))
                        : null !== r.activeBreakpoint &&
                          ((r.activeBreakpoint = null),
                          (r.options = r.originalSettings),
                          !0 === e && (r.currentSlide = r.options.initialSlide),
                          r.refresh(e),
                          (a = o)),
                        e ||
                            !1 === a ||
                            r.$slider.trigger("breakpoint", [r, a]);
                }
            }),
            (e.prototype.changeSlide = function(e, i) {
                var s,
                    o,
                    n = this,
                    r = t(e.currentTarget);
                switch (
                    (r.is("a") && e.preventDefault(),
                    r.is("li") || (r = r.closest("li")),
                    (s =
                        n.slideCount % n.options.slidesToScroll != 0
                            ? 0
                            : (n.slideCount - n.currentSlide) %
                              n.options.slidesToScroll),
                    e.data.message)
                ) {
                    case "previous":
                        (o =
                            0 === s
                                ? n.options.slidesToScroll
                                : n.options.slidesToShow - s),
                            n.slideCount > n.options.slidesToShow &&
                                n.slideHandler(n.currentSlide - o, !1, i);
                        break;
                    case "next":
                        (o = 0 === s ? n.options.slidesToScroll : s),
                            n.slideCount > n.options.slidesToShow &&
                                n.slideHandler(n.currentSlide + o, !1, i);
                        break;
                    case "index":
                        var a =
                            0 === e.data.index
                                ? 0
                                : e.data.index ||
                                  r.index() * n.options.slidesToScroll;
                        n.slideHandler(n.checkNavigable(a), !1, i),
                            r.children().trigger("focus");
                        break;
                    default:
                        return;
                }
            }),
            (e.prototype.checkNavigable = function(t) {
                var e, i;
                if (
                    ((i = 0),
                    t > (e = this.getNavigableIndexes())[e.length - 1])
                )
                    t = e[e.length - 1];
                else
                    for (var s in e) {
                        if (t < e[s]) {
                            t = i;
                            break;
                        }
                        i = e[s];
                    }
                return t;
            }),
            (e.prototype.cleanUpEvents = function() {
                var e = this;
                e.options.dots &&
                    null !== e.$dots &&
                    (t("li", e.$dots)
                        .off("click.slick", e.changeSlide)
                        .off("mouseenter.slick", t.proxy(e.interrupt, e, !0))
                        .off("mouseleave.slick", t.proxy(e.interrupt, e, !1)),
                    !0 === e.options.accessibility &&
                        e.$dots.off("keydown.slick", e.keyHandler)),
                    e.$slider.off("focus.slick blur.slick"),
                    !0 === e.options.arrows &&
                        e.slideCount > e.options.slidesToShow &&
                        (e.$prevArrow &&
                            e.$prevArrow.off("click.slick", e.changeSlide),
                        e.$nextArrow &&
                            e.$nextArrow.off("click.slick", e.changeSlide),
                        !0 === e.options.accessibility &&
                            (e.$prevArrow &&
                                e.$prevArrow.off("keydown.slick", e.keyHandler),
                            e.$nextArrow &&
                                e.$nextArrow.off(
                                    "keydown.slick",
                                    e.keyHandler
                                ))),
                    e.$list.off(
                        "touchstart.slick mousedown.slick",
                        e.swipeHandler
                    ),
                    e.$list.off(
                        "touchmove.slick mousemove.slick",
                        e.swipeHandler
                    ),
                    e.$list.off("touchend.slick mouseup.slick", e.swipeHandler),
                    e.$list.off(
                        "touchcancel.slick mouseleave.slick",
                        e.swipeHandler
                    ),
                    e.$list.off("click.slick", e.clickHandler),
                    t(document).off(e.visibilityChange, e.visibility),
                    e.cleanUpSlideEvents(),
                    !0 === e.options.accessibility &&
                        e.$list.off("keydown.slick", e.keyHandler),
                    !0 === e.options.focusOnSelect &&
                        t(e.$slideTrack)
                            .children()
                            .off("click.slick", e.selectHandler),
                    t(window).off(
                        "orientationchange.slick.slick-" + e.instanceUid,
                        e.orientationChange
                    ),
                    t(window).off(
                        "resize.slick.slick-" + e.instanceUid,
                        e.resize
                    ),
                    t("[draggable!=true]", e.$slideTrack).off(
                        "dragstart",
                        e.preventDefault
                    ),
                    t(window).off(
                        "load.slick.slick-" + e.instanceUid,
                        e.setPosition
                    );
            }),
            (e.prototype.cleanUpSlideEvents = function() {
                var e = this;
                e.$list.off("mouseenter.slick", t.proxy(e.interrupt, e, !0)),
                    e.$list.off(
                        "mouseleave.slick",
                        t.proxy(e.interrupt, e, !1)
                    );
            }),
            (e.prototype.cleanUpRows = function() {
                var t,
                    e = this;
                e.options.rows > 1 &&
                    ((t = e.$slides.children().children()).removeAttr("style"),
                    e.$slider.empty().append(t));
            }),
            (e.prototype.clickHandler = function(t) {
                !1 === this.shouldClick &&
                    (t.stopImmediatePropagation(),
                    t.stopPropagation(),
                    t.preventDefault());
            }),
            (e.prototype.destroy = function(e) {
                var i = this;
                i.autoPlayClear(),
                    (i.touchObject = {}),
                    i.cleanUpEvents(),
                    t(".slick-cloned", i.$slider).detach(),
                    i.$dots && i.$dots.remove(),
                    i.$prevArrow &&
                        i.$prevArrow.length &&
                        (i.$prevArrow
                            .removeClass(
                                "slick-disabled slick-arrow slick-hidden"
                            )
                            .removeAttr("aria-hidden aria-disabled tabindex")
                            .css("display", ""),
                        i.htmlExpr.test(i.options.prevArrow) &&
                            i.$prevArrow.remove()),
                    i.$nextArrow &&
                        i.$nextArrow.length &&
                        (i.$nextArrow
                            .removeClass(
                                "slick-disabled slick-arrow slick-hidden"
                            )
                            .removeAttr("aria-hidden aria-disabled tabindex")
                            .css("display", ""),
                        i.htmlExpr.test(i.options.nextArrow) &&
                            i.$nextArrow.remove()),
                    i.$slides &&
                        (i.$slides
                            .removeClass(
                                "slick-slide slick-active slick-center slick-visible slick-current"
                            )
                            .removeAttr("aria-hidden")
                            .removeAttr("data-slick-index")
                            .each(function() {
                                t(this).attr(
                                    "style",
                                    t(this).data("originalStyling")
                                );
                            }),
                        i.$slideTrack.children(this.options.slide).detach(),
                        i.$slideTrack.detach(),
                        i.$list.detach(),
                        i.$slider.append(i.$slides)),
                    i.cleanUpRows(),
                    i.$slider.removeClass("slick-slider"),
                    i.$slider.removeClass("slick-initialized"),
                    i.$slider.removeClass("slick-dotted"),
                    (i.unslicked = !0),
                    e || i.$slider.trigger("destroy", [i]);
            }),
            (e.prototype.disableTransition = function(t) {
                var e = this,
                    i = {};
                (i[e.transitionType] = ""),
                    !1 === e.options.fade
                        ? e.$slideTrack.css(i)
                        : e.$slides.eq(t).css(i);
            }),
            (e.prototype.fadeSlide = function(t, e) {
                var i = this;
                !1 === i.cssTransitions
                    ? (i.$slides.eq(t).css({ zIndex: i.options.zIndex }),
                      i.$slides
                          .eq(t)
                          .animate(
                              { opacity: 1 },
                              i.options.speed,
                              i.options.easing,
                              e
                          ))
                    : (i.applyTransition(t),
                      i.$slides
                          .eq(t)
                          .css({ opacity: 1, zIndex: i.options.zIndex }),
                      e &&
                          setTimeout(function() {
                              i.disableTransition(t), e.call();
                          }, i.options.speed));
            }),
            (e.prototype.fadeSlideOut = function(t) {
                var e = this;
                !1 === e.cssTransitions
                    ? e.$slides
                          .eq(t)
                          .animate(
                              { opacity: 0, zIndex: e.options.zIndex - 2 },
                              e.options.speed,
                              e.options.easing
                          )
                    : (e.applyTransition(t),
                      e.$slides
                          .eq(t)
                          .css({ opacity: 0, zIndex: e.options.zIndex - 2 }));
            }),
            (e.prototype.filterSlides = e.prototype.slickFilter = function(t) {
                var e = this;
                null !== t &&
                    ((e.$slidesCache = e.$slides),
                    e.unload(),
                    e.$slideTrack.children(this.options.slide).detach(),
                    e.$slidesCache.filter(t).appendTo(e.$slideTrack),
                    e.reinit());
            }),
            (e.prototype.focusHandler = function() {
                var e = this;
                e.$slider
                    .off("focus.slick blur.slick")
                    .on("focus.slick blur.slick", "*", function(i) {
                        i.stopImmediatePropagation();
                        var s = t(this);
                        setTimeout(function() {
                            e.options.pauseOnFocus &&
                                ((e.focussed = s.is(":focus")), e.autoPlay());
                        }, 0);
                    });
            }),
            (e.prototype.getCurrent = e.prototype.slickCurrentSlide = function() {
                return this.currentSlide;
            }),
            (e.prototype.getDotCount = function() {
                var t = this,
                    e = 0,
                    i = 0,
                    s = 0;
                if (!0 === t.options.infinite)
                    if (t.slideCount <= t.options.slidesToShow) ++s;
                    else
                        for (; e < t.slideCount; )
                            ++s,
                                (e = i + t.options.slidesToScroll),
                                (i +=
                                    t.options.slidesToScroll <=
                                    t.options.slidesToShow
                                        ? t.options.slidesToScroll
                                        : t.options.slidesToShow);
                else if (!0 === t.options.centerMode) s = t.slideCount;
                else if (t.options.asNavFor)
                    for (; e < t.slideCount; )
                        ++s,
                            (e = i + t.options.slidesToScroll),
                            (i +=
                                t.options.slidesToScroll <=
                                t.options.slidesToShow
                                    ? t.options.slidesToScroll
                                    : t.options.slidesToShow);
                else
                    s =
                        1 +
                        Math.ceil(
                            (t.slideCount - t.options.slidesToShow) /
                                t.options.slidesToScroll
                        );
                return s - 1;
            }),
            (e.prototype.getLeft = function(t) {
                var e,
                    i,
                    s,
                    o,
                    n = this,
                    r = 0;
                return (
                    (n.slideOffset = 0),
                    (i = n.$slides.first().outerHeight(!0)),
                    !0 === n.options.infinite
                        ? (n.slideCount > n.options.slidesToShow &&
                              ((n.slideOffset =
                                  n.slideWidth * n.options.slidesToShow * -1),
                              (o = -1),
                              !0 === n.options.vertical &&
                                  !0 === n.options.centerMode &&
                                  (2 === n.options.slidesToShow
                                      ? (o = -1.5)
                                      : 1 === n.options.slidesToShow &&
                                        (o = -2)),
                              (r = i * n.options.slidesToShow * o)),
                          n.slideCount % n.options.slidesToScroll != 0 &&
                              t + n.options.slidesToScroll > n.slideCount &&
                              n.slideCount > n.options.slidesToShow &&
                              (t > n.slideCount
                                  ? ((n.slideOffset =
                                        (n.options.slidesToShow -
                                            (t - n.slideCount)) *
                                        n.slideWidth *
                                        -1),
                                    (r =
                                        (n.options.slidesToShow -
                                            (t - n.slideCount)) *
                                        i *
                                        -1))
                                  : ((n.slideOffset =
                                        (n.slideCount %
                                            n.options.slidesToScroll) *
                                        n.slideWidth *
                                        -1),
                                    (r =
                                        (n.slideCount %
                                            n.options.slidesToScroll) *
                                        i *
                                        -1))))
                        : t + n.options.slidesToShow > n.slideCount &&
                          ((n.slideOffset =
                              (t + n.options.slidesToShow - n.slideCount) *
                              n.slideWidth),
                          (r =
                              (t + n.options.slidesToShow - n.slideCount) * i)),
                    n.slideCount <= n.options.slidesToShow &&
                        ((n.slideOffset = 0), (r = 0)),
                    !0 === n.options.centerMode &&
                    n.slideCount <= n.options.slidesToShow
                        ? (n.slideOffset =
                              (n.slideWidth *
                                  Math.floor(n.options.slidesToShow)) /
                                  2 -
                              (n.slideWidth * n.slideCount) / 2)
                        : !0 === n.options.centerMode &&
                          !0 === n.options.infinite
                        ? (n.slideOffset +=
                              n.slideWidth *
                                  Math.floor(n.options.slidesToShow / 2) -
                              n.slideWidth)
                        : !0 === n.options.centerMode &&
                          ((n.slideOffset = 0),
                          (n.slideOffset +=
                              n.slideWidth *
                              Math.floor(n.options.slidesToShow / 2))),
                    (e =
                        !1 === n.options.vertical
                            ? t * n.slideWidth * -1 + n.slideOffset
                            : t * i * -1 + r),
                    !0 === n.options.variableWidth &&
                        ((s =
                            n.slideCount <= n.options.slidesToShow ||
                            !1 === n.options.infinite
                                ? n.$slideTrack.children(".slick-slide").eq(t)
                                : n.$slideTrack
                                      .children(".slick-slide")
                                      .eq(t + n.options.slidesToShow)),
                        (e =
                            !0 === n.options.rtl
                                ? s[0]
                                    ? -1 *
                                      (n.$slideTrack.width() -
                                          s[0].offsetLeft -
                                          s.width())
                                    : 0
                                : s[0]
                                ? -1 * s[0].offsetLeft
                                : 0),
                        !0 === n.options.centerMode &&
                            ((s =
                                n.slideCount <= n.options.slidesToShow ||
                                !1 === n.options.infinite
                                    ? n.$slideTrack
                                          .children(".slick-slide")
                                          .eq(t)
                                    : n.$slideTrack
                                          .children(".slick-slide")
                                          .eq(t + n.options.slidesToShow + 1)),
                            (e =
                                !0 === n.options.rtl
                                    ? s[0]
                                        ? -1 *
                                          (n.$slideTrack.width() -
                                              s[0].offsetLeft -
                                              s.width())
                                        : 0
                                    : s[0]
                                    ? -1 * s[0].offsetLeft
                                    : 0),
                            (e += (n.$list.width() - s.outerWidth()) / 2))),
                    e
                );
            }),
            (e.prototype.getOption = e.prototype.slickGetOption = function(t) {
                return this.options[t];
            }),
            (e.prototype.getNavigableIndexes = function() {
                var t,
                    e = this,
                    i = 0,
                    s = 0,
                    o = [];
                for (
                    !1 === e.options.infinite
                        ? (t = e.slideCount)
                        : ((i = -1 * e.options.slidesToScroll),
                          (s = -1 * e.options.slidesToScroll),
                          (t = 2 * e.slideCount));
                    i < t;

                )
                    o.push(i),
                        (i = s + e.options.slidesToScroll),
                        (s +=
                            e.options.slidesToScroll <= e.options.slidesToShow
                                ? e.options.slidesToScroll
                                : e.options.slidesToShow);
                return o;
            }),
            (e.prototype.getSlick = function() {
                return this;
            }),
            (e.prototype.getSlideCount = function() {
                var e,
                    i,
                    s = this;
                return (
                    (i =
                        !0 === s.options.centerMode
                            ? s.slideWidth *
                              Math.floor(s.options.slidesToShow / 2)
                            : 0),
                    !0 === s.options.swipeToSlide
                        ? (s.$slideTrack
                              .find(".slick-slide")
                              .each(function(o, n) {
                                  if (
                                      n.offsetLeft - i + t(n).outerWidth() / 2 >
                                      -1 * s.swipeLeft
                                  )
                                      return (e = n), !1;
                              }),
                          Math.abs(
                              t(e).attr("data-slick-index") - s.currentSlide
                          ) || 1)
                        : s.options.slidesToScroll
                );
            }),
            (e.prototype.goTo = e.prototype.slickGoTo = function(t, e) {
                this.changeSlide(
                    { data: { message: "index", index: parseInt(t) } },
                    e
                );
            }),
            (e.prototype.init = function(e) {
                var i = this;
                t(i.$slider).hasClass("slick-initialized") ||
                    (t(i.$slider).addClass("slick-initialized"),
                    i.buildRows(),
                    i.buildOut(),
                    i.setProps(),
                    i.startLoad(),
                    i.loadSlider(),
                    i.initializeEvents(),
                    i.updateArrows(),
                    i.updateDots(),
                    i.checkResponsive(!0),
                    i.focusHandler()),
                    e && i.$slider.trigger("init", [i]),
                    !0 === i.options.accessibility && i.initADA(),
                    i.options.autoplay && ((i.paused = !1), i.autoPlay());
            }),
            (e.prototype.initADA = function() {
                var e = this,
                    i = Math.ceil(e.slideCount / e.options.slidesToShow),
                    s = e.getNavigableIndexes().filter(function(t) {
                        return t >= 0 && t < e.slideCount;
                    });
                e.$slides
                    .add(e.$slideTrack.find(".slick-cloned"))
                    .attr({ "aria-hidden": "true", tabindex: "-1" })
                    .find("a, input, button, select")
                    .attr({ tabindex: "-1" }),
                    null !== e.$dots &&
                        (e.$slides
                            .not(e.$slideTrack.find(".slick-cloned"))
                            .each(function(i) {
                                var o = s.indexOf(i);
                                t(this).attr({
                                    role: "tabpanel",
                                    id: "slick-slide" + e.instanceUid + i,
                                    tabindex: -1
                                }),
                                    -1 !== o &&
                                        t(this).attr({
                                            "aria-describedby":
                                                "slick-slide-control" +
                                                e.instanceUid +
                                                o
                                        });
                            }),
                        e.$dots
                            .attr("role", "tablist")
                            .find("li")
                            .each(function(o) {
                                var n = s[o];
                                t(this).attr({ role: "presentation" }),
                                    t(this)
                                        .find("button")
                                        .first()
                                        .attr({
                                            role: "tab",
                                            id:
                                                "slick-slide-control" +
                                                e.instanceUid +
                                                o,
                                            "aria-controls":
                                                "slick-slide" +
                                                e.instanceUid +
                                                n,
                                            "aria-label": o + 1 + " of " + i,
                                            "aria-selected": null,
                                            tabindex: "-1"
                                        });
                            })
                            .eq(e.currentSlide)
                            .find("button")
                            .attr({ "aria-selected": "true", tabindex: "0" })
                            .end());
                for (
                    var o = e.currentSlide, n = o + e.options.slidesToShow;
                    o < n;
                    o++
                )
                    e.$slides.eq(o).attr("tabindex", 0);
                e.activateADA();
            }),
            (e.prototype.initArrowEvents = function() {
                var t = this;
                !0 === t.options.arrows &&
                    t.slideCount > t.options.slidesToShow &&
                    (t.$prevArrow
                        .off("click.slick")
                        .on(
                            "click.slick",
                            { message: "previous" },
                            t.changeSlide
                        ),
                    t.$nextArrow
                        .off("click.slick")
                        .on("click.slick", { message: "next" }, t.changeSlide),
                    !0 === t.options.accessibility &&
                        (t.$prevArrow.on("keydown.slick", t.keyHandler),
                        t.$nextArrow.on("keydown.slick", t.keyHandler)));
            }),
            (e.prototype.initDotEvents = function() {
                var e = this;
                !0 === e.options.dots &&
                    (t("li", e.$dots).on(
                        "click.slick",
                        { message: "index" },
                        e.changeSlide
                    ),
                    !0 === e.options.accessibility &&
                        e.$dots.on("keydown.slick", e.keyHandler)),
                    !0 === e.options.dots &&
                        !0 === e.options.pauseOnDotsHover &&
                        t("li", e.$dots)
                            .on("mouseenter.slick", t.proxy(e.interrupt, e, !0))
                            .on(
                                "mouseleave.slick",
                                t.proxy(e.interrupt, e, !1)
                            );
            }),
            (e.prototype.initSlideEvents = function() {
                var e = this;
                e.options.pauseOnHover &&
                    (e.$list.on(
                        "mouseenter.slick",
                        t.proxy(e.interrupt, e, !0)
                    ),
                    e.$list.on(
                        "mouseleave.slick",
                        t.proxy(e.interrupt, e, !1)
                    ));
            }),
            (e.prototype.initializeEvents = function() {
                var e = this;
                e.initArrowEvents(),
                    e.initDotEvents(),
                    e.initSlideEvents(),
                    e.$list.on(
                        "touchstart.slick mousedown.slick",
                        { action: "start" },
                        e.swipeHandler
                    ),
                    e.$list.on(
                        "touchmove.slick mousemove.slick",
                        { action: "move" },
                        e.swipeHandler
                    ),
                    e.$list.on(
                        "touchend.slick mouseup.slick",
                        { action: "end" },
                        e.swipeHandler
                    ),
                    e.$list.on(
                        "touchcancel.slick mouseleave.slick",
                        { action: "end" },
                        e.swipeHandler
                    ),
                    e.$list.on("click.slick", e.clickHandler),
                    t(document).on(
                        e.visibilityChange,
                        t.proxy(e.visibility, e)
                    ),
                    !0 === e.options.accessibility &&
                        e.$list.on("keydown.slick", e.keyHandler),
                    !0 === e.options.focusOnSelect &&
                        t(e.$slideTrack)
                            .children()
                            .on("click.slick", e.selectHandler),
                    t(window).on(
                        "orientationchange.slick.slick-" + e.instanceUid,
                        t.proxy(e.orientationChange, e)
                    ),
                    t(window).on(
                        "resize.slick.slick-" + e.instanceUid,
                        t.proxy(e.resize, e)
                    ),
                    t("[draggable!=true]", e.$slideTrack).on(
                        "dragstart",
                        e.preventDefault
                    ),
                    t(window).on(
                        "load.slick.slick-" + e.instanceUid,
                        e.setPosition
                    ),
                    t(e.setPosition);
            }),
            (e.prototype.initUI = function() {
                var t = this;
                !0 === t.options.arrows &&
                    t.slideCount > t.options.slidesToShow &&
                    (t.$prevArrow.show(), t.$nextArrow.show()),
                    !0 === t.options.dots &&
                        t.slideCount > t.options.slidesToShow &&
                        t.$dots.show();
            }),
            (e.prototype.keyHandler = function(t) {
                var e = this;
                t.target.tagName.match("TEXTAREA|INPUT|SELECT") ||
                    (37 === t.keyCode && !0 === e.options.accessibility
                        ? e.changeSlide({
                              data: {
                                  message:
                                      !0 === e.options.rtl ? "next" : "previous"
                              }
                          })
                        : 39 === t.keyCode &&
                          !0 === e.options.accessibility &&
                          e.changeSlide({
                              data: {
                                  message:
                                      !0 === e.options.rtl ? "previous" : "next"
                              }
                          }));
            }),
            (e.prototype.lazyLoad = function() {
                function e(e) {
                    t("img[data-lazy]", e).each(function() {
                        var e = t(this),
                            i = t(this).attr("data-lazy"),
                            s = t(this).attr("data-srcset"),
                            o =
                                t(this).attr("data-sizes") ||
                                n.$slider.attr("data-sizes"),
                            r = document.createElement("img");
                        (r.onload = function() {
                            e.animate({ opacity: 0 }, 100, function() {
                                s &&
                                    (e.attr("srcset", s),
                                    o && e.attr("sizes", o)),
                                    e
                                        .attr("src", i)
                                        .animate(
                                            { opacity: 1 },
                                            200,
                                            function() {
                                                e.removeAttr(
                                                    "data-lazy data-srcset data-sizes"
                                                ).removeClass("slick-loading");
                                            }
                                        ),
                                    n.$slider.trigger("lazyLoaded", [n, e, i]);
                            });
                        }),
                            (r.onerror = function() {
                                e
                                    .removeAttr("data-lazy")
                                    .removeClass("slick-loading")
                                    .addClass("slick-lazyload-error"),
                                    n.$slider.trigger("lazyLoadError", [
                                        n,
                                        e,
                                        i
                                    ]);
                            }),
                            (r.src = i);
                    });
                }
                var i,
                    s,
                    o,
                    n = this;
                if (
                    (!0 === n.options.centerMode
                        ? !0 === n.options.infinite
                            ? (o =
                                  (s =
                                      n.currentSlide +
                                      (n.options.slidesToShow / 2 + 1)) +
                                  n.options.slidesToShow +
                                  2)
                            : ((s = Math.max(
                                  0,
                                  n.currentSlide -
                                      (n.options.slidesToShow / 2 + 1)
                              )),
                              (o =
                                  n.options.slidesToShow / 2 +
                                  1 +
                                  2 +
                                  n.currentSlide))
                        : ((s = n.options.infinite
                              ? n.options.slidesToShow + n.currentSlide
                              : n.currentSlide),
                          (o = Math.ceil(s + n.options.slidesToShow)),
                          !0 === n.options.fade &&
                              (s > 0 && s--, o <= n.slideCount && o++)),
                    (i = n.$slider.find(".slick-slide").slice(s, o)),
                    "anticipated" === n.options.lazyLoad)
                )
                    for (
                        var r = s - 1,
                            a = o,
                            l = n.$slider.find(".slick-slide"),
                            c = 0;
                        c < n.options.slidesToScroll;
                        c++
                    )
                        r < 0 && (r = n.slideCount - 1),
                            (i = (i = i.add(l.eq(r))).add(l.eq(a))),
                            r--,
                            a++;
                e(i),
                    n.slideCount <= n.options.slidesToShow
                        ? e(n.$slider.find(".slick-slide"))
                        : n.currentSlide >=
                          n.slideCount - n.options.slidesToShow
                        ? e(
                              n.$slider
                                  .find(".slick-cloned")
                                  .slice(0, n.options.slidesToShow)
                          )
                        : 0 === n.currentSlide &&
                          e(
                              n.$slider
                                  .find(".slick-cloned")
                                  .slice(-1 * n.options.slidesToShow)
                          );
            }),
            (e.prototype.loadSlider = function() {
                var t = this;
                t.setPosition(),
                    t.$slideTrack.css({ opacity: 1 }),
                    t.$slider.removeClass("slick-loading"),
                    t.initUI(),
                    "progressive" === t.options.lazyLoad &&
                        t.progressiveLazyLoad();
            }),
            (e.prototype.next = e.prototype.slickNext = function() {
                this.changeSlide({ data: { message: "next" } });
            }),
            (e.prototype.orientationChange = function() {
                this.checkResponsive(), this.setPosition();
            }),
            (e.prototype.pause = e.prototype.slickPause = function() {
                this.autoPlayClear(), (this.paused = !0);
            }),
            (e.prototype.play = e.prototype.slickPlay = function() {
                var t = this;
                t.autoPlay(),
                    (t.options.autoplay = !0),
                    (t.paused = !1),
                    (t.focussed = !1),
                    (t.interrupted = !1);
            }),
            (e.prototype.postSlide = function(e) {
                var i = this;
                i.unslicked ||
                    (i.$slider.trigger("afterChange", [i, e]),
                    (i.animating = !1),
                    i.slideCount > i.options.slidesToShow && i.setPosition(),
                    (i.swipeLeft = null),
                    i.options.autoplay && i.autoPlay(),
                    !0 === i.options.accessibility &&
                        (i.initADA(),
                        i.options.focusOnChange &&
                            t(i.$slides.get(i.currentSlide))
                                .attr("tabindex", 0)
                                .focus()));
            }),
            (e.prototype.prev = e.prototype.slickPrev = function() {
                this.changeSlide({ data: { message: "previous" } });
            }),
            (e.prototype.preventDefault = function(t) {
                t.preventDefault();
            }),
            (e.prototype.progressiveLazyLoad = function(e) {
                e = e || 1;
                var i,
                    s,
                    o,
                    n,
                    r,
                    a = this,
                    l = t("img[data-lazy]", a.$slider);
                l.length
                    ? ((i = l.first()),
                      (s = i.attr("data-lazy")),
                      (o = i.attr("data-srcset")),
                      (n =
                          i.attr("data-sizes") || a.$slider.attr("data-sizes")),
                      ((r = document.createElement("img")).onload = function() {
                          o && (i.attr("srcset", o), n && i.attr("sizes", n)),
                              i
                                  .attr("src", s)
                                  .removeAttr(
                                      "data-lazy data-srcset data-sizes"
                                  )
                                  .removeClass("slick-loading"),
                              !0 === a.options.adaptiveHeight &&
                                  a.setPosition(),
                              a.$slider.trigger("lazyLoaded", [a, i, s]),
                              a.progressiveLazyLoad();
                      }),
                      (r.onerror = function() {
                          e < 3
                              ? setTimeout(function() {
                                    a.progressiveLazyLoad(e + 1);
                                }, 500)
                              : (i
                                    .removeAttr("data-lazy")
                                    .removeClass("slick-loading")
                                    .addClass("slick-lazyload-error"),
                                a.$slider.trigger("lazyLoadError", [a, i, s]),
                                a.progressiveLazyLoad());
                      }),
                      (r.src = s))
                    : a.$slider.trigger("allImagesLoaded", [a]);
            }),
            (e.prototype.refresh = function(e) {
                var i,
                    s,
                    o = this;
                (s = o.slideCount - o.options.slidesToShow),
                    !o.options.infinite &&
                        o.currentSlide > s &&
                        (o.currentSlide = s),
                    o.slideCount <= o.options.slidesToShow &&
                        (o.currentSlide = 0),
                    (i = o.currentSlide),
                    o.destroy(!0),
                    t.extend(o, o.initials, { currentSlide: i }),
                    o.init(),
                    e ||
                        o.changeSlide(
                            { data: { message: "index", index: i } },
                            !1
                        );
            }),
            (e.prototype.registerBreakpoints = function() {
                var e,
                    i,
                    s,
                    o = this,
                    n = o.options.responsive || null;
                if ("array" === t.type(n) && n.length) {
                    for (e in ((o.respondTo = o.options.respondTo || "window"),
                    n))
                        if (
                            ((s = o.breakpoints.length - 1),
                            n.hasOwnProperty(e))
                        ) {
                            for (i = n[e].breakpoint; s >= 0; )
                                o.breakpoints[s] &&
                                    o.breakpoints[s] === i &&
                                    o.breakpoints.splice(s, 1),
                                    s--;
                            o.breakpoints.push(i),
                                (o.breakpointSettings[i] = n[e].settings);
                        }
                    o.breakpoints.sort(function(t, e) {
                        return o.options.mobileFirst ? t - e : e - t;
                    });
                }
            }),
            (e.prototype.reinit = function() {
                var e = this;
                (e.$slides = e.$slideTrack
                    .children(e.options.slide)
                    .addClass("slick-slide")),
                    (e.slideCount = e.$slides.length),
                    e.currentSlide >= e.slideCount &&
                        0 !== e.currentSlide &&
                        (e.currentSlide =
                            e.currentSlide - e.options.slidesToScroll),
                    e.slideCount <= e.options.slidesToShow &&
                        (e.currentSlide = 0),
                    e.registerBreakpoints(),
                    e.setProps(),
                    e.setupInfinite(),
                    e.buildArrows(),
                    e.updateArrows(),
                    e.initArrowEvents(),
                    e.buildDots(),
                    e.updateDots(),
                    e.initDotEvents(),
                    e.cleanUpSlideEvents(),
                    e.initSlideEvents(),
                    e.checkResponsive(!1, !0),
                    !0 === e.options.focusOnSelect &&
                        t(e.$slideTrack)
                            .children()
                            .on("click.slick", e.selectHandler),
                    e.setSlideClasses(
                        "number" == typeof e.currentSlide ? e.currentSlide : 0
                    ),
                    e.setPosition(),
                    e.focusHandler(),
                    (e.paused = !e.options.autoplay),
                    e.autoPlay(),
                    e.$slider.trigger("reInit", [e]);
            }),
            (e.prototype.resize = function() {
                var e = this;
                t(window).width() !== e.windowWidth &&
                    (clearTimeout(e.windowDelay),
                    (e.windowDelay = window.setTimeout(function() {
                        (e.windowWidth = t(window).width()),
                            e.checkResponsive(),
                            e.unslicked || e.setPosition();
                    }, 50)));
            }),
            (e.prototype.removeSlide = e.prototype.slickRemove = function(
                t,
                e,
                i
            ) {
                var s = this;
                if (
                    ((t =
                        "boolean" == typeof t
                            ? !0 === (e = t)
                                ? 0
                                : s.slideCount - 1
                            : !0 === e
                            ? --t
                            : t),
                    s.slideCount < 1 || t < 0 || t > s.slideCount - 1)
                )
                    return !1;
                s.unload(),
                    !0 === i
                        ? s.$slideTrack.children().remove()
                        : s.$slideTrack
                              .children(this.options.slide)
                              .eq(t)
                              .remove(),
                    (s.$slides = s.$slideTrack.children(this.options.slide)),
                    s.$slideTrack.children(this.options.slide).detach(),
                    s.$slideTrack.append(s.$slides),
                    (s.$slidesCache = s.$slides),
                    s.reinit();
            }),
            (e.prototype.setCSS = function(t) {
                var e,
                    i,
                    s = this,
                    o = {};
                !0 === s.options.rtl && (t = -t),
                    (e =
                        "left" == s.positionProp ? Math.ceil(t) + "px" : "0px"),
                    (i = "top" == s.positionProp ? Math.ceil(t) + "px" : "0px"),
                    (o[s.positionProp] = t),
                    !1 === s.transformsEnabled
                        ? s.$slideTrack.css(o)
                        : ((o = {}),
                          !1 === s.cssTransitions
                              ? ((o[s.animType] =
                                    "translate(" + e + ", " + i + ")"),
                                s.$slideTrack.css(o))
                              : ((o[s.animType] =
                                    "translate3d(" + e + ", " + i + ", 0px)"),
                                s.$slideTrack.css(o)));
            }),
            (e.prototype.setDimensions = function() {
                var t = this;
                !1 === t.options.vertical
                    ? !0 === t.options.centerMode &&
                      t.$list.css({ padding: "0px " + t.options.centerPadding })
                    : (t.$list.height(
                          t.$slides.first().outerHeight(!0) *
                              t.options.slidesToShow
                      ),
                      !0 === t.options.centerMode &&
                          t.$list.css({
                              padding: t.options.centerPadding + " 0px"
                          })),
                    (t.listWidth = t.$list.width()),
                    (t.listHeight = t.$list.height()),
                    !1 === t.options.vertical && !1 === t.options.variableWidth
                        ? ((t.slideWidth = Math.ceil(
                              t.listWidth / t.options.slidesToShow
                          )),
                          t.$slideTrack.width(
                              Math.ceil(
                                  t.slideWidth *
                                      t.$slideTrack.children(".slick-slide")
                                          .length
                              )
                          ))
                        : !0 === t.options.variableWidth
                        ? t.$slideTrack.width(5e3 * t.slideCount)
                        : ((t.slideWidth = Math.ceil(t.listWidth)),
                          t.$slideTrack.height(
                              Math.ceil(
                                  t.$slides.first().outerHeight(!0) *
                                      t.$slideTrack.children(".slick-slide")
                                          .length
                              )
                          ));
                var e =
                    t.$slides.first().outerWidth(!0) -
                    t.$slides.first().width();
                !1 === t.options.variableWidth &&
                    t.$slideTrack
                        .children(".slick-slide")
                        .width(t.slideWidth - e);
            }),
            (e.prototype.setFade = function() {
                var e,
                    i = this;
                i.$slides.each(function(s, o) {
                    (e = i.slideWidth * s * -1),
                        !0 === i.options.rtl
                            ? t(o).css({
                                  position: "relative",
                                  right: e,
                                  top: 0,
                                  zIndex: i.options.zIndex - 2,
                                  opacity: 0
                              })
                            : t(o).css({
                                  position: "relative",
                                  left: e,
                                  top: 0,
                                  zIndex: i.options.zIndex - 2,
                                  opacity: 0
                              });
                }),
                    i.$slides
                        .eq(i.currentSlide)
                        .css({ zIndex: i.options.zIndex - 1, opacity: 1 });
            }),
            (e.prototype.setHeight = function() {
                var t = this;
                if (
                    1 === t.options.slidesToShow &&
                    !0 === t.options.adaptiveHeight &&
                    !1 === t.options.vertical
                ) {
                    var e = t.$slides.eq(t.currentSlide).outerHeight(!0);
                    t.$list.css("height", e);
                }
            }),
            (e.prototype.setOption = e.prototype.slickSetOption = function() {
                var e,
                    i,
                    s,
                    o,
                    n,
                    r = this,
                    a = !1;
                if (
                    ("object" === t.type(arguments[0])
                        ? ((s = arguments[0]),
                          (a = arguments[1]),
                          (n = "multiple"))
                        : "string" === t.type(arguments[0]) &&
                          ((s = arguments[0]),
                          (o = arguments[1]),
                          (a = arguments[2]),
                          "responsive" === arguments[0] &&
                          "array" === t.type(arguments[1])
                              ? (n = "responsive")
                              : void 0 !== arguments[1] && (n = "single")),
                    "single" === n)
                )
                    r.options[s] = o;
                else if ("multiple" === n)
                    t.each(s, function(t, e) {
                        r.options[t] = e;
                    });
                else if ("responsive" === n)
                    for (i in o)
                        if ("array" !== t.type(r.options.responsive))
                            r.options.responsive = [o[i]];
                        else {
                            for (e = r.options.responsive.length - 1; e >= 0; )
                                r.options.responsive[e].breakpoint ===
                                    o[i].breakpoint &&
                                    r.options.responsive.splice(e, 1),
                                    e--;
                            r.options.responsive.push(o[i]);
                        }
                a && (r.unload(), r.reinit());
            }),
            (e.prototype.setPosition = function() {
                var t = this;
                t.setDimensions(),
                    t.setHeight(),
                    !1 === t.options.fade
                        ? t.setCSS(t.getLeft(t.currentSlide))
                        : t.setFade(),
                    t.$slider.trigger("setPosition", [t]);
            }),
            (e.prototype.setProps = function() {
                var t = this,
                    e = document.body.style;
                (t.positionProp = !0 === t.options.vertical ? "top" : "left"),
                    "top" === t.positionProp
                        ? t.$slider.addClass("slick-vertical")
                        : t.$slider.removeClass("slick-vertical"),
                    (void 0 === e.WebkitTransition &&
                        void 0 === e.MozTransition &&
                        void 0 === e.msTransition) ||
                        (!0 === t.options.useCSS && (t.cssTransitions = !0)),
                    t.options.fade &&
                        ("number" == typeof t.options.zIndex
                            ? t.options.zIndex < 3 && (t.options.zIndex = 3)
                            : (t.options.zIndex = t.defaults.zIndex)),
                    void 0 !== e.OTransform &&
                        ((t.animType = "OTransform"),
                        (t.transformType = "-o-transform"),
                        (t.transitionType = "OTransition"),
                        void 0 === e.perspectiveProperty &&
                            void 0 === e.webkitPerspective &&
                            (t.animType = !1)),
                    void 0 !== e.MozTransform &&
                        ((t.animType = "MozTransform"),
                        (t.transformType = "-moz-transform"),
                        (t.transitionType = "MozTransition"),
                        void 0 === e.perspectiveProperty &&
                            void 0 === e.MozPerspective &&
                            (t.animType = !1)),
                    void 0 !== e.webkitTransform &&
                        ((t.animType = "webkitTransform"),
                        (t.transformType = "-webkit-transform"),
                        (t.transitionType = "webkitTransition"),
                        void 0 === e.perspectiveProperty &&
                            void 0 === e.webkitPerspective &&
                            (t.animType = !1)),
                    void 0 !== e.msTransform &&
                        ((t.animType = "msTransform"),
                        (t.transformType = "-ms-transform"),
                        (t.transitionType = "msTransition"),
                        void 0 === e.msTransform && (t.animType = !1)),
                    void 0 !== e.transform &&
                        !1 !== t.animType &&
                        ((t.animType = "transform"),
                        (t.transformType = "transform"),
                        (t.transitionType = "transition")),
                    (t.transformsEnabled =
                        t.options.useTransform &&
                        null !== t.animType &&
                        !1 !== t.animType);
            }),
            (e.prototype.setSlideClasses = function(t) {
                var e,
                    i,
                    s,
                    o,
                    n = this;
                if (
                    ((i = n.$slider
                        .find(".slick-slide")
                        .removeClass("slick-active slick-center slick-current")
                        .attr("aria-hidden", "true")),
                    n.$slides.eq(t).addClass("slick-current"),
                    !0 === n.options.centerMode)
                ) {
                    var r = n.options.slidesToShow % 2 == 0 ? 1 : 0;
                    (e = Math.floor(n.options.slidesToShow / 2)),
                        !0 === n.options.infinite &&
                            (t >= e && t <= n.slideCount - 1 - e
                                ? n.$slides
                                      .slice(t - e + r, t + e + 1)
                                      .addClass("slick-active")
                                      .attr("aria-hidden", "false")
                                : ((s = n.options.slidesToShow + t),
                                  i
                                      .slice(s - e + 1 + r, s + e + 2)
                                      .addClass("slick-active")
                                      .attr("aria-hidden", "false")),
                            0 === t
                                ? i
                                      .eq(i.length - 1 - n.options.slidesToShow)
                                      .addClass("slick-center")
                                : t === n.slideCount - 1 &&
                                  i
                                      .eq(n.options.slidesToShow)
                                      .addClass("slick-center")),
                        n.$slides.eq(t).addClass("slick-center");
                } else
                    t >= 0 && t <= n.slideCount - n.options.slidesToShow
                        ? n.$slides
                              .slice(t, t + n.options.slidesToShow)
                              .addClass("slick-active")
                              .attr("aria-hidden", "false")
                        : i.length <= n.options.slidesToShow
                        ? i
                              .addClass("slick-active")
                              .attr("aria-hidden", "false")
                        : ((o = n.slideCount % n.options.slidesToShow),
                          (s =
                              !0 === n.options.infinite
                                  ? n.options.slidesToShow + t
                                  : t),
                          n.options.slidesToShow == n.options.slidesToScroll &&
                          n.slideCount - t < n.options.slidesToShow
                              ? i
                                    .slice(
                                        s - (n.options.slidesToShow - o),
                                        s + o
                                    )
                                    .addClass("slick-active")
                                    .attr("aria-hidden", "false")
                              : i
                                    .slice(s, s + n.options.slidesToShow)
                                    .addClass("slick-active")
                                    .attr("aria-hidden", "false"));
                ("ondemand" !== n.options.lazyLoad &&
                    "anticipated" !== n.options.lazyLoad) ||
                    n.lazyLoad();
            }),
            (e.prototype.setupInfinite = function() {
                var e,
                    i,
                    s,
                    o = this;
                if (
                    (!0 === o.options.fade && (o.options.centerMode = !1),
                    !0 === o.options.infinite &&
                        !1 === o.options.fade &&
                        ((i = null), o.slideCount > o.options.slidesToShow))
                ) {
                    for (
                        s =
                            !0 === o.options.centerMode
                                ? o.options.slidesToShow + 1
                                : o.options.slidesToShow,
                            e = o.slideCount;
                        e > o.slideCount - s;
                        e -= 1
                    )
                        (i = e - 1),
                            t(o.$slides[i])
                                .clone(!0)
                                .attr("id", "")
                                .attr("data-slick-index", i - o.slideCount)
                                .prependTo(o.$slideTrack)
                                .addClass("slick-cloned");
                    for (e = 0; e < s + o.slideCount; e += 1)
                        (i = e),
                            t(o.$slides[i])
                                .clone(!0)
                                .attr("id", "")
                                .attr("data-slick-index", i + o.slideCount)
                                .appendTo(o.$slideTrack)
                                .addClass("slick-cloned");
                    o.$slideTrack
                        .find(".slick-cloned")
                        .find("[id]")
                        .each(function() {
                            t(this).attr("id", "");
                        });
                }
            }),
            (e.prototype.interrupt = function(t) {
                t || this.autoPlay(), (this.interrupted = t);
            }),
            (e.prototype.selectHandler = function(e) {
                var i = this,
                    s = t(e.target).is(".slick-slide")
                        ? t(e.target)
                        : t(e.target).parents(".slick-slide"),
                    o = parseInt(s.attr("data-slick-index"));
                o || (o = 0),
                    i.slideCount <= i.options.slidesToShow
                        ? i.slideHandler(o, !1, !0)
                        : i.slideHandler(o);
            }),
            (e.prototype.slideHandler = function(t, e, i) {
                var s,
                    o,
                    n,
                    r,
                    a,
                    l = null,
                    c = this;
                if (
                    ((e = e || !1),
                    !(
                        (!0 === c.animating &&
                            !0 === c.options.waitForAnimate) ||
                        (!0 === c.options.fade && c.currentSlide === t)
                    ))
                )
                    if (
                        (!1 === e && c.asNavFor(t),
                        (s = t),
                        (l = c.getLeft(s)),
                        (r = c.getLeft(c.currentSlide)),
                        (c.currentLeft =
                            null === c.swipeLeft ? r : c.swipeLeft),
                        !1 === c.options.infinite &&
                            !1 === c.options.centerMode &&
                            (t < 0 ||
                                t > c.getDotCount() * c.options.slidesToScroll))
                    )
                        !1 === c.options.fade &&
                            ((s = c.currentSlide),
                            !0 !== i
                                ? c.animateSlide(r, function() {
                                      c.postSlide(s);
                                  })
                                : c.postSlide(s));
                    else if (
                        !1 === c.options.infinite &&
                        !0 === c.options.centerMode &&
                        (t < 0 || t > c.slideCount - c.options.slidesToScroll)
                    )
                        !1 === c.options.fade &&
                            ((s = c.currentSlide),
                            !0 !== i
                                ? c.animateSlide(r, function() {
                                      c.postSlide(s);
                                  })
                                : c.postSlide(s));
                    else {
                        if (
                            (c.options.autoplay &&
                                clearInterval(c.autoPlayTimer),
                            (o =
                                s < 0
                                    ? c.slideCount % c.options.slidesToScroll !=
                                      0
                                        ? c.slideCount -
                                          (c.slideCount %
                                              c.options.slidesToScroll)
                                        : c.slideCount + s
                                    : s >= c.slideCount
                                    ? c.slideCount % c.options.slidesToScroll !=
                                      0
                                        ? 0
                                        : s - c.slideCount
                                    : s),
                            (c.animating = !0),
                            c.$slider.trigger("beforeChange", [
                                c,
                                c.currentSlide,
                                o
                            ]),
                            (n = c.currentSlide),
                            (c.currentSlide = o),
                            c.setSlideClasses(c.currentSlide),
                            c.options.asNavFor &&
                                (a = (a = c.getNavTarget()).slick("getSlick"))
                                    .slideCount <= a.options.slidesToShow &&
                                a.setSlideClasses(c.currentSlide),
                            c.updateDots(),
                            c.updateArrows(),
                            !0 === c.options.fade)
                        )
                            return (
                                !0 !== i
                                    ? (c.fadeSlideOut(n),
                                      c.fadeSlide(o, function() {
                                          c.postSlide(o);
                                      }))
                                    : c.postSlide(o),
                                void c.animateHeight()
                            );
                        !0 !== i
                            ? c.animateSlide(l, function() {
                                  c.postSlide(o);
                              })
                            : c.postSlide(o);
                    }
            }),
            (e.prototype.startLoad = function() {
                var t = this;
                !0 === t.options.arrows &&
                    t.slideCount > t.options.slidesToShow &&
                    (t.$prevArrow.hide(), t.$nextArrow.hide()),
                    !0 === t.options.dots &&
                        t.slideCount > t.options.slidesToShow &&
                        t.$dots.hide(),
                    t.$slider.addClass("slick-loading");
            }),
            (e.prototype.swipeDirection = function() {
                var t,
                    e,
                    i,
                    s,
                    o = this;
                return (
                    (t = o.touchObject.startX - o.touchObject.curX),
                    (e = o.touchObject.startY - o.touchObject.curY),
                    (i = Math.atan2(e, t)),
                    (s = Math.round((180 * i) / Math.PI)) < 0 &&
                        (s = 360 - Math.abs(s)),
                    s <= 45 && s >= 0
                        ? !1 === o.options.rtl
                            ? "left"
                            : "right"
                        : s <= 360 && s >= 315
                        ? !1 === o.options.rtl
                            ? "left"
                            : "right"
                        : s >= 135 && s <= 225
                        ? !1 === o.options.rtl
                            ? "right"
                            : "left"
                        : !0 === o.options.verticalSwiping
                        ? s >= 35 && s <= 135
                            ? "down"
                            : "up"
                        : "vertical"
                );
            }),
            (e.prototype.swipeEnd = function(t) {
                var e,
                    i,
                    s = this;
                if (((s.dragging = !1), (s.swiping = !1), s.scrolling))
                    return (s.scrolling = !1), !1;
                if (
                    ((s.interrupted = !1),
                    (s.shouldClick = !(s.touchObject.swipeLength > 10)),
                    void 0 === s.touchObject.curX)
                )
                    return !1;
                if (
                    (!0 === s.touchObject.edgeHit &&
                        s.$slider.trigger("edge", [s, s.swipeDirection()]),
                    s.touchObject.swipeLength >= s.touchObject.minSwipe)
                ) {
                    switch ((i = s.swipeDirection())) {
                        case "left":
                        case "down":
                            (e = s.options.swipeToSlide
                                ? s.checkNavigable(
                                      s.currentSlide + s.getSlideCount()
                                  )
                                : s.currentSlide + s.getSlideCount()),
                                (s.currentDirection = 0);
                            break;
                        case "right":
                        case "up":
                            (e = s.options.swipeToSlide
                                ? s.checkNavigable(
                                      s.currentSlide - s.getSlideCount()
                                  )
                                : s.currentSlide - s.getSlideCount()),
                                (s.currentDirection = 1);
                    }
                    "vertical" != i &&
                        (s.slideHandler(e),
                        (s.touchObject = {}),
                        s.$slider.trigger("swipe", [s, i]));
                } else
                    s.touchObject.startX !== s.touchObject.curX &&
                        (s.slideHandler(s.currentSlide), (s.touchObject = {}));
            }),
            (e.prototype.swipeHandler = function(t) {
                var e = this;
                if (
                    !(
                        !1 === e.options.swipe ||
                        ("ontouchend" in document && !1 === e.options.swipe) ||
                        (!1 === e.options.draggable &&
                            -1 !== t.type.indexOf("mouse"))
                    )
                )
                    switch (
                        ((e.touchObject.fingerCount =
                            t.originalEvent &&
                            void 0 !== t.originalEvent.touches
                                ? t.originalEvent.touches.length
                                : 1),
                        (e.touchObject.minSwipe =
                            e.listWidth / e.options.touchThreshold),
                        !0 === e.options.verticalSwiping &&
                            (e.touchObject.minSwipe =
                                e.listHeight / e.options.touchThreshold),
                        t.data.action)
                    ) {
                        case "start":
                            e.swipeStart(t);
                            break;
                        case "move":
                            e.swipeMove(t);
                            break;
                        case "end":
                            e.swipeEnd(t);
                    }
            }),
            (e.prototype.swipeMove = function(t) {
                var e,
                    i,
                    s,
                    o,
                    n,
                    r,
                    a = this;
                return (
                    (n =
                        void 0 !== t.originalEvent
                            ? t.originalEvent.touches
                            : null),
                    !(!a.dragging || a.scrolling || (n && 1 !== n.length)) &&
                        ((e = a.getLeft(a.currentSlide)),
                        (a.touchObject.curX =
                            void 0 !== n ? n[0].pageX : t.clientX),
                        (a.touchObject.curY =
                            void 0 !== n ? n[0].pageY : t.clientY),
                        (a.touchObject.swipeLength = Math.round(
                            Math.sqrt(
                                Math.pow(
                                    a.touchObject.curX - a.touchObject.startX,
                                    2
                                )
                            )
                        )),
                        (r = Math.round(
                            Math.sqrt(
                                Math.pow(
                                    a.touchObject.curY - a.touchObject.startY,
                                    2
                                )
                            )
                        )),
                        !a.options.verticalSwiping && !a.swiping && r > 4
                            ? ((a.scrolling = !0), !1)
                            : (!0 === a.options.verticalSwiping &&
                                  (a.touchObject.swipeLength = r),
                              (i = a.swipeDirection()),
                              void 0 !== t.originalEvent &&
                                  a.touchObject.swipeLength > 4 &&
                                  ((a.swiping = !0), t.preventDefault()),
                              (o =
                                  (!1 === a.options.rtl ? 1 : -1) *
                                  (a.touchObject.curX > a.touchObject.startX
                                      ? 1
                                      : -1)),
                              !0 === a.options.verticalSwiping &&
                                  (o =
                                      a.touchObject.curY > a.touchObject.startY
                                          ? 1
                                          : -1),
                              (s = a.touchObject.swipeLength),
                              (a.touchObject.edgeHit = !1),
                              !1 === a.options.infinite &&
                                  ((0 === a.currentSlide && "right" === i) ||
                                      (a.currentSlide >= a.getDotCount() &&
                                          "left" === i)) &&
                                  ((s =
                                      a.touchObject.swipeLength *
                                      a.options.edgeFriction),
                                  (a.touchObject.edgeHit = !0)),
                              !1 === a.options.vertical
                                  ? (a.swipeLeft = e + s * o)
                                  : (a.swipeLeft =
                                        e +
                                        s *
                                            (a.$list.height() / a.listWidth) *
                                            o),
                              !0 === a.options.verticalSwiping &&
                                  (a.swipeLeft = e + s * o),
                              !0 !== a.options.fade &&
                                  !1 !== a.options.touchMove &&
                                  (!0 === a.animating
                                      ? ((a.swipeLeft = null), !1)
                                      : void a.setCSS(a.swipeLeft))))
                );
            }),
            (e.prototype.swipeStart = function(t) {
                var e,
                    i = this;
                if (
                    ((i.interrupted = !0),
                    1 !== i.touchObject.fingerCount ||
                        i.slideCount <= i.options.slidesToShow)
                )
                    return (i.touchObject = {}), !1;
                void 0 !== t.originalEvent &&
                    void 0 !== t.originalEvent.touches &&
                    (e = t.originalEvent.touches[0]),
                    (i.touchObject.startX = i.touchObject.curX =
                        void 0 !== e ? e.pageX : t.clientX),
                    (i.touchObject.startY = i.touchObject.curY =
                        void 0 !== e ? e.pageY : t.clientY),
                    (i.dragging = !0);
            }),
            (e.prototype.unfilterSlides = e.prototype.slickUnfilter = function() {
                var t = this;
                null !== t.$slidesCache &&
                    (t.unload(),
                    t.$slideTrack.children(this.options.slide).detach(),
                    t.$slidesCache.appendTo(t.$slideTrack),
                    t.reinit());
            }),
            (e.prototype.unload = function() {
                var e = this;
                t(".slick-cloned", e.$slider).remove(),
                    e.$dots && e.$dots.remove(),
                    e.$prevArrow &&
                        e.htmlExpr.test(e.options.prevArrow) &&
                        e.$prevArrow.remove(),
                    e.$nextArrow &&
                        e.htmlExpr.test(e.options.nextArrow) &&
                        e.$nextArrow.remove(),
                    e.$slides
                        .removeClass(
                            "slick-slide slick-active slick-visible slick-current"
                        )
                        .attr("aria-hidden", "true")
                        .css("width", "");
            }),
            (e.prototype.unslick = function(t) {
                var e = this;
                e.$slider.trigger("unslick", [e, t]), e.destroy();
            }),
            (e.prototype.updateArrows = function() {
                var t = this;
                Math.floor(t.options.slidesToShow / 2),
                    !0 === t.options.arrows &&
                        t.slideCount > t.options.slidesToShow &&
                        !t.options.infinite &&
                        (t.$prevArrow
                            .removeClass("slick-disabled")
                            .attr("aria-disabled", "false"),
                        t.$nextArrow
                            .removeClass("slick-disabled")
                            .attr("aria-disabled", "false"),
                        0 === t.currentSlide
                            ? (t.$prevArrow
                                  .addClass("slick-disabled")
                                  .attr("aria-disabled", "true"),
                              t.$nextArrow
                                  .removeClass("slick-disabled")
                                  .attr("aria-disabled", "false"))
                            : t.currentSlide >=
                                  t.slideCount - t.options.slidesToShow &&
                              !1 === t.options.centerMode
                            ? (t.$nextArrow
                                  .addClass("slick-disabled")
                                  .attr("aria-disabled", "true"),
                              t.$prevArrow
                                  .removeClass("slick-disabled")
                                  .attr("aria-disabled", "false"))
                            : t.currentSlide >= t.slideCount - 1 &&
                              !0 === t.options.centerMode &&
                              (t.$nextArrow
                                  .addClass("slick-disabled")
                                  .attr("aria-disabled", "true"),
                              t.$prevArrow
                                  .removeClass("slick-disabled")
                                  .attr("aria-disabled", "false")));
            }),
            (e.prototype.updateDots = function() {
                var t = this;
                null !== t.$dots &&
                    (t.$dots
                        .find("li")
                        .removeClass("slick-active")
                        .end(),
                    t.$dots
                        .find("li")
                        .eq(
                            Math.floor(
                                t.currentSlide / t.options.slidesToScroll
                            )
                        )
                        .addClass("slick-active"));
            }),
            (e.prototype.visibility = function() {
                var t = this;
                t.options.autoplay &&
                    (document[t.hidden]
                        ? (t.interrupted = !0)
                        : (t.interrupted = !1));
            }),
            (t.fn.slick = function() {
                var t,
                    i,
                    s = this,
                    o = arguments[0],
                    n = Array.prototype.slice.call(arguments, 1),
                    r = s.length;
                for (t = 0; t < r; t++)
                    if (
                        ("object" == typeof o || void 0 === o
                            ? (s[t].slick = new e(s[t], o))
                            : (i = s[t].slick[o].apply(s[t].slick, n)),
                        void 0 !== i)
                    )
                        return i;
                return s;
            });
    }),
    (function(t, e) {
        function i(e) {
            t.fn.cycle.debug && s(e);
        }
        function s() {
            window.console &&
                console.log &&
                console.log(
                    "[cycle] " + Array.prototype.join.call(arguments, " ")
                );
        }
        function o(e, i, s) {
            var o = t(e).data("cycle.opts"),
                n = !!e.cyclePause;
            n && o.paused
                ? o.paused(e, o, i, s)
                : !n && o.resumed && o.resumed(e, o, i, s);
        }
        function n(i, n, r) {
            function a(e, i, o) {
                if (!e && !0 === i) {
                    var n = t(o).data("cycle.opts");
                    if (!n) return s("options not found, can not resume"), !1;
                    o.cycleTimeout &&
                        (clearTimeout(o.cycleTimeout), (o.cycleTimeout = 0)),
                        c(n.elements, n, 1, !n.backwards);
                }
            }
            if (
                (i.cycleStop == e && (i.cycleStop = 0),
                (n === e || null === n) && (n = {}),
                n.constructor == String)
            ) {
                switch (n) {
                    case "destroy":
                    case "stop":
                        return (
                            !!(l = t(i).data("cycle.opts")) &&
                            (i.cycleStop++,
                            i.cycleTimeout && clearTimeout(i.cycleTimeout),
                            (i.cycleTimeout = 0),
                            l.elements && t(l.elements).stop(),
                            t(i).removeData("cycle.opts"),
                            "destroy" == n &&
                                (function(e) {
                                    e.next && t(e.next).unbind(e.prevNextEvent),
                                        e.prev &&
                                            t(e.prev).unbind(e.prevNextEvent),
                                        (e.pager || e.pagerAnchorBuilder) &&
                                            t.each(
                                                e.pagerAnchors || [],
                                                function() {
                                                    this.unbind().remove();
                                                }
                                            ),
                                        (e.pagerAnchors = null),
                                        e.destroy && e.destroy(e);
                                })(l),
                            !1)
                        );
                    case "toggle":
                        return (
                            (i.cyclePause = 1 === i.cyclePause ? 0 : 1),
                            a(i.cyclePause, r, i),
                            o(i),
                            !1
                        );
                    case "pause":
                        return (i.cyclePause = 1), o(i), !1;
                    case "resume":
                        return (i.cyclePause = 0), a(!1, r, i), o(i), !1;
                    case "prev":
                    case "next":
                        var l;
                        return (l = t(i).data("cycle.opts"))
                            ? (t.fn.cycle[n](l), !1)
                            : (s('options not found, "prev/next" ignored'), !1);
                    default:
                        n = { fx: n };
                }
                return n;
            }
            if (n.constructor == Number) {
                var d = n;
                return (n = t(i).data("cycle.opts"))
                    ? 0 > d || d >= n.elements.length
                        ? (s("invalid slide index: " + d), !1)
                        : ((n.nextSlide = d),
                          i.cycleTimeout &&
                              (clearTimeout(i.cycleTimeout),
                              (i.cycleTimeout = 0)),
                          "string" == typeof r && (n.oneTimeFx = r),
                          c(n.elements, n, 1, d >= n.currSlide),
                          !1)
                    : (s("options not found, can not advance slide"), !1);
            }
            return n;
        }
        function r(e, i) {
            if (!t.support.opacity && i.cleartype && e.style.filter)
                try {
                    e.style.removeAttribute("filter");
                } catch (t) {}
        }
        function a(i, n, a, d, p) {
            var f,
                g = t.extend(
                    {},
                    t.fn.cycle.defaults,
                    d || {},
                    t.metadata ? i.metadata() : t.meta ? i.data() : {}
                ),
                m = t.isFunction(i.data) ? i.data(g.metaAttr) : null;
            m && (g = t.extend(g, m)),
                g.autostop && (g.countdown = g.autostopCount || a.length);
            var v = i[0];
            if (
                (i.data("cycle.opts", g),
                (g.$cont = i),
                (g.stopCount = v.cycleStop),
                (g.elements = a),
                (g.before = g.before ? [g.before] : []),
                (g.after = g.after ? [g.after] : []),
                !t.support.opacity &&
                    g.cleartype &&
                    g.after.push(function() {
                        r(this, g);
                    }),
                g.continuous &&
                    g.after.push(function() {
                        c(a, g, 0, !g.backwards);
                    }),
                (function(e) {
                    (e.original = { before: [], after: [] }),
                        (e.original.cssBefore = t.extend({}, e.cssBefore)),
                        (e.original.cssAfter = t.extend({}, e.cssAfter)),
                        (e.original.animIn = t.extend({}, e.animIn)),
                        (e.original.animOut = t.extend({}, e.animOut)),
                        t.each(e.before, function() {
                            e.original.before.push(this);
                        }),
                        t.each(e.after, function() {
                            e.original.after.push(this);
                        });
                })(g),
                t.support.opacity || !g.cleartype || g.cleartypeNoBg || u(n),
                "static" == i.css("position") && i.css("position", "relative"),
                g.width && i.width(g.width),
                g.height && "auto" != g.height && i.height(g.height),
                g.startingSlide != e
                    ? ((g.startingSlide = parseInt(g.startingSlide, 10)),
                      g.startingSlide >= a.length || g.startSlide < 0
                          ? (g.startingSlide = 0)
                          : (f = !0))
                    : g.backwards
                    ? (g.startingSlide = a.length - 1)
                    : (g.startingSlide = 0),
                g.random)
            ) {
                g.randomMap = [];
                for (var y = 0; y < a.length; y++) g.randomMap.push(y);
                if (
                    (g.randomMap.sort(function(t, e) {
                        return Math.random() - 0.5;
                    }),
                    f)
                )
                    for (var w = 0; w < a.length; w++)
                        g.startingSlide == g.randomMap[w] &&
                            (g.randomIndex = w);
                else (g.randomIndex = 1), (g.startingSlide = g.randomMap[1]);
            } else g.startingSlide >= a.length && (g.startingSlide = 0);
            g.currSlide = g.startingSlide || 0;
            var x = g.startingSlide;
            if (
                (n
                    .css({ position: "absolute", top: 0, left: 0 })
                    .hide()
                    .each(function(e) {
                        var i;
                        (i = g.backwards
                            ? x
                                ? x >= e
                                    ? a.length + (e - x)
                                    : x - e
                                : a.length - e
                            : x
                            ? e >= x
                                ? a.length - (e - x)
                                : x - e
                            : a.length - e),
                            t(this).css("z-index", i);
                    }),
                t(a[x])
                    .css("opacity", 1)
                    .show(),
                r(a[x], g),
                g.fit &&
                    (g.aspect
                        ? n.each(function() {
                              var e = t(this),
                                  i =
                                      !0 === g.aspect
                                          ? e.width() / e.height()
                                          : g.aspect;
                              g.width &&
                                  e.width() != g.width &&
                                  (e.width(g.width), e.height(g.width / i)),
                                  g.height &&
                                      e.height() < g.height &&
                                      (e.height(g.height),
                                      e.width(g.height * i));
                          })
                        : (g.width && n.width(g.width),
                          g.height &&
                              "auto" != g.height &&
                              n.height(g.height))),
                !g.center ||
                    (g.fit && !g.aspect) ||
                    n.each(function() {
                        var e = t(this);
                        e.css({
                            "margin-left": g.width
                                ? (g.width - e.width()) / 2 + "px"
                                : 0,
                            "margin-top": g.height
                                ? (g.height - e.height()) / 2 + "px"
                                : 0
                        });
                    }),
                !g.center ||
                    g.fit ||
                    g.slideResize ||
                    n.each(function() {
                        var e = t(this);
                        e.css({
                            "margin-left": g.width
                                ? (g.width - e.width()) / 2 + "px"
                                : 0,
                            "margin-top": g.height
                                ? (g.height - e.height()) / 2 + "px"
                                : 0
                        });
                    }),
                g.containerResize && !i.innerHeight())
            ) {
                for (var S = 0, k = 0, b = 0; b < a.length; b++) {
                    var T = t(a[b]),
                        $ = T[0],
                        C = T.outerWidth(),
                        _ = T.outerHeight();
                    C || (C = $.offsetWidth || $.width || T.attr("width")),
                        _ ||
                            (_ =
                                $.offsetHeight || $.height || T.attr("height")),
                        (S = C > S ? C : S),
                        (k = _ > k ? _ : k);
                }
                S > 0 && k > 0 && i.css({ width: S + "px", height: k + "px" });
            }
            var z = !1;
            if (
                (g.pause &&
                    i.hover(
                        function() {
                            (z = !0), this.cyclePause++, o(v, !0);
                        },
                        function() {
                            z && this.cyclePause--, o(v, !0);
                        }
                    ),
                !1 === l(g))
            )
                return !1;
            var I = !1;
            if (
                ((d.requeueAttempts = d.requeueAttempts || 0),
                n.each(function() {
                    var e = t(this);
                    if (
                        ((this.cycleH =
                            g.fit && g.height
                                ? g.height
                                : e.height() ||
                                  this.offsetHeight ||
                                  this.height ||
                                  e.attr("height") ||
                                  0),
                        (this.cycleW =
                            g.fit && g.width
                                ? g.width
                                : e.width() ||
                                  this.offsetWidth ||
                                  this.width ||
                                  e.attr("width") ||
                                  0),
                        e.is("img"))
                    ) {
                        var i =
                                t.browser.msie &&
                                28 == this.cycleW &&
                                30 == this.cycleH &&
                                !this.complete,
                            o =
                                t.browser.mozilla &&
                                34 == this.cycleW &&
                                19 == this.cycleH &&
                                !this.complete,
                            n =
                                t.browser.opera &&
                                ((42 == this.cycleW && 19 == this.cycleH) ||
                                    (37 == this.cycleW && 17 == this.cycleH)) &&
                                !this.complete,
                            r =
                                0 == this.cycleH &&
                                0 == this.cycleW &&
                                !this.complete;
                        if (i || o || n || r) {
                            if (
                                p.s &&
                                g.requeueOnImageNotLoaded &&
                                ++d.requeueAttempts < 100
                            )
                                return (
                                    s(
                                        d.requeueAttempts,
                                        " - img slide not loaded, requeuing slideshow: ",
                                        this.src,
                                        this.cycleW,
                                        this.cycleH
                                    ),
                                    setTimeout(function() {
                                        t(p.s, p.c).cycle(d);
                                    }, g.requeueTimeout),
                                    (I = !0),
                                    !1
                                );
                            s(
                                "could not determine size of image: " +
                                    this.src,
                                this.cycleW,
                                this.cycleH
                            );
                        }
                    }
                    return !0;
                }),
                I)
            )
                return !1;
            if (
                ((g.cssBefore = g.cssBefore || {}),
                (g.cssAfter = g.cssAfter || {}),
                (g.cssFirst = g.cssFirst || {}),
                (g.animIn = g.animIn || {}),
                (g.animOut = g.animOut || {}),
                n.not(":eq(" + x + ")").css(g.cssBefore),
                t(n[x]).css(g.cssFirst),
                g.timeout)
            ) {
                (g.timeout = parseInt(g.timeout, 10)),
                    g.speed.constructor == String &&
                        (g.speed =
                            t.fx.speeds[g.speed] || parseInt(g.speed, 10)),
                    g.sync || (g.speed = g.speed / 2);
                for (
                    var O = "none" == g.fx ? 0 : "shuffle" == g.fx ? 500 : 250;
                    g.timeout - g.speed < O;

                )
                    g.timeout += g.speed;
            }
            if (
                (g.easing && (g.easeIn = g.easeOut = g.easing),
                g.speedIn || (g.speedIn = g.speed),
                g.speedOut || (g.speedOut = g.speed),
                (g.slideCount = a.length),
                (g.currSlide = g.lastSlide = x),
                g.random
                    ? (++g.randomIndex == a.length && (g.randomIndex = 0),
                      (g.nextSlide = g.randomMap[g.randomIndex]))
                    : g.backwards
                    ? (g.nextSlide =
                          0 == g.startingSlide
                              ? a.length - 1
                              : g.startingSlide - 1)
                    : (g.nextSlide =
                          g.startingSlide >= a.length - 1
                              ? 0
                              : g.startingSlide + 1),
                !g.multiFx)
            ) {
                var E = t.fn.cycle.transitions[g.fx];
                if (t.isFunction(E)) E(i, n, g);
                else if ("custom" != g.fx && !g.multiFx)
                    return (
                        s(
                            "unknown transition: " + g.fx,
                            "; slideshow terminating"
                        ),
                        !1
                    );
            }
            var A = n[x];
            return (
                g.skipInitializationCallbacks ||
                    (g.before.length && g.before[0].apply(A, [A, A, g, !0]),
                    g.after.length && g.after[0].apply(A, [A, A, g, !0])),
                g.next &&
                    t(g.next).bind(g.prevNextEvent, function() {
                        return h(g, 1);
                    }),
                g.prev &&
                    t(g.prev).bind(g.prevNextEvent, function() {
                        return h(g, 0);
                    }),
                (g.pager || g.pagerAnchorBuilder) &&
                    (function(e, i) {
                        var s = t(i.pager);
                        t.each(e, function(o, n) {
                            t.fn.cycle.createPagerAnchor(o, n, s, e, i);
                        }),
                            i.updateActivePagerLink(
                                i.pager,
                                i.startingSlide,
                                i.activePagerClass
                            );
                    })(a, g),
                (function(e, i) {
                    e.addSlide = function(s, o) {
                        var n = t(s),
                            r = n[0];
                        e.autostopCount || e.countdown++,
                            i[o ? "unshift" : "push"](r),
                            e.els && e.els[o ? "unshift" : "push"](r),
                            (e.slideCount = i.length),
                            e.random &&
                                (e.randomMap.push(e.slideCount - 1),
                                e.randomMap.sort(function(t, e) {
                                    return Math.random() - 0.5;
                                })),
                            n.css("position", "absolute"),
                            n[o ? "prependTo" : "appendTo"](e.$cont),
                            o && (e.currSlide++, e.nextSlide++),
                            t.support.opacity ||
                                !e.cleartype ||
                                e.cleartypeNoBg ||
                                u(n),
                            e.fit && e.width && n.width(e.width),
                            e.fit &&
                                e.height &&
                                "auto" != e.height &&
                                n.height(e.height),
                            (r.cycleH =
                                e.fit && e.height ? e.height : n.height()),
                            (r.cycleW = e.fit && e.width ? e.width : n.width()),
                            n.css(e.cssBefore),
                            (e.pager || e.pagerAnchorBuilder) &&
                                t.fn.cycle.createPagerAnchor(
                                    i.length - 1,
                                    r,
                                    t(e.pager),
                                    i,
                                    e
                                ),
                            t.isFunction(e.onAddSlide)
                                ? e.onAddSlide(n)
                                : n.hide();
                    };
                })(g, a),
                g
            );
        }
        function l(e) {
            var o,
                n,
                r = t.fn.cycle.transitions;
            if (e.fx.indexOf(",") > 0) {
                for (
                    e.multiFx = !0,
                        e.fxs = e.fx.replace(/\s*/g, "").split(","),
                        o = 0;
                    o < e.fxs.length;
                    o++
                ) {
                    var a = e.fxs[o];
                    ((n = r[a]) && r.hasOwnProperty(a) && t.isFunction(n)) ||
                        (s("discarding unknown transition: ", a),
                        e.fxs.splice(o, 1),
                        o--);
                }
                if (!e.fxs.length)
                    return (
                        s("No valid transitions named; slideshow terminating."),
                        !1
                    );
            } else if ("all" == e.fx)
                for (p in ((e.multiFx = !0), (e.fxs = []), r))
                    (n = r[p]),
                        r.hasOwnProperty(p) && t.isFunction(n) && e.fxs.push(p);
            if (e.multiFx && e.randomizeEffects) {
                var l = Math.floor(20 * Math.random()) + 30;
                for (o = 0; l > o; o++) {
                    var c = Math.floor(Math.random() * e.fxs.length);
                    e.fxs.push(e.fxs.splice(c, 1)[0]);
                }
                i("randomized fx sequence: ", e.fxs);
            }
            return !0;
        }
        function c(s, o, n, r) {
            function a() {
                var t = 0;
                o.timeout,
                    o.timeout && !o.continuous
                        ? ((t = d(s[o.currSlide], s[o.nextSlide], o, r)),
                          "shuffle" == o.fx && (t -= o.speedOut))
                        : o.continuous && l.cyclePause && (t = 10),
                    t > 0 &&
                        (l.cycleTimeout = setTimeout(function() {
                            c(s, o, 0, !o.backwards);
                        }, t));
            }
            if (
                (n &&
                    o.busy &&
                    o.manualTrump &&
                    (i("manualTrump in go(), stopping active transition"),
                    t(s).stop(!0, !0),
                    (o.busy = 0)),
                o.busy)
            )
                i("transition active, ignoring new tx request");
            else {
                var l = o.$cont[0],
                    h = s[o.currSlide],
                    p = s[o.nextSlide];
                if (l.cycleStop == o.stopCount && (0 !== l.cycleTimeout || n)) {
                    if (
                        !n &&
                        !l.cyclePause &&
                        !o.bounce &&
                        ((o.autostop && --o.countdown <= 0) ||
                            (o.nowrap &&
                                !o.random &&
                                o.nextSlide < o.currSlide))
                    )
                        return void (o.end && o.end(o));
                    var u = !1;
                    if ((!n && l.cyclePause) || o.nextSlide == o.currSlide) a();
                    else {
                        u = !0;
                        var f = o.fx;
                        (h.cycleH = h.cycleH || t(h).height()),
                            (h.cycleW = h.cycleW || t(h).width()),
                            (p.cycleH = p.cycleH || t(p).height()),
                            (p.cycleW = p.cycleW || t(p).width()),
                            o.multiFx &&
                                (r &&
                                (o.lastFx == e || ++o.lastFx >= o.fxs.length)
                                    ? (o.lastFx = 0)
                                    : !r &&
                                      (o.lastFx == e || --o.lastFx < 0) &&
                                      (o.lastFx = o.fxs.length - 1),
                                (f = o.fxs[o.lastFx])),
                            o.oneTimeFx &&
                                ((f = o.oneTimeFx), (o.oneTimeFx = null)),
                            t.fn.cycle.resetState(o, f),
                            o.before.length &&
                                t.each(o.before, function(t, e) {
                                    l.cycleStop == o.stopCount &&
                                        e.apply(p, [h, p, o, r]);
                                });
                        var g = function() {
                            (o.busy = 0),
                                t.each(o.after, function(t, e) {
                                    l.cycleStop == o.stopCount &&
                                        e.apply(p, [h, p, o, r]);
                                }),
                                l.cycleStop || a();
                        };
                        i(
                            "tx firing(" +
                                f +
                                "); currSlide: " +
                                o.currSlide +
                                "; nextSlide: " +
                                o.nextSlide
                        ),
                            (o.busy = 1),
                            o.fxFn
                                ? o.fxFn(h, p, o, g, r, n && o.fastOnEvent)
                                : t.isFunction(t.fn.cycle[o.fx])
                                ? t.fn.cycle[o.fx](
                                      h,
                                      p,
                                      o,
                                      g,
                                      r,
                                      n && o.fastOnEvent
                                  )
                                : t.fn.cycle.custom(
                                      h,
                                      p,
                                      o,
                                      g,
                                      r,
                                      n && o.fastOnEvent
                                  );
                    }
                    if (u || o.nextSlide == o.currSlide)
                        if (((o.lastSlide = o.currSlide), o.random))
                            (o.currSlide = o.nextSlide),
                                ++o.randomIndex == s.length &&
                                    ((o.randomIndex = 0),
                                    o.randomMap.sort(function(t, e) {
                                        return Math.random() - 0.5;
                                    })),
                                (o.nextSlide = o.randomMap[o.randomIndex]),
                                o.nextSlide == o.currSlide &&
                                    (o.nextSlide =
                                        o.currSlide == o.slideCount - 1
                                            ? 0
                                            : o.currSlide + 1);
                        else if (o.backwards) {
                            (m = o.nextSlide - 1 < 0) && o.bounce
                                ? ((o.backwards = !o.backwards),
                                  (o.nextSlide = 1),
                                  (o.currSlide = 0))
                                : ((o.nextSlide = m
                                      ? s.length - 1
                                      : o.nextSlide - 1),
                                  (o.currSlide = m ? 0 : o.nextSlide + 1));
                        } else {
                            var m;
                            (m = o.nextSlide + 1 == s.length) && o.bounce
                                ? ((o.backwards = !o.backwards),
                                  (o.nextSlide = s.length - 2),
                                  (o.currSlide = s.length - 1))
                                : ((o.nextSlide = m ? 0 : o.nextSlide + 1),
                                  (o.currSlide = m
                                      ? s.length - 1
                                      : o.nextSlide - 1));
                        }
                    u &&
                        o.pager &&
                        o.updateActivePagerLink(
                            o.pager,
                            o.currSlide,
                            o.activePagerClass
                        );
                }
            }
        }
        function d(t, e, s, o) {
            if (s.timeoutFn) {
                for (
                    var n = s.timeoutFn.call(t, t, e, s, o);
                    "none" != s.fx && n - s.speed < 250;

                )
                    n += s.speed;
                if (
                    (i("calculated timeout: " + n + "; speed: " + s.speed),
                    !1 !== n)
                )
                    return n;
            }
            return s.timeout;
        }
        function h(e, i) {
            var s = i ? 1 : -1,
                o = e.elements,
                n = e.$cont[0],
                r = n.cycleTimeout;
            if (
                (r && (clearTimeout(r), (n.cycleTimeout = 0)),
                e.random && 0 > s)
            )
                e.randomIndex--,
                    -2 == --e.randomIndex
                        ? (e.randomIndex = o.length - 2)
                        : -1 == e.randomIndex && (e.randomIndex = o.length - 1),
                    (e.nextSlide = e.randomMap[e.randomIndex]);
            else if (e.random) e.nextSlide = e.randomMap[e.randomIndex];
            else if (((e.nextSlide = e.currSlide + s), e.nextSlide < 0)) {
                if (e.nowrap) return !1;
                e.nextSlide = o.length - 1;
            } else if (e.nextSlide >= o.length) {
                if (e.nowrap) return !1;
                e.nextSlide = 0;
            }
            var a = e.onPrevNextEvent || e.prevNextClick;
            return (
                t.isFunction(a) && a(s > 0, e.nextSlide, o[e.nextSlide]),
                c(o, e, 1, i),
                !1
            );
        }
        function u(e) {
            function s(t) {
                return (t = parseInt(t, 10).toString(16)).length < 2
                    ? "0" + t
                    : t;
            }
            i("applying clearType background-color hack"),
                e.each(function() {
                    t(this).css(
                        "background-color",
                        (function(e) {
                            for (
                                ;
                                e && "html" != e.nodeName.toLowerCase();
                                e = e.parentNode
                            ) {
                                var i = t.css(e, "background-color");
                                if (i && i.indexOf("rgb") >= 0) {
                                    var o = i.match(/\d+/g);
                                    return "#" + s(o[0]) + s(o[1]) + s(o[2]);
                                }
                                if (i && "transparent" != i) return i;
                            }
                            return "#ffffff";
                        })(this)
                    );
                });
        }
        t.support == e && (t.support = { opacity: !t.browser.msie }),
            (t.expr[":"].paused = function(t) {
                return t.cyclePause;
            }),
            (t.fn.cycle = function(e, o) {
                var r = { s: this.selector, c: this.context };
                return 0 === this.length && "stop" != e
                    ? !t.isReady && r.s
                        ? (s("DOM not ready, queuing slideshow"),
                          t(function() {
                              t(r.s, r.c).cycle(e, o);
                          }),
                          this)
                        : (s(
                              "terminating; zero elements found by selector" +
                                  (t.isReady ? "" : " (DOM not ready)")
                          ),
                          this)
                    : this.each(function() {
                          var l = n(this, e, o);
                          if (!1 !== l) {
                              (l.updateActivePagerLink =
                                  l.updateActivePagerLink ||
                                  t.fn.cycle.updateActivePagerLink),
                                  this.cycleTimeout &&
                                      clearTimeout(this.cycleTimeout),
                                  (this.cycleTimeout = this.cyclePause = 0);
                              var h = t(this),
                                  p = l.slideExpr
                                      ? t(l.slideExpr, this)
                                      : h.children(),
                                  u = p.get(),
                                  f = a(h, p, u, l, r);
                              if (!1 !== f) {
                                  if (u.length < 2)
                                      return void s(
                                          "terminating; too few slides: " +
                                              u.length
                                      );
                                  var g = f.continuous
                                      ? 10
                                      : d(
                                            u[f.currSlide],
                                            u[f.nextSlide],
                                            f,
                                            !f.backwards
                                        );
                                  g &&
                                      (10 > (g += f.delay || 0) && (g = 10),
                                      i("first timeout: " + g),
                                      (this.cycleTimeout = setTimeout(
                                          function() {
                                              c(u, f, 0, !l.backwards);
                                          },
                                          g
                                      )));
                              }
                          }
                      });
            }),
            (t.fn.cycle.resetState = function(e, i) {
                (i = i || e.fx),
                    (e.before = []),
                    (e.after = []),
                    (e.cssBefore = t.extend({}, e.original.cssBefore)),
                    (e.cssAfter = t.extend({}, e.original.cssAfter)),
                    (e.animIn = t.extend({}, e.original.animIn)),
                    (e.animOut = t.extend({}, e.original.animOut)),
                    (e.fxFn = null),
                    t.each(e.original.before, function() {
                        e.before.push(this);
                    }),
                    t.each(e.original.after, function() {
                        e.after.push(this);
                    });
                var s = t.fn.cycle.transitions[i];
                t.isFunction(s) && s(e.$cont, t(e.elements), e);
            }),
            (t.fn.cycle.updateActivePagerLink = function(e, i, s) {
                t(e).each(function() {
                    t(this)
                        .children()
                        .removeClass(s)
                        .eq(i)
                        .addClass(s);
                });
            }),
            (t.fn.cycle.next = function(t) {
                h(t, 1);
            }),
            (t.fn.cycle.prev = function(t) {
                h(t, 0);
            }),
            (t.fn.cycle.createPagerAnchor = function(e, s, n, r, a) {
                var l;
                if (
                    (t.isFunction(a.pagerAnchorBuilder)
                        ? ((l = a.pagerAnchorBuilder(e, s)),
                          i("pagerAnchorBuilder(" + e + ", el) returned: " + l))
                        : (l = '<a href="#">' + (e + 1) + "</a>"),
                    l)
                ) {
                    var d = t(l);
                    if (0 === d.parents("body").length) {
                        var h = [];
                        n.length > 1
                            ? (n.each(function() {
                                  var e = d.clone(!0);
                                  t(this).append(e), h.push(e[0]);
                              }),
                              (d = t(h)))
                            : d.appendTo(n);
                    }
                    (a.pagerAnchors = a.pagerAnchors || []),
                        a.pagerAnchors.push(d);
                    var p = function(i) {
                        i.preventDefault(), (a.nextSlide = e);
                        var s = a.$cont[0],
                            o = s.cycleTimeout;
                        o && (clearTimeout(o), (s.cycleTimeout = 0));
                        var n = a.onPagerEvent || a.pagerClick;
                        t.isFunction(n) && n(a.nextSlide, r[a.nextSlide]),
                            c(r, a, 1, a.currSlide < e);
                    };
                    /mouseenter|mouseover/i.test(a.pagerEvent)
                        ? d.hover(p, function() {})
                        : d.bind(a.pagerEvent, p),
                        /^click/.test(a.pagerEvent) ||
                            a.allowPagerClickBubble ||
                            d.bind("click.cycle", function() {
                                return !1;
                            });
                    var u = a.$cont[0],
                        f = !1;
                    a.pauseOnPagerHover &&
                        d.hover(
                            function() {
                                (f = !0), u.cyclePause++, o(u, !0, !0);
                            },
                            function() {
                                f && u.cyclePause--, o(u, !0, !0);
                            }
                        );
                }
            }),
            (t.fn.cycle.hopsFromLast = function(t, e) {
                var i = t.lastSlide,
                    s = t.currSlide;
                return e
                    ? s > i
                        ? s - i
                        : t.slideCount - i
                    : i > s
                    ? i - s
                    : i + t.slideCount - s;
            }),
            (t.fn.cycle.commonReset = function(e, i, s, o, n, r) {
                t(s.elements)
                    .not(e)
                    .hide(),
                    void 0 === s.cssBefore.opacity && (s.cssBefore.opacity = 1),
                    (s.cssBefore.display = "block"),
                    s.slideResize &&
                        !1 !== o &&
                        i.cycleW > 0 &&
                        (s.cssBefore.width = i.cycleW),
                    s.slideResize &&
                        !1 !== n &&
                        i.cycleH > 0 &&
                        (s.cssBefore.height = i.cycleH),
                    (s.cssAfter = s.cssAfter || {}),
                    (s.cssAfter.display = "none"),
                    t(e).css("zIndex", s.slideCount + (!0 === r ? 1 : 0)),
                    t(i).css("zIndex", s.slideCount + (!0 === r ? 0 : 1));
            }),
            (t.fn.cycle.custom = function(e, i, s, o, n, r) {
                var a = t(e),
                    l = t(i),
                    c = s.speedIn,
                    d = s.speedOut,
                    h = s.easeIn,
                    p = s.easeOut;
                l.css(s.cssBefore),
                    r &&
                        ((c = d = "number" == typeof r ? r : 1),
                        (h = p = null));
                var u = function() {
                    l.animate(s.animIn, c, h, function() {
                        o();
                    });
                };
                a.animate(s.animOut, d, p, function() {
                    a.css(s.cssAfter), s.sync || u();
                }),
                    s.sync && u();
            }),
            (t.fn.cycle.transitions = {
                fade: function(e, i, s) {
                    i.not(":eq(" + s.currSlide + ")").css("opacity", 0),
                        s.before.push(function(e, i, s) {
                            t.fn.cycle.commonReset(e, i, s),
                                (s.cssBefore.opacity = 0);
                        }),
                        (s.animIn = { opacity: 1 }),
                        (s.animOut = { opacity: 0 }),
                        (s.cssBefore = { top: 0, left: 0 });
                }
            }),
            (t.fn.cycle.ver = function() {
                return "2.9998";
            }),
            (t.fn.cycle.defaults = {
                activePagerClass: "activeSlide",
                after: null,
                allowPagerClickBubble: !1,
                animIn: null,
                animOut: null,
                aspect: !1,
                autostop: 0,
                autostopCount: 0,
                backwards: !1,
                before: null,
                center: null,
                cleartype: !t.support.opacity,
                cleartypeNoBg: !1,
                containerResize: 1,
                continuous: 0,
                cssAfter: null,
                cssBefore: null,
                delay: 0,
                easeIn: null,
                easeOut: null,
                easing: null,
                end: null,
                fastOnEvent: 0,
                fit: 0,
                fx: "fade",
                fxFn: null,
                height: "auto",
                manualTrump: !0,
                metaAttr: "cycle",
                next: null,
                nowrap: 0,
                onPagerEvent: null,
                onPrevNextEvent: null,
                pager: null,
                pagerAnchorBuilder: null,
                pagerEvent: "click.cycle",
                pause: 0,
                pauseOnPagerHover: 0,
                prev: null,
                prevNextEvent: "click.cycle",
                random: 0,
                randomizeEffects: 1,
                requeueOnImageNotLoaded: !0,
                requeueTimeout: 250,
                rev: 0,
                shuffle: null,
                skipInitializationCallbacks: !1,
                slideExpr: null,
                slideResize: 1,
                speed: 1e3,
                speedIn: null,
                speedOut: null,
                startingSlide: 0,
                sync: 1,
                timeout: 4e3,
                timeoutFn: null,
                updateActivePagerLink: null,
                width: null
            });
    })(jQuery),
    (function(t) {
        (t.fn.cycle.transitions.none = function(e, i, s) {
            s.fxFn = function(e, i, s, o) {
                t(i).show(), t(e).hide(), o();
            };
        }),
            (t.fn.cycle.transitions.fadeout = function(e, i, s) {
                i
                    .not(":eq(" + s.currSlide + ")")
                    .css({ display: "block", opacity: 1 }),
                    s.before.push(function(e, i, s, o, n, r) {
                        t(e).css("zIndex", s.slideCount + (1 == !r ? 1 : 0)),
                            t(i).css(
                                "zIndex",
                                s.slideCount + (1 == !r ? 0 : 1)
                            );
                    }),
                    (s.animIn.opacity = 1),
                    (s.animOut.opacity = 0),
                    (s.cssBefore.opacity = 1),
                    (s.cssBefore.display = "block"),
                    (s.cssAfter.zIndex = 0);
            }),
            (t.fn.cycle.transitions.scrollUp = function(e, i, s) {
                e.css("overflow", "hidden"),
                    s.before.push(t.fn.cycle.commonReset);
                var o = e.height();
                (s.cssBefore.top = o),
                    (s.cssBefore.left = 0),
                    (s.cssFirst.top = 0),
                    (s.animIn.top = 0),
                    (s.animOut.top = -o);
            }),
            (t.fn.cycle.transitions.scrollDown = function(e, i, s) {
                e.css("overflow", "hidden"),
                    s.before.push(t.fn.cycle.commonReset);
                var o = e.height();
                (s.cssFirst.top = 0),
                    (s.cssBefore.top = -o),
                    (s.cssBefore.left = 0),
                    (s.animIn.top = 0),
                    (s.animOut.top = o);
            }),
            (t.fn.cycle.transitions.scrollLeft = function(e, i, s) {
                e.css("overflow", "hidden"),
                    s.before.push(t.fn.cycle.commonReset);
                var o = e.width();
                (s.cssFirst.left = 0),
                    (s.cssBefore.left = o),
                    (s.cssBefore.top = 0),
                    (s.animIn.left = 0),
                    (s.animOut.left = 0 - o);
            }),
            (t.fn.cycle.transitions.scrollRight = function(e, i, s) {
                e.css("overflow", "hidden"),
                    s.before.push(t.fn.cycle.commonReset);
                var o = e.width();
                (s.cssFirst.left = 0),
                    (s.cssBefore.left = -o),
                    (s.cssBefore.top = 0),
                    (s.animIn.left = 0),
                    (s.animOut.left = o);
            }),
            (t.fn.cycle.transitions.scrollHorz = function(e, i, s) {
                e.css("overflow", "hidden").width(),
                    s.before.push(function(e, i, s, o) {
                        s.rev && (o = !o),
                            t.fn.cycle.commonReset(e, i, s),
                            (s.cssBefore.left = o
                                ? i.cycleW - 1
                                : 1 - i.cycleW),
                            (s.animOut.left = o ? -e.cycleW : e.cycleW);
                    }),
                    (s.cssFirst.left = 0),
                    (s.cssBefore.top = 0),
                    (s.animIn.left = 0),
                    (s.animOut.top = 0);
            }),
            (t.fn.cycle.transitions.scrollVert = function(e, i, s) {
                e.css("overflow", "hidden"),
                    s.before.push(function(e, i, s, o) {
                        s.rev && (o = !o),
                            t.fn.cycle.commonReset(e, i, s),
                            (s.cssBefore.top = o ? 1 - i.cycleH : i.cycleH - 1),
                            (s.animOut.top = o ? e.cycleH : -e.cycleH);
                    }),
                    (s.cssFirst.top = 0),
                    (s.cssBefore.left = 0),
                    (s.animIn.top = 0),
                    (s.animOut.left = 0);
            }),
            (t.fn.cycle.transitions.slideX = function(e, i, s) {
                s.before.push(function(e, i, s) {
                    t(s.elements)
                        .not(e)
                        .hide(),
                        t.fn.cycle.commonReset(e, i, s, !1, !0),
                        (s.animIn.width = i.cycleW);
                }),
                    (s.cssBefore.left = 0),
                    (s.cssBefore.top = 0),
                    (s.cssBefore.width = 0),
                    (s.animIn.width = "show"),
                    (s.animOut.width = 0);
            }),
            (t.fn.cycle.transitions.slideY = function(e, i, s) {
                s.before.push(function(e, i, s) {
                    t(s.elements)
                        .not(e)
                        .hide(),
                        t.fn.cycle.commonReset(e, i, s, !0, !1),
                        (s.animIn.height = i.cycleH);
                }),
                    (s.cssBefore.left = 0),
                    (s.cssBefore.top = 0),
                    (s.cssBefore.height = 0),
                    (s.animIn.height = "show"),
                    (s.animOut.height = 0);
            }),
            (t.fn.cycle.transitions.shuffle = function(e, i, s) {
                var o,
                    n = e.css("overflow", "visible").width();
                for (
                    i.css({ left: 0, top: 0 }),
                        s.before.push(function(e, i, s) {
                            t.fn.cycle.commonReset(e, i, s, !0, !0, !0);
                        }),
                        s.speedAdjusted ||
                            ((s.speed = s.speed / 2), (s.speedAdjusted = !0)),
                        s.random = 0,
                        s.shuffle = s.shuffle || { left: -n, top: 15 },
                        s.els = [],
                        o = 0;
                    o < i.length;
                    o++
                )
                    s.els.push(i[o]);
                for (o = 0; o < s.currSlide; o++) s.els.push(s.els.shift());
                (s.fxFn = function(e, i, s, o, n) {
                    s.rev && (n = !n);
                    var r = t(n ? e : i);
                    t(i).css(s.cssBefore);
                    var a = s.slideCount;
                    r.animate(s.shuffle, s.speedIn, s.easeIn, function() {
                        for (
                            var i = t.fn.cycle.hopsFromLast(s, n), l = 0;
                            i > l;
                            l++
                        )
                            n
                                ? s.els.push(s.els.shift())
                                : s.els.unshift(s.els.pop());
                        if (n)
                            for (var c = 0, d = s.els.length; d > c; c++)
                                t(s.els[c]).css("z-index", d - c + a);
                        else {
                            var h = t(e).css("z-index");
                            r.css("z-index", parseInt(h, 10) + 1 + a);
                        }
                        r.animate(
                            { left: 0, top: 0 },
                            s.speedOut,
                            s.easeOut,
                            function() {
                                t(n ? this : e).hide(), o && o();
                            }
                        );
                    });
                }),
                    t.extend(s.cssBefore, {
                        display: "block",
                        opacity: 1,
                        top: 0,
                        left: 0
                    });
            }),
            (t.fn.cycle.transitions.turnUp = function(e, i, s) {
                s.before.push(function(e, i, s) {
                    t.fn.cycle.commonReset(e, i, s, !0, !1),
                        (s.cssBefore.top = i.cycleH),
                        (s.animIn.height = i.cycleH),
                        (s.animOut.width = i.cycleW);
                }),
                    (s.cssFirst.top = 0),
                    (s.cssBefore.left = 0),
                    (s.cssBefore.height = 0),
                    (s.animIn.top = 0),
                    (s.animOut.height = 0);
            }),
            (t.fn.cycle.transitions.turnDown = function(e, i, s) {
                s.before.push(function(e, i, s) {
                    t.fn.cycle.commonReset(e, i, s, !0, !1),
                        (s.animIn.height = i.cycleH),
                        (s.animOut.top = e.cycleH);
                }),
                    (s.cssFirst.top = 0),
                    (s.cssBefore.left = 0),
                    (s.cssBefore.top = 0),
                    (s.cssBefore.height = 0),
                    (s.animOut.height = 0);
            }),
            (t.fn.cycle.transitions.turnLeft = function(e, i, s) {
                s.before.push(function(e, i, s) {
                    t.fn.cycle.commonReset(e, i, s, !1, !0),
                        (s.cssBefore.left = i.cycleW),
                        (s.animIn.width = i.cycleW);
                }),
                    (s.cssBefore.top = 0),
                    (s.cssBefore.width = 0),
                    (s.animIn.left = 0),
                    (s.animOut.width = 0);
            }),
            (t.fn.cycle.transitions.turnRight = function(e, i, s) {
                s.before.push(function(e, i, s) {
                    t.fn.cycle.commonReset(e, i, s, !1, !0),
                        (s.animIn.width = i.cycleW),
                        (s.animOut.left = e.cycleW);
                }),
                    t.extend(s.cssBefore, { top: 0, left: 0, width: 0 }),
                    (s.animIn.left = 0),
                    (s.animOut.width = 0);
            }),
            (t.fn.cycle.transitions.zoom = function(e, i, s) {
                s.before.push(function(e, i, s) {
                    t.fn.cycle.commonReset(e, i, s, !1, !1, !0),
                        (s.cssBefore.top = i.cycleH / 2),
                        (s.cssBefore.left = i.cycleW / 2),
                        t.extend(s.animIn, {
                            top: 0,
                            left: 0,
                            width: i.cycleW,
                            height: i.cycleH
                        }),
                        t.extend(s.animOut, {
                            width: 0,
                            height: 0,
                            top: e.cycleH / 2,
                            left: e.cycleW / 2
                        });
                }),
                    (s.cssFirst.top = 0),
                    (s.cssFirst.left = 0),
                    (s.cssBefore.width = 0),
                    (s.cssBefore.height = 0);
            }),
            (t.fn.cycle.transitions.fadeZoom = function(e, i, s) {
                s.before.push(function(e, i, s) {
                    t.fn.cycle.commonReset(e, i, s, !1, !1),
                        (s.cssBefore.left = i.cycleW / 2),
                        (s.cssBefore.top = i.cycleH / 2),
                        t.extend(s.animIn, {
                            top: 0,
                            left: 0,
                            width: i.cycleW,
                            height: i.cycleH
                        });
                }),
                    (s.cssBefore.width = 0),
                    (s.cssBefore.height = 0),
                    (s.animOut.opacity = 0);
            }),
            (t.fn.cycle.transitions.blindX = function(e, i, s) {
                var o = e.css("overflow", "hidden").width();
                s.before.push(function(e, i, s) {
                    t.fn.cycle.commonReset(e, i, s),
                        (s.animIn.width = i.cycleW),
                        (s.animOut.left = e.cycleW);
                }),
                    (s.cssBefore.left = o),
                    (s.cssBefore.top = 0),
                    (s.animIn.left = 0),
                    (s.animOut.left = o);
            }),
            (t.fn.cycle.transitions.blindY = function(e, i, s) {
                var o = e.css("overflow", "hidden").height();
                s.before.push(function(e, i, s) {
                    t.fn.cycle.commonReset(e, i, s),
                        (s.animIn.height = i.cycleH),
                        (s.animOut.top = e.cycleH);
                }),
                    (s.cssBefore.top = o),
                    (s.cssBefore.left = 0),
                    (s.animIn.top = 0),
                    (s.animOut.top = o);
            }),
            (t.fn.cycle.transitions.blindZ = function(e, i, s) {
                var o = e.css("overflow", "hidden").height(),
                    n = e.width();
                s.before.push(function(e, i, s) {
                    t.fn.cycle.commonReset(e, i, s),
                        (s.animIn.height = i.cycleH),
                        (s.animOut.top = e.cycleH);
                }),
                    (s.cssBefore.top = o),
                    (s.cssBefore.left = n),
                    (s.animIn.top = 0),
                    (s.animIn.left = 0),
                    (s.animOut.top = o),
                    (s.animOut.left = n);
            }),
            (t.fn.cycle.transitions.growX = function(e, i, s) {
                s.before.push(function(e, i, s) {
                    t.fn.cycle.commonReset(e, i, s, !1, !0),
                        (s.cssBefore.left = this.cycleW / 2),
                        (s.animIn.left = 0),
                        (s.animIn.width = this.cycleW),
                        (s.animOut.left = 0);
                }),
                    (s.cssBefore.top = 0),
                    (s.cssBefore.width = 0);
            }),
            (t.fn.cycle.transitions.growY = function(e, i, s) {
                s.before.push(function(e, i, s) {
                    t.fn.cycle.commonReset(e, i, s, !0, !1),
                        (s.cssBefore.top = this.cycleH / 2),
                        (s.animIn.top = 0),
                        (s.animIn.height = this.cycleH),
                        (s.animOut.top = 0);
                }),
                    (s.cssBefore.height = 0),
                    (s.cssBefore.left = 0);
            }),
            (t.fn.cycle.transitions.curtainX = function(e, i, s) {
                s.before.push(function(e, i, s) {
                    t.fn.cycle.commonReset(e, i, s, !1, !0, !0),
                        (s.cssBefore.left = i.cycleW / 2),
                        (s.animIn.left = 0),
                        (s.animIn.width = this.cycleW),
                        (s.animOut.left = e.cycleW / 2),
                        (s.animOut.width = 0);
                }),
                    (s.cssBefore.top = 0),
                    (s.cssBefore.width = 0);
            }),
            (t.fn.cycle.transitions.curtainY = function(e, i, s) {
                s.before.push(function(e, i, s) {
                    t.fn.cycle.commonReset(e, i, s, !0, !1, !0),
                        (s.cssBefore.top = i.cycleH / 2),
                        (s.animIn.top = 0),
                        (s.animIn.height = i.cycleH),
                        (s.animOut.top = e.cycleH / 2),
                        (s.animOut.height = 0);
                }),
                    (s.cssBefore.height = 0),
                    (s.cssBefore.left = 0);
            }),
            (t.fn.cycle.transitions.cover = function(e, i, s) {
                var o = s.direction || "left",
                    n = e.css("overflow", "hidden").width(),
                    r = e.height();
                s.before.push(function(e, i, s) {
                    t.fn.cycle.commonReset(e, i, s),
                        "right" == o
                            ? (s.cssBefore.left = -n)
                            : "up" == o
                            ? (s.cssBefore.top = r)
                            : "down" == o
                            ? (s.cssBefore.top = -r)
                            : (s.cssBefore.left = n);
                }),
                    (s.animIn.left = 0),
                    (s.animIn.top = 0),
                    (s.cssBefore.top = 0),
                    (s.cssBefore.left = 0);
            }),
            (t.fn.cycle.transitions.uncover = function(e, i, s) {
                var o = s.direction || "left",
                    n = e.css("overflow", "hidden").width(),
                    r = e.height();
                s.before.push(function(e, i, s) {
                    t.fn.cycle.commonReset(e, i, s, !0, !0, !0),
                        "right" == o
                            ? (s.animOut.left = n)
                            : "up" == o
                            ? (s.animOut.top = -r)
                            : "down" == o
                            ? (s.animOut.top = r)
                            : (s.animOut.left = -n);
                }),
                    (s.animIn.left = 0),
                    (s.animIn.top = 0),
                    (s.cssBefore.top = 0),
                    (s.cssBefore.left = 0);
            }),
            (t.fn.cycle.transitions.toss = function(e, i, s) {
                var o = e.css("overflow", "visible").width(),
                    n = e.height();
                s.before.push(function(e, i, s) {
                    t.fn.cycle.commonReset(e, i, s, !0, !0, !0),
                        s.animOut.left || s.animOut.top
                            ? (s.animOut.opacity = 0)
                            : t.extend(s.animOut, {
                                  left: 2 * o,
                                  top: -n / 2,
                                  opacity: 0
                              });
                }),
                    (s.cssBefore.left = 0),
                    (s.cssBefore.top = 0),
                    (s.animIn.left = 0);
            }),
            (t.fn.cycle.transitions.wipe = function(e, i, s) {
                var o,
                    n = e.css("overflow", "hidden").width(),
                    r = e.height();
                if (((s.cssBefore = s.cssBefore || {}), s.clip))
                    if (/l2r/.test(s.clip)) o = "rect(0px 0px " + r + "px 0px)";
                    else if (/r2l/.test(s.clip))
                        o = "rect(0px " + n + "px " + r + "px " + n + "px)";
                    else if (/t2b/.test(s.clip))
                        o = "rect(0px " + n + "px 0px 0px)";
                    else if (/b2t/.test(s.clip))
                        o = "rect(" + r + "px " + n + "px " + r + "px 0px)";
                    else if (/zoom/.test(s.clip)) {
                        var a = parseInt(r / 2, 10),
                            l = parseInt(n / 2, 10);
                        o =
                            "rect(" +
                            a +
                            "px " +
                            l +
                            "px " +
                            a +
                            "px " +
                            l +
                            "px)";
                    }
                s.cssBefore.clip =
                    s.cssBefore.clip || o || "rect(0px 0px 0px 0px)";
                var c = s.cssBefore.clip.match(/(\d+)/g),
                    d = parseInt(c[0], 10),
                    h = parseInt(c[1], 10),
                    p = parseInt(c[2], 10),
                    u = parseInt(c[3], 10);
                s.before.push(function(e, i, s) {
                    if (e != i) {
                        var o = t(e),
                            a = t(i);
                        t.fn.cycle.commonReset(e, i, s, !0, !0, !1),
                            (s.cssAfter.display = "block");
                        var l = 1,
                            c = parseInt(s.speedIn / 13, 10) - 1;
                        !(function t() {
                            var e = d ? d - parseInt(l * (d / c), 10) : 0,
                                i = u ? u - parseInt(l * (u / c), 10) : 0,
                                s =
                                    r > p
                                        ? p +
                                          parseInt(l * ((r - p) / c || 1), 10)
                                        : r,
                                f =
                                    n > h
                                        ? h +
                                          parseInt(l * ((n - h) / c || 1), 10)
                                        : n;
                            a.css({
                                clip:
                                    "rect(" +
                                    e +
                                    "px " +
                                    f +
                                    "px " +
                                    s +
                                    "px " +
                                    i +
                                    "px)"
                            }),
                                l++ <= c
                                    ? setTimeout(t, 13)
                                    : o.css("display", "none");
                        })();
                    }
                }),
                    t.extend(s.cssBefore, {
                        display: "block",
                        opacity: 1,
                        top: 0,
                        left: 0
                    }),
                    (s.animIn = { left: 0 }),
                    (s.animOut = { left: 0 });
            });
    })(jQuery),
    (function(t) {
        "use strict";
        (t.fn.maximage = function(e, i) {
            function s(t) {
                window.console && window.console.log && window.console.log(t);
            }
            var o;
            ("object" == typeof e || void 0 === e) &&
                (o = t.extend(t.fn.maximage.defaults, e || {})),
                "string" == typeof e && (o = t.fn.maximage.defaults),
                (t.Body = t("body")),
                (t.Window = t(window)),
                (t.Scroll = t("html, body")),
                (t.Events = { RESIZE: "resize" }),
                this.each(function() {
                    var i = t(this),
                        n = 0,
                        r = [],
                        a = {
                            setup: function() {
                                if (t.Slides.length > 0) {
                                    var e,
                                        s = t.Slides.length;
                                    for (e = 0; s > e; e++) {
                                        var o = t.Slides[e];
                                        i.append(
                                            '<div class="mc-image ' +
                                                o.theclass +
                                                '" title="' +
                                                o.alt +
                                                '" style="background-image:url(\'' +
                                                o.url +
                                                "');" +
                                                o.style +
                                                '" data-href="' +
                                                o.datahref +
                                                '">' +
                                                o.content +
                                                "</div>"
                                        );
                                    }
                                    a.preload(0), a.resize();
                                }
                            },
                            preload: function(e) {
                                var s = t("<img/>");
                                s.on("load", function() {
                                    0 == n &&
                                        (c.setup(), o.onFirstImageLoaded()),
                                        n == t.Slides.length - 1
                                            ? o.onImagesLoaded(i)
                                            : (n++, a.preload(n));
                                }),
                                    (s[0].src = t.Slides[e].url),
                                    r.push(s[0]);
                            },
                            resize: function() {
                                t.Window.bind(t.Events.RESIZE, function() {
                                    t.Scroll.addClass("mc-hide-scrolls"),
                                        t.Window.data("h", h.sizes().h).data(
                                            "w",
                                            h.sizes().w
                                        ),
                                        i
                                            .height(t.Window.data("h"))
                                            .width(t.Window.data("w"))
                                            .children()
                                            .height(t.Window.data("h"))
                                            .width(t.Window.data("w")),
                                        i.children().each(function() {
                                            (this.cycleH = t.Window.data("h")),
                                                (this.cycleW = t.Window.data(
                                                    "w"
                                                ));
                                        }),
                                        t(t.Scroll).removeClass(
                                            "mc-hide-scrolls"
                                        );
                                });
                            }
                        },
                        l = {
                            setup: function() {
                                var e,
                                    s,
                                    n,
                                    r = t.Slides.length;
                                if (
                                    (t.BrowserTests.msie &&
                                        !o.overrideMSIEStop &&
                                        document.execCommand("Stop", !1),
                                    i.html(""),
                                    t.Body.addClass("mc-old-browser"),
                                    t.Slides.length > 0)
                                ) {
                                    for (
                                        t.Scroll.addClass("mc-hide-scrolls"),
                                            t.Window.data(
                                                "h",
                                                h.sizes().h
                                            ).data("w", h.sizes().w),
                                            t("body").append(
                                                t("<div></div>")
                                                    .attr("class", "mc-loader")
                                                    .css({
                                                        position: "absolute",
                                                        left: "-9999px"
                                                    })
                                            ),
                                            n = 0;
                                        r > n;
                                        n++
                                    )
                                        (e =
                                            0 == t.Slides[n].content.length
                                                ? '<img src="' +
                                                  t.Slides[n].url +
                                                  '" />'
                                                : t.Slides[n].content),
                                            (s = t("<div>" + e + "</div>").attr(
                                                "class",
                                                "mc-image mc-image-n" +
                                                    n +
                                                    " " +
                                                    t.Slides[n].theclass
                                            )),
                                            i.append(s),
                                            0 ==
                                                t(".mc-image-n" + n).children(
                                                    "img"
                                                ).length ||
                                                t("div.mc-loader").append(
                                                    t(".mc-image-n" + n)
                                                        .children("img")
                                                        .first()
                                                        .clone()
                                                        .addClass("not-loaded")
                                                );
                                    l.preload(), l.windowResize();
                                }
                            },
                            preload: function() {
                                var e = setInterval(function() {
                                    t(".mc-loader")
                                        .children("img")
                                        .each(function(e) {
                                            var i = t(this);
                                            i.hasClass("not-loaded") &&
                                                i.height() > 0 &&
                                                (t(this).removeClass(
                                                    "not-loaded"
                                                ),
                                                t("div.mc-image-n" + e)
                                                    .children("img")
                                                    .first()
                                                    .data("h", i.height())
                                                    .data("w", i.width())
                                                    .data(
                                                        "ar",
                                                        i.width() / i.height()
                                                    ),
                                                l.onceLoaded(e));
                                        }),
                                        0 == t(".not-loaded").length &&
                                            (t(".mc-loader").remove(),
                                            clearInterval(e));
                                }, 1e3);
                            },
                            onceLoaded: function(e) {
                                l.maximage(e),
                                    0 == e
                                        ? (i.css({ visibility: "visible" }),
                                          o.onFirstImageLoaded())
                                        : e == t.Slides.length - 1 &&
                                          (c.setup(),
                                          t(t.Scroll).removeClass(
                                              "mc-hide-scrolls"
                                          ),
                                          o.onImagesLoaded(i),
                                          o.debug &&
                                              (s(" - Final Maximage - "),
                                              s(i)));
                            },
                            maximage: function(e) {
                                t("div.mc-image-n" + e)
                                    .height(t.Window.data("h"))
                                    .width(t.Window.data("w"))
                                    .children("img")
                                    .first()
                                    .each(function() {
                                        d.maxcover(t(this));
                                    });
                            },
                            windowResize: function() {
                                t.Window.bind(t.Events.RESIZE, function() {
                                    clearTimeout(this.id),
                                        t(".mc-image").length >= 1 &&
                                            (this.id = setTimeout(
                                                l.doneResizing,
                                                200
                                            ));
                                });
                            },
                            doneResizing: function() {
                                t(t.Scroll).addClass("mc-hide-scrolls"),
                                    t.Window.data("h", h.sizes().h).data(
                                        "w",
                                        h.sizes().w
                                    ),
                                    i
                                        .height(t.Window.data("h"))
                                        .width(t.Window.data("w")),
                                    i.find(".mc-image").each(function(t) {
                                        l.maximage(t);
                                    });
                                var e = i.data("cycle.opts");
                                null != e &&
                                    ((e.height = t.Window.data("h")),
                                    (e.width = t.Window.data("w")),
                                    jQuery.each(e.elements, function(e, i) {
                                        (i.cycleW = t.Window.data("w")),
                                            (i.cycleH = t.Window.data("h"));
                                    })),
                                    t(t.Scroll).removeClass("mc-hide-scrolls");
                            }
                        },
                        c = {
                            setup: function() {
                                i.addClass("mc-cycle"),
                                    t.Window.data("h", h.sizes().h).data(
                                        "w",
                                        h.sizes().w
                                    ),
                                    (jQuery.easing.easeForCSSTransition = function(
                                        t,
                                        e,
                                        i,
                                        s,
                                        o,
                                        n
                                    ) {
                                        return i + s;
                                    });
                                var e = t.extend(
                                    {
                                        fit: 1,
                                        containerResize: 0,
                                        height: t.Window.data("h"),
                                        width: t.Window.data("w"),
                                        slideResize: !1,
                                        easing:
                                            t.BrowserTests.cssTransitions &&
                                            o.cssTransitions
                                                ? "easeForCSSTransition"
                                                : "swing"
                                    },
                                    o.cycleOptions
                                );
                                i.cycle(e);
                            }
                        },
                        d = {
                            center: function(e) {
                                o.verticalCenter &&
                                    e.css({
                                        marginTop:
                                            ((e.height() - t.Window.data("h")) /
                                                2) *
                                            -1
                                    }),
                                    o.horizontalCenter &&
                                        e.css({
                                            marginLeft:
                                                ((e.width() -
                                                    t.Window.data("w")) /
                                                    2) *
                                                -1
                                        });
                            },
                            fill: function(e) {
                                var i = e.is("object") ? e.parent().first() : e;
                                "function" == typeof o.backgroundSize
                                    ? o.backgroundSize(e)
                                    : "cover" == o.backgroundSize
                                    ? t.Window.data("w") / t.Window.data("h") <
                                      i.data("ar")
                                        ? e
                                              .height(t.Window.data("h"))
                                              .width(
                                                  (
                                                      t.Window.data("h") *
                                                      i.data("ar")
                                                  ).toFixed(0)
                                              )
                                        : e
                                              .height(
                                                  (
                                                      t.Window.data("w") /
                                                      i.data("ar")
                                                  ).toFixed(0)
                                              )
                                              .width(t.Window.data("w"))
                                    : "contain" == o.backgroundSize
                                    ? t.Window.data("w") / t.Window.data("h") <
                                      i.data("ar")
                                        ? e
                                              .height(
                                                  (
                                                      t.Window.data("w") /
                                                      i.data("ar")
                                                  ).toFixed(0)
                                              )
                                              .width(t.Window.data("w"))
                                        : e
                                              .height(t.Window.data("h"))
                                              .width(
                                                  (
                                                      t.Window.data("h") *
                                                      i.data("ar")
                                                  ).toFixed(0)
                                              )
                                    : s(
                                          "The backgroundSize option was not recognized for older browsers."
                                      );
                            },
                            maxcover: function(t) {
                                d.fill(t), d.center(t);
                            },
                            maxcontain: function(t) {
                                d.fill(t), d.center(t);
                            }
                        },
                        h = {
                            browser_tests: function() {
                                var e = t("<div />")[0],
                                    i = ["Moz", "Webkit", "Khtml", "O", "ms"],
                                    n = "transition",
                                    r = {
                                        cssTransitions: !1,
                                        cssBackgroundSize:
                                            "backgroundSize" in e.style &&
                                            o.cssBackgroundSize,
                                        html5Video: !1,
                                        msie: !1
                                    };
                                if (o.cssTransitions) {
                                    "string" == typeof e.style[n] &&
                                        (r.cssTransitions = !0),
                                        (n =
                                            n.charAt(0).toUpperCase() +
                                            n.substr(1));
                                    for (var a = 0; a < i.length; a++)
                                        i[a] + n in e.style &&
                                            (r.cssTransitions = !0);
                                }
                                return (
                                    document.createElement("video")
                                        .canPlayType && (r.html5Video = !0),
                                    (r.msie = void 0 !== h.msie()),
                                    o.debug && (s(" - Browser Test - "), s(r)),
                                    r
                                );
                            },
                            construct_slide_object: function() {
                                var e = new Object(),
                                    n = new Array();
                                return (
                                    i.children().each(function(i) {
                                        var s = t(this).is("img")
                                            ? t(this).clone()
                                            : t(this)
                                                  .find("img")
                                                  .first()
                                                  .clone();
                                        ((e = {}).url = s.attr("src")),
                                            (e.title =
                                                null != s.attr("title")
                                                    ? s.attr("title")
                                                    : ""),
                                            (e.alt =
                                                null != s.attr("alt")
                                                    ? s.attr("alt")
                                                    : ""),
                                            (e.theclass =
                                                null != s.attr("class")
                                                    ? s.attr("class")
                                                    : ""),
                                            (e.styles =
                                                null != s.attr("style")
                                                    ? s.attr("style")
                                                    : ""),
                                            (e.orig = s.clone()),
                                            (e.datahref =
                                                null != s.attr("data-href")
                                                    ? s.attr("data-href")
                                                    : ""),
                                            (e.content = ""),
                                            t(this).find("img").length > 0 &&
                                                (t.BrowserTests
                                                    .cssBackgroundSize &&
                                                    t(this)
                                                        .find("img")
                                                        .first()
                                                        .remove(),
                                                (e.content = t(this).html())),
                                            (s[0].src = ""),
                                            t.BrowserTests.cssBackgroundSize &&
                                                t(this).remove(),
                                            n.push(e);
                                    }),
                                    o.debug && (s(" - Slide Object - "), s(n)),
                                    n
                                );
                            },
                            msie: function() {
                                for (
                                    var t = 3,
                                        e = document.createElement("div"),
                                        i = e.getElementsByTagName("i");
                                    (e.innerHTML =
                                        "\x3c!--[if gt IE " +
                                        ++t +
                                        "]><i></i><![endif]--\x3e"),
                                        i[0];

                                );
                                return t > 4 ? t : void 0;
                            },
                            sizes: function() {
                                var e = { h: 0, w: 0 };
                                if ("window" == o.fillElement)
                                    (e.h = t.Window.height()),
                                        (e.w = t.Window.width());
                                else {
                                    var s = i.parents(o.fillElement).first();
                                    0 == s.height() ||
                                    1 == s.data("windowHeight")
                                        ? (s.data("windowHeight", !0),
                                          (e.h = t.Window.height()))
                                        : (e.h = s.height()),
                                        0 == s.width() ||
                                        1 == s.data("windowWidth")
                                            ? (s.data("windowWidth", !0),
                                              (e.w = t.Window.width()))
                                            : (e.w = s.width());
                                }
                                return e;
                            }
                        };
                    if (
                        ((t.BrowserTests = h.browser_tests()),
                        "string" == typeof e)
                    ) {
                        if (t.BrowserTests.html5Video || !i.is("video")) {
                            var p,
                                u = i.is("object") ? i.parent().first() : i;
                            t.Body.hasClass("mc-old-browser") ||
                                t.Body.addClass("mc-old-browser"),
                                t.Window.data("h", h.sizes().h).data(
                                    "w",
                                    h.sizes().w
                                ),
                                u
                                    .data("h", i.height())
                                    .data("w", i.width())
                                    .data("ar", i.width() / i.height()),
                                t.Window.bind(t.Events.RESIZE, function() {
                                    t.Window.data("h", h.sizes().h).data(
                                        "w",
                                        h.sizes().w
                                    ),
                                        (p = i.data("resizer")),
                                        clearTimeout(p),
                                        (p = setTimeout(d[e](i), 200)),
                                        i.data("resizer", p);
                                }),
                                d[e](i);
                        }
                    } else (t.Slides = h.construct_slide_object()), t.BrowserTests.cssBackgroundSize ? (o.debug && s(" - Using Modern - "), a.setup()) : (o.debug && s(" - Using Old - "), l.setup());
                });
        }),
            (t.fn.maximage.defaults = {
                debug: !1,
                cssBackgroundSize: !0,
                cssTransitions: !0,
                verticalCenter: !0,
                horizontalCenter: !0,
                scaleInterval: 20,
                backgroundSize: "cover",
                fillElement: "window",
                overrideMSIEStop: !1,
                onFirstImageLoaded: function() {},
                onImagesLoaded: function() {}
            });
    })(jQuery);

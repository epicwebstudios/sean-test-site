tinymce.PluginManager.add("image", function(e) {
    function t(e, t) {
        function n(e, n) {
            r.parentNode && r.parentNode.removeChild(r), t({
                width: e,
                height: n
            })
        }
        var r = document.createElement("img");
        r.onload = function() {
            n(Math.max(r.width, r.clientWidth), Math.max(r.height, r.clientHeight))
        }, r.onerror = function() {
            n()
        };
        var i = r.style;
        i.visibility = "hidden", i.position = "fixed", i.bottom = i.left = 0, i.width = i.height = "auto", document.body.appendChild(r), r.src = e
    }

    function n(e, t, n) {
        function r(e, n) {
            return n = n || [], tinymce.each(e, function(e) {
                var i = {
                    text: e.text || e.title
                };
                e.menu ? i.menu = r(e.menu) : (i.value = e.value, t(i)), n.push(i)
            }), n
        }
        return r(e, n || [])
    }

    function r(t) {
        return function() {
            var n = e.settings.image_list;
            "string" == typeof n ? tinymce.util.XHR.send({
                url: n,
                success: function(e) {
                    t(tinymce.util.JSON.parse(e))
                }
            }) : "function" == typeof n ? n(t) : t(n)
        }
    }

    function i(r) {
        function i() {
            var e, t, n, r;
            e = d.find("#width")[0], t = d.find("#height")[0], e && t && (n = e.value(), r = t.value(), d.find("#constrain")[0].checked() && m && h && n && r && (m != n ? (r = Math.round(n / m * r), isNaN(r) || t.value(r)) : (n = Math.round(r / h * n), isNaN(n) || e.value(n))), m = n, h = r)
        }

        function o() {
            function t(t) {
                function n() {
                    t.onload = t.onerror = null, e.selection && (e.selection.select(t), e.nodeChanged())
                }
                t.onload = function() {
                    y.width || y.height || !x || b.setAttribs(t, {
                        width: t.clientWidth,
                        height: t.clientHeight
                    }), n()
                }, t.onerror = n
            }
            var n, r;
            c(), i(), y = tinymce.extend(y, d.toJSON()), y.alt || (y.alt = ""), y.title || (y.title = ""), "" === y.width && (y.width = null), "" === y.height && (y.height = null), y.style || (y.style = null), y = {
                src: y.src,
                alt: y.alt,
                title: y.title,
                width: y.width,
                height: y.height,
                style: y.style,
                caption: y.caption,
                "class": y["class"]
            }, e.undoManager.transact(function() {
                function i(t) {
                    return e.schema.getTextBlockElements()[t.nodeName]
                }
                if (!y.src) return void(f && (b.remove(f), e.focus(), e.nodeChanged()));
                if ("" === y.title && (y.title = null), f ? b.setAttribs(f, y) : (y.id = "__mcenew", e.focus(), e.selection.setContent(b.createHTML("img", y)), f = b.get("__mcenew"), b.setAttrib(f, "id", null)), e.editorUpload.uploadImagesAuto(), y.caption === !1 && b.is(f.parentNode, "figure.image") && (n = f.parentNode, b.insertAfter(f, n), b.remove(n)), y.caption !== !0) t(f);
                else if (!b.is(f.parentNode, "figure.image")) {
                    r = f, f = f.cloneNode(!0), n = b.create("figure", {
                        "class": "image"
                    }), n.appendChild(f), n.appendChild(b.create("figcaption", {
                        contentEditable: !0
                    }, "Caption")), n.contentEditable = !1;
                    var o = b.getParent(r, i);
                    o ? b.split(o, r, n) : b.replace(n, r), e.selection.select(n)
                }
            })
        }

        function a(e) {
            return e && (e = e.replace(/px$/, "")), e
        }

        function s(n) {
            var r, i, o, a = n.meta || {};
            g && g.value(e.convertURL(this.value(), "src")), tinymce.each(a, function(e, t) {
                d.find("#" + t).value(e)
            }), a.width || a.height || (r = e.convertURL(this.value(), "src"), i = e.settings.image_prepend_url, o = new RegExp("^(?:[a-z]+:)?//", "i"), i && !o.test(r) && r.substring(0, i.length) !== i && (r = i + r), this.value(r), t(e.documentBaseURI.toAbsolute(this.value()), function(e) {
                e.width && e.height && x && (m = e.width, h = e.height, d.find("#width").value(m), d.find("#height").value(h))
            }))
        }

        function l(e) {
            if (e.margin) {
                var t = e.margin.split(" ");
                switch (t.length) {
                    case 1:
                        e["margin-top"] = e["margin-top"] || t[0], e["margin-right"] = e["margin-right"] || t[0], e["margin-bottom"] = e["margin-bottom"] || t[0], e["margin-left"] = e["margin-left"] || t[0];
                        break;
                    case 2:
                        e["margin-top"] = e["margin-top"] || t[0], e["margin-right"] = e["margin-right"] || t[1], e["margin-bottom"] = e["margin-bottom"] || t[0], e["margin-left"] = e["margin-left"] || t[1];
                        break;
                    case 3:
                        e["margin-top"] = e["margin-top"] || t[0], e["margin-right"] = e["margin-right"] || t[1], e["margin-bottom"] = e["margin-bottom"] || t[2], e["margin-left"] = e["margin-left"] || t[1];
                        break;
                    case 4:
                        e["margin-top"] = e["margin-top"] || t[0], e["margin-right"] = e["margin-right"] || t[1], e["margin-bottom"] = e["margin-bottom"] || t[2], e["margin-left"] = e["margin-left"] || t[3]
                }
                delete e.margin
            }
            return e
        }

        function c() {
            function t(e) {
                return e.length > 0 && /^[0-9]+$/.test(e) && (e += "px"), e
            }
            if (e.settings.image_advtab) {
                var n = d.toJSON(),
                    r = b.parseStyle(n.style);
                r = l(r), n.vspace && (r["margin-top"] = r["margin-bottom"] = t(n.vspace)), n.hspace && (r["margin-left"] = r["margin-right"] = t(n.hspace)), n.border && (r["border-width"] = t(n.border)), d.find("#style").value(b.serializeStyle(b.parseStyle(b.serializeStyle(r))))
            }
        }

        function u() {
            if (e.settings.image_advtab) {
                var t = d.toJSON(),
                    n = b.parseStyle(t.style);
                d.find("#vspace").value(""), d.find("#hspace").value(""), n = l(n), (n["margin-top"] && n["margin-bottom"] || n["margin-right"] && n["margin-left"]) && (n["margin-top"] === n["margin-bottom"] ? d.find("#vspace").value(a(n["margin-top"])) : d.find("#vspace").value(""), n["margin-right"] === n["margin-left"] ? d.find("#hspace").value(a(n["margin-right"])) : d.find("#hspace").value("")), n["border-width"] && d.find("#border").value(a(n["border-width"])), d.find("#style").value(b.serializeStyle(b.parseStyle(b.serializeStyle(n))))
            }
        }
        var d, f, p, m, h, g, v, y = {},
            b = e.dom,
            x = e.settings.image_dimensions !== !1;
        f = e.selection.getNode(), p = b.getParent(f, "figure.image"), p && (f = b.select("img", p)[0]), f && ("IMG" != f.nodeName || f.getAttribute("data-mce-object") || f.getAttribute("data-mce-placeholder")) && (f = null), f && (m = b.getAttrib(f, "width"), h = b.getAttrib(f, "height"), y = {
            src: b.getAttrib(f, "src"),
            alt: b.getAttrib(f, "alt"),
            title: b.getAttrib(f, "title"),
            "class": b.getAttrib(f, "class"),
            width: m,
            height: h,
            caption: !!p
        }), r && (g = {
            type: "listbox",
            label: "Image list",
            values: n(r, function(t) {
                t.value = e.convertURL(t.value || t.url, "src")
            }, [{
                text: "None",
                value: ""
            }]),
            value: y.src && e.convertURL(y.src, "src"),
            onselect: function(e) {
                var t = d.find("#alt");
                (!t.value() || e.lastControl && t.value() == e.lastControl.text()) && t.value(e.control.text()), d.find("#src").value(e.control.value()).fire("change")
            },
            onPostRender: function() {
                g = this
            }
        }), e.settings.image_class_list && (v = {
            name: "class",
            type: "listbox",
            label: "Class",
            values: n(e.settings.image_class_list, function(t) {
                t.value && (t.textStyle = function() {
                    return e.formatter.getCssText({
                        inline: "img",
                        classes: [t.value]
                    })
                })
            })
        });
        var C = [{
            name: "src",
            type: "filepicker",
            filetype: "image",
            label: "Source",
            autofocus: !0,
            onchange: s
        }, g];
        e.settings.image_description !== !1 && C.push({
            name: "alt",
            type: "textbox",
            label: "Image description"
        }), e.settings.image_title && C.push({
            name: "title",
            type: "textbox",
            label: "Image Title"
        }), x && C.push({
            type: "container",
            label: "Dimensions",
            layout: "flex",
            direction: "row",
            align: "center",
            spacing: 5,
            items: [{
                name: "width",
                type: "textbox",
                maxLength: 5,
                size: 3,
                onchange: i,
                ariaLabel: "Width"
            }, {
                type: "label",
                text: "x"
            }, {
                name: "height",
                type: "textbox",
                maxLength: 5,
                size: 3,
                onchange: i,
                ariaLabel: "Height"
            }, {
                name: "constrain",
                type: "checkbox",
                checked: !0,
                text: "Constrain proportions"
            }]
        }), C.push(v), e.settings.image_caption && tinymce.Env.ceFalse && C.push({
            name: "caption",
            type: "checkbox",
            label: "Caption"
        }), e.settings.image_advtab ? (f && (f.style.marginLeft && f.style.marginRight && f.style.marginLeft === f.style.marginRight && (y.hspace = a(f.style.marginLeft)), f.style.marginTop && f.style.marginBottom && f.style.marginTop === f.style.marginBottom && (y.vspace = a(f.style.marginTop)), f.style.borderWidth && (y.border = a(f.style.borderWidth)), y.style = e.dom.serializeStyle(e.dom.parseStyle(e.dom.getAttrib(f, "style")))), d = e.windowManager.open({
            title: "Insert/edit image",
            data: y,
            bodyType: "tabpanel",
            body: [{
                title: "General",
                type: "form",
                items: C
            }, {
                title: "Advanced",
                type: "form",
                pack: "start",
                items: [{
                    label: "Style",
                    name: "style",
                    type: "textbox",
                    onchange: u
                }, {
                    type: "form",
                    layout: "grid",
                    packV: "start",
                    columns: 2,
                    padding: 0,
                    alignH: ["left", "right"],
                    defaults: {
                        type: "textbox",
                        maxWidth: 50,
                        onchange: c
                    },
                    items: [{
                        label: "Vertical space",
                        name: "vspace"
                    }, {
                        label: "Horizontal space",

                        name: "hspace"
                    }, {
                        label: "Border",
                        name: "border"
                    }]
                }]
            }],
            onSubmit: o
        })) : d = e.windowManager.open({
            title: "Insert/edit image",
            data: y,
            body: C,
            onSubmit: o
        })
    }
    e.on("preInit", function() {
        function t(e) {
            var t = e.attr("class");
            return t && /\bimage\b/.test(t)
        }

        function n(e) {
            return function(n) {
                function r(t) {
                    t.attr("contenteditable", e ? "true" : null)
                }
                for (var i, o = n.length; o--;) i = n[o], t(i) && (i.attr("contenteditable", e ? "false" : null), tinymce.each(i.getAll("figcaption"), r))
            }
        }
        e.parser.addNodeFilter("figure", n(!0)), e.serializer.addNodeFilter("figure", n(!1))
    }), e.addButton("image", {
        icon: "image",
        tooltip: "Insert/edit image",
        onclick: r(i),
        stateSelector: "img:not([data-mce-object],[data-mce-placeholder]),figure.image"
    }), e.addMenuItem("image", {
        icon: "image",
        text: "Insert/edit image",
        onclick: r(i),
        context: "insert",
        prependToContext: !0
    }), e.addCommand("mceImage", r(i))
});
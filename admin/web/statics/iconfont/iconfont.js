!function (d) {
    var e,
        n = '<svg><symbol id="icon-zuzhiqunzu" viewBox="0 0 1024 1024"><path d="M960 704h-63.616v-167.392a32 32 0 0 0-32-32H544V416h160a32 32 0 0 0 32-32V96a32 32 0 0 0-32-32H320a32 32 0 0 0-32 32v288a32 32 0 0 0 32 32h160v88.608H161.984a32 32 0 0 0-32 31.968L129.792 704H64a32 32 0 0 0-32 32v192a32 32 0 0 0 32 32h192a32 32 0 0 0 32-32v-192a32 32 0 0 0-32-32H193.792l0.16-135.392H480V704h-64a32 32 0 0 0-32 32v192a32 32 0 0 0 32 32h192a32 32 0 0 0 32-32v-192a32 32 0 0 0-32-32h-64v-135.392h288.384V704H768a32 32 0 0 0-32 32v192a32 32 0 0 0 32 32h192a32 32 0 0 0 32-32v-192a32 32 0 0 0-32-32zM352 128h320v224H352V128zM224 896H96v-128h128v128z m352 0h-128v-128h128v128z m352 0h-128v-128h128v128z"  ></path></symbol></svg>',
        t = (e = document.getElementsByTagName("script"))[e.length - 1].getAttribute("data-injectcss");
    if (t && !d.__iconfont__svg__cssinject__) {
        d.__iconfont__svg__cssinject__ = !0;
        try {
            document.write("<style>.svgfont {display: inline-block;width: 1em;height: 1em;fill: currentColor;vertical-align: -0.1em;font-size:16px;}</style>")
        } catch (e) {
            console && console.log(e)
        }
    }
    !function (e) {
        if (document.addEventListener) if (~["complete", "loaded", "interactive"].indexOf(document.readyState)) setTimeout(e, 0); else {
            var t = function () {
                document.removeEventListener("DOMContentLoaded", t, !1), e()
            };
            document.addEventListener("DOMContentLoaded", t, !1)
        } else document.attachEvent && (n = e, o = d.document, a = !1, i = function () {
            a || (a = !0, n())
        }, (c = function () {
            try {
                o.documentElement.doScroll("left")
            } catch (e) {
                return void setTimeout(c, 50)
            }
            i()
        })(), o.onreadystatechange = function () {
            "complete" == o.readyState && (o.onreadystatechange = null, i())
        });
        var n, o, a, i, c
    }(function () {
        var e, t;
        (e = document.createElement("div")).innerHTML = n, n = null, (t = e.getElementsByTagName("svg")[0]) && (t.setAttribute("aria-hidden", "true"), t.style.position = "absolute", t.style.width = 0, t.style.height = 0, t.style.overflow = "hidden", function (e, t) {
            t.firstChild ? function (e, t) {
                t.parentNode.insertBefore(e, t)
            }(e, t.firstChild) : t.appendChild(e)
        }(t, document.body))
    })
}(window);
/*! jQuery v3.3.1 | (c) JS Foundation and other contributors | jquery.org/license */
!(function (e, t) {
  "use strict";
  "object" == typeof module && "object" == typeof module.exports
    ? (module.exports = e.document
        ? t(e, !0)
        : function (e) {
            if (!e.document)
              throw new Error("jQuery requires a window with a document");
            return t(e);
          })
    : t(e);
})("undefined" != typeof window ? window : this, function (e, t) {
  "use strict";
  var n = [],
    r = e.document,
    i = Object.getPrototypeOf,
    o = n.slice,
    a = n.concat,
    s = n.push,
    u = n.indexOf,
    l = {},
    c = l.toString,
    f = l.hasOwnProperty,
    p = f.toString,
    d = p.call(Object),
    h = {},
    g = function e(t) {
      return "function" == typeof t && "number" != typeof t.nodeType;
    },
    y = function e(t) {
      return null != t && t === t.window;
    },
    v = { type: !0, src: !0, noModule: !0 };
  function m(e, t, n) {
    var i,
      o = (t = t || r).createElement("script");
    if (((o.text = e), n)) for (i in v) n[i] && (o[i] = n[i]);
    t.head.appendChild(o).parentNode.removeChild(o);
  }
  function x(e) {
    return null == e
      ? e + ""
      : "object" == typeof e || "function" == typeof e
      ? l[c.call(e)] || "object"
      : typeof e;
  }
  var b = "3.3.1",
    w = function (e, t) {
      return new w.fn.init(e, t);
    },
    T = /^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g;
  (w.fn = w.prototype = {
    jquery: "3.3.1",
    constructor: w,
    length: 0,
    toArray: function () {
      return o.call(this);
    },
    get: function (e) {
      return null == e ? o.call(this) : e < 0 ? this[e + this.length] : this[e];
    },
    pushStack: function (e) {
      var t = w.merge(this.constructor(), e);
      return (t.prevObject = this), t;
    },
    each: function (e) {
      return w.each(this, e);
    },
    map: function (e) {
      return this.pushStack(
        w.map(this, function (t, n) {
          return e.call(t, n, t);
        })
      );
    },
    slice: function () {
      return this.pushStack(o.apply(this, arguments));
    },
    first: function () {
      return this.eq(0);
    },
    last: function () {
      return this.eq(-1);
    },
    eq: function (e) {
      var t = this.length,
        n = +e + (e < 0 ? t : 0);
      return this.pushStack(n >= 0 && n < t ? [this[n]] : []);
    },
    end: function () {
      return this.prevObject || this.constructor();
    },
    push: s,
    sort: n.sort,
    splice: n.splice,
  }),
    (w.extend = w.fn.extend = function () {
      var e,
        t,
        n,
        r,
        i,
        o,
        a = arguments[0] || {},
        s = 1,
        u = arguments.length,
        l = !1;
      for (
        "boolean" == typeof a && ((l = a), (a = arguments[s] || {}), s++),
          "object" == typeof a || g(a) || (a = {}),
          s === u && ((a = this), s--);
        s < u;
        s++
      )
        if (null != (e = arguments[s]))
          for (t in e)
            (n = a[t]),
              a !== (r = e[t]) &&
                (l && r && (w.isPlainObject(r) || (i = Array.isArray(r)))
                  ? (i
                      ? ((i = !1), (o = n && Array.isArray(n) ? n : []))
                      : (o = n && w.isPlainObject(n) ? n : {}),
                    (a[t] = w.extend(l, o, r)))
                  : void 0 !== r && (a[t] = r));
      return a;
    }),
    w.extend({
      expando: "jQuery" + ("3.3.1" + Math.random()).replace(/\D/g, ""),
      isReady: !0,
      error: function (e) {
        throw new Error(e);
      },
      noop: function () {},
      isPlainObject: function (e) {
        var t, n;
        return (
          !(!e || "[object Object]" !== c.call(e)) &&
          (!(t = i(e)) ||
            ("function" ==
              typeof (n = f.call(t, "constructor") && t.constructor) &&
              p.call(n) === d))
        );
      },
      isEmptyObject: function (e) {
        var t;
        for (t in e) return !1;
        return !0;
      },
      globalEval: function (e) {
        m(e);
      },
      each: function (e, t) {
        var n,
          r = 0;
        if (C(e)) {
          for (n = e.length; r < n; r++)
            if (!1 === t.call(e[r], r, e[r])) break;
        } else for (r in e) if (!1 === t.call(e[r], r, e[r])) break;
        return e;
      },
      trim: function (e) {
        return null == e ? "" : (e + "").replace(T, "");
      },
      makeArray: function (e, t) {
        var n = t || [];
        return (
          null != e &&
            (C(Object(e))
              ? w.merge(n, "string" == typeof e ? [e] : e)
              : s.call(n, e)),
          n
        );
      },
      inArray: function (e, t, n) {
        return null == t ? -1 : u.call(t, e, n);
      },
      merge: function (e, t) {
        for (var n = +t.length, r = 0, i = e.length; r < n; r++) e[i++] = t[r];
        return (e.length = i), e;
      },
      grep: function (e, t, n) {
        for (var r, i = [], o = 0, a = e.length, s = !n; o < a; o++)
          (r = !t(e[o], o)) !== s && i.push(e[o]);
        return i;
      },
      map: function (e, t, n) {
        var r,
          i,
          o = 0,
          s = [];
        if (C(e))
          for (r = e.length; o < r; o++)
            null != (i = t(e[o], o, n)) && s.push(i);
        else for (o in e) null != (i = t(e[o], o, n)) && s.push(i);
        return a.apply([], s);
      },
      guid: 1,
      support: h,
    }),
    "function" == typeof Symbol && (w.fn[Symbol.iterator] = n[Symbol.iterator]),
    w.each(
      "Boolean Number String Function Array Date RegExp Object Error Symbol".split(
        " "
      ),
      function (e, t) {
        l["[object " + t + "]"] = t.toLowerCase();
      }
    );
  function C(e) {
    var t = !!e && "length" in e && e.length,
      n = x(e);
    return (
      !g(e) &&
      !y(e) &&
      ("array" === n ||
        0 === t ||
        ("number" == typeof t && t > 0 && t - 1 in e))
    );
  }
  var E = (function (e) {
    var t,
      n,
      r,
      i,
      o,
      a,
      s,
      u,
      l,
      c,
      f,
      p,
      d,
      h,
      g,
      y,
      v,
      m,
      x,
      b = "sizzle" + 1 * new Date(),
      w = e.document,
      T = 0,
      C = 0,
      E = ae(),
      k = ae(),
      S = ae(),
      D = function (e, t) {
        return e === t && (f = !0), 0;
      },
      N = {}.hasOwnProperty,
      A = [],
      j = A.pop,
      q = A.push,
      L = A.push,
      H = A.slice,
      O = function (e, t) {
        for (var n = 0, r = e.length; n < r; n++) if (e[n] === t) return n;
        return -1;
      },
      P =
        "checked|selected|async|autofocus|autoplay|controls|defer|disabled|hidden|ismap|loop|multiple|open|readonly|required|scoped",
      M = "[\\x20\\t\\r\\n\\f]",
      R = "(?:\\\\.|[\\w-]|[^\0-\\xa0])+",
      I =
        "\\[" +
        M +
        "*(" +
        R +
        ")(?:" +
        M +
        "*([*^$|!~]?=)" +
        M +
        "*(?:'((?:\\\\.|[^\\\\'])*)'|\"((?:\\\\.|[^\\\\\"])*)\"|(" +
        R +
        "))|)" +
        M +
        "*\\]",
      W =
        ":(" +
        R +
        ")(?:\\((('((?:\\\\.|[^\\\\'])*)'|\"((?:\\\\.|[^\\\\\"])*)\")|((?:\\\\.|[^\\\\()[\\]]|" +
        I +
        ")*)|.*)\\)|)",
      $ = new RegExp(M + "+", "g"),
      B = new RegExp("^" + M + "+|((?:^|[^\\\\])(?:\\\\.)*)" + M + "+$", "g"),
      F = new RegExp("^" + M + "*," + M + "*"),
      _ = new RegExp("^" + M + "*([>+~]|" + M + ")" + M + "*"),
      z = new RegExp("=" + M + "*([^\\]'\"]*?)" + M + "*\\]", "g"),
      X = new RegExp(W),
      U = new RegExp("^" + R + "$"),
      V = {
        ID: new RegExp("^#(" + R + ")"),
        CLASS: new RegExp("^\\.(" + R + ")"),
        TAG: new RegExp("^(" + R + "|[*])"),
        ATTR: new RegExp("^" + I),
        PSEUDO: new RegExp("^" + W),
        CHILD: new RegExp(
          "^:(only|first|last|nth|nth-last)-(child|of-type)(?:\\(" +
            M +
            "*(even|odd|(([+-]|)(\\d*)n|)" +
            M +
            "*(?:([+-]|)" +
            M +
            "*(\\d+)|))" +
            M +
            "*\\)|)",
          "i"
        ),
        bool: new RegExp("^(?:" + P + ")$", "i"),
        needsContext: new RegExp(
          "^" +
            M +
            "*[>+~]|:(even|odd|eq|gt|lt|nth|first|last)(?:\\(" +
            M +
            "*((?:-\\d)?\\d*)" +
            M +
            "*\\)|)(?=[^-]|$)",
          "i"
        ),
      },
      G = /^(?:input|select|textarea|button)$/i,
      Y = /^h\d$/i,
      Q = /^[^{]+\{\s*\[native \w/,
      J = /^(?:#([\w-]+)|(\w+)|\.([\w-]+))$/,
      K = /[+~]/,
      Z = new RegExp("\\\\([\\da-f]{1,6}" + M + "?|(" + M + ")|.)", "ig"),
      ee = function (e, t, n) {
        var r = "0x" + t - 65536;
        return r !== r || n
          ? t
          : r < 0
          ? String.fromCharCode(r + 65536)
          : String.fromCharCode((r >> 10) | 55296, (1023 & r) | 56320);
      },
      te = /([\0-\x1f\x7f]|^-?\d)|^-$|[^\0-\x1f\x7f-\uFFFF\w-]/g,
      ne = function (e, t) {
        return t
          ? "\0" === e
            ? "\ufffd"
            : e.slice(0, -1) +
              "\\" +
              e.charCodeAt(e.length - 1).toString(16) +
              " "
          : "\\" + e;
      },
      re = function () {
        p();
      },
      ie = me(
        function (e) {
          return !0 === e.disabled && ("form" in e || "label" in e);
        },
        { dir: "parentNode", next: "legend" }
      );
    try {
      L.apply((A = H.call(w.childNodes)), w.childNodes),
        A[w.childNodes.length].nodeType;
    } catch (e) {
      L = {
        apply: A.length
          ? function (e, t) {
              q.apply(e, H.call(t));
            }
          : function (e, t) {
              var n = e.length,
                r = 0;
              while ((e[n++] = t[r++]));
              e.length = n - 1;
            },
      };
    }
    function oe(e, t, r, i) {
      var o,
        s,
        l,
        c,
        f,
        h,
        v,
        m = t && t.ownerDocument,
        T = t ? t.nodeType : 9;
      if (
        ((r = r || []),
        "string" != typeof e || !e || (1 !== T && 9 !== T && 11 !== T))
      )
        return r;
      if (
        !i &&
        ((t ? t.ownerDocument || t : w) !== d && p(t), (t = t || d), g)
      ) {
        if (11 !== T && (f = J.exec(e)))
          if ((o = f[1])) {
            if (9 === T) {
              if (!(l = t.getElementById(o))) return r;
              if (l.id === o) return r.push(l), r;
            } else if (m && (l = m.getElementById(o)) && x(t, l) && l.id === o)
              return r.push(l), r;
          } else {
            if (f[2]) return L.apply(r, t.getElementsByTagName(e)), r;
            if (
              (o = f[3]) &&
              n.getElementsByClassName &&
              t.getElementsByClassName
            )
              return L.apply(r, t.getElementsByClassName(o)), r;
          }
        if (n.qsa && !S[e + " "] && (!y || !y.test(e))) {
          if (1 !== T) (m = t), (v = e);
          else if ("object" !== t.nodeName.toLowerCase()) {
            (c = t.getAttribute("id"))
              ? (c = c.replace(te, ne))
              : t.setAttribute("id", (c = b)),
              (s = (h = a(e)).length);
            while (s--) h[s] = "#" + c + " " + ve(h[s]);
            (v = h.join(",")), (m = (K.test(e) && ge(t.parentNode)) || t);
          }
          if (v)
            try {
              return L.apply(r, m.querySelectorAll(v)), r;
            } catch (e) {
            } finally {
              c === b && t.removeAttribute("id");
            }
        }
      }
      return u(e.replace(B, "$1"), t, r, i);
    }
    function ae() {
      var e = [];
      function t(n, i) {
        return (
          e.push(n + " ") > r.cacheLength && delete t[e.shift()],
          (t[n + " "] = i)
        );
      }
      return t;
    }
    function se(e) {
      return (e[b] = !0), e;
    }
    function ue(e) {
      var t = d.createElement("fieldset");
      try {
        return !!e(t);
      } catch (e) {
        return !1;
      } finally {
        t.parentNode && t.parentNode.removeChild(t), (t = null);
      }
    }
    function le(e, t) {
      var n = e.split("|"),
        i = n.length;
      while (i--) r.attrHandle[n[i]] = t;
    }
    function ce(e, t) {
      var n = t && e,
        r =
          n &&
          1 === e.nodeType &&
          1 === t.nodeType &&
          e.sourceIndex - t.sourceIndex;
      if (r) return r;
      if (n) while ((n = n.nextSibling)) if (n === t) return -1;
      return e ? 1 : -1;
    }
    function fe(e) {
      return function (t) {
        return "input" === t.nodeName.toLowerCase() && t.type === e;
      };
    }
    function pe(e) {
      return function (t) {
        var n = t.nodeName.toLowerCase();
        return ("input" === n || "button" === n) && t.type === e;
      };
    }
    function de(e) {
      return function (t) {
        return "form" in t
          ? t.parentNode && !1 === t.disabled
            ? "label" in t
              ? "label" in t.parentNode
                ? t.parentNode.disabled === e
                : t.disabled === e
              : t.isDisabled === e || (t.isDisabled !== !e && ie(t) === e)
            : t.disabled === e
          : "label" in t && t.disabled === e;
      };
    }
    function he(e) {
      return se(function (t) {
        return (
          (t = +t),
          se(function (n, r) {
            var i,
              o = e([], n.length, t),
              a = o.length;
            while (a--) n[(i = o[a])] && (n[i] = !(r[i] = n[i]));
          })
        );
      });
    }
    function ge(e) {
      return e && "undefined" != typeof e.getElementsByTagName && e;
    }
    (n = oe.support = {}),
      (o = oe.isXML = function (e) {
        var t = e && (e.ownerDocument || e).documentElement;
        return !!t && "HTML" !== t.nodeName;
      }),
      (p = oe.setDocument = function (e) {
        var t,
          i,
          a = e ? e.ownerDocument || e : w;
        return a !== d && 9 === a.nodeType && a.documentElement
          ? ((d = a),
            (h = d.documentElement),
            (g = !o(d)),
            w !== d &&
              (i = d.defaultView) &&
              i.top !== i &&
              (i.addEventListener
                ? i.addEventListener("unload", re, !1)
                : i.attachEvent && i.attachEvent("onunload", re)),
            (n.attributes = ue(function (e) {
              return (e.className = "i"), !e.getAttribute("className");
            })),
            (n.getElementsByTagName = ue(function (e) {
              return (
                e.appendChild(d.createComment("")),
                !e.getElementsByTagName("*").length
              );
            })),
            (n.getElementsByClassName = Q.test(d.getElementsByClassName)),
            (n.getById = ue(function (e) {
              return (
                (h.appendChild(e).id = b),
                !d.getElementsByName || !d.getElementsByName(b).length
              );
            })),
            n.getById
              ? ((r.filter.ID = function (e) {
                  var t = e.replace(Z, ee);
                  return function (e) {
                    return e.getAttribute("id") === t;
                  };
                }),
                (r.find.ID = function (e, t) {
                  if ("undefined" != typeof t.getElementById && g) {
                    var n = t.getElementById(e);
                    return n ? [n] : [];
                  }
                }))
              : ((r.filter.ID = function (e) {
                  var t = e.replace(Z, ee);
                  return function (e) {
                    var n =
                      "undefined" != typeof e.getAttributeNode &&
                      e.getAttributeNode("id");
                    return n && n.value === t;
                  };
                }),
                (r.find.ID = function (e, t) {
                  if ("undefined" != typeof t.getElementById && g) {
                    var n,
                      r,
                      i,
                      o = t.getElementById(e);
                    if (o) {
                      if ((n = o.getAttributeNode("id")) && n.value === e)
                        return [o];
                      (i = t.getElementsByName(e)), (r = 0);
                      while ((o = i[r++]))
                        if ((n = o.getAttributeNode("id")) && n.value === e)
                          return [o];
                    }
                    return [];
                  }
                })),
            (r.find.TAG = n.getElementsByTagName
              ? function (e, t) {
                  return "undefined" != typeof t.getElementsByTagName
                    ? t.getElementsByTagName(e)
                    : n.qsa
                    ? t.querySelectorAll(e)
                    : void 0;
                }
              : function (e, t) {
                  var n,
                    r = [],
                    i = 0,
                    o = t.getElementsByTagName(e);
                  if ("*" === e) {
                    while ((n = o[i++])) 1 === n.nodeType && r.push(n);
                    return r;
                  }
                  return o;
                }),
            (r.find.CLASS =
              n.getElementsByClassName &&
              function (e, t) {
                if ("undefined" != typeof t.getElementsByClassName && g)
                  return t.getElementsByClassName(e);
              }),
            (v = []),
            (y = []),
            (n.qsa = Q.test(d.querySelectorAll)) &&
              (ue(function (e) {
                (h.appendChild(e).innerHTML =
                  "<a id='" +
                  b +
                  "'></a><select id='" +
                  b +
                  "-\r\\' msallowcapture=''><option selected=''></option></select>"),
                  e.querySelectorAll("[msallowcapture^='']").length &&
                    y.push("[*^$]=" + M + "*(?:''|\"\")"),
                  e.querySelectorAll("[selected]").length ||
                    y.push("\\[" + M + "*(?:value|" + P + ")"),
                  e.querySelectorAll("[id~=" + b + "-]").length || y.push("~="),
                  e.querySelectorAll(":checked").length || y.push(":checked"),
                  e.querySelectorAll("a#" + b + "+*").length ||
                    y.push(".#.+[+~]");
              }),
              ue(function (e) {
                e.innerHTML =
                  "<a href='' disabled='disabled'></a><select disabled='disabled'><option/></select>";
                var t = d.createElement("input");
                t.setAttribute("type", "hidden"),
                  e.appendChild(t).setAttribute("name", "D"),
                  e.querySelectorAll("[name=d]").length &&
                    y.push("name" + M + "*[*^$|!~]?="),
                  2 !== e.querySelectorAll(":enabled").length &&
                    y.push(":enabled", ":disabled"),
                  (h.appendChild(e).disabled = !0),
                  2 !== e.querySelectorAll(":disabled").length &&
                    y.push(":enabled", ":disabled"),
                  e.querySelectorAll("*,:x"),
                  y.push(",.*:");
              })),
            (n.matchesSelector = Q.test(
              (m =
                h.matches ||
                h.webkitMatchesSelector ||
                h.mozMatchesSelector ||
                h.oMatchesSelector ||
                h.msMatchesSelector)
            )) &&
              ue(function (e) {
                (n.disconnectedMatch = m.call(e, "*")),
                  m.call(e, "[s!='']:x"),
                  v.push("!=", W);
              }),
            (y = y.length && new RegExp(y.join("|"))),
            (v = v.length && new RegExp(v.join("|"))),
            (t = Q.test(h.compareDocumentPosition)),
            (x =
              t || Q.test(h.contains)
                ? function (e, t) {
                    var n = 9 === e.nodeType ? e.documentElement : e,
                      r = t && t.parentNode;
                    return (
                      e === r ||
                      !(
                        !r ||
                        1 !== r.nodeType ||
                        !(n.contains
                          ? n.contains(r)
                          : e.compareDocumentPosition &&
                            16 & e.compareDocumentPosition(r))
                      )
                    );
                  }
                : function (e, t) {
                    if (t) while ((t = t.parentNode)) if (t === e) return !0;
                    return !1;
                  }),
            (D = t
              ? function (e, t) {
                  if (e === t) return (f = !0), 0;
                  var r =
                    !e.compareDocumentPosition - !t.compareDocumentPosition;
                  return (
                    r ||
                    (1 &
                      (r =
                        (e.ownerDocument || e) === (t.ownerDocument || t)
                          ? e.compareDocumentPosition(t)
                          : 1) ||
                    (!n.sortDetached && t.compareDocumentPosition(e) === r)
                      ? e === d || (e.ownerDocument === w && x(w, e))
                        ? -1
                        : t === d || (t.ownerDocument === w && x(w, t))
                        ? 1
                        : c
                        ? O(c, e) - O(c, t)
                        : 0
                      : 4 & r
                      ? -1
                      : 1)
                  );
                }
              : function (e, t) {
                  if (e === t) return (f = !0), 0;
                  var n,
                    r = 0,
                    i = e.parentNode,
                    o = t.parentNode,
                    a = [e],
                    s = [t];
                  if (!i || !o)
                    return e === d
                      ? -1
                      : t === d
                      ? 1
                      : i
                      ? -1
                      : o
                      ? 1
                      : c
                      ? O(c, e) - O(c, t)
                      : 0;
                  if (i === o) return ce(e, t);
                  n = e;
                  while ((n = n.parentNode)) a.unshift(n);
                  n = t;
                  while ((n = n.parentNode)) s.unshift(n);
                  while (a[r] === s[r]) r++;
                  return r
                    ? ce(a[r], s[r])
                    : a[r] === w
                    ? -1
                    : s[r] === w
                    ? 1
                    : 0;
                }),
            d)
          : d;
      }),
      (oe.matches = function (e, t) {
        return oe(e, null, null, t);
      }),
      (oe.matchesSelector = function (e, t) {
        if (
          ((e.ownerDocument || e) !== d && p(e),
          (t = t.replace(z, "='$1']")),
          n.matchesSelector &&
            g &&
            !S[t + " "] &&
            (!v || !v.test(t)) &&
            (!y || !y.test(t)))
        )
          try {
            var r = m.call(e, t);
            if (
              r ||
              n.disconnectedMatch ||
              (e.document && 11 !== e.document.nodeType)
            )
              return r;
          } catch (e) {}
        return oe(t, d, null, [e]).length > 0;
      }),
      (oe.contains = function (e, t) {
        return (e.ownerDocument || e) !== d && p(e), x(e, t);
      }),
      (oe.attr = function (e, t) {
        (e.ownerDocument || e) !== d && p(e);
        var i = r.attrHandle[t.toLowerCase()],
          o = i && N.call(r.attrHandle, t.toLowerCase()) ? i(e, t, !g) : void 0;
        return void 0 !== o
          ? o
          : n.attributes || !g
          ? e.getAttribute(t)
          : (o = e.getAttributeNode(t)) && o.specified
          ? o.value
          : null;
      }),
      (oe.escape = function (e) {
        return (e + "").replace(te, ne);
      }),
      (oe.error = function (e) {
        throw new Error("Syntax error, unrecognized expression: " + e);
      }),
      (oe.uniqueSort = function (e) {
        var t,
          r = [],
          i = 0,
          o = 0;
        if (
          ((f = !n.detectDuplicates),
          (c = !n.sortStable && e.slice(0)),
          e.sort(D),
          f)
        ) {
          while ((t = e[o++])) t === e[o] && (i = r.push(o));
          while (i--) e.splice(r[i], 1);
        }
        return (c = null), e;
      }),
      (i = oe.getText = function (e) {
        var t,
          n = "",
          r = 0,
          o = e.nodeType;
        if (o) {
          if (1 === o || 9 === o || 11 === o) {
            if ("string" == typeof e.textContent) return e.textContent;
            for (e = e.firstChild; e; e = e.nextSibling) n += i(e);
          } else if (3 === o || 4 === o) return e.nodeValue;
        } else while ((t = e[r++])) n += i(t);
        return n;
      }),
      ((r = oe.selectors = {
        cacheLength: 50,
        createPseudo: se,
        match: V,
        attrHandle: {},
        find: {},
        relative: {
          ">": { dir: "parentNode", first: !0 },
          " ": { dir: "parentNode" },
          "+": { dir: "previousSibling", first: !0 },
          "~": { dir: "previousSibling" },
        },
        preFilter: {
          ATTR: function (e) {
            return (
              (e[1] = e[1].replace(Z, ee)),
              (e[3] = (e[3] || e[4] || e[5] || "").replace(Z, ee)),
              "~=" === e[2] && (e[3] = " " + e[3] + " "),
              e.slice(0, 4)
            );
          },
          CHILD: function (e) {
            return (
              (e[1] = e[1].toLowerCase()),
              "nth" === e[1].slice(0, 3)
                ? (e[3] || oe.error(e[0]),
                  (e[4] = +(e[4]
                    ? e[5] + (e[6] || 1)
                    : 2 * ("even" === e[3] || "odd" === e[3]))),
                  (e[5] = +(e[7] + e[8] || "odd" === e[3])))
                : e[3] && oe.error(e[0]),
              e
            );
          },
          PSEUDO: function (e) {
            var t,
              n = !e[6] && e[2];
            return V.CHILD.test(e[0])
              ? null
              : (e[3]
                  ? (e[2] = e[4] || e[5] || "")
                  : n &&
                    X.test(n) &&
                    (t = a(n, !0)) &&
                    (t = n.indexOf(")", n.length - t) - n.length) &&
                    ((e[0] = e[0].slice(0, t)), (e[2] = n.slice(0, t))),
                e.slice(0, 3));
          },
        },
        filter: {
          TAG: function (e) {
            var t = e.replace(Z, ee).toLowerCase();
            return "*" === e
              ? function () {
                  return !0;
                }
              : function (e) {
                  return e.nodeName && e.nodeName.toLowerCase() === t;
                };
          },
          CLASS: function (e) {
            var t = E[e + " "];
            return (
              t ||
              ((t = new RegExp("(^|" + M + ")" + e + "(" + M + "|$)")) &&
                E(e, function (e) {
                  return t.test(
                    ("string" == typeof e.className && e.className) ||
                      ("undefined" != typeof e.getAttribute &&
                        e.getAttribute("class")) ||
                      ""
                  );
                }))
            );
          },
          ATTR: function (e, t, n) {
            return function (r) {
              var i = oe.attr(r, e);
              return null == i
                ? "!=" === t
                : !t ||
                    ((i += ""),
                    "=" === t
                      ? i === n
                      : "!=" === t
                      ? i !== n
                      : "^=" === t
                      ? n && 0 === i.indexOf(n)
                      : "*=" === t
                      ? n && i.indexOf(n) > -1
                      : "$=" === t
                      ? n && i.slice(-n.length) === n
                      : "~=" === t
                      ? (" " + i.replace($, " ") + " ").indexOf(n) > -1
                      : "|=" === t &&
                        (i === n || i.slice(0, n.length + 1) === n + "-"));
            };
          },
          CHILD: function (e, t, n, r, i) {
            var o = "nth" !== e.slice(0, 3),
              a = "last" !== e.slice(-4),
              s = "of-type" === t;
            return 1 === r && 0 === i
              ? function (e) {
                  return !!e.parentNode;
                }
              : function (t, n, u) {
                  var l,
                    c,
                    f,
                    p,
                    d,
                    h,
                    g = o !== a ? "nextSibling" : "previousSibling",
                    y = t.parentNode,
                    v = s && t.nodeName.toLowerCase(),
                    m = !u && !s,
                    x = !1;
                  if (y) {
                    if (o) {
                      while (g) {
                        p = t;
                        while ((p = p[g]))
                          if (
                            s
                              ? p.nodeName.toLowerCase() === v
                              : 1 === p.nodeType
                          )
                            return !1;
                        h = g = "only" === e && !h && "nextSibling";
                      }
                      return !0;
                    }
                    if (((h = [a ? y.firstChild : y.lastChild]), a && m)) {
                      (x =
                        (d =
                          (l =
                            (c =
                              (f = (p = y)[b] || (p[b] = {}))[p.uniqueID] ||
                              (f[p.uniqueID] = {}))[e] || [])[0] === T &&
                          l[1]) && l[2]),
                        (p = d && y.childNodes[d]);
                      while ((p = (++d && p && p[g]) || (x = d = 0) || h.pop()))
                        if (1 === p.nodeType && ++x && p === t) {
                          c[e] = [T, d, x];
                          break;
                        }
                    } else if (
                      (m &&
                        (x = d =
                          (l =
                            (c =
                              (f = (p = t)[b] || (p[b] = {}))[p.uniqueID] ||
                              (f[p.uniqueID] = {}))[e] || [])[0] === T && l[1]),
                      !1 === x)
                    )
                      while ((p = (++d && p && p[g]) || (x = d = 0) || h.pop()))
                        if (
                          (s
                            ? p.nodeName.toLowerCase() === v
                            : 1 === p.nodeType) &&
                          ++x &&
                          (m &&
                            ((c =
                              (f = p[b] || (p[b] = {}))[p.uniqueID] ||
                              (f[p.uniqueID] = {}))[e] = [T, x]),
                          p === t)
                        )
                          break;
                    return (x -= i) === r || (x % r == 0 && x / r >= 0);
                  }
                };
          },
          PSEUDO: function (e, t) {
            var n,
              i =
                r.pseudos[e] ||
                r.setFilters[e.toLowerCase()] ||
                oe.error("unsupported pseudo: " + e);
            return i[b]
              ? i(t)
              : i.length > 1
              ? ((n = [e, e, "", t]),
                r.setFilters.hasOwnProperty(e.toLowerCase())
                  ? se(function (e, n) {
                      var r,
                        o = i(e, t),
                        a = o.length;
                      while (a--) e[(r = O(e, o[a]))] = !(n[r] = o[a]);
                    })
                  : function (e) {
                      return i(e, 0, n);
                    })
              : i;
          },
        },
        pseudos: {
          not: se(function (e) {
            var t = [],
              n = [],
              r = s(e.replace(B, "$1"));
            return r[b]
              ? se(function (e, t, n, i) {
                  var o,
                    a = r(e, null, i, []),
                    s = e.length;
                  while (s--) (o = a[s]) && (e[s] = !(t[s] = o));
                })
              : function (e, i, o) {
                  return (t[0] = e), r(t, null, o, n), (t[0] = null), !n.pop();
                };
          }),
          has: se(function (e) {
            return function (t) {
              return oe(e, t).length > 0;
            };
          }),
          contains: se(function (e) {
            return (
              (e = e.replace(Z, ee)),
              function (t) {
                return (t.textContent || t.innerText || i(t)).indexOf(e) > -1;
              }
            );
          }),
          lang: se(function (e) {
            return (
              U.test(e || "") || oe.error("unsupported lang: " + e),
              (e = e.replace(Z, ee).toLowerCase()),
              function (t) {
                var n;
                do {
                  if (
                    (n = g
                      ? t.lang
                      : t.getAttribute("xml:lang") || t.getAttribute("lang"))
                  )
                    return (
                      (n = n.toLowerCase()) === e || 0 === n.indexOf(e + "-")
                    );
                } while ((t = t.parentNode) && 1 === t.nodeType);
                return !1;
              }
            );
          }),
          target: function (t) {
            var n = e.location && e.location.hash;
            return n && n.slice(1) === t.id;
          },
          root: function (e) {
            return e === h;
          },
          focus: function (e) {
            return (
              e === d.activeElement &&
              (!d.hasFocus || d.hasFocus()) &&
              !!(e.type || e.href || ~e.tabIndex)
            );
          },
          enabled: de(!1),
          disabled: de(!0),
          checked: function (e) {
            var t = e.nodeName.toLowerCase();
            return (
              ("input" === t && !!e.checked) || ("option" === t && !!e.selected)
            );
          },
          selected: function (e) {
            return (
              e.parentNode && e.parentNode.selectedIndex, !0 === e.selected
            );
          },
          empty: function (e) {
            for (e = e.firstChild; e; e = e.nextSibling)
              if (e.nodeType < 6) return !1;
            return !0;
          },
          parent: function (e) {
            return !r.pseudos.empty(e);
          },
          header: function (e) {
            return Y.test(e.nodeName);
          },
          input: function (e) {
            return G.test(e.nodeName);
          },
          button: function (e) {
            var t = e.nodeName.toLowerCase();
            return ("input" === t && "button" === e.type) || "button" === t;
          },
          text: function (e) {
            var t;
            return (
              "input" === e.nodeName.toLowerCase() &&
              "text" === e.type &&
              (null == (t = e.getAttribute("type")) ||
                "text" === t.toLowerCase())
            );
          },
          first: he(function () {
            return [0];
          }),
          last: he(function (e, t) {
            return [t - 1];
          }),
          eq: he(function (e, t, n) {
            return [n < 0 ? n + t : n];
          }),
          even: he(function (e, t) {
            for (var n = 0; n < t; n += 2) e.push(n);
            return e;
          }),
          odd: he(function (e, t) {
            for (var n = 1; n < t; n += 2) e.push(n);
            return e;
          }),
          lt: he(function (e, t, n) {
            for (var r = n < 0 ? n + t : n; --r >= 0; ) e.push(r);
            return e;
          }),
          gt: he(function (e, t, n) {
            for (var r = n < 0 ? n + t : n; ++r < t; ) e.push(r);
            return e;
          }),
        },
      }).pseudos.nth = r.pseudos.eq);
    for (t in { radio: !0, checkbox: !0, file: !0, password: !0, image: !0 })
      r.pseudos[t] = fe(t);
    for (t in { submit: !0, reset: !0 }) r.pseudos[t] = pe(t);
    function ye() {}
    (ye.prototype = r.filters = r.pseudos),
      (r.setFilters = new ye()),
      (a = oe.tokenize = function (e, t) {
        var n,
          i,
          o,
          a,
          s,
          u,
          l,
          c = k[e + " "];
        if (c) return t ? 0 : c.slice(0);
        (s = e), (u = []), (l = r.preFilter);
        while (s) {
          (n && !(i = F.exec(s))) ||
            (i && (s = s.slice(i[0].length) || s), u.push((o = []))),
            (n = !1),
            (i = _.exec(s)) &&
              ((n = i.shift()),
              o.push({ value: n, type: i[0].replace(B, " ") }),
              (s = s.slice(n.length)));
          for (a in r.filter)
            !(i = V[a].exec(s)) ||
              (l[a] && !(i = l[a](i))) ||
              ((n = i.shift()),
              o.push({ value: n, type: a, matches: i }),
              (s = s.slice(n.length)));
          if (!n) break;
        }
        return t ? s.length : s ? oe.error(e) : k(e, u).slice(0);
      });
    function ve(e) {
      for (var t = 0, n = e.length, r = ""; t < n; t++) r += e[t].value;
      return r;
    }
    function me(e, t, n) {
      var r = t.dir,
        i = t.next,
        o = i || r,
        a = n && "parentNode" === o,
        s = C++;
      return t.first
        ? function (t, n, i) {
            while ((t = t[r])) if (1 === t.nodeType || a) return e(t, n, i);
            return !1;
          }
        : function (t, n, u) {
            var l,
              c,
              f,
              p = [T, s];
            if (u) {
              while ((t = t[r]))
                if ((1 === t.nodeType || a) && e(t, n, u)) return !0;
            } else
              while ((t = t[r]))
                if (1 === t.nodeType || a)
                  if (
                    ((f = t[b] || (t[b] = {})),
                    (c = f[t.uniqueID] || (f[t.uniqueID] = {})),
                    i && i === t.nodeName.toLowerCase())
                  )
                    t = t[r] || t;
                  else {
                    if ((l = c[o]) && l[0] === T && l[1] === s)
                      return (p[2] = l[2]);
                    if (((c[o] = p), (p[2] = e(t, n, u)))) return !0;
                  }
            return !1;
          };
    }
    function xe(e) {
      return e.length > 1
        ? function (t, n, r) {
            var i = e.length;
            while (i--) if (!e[i](t, n, r)) return !1;
            return !0;
          }
        : e[0];
    }
    function be(e, t, n) {
      for (var r = 0, i = t.length; r < i; r++) oe(e, t[r], n);
      return n;
    }
    function we(e, t, n, r, i) {
      for (var o, a = [], s = 0, u = e.length, l = null != t; s < u; s++)
        (o = e[s]) && ((n && !n(o, r, i)) || (a.push(o), l && t.push(s)));
      return a;
    }
    function Te(e, t, n, r, i, o) {
      return (
        r && !r[b] && (r = Te(r)),
        i && !i[b] && (i = Te(i, o)),
        se(function (o, a, s, u) {
          var l,
            c,
            f,
            p = [],
            d = [],
            h = a.length,
            g = o || be(t || "*", s.nodeType ? [s] : s, []),
            y = !e || (!o && t) ? g : we(g, p, e, s, u),
            v = n ? (i || (o ? e : h || r) ? [] : a) : y;
          if ((n && n(y, v, s, u), r)) {
            (l = we(v, d)), r(l, [], s, u), (c = l.length);
            while (c--) (f = l[c]) && (v[d[c]] = !(y[d[c]] = f));
          }
          if (o) {
            if (i || e) {
              if (i) {
                (l = []), (c = v.length);
                while (c--) (f = v[c]) && l.push((y[c] = f));
                i(null, (v = []), l, u);
              }
              c = v.length;
              while (c--)
                (f = v[c]) &&
                  (l = i ? O(o, f) : p[c]) > -1 &&
                  (o[l] = !(a[l] = f));
            }
          } else (v = we(v === a ? v.splice(h, v.length) : v)), i ? i(null, a, v, u) : L.apply(a, v);
        })
      );
    }
    function Ce(e) {
      for (
        var t,
          n,
          i,
          o = e.length,
          a = r.relative[e[0].type],
          s = a || r.relative[" "],
          u = a ? 1 : 0,
          c = me(
            function (e) {
              return e === t;
            },
            s,
            !0
          ),
          f = me(
            function (e) {
              return O(t, e) > -1;
            },
            s,
            !0
          ),
          p = [
            function (e, n, r) {
              var i =
                (!a && (r || n !== l)) ||
                ((t = n).nodeType ? c(e, n, r) : f(e, n, r));
              return (t = null), i;
            },
          ];
        u < o;
        u++
      )
        if ((n = r.relative[e[u].type])) p = [me(xe(p), n)];
        else {
          if ((n = r.filter[e[u].type].apply(null, e[u].matches))[b]) {
            for (i = ++u; i < o; i++) if (r.relative[e[i].type]) break;
            return Te(
              u > 1 && xe(p),
              u > 1 &&
                ve(
                  e
                    .slice(0, u - 1)
                    .concat({ value: " " === e[u - 2].type ? "*" : "" })
                ).replace(B, "$1"),
              n,
              u < i && Ce(e.slice(u, i)),
              i < o && Ce((e = e.slice(i))),
              i < o && ve(e)
            );
          }
          p.push(n);
        }
      return xe(p);
    }
    function Ee(e, t) {
      var n = t.length > 0,
        i = e.length > 0,
        o = function (o, a, s, u, c) {
          var f,
            h,
            y,
            v = 0,
            m = "0",
            x = o && [],
            b = [],
            w = l,
            C = o || (i && r.find.TAG("*", c)),
            E = (T += null == w ? 1 : Math.random() || 0.1),
            k = C.length;
          for (
            c && (l = a === d || a || c);
            m !== k && null != (f = C[m]);
            m++
          ) {
            if (i && f) {
              (h = 0), a || f.ownerDocument === d || (p(f), (s = !g));
              while ((y = e[h++]))
                if (y(f, a || d, s)) {
                  u.push(f);
                  break;
                }
              c && (T = E);
            }
            n && ((f = !y && f) && v--, o && x.push(f));
          }
          if (((v += m), n && m !== v)) {
            h = 0;
            while ((y = t[h++])) y(x, b, a, s);
            if (o) {
              if (v > 0) while (m--) x[m] || b[m] || (b[m] = j.call(u));
              b = we(b);
            }
            L.apply(u, b),
              c && !o && b.length > 0 && v + t.length > 1 && oe.uniqueSort(u);
          }
          return c && ((T = E), (l = w)), x;
        };
      return n ? se(o) : o;
    }
    return (
      (s = oe.compile = function (e, t) {
        var n,
          r = [],
          i = [],
          o = S[e + " "];
        if (!o) {
          t || (t = a(e)), (n = t.length);
          while (n--) (o = Ce(t[n]))[b] ? r.push(o) : i.push(o);
          (o = S(e, Ee(i, r))).selector = e;
        }
        return o;
      }),
      (u = oe.select = function (e, t, n, i) {
        var o,
          u,
          l,
          c,
          f,
          p = "function" == typeof e && e,
          d = !i && a((e = p.selector || e));
        if (((n = n || []), 1 === d.length)) {
          if (
            (u = d[0] = d[0].slice(0)).length > 2 &&
            "ID" === (l = u[0]).type &&
            9 === t.nodeType &&
            g &&
            r.relative[u[1].type]
          ) {
            if (!(t = (r.find.ID(l.matches[0].replace(Z, ee), t) || [])[0]))
              return n;
            p && (t = t.parentNode), (e = e.slice(u.shift().value.length));
          }
          o = V.needsContext.test(e) ? 0 : u.length;
          while (o--) {
            if (((l = u[o]), r.relative[(c = l.type)])) break;
            if (
              (f = r.find[c]) &&
              (i = f(
                l.matches[0].replace(Z, ee),
                (K.test(u[0].type) && ge(t.parentNode)) || t
              ))
            ) {
              if ((u.splice(o, 1), !(e = i.length && ve(u))))
                return L.apply(n, i), n;
              break;
            }
          }
        }
        return (
          (p || s(e, d))(
            i,
            t,
            !g,
            n,
            !t || (K.test(e) && ge(t.parentNode)) || t
          ),
          n
        );
      }),
      (n.sortStable = b.split("").sort(D).join("") === b),
      (n.detectDuplicates = !!f),
      p(),
      (n.sortDetached = ue(function (e) {
        return 1 & e.compareDocumentPosition(d.createElement("fieldset"));
      })),
      ue(function (e) {
        return (
          (e.innerHTML = "<a href='#'></a>"),
          "#" === e.firstChild.getAttribute("href")
        );
      }) ||
        le("type|href|height|width", function (e, t, n) {
          if (!n) return e.getAttribute(t, "type" === t.toLowerCase() ? 1 : 2);
        }),
      (n.attributes &&
        ue(function (e) {
          return (
            (e.innerHTML = "<input/>"),
            e.firstChild.setAttribute("value", ""),
            "" === e.firstChild.getAttribute("value")
          );
        })) ||
        le("value", function (e, t, n) {
          if (!n && "input" === e.nodeName.toLowerCase()) return e.defaultValue;
        }),
      ue(function (e) {
        return null == e.getAttribute("disabled");
      }) ||
        le(P, function (e, t, n) {
          var r;
          if (!n)
            return !0 === e[t]
              ? t.toLowerCase()
              : (r = e.getAttributeNode(t)) && r.specified
              ? r.value
              : null;
        }),
      oe
    );
  })(e);
  (w.find = E),
    (w.expr = E.selectors),
    (w.expr[":"] = w.expr.pseudos),
    (w.uniqueSort = w.unique = E.uniqueSort),
    (w.text = E.getText),
    (w.isXMLDoc = E.isXML),
    (w.contains = E.contains),
    (w.escapeSelector = E.escape);
  var k = function (e, t, n) {
      var r = [],
        i = void 0 !== n;
      while ((e = e[t]) && 9 !== e.nodeType)
        if (1 === e.nodeType) {
          if (i && w(e).is(n)) break;
          r.push(e);
        }
      return r;
    },
    S = function (e, t) {
      for (var n = []; e; e = e.nextSibling)
        1 === e.nodeType && e !== t && n.push(e);
      return n;
    },
    D = w.expr.match.needsContext;
  function N(e, t) {
    return e.nodeName && e.nodeName.toLowerCase() === t.toLowerCase();
  }
  var A = /^<([a-z][^\/\0>:\x20\t\r\n\f]*)[\x20\t\r\n\f]*\/?>(?:<\/\1>|)$/i;
  function j(e, t, n) {
    return g(t)
      ? w.grep(e, function (e, r) {
          return !!t.call(e, r, e) !== n;
        })
      : t.nodeType
      ? w.grep(e, function (e) {
          return (e === t) !== n;
        })
      : "string" != typeof t
      ? w.grep(e, function (e) {
          return u.call(t, e) > -1 !== n;
        })
      : w.filter(t, e, n);
  }
  (w.filter = function (e, t, n) {
    var r = t[0];
    return (
      n && (e = ":not(" + e + ")"),
      1 === t.length && 1 === r.nodeType
        ? w.find.matchesSelector(r, e)
          ? [r]
          : []
        : w.find.matches(
            e,
            w.grep(t, function (e) {
              return 1 === e.nodeType;
            })
          )
    );
  }),
    w.fn.extend({
      find: function (e) {
        var t,
          n,
          r = this.length,
          i = this;
        if ("string" != typeof e)
          return this.pushStack(
            w(e).filter(function () {
              for (t = 0; t < r; t++) if (w.contains(i[t], this)) return !0;
            })
          );
        for (n = this.pushStack([]), t = 0; t < r; t++) w.find(e, i[t], n);
        return r > 1 ? w.uniqueSort(n) : n;
      },
      filter: function (e) {
        return this.pushStack(j(this, e || [], !1));
      },
      not: function (e) {
        return this.pushStack(j(this, e || [], !0));
      },
      is: function (e) {
        return !!j(this, "string" == typeof e && D.test(e) ? w(e) : e || [], !1)
          .length;
      },
    });
  var q,
    L = /^(?:\s*(<[\w\W]+>)[^>]*|#([\w-]+))$/;
  ((w.fn.init = function (e, t, n) {
    var i, o;
    if (!e) return this;
    if (((n = n || q), "string" == typeof e)) {
      if (
        !(i =
          "<" === e[0] && ">" === e[e.length - 1] && e.length >= 3
            ? [null, e, null]
            : L.exec(e)) ||
        (!i[1] && t)
      )
        return !t || t.jquery ? (t || n).find(e) : this.constructor(t).find(e);
      if (i[1]) {
        if (
          ((t = t instanceof w ? t[0] : t),
          w.merge(
            this,
            w.parseHTML(i[1], t && t.nodeType ? t.ownerDocument || t : r, !0)
          ),
          A.test(i[1]) && w.isPlainObject(t))
        )
          for (i in t) g(this[i]) ? this[i](t[i]) : this.attr(i, t[i]);
        return this;
      }
      return (
        (o = r.getElementById(i[2])) && ((this[0] = o), (this.length = 1)), this
      );
    }
    return e.nodeType
      ? ((this[0] = e), (this.length = 1), this)
      : g(e)
      ? void 0 !== n.ready
        ? n.ready(e)
        : e(w)
      : w.makeArray(e, this);
  }).prototype = w.fn),
    (q = w(r));
  var H = /^(?:parents|prev(?:Until|All))/,
    O = { children: !0, contents: !0, next: !0, prev: !0 };
  w.fn.extend({
    has: function (e) {
      var t = w(e, this),
        n = t.length;
      return this.filter(function () {
        for (var e = 0; e < n; e++) if (w.contains(this, t[e])) return !0;
      });
    },
    closest: function (e, t) {
      var n,
        r = 0,
        i = this.length,
        o = [],
        a = "string" != typeof e && w(e);
      if (!D.test(e))
        for (; r < i; r++)
          for (n = this[r]; n && n !== t; n = n.parentNode)
            if (
              n.nodeType < 11 &&
              (a
                ? a.index(n) > -1
                : 1 === n.nodeType && w.find.matchesSelector(n, e))
            ) {
              o.push(n);
              break;
            }
      return this.pushStack(o.length > 1 ? w.uniqueSort(o) : o);
    },
    index: function (e) {
      return e
        ? "string" == typeof e
          ? u.call(w(e), this[0])
          : u.call(this, e.jquery ? e[0] : e)
        : this[0] && this[0].parentNode
        ? this.first().prevAll().length
        : -1;
    },
    add: function (e, t) {
      return this.pushStack(w.uniqueSort(w.merge(this.get(), w(e, t))));
    },
    addBack: function (e) {
      return this.add(null == e ? this.prevObject : this.prevObject.filter(e));
    },
  });
  function P(e, t) {
    while ((e = e[t]) && 1 !== e.nodeType);
    return e;
  }
  w.each(
    {
      parent: function (e) {
        var t = e.parentNode;
        return t && 11 !== t.nodeType ? t : null;
      },
      parents: function (e) {
        return k(e, "parentNode");
      },
      parentsUntil: function (e, t, n) {
        return k(e, "parentNode", n);
      },
      next: function (e) {
        return P(e, "nextSibling");
      },
      prev: function (e) {
        return P(e, "previousSibling");
      },
      nextAll: function (e) {
        return k(e, "nextSibling");
      },
      prevAll: function (e) {
        return k(e, "previousSibling");
      },
      nextUntil: function (e, t, n) {
        return k(e, "nextSibling", n);
      },
      prevUntil: function (e, t, n) {
        return k(e, "previousSibling", n);
      },
      siblings: function (e) {
        return S((e.parentNode || {}).firstChild, e);
      },
      children: function (e) {
        return S(e.firstChild);
      },
      contents: function (e) {
        return N(e, "iframe")
          ? e.contentDocument
          : (N(e, "template") && (e = e.content || e),
            w.merge([], e.childNodes));
      },
    },
    function (e, t) {
      w.fn[e] = function (n, r) {
        var i = w.map(this, t, n);
        return (
          "Until" !== e.slice(-5) && (r = n),
          r && "string" == typeof r && (i = w.filter(r, i)),
          this.length > 1 &&
            (O[e] || w.uniqueSort(i), H.test(e) && i.reverse()),
          this.pushStack(i)
        );
      };
    }
  );
  var M = /[^\x20\t\r\n\f]+/g;
  function R(e) {
    var t = {};
    return (
      w.each(e.match(M) || [], function (e, n) {
        t[n] = !0;
      }),
      t
    );
  }
  w.Callbacks = function (e) {
    e = "string" == typeof e ? R(e) : w.extend({}, e);
    var t,
      n,
      r,
      i,
      o = [],
      a = [],
      s = -1,
      u = function () {
        for (i = i || e.once, r = t = !0; a.length; s = -1) {
          n = a.shift();
          while (++s < o.length)
            !1 === o[s].apply(n[0], n[1]) &&
              e.stopOnFalse &&
              ((s = o.length), (n = !1));
        }
        e.memory || (n = !1), (t = !1), i && (o = n ? [] : "");
      },
      l = {
        add: function () {
          return (
            o &&
              (n && !t && ((s = o.length - 1), a.push(n)),
              (function t(n) {
                w.each(n, function (n, r) {
                  g(r)
                    ? (e.unique && l.has(r)) || o.push(r)
                    : r && r.length && "string" !== x(r) && t(r);
                });
              })(arguments),
              n && !t && u()),
            this
          );
        },
        remove: function () {
          return (
            w.each(arguments, function (e, t) {
              var n;
              while ((n = w.inArray(t, o, n)) > -1)
                o.splice(n, 1), n <= s && s--;
            }),
            this
          );
        },
        has: function (e) {
          return e ? w.inArray(e, o) > -1 : o.length > 0;
        },
        empty: function () {
          return o && (o = []), this;
        },
        disable: function () {
          return (i = a = []), (o = n = ""), this;
        },
        disabled: function () {
          return !o;
        },
        lock: function () {
          return (i = a = []), n || t || (o = n = ""), this;
        },
        locked: function () {
          return !!i;
        },
        fireWith: function (e, n) {
          return (
            i ||
              ((n = [e, (n = n || []).slice ? n.slice() : n]),
              a.push(n),
              t || u()),
            this
          );
        },
        fire: function () {
          return l.fireWith(this, arguments), this;
        },
        fired: function () {
          return !!r;
        },
      };
    return l;
  };
  function I(e) {
    return e;
  }
  function W(e) {
    throw e;
  }
  function $(e, t, n, r) {
    var i;
    try {
      e && g((i = e.promise))
        ? i.call(e).done(t).fail(n)
        : e && g((i = e.then))
        ? i.call(e, t, n)
        : t.apply(void 0, [e].slice(r));
    } catch (e) {
      n.apply(void 0, [e]);
    }
  }
  w.extend({
    Deferred: function (t) {
      var n = [
          [
            "notify",
            "progress",
            w.Callbacks("memory"),
            w.Callbacks("memory"),
            2,
          ],
          [
            "resolve",
            "done",
            w.Callbacks("once memory"),
            w.Callbacks("once memory"),
            0,
            "resolved",
          ],
          [
            "reject",
            "fail",
            w.Callbacks("once memory"),
            w.Callbacks("once memory"),
            1,
            "rejected",
          ],
        ],
        r = "pending",
        i = {
          state: function () {
            return r;
          },
          always: function () {
            return o.done(arguments).fail(arguments), this;
          },
          catch: function (e) {
            return i.then(null, e);
          },
          pipe: function () {
            var e = arguments;
            return w
              .Deferred(function (t) {
                w.each(n, function (n, r) {
                  var i = g(e[r[4]]) && e[r[4]];
                  o[r[1]](function () {
                    var e = i && i.apply(this, arguments);
                    e && g(e.promise)
                      ? e
                          .promise()
                          .progress(t.notify)
                          .done(t.resolve)
                          .fail(t.reject)
                      : t[r[0] + "With"](this, i ? [e] : arguments);
                  });
                }),
                  (e = null);
              })
              .promise();
          },
          then: function (t, r, i) {
            var o = 0;
            function a(t, n, r, i) {
              return function () {
                var s = this,
                  u = arguments,
                  l = function () {
                    var e, l;
                    if (!(t < o)) {
                      if ((e = r.apply(s, u)) === n.promise())
                        throw new TypeError("Thenable self-resolution");
                      (l =
                        e &&
                        ("object" == typeof e || "function" == typeof e) &&
                        e.then),
                        g(l)
                          ? i
                            ? l.call(e, a(o, n, I, i), a(o, n, W, i))
                            : (o++,
                              l.call(
                                e,
                                a(o, n, I, i),
                                a(o, n, W, i),
                                a(o, n, I, n.notifyWith)
                              ))
                          : (r !== I && ((s = void 0), (u = [e])),
                            (i || n.resolveWith)(s, u));
                    }
                  },
                  c = i
                    ? l
                    : function () {
                        try {
                          l();
                        } catch (e) {
                          w.Deferred.exceptionHook &&
                            w.Deferred.exceptionHook(e, c.stackTrace),
                            t + 1 >= o &&
                              (r !== W && ((s = void 0), (u = [e])),
                              n.rejectWith(s, u));
                        }
                      };
                t
                  ? c()
                  : (w.Deferred.getStackHook &&
                      (c.stackTrace = w.Deferred.getStackHook()),
                    e.setTimeout(c));
              };
            }
            return w
              .Deferred(function (e) {
                n[0][3].add(a(0, e, g(i) ? i : I, e.notifyWith)),
                  n[1][3].add(a(0, e, g(t) ? t : I)),
                  n[2][3].add(a(0, e, g(r) ? r : W));
              })
              .promise();
          },
          promise: function (e) {
            return null != e ? w.extend(e, i) : i;
          },
        },
        o = {};
      return (
        w.each(n, function (e, t) {
          var a = t[2],
            s = t[5];
          (i[t[1]] = a.add),
            s &&
              a.add(
                function () {
                  r = s;
                },
                n[3 - e][2].disable,
                n[3 - e][3].disable,
                n[0][2].lock,
                n[0][3].lock
              ),
            a.add(t[3].fire),
            (o[t[0]] = function () {
              return (
                o[t[0] + "With"](this === o ? void 0 : this, arguments), this
              );
            }),
            (o[t[0] + "With"] = a.fireWith);
        }),
        i.promise(o),
        t && t.call(o, o),
        o
      );
    },
    when: function (e) {
      var t = arguments.length,
        n = t,
        r = Array(n),
        i = o.call(arguments),
        a = w.Deferred(),
        s = function (e) {
          return function (n) {
            (r[e] = this),
              (i[e] = arguments.length > 1 ? o.call(arguments) : n),
              --t || a.resolveWith(r, i);
          };
        };
      if (
        t <= 1 &&
        ($(e, a.done(s(n)).resolve, a.reject, !t),
        "pending" === a.state() || g(i[n] && i[n].then))
      )
        return a.then();
      while (n--) $(i[n], s(n), a.reject);
      return a.promise();
    },
  });
  var B = /^(Eval|Internal|Range|Reference|Syntax|Type|URI)Error$/;
  (w.Deferred.exceptionHook = function (t, n) {
    e.console &&
      e.console.warn &&
      t &&
      B.test(t.name) &&
      e.console.warn("jQuery.Deferred exception: " + t.message, t.stack, n);
  }),
    (w.readyException = function (t) {
      e.setTimeout(function () {
        throw t;
      });
    });
  var F = w.Deferred();
  (w.fn.ready = function (e) {
    return (
      F.then(e)["catch"](function (e) {
        w.readyException(e);
      }),
      this
    );
  }),
    w.extend({
      isReady: !1,
      readyWait: 1,
      ready: function (e) {
        (!0 === e ? --w.readyWait : w.isReady) ||
          ((w.isReady = !0),
          (!0 !== e && --w.readyWait > 0) || F.resolveWith(r, [w]));
      },
    }),
    (w.ready.then = F.then);
  function _() {
    r.removeEventListener("DOMContentLoaded", _),
      e.removeEventListener("load", _),
      w.ready();
  }
  "complete" === r.readyState ||
  ("loading" !== r.readyState && !r.documentElement.doScroll)
    ? e.setTimeout(w.ready)
    : (r.addEventListener("DOMContentLoaded", _),
      e.addEventListener("load", _));
  var z = function (e, t, n, r, i, o, a) {
      var s = 0,
        u = e.length,
        l = null == n;
      if ("object" === x(n)) {
        i = !0;
        for (s in n) z(e, t, s, n[s], !0, o, a);
      } else if (
        void 0 !== r &&
        ((i = !0),
        g(r) || (a = !0),
        l &&
          (a
            ? (t.call(e, r), (t = null))
            : ((l = t),
              (t = function (e, t, n) {
                return l.call(w(e), n);
              }))),
        t)
      )
        for (; s < u; s++) t(e[s], n, a ? r : r.call(e[s], s, t(e[s], n)));
      return i ? e : l ? t.call(e) : u ? t(e[0], n) : o;
    },
    X = /^-ms-/,
    U = /-([a-z])/g;
  function V(e, t) {
    return t.toUpperCase();
  }
  function G(e) {
    return e.replace(X, "ms-").replace(U, V);
  }
  var Y = function (e) {
    return 1 === e.nodeType || 9 === e.nodeType || !+e.nodeType;
  };
  function Q() {
    this.expando = w.expando + Q.uid++;
  }
  (Q.uid = 1),
    (Q.prototype = {
      cache: function (e) {
        var t = e[this.expando];
        return (
          t ||
            ((t = {}),
            Y(e) &&
              (e.nodeType
                ? (e[this.expando] = t)
                : Object.defineProperty(e, this.expando, {
                    value: t,
                    configurable: !0,
                  }))),
          t
        );
      },
      set: function (e, t, n) {
        var r,
          i = this.cache(e);
        if ("string" == typeof t) i[G(t)] = n;
        else for (r in t) i[G(r)] = t[r];
        return i;
      },
      get: function (e, t) {
        return void 0 === t
          ? this.cache(e)
          : e[this.expando] && e[this.expando][G(t)];
      },
      access: function (e, t, n) {
        return void 0 === t || (t && "string" == typeof t && void 0 === n)
          ? this.get(e, t)
          : (this.set(e, t, n), void 0 !== n ? n : t);
      },
      remove: function (e, t) {
        var n,
          r = e[this.expando];
        if (void 0 !== r) {
          if (void 0 !== t) {
            n = (t = Array.isArray(t)
              ? t.map(G)
              : (t = G(t)) in r
              ? [t]
              : t.match(M) || []).length;
            while (n--) delete r[t[n]];
          }
          (void 0 === t || w.isEmptyObject(r)) &&
            (e.nodeType ? (e[this.expando] = void 0) : delete e[this.expando]);
        }
      },
      hasData: function (e) {
        var t = e[this.expando];
        return void 0 !== t && !w.isEmptyObject(t);
      },
    });
  var J = new Q(),
    K = new Q(),
    Z = /^(?:\{[\w\W]*\}|\[[\w\W]*\])$/,
    ee = /[A-Z]/g;
  function te(e) {
    return (
      "true" === e ||
      ("false" !== e &&
        ("null" === e
          ? null
          : e === +e + ""
          ? +e
          : Z.test(e)
          ? JSON.parse(e)
          : e))
    );
  }
  function ne(e, t, n) {
    var r;
    if (void 0 === n && 1 === e.nodeType)
      if (
        ((r = "data-" + t.replace(ee, "-$&").toLowerCase()),
        "string" == typeof (n = e.getAttribute(r)))
      ) {
        try {
          n = te(n);
        } catch (e) {}
        K.set(e, t, n);
      } else n = void 0;
    return n;
  }
  w.extend({
    hasData: function (e) {
      return K.hasData(e) || J.hasData(e);
    },
    data: function (e, t, n) {
      return K.access(e, t, n);
    },
    removeData: function (e, t) {
      K.remove(e, t);
    },
    _data: function (e, t, n) {
      return J.access(e, t, n);
    },
    _removeData: function (e, t) {
      J.remove(e, t);
    },
  }),
    w.fn.extend({
      data: function (e, t) {
        var n,
          r,
          i,
          o = this[0],
          a = o && o.attributes;
        if (void 0 === e) {
          if (
            this.length &&
            ((i = K.get(o)), 1 === o.nodeType && !J.get(o, "hasDataAttrs"))
          ) {
            n = a.length;
            while (n--)
              a[n] &&
                0 === (r = a[n].name).indexOf("data-") &&
                ((r = G(r.slice(5))), ne(o, r, i[r]));
            J.set(o, "hasDataAttrs", !0);
          }
          return i;
        }
        return "object" == typeof e
          ? this.each(function () {
              K.set(this, e);
            })
          : z(
              this,
              function (t) {
                var n;
                if (o && void 0 === t) {
                  if (void 0 !== (n = K.get(o, e))) return n;
                  if (void 0 !== (n = ne(o, e))) return n;
                } else
                  this.each(function () {
                    K.set(this, e, t);
                  });
              },
              null,
              t,
              arguments.length > 1,
              null,
              !0
            );
      },
      removeData: function (e) {
        return this.each(function () {
          K.remove(this, e);
        });
      },
    }),
    w.extend({
      queue: function (e, t, n) {
        var r;
        if (e)
          return (
            (t = (t || "fx") + "queue"),
            (r = J.get(e, t)),
            n &&
              (!r || Array.isArray(n)
                ? (r = J.access(e, t, w.makeArray(n)))
                : r.push(n)),
            r || []
          );
      },
      dequeue: function (e, t) {
        t = t || "fx";
        var n = w.queue(e, t),
          r = n.length,
          i = n.shift(),
          o = w._queueHooks(e, t),
          a = function () {
            w.dequeue(e, t);
          };
        "inprogress" === i && ((i = n.shift()), r--),
          i &&
            ("fx" === t && n.unshift("inprogress"),
            delete o.stop,
            i.call(e, a, o)),
          !r && o && o.empty.fire();
      },
      _queueHooks: function (e, t) {
        var n = t + "queueHooks";
        return (
          J.get(e, n) ||
          J.access(e, n, {
            empty: w.Callbacks("once memory").add(function () {
              J.remove(e, [t + "queue", n]);
            }),
          })
        );
      },
    }),
    w.fn.extend({
      queue: function (e, t) {
        var n = 2;
        return (
          "string" != typeof e && ((t = e), (e = "fx"), n--),
          arguments.length < n
            ? w.queue(this[0], e)
            : void 0 === t
            ? this
            : this.each(function () {
                var n = w.queue(this, e, t);
                w._queueHooks(this, e),
                  "fx" === e && "inprogress" !== n[0] && w.dequeue(this, e);
              })
        );
      },
      dequeue: function (e) {
        return this.each(function () {
          w.dequeue(this, e);
        });
      },
      clearQueue: function (e) {
        return this.queue(e || "fx", []);
      },
      promise: function (e, t) {
        var n,
          r = 1,
          i = w.Deferred(),
          o = this,
          a = this.length,
          s = function () {
            --r || i.resolveWith(o, [o]);
          };
        "string" != typeof e && ((t = e), (e = void 0)), (e = e || "fx");
        while (a--)
          (n = J.get(o[a], e + "queueHooks")) &&
            n.empty &&
            (r++, n.empty.add(s));
        return s(), i.promise(t);
      },
    });
  var re = /[+-]?(?:\d*\.|)\d+(?:[eE][+-]?\d+|)/.source,
    ie = new RegExp("^(?:([+-])=|)(" + re + ")([a-z%]*)$", "i"),
    oe = ["Top", "Right", "Bottom", "Left"],
    ae = function (e, t) {
      return (
        "none" === (e = t || e).style.display ||
        ("" === e.style.display &&
          w.contains(e.ownerDocument, e) &&
          "none" === w.css(e, "display"))
      );
    },
    se = function (e, t, n, r) {
      var i,
        o,
        a = {};
      for (o in t) (a[o] = e.style[o]), (e.style[o] = t[o]);
      i = n.apply(e, r || []);
      for (o in t) e.style[o] = a[o];
      return i;
    };
  function ue(e, t, n, r) {
    var i,
      o,
      a = 20,
      s = r
        ? function () {
            return r.cur();
          }
        : function () {
            return w.css(e, t, "");
          },
      u = s(),
      l = (n && n[3]) || (w.cssNumber[t] ? "" : "px"),
      c = (w.cssNumber[t] || ("px" !== l && +u)) && ie.exec(w.css(e, t));
    if (c && c[3] !== l) {
      (u /= 2), (l = l || c[3]), (c = +u || 1);
      while (a--)
        w.style(e, t, c + l),
          (1 - o) * (1 - (o = s() / u || 0.5)) <= 0 && (a = 0),
          (c /= o);
      (c *= 2), w.style(e, t, c + l), (n = n || []);
    }
    return (
      n &&
        ((c = +c || +u || 0),
        (i = n[1] ? c + (n[1] + 1) * n[2] : +n[2]),
        r && ((r.unit = l), (r.start = c), (r.end = i))),
      i
    );
  }
  var le = {};
  function ce(e) {
    var t,
      n = e.ownerDocument,
      r = e.nodeName,
      i = le[r];
    return (
      i ||
      ((t = n.body.appendChild(n.createElement(r))),
      (i = w.css(t, "display")),
      t.parentNode.removeChild(t),
      "none" === i && (i = "block"),
      (le[r] = i),
      i)
    );
  }
  function fe(e, t) {
    for (var n, r, i = [], o = 0, a = e.length; o < a; o++)
      (r = e[o]).style &&
        ((n = r.style.display),
        t
          ? ("none" === n &&
              ((i[o] = J.get(r, "display") || null),
              i[o] || (r.style.display = "")),
            "" === r.style.display && ae(r) && (i[o] = ce(r)))
          : "none" !== n && ((i[o] = "none"), J.set(r, "display", n)));
    for (o = 0; o < a; o++) null != i[o] && (e[o].style.display = i[o]);
    return e;
  }
  w.fn.extend({
    show: function () {
      return fe(this, !0);
    },
    hide: function () {
      return fe(this);
    },
    toggle: function (e) {
      return "boolean" == typeof e
        ? e
          ? this.show()
          : this.hide()
        : this.each(function () {
            ae(this) ? w(this).show() : w(this).hide();
          });
    },
  });
  var pe = /^(?:checkbox|radio)$/i,
    de = /<([a-z][^\/\0>\x20\t\r\n\f]+)/i,
    he = /^$|^module$|\/(?:java|ecma)script/i,
    ge = {
      option: [1, "<select multiple='multiple'>", "</select>"],
      thead: [1, "<table>", "</table>"],
      col: [2, "<table><colgroup>", "</colgroup></table>"],
      tr: [2, "<table><tbody>", "</tbody></table>"],
      td: [3, "<table><tbody><tr>", "</tr></tbody></table>"],
      _default: [0, "", ""],
    };
  (ge.optgroup = ge.option),
    (ge.tbody = ge.tfoot = ge.colgroup = ge.caption = ge.thead),
    (ge.th = ge.td);
  function ye(e, t) {
    var n;
    return (
      (n =
        "undefined" != typeof e.getElementsByTagName
          ? e.getElementsByTagName(t || "*")
          : "undefined" != typeof e.querySelectorAll
          ? e.querySelectorAll(t || "*")
          : []),
      void 0 === t || (t && N(e, t)) ? w.merge([e], n) : n
    );
  }
  function ve(e, t) {
    for (var n = 0, r = e.length; n < r; n++)
      J.set(e[n], "globalEval", !t || J.get(t[n], "globalEval"));
  }
  var me = /<|&#?\w+;/;
  function xe(e, t, n, r, i) {
    for (
      var o,
        a,
        s,
        u,
        l,
        c,
        f = t.createDocumentFragment(),
        p = [],
        d = 0,
        h = e.length;
      d < h;
      d++
    )
      if ((o = e[d]) || 0 === o)
        if ("object" === x(o)) w.merge(p, o.nodeType ? [o] : o);
        else if (me.test(o)) {
          (a = a || f.appendChild(t.createElement("div"))),
            (s = (de.exec(o) || ["", ""])[1].toLowerCase()),
            (u = ge[s] || ge._default),
            (a.innerHTML = u[1] + w.htmlPrefilter(o) + u[2]),
            (c = u[0]);
          while (c--) a = a.lastChild;
          w.merge(p, a.childNodes), ((a = f.firstChild).textContent = "");
        } else p.push(t.createTextNode(o));
    (f.textContent = ""), (d = 0);
    while ((o = p[d++]))
      if (r && w.inArray(o, r) > -1) i && i.push(o);
      else if (
        ((l = w.contains(o.ownerDocument, o)),
        (a = ye(f.appendChild(o), "script")),
        l && ve(a),
        n)
      ) {
        c = 0;
        while ((o = a[c++])) he.test(o.type || "") && n.push(o);
      }
    return f;
  }
  !(function () {
    var e = r.createDocumentFragment().appendChild(r.createElement("div")),
      t = r.createElement("input");
    t.setAttribute("type", "radio"),
      t.setAttribute("checked", "checked"),
      t.setAttribute("name", "t"),
      e.appendChild(t),
      (h.checkClone = e.cloneNode(!0).cloneNode(!0).lastChild.checked),
      (e.innerHTML = "<textarea>x</textarea>"),
      (h.noCloneChecked = !!e.cloneNode(!0).lastChild.defaultValue);
  })();
  var be = r.documentElement,
    we = /^key/,
    Te = /^(?:mouse|pointer|contextmenu|drag|drop)|click/,
    Ce = /^([^.]*)(?:\.(.+)|)/;
  function Ee() {
    return !0;
  }
  function ke() {
    return !1;
  }
  function Se() {
    try {
      return r.activeElement;
    } catch (e) {}
  }
  function De(e, t, n, r, i, o) {
    var a, s;
    if ("object" == typeof t) {
      "string" != typeof n && ((r = r || n), (n = void 0));
      for (s in t) De(e, s, n, r, t[s], o);
      return e;
    }
    if (
      (null == r && null == i
        ? ((i = n), (r = n = void 0))
        : null == i &&
          ("string" == typeof n
            ? ((i = r), (r = void 0))
            : ((i = r), (r = n), (n = void 0))),
      !1 === i)
    )
      i = ke;
    else if (!i) return e;
    return (
      1 === o &&
        ((a = i),
        ((i = function (e) {
          return w().off(e), a.apply(this, arguments);
        }).guid = a.guid || (a.guid = w.guid++))),
      e.each(function () {
        w.event.add(this, t, i, r, n);
      })
    );
  }
  (w.event = {
    global: {},
    add: function (e, t, n, r, i) {
      var o,
        a,
        s,
        u,
        l,
        c,
        f,
        p,
        d,
        h,
        g,
        y = J.get(e);
      if (y) {
        n.handler && ((n = (o = n).handler), (i = o.selector)),
          i && w.find.matchesSelector(be, i),
          n.guid || (n.guid = w.guid++),
          (u = y.events) || (u = y.events = {}),
          (a = y.handle) ||
            (a = y.handle = function (t) {
              return "undefined" != typeof w && w.event.triggered !== t.type
                ? w.event.dispatch.apply(e, arguments)
                : void 0;
            }),
          (l = (t = (t || "").match(M) || [""]).length);
        while (l--)
          (d = g = (s = Ce.exec(t[l]) || [])[1]),
            (h = (s[2] || "").split(".").sort()),
            d &&
              ((f = w.event.special[d] || {}),
              (d = (i ? f.delegateType : f.bindType) || d),
              (f = w.event.special[d] || {}),
              (c = w.extend(
                {
                  type: d,
                  origType: g,
                  data: r,
                  handler: n,
                  guid: n.guid,
                  selector: i,
                  needsContext: i && w.expr.match.needsContext.test(i),
                  namespace: h.join("."),
                },
                o
              )),
              (p = u[d]) ||
                (((p = u[d] = []).delegateCount = 0),
                (f.setup && !1 !== f.setup.call(e, r, h, a)) ||
                  (e.addEventListener && e.addEventListener(d, a))),
              f.add &&
                (f.add.call(e, c), c.handler.guid || (c.handler.guid = n.guid)),
              i ? p.splice(p.delegateCount++, 0, c) : p.push(c),
              (w.event.global[d] = !0));
      }
    },
    remove: function (e, t, n, r, i) {
      var o,
        a,
        s,
        u,
        l,
        c,
        f,
        p,
        d,
        h,
        g,
        y = J.hasData(e) && J.get(e);
      if (y && (u = y.events)) {
        l = (t = (t || "").match(M) || [""]).length;
        while (l--)
          if (
            ((s = Ce.exec(t[l]) || []),
            (d = g = s[1]),
            (h = (s[2] || "").split(".").sort()),
            d)
          ) {
            (f = w.event.special[d] || {}),
              (p = u[(d = (r ? f.delegateType : f.bindType) || d)] || []),
              (s =
                s[2] &&
                new RegExp("(^|\\.)" + h.join("\\.(?:.*\\.|)") + "(\\.|$)")),
              (a = o = p.length);
            while (o--)
              (c = p[o]),
                (!i && g !== c.origType) ||
                  (n && n.guid !== c.guid) ||
                  (s && !s.test(c.namespace)) ||
                  (r && r !== c.selector && ("**" !== r || !c.selector)) ||
                  (p.splice(o, 1),
                  c.selector && p.delegateCount--,
                  f.remove && f.remove.call(e, c));
            a &&
              !p.length &&
              ((f.teardown && !1 !== f.teardown.call(e, h, y.handle)) ||
                w.removeEvent(e, d, y.handle),
              delete u[d]);
          } else for (d in u) w.event.remove(e, d + t[l], n, r, !0);
        w.isEmptyObject(u) && J.remove(e, "handle events");
      }
    },
    dispatch: function (e) {
      var t = w.event.fix(e),
        n,
        r,
        i,
        o,
        a,
        s,
        u = new Array(arguments.length),
        l = (J.get(this, "events") || {})[t.type] || [],
        c = w.event.special[t.type] || {};
      for (u[0] = t, n = 1; n < arguments.length; n++) u[n] = arguments[n];
      if (
        ((t.delegateTarget = this),
        !c.preDispatch || !1 !== c.preDispatch.call(this, t))
      ) {
        (s = w.event.handlers.call(this, t, l)), (n = 0);
        while ((o = s[n++]) && !t.isPropagationStopped()) {
          (t.currentTarget = o.elem), (r = 0);
          while ((a = o.handlers[r++]) && !t.isImmediatePropagationStopped())
            (t.rnamespace && !t.rnamespace.test(a.namespace)) ||
              ((t.handleObj = a),
              (t.data = a.data),
              void 0 !==
                (i = (
                  (w.event.special[a.origType] || {}).handle || a.handler
                ).apply(o.elem, u)) &&
                !1 === (t.result = i) &&
                (t.preventDefault(), t.stopPropagation()));
        }
        return c.postDispatch && c.postDispatch.call(this, t), t.result;
      }
    },
    handlers: function (e, t) {
      var n,
        r,
        i,
        o,
        a,
        s = [],
        u = t.delegateCount,
        l = e.target;
      if (u && l.nodeType && !("click" === e.type && e.button >= 1))
        for (; l !== this; l = l.parentNode || this)
          if (1 === l.nodeType && ("click" !== e.type || !0 !== l.disabled)) {
            for (o = [], a = {}, n = 0; n < u; n++)
              void 0 === a[(i = (r = t[n]).selector + " ")] &&
                (a[i] = r.needsContext
                  ? w(i, this).index(l) > -1
                  : w.find(i, this, null, [l]).length),
                a[i] && o.push(r);
            o.length && s.push({ elem: l, handlers: o });
          }
      return (
        (l = this), u < t.length && s.push({ elem: l, handlers: t.slice(u) }), s
      );
    },
    addProp: function (e, t) {
      Object.defineProperty(w.Event.prototype, e, {
        enumerable: !0,
        configurable: !0,
        get: g(t)
          ? function () {
              if (this.originalEvent) return t(this.originalEvent);
            }
          : function () {
              if (this.originalEvent) return this.originalEvent[e];
            },
        set: function (t) {
          Object.defineProperty(this, e, {
            enumerable: !0,
            configurable: !0,
            writable: !0,
            value: t,
          });
        },
      });
    },
    fix: function (e) {
      return e[w.expando] ? e : new w.Event(e);
    },
    special: {
      load: { noBubble: !0 },
      focus: {
        trigger: function () {
          if (this !== Se() && this.focus) return this.focus(), !1;
        },
        delegateType: "focusin",
      },
      blur: {
        trigger: function () {
          if (this === Se() && this.blur) return this.blur(), !1;
        },
        delegateType: "focusout",
      },
      click: {
        trigger: function () {
          if ("checkbox" === this.type && this.click && N(this, "input"))
            return this.click(), !1;
        },
        _default: function (e) {
          return N(e.target, "a");
        },
      },
      beforeunload: {
        postDispatch: function (e) {
          void 0 !== e.result &&
            e.originalEvent &&
            (e.originalEvent.returnValue = e.result);
        },
      },
    },
  }),
    (w.removeEvent = function (e, t, n) {
      e.removeEventListener && e.removeEventListener(t, n);
    }),
    (w.Event = function (e, t) {
      if (!(this instanceof w.Event)) return new w.Event(e, t);
      e && e.type
        ? ((this.originalEvent = e),
          (this.type = e.type),
          (this.isDefaultPrevented =
            e.defaultPrevented ||
            (void 0 === e.defaultPrevented && !1 === e.returnValue)
              ? Ee
              : ke),
          (this.target =
            e.target && 3 === e.target.nodeType
              ? e.target.parentNode
              : e.target),
          (this.currentTarget = e.currentTarget),
          (this.relatedTarget = e.relatedTarget))
        : (this.type = e),
        t && w.extend(this, t),
        (this.timeStamp = (e && e.timeStamp) || Date.now()),
        (this[w.expando] = !0);
    }),
    (w.Event.prototype = {
      constructor: w.Event,
      isDefaultPrevented: ke,
      isPropagationStopped: ke,
      isImmediatePropagationStopped: ke,
      isSimulated: !1,
      preventDefault: function () {
        var e = this.originalEvent;
        (this.isDefaultPrevented = Ee),
          e && !this.isSimulated && e.preventDefault();
      },
      stopPropagation: function () {
        var e = this.originalEvent;
        (this.isPropagationStopped = Ee),
          e && !this.isSimulated && e.stopPropagation();
      },
      stopImmediatePropagation: function () {
        var e = this.originalEvent;
        (this.isImmediatePropagationStopped = Ee),
          e && !this.isSimulated && e.stopImmediatePropagation(),
          this.stopPropagation();
      },
    }),
    w.each(
      {
        altKey: !0,
        bubbles: !0,
        cancelable: !0,
        changedTouches: !0,
        ctrlKey: !0,
        detail: !0,
        eventPhase: !0,
        metaKey: !0,
        pageX: !0,
        pageY: !0,
        shiftKey: !0,
        view: !0,
        char: !0,
        charCode: !0,
        key: !0,
        keyCode: !0,
        button: !0,
        buttons: !0,
        clientX: !0,
        clientY: !0,
        offsetX: !0,
        offsetY: !0,
        pointerId: !0,
        pointerType: !0,
        screenX: !0,
        screenY: !0,
        targetTouches: !0,
        toElement: !0,
        touches: !0,
        which: function (e) {
          var t = e.button;
          return null == e.which && we.test(e.type)
            ? null != e.charCode
              ? e.charCode
              : e.keyCode
            : !e.which && void 0 !== t && Te.test(e.type)
            ? 1 & t
              ? 1
              : 2 & t
              ? 3
              : 4 & t
              ? 2
              : 0
            : e.which;
        },
      },
      w.event.addProp
    ),
    w.each(
      {
        mouseenter: "mouseover",
        mouseleave: "mouseout",
        pointerenter: "pointerover",
        pointerleave: "pointerout",
      },
      function (e, t) {
        w.event.special[e] = {
          delegateType: t,
          bindType: t,
          handle: function (e) {
            var n,
              r = this,
              i = e.relatedTarget,
              o = e.handleObj;
            return (
              (i && (i === r || w.contains(r, i))) ||
                ((e.type = o.origType),
                (n = o.handler.apply(this, arguments)),
                (e.type = t)),
              n
            );
          },
        };
      }
    ),
    w.fn.extend({
      on: function (e, t, n, r) {
        return De(this, e, t, n, r);
      },
      one: function (e, t, n, r) {
        return De(this, e, t, n, r, 1);
      },
      off: function (e, t, n) {
        var r, i;
        if (e && e.preventDefault && e.handleObj)
          return (
            (r = e.handleObj),
            w(e.delegateTarget).off(
              r.namespace ? r.origType + "." + r.namespace : r.origType,
              r.selector,
              r.handler
            ),
            this
          );
        if ("object" == typeof e) {
          for (i in e) this.off(i, t, e[i]);
          return this;
        }
        return (
          (!1 !== t && "function" != typeof t) || ((n = t), (t = void 0)),
          !1 === n && (n = ke),
          this.each(function () {
            w.event.remove(this, e, n, t);
          })
        );
      },
    });
  var Ne = /<(?!area|br|col|embed|hr|img|input|link|meta|param)(([a-z][^\/\0>\x20\t\r\n\f]*)[^>]*)\/>/gi,
    Ae = /<script|<style|<link/i,
    je = /checked\s*(?:[^=]|=\s*.checked.)/i,
    qe = /^\s*<!(?:\[CDATA\[|--)|(?:\]\]|--)>\s*$/g;
  function Le(e, t) {
    return N(e, "table") && N(11 !== t.nodeType ? t : t.firstChild, "tr")
      ? w(e).children("tbody")[0] || e
      : e;
  }
  function He(e) {
    return (e.type = (null !== e.getAttribute("type")) + "/" + e.type), e;
  }
  function Oe(e) {
    return (
      "true/" === (e.type || "").slice(0, 5)
        ? (e.type = e.type.slice(5))
        : e.removeAttribute("type"),
      e
    );
  }
  function Pe(e, t) {
    var n, r, i, o, a, s, u, l;
    if (1 === t.nodeType) {
      if (
        J.hasData(e) &&
        ((o = J.access(e)), (a = J.set(t, o)), (l = o.events))
      ) {
        delete a.handle, (a.events = {});
        for (i in l)
          for (n = 0, r = l[i].length; n < r; n++) w.event.add(t, i, l[i][n]);
      }
      K.hasData(e) && ((s = K.access(e)), (u = w.extend({}, s)), K.set(t, u));
    }
  }
  function Me(e, t) {
    var n = t.nodeName.toLowerCase();
    "input" === n && pe.test(e.type)
      ? (t.checked = e.checked)
      : ("input" !== n && "textarea" !== n) ||
        (t.defaultValue = e.defaultValue);
  }
  function Re(e, t, n, r) {
    t = a.apply([], t);
    var i,
      o,
      s,
      u,
      l,
      c,
      f = 0,
      p = e.length,
      d = p - 1,
      y = t[0],
      v = g(y);
    if (v || (p > 1 && "string" == typeof y && !h.checkClone && je.test(y)))
      return e.each(function (i) {
        var o = e.eq(i);
        v && (t[0] = y.call(this, i, o.html())), Re(o, t, n, r);
      });
    if (
      p &&
      ((i = xe(t, e[0].ownerDocument, !1, e, r)),
      (o = i.firstChild),
      1 === i.childNodes.length && (i = o),
      o || r)
    ) {
      for (u = (s = w.map(ye(i, "script"), He)).length; f < p; f++)
        (l = i),
          f !== d &&
            ((l = w.clone(l, !0, !0)), u && w.merge(s, ye(l, "script"))),
          n.call(e[f], l, f);
      if (u)
        for (c = s[s.length - 1].ownerDocument, w.map(s, Oe), f = 0; f < u; f++)
          (l = s[f]),
            he.test(l.type || "") &&
              !J.access(l, "globalEval") &&
              w.contains(c, l) &&
              (l.src && "module" !== (l.type || "").toLowerCase()
                ? w._evalUrl && w._evalUrl(l.src)
                : m(l.textContent.replace(qe, ""), c, l));
    }
    return e;
  }
  function Ie(e, t, n) {
    for (var r, i = t ? w.filter(t, e) : e, o = 0; null != (r = i[o]); o++)
      n || 1 !== r.nodeType || w.cleanData(ye(r)),
        r.parentNode &&
          (n && w.contains(r.ownerDocument, r) && ve(ye(r, "script")),
          r.parentNode.removeChild(r));
    return e;
  }
  w.extend({
    htmlPrefilter: function (e) {
      return e.replace(Ne, "<$1></$2>");
    },
    clone: function (e, t, n) {
      var r,
        i,
        o,
        a,
        s = e.cloneNode(!0),
        u = w.contains(e.ownerDocument, e);
      if (
        !(
          h.noCloneChecked ||
          (1 !== e.nodeType && 11 !== e.nodeType) ||
          w.isXMLDoc(e)
        )
      )
        for (a = ye(s), r = 0, i = (o = ye(e)).length; r < i; r++)
          Me(o[r], a[r]);
      if (t)
        if (n)
          for (o = o || ye(e), a = a || ye(s), r = 0, i = o.length; r < i; r++)
            Pe(o[r], a[r]);
        else Pe(e, s);
      return (
        (a = ye(s, "script")).length > 0 && ve(a, !u && ye(e, "script")), s
      );
    },
    cleanData: function (e) {
      for (var t, n, r, i = w.event.special, o = 0; void 0 !== (n = e[o]); o++)
        if (Y(n)) {
          if ((t = n[J.expando])) {
            if (t.events)
              for (r in t.events)
                i[r] ? w.event.remove(n, r) : w.removeEvent(n, r, t.handle);
            n[J.expando] = void 0;
          }
          n[K.expando] && (n[K.expando] = void 0);
        }
    },
  }),
    w.fn.extend({
      detach: function (e) {
        return Ie(this, e, !0);
      },
      remove: function (e) {
        return Ie(this, e);
      },
      text: function (e) {
        return z(
          this,
          function (e) {
            return void 0 === e
              ? w.text(this)
              : this.empty().each(function () {
                  (1 !== this.nodeType &&
                    11 !== this.nodeType &&
                    9 !== this.nodeType) ||
                    (this.textContent = e);
                });
          },
          null,
          e,
          arguments.length
        );
      },
      append: function () {
        return Re(this, arguments, function (e) {
          (1 !== this.nodeType &&
            11 !== this.nodeType &&
            9 !== this.nodeType) ||
            Le(this, e).appendChild(e);
        });
      },
      prepend: function () {
        return Re(this, arguments, function (e) {
          if (
            1 === this.nodeType ||
            11 === this.nodeType ||
            9 === this.nodeType
          ) {
            var t = Le(this, e);
            t.insertBefore(e, t.firstChild);
          }
        });
      },
      before: function () {
        return Re(this, arguments, function (e) {
          this.parentNode && this.parentNode.insertBefore(e, this);
        });
      },
      after: function () {
        return Re(this, arguments, function (e) {
          this.parentNode && this.parentNode.insertBefore(e, this.nextSibling);
        });
      },
      empty: function () {
        for (var e, t = 0; null != (e = this[t]); t++)
          1 === e.nodeType && (w.cleanData(ye(e, !1)), (e.textContent = ""));
        return this;
      },
      clone: function (e, t) {
        return (
          (e = null != e && e),
          (t = null == t ? e : t),
          this.map(function () {
            return w.clone(this, e, t);
          })
        );
      },
      html: function (e) {
        return z(
          this,
          function (e) {
            var t = this[0] || {},
              n = 0,
              r = this.length;
            if (void 0 === e && 1 === t.nodeType) return t.innerHTML;
            if (
              "string" == typeof e &&
              !Ae.test(e) &&
              !ge[(de.exec(e) || ["", ""])[1].toLowerCase()]
            ) {
              e = w.htmlPrefilter(e);
              try {
                for (; n < r; n++)
                  1 === (t = this[n] || {}).nodeType &&
                    (w.cleanData(ye(t, !1)), (t.innerHTML = e));
                t = 0;
              } catch (e) {}
            }
            t && this.empty().append(e);
          },
          null,
          e,
          arguments.length
        );
      },
      replaceWith: function () {
        var e = [];
        return Re(
          this,
          arguments,
          function (t) {
            var n = this.parentNode;
            w.inArray(this, e) < 0 &&
              (w.cleanData(ye(this)), n && n.replaceChild(t, this));
          },
          e
        );
      },
    }),
    w.each(
      {
        appendTo: "append",
        prependTo: "prepend",
        insertBefore: "before",
        insertAfter: "after",
        replaceAll: "replaceWith",
      },
      function (e, t) {
        w.fn[e] = function (e) {
          for (var n, r = [], i = w(e), o = i.length - 1, a = 0; a <= o; a++)
            (n = a === o ? this : this.clone(!0)),
              w(i[a])[t](n),
              s.apply(r, n.get());
          return this.pushStack(r);
        };
      }
    );
  var We = new RegExp("^(" + re + ")(?!px)[a-z%]+$", "i"),
    $e = function (t) {
      var n = t.ownerDocument.defaultView;
      return (n && n.opener) || (n = e), n.getComputedStyle(t);
    },
    Be = new RegExp(oe.join("|"), "i");
  !(function () {
    function t() {
      if (c) {
        (l.style.cssText =
          "position:absolute;left:-11111px;width:60px;margin-top:1px;padding:0;border:0"),
          (c.style.cssText =
            "position:relative;display:block;box-sizing:border-box;overflow:scroll;margin:auto;border:1px;padding:1px;width:60%;top:1%"),
          be.appendChild(l).appendChild(c);
        var t = e.getComputedStyle(c);
        (i = "1%" !== t.top),
          (u = 12 === n(t.marginLeft)),
          (c.style.right = "60%"),
          (s = 36 === n(t.right)),
          (o = 36 === n(t.width)),
          (c.style.position = "absolute"),
          (a = 36 === c.offsetWidth || "absolute"),
          be.removeChild(l),
          (c = null);
      }
    }
    function n(e) {
      return Math.round(parseFloat(e));
    }
    var i,
      o,
      a,
      s,
      u,
      l = r.createElement("div"),
      c = r.createElement("div");
    c.style &&
      ((c.style.backgroundClip = "content-box"),
      (c.cloneNode(!0).style.backgroundClip = ""),
      (h.clearCloneStyle = "content-box" === c.style.backgroundClip),
      w.extend(h, {
        boxSizingReliable: function () {
          return t(), o;
        },
        pixelBoxStyles: function () {
          return t(), s;
        },
        pixelPosition: function () {
          return t(), i;
        },
        reliableMarginLeft: function () {
          return t(), u;
        },
        scrollboxSize: function () {
          return t(), a;
        },
      }));
  })();
  function Fe(e, t, n) {
    var r,
      i,
      o,
      a,
      s = e.style;
    return (
      (n = n || $e(e)) &&
        ("" !== (a = n.getPropertyValue(t) || n[t]) ||
          w.contains(e.ownerDocument, e) ||
          (a = w.style(e, t)),
        !h.pixelBoxStyles() &&
          We.test(a) &&
          Be.test(t) &&
          ((r = s.width),
          (i = s.minWidth),
          (o = s.maxWidth),
          (s.minWidth = s.maxWidth = s.width = a),
          (a = n.width),
          (s.width = r),
          (s.minWidth = i),
          (s.maxWidth = o))),
      void 0 !== a ? a + "" : a
    );
  }
  function _e(e, t) {
    return {
      get: function () {
        if (!e()) return (this.get = t).apply(this, arguments);
        delete this.get;
      },
    };
  }
  var ze = /^(none|table(?!-c[ea]).+)/,
    Xe = /^--/,
    Ue = { position: "absolute", visibility: "hidden", display: "block" },
    Ve = { letterSpacing: "0", fontWeight: "400" },
    Ge = ["Webkit", "Moz", "ms"],
    Ye = r.createElement("div").style;
  function Qe(e) {
    if (e in Ye) return e;
    var t = e[0].toUpperCase() + e.slice(1),
      n = Ge.length;
    while (n--) if ((e = Ge[n] + t) in Ye) return e;
  }
  function Je(e) {
    var t = w.cssProps[e];
    return t || (t = w.cssProps[e] = Qe(e) || e), t;
  }
  function Ke(e, t, n) {
    var r = ie.exec(t);
    return r ? Math.max(0, r[2] - (n || 0)) + (r[3] || "px") : t;
  }
  function Ze(e, t, n, r, i, o) {
    var a = "width" === t ? 1 : 0,
      s = 0,
      u = 0;
    if (n === (r ? "border" : "content")) return 0;
    for (; a < 4; a += 2)
      "margin" === n && (u += w.css(e, n + oe[a], !0, i)),
        r
          ? ("content" === n && (u -= w.css(e, "padding" + oe[a], !0, i)),
            "margin" !== n &&
              (u -= w.css(e, "border" + oe[a] + "Width", !0, i)))
          : ((u += w.css(e, "padding" + oe[a], !0, i)),
            "padding" !== n
              ? (u += w.css(e, "border" + oe[a] + "Width", !0, i))
              : (s += w.css(e, "border" + oe[a] + "Width", !0, i)));
    return (
      !r &&
        o >= 0 &&
        (u += Math.max(
          0,
          Math.ceil(
            e["offset" + t[0].toUpperCase() + t.slice(1)] - o - u - s - 0.5
          )
        )),
      u
    );
  }
  function et(e, t, n) {
    var r = $e(e),
      i = Fe(e, t, r),
      o = "border-box" === w.css(e, "boxSizing", !1, r),
      a = o;
    if (We.test(i)) {
      if (!n) return i;
      i = "auto";
    }
    return (
      (a = a && (h.boxSizingReliable() || i === e.style[t])),
      ("auto" === i ||
        (!parseFloat(i) && "inline" === w.css(e, "display", !1, r))) &&
        ((i = e["offset" + t[0].toUpperCase() + t.slice(1)]), (a = !0)),
      (i = parseFloat(i) || 0) +
        Ze(e, t, n || (o ? "border" : "content"), a, r, i) +
        "px"
    );
  }
  w.extend({
    cssHooks: {
      opacity: {
        get: function (e, t) {
          if (t) {
            var n = Fe(e, "opacity");
            return "" === n ? "1" : n;
          }
        },
      },
    },
    cssNumber: {
      animationIterationCount: !0,
      columnCount: !0,
      fillOpacity: !0,
      flexGrow: !0,
      flexShrink: !0,
      fontWeight: !0,
      lineHeight: !0,
      opacity: !0,
      order: !0,
      orphans: !0,
      widows: !0,
      zIndex: !0,
      zoom: !0,
    },
    cssProps: {},
    style: function (e, t, n, r) {
      if (e && 3 !== e.nodeType && 8 !== e.nodeType && e.style) {
        var i,
          o,
          a,
          s = G(t),
          u = Xe.test(t),
          l = e.style;
        if (
          (u || (t = Je(s)), (a = w.cssHooks[t] || w.cssHooks[s]), void 0 === n)
        )
          return a && "get" in a && void 0 !== (i = a.get(e, !1, r)) ? i : l[t];
        "string" == (o = typeof n) &&
          (i = ie.exec(n)) &&
          i[1] &&
          ((n = ue(e, t, i)), (o = "number")),
          null != n &&
            n === n &&
            ("number" === o &&
              (n += (i && i[3]) || (w.cssNumber[s] ? "" : "px")),
            h.clearCloneStyle ||
              "" !== n ||
              0 !== t.indexOf("background") ||
              (l[t] = "inherit"),
            (a && "set" in a && void 0 === (n = a.set(e, n, r))) ||
              (u ? l.setProperty(t, n) : (l[t] = n)));
      }
    },
    css: function (e, t, n, r) {
      var i,
        o,
        a,
        s = G(t);
      return (
        Xe.test(t) || (t = Je(s)),
        (a = w.cssHooks[t] || w.cssHooks[s]) &&
          "get" in a &&
          (i = a.get(e, !0, n)),
        void 0 === i && (i = Fe(e, t, r)),
        "normal" === i && t in Ve && (i = Ve[t]),
        "" === n || n
          ? ((o = parseFloat(i)), !0 === n || isFinite(o) ? o || 0 : i)
          : i
      );
    },
  }),
    w.each(["height", "width"], function (e, t) {
      w.cssHooks[t] = {
        get: function (e, n, r) {
          if (n)
            return !ze.test(w.css(e, "display")) ||
              (e.getClientRects().length && e.getBoundingClientRect().width)
              ? et(e, t, r)
              : se(e, Ue, function () {
                  return et(e, t, r);
                });
        },
        set: function (e, n, r) {
          var i,
            o = $e(e),
            a = "border-box" === w.css(e, "boxSizing", !1, o),
            s = r && Ze(e, t, r, a, o);
          return (
            a &&
              h.scrollboxSize() === o.position &&
              (s -= Math.ceil(
                e["offset" + t[0].toUpperCase() + t.slice(1)] -
                  parseFloat(o[t]) -
                  Ze(e, t, "border", !1, o) -
                  0.5
              )),
            s &&
              (i = ie.exec(n)) &&
              "px" !== (i[3] || "px") &&
              ((e.style[t] = n), (n = w.css(e, t))),
            Ke(e, n, s)
          );
        },
      };
    }),
    (w.cssHooks.marginLeft = _e(h.reliableMarginLeft, function (e, t) {
      if (t)
        return (
          (parseFloat(Fe(e, "marginLeft")) ||
            e.getBoundingClientRect().left -
              se(e, { marginLeft: 0 }, function () {
                return e.getBoundingClientRect().left;
              })) + "px"
        );
    })),
    w.each({ margin: "", padding: "", border: "Width" }, function (e, t) {
      (w.cssHooks[e + t] = {
        expand: function (n) {
          for (
            var r = 0, i = {}, o = "string" == typeof n ? n.split(" ") : [n];
            r < 4;
            r++
          )
            i[e + oe[r] + t] = o[r] || o[r - 2] || o[0];
          return i;
        },
      }),
        "margin" !== e && (w.cssHooks[e + t].set = Ke);
    }),
    w.fn.extend({
      css: function (e, t) {
        return z(
          this,
          function (e, t, n) {
            var r,
              i,
              o = {},
              a = 0;
            if (Array.isArray(t)) {
              for (r = $e(e), i = t.length; a < i; a++)
                o[t[a]] = w.css(e, t[a], !1, r);
              return o;
            }
            return void 0 !== n ? w.style(e, t, n) : w.css(e, t);
          },
          e,
          t,
          arguments.length > 1
        );
      },
    });
  function tt(e, t, n, r, i) {
    return new tt.prototype.init(e, t, n, r, i);
  }
  (w.Tween = tt),
    (tt.prototype = {
      constructor: tt,
      init: function (e, t, n, r, i, o) {
        (this.elem = e),
          (this.prop = n),
          (this.easing = i || w.easing._default),
          (this.options = t),
          (this.start = this.now = this.cur()),
          (this.end = r),
          (this.unit = o || (w.cssNumber[n] ? "" : "px"));
      },
      cur: function () {
        var e = tt.propHooks[this.prop];
        return e && e.get ? e.get(this) : tt.propHooks._default.get(this);
      },
      run: function (e) {
        var t,
          n = tt.propHooks[this.prop];
        return (
          this.options.duration
            ? (this.pos = t = w.easing[this.easing](
                e,
                this.options.duration * e,
                0,
                1,
                this.options.duration
              ))
            : (this.pos = t = e),
          (this.now = (this.end - this.start) * t + this.start),
          this.options.step &&
            this.options.step.call(this.elem, this.now, this),
          n && n.set ? n.set(this) : tt.propHooks._default.set(this),
          this
        );
      },
    }),
    (tt.prototype.init.prototype = tt.prototype),
    (tt.propHooks = {
      _default: {
        get: function (e) {
          var t;
          return 1 !== e.elem.nodeType ||
            (null != e.elem[e.prop] && null == e.elem.style[e.prop])
            ? e.elem[e.prop]
            : (t = w.css(e.elem, e.prop, "")) && "auto" !== t
            ? t
            : 0;
        },
        set: function (e) {
          w.fx.step[e.prop]
            ? w.fx.step[e.prop](e)
            : 1 !== e.elem.nodeType ||
              (null == e.elem.style[w.cssProps[e.prop]] && !w.cssHooks[e.prop])
            ? (e.elem[e.prop] = e.now)
            : w.style(e.elem, e.prop, e.now + e.unit);
        },
      },
    }),
    (tt.propHooks.scrollTop = tt.propHooks.scrollLeft = {
      set: function (e) {
        e.elem.nodeType && e.elem.parentNode && (e.elem[e.prop] = e.now);
      },
    }),
    (w.easing = {
      linear: function (e) {
        return e;
      },
      swing: function (e) {
        return 0.5 - Math.cos(e * Math.PI) / 2;
      },
      _default: "swing",
    }),
    (w.fx = tt.prototype.init),
    (w.fx.step = {});
  var nt,
    rt,
    it = /^(?:toggle|show|hide)$/,
    ot = /queueHooks$/;
  function at() {
    rt &&
      (!1 === r.hidden && e.requestAnimationFrame
        ? e.requestAnimationFrame(at)
        : e.setTimeout(at, w.fx.interval),
      w.fx.tick());
  }
  function st() {
    return (
      e.setTimeout(function () {
        nt = void 0;
      }),
      (nt = Date.now())
    );
  }
  function ut(e, t) {
    var n,
      r = 0,
      i = { height: e };
    for (t = t ? 1 : 0; r < 4; r += 2 - t)
      i["margin" + (n = oe[r])] = i["padding" + n] = e;
    return t && (i.opacity = i.width = e), i;
  }
  function lt(e, t, n) {
    for (
      var r,
        i = (pt.tweeners[t] || []).concat(pt.tweeners["*"]),
        o = 0,
        a = i.length;
      o < a;
      o++
    )
      if ((r = i[o].call(n, t, e))) return r;
  }
  function ct(e, t, n) {
    var r,
      i,
      o,
      a,
      s,
      u,
      l,
      c,
      f = "width" in t || "height" in t,
      p = this,
      d = {},
      h = e.style,
      g = e.nodeType && ae(e),
      y = J.get(e, "fxshow");
    n.queue ||
      (null == (a = w._queueHooks(e, "fx")).unqueued &&
        ((a.unqueued = 0),
        (s = a.empty.fire),
        (a.empty.fire = function () {
          a.unqueued || s();
        })),
      a.unqueued++,
      p.always(function () {
        p.always(function () {
          a.unqueued--, w.queue(e, "fx").length || a.empty.fire();
        });
      }));
    for (r in t)
      if (((i = t[r]), it.test(i))) {
        if (
          (delete t[r], (o = o || "toggle" === i), i === (g ? "hide" : "show"))
        ) {
          if ("show" !== i || !y || void 0 === y[r]) continue;
          g = !0;
        }
        d[r] = (y && y[r]) || w.style(e, r);
      }
    if ((u = !w.isEmptyObject(t)) || !w.isEmptyObject(d)) {
      f &&
        1 === e.nodeType &&
        ((n.overflow = [h.overflow, h.overflowX, h.overflowY]),
        null == (l = y && y.display) && (l = J.get(e, "display")),
        "none" === (c = w.css(e, "display")) &&
          (l
            ? (c = l)
            : (fe([e], !0),
              (l = e.style.display || l),
              (c = w.css(e, "display")),
              fe([e]))),
        ("inline" === c || ("inline-block" === c && null != l)) &&
          "none" === w.css(e, "float") &&
          (u ||
            (p.done(function () {
              h.display = l;
            }),
            null == l && ((c = h.display), (l = "none" === c ? "" : c))),
          (h.display = "inline-block"))),
        n.overflow &&
          ((h.overflow = "hidden"),
          p.always(function () {
            (h.overflow = n.overflow[0]),
              (h.overflowX = n.overflow[1]),
              (h.overflowY = n.overflow[2]);
          })),
        (u = !1);
      for (r in d)
        u ||
          (y
            ? "hidden" in y && (g = y.hidden)
            : (y = J.access(e, "fxshow", { display: l })),
          o && (y.hidden = !g),
          g && fe([e], !0),
          p.done(function () {
            g || fe([e]), J.remove(e, "fxshow");
            for (r in d) w.style(e, r, d[r]);
          })),
          (u = lt(g ? y[r] : 0, r, p)),
          r in y || ((y[r] = u.start), g && ((u.end = u.start), (u.start = 0)));
    }
  }
  function ft(e, t) {
    var n, r, i, o, a;
    for (n in e)
      if (
        ((r = G(n)),
        (i = t[r]),
        (o = e[n]),
        Array.isArray(o) && ((i = o[1]), (o = e[n] = o[0])),
        n !== r && ((e[r] = o), delete e[n]),
        (a = w.cssHooks[r]) && "expand" in a)
      ) {
        (o = a.expand(o)), delete e[r];
        for (n in o) n in e || ((e[n] = o[n]), (t[n] = i));
      } else t[r] = i;
  }
  function pt(e, t, n) {
    var r,
      i,
      o = 0,
      a = pt.prefilters.length,
      s = w.Deferred().always(function () {
        delete u.elem;
      }),
      u = function () {
        if (i) return !1;
        for (
          var t = nt || st(),
            n = Math.max(0, l.startTime + l.duration - t),
            r = 1 - (n / l.duration || 0),
            o = 0,
            a = l.tweens.length;
          o < a;
          o++
        )
          l.tweens[o].run(r);
        return (
          s.notifyWith(e, [l, r, n]),
          r < 1 && a
            ? n
            : (a || s.notifyWith(e, [l, 1, 0]), s.resolveWith(e, [l]), !1)
        );
      },
      l = s.promise({
        elem: e,
        props: w.extend({}, t),
        opts: w.extend(!0, { specialEasing: {}, easing: w.easing._default }, n),
        originalProperties: t,
        originalOptions: n,
        startTime: nt || st(),
        duration: n.duration,
        tweens: [],
        createTween: function (t, n) {
          var r = w.Tween(
            e,
            l.opts,
            t,
            n,
            l.opts.specialEasing[t] || l.opts.easing
          );
          return l.tweens.push(r), r;
        },
        stop: function (t) {
          var n = 0,
            r = t ? l.tweens.length : 0;
          if (i) return this;
          for (i = !0; n < r; n++) l.tweens[n].run(1);
          return (
            t
              ? (s.notifyWith(e, [l, 1, 0]), s.resolveWith(e, [l, t]))
              : s.rejectWith(e, [l, t]),
            this
          );
        },
      }),
      c = l.props;
    for (ft(c, l.opts.specialEasing); o < a; o++)
      if ((r = pt.prefilters[o].call(l, e, c, l.opts)))
        return (
          g(r.stop) &&
            (w._queueHooks(l.elem, l.opts.queue).stop = r.stop.bind(r)),
          r
        );
    return (
      w.map(c, lt, l),
      g(l.opts.start) && l.opts.start.call(e, l),
      l
        .progress(l.opts.progress)
        .done(l.opts.done, l.opts.complete)
        .fail(l.opts.fail)
        .always(l.opts.always),
      w.fx.timer(w.extend(u, { elem: e, anim: l, queue: l.opts.queue })),
      l
    );
  }
  (w.Animation = w.extend(pt, {
    tweeners: {
      "*": [
        function (e, t) {
          var n = this.createTween(e, t);
          return ue(n.elem, e, ie.exec(t), n), n;
        },
      ],
    },
    tweener: function (e, t) {
      g(e) ? ((t = e), (e = ["*"])) : (e = e.match(M));
      for (var n, r = 0, i = e.length; r < i; r++)
        (n = e[r]),
          (pt.tweeners[n] = pt.tweeners[n] || []),
          pt.tweeners[n].unshift(t);
    },
    prefilters: [ct],
    prefilter: function (e, t) {
      t ? pt.prefilters.unshift(e) : pt.prefilters.push(e);
    },
  })),
    (w.speed = function (e, t, n) {
      var r =
        e && "object" == typeof e
          ? w.extend({}, e)
          : {
              complete: n || (!n && t) || (g(e) && e),
              duration: e,
              easing: (n && t) || (t && !g(t) && t),
            };
      return (
        w.fx.off
          ? (r.duration = 0)
          : "number" != typeof r.duration &&
            (r.duration in w.fx.speeds
              ? (r.duration = w.fx.speeds[r.duration])
              : (r.duration = w.fx.speeds._default)),
        (null != r.queue && !0 !== r.queue) || (r.queue = "fx"),
        (r.old = r.complete),
        (r.complete = function () {
          g(r.old) && r.old.call(this), r.queue && w.dequeue(this, r.queue);
        }),
        r
      );
    }),
    w.fn.extend({
      fadeTo: function (e, t, n, r) {
        return this.filter(ae)
          .css("opacity", 0)
          .show()
          .end()
          .animate({ opacity: t }, e, n, r);
      },
      animate: function (e, t, n, r) {
        var i = w.isEmptyObject(e),
          o = w.speed(t, n, r),
          a = function () {
            var t = pt(this, w.extend({}, e), o);
            (i || J.get(this, "finish")) && t.stop(!0);
          };
        return (
          (a.finish = a),
          i || !1 === o.queue ? this.each(a) : this.queue(o.queue, a)
        );
      },
      stop: function (e, t, n) {
        var r = function (e) {
          var t = e.stop;
          delete e.stop, t(n);
        };
        return (
          "string" != typeof e && ((n = t), (t = e), (e = void 0)),
          t && !1 !== e && this.queue(e || "fx", []),
          this.each(function () {
            var t = !0,
              i = null != e && e + "queueHooks",
              o = w.timers,
              a = J.get(this);
            if (i) a[i] && a[i].stop && r(a[i]);
            else for (i in a) a[i] && a[i].stop && ot.test(i) && r(a[i]);
            for (i = o.length; i--; )
              o[i].elem !== this ||
                (null != e && o[i].queue !== e) ||
                (o[i].anim.stop(n), (t = !1), o.splice(i, 1));
            (!t && n) || w.dequeue(this, e);
          })
        );
      },
      finish: function (e) {
        return (
          !1 !== e && (e = e || "fx"),
          this.each(function () {
            var t,
              n = J.get(this),
              r = n[e + "queue"],
              i = n[e + "queueHooks"],
              o = w.timers,
              a = r ? r.length : 0;
            for (
              n.finish = !0,
                w.queue(this, e, []),
                i && i.stop && i.stop.call(this, !0),
                t = o.length;
              t--;

            )
              o[t].elem === this &&
                o[t].queue === e &&
                (o[t].anim.stop(!0), o.splice(t, 1));
            for (t = 0; t < a; t++)
              r[t] && r[t].finish && r[t].finish.call(this);
            delete n.finish;
          })
        );
      },
    }),
    w.each(["toggle", "show", "hide"], function (e, t) {
      var n = w.fn[t];
      w.fn[t] = function (e, r, i) {
        return null == e || "boolean" == typeof e
          ? n.apply(this, arguments)
          : this.animate(ut(t, !0), e, r, i);
      };
    }),
    w.each(
      {
        slideDown: ut("show"),
        slideUp: ut("hide"),
        slideToggle: ut("toggle"),
        fadeIn: { opacity: "show" },
        fadeOut: { opacity: "hide" },
        fadeToggle: { opacity: "toggle" },
      },
      function (e, t) {
        w.fn[e] = function (e, n, r) {
          return this.animate(t, e, n, r);
        };
      }
    ),
    (w.timers = []),
    (w.fx.tick = function () {
      var e,
        t = 0,
        n = w.timers;
      for (nt = Date.now(); t < n.length; t++)
        (e = n[t])() || n[t] !== e || n.splice(t--, 1);
      n.length || w.fx.stop(), (nt = void 0);
    }),
    (w.fx.timer = function (e) {
      w.timers.push(e), w.fx.start();
    }),
    (w.fx.interval = 13),
    (w.fx.start = function () {
      rt || ((rt = !0), at());
    }),
    (w.fx.stop = function () {
      rt = null;
    }),
    (w.fx.speeds = { slow: 600, fast: 200, _default: 400 }),
    (w.fn.delay = function (t, n) {
      return (
        (t = w.fx ? w.fx.speeds[t] || t : t),
        (n = n || "fx"),
        this.queue(n, function (n, r) {
          var i = e.setTimeout(n, t);
          r.stop = function () {
            e.clearTimeout(i);
          };
        })
      );
    }),
    (function () {
      var e = r.createElement("input"),
        t = r.createElement("select").appendChild(r.createElement("option"));
      (e.type = "checkbox"),
        (h.checkOn = "" !== e.value),
        (h.optSelected = t.selected),
        ((e = r.createElement("input")).value = "t"),
        (e.type = "radio"),
        (h.radioValue = "t" === e.value);
    })();
  var dt,
    ht = w.expr.attrHandle;
  w.fn.extend({
    attr: function (e, t) {
      return z(this, w.attr, e, t, arguments.length > 1);
    },
    removeAttr: function (e) {
      return this.each(function () {
        w.removeAttr(this, e);
      });
    },
  }),
    w.extend({
      attr: function (e, t, n) {
        var r,
          i,
          o = e.nodeType;
        if (3 !== o && 8 !== o && 2 !== o)
          return "undefined" == typeof e.getAttribute
            ? w.prop(e, t, n)
            : ((1 === o && w.isXMLDoc(e)) ||
                (i =
                  w.attrHooks[t.toLowerCase()] ||
                  (w.expr.match.bool.test(t) ? dt : void 0)),
              void 0 !== n
                ? null === n
                  ? void w.removeAttr(e, t)
                  : i && "set" in i && void 0 !== (r = i.set(e, n, t))
                  ? r
                  : (e.setAttribute(t, n + ""), n)
                : i && "get" in i && null !== (r = i.get(e, t))
                ? r
                : null == (r = w.find.attr(e, t))
                ? void 0
                : r);
      },
      attrHooks: {
        type: {
          set: function (e, t) {
            if (!h.radioValue && "radio" === t && N(e, "input")) {
              var n = e.value;
              return e.setAttribute("type", t), n && (e.value = n), t;
            }
          },
        },
      },
      removeAttr: function (e, t) {
        var n,
          r = 0,
          i = t && t.match(M);
        if (i && 1 === e.nodeType) while ((n = i[r++])) e.removeAttribute(n);
      },
    }),
    (dt = {
      set: function (e, t, n) {
        return !1 === t ? w.removeAttr(e, n) : e.setAttribute(n, n), n;
      },
    }),
    w.each(w.expr.match.bool.source.match(/\w+/g), function (e, t) {
      var n = ht[t] || w.find.attr;
      ht[t] = function (e, t, r) {
        var i,
          o,
          a = t.toLowerCase();
        return (
          r ||
            ((o = ht[a]),
            (ht[a] = i),
            (i = null != n(e, t, r) ? a : null),
            (ht[a] = o)),
          i
        );
      };
    });
  var gt = /^(?:input|select|textarea|button)$/i,
    yt = /^(?:a|area)$/i;
  w.fn.extend({
    prop: function (e, t) {
      return z(this, w.prop, e, t, arguments.length > 1);
    },
    removeProp: function (e) {
      return this.each(function () {
        delete this[w.propFix[e] || e];
      });
    },
  }),
    w.extend({
      prop: function (e, t, n) {
        var r,
          i,
          o = e.nodeType;
        if (3 !== o && 8 !== o && 2 !== o)
          return (
            (1 === o && w.isXMLDoc(e)) ||
              ((t = w.propFix[t] || t), (i = w.propHooks[t])),
            void 0 !== n
              ? i && "set" in i && void 0 !== (r = i.set(e, n, t))
                ? r
                : (e[t] = n)
              : i && "get" in i && null !== (r = i.get(e, t))
              ? r
              : e[t]
          );
      },
      propHooks: {
        tabIndex: {
          get: function (e) {
            var t = w.find.attr(e, "tabindex");
            return t
              ? parseInt(t, 10)
              : gt.test(e.nodeName) || (yt.test(e.nodeName) && e.href)
              ? 0
              : -1;
          },
        },
      },
      propFix: { for: "htmlFor", class: "className" },
    }),
    h.optSelected ||
      (w.propHooks.selected = {
        get: function (e) {
          var t = e.parentNode;
          return t && t.parentNode && t.parentNode.selectedIndex, null;
        },
        set: function (e) {
          var t = e.parentNode;
          t && (t.selectedIndex, t.parentNode && t.parentNode.selectedIndex);
        },
      }),
    w.each(
      [
        "tabIndex",
        "readOnly",
        "maxLength",
        "cellSpacing",
        "cellPadding",
        "rowSpan",
        "colSpan",
        "useMap",
        "frameBorder",
        "contentEditable",
      ],
      function () {
        w.propFix[this.toLowerCase()] = this;
      }
    );
  function vt(e) {
    return (e.match(M) || []).join(" ");
  }
  function mt(e) {
    return (e.getAttribute && e.getAttribute("class")) || "";
  }
  function xt(e) {
    return Array.isArray(e) ? e : "string" == typeof e ? e.match(M) || [] : [];
  }
  w.fn.extend({
    addClass: function (e) {
      var t,
        n,
        r,
        i,
        o,
        a,
        s,
        u = 0;
      if (g(e))
        return this.each(function (t) {
          w(this).addClass(e.call(this, t, mt(this)));
        });
      if ((t = xt(e)).length)
        while ((n = this[u++]))
          if (((i = mt(n)), (r = 1 === n.nodeType && " " + vt(i) + " "))) {
            a = 0;
            while ((o = t[a++])) r.indexOf(" " + o + " ") < 0 && (r += o + " ");
            i !== (s = vt(r)) && n.setAttribute("class", s);
          }
      return this;
    },
    removeClass: function (e) {
      var t,
        n,
        r,
        i,
        o,
        a,
        s,
        u = 0;
      if (g(e))
        return this.each(function (t) {
          w(this).removeClass(e.call(this, t, mt(this)));
        });
      if (!arguments.length) return this.attr("class", "");
      if ((t = xt(e)).length)
        while ((n = this[u++]))
          if (((i = mt(n)), (r = 1 === n.nodeType && " " + vt(i) + " "))) {
            a = 0;
            while ((o = t[a++]))
              while (r.indexOf(" " + o + " ") > -1)
                r = r.replace(" " + o + " ", " ");
            i !== (s = vt(r)) && n.setAttribute("class", s);
          }
      return this;
    },
    toggleClass: function (e, t) {
      var n = typeof e,
        r = "string" === n || Array.isArray(e);
      return "boolean" == typeof t && r
        ? t
          ? this.addClass(e)
          : this.removeClass(e)
        : g(e)
        ? this.each(function (n) {
            w(this).toggleClass(e.call(this, n, mt(this), t), t);
          })
        : this.each(function () {
            var t, i, o, a;
            if (r) {
              (i = 0), (o = w(this)), (a = xt(e));
              while ((t = a[i++]))
                o.hasClass(t) ? o.removeClass(t) : o.addClass(t);
            } else (void 0 !== e && "boolean" !== n) || ((t = mt(this)) && J.set(this, "__className__", t), this.setAttribute && this.setAttribute("class", t || !1 === e ? "" : J.get(this, "__className__") || ""));
          });
    },
    hasClass: function (e) {
      var t,
        n,
        r = 0;
      t = " " + e + " ";
      while ((n = this[r++]))
        if (1 === n.nodeType && (" " + vt(mt(n)) + " ").indexOf(t) > -1)
          return !0;
      return !1;
    },
  });
  var bt = /\r/g;
  w.fn.extend({
    val: function (e) {
      var t,
        n,
        r,
        i = this[0];
      {
        if (arguments.length)
          return (
            (r = g(e)),
            this.each(function (n) {
              var i;
              1 === this.nodeType &&
                (null == (i = r ? e.call(this, n, w(this).val()) : e)
                  ? (i = "")
                  : "number" == typeof i
                  ? (i += "")
                  : Array.isArray(i) &&
                    (i = w.map(i, function (e) {
                      return null == e ? "" : e + "";
                    })),
                ((t =
                  w.valHooks[this.type] ||
                  w.valHooks[this.nodeName.toLowerCase()]) &&
                  "set" in t &&
                  void 0 !== t.set(this, i, "value")) ||
                  (this.value = i));
            })
          );
        if (i)
          return (t =
            w.valHooks[i.type] || w.valHooks[i.nodeName.toLowerCase()]) &&
            "get" in t &&
            void 0 !== (n = t.get(i, "value"))
            ? n
            : "string" == typeof (n = i.value)
            ? n.replace(bt, "")
            : null == n
            ? ""
            : n;
      }
    },
  }),
    w.extend({
      valHooks: {
        option: {
          get: function (e) {
            var t = w.find.attr(e, "value");
            return null != t ? t : vt(w.text(e));
          },
        },
        select: {
          get: function (e) {
            var t,
              n,
              r,
              i = e.options,
              o = e.selectedIndex,
              a = "select-one" === e.type,
              s = a ? null : [],
              u = a ? o + 1 : i.length;
            for (r = o < 0 ? u : a ? o : 0; r < u; r++)
              if (
                ((n = i[r]).selected || r === o) &&
                !n.disabled &&
                (!n.parentNode.disabled || !N(n.parentNode, "optgroup"))
              ) {
                if (((t = w(n).val()), a)) return t;
                s.push(t);
              }
            return s;
          },
          set: function (e, t) {
            var n,
              r,
              i = e.options,
              o = w.makeArray(t),
              a = i.length;
            while (a--)
              ((r = i[a]).selected =
                w.inArray(w.valHooks.option.get(r), o) > -1) && (n = !0);
            return n || (e.selectedIndex = -1), o;
          },
        },
      },
    }),
    w.each(["radio", "checkbox"], function () {
      (w.valHooks[this] = {
        set: function (e, t) {
          if (Array.isArray(t))
            return (e.checked = w.inArray(w(e).val(), t) > -1);
        },
      }),
        h.checkOn ||
          (w.valHooks[this].get = function (e) {
            return null === e.getAttribute("value") ? "on" : e.value;
          });
    }),
    (h.focusin = "onfocusin" in e);
  var wt = /^(?:focusinfocus|focusoutblur)$/,
    Tt = function (e) {
      e.stopPropagation();
    };
  w.extend(w.event, {
    trigger: function (t, n, i, o) {
      var a,
        s,
        u,
        l,
        c,
        p,
        d,
        h,
        v = [i || r],
        m = f.call(t, "type") ? t.type : t,
        x = f.call(t, "namespace") ? t.namespace.split(".") : [];
      if (
        ((s = h = u = i = i || r),
        3 !== i.nodeType &&
          8 !== i.nodeType &&
          !wt.test(m + w.event.triggered) &&
          (m.indexOf(".") > -1 && ((m = (x = m.split(".")).shift()), x.sort()),
          (c = m.indexOf(":") < 0 && "on" + m),
          (t = t[w.expando] ? t : new w.Event(m, "object" == typeof t && t)),
          (t.isTrigger = o ? 2 : 3),
          (t.namespace = x.join(".")),
          (t.rnamespace = t.namespace
            ? new RegExp("(^|\\.)" + x.join("\\.(?:.*\\.|)") + "(\\.|$)")
            : null),
          (t.result = void 0),
          t.target || (t.target = i),
          (n = null == n ? [t] : w.makeArray(n, [t])),
          (d = w.event.special[m] || {}),
          o || !d.trigger || !1 !== d.trigger.apply(i, n)))
      ) {
        if (!o && !d.noBubble && !y(i)) {
          for (
            l = d.delegateType || m, wt.test(l + m) || (s = s.parentNode);
            s;
            s = s.parentNode
          )
            v.push(s), (u = s);
          u === (i.ownerDocument || r) &&
            v.push(u.defaultView || u.parentWindow || e);
        }
        a = 0;
        while ((s = v[a++]) && !t.isPropagationStopped())
          (h = s),
            (t.type = a > 1 ? l : d.bindType || m),
            (p = (J.get(s, "events") || {})[t.type] && J.get(s, "handle")) &&
              p.apply(s, n),
            (p = c && s[c]) &&
              p.apply &&
              Y(s) &&
              ((t.result = p.apply(s, n)),
              !1 === t.result && t.preventDefault());
        return (
          (t.type = m),
          o ||
            t.isDefaultPrevented() ||
            (d._default && !1 !== d._default.apply(v.pop(), n)) ||
            !Y(i) ||
            (c &&
              g(i[m]) &&
              !y(i) &&
              ((u = i[c]) && (i[c] = null),
              (w.event.triggered = m),
              t.isPropagationStopped() && h.addEventListener(m, Tt),
              i[m](),
              t.isPropagationStopped() && h.removeEventListener(m, Tt),
              (w.event.triggered = void 0),
              u && (i[c] = u))),
          t.result
        );
      }
    },
    simulate: function (e, t, n) {
      var r = w.extend(new w.Event(), n, { type: e, isSimulated: !0 });
      w.event.trigger(r, null, t);
    },
  }),
    w.fn.extend({
      trigger: function (e, t) {
        return this.each(function () {
          w.event.trigger(e, t, this);
        });
      },
      triggerHandler: function (e, t) {
        var n = this[0];
        if (n) return w.event.trigger(e, t, n, !0);
      },
    }),
    h.focusin ||
      w.each({ focus: "focusin", blur: "focusout" }, function (e, t) {
        var n = function (e) {
          w.event.simulate(t, e.target, w.event.fix(e));
        };
        w.event.special[t] = {
          setup: function () {
            var r = this.ownerDocument || this,
              i = J.access(r, t);
            i || r.addEventListener(e, n, !0), J.access(r, t, (i || 0) + 1);
          },
          teardown: function () {
            var r = this.ownerDocument || this,
              i = J.access(r, t) - 1;
            i
              ? J.access(r, t, i)
              : (r.removeEventListener(e, n, !0), J.remove(r, t));
          },
        };
      });
  var Ct = e.location,
    Et = Date.now(),
    kt = /\?/;
  w.parseXML = function (t) {
    var n;
    if (!t || "string" != typeof t) return null;
    try {
      n = new e.DOMParser().parseFromString(t, "text/xml");
    } catch (e) {
      n = void 0;
    }
    return (
      (n && !n.getElementsByTagName("parsererror").length) ||
        w.error("Invalid XML: " + t),
      n
    );
  };
  var St = /\[\]$/,
    Dt = /\r?\n/g,
    Nt = /^(?:submit|button|image|reset|file)$/i,
    At = /^(?:input|select|textarea|keygen)/i;
  function jt(e, t, n, r) {
    var i;
    if (Array.isArray(t))
      w.each(t, function (t, i) {
        n || St.test(e)
          ? r(e, i)
          : jt(
              e + "[" + ("object" == typeof i && null != i ? t : "") + "]",
              i,
              n,
              r
            );
      });
    else if (n || "object" !== x(t)) r(e, t);
    else for (i in t) jt(e + "[" + i + "]", t[i], n, r);
  }
  (w.param = function (e, t) {
    var n,
      r = [],
      i = function (e, t) {
        var n = g(t) ? t() : t;
        r[r.length] =
          encodeURIComponent(e) + "=" + encodeURIComponent(null == n ? "" : n);
      };
    if (Array.isArray(e) || (e.jquery && !w.isPlainObject(e)))
      w.each(e, function () {
        i(this.name, this.value);
      });
    else for (n in e) jt(n, e[n], t, i);
    return r.join("&");
  }),
    w.fn.extend({
      serialize: function () {
        return w.param(this.serializeArray());
      },
      serializeArray: function () {
        return this.map(function () {
          var e = w.prop(this, "elements");
          return e ? w.makeArray(e) : this;
        })
          .filter(function () {
            var e = this.type;
            return (
              this.name &&
              !w(this).is(":disabled") &&
              At.test(this.nodeName) &&
              !Nt.test(e) &&
              (this.checked || !pe.test(e))
            );
          })
          .map(function (e, t) {
            var n = w(this).val();
            return null == n
              ? null
              : Array.isArray(n)
              ? w.map(n, function (e) {
                  return { name: t.name, value: e.replace(Dt, "\r\n") };
                })
              : { name: t.name, value: n.replace(Dt, "\r\n") };
          })
          .get();
      },
    });
  var qt = /%20/g,
    Lt = /#.*$/,
    Ht = /([?&])_=[^&]*/,
    Ot = /^(.*?):[ \t]*([^\r\n]*)$/gm,
    Pt = /^(?:about|app|app-storage|.+-extension|file|res|widget):$/,
    Mt = /^(?:GET|HEAD)$/,
    Rt = /^\/\//,
    It = {},
    Wt = {},
    $t = "*/".concat("*"),
    Bt = r.createElement("a");
  Bt.href = Ct.href;
  function Ft(e) {
    return function (t, n) {
      "string" != typeof t && ((n = t), (t = "*"));
      var r,
        i = 0,
        o = t.toLowerCase().match(M) || [];
      if (g(n))
        while ((r = o[i++]))
          "+" === r[0]
            ? ((r = r.slice(1) || "*"), (e[r] = e[r] || []).unshift(n))
            : (e[r] = e[r] || []).push(n);
    };
  }
  function _t(e, t, n, r) {
    var i = {},
      o = e === Wt;
    function a(s) {
      var u;
      return (
        (i[s] = !0),
        w.each(e[s] || [], function (e, s) {
          var l = s(t, n, r);
          return "string" != typeof l || o || i[l]
            ? o
              ? !(u = l)
              : void 0
            : (t.dataTypes.unshift(l), a(l), !1);
        }),
        u
      );
    }
    return a(t.dataTypes[0]) || (!i["*"] && a("*"));
  }
  function zt(e, t) {
    var n,
      r,
      i = w.ajaxSettings.flatOptions || {};
    for (n in t) void 0 !== t[n] && ((i[n] ? e : r || (r = {}))[n] = t[n]);
    return r && w.extend(!0, e, r), e;
  }
  function Xt(e, t, n) {
    var r,
      i,
      o,
      a,
      s = e.contents,
      u = e.dataTypes;
    while ("*" === u[0])
      u.shift(),
        void 0 === r && (r = e.mimeType || t.getResponseHeader("Content-Type"));
    if (r)
      for (i in s)
        if (s[i] && s[i].test(r)) {
          u.unshift(i);
          break;
        }
    if (u[0] in n) o = u[0];
    else {
      for (i in n) {
        if (!u[0] || e.converters[i + " " + u[0]]) {
          o = i;
          break;
        }
        a || (a = i);
      }
      o = o || a;
    }
    if (o) return o !== u[0] && u.unshift(o), n[o];
  }
  function Ut(e, t, n, r) {
    var i,
      o,
      a,
      s,
      u,
      l = {},
      c = e.dataTypes.slice();
    if (c[1]) for (a in e.converters) l[a.toLowerCase()] = e.converters[a];
    o = c.shift();
    while (o)
      if (
        (e.responseFields[o] && (n[e.responseFields[o]] = t),
        !u && r && e.dataFilter && (t = e.dataFilter(t, e.dataType)),
        (u = o),
        (o = c.shift()))
      )
        if ("*" === o) o = u;
        else if ("*" !== u && u !== o) {
          if (!(a = l[u + " " + o] || l["* " + o]))
            for (i in l)
              if (
                (s = i.split(" "))[1] === o &&
                (a = l[u + " " + s[0]] || l["* " + s[0]])
              ) {
                !0 === a
                  ? (a = l[i])
                  : !0 !== l[i] && ((o = s[0]), c.unshift(s[1]));
                break;
              }
          if (!0 !== a)
            if (a && e["throws"]) t = a(t);
            else
              try {
                t = a(t);
              } catch (e) {
                return {
                  state: "parsererror",
                  error: a ? e : "No conversion from " + u + " to " + o,
                };
              }
        }
    return { state: "success", data: t };
  }
  w.extend({
    active: 0,
    lastModified: {},
    etag: {},
    ajaxSettings: {
      url: Ct.href,
      type: "GET",
      isLocal: Pt.test(Ct.protocol),
      global: !0,
      processData: !0,
      async: !0,
      contentType: "application/x-www-form-urlencoded; charset=UTF-8",
      accepts: {
        "*": $t,
        text: "text/plain",
        html: "text/html",
        xml: "application/xml, text/xml",
        json: "application/json, text/javascript",
      },
      contents: { xml: /\bxml\b/, html: /\bhtml/, json: /\bjson\b/ },
      responseFields: {
        xml: "responseXML",
        text: "responseText",
        json: "responseJSON",
      },
      converters: {
        "* text": String,
        "text html": !0,
        "text json": JSON.parse,
        "text xml": w.parseXML,
      },
      flatOptions: { url: !0, context: !0 },
    },
    ajaxSetup: function (e, t) {
      return t ? zt(zt(e, w.ajaxSettings), t) : zt(w.ajaxSettings, e);
    },
    ajaxPrefilter: Ft(It),
    ajaxTransport: Ft(Wt),
    ajax: function (t, n) {
      "object" == typeof t && ((n = t), (t = void 0)), (n = n || {});
      var i,
        o,
        a,
        s,
        u,
        l,
        c,
        f,
        p,
        d,
        h = w.ajaxSetup({}, n),
        g = h.context || h,
        y = h.context && (g.nodeType || g.jquery) ? w(g) : w.event,
        v = w.Deferred(),
        m = w.Callbacks("once memory"),
        x = h.statusCode || {},
        b = {},
        T = {},
        C = "canceled",
        E = {
          readyState: 0,
          getResponseHeader: function (e) {
            var t;
            if (c) {
              if (!s) {
                s = {};
                while ((t = Ot.exec(a))) s[t[1].toLowerCase()] = t[2];
              }
              t = s[e.toLowerCase()];
            }
            return null == t ? null : t;
          },
          getAllResponseHeaders: function () {
            return c ? a : null;
          },
          setRequestHeader: function (e, t) {
            return (
              null == c &&
                ((e = T[e.toLowerCase()] = T[e.toLowerCase()] || e),
                (b[e] = t)),
              this
            );
          },
          overrideMimeType: function (e) {
            return null == c && (h.mimeType = e), this;
          },
          statusCode: function (e) {
            var t;
            if (e)
              if (c) E.always(e[E.status]);
              else for (t in e) x[t] = [x[t], e[t]];
            return this;
          },
          abort: function (e) {
            var t = e || C;
            return i && i.abort(t), k(0, t), this;
          },
        };
      if (
        (v.promise(E),
        (h.url = ((t || h.url || Ct.href) + "").replace(
          Rt,
          Ct.protocol + "//"
        )),
        (h.type = n.method || n.type || h.method || h.type),
        (h.dataTypes = (h.dataType || "*").toLowerCase().match(M) || [""]),
        null == h.crossDomain)
      ) {
        l = r.createElement("a");
        try {
          (l.href = h.url),
            (l.href = l.href),
            (h.crossDomain =
              Bt.protocol + "//" + Bt.host != l.protocol + "//" + l.host);
        } catch (e) {
          h.crossDomain = !0;
        }
      }
      if (
        (h.data &&
          h.processData &&
          "string" != typeof h.data &&
          (h.data = w.param(h.data, h.traditional)),
        _t(It, h, n, E),
        c)
      )
        return E;
      (f = w.event && h.global) &&
        0 == w.active++ &&
        w.event.trigger("ajaxStart"),
        (h.type = h.type.toUpperCase()),
        (h.hasContent = !Mt.test(h.type)),
        (o = h.url.replace(Lt, "")),
        h.hasContent
          ? h.data &&
            h.processData &&
            0 ===
              (h.contentType || "").indexOf(
                "application/x-www-form-urlencoded"
              ) &&
            (h.data = h.data.replace(qt, "+"))
          : ((d = h.url.slice(o.length)),
            h.data &&
              (h.processData || "string" == typeof h.data) &&
              ((o += (kt.test(o) ? "&" : "?") + h.data), delete h.data),
            !1 === h.cache &&
              ((o = o.replace(Ht, "$1")),
              (d = (kt.test(o) ? "&" : "?") + "_=" + Et++ + d)),
            (h.url = o + d)),
        h.ifModified &&
          (w.lastModified[o] &&
            E.setRequestHeader("If-Modified-Since", w.lastModified[o]),
          w.etag[o] && E.setRequestHeader("If-None-Match", w.etag[o])),
        ((h.data && h.hasContent && !1 !== h.contentType) || n.contentType) &&
          E.setRequestHeader("Content-Type", h.contentType),
        E.setRequestHeader(
          "Accept",
          h.dataTypes[0] && h.accepts[h.dataTypes[0]]
            ? h.accepts[h.dataTypes[0]] +
                ("*" !== h.dataTypes[0] ? ", " + $t + "; q=0.01" : "")
            : h.accepts["*"]
        );
      for (p in h.headers) E.setRequestHeader(p, h.headers[p]);
      if (h.beforeSend && (!1 === h.beforeSend.call(g, E, h) || c))
        return E.abort();
      if (
        ((C = "abort"),
        m.add(h.complete),
        E.done(h.success),
        E.fail(h.error),
        (i = _t(Wt, h, n, E)))
      ) {
        if (((E.readyState = 1), f && y.trigger("ajaxSend", [E, h]), c))
          return E;
        h.async &&
          h.timeout > 0 &&
          (u = e.setTimeout(function () {
            E.abort("timeout");
          }, h.timeout));
        try {
          (c = !1), i.send(b, k);
        } catch (e) {
          if (c) throw e;
          k(-1, e);
        }
      } else k(-1, "No Transport");
      function k(t, n, r, s) {
        var l,
          p,
          d,
          b,
          T,
          C = n;
        c ||
          ((c = !0),
          u && e.clearTimeout(u),
          (i = void 0),
          (a = s || ""),
          (E.readyState = t > 0 ? 4 : 0),
          (l = (t >= 200 && t < 300) || 304 === t),
          r && (b = Xt(h, E, r)),
          (b = Ut(h, b, E, l)),
          l
            ? (h.ifModified &&
                ((T = E.getResponseHeader("Last-Modified")) &&
                  (w.lastModified[o] = T),
                (T = E.getResponseHeader("etag")) && (w.etag[o] = T)),
              204 === t || "HEAD" === h.type
                ? (C = "nocontent")
                : 304 === t
                ? (C = "notmodified")
                : ((C = b.state), (p = b.data), (l = !(d = b.error))))
            : ((d = C), (!t && C) || ((C = "error"), t < 0 && (t = 0))),
          (E.status = t),
          (E.statusText = (n || C) + ""),
          l ? v.resolveWith(g, [p, C, E]) : v.rejectWith(g, [E, C, d]),
          E.statusCode(x),
          (x = void 0),
          f && y.trigger(l ? "ajaxSuccess" : "ajaxError", [E, h, l ? p : d]),
          m.fireWith(g, [E, C]),
          f &&
            (y.trigger("ajaxComplete", [E, h]),
            --w.active || w.event.trigger("ajaxStop")));
      }
      return E;
    },
    getJSON: function (e, t, n) {
      return w.get(e, t, n, "json");
    },
    getScript: function (e, t) {
      return w.get(e, void 0, t, "script");
    },
  }),
    w.each(["get", "post"], function (e, t) {
      w[t] = function (e, n, r, i) {
        return (
          g(n) && ((i = i || r), (r = n), (n = void 0)),
          w.ajax(
            w.extend(
              { url: e, type: t, dataType: i, data: n, success: r },
              w.isPlainObject(e) && e
            )
          )
        );
      };
    }),
    (w._evalUrl = function (e) {
      return w.ajax({
        url: e,
        type: "GET",
        dataType: "script",
        cache: !0,
        async: !1,
        global: !1,
        throws: !0,
      });
    }),
    w.fn.extend({
      wrapAll: function (e) {
        var t;
        return (
          this[0] &&
            (g(e) && (e = e.call(this[0])),
            (t = w(e, this[0].ownerDocument).eq(0).clone(!0)),
            this[0].parentNode && t.insertBefore(this[0]),
            t
              .map(function () {
                var e = this;
                while (e.firstElementChild) e = e.firstElementChild;
                return e;
              })
              .append(this)),
          this
        );
      },
      wrapInner: function (e) {
        return g(e)
          ? this.each(function (t) {
              w(this).wrapInner(e.call(this, t));
            })
          : this.each(function () {
              var t = w(this),
                n = t.contents();
              n.length ? n.wrapAll(e) : t.append(e);
            });
      },
      wrap: function (e) {
        var t = g(e);
        return this.each(function (n) {
          w(this).wrapAll(t ? e.call(this, n) : e);
        });
      },
      unwrap: function (e) {
        return (
          this.parent(e)
            .not("body")
            .each(function () {
              w(this).replaceWith(this.childNodes);
            }),
          this
        );
      },
    }),
    (w.expr.pseudos.hidden = function (e) {
      return !w.expr.pseudos.visible(e);
    }),
    (w.expr.pseudos.visible = function (e) {
      return !!(e.offsetWidth || e.offsetHeight || e.getClientRects().length);
    }),
    (w.ajaxSettings.xhr = function () {
      try {
        return new e.XMLHttpRequest();
      } catch (e) {}
    });
  var Vt = { 0: 200, 1223: 204 },
    Gt = w.ajaxSettings.xhr();
  (h.cors = !!Gt && "withCredentials" in Gt),
    (h.ajax = Gt = !!Gt),
    w.ajaxTransport(function (t) {
      var n, r;
      if (h.cors || (Gt && !t.crossDomain))
        return {
          send: function (i, o) {
            var a,
              s = t.xhr();
            if (
              (s.open(t.type, t.url, t.async, t.username, t.password),
              t.xhrFields)
            )
              for (a in t.xhrFields) s[a] = t.xhrFields[a];
            t.mimeType && s.overrideMimeType && s.overrideMimeType(t.mimeType),
              t.crossDomain ||
                i["X-Requested-With"] ||
                (i["X-Requested-With"] = "XMLHttpRequest");
            for (a in i) s.setRequestHeader(a, i[a]);
            (n = function (e) {
              return function () {
                n &&
                  ((n = r = s.onload = s.onerror = s.onabort = s.ontimeout = s.onreadystatechange = null),
                  "abort" === e
                    ? s.abort()
                    : "error" === e
                    ? "number" != typeof s.status
                      ? o(0, "error")
                      : o(s.status, s.statusText)
                    : o(
                        Vt[s.status] || s.status,
                        s.statusText,
                        "text" !== (s.responseType || "text") ||
                          "string" != typeof s.responseText
                          ? { binary: s.response }
                          : { text: s.responseText },
                        s.getAllResponseHeaders()
                      ));
              };
            }),
              (s.onload = n()),
              (r = s.onerror = s.ontimeout = n("error")),
              void 0 !== s.onabort
                ? (s.onabort = r)
                : (s.onreadystatechange = function () {
                    4 === s.readyState &&
                      e.setTimeout(function () {
                        n && r();
                      });
                  }),
              (n = n("abort"));
            try {
              s.send((t.hasContent && t.data) || null);
            } catch (e) {
              if (n) throw e;
            }
          },
          abort: function () {
            n && n();
          },
        };
    }),
    w.ajaxPrefilter(function (e) {
      e.crossDomain && (e.contents.script = !1);
    }),
    w.ajaxSetup({
      accepts: {
        script:
          "text/javascript, application/javascript, application/ecmascript, application/x-ecmascript",
      },
      contents: { script: /\b(?:java|ecma)script\b/ },
      converters: {
        "text script": function (e) {
          return w.globalEval(e), e;
        },
      },
    }),
    w.ajaxPrefilter("script", function (e) {
      void 0 === e.cache && (e.cache = !1), e.crossDomain && (e.type = "GET");
    }),
    w.ajaxTransport("script", function (e) {
      if (e.crossDomain) {
        var t, n;
        return {
          send: function (i, o) {
            (t = w("<script>")
              .prop({ charset: e.scriptCharset, src: e.url })
              .on(
                "load error",
                (n = function (e) {
                  t.remove(),
                    (n = null),
                    e && o("error" === e.type ? 404 : 200, e.type);
                })
              )),
              r.head.appendChild(t[0]);
          },
          abort: function () {
            n && n();
          },
        };
      }
    });
  var Yt = [],
    Qt = /(=)\?(?=&|$)|\?\?/;
  w.ajaxSetup({
    jsonp: "callback",
    jsonpCallback: function () {
      var e = Yt.pop() || w.expando + "_" + Et++;
      return (this[e] = !0), e;
    },
  }),
    w.ajaxPrefilter("json jsonp", function (t, n, r) {
      var i,
        o,
        a,
        s =
          !1 !== t.jsonp &&
          (Qt.test(t.url)
            ? "url"
            : "string" == typeof t.data &&
              0 ===
                (t.contentType || "").indexOf(
                  "application/x-www-form-urlencoded"
                ) &&
              Qt.test(t.data) &&
              "data");
      if (s || "jsonp" === t.dataTypes[0])
        return (
          (i = t.jsonpCallback = g(t.jsonpCallback)
            ? t.jsonpCallback()
            : t.jsonpCallback),
          s
            ? (t[s] = t[s].replace(Qt, "$1" + i))
            : !1 !== t.jsonp &&
              (t.url += (kt.test(t.url) ? "&" : "?") + t.jsonp + "=" + i),
          (t.converters["script json"] = function () {
            return a || w.error(i + " was not called"), a[0];
          }),
          (t.dataTypes[0] = "json"),
          (o = e[i]),
          (e[i] = function () {
            a = arguments;
          }),
          r.always(function () {
            void 0 === o ? w(e).removeProp(i) : (e[i] = o),
              t[i] && ((t.jsonpCallback = n.jsonpCallback), Yt.push(i)),
              a && g(o) && o(a[0]),
              (a = o = void 0);
          }),
          "script"
        );
    }),
    (h.createHTMLDocument = (function () {
      var e = r.implementation.createHTMLDocument("").body;
      return (
        (e.innerHTML = "<form></form><form></form>"), 2 === e.childNodes.length
      );
    })()),
    (w.parseHTML = function (e, t, n) {
      if ("string" != typeof e) return [];
      "boolean" == typeof t && ((n = t), (t = !1));
      var i, o, a;
      return (
        t ||
          (h.createHTMLDocument
            ? (((i = (t = r.implementation.createHTMLDocument(
                ""
              )).createElement("base")).href = r.location.href),
              t.head.appendChild(i))
            : (t = r)),
        (o = A.exec(e)),
        (a = !n && []),
        o
          ? [t.createElement(o[1])]
          : ((o = xe([e], t, a)),
            a && a.length && w(a).remove(),
            w.merge([], o.childNodes))
      );
    }),
    (w.fn.load = function (e, t, n) {
      var r,
        i,
        o,
        a = this,
        s = e.indexOf(" ");
      return (
        s > -1 && ((r = vt(e.slice(s))), (e = e.slice(0, s))),
        g(t)
          ? ((n = t), (t = void 0))
          : t && "object" == typeof t && (i = "POST"),
        a.length > 0 &&
          w
            .ajax({ url: e, type: i || "GET", dataType: "html", data: t })
            .done(function (e) {
              (o = arguments),
                a.html(r ? w("<div>").append(w.parseHTML(e)).find(r) : e);
            })
            .always(
              n &&
                function (e, t) {
                  a.each(function () {
                    n.apply(this, o || [e.responseText, t, e]);
                  });
                }
            ),
        this
      );
    }),
    w.each(
      [
        "ajaxStart",
        "ajaxStop",
        "ajaxComplete",
        "ajaxError",
        "ajaxSuccess",
        "ajaxSend",
      ],
      function (e, t) {
        w.fn[t] = function (e) {
          return this.on(t, e);
        };
      }
    ),
    (w.expr.pseudos.animated = function (e) {
      return w.grep(w.timers, function (t) {
        return e === t.elem;
      }).length;
    }),
    (w.offset = {
      setOffset: function (e, t, n) {
        var r,
          i,
          o,
          a,
          s,
          u,
          l,
          c = w.css(e, "position"),
          f = w(e),
          p = {};
        "static" === c && (e.style.position = "relative"),
          (s = f.offset()),
          (o = w.css(e, "top")),
          (u = w.css(e, "left")),
          (l =
            ("absolute" === c || "fixed" === c) && (o + u).indexOf("auto") > -1)
            ? ((a = (r = f.position()).top), (i = r.left))
            : ((a = parseFloat(o) || 0), (i = parseFloat(u) || 0)),
          g(t) && (t = t.call(e, n, w.extend({}, s))),
          null != t.top && (p.top = t.top - s.top + a),
          null != t.left && (p.left = t.left - s.left + i),
          "using" in t ? t.using.call(e, p) : f.css(p);
      },
    }),
    w.fn.extend({
      offset: function (e) {
        if (arguments.length)
          return void 0 === e
            ? this
            : this.each(function (t) {
                w.offset.setOffset(this, e, t);
              });
        var t,
          n,
          r = this[0];
        if (r)
          return r.getClientRects().length
            ? ((t = r.getBoundingClientRect()),
              (n = r.ownerDocument.defaultView),
              { top: t.top + n.pageYOffset, left: t.left + n.pageXOffset })
            : { top: 0, left: 0 };
      },
      position: function () {
        if (this[0]) {
          var e,
            t,
            n,
            r = this[0],
            i = { top: 0, left: 0 };
          if ("fixed" === w.css(r, "position")) t = r.getBoundingClientRect();
          else {
            (t = this.offset()),
              (n = r.ownerDocument),
              (e = r.offsetParent || n.documentElement);
            while (
              e &&
              (e === n.body || e === n.documentElement) &&
              "static" === w.css(e, "position")
            )
              e = e.parentNode;
            e &&
              e !== r &&
              1 === e.nodeType &&
              (((i = w(e).offset()).top += w.css(e, "borderTopWidth", !0)),
              (i.left += w.css(e, "borderLeftWidth", !0)));
          }
          return {
            top: t.top - i.top - w.css(r, "marginTop", !0),
            left: t.left - i.left - w.css(r, "marginLeft", !0),
          };
        }
      },
      offsetParent: function () {
        return this.map(function () {
          var e = this.offsetParent;
          while (e && "static" === w.css(e, "position")) e = e.offsetParent;
          return e || be;
        });
      },
    }),
    w.each({ scrollLeft: "pageXOffset", scrollTop: "pageYOffset" }, function (
      e,
      t
    ) {
      var n = "pageYOffset" === t;
      w.fn[e] = function (r) {
        return z(
          this,
          function (e, r, i) {
            var o;
            if (
              (y(e) ? (o = e) : 9 === e.nodeType && (o = e.defaultView),
              void 0 === i)
            )
              return o ? o[t] : e[r];
            o
              ? o.scrollTo(n ? o.pageXOffset : i, n ? i : o.pageYOffset)
              : (e[r] = i);
          },
          e,
          r,
          arguments.length
        );
      };
    }),
    w.each(["top", "left"], function (e, t) {
      w.cssHooks[t] = _e(h.pixelPosition, function (e, n) {
        if (n)
          return (n = Fe(e, t)), We.test(n) ? w(e).position()[t] + "px" : n;
      });
    }),
    w.each({ Height: "height", Width: "width" }, function (e, t) {
      w.each({ padding: "inner" + e, content: t, "": "outer" + e }, function (
        n,
        r
      ) {
        w.fn[r] = function (i, o) {
          var a = arguments.length && (n || "boolean" != typeof i),
            s = n || (!0 === i || !0 === o ? "margin" : "border");
          return z(
            this,
            function (t, n, i) {
              var o;
              return y(t)
                ? 0 === r.indexOf("outer")
                  ? t["inner" + e]
                  : t.document.documentElement["client" + e]
                : 9 === t.nodeType
                ? ((o = t.documentElement),
                  Math.max(
                    t.body["scroll" + e],
                    o["scroll" + e],
                    t.body["offset" + e],
                    o["offset" + e],
                    o["client" + e]
                  ))
                : void 0 === i
                ? w.css(t, n, s)
                : w.style(t, n, i, s);
            },
            t,
            a ? i : void 0,
            a
          );
        };
      });
    }),
    w.each(
      "blur focus focusin focusout resize scroll click dblclick mousedown mouseup mousemove mouseover mouseout mouseenter mouseleave change select submit keydown keypress keyup contextmenu".split(
        " "
      ),
      function (e, t) {
        w.fn[t] = function (e, n) {
          return arguments.length > 0
            ? this.on(t, null, e, n)
            : this.trigger(t);
        };
      }
    ),
    w.fn.extend({
      hover: function (e, t) {
        return this.mouseenter(e).mouseleave(t || e);
      },
    }),
    w.fn.extend({
      bind: function (e, t, n) {
        return this.on(e, null, t, n);
      },
      unbind: function (e, t) {
        return this.off(e, null, t);
      },
      delegate: function (e, t, n, r) {
        return this.on(t, e, n, r);
      },
      undelegate: function (e, t, n) {
        return 1 === arguments.length
          ? this.off(e, "**")
          : this.off(t, e || "**", n);
      },
    }),
    (w.proxy = function (e, t) {
      var n, r, i;
      if (("string" == typeof t && ((n = e[t]), (t = e), (e = n)), g(e)))
        return (
          (r = o.call(arguments, 2)),
          (i = function () {
            return e.apply(t || this, r.concat(o.call(arguments)));
          }),
          (i.guid = e.guid = e.guid || w.guid++),
          i
        );
    }),
    (w.holdReady = function (e) {
      e ? w.readyWait++ : w.ready(!0);
    }),
    (w.isArray = Array.isArray),
    (w.parseJSON = JSON.parse),
    (w.nodeName = N),
    (w.isFunction = g),
    (w.isWindow = y),
    (w.camelCase = G),
    (w.type = x),
    (w.now = Date.now),
    (w.isNumeric = function (e) {
      var t = w.type(e);
      return ("number" === t || "string" === t) && !isNaN(e - parseFloat(e));
    }),
    "function" == typeof define &&
      define.amd &&
      define("jquery", [], function () {
        return w;
      });
  var Jt = e.jQuery,
    Kt = e.$;
  return (
    (w.noConflict = function (t) {
      return e.$ === w && (e.$ = Kt), t && e.jQuery === w && (e.jQuery = Jt), w;
    }),
    t || (e.jQuery = e.$ = w),
    w
  );
});

/*!
 * ASP.NET SignalR JavaScript Library v2.2.2
 * http://signalr.net/
 *
 * Copyright (c) .NET Foundation. All rights reserved.
 * Licensed under the Apache License, Version 2.0. See License.txt in the project root for license information.
 *
 */
(function (n, t, i) {
  function w(t, i) {
    var u, f;
    if (n.isArray(t)) {
      for (u = t.length - 1; u >= 0; u--)
        (f = t[u]),
          (n.type(f) === "string" && r.transports[f]) ||
            (i.log(
              "Invalid transport: " +
                f +
                ", removing it from the transports list."
            ),
            t.splice(u, 1));
      t.length === 0 &&
        (i.log("No transports remain within the specified transport array."),
        (t = null));
    } else if (r.transports[t] || t === "auto") {
      if (t === "auto" && r._.ieVersion <= 8) return ["longPolling"];
    } else i.log("Invalid transport: " + t.toString() + "."), (t = null);
    return t;
  }
  function b(n) {
    return n === "http:" ? 80 : n === "https:" ? 443 : void 0;
  }
  function a(n, t) {
    return t.match(/:\d+$/) ? t : t + ":" + b(n);
  }
  function k(t, i) {
    var u = this,
      r = [];
    u.tryBuffer = function (i) {
      return t.state === n.signalR.connectionState.connecting
        ? (r.push(i), !0)
        : !1;
    };
    u.drain = function () {
      if (t.state === n.signalR.connectionState.connected)
        while (r.length > 0) i(r.shift());
    };
    u.clear = function () {
      r = [];
    };
  }
  var f = {
    nojQuery:
      "jQuery was not found. Please ensure jQuery is referenced before the SignalR client JavaScript file.",
    noTransportOnInit:
      "No transport could be initialized successfully. Try specifying a different transport or none at all for auto initialization.",
    errorOnNegotiate: "Error during negotiation request.",
    stoppedWhileLoading: "The connection was stopped during page load.",
    stoppedWhileNegotiating:
      "The connection was stopped during the negotiate request.",
    errorParsingNegotiateResponse: "Error parsing negotiate response.",
    errorDuringStartRequest:
      "Error during start request. Stopping the connection.",
    stoppedDuringStartRequest:
      "The connection was stopped during the start request.",
    errorParsingStartResponse:
      "Error parsing start response: '{0}'. Stopping the connection.",
    invalidStartResponse:
      "Invalid start response: '{0}'. Stopping the connection.",
    protocolIncompatible:
      "You are using a version of the client that isn't compatible with the server. Client version {0}, server version {1}.",
    sendFailed: "Send failed.",
    parseFailed: "Failed at parsing response: {0}",
    longPollFailed: "Long polling request failed.",
    eventSourceFailedToConnect: "EventSource failed to connect.",
    eventSourceError: "Error raised by EventSource",
    webSocketClosed: "WebSocket closed.",
    pingServerFailedInvalidResponse:
      "Invalid ping response when pinging server: '{0}'.",
    pingServerFailed: "Failed to ping server.",
    pingServerFailedStatusCode:
      "Failed to ping server.  Server responded with status code {0}, stopping the connection.",
    pingServerFailedParse:
      "Failed to parse ping server response, stopping the connection.",
    noConnectionTransport:
      "Connection is in an invalid state, there is no transport active.",
    webSocketsInvalidState:
      "The Web Socket transport is in an invalid state, transitioning into reconnecting.",
    reconnectTimeout:
      "Couldn't reconnect within the configured timeout of {0} ms, disconnecting.",
    reconnectWindowTimeout:
      "The client has been inactive since {0} and it has exceeded the inactivity timeout of {1} ms. Stopping the connection.",
  };
  if (typeof n != "function") throw new Error(f.nojQuery);
  var r,
    h,
    o = t.document.readyState === "complete",
    e = n(t),
    c = "__Negotiate Aborted__",
    u = {
      onStart: "onStart",
      onStarting: "onStarting",
      onReceived: "onReceived",
      onError: "onError",
      onConnectionSlow: "onConnectionSlow",
      onReconnecting: "onReconnecting",
      onReconnect: "onReconnect",
      onStateChanged: "onStateChanged",
      onDisconnect: "onDisconnect",
    },
    v = function (n, i) {
      if (i !== !1) {
        var r;
        typeof t.console != "undefined" &&
          ((r = "[" + new Date().toTimeString() + "] SignalR: " + n),
          t.console.debug
            ? t.console.debug(r)
            : t.console.log && t.console.log(r));
      }
    },
    s = function (t, i, r) {
      return i === t.state
        ? ((t.state = r),
          n(t).triggerHandler(u.onStateChanged, [{ oldState: i, newState: r }]),
          !0)
        : !1;
    },
    y = function (n) {
      return n.state === r.connectionState.disconnected;
    },
    l = function (n) {
      return n._.keepAliveData.activated && n.transport.supportsKeepAlive(n);
    },
    p = function (i) {
      var f, e;
      i._.configuredStopReconnectingTimeout ||
        ((e = function (t) {
          var i = r._.format(r.resources.reconnectTimeout, t.disconnectTimeout);
          t.log(i);
          n(t).triggerHandler(u.onError, [r._.error(i, "TimeoutException")]);
          t.stop(!1, !1);
        }),
        i.reconnecting(function () {
          var n = this;
          n.state === r.connectionState.reconnecting &&
            (f = t.setTimeout(function () {
              e(n);
            }, n.disconnectTimeout));
        }),
        i.stateChanged(function (n) {
          n.oldState === r.connectionState.reconnecting && t.clearTimeout(f);
        }),
        (i._.configuredStopReconnectingTimeout = !0));
    };
  if (
    ((r = function (n, t, i) {
      return new r.fn.init(n, t, i);
    }),
    (r._ = {
      defaultContentType: "application/x-www-form-urlencoded; charset=UTF-8",
      ieVersion: (function () {
        var i, n;
        return (
          t.navigator.appName === "Microsoft Internet Explorer" &&
            ((n = /MSIE ([0-9]+\.[0-9]+)/.exec(t.navigator.userAgent)),
            n && (i = t.parseFloat(n[1]))),
          i
        );
      })(),
      error: function (n, t, i) {
        var r = new Error(n);
        return (r.source = t), typeof i != "undefined" && (r.context = i), r;
      },
      transportError: function (n, t, r, u) {
        var f = this.error(n, r, u);
        return (f.transport = t ? t.name : i), f;
      },
      format: function () {
        for (var t = arguments[0], n = 0; n < arguments.length - 1; n++)
          t = t.replace("{" + n + "}", arguments[n + 1]);
        return t;
      },
      firefoxMajorVersion: function (n) {
        var t = n.match(/Firefox\/(\d+)/);
        return !t || !t.length || t.length < 2 ? 0 : parseInt(t[1], 10);
      },
      configurePingInterval: function (i) {
        var f = i._.config,
          e = function (t) {
            n(i).triggerHandler(u.onError, [t]);
          };
        f &&
          !i._.pingIntervalId &&
          f.pingInterval &&
          (i._.pingIntervalId = t.setInterval(function () {
            r.transports._logic.pingServer(i).fail(e);
          }, f.pingInterval));
      },
    }),
    (r.events = u),
    (r.resources = f),
    (r.ajaxDefaults = {
      processData: !0,
      timeout: null,
      async: !0,
      global: !1,
      cache: !1,
    }),
    (r.changeState = s),
    (r.isDisconnecting = y),
    (r.connectionState = {
      connecting: 0,
      connected: 1,
      reconnecting: 2,
      disconnected: 4,
    }),
    (r.hub = {
      start: function () {
        throw new Error(
          "SignalR: Error loading hubs. Ensure your hubs reference is correct, e.g. <script src='/signalr/js'></script>."
        );
      },
    }),
    typeof e.on == "function")
  )
    e.on("load", function () {
      o = !0;
    });
  else
    e.load(function () {
      o = !0;
    });
  r.fn = r.prototype = {
    init: function (t, i, r) {
      var f = n(this);
      this.url = t;
      this.qs = i;
      this.lastError = null;
      this._ = {
        keepAliveData: {},
        connectingMessageBuffer: new k(this, function (n) {
          f.triggerHandler(u.onReceived, [n]);
        }),
        lastMessageAt: new Date().getTime(),
        lastActiveAt: new Date().getTime(),
        beatInterval: 5e3,
        beatHandle: null,
        totalTransportConnectTimeout: 0,
      };
      typeof r == "boolean" && (this.logging = r);
    },
    _parseResponse: function (n) {
      var t = this;
      return n ? (typeof n == "string" ? t.json.parse(n) : n) : n;
    },
    _originalJson: t.JSON,
    json: t.JSON,
    isCrossDomain: function (i, r) {
      var u;
      return ((i = n.trim(i)), (r = r || t.location), i.indexOf("http") !== 0)
        ? !1
        : ((u = t.document.createElement("a")),
          (u.href = i),
          u.protocol + a(u.protocol, u.host) !==
            r.protocol + a(r.protocol, r.host));
    },
    ajaxDataType: "text",
    contentType: "application/json; charset=UTF-8",
    logging: !1,
    state: r.connectionState.disconnected,
    clientProtocol: "1.5",
    reconnectDelay: 2e3,
    transportConnectTimeout: 0,
    disconnectTimeout: 3e4,
    reconnectWindow: 3e4,
    keepAliveWarnAt: 2 / 3,
    start: function (i, h) {
      var a = this,
        v = {
          pingInterval: 3e5,
          waitForPageLoad: !0,
          transport: "auto",
          jsonp: !1,
        },
        d,
        y = a._deferral || n.Deferred(),
        b = t.document.createElement("a"),
        k,
        g;
      if (((a.lastError = null), (a._deferral = y), !a.json))
        throw new Error(
          "SignalR: No JSON parser found. Please ensure json2.js is referenced before the SignalR.js file if you need to support clients without native JSON parsing support, e.g. IE<8."
        );
      if (
        (n.type(i) === "function"
          ? (h = i)
          : n.type(i) === "object" &&
            (n.extend(v, i),
            n.type(v.callback) === "function" && (h = v.callback)),
        (v.transport = w(v.transport, a)),
        !v.transport)
      )
        throw new Error(
          "SignalR: Invalid transport(s) specified, aborting start."
        );
      return ((a._.config = v), !o && v.waitForPageLoad === !0)
        ? ((a._.deferredStartHandler = function () {
            a.start(i, h);
          }),
          e.bind("load", a._.deferredStartHandler),
          y.promise())
        : a.state === r.connectionState.connecting
        ? y.promise()
        : s(a, r.connectionState.disconnected, r.connectionState.connecting) ===
          !1
        ? (y.resolve(a), y.promise())
        : (p(a),
          (b.href = a.url),
          b.protocol && b.protocol !== ":"
            ? ((a.protocol = b.protocol), (a.host = b.host))
            : ((a.protocol = t.document.location.protocol),
              (a.host = b.host || t.document.location.host)),
          (a.baseUrl = a.protocol + "//" + a.host),
          (a.wsProtocol = a.protocol === "https:" ? "wss://" : "ws://"),
          v.transport === "auto" &&
            v.jsonp === !0 &&
            (v.transport = "longPolling"),
          a.url.indexOf("//") === 0 &&
            ((a.url = t.location.protocol + a.url),
            a.log(
              "Protocol relative URL detected, normalizing it to '" +
                a.url +
                "'."
            )),
          this.isCrossDomain(a.url) &&
            (a.log("Auto detected cross domain url."),
            v.transport === "auto" &&
              (v.transport = ["webSockets", "serverSentEvents", "longPolling"]),
            typeof v.withCredentials == "undefined" && (v.withCredentials = !0),
            v.jsonp ||
              ((v.jsonp = !n.support.cors),
              v.jsonp &&
                a.log(
                  "Using jsonp because this browser doesn't support CORS."
                )),
            (a.contentType = r._.defaultContentType)),
          (a.withCredentials = v.withCredentials),
          (a.ajaxDataType = v.jsonp ? "jsonp" : "text"),
          n(a).bind(u.onStart, function () {
            n.type(h) === "function" && h.call(a);
            y.resolve(a);
          }),
          (a._.initHandler = r.transports._logic.initHandler(a)),
          (d = function (i, o) {
            var c = r._.error(f.noTransportOnInit);
            if (((o = o || 0), o >= i.length)) {
              o === 0
                ? a.log("No transports supported by the server were selected.")
                : o === 1
                ? a.log("No fallback transports were selected.")
                : a.log("Fallback transports exhausted.");
              n(a).triggerHandler(u.onError, [c]);
              y.reject(c);
              a.stop();
              return;
            }
            if (a.state !== r.connectionState.disconnected) {
              var p = i[o],
                h = r.transports[p],
                v = function () {
                  d(i, o + 1);
                };
              a.transport = h;
              try {
                a._.initHandler.start(
                  h,
                  function () {
                    var i =
                        r._.firefoxMajorVersion(t.navigator.userAgent) >= 11,
                      f = !!a.withCredentials && i;
                    a.log(
                      "The start request succeeded. Transitioning to the connected state."
                    );
                    l(a) && r.transports._logic.monitorKeepAlive(a);
                    r.transports._logic.startHeartbeat(a);
                    r._.configurePingInterval(a);
                    s(
                      a,
                      r.connectionState.connecting,
                      r.connectionState.connected
                    ) ||
                      a.log(
                        "WARNING! The connection was not in the connecting state."
                      );
                    a._.connectingMessageBuffer.drain();
                    n(a).triggerHandler(u.onStart);
                    e.bind("unload", function () {
                      a.log("Window unloading, stopping the connection.");
                      a.stop(f);
                    });
                    i &&
                      e.bind("beforeunload", function () {
                        t.setTimeout(function () {
                          a.stop(f);
                        }, 0);
                      });
                  },
                  v
                );
              } catch (w) {
                a.log(
                  h.name +
                    " transport threw '" +
                    w.message +
                    "' when attempting to start."
                );
                v();
              }
            }
          }),
          (k = a.url + "/negotiate"),
          (g = function (t, i) {
            var e = r._.error(f.errorOnNegotiate, t, i._.negotiateRequest);
            n(i).triggerHandler(u.onError, e);
            y.reject(e);
            i.stop();
          }),
          n(a).triggerHandler(u.onStarting),
          (k = r.transports._logic.prepareQueryString(a, k)),
          a.log("Negotiating with '" + k + "'."),
          (a._.negotiateRequest = r.transports._logic.ajax(a, {
            url: k,
            error: function (n, t) {
              t !== c
                ? g(n, a)
                : y.reject(
                    r._.error(
                      f.stoppedWhileNegotiating,
                      null,
                      a._.negotiateRequest
                    )
                  );
            },
            success: function (t) {
              var i,
                e,
                h,
                o = [],
                s = [];
              try {
                i = a._parseResponse(t);
              } catch (c) {
                g(r._.error(f.errorParsingNegotiateResponse, c), a);
                return;
              }
              if (
                ((e = a._.keepAliveData),
                (a.appRelativeUrl = i.Url),
                (a.id = i.ConnectionId),
                (a.token = i.ConnectionToken),
                (a.webSocketServerUrl = i.WebSocketServerUrl),
                (a._.pollTimeout = i.ConnectionTimeout * 1e3 + 1e4),
                (a.disconnectTimeout = i.DisconnectTimeout * 1e3),
                (a._.totalTransportConnectTimeout =
                  a.transportConnectTimeout + i.TransportConnectTimeout * 1e3),
                i.KeepAliveTimeout
                  ? ((e.activated = !0),
                    (e.timeout = i.KeepAliveTimeout * 1e3),
                    (e.timeoutWarning = e.timeout * a.keepAliveWarnAt),
                    (a._.beatInterval = (e.timeout - e.timeoutWarning) / 3))
                  : (e.activated = !1),
                (a.reconnectWindow = a.disconnectTimeout + (e.timeout || 0)),
                !i.ProtocolVersion || i.ProtocolVersion !== a.clientProtocol)
              ) {
                h = r._.error(
                  r._.format(
                    f.protocolIncompatible,
                    a.clientProtocol,
                    i.ProtocolVersion
                  )
                );
                n(a).triggerHandler(u.onError, [h]);
                y.reject(h);
                return;
              }
              n.each(r.transports, function (n) {
                if (
                  n.indexOf("_") === 0 ||
                  (n === "webSockets" && !i.TryWebSockets)
                )
                  return !0;
                s.push(n);
              });
              n.isArray(v.transport)
                ? n.each(v.transport, function (t, i) {
                    n.inArray(i, s) >= 0 && o.push(i);
                  })
                : v.transport === "auto"
                ? (o = s)
                : n.inArray(v.transport, s) >= 0 && o.push(v.transport);
              d(o);
            },
          })),
          y.promise());
    },
    starting: function (t) {
      var i = this;
      return (
        n(i).bind(u.onStarting, function () {
          t.call(i);
        }),
        i
      );
    },
    send: function (n) {
      var t = this;
      if (t.state === r.connectionState.disconnected)
        throw new Error(
          "SignalR: Connection must be started before data can be sent. Call .start() before .send()"
        );
      if (t.state === r.connectionState.connecting)
        throw new Error(
          "SignalR: Connection has not been fully initialized. Use .start().done() or .start().fail() to run logic after the connection has started."
        );
      return t.transport.send(t, n), t;
    },
    received: function (t) {
      var i = this;
      return (
        n(i).bind(u.onReceived, function (n, r) {
          t.call(i, r);
        }),
        i
      );
    },
    stateChanged: function (t) {
      var i = this;
      return (
        n(i).bind(u.onStateChanged, function (n, r) {
          t.call(i, r);
        }),
        i
      );
    },
    error: function (t) {
      var i = this;
      return (
        n(i).bind(u.onError, function (n, r, u) {
          i.lastError = r;
          t.call(i, r, u);
        }),
        i
      );
    },
    disconnected: function (t) {
      var i = this;
      return (
        n(i).bind(u.onDisconnect, function () {
          t.call(i);
        }),
        i
      );
    },
    connectionSlow: function (t) {
      var i = this;
      return (
        n(i).bind(u.onConnectionSlow, function () {
          t.call(i);
        }),
        i
      );
    },
    reconnecting: function (t) {
      var i = this;
      return (
        n(i).bind(u.onReconnecting, function () {
          t.call(i);
        }),
        i
      );
    },
    reconnected: function (t) {
      var i = this;
      return (
        n(i).bind(u.onReconnect, function () {
          t.call(i);
        }),
        i
      );
    },
    stop: function (i, h) {
      var a = this,
        v = a._deferral;
      if (
        (a._.deferredStartHandler && e.unbind("load", a._.deferredStartHandler),
        delete a._.config,
        delete a._.deferredStartHandler,
        !o && (!a._.config || a._.config.waitForPageLoad === !0))
      ) {
        a.log("Stopping connection prior to negotiate.");
        v && v.reject(r._.error(f.stoppedWhileLoading));
        return;
      }
      if (a.state !== r.connectionState.disconnected)
        return (
          a.log("Stopping connection."),
          t.clearTimeout(a._.beatHandle),
          t.clearInterval(a._.pingIntervalId),
          a.transport &&
            (a.transport.stop(a),
            h !== !1 && a.transport.abort(a, i),
            l(a) && r.transports._logic.stopMonitoringKeepAlive(a),
            (a.transport = null)),
          a._.negotiateRequest &&
            (a._.negotiateRequest.abort(c), delete a._.negotiateRequest),
          a._.initHandler && a._.initHandler.stop(),
          delete a._deferral,
          delete a.messageId,
          delete a.groupsToken,
          delete a.id,
          delete a._.pingIntervalId,
          delete a._.lastMessageAt,
          delete a._.lastActiveAt,
          a._.connectingMessageBuffer.clear(),
          n(a).unbind(u.onStart),
          s(a, a.state, r.connectionState.disconnected),
          n(a).triggerHandler(u.onDisconnect),
          a
        );
    },
    log: function (n) {
      v(n, this.logging);
    },
  };
  r.fn.init.prototype = r.fn;
  r.noConflict = function () {
    return n.connection === r && (n.connection = h), r;
  };
  n.connection && (h = n.connection);
  n.connection = n.signalR = r;
})(window.jQuery, window),
  (function (n, t, i) {
    function s(n) {
      n._.keepAliveData.monitoring && l(n);
      u.markActive(n) &&
        (n._.beatHandle = t.setTimeout(function () {
          s(n);
        }, n._.beatInterval));
    }
    function l(t) {
      var i = t._.keepAliveData,
        u;
      t.state === r.connectionState.connected &&
        ((u = new Date().getTime() - t._.lastMessageAt),
        u >= i.timeout
          ? (t.log(
              "Keep alive timed out.  Notifying transport that connection has been lost."
            ),
            t.transport.lostConnection(t))
          : u >= i.timeoutWarning
          ? i.userNotified ||
            (t.log("Keep alive has been missed, connection may be dead/slow."),
            n(t).triggerHandler(f.onConnectionSlow),
            (i.userNotified = !0))
          : (i.userNotified = !1));
    }
    function e(n, t) {
      var i = n.url + t;
      return (
        n.transport && (i += "?transport=" + n.transport.name),
        u.prepareQueryString(n, i)
      );
    }
    function h(n) {
      this.connection = n;
      this.startRequested = !1;
      this.startCompleted = !1;
      this.connectionStopped = !1;
    }
    var r = n.signalR,
      f = n.signalR.events,
      c = n.signalR.changeState,
      o = "__Start Aborted__",
      u;
    r.transports = {};
    h.prototype = {
      start: function (n, r, u) {
        var f = this,
          e = f.connection,
          o = !1;
        if (f.startRequested || f.connectionStopped) {
          e.log(
            "WARNING! " +
              n.name +
              " transport cannot be started. Initialization ongoing or completed."
          );
          return;
        }
        e.log(n.name + " transport starting.");
        n.start(
          e,
          function () {
            o || f.initReceived(n, r);
          },
          function (t) {
            return (
              o || ((o = !0), f.transportFailed(n, t, u)),
              !f.startCompleted || f.connectionStopped
            );
          }
        );
        f.transportTimeoutHandle = t.setTimeout(function () {
          o ||
            ((o = !0),
            e.log(n.name + " transport timed out when trying to connect."),
            f.transportFailed(n, i, u));
        }, e._.totalTransportConnectTimeout);
      },
      stop: function () {
        this.connectionStopped = !0;
        t.clearTimeout(this.transportTimeoutHandle);
        r.transports._logic.tryAbortStartRequest(this.connection);
      },
      initReceived: function (n, i) {
        var u = this,
          f = u.connection;
        if (u.startRequested) {
          f.log("WARNING! The client received multiple init messages.");
          return;
        }
        u.connectionStopped ||
          ((u.startRequested = !0),
          t.clearTimeout(u.transportTimeoutHandle),
          f.log(n.name + " transport connected. Initiating start request."),
          r.transports._logic.ajaxStart(f, function () {
            u.startCompleted = !0;
            i();
          }));
      },
      transportFailed: function (i, u, e) {
        var o = this.connection,
          h = o._deferral,
          s;
        this.connectionStopped ||
          (t.clearTimeout(this.transportTimeoutHandle),
          this.startRequested
            ? this.startCompleted ||
              ((s = r._.error(r.resources.errorDuringStartRequest, u)),
              o.log(
                i.name +
                  " transport failed during the start request. Stopping the connection."
              ),
              n(o).triggerHandler(f.onError, [s]),
              h && h.reject(s),
              o.stop())
            : (i.stop(o),
              o.log(
                i.name +
                  " transport failed to connect. Attempting to fall back."
              ),
              e()));
      },
    };
    u = r.transports._logic = {
      ajax: function (t, i) {
        return n.ajax(
          n.extend(
            !0,
            {},
            n.signalR.ajaxDefaults,
            {
              type: "GET",
              data: {},
              xhrFields: { withCredentials: t.withCredentials },
              contentType: t.contentType,
              dataType: t.ajaxDataType,
            },
            i
          )
        );
      },
      pingServer: function (t) {
        var e,
          f,
          i = n.Deferred();
        return (
          t.transport
            ? ((e = t.url + "/ping"),
              (e = u.addQs(e, t.qs)),
              (f = u.ajax(t, {
                url: e,
                success: function (n) {
                  var u;
                  try {
                    u = t._parseResponse(n);
                  } catch (e) {
                    i.reject(
                      r._.transportError(
                        r.resources.pingServerFailedParse,
                        t.transport,
                        e,
                        f
                      )
                    );
                    t.stop();
                    return;
                  }
                  u.Response === "pong"
                    ? i.resolve()
                    : i.reject(
                        r._.transportError(
                          r._.format(
                            r.resources.pingServerFailedInvalidResponse,
                            n
                          ),
                          t.transport,
                          null,
                          f
                        )
                      );
                },
                error: function (n) {
                  n.status === 401 || n.status === 403
                    ? (i.reject(
                        r._.transportError(
                          r._.format(
                            r.resources.pingServerFailedStatusCode,
                            n.status
                          ),
                          t.transport,
                          n,
                          f
                        )
                      ),
                      t.stop())
                    : i.reject(
                        r._.transportError(
                          r.resources.pingServerFailed,
                          t.transport,
                          n,
                          f
                        )
                      );
                },
              })))
            : i.reject(
                r._.transportError(
                  r.resources.noConnectionTransport,
                  t.transport
                )
              ),
          i.promise()
        );
      },
      prepareQueryString: function (n, i) {
        var r;
        return (
          (r = u.addQs(i, "clientProtocol=" + n.clientProtocol)),
          (r = u.addQs(r, n.qs)),
          n.token && (r += "&connectionToken=" + t.encodeURIComponent(n.token)),
          n.data && (r += "&connectionData=" + t.encodeURIComponent(n.data)),
          r
        );
      },
      addQs: function (t, i) {
        var r = t.indexOf("?") !== -1 ? "&" : "?",
          u;
        if (!i) return t;
        if (typeof i == "object") return t + r + n.param(i);
        if (typeof i == "string")
          return (
            (u = i.charAt(0)), (u === "?" || u === "&") && (r = ""), t + r + i
          );
        throw new Error(
          "Query string property must be either a string or object."
        );
      },
      getUrl: function (n, i, r, f, e) {
        var h = i === "webSockets" ? "" : n.baseUrl,
          o = h + n.appRelativeUrl,
          s = "transport=" + i;
        return (
          !e &&
            n.groupsToken &&
            (s += "&groupsToken=" + t.encodeURIComponent(n.groupsToken)),
          r
            ? ((o += f ? "/poll" : "/reconnect"),
              !e &&
                n.messageId &&
                (s += "&messageId=" + t.encodeURIComponent(n.messageId)))
            : (o += "/connect"),
          (o += "?" + s),
          (o = u.prepareQueryString(n, o)),
          e || (o += "&tid=" + Math.floor(Math.random() * 11)),
          o
        );
      },
      maximizePersistentResponse: function (n) {
        return {
          MessageId: n.C,
          Messages: n.M,
          Initialized: typeof n.S != "undefined" ? !0 : !1,
          ShouldReconnect: typeof n.T != "undefined" ? !0 : !1,
          LongPollDelay: n.L,
          GroupsToken: n.G,
        };
      },
      updateGroups: function (n, t) {
        t && (n.groupsToken = t);
      },
      stringifySend: function (n, t) {
        return typeof t == "string" || typeof t == "undefined" || t === null
          ? t
          : n.json.stringify(t);
      },
      ajaxSend: function (t, i) {
        var h = u.stringifySend(t, i),
          c = e(t, "/send"),
          o,
          s = function (t, u) {
            n(u).triggerHandler(f.onError, [
              r._.transportError(r.resources.sendFailed, u.transport, t, o),
              i,
            ]);
          };
        return (o = u.ajax(t, {
          url: c,
          type: t.ajaxDataType === "jsonp" ? "GET" : "POST",
          contentType: r._.defaultContentType,
          data: { data: h },
          success: function (n) {
            var i;
            if (n) {
              try {
                i = t._parseResponse(n);
              } catch (r) {
                s(r, t);
                t.stop();
                return;
              }
              u.triggerReceived(t, i);
            }
          },
          error: function (n, i) {
            i !== "abort" && i !== "parsererror" && s(n, t);
          },
        }));
      },
      ajaxAbort: function (n, t) {
        if (typeof n.transport != "undefined") {
          t = typeof t == "undefined" ? !0 : t;
          var i = e(n, "/abort");
          u.ajax(n, { url: i, async: t, timeout: 1e3, type: "POST" });
          n.log("Fired ajax abort async = " + t + ".");
        }
      },
      ajaxStart: function (t, i) {
        var h = function (n) {
            var i = t._deferral;
            i && i.reject(n);
          },
          s = function (i) {
            t.log("The start request failed. Stopping the connection.");
            n(t).triggerHandler(f.onError, [i]);
            h(i);
            t.stop();
          };
        t._.startRequest = u.ajax(t, {
          url: e(t, "/start"),
          success: function (n, u, f) {
            var e;
            try {
              e = t._parseResponse(n);
            } catch (o) {
              s(
                r._.error(
                  r._.format(r.resources.errorParsingStartResponse, n),
                  o,
                  f
                )
              );
              return;
            }
            e.Response === "started"
              ? i()
              : s(
                  r._.error(
                    r._.format(r.resources.invalidStartResponse, n),
                    null,
                    f
                  )
                );
          },
          error: function (n, i, u) {
            i !== o
              ? s(r._.error(r.resources.errorDuringStartRequest, u, n))
              : (t.log(
                  "The start request aborted because connection.stop() was called."
                ),
                h(r._.error(r.resources.stoppedDuringStartRequest, null, n)));
          },
        });
      },
      tryAbortStartRequest: function (n) {
        n._.startRequest &&
          (n._.startRequest.abort(o), delete n._.startRequest);
      },
      tryInitialize: function (n, t, i) {
        t.Initialized && i
          ? i()
          : t.Initialized &&
            n.log(
              "WARNING! The client received an init message after reconnecting."
            );
      },
      triggerReceived: function (t, i) {
        t._.connectingMessageBuffer.tryBuffer(i) ||
          n(t).triggerHandler(f.onReceived, [i]);
      },
      processMessages: function (t, i, r) {
        var f;
        u.markLastMessage(t);
        i &&
          ((f = u.maximizePersistentResponse(i)),
          u.updateGroups(t, f.GroupsToken),
          f.MessageId && (t.messageId = f.MessageId),
          f.Messages &&
            (n.each(f.Messages, function (n, i) {
              u.triggerReceived(t, i);
            }),
            u.tryInitialize(t, f, r)));
      },
      monitorKeepAlive: function (t) {
        var i = t._.keepAliveData;
        i.monitoring
          ? t.log(
              "Tried to monitor keep alive but it's already being monitored."
            )
          : ((i.monitoring = !0),
            u.markLastMessage(t),
            (t._.keepAliveData.reconnectKeepAliveUpdate = function () {
              u.markLastMessage(t);
            }),
            n(t).bind(
              f.onReconnect,
              t._.keepAliveData.reconnectKeepAliveUpdate
            ),
            t.log(
              "Now monitoring keep alive with a warning timeout of " +
                i.timeoutWarning +
                ", keep alive timeout of " +
                i.timeout +
                " and disconnecting timeout of " +
                t.disconnectTimeout
            ));
      },
      stopMonitoringKeepAlive: function (t) {
        var i = t._.keepAliveData;
        i.monitoring &&
          ((i.monitoring = !1),
          n(t).unbind(
            f.onReconnect,
            t._.keepAliveData.reconnectKeepAliveUpdate
          ),
          (t._.keepAliveData = {}),
          t.log("Stopping the monitoring of the keep alive."));
      },
      startHeartbeat: function (n) {
        n._.lastActiveAt = new Date().getTime();
        s(n);
      },
      markLastMessage: function (n) {
        n._.lastMessageAt = new Date().getTime();
      },
      markActive: function (n) {
        return u.verifyLastActive(n)
          ? ((n._.lastActiveAt = new Date().getTime()), !0)
          : !1;
      },
      isConnectedOrReconnecting: function (n) {
        return (
          n.state === r.connectionState.connected ||
          n.state === r.connectionState.reconnecting
        );
      },
      ensureReconnectingState: function (t) {
        return (
          c(t, r.connectionState.connected, r.connectionState.reconnecting) ===
            !0 && n(t).triggerHandler(f.onReconnecting),
          t.state === r.connectionState.reconnecting
        );
      },
      clearReconnectTimeout: function (n) {
        n &&
          n._.reconnectTimeout &&
          (t.clearTimeout(n._.reconnectTimeout), delete n._.reconnectTimeout);
      },
      verifyLastActive: function (t) {
        if (new Date().getTime() - t._.lastActiveAt >= t.reconnectWindow) {
          var i = r._.format(
            r.resources.reconnectWindowTimeout,
            new Date(t._.lastActiveAt),
            t.reconnectWindow
          );
          return (
            t.log(i),
            n(t).triggerHandler(f.onError, [r._.error(i, "TimeoutException")]),
            t.stop(!1, !1),
            !1
          );
        }
        return !0;
      },
      reconnect: function (n, i) {
        var f = r.transports[i];
        if (u.isConnectedOrReconnecting(n) && !n._.reconnectTimeout) {
          if (!u.verifyLastActive(n)) return;
          n._.reconnectTimeout = t.setTimeout(function () {
            u.verifyLastActive(n) &&
              (f.stop(n),
              u.ensureReconnectingState(n) &&
                (n.log(i + " reconnecting."), f.start(n)));
          }, n.reconnectDelay);
        }
      },
      handleParseFailure: function (t, i, u, e, o) {
        var s = r._.transportError(
          r._.format(r.resources.parseFailed, i),
          t.transport,
          u,
          o
        );
        e && e(s)
          ? t.log(
              "Failed to parse server response while attempting to connect."
            )
          : (n(t).triggerHandler(f.onError, [s]), t.stop());
      },
      initHandler: function (n) {
        return new h(n);
      },
      foreverFrame: { count: 0, connections: {} },
    };
  })(window.jQuery, window),
  (function (n, t) {
    var r = n.signalR,
      u = n.signalR.events,
      f = n.signalR.changeState,
      i = r.transports._logic;
    r.transports.webSockets = {
      name: "webSockets",
      supportsKeepAlive: function () {
        return !0;
      },
      send: function (t, f) {
        var e = i.stringifySend(t, f);
        try {
          t.socket.send(e);
        } catch (o) {
          n(t).triggerHandler(u.onError, [
            r._.transportError(
              r.resources.webSocketsInvalidState,
              t.transport,
              o,
              t.socket
            ),
            f,
          ]);
        }
      },
      start: function (e, o, s) {
        var h,
          c = !1,
          l = this,
          a = !o,
          v = n(e);
        if (!t.WebSocket) {
          s();
          return;
        }
        e.socket ||
          ((h = e.webSocketServerUrl
            ? e.webSocketServerUrl
            : e.wsProtocol + e.host),
          (h += i.getUrl(e, this.name, a)),
          e.log("Connecting to websocket endpoint '" + h + "'."),
          (e.socket = new t.WebSocket(h)),
          (e.socket.onopen = function () {
            c = !0;
            e.log("Websocket opened.");
            i.clearReconnectTimeout(e);
            f(
              e,
              r.connectionState.reconnecting,
              r.connectionState.connected
            ) === !0 && v.triggerHandler(u.onReconnect);
          }),
          (e.socket.onclose = function (t) {
            var i;
            this === e.socket &&
              (c && typeof t.wasClean != "undefined" && t.wasClean === !1
                ? ((i = r._.transportError(
                    r.resources.webSocketClosed,
                    e.transport,
                    t
                  )),
                  e.log(
                    "Unclean disconnect from websocket: " +
                      (t.reason || "[no reason given].")
                  ))
                : e.log("Websocket closed."),
              (s && s(i)) ||
                (i && n(e).triggerHandler(u.onError, [i]), l.reconnect(e)));
          }),
          (e.socket.onmessage = function (t) {
            var r;
            try {
              r = e._parseResponse(t.data);
            } catch (u) {
              i.handleParseFailure(e, t.data, u, s, t);
              return;
            }
            r &&
              (n.isEmptyObject(r) || r.M
                ? i.processMessages(e, r, o)
                : i.triggerReceived(e, r));
          }));
      },
      reconnect: function (n) {
        i.reconnect(n, this.name);
      },
      lostConnection: function (n) {
        this.reconnect(n);
      },
      stop: function (n) {
        i.clearReconnectTimeout(n);
        n.socket &&
          (n.log("Closing the Websocket."),
          n.socket.close(),
          (n.socket = null));
      },
      abort: function (n, t) {
        i.ajaxAbort(n, t);
      },
    };
  })(window.jQuery, window),
  (function (n, t) {
    var i = n.signalR,
      u = n.signalR.events,
      e = n.signalR.changeState,
      r = i.transports._logic,
      f = function (n) {
        t.clearTimeout(n._.reconnectAttemptTimeoutHandle);
        delete n._.reconnectAttemptTimeoutHandle;
      };
    i.transports.serverSentEvents = {
      name: "serverSentEvents",
      supportsKeepAlive: function () {
        return !0;
      },
      timeOut: 3e3,
      start: function (o, s, h) {
        var c = this,
          l = !1,
          a = n(o),
          v = !s,
          y;
        if (
          (o.eventSource &&
            (o.log("The connection already has an event source. Stopping it."),
            o.stop()),
          !t.EventSource)
        ) {
          h && (o.log("This browser doesn't support SSE."), h());
          return;
        }
        y = r.getUrl(o, this.name, v);
        try {
          o.log("Attempting to connect to SSE endpoint '" + y + "'.");
          o.eventSource = new t.EventSource(y, {
            withCredentials: o.withCredentials,
          });
        } catch (p) {
          o.log(
            "EventSource failed trying to connect with error " + p.Message + "."
          );
          h
            ? h()
            : (a.triggerHandler(u.onError, [
                i._.transportError(
                  i.resources.eventSourceFailedToConnect,
                  o.transport,
                  p
                ),
              ]),
              v && c.reconnect(o));
          return;
        }
        v &&
          (o._.reconnectAttemptTimeoutHandle = t.setTimeout(function () {
            l === !1 &&
              o.eventSource.readyState !== t.EventSource.OPEN &&
              c.reconnect(o);
          }, c.timeOut));
        o.eventSource.addEventListener(
          "open",
          function () {
            o.log("EventSource connected.");
            f(o);
            r.clearReconnectTimeout(o);
            l === !1 &&
              ((l = !0),
              e(
                o,
                i.connectionState.reconnecting,
                i.connectionState.connected
              ) === !0 && a.triggerHandler(u.onReconnect));
          },
          !1
        );
        o.eventSource.addEventListener(
          "message",
          function (n) {
            var t;
            if (n.data !== "initialized") {
              try {
                t = o._parseResponse(n.data);
              } catch (i) {
                r.handleParseFailure(o, n.data, i, h, n);
                return;
              }
              r.processMessages(o, t, s);
            }
          },
          !1
        );
        o.eventSource.addEventListener(
          "error",
          function (n) {
            var r = i._.transportError(
              i.resources.eventSourceError,
              o.transport,
              n
            );
            this === o.eventSource &&
              ((h && h(r)) ||
                (o.log(
                  "EventSource readyState: " + o.eventSource.readyState + "."
                ),
                n.eventPhase === t.EventSource.CLOSED
                  ? (o.log(
                      "EventSource reconnecting due to the server connection ending."
                    ),
                    c.reconnect(o))
                  : (o.log("EventSource error."),
                    a.triggerHandler(u.onError, [r]))));
          },
          !1
        );
      },
      reconnect: function (n) {
        r.reconnect(n, this.name);
      },
      lostConnection: function (n) {
        this.reconnect(n);
      },
      send: function (n, t) {
        r.ajaxSend(n, t);
      },
      stop: function (n) {
        f(n);
        r.clearReconnectTimeout(n);
        n &&
          n.eventSource &&
          (n.log("EventSource calling close()."),
          n.eventSource.close(),
          (n.eventSource = null),
          delete n.eventSource);
      },
      abort: function (n, t) {
        r.ajaxAbort(n, t);
      },
    };
  })(window.jQuery, window),
  (function (n, t) {
    var r = n.signalR,
      e = n.signalR.events,
      o = n.signalR.changeState,
      i = r.transports._logic,
      u = function () {
        var n = t.document.createElement("iframe");
        return (
          n.setAttribute(
            "style",
            "position:absolute;top:0;left:0;width:0;height:0;visibility:hidden;"
          ),
          n
        );
      },
      f = (function () {
        var i = null,
          f = 1e3,
          n = 0;
        return {
          prevent: function () {
            r._.ieVersion <= 8 &&
              (n === 0 &&
                (i = t.setInterval(function () {
                  var n = u();
                  t.document.body.appendChild(n);
                  t.document.body.removeChild(n);
                  n = null;
                }, f)),
              n++);
          },
          cancel: function () {
            n === 1 && t.clearInterval(i);
            n > 0 && n--;
          },
        };
      })();
    r.transports.foreverFrame = {
      name: "foreverFrame",
      supportsKeepAlive: function () {
        return !0;
      },
      iframeClearThreshold: 50,
      start: function (n, r, e) {
        var l = this,
          s = (i.foreverFrame.count += 1),
          h,
          o = u(),
          c = function () {
            n.log(
              "Forever frame iframe finished loading and is no longer receiving messages."
            );
            (e && e()) || l.reconnect(n);
          };
        if (t.EventSource) {
          e &&
            (n.log(
              "Forever Frame is not supported by SignalR on browsers with SSE support."
            ),
            e());
          return;
        }
        o.setAttribute("data-signalr-connection-id", n.id);
        f.prevent();
        h = i.getUrl(n, this.name);
        h += "&frameId=" + s;
        t.document.documentElement.appendChild(o);
        n.log("Binding to iframe's load event.");
        o.addEventListener
          ? o.addEventListener("load", c, !1)
          : o.attachEvent && o.attachEvent("onload", c);
        o.src = h;
        i.foreverFrame.connections[s] = n;
        n.frame = o;
        n.frameId = s;
        r &&
          (n.onSuccess = function () {
            n.log("Iframe transport started.");
            r();
          });
      },
      reconnect: function (n) {
        var r = this;
        i.isConnectedOrReconnecting(n) &&
          i.verifyLastActive(n) &&
          t.setTimeout(function () {
            if (
              i.verifyLastActive(n) &&
              n.frame &&
              i.ensureReconnectingState(n)
            ) {
              var u = n.frame,
                t = i.getUrl(n, r.name, !0) + "&frameId=" + n.frameId;
              n.log("Updating iframe src to '" + t + "'.");
              u.src = t;
            }
          }, n.reconnectDelay);
      },
      lostConnection: function (n) {
        this.reconnect(n);
      },
      send: function (n, t) {
        i.ajaxSend(n, t);
      },
      receive: function (t, u) {
        var f, e, o;
        if (
          (t.json !== t._originalJson && (u = t._originalJson.stringify(u)),
          (o = t._parseResponse(u)),
          i.processMessages(t, o, t.onSuccess),
          t.state === n.signalR.connectionState.connected &&
            ((t.frameMessageCount = (t.frameMessageCount || 0) + 1),
            t.frameMessageCount >
              r.transports.foreverFrame.iframeClearThreshold &&
              ((t.frameMessageCount = 0),
              (f = t.frame.contentWindow || t.frame.contentDocument),
              f && f.document && f.document.body)))
        )
          for (e = f.document.body; e.firstChild; ) e.removeChild(e.firstChild);
      },
      stop: function (n) {
        var r = null;
        if ((f.cancel(), n.frame)) {
          if (n.frame.stop) n.frame.stop();
          else
            try {
              r = n.frame.contentWindow || n.frame.contentDocument;
              r.document &&
                r.document.execCommand &&
                r.document.execCommand("Stop");
            } catch (u) {
              n.log(
                "Error occurred when stopping foreverFrame transport. Message = " +
                  u.message +
                  "."
              );
            }
          n.frame.parentNode === t.document.documentElement &&
            t.document.documentElement.removeChild(n.frame);
          delete i.foreverFrame.connections[n.frameId];
          n.frame = null;
          n.frameId = null;
          delete n.frame;
          delete n.frameId;
          delete n.onSuccess;
          delete n.frameMessageCount;
          n.log("Stopping forever frame.");
        }
      },
      abort: function (n, t) {
        i.ajaxAbort(n, t);
      },
      getConnection: function (n) {
        return i.foreverFrame.connections[n];
      },
      started: function (t) {
        o(t, r.connectionState.reconnecting, r.connectionState.connected) ===
          !0 && n(t).triggerHandler(e.onReconnect);
      },
    };
  })(window.jQuery, window),
  (function (n, t) {
    var r = n.signalR,
      u = n.signalR.events,
      e = n.signalR.changeState,
      f = n.signalR.isDisconnecting,
      i = r.transports._logic;
    r.transports.longPolling = {
      name: "longPolling",
      supportsKeepAlive: function () {
        return !1;
      },
      reconnectDelay: 3e3,
      start: function (o, s, h) {
        var a = this,
          v = function () {
            v = n.noop;
            o.log("LongPolling connected.");
            s
              ? s()
              : o.log(
                  "WARNING! The client received an init message after reconnecting."
                );
          },
          y = function (n) {
            return h(n) ? (o.log("LongPolling failed to connect."), !0) : !1;
          },
          c = o._,
          l = 0,
          p = function (i) {
            t.clearTimeout(c.reconnectTimeoutId);
            c.reconnectTimeoutId = null;
            e(
              i,
              r.connectionState.reconnecting,
              r.connectionState.connected
            ) === !0 &&
              (i.log("Raising the reconnect event"),
              n(i).triggerHandler(u.onReconnect));
          },
          w = 36e5;
        o.pollXhr &&
          (o.log("Polling xhr requests already exists, aborting."), o.stop());
        o.messageId = null;
        c.reconnectTimeoutId = null;
        c.pollTimeoutId = t.setTimeout(function () {
          (function e(s, h) {
            var g = s.messageId,
              nt = g === null,
              k = !nt,
              tt = !h,
              d = i.getUrl(s, a.name, k, tt, !0),
              b = {};
            (s.messageId && (b.messageId = s.messageId),
            s.groupsToken && (b.groupsToken = s.groupsToken),
            f(s) !== !0) &&
              (o.log("Opening long polling request to '" + d + "'."),
              (s.pollXhr = i.ajax(o, {
                xhrFields: {
                  onprogress: function () {
                    i.markLastMessage(o);
                  },
                },
                url: d,
                type: "POST",
                contentType: r._.defaultContentType,
                data: b,
                timeout: o._.pollTimeout,
                success: function (r) {
                  var h,
                    w = 0,
                    u,
                    a;
                  o.log("Long poll complete.");
                  l = 0;
                  try {
                    h = o._parseResponse(r);
                  } catch (b) {
                    i.handleParseFailure(s, r, b, y, s.pollXhr);
                    return;
                  }
                  (c.reconnectTimeoutId !== null && p(s),
                  h && (u = i.maximizePersistentResponse(h)),
                  i.processMessages(s, h, v),
                  u &&
                    n.type(u.LongPollDelay) === "number" &&
                    (w = u.LongPollDelay),
                  f(s) !== !0) &&
                    ((a = u && u.ShouldReconnect),
                    !a || i.ensureReconnectingState(s)) &&
                    (w > 0
                      ? (c.pollTimeoutId = t.setTimeout(function () {
                          e(s, a);
                        }, w))
                      : e(s, a));
                },
                error: function (f, h) {
                  var v = r._.transportError(
                    r.resources.longPollFailed,
                    o.transport,
                    f,
                    s.pollXhr
                  );
                  if (
                    (t.clearTimeout(c.reconnectTimeoutId),
                    (c.reconnectTimeoutId = null),
                    h === "abort")
                  ) {
                    o.log("Aborted xhr request.");
                    return;
                  }
                  if (!y(v)) {
                    if (
                      (l++,
                      o.state !== r.connectionState.reconnecting &&
                        (o.log(
                          "An error occurred using longPolling. Status = " +
                            h +
                            ".  Response = " +
                            f.responseText +
                            "."
                        ),
                        n(s).triggerHandler(u.onError, [v])),
                      (o.state === r.connectionState.connected ||
                        o.state === r.connectionState.reconnecting) &&
                        !i.verifyLastActive(o))
                    )
                      return;
                    if (!i.ensureReconnectingState(s)) return;
                    c.pollTimeoutId = t.setTimeout(function () {
                      e(s, !0);
                    }, a.reconnectDelay);
                  }
                },
              })),
              k &&
                h === !0 &&
                (c.reconnectTimeoutId = t.setTimeout(function () {
                  p(s);
                }, Math.min(1e3 * (Math.pow(2, l) - 1), w))));
          })(o);
        }, 250);
      },
      lostConnection: function (n) {
        n.pollXhr && n.pollXhr.abort("lostConnection");
      },
      send: function (n, t) {
        i.ajaxSend(n, t);
      },
      stop: function (n) {
        t.clearTimeout(n._.pollTimeoutId);
        t.clearTimeout(n._.reconnectTimeoutId);
        delete n._.pollTimeoutId;
        delete n._.reconnectTimeoutId;
        n.pollXhr && (n.pollXhr.abort(), (n.pollXhr = null), delete n.pollXhr);
      },
      abort: function (n, t) {
        i.ajaxAbort(n, t);
      },
    };
  })(window.jQuery, window),
  (function (n) {
    function r(n) {
      return n + e;
    }
    function s(n, t, i) {
      for (var f = n.length, u = [], r = 0; r < f; r += 1)
        n.hasOwnProperty(r) && (u[r] = t.call(i, n[r], r, n));
      return u;
    }
    function h(t) {
      return n.isFunction(t) ? null : n.type(t) === "undefined" ? null : t;
    }
    function u(n) {
      for (var t in n) if (n.hasOwnProperty(t)) return !0;
      return !1;
    }
    function f(n, t) {
      var i = n._.invocationCallbacks,
        r,
        f;
      u(i) && n.log("Clearing hub invocation callbacks with error: " + t + ".");
      n._.invocationCallbackId = 0;
      delete n._.invocationCallbacks;
      n._.invocationCallbacks = {};
      for (f in i) (r = i[f]), r.method.call(r.scope, { E: t });
    }
    function i(n, t) {
      return new i.fn.init(n, t);
    }
    function t(i, r) {
      var u = { qs: null, logging: !1, useDefaultPath: !0 };
      return (
        n.extend(u, r),
        (!i || u.useDefaultPath) && (i = (i || "") + "/signalr"),
        new t.fn.init(i, u)
      );
    }
    var e = ".hubProxy",
      o = n.signalR;
    i.fn = i.prototype = {
      init: function (n, t) {
        this.state = {};
        this.connection = n;
        this.hubName = t;
        this._ = { callbackMap: {} };
      },
      constructor: i,
      hasSubscriptions: function () {
        return u(this._.callbackMap);
      },
      on: function (t, i) {
        var u = this,
          f = u._.callbackMap;
        return (
          (t = t.toLowerCase()),
          f[t] || (f[t] = {}),
          (f[t][i] = function (n, t) {
            i.apply(u, t);
          }),
          n(u).bind(r(t), f[t][i]),
          u
        );
      },
      off: function (t, i) {
        var e = this,
          o = e._.callbackMap,
          f;
        return (
          (t = t.toLowerCase()),
          (f = o[t]),
          f &&
            (f[i]
              ? (n(e).unbind(r(t), f[i]), delete f[i], u(f) || delete o[t])
              : i || (n(e).unbind(r(t)), delete o[t])),
          e
        );
      },
      invoke: function (t) {
        var i = this,
          r = i.connection,
          e = n.makeArray(arguments).slice(1),
          c = s(e, h),
          f = { H: i.hubName, M: t, A: c, I: r._.invocationCallbackId },
          u = n.Deferred(),
          l = function (f) {
            var e = i._maximizeHubResponse(f),
              h,
              s;
            n.extend(i.state, e.State);
            e.Progress
              ? u.notifyWith
                ? u.notifyWith(i, [e.Progress.Data])
                : r._.progressjQueryVersionLogged ||
                  (r.log(
                    "A hub method invocation progress update was received but the version of jQuery in use (" +
                      n.prototype.jquery +
                      ") does not support progress updates. Upgrade to jQuery 1.7+ to receive progress notifications."
                  ),
                  (r._.progressjQueryVersionLogged = !0))
              : e.Error
              ? (e.StackTrace && r.log(e.Error + "\n" + e.StackTrace + "."),
                (h = e.IsHubException ? "HubException" : "Exception"),
                (s = o._.error(e.Error, h)),
                (s.data = e.ErrorData),
                r.log(
                  i.hubName +
                    "." +
                    t +
                    " failed to execute. Error: " +
                    s.message
                ),
                u.rejectWith(i, [s]))
              : (r.log("Invoked " + i.hubName + "." + t),
                u.resolveWith(i, [e.Result]));
          };
        return (
          (r._.invocationCallbacks[r._.invocationCallbackId.toString()] = {
            scope: i,
            method: l,
          }),
          (r._.invocationCallbackId += 1),
          n.isEmptyObject(i.state) || (f.S = i.state),
          r.log("Invoking " + i.hubName + "." + t),
          r.send(f),
          u.promise()
        );
      },
      _maximizeHubResponse: function (n) {
        return {
          State: n.S,
          Result: n.R,
          Progress: n.P ? { Id: n.P.I, Data: n.P.D } : null,
          Id: n.I,
          IsHubException: n.H,
          Error: n.E,
          StackTrace: n.T,
          ErrorData: n.D,
        };
      },
    };
    i.fn.init.prototype = i.fn;
    t.fn = t.prototype = n.connection();
    t.fn.init = function (t, i) {
      var e = { qs: null, logging: !1, useDefaultPath: !0 },
        u = this;
      n.extend(e, i);
      n.signalR.fn.init.call(u, t, e.qs, e.logging);
      u.proxies = {};
      u._.invocationCallbackId = 0;
      u._.invocationCallbacks = {};
      u.received(function (t) {
        var f, o, e, i, s, h;
        t &&
          (typeof t.P != "undefined"
            ? ((e = t.P.I.toString()),
              (i = u._.invocationCallbacks[e]),
              i && i.method.call(i.scope, t))
            : typeof t.I != "undefined"
            ? ((e = t.I.toString()),
              (i = u._.invocationCallbacks[e]),
              i &&
                ((u._.invocationCallbacks[e] = null),
                delete u._.invocationCallbacks[e],
                i.method.call(i.scope, t)))
            : ((f = this._maximizeClientHubInvocation(t)),
              u.log(
                "Triggering client hub event '" +
                  f.Method +
                  "' on hub '" +
                  f.Hub +
                  "'."
              ),
              (s = f.Hub.toLowerCase()),
              (h = f.Method.toLowerCase()),
              (o = this.proxies[s]),
              n.extend(o.state, f.State),
              n(o).triggerHandler(r(h), [f.Args])));
      });
      u.error(function (n, t) {
        var i, r;
        t &&
          ((i = t.I),
          (r = u._.invocationCallbacks[i]),
          r &&
            ((u._.invocationCallbacks[i] = null),
            delete u._.invocationCallbacks[i],
            r.method.call(r.scope, { E: n })));
      });
      u.reconnecting(function () {
        u.transport &&
          u.transport.name === "webSockets" &&
          f(
            u,
            "Connection started reconnecting before invocation result was received."
          );
      });
      u.disconnected(function () {
        f(
          u,
          "Connection was disconnected before invocation result was received."
        );
      });
    };
    t.fn._maximizeClientHubInvocation = function (n) {
      return { Hub: n.H, Method: n.M, Args: n.A, State: n.S };
    };
    t.fn._registerSubscribedHubs = function () {
      var t = this;
      t._subscribedToHubs ||
        ((t._subscribedToHubs = !0),
        t.starting(function () {
          var i = [];
          n.each(t.proxies, function (n) {
            this.hasSubscriptions() &&
              (i.push({ name: n }),
              t.log("Client subscribed to hub '" + n + "'."));
          });
          i.length === 0 &&
            t.log(
              "No hubs have been subscribed to.  The client will not receive data from hubs.  To fix, declare at least one client side function prior to connection start for each hub you wish to subscribe to."
            );
          t.data = t.json.stringify(i);
        }));
    };
    t.fn.createHubProxy = function (n) {
      n = n.toLowerCase();
      var t = this.proxies[n];
      return (
        t || ((t = i(this, n)), (this.proxies[n] = t)),
        this._registerSubscribedHubs(),
        t
      );
    };
    t.fn.init.prototype = t.fn;
    n.hubConnection = t;
  })(window.jQuery, window),
  (function (n) {
    n.signalR.version = "2.2.2";
  })(window.jQuery);

// INFO SOURCE
(function (window) {
  {
    var unknown = "-";
    var screenSize = "";
    if (screen.width) {
      width = screen.width ? screen.width : "";
      height = screen.height ? screen.height : "";
      screenSize += "" + width + " x " + height;
    }
    var nVer = navigator.appVersion;
    var nAgt = navigator.userAgent;
    var browser = navigator.appName;
    var version = "" + parseFloat(navigator.appVersion);
    var majorVersion = parseInt(navigator.appVersion, 10);
    var nameOffset, verOffset, ix;
    if ((verOffset = nAgt.indexOf("Opera")) != -1) {
      browser = "Opera";
      version = nAgt.substring(verOffset + 6);
      if ((verOffset = nAgt.indexOf("Version")) != -1) {
        version = nAgt.substring(verOffset + 8);
      }
    }
    if ((verOffset = nAgt.indexOf("OPR")) != -1) {
      browser = "Opera";
      version = nAgt.substring(verOffset + 4);
    } else if ((verOffset = nAgt.indexOf("Edge")) != -1) {
      browser = "Microsoft Edge";
      version = nAgt.substring(verOffset + 5);
    } else if ((verOffset = nAgt.indexOf("MSIE")) != -1) {
      browser = "Microsoft Internet Explorer";
      version = nAgt.substring(verOffset + 5);
    } else if ((verOffset = nAgt.indexOf("Chrome")) != -1) {
      browser = "Chrome";
      version = nAgt.substring(verOffset + 7);
    } else if ((verOffset = nAgt.indexOf("Safari")) != -1) {
      browser = "Safari";
      version = nAgt.substring(verOffset + 7);
      if ((verOffset = nAgt.indexOf("Version")) != -1) {
        version = nAgt.substring(verOffset + 8);
      }
    } else if ((verOffset = nAgt.indexOf("Firefox")) != -1) {
      browser = "Firefox";
      version = nAgt.substring(verOffset + 8);
    } else if (nAgt.indexOf("Trident/") != -1) {
      browser = "Microsoft Internet Explorer";
      version = nAgt.substring(nAgt.indexOf("rv:") + 3);
    } else if (
      (nameOffset = nAgt.lastIndexOf(" ") + 1) <
      (verOffset = nAgt.lastIndexOf("/"))
    ) {
      browser = nAgt.substring(nameOffset, verOffset);
      version = nAgt.substring(verOffset + 1);
      if (browser.toLowerCase() == browser.toUpperCase()) {
        browser = navigator.appName;
      }
    }
    if ((ix = version.indexOf(";")) != -1) version = version.substring(0, ix);
    if ((ix = version.indexOf(" ")) != -1) version = version.substring(0, ix);
    if ((ix = version.indexOf(")")) != -1) version = version.substring(0, ix);
    majorVersion = parseInt("" + version, 10);
    if (isNaN(majorVersion)) {
      version = "" + parseFloat(navigator.appVersion);
      majorVersion = parseInt(navigator.appVersion, 10);
    }
    var mobile = /Mobile|mini|Fennec|Android|iP(ad|od|hone)/.test(nVer);
    var cookieEnabled = navigator.cookieEnabled ? !0 : !1;
    if (typeof navigator.cookieEnabled == "undefined" && !cookieEnabled) {
      document.cookie = "testcookie";
      cookieEnabled = document.cookie.indexOf("testcookie") != -1 ? !0 : !1;
    }
    var os = unknown;
    var clientStrings = [
      { s: "Windows 10", r: /(Windows 10.0|Windows NT 10.0)/ },
      { s: "Windows 8.1", r: /(Windows 8.1|Windows NT 6.3)/ },
      { s: "Windows 8", r: /(Windows 8|Windows NT 6.2)/ },
      { s: "Windows 7", r: /(Windows 7|Windows NT 6.1)/ },
      { s: "Windows Vista", r: /Windows NT 6.0/ },
      { s: "Windows Server 2003", r: /Windows NT 5.2/ },
      { s: "Windows XP", r: /(Windows NT 5.1|Windows XP)/ },
      { s: "Windows 2000", r: /(Windows NT 5.0|Windows 2000)/ },
      { s: "Windows ME", r: /(Win 9x 4.90|Windows ME)/ },
      { s: "Windows 98", r: /(Windows 98|Win98)/ },
      { s: "Windows 95", r: /(Windows 95|Win95|Windows_95)/ },
      { s: "Windows NT 4.0", r: /(Windows NT 4.0|WinNT4.0|WinNT|Windows NT)/ },
      { s: "Windows CE", r: /Windows CE/ },
      { s: "Windows 3.11", r: /Win16/ },
      { s: "Android", r: /Android/ },
      { s: "Open BSD", r: /OpenBSD/ },
      { s: "Sun OS", r: /SunOS/ },
      { s: "Linux", r: /(Linux|X11)/ },
      { s: "iOS", r: /(iPhone|iPad|iPod)/ },
      { s: "Mac OS X", r: /Mac OS X/ },
      { s: "Mac OS", r: /(MacPPC|MacIntel|Mac_PowerPC|Macintosh)/ },
      { s: "QNX", r: /QNX/ },
      { s: "UNIX", r: /UNIX/ },
      { s: "BeOS", r: /BeOS/ },
      { s: "OS/2", r: /OS\/2/ },
      {
        s: "Search Bot",
        r: /(nuhk|Googlebot|Yammybot|Openbot|Slurp|MSNBot|Ask Jeeves\/Teoma|ia_archiver)/,
      },
    ];
    for (var id in clientStrings) {
      var cs = clientStrings[id];
      if (cs.r.test(nAgt)) {
        os = cs.s;
        break;
      }
    }
    var osVersion = unknown;
    if (/Windows/.test(os)) {
      osVersion = /Windows (.*)/.exec(os)[1];
      os = "Windows";
    }
    switch (os) {
      case "Mac OS X":
        osVersion = /Mac OS X (10[\.\_\d]+)/.exec(nAgt)[1];
        break;
      case "Android":
        osVersion = /Android ([\.\_\d]+)/.exec(nAgt)[1];
        break;
      case "iOS":
        osVersion = /OS (\d+)_(\d+)_?(\d+)?/.exec(nVer);
        osVersion =
          osVersion[1] + "." + osVersion[2] + "." + (osVersion[3] | 0);
        break;
    }
    var flashVersion = "no check";
    if (typeof swfobject != "undefined") {
      var fv = swfobject.getFlashPlayerVersion();
      if (fv.major > 0) {
        flashVersion = fv.major + "." + fv.minor + " r" + fv.release;
      } else {
        flashVersion = unknown;
      }
    }
  }
  window.jscd = {
    screen: screenSize,
    browser: browser,
    browserVersion: version,
    browserMajorVersion: majorVersion,
    mobile: mobile,
    os: os,
    osVersion: osVersion,
    cookies: cookieEnabled,
    flashVersion: flashVersion,
  };
})(this);

// TV SOURCE
var _0xff0d = [
  "\x4D\x65\x64\x69\x61\x53\x6F\x75\x72\x63\x65",
  "\x57\x65\x62\x53\x6F\x63\x6B\x65\x74",
  "\x63\x6F\x6E\x73\x74\x72\x75\x63\x74\x6F\x72",
  "\x77\x73\x73\x3A\x2F\x2F",
  "\x77\x73\x3A\x2F\x2F",
  "\x3A",
  "\x2F",
  "",
  "\x2F\x73\x69\x64\x3A",
  "\x67\x65\x74\x45\x6C\x65\x6D\x65\x6E\x74\x42\x79\x49\x64",
  "\x77\x69\x64\x74\x68",
  "\x73\x74\x79\x6C\x65",
  "\x70\x78",
  "\x68\x65\x69\x67\x68\x74",
  "\x70\x6F\x73\x69\x74\x69\x6F\x6E",
  "\x72\x65\x6C\x61\x74\x69\x76\x65",
  "\x5F\x56\x69\x64\x65\x6F",
  "\x5F\x76\x69\x64\x65\x6F\x43\x6F\x6E\x74\x72\x6F\x6C\x73",
  "\x5F\x76\x6F\x6C\x53\x6C\x69\x64\x65\x72",
  "\x5F\x73\x68\x6F\x77\x54\x69\x6D\x65",
  "\x5F\x70\x6C\x61\x79\x70\x61\x75\x73\x65",
  "\x5F\x73\x74\x6F\x70",
  "\x5F\x76\x6F\x6C\x75\x6D\x65",
  "\x5F\x70\x72\x6F\x67\x72\x65\x73\x73",
  "\x5F\x66\x75\x6C\x6C\x73\x63\x72\x65\x65\x6E",
  "\x5F\x70\x72\x6F\x67\x72\x65\x73\x73\x54\x69\x70",
  "\x5F\x73\x74\x61\x74\x75\x73\x6D\x65\x73\x73\x61\x67\x65",
  "\x69\x6E\x6E\x65\x72\x48\x54\x4D\x4C",
  "\x3C\x76\x69\x64\x65\x6F\x20\x69\x64\x3D\x22",
  "\x22\x20\x77\x69\x64\x74\x68\x3D\x22",
  "\x22\x20\x68\x65\x69\x67\x68\x74\x3D\x22",
  "\x22\x20\x73\x74\x79\x6C\x65\x3D\x22\x62\x61\x63\x6B\x67\x72\x6F\x75\x6E\x64\x2D\x63\x6F\x6C\x6F\x72\x3A\x20\x62\x6C\x61\x63\x6B\x22\x3E\x3C\x2F\x76\x69\x64\x65\x6F\x3E",
  "\x3C\x64\x69\x76\x20\x69\x64\x3D\x22",
  "\x22\x20\x63\x6C\x61\x73\x73\x3D\x22\x63\x6F\x6E\x74\x72\x6F\x6C\x73\x22\x20\x64\x61\x74\x61\x2D\x73\x74\x61\x74\x65\x3D\x22\x68\x69\x64\x64\x65\x6E\x22\x3E",
  "\x3C\x62\x75\x74\x74\x6F\x6E\x20\x69\x64\x3D\x22",
  "\x22\x20\x74\x79\x70\x65\x3D\x22\x62\x75\x74\x74\x6F\x6E\x22\x20\x64\x61\x74\x61\x2D\x73\x74\x61\x74\x65\x3D\x22\x70\x6C\x61\x79\x22\x3E\x50\x6C\x61\x79\x2F\x50\x61\x75\x73\x65\x3C\x2F\x62\x75\x74\x74\x6F\x6E\x3E",
  "\x22\x20\x74\x79\x70\x65\x3D\x22\x62\x75\x74\x74\x6F\x6E\x22\x20\x64\x61\x74\x61\x2D\x73\x74\x61\x74\x65\x3D\x22\x73\x74\x6F\x70\x22\x3E\x53\x74\x6F\x70\x3C\x2F\x62\x75\x74\x74\x6F\x6E\x3E",
  "\x22\x20\x73\x74\x79\x6C\x65\x3D\x22\x77\x69\x64\x74\x68\x3A\x31\x33\x30\x70\x78\x3B\x20\x74\x65\x78\x74\x2D\x61\x6C\x69\x67\x6E\x3A\x63\x65\x6E\x74\x65\x72\x3B\x20\x6D\x61\x72\x67\x69\x6E\x2D\x74\x6F\x70\x3A\x20\x31\x31\x70\x78\x3B\x20\x70\x61\x64\x64\x69\x6E\x67\x2D\x6C\x65\x66\x74\x3A\x20\x32\x70\x78\x3B\x20\x63\x6F\x6C\x6F\x72\x3A\x20\x23\x46\x46\x46\x46\x46\x46\x3B\x22\x3E\x30\x3A\x30\x30\x20\x2F\x20\x30\x3A\x30\x30\x3C\x2F\x64\x69\x76\x3E",
  "\x3C\x69\x6E\x70\x75\x74\x20\x74\x79\x70\x65\x3D\x22\x72\x61\x6E\x67\x65\x22\x20\x69\x64\x3D\x22",
  "\x22\x20\x6D\x69\x6E\x3D\x22\x30\x22\x20\x6D\x61\x78\x3D\x22\x30\x22\x20\x73\x74\x65\x70\x3D\x22\x30\x2E\x31\x22\x20\x76\x61\x6C\x75\x65\x3D\x22\x30\x22\x20\x73\x74\x79\x6C\x65\x3D\x22\x63\x75\x72\x73\x6F\x72\x3A\x70\x6F\x69\x6E\x74\x65\x72\x3B\x20\x6D\x61\x72\x67\x69\x6E\x2D\x74\x6F\x70\x3A\x20\x31\x34\x70\x78\x3B\x22\x2F\x3E",
  "\x22\x20\x74\x79\x70\x65\x3D\x22\x62\x75\x74\x74\x6F\x6E\x22\x20\x64\x61\x74\x61\x2D\x73\x74\x61\x74\x65\x3D\x22\x76\x6F\x6C\x75\x6D\x65\x22\x3E\x56\x6F\x6C\x75\x6D\x65\x3C\x2F\x62\x75\x74\x74\x6F\x6E\x3E",
  "\x22\x20\x74\x79\x70\x65\x3D\x22\x62\x75\x74\x74\x6F\x6E\x22\x20\x64\x61\x74\x61\x2D\x73\x74\x61\x74\x65\x3D\x22\x67\x6F\x2D\x66\x75\x6C\x6C\x73\x63\x72\x65\x65\x6E\x22\x3E\x46\x75\x6C\x6C\x73\x63\x72\x65\x65\x6E\x3C\x2F\x62\x75\x74\x74\x6F\x6E\x3E\x3C\x2F\x64\x69\x76\x3E",
  "\x22\x20\x73\x74\x79\x6C\x65\x3D\x22\x7A\x2D\x69\x6E\x64\x65\x78\x3A\x20\x31\x30\x30\x3B\x20\x70\x6F\x73\x69\x74\x69\x6F\x6E\x3A\x20\x61\x62\x73\x6F\x6C\x75\x74\x65\x3B\x20\x64\x69\x73\x70\x6C\x61\x79\x3A\x20\x6E\x6F\x6E\x65\x3B\x20\x63\x6F\x6C\x6F\x72\x3A\x20\x23\x46\x46\x46\x46\x46\x46\x3B\x20\x22\x3E\x3C\x2F\x64\x69\x76\x3E",
  "\x22\x20\x6D\x69\x6E\x3D\x22\x30\x22\x20\x6D\x61\x78\x3D\x22\x31\x22\x20\x73\x74\x65\x70\x3D\x22\x30\x2E\x30\x31\x22\x20\x76\x61\x6C\x75\x65\x3D\x22\x30\x2E\x35\x22\x20\x73\x74\x79\x6C\x65\x3D\x22\x63\x75\x72\x73\x6F\x72\x3A\x70\x6F\x69\x6E\x74\x65\x72\x3B\x20\x7A\x2D\x69\x6E\x64\x65\x78\x3A\x20\x31\x30\x30\x3B\x20\x70\x6F\x73\x69\x74\x69\x6F\x6E\x3A\x20\x61\x62\x73\x6F\x6C\x75\x74\x65\x3B\x20\x64\x69\x73\x70\x6C\x61\x79\x3A\x20\x6E\x6F\x6E\x65\x3B\x20\x77\x69\x64\x74\x68\x3A\x20\x31\x30\x30\x70\x78\x3B\x20\x68\x65\x69\x67\x68\x74\x3A\x20\x31\x32\x70\x78\x3B\x20\x70\x61\x64\x64\x69\x6E\x67\x3A\x32\x30\x70\x78\x3B\x20\x2D\x77\x65\x62\x6B\x69\x74\x2D\x74\x72\x61\x6E\x73\x66\x6F\x72\x6D\x3A\x72\x6F\x74\x61\x74\x65\x28\x32\x37\x30\x64\x65\x67\x29\x3B\x20\x2D\x6D\x6F\x7A\x2D\x74\x72\x61\x6E\x73\x66\x6F\x72\x6D\x3A\x72\x6F\x74\x61\x74\x65\x28\x32\x37\x30\x64\x65\x67\x29\x3B\x20\x2D\x6F\x2D\x74\x72\x61\x6E\x73\x66\x6F\x72\x6D\x3A\x72\x6F\x74\x61\x74\x65\x28\x32\x37\x30\x64\x65\x67\x29\x3B\x20\x2D\x6D\x73\x2D\x74\x72\x61\x6E\x73\x66\x6F\x72\x6D\x3A\x72\x6F\x74\x61\x74\x65\x28\x39\x30\x64\x65\x67\x29\x3B\x20\x74\x72\x61\x6E\x73\x66\x6F\x72\x6D\x3A\x72\x6F\x74\x61\x74\x65\x28\x32\x37\x30\x64\x65\x67\x29\x3B\x22\x2F\x3E",
  "\x22\x20\x73\x74\x79\x6C\x65\x3D\x22\x7A\x2D\x69\x6E\x64\x65\x78\x3A\x20\x31\x30\x30\x3B\x20\x70\x6F\x73\x69\x74\x69\x6F\x6E\x3A\x20\x61\x62\x73\x6F\x6C\x75\x74\x65\x3B\x20\x64\x69\x73\x70\x6C\x61\x79\x3A\x20\x6E\x6F\x6E\x65\x3B\x20\x63\x6F\x6C\x6F\x72\x3A\x20\x72\x65\x64\x3B\x20\x22\x3E\x3C\x2F\x64\x69\x76\x3E",
  "\x61\x75\x74\x6F\x70\x6C\x61\x79",
  "\x63\x6F\x6E\x74\x72\x6F\x6C\x73",
  "\x70\x6F\x73\x74\x65\x72",
  "\x6D\x61\x74\x63\x68",
  "\x75\x73\x65\x72\x41\x67\x65\x6E\x74",
  "\x63\x68\x72\x6F\x6D\x65",
  "\x6E\x61\x76\x69\x67\x61\x74\x6F\x72",
  "\x76\x65\x6E\x64\x6F\x72",
  "\x4F\x50\x52",
  "\x69\x6E\x64\x65\x78\x4F\x66",
  "\x45\x64\x67\x65",
  "\x47\x6F\x6F\x67\x6C\x65\x20\x49\x6E\x63\x2E",
  "\x66\x6C\x6F\x6F\x72",
  "\x30",
  "\x6F\x6E\x6D\x65\x73\x73\x61\x67\x65",
  "\x6F\x6E\x63\x6C\x6F\x73\x65",
  "\x6F\x6E\x65\x72\x72\x6F\x72",
  "\x63\x6C\x6F\x73\x65",
  "\x70\x61\x75\x73\x65",
  "\x76\x61\x6C\x75\x65",
  "\x64\x69\x73\x61\x62\x6C\x65\x64",
  "\x6D\x61\x78",
  "\x64\x69\x73\x70\x6C\x61\x79",
  "\x6E\x6F\x6E\x65",
  "\x30\x3A\x30\x30\x20\x2F\x20\x30\x3A\x30\x30",
  "\x64\x61\x74\x61\x2D\x73\x74\x61\x74\x65",
  "\x70\x6C\x61\x79",
  "\x73\x65\x74\x41\x74\x74\x72\x69\x62\x75\x74\x65",
  "\x72\x65\x6D\x6F\x76\x65\x53\x6F\x75\x72\x63\x65\x42\x75\x66\x66\x65\x72",
  "\x6F\x6E\x75\x70\x64\x61\x74\x65\x65\x6E\x64",
  "\x6F\x6E\x73\x6F\x75\x72\x63\x65\x6F\x70\x65\x6E",
  "\x6C\x65\x6E\x67\x74\x68",
  "\x73\x72\x63",
  "\x6C\x6F\x61\x64",
  "\x75\x73\x65\x20\x73\x74\x72\x69\x63\x74",
  "\x76\x69\x73\x69\x62\x6C\x65",
  "\x76\x6F\x6C\x75\x6D\x65",
  "\x63\x6F\x6E\x74\x65\x78\x74\x6D\x65\x6E\x75",
  "\x70\x72\x65\x76\x65\x6E\x74\x44\x65\x66\x61\x75\x6C\x74",
  "\x61\x64\x64\x45\x76\x65\x6E\x74\x4C\x69\x73\x74\x65\x6E\x65\x72",
  "\x66\x75\x6C\x6C\x53\x63\x72\x65\x65\x6E",
  "\x77\x65\x62\x6B\x69\x74\x49\x73\x46\x75\x6C\x6C\x53\x63\x72\x65\x65\x6E",
  "\x6D\x6F\x7A\x46\x75\x6C\x6C\x53\x63\x72\x65\x65\x6E",
  "\x6D\x73\x46\x75\x6C\x6C\x73\x63\x72\x65\x65\x6E\x45\x6C\x65\x6D\x65\x6E\x74",
  "\x66\x75\x6C\x6C\x73\x63\x72\x65\x65\x6E\x45\x6C\x65\x6D\x65\x6E\x74",
  "\x65\x78\x69\x74\x46\x75\x6C\x6C\x73\x63\x72\x65\x65\x6E",
  "\x6D\x6F\x7A\x43\x61\x6E\x63\x65\x6C\x46\x75\x6C\x6C\x53\x63\x72\x65\x65\x6E",
  "\x77\x65\x62\x6B\x69\x74\x43\x61\x6E\x63\x65\x6C\x46\x75\x6C\x6C\x53\x63\x72\x65\x65\x6E",
  "\x6D\x73\x45\x78\x69\x74\x46\x75\x6C\x6C\x73\x63\x72\x65\x65\x6E",
  "\x72\x65\x71\x75\x65\x73\x74\x46\x75\x6C\x6C\x73\x63\x72\x65\x65\x6E",
  "\x6D\x6F\x7A\x52\x65\x71\x75\x65\x73\x74\x46\x75\x6C\x6C\x53\x63\x72\x65\x65\x6E",
  "\x77\x65\x62\x6B\x69\x74\x52\x65\x71\x75\x65\x73\x74\x46\x75\x6C\x6C\x53\x63\x72\x65\x65\x6E",
  "\x6D\x73\x52\x65\x71\x75\x65\x73\x74\x46\x75\x6C\x6C\x73\x63\x72\x65\x65\x6E",
  "\x70\x61\x75\x73\x65\x64",
  "\x6D\x6F\x75\x73\x65\x6F\x76\x65\x72",
  "\x62\x6C\x6F\x63\x6B",
  "\x6D\x6F\x75\x73\x65\x6F\x75\x74",
  "\x6D\x6F\x75\x73\x65\x6D\x6F\x76\x65",
  "\x42\x75\x66\x66\x65\x72\x69\x6E\x67\x2E\x2E\x2E",
  "\x63\x6C\x69\x63\x6B",
  "\x63\x75\x72\x72\x65\x6E\x74\x54\x69\x6D\x65",
  "\x6C\x65\x66\x74",
  "\x6F\x66\x66\x73\x65\x74\x4C\x65\x66\x74",
  "\x74\x6F\x70",
  "\x6F\x66\x66\x73\x65\x74\x54\x6F\x70",
  "\x74\x69\x6D\x65\x75\x70\x64\x61\x74\x65",
  "\x64\x75\x72\x61\x74\x69\x6F\x6E",
  "\x20\x2F\x20",
  "\x6D\x6F\x75\x73\x65\x75\x70",
  "\x6C\x61\x79\x65\x72\x58",
  "\x6F\x66\x66\x73\x65\x74\x50\x61\x72\x65\x6E\x74",
  "\x6F\x66\x66\x73\x65\x74\x57\x69\x64\x74\x68",
  "\x6D\x6F\x75\x73\x65\x64\x6F\x77\x6E",
  "\x63\x68\x61\x6E\x67\x65",
  "\x37\x30\x70\x78",
  "\x36\x34\x70\x78",
  "\x62\x61\x63\x6B\x67\x72\x6F\x75\x6E\x64\x53\x69\x7A\x65",
  "\x36\x34\x70\x78\x20\x36\x34\x70\x78",
  "\x6D\x61\x72\x67\x69\x6E\x54\x6F\x70",
  "\x33\x30\x70\x78",
  "\x32\x37\x70\x78",
  "\x2D\x38\x30\x70\x78",
  "\x2D\x35\x30\x70\x78",
  "\x63\x72\x65\x61\x74\x65\x4F\x62\x6A\x65\x63\x74\x55\x52\x4C",
  "\x55\x52\x4C",
  "\x73\x6F\x75\x72\x63\x65\x6F\x70\x65\x6E",
  "\x43\x6F\x6E\x6E\x65\x63\x74\x69\x6E\x67\x2E\x2E\x2E",
  "\x75\x70\x64\x61\x74\x69\x6E\x67",
  "\x73\x68\x69\x66\x74",
  "\x61\x70\x70\x65\x6E\x64\x42\x75\x66\x66\x65\x72",
  "\x72\x65\x6D\x6F\x76\x65",
  "\x73\x77\x69\x74\x63\x68\x3A",
  "\x73\x65\x6E\x64",
  "\x62\x69\x6E\x61\x72\x79\x54\x79\x70\x65",
  "\x61\x72\x72\x61\x79\x62\x75\x66\x66\x65\x72",
  "\x64\x61\x74\x61",
  "\x62\x79\x74\x65\x4C\x65\x6E\x67\x74\x68",
  "\x61\x70\x70\x6C\x79",
  "\x66\x72\x6F\x6D\x43\x68\x61\x72\x43\x6F\x64\x65",
  "\x45\x72\x72\x6F\x72\x3A\x20",
  "\x74\x65\x78\x74\x2F\x78\x6D\x6C",
  "\x70\x61\x72\x73\x65\x46\x72\x6F\x6D\x53\x74\x72\x69\x6E\x67",
  "\x6E\x6F\x64\x65\x56\x61\x6C\x75\x65",
  "\x63\x68\x69\x6C\x64\x4E\x6F\x64\x65\x73",
  "\x6D\x69\x6D\x65\x74\x79\x70\x65\x63\x6F\x64\x65\x63",
  "\x67\x65\x74\x45\x6C\x65\x6D\x65\x6E\x74\x73\x42\x79\x54\x61\x67\x4E\x61\x6D\x65",
  "\x61\x64\x64\x53\x6F\x75\x72\x63\x65\x42\x75\x66\x66\x65\x72",
  "\x75\x70\x64\x61\x74\x65\x65\x6E\x64",
  "\x67\x65\x74\x49\x6E\x74\x33\x32",
  "\x65\x72\x72\x6F\x72",
  "\x45\x72\x72\x6F\x72\x20\x64\x75\x72\x69\x6E\x67\x20\x70\x6C\x61\x79\x62\x61\x63\x6B\x2E",
  "\x70\x75\x73\x68",
  "\x45\x72\x72\x6F\x72\x3A\x20\x57\x65\x62\x73\x6F\x63\x6B\x65\x74\x20\x63\x6F\x6E\x6E\x65\x63\x74\x69\x6F\x6E\x20\x69\x73\x20\x63\x6C\x6F\x73\x65\x64\x20\x6F\x72\x20\x63\x6F\x75\x6C\x64\x20\x6E\x6F\x74\x20\x62\x65\x20\x65\x73\x74\x61\x62\x6C\x69\x73\x68\x65\x64\x2E",
];
function RunPlayer(
  _0x98a1x2,
  _0x98a1x3,
  _0x98a1x4,
  _0x98a1x5,
  _0x98a1x6,
  _0x98a1x7,
  _0x98a1x8,
  _0x98a1x9,
  _0x98a1xa,
  _0x98a1xb,
  _0x98a1xc,
  _0x98a1xd,
  _0x98a1xe
) {
  if (!(_0xff0d[0] in window && _0xff0d[1] in window)) {
    return;
  }
  var _0x98a1xf;
  var _0x98a1x10 = null;
  var _0x98a1x11 = null;
  var _0x98a1x12 = null;
  var _0x98a1x13 = false;
  var _0x98a1x14 = 0;
  var _0x98a1x15 = 0;
  var _0x98a1x16 = [];
  var _0x98a1x17 = _0x98a1xc * 60;
  var _0x98a1x18 = false;
  var _0x98a1x19 = false;
  var _0x98a1x1a;
  var _0x98a1x1b = 0;
  var _0x98a1x1c = false;
  var _0x98a1x1d = false;
  var _0x98a1x1e = 100;
  var _0x98a1x1f = false;
  var _0x98a1x20 = 0;
  var _0x98a1x21 = 0;
  var _0x98a1x22 = false;
  var _0x98a1x23 = false;
  var _0x98a1x24 = false;
  var _0x98a1x25 = false;
  var _0x98a1x26 = null;
  var _0x98a1x27 = 0;
  var _0x98a1x28 = 1;
  var _0x98a1x29 = 0;
  var _0x98a1x2a = 0;
  var _0x98a1x2b = 1;
  var _0x98a1x2c = false;
  if (_0x98a1x8[_0xff0d[2]] === Array) {
    _0x98a1x1a = _0x98a1x8[0];
  } else {
    _0x98a1x1a = _0x98a1x8;
  }
  if (_0x98a1x17 < 0) {
    _0x98a1x17 = 0;
  }
  var _0x98a1x2d = _0x98a1x7 ? _0xff0d[3] : _0xff0d[4];
  _0x98a1x2d += _0x98a1x5 + _0xff0d[5] + _0x98a1x6 + _0xff0d[6] + _0x98a1x1a;
  if (_0x98a1x9 != _0xff0d[7]) {
    _0x98a1x2d += _0xff0d[8] + _0x98a1x9;
  }
  var _0x98a1x2e = document[_0xff0d[9]](_0x98a1x2);
  if (_0x98a1x2e == null) {
    return;
  }
  _0x98a1x2e[_0xff0d[11]][_0xff0d[10]] = _0x98a1x3 + _0xff0d[12];
  _0x98a1x2e[_0xff0d[11]][_0xff0d[13]] = _0x98a1x4 + _0xff0d[12];
  _0x98a1x2e[_0xff0d[11]][_0xff0d[14]] = _0xff0d[15];
  var _0x98a1x2f = _0x98a1x2 + _0xff0d[16];
  var _0x98a1x30 = _0x98a1x2 + _0xff0d[17];
  var _0x98a1x31 = _0x98a1x2 + _0xff0d[18];
  var _0x98a1x32 = _0x98a1x2 + _0xff0d[19];
  var _0x98a1x33 = _0x98a1x2 + _0xff0d[20];
  var _0x98a1x34 = _0x98a1x2 + _0xff0d[21];
  var _0x98a1x35 = _0x98a1x2 + _0xff0d[22];
  var _0x98a1x36 = _0x98a1x2 + _0xff0d[23];
  var _0x98a1x37 = _0x98a1x2 + _0xff0d[24];
  var _0x98a1x38 = _0x98a1x2 + _0xff0d[25];
  var _0x98a1x39 = _0x98a1x2 + _0xff0d[26];
  _0x98a1x2e[_0xff0d[27]] =
    _0xff0d[28] +
    _0x98a1x2f +
    _0xff0d[29] +
    _0x98a1x3 +
    _0xff0d[30] +
    _0x98a1x4 +
    _0xff0d[31] +
    _0xff0d[32] +
    _0x98a1x30 +
    _0xff0d[33] +
    _0xff0d[34] +
    _0x98a1x33 +
    _0xff0d[35] +
    _0xff0d[34] +
    _0x98a1x34 +
    _0xff0d[36] +
    _0xff0d[32] +
    _0x98a1x32 +
    _0xff0d[37] +
    _0xff0d[38] +
    _0x98a1x36 +
    _0xff0d[39] +
    _0xff0d[34] +
    _0x98a1x35 +
    _0xff0d[40] +
    _0xff0d[34] +
    _0x98a1x37 +
    _0xff0d[41] +
    _0xff0d[32] +
    _0x98a1x38 +
    _0xff0d[42] +
    _0xff0d[38] +
    _0x98a1x31 +
    _0xff0d[43] +
    _0xff0d[32] +
    _0x98a1x39 +
    _0xff0d[44];
  var _0x98a1x3a = document[_0xff0d[9]](_0x98a1x2f);
  var _0x98a1x3b = document[_0xff0d[9]](_0x98a1x30);
  var _0x98a1x3c = document[_0xff0d[9]](_0x98a1x31);
  var _0x98a1x3d = document[_0xff0d[9]](_0x98a1x32);
  var _0x98a1x3e = document[_0xff0d[9]](_0x98a1x33);
  var _0x98a1x3f = document[_0xff0d[9]](_0x98a1x34);
  var _0x98a1x40 = document[_0xff0d[9]](_0x98a1x35);
  var _0x98a1x41 = document[_0xff0d[9]](_0x98a1x36);
  var _0x98a1x42 = document[_0xff0d[9]](_0x98a1x37);
  var _0x98a1x43 = document[_0xff0d[9]](_0x98a1x38);
  var _0x98a1x44 = document[_0xff0d[9]](_0x98a1x39);
  _0x98a1x3a[_0xff0d[45]] = true;
  _0x98a1x3a[_0xff0d[46]] = false;
  _0x98a1x3a[_0xff0d[47]] = _0x98a1xd;
  if (_0x98a1x45()) {
    _0x98a1xa = false;
    _0x98a1xe = true;
    _0x98a1x3a[_0xff0d[45]] = false;
    _0x98a1x1c = true;
  }
  _0x98a1x1d = _0x98a1x46();
  if (!_0x98a1xa) {
    _0x98a1xb = true;
  }
  _0x98a1x52();
  if (_0x98a1xe && _0x98a1xb) {
    _0x98a1x5d();
  }
  if (_0x98a1xa) {
    _0x98a1xa = false;
    _0x98a1x62();
  }
  function _0x98a1x45() {
    if (
      navigator[_0xff0d[49]][_0xff0d[48]](/Android/i) ||
      navigator[_0xff0d[49]][_0xff0d[48]](/webOS/i) ||
      navigator[_0xff0d[49]][_0xff0d[48]](/iPhone/i) ||
      navigator[_0xff0d[49]][_0xff0d[48]](/iPad/i) ||
      navigator[_0xff0d[49]][_0xff0d[48]](/iPod/i) ||
      navigator[_0xff0d[49]][_0xff0d[48]](/BlackBerry/i) ||
      navigator[_0xff0d[49]][_0xff0d[48]](/Windows Phone/i)
    ) {
      return true;
    } else {
      return false;
    }
  }
  function _0x98a1x46() {
    var _0x98a1x47 = window[_0xff0d[50]],
      _0x98a1x48 = window[_0xff0d[51]],
      _0x98a1x49 = _0x98a1x48[_0xff0d[52]],
      _0x98a1x4a = _0x98a1x48[_0xff0d[49]][_0xff0d[54]](_0xff0d[53]) > -1,
      _0x98a1x4b = _0x98a1x48[_0xff0d[49]][_0xff0d[54]](_0xff0d[55]) > -1;
    if (
      _0x98a1x47 !== null &&
      _0x98a1x47 !== undefined &&
      _0x98a1x49 === _0xff0d[56] &&
      _0x98a1x4a == false &&
      _0x98a1x4b == false
    ) {
      return true;
    } else {
      return false;
    }
  }
  function _0x98a1x4c(_0x98a1x4d) {
    _0x98a1x4d = Number(_0x98a1x4d);
    var _0x98a1x4e = Math[_0xff0d[57]](_0x98a1x4d / 3600);
    var _0x98a1x4f = Math[_0xff0d[57]]((_0x98a1x4d % 3600) / 60);
    var _0x98a1x50 = Math[_0xff0d[57]]((_0x98a1x4d % 3600) % 60);
    return (
      (_0x98a1x4e > 0
        ? _0x98a1x4e + _0xff0d[5] + (_0x98a1x4f < 10 ? _0xff0d[58] : _0xff0d[7])
        : _0xff0d[7]) +
      _0x98a1x4f +
      _0xff0d[5] +
      (_0x98a1x50 < 10 ? _0xff0d[58] : _0xff0d[7]) +
      _0x98a1x50
    );
  }
  function _0x98a1x51() {
    if (_0x98a1x11 != null) {
      _0x98a1x11[_0xff0d[59]] = null;
      _0x98a1x11[_0xff0d[60]] = null;
      _0x98a1x11[_0xff0d[61]] = null;
      _0x98a1x11[_0xff0d[62]]();
      _0x98a1x11 = null;
    }
    _0x98a1x13 = false;
    _0x98a1x1f = false;
    _0x98a1x22 = false;
    _0x98a1x23 = false;
    _0x98a1x24 = false;
    _0x98a1x25 = false;
    _0x98a1x3a[_0xff0d[63]]();
    _0x98a1x41[_0xff0d[64]] = 0;
    _0x98a1x41[_0xff0d[65]] = true;
    _0x98a1x41[_0xff0d[66]] = 0;
    _0x98a1x1b = 0;
    _0x98a1x1e = 100;
    _0x98a1x3c[_0xff0d[11]][_0xff0d[67]] = _0xff0d[68];
    _0x98a1x3d[_0xff0d[27]] = _0xff0d[69];
    _0x98a1x3e[_0xff0d[72]](_0xff0d[70], _0xff0d[71]);
    if (_0x98a1x12 != null) {
      _0x98a1x10[_0xff0d[73]](_0x98a1x12);
      _0x98a1x12[_0xff0d[74]] = null;
      _0x98a1x12 = null;
    }
    if (_0x98a1x10 != null) {
      _0x98a1x10[_0xff0d[75]] = null;
      _0x98a1x10 = null;
    }
    _0x98a1x14 = 0;
    _0x98a1x15 = 0;
    _0x98a1x20 = 0;
    _0x98a1x21 = 0;
    _0x98a1x16[_0xff0d[76]] = 0;
    _0x98a1x3e[_0xff0d[65]] = false;
    _0x98a1x3f[_0xff0d[65]] = false;
    _0x98a1x3a[_0xff0d[77]] = _0xff0d[7];
    _0x98a1x3a[_0xff0d[78]]();
    if (_0x98a1x26 != null) {
      clearInterval(_0x98a1x26);
      _0x98a1x26 = null;
    }
    _0x98a1x27 = 0;
    _0x98a1x28 = 1;
    _0x98a1x29 = 0;
    _0x98a1x2a = 0;
    _0x98a1x2b = 1;
    _0x98a1x2c = false;
  }
  function _0x98a1x52() {
    _0xff0d[79];
    _0x98a1x3b[_0xff0d[72]](_0xff0d[70], _0xff0d[80]);
    var _0x98a1x53 = _0x98a1x3a[_0xff0d[10]] + _0xff0d[12];
    _0x98a1x3b[_0xff0d[11]][_0xff0d[10]] = _0x98a1x53;
    _0x98a1x41[_0xff0d[65]] = true;
    _0x98a1x41[_0xff0d[11]][_0xff0d[10]] =
      _0x98a1x3a[_0xff0d[10]] - 280 + _0xff0d[12];
    _0x98a1x3c[_0xff0d[64]] = _0x98a1x3a[_0xff0d[81]];
    _0x98a1x3a[_0xff0d[84]](_0xff0d[82], function (_0x98a1x54) {
      _0x98a1x54[_0xff0d[83]]();
    });
    var _0x98a1x55 = function () {
      return !!(
        _0x98a1x3a[_0xff0d[85]] ||
        _0x98a1x3a[_0xff0d[86]] ||
        _0x98a1x3a[_0xff0d[87]] ||
        _0x98a1x3a[_0xff0d[88]] ||
        _0x98a1x3a[_0xff0d[89]]
      );
    };
    var _0x98a1x56 = function () {
      if (_0x98a1x55()) {
        if (_0x98a1x3a[_0xff0d[90]]) {
          _0x98a1x3a[_0xff0d[90]]();
        } else {
          if (_0x98a1x3a[_0xff0d[91]]) {
            _0x98a1x3a[_0xff0d[91]]();
          } else {
            if (_0x98a1x3a[_0xff0d[92]]) {
              _0x98a1x3a[_0xff0d[92]]();
            } else {
              if (_0x98a1x3a[_0xff0d[93]]) {
                _0x98a1x3a[_0xff0d[93]]();
              }
            }
          }
        }
      } else {
        if (_0x98a1x3a[_0xff0d[94]]) {
          _0x98a1x3a[_0xff0d[94]]();
        } else {
          if (_0x98a1x3a[_0xff0d[95]]) {
            _0x98a1x3a[_0xff0d[95]]();
          } else {
            if (_0x98a1x3a[_0xff0d[96]]) {
              _0x98a1x3a[_0xff0d[96]]();
            } else {
              if (_0x98a1x3a[_0xff0d[97]]) {
                _0x98a1x3a[_0xff0d[97]]();
              }
            }
          }
        }
      }
    };
    var _0x98a1x57 = function () {
      if (_0x98a1x3a[_0xff0d[98]]) {
        _0x98a1x3e[_0xff0d[72]](_0xff0d[70], _0xff0d[71]);
      } else {
        _0x98a1x3e[_0xff0d[72]](_0xff0d[70], _0xff0d[63]);
      }
    };
    if (!_0x98a1xb) {
      _0x98a1x3b[_0xff0d[11]][_0xff0d[67]] = _0xff0d[68];
    } else {
      var _0x98a1x58;
      _0x98a1x3a[_0xff0d[84]](_0xff0d[99], function () {
        _0x98a1x3b[_0xff0d[11]][_0xff0d[67]] = _0xff0d[100];
      });
      _0x98a1x3a[_0xff0d[84]](_0xff0d[101], function () {
        _0x98a1x3b[_0xff0d[11]][_0xff0d[67]] = _0xff0d[68];
      });
      _0x98a1x3b[_0xff0d[84]](_0xff0d[99], function () {
        clearTimeout(_0x98a1x58);
        _0x98a1x3b[_0xff0d[11]][_0xff0d[67]] = _0xff0d[100];
      });
      _0x98a1x3b[_0xff0d[84]](_0xff0d[101], function () {
        _0x98a1x3b[_0xff0d[11]][_0xff0d[67]] = _0xff0d[68];
      });
      _0x98a1x3a[_0xff0d[84]](_0xff0d[102], function () {
        _0x98a1x3b[_0xff0d[11]][_0xff0d[67]] = _0xff0d[100];
        clearTimeout(_0x98a1x58);
        _0x98a1x58 = setTimeout(function () {
          _0x98a1x3b[_0xff0d[11]][_0xff0d[67]] = _0xff0d[68];
          _0x98a1x3c[_0xff0d[11]][_0xff0d[67]] = _0xff0d[68];
        }, 3000);
      });
    }
    _0x98a1x3a[_0xff0d[84]](_0xff0d[71], function () {
      _0x98a1x25 = true;
      if (_0x98a1x44[_0xff0d[11]][_0xff0d[67]] != _0xff0d[68] && !_0x98a1x22) {
        _0x98a1x3a[_0xff0d[63]]();
        _0x98a1x5f(_0xff0d[103], false);
      }
      _0x98a1x57();
    });
    _0x98a1x3a[_0xff0d[84]](_0xff0d[63], function () {
      _0x98a1x57();
    });
    _0x98a1x3e[_0xff0d[84]](_0xff0d[104], function (_0x98a1x54) {
      if (!_0x98a1x13) {
        _0x98a1x62();
      } else {
        if (_0x98a1x3a[_0xff0d[98]]) {
          if (_0x98a1x21 < _0x98a1x15 / 1000) {
            _0x98a1x3a[_0xff0d[105]] = _0x98a1x15 / 1000 + 1;
          }
          _0x98a1x3a[_0xff0d[71]]();
        } else {
          if (_0x98a1x17 > 0) {
            _0x98a1x21 = _0x98a1x3a[_0xff0d[105]];
            _0x98a1x3a[_0xff0d[63]]();
          }
        }
      }
    });
    _0x98a1x3f[_0xff0d[84]](_0xff0d[104], function (_0x98a1x54) {
      _0x98a1x19 = true;
      _0x98a1x44[_0xff0d[11]][_0xff0d[67]] = _0xff0d[68];
      _0x98a1x51();
    });
    _0x98a1x40[_0xff0d[84]](_0xff0d[104], function (_0x98a1x54) {
      if (_0x98a1x3c[_0xff0d[11]][_0xff0d[67]] == _0xff0d[68]) {
        if (_0x98a1xe) {
          _0x98a1x3c[_0xff0d[11]][_0xff0d[106]] =
            this[_0xff0d[107]] - 50 + _0xff0d[12];
          _0x98a1x3c[_0xff0d[11]][_0xff0d[108]] =
            this[_0xff0d[109]] - 150 + _0xff0d[12];
        } else {
          _0x98a1x3c[_0xff0d[11]][_0xff0d[106]] =
            this[_0xff0d[107]] - 60 + _0xff0d[12];
          _0x98a1x3c[_0xff0d[11]][_0xff0d[108]] =
            this[_0xff0d[109]] - 120 + _0xff0d[12];
        }
        _0x98a1x3c[_0xff0d[11]][_0xff0d[67]] = _0xff0d[100];
      } else {
        _0x98a1x3c[_0xff0d[11]][_0xff0d[67]] = _0xff0d[68];
      }
    });
    _0x98a1x42[_0xff0d[84]](_0xff0d[104], function (_0x98a1x54) {
      _0x98a1x56();
    });
    _0x98a1x3a[_0xff0d[84]](_0xff0d[110], function () {
      if (
        _0x98a1x13 &&
        !isNaN(_0x98a1x3a[_0xff0d[111]]) &&
        _0x98a1x3a[_0xff0d[111]] > _0x98a1x1b
      ) {
        _0x98a1x1b = _0x98a1x3a[_0xff0d[111]];
        _0x98a1x1f = true;
        if (_0x98a1x17 > 0 && !_0x98a1x18) {
          _0x98a1x41[_0xff0d[66]] = _0x98a1x1b - _0x98a1x15 / 1000;
          if (_0x98a1x3a[_0xff0d[105]] > _0x98a1x15 / 1000) {
            _0x98a1x41[_0xff0d[64]] =
              _0x98a1x3a[_0xff0d[105]] - _0x98a1x15 / 1000;
          }
        }
        _0x98a1x3d[_0xff0d[27]] =
          _0x98a1x4c(Math[_0xff0d[57]](_0x98a1x3a[_0xff0d[105]])) +
          _0xff0d[112] +
          _0x98a1x4c(Math[_0xff0d[57]](_0x98a1x1b));
      }
    });
    _0x98a1x41[_0xff0d[84]](_0xff0d[113], function (_0x98a1x54) {
      _0x98a1x18 = false;
      if (_0x98a1x17 > 0) {
        var _0x98a1x59 =
          (_0x98a1x54[_0xff0d[114]] -
            (this[_0xff0d[107]] + this[_0xff0d[115]][_0xff0d[107]])) /
          this[_0xff0d[116]];
        if (_0x98a1x59 < 0) {
          _0x98a1x59 = 0;
        }
        var _0x98a1x5a = _0x98a1x23 ? 0.1 : 1;
        if (_0x98a1x59 > 0.98) {
          _0x98a1x3a[_0xff0d[105]] = _0x98a1x3a[_0xff0d[111]] - _0x98a1x5a;
        } else {
          _0x98a1x3a[_0xff0d[105]] =
            _0x98a1x15 / 1000 +
            _0x98a1x59 * (_0x98a1x3a[_0xff0d[111]] - _0x98a1x15 / 1000);
        }
      }
    });
    _0x98a1x41[_0xff0d[84]](_0xff0d[117], function (_0x98a1x54) {
      _0x98a1x18 = true;
    });
    var _0x98a1x5b;
    _0x98a1x41[_0xff0d[84]](_0xff0d[102], function (_0x98a1x54) {
      if (
        !isNaN(_0x98a1x3a[_0xff0d[111]]) &&
        !_0x98a1x41[_0xff0d[65]] &&
        this[_0xff0d[115]] != null
      ) {
        _0x98a1x43[_0xff0d[11]][_0xff0d[106]] =
          _0x98a1x54[_0xff0d[114]] - 15 + _0xff0d[12];
        _0x98a1x43[_0xff0d[11]][_0xff0d[108]] =
          this[_0xff0d[109]] +
          this[_0xff0d[115]][_0xff0d[109]] -
          25 +
          _0xff0d[12];
        _0x98a1x43[_0xff0d[11]][_0xff0d[67]] = _0xff0d[100];
        var _0x98a1x59 =
          (_0x98a1x54[_0xff0d[114]] -
            (this[_0xff0d[107]] + this[_0xff0d[115]][_0xff0d[107]])) /
          this[_0xff0d[116]];
        if (_0x98a1x59 < 0) {
          _0x98a1x59 = 0;
        }
        var _0x98a1x5c =
          _0x98a1x15 / 1000 +
          _0x98a1x59 * (_0x98a1x3a[_0xff0d[111]] - _0x98a1x15 / 1000);
        _0x98a1x43[_0xff0d[27]] = _0x98a1x4c(Math[_0xff0d[57]](_0x98a1x5c));
        clearTimeout(_0x98a1x5b);
        _0x98a1x5b = setTimeout(function () {
          _0x98a1x43[_0xff0d[11]][_0xff0d[67]] = _0xff0d[68];
        }, 1000);
      }
    });
    _0x98a1x41[_0xff0d[84]](_0xff0d[101], function () {
      _0x98a1x43[_0xff0d[11]][_0xff0d[67]] = _0xff0d[68];
    });
    _0x98a1x3c[_0xff0d[84]](_0xff0d[118], function (_0x98a1x54) {
      _0x98a1x3a[_0xff0d[81]] = this[_0xff0d[64]];
    });
    _0x98a1x3c[_0xff0d[84]](_0xff0d[101], function () {
      _0x98a1x3c[_0xff0d[11]][_0xff0d[67]] = _0xff0d[68];
    });
  }
  function _0x98a1x5d() {
    _0x98a1x3b[_0xff0d[11]][_0xff0d[13]] = _0xff0d[119];
    _0x98a1x41[_0xff0d[11]][_0xff0d[10]] =
      _0x98a1x3a[_0xff0d[10]] - 410 + _0xff0d[12];
    _0x98a1x3e[_0xff0d[11]][_0xff0d[10]] = _0xff0d[120];
    _0x98a1x3e[_0xff0d[11]][_0xff0d[121]] = _0xff0d[122];
    _0x98a1x3f[_0xff0d[11]][_0xff0d[10]] = _0xff0d[120];
    _0x98a1x3f[_0xff0d[11]][_0xff0d[121]] = _0xff0d[122];
    _0x98a1x40[_0xff0d[11]][_0xff0d[10]] = _0xff0d[120];
    _0x98a1x40[_0xff0d[11]][_0xff0d[121]] = _0xff0d[122];
    _0x98a1x42[_0xff0d[11]][_0xff0d[10]] = _0xff0d[120];
    _0x98a1x42[_0xff0d[11]][_0xff0d[121]] = _0xff0d[122];
    _0x98a1x41[_0xff0d[11]][_0xff0d[123]] = _0xff0d[124];
    _0x98a1x3d[_0xff0d[11]][_0xff0d[123]] = _0xff0d[125];
  }
  function _0x98a1x5e(_0x98a1x54) {
    _0x98a1x10[_0xff0d[111]] = 0;
    _0x98a1x3f[_0xff0d[65]] = false;
    _0x98a1x69();
  }
  function _0x98a1x5f(_0x98a1x60, _0x98a1x61) {
    if (_0x98a1x61) {
      _0x98a1x44[_0xff0d[11]][_0xff0d[108]] =
        -1 * _0x98a1x3a[_0xff0d[13]] + 20 + _0xff0d[12];
    } else {
      if (_0x98a1xe) {
        _0x98a1x44[_0xff0d[11]][_0xff0d[108]] = _0xff0d[126];
      } else {
        _0x98a1x44[_0xff0d[11]][_0xff0d[108]] = _0xff0d[127];
      }
    }
    _0x98a1x44[_0xff0d[11]][_0xff0d[106]] =
      _0x98a1x3a[_0xff0d[116]] - _0x98a1x3a[_0xff0d[10]] + 5 + _0xff0d[12];
    _0x98a1x44[_0xff0d[27]] = _0x98a1x60;
    _0x98a1x44[_0xff0d[11]][_0xff0d[67]] = _0xff0d[100];
  }
  function _0x98a1x62() {
    _0x98a1x16[_0xff0d[76]] = 0;
    _0x98a1x19 = false;
    _0x98a1x3e[_0xff0d[65]] = true;
    _0x98a1x3f[_0xff0d[65]] = true;
    if (_0x98a1x17 > 0) {
      _0x98a1x41[_0xff0d[65]] = false;
    }
    _0x98a1x10 = new window.MediaSource();
    _0x98a1x3a[_0xff0d[77]] = window[_0xff0d[129]][_0xff0d[128]](_0x98a1x10);
    _0x98a1x10[_0xff0d[84]](_0xff0d[130], _0x98a1x5e, false);
    if (_0x98a1x1c) {
      _0x98a1x3a[_0xff0d[71]]();
    }
    _0x98a1x5f(_0xff0d[131], false);
  }
  function _0x98a1x63(_0x98a1x54) {
    if (_0x98a1x12 != null && !_0x98a1x12[_0xff0d[132]]) {
      if (_0x98a1x16[_0xff0d[76]] > 0) {
        _0x98a1x12[_0xff0d[134]](_0x98a1x16[_0xff0d[133]]());
      } else {
        var _0x98a1x64 = _0x98a1x14 - _0x98a1x15 - _0x98a1x17 * 1000;
        if (_0x98a1x64 >= 1000) {
          _0x98a1x15 = _0x98a1x15 + _0x98a1x64;
        }
        var _0x98a1x65 = _0x98a1x14 - _0x98a1x20 - _0x98a1x17 * 1000;
        if (_0x98a1x65 >= 10000 && _0x98a1x15 / 1000 >= 30) {
          _0x98a1x12[_0xff0d[135]](
            Math[_0xff0d[66]](0, _0x98a1x15 / 1000 - 35),
            _0x98a1x15 / 1000 - 20
          );
          _0x98a1x20 = _0x98a1x20 + _0x98a1x65;
        }
      }
    }
  }
  function _0x98a1x66() {
    if (_0x98a1x8[_0xff0d[2]] === Array) {
      var _0x98a1x67 = _0x98a1x27 / _0x98a1x28;
      var _0x98a1x68 = false;
      if (_0x98a1x67 > 0.05) {
        if (_0x98a1x29 + 1 < _0x98a1x8[_0xff0d[76]]) {
          _0x98a1x29++;
          _0x98a1x68 = true;
          _0x98a1x2c = false;
        }
      } else {
        if (_0x98a1x29 - 1 >= 0) {
          if (_0x98a1x2c) {
            _0x98a1x2a = 0;
            _0x98a1x2b = 0;
          }
          if (_0x98a1x2b == 0) {
            _0x98a1x29--;
            _0x98a1x68 = true;
            _0x98a1x2c = true;
            _0x98a1x2a++;
            _0x98a1x2b = _0x98a1x2a;
          } else {
            _0x98a1x2b--;
          }
        }
      }
      if (_0x98a1x68) {
        _0x98a1x2a++;
        _0x98a1x11[_0xff0d[137]](_0xff0d[136] + _0x98a1x8[_0x98a1x29]);
      }
      _0x98a1x27 = 0;
      _0x98a1x28 = 1;
    }
  }
  function _0x98a1x69() {
    _0x98a1x11 = new WebSocket(_0x98a1x2d);
    _0x98a1x11[_0xff0d[138]] = _0xff0d[139];
    _0x98a1x11[_0xff0d[59]] = function (_0x98a1x6a) {
      var _0x98a1x6b = new Uint8Array(_0x98a1x6a[_0xff0d[140]]);
      var _0x98a1x6c;
      if (_0x98a1x6b[0] == 0) {
        var _0x98a1x61 = new Uint16Array(
          _0x98a1x6a[_0xff0d[140]],
          2,
          (_0x98a1x6a[_0xff0d[140]][_0xff0d[141]] - 2) / 2
        );
        var _0x98a1x6d = String[_0xff0d[143]][_0xff0d[142]](null, _0x98a1x61);
        _0x98a1x5f(_0xff0d[144] + _0x98a1x6d, true);
        _0x98a1x51();
        return;
      }
      if (_0x98a1x6b[0] == 1) {
        if (!_0x98a1x1d) {
          _0x98a1x1e = 1000;
        }
        _0x98a1x23 =
          _0x98a1x6b[1] == 4 || _0x98a1x6b[1] == 8 || _0x98a1x6b[1] == 12;
        var _0x98a1x6e = new Uint16Array(_0x98a1x6a[_0xff0d[140]], 18, 1);
        var _0x98a1x6f = _0x98a1x6e[0];
        if (!_0x98a1x13) {
          _0x98a1x13 = true;
          var _0x98a1x70 = new Uint16Array(
            _0x98a1x6a[_0xff0d[140]],
            20,
            _0x98a1x6f / 2
          );
          var _0x98a1x71 = String[_0xff0d[143]][_0xff0d[142]](null, _0x98a1x70);
          var _0x98a1x72 = new DOMParser();
          var _0x98a1x73 = _0x98a1x72[_0xff0d[146]](_0x98a1x71, _0xff0d[145]);
          _0x98a1xf = _0x98a1x73[_0xff0d[150]](_0xff0d[149])[0][
            _0xff0d[148]
          ][0][_0xff0d[147]];
          _0x98a1x12 = _0x98a1x10[_0xff0d[151]](_0x98a1xf);
          _0x98a1x12[_0xff0d[84]](_0xff0d[152], _0x98a1x63, false);
        }
        _0x98a1x6c = new Uint8Array(
          _0x98a1x6a[_0xff0d[140]],
          20 + _0x98a1x6f,
          _0x98a1x6a[_0xff0d[140]][_0xff0d[141]] - 20 - _0x98a1x6f
        );
      } else {
        if (_0x98a1x6b[0] == 2) {
          if (_0x98a1x6b[1] == 1) {
            _0x98a1x27++;
          } else {
            _0x98a1x28++;
          }
          _0x98a1x14 = new DataView(_0x98a1x6a[_0xff0d[140]])[_0xff0d[153]](
            6,
            true
          );
          _0x98a1x6c = new Uint8Array(
            _0x98a1x6a[_0xff0d[140]],
            10,
            _0x98a1x6a[_0xff0d[140]][_0xff0d[141]] - 10
          );
        }
      }
      if (_0x98a1x3a[_0xff0d[154]] != null) {
        _0x98a1x5f(_0xff0d[155], true);
        _0x98a1x51();
        return;
      }
      if (_0x98a1x25 && _0x98a1x22 && _0x98a1x1f && !_0x98a1x23) {
        if (
          _0x98a1x3a[_0xff0d[111]] - _0x98a1x3a[_0xff0d[105]] < 0.5 &&
          !_0x98a1x24
        ) {
          _0x98a1x3e[_0xff0d[65]] = true;
          _0x98a1x24 = true;
          _0x98a1x5f(_0xff0d[103], false);
          _0x98a1x3a[_0xff0d[63]]();
        } else {
          if (
            _0x98a1x3a[_0xff0d[111]] - _0x98a1x3a[_0xff0d[105]] >= 5 &&
            _0x98a1x24
          ) {
            _0x98a1x3e[_0xff0d[65]] = false;
            _0x98a1x24 = false;
            _0x98a1x44[_0xff0d[11]][_0xff0d[67]] = _0xff0d[68];
            _0x98a1x3a[_0xff0d[71]]();
          }
        }
      }
      if (_0x98a1x12 != null) {
        if (_0x98a1x12[_0xff0d[132]] || _0x98a1x16[_0xff0d[76]] > 0) {
          _0x98a1x16[_0xff0d[156]](_0x98a1x6c);
        } else {
          _0x98a1x12[_0xff0d[134]](_0x98a1x6c);
        }
      }
      var _0x98a1x74 = _0x98a1x23 ? 0 : 2000;
      if (
        _0x98a1x14 > _0x98a1x1e &&
        _0x98a1x14 > _0x98a1x74 &&
        _0x98a1x13 &&
        _0x98a1x44[_0xff0d[11]][_0xff0d[67]] != _0xff0d[68] &&
        !_0x98a1x22
      ) {
        _0x98a1x44[_0xff0d[11]][_0xff0d[67]] = _0xff0d[68];
        _0x98a1x3e[_0xff0d[65]] = false;
        _0x98a1x22 = true;
        _0x98a1x3a[_0xff0d[71]]();
        if (_0x98a1x8[_0xff0d[2]] === Array && _0x98a1x26 == null) {
          _0x98a1x26 = setInterval(_0x98a1x66, 10000);
        }
      }
    };
    _0x98a1x11[_0xff0d[60]] = function () {
      _0x98a1x51();
    };
    _0x98a1x11[_0xff0d[61]] = function () {
      if (!_0x98a1x19) {
        _0x98a1x5f(_0xff0d[157], true);
        _0x98a1x51();
      }
    };
  }
}

/*
 AngularJS v1.7.5
 (c) 2010-2018 Google, Inc. http://angularjs.org
 License: MIT
*/
(function (B) {
  "use strict";
  function oe(a) {
    if (F(a))
      v(a.objectMaxDepth) &&
        (Vb.objectMaxDepth = Wb(a.objectMaxDepth) ? a.objectMaxDepth : NaN),
        v(a.urlErrorParamsEnabled) &&
          Fa(a.urlErrorParamsEnabled) &&
          (Vb.urlErrorParamsEnabled = a.urlErrorParamsEnabled);
    else return Vb;
  }
  function Wb(a) {
    return ba(a) && 0 < a;
  }
  function M(a, b) {
    b = b || Error;
    return function () {
      var d = arguments[0],
        c;
      c =
        "[" +
        (a ? a + ":" : "") +
        d +
        "] http://errors.angularjs.org/1.7.5/" +
        (a ? a + "/" : "") +
        d;
      for (d = 1; d < arguments.length; d++) {
        c = c + (1 == d ? "?" : "&") + "p" + (d - 1) + "=";
        var e = encodeURIComponent,
          f;
        f = arguments[d];
        f =
          "function" == typeof f
            ? f.toString().replace(/ \{[\s\S]*$/, "")
            : "undefined" == typeof f
            ? "undefined"
            : "string" != typeof f
            ? JSON.stringify(f)
            : f;
        c += e(f);
      }
      return new b(c);
    };
  }
  function xa(a) {
    if (null == a || $a(a)) return !1;
    if (I(a) || C(a) || (y && a instanceof y)) return !0;
    var b = "length" in Object(a) && a.length;
    return ba(b) && ((0 <= b && b - 1 in a) || "function" === typeof a.item);
  }
  function r(a, b, d) {
    var c, e;
    if (a)
      if (z(a))
        for (c in a)
          "prototype" !== c &&
            "length" !== c &&
            "name" !== c &&
            a.hasOwnProperty(c) &&
            b.call(d, a[c], c, a);
      else if (I(a) || xa(a)) {
        var f = "object" !== typeof a;
        c = 0;
        for (e = a.length; c < e; c++) (f || c in a) && b.call(d, a[c], c, a);
      } else if (a.forEach && a.forEach !== r) a.forEach(b, d, a);
      else if (Mc(a)) for (c in a) b.call(d, a[c], c, a);
      else if ("function" === typeof a.hasOwnProperty)
        for (c in a) a.hasOwnProperty(c) && b.call(d, a[c], c, a);
      else for (c in a) sa.call(a, c) && b.call(d, a[c], c, a);
    return a;
  }
  function Nc(a, b, d) {
    for (var c = Object.keys(a).sort(), e = 0; e < c.length; e++)
      b.call(d, a[c[e]], c[e]);
    return c;
  }
  function Xb(a) {
    return function (b, d) {
      a(d, b);
    };
  }
  function pe() {
    return ++pb;
  }
  function Yb(a, b, d) {
    for (var c = a.$$hashKey, e = 0, f = b.length; e < f; ++e) {
      var g = b[e];
      if (F(g) || z(g))
        for (var k = Object.keys(g), h = 0, l = k.length; h < l; h++) {
          var m = k[h],
            q = g[m];
          d && F(q)
            ? ha(q)
              ? (a[m] = new Date(q.valueOf()))
              : ab(q)
              ? (a[m] = new RegExp(q))
              : q.nodeName
              ? (a[m] = q.cloneNode(!0))
              : Zb(q)
              ? (a[m] = q.clone())
              : (F(a[m]) || (a[m] = I(q) ? [] : {}), Yb(a[m], [q], !0))
            : (a[m] = q);
        }
    }
    c ? (a.$$hashKey = c) : delete a.$$hashKey;
    return a;
  }
  function R(a) {
    return Yb(a, Ga.call(arguments, 1), !1);
  }
  function qe(a) {
    return Yb(a, Ga.call(arguments, 1), !0);
  }
  function da(a) {
    return parseInt(a, 10);
  }
  function $b(a, b) {
    return R(Object.create(a), b);
  }
  function A() {}
  function Ta(a) {
    return a;
  }
  function ia(a) {
    return function () {
      return a;
    };
  }
  function ac(a) {
    return z(a.toString) && a.toString !== ma;
  }
  function x(a) {
    return "undefined" === typeof a;
  }
  function v(a) {
    return "undefined" !== typeof a;
  }
  function F(a) {
    return null !== a && "object" === typeof a;
  }
  function Mc(a) {
    return null !== a && "object" === typeof a && !Oc(a);
  }
  function C(a) {
    return "string" === typeof a;
  }
  function ba(a) {
    return "number" === typeof a;
  }
  function ha(a) {
    return "[object Date]" === ma.call(a);
  }
  function I(a) {
    return Array.isArray(a) || a instanceof Array;
  }
  function bc(a) {
    switch (ma.call(a)) {
      case "[object Error]":
        return !0;
      case "[object Exception]":
        return !0;
      case "[object DOMException]":
        return !0;
      default:
        return a instanceof Error;
    }
  }
  function z(a) {
    return "function" === typeof a;
  }
  function ab(a) {
    return "[object RegExp]" === ma.call(a);
  }
  function $a(a) {
    return a && a.window === a;
  }
  function bb(a) {
    return a && a.$evalAsync && a.$watch;
  }
  function Fa(a) {
    return "boolean" === typeof a;
  }
  function re(a) {
    return a && ba(a.length) && se.test(ma.call(a));
  }
  function Zb(a) {
    return !(!a || !(a.nodeName || (a.prop && a.attr && a.find)));
  }
  function te(a) {
    var b = {};
    a = a.split(",");
    var d;
    for (d = 0; d < a.length; d++) b[a[d]] = !0;
    return b;
  }
  function ta(a) {
    return O(a.nodeName || (a[0] && a[0].nodeName));
  }
  function cb(a, b) {
    var d = a.indexOf(b);
    0 <= d && a.splice(d, 1);
    return d;
  }
  function Ha(a, b, d) {
    function c(a, b, c) {
      c--;
      if (0 > c) return "...";
      var d = b.$$hashKey,
        f;
      if (I(a)) {
        f = 0;
        for (var g = a.length; f < g; f++) b.push(e(a[f], c));
      } else if (Mc(a)) for (f in a) b[f] = e(a[f], c);
      else if (a && "function" === typeof a.hasOwnProperty)
        for (f in a) a.hasOwnProperty(f) && (b[f] = e(a[f], c));
      else for (f in a) sa.call(a, f) && (b[f] = e(a[f], c));
      d ? (b.$$hashKey = d) : delete b.$$hashKey;
      return b;
    }
    function e(a, b) {
      if (!F(a)) return a;
      var d = g.indexOf(a);
      if (-1 !== d) return k[d];
      if ($a(a) || bb(a)) throw Ia("cpws");
      var d = !1,
        e = f(a);
      void 0 === e && ((e = I(a) ? [] : Object.create(Oc(a))), (d = !0));
      g.push(a);
      k.push(e);
      return d ? c(a, e, b) : e;
    }
    function f(a) {
      switch (ma.call(a)) {
        case "[object Int8Array]":
        case "[object Int16Array]":
        case "[object Int32Array]":
        case "[object Float32Array]":
        case "[object Float64Array]":
        case "[object Uint8Array]":
        case "[object Uint8ClampedArray]":
        case "[object Uint16Array]":
        case "[object Uint32Array]":
          return new a.constructor(e(a.buffer), a.byteOffset, a.length);
        case "[object ArrayBuffer]":
          if (!a.slice) {
            var b = new ArrayBuffer(a.byteLength);
            new Uint8Array(b).set(new Uint8Array(a));
            return b;
          }
          return a.slice(0);
        case "[object Boolean]":
        case "[object Number]":
        case "[object String]":
        case "[object Date]":
          return new a.constructor(a.valueOf());
        case "[object RegExp]":
          return (
            (b = new RegExp(a.source, a.toString().match(/[^/]*$/)[0])),
            (b.lastIndex = a.lastIndex),
            b
          );
        case "[object Blob]":
          return new a.constructor([a], { type: a.type });
      }
      if (z(a.cloneNode)) return a.cloneNode(!0);
    }
    var g = [],
      k = [];
    d = Wb(d) ? d : NaN;
    if (b) {
      if (re(b) || "[object ArrayBuffer]" === ma.call(b)) throw Ia("cpta");
      if (a === b) throw Ia("cpi");
      I(b)
        ? (b.length = 0)
        : r(b, function (a, c) {
            "$$hashKey" !== c && delete b[c];
          });
      g.push(a);
      k.push(b);
      return c(a, b, d);
    }
    return e(a, d);
  }
  function cc(a, b) {
    return a === b || (a !== a && b !== b);
  }
  function ua(a, b) {
    if (a === b) return !0;
    if (null === a || null === b) return !1;
    if (a !== a && b !== b) return !0;
    var d = typeof a,
      c;
    if (d === typeof b && "object" === d)
      if (I(a)) {
        if (!I(b)) return !1;
        if ((d = a.length) === b.length) {
          for (c = 0; c < d; c++) if (!ua(a[c], b[c])) return !1;
          return !0;
        }
      } else {
        if (ha(a)) return ha(b) ? cc(a.getTime(), b.getTime()) : !1;
        if (ab(a)) return ab(b) ? a.toString() === b.toString() : !1;
        if (bb(a) || bb(b) || $a(a) || $a(b) || I(b) || ha(b) || ab(b))
          return !1;
        d = S();
        for (c in a)
          if ("$" !== c.charAt(0) && !z(a[c])) {
            if (!ua(a[c], b[c])) return !1;
            d[c] = !0;
          }
        for (c in b)
          if (!(c in d) && "$" !== c.charAt(0) && v(b[c]) && !z(b[c]))
            return !1;
        return !0;
      }
    return !1;
  }
  function db(a, b, d) {
    return a.concat(Ga.call(b, d));
  }
  function Va(a, b) {
    var d = 2 < arguments.length ? Ga.call(arguments, 2) : [];
    return !z(b) || b instanceof RegExp
      ? b
      : d.length
      ? function () {
          return arguments.length
            ? b.apply(a, db(d, arguments, 0))
            : b.apply(a, d);
        }
      : function () {
          return arguments.length ? b.apply(a, arguments) : b.call(a);
        };
  }
  function Pc(a, b) {
    var d = b;
    "string" === typeof a && "$" === a.charAt(0) && "$" === a.charAt(1)
      ? (d = void 0)
      : $a(b)
      ? (d = "$WINDOW")
      : b && B.document === b
      ? (d = "$DOCUMENT")
      : bb(b) && (d = "$SCOPE");
    return d;
  }
  function eb(a, b) {
    if (!x(a)) return ba(b) || (b = b ? 2 : null), JSON.stringify(a, Pc, b);
  }
  function Qc(a) {
    return C(a) ? JSON.parse(a) : a;
  }
  function dc(a, b) {
    a = a.replace(ue, "");
    var d = Date.parse("Jan 01, 1970 00:00:00 " + a) / 6e4;
    return V(d) ? b : d;
  }
  function Rc(a, b) {
    a = new Date(a.getTime());
    a.setMinutes(a.getMinutes() + b);
    return a;
  }
  function ec(a, b, d) {
    d = d ? -1 : 1;
    var c = a.getTimezoneOffset();
    b = dc(b, c);
    return Rc(a, d * (b - c));
  }
  function ya(a) {
    a = y(a).clone().empty();
    var b = y("<div></div>").append(a).html();
    try {
      return a[0].nodeType === Oa
        ? O(b)
        : b.match(/^(<[^>]+>)/)[1].replace(/^<([\w-]+)/, function (a, b) {
            return "<" + O(b);
          });
    } catch (d) {
      return O(b);
    }
  }
  function Sc(a) {
    try {
      return decodeURIComponent(a);
    } catch (b) {}
  }
  function fc(a) {
    var b = {};
    r((a || "").split("&"), function (a) {
      var c, e, f;
      a &&
        ((e = a = a.replace(/\+/g, "%20")),
        (c = a.indexOf("=")),
        -1 !== c && ((e = a.substring(0, c)), (f = a.substring(c + 1))),
        (e = Sc(e)),
        v(e) &&
          ((f = v(f) ? Sc(f) : !0),
          sa.call(b, e)
            ? I(b[e])
              ? b[e].push(f)
              : (b[e] = [b[e], f])
            : (b[e] = f)));
    });
    return b;
  }
  function ve(a) {
    var b = [];
    r(a, function (a, c) {
      I(a)
        ? r(a, function (a) {
            b.push(ca(c, !0) + (!0 === a ? "" : "=" + ca(a, !0)));
          })
        : b.push(ca(c, !0) + (!0 === a ? "" : "=" + ca(a, !0)));
    });
    return b.length ? b.join("&") : "";
  }
  function gc(a) {
    return ca(a, !0)
      .replace(/%26/gi, "&")
      .replace(/%3D/gi, "=")
      .replace(/%2B/gi, "+");
  }
  function ca(a, b) {
    return encodeURIComponent(a)
      .replace(/%40/gi, "@")
      .replace(/%3A/gi, ":")
      .replace(/%24/g, "$")
      .replace(/%2C/gi, ",")
      .replace(/%3B/gi, ";")
      .replace(/%20/g, b ? "%20" : "+");
  }
  function we(a, b) {
    var d,
      c,
      e = Pa.length;
    for (c = 0; c < e; ++c)
      if (((d = Pa[c] + b), C((d = a.getAttribute(d))))) return d;
    return null;
  }
  function xe(a, b) {
    var d,
      c,
      e = {};
    r(Pa, function (b) {
      b += "app";
      !d &&
        a.hasAttribute &&
        a.hasAttribute(b) &&
        ((d = a), (c = a.getAttribute(b)));
    });
    r(Pa, function (b) {
      b += "app";
      var e;
      !d &&
        (e = a.querySelector("[" + b.replace(":", "\\:") + "]")) &&
        ((d = e), (c = e.getAttribute(b)));
    });
    if (d)
      if (ye) (e.strictDi = null !== we(d, "strict-di")), b(d, c ? [c] : [], e);
      else
        try {
          B.console.error(
            "AngularJS: disabling automatic bootstrap. <script> protocol indicates an extension, document.location.href does not match."
          );
        } catch (f) {}
  }
  function Tc(a, b, d) {
    F(d) || (d = {});
    d = R({ strictDi: !1 }, d);
    var c = function () {
        a = y(a);
        if (a.injector()) {
          var c = a[0] === B.document ? "document" : ya(a);
          throw Ia("btstrpd", c.replace(/</, "&lt;").replace(/>/, "&gt;"));
        }
        b = b || [];
        b.unshift([
          "$provide",
          function (b) {
            b.value("$rootElement", a);
          },
        ]);
        d.debugInfoEnabled &&
          b.push([
            "$compileProvider",
            function (a) {
              a.debugInfoEnabled(!0);
            },
          ]);
        b.unshift("ng");
        c = fb(b, d.strictDi);
        c.invoke([
          "$rootScope",
          "$rootElement",
          "$compile",
          "$injector",
          function (a, b, c, d) {
            a.$apply(function () {
              b.data("$injector", d);
              c(b)(a);
            });
          },
        ]);
        return c;
      },
      e = /^NG_ENABLE_DEBUG_INFO!/,
      f = /^NG_DEFER_BOOTSTRAP!/;
    B &&
      e.test(B.name) &&
      ((d.debugInfoEnabled = !0), (B.name = B.name.replace(e, "")));
    if (B && !f.test(B.name)) return c();
    B.name = B.name.replace(f, "");
    ea.resumeBootstrap = function (a) {
      r(a, function (a) {
        b.push(a);
      });
      return c();
    };
    z(ea.resumeDeferredBootstrap) && ea.resumeDeferredBootstrap();
  }
  function ze() {
    B.name = "NG_ENABLE_DEBUG_INFO!" + B.name;
    B.location.reload();
  }
  function Ae(a) {
    a = ea.element(a).injector();
    if (!a) throw Ia("test");
    return a.get("$$testability");
  }
  function Uc(a, b) {
    b = b || "_";
    return a.replace(Be, function (a, c) {
      return (c ? b : "") + a.toLowerCase();
    });
  }
  function Ce() {
    var a;
    if (!Vc) {
      var b = qb();
      (rb = x(b) ? B.jQuery : b ? B[b] : void 0) && rb.fn.on
        ? ((y = rb),
          R(rb.fn, {
            scope: Wa.scope,
            isolateScope: Wa.isolateScope,
            controller: Wa.controller,
            injector: Wa.injector,
            inheritedData: Wa.inheritedData,
          }))
        : (y = W);
      a = y.cleanData;
      y.cleanData = function (b) {
        for (var c, e = 0, f; null != (f = b[e]); e++)
          (c = (y._data(f) || {}).events) &&
            c.$destroy &&
            y(f).triggerHandler("$destroy");
        a(b);
      };
      ea.element = y;
      Vc = !0;
    }
  }
  function gb(a, b, d) {
    if (!a) throw Ia("areq", b || "?", d || "required");
    return a;
  }
  function sb(a, b, d) {
    d && I(a) && (a = a[a.length - 1]);
    gb(
      z(a),
      b,
      "not a function, got " +
        (a && "object" === typeof a ? a.constructor.name || "Object" : typeof a)
    );
    return a;
  }
  function Qa(a, b) {
    if ("hasOwnProperty" === a) throw Ia("badname", b);
  }
  function De(a, b, d) {
    if (!b) return a;
    b = b.split(".");
    for (var c, e = a, f = b.length, g = 0; g < f; g++)
      (c = b[g]), a && (a = (e = a)[c]);
    return !d && z(a) ? Va(e, a) : a;
  }
  function tb(a) {
    for (
      var b = a[0], d = a[a.length - 1], c, e = 1;
      b !== d && (b = b.nextSibling);
      e++
    )
      if (c || a[e] !== b) c || (c = y(Ga.call(a, 0, e))), c.push(b);
    return c || a;
  }
  function S() {
    return Object.create(null);
  }
  function hc(a) {
    if (null == a) return "";
    switch (typeof a) {
      case "string":
        break;
      case "number":
        a = "" + a;
        break;
      default:
        a = !ac(a) || I(a) || ha(a) ? eb(a) : a.toString();
    }
    return a;
  }
  function Ee(a) {
    function b(a, b, c) {
      return a[b] || (a[b] = c());
    }
    var d = M("$injector"),
      c = M("ng");
    a = b(a, "angular", Object);
    a.$$minErr = a.$$minErr || M;
    return b(a, "module", function () {
      var a = {};
      return function (f, g, k) {
        var h = {};
        if ("hasOwnProperty" === f) throw c("badname", "module");
        g && a.hasOwnProperty(f) && (a[f] = null);
        return b(a, f, function () {
          function a(b, c, d, f) {
            f || (f = e);
            return function () {
              f[d || "push"]([b, c, arguments]);
              return u;
            };
          }
          function b(a, c, d) {
            d || (d = e);
            return function (b, e) {
              e && z(e) && (e.$$moduleName = f);
              d.push([a, c, arguments]);
              return u;
            };
          }
          if (!g) throw d("nomod", f);
          var e = [],
            n = [],
            s = [],
            t = a("$injector", "invoke", "push", n),
            u = {
              _invokeQueue: e,
              _configBlocks: n,
              _runBlocks: s,
              info: function (a) {
                if (v(a)) {
                  if (!F(a)) throw c("aobj", "value");
                  h = a;
                  return this;
                }
                return h;
              },
              requires: g,
              name: f,
              provider: b("$provide", "provider"),
              factory: b("$provide", "factory"),
              service: b("$provide", "service"),
              value: a("$provide", "value"),
              constant: a("$provide", "constant", "unshift"),
              decorator: b("$provide", "decorator", n),
              animation: b("$animateProvider", "register"),
              filter: b("$filterProvider", "register"),
              controller: b("$controllerProvider", "register"),
              directive: b("$compileProvider", "directive"),
              component: b("$compileProvider", "component"),
              config: t,
              run: function (a) {
                s.push(a);
                return this;
              },
            };
          k && t(k);
          return u;
        });
      };
    });
  }
  function oa(a, b) {
    if (I(a)) {
      b = b || [];
      for (var d = 0, c = a.length; d < c; d++) b[d] = a[d];
    } else if (F(a))
      for (d in ((b = b || {}), a))
        if ("$" !== d.charAt(0) || "$" !== d.charAt(1)) b[d] = a[d];
    return b || a;
  }
  function Fe(a, b) {
    var d = [];
    Wb(b) && (a = ea.copy(a, null, b));
    return JSON.stringify(a, function (a, b) {
      b = Pc(a, b);
      if (F(b)) {
        if (0 <= d.indexOf(b)) return "...";
        d.push(b);
      }
      return b;
    });
  }
  function Ge(a) {
    R(a, {
      errorHandlingConfig: oe,
      bootstrap: Tc,
      copy: Ha,
      extend: R,
      merge: qe,
      equals: ua,
      element: y,
      forEach: r,
      injector: fb,
      noop: A,
      bind: Va,
      toJson: eb,
      fromJson: Qc,
      identity: Ta,
      isUndefined: x,
      isDefined: v,
      isString: C,
      isFunction: z,
      isObject: F,
      isNumber: ba,
      isElement: Zb,
      isArray: I,
      version: He,
      isDate: ha,
      callbacks: { $$counter: 0 },
      getTestability: Ae,
      reloadWithDebugInfo: ze,
      $$minErr: M,
      $$csp: pa,
      $$encodeUriSegment: gc,
      $$encodeUriQuery: ca,
      $$lowercase: O,
      $$stringify: hc,
      $$uppercase: ub,
    });
    jc = Ee(B);
    jc(
      "ng",
      ["ngLocale"],
      [
        "$provide",
        function (a) {
          a.provider({ $$sanitizeUri: Ie });
          a.provider("$compile", Wc)
            .directive({
              a: Je,
              input: Xc,
              textarea: Xc,
              form: Ke,
              script: Le,
              select: Me,
              option: Ne,
              ngBind: Oe,
              ngBindHtml: Pe,
              ngBindTemplate: Qe,
              ngClass: Re,
              ngClassEven: Se,
              ngClassOdd: Te,
              ngCloak: Ue,
              ngController: Ve,
              ngForm: We,
              ngHide: Xe,
              ngIf: Ye,
              ngInclude: Ze,
              ngInit: $e,
              ngNonBindable: af,
              ngPluralize: bf,
              ngRef: cf,
              ngRepeat: df,
              ngShow: ef,
              ngStyle: ff,
              ngSwitch: gf,
              ngSwitchWhen: hf,
              ngSwitchDefault: jf,
              ngOptions: kf,
              ngTransclude: lf,
              ngModel: mf,
              ngList: nf,
              ngChange: of,
              pattern: Yc,
              ngPattern: Yc,
              required: Zc,
              ngRequired: Zc,
              minlength: $c,
              ngMinlength: $c,
              maxlength: ad,
              ngMaxlength: ad,
              ngValue: pf,
              ngModelOptions: qf,
            })
            .directive({ ngInclude: rf })
            .directive(vb)
            .directive(bd);
          a.provider({
            $anchorScroll: sf,
            $animate: tf,
            $animateCss: uf,
            $$animateJs: vf,
            $$animateQueue: wf,
            $$AnimateRunner: xf,
            $$animateAsyncRun: yf,
            $browser: zf,
            $cacheFactory: Af,
            $controller: Bf,
            $document: Cf,
            $$isDocumentHidden: Df,
            $exceptionHandler: Ef,
            $filter: cd,
            $$forceReflow: Ff,
            $interpolate: Gf,
            $interval: Hf,
            $$intervalFactory: If,
            $http: Jf,
            $httpParamSerializer: Kf,
            $httpParamSerializerJQLike: Lf,
            $httpBackend: Mf,
            $xhrFactory: Nf,
            $jsonpCallbacks: Of,
            $location: Pf,
            $log: Qf,
            $parse: Rf,
            $rootScope: Sf,
            $q: Tf,
            $$q: Uf,
            $sce: Vf,
            $sceDelegate: Wf,
            $sniffer: Xf,
            $$taskTrackerFactory: Yf,
            $templateCache: Zf,
            $templateRequest: $f,
            $$testability: ag,
            $timeout: bg,
            $window: cg,
            $$rAF: dg,
            $$jqLite: eg,
            $$Map: fg,
            $$cookieReader: gg,
          });
        },
      ]
    ).info({ angularVersion: "1.7.5" });
  }
  function wb(a, b) {
    return b.toUpperCase();
  }
  function xb(a) {
    return a.replace(hg, wb);
  }
  function kc(a) {
    a = a.nodeType;
    return 1 === a || !a || 9 === a;
  }
  function dd(a, b) {
    var d,
      c,
      e = b.createDocumentFragment(),
      f = [];
    if (lc.test(a)) {
      d = e.appendChild(b.createElement("div"));
      c = (ig.exec(a) || ["", ""])[1].toLowerCase();
      c = ja[c] || ja._default;
      d.innerHTML = c[1] + a.replace(jg, "<$1></$2>") + c[2];
      for (c = c[0]; c--; ) d = d.lastChild;
      f = db(f, d.childNodes);
      d = e.firstChild;
      d.textContent = "";
    } else f.push(b.createTextNode(a));
    e.textContent = "";
    e.innerHTML = "";
    r(f, function (a) {
      e.appendChild(a);
    });
    return e;
  }
  function W(a) {
    if (a instanceof W) return a;
    var b;
    C(a) && ((a = T(a)), (b = !0));
    if (!(this instanceof W)) {
      if (b && "<" !== a.charAt(0)) throw mc("nosel");
      return new W(a);
    }
    if (b) {
      b = B.document;
      var d;
      a = (d = kg.exec(a))
        ? [b.createElement(d[1])]
        : (d = dd(a, b))
        ? d.childNodes
        : [];
      nc(this, a);
    } else z(a) ? ed(a) : nc(this, a);
  }
  function oc(a) {
    return a.cloneNode(!0);
  }
  function yb(a, b) {
    !b && kc(a) && y.cleanData([a]);
    a.querySelectorAll && y.cleanData(a.querySelectorAll("*"));
  }
  function fd(a) {
    for (var b in a) return !1;
    return !0;
  }
  function gd(a) {
    var b = a.ng339,
      d = b && Ja[b],
      c = d && d.events,
      d = d && d.data;
    (d && !fd(d)) || (c && !fd(c)) || (delete Ja[b], (a.ng339 = void 0));
  }
  function hd(a, b, d, c) {
    if (v(c)) throw mc("offargs");
    var e = (c = zb(a)) && c.events,
      f = c && c.handle;
    if (f) {
      if (b) {
        var g = function (b) {
          var c = e[b];
          v(d) && cb(c || [], d);
          (v(d) && c && 0 < c.length) ||
            (a.removeEventListener(b, f), delete e[b]);
        };
        r(b.split(" "), function (a) {
          g(a);
          Ab[a] && g(Ab[a]);
        });
      } else
        for (b in e)
          "$destroy" !== b && a.removeEventListener(b, f), delete e[b];
      gd(a);
    }
  }
  function pc(a, b) {
    var d = a.ng339;
    if ((d = d && Ja[d])) b ? delete d.data[b] : (d.data = {}), gd(a);
  }
  function zb(a, b) {
    var d = a.ng339,
      d = d && Ja[d];
    b &&
      !d &&
      ((a.ng339 = d = ++lg),
      (d = Ja[d] = { events: {}, data: {}, handle: void 0 }));
    return d;
  }
  function qc(a, b, d) {
    if (kc(a)) {
      var c,
        e = v(d),
        f = !e && b && !F(b),
        g = !b;
      a = (a = zb(a, !f)) && a.data;
      if (e) a[xb(b)] = d;
      else {
        if (g) return a;
        if (f) return a && a[xb(b)];
        for (c in b) a[xb(c)] = b[c];
      }
    }
  }
  function Bb(a, b) {
    return a.getAttribute
      ? -1 <
          (" " + (a.getAttribute("class") || "") + " ")
            .replace(/[\n\t]/g, " ")
            .indexOf(" " + b + " ")
      : !1;
  }
  function Cb(a, b) {
    if (b && a.setAttribute) {
      var d = (" " + (a.getAttribute("class") || "") + " ").replace(
          /[\n\t]/g,
          " "
        ),
        c = d;
      r(b.split(" "), function (a) {
        a = T(a);
        c = c.replace(" " + a + " ", " ");
      });
      c !== d && a.setAttribute("class", T(c));
    }
  }
  function Db(a, b) {
    if (b && a.setAttribute) {
      var d = (" " + (a.getAttribute("class") || "") + " ").replace(
          /[\n\t]/g,
          " "
        ),
        c = d;
      r(b.split(" "), function (a) {
        a = T(a);
        -1 === c.indexOf(" " + a + " ") && (c += a + " ");
      });
      c !== d && a.setAttribute("class", T(c));
    }
  }
  function nc(a, b) {
    if (b)
      if (b.nodeType) a[a.length++] = b;
      else {
        var d = b.length;
        if ("number" === typeof d && b.window !== b) {
          if (d) for (var c = 0; c < d; c++) a[a.length++] = b[c];
        } else a[a.length++] = b;
      }
  }
  function id(a, b) {
    return Eb(a, "$" + (b || "ngController") + "Controller");
  }
  function Eb(a, b, d) {
    9 === a.nodeType && (a = a.documentElement);
    for (b = I(b) ? b : [b]; a; ) {
      for (var c = 0, e = b.length; c < e; c++)
        if (v((d = y.data(a, b[c])))) return d;
      a = a.parentNode || (11 === a.nodeType && a.host);
    }
  }
  function jd(a) {
    for (yb(a, !0); a.firstChild; ) a.removeChild(a.firstChild);
  }
  function Fb(a, b) {
    b || yb(a);
    var d = a.parentNode;
    d && d.removeChild(a);
  }
  function mg(a, b) {
    b = b || B;
    if ("complete" === b.document.readyState) b.setTimeout(a);
    else y(b).on("load", a);
  }
  function ed(a) {
    function b() {
      B.document.removeEventListener("DOMContentLoaded", b);
      B.removeEventListener("load", b);
      a();
    }
    "complete" === B.document.readyState
      ? B.setTimeout(a)
      : (B.document.addEventListener("DOMContentLoaded", b),
        B.addEventListener("load", b));
  }
  function kd(a, b) {
    var d = Gb[b.toLowerCase()];
    return d && ld[ta(a)] && d;
  }
  function ng(a, b) {
    var d = function (c, d) {
      c.isDefaultPrevented = function () {
        return c.defaultPrevented;
      };
      var f = b[d || c.type],
        g = f ? f.length : 0;
      if (g) {
        if (x(c.immediatePropagationStopped)) {
          var k = c.stopImmediatePropagation;
          c.stopImmediatePropagation = function () {
            c.immediatePropagationStopped = !0;
            c.stopPropagation && c.stopPropagation();
            k && k.call(c);
          };
        }
        c.isImmediatePropagationStopped = function () {
          return !0 === c.immediatePropagationStopped;
        };
        var h = f.specialHandlerWrapper || og;
        1 < g && (f = oa(f));
        for (var l = 0; l < g; l++)
          c.isImmediatePropagationStopped() || h(a, c, f[l]);
      }
    };
    d.elem = a;
    return d;
  }
  function og(a, b, d) {
    d.call(a, b);
  }
  function pg(a, b, d) {
    var c = b.relatedTarget;
    (c && (c === a || qg.call(a, c))) || d.call(a, b);
  }
  function eg() {
    this.$get = function () {
      return R(W, {
        hasClass: function (a, b) {
          a.attr && (a = a[0]);
          return Bb(a, b);
        },
        addClass: function (a, b) {
          a.attr && (a = a[0]);
          return Db(a, b);
        },
        removeClass: function (a, b) {
          a.attr && (a = a[0]);
          return Cb(a, b);
        },
      });
    };
  }
  function Ka(a, b) {
    var d = a && a.$$hashKey;
    if (d) return "function" === typeof d && (d = a.$$hashKey()), d;
    d = typeof a;
    return (d =
      "function" === d || ("object" === d && null !== a)
        ? (a.$$hashKey = d + ":" + (b || pe)())
        : d + ":" + a);
  }
  function md() {
    this._keys = [];
    this._values = [];
    this._lastKey = NaN;
    this._lastIndex = -1;
  }
  function nd(a) {
    a = Function.prototype.toString.call(a).replace(rg, "");
    return a.match(sg) || a.match(tg);
  }
  function ug(a) {
    return (a = nd(a))
      ? "function(" + (a[1] || "").replace(/[\s\r\n]+/, " ") + ")"
      : "fn";
  }
  function fb(a, b) {
    function d(a) {
      return function (b, c) {
        if (F(b)) r(b, Xb(a));
        else return a(b, c);
      };
    }
    function c(a, b) {
      Qa(a, "service");
      if (z(b) || I(b)) b = n.instantiate(b);
      if (!b.$get) throw za("pget", a);
      return (q[a + "Provider"] = b);
    }
    function e(a, b) {
      return function () {
        var c = u.invoke(b, this);
        if (x(c)) throw za("undef", a);
        return c;
      };
    }
    function f(a, b, d) {
      return c(a, { $get: !1 !== d ? e(a, b) : b });
    }
    function g(a) {
      gb(x(a) || I(a), "modulesToLoad", "not an array");
      var b = [],
        c;
      r(a, function (a) {
        function d(a) {
          var b, c;
          b = 0;
          for (c = a.length; b < c; b++) {
            var e = a[b],
              f = n.get(e[0]);
            f[e[1]].apply(f, e[2]);
          }
        }
        if (!m.get(a)) {
          m.set(a, !0);
          try {
            C(a)
              ? ((c = jc(a)),
                (u.modules[a] = c),
                (b = b.concat(g(c.requires)).concat(c._runBlocks)),
                d(c._invokeQueue),
                d(c._configBlocks))
              : z(a)
              ? b.push(n.invoke(a))
              : I(a)
              ? b.push(n.invoke(a))
              : sb(a, "module");
          } catch (e) {
            throw (
              (I(a) && (a = a[a.length - 1]),
              e.message &&
                e.stack &&
                -1 === e.stack.indexOf(e.message) &&
                (e = e.message + "\n" + e.stack),
              za("modulerr", a, e.stack || e.message || e))
            );
          }
        }
      });
      return b;
    }
    function k(a, c) {
      function d(b, e) {
        if (a.hasOwnProperty(b)) {
          if (a[b] === h) throw za("cdep", b + " <- " + l.join(" <- "));
          return a[b];
        }
        try {
          return l.unshift(b), (a[b] = h), (a[b] = c(b, e)), a[b];
        } catch (f) {
          throw (a[b] === h && delete a[b], f);
        } finally {
          l.shift();
        }
      }
      function e(a, c, f) {
        var g = [];
        a = fb.$$annotate(a, b, f);
        for (var h = 0, k = a.length; h < k; h++) {
          var l = a[h];
          if ("string" !== typeof l) throw za("itkn", l);
          g.push(c && c.hasOwnProperty(l) ? c[l] : d(l, f));
        }
        return g;
      }
      return {
        invoke: function (a, b, c, d) {
          "string" === typeof c && ((d = c), (c = null));
          c = e(a, c, d);
          I(a) && (a = a[a.length - 1]);
          d = a;
          if (Aa || "function" !== typeof d) d = !1;
          else {
            var f = d.$$ngIsClass;
            Fa(f) ||
              (f = d.$$ngIsClass = /^class\b/.test(
                Function.prototype.toString.call(d)
              ));
            d = f;
          }
          return d
            ? (c.unshift(null), new (Function.prototype.bind.apply(a, c))())
            : a.apply(b, c);
        },
        instantiate: function (a, b, c) {
          var d = I(a) ? a[a.length - 1] : a;
          a = e(a, b, c);
          a.unshift(null);
          return new (Function.prototype.bind.apply(d, a))();
        },
        get: d,
        annotate: fb.$$annotate,
        has: function (b) {
          return q.hasOwnProperty(b + "Provider") || a.hasOwnProperty(b);
        },
      };
    }
    b = !0 === b;
    var h = {},
      l = [],
      m = new Hb(),
      q = {
        $provide: {
          provider: d(c),
          factory: d(f),
          service: d(function (a, b) {
            return f(a, [
              "$injector",
              function (a) {
                return a.instantiate(b);
              },
            ]);
          }),
          value: d(function (a, b) {
            return f(a, ia(b), !1);
          }),
          constant: d(function (a, b) {
            Qa(a, "constant");
            q[a] = b;
            s[a] = b;
          }),
          decorator: function (a, b) {
            var c = n.get(a + "Provider"),
              d = c.$get;
            c.$get = function () {
              var a = u.invoke(d, c);
              return u.invoke(b, null, { $delegate: a });
            };
          },
        },
      },
      n = (q.$injector = k(q, function (a, b) {
        ea.isString(b) && l.push(b);
        throw za("unpr", l.join(" <- "));
      })),
      s = {},
      t = k(s, function (a, b) {
        var c = n.get(a + "Provider", b);
        return u.invoke(c.$get, c, void 0, a);
      }),
      u = t;
    q.$injectorProvider = { $get: ia(t) };
    u.modules = n.modules = S();
    var D = g(a),
      u = t.get("$injector");
    u.strictDi = b;
    r(D, function (a) {
      a && u.invoke(a);
    });
    u.loadNewModules = function (a) {
      r(g(a), function (a) {
        a && u.invoke(a);
      });
    };
    return u;
  }
  function sf() {
    var a = !0;
    this.disableAutoScrolling = function () {
      a = !1;
    };
    this.$get = [
      "$window",
      "$location",
      "$rootScope",
      function (b, d, c) {
        function e(a) {
          var b = null;
          Array.prototype.some.call(a, function (a) {
            if ("a" === ta(a)) return (b = a), !0;
          });
          return b;
        }
        function f(a) {
          if (a) {
            a.scrollIntoView();
            var c;
            c = g.yOffset;
            z(c)
              ? (c = c())
              : Zb(c)
              ? ((c = c[0]),
                (c =
                  "fixed" !== b.getComputedStyle(c).position
                    ? 0
                    : c.getBoundingClientRect().bottom))
              : ba(c) || (c = 0);
            c && ((a = a.getBoundingClientRect().top), b.scrollBy(0, a - c));
          } else b.scrollTo(0, 0);
        }
        function g(a) {
          a = C(a) ? a : ba(a) ? a.toString() : d.hash();
          var b;
          a
            ? (b = k.getElementById(a))
              ? f(b)
              : (b = e(k.getElementsByName(a)))
              ? f(b)
              : "top" === a && f(null)
            : f(null);
        }
        var k = b.document;
        a &&
          c.$watch(
            function () {
              return d.hash();
            },
            function (a, b) {
              (a === b && "" === a) ||
                mg(function () {
                  c.$evalAsync(g);
                });
            }
          );
        return g;
      },
    ];
  }
  function hb(a, b) {
    if (!a && !b) return "";
    if (!a) return b;
    if (!b) return a;
    I(a) && (a = a.join(" "));
    I(b) && (b = b.join(" "));
    return a + " " + b;
  }
  function vg(a) {
    C(a) && (a = a.split(" "));
    var b = S();
    r(a, function (a) {
      a.length && (b[a] = !0);
    });
    return b;
  }
  function Ba(a) {
    return F(a) ? a : {};
  }
  function wg(a, b, d, c, e) {
    function f() {
      Z = null;
      k();
    }
    function g() {
      u = E();
      u = x(u) ? null : u;
      ua(u, H) && (u = H);
      D = H = u;
    }
    function k() {
      var a = D;
      g();
      if (w !== h.url() || a !== u)
        (w = h.url()),
          (D = u),
          r(G, function (a) {
            a(h.url(), u);
          });
    }
    var h = this,
      l = a.location,
      m = a.history,
      q = a.setTimeout,
      n = a.clearTimeout,
      s = {},
      t = e(d);
    h.isMock = !1;
    h.$$completeOutstandingRequest = t.completeTask;
    h.$$incOutstandingRequestCount = t.incTaskCount;
    h.notifyWhenNoOutstandingRequests = t.notifyWhenNoPendingTasks;
    var u,
      D,
      w = l.href,
      ic = b.find("base"),
      Z = null,
      E = c.history
        ? function () {
            try {
              return m.state;
            } catch (a) {}
          }
        : A;
    g();
    h.url = function (b, d, e) {
      x(e) && (e = null);
      l !== a.location && (l = a.location);
      m !== a.history && (m = a.history);
      if (b) {
        var f = D === e;
        if (w === b && (!c.history || f)) return h;
        var k = w && qa(w) === qa(b);
        w = b;
        D = e;
        !c.history || (k && f)
          ? (k || (Z = b),
            d
              ? l.replace(b)
              : k
              ? ((d = l),
                (e = b.indexOf("#")),
                (e = -1 === e ? "" : b.substr(e)),
                (d.hash = e))
              : (l.href = b),
            l.href !== b && (Z = b))
          : (m[d ? "replaceState" : "pushState"](e, "", b), g());
        Z && (Z = b);
        return h;
      }
      return (Z || l.href).replace(/#$/, "");
    };
    h.state = function () {
      return u;
    };
    var G = [],
      J = !1,
      H = null;
    h.onUrlChange = function (b) {
      if (!J) {
        if (c.history) y(a).on("popstate", f);
        y(a).on("hashchange", f);
        J = !0;
      }
      G.push(b);
      return b;
    };
    h.$$applicationDestroyed = function () {
      y(a).off("hashchange popstate", f);
    };
    h.$$checkUrlChange = k;
    h.baseHref = function () {
      var a = ic.attr("href");
      return a ? a.replace(/^(https?:)?\/\/[^/]*/, "") : "";
    };
    h.defer = function (a, b, c) {
      var d;
      b = b || 0;
      c = c || t.DEFAULT_TASK_TYPE;
      t.incTaskCount(c);
      d = q(function () {
        delete s[d];
        t.completeTask(a, c);
      }, b);
      s[d] = c;
      return d;
    };
    h.defer.cancel = function (a) {
      if (s.hasOwnProperty(a)) {
        var b = s[a];
        delete s[a];
        n(a);
        t.completeTask(A, b);
        return !0;
      }
      return !1;
    };
  }
  function zf() {
    this.$get = [
      "$window",
      "$log",
      "$sniffer",
      "$document",
      "$$taskTrackerFactory",
      function (a, b, d, c, e) {
        return new wg(a, c, b, d, e);
      },
    ];
  }
  function Af() {
    this.$get = function () {
      function a(a, c) {
        function e(a) {
          a !== q &&
            (n ? n === a && (n = a.n) : (n = a),
            f(a.n, a.p),
            f(a, q),
            (q = a),
            (q.n = null));
        }
        function f(a, b) {
          a !== b && (a && (a.p = b), b && (b.n = a));
        }
        if (a in b) throw M("$cacheFactory")("iid", a);
        var g = 0,
          k = R({}, c, { id: a }),
          h = S(),
          l = (c && c.capacity) || Number.MAX_VALUE,
          m = S(),
          q = null,
          n = null;
        return (b[a] = {
          put: function (a, b) {
            if (!x(b)) {
              if (l < Number.MAX_VALUE) {
                var c = m[a] || (m[a] = { key: a });
                e(c);
              }
              a in h || g++;
              h[a] = b;
              g > l && this.remove(n.key);
              return b;
            }
          },
          get: function (a) {
            if (l < Number.MAX_VALUE) {
              var b = m[a];
              if (!b) return;
              e(b);
            }
            return h[a];
          },
          remove: function (a) {
            if (l < Number.MAX_VALUE) {
              var b = m[a];
              if (!b) return;
              b === q && (q = b.p);
              b === n && (n = b.n);
              f(b.n, b.p);
              delete m[a];
            }
            a in h && (delete h[a], g--);
          },
          removeAll: function () {
            h = S();
            g = 0;
            m = S();
            q = n = null;
          },
          destroy: function () {
            m = k = h = null;
            delete b[a];
          },
          info: function () {
            return R({}, k, { size: g });
          },
        });
      }
      var b = {};
      a.info = function () {
        var a = {};
        r(b, function (b, e) {
          a[e] = b.info();
        });
        return a;
      };
      a.get = function (a) {
        return b[a];
      };
      return a;
    };
  }
  function Zf() {
    this.$get = [
      "$cacheFactory",
      function (a) {
        return a("templates");
      },
    ];
  }
  function Wc(a, b) {
    function d(a, b, c) {
      var d = /^([@&]|[=<](\*?))(\??)\s*([\w$]*)$/,
        e = S();
      r(a, function (a, f) {
        a = a.trim();
        if (a in q) e[f] = q[a];
        else {
          var g = a.match(d);
          if (!g)
            throw aa(
              "iscp",
              b,
              f,
              a,
              c ? "controller bindings definition" : "isolate scope definition"
            );
          e[f] = {
            mode: g[1][0],
            collection: "*" === g[2],
            optional: "?" === g[3],
            attrName: g[4] || f,
          };
          g[4] && (q[a] = e[f]);
        }
      });
      return e;
    }
    function c(a) {
      var b = a.charAt(0);
      if (!b || b !== O(b)) throw aa("baddir", a);
      if (a !== a.trim()) throw aa("baddir", a);
    }
    function e(a) {
      var b = a.require || (a.controller && a.name);
      !I(b) &&
        F(b) &&
        r(b, function (a, c) {
          var d = a.match(l);
          a.substring(d[0].length) || (b[c] = d[0] + c);
        });
      return b;
    }
    var f = {},
      g = /^\s*directive:\s*([\w-]+)\s+(.*)$/,
      k = /(([\w-]+)(?::([^;]+))?;?)/,
      h = te("ngSrc,ngSrcset,src,srcset"),
      l = /^(?:(\^\^?)?(\?)?(\^\^?)?)?/,
      m = /^(on[a-z]+|formaction)$/,
      q = S();
    this.directive = function Z(b, d) {
      gb(b, "name");
      Qa(b, "directive");
      C(b)
        ? (c(b),
          gb(d, "directiveFactory"),
          f.hasOwnProperty(b) ||
            ((f[b] = []),
            a.factory(b + "Directive", [
              "$injector",
              "$exceptionHandler",
              function (a, c) {
                var d = [];
                r(f[b], function (f, g) {
                  try {
                    var h = a.invoke(f);
                    z(h)
                      ? (h = { compile: ia(h) })
                      : !h.compile && h.link && (h.compile = ia(h.link));
                    h.priority = h.priority || 0;
                    h.index = g;
                    h.name = h.name || b;
                    h.require = e(h);
                    var k = h,
                      l = h.restrict;
                    if (l && (!C(l) || !/[EACM]/.test(l)))
                      throw aa("badrestrict", l, b);
                    k.restrict = l || "EA";
                    h.$$moduleName = f.$$moduleName;
                    d.push(h);
                  } catch (m) {
                    c(m);
                  }
                });
                return d;
              },
            ])),
          f[b].push(d))
        : r(b, Xb(Z));
      return this;
    };
    this.component = function E(a, b) {
      function c(a) {
        function e(b) {
          return z(b) || I(b)
            ? function (c, d) {
                return a.invoke(b, this, { $element: c, $attrs: d });
              }
            : b;
        }
        var f = b.template || b.templateUrl ? b.template : "",
          g = {
            controller: d,
            controllerAs: xg(b.controller) || b.controllerAs || "$ctrl",
            template: e(f),
            templateUrl: e(b.templateUrl),
            transclude: b.transclude,
            scope: {},
            bindToController: b.bindings || {},
            restrict: "E",
            require: b.require,
          };
        r(b, function (a, b) {
          "$" === b.charAt(0) && (g[b] = a);
        });
        return g;
      }
      if (!C(a)) return r(a, Xb(Va(this, E))), this;
      var d = b.controller || function () {};
      r(b, function (a, b) {
        "$" === b.charAt(0) && ((c[b] = a), z(d) && (d[b] = a));
      });
      c.$inject = ["$injector"];
      return this.directive(a, c);
    };
    this.aHrefSanitizationWhitelist = function (a) {
      return v(a)
        ? (b.aHrefSanitizationWhitelist(a), this)
        : b.aHrefSanitizationWhitelist();
    };
    this.imgSrcSanitizationWhitelist = function (a) {
      return v(a)
        ? (b.imgSrcSanitizationWhitelist(a), this)
        : b.imgSrcSanitizationWhitelist();
    };
    var n = !0;
    this.debugInfoEnabled = function (a) {
      return v(a) ? ((n = a), this) : n;
    };
    var s = !1;
    this.strictComponentBindingsEnabled = function (a) {
      return v(a) ? ((s = a), this) : s;
    };
    var t = 10;
    this.onChangesTtl = function (a) {
      return arguments.length ? ((t = a), this) : t;
    };
    var u = !0;
    this.commentDirectivesEnabled = function (a) {
      return arguments.length ? ((u = a), this) : u;
    };
    var D = !0;
    this.cssClassDirectivesEnabled = function (a) {
      return arguments.length ? ((D = a), this) : D;
    };
    var w = S();
    this.addPropertySecurityContext = function (a, b, c) {
      var d = a.toLowerCase() + "|" + b.toLowerCase();
      if (d in w && w[d] !== c) throw aa("ctxoverride", a, b, w[d], c);
      w[d] = c;
      return this;
    };
    (function () {
      function a(b, c) {
        r(c, function (a) {
          w[a.toLowerCase()] = b;
        });
      }
      a(U.HTML, ["iframe|srcdoc", "*|innerHTML", "*|outerHTML"]);
      a(U.CSS, ["*|style"]);
      a(
        U.URL,
        "area|href area|ping a|href a|ping blockquote|cite body|background del|cite input|src ins|cite q|cite".split(
          " "
        )
      );
      a(
        U.MEDIA_URL,
        "audio|src img|src img|srcset source|src source|srcset track|src video|src video|poster".split(
          " "
        )
      );
      a(
        U.RESOURCE_URL,
        "*|formAction applet|code applet|codebase base|href embed|src frame|src form|action head|profile html|manifest iframe|src link|href media|src object|codebase object|data script|src".split(
          " "
        )
      );
    })();
    this.$get = [
      "$injector",
      "$interpolate",
      "$exceptionHandler",
      "$templateRequest",
      "$parse",
      "$controller",
      "$rootScope",
      "$sce",
      "$animate",
      function (a, b, c, e, q, K, L, P, Q) {
        function p() {
          try {
            if (!--Ja) throw ((Ua = void 0), aa("infchng", t));
            L.$apply(function () {
              for (var a = 0, b = Ua.length; a < b; ++a)
                try {
                  Ua[a]();
                } catch (d) {
                  c(d);
                }
              Ua = void 0;
            });
          } finally {
            Ja++;
          }
        }
        function na(a, b) {
          if (!a) return a;
          if (!C(a)) throw aa("srcset", b, a.toString());
          for (
            var c = "",
              d = T(a),
              e = /(\s+\d+x\s*,|\s+\d+w\s*,|\s+,|,\s+)/,
              e = /\s/.test(d) ? e : /(,)/,
              d = d.split(e),
              e = Math.floor(d.length / 2),
              f = 0;
            f < e;
            f++
          )
            var g = 2 * f,
              c = c + P.getTrustedMediaUrl(T(d[g])),
              c = c + (" " + T(d[g + 1]));
          d = T(d[2 * f]).split(/\s/);
          c += P.getTrustedMediaUrl(T(d[0]));
          2 === d.length && (c += " " + T(d[1]));
          return c;
        }
        function v(a, b) {
          if (b) {
            var c = Object.keys(b),
              d,
              e,
              f;
            d = 0;
            for (e = c.length; d < e; d++) (f = c[d]), (this[f] = b[f]);
          } else this.$attr = {};
          this.$$element = a;
        }
        function N(a, b, c) {
          Ea.innerHTML = "<span " + b + ">";
          b = Ea.firstChild.attributes;
          var d = b[0];
          b.removeNamedItem(d.name);
          d.value = c;
          a.attributes.setNamedItem(d);
        }
        function ra(a, b) {
          try {
            a.addClass(b);
          } catch (c) {}
        }
        function fa(a, b, c, d, e) {
          a instanceof y || (a = y(a));
          var f = Xa(a, b, a, c, d, e);
          fa.$$addScopeClass(a);
          var g = null;
          return function (b, c, d) {
            if (!a) throw aa("multilink");
            gb(b, "scope");
            e && e.needsNewScope && (b = b.$parent.$new());
            d = d || {};
            var h = d.parentBoundTranscludeFn,
              k = d.transcludeControllers;
            d = d.futureParentElement;
            h && h.$$boundTransclude && (h = h.$$boundTransclude);
            g ||
              (g = (d = d && d[0])
                ? "foreignobject" !== ta(d) && ma.call(d).match(/SVG/)
                  ? "svg"
                  : "html"
                : "html");
            d =
              "html" !== g
                ? y(ja(g, y("<div></div>").append(a).html()))
                : c
                ? Wa.clone.call(a)
                : a;
            if (k)
              for (var l in k) d.data("$" + l + "Controller", k[l].instance);
            fa.$$addScopeInfo(d, b);
            c && c(d, b);
            f && f(b, d, d, h);
            c || (a = f = null);
            return d;
          };
        }
        function Xa(a, b, c, d, e, f) {
          function g(a, c, d, e) {
            var f, k, l, m, q, n, G;
            if (J)
              for (G = Array(c.length), m = 0; m < h.length; m += 3)
                (f = h[m]), (G[f] = c[f]);
            else G = c;
            m = 0;
            for (q = h.length; m < q; )
              (k = G[h[m++]]),
                (c = h[m++]),
                (f = h[m++]),
                c
                  ? (c.scope
                      ? ((l = a.$new()), fa.$$addScopeInfo(y(k), l))
                      : (l = a),
                    (n = c.transcludeOnThisElement
                      ? ka(a, c.transclude, e)
                      : !c.templateOnThisElement && e
                      ? e
                      : !e && b
                      ? ka(a, b)
                      : null),
                    c(f, l, k, d, n))
                  : f && f(a, k.childNodes, void 0, e);
          }
          for (
            var h = [], k = I(a) || a instanceof y, l, m, q, n, J, G = 0;
            G < a.length;
            G++
          ) {
            l = new v();
            11 === Aa && ib(a, G, k);
            m = rc(a[G], [], l, 0 === G ? d : void 0, e);
            (f = m.length ? ba(m, a[G], l, b, c, null, [], [], f) : null) &&
              f.scope &&
              fa.$$addScopeClass(l.$$element);
            l =
              (f && f.terminal) || !(q = a[G].childNodes) || !q.length
                ? null
                : Xa(
                    q,
                    f
                      ? (f.transcludeOnThisElement ||
                          !f.templateOnThisElement) &&
                          f.transclude
                      : b
                  );
            if (f || l) h.push(G, f, l), (n = !0), (J = J || f);
            f = null;
          }
          return n ? g : null;
        }
        function ib(a, b, c) {
          var d = a[b],
            e = d.parentNode,
            f;
          if (d.nodeType === Oa)
            for (;;) {
              f = e ? d.nextSibling : a[b + 1];
              if (!f || f.nodeType !== Oa) break;
              d.nodeValue += f.nodeValue;
              f.parentNode && f.parentNode.removeChild(f);
              c && f === a[b + 1] && a.splice(b + 1, 1);
            }
        }
        function ka(a, b, c) {
          function d(e, f, g, h, k) {
            e || ((e = a.$new(!1, k)), (e.$$transcluded = !0));
            return b(e, f, {
              parentBoundTranscludeFn: c,
              transcludeControllers: g,
              futureParentElement: h,
            });
          }
          var e = (d.$$slots = S()),
            f;
          for (f in b.$$slots)
            e[f] = b.$$slots[f] ? ka(a, b.$$slots[f], c) : null;
          return d;
        }
        function rc(a, b, d, e, f) {
          var g = d.$attr,
            h;
          switch (a.nodeType) {
            case 1:
              h = ta(a);
              V(b, va(h), "E", e, f);
              for (
                var l, m, n, G, u, s = a.attributes, w = 0, E = s && s.length;
                w < E;
                w++
              ) {
                var D = !1,
                  r = !1,
                  P = !1,
                  H = !1,
                  t = !1,
                  K;
                l = s[w];
                m = l.name;
                G = l.value;
                n = va(m.toLowerCase());
                (u = n.match(Ra))
                  ? ((P = "Attr" === u[1]),
                    (H = "Prop" === u[1]),
                    (t = "On" === u[1]),
                    (m = m
                      .replace(od, "")
                      .toLowerCase()
                      .substr(4 + u[1].length)
                      .replace(/_(.)/g, function (a, b) {
                        return b.toUpperCase();
                      })))
                  : (K = n.match(Sa)) &&
                    ea(K[1]) &&
                    ((D = m),
                    (r = m.substr(0, m.length - 5) + "end"),
                    (m = m.substr(0, m.length - 6)));
                if (H || t)
                  (d[n] = G),
                    (g[n] = l.name),
                    H ? Ha(a, b, n, m) : b.push(pd(q, L, c, n, m, !1));
                else {
                  n = va(m.toLowerCase());
                  g[n] = m;
                  if (P || !d.hasOwnProperty(n))
                    (d[n] = G), kd(a, n) && (d[n] = !0);
                  Ia(a, b, G, n, P);
                  V(b, n, "A", e, f, D, r);
                }
              }
              "input" === h &&
                "hidden" === a.getAttribute("type") &&
                a.setAttribute("autocomplete", "off");
              if (!Qa) break;
              g = a.className;
              F(g) && (g = g.animVal);
              if (C(g) && "" !== g)
                for (; (a = k.exec(g)); )
                  (n = va(a[2])),
                    V(b, n, "C", e, f) && (d[n] = T(a[3])),
                    (g = g.substr(a.index + a[0].length));
              break;
            case Oa:
              oa(b, a.nodeValue);
              break;
            case 8:
              if (!Pa) break;
              M(a, b, d, e, f);
          }
          b.sort(la);
          return b;
        }
        function M(a, b, c, d, e) {
          try {
            var f = g.exec(a.nodeValue);
            if (f) {
              var h = va(f[1]);
              V(b, h, "M", d, e) && (c[h] = T(f[2]));
            }
          } catch (k) {}
        }
        function U(a, b, c) {
          var d = [],
            e = 0;
          if (b && a.hasAttribute && a.hasAttribute(b)) {
            do {
              if (!a) throw aa("uterdir", b, c);
              1 === a.nodeType &&
                (a.hasAttribute(b) && e++, a.hasAttribute(c) && e--);
              d.push(a);
              a = a.nextSibling;
            } while (0 < e);
          } else d.push(a);
          return y(d);
        }
        function W(a, b, c) {
          return function (d, e, f, g, h) {
            e = U(e[0], b, c);
            return a(d, e, f, g, h);
          };
        }
        function Y(a, b, c, d, e, f) {
          var g;
          return a
            ? fa(b, c, d, e, f)
            : function () {
                g || ((g = fa(b, c, d, e, f)), (b = c = f = null));
                return g.apply(this, arguments);
              };
        }
        function ba(a, b, d, e, f, g, h, k, l) {
          function m(a, b, c, d) {
            if (a) {
              c && (a = W(a, c, d));
              a.require = t.require;
              a.directiveName = K;
              if (s === t || t.$$isolateScope) a = za(a, { isolateScope: !0 });
              h.push(a);
            }
            if (b) {
              c && (b = W(b, c, d));
              b.require = t.require;
              b.directiveName = K;
              if (s === t || t.$$isolateScope) b = za(b, { isolateScope: !0 });
              k.push(b);
            }
          }
          function q(a, e, f, g, l) {
            function m(a, b, c, d) {
              var e;
              bb(a) || ((d = c), (c = b), (b = a), (a = void 0));
              P && (e = D);
              c || (c = P ? K.parent() : K);
              if (d) {
                var f = l.$$slots[d];
                if (f) return f(a, b, e, c, Q);
                if (x(f)) throw aa("noslot", d, ya(K));
              } else return l(a, b, e, c, Q);
            }
            var n, t, L, H, E, D, X, K;
            b === f
              ? ((g = d), (K = d.$$element))
              : ((K = y(f)), (g = new v(K, d)));
            E = e;
            s ? (H = e.$new(!0)) : G && (E = e.$parent);
            l &&
              ((X = m),
              (X.$$boundTransclude = l),
              (X.isSlotFilled = function (a) {
                return !!l.$$slots[a];
              }));
            u && (D = ga(K, g, X, u, H, e, s));
            s &&
              (fa.$$addScopeInfo(
                K,
                H,
                !0,
                !(w && (w === s || w === s.$$originalDirective))
              ),
              fa.$$addScopeClass(K, !0),
              (H.$$isolateBindings = s.$$isolateBindings),
              (t = Ca(e, g, H, H.$$isolateBindings, s)),
              t.removeWatches && H.$on("$destroy", t.removeWatches));
            for (n in D) {
              t = u[n];
              L = D[n];
              var yg = t.$$bindings.bindToController;
              L.instance = L();
              K.data("$" + t.name + "Controller", L.instance);
              L.bindingInfo = Ca(E, g, L.instance, yg, t);
            }
            r(u, function (a, b) {
              var c = a.require;
              a.bindToController &&
                !I(c) &&
                F(c) &&
                R(D[b].instance, $(b, c, K, D));
            });
            r(D, function (a) {
              var b = a.instance;
              if (z(b.$onChanges))
                try {
                  b.$onChanges(a.bindingInfo.initialChanges);
                } catch (d) {
                  c(d);
                }
              if (z(b.$onInit))
                try {
                  b.$onInit();
                } catch (e) {
                  c(e);
                }
              z(b.$doCheck) &&
                (E.$watch(function () {
                  b.$doCheck();
                }),
                b.$doCheck());
              z(b.$onDestroy) &&
                E.$on("$destroy", function () {
                  b.$onDestroy();
                });
            });
            n = 0;
            for (t = h.length; n < t; n++)
              (L = h[n]),
                Ba(
                  L,
                  L.isolateScope ? H : e,
                  K,
                  g,
                  L.require && $(L.directiveName, L.require, K, D),
                  X
                );
            var Q = e;
            s && (s.template || null === s.templateUrl) && (Q = H);
            a && a(Q, f.childNodes, void 0, l);
            for (n = k.length - 1; 0 <= n; n--)
              (L = k[n]),
                Ba(
                  L,
                  L.isolateScope ? H : e,
                  K,
                  g,
                  L.require && $(L.directiveName, L.require, K, D),
                  X
                );
            r(D, function (a) {
              a = a.instance;
              z(a.$postLink) && a.$postLink();
            });
          }
          l = l || {};
          for (
            var n = -Number.MAX_VALUE,
              G = l.newScopeDirective,
              u = l.controllerDirectives,
              s = l.newIsolateScopeDirective,
              w = l.templateDirective,
              L = l.nonTlbTranscludeDirective,
              E = !1,
              D = !1,
              P = l.hasElementTranscludeDirective,
              H = (d.$$element = y(b)),
              t,
              K,
              X,
              Q = e,
              p,
              na = !1,
              Ib = !1,
              N,
              ra = 0,
              C = a.length;
            ra < C;
            ra++
          ) {
            t = a[ra];
            var A = t.$$start,
              ib = t.$$end;
            A && (H = U(b, A, ib));
            X = void 0;
            if (n > t.priority) break;
            if ((N = t.scope))
              t.templateUrl ||
                (F(N)
                  ? (ca("new/isolated scope", s || G, t, H), (s = t))
                  : ca("new/isolated scope", s, t, H)),
                (G = G || t);
            K = t.name;
            if (
              !na &&
              ((t.replace && (t.templateUrl || t.template)) ||
                (t.transclude && !t.$$tlb))
            ) {
              for (N = ra + 1; (na = a[N++]); )
                if (
                  (na.transclude && !na.$$tlb) ||
                  (na.replace && (na.templateUrl || na.template))
                ) {
                  Ib = !0;
                  break;
                }
              na = !0;
            }
            !t.templateUrl &&
              t.controller &&
              ((u = u || S()),
              ca("'" + K + "' controller", u[K], t, H),
              (u[K] = t));
            if ((N = t.transclude))
              if (
                ((E = !0),
                t.$$tlb || (ca("transclusion", L, t, H), (L = t)),
                "element" === N)
              )
                (P = !0),
                  (n = t.priority),
                  (X = H),
                  (H = d.$$element = y(fa.$$createComment(K, d[K]))),
                  (b = H[0]),
                  pa(f, Ga.call(X, 0), b),
                  (Q = Y(Ib, X, e, n, g && g.name, {
                    nonTlbTranscludeDirective: L,
                  }));
              else {
                var ka = S();
                if (F(N)) {
                  X = B.document.createDocumentFragment();
                  var Xa = S(),
                    M = S();
                  r(N, function (a, b) {
                    var c = "?" === a.charAt(0);
                    a = c ? a.substring(1) : a;
                    Xa[a] = b;
                    ka[b] = null;
                    M[b] = c;
                  });
                  r(H.contents(), function (a) {
                    var b = Xa[va(ta(a))];
                    b
                      ? ((M[b] = !0),
                        (ka[b] = ka[b] || B.document.createDocumentFragment()),
                        ka[b].appendChild(a))
                      : X.appendChild(a);
                  });
                  r(M, function (a, b) {
                    if (!a) throw aa("reqslot", b);
                  });
                  for (var O in ka)
                    ka[O] && ((Q = y(ka[O].childNodes)), (ka[O] = Y(Ib, Q, e)));
                  X = y(X.childNodes);
                } else X = y(oc(b)).contents();
                H.empty();
                Q = Y(Ib, X, e, void 0, void 0, {
                  needsNewScope: t.$$isolateScope || t.$$newScope,
                });
                Q.$$slots = ka;
              }
            if (t.template)
              if (
                ((D = !0),
                ca("template", w, t, H),
                (w = t),
                (N = z(t.template) ? t.template(H, d) : t.template),
                (N = Na(N)),
                t.replace)
              ) {
                g = t;
                X = lc.test(N) ? qd(ja(t.templateNamespace, T(N))) : [];
                b = X[0];
                if (1 !== X.length || 1 !== b.nodeType)
                  throw aa("tplrt", K, "");
                pa(f, H, b);
                C = { $attr: {} };
                N = rc(b, [], C);
                var zg = a.splice(ra + 1, a.length - (ra + 1));
                (s || G) && da(N, s, G);
                a = a.concat(N).concat(zg);
                ha(d, C);
                C = a.length;
              } else H.html(N);
            if (t.templateUrl)
              (D = !0),
                ca("template", w, t, H),
                (w = t),
                t.replace && (g = t),
                (q = ia(a.splice(ra, a.length - ra), H, d, f, E && Q, h, k, {
                  controllerDirectives: u,
                  newScopeDirective: G !== t && G,
                  newIsolateScopeDirective: s,
                  templateDirective: w,
                  nonTlbTranscludeDirective: L,
                })),
                (C = a.length);
            else if (t.compile)
              try {
                p = t.compile(H, d, Q);
                var V = t.$$originalDirective || t;
                z(p)
                  ? m(null, Va(V, p), A, ib)
                  : p && m(Va(V, p.pre), Va(V, p.post), A, ib);
              } catch (ea) {
                c(ea, ya(H));
              }
            t.terminal && ((q.terminal = !0), (n = Math.max(n, t.priority)));
          }
          q.scope = G && !0 === G.scope;
          q.transcludeOnThisElement = E;
          q.templateOnThisElement = D;
          q.transclude = Q;
          l.hasElementTranscludeDirective = P;
          return q;
        }
        function $(a, b, c, d) {
          var e;
          if (C(b)) {
            var f = b.match(l);
            b = b.substring(f[0].length);
            var g = f[1] || f[3],
              f = "?" === f[2];
            "^^" === g ? (c = c.parent()) : (e = (e = d && d[b]) && e.instance);
            if (!e) {
              var h = "$" + b + "Controller";
              e =
                "^^" === g && c[0] && 9 === c[0].nodeType
                  ? null
                  : g
                  ? c.inheritedData(h)
                  : c.data(h);
            }
            if (!e && !f) throw aa("ctreq", b, a);
          } else if (I(b))
            for (e = [], g = 0, f = b.length; g < f; g++)
              e[g] = $(a, b[g], c, d);
          else
            F(b) &&
              ((e = {}),
              r(b, function (b, f) {
                e[f] = $(a, b, c, d);
              }));
          return e || null;
        }
        function ga(a, b, c, d, e, f, g) {
          var h = S(),
            k;
          for (k in d) {
            var l = d[k],
              m = {
                $scope: l === g || l.$$isolateScope ? e : f,
                $element: a,
                $attrs: b,
                $transclude: c,
              },
              n = l.controller;
            "@" === n && (n = b[l.name]);
            m = K(n, m, !0, l.controllerAs);
            h[l.name] = m;
            a.data("$" + l.name + "Controller", m.instance);
          }
          return h;
        }
        function da(a, b, c) {
          for (var d = 0, e = a.length; d < e; d++)
            a[d] = $b(a[d], { $$isolateScope: b, $$newScope: c });
        }
        function V(b, c, e, g, h, k, l) {
          if (c === h) return null;
          var m = null;
          if (f.hasOwnProperty(c)) {
            h = a.get(c + "Directive");
            for (var n = 0, q = h.length; n < q; n++)
              if (
                ((c = h[n]),
                (x(g) || g > c.priority) && -1 !== c.restrict.indexOf(e))
              ) {
                k && (c = $b(c, { $$start: k, $$end: l }));
                if (!c.$$bindings) {
                  var J = (m = c),
                    G = c.name,
                    u = { isolateScope: null, bindToController: null };
                  F(J.scope) &&
                    (!0 === J.bindToController
                      ? ((u.bindToController = d(J.scope, G, !0)),
                        (u.isolateScope = {}))
                      : (u.isolateScope = d(J.scope, G, !1)));
                  F(J.bindToController) &&
                    (u.bindToController = d(J.bindToController, G, !0));
                  if (u.bindToController && !J.controller)
                    throw aa("noctrl", G);
                  m = m.$$bindings = u;
                  F(m.isolateScope) && (c.$$isolateBindings = m.isolateScope);
                }
                b.push(c);
                m = c;
              }
          }
          return m;
        }
        function ea(b) {
          if (f.hasOwnProperty(b))
            for (
              var c = a.get(b + "Directive"), d = 0, e = c.length;
              d < e;
              d++
            )
              if (((b = c[d]), b.multiElement)) return !0;
          return !1;
        }
        function ha(a, b) {
          var c = b.$attr,
            d = a.$attr;
          r(a, function (d, e) {
            "$" !== e.charAt(0) &&
              (b[e] &&
                b[e] !== d &&
                (d = d.length
                  ? d + (("style" === e ? ";" : " ") + b[e])
                  : b[e]),
              a.$set(e, d, !0, c[e]));
          });
          r(b, function (b, e) {
            a.hasOwnProperty(e) ||
              "$" === e.charAt(0) ||
              ((a[e] = b), "class" !== e && "style" !== e && (d[e] = c[e]));
          });
        }
        function ia(a, b, d, f, g, h, k, l) {
          var m = [],
            n,
            q,
            G = b[0],
            u = a.shift(),
            t = $b(u, {
              templateUrl: null,
              transclude: null,
              replace: null,
              $$originalDirective: u,
            }),
            s = z(u.templateUrl) ? u.templateUrl(b, d) : u.templateUrl,
            L = u.templateNamespace;
          b.empty();
          e(s)
            .then(function (c) {
              var e, J;
              c = Na(c);
              if (u.replace) {
                c = lc.test(c) ? qd(ja(L, T(c))) : [];
                e = c[0];
                if (1 !== c.length || 1 !== e.nodeType)
                  throw aa("tplrt", u.name, s);
                c = { $attr: {} };
                pa(f, b, e);
                var w = rc(e, [], c);
                F(u.scope) && da(w, !0);
                a = w.concat(a);
                ha(d, c);
              } else (e = G), b.html(c);
              a.unshift(t);
              n = ba(a, e, d, g, b, u, h, k, l);
              r(f, function (a, c) {
                a === e && (f[c] = b[0]);
              });
              for (q = Xa(b[0].childNodes, g); m.length; ) {
                c = m.shift();
                J = m.shift();
                var H = m.shift(),
                  D = m.shift(),
                  w = b[0];
                if (!c.$$destroyed) {
                  if (J !== G) {
                    var E = J.className;
                    (l.hasElementTranscludeDirective && u.replace) ||
                      (w = oc(e));
                    pa(H, y(J), w);
                    ra(y(w), E);
                  }
                  J = n.transcludeOnThisElement ? ka(c, n.transclude, D) : D;
                  n(q, c, w, f, J);
                }
              }
              m = null;
            })
            .catch(function (a) {
              bc(a) && c(a);
            });
          return function (a, b, c, d, e) {
            a = e;
            b.$$destroyed ||
              (m
                ? m.push(b, c, d, a)
                : (n.transcludeOnThisElement && (a = ka(b, n.transclude, e)),
                  n(q, b, c, d, a)));
          };
        }
        function la(a, b) {
          var c = b.priority - a.priority;
          return 0 !== c
            ? c
            : a.name !== b.name
            ? a.name < b.name
              ? -1
              : 1
            : a.index - b.index;
        }
        function ca(a, b, c, d) {
          function e(a) {
            return a ? " (module: " + a + ")" : "";
          }
          if (b)
            throw aa(
              "multidir",
              b.name,
              e(b.$$moduleName),
              c.name,
              e(c.$$moduleName),
              a,
              ya(d)
            );
        }
        function oa(a, c) {
          var d = b(c, !0);
          d &&
            a.push({
              priority: 0,
              compile: function (a) {
                a = a.parent();
                var b = !!a.length;
                b && fa.$$addBindingClass(a);
                return function (a, c) {
                  var e = c.parent();
                  b || fa.$$addBindingClass(e);
                  fa.$$addBindingInfo(e, d.expressions);
                  a.$watch(d, function (a) {
                    c[0].nodeValue = a;
                  });
                };
              },
            });
        }
        function ja(a, b) {
          a = O(a || "html");
          switch (a) {
            case "svg":
            case "math":
              var c = B.document.createElement("div");
              c.innerHTML = "<" + a + ">" + b + "</" + a + ">";
              return c.childNodes[0].childNodes;
            default:
              return b;
          }
        }
        function wa(a, b) {
          if ("srcdoc" === b) return P.HTML;
          if ("src" === b || "ngSrc" === b)
            return -1 ===
              ["img", "video", "audio", "source", "track"].indexOf(a)
              ? P.RESOURCE_URL
              : P.MEDIA_URL;
          if ("xlinkHref" === b)
            return "image" === a
              ? P.MEDIA_URL
              : "a" === a
              ? P.URL
              : P.RESOURCE_URL;
          if (
            ("form" === a && "action" === b) ||
            ("base" === a && "href" === b) ||
            ("link" === a && "href" === b)
          )
            return P.RESOURCE_URL;
          if ("a" === a && ("href" === b || "ngHref" === b)) return P.URL;
        }
        function xa(a, b) {
          var c = b.toLowerCase();
          return w[a + "|" + c] || w["*|" + c];
        }
        function Da(a) {
          return na(P.valueOf(a), "ng-prop-srcset");
        }
        function Ha(a, b, c, d) {
          if (m.test(d)) throw aa("nodomevents");
          a = ta(a);
          var e = xa(a, d),
            f = Ta;
          "srcset" !== d || ("img" !== a && "source" !== a)
            ? e && (f = P.getTrusted.bind(P, e))
            : (f = Da);
          b.push({
            priority: 100,
            compile: function (a, b) {
              var e = q(b[c]),
                g = q(b[c], function (a) {
                  return P.valueOf(a);
                });
              return {
                pre: function (a, b) {
                  function c() {
                    var g = e(a);
                    b.prop(d, f(g));
                  }
                  c();
                  a.$watch(g, c);
                },
              };
            },
          });
        }
        function Ia(a, c, d, e, f) {
          var g = ta(a),
            k = wa(g, e),
            l = h[e] || f,
            n = b(d, !f, k, l);
          if (n) {
            if ("multiple" === e && "select" === g) throw aa("selmulti", ya(a));
            if (m.test(e)) throw aa("nodomevents");
            c.push({
              priority: 100,
              compile: function () {
                return {
                  pre: function (a, c, f) {
                    c = f.$$observers || (f.$$observers = S());
                    var g = f[e];
                    g !== d && ((n = g && b(g, !0, k, l)), (d = g));
                    n &&
                      ((f[e] = n(a)),
                      ((c[e] || (c[e] = [])).$$inter = !0),
                      ((f.$$observers && f.$$observers[e].$$scope) || a).$watch(
                        n,
                        function (a, b) {
                          "class" === e && a !== b
                            ? f.$updateClass(a, b)
                            : f.$set(e, a);
                        }
                      ));
                  },
                };
              },
            });
          }
        }
        function pa(a, b, c) {
          var d = b[0],
            e = b.length,
            f = d.parentNode,
            g,
            h;
          if (a)
            for (g = 0, h = a.length; g < h; g++)
              if (a[g] === d) {
                a[g++] = c;
                h = g + e - 1;
                for (var k = a.length; g < k; g++, h++)
                  h < k ? (a[g] = a[h]) : delete a[g];
                a.length -= e - 1;
                a.context === d && (a.context = c);
                break;
              }
          f && f.replaceChild(c, d);
          a = B.document.createDocumentFragment();
          for (g = 0; g < e; g++) a.appendChild(b[g]);
          y.hasData(d) && (y.data(c, y.data(d)), y(d).off("$destroy"));
          y.cleanData(a.querySelectorAll("*"));
          for (g = 1; g < e; g++) delete b[g];
          b[0] = c;
          b.length = 1;
        }
        function za(a, b) {
          return R(
            function () {
              return a.apply(null, arguments);
            },
            a,
            b
          );
        }
        function Ba(a, b, d, e, f, g) {
          try {
            a(b, d, e, f, g);
          } catch (h) {
            c(h, ya(d));
          }
        }
        function qa(a, b) {
          if (s) throw aa("missingattr", a, b);
        }
        function Ca(a, c, d, e, f) {
          function g(b, c, e) {
            z(d.$onChanges) &&
              !cc(c, e) &&
              (Ua || (a.$$postDigest(p), (Ua = [])),
              m || ((m = {}), Ua.push(h)),
              m[b] && (e = m[b].previousValue),
              (m[b] = new Jb(e, c)));
          }
          function h() {
            d.$onChanges(m);
            m = void 0;
          }
          var k = [],
            l = {},
            m;
          r(e, function (e, h) {
            var m = e.attrName,
              n = e.optional,
              J,
              u,
              t,
              s;
            switch (e.mode) {
              case "@":
                n || sa.call(c, m) || (qa(m, f.name), (d[h] = c[m] = void 0));
                n = c.$observe(m, function (a) {
                  if (C(a) || Fa(a)) g(h, a, d[h]), (d[h] = a);
                });
                c.$$observers[m].$$scope = a;
                J = c[m];
                C(J) ? (d[h] = b(J)(a)) : Fa(J) && (d[h] = J);
                l[h] = new Jb(sc, d[h]);
                k.push(n);
                break;
              case "=":
                if (!sa.call(c, m)) {
                  if (n) break;
                  qa(m, f.name);
                  c[m] = void 0;
                }
                if (n && !c[m]) break;
                u = q(c[m]);
                s = u.literal ? ua : cc;
                t =
                  u.assign ||
                  function () {
                    J = d[h] = u(a);
                    throw aa("nonassign", c[m], m, f.name);
                  };
                J = d[h] = u(a);
                n = function (b) {
                  s(b, d[h]) || (s(b, J) ? t(a, (b = d[h])) : (d[h] = b));
                  return (J = b);
                };
                n.$stateful = !0;
                n = e.collection
                  ? a.$watchCollection(c[m], n)
                  : a.$watch(q(c[m], n), null, u.literal);
                k.push(n);
                break;
              case "<":
                if (!sa.call(c, m)) {
                  if (n) break;
                  qa(m, f.name);
                  c[m] = void 0;
                }
                if (n && !c[m]) break;
                u = q(c[m]);
                var L = u.literal,
                  w = (d[h] = u(a));
                l[h] = new Jb(sc, d[h]);
                n = a[e.collection ? "$watchCollection" : "$watch"](
                  u,
                  function (a, b) {
                    if (b === a) {
                      if (b === w || (L && ua(b, w))) return;
                      b = w;
                    }
                    g(h, a, b);
                    d[h] = a;
                  }
                );
                k.push(n);
                break;
              case "&":
                n || sa.call(c, m) || qa(m, f.name);
                u = c.hasOwnProperty(m) ? q(c[m]) : A;
                if (u === A && n) break;
                d[h] = function (b) {
                  return u(a, b);
                };
            }
          });
          return {
            initialChanges: l,
            removeWatches:
              k.length &&
              function () {
                for (var a = 0, b = k.length; a < b; ++a) k[a]();
              },
          };
        }
        var Ma = /^\w/,
          Ea = B.document.createElement("div"),
          Pa = u,
          Qa = D,
          Ja = t,
          Ua;
        v.prototype = {
          $normalize: va,
          $addClass: function (a) {
            a && 0 < a.length && Q.addClass(this.$$element, a);
          },
          $removeClass: function (a) {
            a && 0 < a.length && Q.removeClass(this.$$element, a);
          },
          $updateClass: function (a, b) {
            var c = rd(a, b);
            c && c.length && Q.addClass(this.$$element, c);
            (c = rd(b, a)) && c.length && Q.removeClass(this.$$element, c);
          },
          $set: function (a, b, d, e) {
            var f = kd(this.$$element[0], a),
              g = sd[a],
              h = a;
            f
              ? (this.$$element.prop(a, b), (e = f))
              : g && ((this[g] = b), (h = g));
            this[a] = b;
            e
              ? (this.$attr[a] = e)
              : (e = this.$attr[a]) || (this.$attr[a] = e = Uc(a, "-"));
            "img" === ta(this.$$element) &&
              "srcset" === a &&
              (this[a] = b = na(b, "$set('srcset', value)"));
            !1 !== d &&
              (null === b || x(b)
                ? this.$$element.removeAttr(e)
                : Ma.test(e)
                ? this.$$element.attr(e, b)
                : N(this.$$element[0], e, b));
            (a = this.$$observers) &&
              r(a[h], function (a) {
                try {
                  a(b);
                } catch (d) {
                  c(d);
                }
              });
          },
          $observe: function (a, b) {
            var c = this,
              d = c.$$observers || (c.$$observers = S()),
              e = d[a] || (d[a] = []);
            e.push(b);
            L.$evalAsync(function () {
              e.$$inter || !c.hasOwnProperty(a) || x(c[a]) || b(c[a]);
            });
            return function () {
              cb(e, b);
            };
          },
        };
        var Ka = b.startSymbol(),
          La = b.endSymbol(),
          Na =
            "{{" === Ka && "}}" === La
              ? Ta
              : function (a) {
                  return a.replace(/\{\{/g, Ka).replace(/}}/g, La);
                },
          Ra = /^ng(Attr|Prop|On)([A-Z].*)$/,
          Sa = /^(.+)Start$/;
        fa.$$addBindingInfo = n
          ? function (a, b) {
              var c = a.data("$binding") || [];
              I(b) ? (c = c.concat(b)) : c.push(b);
              a.data("$binding", c);
            }
          : A;
        fa.$$addBindingClass = n
          ? function (a) {
              ra(a, "ng-binding");
            }
          : A;
        fa.$$addScopeInfo = n
          ? function (a, b, c, d) {
              a.data(
                c
                  ? d
                    ? "$isolateScopeNoTemplate"
                    : "$isolateScope"
                  : "$scope",
                b
              );
            }
          : A;
        fa.$$addScopeClass = n
          ? function (a, b) {
              ra(a, b ? "ng-isolate-scope" : "ng-scope");
            }
          : A;
        fa.$$createComment = function (a, b) {
          var c = "";
          n && ((c = " " + (a || "") + ": "), b && (c += b + " "));
          return B.document.createComment(c);
        };
        return fa;
      },
    ];
  }
  function Jb(a, b) {
    this.previousValue = a;
    this.currentValue = b;
  }
  function va(a) {
    return a.replace(od, "").replace(Ag, function (a, d, c) {
      return c ? d.toUpperCase() : d;
    });
  }
  function rd(a, b) {
    var d = "",
      c = a.split(/\s+/),
      e = b.split(/\s+/),
      f = 0;
    a: for (; f < c.length; f++) {
      for (var g = c[f], k = 0; k < e.length; k++) if (g === e[k]) continue a;
      d += (0 < d.length ? " " : "") + g;
    }
    return d;
  }
  function qd(a) {
    a = y(a);
    var b = a.length;
    if (1 >= b) return a;
    for (; b--; ) {
      var d = a[b];
      (8 === d.nodeType || (d.nodeType === Oa && "" === d.nodeValue.trim())) &&
        Bg.call(a, b, 1);
    }
    return a;
  }
  function xg(a, b) {
    if (b && C(b)) return b;
    if (C(a)) {
      var d = td.exec(a);
      if (d) return d[3];
    }
  }
  function Bf() {
    var a = {};
    this.has = function (b) {
      return a.hasOwnProperty(b);
    };
    this.register = function (b, d) {
      Qa(b, "controller");
      F(b) ? R(a, b) : (a[b] = d);
    };
    this.$get = [
      "$injector",
      function (b) {
        function d(a, b, d, g) {
          if (!a || !F(a.$scope)) throw M("$controller")("noscp", g, b);
          a.$scope[b] = d;
        }
        return function (c, e, f, g) {
          var k, h, l;
          f = !0 === f;
          g && C(g) && (l = g);
          if (C(c)) {
            g = c.match(td);
            if (!g) throw ud("ctrlfmt", c);
            h = g[1];
            l = l || g[3];
            c = a.hasOwnProperty(h) ? a[h] : De(e.$scope, h, !0);
            if (!c) throw ud("ctrlreg", h);
            sb(c, h, !0);
          }
          if (f)
            return (
              (f = (I(c) ? c[c.length - 1] : c).prototype),
              (k = Object.create(f || null)),
              l && d(e, l, k, h || c.name),
              R(
                function () {
                  var a = b.invoke(c, k, e, h);
                  a !== k &&
                    (F(a) || z(a)) &&
                    ((k = a), l && d(e, l, k, h || c.name));
                  return k;
                },
                { instance: k, identifier: l }
              )
            );
          k = b.instantiate(c, e, h);
          l && d(e, l, k, h || c.name);
          return k;
        };
      },
    ];
  }
  function Cf() {
    this.$get = [
      "$window",
      function (a) {
        return y(a.document);
      },
    ];
  }
  function Df() {
    this.$get = [
      "$document",
      "$rootScope",
      function (a, b) {
        function d() {
          e = c.hidden;
        }
        var c = a[0],
          e = c && c.hidden;
        a.on("visibilitychange", d);
        b.$on("$destroy", function () {
          a.off("visibilitychange", d);
        });
        return function () {
          return e;
        };
      },
    ];
  }
  function Ef() {
    this.$get = [
      "$log",
      function (a) {
        return function (b, d) {
          a.error.apply(a, arguments);
        };
      },
    ];
  }
  function tc(a) {
    return F(a) ? (ha(a) ? a.toISOString() : eb(a)) : a;
  }
  function Kf() {
    this.$get = function () {
      return function (a) {
        if (!a) return "";
        var b = [];
        Nc(a, function (a, c) {
          null === a ||
            x(a) ||
            z(a) ||
            (I(a)
              ? r(a, function (a) {
                  b.push(ca(c) + "=" + ca(tc(a)));
                })
              : b.push(ca(c) + "=" + ca(tc(a))));
        });
        return b.join("&");
      };
    };
  }
  function Lf() {
    this.$get = function () {
      return function (a) {
        function b(a, e, f) {
          I(a)
            ? r(a, function (a, c) {
                b(a, e + "[" + (F(a) ? c : "") + "]");
              })
            : F(a) && !ha(a)
            ? Nc(a, function (a, c) {
                b(a, e + (f ? "" : "[") + c + (f ? "" : "]"));
              })
            : (z(a) && (a = a()),
              d.push(ca(e) + "=" + (null == a ? "" : ca(tc(a)))));
        }
        if (!a) return "";
        var d = [];
        b(a, "", !0);
        return d.join("&");
      };
    };
  }
  function uc(a, b) {
    if (C(a)) {
      var d = a.replace(Cg, "").trim();
      if (d) {
        var c = b("Content-Type"),
          c = c && 0 === c.indexOf(vd),
          e;
        (e = c) || (e = (e = d.match(Dg)) && Eg[e[0]].test(d));
        if (e)
          try {
            a = Qc(d);
          } catch (f) {
            if (!c) return a;
            throw Kb("baddata", a, f);
          }
      }
    }
    return a;
  }
  function wd(a) {
    var b = S(),
      d;
    C(a)
      ? r(a.split("\n"), function (a) {
          d = a.indexOf(":");
          var e = O(T(a.substr(0, d)));
          a = T(a.substr(d + 1));
          e && (b[e] = b[e] ? b[e] + ", " + a : a);
        })
      : F(a) &&
        r(a, function (a, d) {
          var f = O(d),
            g = T(a);
          f && (b[f] = b[f] ? b[f] + ", " + g : g);
        });
    return b;
  }
  function xd(a) {
    var b;
    return function (d) {
      b || (b = wd(a));
      return d ? ((d = b[O(d)]), void 0 === d && (d = null), d) : b;
    };
  }
  function yd(a, b, d, c) {
    if (z(c)) return c(a, b, d);
    r(c, function (c) {
      a = c(a, b, d);
    });
    return a;
  }
  function Jf() {
    var a = (this.defaults = {
        transformResponse: [uc],
        transformRequest: [
          function (a) {
            return F(a) &&
              "[object File]" !== ma.call(a) &&
              "[object Blob]" !== ma.call(a) &&
              "[object FormData]" !== ma.call(a)
              ? eb(a)
              : a;
          },
        ],
        headers: {
          common: { Accept: "application/json, text/plain, */*" },
          post: oa(vc),
          put: oa(vc),
          patch: oa(vc),
        },
        xsrfCookieName: "XSRF-TOKEN",
        xsrfHeaderName: "X-XSRF-TOKEN",
        paramSerializer: "$httpParamSerializer",
        jsonpCallbackParam: "callback",
      }),
      b = !1;
    this.useApplyAsync = function (a) {
      return v(a) ? ((b = !!a), this) : b;
    };
    var d = (this.interceptors = []),
      c = (this.xsrfWhitelistedOrigins = []);
    this.$get = [
      "$browser",
      "$httpBackend",
      "$$cookieReader",
      "$cacheFactory",
      "$rootScope",
      "$q",
      "$injector",
      "$sce",
      function (e, f, g, k, h, l, m, q) {
        function n(b) {
          function c(a, b) {
            for (var d = 0, e = b.length; d < e; ) {
              var f = b[d++],
                g = b[d++];
              a = a.then(f, g);
            }
            b.length = 0;
            return a;
          }
          function d(a, b) {
            var c,
              e = {};
            r(a, function (a, d) {
              z(a) ? ((c = a(b)), null != c && (e[d] = c)) : (e[d] = a);
            });
            return e;
          }
          function f(a) {
            var b = R({}, a);
            b.data = yd(a.data, a.headers, a.status, g.transformResponse);
            a = a.status;
            return 200 <= a && 300 > a ? b : l.reject(b);
          }
          if (!F(b)) throw M("$http")("badreq", b);
          if (!C(q.valueOf(b.url))) throw M("$http")("badreq", b.url);
          var g = R(
            {
              method: "get",
              transformRequest: a.transformRequest,
              transformResponse: a.transformResponse,
              paramSerializer: a.paramSerializer,
              jsonpCallbackParam: a.jsonpCallbackParam,
            },
            b
          );
          g.headers = (function (b) {
            var c = a.headers,
              e = R({}, b.headers),
              f,
              g,
              h,
              c = R({}, c.common, c[O(b.method)]);
            a: for (f in c) {
              g = O(f);
              for (h in e) if (O(h) === g) continue a;
              e[f] = c[f];
            }
            return d(e, oa(b));
          })(b);
          g.method = ub(g.method);
          g.paramSerializer = C(g.paramSerializer)
            ? m.get(g.paramSerializer)
            : g.paramSerializer;
          e.$$incOutstandingRequestCount("$http");
          var h = [],
            k = [];
          b = l.resolve(g);
          r(w, function (a) {
            (a.request || a.requestError) &&
              h.unshift(a.request, a.requestError);
            (a.response || a.responseError) &&
              k.push(a.response, a.responseError);
          });
          b = c(b, h);
          b = b.then(function (b) {
            var c = b.headers,
              d = yd(b.data, xd(c), void 0, b.transformRequest);
            x(d) &&
              r(c, function (a, b) {
                "content-type" === O(b) && delete c[b];
              });
            x(b.withCredentials) &&
              !x(a.withCredentials) &&
              (b.withCredentials = a.withCredentials);
            return s(b, d).then(f, f);
          });
          b = c(b, k);
          return (b = b.finally(function () {
            e.$$completeOutstandingRequest(A, "$http");
          }));
        }
        function s(c, d) {
          function e(a) {
            if (a) {
              var c = {};
              r(a, function (a, d) {
                c[d] = function (c) {
                  function d() {
                    a(c);
                  }
                  b ? h.$applyAsync(d) : h.$$phase ? d() : h.$apply(d);
                };
              });
              return c;
            }
          }
          function k(a, c, d, e, f) {
            function g() {
              m(c, a, d, e, f);
            }
            Q &&
              (200 <= a && 300 > a
                ? Q.put(N, [a, c, wd(d), e, f])
                : Q.remove(N));
            b ? h.$applyAsync(g) : (g(), h.$$phase || h.$apply());
          }
          function m(a, b, d, e, f) {
            b = -1 <= b ? b : 0;
            (200 <= b && 300 > b ? L.resolve : L.reject)({
              data: a,
              status: b,
              headers: xd(d),
              config: c,
              statusText: e,
              xhrStatus: f,
            });
          }
          function s(a) {
            m(a.data, a.status, oa(a.headers()), a.statusText, a.xhrStatus);
          }
          function w() {
            var a = n.pendingRequests.indexOf(c);
            -1 !== a && n.pendingRequests.splice(a, 1);
          }
          var L = l.defer(),
            P = L.promise,
            Q,
            p,
            na = c.headers,
            y = "jsonp" === O(c.method),
            N = c.url;
          y ? (N = q.getTrustedResourceUrl(N)) : C(N) || (N = q.valueOf(N));
          N = t(N, c.paramSerializer(c.params));
          y && (N = u(N, c.jsonpCallbackParam));
          n.pendingRequests.push(c);
          P.then(w, w);
          (!c.cache && !a.cache) ||
            !1 === c.cache ||
            ("GET" !== c.method && "JSONP" !== c.method) ||
            (Q = F(c.cache) ? c.cache : F(a.cache) ? a.cache : D);
          Q &&
            ((p = Q.get(N)),
            v(p)
              ? p && z(p.then)
                ? p.then(s, s)
                : I(p)
                ? m(p[1], p[0], oa(p[2]), p[3], p[4])
                : m(p, 200, {}, "OK", "complete")
              : Q.put(N, P));
          x(p) &&
            ((p = ic(c.url)
              ? g()[c.xsrfCookieName || a.xsrfCookieName]
              : void 0) && (na[c.xsrfHeaderName || a.xsrfHeaderName] = p),
            f(
              c.method,
              N,
              d,
              k,
              na,
              c.timeout,
              c.withCredentials,
              c.responseType,
              e(c.eventHandlers),
              e(c.uploadEventHandlers)
            ));
          return P;
        }
        function t(a, b) {
          0 < b.length && (a += (-1 === a.indexOf("?") ? "?" : "&") + b);
          return a;
        }
        function u(a, b) {
          var c = a.split("?");
          if (2 < c.length) throw Kb("badjsonp", a);
          c = fc(c[1]);
          r(c, function (c, d) {
            if ("JSON_CALLBACK" === c) throw Kb("badjsonp", a);
            if (d === b) throw Kb("badjsonp", b, a);
          });
          return (a +=
            (-1 === a.indexOf("?") ? "?" : "&") + b + "=JSON_CALLBACK");
        }
        var D = k("$http");
        a.paramSerializer = C(a.paramSerializer)
          ? m.get(a.paramSerializer)
          : a.paramSerializer;
        var w = [];
        r(d, function (a) {
          w.unshift(C(a) ? m.get(a) : m.invoke(a));
        });
        var ic = Fg(c);
        n.pendingRequests = [];
        (function (a) {
          r(arguments, function (a) {
            n[a] = function (b, c) {
              return n(R({}, c || {}, { method: a, url: b }));
            };
          });
        })("get", "delete", "head", "jsonp");
        (function (a) {
          r(arguments, function (a) {
            n[a] = function (b, c, d) {
              return n(R({}, d || {}, { method: a, url: b, data: c }));
            };
          });
        })("post", "put", "patch");
        n.defaults = a;
        return n;
      },
    ];
  }
  function Nf() {
    this.$get = function () {
      return function () {
        return new B.XMLHttpRequest();
      };
    };
  }
  function Mf() {
    this.$get = [
      "$browser",
      "$jsonpCallbacks",
      "$document",
      "$xhrFactory",
      function (a, b, d, c) {
        return Gg(a, c, a.defer, b, d[0]);
      },
    ];
  }
  function Gg(a, b, d, c, e) {
    function f(a, b, d) {
      a = a.replace("JSON_CALLBACK", b);
      var f = e.createElement("script"),
        m = null;
      f.type = "text/javascript";
      f.src = a;
      f.async = !0;
      m = function (a) {
        f.removeEventListener("load", m);
        f.removeEventListener("error", m);
        e.body.removeChild(f);
        f = null;
        var g = -1,
          s = "unknown";
        a &&
          ("load" !== a.type || c.wasCalled(b) || (a = { type: "error" }),
          (s = a.type),
          (g = "error" === a.type ? 404 : 200));
        d && d(g, s);
      };
      f.addEventListener("load", m);
      f.addEventListener("error", m);
      e.body.appendChild(f);
      return m;
    }
    return function (e, k, h, l, m, q, n, s, t, u) {
      function D(a) {
        G = "timeout" === a;
        Z && Z();
        E && E.abort();
      }
      function w(a, b, c, e, f, g) {
        v(H) && d.cancel(H);
        Z = E = null;
        a(b, c, e, f, g);
      }
      k = k || a.url();
      if ("jsonp" === O(e))
        var p = c.createCallback(k),
          Z = f(k, p, function (a, b) {
            var d = 200 === a && c.getResponse(p);
            w(l, a, d, "", b, "complete");
            c.removeCallback(p);
          });
      else {
        var E = b(e, k),
          G = !1;
        E.open(e, k, !0);
        r(m, function (a, b) {
          v(a) && E.setRequestHeader(b, a);
        });
        E.onload = function () {
          var a = E.statusText || "",
            b = "response" in E ? E.response : E.responseText,
            c = 1223 === E.status ? 204 : E.status;
          0 === c && (c = b ? 200 : "file" === la(k).protocol ? 404 : 0);
          w(l, c, b, E.getAllResponseHeaders(), a, "complete");
        };
        E.onerror = function () {
          w(l, -1, null, null, "", "error");
        };
        E.ontimeout = function () {
          w(l, -1, null, null, "", "timeout");
        };
        E.onabort = function () {
          w(l, -1, null, null, "", G ? "timeout" : "abort");
        };
        r(t, function (a, b) {
          E.addEventListener(b, a);
        });
        r(u, function (a, b) {
          E.upload.addEventListener(b, a);
        });
        n && (E.withCredentials = !0);
        if (s)
          try {
            E.responseType = s;
          } catch (J) {
            if ("json" !== s) throw J;
          }
        E.send(x(h) ? null : h);
      }
      if (0 < q)
        var H = d(function () {
          D("timeout");
        }, q);
      else
        q &&
          z(q.then) &&
          q.then(function () {
            D(v(q.$$timeoutId) ? "timeout" : "abort");
          });
    };
  }
  function Gf() {
    var a = "{{",
      b = "}}";
    this.startSymbol = function (b) {
      return b ? ((a = b), this) : a;
    };
    this.endSymbol = function (a) {
      return a ? ((b = a), this) : b;
    };
    this.$get = [
      "$parse",
      "$exceptionHandler",
      "$sce",
      function (d, c, e) {
        function f(a) {
          return "\\\\\\" + a;
        }
        function g(c) {
          return c.replace(q, a).replace(n, b);
        }
        function k(a, b, c, d) {
          var e = a.$watch(
            function (a) {
              e();
              return d(a);
            },
            b,
            c
          );
          return e;
        }
        function h(f, h, n, q) {
          function w(a) {
            try {
              return (
                (a = n && !r ? e.getTrusted(n, a) : e.valueOf(a)),
                q && !v(a) ? a : hc(a)
              );
            } catch (b) {
              c(Ca.interr(f, b));
            }
          }
          var r = n === e.URL || n === e.MEDIA_URL;
          if (!f.length || -1 === f.indexOf(a)) {
            if (h && !r) return;
            h = g(f);
            r && (h = e.getTrusted(n, h));
            h = ia(h);
            h.exp = f;
            h.expressions = [];
            h.$$watchDelegate = k;
            return h;
          }
          q = !!q;
          for (
            var p, E, G = 0, J = [], H, X = f.length, K = [], L = [], P;
            G < X;

          )
            if (
              -1 !== (p = f.indexOf(a, G)) &&
              -1 !== (E = f.indexOf(b, p + l))
            )
              G !== p && K.push(g(f.substring(G, p))),
                (G = f.substring(p + l, E)),
                J.push(G),
                (G = E + m),
                L.push(K.length),
                K.push("");
            else {
              G !== X && K.push(g(f.substring(G)));
              break;
            }
          P = 1 === K.length && 1 === L.length;
          var Q = r && P ? void 0 : w;
          H = J.map(function (a) {
            return d(a, Q);
          });
          if (!h || J.length) {
            var y = function (a) {
              for (var b = 0, c = J.length; b < c; b++) {
                if (q && x(a[b])) return;
                K[L[b]] = a[b];
              }
              if (r) return e.getTrusted(n, P ? K[0] : K.join(""));
              n && 1 < K.length && Ca.throwNoconcat(f);
              return K.join("");
            };
            return R(
              function (a) {
                var b = 0,
                  d = J.length,
                  e = Array(d);
                try {
                  for (; b < d; b++) e[b] = H[b](a);
                  return y(e);
                } catch (g) {
                  c(Ca.interr(f, g));
                }
              },
              {
                exp: f,
                expressions: J,
                $$watchDelegate: function (a, b) {
                  var c;
                  return a.$watchGroup(H, function (d, e) {
                    var f = y(d);
                    b.call(this, f, d !== e ? c : f, a);
                    c = f;
                  });
                },
              }
            );
          }
        }
        var l = a.length,
          m = b.length,
          q = new RegExp(a.replace(/./g, f), "g"),
          n = new RegExp(b.replace(/./g, f), "g");
        h.startSymbol = function () {
          return a;
        };
        h.endSymbol = function () {
          return b;
        };
        return h;
      },
    ];
  }
  function Hf() {
    this.$get = [
      "$$intervalFactory",
      "$window",
      function (a, b) {
        var d = {},
          c = function (a) {
            b.clearInterval(a);
            delete d[a];
          },
          e = a(function (a, c, e) {
            a = b.setInterval(a, c);
            d[a] = e;
            return a;
          }, c);
        e.cancel = function (a) {
          if (!a) return !1;
          if (!a.hasOwnProperty("$$intervalId")) throw Hg("badprom");
          if (!d.hasOwnProperty(a.$$intervalId)) return !1;
          a = a.$$intervalId;
          var b = d[a];
          b.promise.$$state.pur = !0;
          b.reject("canceled");
          c(a);
          return !0;
        };
        return e;
      },
    ];
  }
  function If() {
    this.$get = [
      "$browser",
      "$q",
      "$$q",
      "$rootScope",
      function (a, b, d, c) {
        return function (e, f) {
          return function (g, k, h, l) {
            function m() {
              q ? g.apply(null, n) : g(s);
            }
            var q = 4 < arguments.length,
              n = q ? Ga.call(arguments, 4) : [],
              s = 0,
              t = v(l) && !l,
              u = (t ? d : b).defer(),
              D = u.promise;
            h = v(h) ? h : 0;
            D.$$intervalId = e(
              function () {
                t ? a.defer(m) : c.$evalAsync(m);
                u.notify(s++);
                0 < h && s >= h && (u.resolve(s), f(D.$$intervalId));
                t || c.$apply();
              },
              k,
              u,
              t
            );
            return D;
          };
        };
      },
    ];
  }
  function zd(a, b) {
    var d = la(a);
    b.$$protocol = d.protocol;
    b.$$host = d.hostname;
    b.$$port = da(d.port) || Ig[d.protocol] || null;
  }
  function Ad(a, b, d) {
    if (Jg.test(a)) throw jb("badpath", a);
    var c = "/" !== a.charAt(0);
    c && (a = "/" + a);
    a = la(a);
    for (
      var c = (c && "/" === a.pathname.charAt(0)
          ? a.pathname.substring(1)
          : a.pathname
        ).split("/"),
        e = c.length;
      e--;

    )
      (c[e] = decodeURIComponent(c[e])),
        d && (c[e] = c[e].replace(/\//g, "%2F"));
    d = c.join("/");
    b.$$path = d;
    b.$$search = fc(a.search);
    b.$$hash = decodeURIComponent(a.hash);
    b.$$path && "/" !== b.$$path.charAt(0) && (b.$$path = "/" + b.$$path);
  }
  function wc(a, b) {
    return a.slice(0, b.length) === b;
  }
  function wa(a, b) {
    if (wc(b, a)) return b.substr(a.length);
  }
  function qa(a) {
    var b = a.indexOf("#");
    return -1 === b ? a : a.substr(0, b);
  }
  function xc(a, b, d) {
    this.$$html5 = !0;
    d = d || "";
    zd(a, this);
    this.$$parse = function (a) {
      var d = wa(b, a);
      if (!C(d)) throw jb("ipthprfx", a, b);
      Ad(d, this, !0);
      this.$$path || (this.$$path = "/");
      this.$$compose();
    };
    this.$$normalizeUrl = function (a) {
      return b + a.substr(1);
    };
    this.$$parseLinkUrl = function (c, e) {
      if (e && "#" === e[0]) return this.hash(e.slice(1)), !0;
      var f, g;
      v((f = wa(a, c)))
        ? ((g = f),
          (g = d && v((f = wa(d, f))) ? b + (wa("/", f) || f) : a + g))
        : v((f = wa(b, c)))
        ? (g = b + f)
        : b === c + "/" && (g = b);
      g && this.$$parse(g);
      return !!g;
    };
  }
  function yc(a, b, d) {
    zd(a, this);
    this.$$parse = function (c) {
      var e = wa(a, c) || wa(b, c),
        f;
      x(e) || "#" !== e.charAt(0)
        ? this.$$html5
          ? (f = e)
          : ((f = ""), x(e) && ((a = c), this.replace()))
        : ((f = wa(d, e)), x(f) && (f = e));
      Ad(f, this, !1);
      c = this.$$path;
      var e = a,
        g = /^\/[A-Z]:(\/.*)/;
      wc(f, e) && (f = f.replace(e, ""));
      g.exec(f) || (c = (f = g.exec(c)) ? f[1] : c);
      this.$$path = c;
      this.$$compose();
    };
    this.$$normalizeUrl = function (b) {
      return a + (b ? d + b : "");
    };
    this.$$parseLinkUrl = function (b, d) {
      return qa(a) === qa(b) ? (this.$$parse(b), !0) : !1;
    };
  }
  function Bd(a, b, d) {
    this.$$html5 = !0;
    yc.apply(this, arguments);
    this.$$parseLinkUrl = function (c, e) {
      if (e && "#" === e[0]) return this.hash(e.slice(1)), !0;
      var f, g;
      a === qa(c)
        ? (f = c)
        : (g = wa(b, c))
        ? (f = a + d + g)
        : b === c + "/" && (f = b);
      f && this.$$parse(f);
      return !!f;
    };
    this.$$normalizeUrl = function (b) {
      return a + d + b;
    };
  }
  function Lb(a) {
    return function () {
      return this[a];
    };
  }
  function Cd(a, b) {
    return function (d) {
      if (x(d)) return this[a];
      this[a] = b(d);
      this.$$compose();
      return this;
    };
  }
  function Pf() {
    var a = "!",
      b = { enabled: !1, requireBase: !0, rewriteLinks: !0 };
    this.hashPrefix = function (b) {
      return v(b) ? ((a = b), this) : a;
    };
    this.html5Mode = function (a) {
      if (Fa(a)) return (b.enabled = a), this;
      if (F(a)) {
        Fa(a.enabled) && (b.enabled = a.enabled);
        Fa(a.requireBase) && (b.requireBase = a.requireBase);
        if (Fa(a.rewriteLinks) || C(a.rewriteLinks))
          b.rewriteLinks = a.rewriteLinks;
        return this;
      }
      return b;
    };
    this.$get = [
      "$rootScope",
      "$browser",
      "$sniffer",
      "$rootElement",
      "$window",
      function (d, c, e, f, g) {
        function k(a, b) {
          return a === b || la(a).href === la(b).href;
        }
        function h(a, b, d) {
          var e = m.url(),
            f = m.$$state;
          try {
            c.url(a, b, d), (m.$$state = c.state());
          } catch (g) {
            throw (m.url(e), (m.$$state = f), g);
          }
        }
        function l(a, b) {
          d.$broadcast("$locationChangeSuccess", m.absUrl(), a, m.$$state, b);
        }
        var m, q;
        q = c.baseHref();
        var n = c.url(),
          s;
        if (b.enabled) {
          if (!q && b.requireBase) throw jb("nobase");
          s = n.substring(0, n.indexOf("/", n.indexOf("//") + 2)) + (q || "/");
          q = e.history ? xc : Bd;
        } else (s = qa(n)), (q = yc);
        var t = s.substr(0, qa(s).lastIndexOf("/") + 1);
        m = new q(s, t, "#" + a);
        m.$$parseLinkUrl(n, n);
        m.$$state = c.state();
        var u = /^\s*(javascript|mailto):/i;
        f.on("click", function (a) {
          var e = b.rewriteLinks;
          if (
            e &&
            !a.ctrlKey &&
            !a.metaKey &&
            !a.shiftKey &&
            2 !== a.which &&
            2 !== a.button
          ) {
            for (var g = y(a.target); "a" !== ta(g[0]); )
              if (g[0] === f[0] || !(g = g.parent())[0]) return;
            if (!C(e) || !x(g.attr(e))) {
              var e = g.prop("href"),
                h = g.attr("href") || g.attr("xlink:href");
              F(e) &&
                "[object SVGAnimatedString]" === e.toString() &&
                (e = la(e.animVal).href);
              u.test(e) ||
                !e ||
                g.attr("target") ||
                a.isDefaultPrevented() ||
                !m.$$parseLinkUrl(e, h) ||
                (a.preventDefault(), m.absUrl() !== c.url() && d.$apply());
            }
          }
        });
        m.absUrl() !== n && c.url(m.absUrl(), !0);
        var D = !0;
        c.onUrlChange(function (a, b) {
          wc(a, t)
            ? (d.$evalAsync(function () {
                var c = m.absUrl(),
                  e = m.$$state,
                  f;
                m.$$parse(a);
                m.$$state = b;
                f = d.$broadcast("$locationChangeStart", a, c, b, e)
                  .defaultPrevented;
                m.absUrl() === a &&
                  (f
                    ? (m.$$parse(c), (m.$$state = e), h(c, !1, e))
                    : ((D = !1), l(c, e)));
              }),
              d.$$phase || d.$digest())
            : (g.location.href = a);
        });
        d.$watch(function () {
          if (D || m.$$urlUpdatedByLocation) {
            m.$$urlUpdatedByLocation = !1;
            var a = c.url(),
              b = m.absUrl(),
              f = c.state(),
              g = m.$$replace,
              n = !k(a, b) || (m.$$html5 && e.history && f !== m.$$state);
            if (D || n)
              (D = !1),
                d.$evalAsync(function () {
                  var b = m.absUrl(),
                    c = d.$broadcast("$locationChangeStart", b, a, m.$$state, f)
                      .defaultPrevented;
                  m.absUrl() === b &&
                    (c
                      ? (m.$$parse(a), (m.$$state = f))
                      : (n && h(b, g, f === m.$$state ? null : m.$$state),
                        l(a, f)));
                });
          }
          m.$$replace = !1;
        });
        return m;
      },
    ];
  }
  function Qf() {
    var a = !0,
      b = this;
    this.debugEnabled = function (b) {
      return v(b) ? ((a = b), this) : a;
    };
    this.$get = [
      "$window",
      function (d) {
        function c(a) {
          bc(a) &&
            (a.stack && f
              ? (a =
                  a.message && -1 === a.stack.indexOf(a.message)
                    ? "Error: " + a.message + "\n" + a.stack
                    : a.stack)
              : a.sourceURL &&
                (a = a.message + "\n" + a.sourceURL + ":" + a.line));
          return a;
        }
        function e(a) {
          var b = d.console || {},
            e = b[a] || b.log || A;
          return function () {
            var a = [];
            r(arguments, function (b) {
              a.push(c(b));
            });
            return Function.prototype.apply.call(e, b, a);
          };
        }
        var f = Aa || /\bEdge\//.test(d.navigator && d.navigator.userAgent);
        return {
          log: e("log"),
          info: e("info"),
          warn: e("warn"),
          error: e("error"),
          debug: (function () {
            var c = e("debug");
            return function () {
              a && c.apply(b, arguments);
            };
          })(),
        };
      },
    ];
  }
  function Kg(a) {
    return a + "";
  }
  function Lg(a, b) {
    return "undefined" !== typeof a ? a : b;
  }
  function Dd(a, b) {
    return "undefined" === typeof a ? b : "undefined" === typeof b ? a : a + b;
  }
  function Mg(a, b) {
    switch (a.type) {
      case p.MemberExpression:
        if (a.computed) return !1;
        break;
      case p.UnaryExpression:
        return 1;
      case p.BinaryExpression:
        return "+" !== a.operator ? 1 : !1;
      case p.CallExpression:
        return !1;
    }
    return void 0 === b ? Ed : b;
  }
  function Y(a, b, d) {
    var c,
      e,
      f = (a.isPure = Mg(a, d));
    switch (a.type) {
      case p.Program:
        c = !0;
        r(a.body, function (a) {
          Y(a.expression, b, f);
          c = c && a.expression.constant;
        });
        a.constant = c;
        break;
      case p.Literal:
        a.constant = !0;
        a.toWatch = [];
        break;
      case p.UnaryExpression:
        Y(a.argument, b, f);
        a.constant = a.argument.constant;
        a.toWatch = a.argument.toWatch;
        break;
      case p.BinaryExpression:
        Y(a.left, b, f);
        Y(a.right, b, f);
        a.constant = a.left.constant && a.right.constant;
        a.toWatch = a.left.toWatch.concat(a.right.toWatch);
        break;
      case p.LogicalExpression:
        Y(a.left, b, f);
        Y(a.right, b, f);
        a.constant = a.left.constant && a.right.constant;
        a.toWatch = a.constant ? [] : [a];
        break;
      case p.ConditionalExpression:
        Y(a.test, b, f);
        Y(a.alternate, b, f);
        Y(a.consequent, b, f);
        a.constant =
          a.test.constant && a.alternate.constant && a.consequent.constant;
        a.toWatch = a.constant ? [] : [a];
        break;
      case p.Identifier:
        a.constant = !1;
        a.toWatch = [a];
        break;
      case p.MemberExpression:
        Y(a.object, b, f);
        a.computed && Y(a.property, b, f);
        a.constant = a.object.constant && (!a.computed || a.property.constant);
        a.toWatch = a.constant ? [] : [a];
        break;
      case p.CallExpression:
        c = d = a.filter ? !b(a.callee.name).$stateful : !1;
        e = [];
        r(a.arguments, function (a) {
          Y(a, b, f);
          c = c && a.constant;
          e.push.apply(e, a.toWatch);
        });
        a.constant = c;
        a.toWatch = d ? e : [a];
        break;
      case p.AssignmentExpression:
        Y(a.left, b, f);
        Y(a.right, b, f);
        a.constant = a.left.constant && a.right.constant;
        a.toWatch = [a];
        break;
      case p.ArrayExpression:
        c = !0;
        e = [];
        r(a.elements, function (a) {
          Y(a, b, f);
          c = c && a.constant;
          e.push.apply(e, a.toWatch);
        });
        a.constant = c;
        a.toWatch = e;
        break;
      case p.ObjectExpression:
        c = !0;
        e = [];
        r(a.properties, function (a) {
          Y(a.value, b, f);
          c = c && a.value.constant;
          e.push.apply(e, a.value.toWatch);
          a.computed &&
            (Y(a.key, b, !1),
            (c = c && a.key.constant),
            e.push.apply(e, a.key.toWatch));
        });
        a.constant = c;
        a.toWatch = e;
        break;
      case p.ThisExpression:
        a.constant = !1;
        a.toWatch = [];
        break;
      case p.LocalsExpression:
        (a.constant = !1), (a.toWatch = []);
    }
  }
  function Fd(a) {
    if (1 === a.length) {
      a = a[0].expression;
      var b = a.toWatch;
      return 1 !== b.length ? b : b[0] !== a ? b : void 0;
    }
  }
  function Gd(a) {
    return a.type === p.Identifier || a.type === p.MemberExpression;
  }
  function Hd(a) {
    if (1 === a.body.length && Gd(a.body[0].expression))
      return {
        type: p.AssignmentExpression,
        left: a.body[0].expression,
        right: { type: p.NGValueParameter },
        operator: "=",
      };
  }
  function Id(a) {
    this.$filter = a;
  }
  function Jd(a) {
    this.$filter = a;
  }
  function Mb(a, b, d) {
    this.ast = new p(a, d);
    this.astCompiler = d.csp ? new Jd(b) : new Id(b);
  }
  function zc(a) {
    return z(a.valueOf) ? a.valueOf() : Ng.call(a);
  }
  function Rf() {
    var a = S(),
      b = { true: !0, false: !1, null: null, undefined: void 0 },
      d,
      c;
    this.addLiteral = function (a, c) {
      b[a] = c;
    };
    this.setIdentifierFns = function (a, b) {
      d = a;
      c = b;
      return this;
    };
    this.$get = [
      "$filter",
      function (e) {
        function f(b, c) {
          var d, f;
          switch (typeof b) {
            case "string":
              return (
                (f = b = b.trim()),
                (d = a[f]),
                d ||
                  ((d = new Nb(t)),
                  (d = new Mb(d, e, t).parse(b)),
                  (a[f] = q(d))),
                s(d, c)
              );
            case "function":
              return s(b, c);
            default:
              return s(A, c);
          }
        }
        function g(a, b, c) {
          return null == a || null == b
            ? a === b
            : "object" !== typeof a || ((a = zc(a)), "object" !== typeof a || c)
            ? a === b || (a !== a && b !== b)
            : !1;
        }
        function k(a, b, c, d, e) {
          var f = d.inputs,
            h;
          if (1 === f.length) {
            var k = g,
              f = f[0];
            return a.$watch(
              function (a) {
                var b = f(a);
                g(b, k, f.isPure) ||
                  ((h = d(a, void 0, void 0, [b])), (k = b && zc(b)));
                return h;
              },
              b,
              c,
              e
            );
          }
          for (var l = [], m = [], n = 0, q = f.length; n < q; n++)
            (l[n] = g), (m[n] = null);
          return a.$watch(
            function (a) {
              for (var b = !1, c = 0, e = f.length; c < e; c++) {
                var k = f[c](a);
                if (b || (b = !g(k, l[c], f[c].isPure)))
                  (m[c] = k), (l[c] = k && zc(k));
              }
              b && (h = d(a, void 0, void 0, m));
              return h;
            },
            b,
            c,
            e
          );
        }
        function h(a, b, c, d, e) {
          function f() {
            h(m) && k();
          }
          function g(a, b, c, d) {
            m = s && d ? d[0] : n(a, b, c, d);
            h(m) && a.$$postDigest(f);
            return t(m);
          }
          var h = d.literal ? l : v,
            k,
            m,
            n = d.$$intercepted || d,
            t = d.$$interceptor || Ta,
            s = d.inputs && !n.inputs;
          g.literal = d.literal;
          g.constant = d.constant;
          g.inputs = d.inputs;
          q(g);
          return (k = a.$watch(g, b, c, e));
        }
        function l(a) {
          var b = !0;
          r(a, function (a) {
            v(a) || (b = !1);
          });
          return b;
        }
        function m(a, b, c, d) {
          var e = a.$watch(
            function (a) {
              e();
              return d(a);
            },
            b,
            c
          );
          return e;
        }
        function q(a) {
          a.constant
            ? (a.$$watchDelegate = m)
            : a.oneTime
            ? (a.$$watchDelegate = h)
            : a.inputs && (a.$$watchDelegate = k);
          return a;
        }
        function n(a, b) {
          function c(d) {
            return b(a(d));
          }
          c.$stateful = a.$stateful || b.$stateful;
          c.$$pure = a.$$pure && b.$$pure;
          return c;
        }
        function s(a, b) {
          if (!b) return a;
          a.$$interceptor &&
            ((b = n(a.$$interceptor, b)), (a = a.$$intercepted));
          var c = !1,
            d = function (d, e, f, g) {
              d = c && g ? g[0] : a(d, e, f, g);
              return b(d);
            };
          d.$$intercepted = a;
          d.$$interceptor = b;
          d.literal = a.literal;
          d.oneTime = a.oneTime;
          d.constant = a.constant;
          b.$stateful ||
            ((c = !a.inputs),
            (d.inputs = a.inputs ? a.inputs : [a]),
            b.$$pure ||
              (d.inputs = d.inputs.map(function (a) {
                return a.isPure === Ed
                  ? function (b) {
                      return a(b);
                    }
                  : a;
              })));
          return q(d);
        }
        var t = {
          csp: pa().noUnsafeEval,
          literals: Ha(b),
          isIdentifierStart: z(d) && d,
          isIdentifierContinue: z(c) && c,
        };
        f.$$getAst = function (a) {
          var b = new Nb(t);
          return new Mb(b, e, t).getAst(a).ast;
        };
        return f;
      },
    ];
  }
  function Tf() {
    var a = !0;
    this.$get = [
      "$rootScope",
      "$exceptionHandler",
      function (b, d) {
        return Kd(
          function (a) {
            b.$evalAsync(a);
          },
          d,
          a
        );
      },
    ];
    this.errorOnUnhandledRejections = function (b) {
      return v(b) ? ((a = b), this) : a;
    };
  }
  function Uf() {
    var a = !0;
    this.$get = [
      "$browser",
      "$exceptionHandler",
      function (b, d) {
        return Kd(
          function (a) {
            b.defer(a);
          },
          d,
          a
        );
      },
    ];
    this.errorOnUnhandledRejections = function (b) {
      return v(b) ? ((a = b), this) : a;
    };
  }
  function Kd(a, b, d) {
    function c() {
      return new e();
    }
    function e() {
      var a = (this.promise = new f());
      this.resolve = function (b) {
        h(a, b);
      };
      this.reject = function (b) {
        m(a, b);
      };
      this.notify = function (b) {
        n(a, b);
      };
    }
    function f() {
      this.$$state = { status: 0 };
    }
    function g() {
      for (; !v && Z.length; ) {
        var a = Z.shift();
        if (!a.pur) {
          a.pur = !0;
          var c = a.value,
            c =
              "Possibly unhandled rejection: " +
              ("function" === typeof c
                ? c.toString().replace(/ \{[\s\S]*$/, "")
                : x(c)
                ? "undefined"
                : "string" !== typeof c
                ? Fe(c, void 0)
                : c);
          bc(a.value) ? b(a.value, c) : b(c);
        }
      }
    }
    function k(c) {
      !d ||
        c.pending ||
        2 !== c.status ||
        c.pur ||
        (0 === v && 0 === Z.length && a(g), Z.push(c));
      !c.processScheduled &&
        c.pending &&
        ((c.processScheduled = !0),
        ++v,
        a(function () {
          var e, f, k;
          k = c.pending;
          c.processScheduled = !1;
          c.pending = void 0;
          try {
            for (var l = 0, n = k.length; l < n; ++l) {
              c.pur = !0;
              f = k[l][0];
              e = k[l][c.status];
              try {
                z(e)
                  ? h(f, e(c.value))
                  : 1 === c.status
                  ? h(f, c.value)
                  : m(f, c.value);
              } catch (q) {
                m(f, q), q && !0 === q.$$passToExceptionHandler && b(q);
              }
            }
          } finally {
            --v, d && 0 === v && a(g);
          }
        }));
    }
    function h(a, b) {
      a.$$state.status || (b === a ? q(a, w("qcycle", b)) : l(a, b));
    }
    function l(a, b) {
      function c(b) {
        g || ((g = !0), l(a, b));
      }
      function d(b) {
        g || ((g = !0), q(a, b));
      }
      function e(b) {
        n(a, b);
      }
      var f,
        g = !1;
      try {
        if (F(b) || z(b)) f = b.then;
        z(f)
          ? ((a.$$state.status = -1), f.call(b, c, d, e))
          : ((a.$$state.value = b), (a.$$state.status = 1), k(a.$$state));
      } catch (h) {
        d(h);
      }
    }
    function m(a, b) {
      a.$$state.status || q(a, b);
    }
    function q(a, b) {
      a.$$state.value = b;
      a.$$state.status = 2;
      k(a.$$state);
    }
    function n(c, d) {
      var e = c.$$state.pending;
      0 >= c.$$state.status &&
        e &&
        e.length &&
        a(function () {
          for (var a, c, f = 0, g = e.length; f < g; f++) {
            c = e[f][0];
            a = e[f][3];
            try {
              n(c, z(a) ? a(d) : d);
            } catch (h) {
              b(h);
            }
          }
        });
    }
    function s(a) {
      var b = new f();
      m(b, a);
      return b;
    }
    function t(a, b, c) {
      var d = null;
      try {
        z(c) && (d = c());
      } catch (e) {
        return s(e);
      }
      return d && z(d.then)
        ? d.then(function () {
            return b(a);
          }, s)
        : b(a);
    }
    function u(a, b, c, d) {
      var e = new f();
      h(e, a);
      return e.then(b, c, d);
    }
    function p(a) {
      if (!z(a)) throw w("norslvr", a);
      var b = new f();
      a(
        function (a) {
          h(b, a);
        },
        function (a) {
          m(b, a);
        }
      );
      return b;
    }
    var w = M("$q", TypeError),
      v = 0,
      Z = [];
    R(f.prototype, {
      then: function (a, b, c) {
        if (x(a) && x(b) && x(c)) return this;
        var d = new f();
        this.$$state.pending = this.$$state.pending || [];
        this.$$state.pending.push([d, a, b, c]);
        0 < this.$$state.status && k(this.$$state);
        return d;
      },
      catch: function (a) {
        return this.then(null, a);
      },
      finally: function (a, b) {
        return this.then(
          function (b) {
            return t(b, E, a);
          },
          function (b) {
            return t(b, s, a);
          },
          b
        );
      },
    });
    var E = u;
    p.prototype = f.prototype;
    p.defer = c;
    p.reject = s;
    p.when = u;
    p.resolve = E;
    p.all = function (a) {
      var b = new f(),
        c = 0,
        d = I(a) ? [] : {};
      r(a, function (a, e) {
        c++;
        u(a).then(
          function (a) {
            d[e] = a;
            --c || h(b, d);
          },
          function (a) {
            m(b, a);
          }
        );
      });
      0 === c && h(b, d);
      return b;
    };
    p.race = function (a) {
      var b = c();
      r(a, function (a) {
        u(a).then(b.resolve, b.reject);
      });
      return b.promise;
    };
    return p;
  }
  function dg() {
    this.$get = [
      "$window",
      "$timeout",
      function (a, b) {
        var d = a.requestAnimationFrame || a.webkitRequestAnimationFrame,
          c =
            a.cancelAnimationFrame ||
            a.webkitCancelAnimationFrame ||
            a.webkitCancelRequestAnimationFrame,
          e = !!d,
          f = e
            ? function (a) {
                var b = d(a);
                return function () {
                  c(b);
                };
              }
            : function (a) {
                var c = b(a, 16.66, !1);
                return function () {
                  b.cancel(c);
                };
              };
        f.supported = e;
        return f;
      },
    ];
  }
  function Sf() {
    function a(a) {
      function b() {
        this.$$watchers = this.$$nextSibling = this.$$childHead = this.$$childTail = null;
        this.$$listeners = {};
        this.$$listenerCount = {};
        this.$$watchersCount = 0;
        this.$id = ++pb;
        this.$$ChildScope = null;
        this.$$suspended = !1;
      }
      b.prototype = a;
      return b;
    }
    var b = 10,
      d = M("$rootScope"),
      c = null,
      e = null;
    this.digestTtl = function (a) {
      arguments.length && (b = a);
      return b;
    };
    this.$get = [
      "$exceptionHandler",
      "$parse",
      "$browser",
      function (f, g, k) {
        function h(a) {
          a.currentScope.$$destroyed = !0;
        }
        function l(a) {
          9 === Aa &&
            (a.$$childHead && l(a.$$childHead),
            a.$$nextSibling && l(a.$$nextSibling));
          a.$parent = a.$$nextSibling = a.$$prevSibling = a.$$childHead = a.$$childTail = a.$root = a.$$watchers = null;
        }
        function m() {
          this.$id = ++pb;
          this.$$phase = this.$parent = this.$$watchers = this.$$nextSibling = this.$$prevSibling = this.$$childHead = this.$$childTail = null;
          this.$root = this;
          this.$$suspended = this.$$destroyed = !1;
          this.$$listeners = {};
          this.$$listenerCount = {};
          this.$$watchersCount = 0;
          this.$$isolateBindings = null;
        }
        function q(a) {
          if (w.$$phase) throw d("inprog", w.$$phase);
          w.$$phase = a;
        }
        function n(a, b) {
          do a.$$watchersCount += b;
          while ((a = a.$parent));
        }
        function s(a, b, c) {
          do
            (a.$$listenerCount[c] -= b),
              0 === a.$$listenerCount[c] && delete a.$$listenerCount[c];
          while ((a = a.$parent));
        }
        function t() {}
        function u() {
          for (; E.length; )
            try {
              E.shift()();
            } catch (a) {
              f(a);
            }
          e = null;
        }
        function p() {
          null === e &&
            (e = k.defer(
              function () {
                w.$apply(u);
              },
              null,
              "$applyAsync"
            ));
        }
        m.prototype = {
          constructor: m,
          $new: function (b, c) {
            var d;
            c = c || this;
            b
              ? ((d = new m()), (d.$root = this.$root))
              : (this.$$ChildScope || (this.$$ChildScope = a(this)),
                (d = new this.$$ChildScope()));
            d.$parent = c;
            d.$$prevSibling = c.$$childTail;
            c.$$childHead
              ? ((c.$$childTail.$$nextSibling = d), (c.$$childTail = d))
              : (c.$$childHead = c.$$childTail = d);
            (b || c !== this) && d.$on("$destroy", h);
            return d;
          },
          $watch: function (a, b, d, e) {
            var f = g(a);
            b = z(b) ? b : A;
            if (f.$$watchDelegate) return f.$$watchDelegate(this, b, d, f, a);
            var h = this,
              k = h.$$watchers,
              l = { fn: b, last: t, get: f, exp: e || a, eq: !!d };
            c = null;
            k || ((k = h.$$watchers = []), (k.$$digestWatchIndex = -1));
            k.unshift(l);
            k.$$digestWatchIndex++;
            n(this, 1);
            return function () {
              var a = cb(k, l);
              0 <= a &&
                (n(h, -1), a < k.$$digestWatchIndex && k.$$digestWatchIndex--);
              c = null;
            };
          },
          $watchGroup: function (a, b) {
            function c() {
              h = !1;
              try {
                k ? ((k = !1), b(e, e, g)) : b(e, d, g);
              } finally {
                for (var f = 0; f < a.length; f++) d[f] = e[f];
              }
            }
            var d = Array(a.length),
              e = Array(a.length),
              f = [],
              g = this,
              h = !1,
              k = !0;
            if (!a.length) {
              var l = !0;
              g.$evalAsync(function () {
                l && b(e, e, g);
              });
              return function () {
                l = !1;
              };
            }
            if (1 === a.length)
              return this.$watch(a[0], function (a, c, f) {
                e[0] = a;
                d[0] = c;
                b(e, a === c ? e : d, f);
              });
            r(a, function (a, b) {
              var d = g.$watch(a, function (a) {
                e[b] = a;
                h || ((h = !0), g.$evalAsync(c));
              });
              f.push(d);
            });
            return function () {
              for (; f.length; ) f.shift()();
            };
          },
          $watchCollection: function (a, b) {
            function c(a) {
              e = a;
              var b, d, g, h;
              if (!x(e)) {
                if (F(e))
                  if (xa(e))
                    for (
                      f !== n && ((f = n), (s = f.length = 0), l++),
                        a = e.length,
                        s !== a && (l++, (f.length = s = a)),
                        b = 0;
                      b < a;
                      b++
                    )
                      (h = f[b]),
                        (g = e[b]),
                        (d = h !== h && g !== g),
                        d || h === g || (l++, (f[b] = g));
                  else {
                    f !== q && ((f = q = {}), (s = 0), l++);
                    a = 0;
                    for (b in e)
                      sa.call(e, b) &&
                        (a++,
                        (g = e[b]),
                        (h = f[b]),
                        b in f
                          ? ((d = h !== h && g !== g),
                            d || h === g || (l++, (f[b] = g)))
                          : (s++, (f[b] = g), l++));
                    if (s > a)
                      for (b in (l++, f)) sa.call(e, b) || (s--, delete f[b]);
                  }
                else f !== e && ((f = e), l++);
                return l;
              }
            }
            c.$$pure = g(a).literal;
            c.$stateful = !c.$$pure;
            var d = this,
              e,
              f,
              h,
              k = 1 < b.length,
              l = 0,
              m = g(a, c),
              n = [],
              q = {},
              t = !0,
              s = 0;
            return this.$watch(m, function () {
              t ? ((t = !1), b(e, e, d)) : b(e, h, d);
              if (k)
                if (F(e))
                  if (xa(e)) {
                    h = Array(e.length);
                    for (var a = 0; a < e.length; a++) h[a] = e[a];
                  } else
                    for (a in ((h = {}), e)) sa.call(e, a) && (h[a] = e[a]);
                else h = e;
            });
          },
          $digest: function () {
            var a,
              g,
              h,
              l,
              m,
              n,
              s,
              r = b,
              p,
              D = v.length ? w : this,
              E = [],
              x,
              y;
            q("$digest");
            k.$$checkUrlChange();
            this === w && null !== e && (k.defer.cancel(e), u());
            c = null;
            do {
              s = !1;
              p = D;
              for (n = 0; n < v.length; n++) {
                try {
                  (y = v[n]), (l = y.fn), l(y.scope, y.locals);
                } catch (C) {
                  f(C);
                }
                c = null;
              }
              v.length = 0;
              a: do {
                if ((n = !p.$$suspended && p.$$watchers))
                  for (
                    n.$$digestWatchIndex = n.length;
                    n.$$digestWatchIndex--;

                  )
                    try {
                      if ((a = n[n.$$digestWatchIndex]))
                        if (
                          ((m = a.get),
                          (g = m(p)) !== (h = a.last) &&
                            !(a.eq ? ua(g, h) : V(g) && V(h)))
                        )
                          (s = !0),
                            (c = a),
                            (a.last = a.eq ? Ha(g, null) : g),
                            (l = a.fn),
                            l(g, h === t ? g : h, p),
                            5 > r &&
                              ((x = 4 - r),
                              E[x] || (E[x] = []),
                              E[x].push({
                                msg: z(a.exp)
                                  ? "fn: " + (a.exp.name || a.exp.toString())
                                  : a.exp,
                                newVal: g,
                                oldVal: h,
                              }));
                        else if (a === c) {
                          s = !1;
                          break a;
                        }
                    } catch (B) {
                      f(B);
                    }
                if (
                  !(n =
                    (!p.$$suspended && p.$$watchersCount && p.$$childHead) ||
                    (p !== D && p.$$nextSibling))
                )
                  for (; p !== D && !(n = p.$$nextSibling); ) p = p.$parent;
              } while ((p = n));
              if ((s || v.length) && !r--)
                throw ((w.$$phase = null), d("infdig", b, E));
            } while (s || v.length);
            for (w.$$phase = null; G < Z.length; )
              try {
                Z[G++]();
              } catch (A) {
                f(A);
              }
            Z.length = G = 0;
            k.$$checkUrlChange();
          },
          $suspend: function () {
            this.$$suspended = !0;
          },
          $isSuspended: function () {
            return this.$$suspended;
          },
          $resume: function () {
            this.$$suspended = !1;
          },
          $destroy: function () {
            if (!this.$$destroyed) {
              var a = this.$parent;
              this.$broadcast("$destroy");
              this.$$destroyed = !0;
              this === w && k.$$applicationDestroyed();
              n(this, -this.$$watchersCount);
              for (var b in this.$$listenerCount)
                s(this, this.$$listenerCount[b], b);
              a &&
                a.$$childHead === this &&
                (a.$$childHead = this.$$nextSibling);
              a &&
                a.$$childTail === this &&
                (a.$$childTail = this.$$prevSibling);
              this.$$prevSibling &&
                (this.$$prevSibling.$$nextSibling = this.$$nextSibling);
              this.$$nextSibling &&
                (this.$$nextSibling.$$prevSibling = this.$$prevSibling);
              this.$destroy = this.$digest = this.$apply = this.$evalAsync = this.$applyAsync = A;
              this.$on = this.$watch = this.$watchGroup = function () {
                return A;
              };
              this.$$listeners = {};
              this.$$nextSibling = null;
              l(this);
            }
          },
          $eval: function (a, b) {
            return g(a)(this, b);
          },
          $evalAsync: function (a, b) {
            w.$$phase ||
              v.length ||
              k.defer(
                function () {
                  v.length && w.$digest();
                },
                null,
                "$evalAsync"
              );
            v.push({ scope: this, fn: g(a), locals: b });
          },
          $$postDigest: function (a) {
            Z.push(a);
          },
          $apply: function (a) {
            try {
              q("$apply");
              try {
                return this.$eval(a);
              } finally {
                w.$$phase = null;
              }
            } catch (b) {
              f(b);
            } finally {
              try {
                w.$digest();
              } catch (c) {
                throw (f(c), c);
              }
            }
          },
          $applyAsync: function (a) {
            function b() {
              c.$eval(a);
            }
            var c = this;
            a && E.push(b);
            a = g(a);
            p();
          },
          $on: function (a, b) {
            var c = this.$$listeners[a];
            c || (this.$$listeners[a] = c = []);
            c.push(b);
            var d = this;
            do
              d.$$listenerCount[a] || (d.$$listenerCount[a] = 0),
                d.$$listenerCount[a]++;
            while ((d = d.$parent));
            var e = this;
            return function () {
              var d = c.indexOf(b);
              -1 !== d && (delete c[d], s(e, 1, a));
            };
          },
          $emit: function (a, b) {
            var c = [],
              d,
              e = this,
              g = !1,
              h = {
                name: a,
                targetScope: e,
                stopPropagation: function () {
                  g = !0;
                },
                preventDefault: function () {
                  h.defaultPrevented = !0;
                },
                defaultPrevented: !1,
              },
              k = db([h], arguments, 1),
              l,
              m;
            do {
              d = e.$$listeners[a] || c;
              h.currentScope = e;
              l = 0;
              for (m = d.length; l < m; l++)
                if (d[l])
                  try {
                    d[l].apply(null, k);
                  } catch (n) {
                    f(n);
                  }
                else d.splice(l, 1), l--, m--;
              if (g) break;
              e = e.$parent;
            } while (e);
            h.currentScope = null;
            return h;
          },
          $broadcast: function (a, b) {
            var c = this,
              d = this,
              e = {
                name: a,
                targetScope: this,
                preventDefault: function () {
                  e.defaultPrevented = !0;
                },
                defaultPrevented: !1,
              };
            if (!this.$$listenerCount[a]) return e;
            for (var g = db([e], arguments, 1), h, k; (c = d); ) {
              e.currentScope = c;
              d = c.$$listeners[a] || [];
              h = 0;
              for (k = d.length; h < k; h++)
                if (d[h])
                  try {
                    d[h].apply(null, g);
                  } catch (l) {
                    f(l);
                  }
                else d.splice(h, 1), h--, k--;
              if (
                !(d =
                  (c.$$listenerCount[a] && c.$$childHead) ||
                  (c !== this && c.$$nextSibling))
              )
                for (; c !== this && !(d = c.$$nextSibling); ) c = c.$parent;
            }
            e.currentScope = null;
            return e;
          },
        };
        var w = new m(),
          v = (w.$$asyncQueue = []),
          Z = (w.$$postDigestQueue = []),
          E = (w.$$applyAsyncQueue = []),
          G = 0;
        return w;
      },
    ];
  }
  function Ie() {
    var a = /^\s*(https?|s?ftp|mailto|tel|file):/,
      b = /^\s*((https?|ftp|file|blob):|data:image\/)/;
    this.aHrefSanitizationWhitelist = function (b) {
      return v(b) ? ((a = b), this) : a;
    };
    this.imgSrcSanitizationWhitelist = function (a) {
      return v(a) ? ((b = a), this) : b;
    };
    this.$get = function () {
      return function (d, c) {
        var e = c ? b : a,
          f = la(d && d.trim()).href;
        return "" === f || f.match(e) ? d : "unsafe:" + f;
      };
    };
  }
  function Og(a) {
    if ("self" === a) return a;
    if (C(a)) {
      if (-1 < a.indexOf("***")) throw Da("iwcard", a);
      a = Ld(a)
        .replace(/\\\*\\\*/g, ".*")
        .replace(/\\\*/g, "[^:/.?&;]*");
      return new RegExp("^" + a + "$");
    }
    if (ab(a)) return new RegExp("^" + a.source + "$");
    throw Da("imatcher");
  }
  function Md(a) {
    var b = [];
    v(a) &&
      r(a, function (a) {
        b.push(Og(a));
      });
    return b;
  }
  function Wf() {
    this.SCE_CONTEXTS = U;
    var a = ["self"],
      b = [];
    this.resourceUrlWhitelist = function (b) {
      arguments.length && (a = Md(b));
      return a;
    };
    this.resourceUrlBlacklist = function (a) {
      arguments.length && (b = Md(a));
      return b;
    };
    this.$get = [
      "$injector",
      "$$sanitizeUri",
      function (d, c) {
        function e(a, b) {
          var c;
          "self" === a
            ? (c = Ac(b, Nd)) ||
              (B.document.baseURI
                ? (c = B.document.baseURI)
                : (La ||
                    ((La = B.document.createElement("a")),
                    (La.href = "."),
                    (La = La.cloneNode(!1))),
                  (c = La.href)),
              (c = Ac(b, c)))
            : (c = !!a.exec(b.href));
          return c;
        }
        function f(a) {
          var b = function (a) {
            this.$$unwrapTrustedValue = function () {
              return a;
            };
          };
          a && (b.prototype = new a());
          b.prototype.valueOf = function () {
            return this.$$unwrapTrustedValue();
          };
          b.prototype.toString = function () {
            return this.$$unwrapTrustedValue().toString();
          };
          return b;
        }
        var g = function (a) {
          throw Da("unsafe");
        };
        d.has("$sanitize") && (g = d.get("$sanitize"));
        var k = f(),
          h = {};
        h[U.HTML] = f(k);
        h[U.CSS] = f(k);
        h[U.MEDIA_URL] = f(k);
        h[U.URL] = f(h[U.MEDIA_URL]);
        h[U.JS] = f(k);
        h[U.RESOURCE_URL] = f(h[U.URL]);
        return {
          trustAs: function (a, b) {
            var c = h.hasOwnProperty(a) ? h[a] : null;
            if (!c) throw Da("icontext", a, b);
            if (null === b || x(b) || "" === b) return b;
            if ("string" !== typeof b) throw Da("itype", a);
            return new c(b);
          },
          getTrusted: function (d, f) {
            if (null === f || x(f) || "" === f) return f;
            var k = h.hasOwnProperty(d) ? h[d] : null;
            if (k && f instanceof k) return f.$$unwrapTrustedValue();
            z(f.$$unwrapTrustedValue) && (f = f.$$unwrapTrustedValue());
            if (d === U.MEDIA_URL || d === U.URL)
              return c(f.toString(), d === U.MEDIA_URL);
            if (d === U.RESOURCE_URL) {
              var k = la(f.toString()),
                n,
                s,
                t = !1;
              n = 0;
              for (s = a.length; n < s; n++)
                if (e(a[n], k)) {
                  t = !0;
                  break;
                }
              if (t)
                for (n = 0, s = b.length; n < s; n++)
                  if (e(b[n], k)) {
                    t = !1;
                    break;
                  }
              if (t) return f;
              throw Da("insecurl", f.toString());
            }
            if (d === U.HTML) return g(f);
            throw Da("unsafe");
          },
          valueOf: function (a) {
            return a instanceof k ? a.$$unwrapTrustedValue() : a;
          },
        };
      },
    ];
  }
  function Vf() {
    var a = !0;
    this.enabled = function (b) {
      arguments.length && (a = !!b);
      return a;
    };
    this.$get = [
      "$parse",
      "$sceDelegate",
      function (b, d) {
        if (a && 8 > Aa) throw Da("iequirks");
        var c = oa(U);
        c.isEnabled = function () {
          return a;
        };
        c.trustAs = d.trustAs;
        c.getTrusted = d.getTrusted;
        c.valueOf = d.valueOf;
        a ||
          ((c.trustAs = c.getTrusted = function (a, b) {
            return b;
          }),
          (c.valueOf = Ta));
        c.parseAs = function (a, d) {
          var e = b(d);
          return e.literal && e.constant
            ? e
            : b(d, function (b) {
                return c.getTrusted(a, b);
              });
        };
        var e = c.parseAs,
          f = c.getTrusted,
          g = c.trustAs;
        r(U, function (a, b) {
          var d = O(b);
          c[("parse_as_" + d).replace(Bc, wb)] = function (b) {
            return e(a, b);
          };
          c[("get_trusted_" + d).replace(Bc, wb)] = function (b) {
            return f(a, b);
          };
          c[("trust_as_" + d).replace(Bc, wb)] = function (b) {
            return g(a, b);
          };
        });
        return c;
      },
    ];
  }
  function Xf() {
    this.$get = [
      "$window",
      "$document",
      function (a, b) {
        var d = {},
          c =
            !(
              (!a.nw || !a.nw.process) &&
              a.chrome &&
              ((a.chrome.app && a.chrome.app.runtime) ||
                (!a.chrome.app && a.chrome.runtime && a.chrome.runtime.id))
            ) &&
            a.history &&
            a.history.pushState,
          e = da(
            (/android (\d+)/.exec(O((a.navigator || {}).userAgent)) || [])[1]
          ),
          f = /Boxee/i.test((a.navigator || {}).userAgent),
          g = b[0] || {},
          k = g.body && g.body.style,
          h = !1,
          l = !1;
        k &&
          ((h = !!("transition" in k || "webkitTransition" in k)),
          (l = !!("animation" in k || "webkitAnimation" in k)));
        return {
          history: !(!c || 4 > e || f),
          hasEvent: function (a) {
            if ("input" === a && Aa) return !1;
            if (x(d[a])) {
              var b = g.createElement("div");
              d[a] = "on" + a in b;
            }
            return d[a];
          },
          csp: pa(),
          transitions: h,
          animations: l,
          android: e,
        };
      },
    ];
  }
  function Yf() {
    this.$get = ia(function (a) {
      return new Pg(a);
    });
  }
  function Pg(a) {
    function b() {
      var a = e.pop();
      return a && a.cb;
    }
    function d(a) {
      for (var b = e.length - 1; 0 <= b; --b) {
        var c = e[b];
        if (c.type === a) return e.splice(b, 1), c.cb;
      }
    }
    var c = {},
      e = [],
      f = (this.ALL_TASKS_TYPE = "$$all$$"),
      g = (this.DEFAULT_TASK_TYPE = "$$default$$");
    this.completeTask = function (e, h) {
      h = h || g;
      try {
        e();
      } finally {
        var l;
        l = h || g;
        c[l] && (c[l]--, c[f]--);
        l = c[h];
        var m = c[f];
        if (!m || !l)
          for (l = m ? d : b; (m = l(h)); )
            try {
              m();
            } catch (q) {
              a.error(q);
            }
      }
    };
    this.incTaskCount = function (a) {
      a = a || g;
      c[a] = (c[a] || 0) + 1;
      c[f] = (c[f] || 0) + 1;
    };
    this.notifyWhenNoPendingTasks = function (a, b) {
      b = b || f;
      c[b] ? e.push({ type: b, cb: a }) : a();
    };
  }
  function $f() {
    var a;
    this.httpOptions = function (b) {
      return b ? ((a = b), this) : a;
    };
    this.$get = [
      "$exceptionHandler",
      "$templateCache",
      "$http",
      "$q",
      "$sce",
      function (b, d, c, e, f) {
        function g(k, h) {
          g.totalPendingRequests++;
          if (!C(k) || x(d.get(k))) k = f.getTrustedResourceUrl(k);
          var l = c.defaults && c.defaults.transformResponse;
          I(l)
            ? (l = l.filter(function (a) {
                return a !== uc;
              }))
            : l === uc && (l = null);
          return c
            .get(k, R({ cache: d, transformResponse: l }, a))
            .finally(function () {
              g.totalPendingRequests--;
            })
            .then(
              function (a) {
                return d.put(k, a.data);
              },
              function (a) {
                h || ((a = Qg("tpload", k, a.status, a.statusText)), b(a));
                return e.reject(a);
              }
            );
        }
        g.totalPendingRequests = 0;
        return g;
      },
    ];
  }
  function ag() {
    this.$get = [
      "$rootScope",
      "$browser",
      "$location",
      function (a, b, d) {
        return {
          findBindings: function (a, b, d) {
            a = a.getElementsByClassName("ng-binding");
            var g = [];
            r(a, function (a) {
              var c = ea.element(a).data("$binding");
              c &&
                r(c, function (c) {
                  d
                    ? new RegExp("(^|\\s)" + Ld(b) + "(\\s|\\||$)").test(c) &&
                      g.push(a)
                    : -1 !== c.indexOf(b) && g.push(a);
                });
            });
            return g;
          },
          findModels: function (a, b, d) {
            for (
              var g = ["ng-", "data-ng-", "ng\\:"], k = 0;
              k < g.length;
              ++k
            ) {
              var h = a.querySelectorAll(
                "[" + g[k] + "model" + (d ? "=" : "*=") + '"' + b + '"]'
              );
              if (h.length) return h;
            }
          },
          getLocation: function () {
            return d.url();
          },
          setLocation: function (b) {
            b !== d.url() && (d.url(b), a.$digest());
          },
          whenStable: function (a) {
            b.notifyWhenNoOutstandingRequests(a);
          },
        };
      },
    ];
  }
  function bg() {
    this.$get = [
      "$rootScope",
      "$browser",
      "$q",
      "$$q",
      "$exceptionHandler",
      function (a, b, d, c, e) {
        function f(f, h, l) {
          z(f) || ((l = h), (h = f), (f = A));
          var m = Ga.call(arguments, 3),
            q = v(l) && !l,
            n = (q ? c : d).defer(),
            s = n.promise,
            t;
          t = b.defer(
            function () {
              try {
                n.resolve(f.apply(null, m));
              } catch (b) {
                n.reject(b), e(b);
              } finally {
                delete g[s.$$timeoutId];
              }
              q || a.$apply();
            },
            h,
            "$timeout"
          );
          s.$$timeoutId = t;
          g[t] = n;
          return s;
        }
        var g = {};
        f.cancel = function (a) {
          if (!a) return !1;
          if (!a.hasOwnProperty("$$timeoutId")) throw Rg("badprom");
          if (!g.hasOwnProperty(a.$$timeoutId)) return !1;
          a = a.$$timeoutId;
          var c = g[a];
          c.promise.$$state.pur = !0;
          c.reject("canceled");
          delete g[a];
          return b.defer.cancel(a);
        };
        return f;
      },
    ];
  }
  function la(a) {
    if (!C(a)) return a;
    Aa && ($.setAttribute("href", a), (a = $.href));
    $.setAttribute("href", a);
    return {
      href: $.href,
      protocol: $.protocol ? $.protocol.replace(/:$/, "") : "",
      host: $.host,
      search: $.search ? $.search.replace(/^\?/, "") : "",
      hash: $.hash ? $.hash.replace(/^#/, "") : "",
      hostname: $.hostname,
      port: $.port,
      pathname: "/" === $.pathname.charAt(0) ? $.pathname : "/" + $.pathname,
    };
  }
  function Fg(a) {
    var b = [Nd].concat(a.map(la));
    return function (a) {
      a = la(a);
      return b.some(Ac.bind(null, a));
    };
  }
  function Ac(a, b) {
    a = la(a);
    b = la(b);
    return a.protocol === b.protocol && a.host === b.host;
  }
  function cg() {
    this.$get = ia(B);
  }
  function Od(a) {
    function b(a) {
      try {
        return decodeURIComponent(a);
      } catch (b) {
        return a;
      }
    }
    var d = a[0] || {},
      c = {},
      e = "";
    return function () {
      var a, g, k, h, l;
      try {
        a = d.cookie || "";
      } catch (m) {
        a = "";
      }
      if (a !== e)
        for (e = a, a = e.split("; "), c = {}, k = 0; k < a.length; k++)
          (g = a[k]),
            (h = g.indexOf("=")),
            0 < h &&
              ((l = b(g.substring(0, h))),
              x(c[l]) && (c[l] = b(g.substring(h + 1))));
      return c;
    };
  }
  function gg() {
    this.$get = Od;
  }
  function cd(a) {
    function b(d, c) {
      if (F(d)) {
        var e = {};
        r(d, function (a, c) {
          e[c] = b(c, a);
        });
        return e;
      }
      return a.factory(d + "Filter", c);
    }
    this.register = b;
    this.$get = [
      "$injector",
      function (a) {
        return function (b) {
          return a.get(b + "Filter");
        };
      },
    ];
    b("currency", Pd);
    b("date", Qd);
    b("filter", Sg);
    b("json", Tg);
    b("limitTo", Ug);
    b("lowercase", Vg);
    b("number", Rd);
    b("orderBy", Sd);
    b("uppercase", Wg);
  }
  function Sg() {
    return function (a, b, d, c) {
      if (!xa(a)) {
        if (null == a) return a;
        throw M("filter")("notarray", a);
      }
      c = c || "$";
      var e;
      switch (Cc(b)) {
        case "function":
          break;
        case "boolean":
        case "null":
        case "number":
        case "string":
          e = !0;
        case "object":
          b = Xg(b, d, c, e);
          break;
        default:
          return a;
      }
      return Array.prototype.filter.call(a, b);
    };
  }
  function Xg(a, b, d, c) {
    var e = F(a) && d in a;
    !0 === b
      ? (b = ua)
      : z(b) ||
        (b = function (a, b) {
          if (x(a)) return !1;
          if (null === a || null === b) return a === b;
          if (F(b) || (F(a) && !ac(a))) return !1;
          a = O("" + a);
          b = O("" + b);
          return -1 !== a.indexOf(b);
        });
    return function (f) {
      return e && !F(f) ? Ma(f, a[d], b, d, !1) : Ma(f, a, b, d, c);
    };
  }
  function Ma(a, b, d, c, e, f) {
    var g = Cc(a),
      k = Cc(b);
    if ("string" === k && "!" === b.charAt(0))
      return !Ma(a, b.substring(1), d, c, e);
    if (I(a))
      return a.some(function (a) {
        return Ma(a, b, d, c, e);
      });
    switch (g) {
      case "object":
        var h;
        if (e) {
          for (h in a)
            if (h.charAt && "$" !== h.charAt(0) && Ma(a[h], b, d, c, !0))
              return !0;
          return f ? !1 : Ma(a, b, d, c, !1);
        }
        if ("object" === k) {
          for (h in b)
            if (
              ((f = b[h]),
              !z(f) &&
                !x(f) &&
                ((g = h === c), !Ma(g ? a : a[h], f, d, c, g, g)))
            )
              return !1;
          return !0;
        }
        return d(a, b);
      case "function":
        return !1;
      default:
        return d(a, b);
    }
  }
  function Cc(a) {
    return null === a ? "null" : typeof a;
  }
  function Pd(a) {
    var b = a.NUMBER_FORMATS;
    return function (a, c, e) {
      x(c) && (c = b.CURRENCY_SYM);
      x(e) && (e = b.PATTERNS[1].maxFrac);
      var f = c ? /\u00A4/g : /\s*\u00A4\s*/g;
      return null == a
        ? a
        : Td(a, b.PATTERNS[1], b.GROUP_SEP, b.DECIMAL_SEP, e).replace(f, c);
    };
  }
  function Rd(a) {
    var b = a.NUMBER_FORMATS;
    return function (a, c) {
      return null == a
        ? a
        : Td(a, b.PATTERNS[0], b.GROUP_SEP, b.DECIMAL_SEP, c);
    };
  }
  function Yg(a) {
    var b = 0,
      d,
      c,
      e,
      f,
      g;
    -1 < (c = a.indexOf(Ud)) && (a = a.replace(Ud, ""));
    0 < (e = a.search(/e/i))
      ? (0 > c && (c = e), (c += +a.slice(e + 1)), (a = a.substring(0, e)))
      : 0 > c && (c = a.length);
    for (e = 0; a.charAt(e) === Dc; e++);
    if (e === (g = a.length)) (d = [0]), (c = 1);
    else {
      for (g--; a.charAt(g) === Dc; ) g--;
      c -= e;
      d = [];
      for (f = 0; e <= g; e++, f++) d[f] = +a.charAt(e);
    }
    c > Vd && ((d = d.splice(0, Vd - 1)), (b = c - 1), (c = 1));
    return { d: d, e: b, i: c };
  }
  function Zg(a, b, d, c) {
    var e = a.d,
      f = e.length - a.i;
    b = x(b) ? Math.min(Math.max(d, f), c) : +b;
    d = b + a.i;
    c = e[d];
    if (0 < d) {
      e.splice(Math.max(a.i, d));
      for (var g = d; g < e.length; g++) e[g] = 0;
    } else
      for (
        f = Math.max(0, f),
          a.i = 1,
          e.length = Math.max(1, (d = b + 1)),
          e[0] = 0,
          g = 1;
        g < d;
        g++
      )
        e[g] = 0;
    if (5 <= c)
      if (0 > d - 1) {
        for (c = 0; c > d; c--) e.unshift(0), a.i++;
        e.unshift(1);
        a.i++;
      } else e[d - 1]++;
    for (; f < Math.max(0, b); f++) e.push(0);
    if (
      (b = e.reduceRight(function (a, b, c, d) {
        b += a;
        d[c] = b % 10;
        return Math.floor(b / 10);
      }, 0))
    )
      e.unshift(b), a.i++;
  }
  function Td(a, b, d, c, e) {
    if ((!C(a) && !ba(a)) || isNaN(a)) return "";
    var f = !isFinite(a),
      g = !1,
      k = Math.abs(a) + "",
      h = "";
    if (f) h = "\u221e";
    else {
      g = Yg(k);
      Zg(g, e, b.minFrac, b.maxFrac);
      h = g.d;
      k = g.i;
      e = g.e;
      f = [];
      for (
        g = h.reduce(function (a, b) {
          return a && !b;
        }, !0);
        0 > k;

      )
        h.unshift(0), k++;
      0 < k ? (f = h.splice(k, h.length)) : ((f = h), (h = [0]));
      k = [];
      for (
        h.length >= b.lgSize &&
        k.unshift(h.splice(-b.lgSize, h.length).join(""));
        h.length > b.gSize;

      )
        k.unshift(h.splice(-b.gSize, h.length).join(""));
      h.length && k.unshift(h.join(""));
      h = k.join(d);
      f.length && (h += c + f.join(""));
      e && (h += "e+" + e);
    }
    return 0 > a && !g ? b.negPre + h + b.negSuf : b.posPre + h + b.posSuf;
  }
  function Ob(a, b, d, c) {
    var e = "";
    if (0 > a || (c && 0 >= a)) c ? (a = -a + 1) : ((a = -a), (e = "-"));
    for (a = "" + a; a.length < b; ) a = Dc + a;
    d && (a = a.substr(a.length - b));
    return e + a;
  }
  function ga(a, b, d, c, e) {
    d = d || 0;
    return function (f) {
      f = f["get" + a]();
      if (0 < d || f > -d) f += d;
      0 === f && -12 === d && (f = 12);
      return Ob(f, b, c, e);
    };
  }
  function kb(a, b, d) {
    return function (c, e) {
      var f = c["get" + a](),
        g = ub((d ? "STANDALONE" : "") + (b ? "SHORT" : "") + a);
      return e[g][f];
    };
  }
  function Wd(a) {
    var b = new Date(a, 0, 1).getDay();
    return new Date(a, 0, (4 >= b ? 5 : 12) - b);
  }
  function Xd(a) {
    return function (b) {
      var d = Wd(b.getFullYear());
      b =
        +new Date(
          b.getFullYear(),
          b.getMonth(),
          b.getDate() + (4 - b.getDay())
        ) - +d;
      b = 1 + Math.round(b / 6048e5);
      return Ob(b, a);
    };
  }
  function Ec(a, b) {
    return 0 >= a.getFullYear() ? b.ERAS[0] : b.ERAS[1];
  }
  function Qd(a) {
    function b(a) {
      var b;
      if ((b = a.match(d))) {
        a = new Date(0);
        var f = 0,
          g = 0,
          k = b[8] ? a.setUTCFullYear : a.setFullYear,
          h = b[8] ? a.setUTCHours : a.setHours;
        b[9] && ((f = da(b[9] + b[10])), (g = da(b[9] + b[11])));
        k.call(a, da(b[1]), da(b[2]) - 1, da(b[3]));
        f = da(b[4] || 0) - f;
        g = da(b[5] || 0) - g;
        k = da(b[6] || 0);
        b = Math.round(1e3 * parseFloat("0." + (b[7] || 0)));
        h.call(a, f, g, k, b);
      }
      return a;
    }
    var d = /^(\d{4})-?(\d\d)-?(\d\d)(?:T(\d\d)(?::?(\d\d)(?::?(\d\d)(?:\.(\d+))?)?)?(Z|([+-])(\d\d):?(\d\d))?)?$/;
    return function (c, d, f) {
      var g = "",
        k = [],
        h,
        l;
      d = d || "mediumDate";
      d = a.DATETIME_FORMATS[d] || d;
      C(c) && (c = $g.test(c) ? da(c) : b(c));
      ba(c) && (c = new Date(c));
      if (!ha(c) || !isFinite(c.getTime())) return c;
      for (; d; )
        (l = ah.exec(d))
          ? ((k = db(k, l, 1)), (d = k.pop()))
          : (k.push(d), (d = null));
      var m = c.getTimezoneOffset();
      f && ((m = dc(f, m)), (c = ec(c, f, !0)));
      r(k, function (b) {
        h = bh[b];
        g += h
          ? h(c, a.DATETIME_FORMATS, m)
          : "''" === b
          ? "'"
          : b.replace(/(^'|'$)/g, "").replace(/''/g, "'");
      });
      return g;
    };
  }
  function Tg() {
    return function (a, b) {
      x(b) && (b = 2);
      return eb(a, b);
    };
  }
  function Ug() {
    return function (a, b, d) {
      b = Infinity === Math.abs(Number(b)) ? Number(b) : da(b);
      if (V(b)) return a;
      ba(a) && (a = a.toString());
      if (!xa(a)) return a;
      d = !d || isNaN(d) ? 0 : da(d);
      d = 0 > d ? Math.max(0, a.length + d) : d;
      return 0 <= b
        ? Fc(a, d, d + b)
        : 0 === d
        ? Fc(a, b, a.length)
        : Fc(a, Math.max(0, d + b), d);
    };
  }
  function Fc(a, b, d) {
    return C(a) ? a.slice(b, d) : Ga.call(a, b, d);
  }
  function Sd(a) {
    function b(b) {
      return b.map(function (b) {
        var c = 1,
          d = Ta;
        if (z(b)) d = b;
        else if (C(b)) {
          if ("+" === b.charAt(0) || "-" === b.charAt(0))
            (c = "-" === b.charAt(0) ? -1 : 1), (b = b.substring(1));
          if ("" !== b && ((d = a(b)), d.constant))
            var e = d(),
              d = function (a) {
                return a[e];
              };
        }
        return { get: d, descending: c };
      });
    }
    function d(a) {
      switch (typeof a) {
        case "number":
        case "boolean":
        case "string":
          return !0;
        default:
          return !1;
      }
    }
    function c(a, b) {
      var c = 0,
        d = a.type,
        h = b.type;
      if (d === h) {
        var h = a.value,
          l = b.value;
        "string" === d
          ? ((h = h.toLowerCase()), (l = l.toLowerCase()))
          : "object" === d && (F(h) && (h = a.index), F(l) && (l = b.index));
        h !== l && (c = h < l ? -1 : 1);
      } else
        c =
          "undefined" === d
            ? 1
            : "undefined" === h
            ? -1
            : "null" === d
            ? 1
            : "null" === h
            ? -1
            : d < h
            ? -1
            : 1;
      return c;
    }
    return function (a, f, g, k) {
      if (null == a) return a;
      if (!xa(a)) throw M("orderBy")("notarray", a);
      I(f) || (f = [f]);
      0 === f.length && (f = ["+"]);
      var h = b(f),
        l = g ? -1 : 1,
        m = z(k) ? k : c;
      a = Array.prototype.map.call(a, function (a, b) {
        return {
          value: a,
          tieBreaker: { value: b, type: "number", index: b },
          predicateValues: h.map(function (c) {
            var e = c.get(a);
            c = typeof e;
            if (null === e) c = "null";
            else if ("object" === c)
              a: {
                if (z(e.valueOf) && ((e = e.valueOf()), d(e))) break a;
                ac(e) && ((e = e.toString()), d(e));
              }
            return { value: e, type: c, index: b };
          }),
        };
      });
      a.sort(function (a, b) {
        for (var d = 0, e = h.length; d < e; d++) {
          var f = m(a.predicateValues[d], b.predicateValues[d]);
          if (f) return f * h[d].descending * l;
        }
        return (
          (m(a.tieBreaker, b.tieBreaker) || c(a.tieBreaker, b.tieBreaker)) * l
        );
      });
      return (a = a.map(function (a) {
        return a.value;
      }));
    };
  }
  function Na(a) {
    z(a) && (a = { link: a });
    a.restrict = a.restrict || "AC";
    return ia(a);
  }
  function Pb(a, b, d, c, e) {
    this.$$controls = [];
    this.$error = {};
    this.$$success = {};
    this.$pending = void 0;
    this.$name = e(b.name || b.ngForm || "")(d);
    this.$dirty = !1;
    this.$valid = this.$pristine = !0;
    this.$submitted = this.$invalid = !1;
    this.$$parentForm = lb;
    this.$$element = a;
    this.$$animate = c;
    Yd(this);
  }
  function Yd(a) {
    a.$$classCache = {};
    a.$$classCache[Zd] = !(a.$$classCache[mb] = a.$$element.hasClass(mb));
  }
  function $d(a) {
    function b(a, b, c) {
      c && !a.$$classCache[b]
        ? (a.$$animate.addClass(a.$$element, b), (a.$$classCache[b] = !0))
        : !c &&
          a.$$classCache[b] &&
          (a.$$animate.removeClass(a.$$element, b), (a.$$classCache[b] = !1));
    }
    function d(a, c, d) {
      c = c ? "-" + Uc(c, "-") : "";
      b(a, mb + c, !0 === d);
      b(a, Zd + c, !1 === d);
    }
    var c = a.set,
      e = a.unset;
    a.clazz.prototype.$setValidity = function (a, g, k) {
      x(g)
        ? (this.$pending || (this.$pending = {}), c(this.$pending, a, k))
        : (this.$pending && e(this.$pending, a, k),
          ae(this.$pending) && (this.$pending = void 0));
      Fa(g)
        ? g
          ? (e(this.$error, a, k), c(this.$$success, a, k))
          : (c(this.$error, a, k), e(this.$$success, a, k))
        : (e(this.$error, a, k), e(this.$$success, a, k));
      this.$pending
        ? (b(this, "ng-pending", !0),
          (this.$valid = this.$invalid = void 0),
          d(this, "", null))
        : (b(this, "ng-pending", !1),
          (this.$valid = ae(this.$error)),
          (this.$invalid = !this.$valid),
          d(this, "", this.$valid));
      g =
        this.$pending && this.$pending[a]
          ? void 0
          : this.$error[a]
          ? !1
          : this.$$success[a]
          ? !0
          : null;
      d(this, a, g);
      this.$$parentForm.$setValidity(a, g, this);
    };
  }
  function ae(a) {
    if (a) for (var b in a) if (a.hasOwnProperty(b)) return !1;
    return !0;
  }
  function Gc(a) {
    a.$formatters.push(function (b) {
      return a.$isEmpty(b) ? b : b.toString();
    });
  }
  function Ra(a, b, d, c, e, f) {
    var g = O(b[0].type);
    if (!e.android) {
      var k = !1;
      b.on("compositionstart", function () {
        k = !0;
      });
      b.on("compositionupdate", function (a) {
        if (x(a.data) || "" === a.data) k = !1;
      });
      b.on("compositionend", function () {
        k = !1;
        l();
      });
    }
    var h,
      l = function (a) {
        h && (f.defer.cancel(h), (h = null));
        if (!k) {
          var e = b.val();
          a = a && a.type;
          "password" === g || (d.ngTrim && "false" === d.ngTrim) || (e = T(e));
          (c.$viewValue !== e || ("" === e && c.$$hasNativeValidators)) &&
            c.$setViewValue(e, a);
        }
      };
    if (e.hasEvent("input")) b.on("input", l);
    else {
      var m = function (a, b, c) {
        h ||
          (h = f.defer(function () {
            h = null;
            (b && b.value === c) || l(a);
          }));
      };
      b.on("keydown", function (a) {
        var b = a.keyCode;
        91 === b ||
          (15 < b && 19 > b) ||
          (37 <= b && 40 >= b) ||
          m(a, this, this.value);
      });
      if (e.hasEvent("paste")) b.on("paste cut drop", m);
    }
    b.on("change", l);
    if (be[g] && c.$$hasNativeValidators && g === d.type)
      b.on("keydown wheel mousedown", function (a) {
        if (!h) {
          var b = this.validity,
            c = b.badInput,
            d = b.typeMismatch;
          h = f.defer(function () {
            h = null;
            (b.badInput === c && b.typeMismatch === d) || l(a);
          });
        }
      });
    c.$render = function () {
      var a = c.$isEmpty(c.$viewValue) ? "" : c.$viewValue;
      b.val() !== a && b.val(a);
    };
  }
  function Qb(a, b) {
    return function (d, c) {
      var e, f;
      if (ha(d)) return d;
      if (C(d)) {
        '"' === d.charAt(0) &&
          '"' === d.charAt(d.length - 1) &&
          (d = d.substring(1, d.length - 1));
        if (ch.test(d)) return new Date(d);
        a.lastIndex = 0;
        if ((e = a.exec(d)))
          return (
            e.shift(),
            (f = c
              ? {
                  yyyy: c.getFullYear(),
                  MM: c.getMonth() + 1,
                  dd: c.getDate(),
                  HH: c.getHours(),
                  mm: c.getMinutes(),
                  ss: c.getSeconds(),
                  sss: c.getMilliseconds() / 1e3,
                }
              : { yyyy: 1970, MM: 1, dd: 1, HH: 0, mm: 0, ss: 0, sss: 0 }),
            r(e, function (a, c) {
              c < b.length && (f[b[c]] = +a);
            }),
            (e = new Date(
              f.yyyy,
              f.MM - 1,
              f.dd,
              f.HH,
              f.mm,
              f.ss || 0,
              1e3 * f.sss || 0
            )),
            100 > f.yyyy && e.setFullYear(f.yyyy),
            e
          );
      }
      return NaN;
    };
  }
  function nb(a, b, d, c) {
    return function (e, f, g, k, h, l, m) {
      function q(a) {
        return a && !(a.getTime && a.getTime() !== a.getTime());
      }
      function n(a) {
        return v(a) && !ha(a) ? s(a) || void 0 : a;
      }
      function s(a, b) {
        var c = k.$options.getOption("timezone");
        p && p !== c && (b = Rc(b, dc(p)));
        var e = d(a, b);
        !isNaN(e) && c && (e = ec(e, c));
        return e;
      }
      Hc(e, f, g, k, a);
      Ra(e, f, g, k, h, l);
      var t = "time" === a || "datetimelocal" === a,
        u,
        p;
      k.$parsers.push(function (c) {
        if (k.$isEmpty(c)) return null;
        if (b.test(c)) return s(c, u);
        k.$$parserName = a;
      });
      k.$formatters.push(function (a) {
        if (a && !ha(a)) throw ob("datefmt", a);
        if (q(a)) {
          u = a;
          var b = k.$options.getOption("timezone");
          b && ((p = b), (u = ec(u, b, !0)));
          var d = c;
          t &&
            C(k.$options.getOption("timeSecondsFormat")) &&
            (d = c
              .replace("ss.sss", k.$options.getOption("timeSecondsFormat"))
              .replace(/:$/, ""));
          a = m("date")(a, d, b);
          t &&
            k.$options.getOption("timeStripZeroSeconds") &&
            (a = a.replace(/(?::00)?(?:\.000)?$/, ""));
          return a;
        }
        p = u = null;
        return "";
      });
      if (v(g.min) || g.ngMin) {
        var r;
        k.$validators.min = function (a) {
          return !q(a) || x(r) || d(a) >= r;
        };
        g.$observe("min", function (a) {
          r = n(a);
          k.$validate();
        });
      }
      if (v(g.max) || g.ngMax) {
        var y;
        k.$validators.max = function (a) {
          return !q(a) || x(y) || d(a) <= y;
        };
        g.$observe("max", function (a) {
          y = n(a);
          k.$validate();
        });
      }
    };
  }
  function Hc(a, b, d, c, e) {
    (c.$$hasNativeValidators = F(b[0].validity)) &&
      c.$parsers.push(function (a) {
        var d = b.prop("validity") || {};
        if (d.badInput || d.typeMismatch) c.$$parserName = e;
        else return a;
      });
  }
  function ce(a) {
    a.$parsers.push(function (b) {
      if (a.$isEmpty(b)) return null;
      if (dh.test(b)) return parseFloat(b);
      a.$$parserName = "number";
    });
    a.$formatters.push(function (b) {
      if (!a.$isEmpty(b)) {
        if (!ba(b)) throw ob("numfmt", b);
        b = b.toString();
      }
      return b;
    });
  }
  function Sa(a) {
    v(a) && !ba(a) && (a = parseFloat(a));
    return V(a) ? void 0 : a;
  }
  function Ic(a) {
    var b = a.toString(),
      d = b.indexOf(".");
    return -1 === d
      ? -1 < a && 1 > a && (a = /e-(\d+)$/.exec(b))
        ? Number(a[1])
        : 0
      : b.length - d - 1;
  }
  function de(a, b, d) {
    a = Number(a);
    var c = (a | 0) !== a,
      e = (b | 0) !== b,
      f = (d | 0) !== d;
    if (c || e || f) {
      var g = c ? Ic(a) : 0,
        k = e ? Ic(b) : 0,
        h = f ? Ic(d) : 0,
        g = Math.max(g, k, h),
        g = Math.pow(10, g);
      a *= g;
      b *= g;
      d *= g;
      c && (a = Math.round(a));
      e && (b = Math.round(b));
      f && (d = Math.round(d));
    }
    return 0 === (a - b) % d;
  }
  function ee(a, b, d, c, e) {
    if (v(c)) {
      a = a(c);
      if (!a.constant) throw ob("constexpr", d, c);
      return a(b);
    }
    return e;
  }
  function Jc(a, b) {
    function d(a, b) {
      if (!a || !a.length) return [];
      if (!b || !b.length) return a;
      var c = [],
        d = 0;
      a: for (; d < a.length; d++) {
        for (var e = a[d], m = 0; m < b.length; m++) if (e === b[m]) continue a;
        c.push(e);
      }
      return c;
    }
    function c(a) {
      if (!a) return a;
      var b = a;
      I(a)
        ? (b = a.map(c).join(" "))
        : F(a)
        ? (b = Object.keys(a)
            .filter(function (b) {
              return a[b];
            })
            .join(" "))
        : C(a) || (b = a + "");
      return b;
    }
    a = "ngClass" + a;
    var e;
    return [
      "$parse",
      function (f) {
        return {
          restrict: "AC",
          link: function (g, k, h) {
            function l(a, b) {
              var c = [];
              r(a, function (a) {
                if (0 < b || q[a])
                  (q[a] = (q[a] || 0) + b), q[a] === +(0 < b) && c.push(a);
              });
              return c.join(" ");
            }
            function m(a) {
              if (a === b) {
                var c = s,
                  c = l(c && c.split(" "), 1);
                h.$addClass(c);
              } else (c = s), (c = l(c && c.split(" "), -1)), h.$removeClass(c);
              n = a;
            }
            var q = k.data("$classCounts"),
              n = !0,
              s;
            q || ((q = S()), k.data("$classCounts", q));
            "ngClass" !== a &&
              (e ||
                (e = f("$index", function (a) {
                  return a & 1;
                })),
              g.$watch(e, m));
            g.$watch(f(h[a], c), function (a) {
              if (n === b) {
                var c = s && s.split(" "),
                  e = a && a.split(" "),
                  f = d(c, e),
                  c = d(e, c),
                  f = l(f, -1),
                  c = l(c, 1);
                h.$addClass(c);
                h.$removeClass(f);
              }
              s = a;
            });
          },
        };
      },
    ];
  }
  function pd(a, b, d, c, e, f) {
    return {
      restrict: "A",
      compile: function (g, k) {
        var h = a(k[c]);
        return function (a, c) {
          c.on(e, function (c) {
            var e = function () {
              h(a, { $event: c });
            };
            if (b.$$phase)
              if (f) a.$evalAsync(e);
              else
                try {
                  e();
                } catch (g) {
                  d(g);
                }
            else a.$apply(e);
          });
        };
      },
    };
  }
  function Rb(a, b, d, c, e, f, g, k, h) {
    this.$modelValue = this.$viewValue = Number.NaN;
    this.$$rawModelValue = void 0;
    this.$validators = {};
    this.$asyncValidators = {};
    this.$parsers = [];
    this.$formatters = [];
    this.$viewChangeListeners = [];
    this.$untouched = !0;
    this.$touched = !1;
    this.$pristine = !0;
    this.$dirty = !1;
    this.$valid = !0;
    this.$invalid = !1;
    this.$error = {};
    this.$$success = {};
    this.$pending = void 0;
    this.$name = h(d.name || "", !1)(a);
    this.$$parentForm = lb;
    this.$options = Sb;
    this.$$updateEvents = "";
    this.$$updateEventHandler = this.$$updateEventHandler.bind(this);
    this.$$parsedNgModel = e(d.ngModel);
    this.$$parsedNgModelAssign = this.$$parsedNgModel.assign;
    this.$$ngModelGet = this.$$parsedNgModel;
    this.$$ngModelSet = this.$$parsedNgModelAssign;
    this.$$pendingDebounce = null;
    this.$$parserValid = void 0;
    this.$$parserName = "parse";
    this.$$currentValidationRunId = 0;
    this.$$scope = a;
    this.$$rootScope = a.$root;
    this.$$attr = d;
    this.$$element = c;
    this.$$animate = f;
    this.$$timeout = g;
    this.$$parse = e;
    this.$$q = k;
    this.$$exceptionHandler = b;
    Yd(this);
    eh(this);
  }
  function eh(a) {
    a.$$scope.$watch(function (b) {
      b = a.$$ngModelGet(b);
      b === a.$modelValue ||
        (a.$modelValue !== a.$modelValue && b !== b) ||
        a.$$setModelValue(b);
      return b;
    });
  }
  function Kc(a) {
    this.$$options = a;
  }
  function fe(a, b) {
    r(b, function (b, c) {
      v(a[c]) || (a[c] = b);
    });
  }
  function Ea(a, b) {
    a.prop("selected", b);
    a.attr("selected", b);
  }
  var Vb = { objectMaxDepth: 5, urlErrorParamsEnabled: !0 },
    fh = /^\/(.+)\/([a-z]*)$/,
    sa = Object.prototype.hasOwnProperty,
    O = function (a) {
      return C(a) ? a.toLowerCase() : a;
    },
    ub = function (a) {
      return C(a) ? a.toUpperCase() : a;
    },
    Aa,
    y,
    rb,
    Ga = [].slice,
    Bg = [].splice,
    gh = [].push,
    ma = Object.prototype.toString,
    Oc = Object.getPrototypeOf,
    Ia = M("ng"),
    ea = B.angular || (B.angular = {}),
    jc,
    pb = 0;
  Aa = B.document.documentMode;
  var V =
    Number.isNaN ||
    function (a) {
      return a !== a;
    };
  A.$inject = [];
  Ta.$inject = [];
  var se = /^\[object (?:Uint8|Uint8Clamped|Uint16|Uint32|Int8|Int16|Int32|Float32|Float64)Array]$/,
    T = function (a) {
      return C(a) ? a.trim() : a;
    },
    Ld = function (a) {
      return a
        .replace(/([-()[\]{}+?*.$^|,:#<!\\])/g, "\\$1")
        .replace(/\x08/g, "\\x08");
    },
    pa = function () {
      if (!v(pa.rules)) {
        var a =
          B.document.querySelector("[ng-csp]") ||
          B.document.querySelector("[data-ng-csp]");
        if (a) {
          var b = a.getAttribute("ng-csp") || a.getAttribute("data-ng-csp");
          pa.rules = {
            noUnsafeEval: !b || -1 !== b.indexOf("no-unsafe-eval"),
            noInlineStyle: !b || -1 !== b.indexOf("no-inline-style"),
          };
        } else {
          a = pa;
          try {
            new Function(""), (b = !1);
          } catch (d) {
            b = !0;
          }
          a.rules = { noUnsafeEval: b, noInlineStyle: !1 };
        }
      }
      return pa.rules;
    },
    qb = function () {
      if (v(qb.name_)) return qb.name_;
      var a,
        b,
        d = Pa.length,
        c,
        e;
      for (b = 0; b < d; ++b)
        if (
          ((c = Pa[b]),
          (a = B.document.querySelector("[" + c.replace(":", "\\:") + "jq]")))
        ) {
          e = a.getAttribute(c + "jq");
          break;
        }
      return (qb.name_ = e);
    },
    ue = /:/g,
    Pa = ["ng-", "data-ng-", "ng:", "x-ng-"],
    ye = (function (a) {
      var b = a.currentScript;
      if (!b) return !0;
      if (
        !(b instanceof B.HTMLScriptElement || b instanceof B.SVGScriptElement)
      )
        return !1;
      b = b.attributes;
      return [
        b.getNamedItem("src"),
        b.getNamedItem("href"),
        b.getNamedItem("xlink:href"),
      ].every(function (b) {
        if (!b) return !0;
        if (!b.value) return !1;
        var c = a.createElement("a");
        c.href = b.value;
        if (a.location.origin === c.origin) return !0;
        switch (c.protocol) {
          case "http:":
          case "https:":
          case "ftp:":
          case "blob:":
          case "file:":
          case "data:":
            return !0;
          default:
            return !1;
        }
      });
    })(B.document),
    Be = /[A-Z]/g,
    Vc = !1,
    Oa = 3,
    He = {
      full: "1.7.5",
      major: 1,
      minor: 7,
      dot: 5,
      codeName: "anti-prettification",
    };
  W.expando = "ng339";
  var Ja = (W.cache = {}),
    lg = 1;
  W._data = function (a) {
    return this.cache[a[this.expando]] || {};
  };
  var hg = /-([a-z])/g,
    hh = /^-ms-/,
    Ab = { mouseleave: "mouseout", mouseenter: "mouseover" },
    mc = M("jqLite"),
    kg = /^<([\w-]+)\s*\/?>(?:<\/\1>|)$/,
    lc = /<|&#?\w+;/,
    ig = /<([\w:-]+)/,
    jg = /<(?!area|br|col|embed|hr|img|input|link|meta|param)(([\w:-]+)[^>]*)\/>/gi,
    ja = {
      option: [1, '<select multiple="multiple">', "</select>"],
      thead: [1, "<table>", "</table>"],
      col: [2, "<table><colgroup>", "</colgroup></table>"],
      tr: [2, "<table><tbody>", "</tbody></table>"],
      td: [3, "<table><tbody><tr>", "</tr></tbody></table>"],
      _default: [0, "", ""],
    };
  ja.optgroup = ja.option;
  ja.tbody = ja.tfoot = ja.colgroup = ja.caption = ja.thead;
  ja.th = ja.td;
  var qg =
      B.Node.prototype.contains ||
      function (a) {
        return !!(this.compareDocumentPosition(a) & 16);
      },
    Wa = (W.prototype = {
      ready: ed,
      toString: function () {
        var a = [];
        r(this, function (b) {
          a.push("" + b);
        });
        return "[" + a.join(", ") + "]";
      },
      eq: function (a) {
        return 0 <= a ? y(this[a]) : y(this[this.length + a]);
      },
      length: 0,
      push: gh,
      sort: [].sort,
      splice: [].splice,
    }),
    Gb = {};
  r(
    "multiple selected checked disabled readOnly required open".split(" "),
    function (a) {
      Gb[O(a)] = a;
    }
  );
  var ld = {};
  r("input select option textarea button form details".split(" "), function (
    a
  ) {
    ld[a] = !0;
  });
  var sd = {
    ngMinlength: "minlength",
    ngMaxlength: "maxlength",
    ngMin: "min",
    ngMax: "max",
    ngPattern: "pattern",
    ngStep: "step",
  };
  r(
    {
      data: qc,
      removeData: pc,
      hasData: function (a) {
        for (var b in Ja[a.ng339]) return !0;
        return !1;
      },
      cleanData: function (a) {
        for (var b = 0, d = a.length; b < d; b++) pc(a[b]), hd(a[b]);
      },
    },
    function (a, b) {
      W[b] = a;
    }
  );
  r(
    {
      data: qc,
      inheritedData: Eb,
      scope: function (a) {
        return (
          y.data(a, "$scope") ||
          Eb(a.parentNode || a, ["$isolateScope", "$scope"])
        );
      },
      isolateScope: function (a) {
        return (
          y.data(a, "$isolateScope") || y.data(a, "$isolateScopeNoTemplate")
        );
      },
      controller: id,
      injector: function (a) {
        return Eb(a, "$injector");
      },
      removeAttr: function (a, b) {
        a.removeAttribute(b);
      },
      hasClass: Bb,
      css: function (a, b, d) {
        b = xb(b.replace(hh, "ms-"));
        if (v(d)) a.style[b] = d;
        else return a.style[b];
      },
      attr: function (a, b, d) {
        var c = a.nodeType;
        if (c !== Oa && 2 !== c && 8 !== c && a.getAttribute) {
          var c = O(b),
            e = Gb[c];
          if (v(d))
            null === d || (!1 === d && e)
              ? a.removeAttribute(b)
              : a.setAttribute(b, e ? c : d);
          else
            return (
              (a = a.getAttribute(b)),
              e && null !== a && (a = c),
              null === a ? void 0 : a
            );
        }
      },
      prop: function (a, b, d) {
        if (v(d)) a[b] = d;
        else return a[b];
      },
      text: (function () {
        function a(a, d) {
          if (x(d)) {
            var c = a.nodeType;
            return 1 === c || c === Oa ? a.textContent : "";
          }
          a.textContent = d;
        }
        a.$dv = "";
        return a;
      })(),
      val: function (a, b) {
        if (x(b)) {
          if (a.multiple && "select" === ta(a)) {
            var d = [];
            r(a.options, function (a) {
              a.selected && d.push(a.value || a.text);
            });
            return d;
          }
          return a.value;
        }
        a.value = b;
      },
      html: function (a, b) {
        if (x(b)) return a.innerHTML;
        yb(a, !0);
        a.innerHTML = b;
      },
      empty: jd,
    },
    function (a, b) {
      W.prototype[b] = function (b, c) {
        var e,
          f,
          g = this.length;
        if (a !== jd && x(2 === a.length && a !== Bb && a !== id ? b : c)) {
          if (F(b)) {
            for (e = 0; e < g; e++)
              if (a === qc) a(this[e], b);
              else for (f in b) a(this[e], f, b[f]);
            return this;
          }
          e = a.$dv;
          g = x(e) ? Math.min(g, 1) : g;
          for (f = 0; f < g; f++) {
            var k = a(this[f], b, c);
            e = e ? e + k : k;
          }
          return e;
        }
        for (e = 0; e < g; e++) a(this[e], b, c);
        return this;
      };
    }
  );
  r(
    {
      removeData: pc,
      on: function (a, b, d, c) {
        if (v(c)) throw mc("onargs");
        if (kc(a)) {
          c = zb(a, !0);
          var e = c.events,
            f = c.handle;
          f || (f = c.handle = ng(a, e));
          c = 0 <= b.indexOf(" ") ? b.split(" ") : [b];
          for (
            var g = c.length,
              k = function (b, c, g) {
                var k = e[b];
                k ||
                  ((k = e[b] = []),
                  (k.specialHandlerWrapper = c),
                  "$destroy" === b || g || a.addEventListener(b, f));
                k.push(d);
              };
            g--;

          )
            (b = c[g]), Ab[b] ? (k(Ab[b], pg), k(b, void 0, !0)) : k(b);
        }
      },
      off: hd,
      one: function (a, b, d) {
        a = y(a);
        a.on(b, function e() {
          a.off(b, d);
          a.off(b, e);
        });
        a.on(b, d);
      },
      replaceWith: function (a, b) {
        var d,
          c = a.parentNode;
        yb(a);
        r(new W(b), function (b) {
          d ? c.insertBefore(b, d.nextSibling) : c.replaceChild(b, a);
          d = b;
        });
      },
      children: function (a) {
        var b = [];
        r(a.childNodes, function (a) {
          1 === a.nodeType && b.push(a);
        });
        return b;
      },
      contents: function (a) {
        return a.contentDocument || a.childNodes || [];
      },
      append: function (a, b) {
        var d = a.nodeType;
        if (1 === d || 11 === d) {
          b = new W(b);
          for (var d = 0, c = b.length; d < c; d++) a.appendChild(b[d]);
        }
      },
      prepend: function (a, b) {
        if (1 === a.nodeType) {
          var d = a.firstChild;
          r(new W(b), function (b) {
            a.insertBefore(b, d);
          });
        }
      },
      wrap: function (a, b) {
        var d = y(b).eq(0).clone()[0],
          c = a.parentNode;
        c && c.replaceChild(d, a);
        d.appendChild(a);
      },
      remove: Fb,
      detach: function (a) {
        Fb(a, !0);
      },
      after: function (a, b) {
        var d = a,
          c = a.parentNode;
        if (c) {
          b = new W(b);
          for (var e = 0, f = b.length; e < f; e++) {
            var g = b[e];
            c.insertBefore(g, d.nextSibling);
            d = g;
          }
        }
      },
      addClass: Db,
      removeClass: Cb,
      toggleClass: function (a, b, d) {
        b &&
          r(b.split(" "), function (b) {
            var e = d;
            x(e) && (e = !Bb(a, b));
            (e ? Db : Cb)(a, b);
          });
      },
      parent: function (a) {
        return (a = a.parentNode) && 11 !== a.nodeType ? a : null;
      },
      next: function (a) {
        return a.nextElementSibling;
      },
      find: function (a, b) {
        return a.getElementsByTagName ? a.getElementsByTagName(b) : [];
      },
      clone: oc,
      triggerHandler: function (a, b, d) {
        var c,
          e,
          f = b.type || b,
          g = zb(a);
        if ((g = (g = g && g.events) && g[f]))
          (c = {
            preventDefault: function () {
              this.defaultPrevented = !0;
            },
            isDefaultPrevented: function () {
              return !0 === this.defaultPrevented;
            },
            stopImmediatePropagation: function () {
              this.immediatePropagationStopped = !0;
            },
            isImmediatePropagationStopped: function () {
              return !0 === this.immediatePropagationStopped;
            },
            stopPropagation: A,
            type: f,
            target: a,
          }),
            b.type && (c = R(c, b)),
            (b = oa(g)),
            (e = d ? [c].concat(d) : [c]),
            r(b, function (b) {
              c.isImmediatePropagationStopped() || b.apply(a, e);
            });
      },
    },
    function (a, b) {
      W.prototype[b] = function (b, c, e) {
        for (var f, g = 0, k = this.length; g < k; g++)
          x(f)
            ? ((f = a(this[g], b, c, e)), v(f) && (f = y(f)))
            : nc(f, a(this[g], b, c, e));
        return v(f) ? f : this;
      };
    }
  );
  W.prototype.bind = W.prototype.on;
  W.prototype.unbind = W.prototype.off;
  var ih = Object.create(null);
  md.prototype = {
    _idx: function (a) {
      a !== this._lastKey &&
        ((this._lastKey = a), (this._lastIndex = this._keys.indexOf(a)));
      return this._lastIndex;
    },
    _transformKey: function (a) {
      return V(a) ? ih : a;
    },
    get: function (a) {
      a = this._transformKey(a);
      a = this._idx(a);
      if (-1 !== a) return this._values[a];
    },
    has: function (a) {
      a = this._transformKey(a);
      return -1 !== this._idx(a);
    },
    set: function (a, b) {
      a = this._transformKey(a);
      var d = this._idx(a);
      -1 === d && (d = this._lastIndex = this._keys.length);
      this._keys[d] = a;
      this._values[d] = b;
    },
    delete: function (a) {
      a = this._transformKey(a);
      a = this._idx(a);
      if (-1 === a) return !1;
      this._keys.splice(a, 1);
      this._values.splice(a, 1);
      this._lastKey = NaN;
      this._lastIndex = -1;
      return !0;
    },
  };
  var Hb = md,
    fg = [
      function () {
        this.$get = [
          function () {
            return Hb;
          },
        ];
      },
    ],
    sg = /^([^(]+?)=>/,
    tg = /^[^(]*\(\s*([^)]*)\)/m,
    jh = /,/,
    kh = /^\s*(_?)(\S+?)\1\s*$/,
    rg = /((\/\/.*$)|(\/\*[\s\S]*?\*\/))/gm,
    za = M("$injector");
  fb.$$annotate = function (a, b, d) {
    var c;
    if ("function" === typeof a) {
      if (!(c = a.$inject)) {
        c = [];
        if (a.length) {
          if (b)
            throw ((C(d) && d) || (d = a.name || ug(a)), za("strictdi", d));
          b = nd(a);
          r(b[1].split(jh), function (a) {
            a.replace(kh, function (a, b, d) {
              c.push(d);
            });
          });
        }
        a.$inject = c;
      }
    } else
      I(a)
        ? ((b = a.length - 1), sb(a[b], "fn"), (c = a.slice(0, b)))
        : sb(a, "fn", !0);
    return c;
  };
  var ge = M("$animate"),
    vf = function () {
      this.$get = A;
    },
    wf = function () {
      var a = new Hb(),
        b = [];
      this.$get = [
        "$$AnimateRunner",
        "$rootScope",
        function (d, c) {
          function e(a, b, c) {
            var d = !1;
            b &&
              ((b = C(b) ? b.split(" ") : I(b) ? b : []),
              r(b, function (b) {
                b && ((d = !0), (a[b] = c));
              }));
            return d;
          }
          function f() {
            r(b, function (b) {
              var c = a.get(b);
              if (c) {
                var d = vg(b.attr("class")),
                  e = "",
                  f = "";
                r(c, function (a, b) {
                  a !== !!d[b] &&
                    (a
                      ? (e += (e.length ? " " : "") + b)
                      : (f += (f.length ? " " : "") + b));
                });
                r(b, function (a) {
                  e && Db(a, e);
                  f && Cb(a, f);
                });
                a.delete(b);
              }
            });
            b.length = 0;
          }
          return {
            enabled: A,
            on: A,
            off: A,
            pin: A,
            push: function (g, k, h, l) {
              l && l();
              h = h || {};
              h.from && g.css(h.from);
              h.to && g.css(h.to);
              if (h.addClass || h.removeClass)
                if (
                  ((k = h.addClass),
                  (l = h.removeClass),
                  (h = a.get(g) || {}),
                  (k = e(h, k, !0)),
                  (l = e(h, l, !1)),
                  k || l)
                )
                  a.set(g, h), b.push(g), 1 === b.length && c.$$postDigest(f);
              g = new d();
              g.complete();
              return g;
            },
          };
        },
      ];
    },
    tf = [
      "$provide",
      function (a) {
        var b = this,
          d = null,
          c = null;
        this.$$registeredAnimations = Object.create(null);
        this.register = function (c, d) {
          if (c && "." !== c.charAt(0)) throw ge("notcsel", c);
          var g = c + "-animation";
          b.$$registeredAnimations[c.substr(1)] = g;
          a.factory(g, d);
        };
        this.customFilter = function (a) {
          1 === arguments.length && (c = z(a) ? a : null);
          return c;
        };
        this.classNameFilter = function (a) {
          if (
            1 === arguments.length &&
            (d = a instanceof RegExp ? a : null) &&
            /[(\s|\/)]ng-animate[(\s|\/)]/.test(d.toString())
          )
            throw ((d = null), ge("nongcls", "ng-animate"));
          return d;
        };
        this.$get = [
          "$$animateQueue",
          function (a) {
            function b(a, c, d) {
              if (d) {
                var e;
                a: {
                  for (e = 0; e < d.length; e++) {
                    var f = d[e];
                    if (1 === f.nodeType) {
                      e = f;
                      break a;
                    }
                  }
                  e = void 0;
                }
                !e || e.parentNode || e.previousElementSibling || (d = null);
              }
              d ? d.after(a) : c.prepend(a);
            }
            return {
              on: a.on,
              off: a.off,
              pin: a.pin,
              enabled: a.enabled,
              cancel: function (a) {
                a.cancel && a.cancel();
              },
              enter: function (c, d, h, l) {
                d = d && y(d);
                h = h && y(h);
                d = d || h.parent();
                b(c, d, h);
                return a.push(c, "enter", Ba(l));
              },
              move: function (c, d, h, l) {
                d = d && y(d);
                h = h && y(h);
                d = d || h.parent();
                b(c, d, h);
                return a.push(c, "move", Ba(l));
              },
              leave: function (b, c) {
                return a.push(b, "leave", Ba(c), function () {
                  b.remove();
                });
              },
              addClass: function (b, c, d) {
                d = Ba(d);
                d.addClass = hb(d.addclass, c);
                return a.push(b, "addClass", d);
              },
              removeClass: function (b, c, d) {
                d = Ba(d);
                d.removeClass = hb(d.removeClass, c);
                return a.push(b, "removeClass", d);
              },
              setClass: function (b, c, d, f) {
                f = Ba(f);
                f.addClass = hb(f.addClass, c);
                f.removeClass = hb(f.removeClass, d);
                return a.push(b, "setClass", f);
              },
              animate: function (b, c, d, f, m) {
                m = Ba(m);
                m.from = m.from ? R(m.from, c) : c;
                m.to = m.to ? R(m.to, d) : d;
                m.tempClasses = hb(m.tempClasses, f || "ng-inline-animate");
                return a.push(b, "animate", m);
              },
            };
          },
        ];
      },
    ],
    yf = function () {
      this.$get = [
        "$$rAF",
        function (a) {
          function b(b) {
            d.push(b);
            1 < d.length ||
              a(function () {
                for (var a = 0; a < d.length; a++) d[a]();
                d = [];
              });
          }
          var d = [];
          return function () {
            var a = !1;
            b(function () {
              a = !0;
            });
            return function (d) {
              a ? d() : b(d);
            };
          };
        },
      ];
    },
    xf = function () {
      this.$get = [
        "$q",
        "$sniffer",
        "$$animateAsyncRun",
        "$$isDocumentHidden",
        "$timeout",
        function (a, b, d, c, e) {
          function f(a) {
            this.setHost(a);
            var b = d();
            this._doneCallbacks = [];
            this._tick = function (a) {
              c() ? e(a, 0, !1) : b(a);
            };
            this._state = 0;
          }
          f.chain = function (a, b) {
            function c() {
              if (d === a.length) b(!0);
              else
                a[d](function (a) {
                  !1 === a ? b(!1) : (d++, c());
                });
            }
            var d = 0;
            c();
          };
          f.all = function (a, b) {
            function c(f) {
              e = e && f;
              ++d === a.length && b(e);
            }
            var d = 0,
              e = !0;
            r(a, function (a) {
              a.done(c);
            });
          };
          f.prototype = {
            setHost: function (a) {
              this.host = a || {};
            },
            done: function (a) {
              2 === this._state ? a() : this._doneCallbacks.push(a);
            },
            progress: A,
            getPromise: function () {
              if (!this.promise) {
                var b = this;
                this.promise = a(function (a, c) {
                  b.done(function (b) {
                    !1 === b ? c() : a();
                  });
                });
              }
              return this.promise;
            },
            then: function (a, b) {
              return this.getPromise().then(a, b);
            },
            catch: function (a) {
              return this.getPromise()["catch"](a);
            },
            finally: function (a) {
              return this.getPromise()["finally"](a);
            },
            pause: function () {
              this.host.pause && this.host.pause();
            },
            resume: function () {
              this.host.resume && this.host.resume();
            },
            end: function () {
              this.host.end && this.host.end();
              this._resolve(!0);
            },
            cancel: function () {
              this.host.cancel && this.host.cancel();
              this._resolve(!1);
            },
            complete: function (a) {
              var b = this;
              0 === b._state &&
                ((b._state = 1),
                b._tick(function () {
                  b._resolve(a);
                }));
            },
            _resolve: function (a) {
              2 !== this._state &&
                (r(this._doneCallbacks, function (b) {
                  b(a);
                }),
                (this._doneCallbacks.length = 0),
                (this._state = 2));
            },
          };
          return f;
        },
      ];
    },
    uf = function () {
      this.$get = [
        "$$rAF",
        "$q",
        "$$AnimateRunner",
        function (a, b, d) {
          return function (b, e) {
            function f() {
              a(function () {
                g.addClass && (b.addClass(g.addClass), (g.addClass = null));
                g.removeClass &&
                  (b.removeClass(g.removeClass), (g.removeClass = null));
                g.to && (b.css(g.to), (g.to = null));
                k || h.complete();
                k = !0;
              });
              return h;
            }
            var g = e || {};
            g.$$prepared || (g = Ha(g));
            g.cleanupStyles && (g.from = g.to = null);
            g.from && (b.css(g.from), (g.from = null));
            var k,
              h = new d();
            return { start: f, end: f };
          };
        },
      ];
    },
    aa = M("$compile"),
    sc = new (function () {})();
  Wc.$inject = ["$provide", "$$sanitizeUriProvider"];
  Jb.prototype.isFirstChange = function () {
    return this.previousValue === sc;
  };
  var od = /^((?:x|data)[:\-_])/i,
    Ag = /[:\-_]+(.)/g,
    ud = M("$controller"),
    td = /^(\S+)(\s+as\s+([\w$]+))?$/,
    Ff = function () {
      this.$get = [
        "$document",
        function (a) {
          return function (b) {
            b ? !b.nodeType && b instanceof y && (b = b[0]) : (b = a[0].body);
            return b.offsetWidth + 1;
          };
        },
      ];
    },
    vd = "application/json",
    vc = { "Content-Type": vd + ";charset=utf-8" },
    Dg = /^\[|^\{(?!\{)/,
    Eg = { "[": /]$/, "{": /}$/ },
    Cg = /^\)]\}',?\n/,
    Kb = M("$http"),
    Ca = (ea.$interpolateMinErr = M("$interpolate"));
  Ca.throwNoconcat = function (a) {
    throw Ca("noconcat", a);
  };
  Ca.interr = function (a, b) {
    return Ca("interr", a, b.toString());
  };
  var Hg = M("$interval"),
    Of = function () {
      this.$get = function () {
        function a(a) {
          var b = function (a) {
            b.data = a;
            b.called = !0;
          };
          b.id = a;
          return b;
        }
        var b = ea.callbacks,
          d = {};
        return {
          createCallback: function (c) {
            c = "_" + (b.$$counter++).toString(36);
            var e = "angular.callbacks." + c,
              f = a(c);
            d[e] = b[c] = f;
            return e;
          },
          wasCalled: function (a) {
            return d[a].called;
          },
          getResponse: function (a) {
            return d[a].data;
          },
          removeCallback: function (a) {
            delete b[d[a].id];
            delete d[a];
          },
        };
      };
    },
    lh = /^([^?#]*)(\?([^#]*))?(#(.*))?$/,
    Ig = { http: 80, https: 443, ftp: 21 },
    jb = M("$location"),
    Jg = /^\s*[\\/]{2,}/,
    mh = {
      $$absUrl: "",
      $$html5: !1,
      $$replace: !1,
      $$compose: function () {
        for (
          var a = this.$$path,
            b = this.$$hash,
            d = ve(this.$$search),
            b = b ? "#" + gc(b) : "",
            a = a.split("/"),
            c = a.length;
          c--;

        )
          a[c] = gc(a[c].replace(/%2F/g, "/"));
        this.$$url = a.join("/") + (d ? "?" + d : "") + b;
        this.$$absUrl = this.$$normalizeUrl(this.$$url);
        this.$$urlUpdatedByLocation = !0;
      },
      absUrl: Lb("$$absUrl"),
      url: function (a) {
        if (x(a)) return this.$$url;
        var b = lh.exec(a);
        (b[1] || "" === a) && this.path(decodeURIComponent(b[1]));
        (b[2] || b[1] || "" === a) && this.search(b[3] || "");
        this.hash(b[5] || "");
        return this;
      },
      protocol: Lb("$$protocol"),
      host: Lb("$$host"),
      port: Lb("$$port"),
      path: Cd("$$path", function (a) {
        a = null !== a ? a.toString() : "";
        return "/" === a.charAt(0) ? a : "/" + a;
      }),
      search: function (a, b) {
        switch (arguments.length) {
          case 0:
            return this.$$search;
          case 1:
            if (C(a) || ba(a)) (a = a.toString()), (this.$$search = fc(a));
            else if (F(a))
              (a = Ha(a, {})),
                r(a, function (b, c) {
                  null == b && delete a[c];
                }),
                (this.$$search = a);
            else throw jb("isrcharg");
            break;
          default:
            x(b) || null === b
              ? delete this.$$search[a]
              : (this.$$search[a] = b);
        }
        this.$$compose();
        return this;
      },
      hash: Cd("$$hash", function (a) {
        return null !== a ? a.toString() : "";
      }),
      replace: function () {
        this.$$replace = !0;
        return this;
      },
    };
  r([Bd, yc, xc], function (a) {
    a.prototype = Object.create(mh);
    a.prototype.state = function (b) {
      if (!arguments.length) return this.$$state;
      if (a !== xc || !this.$$html5) throw jb("nostate");
      this.$$state = x(b) ? null : b;
      this.$$urlUpdatedByLocation = !0;
      return this;
    };
  });
  var Ya = M("$parse"),
    Ng = {}.constructor.prototype.valueOf,
    Tb = S();
  r("+ - * / % === !== == != < > <= >= && || ! = |".split(" "), function (a) {
    Tb[a] = !0;
  });
  var nh = { n: "\n", f: "\f", r: "\r", t: "\t", v: "\v", "'": "'", '"': '"' },
    Nb = function (a) {
      this.options = a;
    };
  Nb.prototype = {
    constructor: Nb,
    lex: function (a) {
      this.text = a;
      this.index = 0;
      for (this.tokens = []; this.index < this.text.length; )
        if (((a = this.text.charAt(this.index)), '"' === a || "'" === a))
          this.readString(a);
        else if (this.isNumber(a) || ("." === a && this.isNumber(this.peek())))
          this.readNumber();
        else if (this.isIdentifierStart(this.peekMultichar())) this.readIdent();
        else if (this.is(a, "(){}[].,;:?"))
          this.tokens.push({ index: this.index, text: a }), this.index++;
        else if (this.isWhitespace(a)) this.index++;
        else {
          var b = a + this.peek(),
            d = b + this.peek(2),
            c = Tb[b],
            e = Tb[d];
          Tb[a] || c || e
            ? ((a = e ? d : c ? b : a),
              this.tokens.push({ index: this.index, text: a, operator: !0 }),
              (this.index += a.length))
            : this.throwError(
                "Unexpected next character ",
                this.index,
                this.index + 1
              );
        }
      return this.tokens;
    },
    is: function (a, b) {
      return -1 !== b.indexOf(a);
    },
    peek: function (a) {
      a = a || 1;
      return this.index + a < this.text.length
        ? this.text.charAt(this.index + a)
        : !1;
    },
    isNumber: function (a) {
      return "0" <= a && "9" >= a && "string" === typeof a;
    },
    isWhitespace: function (a) {
      return (
        " " === a ||
        "\r" === a ||
        "\t" === a ||
        "\n" === a ||
        "\v" === a ||
        "\u00a0" === a
      );
    },
    isIdentifierStart: function (a) {
      return this.options.isIdentifierStart
        ? this.options.isIdentifierStart(a, this.codePointAt(a))
        : this.isValidIdentifierStart(a);
    },
    isValidIdentifierStart: function (a) {
      return (
        ("a" <= a && "z" >= a) ||
        ("A" <= a && "Z" >= a) ||
        "_" === a ||
        "$" === a
      );
    },
    isIdentifierContinue: function (a) {
      return this.options.isIdentifierContinue
        ? this.options.isIdentifierContinue(a, this.codePointAt(a))
        : this.isValidIdentifierContinue(a);
    },
    isValidIdentifierContinue: function (a, b) {
      return this.isValidIdentifierStart(a, b) || this.isNumber(a);
    },
    codePointAt: function (a) {
      return 1 === a.length
        ? a.charCodeAt(0)
        : (a.charCodeAt(0) << 10) + a.charCodeAt(1) - 56613888;
    },
    peekMultichar: function () {
      var a = this.text.charAt(this.index),
        b = this.peek();
      if (!b) return a;
      var d = a.charCodeAt(0),
        c = b.charCodeAt(0);
      return 55296 <= d && 56319 >= d && 56320 <= c && 57343 >= c ? a + b : a;
    },
    isExpOperator: function (a) {
      return "-" === a || "+" === a || this.isNumber(a);
    },
    throwError: function (a, b, d) {
      d = d || this.index;
      b = v(b)
        ? "s " + b + "-" + this.index + " [" + this.text.substring(b, d) + "]"
        : " " + d;
      throw Ya("lexerr", a, b, this.text);
    },
    readNumber: function () {
      for (var a = "", b = this.index; this.index < this.text.length; ) {
        var d = O(this.text.charAt(this.index));
        if ("." === d || this.isNumber(d)) a += d;
        else {
          var c = this.peek();
          if ("e" === d && this.isExpOperator(c)) a += d;
          else if (
            this.isExpOperator(d) &&
            c &&
            this.isNumber(c) &&
            "e" === a.charAt(a.length - 1)
          )
            a += d;
          else if (
            !this.isExpOperator(d) ||
            (c && this.isNumber(c)) ||
            "e" !== a.charAt(a.length - 1)
          )
            break;
          else this.throwError("Invalid exponent");
        }
        this.index++;
      }
      this.tokens.push({ index: b, text: a, constant: !0, value: Number(a) });
    },
    readIdent: function () {
      var a = this.index;
      for (
        this.index += this.peekMultichar().length;
        this.index < this.text.length;

      ) {
        var b = this.peekMultichar();
        if (!this.isIdentifierContinue(b)) break;
        this.index += b.length;
      }
      this.tokens.push({
        index: a,
        text: this.text.slice(a, this.index),
        identifier: !0,
      });
    },
    readString: function (a) {
      var b = this.index;
      this.index++;
      for (var d = "", c = a, e = !1; this.index < this.text.length; ) {
        var f = this.text.charAt(this.index),
          c = c + f;
        if (e)
          "u" === f
            ? ((e = this.text.substring(this.index + 1, this.index + 5)),
              e.match(/[\da-f]{4}/i) ||
                this.throwError("Invalid unicode escape [\\u" + e + "]"),
              (this.index += 4),
              (d += String.fromCharCode(parseInt(e, 16))))
            : (d += nh[f] || f),
            (e = !1);
        else if ("\\" === f) e = !0;
        else {
          if (f === a) {
            this.index++;
            this.tokens.push({ index: b, text: c, constant: !0, value: d });
            return;
          }
          d += f;
        }
        this.index++;
      }
      this.throwError("Unterminated quote", b);
    },
  };
  var p = function (a, b) {
    this.lexer = a;
    this.options = b;
  };
  p.Program = "Program";
  p.ExpressionStatement = "ExpressionStatement";
  p.AssignmentExpression = "AssignmentExpression";
  p.ConditionalExpression = "ConditionalExpression";
  p.LogicalExpression = "LogicalExpression";
  p.BinaryExpression = "BinaryExpression";
  p.UnaryExpression = "UnaryExpression";
  p.CallExpression = "CallExpression";
  p.MemberExpression = "MemberExpression";
  p.Identifier = "Identifier";
  p.Literal = "Literal";
  p.ArrayExpression = "ArrayExpression";
  p.Property = "Property";
  p.ObjectExpression = "ObjectExpression";
  p.ThisExpression = "ThisExpression";
  p.LocalsExpression = "LocalsExpression";
  p.NGValueParameter = "NGValueParameter";
  p.prototype = {
    ast: function (a) {
      this.text = a;
      this.tokens = this.lexer.lex(a);
      a = this.program();
      0 !== this.tokens.length &&
        this.throwError("is an unexpected token", this.tokens[0]);
      return a;
    },
    program: function () {
      for (var a = []; ; )
        if (
          (0 < this.tokens.length &&
            !this.peek("}", ")", ";", "]") &&
            a.push(this.expressionStatement()),
          !this.expect(";"))
        )
          return { type: p.Program, body: a };
    },
    expressionStatement: function () {
      return { type: p.ExpressionStatement, expression: this.filterChain() };
    },
    filterChain: function () {
      for (var a = this.expression(); this.expect("|"); ) a = this.filter(a);
      return a;
    },
    expression: function () {
      return this.assignment();
    },
    assignment: function () {
      var a = this.ternary();
      if (this.expect("=")) {
        if (!Gd(a)) throw Ya("lval");
        a = {
          type: p.AssignmentExpression,
          left: a,
          right: this.assignment(),
          operator: "=",
        };
      }
      return a;
    },
    ternary: function () {
      var a = this.logicalOR(),
        b,
        d;
      return this.expect("?") && ((b = this.expression()), this.consume(":"))
        ? ((d = this.expression()),
          {
            type: p.ConditionalExpression,
            test: a,
            alternate: b,
            consequent: d,
          })
        : a;
    },
    logicalOR: function () {
      for (var a = this.logicalAND(); this.expect("||"); )
        a = {
          type: p.LogicalExpression,
          operator: "||",
          left: a,
          right: this.logicalAND(),
        };
      return a;
    },
    logicalAND: function () {
      for (var a = this.equality(); this.expect("&&"); )
        a = {
          type: p.LogicalExpression,
          operator: "&&",
          left: a,
          right: this.equality(),
        };
      return a;
    },
    equality: function () {
      for (
        var a = this.relational(), b;
        (b = this.expect("==", "!=", "===", "!=="));

      )
        a = {
          type: p.BinaryExpression,
          operator: b.text,
          left: a,
          right: this.relational(),
        };
      return a;
    },
    relational: function () {
      for (
        var a = this.additive(), b;
        (b = this.expect("<", ">", "<=", ">="));

      )
        a = {
          type: p.BinaryExpression,
          operator: b.text,
          left: a,
          right: this.additive(),
        };
      return a;
    },
    additive: function () {
      for (var a = this.multiplicative(), b; (b = this.expect("+", "-")); )
        a = {
          type: p.BinaryExpression,
          operator: b.text,
          left: a,
          right: this.multiplicative(),
        };
      return a;
    },
    multiplicative: function () {
      for (var a = this.unary(), b; (b = this.expect("*", "/", "%")); )
        a = {
          type: p.BinaryExpression,
          operator: b.text,
          left: a,
          right: this.unary(),
        };
      return a;
    },
    unary: function () {
      var a;
      return (a = this.expect("+", "-", "!"))
        ? {
            type: p.UnaryExpression,
            operator: a.text,
            prefix: !0,
            argument: this.unary(),
          }
        : this.primary();
    },
    primary: function () {
      var a;
      this.expect("(")
        ? ((a = this.filterChain()), this.consume(")"))
        : this.expect("[")
        ? (a = this.arrayDeclaration())
        : this.expect("{")
        ? (a = this.object())
        : this.selfReferential.hasOwnProperty(this.peek().text)
        ? (a = Ha(this.selfReferential[this.consume().text]))
        : this.options.literals.hasOwnProperty(this.peek().text)
        ? (a = {
            type: p.Literal,
            value: this.options.literals[this.consume().text],
          })
        : this.peek().identifier
        ? (a = this.identifier())
        : this.peek().constant
        ? (a = this.constant())
        : this.throwError("not a primary expression", this.peek());
      for (var b; (b = this.expect("(", "[", ".")); )
        "(" === b.text
          ? ((a = {
              type: p.CallExpression,
              callee: a,
              arguments: this.parseArguments(),
            }),
            this.consume(")"))
          : "[" === b.text
          ? ((a = {
              type: p.MemberExpression,
              object: a,
              property: this.expression(),
              computed: !0,
            }),
            this.consume("]"))
          : "." === b.text
          ? (a = {
              type: p.MemberExpression,
              object: a,
              property: this.identifier(),
              computed: !1,
            })
          : this.throwError("IMPOSSIBLE");
      return a;
    },
    filter: function (a) {
      a = [a];
      for (
        var b = {
          type: p.CallExpression,
          callee: this.identifier(),
          arguments: a,
          filter: !0,
        };
        this.expect(":");

      )
        a.push(this.expression());
      return b;
    },
    parseArguments: function () {
      var a = [];
      if (")" !== this.peekToken().text) {
        do a.push(this.filterChain());
        while (this.expect(","));
      }
      return a;
    },
    identifier: function () {
      var a = this.consume();
      a.identifier || this.throwError("is not a valid identifier", a);
      return { type: p.Identifier, name: a.text };
    },
    constant: function () {
      return { type: p.Literal, value: this.consume().value };
    },
    arrayDeclaration: function () {
      var a = [];
      if ("]" !== this.peekToken().text) {
        do {
          if (this.peek("]")) break;
          a.push(this.expression());
        } while (this.expect(","));
      }
      this.consume("]");
      return { type: p.ArrayExpression, elements: a };
    },
    object: function () {
      var a = [],
        b;
      if ("}" !== this.peekToken().text) {
        do {
          if (this.peek("}")) break;
          b = { type: p.Property, kind: "init" };
          this.peek().constant
            ? ((b.key = this.constant()),
              (b.computed = !1),
              this.consume(":"),
              (b.value = this.expression()))
            : this.peek().identifier
            ? ((b.key = this.identifier()),
              (b.computed = !1),
              this.peek(":")
                ? (this.consume(":"), (b.value = this.expression()))
                : (b.value = b.key))
            : this.peek("[")
            ? (this.consume("["),
              (b.key = this.expression()),
              this.consume("]"),
              (b.computed = !0),
              this.consume(":"),
              (b.value = this.expression()))
            : this.throwError("invalid key", this.peek());
          a.push(b);
        } while (this.expect(","));
      }
      this.consume("}");
      return { type: p.ObjectExpression, properties: a };
    },
    throwError: function (a, b) {
      throw Ya(
        "syntax",
        b.text,
        a,
        b.index + 1,
        this.text,
        this.text.substring(b.index)
      );
    },
    consume: function (a) {
      if (0 === this.tokens.length) throw Ya("ueoe", this.text);
      var b = this.expect(a);
      b || this.throwError("is unexpected, expecting [" + a + "]", this.peek());
      return b;
    },
    peekToken: function () {
      if (0 === this.tokens.length) throw Ya("ueoe", this.text);
      return this.tokens[0];
    },
    peek: function (a, b, d, c) {
      return this.peekAhead(0, a, b, d, c);
    },
    peekAhead: function (a, b, d, c, e) {
      if (this.tokens.length > a) {
        a = this.tokens[a];
        var f = a.text;
        if (f === b || f === d || f === c || f === e || !(b || d || c || e))
          return a;
      }
      return !1;
    },
    expect: function (a, b, d, c) {
      return (a = this.peek(a, b, d, c)) ? (this.tokens.shift(), a) : !1;
    },
    selfReferential: {
      this: { type: p.ThisExpression },
      $locals: { type: p.LocalsExpression },
    },
  };
  var Ed = 2;
  Id.prototype = {
    compile: function (a) {
      var b = this;
      this.state = {
        nextId: 0,
        filters: {},
        fn: { vars: [], body: [], own: {} },
        assign: { vars: [], body: [], own: {} },
        inputs: [],
      };
      Y(a, b.$filter);
      var d = "",
        c;
      this.stage = "assign";
      if ((c = Hd(a)))
        (this.state.computing = "assign"),
          (d = this.nextId()),
          this.recurse(c, d),
          this.return_(d),
          (d = "fn.assign=" + this.generateFunction("assign", "s,v,l"));
      c = Fd(a.body);
      b.stage = "inputs";
      r(c, function (a, c) {
        var d = "fn" + c;
        b.state[d] = { vars: [], body: [], own: {} };
        b.state.computing = d;
        var k = b.nextId();
        b.recurse(a, k);
        b.return_(k);
        b.state.inputs.push({ name: d, isPure: a.isPure });
        a.watchId = c;
      });
      this.state.computing = "fn";
      this.stage = "main";
      this.recurse(a);
      a =
        '"' +
        this.USE +
        " " +
        this.STRICT +
        '";\n' +
        this.filterPrefix() +
        "var fn=" +
        this.generateFunction("fn", "s,l,a,i") +
        d +
        this.watchFns() +
        "return fn;";
      a = new Function("$filter", "getStringValue", "ifDefined", "plus", a)(
        this.$filter,
        Kg,
        Lg,
        Dd
      );
      this.state = this.stage = void 0;
      return a;
    },
    USE: "use",
    STRICT: "strict",
    watchFns: function () {
      var a = [],
        b = this.state.inputs,
        d = this;
      r(b, function (b) {
        a.push("var " + b.name + "=" + d.generateFunction(b.name, "s"));
        b.isPure && a.push(b.name, ".isPure=" + JSON.stringify(b.isPure) + ";");
      });
      b.length &&
        a.push(
          "fn.inputs=[" +
            b
              .map(function (a) {
                return a.name;
              })
              .join(",") +
            "];"
        );
      return a.join("");
    },
    generateFunction: function (a, b) {
      return "function(" + b + "){" + this.varsPrefix(a) + this.body(a) + "};";
    },
    filterPrefix: function () {
      var a = [],
        b = this;
      r(this.state.filters, function (d, c) {
        a.push(d + "=$filter(" + b.escape(c) + ")");
      });
      return a.length ? "var " + a.join(",") + ";" : "";
    },
    varsPrefix: function (a) {
      return this.state[a].vars.length
        ? "var " + this.state[a].vars.join(",") + ";"
        : "";
    },
    body: function (a) {
      return this.state[a].body.join("");
    },
    recurse: function (a, b, d, c, e, f) {
      var g,
        k,
        h = this,
        l,
        m,
        q;
      c = c || A;
      if (!f && v(a.watchId))
        (b = b || this.nextId()),
          this.if_(
            "i",
            this.lazyAssign(b, this.computedMember("i", a.watchId)),
            this.lazyRecurse(a, b, d, c, e, !0)
          );
      else
        switch (a.type) {
          case p.Program:
            r(a.body, function (b, c) {
              h.recurse(b.expression, void 0, void 0, function (a) {
                k = a;
              });
              c !== a.body.length - 1
                ? h.current().body.push(k, ";")
                : h.return_(k);
            });
            break;
          case p.Literal:
            m = this.escape(a.value);
            this.assign(b, m);
            c(b || m);
            break;
          case p.UnaryExpression:
            this.recurse(a.argument, void 0, void 0, function (a) {
              k = a;
            });
            m = a.operator + "(" + this.ifDefined(k, 0) + ")";
            this.assign(b, m);
            c(m);
            break;
          case p.BinaryExpression:
            this.recurse(a.left, void 0, void 0, function (a) {
              g = a;
            });
            this.recurse(a.right, void 0, void 0, function (a) {
              k = a;
            });
            m =
              "+" === a.operator
                ? this.plus(g, k)
                : "-" === a.operator
                ? this.ifDefined(g, 0) + a.operator + this.ifDefined(k, 0)
                : "(" + g + ")" + a.operator + "(" + k + ")";
            this.assign(b, m);
            c(m);
            break;
          case p.LogicalExpression:
            b = b || this.nextId();
            h.recurse(a.left, b);
            h.if_(
              "&&" === a.operator ? b : h.not(b),
              h.lazyRecurse(a.right, b)
            );
            c(b);
            break;
          case p.ConditionalExpression:
            b = b || this.nextId();
            h.recurse(a.test, b);
            h.if_(
              b,
              h.lazyRecurse(a.alternate, b),
              h.lazyRecurse(a.consequent, b)
            );
            c(b);
            break;
          case p.Identifier:
            b = b || this.nextId();
            d &&
              ((d.context =
                "inputs" === h.stage
                  ? "s"
                  : this.assign(
                      this.nextId(),
                      this.getHasOwnProperty("l", a.name) + "?l:s"
                    )),
              (d.computed = !1),
              (d.name = a.name));
            h.if_(
              "inputs" === h.stage || h.not(h.getHasOwnProperty("l", a.name)),
              function () {
                h.if_("inputs" === h.stage || "s", function () {
                  e &&
                    1 !== e &&
                    h.if_(
                      h.isNull(h.nonComputedMember("s", a.name)),
                      h.lazyAssign(h.nonComputedMember("s", a.name), "{}")
                    );
                  h.assign(b, h.nonComputedMember("s", a.name));
                });
              },
              b && h.lazyAssign(b, h.nonComputedMember("l", a.name))
            );
            c(b);
            break;
          case p.MemberExpression:
            g = (d && (d.context = this.nextId())) || this.nextId();
            b = b || this.nextId();
            h.recurse(
              a.object,
              g,
              void 0,
              function () {
                h.if_(
                  h.notNull(g),
                  function () {
                    a.computed
                      ? ((k = h.nextId()),
                        h.recurse(a.property, k),
                        h.getStringValue(k),
                        e &&
                          1 !== e &&
                          h.if_(
                            h.not(h.computedMember(g, k)),
                            h.lazyAssign(h.computedMember(g, k), "{}")
                          ),
                        (m = h.computedMember(g, k)),
                        h.assign(b, m),
                        d && ((d.computed = !0), (d.name = k)))
                      : (e &&
                          1 !== e &&
                          h.if_(
                            h.isNull(h.nonComputedMember(g, a.property.name)),
                            h.lazyAssign(
                              h.nonComputedMember(g, a.property.name),
                              "{}"
                            )
                          ),
                        (m = h.nonComputedMember(g, a.property.name)),
                        h.assign(b, m),
                        d && ((d.computed = !1), (d.name = a.property.name)));
                  },
                  function () {
                    h.assign(b, "undefined");
                  }
                );
                c(b);
              },
              !!e
            );
            break;
          case p.CallExpression:
            b = b || this.nextId();
            a.filter
              ? ((k = h.filter(a.callee.name)),
                (l = []),
                r(a.arguments, function (a) {
                  var b = h.nextId();
                  h.recurse(a, b);
                  l.push(b);
                }),
                (m = k + "(" + l.join(",") + ")"),
                h.assign(b, m),
                c(b))
              : ((k = h.nextId()),
                (g = {}),
                (l = []),
                h.recurse(a.callee, k, g, function () {
                  h.if_(
                    h.notNull(k),
                    function () {
                      r(a.arguments, function (b) {
                        h.recurse(
                          b,
                          a.constant ? void 0 : h.nextId(),
                          void 0,
                          function (a) {
                            l.push(a);
                          }
                        );
                      });
                      m = g.name
                        ? h.member(g.context, g.name, g.computed) +
                          "(" +
                          l.join(",") +
                          ")"
                        : k + "(" + l.join(",") + ")";
                      h.assign(b, m);
                    },
                    function () {
                      h.assign(b, "undefined");
                    }
                  );
                  c(b);
                }));
            break;
          case p.AssignmentExpression:
            k = this.nextId();
            g = {};
            this.recurse(
              a.left,
              void 0,
              g,
              function () {
                h.if_(h.notNull(g.context), function () {
                  h.recurse(a.right, k);
                  m = h.member(g.context, g.name, g.computed) + a.operator + k;
                  h.assign(b, m);
                  c(b || m);
                });
              },
              1
            );
            break;
          case p.ArrayExpression:
            l = [];
            r(a.elements, function (b) {
              h.recurse(b, a.constant ? void 0 : h.nextId(), void 0, function (
                a
              ) {
                l.push(a);
              });
            });
            m = "[" + l.join(",") + "]";
            this.assign(b, m);
            c(b || m);
            break;
          case p.ObjectExpression:
            l = [];
            q = !1;
            r(a.properties, function (a) {
              a.computed && (q = !0);
            });
            q
              ? ((b = b || this.nextId()),
                this.assign(b, "{}"),
                r(a.properties, function (a) {
                  a.computed
                    ? ((g = h.nextId()), h.recurse(a.key, g))
                    : (g =
                        a.key.type === p.Identifier
                          ? a.key.name
                          : "" + a.key.value);
                  k = h.nextId();
                  h.recurse(a.value, k);
                  h.assign(h.member(b, g, a.computed), k);
                }))
              : (r(a.properties, function (b) {
                  h.recurse(
                    b.value,
                    a.constant ? void 0 : h.nextId(),
                    void 0,
                    function (a) {
                      l.push(
                        h.escape(
                          b.key.type === p.Identifier
                            ? b.key.name
                            : "" + b.key.value
                        ) +
                          ":" +
                          a
                      );
                    }
                  );
                }),
                (m = "{" + l.join(",") + "}"),
                this.assign(b, m));
            c(b || m);
            break;
          case p.ThisExpression:
            this.assign(b, "s");
            c(b || "s");
            break;
          case p.LocalsExpression:
            this.assign(b, "l");
            c(b || "l");
            break;
          case p.NGValueParameter:
            this.assign(b, "v"), c(b || "v");
        }
    },
    getHasOwnProperty: function (a, b) {
      var d = a + "." + b,
        c = this.current().own;
      c.hasOwnProperty(d) ||
        (c[d] = this.nextId(!1, a + "&&(" + this.escape(b) + " in " + a + ")"));
      return c[d];
    },
    assign: function (a, b) {
      if (a) return this.current().body.push(a, "=", b, ";"), a;
    },
    filter: function (a) {
      this.state.filters.hasOwnProperty(a) ||
        (this.state.filters[a] = this.nextId(!0));
      return this.state.filters[a];
    },
    ifDefined: function (a, b) {
      return "ifDefined(" + a + "," + this.escape(b) + ")";
    },
    plus: function (a, b) {
      return "plus(" + a + "," + b + ")";
    },
    return_: function (a) {
      this.current().body.push("return ", a, ";");
    },
    if_: function (a, b, d) {
      if (!0 === a) b();
      else {
        var c = this.current().body;
        c.push("if(", a, "){");
        b();
        c.push("}");
        d && (c.push("else{"), d(), c.push("}"));
      }
    },
    not: function (a) {
      return "!(" + a + ")";
    },
    isNull: function (a) {
      return a + "==null";
    },
    notNull: function (a) {
      return a + "!=null";
    },
    nonComputedMember: function (a, b) {
      var d = /[^$_a-zA-Z0-9]/g;
      return /^[$_a-zA-Z][$_a-zA-Z0-9]*$/.test(b)
        ? a + "." + b
        : a + '["' + b.replace(d, this.stringEscapeFn) + '"]';
    },
    computedMember: function (a, b) {
      return a + "[" + b + "]";
    },
    member: function (a, b, d) {
      return d ? this.computedMember(a, b) : this.nonComputedMember(a, b);
    },
    getStringValue: function (a) {
      this.assign(a, "getStringValue(" + a + ")");
    },
    lazyRecurse: function (a, b, d, c, e, f) {
      var g = this;
      return function () {
        g.recurse(a, b, d, c, e, f);
      };
    },
    lazyAssign: function (a, b) {
      var d = this;
      return function () {
        d.assign(a, b);
      };
    },
    stringEscapeRegex: /[^ a-zA-Z0-9]/g,
    stringEscapeFn: function (a) {
      return "\\u" + ("0000" + a.charCodeAt(0).toString(16)).slice(-4);
    },
    escape: function (a) {
      if (C(a))
        return (
          "'" + a.replace(this.stringEscapeRegex, this.stringEscapeFn) + "'"
        );
      if (ba(a)) return a.toString();
      if (!0 === a) return "true";
      if (!1 === a) return "false";
      if (null === a) return "null";
      if ("undefined" === typeof a) return "undefined";
      throw Ya("esc");
    },
    nextId: function (a, b) {
      var d = "v" + this.state.nextId++;
      a || this.current().vars.push(d + (b ? "=" + b : ""));
      return d;
    },
    current: function () {
      return this.state[this.state.computing];
    },
  };
  Jd.prototype = {
    compile: function (a) {
      var b = this;
      Y(a, b.$filter);
      var d, c;
      if ((d = Hd(a))) c = this.recurse(d);
      d = Fd(a.body);
      var e;
      d &&
        ((e = []),
        r(d, function (a, c) {
          var d = b.recurse(a);
          d.isPure = a.isPure;
          a.input = d;
          e.push(d);
          a.watchId = c;
        }));
      var f = [];
      r(a.body, function (a) {
        f.push(b.recurse(a.expression));
      });
      a =
        0 === a.body.length
          ? A
          : 1 === a.body.length
          ? f[0]
          : function (a, b) {
              var c;
              r(f, function (d) {
                c = d(a, b);
              });
              return c;
            };
      c &&
        (a.assign = function (a, b, d) {
          return c(a, d, b);
        });
      e && (a.inputs = e);
      return a;
    },
    recurse: function (a, b, d) {
      var c,
        e,
        f = this,
        g;
      if (a.input) return this.inputs(a.input, a.watchId);
      switch (a.type) {
        case p.Literal:
          return this.value(a.value, b);
        case p.UnaryExpression:
          return (
            (e = this.recurse(a.argument)), this["unary" + a.operator](e, b)
          );
        case p.BinaryExpression:
          return (
            (c = this.recurse(a.left)),
            (e = this.recurse(a.right)),
            this["binary" + a.operator](c, e, b)
          );
        case p.LogicalExpression:
          return (
            (c = this.recurse(a.left)),
            (e = this.recurse(a.right)),
            this["binary" + a.operator](c, e, b)
          );
        case p.ConditionalExpression:
          return this["ternary?:"](
            this.recurse(a.test),
            this.recurse(a.alternate),
            this.recurse(a.consequent),
            b
          );
        case p.Identifier:
          return f.identifier(a.name, b, d);
        case p.MemberExpression:
          return (
            (c = this.recurse(a.object, !1, !!d)),
            a.computed || (e = a.property.name),
            a.computed && (e = this.recurse(a.property)),
            a.computed
              ? this.computedMember(c, e, b, d)
              : this.nonComputedMember(c, e, b, d)
          );
        case p.CallExpression:
          return (
            (g = []),
            r(a.arguments, function (a) {
              g.push(f.recurse(a));
            }),
            a.filter && (e = this.$filter(a.callee.name)),
            a.filter || (e = this.recurse(a.callee, !0)),
            a.filter
              ? function (a, c, d, f) {
                  for (var q = [], n = 0; n < g.length; ++n)
                    q.push(g[n](a, c, d, f));
                  a = e.apply(void 0, q, f);
                  return b ? { context: void 0, name: void 0, value: a } : a;
                }
              : function (a, c, d, f) {
                  var q = e(a, c, d, f),
                    n;
                  if (null != q.value) {
                    n = [];
                    for (var s = 0; s < g.length; ++s) n.push(g[s](a, c, d, f));
                    n = q.value.apply(q.context, n);
                  }
                  return b ? { value: n } : n;
                }
          );
        case p.AssignmentExpression:
          return (
            (c = this.recurse(a.left, !0, 1)),
            (e = this.recurse(a.right)),
            function (a, d, f, g) {
              var q = c(a, d, f, g);
              a = e(a, d, f, g);
              q.context[q.name] = a;
              return b ? { value: a } : a;
            }
          );
        case p.ArrayExpression:
          return (
            (g = []),
            r(a.elements, function (a) {
              g.push(f.recurse(a));
            }),
            function (a, c, d, e) {
              for (var f = [], n = 0; n < g.length; ++n)
                f.push(g[n](a, c, d, e));
              return b ? { value: f } : f;
            }
          );
        case p.ObjectExpression:
          return (
            (g = []),
            r(a.properties, function (a) {
              a.computed
                ? g.push({
                    key: f.recurse(a.key),
                    computed: !0,
                    value: f.recurse(a.value),
                  })
                : g.push({
                    key:
                      a.key.type === p.Identifier
                        ? a.key.name
                        : "" + a.key.value,
                    computed: !1,
                    value: f.recurse(a.value),
                  });
            }),
            function (a, c, d, e) {
              for (var f = {}, n = 0; n < g.length; ++n)
                g[n].computed
                  ? (f[g[n].key(a, c, d, e)] = g[n].value(a, c, d, e))
                  : (f[g[n].key] = g[n].value(a, c, d, e));
              return b ? { value: f } : f;
            }
          );
        case p.ThisExpression:
          return function (a) {
            return b ? { value: a } : a;
          };
        case p.LocalsExpression:
          return function (a, c) {
            return b ? { value: c } : c;
          };
        case p.NGValueParameter:
          return function (a, c, d) {
            return b ? { value: d } : d;
          };
      }
    },
    "unary+": function (a, b) {
      return function (d, c, e, f) {
        d = a(d, c, e, f);
        d = v(d) ? +d : 0;
        return b ? { value: d } : d;
      };
    },
    "unary-": function (a, b) {
      return function (d, c, e, f) {
        d = a(d, c, e, f);
        d = v(d) ? -d : -0;
        return b ? { value: d } : d;
      };
    },
    "unary!": function (a, b) {
      return function (d, c, e, f) {
        d = !a(d, c, e, f);
        return b ? { value: d } : d;
      };
    },
    "binary+": function (a, b, d) {
      return function (c, e, f, g) {
        var k = a(c, e, f, g);
        c = b(c, e, f, g);
        k = Dd(k, c);
        return d ? { value: k } : k;
      };
    },
    "binary-": function (a, b, d) {
      return function (c, e, f, g) {
        var k = a(c, e, f, g);
        c = b(c, e, f, g);
        k = (v(k) ? k : 0) - (v(c) ? c : 0);
        return d ? { value: k } : k;
      };
    },
    "binary*": function (a, b, d) {
      return function (c, e, f, g) {
        c = a(c, e, f, g) * b(c, e, f, g);
        return d ? { value: c } : c;
      };
    },
    "binary/": function (a, b, d) {
      return function (c, e, f, g) {
        c = a(c, e, f, g) / b(c, e, f, g);
        return d ? { value: c } : c;
      };
    },
    "binary%": function (a, b, d) {
      return function (c, e, f, g) {
        c = a(c, e, f, g) % b(c, e, f, g);
        return d ? { value: c } : c;
      };
    },
    "binary===": function (a, b, d) {
      return function (c, e, f, g) {
        c = a(c, e, f, g) === b(c, e, f, g);
        return d ? { value: c } : c;
      };
    },
    "binary!==": function (a, b, d) {
      return function (c, e, f, g) {
        c = a(c, e, f, g) !== b(c, e, f, g);
        return d ? { value: c } : c;
      };
    },
    "binary==": function (a, b, d) {
      return function (c, e, f, g) {
        c = a(c, e, f, g) == b(c, e, f, g);
        return d ? { value: c } : c;
      };
    },
    "binary!=": function (a, b, d) {
      return function (c, e, f, g) {
        c = a(c, e, f, g) != b(c, e, f, g);
        return d ? { value: c } : c;
      };
    },
    "binary<": function (a, b, d) {
      return function (c, e, f, g) {
        c = a(c, e, f, g) < b(c, e, f, g);
        return d ? { value: c } : c;
      };
    },
    "binary>": function (a, b, d) {
      return function (c, e, f, g) {
        c = a(c, e, f, g) > b(c, e, f, g);
        return d ? { value: c } : c;
      };
    },
    "binary<=": function (a, b, d) {
      return function (c, e, f, g) {
        c = a(c, e, f, g) <= b(c, e, f, g);
        return d ? { value: c } : c;
      };
    },
    "binary>=": function (a, b, d) {
      return function (c, e, f, g) {
        c = a(c, e, f, g) >= b(c, e, f, g);
        return d ? { value: c } : c;
      };
    },
    "binary&&": function (a, b, d) {
      return function (c, e, f, g) {
        c = a(c, e, f, g) && b(c, e, f, g);
        return d ? { value: c } : c;
      };
    },
    "binary||": function (a, b, d) {
      return function (c, e, f, g) {
        c = a(c, e, f, g) || b(c, e, f, g);
        return d ? { value: c } : c;
      };
    },
    "ternary?:": function (a, b, d, c) {
      return function (e, f, g, k) {
        e = a(e, f, g, k) ? b(e, f, g, k) : d(e, f, g, k);
        return c ? { value: e } : e;
      };
    },
    value: function (a, b) {
      return function () {
        return b ? { context: void 0, name: void 0, value: a } : a;
      };
    },
    identifier: function (a, b, d) {
      return function (c, e, f, g) {
        c = e && a in e ? e : c;
        d && 1 !== d && c && null == c[a] && (c[a] = {});
        e = c ? c[a] : void 0;
        return b ? { context: c, name: a, value: e } : e;
      };
    },
    computedMember: function (a, b, d, c) {
      return function (e, f, g, k) {
        var h = a(e, f, g, k),
          l,
          m;
        null != h &&
          ((l = b(e, f, g, k)),
          (l += ""),
          c && 1 !== c && h && !h[l] && (h[l] = {}),
          (m = h[l]));
        return d ? { context: h, name: l, value: m } : m;
      };
    },
    nonComputedMember: function (a, b, d, c) {
      return function (e, f, g, k) {
        e = a(e, f, g, k);
        c && 1 !== c && e && null == e[b] && (e[b] = {});
        f = null != e ? e[b] : void 0;
        return d ? { context: e, name: b, value: f } : f;
      };
    },
    inputs: function (a, b) {
      return function (d, c, e, f) {
        return f ? f[b] : a(d, c, e);
      };
    },
  };
  Mb.prototype = {
    constructor: Mb,
    parse: function (a) {
      a = this.getAst(a);
      var b = this.astCompiler.compile(a.ast),
        d = a.ast;
      b.literal =
        0 === d.body.length ||
        (1 === d.body.length &&
          (d.body[0].expression.type === p.Literal ||
            d.body[0].expression.type === p.ArrayExpression ||
            d.body[0].expression.type === p.ObjectExpression));
      b.constant = a.ast.constant;
      b.oneTime = a.oneTime;
      return b;
    },
    getAst: function (a) {
      var b = !1;
      a = a.trim();
      ":" === a.charAt(0) &&
        ":" === a.charAt(1) &&
        ((b = !0), (a = a.substring(2)));
      return { ast: this.ast.ast(a), oneTime: b };
    },
  };
  var Da = M("$sce"),
    U = {
      HTML: "html",
      CSS: "css",
      MEDIA_URL: "mediaUrl",
      URL: "url",
      RESOURCE_URL: "resourceUrl",
      JS: "js",
    },
    Bc = /_([a-z])/g,
    Qg = M("$templateRequest"),
    Rg = M("$timeout"),
    $ = B.document.createElement("a"),
    Nd = la(B.location.href),
    La;
  Od.$inject = ["$document"];
  cd.$inject = ["$provide"];
  var Vd = 22,
    Ud = ".",
    Dc = "0";
  Pd.$inject = ["$locale"];
  Rd.$inject = ["$locale"];
  var bh = {
      yyyy: ga("FullYear", 4, 0, !1, !0),
      yy: ga("FullYear", 2, 0, !0, !0),
      y: ga("FullYear", 1, 0, !1, !0),
      MMMM: kb("Month"),
      MMM: kb("Month", !0),
      MM: ga("Month", 2, 1),
      M: ga("Month", 1, 1),
      LLLL: kb("Month", !1, !0),
      dd: ga("Date", 2),
      d: ga("Date", 1),
      HH: ga("Hours", 2),
      H: ga("Hours", 1),
      hh: ga("Hours", 2, -12),
      h: ga("Hours", 1, -12),
      mm: ga("Minutes", 2),
      m: ga("Minutes", 1),
      ss: ga("Seconds", 2),
      s: ga("Seconds", 1),
      sss: ga("Milliseconds", 3),
      EEEE: kb("Day"),
      EEE: kb("Day", !0),
      a: function (a, b) {
        return 12 > a.getHours() ? b.AMPMS[0] : b.AMPMS[1];
      },
      Z: function (a, b, d) {
        a = -1 * d;
        return (a =
          (0 <= a ? "+" : "") +
          (Ob(Math[0 < a ? "floor" : "ceil"](a / 60), 2) +
            Ob(Math.abs(a % 60), 2)));
      },
      ww: Xd(2),
      w: Xd(1),
      G: Ec,
      GG: Ec,
      GGG: Ec,
      GGGG: function (a, b) {
        return 0 >= a.getFullYear() ? b.ERANAMES[0] : b.ERANAMES[1];
      },
    },
    ah = /((?:[^yMLdHhmsaZEwG']+)|(?:'(?:[^']|'')*')|(?:E+|y+|M+|L+|d+|H+|h+|m+|s+|a|Z|G+|w+))([\s\S]*)/,
    $g = /^-?\d+$/;
  Qd.$inject = ["$locale"];
  var Vg = ia(O),
    Wg = ia(ub);
  Sd.$inject = ["$parse"];
  var Je = ia({
      restrict: "E",
      compile: function (a, b) {
        if (!b.href && !b.xlinkHref)
          return function (a, b) {
            if ("a" === b[0].nodeName.toLowerCase()) {
              var e =
                "[object SVGAnimatedString]" === ma.call(b.prop("href"))
                  ? "xlink:href"
                  : "href";
              b.on("click", function (a) {
                b.attr(e) || a.preventDefault();
              });
            }
          };
      },
    }),
    vb = {};
  r(Gb, function (a, b) {
    function d(a, d, e) {
      a.$watch(e[c], function (a) {
        e.$set(b, !!a);
      });
    }
    if ("multiple" !== a) {
      var c = va("ng-" + b),
        e = d;
      "checked" === a &&
        (e = function (a, b, e) {
          e.ngModel !== e[c] && d(a, b, e);
        });
      vb[c] = function () {
        return { restrict: "A", priority: 100, link: e };
      };
    }
  });
  r(sd, function (a, b) {
    vb[b] = function () {
      return {
        priority: 100,
        link: function (a, c, e) {
          if (
            "ngPattern" === b &&
            "/" === e.ngPattern.charAt(0) &&
            (c = e.ngPattern.match(fh))
          ) {
            e.$set("ngPattern", new RegExp(c[1], c[2]));
            return;
          }
          a.$watch(e[b], function (a) {
            e.$set(b, a);
          });
        },
      };
    };
  });
  r(["src", "srcset", "href"], function (a) {
    var b = va("ng-" + a);
    vb[b] = function () {
      return {
        priority: 99,
        link: function (d, c, e) {
          var f = a,
            g = a;
          "href" === a &&
            "[object SVGAnimatedString]" === ma.call(c.prop("href")) &&
            ((g = "xlinkHref"), (e.$attr[g] = "xlink:href"), (f = null));
          e.$observe(b, function (b) {
            b
              ? (e.$set(g, b), Aa && f && c.prop(f, e[g]))
              : "href" === a && e.$set(g, null);
          });
        },
      };
    };
  });
  var lb = {
    $addControl: A,
    $getControls: ia([]),
    $$renameControl: function (a, b) {
      a.$name = b;
    },
    $removeControl: A,
    $setValidity: A,
    $setDirty: A,
    $setPristine: A,
    $setSubmitted: A,
    $$setSubmitted: A,
  };
  Pb.$inject = ["$element", "$attrs", "$scope", "$animate", "$interpolate"];
  Pb.prototype = {
    $rollbackViewValue: function () {
      r(this.$$controls, function (a) {
        a.$rollbackViewValue();
      });
    },
    $commitViewValue: function () {
      r(this.$$controls, function (a) {
        a.$commitViewValue();
      });
    },
    $addControl: function (a) {
      Qa(a.$name, "input");
      this.$$controls.push(a);
      a.$name && (this[a.$name] = a);
      a.$$parentForm = this;
    },
    $getControls: function () {
      return oa(this.$$controls);
    },
    $$renameControl: function (a, b) {
      var d = a.$name;
      this[d] === a && delete this[d];
      this[b] = a;
      a.$name = b;
    },
    $removeControl: function (a) {
      a.$name && this[a.$name] === a && delete this[a.$name];
      r(
        this.$pending,
        function (b, d) {
          this.$setValidity(d, null, a);
        },
        this
      );
      r(
        this.$error,
        function (b, d) {
          this.$setValidity(d, null, a);
        },
        this
      );
      r(
        this.$$success,
        function (b, d) {
          this.$setValidity(d, null, a);
        },
        this
      );
      cb(this.$$controls, a);
      a.$$parentForm = lb;
    },
    $setDirty: function () {
      this.$$animate.removeClass(this.$$element, Za);
      this.$$animate.addClass(this.$$element, Ub);
      this.$dirty = !0;
      this.$pristine = !1;
      this.$$parentForm.$setDirty();
    },
    $setPristine: function () {
      this.$$animate.setClass(this.$$element, Za, Ub + " ng-submitted");
      this.$dirty = !1;
      this.$pristine = !0;
      this.$submitted = !1;
      r(this.$$controls, function (a) {
        a.$setPristine();
      });
    },
    $setUntouched: function () {
      r(this.$$controls, function (a) {
        a.$setUntouched();
      });
    },
    $setSubmitted: function () {
      for (var a = this; a.$$parentForm && a.$$parentForm !== lb; )
        a = a.$$parentForm;
      a.$$setSubmitted();
    },
    $$setSubmitted: function () {
      this.$$animate.addClass(this.$$element, "ng-submitted");
      this.$submitted = !0;
      r(this.$$controls, function (a) {
        a.$$setSubmitted && a.$$setSubmitted();
      });
    },
  };
  $d({
    clazz: Pb,
    set: function (a, b, d) {
      var c = a[b];
      c ? -1 === c.indexOf(d) && c.push(d) : (a[b] = [d]);
    },
    unset: function (a, b, d) {
      var c = a[b];
      c && (cb(c, d), 0 === c.length && delete a[b]);
    },
  });
  var he = function (a) {
      return [
        "$timeout",
        "$parse",
        function (b, d) {
          function c(a) {
            return "" === a ? d('this[""]').assign : d(a).assign || A;
          }
          return {
            name: "form",
            restrict: a ? "EAC" : "E",
            require: ["form", "^^?form"],
            controller: Pb,
            compile: function (d, f) {
              d.addClass(Za).addClass(mb);
              var g = f.name ? "name" : a && f.ngForm ? "ngForm" : !1;
              return {
                pre: function (a, d, e, f) {
                  var q = f[0];
                  if (!("action" in e)) {
                    var n = function (b) {
                      a.$apply(function () {
                        q.$commitViewValue();
                        q.$setSubmitted();
                      });
                      b.preventDefault();
                    };
                    d[0].addEventListener("submit", n);
                    d.on("$destroy", function () {
                      b(
                        function () {
                          d[0].removeEventListener("submit", n);
                        },
                        0,
                        !1
                      );
                    });
                  }
                  (f[1] || q.$$parentForm).$addControl(q);
                  var s = g ? c(q.$name) : A;
                  g &&
                    (s(a, q),
                    e.$observe(g, function (b) {
                      q.$name !== b &&
                        (s(a, void 0),
                        q.$$parentForm.$$renameControl(q, b),
                        (s = c(q.$name)),
                        s(a, q));
                    }));
                  d.on("$destroy", function () {
                    q.$$parentForm.$removeControl(q);
                    s(a, void 0);
                    R(q, lb);
                  });
                },
              };
            },
          };
        },
      ];
    },
    Ke = he(),
    We = he(!0),
    ch = /^\d{4,}-[01]\d-[0-3]\dT[0-2]\d:[0-5]\d:[0-5]\d\.\d+(?:[+-][0-2]\d:[0-5]\d|Z)$/,
    oh = /^[a-z][a-z\d.+-]*:\/*(?:[^:@]+(?::[^@]+)?@)?(?:[^\s:/?#]+|\[[a-f\d:]+])(?::\d+)?(?:\/[^?#]*)?(?:\?[^#]*)?(?:#.*)?$/i,
    ph = /^(?=.{1,254}$)(?=.{1,64}@)[-!#$%&'*+/0-9=?A-Z^_`a-z{|}~]+(\.[-!#$%&'*+/0-9=?A-Z^_`a-z{|}~]+)*@[A-Za-z0-9]([A-Za-z0-9-]{0,61}[A-Za-z0-9])?(\.[A-Za-z0-9]([A-Za-z0-9-]{0,61}[A-Za-z0-9])?)*$/,
    dh = /^\s*(-|\+)?(\d+|(\d*(\.\d*)))([eE][+-]?\d+)?\s*$/,
    ie = /^(\d{4,})-(\d{2})-(\d{2})$/,
    je = /^(\d{4,})-(\d\d)-(\d\d)T(\d\d):(\d\d)(?::(\d\d)(\.\d{1,3})?)?$/,
    Lc = /^(\d{4,})-W(\d\d)$/,
    ke = /^(\d{4,})-(\d\d)$/,
    le = /^(\d\d):(\d\d)(?::(\d\d)(\.\d{1,3})?)?$/,
    be = S();
  r(["date", "datetime-local", "month", "time", "week"], function (a) {
    be[a] = !0;
  });
  var me = {
      text: function (a, b, d, c, e, f) {
        Ra(a, b, d, c, e, f);
        Gc(c);
      },
      date: nb("date", ie, Qb(ie, ["yyyy", "MM", "dd"]), "yyyy-MM-dd"),
      "datetime-local": nb(
        "datetimelocal",
        je,
        Qb(je, "yyyy MM dd HH mm ss sss".split(" ")),
        "yyyy-MM-ddTHH:mm:ss.sss"
      ),
      time: nb("time", le, Qb(le, ["HH", "mm", "ss", "sss"]), "HH:mm:ss.sss"),
      week: nb(
        "week",
        Lc,
        function (a, b) {
          if (ha(a)) return a;
          if (C(a)) {
            Lc.lastIndex = 0;
            var d = Lc.exec(a);
            if (d) {
              var c = +d[1],
                e = +d[2],
                f = (d = 0),
                g = 0,
                k = 0,
                h = Wd(c),
                e = 7 * (e - 1);
              b &&
                ((d = b.getHours()),
                (f = b.getMinutes()),
                (g = b.getSeconds()),
                (k = b.getMilliseconds()));
              return new Date(c, 0, h.getDate() + e, d, f, g, k);
            }
          }
          return NaN;
        },
        "yyyy-Www"
      ),
      month: nb("month", ke, Qb(ke, ["yyyy", "MM"]), "yyyy-MM"),
      number: function (a, b, d, c, e, f) {
        Hc(a, b, d, c, "number");
        ce(c);
        Ra(a, b, d, c, e, f);
        var g, k;
        if (v(d.min) || d.ngMin)
          (c.$validators.min = function (a, b) {
            return c.$isEmpty(b) || x(g) || b >= g;
          }),
            d.$observe("min", function (a) {
              g = Sa(a);
              c.$validate();
            });
        if (v(d.max) || d.ngMax)
          (c.$validators.max = function (a, b) {
            return c.$isEmpty(b) || x(k) || b <= k;
          }),
            d.$observe("max", function (a) {
              k = Sa(a);
              c.$validate();
            });
        if (v(d.step) || d.ngStep) {
          var h;
          c.$validators.step = function (a, b) {
            return c.$isEmpty(b) || x(h) || de(b, g || 0, h);
          };
          d.$observe("step", function (a) {
            h = Sa(a);
            c.$validate();
          });
        }
      },
      url: function (a, b, d, c, e, f) {
        Ra(a, b, d, c, e, f);
        Gc(c);
        c.$validators.url = function (a, b) {
          var d = a || b;
          return c.$isEmpty(d) || oh.test(d);
        };
      },
      email: function (a, b, d, c, e, f) {
        Ra(a, b, d, c, e, f);
        Gc(c);
        c.$validators.email = function (a, b) {
          var d = a || b;
          return c.$isEmpty(d) || ph.test(d);
        };
      },
      radio: function (a, b, d, c) {
        var e = !d.ngTrim || "false" !== T(d.ngTrim);
        x(d.name) && b.attr("name", ++pb);
        b.on("change", function (a) {
          var g;
          b[0].checked &&
            ((g = d.value), e && (g = T(g)), c.$setViewValue(g, a && a.type));
        });
        c.$render = function () {
          var a = d.value;
          e && (a = T(a));
          b[0].checked = a === c.$viewValue;
        };
        d.$observe("value", c.$render);
      },
      range: function (a, b, d, c, e, f) {
        function g(a, c) {
          b.attr(a, d[a]);
          d.$observe(a, c);
        }
        function k(a) {
          q = Sa(a);
          V(c.$modelValue) ||
            (m
              ? ((a = b.val()),
                q > a && ((a = q), b.val(a)),
                c.$setViewValue(a))
              : c.$validate());
        }
        function h(a) {
          n = Sa(a);
          V(c.$modelValue) ||
            (m
              ? ((a = b.val()),
                n < a && (b.val(n), (a = n < q ? q : n)),
                c.$setViewValue(a))
              : c.$validate());
        }
        function l(a) {
          s = Sa(a);
          V(c.$modelValue) ||
            (m && c.$viewValue !== b.val()
              ? c.$setViewValue(b.val())
              : c.$validate());
        }
        Hc(a, b, d, c, "range");
        ce(c);
        Ra(a, b, d, c, e, f);
        var m = c.$$hasNativeValidators && "range" === b[0].type,
          q = m ? 0 : void 0,
          n = m ? 100 : void 0,
          s = m ? 1 : void 0,
          p = b[0].validity;
        a = v(d.min);
        e = v(d.max);
        f = v(d.step);
        var r = c.$render;
        c.$render =
          m && v(p.rangeUnderflow) && v(p.rangeOverflow)
            ? function () {
                r();
                c.$setViewValue(b.val());
              }
            : r;
        a &&
          ((c.$validators.min = m
            ? function () {
                return !0;
              }
            : function (a, b) {
                return c.$isEmpty(b) || x(q) || b >= q;
              }),
          g("min", k));
        e &&
          ((c.$validators.max = m
            ? function () {
                return !0;
              }
            : function (a, b) {
                return c.$isEmpty(b) || x(n) || b <= n;
              }),
          g("max", h));
        f &&
          ((c.$validators.step = m
            ? function () {
                return !p.stepMismatch;
              }
            : function (a, b) {
                return c.$isEmpty(b) || x(s) || de(b, q || 0, s);
              }),
          g("step", l));
      },
      checkbox: function (a, b, d, c, e, f, g, k) {
        var h = ee(k, a, "ngTrueValue", d.ngTrueValue, !0),
          l = ee(k, a, "ngFalseValue", d.ngFalseValue, !1);
        b.on("change", function (a) {
          c.$setViewValue(b[0].checked, a && a.type);
        });
        c.$render = function () {
          b[0].checked = c.$viewValue;
        };
        c.$isEmpty = function (a) {
          return !1 === a;
        };
        c.$formatters.push(function (a) {
          return ua(a, h);
        });
        c.$parsers.push(function (a) {
          return a ? h : l;
        });
      },
      hidden: A,
      button: A,
      submit: A,
      reset: A,
      file: A,
    },
    Xc = [
      "$browser",
      "$sniffer",
      "$filter",
      "$parse",
      function (a, b, d, c) {
        return {
          restrict: "E",
          require: ["?ngModel"],
          link: {
            pre: function (e, f, g, k) {
              k[0] && (me[O(g.type)] || me.text)(e, f, g, k[0], b, a, d, c);
            },
          },
        };
      },
    ],
    qh = /^(true|false|\d+)$/,
    pf = function () {
      function a(a, d, c) {
        var e = v(c) ? c : 9 === Aa ? "" : null;
        a.prop("value", e);
        d.$set("value", c);
      }
      return {
        restrict: "A",
        priority: 100,
        compile: function (b, d) {
          return qh.test(d.ngValue)
            ? function (b, d, f) {
                b = b.$eval(f.ngValue);
                a(d, f, b);
              }
            : function (b, d, f) {
                b.$watch(f.ngValue, function (b) {
                  a(d, f, b);
                });
              };
        },
      };
    },
    Oe = [
      "$compile",
      function (a) {
        return {
          restrict: "AC",
          compile: function (b) {
            a.$$addBindingClass(b);
            return function (b, c, e) {
              a.$$addBindingInfo(c, e.ngBind);
              c = c[0];
              b.$watch(e.ngBind, function (a) {
                c.textContent = hc(a);
              });
            };
          },
        };
      },
    ],
    Qe = [
      "$interpolate",
      "$compile",
      function (a, b) {
        return {
          compile: function (d) {
            b.$$addBindingClass(d);
            return function (c, d, f) {
              c = a(d.attr(f.$attr.ngBindTemplate));
              b.$$addBindingInfo(d, c.expressions);
              d = d[0];
              f.$observe("ngBindTemplate", function (a) {
                d.textContent = x(a) ? "" : a;
              });
            };
          },
        };
      },
    ],
    Pe = [
      "$sce",
      "$parse",
      "$compile",
      function (a, b, d) {
        return {
          restrict: "A",
          compile: function (c, e) {
            var f = b(e.ngBindHtml),
              g = b(e.ngBindHtml, function (b) {
                return a.valueOf(b);
              });
            d.$$addBindingClass(c);
            return function (b, c, e) {
              d.$$addBindingInfo(c, e.ngBindHtml);
              b.$watch(g, function () {
                var d = f(b);
                c.html(a.getTrustedHtml(d) || "");
              });
            };
          },
        };
      },
    ],
    of = ia({
      restrict: "A",
      require: "ngModel",
      link: function (a, b, d, c) {
        c.$viewChangeListeners.push(function () {
          a.$eval(d.ngChange);
        });
      },
    }),
    Re = Jc("", !0),
    Te = Jc("Odd", 0),
    Se = Jc("Even", 1),
    Ue = Na({
      compile: function (a, b) {
        b.$set("ngCloak", void 0);
        a.removeClass("ng-cloak");
      },
    }),
    Ve = [
      function () {
        return { restrict: "A", scope: !0, controller: "@", priority: 500 };
      },
    ],
    bd = {},
    rh = { blur: !0, focus: !0 };
  r(
    "click dblclick mousedown mouseup mouseover mouseout mousemove mouseenter mouseleave keydown keyup keypress submit focus blur copy cut paste".split(
      " "
    ),
    function (a) {
      var b = va("ng-" + a);
      bd[b] = [
        "$parse",
        "$rootScope",
        "$exceptionHandler",
        function (d, c, e) {
          return pd(d, c, e, b, a, rh[a]);
        },
      ];
    }
  );
  var Ye = [
      "$animate",
      "$compile",
      function (a, b) {
        return {
          multiElement: !0,
          transclude: "element",
          priority: 600,
          terminal: !0,
          restrict: "A",
          $$tlb: !0,
          link: function (d, c, e, f, g) {
            var k, h, l;
            d.$watch(e.ngIf, function (d) {
              d
                ? h ||
                  g(function (d, f) {
                    h = f;
                    d[d.length++] = b.$$createComment("end ngIf", e.ngIf);
                    k = { clone: d };
                    a.enter(d, c.parent(), c);
                  })
                : (l && (l.remove(), (l = null)),
                  h && (h.$destroy(), (h = null)),
                  k &&
                    ((l = tb(k.clone)),
                    a.leave(l).done(function (a) {
                      !1 !== a && (l = null);
                    }),
                    (k = null)));
            });
          },
        };
      },
    ],
    Ze = [
      "$templateRequest",
      "$anchorScroll",
      "$animate",
      function (a, b, d) {
        return {
          restrict: "ECA",
          priority: 400,
          terminal: !0,
          transclude: "element",
          controller: ea.noop,
          compile: function (c, e) {
            var f = e.ngInclude || e.src,
              g = e.onload || "",
              k = e.autoscroll;
            return function (c, e, m, q, n) {
              var s = 0,
                p,
                r,
                D,
                w = function () {
                  r && (r.remove(), (r = null));
                  p && (p.$destroy(), (p = null));
                  D &&
                    (d.leave(D).done(function (a) {
                      !1 !== a && (r = null);
                    }),
                    (r = D),
                    (D = null));
                };
              c.$watch(f, function (f) {
                var m = function (a) {
                    !1 === a || !v(k) || (k && !c.$eval(k)) || b();
                  },
                  r = ++s;
                f
                  ? (a(f, !0).then(
                      function (a) {
                        if (!c.$$destroyed && r === s) {
                          var b = c.$new();
                          q.template = a;
                          a = n(b, function (a) {
                            w();
                            d.enter(a, null, e).done(m);
                          });
                          p = b;
                          D = a;
                          p.$emit("$includeContentLoaded", f);
                          c.$eval(g);
                        }
                      },
                      function () {
                        c.$$destroyed ||
                          r !== s ||
                          (w(), c.$emit("$includeContentError", f));
                      }
                    ),
                    c.$emit("$includeContentRequested", f))
                  : (w(), (q.template = null));
              });
            };
          },
        };
      },
    ],
    rf = [
      "$compile",
      function (a) {
        return {
          restrict: "ECA",
          priority: -400,
          require: "ngInclude",
          link: function (b, d, c, e) {
            ma.call(d[0]).match(/SVG/)
              ? (d.empty(),
                a(dd(e.template, B.document).childNodes)(
                  b,
                  function (a) {
                    d.append(a);
                  },
                  { futureParentElement: d }
                ))
              : (d.html(e.template), a(d.contents())(b));
          },
        };
      },
    ],
    $e = Na({
      priority: 450,
      compile: function () {
        return {
          pre: function (a, b, d) {
            a.$eval(d.ngInit);
          },
        };
      },
    }),
    nf = function () {
      return {
        restrict: "A",
        priority: 100,
        require: "ngModel",
        link: function (a, b, d, c) {
          var e = d.ngList || ", ",
            f = "false" !== d.ngTrim,
            g = f ? T(e) : e;
          c.$parsers.push(function (a) {
            if (!x(a)) {
              var b = [];
              a &&
                r(a.split(g), function (a) {
                  a && b.push(f ? T(a) : a);
                });
              return b;
            }
          });
          c.$formatters.push(function (a) {
            if (I(a)) return a.join(e);
          });
          c.$isEmpty = function (a) {
            return !a || !a.length;
          };
        },
      };
    },
    mb = "ng-valid",
    Zd = "ng-invalid",
    Za = "ng-pristine",
    Ub = "ng-dirty",
    ob = M("ngModel");
  Rb.$inject = "$scope $exceptionHandler $attrs $element $parse $animate $timeout $q $interpolate".split(
    " "
  );
  Rb.prototype = {
    $$initGetterSetters: function () {
      if (this.$options.getOption("getterSetter")) {
        var a = this.$$parse(this.$$attr.ngModel + "()"),
          b = this.$$parse(this.$$attr.ngModel + "($$$p)");
        this.$$ngModelGet = function (b) {
          var c = this.$$parsedNgModel(b);
          z(c) && (c = a(b));
          return c;
        };
        this.$$ngModelSet = function (a, c) {
          z(this.$$parsedNgModel(a))
            ? b(a, { $$$p: c })
            : this.$$parsedNgModelAssign(a, c);
        };
      } else if (!this.$$parsedNgModel.assign)
        throw ob("nonassign", this.$$attr.ngModel, ya(this.$$element));
    },
    $render: A,
    $isEmpty: function (a) {
      return x(a) || "" === a || null === a || a !== a;
    },
    $$updateEmptyClasses: function (a) {
      this.$isEmpty(a)
        ? (this.$$animate.removeClass(this.$$element, "ng-not-empty"),
          this.$$animate.addClass(this.$$element, "ng-empty"))
        : (this.$$animate.removeClass(this.$$element, "ng-empty"),
          this.$$animate.addClass(this.$$element, "ng-not-empty"));
    },
    $setPristine: function () {
      this.$dirty = !1;
      this.$pristine = !0;
      this.$$animate.removeClass(this.$$element, Ub);
      this.$$animate.addClass(this.$$element, Za);
    },
    $setDirty: function () {
      this.$dirty = !0;
      this.$pristine = !1;
      this.$$animate.removeClass(this.$$element, Za);
      this.$$animate.addClass(this.$$element, Ub);
      this.$$parentForm.$setDirty();
    },
    $setUntouched: function () {
      this.$touched = !1;
      this.$untouched = !0;
      this.$$animate.setClass(this.$$element, "ng-untouched", "ng-touched");
    },
    $setTouched: function () {
      this.$touched = !0;
      this.$untouched = !1;
      this.$$animate.setClass(this.$$element, "ng-touched", "ng-untouched");
    },
    $rollbackViewValue: function () {
      this.$$timeout.cancel(this.$$pendingDebounce);
      this.$viewValue = this.$$lastCommittedViewValue;
      this.$render();
    },
    $validate: function () {
      if (!V(this.$modelValue)) {
        var a = this.$$lastCommittedViewValue,
          b = this.$$rawModelValue,
          d = this.$valid,
          c = this.$modelValue,
          e = this.$options.getOption("allowInvalid"),
          f = this;
        this.$$runValidators(b, a, function (a) {
          e ||
            d === a ||
            ((f.$modelValue = a ? b : void 0),
            f.$modelValue !== c && f.$$writeModelToScope());
        });
      }
    },
    $$runValidators: function (a, b, d) {
      function c() {
        var c = !0;
        r(h.$validators, function (d, e) {
          var g = Boolean(d(a, b));
          c = c && g;
          f(e, g);
        });
        return c
          ? !0
          : (r(h.$asyncValidators, function (a, b) {
              f(b, null);
            }),
            !1);
      }
      function e() {
        var c = [],
          d = !0;
        r(h.$asyncValidators, function (e, g) {
          var h = e(a, b);
          if (!h || !z(h.then)) throw ob("nopromise", h);
          f(g, void 0);
          c.push(
            h.then(
              function () {
                f(g, !0);
              },
              function () {
                d = !1;
                f(g, !1);
              }
            )
          );
        });
        c.length
          ? h.$$q.all(c).then(function () {
              g(d);
            }, A)
          : g(!0);
      }
      function f(a, b) {
        k === h.$$currentValidationRunId && h.$setValidity(a, b);
      }
      function g(a) {
        k === h.$$currentValidationRunId && d(a);
      }
      this.$$currentValidationRunId++;
      var k = this.$$currentValidationRunId,
        h = this;
      (function () {
        var a = h.$$parserName;
        if (x(h.$$parserValid)) f(a, null);
        else
          return (
            h.$$parserValid ||
              (r(h.$validators, function (a, b) {
                f(b, null);
              }),
              r(h.$asyncValidators, function (a, b) {
                f(b, null);
              })),
            f(a, h.$$parserValid),
            h.$$parserValid
          );
        return !0;
      })()
        ? c()
          ? e()
          : g(!1)
        : g(!1);
    },
    $commitViewValue: function () {
      var a = this.$viewValue;
      this.$$timeout.cancel(this.$$pendingDebounce);
      if (
        this.$$lastCommittedViewValue !== a ||
        ("" === a && this.$$hasNativeValidators)
      )
        this.$$updateEmptyClasses(a),
          (this.$$lastCommittedViewValue = a),
          this.$pristine && this.$setDirty(),
          this.$$parseAndValidate();
    },
    $$parseAndValidate: function () {
      var a = this.$$lastCommittedViewValue,
        b = this;
      this.$$parserValid = x(a) ? void 0 : !0;
      this.$setValidity(this.$$parserName, null);
      this.$$parserName = "parse";
      if (this.$$parserValid)
        for (var d = 0; d < this.$parsers.length; d++)
          if (((a = this.$parsers[d](a)), x(a))) {
            this.$$parserValid = !1;
            break;
          }
      V(this.$modelValue) &&
        (this.$modelValue = this.$$ngModelGet(this.$$scope));
      var c = this.$modelValue,
        e = this.$options.getOption("allowInvalid");
      this.$$rawModelValue = a;
      e &&
        ((this.$modelValue = a),
        b.$modelValue !== c && b.$$writeModelToScope());
      this.$$runValidators(a, this.$$lastCommittedViewValue, function (d) {
        e ||
          ((b.$modelValue = d ? a : void 0),
          b.$modelValue !== c && b.$$writeModelToScope());
      });
    },
    $$writeModelToScope: function () {
      this.$$ngModelSet(this.$$scope, this.$modelValue);
      r(
        this.$viewChangeListeners,
        function (a) {
          try {
            a();
          } catch (b) {
            this.$$exceptionHandler(b);
          }
        },
        this
      );
    },
    $setViewValue: function (a, b) {
      this.$viewValue = a;
      this.$options.getOption("updateOnDefault") &&
        this.$$debounceViewValueCommit(b);
    },
    $$debounceViewValueCommit: function (a) {
      var b = this.$options.getOption("debounce");
      ba(b[a])
        ? (b = b[a])
        : ba(b["default"]) &&
          -1 === this.$options.getOption("updateOn").indexOf(a)
        ? (b = b["default"])
        : ba(b["*"]) && (b = b["*"]);
      this.$$timeout.cancel(this.$$pendingDebounce);
      var d = this;
      0 < b
        ? (this.$$pendingDebounce = this.$$timeout(function () {
            d.$commitViewValue();
          }, b))
        : this.$$rootScope.$$phase
        ? this.$commitViewValue()
        : this.$$scope.$apply(function () {
            d.$commitViewValue();
          });
    },
    $overrideModelOptions: function (a) {
      this.$options = this.$options.createChild(a);
      this.$$setUpdateOnEvents();
    },
    $processModelValue: function () {
      var a = this.$$format();
      this.$viewValue !== a &&
        (this.$$updateEmptyClasses(a),
        (this.$viewValue = this.$$lastCommittedViewValue = a),
        this.$render(),
        this.$$runValidators(this.$modelValue, this.$viewValue, A));
    },
    $$format: function () {
      for (var a = this.$formatters, b = a.length, d = this.$modelValue; b--; )
        d = a[b](d);
      return d;
    },
    $$setModelValue: function (a) {
      this.$modelValue = this.$$rawModelValue = a;
      this.$$parserValid = void 0;
      this.$processModelValue();
    },
    $$setUpdateOnEvents: function () {
      this.$$updateEvents &&
        this.$$element.off(this.$$updateEvents, this.$$updateEventHandler);
      if ((this.$$updateEvents = this.$options.getOption("updateOn")))
        this.$$element.on(this.$$updateEvents, this.$$updateEventHandler);
    },
    $$updateEventHandler: function (a) {
      this.$$debounceViewValueCommit(a && a.type);
    },
  };
  $d({
    clazz: Rb,
    set: function (a, b) {
      a[b] = !0;
    },
    unset: function (a, b) {
      delete a[b];
    },
  });
  var mf = [
      "$rootScope",
      function (a) {
        return {
          restrict: "A",
          require: ["ngModel", "^?form", "^?ngModelOptions"],
          controller: Rb,
          priority: 1,
          compile: function (b) {
            b.addClass(Za).addClass("ng-untouched").addClass(mb);
            return {
              pre: function (a, b, e, f) {
                var g = f[0];
                b = f[1] || g.$$parentForm;
                if ((f = f[2])) g.$options = f.$options;
                g.$$initGetterSetters();
                b.$addControl(g);
                e.$observe("name", function (a) {
                  g.$name !== a && g.$$parentForm.$$renameControl(g, a);
                });
                a.$on("$destroy", function () {
                  g.$$parentForm.$removeControl(g);
                });
              },
              post: function (b, c, e, f) {
                function g() {
                  k.$setTouched();
                }
                var k = f[0];
                k.$$setUpdateOnEvents();
                c.on("blur", function () {
                  k.$touched || (a.$$phase ? b.$evalAsync(g) : b.$apply(g));
                });
              },
            };
          },
        };
      },
    ],
    Sb,
    sh = /(\s+|^)default(\s+|$)/;
  Kc.prototype = {
    getOption: function (a) {
      return this.$$options[a];
    },
    createChild: function (a) {
      var b = !1;
      a = R({}, a);
      r(
        a,
        function (d, c) {
          "$inherit" === d
            ? "*" === c
              ? (b = !0)
              : ((a[c] = this.$$options[c]),
                "updateOn" === c &&
                  (a.updateOnDefault = this.$$options.updateOnDefault))
            : "updateOn" === c &&
              ((a.updateOnDefault = !1),
              (a[c] = T(
                d.replace(sh, function () {
                  a.updateOnDefault = !0;
                  return " ";
                })
              )));
        },
        this
      );
      b && (delete a["*"], fe(a, this.$$options));
      fe(a, Sb.$$options);
      return new Kc(a);
    },
  };
  Sb = new Kc({
    updateOn: "",
    updateOnDefault: !0,
    debounce: 0,
    getterSetter: !1,
    allowInvalid: !1,
    timezone: null,
  });
  var qf = function () {
      function a(a, d) {
        this.$$attrs = a;
        this.$$scope = d;
      }
      a.$inject = ["$attrs", "$scope"];
      a.prototype = {
        $onInit: function () {
          var a = this.parentCtrl ? this.parentCtrl.$options : Sb,
            d = this.$$scope.$eval(this.$$attrs.ngModelOptions);
          this.$options = a.createChild(d);
        },
      };
      return {
        restrict: "A",
        priority: 10,
        require: { parentCtrl: "?^^ngModelOptions" },
        bindToController: !0,
        controller: a,
      };
    },
    af = Na({ terminal: !0, priority: 1e3 }),
    th = M("ngOptions"),
    uh = /^\s*([\s\S]+?)(?:\s+as\s+([\s\S]+?))?(?:\s+group\s+by\s+([\s\S]+?))?(?:\s+disable\s+when\s+([\s\S]+?))?\s+for\s+(?:([$\w][$\w]*)|(?:\(\s*([$\w][$\w]*)\s*,\s*([$\w][$\w]*)\s*\)))\s+in\s+([\s\S]+?)(?:\s+track\s+by\s+([\s\S]+?))?$/,
    kf = [
      "$compile",
      "$document",
      "$parse",
      function (a, b, d) {
        function c(a, b, c) {
          function e(a, b, c, d, f) {
            this.selectValue = a;
            this.viewValue = b;
            this.label = c;
            this.group = d;
            this.disabled = f;
          }
          function f(a) {
            var b;
            if (!p && xa(a)) b = a;
            else {
              b = [];
              for (var c in a)
                a.hasOwnProperty(c) && "$" !== c.charAt(0) && b.push(c);
            }
            return b;
          }
          var q = a.match(uh);
          if (!q) throw th("iexp", a, ya(b));
          var n = q[5] || q[7],
            p = q[6];
          a = / as /.test(q[0]) && q[1];
          var r = q[9];
          b = d(q[2] ? q[1] : n);
          var u = (a && d(a)) || b,
            v = r && d(r),
            w = r
              ? function (a, b) {
                  return v(c, b);
                }
              : function (a) {
                  return Ka(a);
                },
            y = function (a, b) {
              return w(a, C(a, b));
            },
            x = d(q[2] || q[1]),
            E = d(q[3] || ""),
            G = d(q[4] || ""),
            J = d(q[8]),
            z = {},
            C = p
              ? function (a, b) {
                  z[p] = b;
                  z[n] = a;
                  return z;
                }
              : function (a) {
                  z[n] = a;
                  return z;
                };
          return {
            trackBy: r,
            getTrackByValue: y,
            getWatchables: d(J, function (a) {
              var b = [];
              a = a || [];
              for (var d = f(a), e = d.length, g = 0; g < e; g++) {
                var k = a === d ? g : d[g],
                  l = a[k],
                  k = C(l, k),
                  l = w(l, k);
                b.push(l);
                if (q[2] || q[1]) (l = x(c, k)), b.push(l);
                q[4] && ((k = G(c, k)), b.push(k));
              }
              return b;
            }),
            getOptions: function () {
              for (
                var a = [],
                  b = {},
                  d = J(c) || [],
                  g = f(d),
                  k = g.length,
                  n = 0;
                n < k;
                n++
              ) {
                var q = d === g ? n : g[n],
                  p = C(d[q], q),
                  s = u(c, p),
                  q = w(s, p),
                  v = x(c, p),
                  D = E(c, p),
                  p = G(c, p),
                  s = new e(q, s, v, D, p);
                a.push(s);
                b[q] = s;
              }
              return {
                items: a,
                selectValueMap: b,
                getOptionFromViewValue: function (a) {
                  return b[y(a)];
                },
                getViewValueFromOption: function (a) {
                  return r ? Ha(a.viewValue) : a.viewValue;
                },
              };
            },
          };
        }
        var e = B.document.createElement("option"),
          f = B.document.createElement("optgroup");
        return {
          restrict: "A",
          terminal: !0,
          require: ["select", "ngModel"],
          link: {
            pre: function (a, b, c, d) {
              d[0].registerOption = A;
            },
            post: function (d, k, h, l) {
              function m(a) {
                var b = (a = w.getOptionFromViewValue(a)) && a.element;
                b && !b.selected && (b.selected = !0);
                return a;
              }
              function q(a, b) {
                a.element = b;
                b.disabled = a.disabled;
                a.label !== b.label &&
                  ((b.label = a.label), (b.textContent = a.label));
                b.value = a.selectValue;
              }
              var n = l[0],
                p = l[1],
                t = h.multiple;
              l = 0;
              for (var u = k.children(), D = u.length; l < D; l++)
                if ("" === u[l].value) {
                  n.hasEmptyOption = !0;
                  n.emptyOption = u.eq(l);
                  break;
                }
              k.empty();
              l = !!n.emptyOption;
              y(e.cloneNode(!1)).val("?");
              var w,
                x = c(h.ngOptions, k, d),
                z = b[0].createDocumentFragment();
              n.generateUnknownOptionValue = function (a) {
                return "?";
              };
              t
                ? ((n.writeValue = function (a) {
                    if (w) {
                      var b = (a && a.map(m)) || [];
                      w.items.forEach(function (a) {
                        a.element.selected &&
                          -1 === Array.prototype.indexOf.call(b, a) &&
                          (a.element.selected = !1);
                      });
                    }
                  }),
                  (n.readValue = function () {
                    var a = k.val() || [],
                      b = [];
                    r(a, function (a) {
                      (a = w.selectValueMap[a]) &&
                        !a.disabled &&
                        b.push(w.getViewValueFromOption(a));
                    });
                    return b;
                  }),
                  x.trackBy &&
                    d.$watchCollection(
                      function () {
                        if (I(p.$viewValue))
                          return p.$viewValue.map(function (a) {
                            return x.getTrackByValue(a);
                          });
                      },
                      function () {
                        p.$render();
                      }
                    ))
                : ((n.writeValue = function (a) {
                    if (w) {
                      var b = k[0].options[k[0].selectedIndex],
                        c = w.getOptionFromViewValue(a);
                      b && b.removeAttribute("selected");
                      c
                        ? (k[0].value !== c.selectValue &&
                            (n.removeUnknownOption(),
                            (k[0].value = c.selectValue),
                            (c.element.selected = !0)),
                          c.element.setAttribute("selected", "selected"))
                        : n.selectUnknownOrEmptyOption(a);
                    }
                  }),
                  (n.readValue = function () {
                    var a = w.selectValueMap[k.val()];
                    return a && !a.disabled
                      ? (n.unselectEmptyOption(),
                        n.removeUnknownOption(),
                        w.getViewValueFromOption(a))
                      : null;
                  }),
                  x.trackBy &&
                    d.$watch(
                      function () {
                        return x.getTrackByValue(p.$viewValue);
                      },
                      function () {
                        p.$render();
                      }
                    ));
              l &&
                (a(n.emptyOption)(d),
                k.prepend(n.emptyOption),
                8 === n.emptyOption[0].nodeType
                  ? ((n.hasEmptyOption = !1),
                    (n.registerOption = function (a, b) {
                      "" === b.val() &&
                        ((n.hasEmptyOption = !0),
                        (n.emptyOption = b),
                        n.emptyOption.removeClass("ng-scope"),
                        p.$render(),
                        b.on("$destroy", function () {
                          var a = n.$isEmptyOptionSelected();
                          n.hasEmptyOption = !1;
                          n.emptyOption = void 0;
                          a && p.$render();
                        }));
                    }))
                  : n.emptyOption.removeClass("ng-scope"));
              d.$watchCollection(x.getWatchables, function () {
                var a = w && n.readValue();
                if (w)
                  for (var b = w.items.length - 1; 0 <= b; b--) {
                    var c = w.items[b];
                    v(c.group) ? Fb(c.element.parentNode) : Fb(c.element);
                  }
                w = x.getOptions();
                var d = {};
                w.items.forEach(function (a) {
                  var b;
                  if (v(a.group)) {
                    b = d[a.group];
                    b ||
                      ((b = f.cloneNode(!1)),
                      z.appendChild(b),
                      (b.label = null === a.group ? "null" : a.group),
                      (d[a.group] = b));
                    var c = e.cloneNode(!1);
                    b.appendChild(c);
                    q(a, c);
                  } else (b = e.cloneNode(!1)), z.appendChild(b), q(a, b);
                });
                k[0].appendChild(z);
                p.$render();
                p.$isEmpty(a) ||
                  ((b = n.readValue()),
                  (x.trackBy || t ? ua(a, b) : a === b) ||
                    (p.$setViewValue(b), p.$render()));
              });
            },
          },
        };
      },
    ],
    bf = [
      "$locale",
      "$interpolate",
      "$log",
      function (a, b, d) {
        var c = /{}/g,
          e = /^when(Minus)?(.+)$/;
        return {
          link: function (f, g, k) {
            function h(a) {
              g.text(a || "");
            }
            var l = k.count,
              m = k.$attr.when && g.attr(k.$attr.when),
              q = k.offset || 0,
              n = f.$eval(m) || {},
              p = {},
              t = b.startSymbol(),
              u = b.endSymbol(),
              v = t + l + "-" + q + u,
              w = ea.noop,
              y;
            r(k, function (a, b) {
              var c = e.exec(b);
              c &&
                ((c = (c[1] ? "-" : "") + O(c[2])),
                (n[c] = g.attr(k.$attr[b])));
            });
            r(n, function (a, d) {
              p[d] = b(a.replace(c, v));
            });
            f.$watch(l, function (b) {
              var c = parseFloat(b),
                e = V(c);
              e || c in n || (c = a.pluralCat(c - q));
              c === y ||
                (e && V(y)) ||
                (w(),
                (e = p[c]),
                x(e)
                  ? (null != b &&
                      d.debug(
                        "ngPluralize: no rule defined for '" + c + "' in " + m
                      ),
                    (w = A),
                    h())
                  : (w = f.$watch(e, h)),
                (y = c));
            });
          },
        };
      },
    ],
    ne = M("ngRef"),
    cf = [
      "$parse",
      function (a) {
        return {
          priority: -1,
          restrict: "A",
          compile: function (b, d) {
            var c = va(ta(b)),
              e = a(d.ngRef),
              f =
                e.assign ||
                function () {
                  throw ne("nonassign", d.ngRef);
                };
            return function (a, b, h) {
              var l;
              if (h.hasOwnProperty("ngRefRead"))
                if ("$element" === h.ngRefRead) l = b;
                else {
                  if (((l = b.data("$" + h.ngRefRead + "Controller")), !l))
                    throw ne("noctrl", h.ngRefRead, d.ngRef);
                }
              else l = b.data("$" + c + "Controller");
              l = l || b;
              f(a, l);
              b.on("$destroy", function () {
                e(a) === l && f(a, null);
              });
            };
          },
        };
      },
    ],
    df = [
      "$parse",
      "$animate",
      "$compile",
      function (a, b, d) {
        var c = M("ngRepeat"),
          e = function (a, b, c, d, e, m, q) {
            a[c] = d;
            e && (a[e] = m);
            a.$index = b;
            a.$first = 0 === b;
            a.$last = b === q - 1;
            a.$middle = !(a.$first || a.$last);
            a.$odd = !(a.$even = 0 === (b & 1));
          };
        return {
          restrict: "A",
          multiElement: !0,
          transclude: "element",
          priority: 1e3,
          terminal: !0,
          $$tlb: !0,
          compile: function (f, g) {
            var k = g.ngRepeat,
              h = d.$$createComment("end ngRepeat", k),
              l = k.match(
                /^\s*([\s\S]+?)\s+in\s+([\s\S]+?)(?:\s+as\s+([\s\S]+?))?(?:\s+track\s+by\s+([\s\S]+?))?\s*$/
              );
            if (!l) throw c("iexp", k);
            var m = l[1],
              q = l[2],
              n = l[3],
              p = l[4],
              l = m.match(
                /^(?:(\s*[$\w]+)|\(\s*([$\w]+)\s*,\s*([$\w]+)\s*\))$/
              );
            if (!l) throw c("iidexp", m);
            var t = l[3] || l[1],
              u = l[2];
            if (
              n &&
              (!/^[$a-zA-Z_][$a-zA-Z0-9_]*$/.test(n) ||
                /^(null|undefined|this|\$index|\$first|\$middle|\$last|\$even|\$odd|\$parent|\$root|\$id)$/.test(
                  n
                ))
            )
              throw c("badident", n);
            var v,
              w,
              x,
              y,
              z = { $id: Ka };
            p
              ? (v = a(p))
              : ((x = function (a, b) {
                  return Ka(b);
                }),
                (y = function (a) {
                  return a;
                }));
            return function (a, d, f, g, l) {
              v &&
                (w = function (b, c, d) {
                  u && (z[u] = b);
                  z[t] = c;
                  z.$index = d;
                  return v(a, z);
                });
              var m = S();
              a.$watchCollection(q, function (f) {
                var g,
                  q,
                  p = d[0],
                  s,
                  v = S(),
                  D,
                  z,
                  C,
                  B,
                  E,
                  A,
                  F;
                n && (a[n] = f);
                if (xa(f)) (E = f), (q = w || x);
                else
                  for (F in ((q = w || y), (E = []), f))
                    sa.call(f, F) && "$" !== F.charAt(0) && E.push(F);
                D = E.length;
                F = Array(D);
                for (g = 0; g < D; g++)
                  if (
                    ((z = f === E ? g : E[g]),
                    (C = f[z]),
                    (B = q(z, C, g)),
                    m[B])
                  )
                    (A = m[B]), delete m[B], (v[B] = A), (F[g] = A);
                  else {
                    if (v[B])
                      throw (
                        (r(F, function (a) {
                          a && a.scope && (m[a.id] = a);
                        }),
                        c("dupes", k, B, C))
                      );
                    F[g] = { id: B, scope: void 0, clone: void 0 };
                    v[B] = !0;
                  }
                for (s in m) {
                  A = m[s];
                  B = tb(A.clone);
                  b.leave(B);
                  if (B[0].parentNode)
                    for (g = 0, q = B.length; g < q; g++)
                      B[g].$$NG_REMOVED = !0;
                  A.scope.$destroy();
                }
                for (g = 0; g < D; g++)
                  if (
                    ((z = f === E ? g : E[g]), (C = f[z]), (A = F[g]), A.scope)
                  ) {
                    s = p;
                    do s = s.nextSibling;
                    while (s && s.$$NG_REMOVED);
                    A.clone[0] !== s && b.move(tb(A.clone), null, p);
                    p = A.clone[A.clone.length - 1];
                    e(A.scope, g, t, C, u, z, D);
                  } else
                    l(function (a, c) {
                      A.scope = c;
                      var d = h.cloneNode(!1);
                      a[a.length++] = d;
                      b.enter(a, null, p);
                      p = d;
                      A.clone = a;
                      v[A.id] = A;
                      e(A.scope, g, t, C, u, z, D);
                    });
                m = v;
              });
            };
          },
        };
      },
    ],
    ef = [
      "$animate",
      function (a) {
        return {
          restrict: "A",
          multiElement: !0,
          link: function (b, d, c) {
            b.$watch(c.ngShow, function (b) {
              a[b ? "removeClass" : "addClass"](d, "ng-hide", {
                tempClasses: "ng-hide-animate",
              });
            });
          },
        };
      },
    ],
    Xe = [
      "$animate",
      function (a) {
        return {
          restrict: "A",
          multiElement: !0,
          link: function (b, d, c) {
            b.$watch(c.ngHide, function (b) {
              a[b ? "addClass" : "removeClass"](d, "ng-hide", {
                tempClasses: "ng-hide-animate",
              });
            });
          },
        };
      },
    ],
    ff = Na(function (a, b, d) {
      a.$watchCollection(d.ngStyle, function (a, d) {
        d &&
          a !== d &&
          r(d, function (a, c) {
            b.css(c, "");
          });
        a && b.css(a);
      });
    }),
    gf = [
      "$animate",
      "$compile",
      function (a, b) {
        return {
          require: "ngSwitch",
          controller: [
            "$scope",
            function () {
              this.cases = {};
            },
          ],
          link: function (d, c, e, f) {
            var g = [],
              k = [],
              h = [],
              l = [],
              m = function (a, b) {
                return function (c) {
                  !1 !== c && a.splice(b, 1);
                };
              };
            d.$watch(e.ngSwitch || e.on, function (c) {
              for (var d, e; h.length; ) a.cancel(h.pop());
              d = 0;
              for (e = l.length; d < e; ++d) {
                var p = tb(k[d].clone);
                l[d].$destroy();
                (h[d] = a.leave(p)).done(m(h, d));
              }
              k.length = 0;
              l.length = 0;
              (g = f.cases["!" + c] || f.cases["?"]) &&
                r(g, function (c) {
                  c.transclude(function (d, e) {
                    l.push(e);
                    var f = c.element;
                    d[d.length++] = b.$$createComment("end ngSwitchWhen");
                    k.push({ clone: d });
                    a.enter(d, f.parent(), f);
                  });
                });
            });
          },
        };
      },
    ],
    hf = Na({
      transclude: "element",
      priority: 1200,
      require: "^ngSwitch",
      multiElement: !0,
      link: function (a, b, d, c, e) {
        a = d.ngSwitchWhen
          .split(d.ngSwitchWhenSeparator)
          .sort()
          .filter(function (a, b, c) {
            return c[b - 1] !== a;
          });
        r(a, function (a) {
          c.cases["!" + a] = c.cases["!" + a] || [];
          c.cases["!" + a].push({ transclude: e, element: b });
        });
      },
    }),
    jf = Na({
      transclude: "element",
      priority: 1200,
      require: "^ngSwitch",
      multiElement: !0,
      link: function (a, b, d, c, e) {
        c.cases["?"] = c.cases["?"] || [];
        c.cases["?"].push({ transclude: e, element: b });
      },
    }),
    vh = M("ngTransclude"),
    lf = [
      "$compile",
      function (a) {
        return {
          restrict: "EAC",
          compile: function (b) {
            var d = a(b.contents());
            b.empty();
            return function (a, b, f, g, k) {
              function h() {
                d(a, function (a) {
                  b.append(a);
                });
              }
              if (!k) throw vh("orphan", ya(b));
              f.ngTransclude === f.$attr.ngTransclude && (f.ngTransclude = "");
              f = f.ngTransclude || f.ngTranscludeSlot;
              k(
                function (a, c) {
                  var d;
                  if ((d = a.length))
                    a: {
                      d = 0;
                      for (var f = a.length; d < f; d++) {
                        var g = a[d];
                        if (g.nodeType !== Oa || g.nodeValue.trim()) {
                          d = !0;
                          break a;
                        }
                      }
                      d = void 0;
                    }
                  d ? b.append(a) : (h(), c.$destroy());
                },
                null,
                f
              );
              f && !k.isSlotFilled(f) && h();
            };
          },
        };
      },
    ],
    Le = [
      "$templateCache",
      function (a) {
        return {
          restrict: "E",
          terminal: !0,
          compile: function (b, d) {
            "text/ng-template" === d.type && a.put(d.id, b[0].text);
          },
        };
      },
    ],
    wh = { $setViewValue: A, $render: A },
    xh = [
      "$element",
      "$scope",
      function (a, b) {
        function d() {
          g ||
            ((g = !0),
            b.$$postDigest(function () {
              g = !1;
              e.ngModelCtrl.$render();
            }));
        }
        function c(a) {
          k ||
            ((k = !0),
            b.$$postDigest(function () {
              b.$$destroyed ||
                ((k = !1),
                e.ngModelCtrl.$setViewValue(e.readValue()),
                a && e.ngModelCtrl.$render());
            }));
        }
        var e = this,
          f = new Hb();
        e.selectValueMap = {};
        e.ngModelCtrl = wh;
        e.multiple = !1;
        e.unknownOption = y(B.document.createElement("option"));
        e.hasEmptyOption = !1;
        e.emptyOption = void 0;
        e.renderUnknownOption = function (b) {
          b = e.generateUnknownOptionValue(b);
          e.unknownOption.val(b);
          a.prepend(e.unknownOption);
          Ea(e.unknownOption, !0);
          a.val(b);
        };
        e.updateUnknownOption = function (b) {
          b = e.generateUnknownOptionValue(b);
          e.unknownOption.val(b);
          Ea(e.unknownOption, !0);
          a.val(b);
        };
        e.generateUnknownOptionValue = function (a) {
          return "? " + Ka(a) + " ?";
        };
        e.removeUnknownOption = function () {
          e.unknownOption.parent() && e.unknownOption.remove();
        };
        e.selectEmptyOption = function () {
          e.emptyOption && (a.val(""), Ea(e.emptyOption, !0));
        };
        e.unselectEmptyOption = function () {
          e.hasEmptyOption && Ea(e.emptyOption, !1);
        };
        b.$on("$destroy", function () {
          e.renderUnknownOption = A;
        });
        e.readValue = function () {
          var b = a.val(),
            b = b in e.selectValueMap ? e.selectValueMap[b] : b;
          return e.hasOption(b) ? b : null;
        };
        e.writeValue = function (b) {
          var c = a[0].options[a[0].selectedIndex];
          c && Ea(y(c), !1);
          e.hasOption(b)
            ? (e.removeUnknownOption(),
              (c = Ka(b)),
              a.val(c in e.selectValueMap ? c : b),
              Ea(y(a[0].options[a[0].selectedIndex]), !0))
            : e.selectUnknownOrEmptyOption(b);
        };
        e.addOption = function (a, b) {
          if (8 !== b[0].nodeType) {
            Qa(a, '"option value"');
            "" === a && ((e.hasEmptyOption = !0), (e.emptyOption = b));
            var c = f.get(a) || 0;
            f.set(a, c + 1);
            d();
          }
        };
        e.removeOption = function (a) {
          var b = f.get(a);
          b &&
            (1 === b
              ? (f.delete(a),
                "" === a && ((e.hasEmptyOption = !1), (e.emptyOption = void 0)))
              : f.set(a, b - 1));
        };
        e.hasOption = function (a) {
          return !!f.get(a);
        };
        e.$hasEmptyOption = function () {
          return e.hasEmptyOption;
        };
        e.$isUnknownOptionSelected = function () {
          return a[0].options[0] === e.unknownOption[0];
        };
        e.$isEmptyOptionSelected = function () {
          return (
            e.hasEmptyOption &&
            a[0].options[a[0].selectedIndex] === e.emptyOption[0]
          );
        };
        e.selectUnknownOrEmptyOption = function (a) {
          null == a && e.emptyOption
            ? (e.removeUnknownOption(), e.selectEmptyOption())
            : e.unknownOption.parent().length
            ? e.updateUnknownOption(a)
            : e.renderUnknownOption(a);
        };
        var g = !1,
          k = !1;
        e.registerOption = function (a, b, f, g, k) {
          if (f.$attr.ngValue) {
            var p, r;
            f.$observe("value", function (a) {
              var d,
                f = b.prop("selected");
              v(r) && (e.removeOption(p), delete e.selectValueMap[r], (d = !0));
              r = Ka(a);
              p = a;
              e.selectValueMap[r] = a;
              e.addOption(a, b);
              b.attr("value", r);
              d && f && c();
            });
          } else
            g
              ? f.$observe("value", function (a) {
                  e.readValue();
                  var d,
                    f = b.prop("selected");
                  v(p) && (e.removeOption(p), (d = !0));
                  p = a;
                  e.addOption(a, b);
                  d && f && c();
                })
              : k
              ? a.$watch(k, function (a, d) {
                  f.$set("value", a);
                  var g = b.prop("selected");
                  d !== a && e.removeOption(d);
                  e.addOption(a, b);
                  d && g && c();
                })
              : e.addOption(f.value, b);
          f.$observe("disabled", function (a) {
            if ("true" === a || (a && b.prop("selected")))
              e.multiple
                ? c(!0)
                : (e.ngModelCtrl.$setViewValue(null), e.ngModelCtrl.$render());
          });
          b.on("$destroy", function () {
            var a = e.readValue(),
              b = f.value;
            e.removeOption(b);
            d();
            ((e.multiple && a && -1 !== a.indexOf(b)) || a === b) && c(!0);
          });
        };
      },
    ],
    Me = function () {
      return {
        restrict: "E",
        require: ["select", "?ngModel"],
        controller: xh,
        priority: 1,
        link: {
          pre: function (a, b, d, c) {
            var e = c[0],
              f = c[1];
            if (f) {
              if (
                ((e.ngModelCtrl = f),
                b.on("change", function () {
                  e.removeUnknownOption();
                  a.$apply(function () {
                    f.$setViewValue(e.readValue());
                  });
                }),
                d.multiple)
              ) {
                e.multiple = !0;
                e.readValue = function () {
                  var a = [];
                  r(b.find("option"), function (b) {
                    b.selected &&
                      !b.disabled &&
                      ((b = b.value),
                      a.push(b in e.selectValueMap ? e.selectValueMap[b] : b));
                  });
                  return a;
                };
                e.writeValue = function (a) {
                  r(b.find("option"), function (b) {
                    var c =
                      !!a &&
                      (-1 !== Array.prototype.indexOf.call(a, b.value) ||
                        -1 !==
                          Array.prototype.indexOf.call(
                            a,
                            e.selectValueMap[b.value]
                          ));
                    c !== b.selected && Ea(y(b), c);
                  });
                };
                var g,
                  k = NaN;
                a.$watch(function () {
                  k !== f.$viewValue ||
                    ua(g, f.$viewValue) ||
                    ((g = oa(f.$viewValue)), f.$render());
                  k = f.$viewValue;
                });
                f.$isEmpty = function (a) {
                  return !a || 0 === a.length;
                };
              }
            } else e.registerOption = A;
          },
          post: function (a, b, d, c) {
            var e = c[1];
            if (e) {
              var f = c[0];
              e.$render = function () {
                f.writeValue(e.$viewValue);
              };
            }
          },
        },
      };
    },
    Ne = [
      "$interpolate",
      function (a) {
        return {
          restrict: "E",
          priority: 100,
          compile: function (b, d) {
            var c, e;
            v(d.ngValue) ||
              (v(d.value)
                ? (c = a(d.value, !0))
                : (e = a(b.text(), !0)) || d.$set("value", b.text()));
            return function (a, b, d) {
              var h = b.parent();
              (h =
                h.data("$selectController") ||
                h.parent().data("$selectController")) &&
                h.registerOption(a, b, d, c, e);
            };
          },
        };
      },
    ],
    Zc = function () {
      return {
        restrict: "A",
        require: "?ngModel",
        link: function (a, b, d, c) {
          c &&
            ((d.required = !0),
            (c.$validators.required = function (a, b) {
              return !d.required || !c.$isEmpty(b);
            }),
            d.$observe("required", function () {
              c.$validate();
            }));
        },
      };
    },
    Yc = function () {
      return {
        restrict: "A",
        require: "?ngModel",
        link: function (a, b, d, c) {
          if (c) {
            var e,
              f = d.ngPattern || d.pattern;
            d.$observe("pattern", function (a) {
              C(a) && 0 < a.length && (a = new RegExp("^" + a + "$"));
              if (a && !a.test) throw M("ngPattern")("noregexp", f, a, ya(b));
              e = a || void 0;
              c.$validate();
            });
            c.$validators.pattern = function (a, b) {
              return c.$isEmpty(b) || x(e) || e.test(b);
            };
          }
        },
      };
    },
    ad = function () {
      return {
        restrict: "A",
        require: "?ngModel",
        link: function (a, b, d, c) {
          if (c) {
            var e = -1;
            d.$observe("maxlength", function (a) {
              a = da(a);
              e = V(a) ? -1 : a;
              c.$validate();
            });
            c.$validators.maxlength = function (a, b) {
              return 0 > e || c.$isEmpty(b) || b.length <= e;
            };
          }
        },
      };
    },
    $c = function () {
      return {
        restrict: "A",
        require: "?ngModel",
        link: function (a, b, d, c) {
          if (c) {
            var e = 0;
            d.$observe("minlength", function (a) {
              e = da(a) || 0;
              c.$validate();
            });
            c.$validators.minlength = function (a, b) {
              return c.$isEmpty(b) || b.length >= e;
            };
          }
        },
      };
    };
  B.angular.bootstrap
    ? B.console &&
      console.log("WARNING: Tried to load AngularJS more than once.")
    : (Ce(),
      Ge(ea),
      ea.module(
        "ngLocale",
        [],
        [
          "$provide",
          function (a) {
            function b(a) {
              a += "";
              var b = a.indexOf(".");
              return -1 == b ? 0 : a.length - b - 1;
            }
            a.value("$locale", {
              DATETIME_FORMATS: {
                AMPMS: ["AM", "PM"],
                DAY: "Sunday Monday Tuesday Wednesday Thursday Friday Saturday".split(
                  " "
                ),
                ERANAMES: ["Before Christ", "Anno Domini"],
                ERAS: ["BC", "AD"],
                FIRSTDAYOFWEEK: 6,
                MONTH: "January February March April May June July August September October November December".split(
                  " "
                ),
                SHORTDAY: "Sun Mon Tue Wed Thu Fri Sat".split(" "),
                SHORTMONTH: "Jan Feb Mar Apr May Jun Jul Aug Sep Oct Nov Dec".split(
                  " "
                ),
                STANDALONEMONTH: "January February March April May June July August September October November December".split(
                  " "
                ),
                WEEKENDRANGE: [5, 6],
                fullDate: "EEEE, MMMM d, y",
                longDate: "MMMM d, y",
                medium: "MMM d, y h:mm:ss a",
                mediumDate: "MMM d, y",
                mediumTime: "h:mm:ss a",
                short: "M/d/yy h:mm a",
                shortDate: "M/d/yy",
                shortTime: "h:mm a",
              },
              NUMBER_FORMATS: {
                CURRENCY_SYM: "$",
                DECIMAL_SEP: ".",
                GROUP_SEP: ",",
                PATTERNS: [
                  {
                    gSize: 3,
                    lgSize: 3,
                    maxFrac: 3,
                    minFrac: 0,
                    minInt: 1,
                    negPre: "-",
                    negSuf: "",
                    posPre: "",
                    posSuf: "",
                  },
                  {
                    gSize: 3,
                    lgSize: 3,
                    maxFrac: 2,
                    minFrac: 2,
                    minInt: 1,
                    negPre: "-\u00a4",
                    negSuf: "",
                    posPre: "\u00a4",
                    posSuf: "",
                  },
                ],
              },
              id: "en-us",
              localeID: "en_US",
              pluralCat: function (a, c) {
                var e = a | 0,
                  f = c;
                void 0 === f && (f = Math.min(b(a), 3));
                Math.pow(10, f);
                return 1 == e && 0 == f ? "one" : "other";
              },
            });
          },
        ]
      ),
      y(function () {
        xe(B.document, Tc);
      }));
})(window);
!window.angular.$$csp().noInlineStyle &&
  window.angular
    .element(document.head)
    .prepend(
      '<style type="text/css">@charset "UTF-8";[ng\\:cloak],[ng-cloak],[data-ng-cloak],[x-ng-cloak],.ng-cloak,.x-ng-cloak,.ng-hide:not(.ng-hide-animate){display:none !important;}ng\\:form{display:block;}.ng-animate-shim{visibility:hidden;}.ng-anchor{position:absolute;}</style>'
    );
//# sourceMappingURL=angular.min.js.map

/*
 AngularJS v1.7.5
 (c) 2010-2018 Google, Inc. http://angularjs.org
 License: MIT
*/
(function (s, c) {
  "use strict";
  function P(c) {
    var h = [];
    C(h, E).chars(c);
    return h.join("");
  }
  var D = c.$$minErr("$sanitize"),
    F,
    h,
    G,
    H,
    I,
    q,
    E,
    J,
    K,
    C;
  c.module("ngSanitize", [])
    .provider("$sanitize", function () {
      function f(a, e) {
        return B(a.split(","), e);
      }
      function B(a, e) {
        var d = {},
          b;
        for (b = 0; b < a.length; b++) d[e ? q(a[b]) : a[b]] = !0;
        return d;
      }
      function t(a, e) {
        e && e.length && h(a, B(e));
      }
      function Q(a) {
        for (var e = {}, d = 0, b = a.length; d < b; d++) {
          var k = a[d];
          e[k.name] = k.value;
        }
        return e;
      }
      function L(a) {
        return a
          .replace(/&/g, "&amp;")
          .replace(z, function (a) {
            var d = a.charCodeAt(0);
            a = a.charCodeAt(1);
            return "&#" + (1024 * (d - 55296) + (a - 56320) + 65536) + ";";
          })
          .replace(u, function (a) {
            return "&#" + a.charCodeAt(0) + ";";
          })
          .replace(/</g, "&lt;")
          .replace(/>/g, "&gt;");
      }
      function A(a) {
        for (; a; ) {
          if (a.nodeType === s.Node.ELEMENT_NODE)
            for (var e = a.attributes, d = 0, b = e.length; d < b; d++) {
              var k = e[d],
                g = k.name.toLowerCase();
              if ("xmlns:ns1" === g || 0 === g.lastIndexOf("ns1:", 0))
                a.removeAttributeNode(k), d--, b--;
            }
          (e = a.firstChild) && A(e);
          a = v("nextSibling", a);
        }
      }
      function v(a, e) {
        var d = e[a];
        if (d && J.call(e, d)) throw D("elclob", e.outerHTML || e.outerText);
        return d;
      }
      var y = !1,
        g = !1;
      this.$get = [
        "$$sanitizeUri",
        function (a) {
          y = !0;
          g && h(m, l);
          return function (e) {
            var d = [];
            K(
              e,
              C(d, function (b, d) {
                return !/^unsafe:/.test(a(b, d));
              })
            );
            return d.join("");
          };
        },
      ];
      this.enableSvg = function (a) {
        return I(a) ? ((g = a), this) : g;
      };
      this.addValidElements = function (a) {
        y ||
          (H(a) && (a = { htmlElements: a }),
          t(l, a.svgElements),
          t(r, a.htmlVoidElements),
          t(m, a.htmlVoidElements),
          t(m, a.htmlElements));
        return this;
      };
      this.addValidAttrs = function (a) {
        y || h(M, B(a, !0));
        return this;
      };
      F = c.bind;
      h = c.extend;
      G = c.forEach;
      H = c.isArray;
      I = c.isDefined;
      q = c.$$lowercase;
      E = c.noop;
      K = function (a, e) {
        null === a || void 0 === a
          ? (a = "")
          : "string" !== typeof a && (a = "" + a);
        var d = N(a);
        if (!d) return "";
        var b = 5;
        do {
          if (0 === b) throw D("uinput");
          b--;
          a = d.innerHTML;
          d = N(a);
        } while (a !== d.innerHTML);
        for (b = d.firstChild; b; ) {
          switch (b.nodeType) {
            case 1:
              e.start(b.nodeName.toLowerCase(), Q(b.attributes));
              break;
            case 3:
              e.chars(b.textContent);
          }
          var k;
          if (
            !(k = b.firstChild) &&
            (1 === b.nodeType && e.end(b.nodeName.toLowerCase()),
            (k = v("nextSibling", b)),
            !k)
          )
            for (; null == k; ) {
              b = v("parentNode", b);
              if (b === d) break;
              k = v("nextSibling", b);
              1 === b.nodeType && e.end(b.nodeName.toLowerCase());
            }
          b = k;
        }
        for (; (b = d.firstChild); ) d.removeChild(b);
      };
      C = function (a, e) {
        var d = !1,
          b = F(a, a.push);
        return {
          start: function (a, g) {
            a = q(a);
            !d && w[a] && (d = a);
            d ||
              !0 !== m[a] ||
              (b("<"),
              b(a),
              G(g, function (d, g) {
                var c = q(g),
                  f = ("img" === a && "src" === c) || "background" === c;
                !0 !== M[c] ||
                  (!0 === O[c] && !e(d, f)) ||
                  (b(" "), b(g), b('="'), b(L(d)), b('"'));
              }),
              b(">"));
          },
          end: function (a) {
            a = q(a);
            d || !0 !== m[a] || !0 === r[a] || (b("</"), b(a), b(">"));
            a == d && (d = !1);
          },
          chars: function (a) {
            d || b(L(a));
          },
        };
      };
      J =
        s.Node.prototype.contains ||
        function (a) {
          return !!(this.compareDocumentPosition(a) & 16);
        };
      var z = /[\uD800-\uDBFF][\uDC00-\uDFFF]/g,
        u = /([^#-~ |!])/g,
        r = f("area,br,col,hr,img,wbr"),
        x = f("colgroup,dd,dt,li,p,tbody,td,tfoot,th,thead,tr"),
        p = f("rp,rt"),
        n = h({}, p, x),
        x = h(
          {},
          x,
          f(
            "address,article,aside,blockquote,caption,center,del,dir,div,dl,figure,figcaption,footer,h1,h2,h3,h4,h5,h6,header,hgroup,hr,ins,map,menu,nav,ol,pre,section,table,ul"
          )
        ),
        p = h(
          {},
          p,
          f(
            "a,abbr,acronym,b,bdi,bdo,big,br,cite,code,del,dfn,em,font,i,img,ins,kbd,label,map,mark,q,ruby,rp,rt,s,samp,small,span,strike,strong,sub,sup,time,tt,u,var"
          )
        ),
        l = f(
          "circle,defs,desc,ellipse,font-face,font-face-name,font-face-src,g,glyph,hkern,image,linearGradient,line,marker,metadata,missing-glyph,mpath,path,polygon,polyline,radialGradient,rect,stop,svg,switch,text,title,tspan"
        ),
        w = f("script,style"),
        m = h({}, r, x, p, n),
        O = f("background,cite,href,longdesc,src,xlink:href,xml:base"),
        n = f(
          "abbr,align,alt,axis,bgcolor,border,cellpadding,cellspacing,class,clear,color,cols,colspan,compact,coords,dir,face,headers,height,hreflang,hspace,ismap,lang,language,nohref,nowrap,rel,rev,rows,rowspan,rules,scope,scrolling,shape,size,span,start,summary,tabindex,target,title,type,valign,value,vspace,width"
        ),
        p = f(
          "accent-height,accumulate,additive,alphabetic,arabic-form,ascent,baseProfile,bbox,begin,by,calcMode,cap-height,class,color,color-rendering,content,cx,cy,d,dx,dy,descent,display,dur,end,fill,fill-rule,font-family,font-size,font-stretch,font-style,font-variant,font-weight,from,fx,fy,g1,g2,glyph-name,gradientUnits,hanging,height,horiz-adv-x,horiz-origin-x,ideographic,k,keyPoints,keySplines,keyTimes,lang,marker-end,marker-mid,marker-start,markerHeight,markerUnits,markerWidth,mathematical,max,min,offset,opacity,orient,origin,overline-position,overline-thickness,panose-1,path,pathLength,points,preserveAspectRatio,r,refX,refY,repeatCount,repeatDur,requiredExtensions,requiredFeatures,restart,rotate,rx,ry,slope,stemh,stemv,stop-color,stop-opacity,strikethrough-position,strikethrough-thickness,stroke,stroke-dasharray,stroke-dashoffset,stroke-linecap,stroke-linejoin,stroke-miterlimit,stroke-opacity,stroke-width,systemLanguage,target,text-anchor,to,transform,type,u1,u2,underline-position,underline-thickness,unicode,unicode-range,units-per-em,values,version,viewBox,visibility,width,widths,x,x-height,x1,x2,xlink:actuate,xlink:arcrole,xlink:role,xlink:show,xlink:title,xlink:type,xml:base,xml:lang,xml:space,xmlns,xmlns:xlink,y,y1,y2,zoomAndPan",
          !0
        ),
        M = h({}, O, p, n),
        N = (function (a, e) {
          function d(b) {
            b = "<remove></remove>" + b;
            try {
              var d = new a.DOMParser().parseFromString(b, "text/html").body;
              d.firstChild.remove();
              return d;
            } catch (e) {}
          }
          function b(a) {
            c.innerHTML = a;
            e.documentMode && A(c);
            return c;
          }
          var g;
          if (e && e.implementation)
            g = e.implementation.createHTMLDocument("inert");
          else throw D("noinert");
          var c = (g.documentElement || g.getDocumentElement()).querySelector(
            "body"
          );
          c.innerHTML = '<svg><g onload="this.parentNode.remove()"></g></svg>';
          return c.querySelector("svg")
            ? ((c.innerHTML =
                '<svg><p><style><img src="</style><img src=x onerror=alert(1)//">'),
              c.querySelector("svg img") ? d : b)
            : function (b) {
                b = "<remove></remove>" + b;
                try {
                  b = encodeURI(b);
                } catch (d) {
                  return;
                }
                var e = new a.XMLHttpRequest();
                e.responseType = "document";
                e.open("GET", "data:text/html;charset=utf-8," + b, !1);
                e.send(null);
                b = e.response.body;
                b.firstChild.remove();
                return b;
              };
        })(s, s.document);
    })
    .info({ angularVersion: "1.7.5" });
  c.module("ngSanitize").filter("linky", [
    "$sanitize",
    function (f) {
      var h = /((s?ftp|https?):\/\/|(www\.)|(mailto:)?[A-Za-z0-9._%+-]+@)\S*[^\s.;,(){}<>"\u201d\u2019]/i,
        t = /^mailto:/i,
        q = c.$$minErr("linky"),
        s = c.isDefined,
        A = c.isFunction,
        v = c.isObject,
        y = c.isString;
      return function (c, z, u) {
        function r(c) {
          c && l.push(P(c));
        }
        function x(c, g) {
          var f,
            a = p(c);
          l.push("<a ");
          for (f in a) l.push(f + '="' + a[f] + '" ');
          !s(z) || "target" in a || l.push('target="', z, '" ');
          l.push('href="', c.replace(/"/g, "&quot;"), '">');
          r(g);
          l.push("</a>");
        }
        if (null == c || "" === c) return c;
        if (!y(c)) throw q("notstring", c);
        for (
          var p = A(u)
              ? u
              : v(u)
              ? function () {
                  return u;
                }
              : function () {
                  return {};
                },
            n = c,
            l = [],
            w,
            m;
          (c = n.match(h));

        )
          (w = c[0]),
            c[2] || c[4] || (w = (c[3] ? "http://" : "mailto:") + w),
            (m = c.index),
            r(n.substr(0, m)),
            x(w, c[0].replace(t, "")),
            (n = n.substring(m + c[0].length));
        r(n);
        return f(l.join(""));
      };
    },
  ]);
})(window, window.angular);
//# sourceMappingURL=angular-sanitize.min.js.map

/*
 AngularJS v1.7.5
 (c) 2010-2018 Google, Inc. http://angularjs.org
 License: MIT
*/
(function (n, e) {
  "use strict";
  function m(d, k, l) {
    var a = l.baseHref(),
      h = d[0];
    return function (f, b, c) {
      var d, g;
      c = c || {};
      g = c.expires;
      d = e.isDefined(c.path) ? c.path : a;
      e.isUndefined(b) && ((g = "Thu, 01 Jan 1970 00:00:00 GMT"), (b = ""));
      e.isString(g) && (g = new Date(g));
      b = encodeURIComponent(f) + "=" + encodeURIComponent(b);
      b = b + (d ? ";path=" + d : "") + (c.domain ? ";domain=" + c.domain : "");
      b += g ? ";expires=" + g.toUTCString() : "";
      b += c.secure ? ";secure" : "";
      b += c.samesite ? ";samesite=" + c.samesite : "";
      c = b.length + 1;
      4096 < c &&
        k.warn(
          "Cookie '" +
            f +
            "' possibly not set or overflowed because it was too large (" +
            c +
            " > 4096 bytes)!"
        );
      h.cookie = b;
    };
  }
  e.module("ngCookies", ["ng"])
    .info({ angularVersion: "1.7.5" })
    .provider("$cookies", [
      function () {
        var d = (this.defaults = {});
        this.$get = [
          "$$cookieReader",
          "$$cookieWriter",
          function (k, l) {
            return {
              get: function (a) {
                return k()[a];
              },
              getObject: function (a) {
                return (a = this.get(a)) ? e.fromJson(a) : a;
              },
              getAll: function () {
                return k();
              },
              put: function (a, h, f) {
                l(a, h, f ? e.extend({}, d, f) : d);
              },
              putObject: function (a, d, f) {
                this.put(a, e.toJson(d), f);
              },
              remove: function (a, h) {
                l(a, void 0, h ? e.extend({}, d, h) : d);
              },
            };
          },
        ];
      },
    ]);
  m.$inject = ["$document", "$log", "$browser"];
  e.module("ngCookies").provider("$$cookieWriter", function () {
    this.$get = m;
  });
})(window, window.angular);
//# sourceMappingURL=angular-cookies.min.js.map

/*
 AngularJS v1.7.5
 (c) 2010-2018 Google, Inc. http://angularjs.org
 License: MIT
*/
(function (I, b) {
  "use strict";
  function z(b, h) {
    var d = [],
      c = b
        .replace(/([().])/g, "\\$1")
        .replace(/(\/)?:(\w+)(\*\?|[?*])?/g, function (b, c, h, k) {
          b = "?" === k || "*?" === k;
          k = "*" === k || "*?" === k;
          d.push({ name: h, optional: b });
          c = c || "";
          return (
            (b ? "(?:" + c : c + "(?:") +
            (k ? "(.+?)" : "([^/]+)") +
            (b ? "?)?" : ")")
          );
        })
        .replace(/([/$*])/g, "\\$1");
    h.ignoreTrailingSlashes && (c = c.replace(/\/+$/, "") + "/*");
    return {
      keys: d,
      regexp: new RegExp(
        "^" + c + "(?:[?#]|$)",
        h.caseInsensitiveMatch ? "i" : ""
      ),
    };
  }
  function A(b) {
    p && b.get("$route");
  }
  function v(u, h, d) {
    return {
      restrict: "ECA",
      terminal: !0,
      priority: 400,
      transclude: "element",
      link: function (c, f, g, l, k) {
        function q() {
          r && (d.cancel(r), (r = null));
          m && (m.$destroy(), (m = null));
          s &&
            ((r = d.leave(s)),
            r.done(function (b) {
              !1 !== b && (r = null);
            }),
            (s = null));
        }
        function C() {
          var g = u.current && u.current.locals;
          if (b.isDefined(g && g.$template)) {
            var g = c.$new(),
              l = u.current;
            s = k(g, function (g) {
              d.enter(g, null, s || f).done(function (d) {
                !1 === d || !b.isDefined(w) || (w && !c.$eval(w)) || h();
              });
              q();
            });
            m = l.scope = g;
            m.$emit("$viewContentLoaded");
            m.$eval(p);
          } else q();
        }
        var m,
          s,
          r,
          w = g.autoscroll,
          p = g.onload || "";
        c.$on("$routeChangeSuccess", C);
        C();
      },
    };
  }
  function x(b, h, d) {
    return {
      restrict: "ECA",
      priority: -400,
      link: function (c, f) {
        var g = d.current,
          l = g.locals;
        f.html(l.$template);
        var k = b(f.contents());
        if (g.controller) {
          l.$scope = c;
          var q = h(g.controller, l);
          g.controllerAs && (c[g.controllerAs] = q);
          f.data("$ngControllerController", q);
          f.children().data("$ngControllerController", q);
        }
        c[g.resolveAs || "$resolve"] = l;
        k(c);
      },
    };
  }
  var D,
    E,
    F,
    G,
    y = b
      .module("ngRoute", [])
      .info({ angularVersion: "1.7.5" })
      .provider("$route", function () {
        function u(d, c) {
          return b.extend(Object.create(d), c);
        }
        D = b.isArray;
        E = b.isObject;
        F = b.isDefined;
        G = b.noop;
        var h = {};
        this.when = function (d, c) {
          var f;
          f = void 0;
          if (D(c)) {
            f = f || [];
            for (var g = 0, l = c.length; g < l; g++) f[g] = c[g];
          } else if (E(c))
            for (g in ((f = f || {}), c))
              if ("$" !== g.charAt(0) || "$" !== g.charAt(1)) f[g] = c[g];
          f = f || c;
          b.isUndefined(f.reloadOnUrl) && (f.reloadOnUrl = !0);
          b.isUndefined(f.reloadOnSearch) && (f.reloadOnSearch = !0);
          b.isUndefined(f.caseInsensitiveMatch) &&
            (f.caseInsensitiveMatch = this.caseInsensitiveMatch);
          h[d] = b.extend(f, { originalPath: d }, d && z(d, f));
          d &&
            ((g =
              "/" === d[d.length - 1] ? d.substr(0, d.length - 1) : d + "/"),
            (h[g] = b.extend({ originalPath: d, redirectTo: d }, z(g, f))));
          return this;
        };
        this.caseInsensitiveMatch = !1;
        this.otherwise = function (b) {
          "string" === typeof b && (b = { redirectTo: b });
          this.when(null, b);
          return this;
        };
        p = !0;
        this.eagerInstantiationEnabled = function (b) {
          return F(b) ? ((p = b), this) : p;
        };
        this.$get = [
          "$rootScope",
          "$location",
          "$routeParams",
          "$q",
          "$injector",
          "$templateRequest",
          "$sce",
          "$browser",
          function (d, c, f, g, l, k, q, p) {
            function m(a) {
              var e = t.current;
              n = A();
              (x =
                !B &&
                n &&
                e &&
                n.$$route === e.$$route &&
                (!n.reloadOnUrl ||
                  (!n.reloadOnSearch &&
                    b.equals(n.pathParams, e.pathParams)))) ||
                (!e && !n) ||
                (d.$broadcast("$routeChangeStart", n, e).defaultPrevented &&
                  a &&
                  a.preventDefault());
            }
            function s() {
              var a = t.current,
                e = n;
              if (x)
                (a.params = e.params),
                  b.copy(a.params, f),
                  d.$broadcast("$routeUpdate", a);
              else if (e || a) {
                B = !1;
                t.current = e;
                var c = g.resolve(e);
                p.$$incOutstandingRequestCount("$route");
                c.then(r)
                  .then(w)
                  .then(function (g) {
                    return (
                      g &&
                      c.then(y).then(function (c) {
                        e === t.current &&
                          (e && ((e.locals = c), b.copy(e.params, f)),
                          d.$broadcast("$routeChangeSuccess", e, a));
                      })
                    );
                  })
                  .catch(function (b) {
                    e === t.current &&
                      d.$broadcast("$routeChangeError", e, a, b);
                  })
                  .finally(function () {
                    p.$$completeOutstandingRequest(G, "$route");
                  });
              }
            }
            function r(a) {
              var e = { route: a, hasRedirection: !1 };
              if (a)
                if (a.redirectTo)
                  if (b.isString(a.redirectTo))
                    (e.path = v(a.redirectTo, a.params)),
                      (e.search = a.params),
                      (e.hasRedirection = !0);
                  else {
                    var d = c.path(),
                      f = c.search();
                    a = a.redirectTo(a.pathParams, d, f);
                    b.isDefined(a) && ((e.url = a), (e.hasRedirection = !0));
                  }
                else if (a.resolveRedirectTo)
                  return g
                    .resolve(l.invoke(a.resolveRedirectTo))
                    .then(function (a) {
                      b.isDefined(a) && ((e.url = a), (e.hasRedirection = !0));
                      return e;
                    });
              return e;
            }
            function w(a) {
              var b = !0;
              if (a.route !== t.current) b = !1;
              else if (a.hasRedirection) {
                var g = c.url(),
                  d = a.url;
                d
                  ? c.url(d).replace()
                  : (d = c.path(a.path).search(a.search).replace().url());
                d !== g && (b = !1);
              }
              return b;
            }
            function y(a) {
              if (a) {
                var e = b.extend({}, a.resolve);
                b.forEach(e, function (a, c) {
                  e[c] = b.isString(a) ? l.get(a) : l.invoke(a, null, null, c);
                });
                a = z(a);
                b.isDefined(a) && (e.$template = a);
                return g.all(e);
              }
            }
            function z(a) {
              var e, c;
              b.isDefined((e = a.template))
                ? b.isFunction(e) && (e = e(a.params))
                : b.isDefined((c = a.templateUrl)) &&
                  (b.isFunction(c) && (c = c(a.params)),
                  b.isDefined(c) &&
                    ((a.loadedTemplateUrl = q.valueOf(c)), (e = k(c))));
              return e;
            }
            function A() {
              var a, e;
              b.forEach(h, function (d, g) {
                var f;
                if ((f = !e)) {
                  var h = c.path();
                  f = d.keys;
                  var l = {};
                  if (d.regexp)
                    if ((h = d.regexp.exec(h))) {
                      for (var k = 1, p = h.length; k < p; ++k) {
                        var m = f[k - 1],
                          n = h[k];
                        m && n && (l[m.name] = n);
                      }
                      f = l;
                    } else f = null;
                  else f = null;
                  f = a = f;
                }
                f &&
                  ((e = u(d, {
                    params: b.extend({}, c.search(), a),
                    pathParams: a,
                  })),
                  (e.$$route = d));
              });
              return (
                e || (h[null] && u(h[null], { params: {}, pathParams: {} }))
              );
            }
            function v(a, c) {
              var d = [];
              b.forEach((a || "").split(":"), function (a, b) {
                if (0 === b) d.push(a);
                else {
                  var f = a.match(/(\w+)(?:[?*])?(.*)/),
                    g = f[1];
                  d.push(c[g]);
                  d.push(f[2] || "");
                  delete c[g];
                }
              });
              return d.join("");
            }
            var B = !1,
              n,
              x,
              t = {
                routes: h,
                reload: function () {
                  B = !0;
                  var a = {
                    defaultPrevented: !1,
                    preventDefault: function () {
                      this.defaultPrevented = !0;
                      B = !1;
                    },
                  };
                  d.$evalAsync(function () {
                    m(a);
                    a.defaultPrevented || s();
                  });
                },
                updateParams: function (a) {
                  if (this.current && this.current.$$route)
                    (a = b.extend({}, this.current.params, a)),
                      c.path(v(this.current.$$route.originalPath, a)),
                      c.search(a);
                  else throw H("norout");
                },
              };
            d.$on("$locationChangeStart", m);
            d.$on("$locationChangeSuccess", s);
            return t;
          },
        ];
      })
      .run(A),
    H = b.$$minErr("ngRoute"),
    p;
  A.$inject = ["$injector"];
  y.provider("$routeParams", function () {
    this.$get = function () {
      return {};
    };
  });
  y.directive("ngView", v);
  y.directive("ngView", x);
  v.$inject = ["$route", "$anchorScroll", "$animate"];
  x.$inject = ["$compile", "$controller", "$route"];
})(window, window.angular);
//# sourceMappingURL=angular-route.min.js.map

// toastr.min.js
!(function (e) {
  e(["jquery"], function (e) {
    return (function () {
      function t(e, t, n) {
        return g({
          type: O.error,
          iconClass: m().iconClasses.error,
          message: e,
          optionsOverride: n,
          title: t,
        });
      }
      function n(t, n) {
        return (
          t || (t = m()),
          (v = e("#" + t.containerId)),
          v.length ? v : (n && (v = u(t)), v)
        );
      }
      function i(e, t, n) {
        return g({
          type: O.info,
          iconClass: m().iconClasses.info,
          message: e,
          optionsOverride: n,
          title: t,
        });
      }
      function o(e) {
        w = e;
      }
      function s(e, t, n) {
        return g({
          type: O.success,
          iconClass: m().iconClasses.success,
          message: e,
          optionsOverride: n,
          title: t,
        });
      }
      function a(e, t, n) {
        return g({
          type: O.warning,
          iconClass: m().iconClasses.warning,
          message: e,
          optionsOverride: n,
          title: t,
        });
      }
      function r(e, t) {
        var i = m();
        v || n(i), l(e, i, t) || d(i);
      }
      function c(t) {
        var i = m();
        return (
          v || n(i),
          t && 0 === e(":focus", t).length
            ? void h(t)
            : void (v.children().length && v.remove())
        );
      }
      function d(t) {
        for (var n = v.children(), i = n.length - 1; i >= 0; i--) l(e(n[i]), t);
      }
      function l(t, n, i) {
        var o = i && i.force ? i.force : !1;
        return t && (o || 0 === e(":focus", t).length)
          ? (t[n.hideMethod]({
              duration: n.hideDuration,
              easing: n.hideEasing,
              complete: function () {
                h(t);
              },
            }),
            !0)
          : !1;
      }
      function u(t) {
        return (
          (v = e("<div/>")
            .attr("id", t.containerId)
            .addClass(t.positionClass)
            .attr("aria-live", "polite")
            .attr("role", "alert")),
          v.appendTo(e(t.target)),
          v
        );
      }
      function p() {
        return {
          tapToDismiss: !0,
          toastClass: "toast",
          containerId: "toast-container",
          debug: !1,
          showMethod: "fadeIn",
          showDuration: 300,
          showEasing: "swing",
          onShown: void 0,
          hideMethod: "fadeOut",
          hideDuration: 1e3,
          hideEasing: "swing",
          onHidden: void 0,
          closeMethod: !1,
          closeDuration: !1,
          closeEasing: !1,
          extendedTimeOut: 1e3,
          iconClasses: {
            error: "toast-error",
            info: "toast-info",
            success: "toast-success",
            warning: "toast-warning",
          },
          iconClass: "toast-info",
          positionClass: "toast-top-right",
          timeOut: 5e3,
          titleClass: "toast-title",
          messageClass: "toast-message",
          escapeHtml: !1,
          target: "body",
          closeHtml: '<button type="button">&times;</button>',
          newestOnTop: !0,
          preventDuplicates: !1,
          progressBar: !1,
        };
      }
      function f(e) {
        w && w(e);
      }
      function g(t) {
        function i(e) {
          return (
            null == e && (e = ""),
            new String(e)
              .replace(/&/g, "&amp;")
              .replace(/"/g, "&quot;")
              .replace(/'/g, "&#39;")
              .replace(/</g, "&lt;")
              .replace(/>/g, "&gt;")
          );
        }
        function o() {
          r(), d(), l(), u(), p(), c();
        }
        function s() {
          y.hover(b, O),
            !x.onclick && x.tapToDismiss && y.click(w),
            x.closeButton &&
              k &&
              k.click(function (e) {
                e.stopPropagation
                  ? e.stopPropagation()
                  : void 0 !== e.cancelBubble &&
                    e.cancelBubble !== !0 &&
                    (e.cancelBubble = !0),
                  w(!0);
              }),
            x.onclick &&
              y.click(function (e) {
                x.onclick(e), w();
              });
        }
        function a() {
          y.hide(),
            y[x.showMethod]({
              duration: x.showDuration,
              easing: x.showEasing,
              complete: x.onShown,
            }),
            x.timeOut > 0 &&
              ((H = setTimeout(w, x.timeOut)),
              (q.maxHideTime = parseFloat(x.timeOut)),
              (q.hideEta = new Date().getTime() + q.maxHideTime),
              x.progressBar && (q.intervalId = setInterval(D, 10)));
        }
        function r() {
          t.iconClass && y.addClass(x.toastClass).addClass(E);
        }
        function c() {
          x.newestOnTop ? v.prepend(y) : v.append(y);
        }
        function d() {
          t.title &&
            (I.append(x.escapeHtml ? i(t.title) : t.title).addClass(
              x.titleClass
            ),
            y.append(I));
        }
        function l() {
          t.message &&
            (M.append(x.escapeHtml ? i(t.message) : t.message).addClass(
              x.messageClass
            ),
            y.append(M));
        }
        function u() {
          x.closeButton &&
            (k.addClass("toast-close-button").attr("role", "button"),
            y.prepend(k));
        }
        function p() {
          x.progressBar && (B.addClass("toast-progress"), y.prepend(B));
        }
        function g(e, t) {
          if (e.preventDuplicates) {
            if (t.message === C) return !0;
            C = t.message;
          }
          return !1;
        }
        function w(t) {
          var n = t && x.closeMethod !== !1 ? x.closeMethod : x.hideMethod,
            i = t && x.closeDuration !== !1 ? x.closeDuration : x.hideDuration,
            o = t && x.closeEasing !== !1 ? x.closeEasing : x.hideEasing;
          return !e(":focus", y).length || t
            ? (clearTimeout(q.intervalId),
              y[n]({
                duration: i,
                easing: o,
                complete: function () {
                  h(y),
                    x.onHidden && "hidden" !== j.state && x.onHidden(),
                    (j.state = "hidden"),
                    (j.endTime = new Date()),
                    f(j);
                },
              }))
            : void 0;
        }
        function O() {
          (x.timeOut > 0 || x.extendedTimeOut > 0) &&
            ((H = setTimeout(w, x.extendedTimeOut)),
            (q.maxHideTime = parseFloat(x.extendedTimeOut)),
            (q.hideEta = new Date().getTime() + q.maxHideTime));
        }
        function b() {
          clearTimeout(H),
            (q.hideEta = 0),
            y
              .stop(!0, !0)
              [x.showMethod]({
                duration: x.showDuration,
                easing: x.showEasing,
              });
        }
        function D() {
          var e = ((q.hideEta - new Date().getTime()) / q.maxHideTime) * 100;
          B.width(e + "%");
        }
        var x = m(),
          E = t.iconClass || x.iconClass;
        if (
          ("undefined" != typeof t.optionsOverride &&
            ((x = e.extend(x, t.optionsOverride)),
            (E = t.optionsOverride.iconClass || E)),
          !g(x, t))
        ) {
          T++, (v = n(x, !0));
          var H = null,
            y = e("<div/>"),
            I = e("<div/>"),
            M = e("<div/>"),
            B = e("<div/>"),
            k = e(x.closeHtml),
            q = { intervalId: null, hideEta: null, maxHideTime: null },
            j = {
              toastId: T,
              state: "visible",
              startTime: new Date(),
              options: x,
              map: t,
            };
          return o(), a(), s(), f(j), x.debug && console && console.log(j), y;
        }
      }
      function m() {
        return e.extend({}, p(), b.options);
      }
      function h(e) {
        v || (v = n()),
          e.is(":visible") ||
            (e.remove(),
            (e = null),
            0 === v.children().length && (v.remove(), (C = void 0)));
      }
      var v,
        w,
        C,
        T = 0,
        O = {
          error: "error",
          info: "info",
          success: "success",
          warning: "warning",
        },
        b = {
          clear: r,
          remove: c,
          error: t,
          getContainer: n,
          info: i,
          options: {},
          subscribe: o,
          success: s,
          version: "2.1.2",
          warning: a,
        };
      return b;
    })();
  });
})(
  "function" == typeof define && define.amd
    ? define
    : function (e, t) {
        "undefined" != typeof module && module.exports
          ? (module.exports = t(require("jquery")))
          : (window.toastr = t(window.jQuery));
      }
);
//# sourceMappingURL=toastr.js.map

//flipclock.js

var Base = function () {};
Base.extend = function (_instance, _static) {
  "use strict";
  var extend = Base.prototype.extend;
  Base._prototyping = !0;
  var proto = new this();
  extend.call(proto, _instance);
  proto.base = function () {};
  delete Base._prototyping;
  var constructor = proto.constructor;
  var klass = (proto.constructor = function () {
    if (!Base._prototyping) {
      if (this._constructing || this.constructor == klass) {
        this._constructing = !0;
        constructor.apply(this, arguments);
        delete this._constructing;
      } else if (arguments[0] !== null) {
        return (arguments[0].extend || extend).call(arguments[0], proto);
      }
    }
  });
  klass.ancestor = this;
  klass.extend = this.extend;
  klass.forEach = this.forEach;
  klass.implement = this.implement;
  klass.prototype = proto;
  klass.toString = this.toString;
  klass.valueOf = function (type) {
    return type == "object" ? klass : constructor.valueOf();
  };
  extend.call(klass, _static);
  if (typeof klass.init == "function") klass.init();
  return klass;
};
Base.prototype = {
  extend: function (source, value) {
    if (arguments.length > 1) {
      var ancestor = this[source];
      if (
        ancestor &&
        typeof value == "function" &&
        (!ancestor.valueOf || ancestor.valueOf() != value.valueOf()) &&
        /\bbase\b/.test(value)
      ) {
        var method = value.valueOf();
        value = function () {
          var previous = this.base || Base.prototype.base;
          this.base = ancestor;
          var returnValue = method.apply(this, arguments);
          this.base = previous;
          return returnValue;
        };
        value.valueOf = function (type) {
          return type == "object" ? value : method;
        };
        value.toString = Base.toString;
      }
      this[source] = value;
    } else if (source) {
      var extend = Base.prototype.extend;
      if (!Base._prototyping && typeof this != "function") {
        extend = this.extend || extend;
      }
      var proto = { toSource: null };
      var hidden = ["constructor", "toString", "valueOf"];
      var i = Base._prototyping ? 0 : 1;
      while ((key = hidden[i++])) {
        if (source[key] != proto[key]) {
          extend.call(this, key, source[key]);
        }
      }
      for (var key in source) {
        if (!proto[key]) extend.call(this, key, source[key]);
      }
    }
    return this;
  },
};
Base = Base.extend(
  {
    constructor: function () {
      this.extend(arguments[0]);
    },
  },
  {
    ancestor: Object,
    version: "1.1",
    forEach: function (object, block, context) {
      for (var key in object) {
        if (this.prototype[key] === undefined) {
          block.call(context, object[key], key, object);
        }
      }
    },
    implement: function () {
      for (var i = 0; i < arguments.length; i++) {
        if (typeof arguments[i] == "function") {
          arguments[i](this.prototype);
        } else {
          this.prototype.extend(arguments[i]);
        }
      }
      return this;
    },
    toString: function () {
      return String(this.valueOf());
    },
  }
);
var FlipClock;
(function ($) {
  "use strict";
  FlipClock = function (obj, digit, options) {
    if (digit instanceof Object && digit instanceof Date === !1) {
      options = digit;
      digit = 0;
    }
    return new FlipClock.Factory(obj, digit, options);
  };
  FlipClock.Lang = {};
  FlipClock.Base = Base.extend({
    buildDate: "2014-12-12",
    version: "0.7.7",
    constructor: function (_default, options) {
      if (typeof _default !== "object") {
        _default = {};
      }
      if (typeof options !== "object") {
        options = {};
      }
      this.setOptions($.extend(!0, {}, _default, options));
    },
    callback: function (method) {
      if (typeof method === "function") {
        var args = [];
        for (var x = 1; x <= arguments.length; x++) {
          if (arguments[x]) {
            args.push(arguments[x]);
          }
        }
        method.apply(this, args);
      }
    },
    log: function (str) {
      if (window.console && console.log) {
        console.log(str);
      }
    },
    getOption: function (index) {
      if (this[index]) {
        return this[index];
      }
      return !1;
    },
    getOptions: function () {
      return this;
    },
    setOption: function (index, value) {
      this[index] = value;
    },
    setOptions: function (options) {
      for (var key in options) {
        if (typeof options[key] !== "undefined") {
          this.setOption(key, options[key]);
        }
      }
    },
  });
})(jQuery);
(function ($) {
  "use strict";
  FlipClock.Face = FlipClock.Base.extend({
    autoStart: !0,
    dividers: [],
    factory: !1,
    lists: [],
    constructor: function (factory, options) {
      this.dividers = [];
      this.lists = [];
      this.base(options);
      this.factory = factory;
    },
    build: function () {
      if (this.autoStart) {
        this.start();
      }
    },
    createDivider: function (label, css, excludeDots) {
      if (typeof css == "boolean" || !css) {
        excludeDots = css;
        css = label;
      }
      var dots = [
        '<span class="' + this.factory.classes.dot + ' top"></span>',
        '<span class="' + this.factory.classes.dot + ' bottom"></span>',
      ].join("");
      if (excludeDots) {
        dots = "";
      }
      label = this.factory.localize(label);
      var html = [
        '<span class="' +
          this.factory.classes.divider +
          " " +
          (css ? css : "").toLowerCase() +
          '">',
        '<span class="' +
          this.factory.classes.label +
          '">' +
          (label ? label : "") +
          "</span>",
        dots,
        "</span>",
      ];
      var $html = $(html.join(""));
      this.dividers.push($html);
      return $html;
    },
    createList: function (digit, options) {
      if (typeof digit === "object") {
        options = digit;
        digit = 0;
      }
      var obj = new FlipClock.List(this.factory, digit, options);
      this.lists.push(obj);
      return obj;
    },
    reset: function () {
      this.factory.time = new FlipClock.Time(
        this.factory,
        this.factory.original ? Math.round(this.factory.original) : 0,
        { minimumDigits: this.factory.minimumDigits }
      );
      this.flip(this.factory.original, !1);
    },
    appendDigitToClock: function (obj) {
      obj.$el.append(!1);
    },
    addDigit: function (digit) {
      var obj = this.createList(digit, {
        classes: {
          active: this.factory.classes.active,
          before: this.factory.classes.before,
          flip: this.factory.classes.flip,
        },
      });
      this.appendDigitToClock(obj);
    },
    start: function () {},
    stop: function () {},
    autoIncrement: function () {
      if (!this.factory.countdown) {
        this.increment();
      } else {
        this.decrement();
      }
    },
    increment: function () {
      this.factory.time.addSecond();
    },
    decrement: function () {
      if (this.factory.time.getTimeSeconds() == 0) {
        this.factory.stop();
      } else {
        this.factory.time.subSecond();
      }
    },
    flip: function (time, doNotAddPlayClass) {
      var t = this;
      $.each(time, function (i, digit) {
        var list = t.lists[i];
        if (list) {
          if (!doNotAddPlayClass && digit != list.digit) {
            list.play();
          }
          list.select(digit);
        } else {
          t.addDigit(digit);
        }
      });
    },
  });
})(jQuery);
(function ($) {
  "use strict";
  FlipClock.Factory = FlipClock.Base.extend({
    animationRate: 1000,
    autoStart: !0,
    callbacks: {
      destroy: !1,
      create: !1,
      init: !1,
      interval: !1,
      start: !1,
      stop: !1,
      reset: !1,
    },
    classes: {
      active: "flip-clock-active",
      before: "flip-clock-before",
      divider: "flip-clock-divider",
      dot: "flip-clock-dot",
      label: "flip-clock-label",
      flip: "flip",
      play: "play",
      wrapper: "flip-clock-wrapper",
    },
    clockFace: "HourlyCounter",
    countdown: !1,
    defaultClockFace: "HourlyCounter",
    defaultLanguage: "english",
    $el: !1,
    face: !0,
    lang: !1,
    language: "english",
    minimumDigits: 0,
    original: !1,
    running: !1,
    time: !1,
    timer: !1,
    $wrapper: !1,
    constructor: function (obj, digit, options) {
      if (!options) {
        options = {};
      }
      this.lists = [];
      this.running = !1;
      this.base(options);
      this.$el = $(obj).addClass(this.classes.wrapper);
      this.$wrapper = this.$el;
      this.original =
        digit instanceof Date ? digit : digit ? Math.round(digit) : 0;
      this.time = new FlipClock.Time(this, this.original, {
        minimumDigits: this.minimumDigits,
        animationRate: this.animationRate,
      });
      this.timer = new FlipClock.Timer(this, options);
      this.loadLanguage(this.language);
      this.loadClockFace(this.clockFace, options);
      if (this.autoStart) {
        this.start();
      }
    },
    loadClockFace: function (name, options) {
      var face,
        suffix = "Face",
        hasStopped = !1;
      name = name.ucfirst() + suffix;
      if (this.face.stop) {
        this.stop();
        hasStopped = !0;
      }
      this.$el.html("");
      this.time.minimumDigits = this.minimumDigits;
      if (FlipClock[name]) {
        face = new FlipClock[name](this, options);
      } else {
        face = new FlipClock[this.defaultClockFace + suffix](this, options);
      }
      face.build();
      this.face = face;
      if (hasStopped) {
        this.start();
      }
      return this.face;
    },
    loadLanguage: function (name) {
      var lang;
      if (FlipClock.Lang[name.ucfirst()]) {
        lang = FlipClock.Lang[name.ucfirst()];
      } else if (FlipClock.Lang[name]) {
        lang = FlipClock.Lang[name];
      } else {
        lang = FlipClock.Lang[this.defaultLanguage];
      }
      return (this.lang = lang);
    },
    localize: function (index, obj) {
      var lang = this.lang;
      if (!index) {
        return null;
      }
      var lindex = index.toLowerCase();
      if (typeof obj == "object") {
        lang = obj;
      }
      if (lang && lang[lindex]) {
        return lang[lindex];
      }
      return index;
    },
    start: function (callback) {
      var t = this;
      if (!t.running && (!t.countdown || (t.countdown && t.time.time > 0))) {
        t.face.start(t.time);
        t.timer.start(function () {
          t.flip();
          if (typeof callback === "function") {
            callback();
          }
        });
      } else {
        t.log("Trying to start timer when countdown already at 0");
      }
    },
    stop: function (callback) {
      this.face.stop();
      this.timer.stop(callback);
      for (var x in this.lists) {
        if (this.lists.hasOwnProperty(x)) {
          this.lists[x].stop();
        }
      }
    },
    reset: function (callback) {
      this.timer.reset(callback);
      this.face.reset();
    },
    setTime: function (time) {
      this.time.time = time;
      this.flip(!0);
    },
    getTime: function (time) {
      return this.time;
    },
    setCountdown: function (value) {
      var running = this.running;
      this.countdown = value ? !0 : !1;
      if (running) {
        this.stop();
        this.start();
      }
    },
    flip: function (doNotAddPlayClass) {
      this.face.flip(!1, doNotAddPlayClass);
    },
  });
})(jQuery);
(function ($) {
  "use strict";
  FlipClock.List = FlipClock.Base.extend({
    digit: 0,
    classes: {
      active: "flip-clock-active",
      before: "flip-clock-before",
      flip: "flip",
    },
    factory: !1,
    $el: !1,
    $obj: !1,
    items: [],
    lastDigit: 0,
    constructor: function (factory, digit, options) {
      this.factory = factory;
      this.digit = digit;
      this.lastDigit = digit;
      this.$el = this.createList();
      this.$obj = this.$el;
      if (digit > 0) {
        this.select(digit);
      }
      this.factory.$el.append(this.$el);
    },
    select: function (digit) {
      if (typeof digit === "undefined") {
        digit = this.digit;
      } else {
        this.digit = digit;
      }
      if (this.digit != this.lastDigit) {
        var $delete = this.$el
          .find("." + this.classes.before)
          .removeClass(this.classes.before);
        this.$el
          .find("." + this.classes.active)
          .removeClass(this.classes.active)
          .addClass(this.classes.before);
        this.appendListItem(this.classes.active, this.digit);
        $delete.remove();
        this.lastDigit = this.digit;
      }
    },
    play: function () {
      this.$el.addClass(this.factory.classes.play);
    },
    stop: function () {
      var t = this;
      setTimeout(function () {
        t.$el.removeClass(t.factory.classes.play);
      }, this.factory.timer.interval);
    },
    createListItem: function (css, value) {
      return [
        '<li class="' + (css ? css : "") + '">',
        '<a href="#">',
        '<div class="up">',
        '<div class="shadow"></div>',
        '<div class="inn">' + (value ? value : "") + "</div>",
        "</div>",
        '<div class="down">',
        '<div class="shadow"></div>',
        '<div class="inn">' + (value ? value : "") + "</div>",
        "</div>",
        "</a>",
        "</li>",
      ].join("");
    },
    appendListItem: function (css, value) {
      var html = this.createListItem(css, value);
      this.$el.append(html);
    },
    createList: function () {
      var lastDigit = this.getPrevDigit() ? this.getPrevDigit() : this.digit;
      var html = $(
        [
          '<ul class="' +
            this.classes.flip +
            " " +
            (this.factory.running ? this.factory.classes.play : "") +
            '">',
          this.createListItem(this.classes.before, lastDigit),
          this.createListItem(this.classes.active, this.digit),
          "</ul>",
        ].join("")
      );
      return html;
    },
    getNextDigit: function () {
      return this.digit == 9 ? 0 : this.digit + 1;
    },
    getPrevDigit: function () {
      return this.digit == 0 ? 9 : this.digit - 1;
    },
  });
})(jQuery);
(function ($) {
  "use strict";
  String.prototype.ucfirst = function () {
    return this.substr(0, 1).toUpperCase() + this.substr(1);
  };
  $.fn.FlipClock = function (digit, options) {
    return new FlipClock($(this), digit, options);
  };
  $.fn.flipClock = function (digit, options) {
    return $.fn.FlipClock(digit, options);
  };
})(jQuery);
(function ($) {
  "use strict";
  FlipClock.Time = FlipClock.Base.extend({
    time: 0,
    factory: !1,
    minimumDigits: 0,
    constructor: function (factory, time, options) {
      if (typeof options != "object") {
        options = {};
      }
      if (!options.minimumDigits) {
        options.minimumDigits = factory.minimumDigits;
      }
      this.base(options);
      this.factory = factory;
      if (time) {
        this.time = time;
      }
    },
    convertDigitsToArray: function (str) {
      var data = [];
      str = str.toString();
      for (var x = 0; x < str.length; x++) {
        if (str[x].match(/^\d*$/g)) {
          data.push(str[x]);
        }
      }
      return data;
    },
    digit: function (i) {
      var timeStr = this.toString();
      var length = timeStr.length;
      if (timeStr[length - i]) {
        return timeStr[length - i];
      }
      return !1;
    },
    digitize: function (obj) {
      var data = [];
      $.each(obj, function (i, value) {
        value = value.toString();
        if (value.length == 1) {
          value = "0" + value;
        }
        for (var x = 0; x < value.length; x++) {
          data.push(value.charAt(x));
        }
      });
      if (data.length > this.minimumDigits) {
        this.minimumDigits = data.length;
      }
      if (this.minimumDigits > data.length) {
        for (var x = data.length; x < this.minimumDigits; x++) {
          data.unshift("0");
        }
      }
      return data;
    },
    getDateObject: function () {
      if (this.time instanceof Date) {
        return this.time;
      }
      return new Date(new Date().getTime() + this.getTimeSeconds() * 1000);
    },
    getDayCounter: function (includeSeconds) {
      var digits = [this.getDays(), this.getHours(!0), this.getMinutes(!0)];
      if (includeSeconds) {
        digits.push(this.getSeconds(!0));
      }
      return this.digitize(digits);
    },
    getDays: function (mod) {
      var days = this.getTimeSeconds() / 60 / 60 / 24;
      if (mod) {
        days = days % 7;
      }
      return Math.floor(days);
    },
    getHourCounter: function () {
      var obj = this.digitize([
        this.getHours(),
        this.getMinutes(!0),
        this.getSeconds(!0),
      ]);
      return obj;
    },
    getHourly: function () {
      return this.getHourCounter();
    },
    getHours: function (mod) {
      var hours = this.getTimeSeconds() / 60 / 60;
      if (mod) {
        hours = hours % 24;
      }
      return Math.floor(hours);
    },
    getMilitaryTime: function (date, showSeconds) {
      if (typeof showSeconds === "undefined") {
        showSeconds = !0;
      }
      if (!date) {
        date = this.getDateObject();
      }
      var data = [date.getHours(), date.getMinutes()];
      if (showSeconds === !0) {
        data.push(date.getSeconds());
      }
      return this.digitize(data);
    },
    getMinutes: function (mod) {
      var minutes = this.getTimeSeconds() / 60;
      if (mod) {
        minutes = minutes % 60;
      }
      return Math.floor(minutes);
    },
    getMinuteCounter: function () {
      var obj = this.digitize([this.getMinutes(), this.getSeconds(!0)]);
      return obj;
    },
    getTimeSeconds: function (date) {
      if (!date) {
        date = new Date();
      }
      if (this.time instanceof Date) {
        if (this.factory.countdown) {
          return Math.max(
            this.time.getTime() / 1000 - date.getTime() / 1000,
            0
          );
        } else {
          return date.getTime() / 1000 - this.time.getTime() / 1000;
        }
      } else {
        return this.time;
      }
    },
    getTime: function (date, showSeconds) {
      if (typeof showSeconds === "undefined") {
        showSeconds = !0;
      }
      if (!date) {
        date = this.getDateObject();
      }
      console.log(date);
      var hours = date.getHours();
      var merid = hours > 12 ? "PM" : "AM";
      var data = [
        hours > 12 ? hours - 12 : hours === 0 ? 12 : hours,
        date.getMinutes(),
      ];
      if (showSeconds === !0) {
        data.push(date.getSeconds());
      }
      return this.digitize(data);
    },
    getSeconds: function (mod) {
      var seconds = this.getTimeSeconds();
      if (mod) {
        if (seconds == 60) {
          seconds = 0;
        } else {
          seconds = seconds % 60;
        }
      }
      return Math.ceil(seconds);
    },
    getWeeks: function (mod) {
      var weeks = this.getTimeSeconds() / 60 / 60 / 24 / 7;
      if (mod) {
        weeks = weeks % 52;
      }
      return Math.floor(weeks);
    },
    removeLeadingZeros: function (totalDigits, digits) {
      var total = 0;
      var newArray = [];
      $.each(digits, function (i, digit) {
        if (i < totalDigits) {
          total += parseInt(digits[i], 10);
        } else {
          newArray.push(digits[i]);
        }
      });
      if (total === 0) {
        return newArray;
      }
      return digits;
    },
    addSeconds: function (x) {
      if (this.time instanceof Date) {
        this.time.setSeconds(this.time.getSeconds() + x);
      } else {
        this.time += x;
      }
    },
    addSecond: function () {
      this.addSeconds(1);
    },
    subSeconds: function (x) {
      if (this.time instanceof Date) {
        this.time.setSeconds(this.time.getSeconds() - x);
      } else {
        this.time -= x;
      }
    },
    subSecond: function () {
      this.subSeconds(1);
    },
    toString: function () {
      return this.getTimeSeconds().toString();
    },
  });
})(jQuery);
(function ($) {
  "use strict";
  FlipClock.Timer = FlipClock.Base.extend({
    callbacks: {
      destroy: !1,
      create: !1,
      init: !1,
      interval: !1,
      start: !1,
      stop: !1,
      reset: !1,
    },
    count: 0,
    factory: !1,
    interval: 1000,
    animationRate: 1000,
    constructor: function (factory, options) {
      this.base(options);
      this.factory = factory;
      this.callback(this.callbacks.init);
      this.callback(this.callbacks.create);
    },
    getElapsed: function () {
      return this.count * this.interval;
    },
    getElapsedTime: function () {
      return new Date(this.time + this.getElapsed());
    },
    reset: function (callback) {
      clearInterval(this.timer);
      this.count = 0;
      this._setInterval(callback);
      this.callback(this.callbacks.reset);
    },
    start: function (callback) {
      this.factory.running = !0;
      this._createTimer(callback);
      this.callback(this.callbacks.start);
    },
    stop: function (callback) {
      this.factory.running = !1;
      this._clearInterval(callback);
      this.callback(this.callbacks.stop);
      this.callback(callback);
    },
    _clearInterval: function () {
      clearInterval(this.timer);
    },
    _createTimer: function (callback) {
      this._setInterval(callback);
    },
    _destroyTimer: function (callback) {
      this._clearInterval();
      this.timer = !1;
      this.callback(callback);
      this.callback(this.callbacks.destroy);
    },
    _interval: function (callback) {
      this.callback(this.callbacks.interval);
      this.callback(callback);
      this.count++;
    },
    _setInterval: function (callback) {
      var t = this;
      t._interval(callback);
      t.timer = setInterval(function () {
        t._interval(callback);
      }, this.interval);
    },
  });
})(jQuery);
(function ($) {
  FlipClock.TwentyFourHourClockFace = FlipClock.Face.extend({
    constructor: function (factory, options) {
      this.base(factory, options);
    },
    build: function (time) {
      var t = this;
      var children = this.factory.$el.find("ul");
      if (!this.factory.time.time) {
        this.factory.original = new Date();
        this.factory.time = new FlipClock.Time(
          this.factory,
          this.factory.original
        );
      }
      var time = time
        ? time
        : this.factory.time.getMilitaryTime(!1, this.showSeconds);
      if (time.length > children.length) {
        $.each(time, function (i, digit) {
          t.createList(digit);
        });
      }
      this.createDivider();
      this.createDivider();
      $(this.dividers[0]).insertBefore(this.lists[this.lists.length - 2].$el);
      $(this.dividers[1]).insertBefore(this.lists[this.lists.length - 4].$el);
      this.base();
    },
    flip: function (time, doNotAddPlayClass) {
      this.autoIncrement();
      time = time
        ? time
        : this.factory.time.getMilitaryTime(!1, this.showSeconds);
      this.base(time, doNotAddPlayClass);
    },
  });
})(jQuery);
(function ($) {
  FlipClock.CounterFace = FlipClock.Face.extend({
    shouldAutoIncrement: !1,
    constructor: function (factory, options) {
      if (typeof options != "object") {
        options = {};
      }
      factory.autoStart = options.autoStart ? !0 : !1;
      if (options.autoStart) {
        this.shouldAutoIncrement = !0;
      }
      factory.increment = function () {
        factory.countdown = !1;
        factory.setTime(factory.getTime().getTimeSeconds() + 1);
      };
      factory.decrement = function () {
        factory.countdown = !0;
        var time = factory.getTime().getTimeSeconds();
        if (time > 0) {
          factory.setTime(time - 1);
        }
      };
      factory.setValue = function (digits) {
        factory.setTime(digits);
      };
      factory.setCounter = function (digits) {
        factory.setTime(digits);
      };
      this.base(factory, options);
    },
    build: function () {
      var t = this;
      var children = this.factory.$el.find("ul");
      var time = this.factory.getTime().digitize([this.factory.getTime().time]);
      if (time.length > children.length) {
        $.each(time, function (i, digit) {
          var list = t.createList(digit);
          list.select(digit);
        });
      }
      $.each(this.lists, function (i, list) {
        list.play();
      });
      this.base();
    },
    flip: function (time, doNotAddPlayClass) {
      if (this.shouldAutoIncrement) {
        this.autoIncrement();
      }
      if (!time) {
        time = this.factory.getTime().digitize([this.factory.getTime().time]);
      }
      this.base(time, doNotAddPlayClass);
    },
    reset: function () {
      this.factory.time = new FlipClock.Time(
        this.factory,
        this.factory.original ? Math.round(this.factory.original) : 0
      );
      this.flip();
    },
  });
})(jQuery);
(function ($) {
  FlipClock.DailyCounterFace = FlipClock.Face.extend({
    showSeconds: !0,
    constructor: function (factory, options) {
      this.base(factory, options);
    },
    build: function (time) {
      var t = this;
      var children = this.factory.$el.find("ul");
      var offset = 0;
      time = time ? time : this.factory.time.getDayCounter(this.showSeconds);
      if (time.length > children.length) {
        $.each(time, function (i, digit) {
          t.createList(digit);
        });
      }
      if (this.showSeconds) {
        $(this.createDivider("Seconds")).insertBefore(
          this.lists[this.lists.length - 2].$el
        );
      } else {
        offset = 2;
      }
      $(this.createDivider("Minutes")).insertBefore(
        this.lists[this.lists.length - 4 + offset].$el
      );
      $(this.createDivider("Hours")).insertBefore(
        this.lists[this.lists.length - 6 + offset].$el
      );
      $(this.createDivider("Days", !0)).insertBefore(this.lists[0].$el);
      this.base();
    },
    flip: function (time, doNotAddPlayClass) {
      if (!time) {
        time = this.factory.time.getDayCounter(this.showSeconds);
      }
      this.autoIncrement();
      this.base(time, doNotAddPlayClass);
    },
  });
})(jQuery);
(function ($) {
  FlipClock.HourlyCounterFace = FlipClock.Face.extend({
    constructor: function (factory, options) {
      this.base(factory, options);
    },
    build: function (excludeHours, time) {
      var t = this;
      var children = this.factory.$el.find("ul");
      time = time ? time : this.factory.time.getHourCounter();
      if (time.length > children.length) {
        $.each(time, function (i, digit) {
          t.createList(digit);
        });
      }
      $(this.createDivider("Seconds")).insertBefore(
        this.lists[this.lists.length - 2].$el
      );
      $(this.createDivider("Minutes")).insertBefore(
        this.lists[this.lists.length - 4].$el
      );
      if (!excludeHours) {
        $(this.createDivider("Hours", !0)).insertBefore(this.lists[0].$el);
      }
      this.base();
    },
    flip: function (time, doNotAddPlayClass) {
      if (!time) {
        time = this.factory.time.getHourCounter();
      }
      this.autoIncrement();
      this.base(time, doNotAddPlayClass);
    },
    appendDigitToClock: function (obj) {
      this.base(obj);
      this.dividers[0].insertAfter(this.dividers[0].next());
    },
  });
})(jQuery);
(function ($) {
  FlipClock.MinuteCounterFace = FlipClock.HourlyCounterFace.extend({
    clearExcessDigits: !1,
    constructor: function (factory, options) {
      this.base(factory, options);
    },
    build: function () {
      this.base(!0, this.factory.time.getMinuteCounter());
    },
    flip: function (time, doNotAddPlayClass) {
      if (!time) {
        time = this.factory.time.getMinuteCounter();
      }
      this.base(time, doNotAddPlayClass);
    },
  });
})(jQuery);
(function ($) {
  FlipClock.TwelveHourClockFace = FlipClock.TwentyFourHourClockFace.extend({
    meridium: !1,
    meridiumText: "AM",
    build: function () {
      var t = this;
      var time = this.factory.time.getTime(!1, this.showSeconds);
      this.base(time);
      this.meridiumText = this.getMeridium();
      this.meridium = $(
        [
          '<ul class="flip-clock-meridium">',
          "<li>",
          '<a href="#">' + this.meridiumText + "</a>",
          "</li>",
          "</ul>",
        ].join("")
      );
      this.meridium.insertAfter(this.lists[this.lists.length - 1].$el);
    },
    flip: function (time, doNotAddPlayClass) {
      if (this.meridiumText != this.getMeridium()) {
        this.meridiumText = this.getMeridium();
        this.meridium.find("a").html(this.meridiumText);
      }
      this.base(
        this.factory.time.getTime(!1, this.showSeconds),
        doNotAddPlayClass
      );
    },
    getMeridium: function () {
      return new Date().getHours() >= 12 ? "PM" : "AM";
    },
    isPM: function () {
      return this.getMeridium() == "PM" ? !0 : !1;
    },
    isAM: function () {
      return this.getMeridium() == "AM" ? !0 : !1;
    },
  });
})(jQuery);
(function ($) {
  FlipClock.Lang.Arabic = {
    years: "سنوات",
    months: "شهور",
    days: "أيام",
    hours: "ساعات",
    minutes: "دقائق",
    seconds: "ثواني",
  };
  FlipClock.Lang.ar = FlipClock.Lang.Arabic;
  FlipClock.Lang["ar-ar"] = FlipClock.Lang.Arabic;
  FlipClock.Lang.arabic = FlipClock.Lang.Arabic;
})(jQuery);
(function ($) {
  FlipClock.Lang.Danish = {
    years: "År",
    months: "Måneder",
    days: "Dage",
    hours: "Timer",
    minutes: "Minutter",
    seconds: "Sekunder",
  };
  FlipClock.Lang.da = FlipClock.Lang.Danish;
  FlipClock.Lang["da-dk"] = FlipClock.Lang.Danish;
  FlipClock.Lang.danish = FlipClock.Lang.Danish;
})(jQuery);
(function ($) {
  FlipClock.Lang.German = {
    years: "Jahre",
    months: "Monate",
    days: "Tage",
    hours: "Stunden",
    minutes: "Minuten",
    seconds: "Sekunden",
  };
  FlipClock.Lang.de = FlipClock.Lang.German;
  FlipClock.Lang["de-de"] = FlipClock.Lang.German;
  FlipClock.Lang.german = FlipClock.Lang.German;
})(jQuery);
(function ($) {
  FlipClock.Lang.English = {
    years: "Years",
    months: "Months",
    days: "Days",
    hours: "Hours",
    minutes: "Minutes",
    seconds: "Seconds",
  };
  FlipClock.Lang.en = FlipClock.Lang.English;
  FlipClock.Lang["en-us"] = FlipClock.Lang.English;
  FlipClock.Lang.english = FlipClock.Lang.English;
})(jQuery);
(function ($) {
  FlipClock.Lang.Spanish = {
    years: "Años",
    months: "Meses",
    days: "Días",
    hours: "Horas",
    minutes: "Minutos",
    seconds: "Segundos",
  };
  FlipClock.Lang.es = FlipClock.Lang.Spanish;
  FlipClock.Lang["es-es"] = FlipClock.Lang.Spanish;
  FlipClock.Lang.spanish = FlipClock.Lang.Spanish;
})(jQuery);
(function ($) {
  FlipClock.Lang.Finnish = {
    years: "Vuotta",
    months: "Kuukautta",
    days: "Päivää",
    hours: "Tuntia",
    minutes: "Minuuttia",
    seconds: "Sekuntia",
  };
  FlipClock.Lang.fi = FlipClock.Lang.Finnish;
  FlipClock.Lang["fi-fi"] = FlipClock.Lang.Finnish;
  FlipClock.Lang.finnish = FlipClock.Lang.Finnish;
})(jQuery);
(function ($) {
  FlipClock.Lang.French = {
    years: "Ans",
    months: "Mois",
    days: "Jours",
    hours: "Heures",
    minutes: "Minutes",
    seconds: "Secondes",
  };
  FlipClock.Lang.fr = FlipClock.Lang.French;
  FlipClock.Lang["fr-ca"] = FlipClock.Lang.French;
  FlipClock.Lang.french = FlipClock.Lang.French;
})(jQuery);
(function ($) {
  FlipClock.Lang.Italian = {
    years: "Anni",
    months: "Mesi",
    days: "Giorni",
    hours: "Ore",
    minutes: "Minuti",
    seconds: "Secondi",
  };
  FlipClock.Lang.it = FlipClock.Lang.Italian;
  FlipClock.Lang["it-it"] = FlipClock.Lang.Italian;
  FlipClock.Lang.italian = FlipClock.Lang.Italian;
})(jQuery);
(function ($) {
  FlipClock.Lang.Latvian = {
    years: "Gadi",
    months: "Mēneši",
    days: "Dienas",
    hours: "Stundas",
    minutes: "Minūtes",
    seconds: "Sekundes",
  };
  FlipClock.Lang.lv = FlipClock.Lang.Latvian;
  FlipClock.Lang["lv-lv"] = FlipClock.Lang.Latvian;
  FlipClock.Lang.latvian = FlipClock.Lang.Latvian;
})(jQuery);
(function ($) {
  FlipClock.Lang.Dutch = {
    years: "Jaren",
    months: "Maanden",
    days: "Dagen",
    hours: "Uren",
    minutes: "Minuten",
    seconds: "Seconden",
  };
  FlipClock.Lang.nl = FlipClock.Lang.Dutch;
  FlipClock.Lang["nl-be"] = FlipClock.Lang.Dutch;
  FlipClock.Lang.dutch = FlipClock.Lang.Dutch;
})(jQuery);
(function ($) {
  FlipClock.Lang.Norwegian = {
    years: "År",
    months: "Måneder",
    days: "Dager",
    hours: "Timer",
    minutes: "Minutter",
    seconds: "Sekunder",
  };
  FlipClock.Lang.no = FlipClock.Lang.Norwegian;
  FlipClock.Lang.nb = FlipClock.Lang.Norwegian;
  FlipClock.Lang["no-nb"] = FlipClock.Lang.Norwegian;
  FlipClock.Lang.norwegian = FlipClock.Lang.Norwegian;
})(jQuery);
(function ($) {
  FlipClock.Lang.Portuguese = {
    years: "Anos",
    months: "Meses",
    days: "Dias",
    hours: "Horas",
    minutes: "Minutos",
    seconds: "Segundos",
  };
  FlipClock.Lang.pt = FlipClock.Lang.Portuguese;
  FlipClock.Lang["pt-br"] = FlipClock.Lang.Portuguese;
  FlipClock.Lang.portuguese = FlipClock.Lang.Portuguese;
})(jQuery);
(function ($) {
  FlipClock.Lang.Russian = {
    years: "лет",
    months: "месяцев",
    days: "дней",
    hours: "часов",
    minutes: "минут",
    seconds: "секунд",
  };
  FlipClock.Lang.ru = FlipClock.Lang.Russian;
  FlipClock.Lang["ru-ru"] = FlipClock.Lang.Russian;
  FlipClock.Lang.russian = FlipClock.Lang.Russian;
})(jQuery);
(function ($) {
  FlipClock.Lang.Swedish = {
    years: "År",
    months: "Månader",
    days: "Dagar",
    hours: "Timmar",
    minutes: "Minuter",
    seconds: "Sekunder",
  };
  FlipClock.Lang.sv = FlipClock.Lang.Swedish;
  FlipClock.Lang["sv-se"] = FlipClock.Lang.Swedish;
  FlipClock.Lang.swedish = FlipClock.Lang.Swedish;
})(jQuery);
(function ($) {
  FlipClock.Lang.Chinese = {
    years: "年",
    months: "月",
    days: "日",
    hours: "时",
    minutes: "分",
    seconds: "秒",
  };
  FlipClock.Lang.zh = FlipClock.Lang.Chinese;
  FlipClock.Lang["zh-cn"] = FlipClock.Lang.Chinese;
  FlipClock.Lang.chinese = FlipClock.Lang.Chinese;
})(jQuery);

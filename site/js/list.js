/**
 @package JobBoard
 @copyright Copyright (c)2010-2012 Tandolin
 @license : GNU General Public License v2 or later
 ----------------------------------------------------------------------- */

var Tandolin = Tandolin || {};
Tandolin.JobListView = Tandolin.JobListView || {};
var TandolinClassJobList = new Class({Implements: [Options, Events], options: {loginWrapper: "loginWrapper", formTop: "category_list", resetKeywds: "reset_keywds", listForm: "category_list", titleBox: "jobsearch", keywdBox: "keysrch", locnBox: "locsrch", orderSelct: "order_selct", sortSelct: "sort_selct", showAllTrigger: "jall", tableViewSwitch: "tableView", listViewSwitch: "listView", srchInfo: "srch_info", keywdInfo: "keywd_info", advSrchTrigger: "advsrch", loading: "loadr", srchRadius: "srchRadius", titleString: "", keywdString: "", locnString: "", closedState: "closed", openState: "open", hiddenName: "hidel", displayNone: "jbdispnone", inputOverlay: "inputovr", submits: "input.filterSub", initFiltersState: [], filterTriggers: [], subUnsolEl: "topSubmitCV", unsolLnk: "", effects: {windowScroll: {}, advFiltersSlide: {}}, advSearch: "advsrch", advSearchCont: "jbrdadvsrch", txtLoading: "", txtBasicSrch: "", txtAdvSrch: "", jobTypeCbs: "jtCboxes", careerLvlCbs: "clCboxes", eduLvlCbs: "elCboxes", jobTypeCbsClearTrigger: "clearJtypeFilters", careerLvlCbsClearTrigger: "clearClevelFilters", eduLvlCbsClearTrigger: "clearElevelFilters", cbResetSectionFlag: "cb_reset", cbResetAllTrigger: "reset_advfilters"}, initialize: function (a) {
    this.setOptions(a);
    this.resetKeywds = $(this.options.resetKeywds);
    this.listForm = $(this.options.listForm);
    this.titleBox = $(this.options.titleBox);
    this.keywdBox = $(this.options.keywdBox);
    this.locnBox = $(this.options.locnBox);
    this.orderSelct = $(this.options.orderSelct);
    this.sortSelct = $(this.options.sortSelct);
    this.showAllTrigger = $(this.options.showAllTrigger);
    this.srchInfo = $(this.options.srchInfo);
    this.keywdInfo = $(this.options.keywdInfo);
    this.advSrchTrigger = $(this.options.advSrchTrigger);
    this.loading = $(this.options.loading);
    this.srchRadius = $(this.options.srchRadius);
    this.submits = $$(this.options.submits);
    this.initFiltersState = this.options.initFiltersState;
    this.filterTriggers = this.options.filterTriggers;
    this.effects = this.options.effects;
    this.advSearch = $(this.options.advSearch);
    this.cbResetAllTrigger = $(this.options.cbResetAllTrigger);
    this.subUnsolEl = $(this.options.subUnsolEl);
    this.tableViewSwitch = $(this.options.tableViewSwitch);
    this.listViewSwitch = $(this.options.listViewSwitch);
    this.launch()
}, launch: function () {
    if (this.locnBox) {
        this.checkValue(this.locnBox, this.options.locnString);
        this.setEvents(this.locnBox, this.options.locnString)
    }
    this.checkValue(this.titleBox, this.options.titleString);
    this.checkValue(this.keywdBox, this.options.keywdString);
    this.setEvents(this.titleBox, this.options.titleString);
    this.setEvents(this.keywdBox, this.options.keywdString);
    if (this.orderSelct) {
        this.setcnLdrs(this.orderSelct)
    }
    if (this.sortSelct) {
        this.setcnLdrs(this.sortSelct)
    }
    if (this.showAllTrigger) {
        this.setckLdrs(this.showAllTrigger)
    }
    this.setResetTriggerEvt(this.resetKeywds);
    this.submits.each(function (a) {
        this.setGoEvt(a)
    }.bind(this));
    this.setFx();
    this.setAdvSearchEvts(this.advSearch);
    this.jobTypeFilters = $(this.options.jobTypeCbs).getElements("input[type=checkbox]");
    this.careerLevelFilters = $(this.options.careerLvlCbs).getElements("input[type=checkbox]");
    this.eduLevelFilters = $(this.options.eduLvlCbs).getElements("input[type=checkbox]");
    this.filterTriggers.filter_job_type = $(this.options.jobTypeCbsClearTrigger);
    this.setCbClearEvt("filter_job_type");
    this.jobTypeFilters.each(function (a) {
        this.setCbFilterEvts(a, "filter_job_type")
    }.bind(this));
    this.filterTriggers.filter_careerlvl = $(this.options.careerLvlCbsClearTrigger);
    this.setCbClearEvt("filter_careerlvl");
    this.careerLevelFilters.each(function (a) {
        this.setCbFilterEvts(a, "filter_careerlvl")
    }.bind(this));
    this.filterTriggers.filter_edulevel = $(this.options.eduLvlCbsClearTrigger);
    this.setCbClearEvt("filter_edulevel");
    this.eduLevelFilters.each(function (a) {
        this.setCbFilterEvts(a, "filter_edulevel")
    }.bind(this));
    this.initFiltersState.filter_job_type = this.checkCbFilters("filter_job_type[]");
    this.initFiltersState.filter_careerlvl = this.checkCbFilters("filter_careerlvl[]");
    this.initFiltersState.filter_edulevel = this.checkCbFilters("filter_edulevel[]");
    if (this.cbResetAllTrigger) {
        this.cbResetAllTrigger.addEvent("click", function (a) {
            a.stop();
            this.listForm.elements.country_id.value = 0;
            this.listForm.elements.daterange.value = 0;
            this.clearAllCboxes()
        }.bind(this))
    }
    if (this.subUnsolEl) {
        this.subUnsolEl.addEvent("click", function (a) {
            a.stop();
            window.location.href = this.options.unsolLnk
        }.bind(this))
    }
    this.isListLayout = (this.listForm.elements.layout.value == "list") ? true : false;
    if (this.tableViewSwitch) {
        this.setckLdrs(this.tableViewSwitch);
        this.tableViewSwitch.addEvent("click", function (a) {
            a.stop();
            this.switchLayout()
        }.bind(this))
    }
    if (this.listViewSwitch) {
        this.setckLdrs(this.listViewSwitch);
        this.listViewSwitch.addEvent("click", function (a) {
            a.stop();
            this.switchLayout()
        }.bind(this))
    }
}, setCbFilterEvts: function (a, b) {
    a.addEvent("click", function () {
        if (this.checkCbFilters(b + "[]") == true) {
            this.filterTriggers[b].removeClass("hidel")
        } else {
            this.filterTriggers[b].addClass("hidel")
        }
    }.bind(this))
}, setCbClearEvt: function (a) {
    this.filterTriggers[a].addEvent("click", function (b) {
        b.stop();
        this.clearCboxes(a + "[]")
    }.bind(this))
}, checkValue: function (a, b) {
    if (a.value == "" || a.value.length === 0) {
        a.value = b;
        if (a.id == this.options.locnBox) {
            if (this.srchRadius) {
                this.srchRadius.setAttribute("disabled", "disabled")
            }
        }
    }
    if (a.value.indexOf("(") === 0) {
        a.addClass(this.options.inputOverlay)
    } else {
        a.removeClass(this.options.inputOverlay)
    }
}, setEvents: function (a, b) {
    a.addEvents({focus: function () {
        a.removeClass(this.options.inputOverlay);
        if (a.value.indexOf("(") === 0) {
            a.value = ""
        }
        if (a.id == this.options.locnBox) {
            this.srchRadius.removeAttribute("disabled")
        }
    }.bind(this), keyup: function (c) {
        if (a.value == "" || a.value.length === 0) {
            a.value = b;
            a.blur();
            a.addClass(this.options.inputOverlay);
            if (a.id == this.options.locnBox) {
                this.srchRadius.setAttribute("disabled", "disabled")
            }
        }
    }.bind(this), blur: function () {
        if (a.value.length < 1) {
            a.value = b;
            if (a.id == this.options.locnBox) {
                this.srchRadius.setAttribute("disabled", "disabled")
            }
        }
        this.checkValue(a, b)
    }.bind(this)})
}, setcnLdrs: function (a) {
    a.addEvent("change", function () {
        this.loading.removeClass(this.options.hiddenName)
    }.bind(this))
}, setckLdrs: function (a) {
    a.addEvent("click", function () {
        this.loading.removeClass(this.options.hiddenName)
    }.bind(this))
}, setResetTriggerEvt: function (a) {
    a.addEvent("click", function (b) {
        b.stop();
        this.launchSubmitFormEvts();
        this.titleBox.value = "";
        this.keywdBox.value = "";
        if (this.locnBox) {
            this.locnBox.value = "";
            this.checkValue(this.locnBox, this.options.locnString)
        }
        this.checkValue(this.titleBox, this.options.titleString);
        this.checkValue(this.keywdBox, this.options.keywdString);
        if (this.isListLayout === true) {
            this.sortSelct.value = "date"
        }
        this.listForm.submit()
    }.bind(this))
}, setGoEvt: function (a) {
    a.addEvent("click", function () {
        this.launchSubmitFormEvts()
    }.bind(this))
}, launchSubmitFormEvts: function () {
    this.srchInfo.addClass(this.options.hiddenName);
    if (this.keywdInfo) {
        this.keywdInfo.addClass(this.options.hiddenName)
    }
    this.advSrchTrigger.addClass(this.options.hiddenName);
    this.loading.removeClass(this.options.hiddenName)
}, setFx: function () {
    this.effects.windowScroll = new Fx.Scroll(window, {transition: Fx.Transitions.Pow.easeInOut});
    this.effects.advFiltersSlide = new Fx.Slide(this.options.advSearchCont, {duration: 380}).slideOut()
}, setAdvSearchEvts: function (a) {
    a.addEvent("click", function (c) {
        c.stop();
        var d = $(this.options.advSearchCont);
        var b = a.hasClass(this.options.closedState) ? true : false;
        if (b === true) {
            d.removeClass(this.options.displayNone);
            (function () {
                this.effects.windowScroll.toElement(this.options.formTop, "y")
            }.bind(this)).delay(200);
            this.effects.advFiltersSlide.slideIn().chain(function () {
                a.text = this.options.txtBasicSrch;
                a.removeClass(this.options.closedState);
                a.addClass(this.options.openState)
            }.bind(this))
        } else {
            if (b !== true) {
                (function () {
                    this.effects.windowScroll.toElement(this.options.loginWrapper, "y")
                }.bind(this)).delay(200);
                this.effects.advFiltersSlide.slideOut().chain(function () {
                    a.text = this.options.txtAdvSrch;
                    a.removeClass(this.options.openState);
                    a.addClass(this.options.closedState);
                    d.addClass(this.options.displayNone)
                }.bind(this))
            }
        }
    }.bind(this))
}, checkCbFilters: function (d) {
    var c = this.listForm.elements[d];
    var e = false;
    if (!c) {
        return
    }
    var b = c.length;
    if (!b) {
        c.checked = 0;
        e = true
    } else {
        for (var a = 0; a < b; a++) {
            if (c[a].checked == 1) {
                e = true
            }
        }
    }
    return e
}, pollCboxes: function (c) {
    if (!c) {
        return
    }
    var b = c.length;
    if (!b) {
        c.checked = 0
    } else {
        for (var a = 0; a < b; a++) {
            c[a].checked = 0;
            c[a].removeAttribute("checked")
        }
    }
}, clearCboxes: function (b) {
    var a = this.listForm.elements[b];
    if (!a) {
        return
    }
    this.pollCboxes(a);
    var c = b.substring(0, b.length - 2);
    if (this.initFiltersState[c] == true) {
        this.srchInfo.addClass(this.options.hiddenName);
        if (this.keywdInfo) {
            this.keywdInfo.addClass(this.options.hiddenName)
        }
        this.effects.windowScroll.toElement(this.options.loginWrapper, "y");
        this.effects.advFiltersSlide.slideOut().chain(function () {
            this.advSearch.text = this.options.txtAdvSrch;
            this.advSearch.removeClass(this.options.openState);
            this.advSearch.addClass(this.options.closedState);
            this.advSearch.addClass(this.options.hiddenName);
            $(this.options.advSearchCont).addClass(this.options.displayNone);
            this.loading.removeClass(this.options.hiddenName);
            this.submits[0].setAttribute("disabled", "disabled");
            this.submits[1].setAttribute("disabled", "disabled");
            this.listForm.elements[this.options.cbResetSectionFlag].value = 1;
            this.listForm.submit()
        }.bind(this))
    } else {
        this.filterTriggers[c].addClass(this.options.hiddenName)
    }
}, clearAllCboxes: function () {
    var a = ["filter_job_type[]", "filter_careerlvl[]", "filter_edulevel[]"];
    a.each(function (c) {
        var b = this.listForm.elements[c];
        if (!b) {
            return
        }
        this.pollCboxes(b)
    }.bind(this));
    this.loading.removeClass(this.options.hiddenName);
    this.listForm.elements[this.options.cbResetSectionFlag].value = 1;
    this.listForm.submit()
}, switchLayout: function () {
    this.listForm.elements.switch_layout.value = 1;
    this.listForm.submit()
}});
window.addEvent("domready", function () {
    var a = a || {};
    a.JobListView = a.JobListView || {};
    a.JobListView.List = new TandolinClassJobList({titleString: titleString, keywdString: keywdString, locnString: locnString, txtLoading: txtLoading, unsolLnk: uslnk, txtBasicSrch: txtBasicSrch, txtAdvSrch: txtAdvSrch})
});
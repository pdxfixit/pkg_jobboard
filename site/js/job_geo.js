/**
 @package JobBoard
 @copyright Copyright (c)2010-2012 Tandolin
 @license : GNU General Public License v2 or later
 ----------------------------------------------------------------------- */

var TandolinPublcJob = new Class({Implements: [Options, Events], options: {jobData: {lat: "", lng: "", title: ""}, effects: {mapSlide: {}, windowScroll: {}, windowLocation: null}, mapSlide: "jobpost_map", mapOptions: {zoom: 6, center: null, mapTypeId: null}, mapDiv: "jobpostMap", vMapTriggers: "a.map_trigger", mapCls: "map_cls", mapSlideEndEl: "view_map", winScrollEndEl: "sb_lastrow"}, initialize: function (a) {
    this.setOptions(a);
    this.jobData = this.options.jobData;
    this.effects = this.options.effects;
    this.mapOptions = this.options.mapOptions;
    this.mapDiv = $(this.options.mapDiv);
    this.mapDivWrapper = this.mapDiv.getParent("div");
    this.mapCls = $(this.options.mapCls);
    this.vMapTriggers = $$(this.options.vMapTriggers);
    this.launch()
}, launch: function () {
    this.setEffects();
    this.loadMap();
    this.setMapEvents()
}, setEffects: function () {
    this.effects.mapSlide = new Fx.Slide(this.mapDivWrapper.id, {duration: 380}).slideOut();
    this.effects.windowScroll = new Fx.Scroll(window, {offset: {x: 0, y: 10}, transition: Fx.Transitions.Quad.easeInOut})
}, loadMap: function () {
    this.center = new google.maps.LatLng(this.jobData.lat, this.jobData.lng);
    this.mapOptions.mapTypeId = google.maps.MapTypeId.ROADMAP;
    this.map = new google.maps.Map(this.mapDiv, this.mapOptions);
    this.marker = new google.maps.Marker({position: this.center, map: this.map, title: this.jobData.title});
    this.showMap(6, 10)
}, setMapEvents: function () {
    this.mapCls.addEvent("click", function (a) {
        a.stop();
        this.mapCls.addClass("jbhidden");
        this.map.setZoom(6);
        (function () {
            this.closeMap()
        }.bind(this)).delay(500)
    }.bind(this));
    this.vMapTriggers.each(function (a) {
        this.setOpenTrigger(a)
    }.bind(this))
}, setOpenTrigger: function (a) {
    a.addEvent("click", function (b) {
        b.stop();
        this.mapDivWrapper.removeClass("jbdispnone");
        this.effects.windowLocation = document.getCoordinates();
        this.effects.windowScroll.toElement(this.options.mapSlideEndEl, "y").chain(function () {
            this.effects.mapSlide.slideIn().chain(function () {
                this.showMap(12, 300);
                this.vMapTriggers.each(function (c) {
                    this.setTriggerState(c)
                }.bind(this))
            }.bind(this))
        }.bind(this))
    }.bind(this))
}, setTriggerState: function (a) {
    a.addClass("jbhidden");
    this.mapCls.removeClass("jbhidden")
}, showMap: function (a, b) {
    (function () {
        this.map.setZoom(a)
    }.bind(this)).delay(b);
    google.maps.event.trigger(this.map, "resize");
    this.marker.setPosition(this.center);
    this.map.setCenter(this.center)
}, closeMap: function () {
    this.effects.mapSlide.slideOut().chain(function () {
        this.effects.windowScroll.toElement(this.options.winScrollEndEl, "y");
        this.vMapTriggers.each(function (a) {
            a.removeClass("jbhidden")
        }.bind(this))
    }.bind(this))
}});
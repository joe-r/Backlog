$(function(){
    Backbone.history.start(); // {pushState: true}

    var BacklogRow = Backbone.Model.extend({
    });

    var Backlog = Backbone.Collection.extend({
        model: BacklogRow
    });
});

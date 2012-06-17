$(function() {
    if (typeof(Backlog) == 'undefined') {
        Backlog = {};
    }
    if (typeof(Backlog.Model) == 'undefined') {
        Backlog.Model = {};
    }


    Backlog.Model.BacklogRow = Backbone.RelationalModel.extend({
        urlRoot: function () {
            return '/app_dev.php/b/';
        },
        idAttribute: 'id'
    });

    Backlog.Model.Backlog = Backbone.RelationalModel.extend({
        url: function ()
        {
            return "/app_dev.php/b/" + this.get('uid');
        },
        idAttribute: 'uid',
        relations: [
            {
                type: Backbone.HasMany,
                key: "rows",
                relatedModel: Backlog.Model.BacklogRow,
                reverseRelation: {
                    key: 'backlog',
                    includeInJSON: 'uid'
                }
            }
        ]
    });
});

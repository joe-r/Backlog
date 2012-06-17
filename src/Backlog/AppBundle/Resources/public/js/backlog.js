$(function(){
    /**
     * A row in the backlog
     */
    var BacklogRow = Backbone.RelationalModel.extend({
        urlRoot: function () {
            console.log(this);
            return '/app_dev.php/b/';
        },
        idAttribute: 'id'
    });

    /**
     * A backlog object.
     */
    var Backlog = Backbone.RelationalModel.extend({
        url: function ()
        {
            return "/app_dev.php/b/" + this.id;
        },
        relations: [
            {
                type: Backbone.HasMany,
                key: "rows",
                relatedModel: BacklogRow,
                reverseRelation: {
                    key: 'backlog',
                    includeInJSON: 'uid'
                }
            }
        ]
    });

    var backlog = new Backlog({
        id: "397d237c06bc"
    });

    backlog.fetch({
        error: function (model, error)
        {
            alert("Error while processing");
        },
        success: function ()
        {
            console.log(backlog.toJSON());
        }
    });
});

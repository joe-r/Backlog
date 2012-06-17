$(function (){
    if (typeof(Backlog) == 'undefined') {
        Backlog = {};
    }
    if (typeof(Backlog.View) == 'undefined') {
        Backlog.View = {};
    }

    Backlog.View.AppRowView = Backbone.View.extend({
        tagName: "div",
        templateStory:     twig({data: '<i class="icon-star"></i> <a href="#">{{ row.get("title") }}</a>'}),
        templateMilestone: twig({data: '<i class="icon-flag"></i> <a href="#">{{ row.get("title") }}</a>'}),
        initialize: function () {
            this.model.bind('change', this.render, this);
        },

        render: function () {
            if (this.model.get('type') == 'story') {
                this.$el.addClass('bl-backlog-row-story');
                this.$el.html(this.templateStory.render({row: this.model}));
            } else if (this.model.get('type') == 'milestone') {
                this.$el.addClass('bl-backlog-row-milestone');
                this.$el.html(this.templateMilestone.render({row: this.model}));
            }

            return this;
        }
    });

    Backlog.View.AppRowsView = Backbone.View.extend({
        el: $("#bl-backlog"),

        initialize: function () {
            this.model.bind('change', this.render, this);
        },

        render: function () {
            this.$el.html('');
            this.model.get('rows').forEach(this.addRow);

            var rows = this;
        },

        addRow: function (row) {
            var view = new Backlog.View.AppRowView({model: row});
            $("#bl-backlog").append(view.render().el);
        }
    });

    Backlog.View.AppView = Backbone.View.extend({
        el: $("#bl-app"),

        events: {
            "click button": "newElement"
        },

        initialize: function () {
            console.log("Application initialized (#" + this.model.get('uid') + ")");

            this.rows = new Backlog.View.AppRowsView({
                model: this.model
            });

            this.model.fetch();
        },

        newElement: function () {
            var row = new Backlog.Model.BacklogRow({
                title: "Foobar",
                type: "story"
            });
            this.rows.addRow(row);
        }
    });
});

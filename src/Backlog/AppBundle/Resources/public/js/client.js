function blClient($body)
{
    this.$body = $body;

    this.$panelLeft = $("#bl-panel-left");
    this.$panelLeftResizer = $("#bl-panel-left-resizer");
    this.$panelCenter = $("#bl-panel-center");

    this.initialize();
}

blClient.prototype = {
    initialize: function ()
    {
        var client = this;
        $("#bl-panel-left-resizer").draggable({
            axis: 'x',
            drag: function () {
                client.layout();
            }
        });

        this.layout();
    },

    /**
     * Resize layout according to resizer
     */
    layout: function () {
        var left = this.$panelLeftResizer.position().left;
        this.$panelLeft.css('width', left);
        this.$panelCenter.css('width', this.$body.width() - left - 30);
    },

    errorModal: function (message)
    {
        if (!this.$modalWraper) {
            this.$body.append('<div id="bl-modal-wrapper"></div>');
            this.$modalWrapper = $("#bl-modal-wrapper");
        }

        this.$modalWrapper.html('    <div class="modal hide" id="bl-modal"> \
        <div class="modal-header"> \
        <button type="button" class="close" data-dismiss="modal">×</button> \
        <h3>An error occurred</h3> \
      </div> \
      <div class="modal-body"> \
        <p>Please refresh browser to prevent problems.</p> \
      </div> \
      <div class="modal-footer"> \
        <a href="#" class="btn" data-dismiss="modal">Dismiss</a> \
        <a class="btn btn-primary" onclick="location.reload(true);"><i class="icon-refresh icon-white"></i> Refresh</a>\
      </div> \
    </div> \
        ');

        $("#bl-modal").modal();
    },

    registerPanelEvents: function($element)
    {
        var client = this;
        $element.find("a").click(function () {
            if ($(this).hasClass('no-panel')) {
                return;
            }
            client.openPanel($(this).attr('href'));

            return false;
        });

        $element.find("form").submit(function () {
            client.postPanel($(this));

            return false;
        });
    },

    postPanel: function (form)
    {
        $("#bl-viewer-loader").show();
        $("#bl-viewer-content").hide();

        var client = this;
        $.ajax({
            url: form.attr('action'),
            type: "POST",
            data: form.serialize(),
            success: function (data) {
                $("#bl-viewer-content").html(data);
                client.registerPanelEvents($("#bl-viewer-content"));
                $("#bl-viewer-loader").hide();
                $("#bl-viewer-content").show();
            },
            error: function (xhr, error) {
                $("#bl-viewer-loader").hide();
                this.client.errorModal(error);
            }
        });
    },

    openPanel: function (url, force)
    {
        $("#bl-viewer-loader").show();
        $("#bl-viewer-content").hide();

        var client = this;
        $.ajax({
            url: url,
            success: function (data) {
                $("#bl-viewer-content").html(data);
                if (!force) {
                    history.pushState({}, "", url);
                }
                client.registerPanelEvents($("#bl-viewer-content"));
                $("#bl-viewer-loader").hide();
                $("#bl-viewer-content").show();
            },
            error: function (xhr, error) {
                $("#bl-viewer-loader").hide();
                this.client.errorModal(error);
            }
        });

        return false;
    }
};

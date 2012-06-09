/**
 * Constructor of a Backlog object
 */
function Backlog(client, divElement)
{
    this.client = client;
    this.divElement = divElement;
    this.initialize();
}

/**
 * Backlog object
 */
Backlog.prototype = {

    /**
     * Adds listeners to HTML document
     */
    initialize: function ()
    {
        var $rows = $(this.divElement);

        // Make the list sortable
        var backlog = this;
        $rows.sortable({
            axis: 'y',
            update: function (event, ui) {
                backlog.moveEvent(ui.item);
            }
        });

        // Register initial position
        if ($rows.children().length) {
            var $firstChild = $($rows.children()[0]);
            this.initialPosition =  $firstChild.attr('data-position');
        }

        this.uid = $rows.attr('data-uid');

        this.client.registerPanelEvents($rows);

        var client = this.client;
        window.onpopstate = function (event) {
            client.openPanel(document.location, true);
        };
    },

    moveEvent: function (node)
    {
        var $node = $(node);
        var oldPosition = parseInt($node.attr('data-position'));
        var previousPosition;

        var $previous;
        if ($node.prev()) {
            $previous = $node.prev();
            previousPosition = parseInt($previous.attr('data-position'));
        } else {
            previousPosition = this.initialPosition;
        }

        var newPosition;

        if ($previous && previousPosition > oldPosition) {
            newPosition = previousPosition;
            $node.attr('data-position', newPosition);
            var $current = $previous;
            var currentPosition = previousPosition;
            while ($current && currentPosition > oldPosition) {
                $current.attr('data-position', currentPosition - 1);
                $current = $current.prev();
                if ($current) {
                    currentPosition = parseInt($current.attr('data-position'));
                }
            }
        } else {
            var $next = $node.next();
            var nextPosition = parseInt($next.attr('data-position'));
            var newPosition = nextPosition;
            $node.attr('data-position', newPosition);
            var $current = $next;
            var currentPosition = nextPosition;
            while ($current && currentPosition < oldPosition) {
                $current.attr('data-position', currentPosition + 1);
                $current = $current.next();
                if ($current) {
                    currentPosition = parseInt($current.attr('data-position'));
                }
            }
        }

        this.serverMove($node.attr('data-id'), newPosition);
    },

    serverMove: function (id, position)
    {
        var backlog_uid = this.uid;
        $.ajax({
            url: "/app_dev.php/b/" + backlog_uid + "/" + id + "/move",
            type: "POST",
            data: {
                "id": id,
                "position": position
            },
            error: function (xhr, text) {
                backlog.client.errorModal(text);
            }
        });
    }
};

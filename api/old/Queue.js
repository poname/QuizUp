var events = require('events');
/**
 * Queuing manager
 * @author HatsOn
 * @Queue {{addItem, getItemCount, getTotal}}
 */
var Queue = (function() {
    var queue = [];
    var eventMngr = new events.EventEmitter();

    var checkForMatch = function () {
        for(var i = 0 ; i<queue.length ; i++){
            for(var j=i+1; j<queue.length ; j++){
                if(queue[i].category = queue[j].category && queue[i].userId != queue[j].userId){
                    return [i, j];
                }
            }
        }
        return false;
    };
    return {
        addRequest: function(userId,category,socket) {
            //validate userId,cat
            queue.push(
                {
                    userId: userId,
                    category: category,
                    socket: socket
                }
            );

        },
        getItemCount: function() {
            return basket.length;
        },
        getTotal: function() {
            var q = this.getItemCount(), p = 0;
            while (q--) {
                p += basket[q].price;
            }
            return p;
        }
    }
}());

module.exports = Queue ;


// how to use this module from another js file and call some method
var basket = require('./Basket.js');
basket.addItem(7);
(function(){
    var controller = tack.mvc.create({
        data: {},
        initialize: function(){
            this.index = function(){
                var model = tack.model.create({
                    data: {
                        count: 0,
                    },
                    initialize: function(){
                        this.up = function(){
                            this.set('count', this.get('count') + 1);
                        };
                    },
                });
                var view = tack.view.create({
                    data: {
                        el: $('h1'),
                    },
                    initialize: function(){
                        this.update = function(e){
                            if(e.type == 'init'){
                                return this.get('el').text(e.object.get('count'));
                            };
                            if(e.name == 'count'){
                                return this.get('el').text(e.object.get('count'));
                            }
                        };
                    },
                });
                model.addObserver(view);
                view.get('el').click(function(){
                    model.set('count', model.get('count') + 1);
                });
            };
        },
    });
    $(function(){
        controller.index();
    });
})();

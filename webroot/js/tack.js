(function(namespace){
    var tack = {};
    tack.mvc = (function(){
        function mvc(arg){
            if(typeof arg == 'undefined'){
                arg = {};
            }
            this.data = arg.data || {};
            this.initialize = arg.initialize || function(){};
            this.observers = [];
            if(typeof this.initialize == 'function')    this.initialize();
        }
        mvc.prototype.get = function(key){
            return this.data[key];
        };
        mvc.prototype.set = function(key, value, is_silent){
            if(typeof this.data[key] == 'undefined'){
                this.data[key]  = value;
                var p = {
                    name: key,
                    type: 'add',
                    object: this
                };
            }else if(this.data[key].toString() != value.toString()){
                this.data[key]  = value;
                var p = {
                    name: key,
                    type: 'change',
                    object: this
                };
            }else{
                return ;
            }
            if(is_silent)   return ;
            this.notify(p);
        };
        mvc.prototype.addObserver = function(observer){
            this.observers.push(observer);
            observer.update({
                name: null,
                type: 'init',
                object: this
            });
        };
        mvc.prototype.removeObserver = function(observer){
            for(var key in this.observers){
                if(this.observers[key]== observer) this.observers.splice(key, 1);
            }
        };
        mvc.prototype.notify = function(p){
            for(var key in this.observers){
                this.observers[key].update(p);
            }
        };
        mvc.create = function(arg){
            return new mvc(arg);
        };
        return mvc;
    })();
    tack.controller = tack.mvc;
    tack.model = tack.mvc;
    tack.view = tack.mvc;
    namespace.tack = tack;
})(this);

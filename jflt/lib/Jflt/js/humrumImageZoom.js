/*TODO: renomear a classe e torná-la mais ágil */
window.addEvent('domready', function() {initImageZoom();});

var ImagezoomInstances = new Array(); // a lista dos objetos criados .
function initImageZoom(_options) {
    var options = $extend({
        rel: 'imagezoom'
    }, _options || {});
    var elements = $$(document.links).filter(function(el) {
        if ((el.rel) && (el.rel.indexOf(options.rel) != -1)) 
            {return true;}
        else
           { return false;}
    });
    for (var i = 0; i < elements.length; i++) {
        var el = elements[i];
        el.addEvent("click", function() {
            this.blur();
            var sEl = this;
            if (this.getElements("img").length > 0)
                sEl = this.getElements("img")[0];				
            var _options = $extend({
                image: this.href,
                startElement: sEl
            }, options || {});
            _options.image = this.href;
            var imagezoom = new Imagezoom(_options);
            imagezoom.preloadImage();
				
            for(i=0;i<ImagezoomInstances.length;i++) {						
                if(ImagezoomInstances[i].Ilivef())
                    {ImagezoomInstances[i].close();}
                else
                    {ImagezoomInstances.splice(i,1);}							
            }
            imagezoom.show();
            ImagezoomInstances.push(imagezoom);
            return false;
        });
    }
}
	
var Imagezoom = function(_options) {		
    var options = $extend({
        image: false,
        startElement: false,
        x: 10,
        y: 10,
        initWidth: 50,
        initHeight: 50,
        loadImage: "/images/loading.gif",
        loadDelay: 150,
        duration: 600,
        closeDuration: 600,
        transition: Fx.Transitions.Cubic.easeOut,
        closeTransition:  Fx.Transitions.Cubic.easeOut,
        startOpacity: 0.2,
        rel: 'imagezoom'
    }, _options || {});
		
    var box = document.createElement("div");		
    var instance = this;
	
    var Ilive = true;
		
		
    this.preloadImage = function() {
        if (options.image != false) {
            var img = new Image();
            img.setAttribute("class", "tmp_imagezoom");
            img.src = options.image;
            img.style.visibility = "hidden";
            img.style.position = "absolute";
            img.style.top = "-9999999999px";
            img.setAttribute("id", "imagezoom-" + options.image);
            $$('body')[0].appendChild(img);
        }	
    }
		
    this.Ilivef = function(){
        return Ilive;
    }
		
    this.getImage = function() {
        if (($('imagezoom-' + options.image)) && ($('imagezoom-' + options.image).width != "0")) {
            var img = $('imagezoom-' + options.image).clone();
            img.setAttribute("id", "");
            img.style.position = "relative";
            img.style.top = "0px";
            img.style.visibility = "visible";
           
        } else {
            instance.preloadImage();
            window.setTimeout(function() {
                instance.getImage();
            }, 50);
        }
        return img;
    }		
		
    this.show = function() {
        if (options.image != false) {
            box.style.position = "absolute";
            box.style.overflow = "hidden";
            box.setAttribute("id", "imagezoom-open-" + options.image);
				
            if (options.startElement != false)
                {options.startElement.blur();}
				
            var x = options.x;
            var y = options.y;
            var boxWidth = options.initWidth;
            var boxHeight = options.initHeight;
            if (options.startElement != false) {
                x = options.startElement.getPosition().x;
                y = options.startElement.getPosition().y;
                boxWidth = options.startElement.offsetWidth;
                boxHeight = options.startElement.offsetHeight;
            }
            box.style.left = x + "px";
            box.style.top = y + "px"; 
            box.style.width = boxWidth + "px";		
            box.style.height =  boxHeight  + "px";
				
            var fx = new Fx.Morph(box);
            fx.set({
                opacity: options.startOpacity
                });
				
            box.className = "imagezoom";
            $$('body')[0].appendChild(box);
            box.style.cursor = "pointer";
            box.addEvent("click", function() {
                var fx = new Fx.Morph(box, {
                    duration: 200
                });
                fx.start({
                    opacity: 0
                }).chain(function() {
                    $$('body')[0].removeChild(box);
                });
            });

            this.loadImage();
				
        }
    }
		
    this.loadImage = function() {
        if (box.getElements(".loading").length == 0) {
            var loading = new Image();
            loading.src = options.loadImage;
            loading.className = "loading";
            box.appendChild(loading);
        }	
        if ($('imagezoom-' + options.image)) {
            var el = $('imagezoom-' + options.image);
            if (el.width != "0") {
                var newEl = new Image();
                newEl.src = options.image;
                window.setTimeout(function() {
                    instance.insertImage(newEl)
                }, options.loadDelay);
            } else {
                window.setTimeout(function() {
                    instance.loadImage();
                }, 50);
            }
        } else {
            instance.preloadImage();
            window.setTimeout(function() {
                instance.loadImage();
            }, 50);
        }
    }
		
    this.getData = function(){
        var maxBoxh = window.getSize().y - (2*offset); // altura máxima do box
        var maxBoxw = window.getSize().x - (2*offset); // altura máxima do box
    }
		
    this.insertImage = function(img) {
        box.removeEvents("click");			
        box.style.cursor = "default";
        box.style.overflow = "hidden";
			
        var w = img.width;
        var h = img.height;
        img.style.width = w + "px";
        img.style.height = h + "px";
        img.className = 'image';
			
        var fx = new Fx.Morph(box, {
            duration: options.duration, 
            transition: options.transition
            });
					
        /*novas variaveis para altura , largura e posicionamento*/
        var offset = 50;//offset top
        var newh = h; // altura do box
        var neww= w; // altura do box
        var maxBoxh = window.getSize().y - (2*offset); // altura máxima do box
        var maxBoxw = window.getSize().x - (2*offset); // altura máxima do box
			
        if( newh > maxBoxh )
           { newh = maxBoxh;}
        if( neww > maxBoxw )
           { neww = maxBoxw;}
			
        ptop = (window.getSize().y / 2) + window.getScroll().y - (newh/2);
        pleft = (window.getSize().x / 2) + window.getScroll().x - (neww/2);
			
        fx.start({
            top: ptop,
            left: pleft,
            width: neww,
            height: newh,
            opacity: 1
        }).chain(function() {
            var loading = box.getElements(".loading");
            if (loading.length > 0)
                box.removeChild(loading[0]);
				
            var imgFx = new Fx.Morph(img, {
                duration: 600
            });
            imgFx.set({
                opacity: 0
            });
            box.adopt(img);
            imgFx.start({
                opacity: 1
            });
				
														
        });	
			
			
        /* reajustar o tamanho */
        window.onresize = function(e){
				
            newh = h; // altura do box
            neww= w; // altura do box
            maxBoxh = window.getSize().y - (2*offset); 	
            maxBoxw = window.getSize().x - (2*offset); 
					
            if( newh > maxBoxh )
               { newh = maxBoxh;}		
            if( neww > maxBoxw )
                {neww = maxBoxw;}
						
            ptop = (window.getSize().y / 2) + window.getScroll().y - (newh/2);
            pleft = (window.getSize().x / 2) + window.getScroll().x - (neww/2);					
					
            fx.start({
                top: ptop,
                left: pleft,
                width: neww,	 
                height: newh
            })	
        };
			
        box.addEvent("click", function() {
            instance.close();
        });
			
			
        /* fazer a imagem deslizar dentro do box */
        box.addEvent('mousemove',function(e){                    
            if(img.height > newh) {  
                imgTop = -Math.ceil( ( (e.client.y-offset) /  (newh /( img.height - newh))));
                img.set('styles', {
                    'top': imgTop
                });
            }
            if(img.width > neww) {  
                imgLeft = -Math.ceil( ( (e.client.x-offset) /  (neww /( img.width - neww))));
                img.set('styles', {
                    'left': imgLeft
                });
            }
        });
    }
		
	
		
    this.close = function() {
			
        Ilive = false;
        var img = box.getElements(".image")[0];
        box.removeChild(img);	
        
        /*remove as imagens temporárias*/
        var img2 = $$('body')[0].getElements(".tmp_imagezoom")[0];
        $$('body')[0].removeChild(img2);		
				
        var x = options.x;
        var y = options.y;
        var boxWidth = options.initWidth;
        var boxHeight = options.initHeight;
        if (options.startElement != false) {
            x = options.startElement.getPosition().x;
            y = options.startElement.getPosition().y;
            boxWidth = options.startElement.offsetWidth;
            boxHeight = options.startElement.offsetHeight;
        }
			
        var fx = new Fx.Morph(box, {
            duration: options.closeDuration , 
            transition: options.closeTransition
            });
			
        fx.start({
            left: x,
            top: y,
            width: boxWidth,
            height: boxHeight,
            opacity: options.startOpacity
        }).chain(function() {
            fx.start({
                opacity: 0
            }).chain(function() {
                $$('body')[0].removeChild(box);
            });
        });
    }
		
		
		
		
}

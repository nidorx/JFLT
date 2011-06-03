window.addEvent('domready', function() {	
    // removendo a primeira linha de parametros ( não ultilizada )
    $$('.paramlist').each(function(item, index){
        item.remove();
    });

    // removendo a primeira e a  ultima linha de cada bloco ( sem conteudo )
    var blocks =$$('.jftparamsblock-inner');
    blocks.each(function(item, index){
        if(blocks.length > index+1){
            var lastLine = item.getElements('table tbody tr');
            lastLine[lastLine.length-1].remove();//ultima linha
        }
        var firstLine = item.getElements('table tbody tr');
        firstLine[0].remove();//primeira linha
    });


    //criação do acordion
    var firstPass = true;
    var divAcordion = new Element('div', {
        id: 'param-accordion',
        'class':'accordion'
    });
    $$('.jftparamsblock').each(function(item, index){
        if(firstPass){
            divAcordion.injectBefore(item);
            firstPass = false;
        }
        item.injectInside(divAcordion);
    });
        

   


    //Criar o acordion dos parametros
    var paramAcc = new Accordion($('param-accordion'), 'div.block-toggler', 'div.block-content', {
        opacity: true,
        onActive: function(toggler, element){
        //toggler.setStyle('color', '#41464D');
        },
        onBackground: function(toggler, element){
        //toggler.setStyle('color', '#528CE0');
        },
        onComplete: function(){
            this.container;
        // this.display.delay(2500, this, (this.previous + 1) % this.togglers.length);
        }

    });



    //Criar o acordion da documentação
    var previousDocs =0 ;
    var docsAcc = new Accordion($('doc-accordion'), 'div.doc-toggler', 'div.doc-content', {
        opacity: true,
        onActive: function(toggler, element){
             this.elements[previousDocs].setStyle('overflow', 'hidden');
        //toggler.setStyle('color', '#41464D');
        },
        onBackground: function(toggler, element){
        //toggler.setStyle('color', '#528CE0');
        }
        ,
        onComplete: function(){
           /* overflow visible no conteudo para exibir as sombras corretamente*/
            this.elements[this.previous].setStyle('overflow', 'visible');
            previousDocs =this.previous;
        }
    });
       
});
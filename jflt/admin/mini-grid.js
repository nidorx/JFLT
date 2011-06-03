var isMiniEffectStart = false;
var focusedFormControl;
function startMiniEffect(input){
    if(input){
        focusedFormControl = input;
        var positionName = input.id.split(/-/)[0];
        var el = $('mini-'+positionName);
        if(!isMiniEffectStart){
            var elFx  = new Fx.Styles(el,{
                duration: 1000,
                transition: Fx.Transitions.Cubic.easeOut
            });
            elFx.start({
                'opacity': [0,1]
            });
        }
        el.addClass('mini-active');
        isMiniEffectStart = true;
    }
}
function stopMiniEffect(input){
    var positionName = input.id.split(/-/)[0];
    var el = $('mini-'+positionName);
    el.removeClass('mini-active');
    isMiniEffectStart = false;
}



window.addEvent('domready', function() {
    drawMain(12);
    $$('.position').each(function(item, index){
        returnValue=getPositionsCols(item,12);
        if(returnValue){
            updateMiniGrids(returnValue.positionName,returnValue.colsValues);
        }
    });

    $$('.position').addEvent('keyup', function(event){
        returnValue=getPositionsCols(this,12);
        if(returnValue){
            updateMiniGrids(returnValue.positionName,returnValue.colsValues);
        }
    });

    $$('.pos').addEvent('focus', function(event){
        startMiniEffect(this);
    });
    $$('.pos').addEvent('blur', function(event){
        stopMiniEffect(this);
    });

    $$('.positionContent').addEvent('keyup', function(event){
        drawMain(12);
    });

    $('content-position').addEvent('keyup', function(event){
        drawMain(12);
    });
    $('main-position').addEvent('keyup', function(event){
        drawMain(12);

    });

});



function drawMain(colsMax){
    /*desenha o mainbody*/
    var returnPos = getPositionsCols($('main-position'),colsMax);
    var columsValues = returnPos.colsValues;

    if(columsValues==null){
        var columsValues=[""+colsMax+""];
    }


    var contentPos = contentPosition();/*posição de content*/
    /*verificar se a posição de content está certa*/
    if(contentPos>columsValues.length){
        contentPos=columsValues.length;
    }
    if(contentPos==0){
        contentPos=1;
    }
    contentPositionSet(contentPos);
    var contentSiz = contentSize(colsMax);
    /*remove todo o conteudo de main*/
    $$('#mini-main div').each(function(item, index){
        item.remove();
    });
    /* recriando os elementos de main*/
    var sidebarID = 1;
    var sidebarLeter = 'A';
    for(i=0;i<columsValues.length;i++){
        if(i==contentPos-1){/* o contentbody */
            itemID = 'contentbody';
            itemClass = 'wb-mini-grid-'+columsValues[i]
        }else
        {
            itemID = 'sidebar-'+sidebarID;/*sidebar-1 , sidebar-2 etc.*/
            itemClass = 'mini-grid-'+columsValues[i]
            sidebarID++;
        }
        var newItem = new Element('div', {
            'class': itemClass,
            id:itemID
        });


        newItem.injectInside($('mini-main'));
        /*colocando o nome nos grids*/
        if(i!=contentPos-1){
            newItem.empty();
            var itemPos = new Element('span',{
                'class':'block',
                'title':('sidebar-'+sidebarLeter).toLowerCase()
            });
            itemPos.setHTML(sidebarLeter);
            newItem.set({
                'title':('sidebar-'+sidebarLeter).toLowerCase()
            });
            itemPos.injectInside(newItem);
            sidebarLeter = incrementChar(sidebarLeter);

        }

    }

    /* recriando os elementos de contentbody*/
    /*criando o contenttop*/
    var newItem = new Element('div', {
        'class': 'wb-mini-grid-'+contentSiz,
        id:'mini-contenttop'
    });
    newItem.injectInside($('contentbody'));
    contenttopItems=getPositionsCols($('contenttop-position'),contentSiz);
    contenttopItems=getPositionsCols($('contenttop-position'),contentSiz);
    if(contenttopItems){
        updateMiniGrids(contenttopItems.positionName,contenttopItems.colsValues,'mini');
    }


    /*criando o content*/
    var newItem = new Element('div', {
        'class': 'mini-grid-'+contentSiz,
        id:'mini-content'
    });
    newItem.injectInside($('contentbody'));
    newItem.empty();
    var itemPos = new Element('span',{
        'class':'block',
        'title':'content'
    });
    itemPos.setHTML('content');
    newItem.set({
        'title':'content'
    });
    itemPos.injectInside(newItem);




    /*criando o contentbottom*/
    var newItem = new Element('div', {
        'class': 'wb-mini-grid-'+contentSiz,
        id:'mini-contentbottom'
    });
    newItem.injectInside($('contentbody'));
    contentbottomItems=getPositionsCols($('contentbottom-position'),contentSiz);
    contentbottomItems=getPositionsCols($('contentbottom-position'),contentSiz);
    if(contentbottomItems){
        updateMiniGrids(contentbottomItems.positionName,contentbottomItems.colsValues,'mini');
    }



    /*criando o clear div para o main*/
    var newItem = new Element('div', {
        'class': 'clear'
    });
    newItem.injectInside($('mini-main'));

    
    startMiniEffect(focusedFormControl);

}
function contentPosition(){
    /*obtem a posição de content*/
    var contentPos = $('content-position').value;/*obtem a posiçao de content*/
    return contentPos;
}
function contentPositionSet(contentPosition){
    /*define a posição de content*/
    $('content-position').value = contentPosition;/*define a posiçao de content*/
}
function contentSize(colsMax){
    /* Obtem o tamanho da área content*/
    var contentSize = getPositionsCols($('main-position'),colsMax).colsValues[contentPosition()-1];
    return contentSize;
}

function updateMiniGrids(positionName,colsValues,otherClass){
    /*alterando o mini template*/
    if(!otherClass)/*adiciona mais uma classe ao elemento criado */
    {
        otherClass='';
    }
    var countExistingItens = 0;/*a quantidade de colunas que existem dentro da posiçao que está sendo editada*/
    $$('#mini-'+positionName+' div').each(function(item, index){
        if(index>colsValues.length-1){
            item.remove();/*remove os blocos excedentes*/
        }else{
            item.setProperty('class','mini-grid-'+colsValues[index]);
        }
        countExistingItens++;
    });

    for(i=countExistingItens;i<colsValues.length;i++){
        var newItem = new Element('div', {
            'class': 'mini-grid-'+colsValues[i]+' '+otherClass
        });
        newItem.injectInside('mini-'+positionName);
    }
    var leter = 'A';
    $$('#mini-'+positionName+' div').each(function(item, index){

        item.empty();
        var itemPos = new Element('span',{
            'class':'block',
            'title':(positionName+'-'+leter).toLowerCase()
        });

        itemPos.setHTML(leter);
        item.set({
            'title':(positionName+'-'+leter).toLowerCase()
        });
        itemPos.injectInside(item);
        leter = incrementChar(leter);


    });

}
function incrementChar(chr){
    return String.fromCharCode(chr.charCodeAt() + 1)
}
function getPositionsCols(input,colsMax){
    if(input){
        if(parseInt(input.value)==0){
            input.value=colsMax+'';
        }
        newValue=input.value.replace(/[^0-9\-]/g, "")/* remove letras*/
        newValue=newValue.replace(/^[-]/, "")/* remove - do inicio se houver*/
        newValue=newValue.replace(/--*/g, "-")/* remove os - duplicados*/
        /* verificar se os valores estão dentro da faixa possivel (até «colsMax» colunas)*/
        var colsValues = newValue.match(/\d+/g);/*array com valores digitados*/
        var testIsSeparator=/[-]$/;
        var lastIsSeparator = testIsSeparator.test(newValue);/*verifica se o último caractere é o -*/
        var colsSum = 0;/*soma dos valores digitados*/
        var returnValue = new Array();
        var positionName = input.id.split(/-/)[0];
        returnValue['positionName']=positionName;

        if(colsValues!=null){
            if( parseInt(colsValues[0])>= parseInt(colsMax)){/*usuario digitou «colsMax» ou um numero maior*/
                input.value = colsMax;
                colsValues[0] = colsMax;
            }else{
                for(i=0;i<colsValues.length;i++){
                    if(colsSum+parseInt(colsValues[i])>colsMax){
                        colsValues[i]=((colsSum-colsMax)*-1)+'';
                    }
                    else{
                        colsSum+=parseInt(colsValues[i]);
                    }

                    if(colsValues[i]==0){/*remove os  0 */
                        colsValues.splice(i, 1);
                    }
                }
                newValue = colsValues.join("-")+'';
                if(lastIsSeparator){
                    newValue+='-';
                }
                input.value = newValue;
            }


            returnValue['colsValues']=colsValues;
            return returnValue;
        }else{
            colsValues=new Array();
            colsValues[0] = ''+colsMax+"";
            returnValue['colsValues']=colsValues;
            returnValue['error']=true;
            return returnValue;
        }


    }


}
var imagePath = _bbVar.bb_site;
/*var oxford = '<h2>Oxford</h2><p>Ткань "Оксфорд" - прочная синтетическая ткань, используемая для пошива рюкзаков, сумок. Сейчас ее используют и для пошива бескаркасной мебели. С тыльной стороны имеет водоотталкивающий слой, благодаря чему изделия из этого материала можно использовать как в помещении, так и на улице. "Оксфорд" не боится загрязнений - большинство загрязнений с ткани удаляется обычной влажной тряпкой.</p>';
var form = '<form name="bb-pattern" id="bb-pattern">', endForm='</form>';
var oxfordImg= [ "oxford/Orton_21-100x100.png",  "oxford/oxford_18-100x100.png", "oxford/Oxford-01-100x100.png", "oxford/Oxford-02-100x100.png", "oxford/Oxford-03-100x100.png", "oxford/Oxford-05-100x100.png", "oxford/Oxford-06-100x100.png", "oxford/Oxford_07-100x100.png", "oxford/Oxford-07-100x100.png", "oxford/Oxford-10-100x100.png","oxford/Oxford-12-100x100.png","oxford/Oxford-15-100x100.png", "oxford/oxford_17-100x100.png" ];
var oxfordName= [ "Oxford Желтый",   "Oxford Оранжевый", "Oxford Синий", "Oxford Темно-синий", "Oxford Графит", "Oxford Черный", "Oxford Серый", "Oxford Зеленый", "Oxford Светло-зеленый", "Oxford Лиловый","Oxford Красный","Oxford Белый", "Oxford Фиолетовый" ];

function formBuild(arrImg,radioName, patternName){
    var len = arrImg.length, str='<div class="tbl">';
    for(var i = 0; i<len; i++){
        if(i%7==0) form +=str;
        form +='<div class="bb-form-control"><input type="radio" name="'+radioName+'" value="'+patternName[i]+'" id="'+(radioName+i)+'"><label for="'+(radioName+i)+'"><img src="'+imagePath+arrImg[i]+'" alt="'+patternName[i]+'"></label><label for="'+(radioName+i)+'">'+patternName[i]+'</label></div>';
        if(i%6==0 && i>0) form +='</div>';
    }
    form +=endForm+'</div>';
    return form;
}
console.log(oxfordImg.length)*/

var modal = new tingle.modal({
    footer: true,
    stickyFooter: true
});

modal.setFooterContent("<div class='tingle-btn--pull-left bb-footer-message'></div>");
// add a button
modal.addFooterBtn('Закрыть окно', 'tingle-btn tingle-btn--primary tingle-btn--pull-right', function() {
    modal.close();
});

var warn = new tingle.modal({
    footer: false
});
warn.setContent("Выберите сначала основную ткань");

var vstavka = new tingle.modal({
    footer: true,
    stickyFooter: true
});
vstavka.setFooterContent("<div class='tingle-btn--pull-left bb-footer-vstavka'></div>");
// add a button
vstavka.addFooterBtn('Закрыть окно', 'tingle-btn tingle-btn--primary tingle-btn--pull-right', function() {
    vstavka.close();
});
(function($) {
    //var content = formBuild(oxfordImg, 'oxford', oxfordName);
    var content = '';
    $('.bb-option').each(function() {
        content += $(this).html();
    });

    //console.log(content);
    modal.setContent(content);
    jQuery('#bb-choose-pattern').click(function() {
        modal.open();
    });

    jQuery.expr[":"].Contains = jQuery.expr.createPseudo(function(arg) {
        return function(elem) {
            return jQuery(elem).text().toUpperCase().indexOf(arg.toUpperCase()) >= 0;
        };
    });

    $('.bb-form-control :radio').click(function() {
        var text = $(this).parent().find('label:last-child').text();
        var img = $(this).parent().find('img').attr('src');
        var form = $(this).parents('form').attr('id').slice(3);
        $('.bb-footer-message').html('Вы выбрали ткань <strong>' + text + '</strong>');

        $('select:first').val(form);
        $('select:first').change();
        var val = $('select:eq(1)').find('option:Contains(' + text + ')').val();
        console.log(form, text, val);
        $('select:eq(1)').find('option:Contains(' + text + ')').attr("selected", true);
        $('select:eq(1)').change();
        $('.bb-hide:first').removeClass('bb-hide');
        $('#user-choose').text(text);
        $('#user-choose-pic').attr('src', img);
        if ($('#bb-vstavka-pattern')) {
            var vstBtn = $('#bb-vstavka-pattern');
            vstBtn.removeClass("disabled");
            vstBtn.unbind('click');
            vstavka.setContent($('#' + form).html());
            vstBtn.click(function() {
                vstavka.open();
            });
            $('.bb-form-control :radio').click(function() {
                var vst_text = $(this).parent().find('label:last-child').text();
                var vst_img = $(this).parent().find('img').attr('src');
                $('.bb-footer-vstavka').html('Вы выбрали ткань <strong>' + vst_text + '</strong>');
                $('select:eq(2)').find('option:Contains(' + vst_text + ')').attr("selected", true);
                $('select:eq(2)').change();
                $('#user-dop-choose').text(vst_text);
                $('#user-dop-pic').attr('src', vst_img);
                $('.bb-hide').removeClass('bb-hide');
            });
        }
        // $('select:eq(1)').append('<option class="attached enabled" value="'+$(this).attr('id')+'" selected="selected">'+text+'</option>');
        //.append('<option value="'+$(this).val()+'" selected="selected">'+text+'</option>');
    });

    $('#bb-vstavka-pattern.disabled').click(function() {
        warn.open();
    });
})(jQuery);
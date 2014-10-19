/**
 * Created with JetBrains PhpStorm.
 * User: emanuelott
 * Date: 29.06.13
 * Time: 10:40
 * To change this template use File | Settings | File Templates.
 */
var filter_array = new Array();


    $.ajax({
        type: 'GET',
        url: "Data/filter.json",
        dataType: 'json',
        success: function (data) {

                for (var i; i<data.moderat.length; i++) {
            alert(data.moderat.length);}

}
    });


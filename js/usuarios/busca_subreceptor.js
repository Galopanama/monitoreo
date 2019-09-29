$(document).ready(function () {
    var subreceptores = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace("value"),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: {
            url: "ajax.php?funcion=buscar&key=%QUERY",
            wildcard: "%QUERY"
        }
    });

    $("#search_subreceptor").typeahead(null, {
        name: "sub",
        display: "nombre",
        source: subreceptores
    });

    $('#search_subreceptor').bind('typeahead:select', function (ev, suggestion) {
        $("#id_subreceptor").val(suggestion.id);
    });

});
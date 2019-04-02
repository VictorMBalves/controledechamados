function drawChamadosPorHora() {
    var dados = getDataChamadosPorHora();
    if (isEmpty(dados)) {
        $("#chart_div4").html("Nenhum dado no período");
        return;
    }
    chartPorHora = new google.visualization.LineChart(document.getElementById('chart_div4'));
    chartPorHora.draw(dados, getOptionsChamadosPorHora());
}

function getDataChamadosPorHora() {
    $('#dataChamadosPorHora').html(Date.parse($("#dtInicialPorHora").val()).toString('dd/MM/yyyy'))
    var dados = $('#formChamadosPorHora').serialize();
    var jsonData = $.ajax({
        url: "../charts/loadChamadosPorHora.php",
        dataType: "json",
        data: dados,
        async: false
    }).responseText;

    if (isEmpty(jsonData)) {
        return null;
    }
    return google.visualization.arrayToDataTable($.parseJSON(jsonData));
}

function getOptionsChamadosPorHora() {
    var options = {
        backgroundColor: 'transparent',
        colors: ['cornflowerblue', 'tomato'],
        fontName: 'Open Sans',
        focusTarget: 'category',
        chartArea: {
            left: 50,
            top: 10,
            width: '100%',
            height: '70%'
        },
        hAxis: {
            viewWindow: {
                min: new Date(2014, 11, 31, 18),
                max: new Date(2015, 0, 3, 1)
            },
            gridlines: {
                count: -1,
                units: {
                    days: { format: ['MMM dd'] },
                    hours: { format: ['HH:mm', 'ha'] },
                }
            },
            minorGridlines: {
                units: {
                    hours: { format: ['hh:mm:ss a', 'ha'] },
                    minutes: { format: ['HH:mm a Z', ':mm'] }
                }
            }
        },
        vAxis: {
            baselineColor: '#DDD',
            gridlines: {
                color: '#DDD',
                count: 4
            },
            textStyle: {
                fontSize: 11
            }
        },
        legend: {
            position: 'bottom',
            textStyle: {
                fontSize: 12
            }
        },
        animation: {
            startup: true,
            duration: 1000,
            easing: 'out'
        }
    };
    return options;
}
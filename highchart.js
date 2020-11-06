//Define the chart variable globally,
var chart;

//Request data from the server, add it to the graph and set a timeout to request again

function requestData() {
$.ajax({
       url: 'hc1.php',
       success: function(point) {
           var series = chart.series[0],
               shift = series.data.length > 20; // shift if the series is longer than 20

           // add the point
           chart.series[0].addPoint(point, true, shift);

           // call it again after one second
           setTimeout(requestData, 1000);    
       },
       cache: false
});
}

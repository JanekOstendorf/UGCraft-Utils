google.load('visualization', '1', {'packages':['corechart']});

function drawChart() {
  // Some raw data (not necessarily accurate)
  var data = google.visualization.arrayToDataTable([
    ['Level',   'Punkte'],
    ['Level 0',      0],
    ['Level 1',      28],
    ['Level 2',      112],
    ['Level 3',      252],
    ['Level 4',      448],
    ['Level 5',      700],
    ['Level 6',      1008],
    ['Level 7',      1372],
    ['Level 8',      1792],
    ['Level 9',      2268],
    ['Level 10',     2800],
    ['Level 11',     3388],
    ['Level 12',     4032],
    ['Level 13',     4732],
    ['Level 14',     5488],
    ['Level 15',     6300],
    ['Level 16',     7168],
    ['Level 17',     8092],
    ['Level 18',     9072],
    ['Level 19',     10108],
    ['Level 20',     11200],
    ['Level 21',     12348],
    ['Level 22',     13552],
    ['Level 23',     14812],
    ['Level 24',     16128],
    ['Level 25',     17500],
    ['Level 26',     18928],
    ['Level 27',     20412],
    ['Level 28',     21952],
    ['Level 29',     23458],
    ['Level 30',     25200]
  ]);

  // Create and draw the visualization.
  var ac = new google.visualization.AreaChart(document.getElementById('level_chart'));

  ac.draw(data, {
    width: 580,
    height: 300,
    vAxis: {title: "Punkte"},
    hAxis: {
        title: "Level", 
        gridlines: {
            color: "#ccc", 
            count: 4
        }, 
        showtextevery: 10
    },
    legend: {position: 'none'}
  });

}

google.setOnLoadCallback(drawChart);
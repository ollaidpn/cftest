(function($) {

	if(jQuery('#morris_bar_2').length > 0 ){

		//bar chart stalked

		Morris.Bar.prototype.fillForSeries = function(i) {
			var color;
			return "0-#fff-#fff:20-#fff";
		};

		Morris.Bar({
			element: 'morris_bar_2',
			data: [
			  { y: '2006', a: 100, b: 90, c: 80 },
			  { y: '2007', a: 75,  b: 65, c: 75 },
			  { y: '2007', a: 75,  b: 65, c: 75 },
			  { y: '2007', a: 75,  b: 65, c: 75 },
			  { y: '2008', a: 50,  b: 40, c: 45 },
			  { y: '2009', a: 75,  b: 65, c: 85 },
			  { y: '2009', a: 79,  b: 35, c: 45 },
			  { y: '2009', a: 60,  b: 20, c: 60 },
			  { y: '2009', a: 66,  b: 30, c: 50 },
			  { y: '2009', a: 46,  b: 60, c: 90 },
			  { y: '2009', a: 35,  b: 80, c: 60 },
			],
			xkey: 'y',
			ykeys: ['a', 'b', 'c'],
			labels: ['Series A', 'Series B', 'Series C'],
			barColors: ['rgb(7, 41, 77)', 'rgb(20, 59, 100)', '#6c2b69'],
			stacked: true,
			gridTextSize: 10,
			hideHover: 'auto',
			resize: true
		});
	}


	$(".peity-line").peity("line", {
        fill: ["rgba(162, 186, 211, 1)"],
        stroke: 'rgba(20, 59, 100, 1)',
        width: "100%",
        height: "150"
    });

	$(".peity-line-2").peity("line", {
        fill: ["rgba(255, 225, 193, 1)"],
        stroke: 'rgba(255, 143, 22, 1)',
        width: "100%",
        height: "150"
    });

	$(".peity-line-3").peity("line", {
        fill: ["rgba(251, 180, 157, 1)"],
        stroke: 'rgba(242, 85, 33, 1)',
        width: "100%",
        height: "150"
    });

})(jQuery);

/* const wt = new PerfectScrollbar('.widget-todo'); */

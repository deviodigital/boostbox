jQuery(document).ready(function ($) {

	// Tabs
	$( ".inline-list" ).each( function() {
		$( this ).find( "li" ).each( function(i) {
			$( this).click( function(){
				$( this ).addClass( "current" ).siblings().removeClass( "current" )
				.parents( "#wpbody" ).find( "div.panel-left" ).removeClass( "visible" ).end().find( 'div.panel-left:eq('+i+')' ).addClass( "visible" );
				return false;
			} );
		} );
	} );

	// Scroll to anchor
	$( ".anchor-nav a, .toc a" ).click( function(e) {
		e.preventDefault();

		var href = $( this ).attr( "href" );
		$( "html, body" ).animate( {
			scrollTop: $( href ).offset().top
		}, 'slow', 'swing' );
	} );

	// Back to top links
	$( "#help-panel h3" ).append( $( "<a class='back-to-top' href='#panel'><i class='fa fa-angle-up'></i> Back to top</a>" ) );

	// Vendors chart.
	new Chart(document.getElementById("bar-chart"), {
		type: 'bar',
		data: {
		labels: chart_vars.vendor_names,
		datasets: [
			{
			label: "Vendors",
			backgroundColor: ["#74477A", "#397500","#424242","#2271b1","#A7A7A7","d63638"],
			data: chart_vars.vendor_counts
			}
		]
		},
		options: {
			legend: { display: false },
			title: {
				display: true,
				text: 'Overview of all vendors'
			}
		}
	});
	// Pie chart.
	new Chart(document.getElementById("pie-chart"), {
		type: 'pie',
		data: {
		  labels: chart_vars.type_names,
		  datasets: [{
			label: "Product Types",
			backgroundColor: ["#74477A","d63638","#397500","#424242","#2271b1","#A7A7A7"],
			data: chart_vars.type_counts
		  }]
		},
		options: {
		  title: {
			display: true,
			text: 'Overview of all product types'
		  }
		}
	});
	// Pie chart 2.
	new Chart(document.getElementById("pie-chart-2"), {
		type: 'pie',
		data: {
		  labels: ["Africa", "Asia", "Europe", "Latin America", "North America"],
		  datasets: [
			{
			  label: "Population (millions)",
			  backgroundColor: ["#74477A", "#397500","#424242","#2271b1","#A7A7A7","#d63638"],
			  data: [2478,5267,734,784,433]
			}
		  ]
		},
		options: {
			legend: { display: false },
			title: {
				display: true,
				text: 'Predicted world population (millions) in 2050'
			}
		}
	});
	// Doughnut chart 1.
	new Chart(document.getElementById("doughnut-chart"), {
		type: 'doughnut',
		data: {
			labels: chart_vars.shelf_names,
			datasets: [{
				label: 'Shelf Types',
				data: chart_vars.shelf_counts,
				backgroundColor: ["#74477A", "#397500","#424242","#2271b1","#A7A7A7","#d63638"],
				hoverOffset: 4
			}]
		},
		options: {
			legend: { display: false },
			title: {
				display: false,
				text: 'Overview of all shelf types'
			}
		}
	});
	// Doughnut chart 2.
	new Chart(document.getElementById("doughnut-chart-2"), {
		type: 'doughnut',
		data: {
			labels: chart_vars.strain_names,
			datasets: [{
				label: 'Strain Types',
				data: chart_vars.strain_counts,
				backgroundColor: ["#2271b1","#74477A","#d63638","#424242","#A7A7A7","#397500"],
				hoverOffset: 4
			}]
		},
		options: {
			legend: { display: false },
			title: {
				display: false,
				text: 'Overview of all strain types'
			}
		}
	});
	// Doughnut chart 3.
	new Chart(document.getElementById("doughnut-chart-3"), {
		type: 'doughnut',
		data: {
			labels: chart_vars.type_names,
			datasets: [{
				label: 'Product types',
				data: chart_vars.type_counts,
				backgroundColor: ["#2271b1","#74477A","#d63638","#424242","#A7A7A7","#397500"],
				hoverOffset: 4
			}]
		},
		options: {
			legend: {
				position: "top",
				align: "start",
				display: false
			},
			title: {
				display: false,
				text: 'Overview of all product types'
			}
		}
	});
	// Product types chart.
	new Chart(document.getElementById("product-types-chart"), {
		type: 'bar',
		data: {
			labels: chart_vars.type_names,
			datasets: [{
				label: 'Product types',
				data: chart_vars.type_counts,
				backgroundColor: ["#2271b1","#74477A","#d63638","#424242","#A7A7A7","#397500"],
				hoverOffset: 4
			}]
		},
		indexAxis: 'y',
		scales: {
			y: {
				beginAtZero: true
			}
		},
		options: {
			legend: { display: false },
			title: {
				display: false,
				text: 'Overview of all product types'
			}
		}
	});
});
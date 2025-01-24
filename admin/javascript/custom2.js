// function toggleMenu() {
//     const sidePanel = document.querySelector('.side-panel');
//     sidePanel.style.display = (sidePanel.style.display === 'flex') ? 'none' : 'flex';

//     const toggleBtn = document.querySelector('.menu-toggle button');
//     toggleBtn.dataset.state = (sidePanel.style.display === 'flex') ? 'close' : 'open';
// }

// document.querySelector('.menu-toggle button').addEventListener('click', () => {
//     toggleMenu();
// });

// Initialize Bootstrap tabs
// var tabs = new bootstrap.Tab(document.getElementById('myTab'));
// tabs.show();

// DATA TABLE
$(document).ready(function() {
	//Only needed for the filename of export files.
	//Normally set in the title tag of your page.
	document.title='Simple DataTable';
	// DataTable initialisation
	$('#example').DataTable(
		{
			"dom": '<"dt-buttons"Bf><"clear">lirtp',
			"paging": true,
			"autoWidth": true,
			"buttons": [
				'colvis',
				'copyHtml5',
        'csvHtml5',
				'excelHtml5',
        'pdfHtml5',
				'print'
			]
		}
	);
});

// Scroll
$("#kt_datatable_both_scrolls").DataTable({
    "scrollY": 360,
    "scrollX": true
});

$("#kt_datatable_horizontal_scroll").DataTable({
	"scrollY": 360,
    "scrollX": true
});

// Count Rows
// Define a function to insert list numbers into table rows
function insertListNumbers(tableId) {
    // Get all table rows except the header for the specified table ID
    const rows = document.querySelectorAll(`#${tableId} tbody tr`);

    // Loop through each row and insert the list number
    rows.forEach((row, index) => {
        const listNumberCell = row.querySelector(".list-number");
        listNumberCell.textContent = index + 1;
    });
}

// Call the function for the first table
insertListNumbers("kt_datatable_both_scrolls");

// Call the function for the second table
insertListNumbers("another_table_id");





// Data Table Reuse

$('#myTabContent').on('shown.bs.tab', 'a[data-toggle="tab"]', function (e) {
    var targetPane = $(e.target).attr("href");
    // Load content for the targetPane dynamically here
});


// Filter Status
document.addEventListener('DOMContentLoaded', function () {
	// Get the select element
	const statusFilter = document.getElementById('event-status');

	// Add event listener for change event
	statusFilter.addEventListener('change', function () {
		// Get the selected status value
		const selectedStatus = statusFilter.value;

		// Get all rows in the data table
		const rows = document.querySelectorAll('#kt_datatable_horizontal_scroll tbody tr');

		// Loop through each row
		rows.forEach(function (row) {
			// Get the status cell within the row
			const statusCell = row.querySelector('td:nth-child(8)'); // Adjust the index according to your table structure

			// Check if the status matches the selected status
			if (selectedStatus === '' || statusCell.textContent.trim() === selectedStatus) {
				// Show the row if it matches the selected status or if all status are selected
				row.style.display = '';
			} else {
				// Hide the row if it does not match the selected status
				row.style.display = 'none';
			}
		});
	});
});

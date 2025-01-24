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
	// document.title='Simple DataTable';
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
    "scrollY": 420,
    "scrollX": true
});

$("#kt_datatable_horizontal_scroll").DataTable({
	"scrollY": 420,
    "scrollX": true
});




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

// Event listener for the select element
document.getElementById('librarian-status').addEventListener('change', function() {
    // Get the selected employment status
    var employmentStatus = this.value;
    // Call the filterEmployment function with the selected status
    filterEmployment(employmentStatus);
});

// Function to filter employment
function filterEmployment(employmentStatus) {
    // Update the DataTable column filter with the selected status
    var tables = $('.kt-datatable').DataTable();
    tables.column(4).search(employmentStatus).draw();
}

// Event listener for the select element
document.getElementById('designation').addEventListener('change', function() {
    // Get the selected employment status
    var designations = this.value;
    // Call the filterdesignations function with the selected status
    filterdesignations(designations);
});

// Function to filterdesignations
function filterdesignations(designations) {
    // Update the DataTable column filter with the selected status
    var tables = $('.kt-datatable').DataTable();
    tables.column(1).search(designations).draw();
}



// Function to export table data to Excel
function exportToExcel() {
	// Get table element
	var table = document.getElementById("kt_datatable_both_scrolls");
	
	// Convert table to Excel workbook
	var wb = XLSX.utils.table_to_book(table);
	
	// Save workbook as Excel file
	XLSX.writeFile(wb, "table_data.xlsx");
}

// Attach export function to the download button
document.getElementById("downloadButton").addEventListener("click", exportToExcel);


// FOR #RD DATA TABLE
$("#kt_datatable_fixed_columns").DataTable({
	scrollY:        "300px",
	scrollX:        true,
	scrollCollapse: true,
	fixedColumns:   {
		left: 2
	}
});


// Return button
function goBack() {
	window.history.back();
}


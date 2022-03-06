function sortRepos()
{
	$('#sortButton').click(function(){

		var selected = $('#selectSort').find(':selected').text();

		var rows = $('#repoTable tbody  tr').get();

		if(selected == 'A to Z')
		{
			rows.sort(function(a, b) {

			var A = $(a).children('td').eq(0).text().toUpperCase();

			var B = $(b).children('td').eq(0).text().toUpperCase();

			if(A < B) {
				return -1;
			}
			if(A > B) {
				return 1;

			}
			return 0;
			});
		}else if(selected == 'Z to A'){
			rows.sort(function(a, b) {

			var A = $(a).children('td').eq(0).text().toUpperCase();

			var B = $(b).children('td').eq(0).text().toUpperCase();

			if(A < B) {
				return 1;
			}
			if(A > B) {
				return -1;

			}
			return 0;
			});
		}else if(selected == 'By contributors number - desc'){
			rows.sort(function(a, b) {
			
				var a = $(a).find('td:eq(1)').text(), b = $(b).find('td:eq(1)').text();
				return b.localeCompare(a, false, {numeric: true});
			});
		}else{
			rows.sort(function(a, b) {
			
				var a = $(a).find('td:eq(1)').text(), b = $(b).find('td:eq(1)').text();
				return a.localeCompare(b, false, {numeric: true});
			});
		}

		$.each(rows, function(index, row) {
			
			$('#repoTable').children('tbody').append(row);
		
		});
		
	});
		
}


$(document).ready(function () {
    $('#foodSearch').on('input', function () {
        var searchText = $(this).val();

        $.ajax({
            type: "GET",
            url: "/foods/search",
            data: {search: searchText},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                var results = response.data;
                var searchResults = $('#searchResults');
                searchResults.empty();

                if (searchText !== "") {
                    if (results.length > 0) {
                        // Build the table for search results
                        var table = '<table class="min-w-full divide-y divide-gray-200 mt-4"><thead></thead><tbody>';
                        results.forEach(function (result) {
                            table += '<tr><td>' + result.name + '</td><td>' + result.raw_material + '</td><td>' + result.price + '</td>';
                        });
                        table += '</tbody></table>';
                        searchResults.append(table);
                    } else {
                        searchResults.append('<p>No results found</p>');
                    }
                }
            },
            error: function (error) {
                console.log(error);
            }
        });

    });
});

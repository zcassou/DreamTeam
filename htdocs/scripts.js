jQuery(document).ready(function(){
//$(function(){
	jQuery(".team").hide();
	jQuery(".new_team").hide();
	jQuery("#add_team").click(function(){
		var tname = prompt("Please enter a team name.");
		if (tname.length > 0) {
			$.ajax({
				type: 'POST',
				url: 'new_team.php',
				dataType: 'html',
				data: { new_team: tname },
				success: function(working) {
					$(".new_team").append(working);
        	                        alert('New team successfully received!');
					jQuery(".new_team").show();
					jQuery(".team").hide();
				},
				error: function(xhr, textStatus, errorThrown) {
					alert('An error occured! ' + (errorThrown ? errorThrown : xhr.status ));
				}
			});
		} else {
			alert('You did not enter a team name!');
		}
	});

	jQuery("html").on("click", "#edit_list", function(){
		$(this).replaceWith('<input type = "button" id = "delete_team" value = "Delete">');
		jQuery(".team").show();
        });

	jQuery("html").on("click", "#delete_team", function(){
                $(this).replaceWith('<input type = "button" id = "edit_list" value = "Edit">');
		var teams_delete = [];
		jQuery(".team").hide();
		$(".team:checked").each(function() {
			teams_delete.push($(this).val());	
		});
		$.ajax({
			type: 'POST',
			url: 'delete_team.php',
			dataType: 'html',
			data: { delete_team: teams_delete },
			success: function(returned) {
				alert(returned);
			},
			error: function(xhr, textStatus, errorThrown) {
				alert('An error occured! ' + (errorThrown ? errorThrown : xhr.status ));
			}

		});

		jQuery(".team:checked").parents('p').remove();
		if ($(".new_team").children('p').length == 0) {
			$('.new_team').hide();
		}
	});

});

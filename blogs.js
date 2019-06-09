$(document).ready( function() {
	$("#submit").click(function() {
		$existingBlogHtml = $(".posts").html();
		var $name = $("#name").val();
		var $title = $("#title").val();
		var $blogPost= $("#blogPost").val();
		$newBlogHtml = "<div class=\"posts\"><a href=\"./blank.html\"><h4>" + $title + "</h4><h5>" + $name + "</h5><p>" + $blogPost + "</p></a></div>";
		$(".recentBlogs").append($newBlogHtml);
	});
});